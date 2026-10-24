<?php

namespace App\Http\Controllers;

use App\Models\KategoriSampah;
use App\Models\LokasiTempatSampah;
use Illuminate\Http\Request;

/** PBI-11 (peta) & PBI-12 (detail lokasi) */
class PetaController extends Controller
{
    public function index(Request $request)
    {
        return view('peta.index', [
            'kategori' => KategoriSampah::aktif()->get(),
            'dipilih' => $request->query('kategori'),
        ]);
    }

    /** Data titik untuk Leaflet (filter ?kategori=<id_kategori>). */
    public function data(Request $request)
    {
        $lokasi = LokasiTempatSampah::aktif()
            ->with('kategori:id_kategori,nama_kategori,kode,warna_label')
            ->when($request->filled('kategori'), fn ($q) => $q->whereHas('kategori', fn ($k) => $k->where('kategori_sampah.id_kategori', $request->kategori)))
            ->get()
            ->map(fn ($l) => [
                'id' => $l->id_lokasi,
                'kode' => $l->kode_titik,
                'nama' => $l->nama_lokasi,
                'lat' => $l->latitude,
                'lng' => $l->longitude,
                'kategori' => $l->kategori->pluck('nama_kategori'),
                'url' => route('peta.show', $l),
            ]);

        return response()->json($lokasi);
    }

    public function show(LokasiTempatSampah $lokasi)
    {
        abort_if($lokasi->status !== 'aktif', 404, 'Lokasi tidak lagi tersedia.');

        return view('pages.detail', [
            'title' => $lokasi->nama_lokasi . ' - Titik ' . $lokasi->kode_titik,
            'items' => [
                'Koordinat' => $lokasi->latitude . ', ' . $lokasi->longitude,
                'Kategori diterima' => $lokasi->kategori->pluck('nama_kategori')->implode(', '),
            ],
            'back' => route('peta.index'),
            'action' => ['href' => route('aktivitas.create', ['lokasi' => $lokasi->id_lokasi]), 'label' => 'Catat aktivitas di titik ini'],
        ]);
    }
}
