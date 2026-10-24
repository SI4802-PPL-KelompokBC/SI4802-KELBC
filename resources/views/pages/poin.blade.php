@extends('layouts.app', ['title' => 'Poin Saya'])
@section('content')
<div class="flex items-center justify-between">
    <h1 class="text-xl font-semibold">Poin Saya</h1>
    <a href="{{ route('poin.riwayat') }}" class="rounded-lg border bg-white px-4 py-2 text-sm">Riwayat Transaksi</a>
</div>
<div class="mt-4 rounded-2xl bg-brand-900 p-6 text-white">
    <div class="text-sm text-white/70">Saldo Reward Point</div>
    <div class="text-5xl font-bold">{{ number_format($saldo, 0, ',', '.') }} <span class="text-base font-normal">poin</span></div>
    <div class="mt-2 text-xs text-white/60">Dihitung dari seluruh transaksi poin yang tercatat.</div>
</div>
<div class="mt-4 rounded-xl bg-amber-50 p-4 text-sm text-amber-800">Penukaran poin belum tersedia. Pada tahap ini reward point digunakan sebagai gamifikasi.</div>
<div class="mt-4 rounded-xl bg-white p-4 shadow-sm">
    <h2 class="mb-2 font-semibold">Transaksi Terbaru</h2>
    @forelse ($transaksi as $t)
        <div class="flex justify-between border-t py-2 text-sm"><span>{{ $t->keterangan }}</span><span class="{{ $t->jumlah_poin < 0 ? 'text-red-600' : 'text-green-700' }}">{{ $t->jumlah_poin > 0 ? '+' : '' }}{{ $t->jumlah_poin }}</span></div>
    @empty <p class="text-sm text-slate-500">Belum ada transaksi.</p> @endforelse
</div>
@endsection
