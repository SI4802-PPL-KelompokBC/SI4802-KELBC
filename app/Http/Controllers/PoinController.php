<?php

namespace App\Http\Controllers;

use App\Services\PointEngine;
use Illuminate\Http\Request;

/** PBI-17 (saldo) & PBI-18 (riwayat transaksi) */
class PoinController extends Controller
{
    public function index(PointEngine $poin)
    {
        $user = auth()->user();

        return view('pages.poin', [
            'saldo' => $poin->saldo($user),
            'transaksi' => $user->transaksiPoin()->latest('tanggal')->limit(5)->get(),
        ]);
    }

    public function riwayat(Request $request, PointEngine $poin)
    {
        $user = $request->user();
        $transaksi = $user->transaksiPoin()
            ->when($request->filled('jenis'), fn ($q) => $q->where('jenis', $request->jenis))
            ->latest('tanggal')->paginate(10)->withQueryString();

        $currentSaldo = $poin->saldo($user);

        return view('pages.riwayat', compact('transaksi', 'currentSaldo'));
    }
}
