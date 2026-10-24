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

    public function riwayat(Request $request)
    {
        $transaksi = $request->user()->transaksiPoin()
            ->when($request->filled('jenis'), fn ($q) => $q->where('jenis', $request->jenis))
            ->latest('tanggal')->paginate(10)->withQueryString();

        return view('pages.table', [
            'title' => 'Riwayat Transaksi Poin',
            'subtitle' => 'Setiap penambahan atau koreksi poin dicatat sebagai transaksi.',
            'columns' => ['Tanggal', 'Keterangan', 'Jenis', 'Jumlah'],
            'rows' => $transaksi->map(fn ($t) => [
                $t->tanggal->format('d M Y H:i'), $t->keterangan, ucfirst($t->jenis),
                ($t->jumlah_poin > 0 ? '+' : '') . $t->jumlah_poin,
            ])->all(),
            'paginator' => $transaksi,
        ]);
    }
}
