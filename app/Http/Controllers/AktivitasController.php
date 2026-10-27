<?php

namespace App\Http\Controllers;

use App\Models\AktivitasPemilahan;
use App\Models\KategoriSampah;
use App\Models\LokasiTempatSampah;
use App\Services\JadwalSiklus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

/** PBI-13 (CRUD aktivitas), PBI-14 (riwayat), PBI-15 (status verifikasi) */
class AktivitasController extends Controller
{
    public function index(Request $request)
    {
        $aktivitas = $request->user()->aktivitas()
            ->with(['kategori', 'lokasi'])
            ->when($request->filled('status'), fn ($q) => $q->where('status_verifikasi', $request->status))
            ->latest('tanggal_waktu')
            ->paginate(10)->withQueryString();

        return view('aktivitas.index', ['aktivitas' => $aktivitas]);
    }

    public function create(Request $request, JadwalSiklus $siklus)
    {
        return view('aktivitas.form', [
            'aktivitas' => new AktivitasPemilahan(['tanggal_waktu' => now(), 'id_lokasi' => $request->query('lokasi')]),
            'kategori' => KategoriSampah::aktif()->get(),
            'lokasi' => LokasiTempatSampah::aktif()->with('kategori')->get(),
            'kategoriHariIni' => $siklus->kategoriUntuk(now()),
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request, fotoWajib: true);
        $data['foto_bukti'] = $request->file('foto_bukti')->store('bukti', 'public');

        $aktivitas = $request->user()->aktivitas()->create($data + ['status_verifikasi' => AktivitasPemilahan::MENUNGGU]);

        return redirect()->route('aktivitas.show', $aktivitas)->with('status', 'Aktivitas diajukan, menunggu validasi petugas.');
    }

    public function show(AktivitasPemilahan $aktivitas)
    {
        $this->authorizeOwner($aktivitas);

        return view('aktivitas.show', ['aktivitas' => $aktivitas->load(['kategori', 'lokasi', 'petugas', 'transaksi'])]);
    }

    public function edit(AktivitasPemilahan $aktivitas, JadwalSiklus $siklus)
    {
        $this->authorizeOwner($aktivitas);
        abort_unless($aktivitas->bisa_diubah, 403, 'Pengajuan yang sudah terverifikasi tidak dapat diubah.');

        return view('aktivitas.form', [
            'aktivitas' => $aktivitas,
            'kategori' => KategoriSampah::aktif()->get(),
            'lokasi' => LokasiTempatSampah::aktif()->with('kategori')->get(),
            'kategoriHariIni' => $siklus->kategoriUntuk(now()),
        ]);
    }

    /** Dipakai juga untuk "Ajukan Ulang" setelah ditolak: status kembali ke Menunggu Validasi. */
    public function update(Request $request, AktivitasPemilahan $aktivitas)
    {
        $this->authorizeOwner($aktivitas);
        abort_unless($aktivitas->bisa_diubah, 403, 'Pengajuan yang sudah terverifikasi tidak dapat diubah.');

        $data = $this->validated($request, fotoWajib: false);

        if ($request->hasFile('foto_bukti')) {
            Storage::disk('public')->delete($aktivitas->foto_bukti);
            $data['foto_bukti'] = $request->file('foto_bukti')->store('bukti', 'public');
        }

        $aktivitas->update($data + [
            'status_verifikasi' => AktivitasPemilahan::MENUNGGU,
            'alasan_penolakan' => null,
        ]);

        return redirect()->route('aktivitas.show', $aktivitas)->with('status', 'Pengajuan diperbarui.');
    }

    public function destroy(AktivitasPemilahan $aktivitas)
    {
        $this->authorizeOwner($aktivitas);
        abort_unless($aktivitas->status_verifikasi === AktivitasPemilahan::MENUNGGU, 403, 'Hanya pengajuan Menunggu Validasi yang dapat dibatalkan.');

        Storage::disk('public')->delete($aktivitas->foto_bukti);
        $aktivitas->delete();

        return redirect()->route('aktivitas.index')->with('status', 'Pengajuan dibatalkan.');
    }

    private function authorizeOwner(AktivitasPemilahan $a): void
    {
        abort_unless($a->id_pengguna === auth()->id(), 403);
    }

    private function validated(Request $request, bool $fotoWajib): array
    {
        $data = $request->validate([
            'id_kategori' => ['required', 'exists:kategori_sampah,id_kategori'],
            'id_lokasi' => ['required', 'exists:lokasi_tempat_sampah,id_lokasi'],
            'tanggal_waktu' => ['required', 'date', 'before_or_equal:now'],
            'jumlah' => ['required', 'numeric', 'min:0.01', 'max:1000'],
            'foto_bukti' => [$fotoWajib ? 'required' : 'nullable', 'image', 'mimes:jpg,jpeg,png', 'max:5120'],
            'catatan' => ['nullable', 'string', 'max:255'],
            'pernyataan' => ['accepted'],
        ], ['pernyataan.accepted' => 'Centang pernyataan bahwa sampah sudah dipilah dan dibuang sesuai kategori.']);

        // Validasi bisnis: kategori harus diterima di lokasi yang dipilih.
        $diterima = LokasiTempatSampah::whereKey($data['id_lokasi'])
            ->whereHas('kategori', fn ($q) => $q->where('kategori_sampah.id_kategori', $data['id_kategori']))
            ->exists();

        if (! $diterima) {
            return back()->withErrors(['id_lokasi' => 'Titik ini tidak menerima kategori yang dipilih.'])->withInput();
        }

        unset($data['pernyataan'], $data['foto_bukti']);

        return $data;
    }
}
