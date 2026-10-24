@extends('layouts.app', ['title' => 'Validasi ' . $aktivitas->kode])
@section('content')
<a href="{{ route('admin.validasi.index') }}" class="text-sm text-brand-700">&larr; Kembali ke antrian</a>
<div class="mt-2 rounded-xl bg-white p-5 shadow-sm">
    <div class="flex items-center justify-between">
        <div>
            <div class="font-semibold">{{ $aktivitas->pengguna->nama_lengkap }}</div>
            <div class="text-xs text-slate-500">{{ $aktivitas->pengguna->nim_nip }} - {{ $aktivitas->pengguna->program_studi }}</div>
        </div>
        @include('partials.badge', ['status' => $aktivitas->status_verifikasi])
    </div>

    <img src="{{ asset('storage/' . $aktivitas->foto_bukti) }}" class="mt-4 max-h-80 rounded" alt="Foto bukti">

    <dl class="mt-4 grid gap-3 text-sm sm:grid-cols-4">
        <div><dt class="text-xs text-slate-500">Kategori</dt><dd>{{ $aktivitas->kategori->nama_kategori }}</dd></div>
        <div><dt class="text-xs text-slate-500">Lokasi</dt><dd>{{ $aktivitas->lokasi->nama_lokasi }}</dd></div>
        <div><dt class="text-xs text-slate-500">Waktu</dt><dd>{{ $aktivitas->tanggal_waktu->format('d M Y, H:i') }}</dd></div>
        <div><dt class="text-xs text-slate-500">Jumlah</dt><dd>{{ $aktivitas->jumlah }}</dd></div>
    </dl>
    @if ($aktivitas->catatan)<p class="mt-3 rounded bg-slate-50 p-3 text-sm">"{{ $aktivitas->catatan }}"</p>@endif

    @if ($aktivitas->status_verifikasi === 'menunggu')
        <div class="mt-6 grid gap-4 md:grid-cols-2">
            <form method="POST" action="{{ route('admin.validasi.reject', $aktivitas) }}" class="space-y-2">
                @csrf
                <label class="text-sm font-medium">Alasan penolakan (wajib saat menolak)</label>
                <textarea name="alasan_penolakan" rows="2" class="w-full rounded-lg border px-3 py-2"></textarea>
                <button class="rounded-lg border border-red-300 px-4 py-2 text-sm text-red-700">Tolak Aktivitas</button>
            </form>
            <form method="POST" action="{{ route('admin.validasi.approve', $aktivitas) }}" class="flex items-end justify-end">
                @csrf
                <button class="rounded-lg bg-brand-600 px-4 py-2 text-sm text-white">Setujui & Beri Poin</button>
            </form>
        </div>
    @elseif ($aktivitas->status_verifikasi === 'ditolak')
        <p class="mt-4 text-sm text-red-700">Alasan: {{ $aktivitas->alasan_penolakan }}</p>
    @else
        <p class="mt-4 text-sm text-green-700">+{{ $aktivitas->poin_diperoleh }} poin. Divalidasi oleh {{ $aktivitas->petugas?->nama_lengkap }}.</p>
    @endif

    <form method="POST" action="{{ route('admin.validasi.koreksi', $aktivitas) }}" class="mt-6 flex flex-wrap items-end gap-2 border-t pt-4 text-sm">
        @csrf
        <div><label class="block text-xs text-slate-500">Koreksi poin (pengurangan)</label><input type="number" name="jumlah" min="1" placeholder="10" class="w-24 rounded-lg border px-3 py-2"></div>
        <div class="flex-1"><label class="block text-xs text-slate-500">Keterangan</label><input name="keterangan" placeholder="pembuangan tidak sesuai kategori" class="w-full rounded-lg border px-3 py-2"></div>
        <button class="rounded-lg border px-4 py-2">Catat Koreksi</button>
    </form>
</div>
@endsection
