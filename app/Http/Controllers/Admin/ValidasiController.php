<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AktivitasPemilahan;
use App\Services\PointEngine;
use Illuminate\Http\Request;
use RuntimeException;

/** Validasi aktivitas oleh petugas/admin (alur Gambar 2.3). Terkait PBI-13/15/16. */
class ValidasiController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status', AktivitasPemilahan::MENUNGGU);

        return view('admin.validasi.index', [
            'status' => $status,
            'antrian' => AktivitasPemilahan::with(['pengguna', 'kategori', 'lokasi'])
                ->where('status_verifikasi', $status)
                ->oldest('tanggal_waktu')
                ->paginate(15)->withQueryString(),
            'jumlah' => AktivitasPemilahan::selectRaw('status_verifikasi, count(*) as n')->groupBy('status_verifikasi')->pluck('n', 'status_verifikasi'),
        ]);
    }

    public function show(AktivitasPemilahan $aktivitas)
    {
        return view('admin.validasi.show', ['aktivitas' => $aktivitas->load(['pengguna', 'kategori', 'lokasi', 'petugas'])]);
    }

    public function approve(AktivitasPemilahan $aktivitas, PointEngine $engine)
    {
        try {
            $trx = $engine->approve($aktivitas, auth()->user());
        } catch (RuntimeException $e) {
            return back()->withErrors(['validasi' => $e->getMessage()]);
        }

        return redirect()->route('admin.validasi.index')->with('status', "Disetujui, +{$trx->jumlah_poin} poin.");
    }

    public function reject(Request $request, AktivitasPemilahan $aktivitas, PointEngine $engine)
    {
        $data = $request->validate(['alasan_penolakan' => ['required', 'string', 'max:255']]);

        try {
            $engine->reject($aktivitas, auth()->user(), $data['alasan_penolakan']);
        } catch (RuntimeException $e) {
            return back()->withErrors(['validasi' => $e->getMessage()]);
        }

        return redirect()->route('admin.validasi.index')->with('status', 'Aktivitas ditolak.');
    }

    /** Pengurangan poin (FR-12) untuk pembuangan tidak sesuai kategori. */
    public function koreksi(Request $request, AktivitasPemilahan $aktivitas, PointEngine $engine)
    {
        $data = $request->validate([
            'jumlah' => ['required', 'integer', 'min:1', 'max:1000'],
            'keterangan' => ['required', 'string', 'max:255'],
        ]);

        $engine->koreksi($aktivitas->pengguna, (int) $data['jumlah'], 'Koreksi: ' . $data['keterangan']);

        return back()->with('status', 'Koreksi poin dicatat.');
    }
}
