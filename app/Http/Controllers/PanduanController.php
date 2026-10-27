<?php

namespace App\Http\Controllers;

use App\Models\JenisSampah;
use App\Models\KategoriSampah;
use Illuminate\Http\Request;

/** PBI-03 (cari jenis), PBI-05 (panduan), PBI-06 (detail kategori) */
class PanduanController extends Controller
{
    public function index()
    {
        $kategoris = KategoriSampah::aktif()->with(['jenis' => fn ($q) => $q->where('diterima', true)])->get();

        return view('pages.panduan', compact('kategoris'));
    }

    public function show(KategoriSampah $kategori)
    {
        abort_if($kategori->status !== 'aktif', 404);

        $kategori->load(['jenis' => fn ($q) => $q->where('diterima', true)]);

        return view('pages.panduan-detail', compact('kategori'));
    }

    public function cari(Request $request)
    {
        $q = trim((string) $request->query('q', ''));

        $hasil = $q === '' ? collect() : JenisSampah::with('kategori')
            ->where('nama_jenis', 'like', "%{$q}%")
            ->whereHas('kategori', fn ($k) => $k->where('status', 'aktif'))
            ->limit(20)->get();

        return view('pages.cari', ['q' => $q, 'hasil' => $hasil]);
    }
}
