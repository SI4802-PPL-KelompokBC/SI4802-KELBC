<?php

namespace App\Http\Controllers;

use App\Models\AktivitasPemilahan;
use App\Models\TransaksiPoin;
use App\Services\JadwalSiklus;
use App\Services\PointEngine;

class DashboardController extends Controller
{
    public function index(JadwalSiklus $siklus, PointEngine $poin)
    {
        $user = auth()->user();

        return view('dashboard', [
            'kategoriHariIni' => $siklus->kategoriUntuk(now()),
            'saldo' => $poin->saldo($user),
            'totalAktivitas' => $user->aktivitas()->count(),
            'terverifikasi' => $user->aktivitas()->where('status_verifikasi', AktivitasPemilahan::TERVERIFIKASI)->count(),
            'menunggu' => $user->aktivitas()->where('status_verifikasi', AktivitasPemilahan::MENUNGGU)->count(),
            'terbaru' => $user->aktivitas()->with(['kategori', 'lokasi'])->latest('tanggal_waktu')->limit(5)->get(),
        ]);
    }
}
