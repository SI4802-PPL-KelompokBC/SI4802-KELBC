@extends('layouts.app', ['title' => 'Beranda'])
@section('content')
<div class="rounded-2xl bg-brand-600 p-6 text-white">
    <div class="text-sm text-white/80">Hari ini, {{ now()->translatedFormat('l, d F Y') }}</div>
    <div class="mt-1 text-2xl font-bold">Jadwal Sampah {{ $kategoriHariIni?->nama_kategori ?? '-' }}</div>
    <a href="{{ route('aktivitas.create') }}" class="mt-4 inline-block rounded-lg bg-white px-4 py-2 text-sm font-medium text-brand-700">Catat Aktivitas</a>
</div>

<div class="mt-6 grid gap-4 sm:grid-cols-4">
    @foreach ([['Saldo Poin', number_format($saldo, 0, ',', '.')], ['Total Aktivitas', $totalAktivitas], ['Terverifikasi', $terverifikasi], ['Menunggu', $menunggu]] as [$l, $v])
        <div class="rounded-xl bg-white p-4 shadow-sm"><div class="text-xs text-slate-500">{{ $l }}</div><div class="text-2xl font-bold">{{ $v }}</div></div>
    @endforeach
</div>

<div class="mt-6 rounded-xl bg-white p-4 shadow-sm">
    <div class="mb-2 flex justify-between"><h2 class="font-semibold">Aktivitas terbaru</h2><a href="{{ route('aktivitas.index') }}" class="text-sm text-brand-700">Lihat semua</a></div>
    @forelse ($terbaru as $a)
        <a href="{{ route('aktivitas.show', $a) }}" class="flex items-center justify-between border-t py-2 text-sm">
            <span>{{ $a->kode }} - {{ $a->kategori->nama_kategori }} - {{ $a->lokasi->nama_lokasi }}</span>
            @include('partials.badge', ['status' => $a->status_verifikasi])
        </a>
    @empty
        <p class="text-sm text-slate-500">Belum ada aktivitas.</p>
    @endforelse
</div>
@endsection
