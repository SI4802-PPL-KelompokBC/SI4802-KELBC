<?php

namespace App\Http\Controllers;

class AlurController extends Controller
{
    // TODO: konten alur pengelolaan dikelola admin (FR-18); sementara statis.
    public function index()
    {
        return view('pages.detail', [
            'title' => 'Alur Pengelolaan Sampah',
            'items' => [
                '1. Pembuangan' => 'Civitas memilah dan membuang sampah di titik sesuai kategori.',
                '2. Pengumpulan' => 'Sampah dikumpulkan di titik pembuangan.',
                '3. Pengangkutan' => 'Petugas mengangkut sesuai jadwal pengangkutan.',
                '4. Pemilahan ulang' => 'Dipilah ulang di TPS kampus bila ada yang tercampur.',
                '5. Pengolahan' => 'Organik menjadi kompos; plastik dan kertas ke bank sampah.',
            ],
        ]);
    }
}
