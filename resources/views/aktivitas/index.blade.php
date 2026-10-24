@extends('layouts.app', ['title' => 'Riwayat Aktivitas'])
@section('content')
<div class="flex items-center justify-between">
    <h1 class="text-xl font-semibold">Riwayat Aktivitas Pemilahan</h1>
    <a href="{{ route('aktivitas.create') }}" class="rounded-lg bg-brand-600 px-4 py-2 text-sm text-white">+ Catat Aktivitas</a>
</div>
<div class="mt-3 flex gap-2 text-sm">
    <a href="{{ route('aktivitas.index') }}" class="rounded-full border bg-white px-3 py-1">Semua</a>
    @foreach (['menunggu' => 'Menunggu', 'terverifikasi' => 'Terverifikasi', 'ditolak' => 'Ditolak'] as $v => $l)
        <a href="{{ route('aktivitas.index', ['status' => $v]) }}" class="rounded-full border bg-white px-3 py-1">{{ $l }}</a>
    @endforeach
</div>
<div class="mt-4 overflow-x-auto rounded-xl bg-white shadow-sm">
    <table class="w-full text-left text-sm">
        <thead class="bg-slate-50 text-xs uppercase text-slate-500"><tr><th class="px-4 py-3">ID</th><th class="px-4 py-3">Tanggal</th><th class="px-4 py-3">Kategori</th><th class="px-4 py-3">Lokasi</th><th class="px-4 py-3">Jumlah</th><th class="px-4 py-3">Status</th><th class="px-4 py-3">Poin</th><th></th></tr></thead>
        <tbody>
        @forelse ($aktivitas as $a)
            <tr class="border-t">
                <td class="px-4 py-3 font-medium">{{ $a->kode }}</td>
                <td class="px-4 py-3">{{ $a->tanggal_waktu->format('d M Y, H:i') }}</td>
                <td class="px-4 py-3">{{ $a->kategori->nama_kategori }}</td>
                <td class="px-4 py-3">{{ $a->lokasi->nama_lokasi }}</td>
                <td class="px-4 py-3">{{ $a->jumlah }}</td>
                <td class="px-4 py-3">@include('partials.badge', ['status' => $a->status_verifikasi])</td>
                <td class="px-4 py-3">{{ $a->status_verifikasi === 'terverifikasi' ? '+' . $a->poin_diperoleh : '-' }}</td>
                <td class="px-4 py-3"><a href="{{ route('aktivitas.show', $a) }}" class="text-brand-700">Lihat detail</a></td>
            </tr>
        @empty
            <tr><td colspan="8" class="px-4 py-6 text-center text-slate-500">Belum ada aktivitas yang tercatat.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>
<div class="mt-4">{{ $aktivitas->links() }}</div>
@endsection
