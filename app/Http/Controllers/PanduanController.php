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
        return view('pages.table', [
            'title' => 'Panduan Pemilahan Sampah',
            'subtitle' => 'Pelajari cara memilah dan membuang sampah dengan benar di lingkungan Telkom University.',
            'columns' => ['Kode', 'Kategori', 'Deskripsi', 'Detail'],
            'rows' => KategoriSampah::aktif()->get()->map(fn ($k) => [
                $k->kode, $k->nama_kategori, $k->deskripsi,
                ['href' => route('panduan.show', $k), 'label' => 'Lihat detail'],
            ])->all(),
        ]);
    }

    public function show(KategoriSampah $kategori)
    {
        abort_if($kategori->status !== 'aktif', 404);

        return view('pages.detail', [
            'title' => 'Sampah ' . $kategori->nama_kategori,
            'items' => [
                'Kode' => $kategori->kode,
                'Deskripsi' => $kategori->deskripsi,
                'Karakteristik' => $kategori->karakteristik,
                'Cara penanganan' => $kategori->cara_pembuangan,
                'Contoh' => $kategori->jenis()->where('diterima', true)->pluck('nama_jenis')->implode(', '),
            ],
            'back' => route('panduan.index'),
        ]);
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
