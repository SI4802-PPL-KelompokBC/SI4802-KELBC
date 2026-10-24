<?php

namespace App\Http\Controllers;

use App\Models\JadwalPengangkutan;
use App\Models\PengingatJadwal;
use App\Services\JadwalSiklus;
use Illuminate\Http\Request;

/** PBI-08 (lihat jadwal) & PBI-09 (pengingat) */
class JadwalController extends Controller
{
    public function index(JadwalSiklus $siklus)
    {
        $minggu = collect(range(0, 6))->map(fn ($i) => [
            'tanggal' => now()->addDays($i),
            'kategori' => $siklus->kategoriUntuk(now()->addDays($i)),
        ]);

        $hariIni = $siklus->kategoriUntuk(now());

        $jadwal = JadwalPengangkutan::aktif()
            ->with(['kategori', 'lokasi'])
            ->when($hariIni, fn ($q) => $q->where('id_kategori', $hariIni->id_kategori))
            ->get();

        return view('pages.jadwal', [
            'minggu' => $minggu,
            'hariIni' => $hariIni,
            'jadwal' => $jadwal,
            'pengingat' => auth()->user()->pengingat()->with('jadwal.kategori')->get(),
        ]);
    }

    public function simpanPengingat(Request $request)
    {
        $data = $request->validate([
            'id_jadwal' => ['required', 'exists:jadwal_pengangkutan,id_jadwal'],
            'waktu_pengingat' => ['required', 'date_format:H:i'],
            'aktif' => ['nullable', 'boolean'],
        ]);

        PengingatJadwal::updateOrCreate(
            ['id_pengguna' => $request->user()->id_pengguna, 'id_jadwal' => $data['id_jadwal']],
            ['waktu_pengingat' => $data['waktu_pengingat'], 'aktif' => $request->boolean('aktif', true)]
        );

        return back()->with('status', 'Pengaturan pengingat disimpan.');
    }
}
