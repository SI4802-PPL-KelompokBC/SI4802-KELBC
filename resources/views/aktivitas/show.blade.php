@extends('layouts.app', ['title' => 'Detail ' . $aktivitas->kode])
@section('content')
<div class="flex items-center justify-between">
    <h1 class="flex items-center gap-2 text-xl font-semibold">Detail Aktivitas {{ $aktivitas->kode }} @include('partials.badge', ['status' => $aktivitas->status_verifikasi])</h1>
    <div class="flex gap-2">
        @if ($aktivitas->status_verifikasi === 'menunggu')
            <form method="POST" action="{{ route('aktivitas.destroy', $aktivitas) }}" onsubmit="return confirm('Batalkan pengajuan ini?')">@csrf @method('DELETE')<button class="rounded-lg border border-red-300 px-4 py-2 text-sm text-red-700">Batalkan Pengajuan</button></form>
        @endif
        @if ($aktivitas->bisa_diubah)
            <a href="{{ route('aktivitas.edit', $aktivitas) }}" class="rounded-lg bg-brand-600 px-4 py-2 text-sm text-white">{{ $aktivitas->status_verifikasi === 'ditolak' ? 'Ajukan Ulang' : 'Edit Pengajuan' }}</a>
        @endif
    </div>
</div>

@if ($aktivitas->status_verifikasi === 'menunggu')
    <div class="mt-4 rounded-lg bg-amber-50 p-3 text-sm text-amber-800">Menunggu validasi petugas. Kamu masih bisa mengedit atau membatalkan pengajuan.</div>
@elseif ($aktivitas->status_verifikasi === 'terverifikasi')
    <div class="mt-4 rounded-lg bg-green-50 p-3 text-sm text-green-800">Terverifikasi: +{{ $aktivitas->poin_diperoleh }} poin ditambahkan. Divalidasi oleh {{ $aktivitas->petugas?->nama_lengkap }}.</div>
@else
    <div class="mt-4 rounded-lg bg-red-50 p-3 text-sm text-red-800"><b>Alasan penolakan:</b> {{ $aktivitas->alasan_penolakan }}</div>
@endif

<dl class="mt-4 grid gap-4 rounded-xl bg-white p-5 shadow-sm sm:grid-cols-3">
    <div><dt class="text-xs text-slate-500">Kategori</dt><dd>{{ $aktivitas->kategori->nama_kategori }}</dd></div>
    <div><dt class="text-xs text-slate-500">Lokasi</dt><dd>{{ $aktivitas->lokasi->nama_lokasi }}</dd></div>
    <div><dt class="text-xs text-slate-500">Tanggal & waktu</dt><dd>{{ $aktivitas->tanggal_waktu->format('d M Y, H:i') }}</dd></div>
    <div><dt class="text-xs text-slate-500">Jumlah</dt><dd>{{ $aktivitas->jumlah }}</dd></div>
    <div class="sm:col-span-2"><dt class="text-xs text-slate-500">Catatan</dt><dd>{{ $aktivitas->catatan ?: '-' }}</dd></div>
    <div class="sm:col-span-3"><dt class="text-xs text-slate-500">Foto bukti</dt><dd><img src="{{ asset('storage/' . $aktivitas->foto_bukti) }}" class="mt-1 max-h-72 rounded" alt="Foto bukti"></dd></div>
</dl>
@endsection
