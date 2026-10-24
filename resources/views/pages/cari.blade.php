@extends('layouts.app', ['title' => 'Cari Jenis Sampah'])
@section('content')
<h1 class="text-xl font-semibold">Cari Jenis Sampah</h1>
<form method="GET" action="{{ route('panduan.cari') }}" class="mt-4 flex gap-2">
    <input name="q" value="{{ $q }}" placeholder="mis. kulit pisang" class="w-full rounded-lg border px-3 py-2" autofocus>
    <button class="rounded-lg bg-brand-600 px-4 text-white">Cari</button>
</form>
<div class="mt-4 space-y-2">
    @forelse ($hasil as $j)
        <a href="{{ route('panduan.show', $j->kategori) }}" class="flex justify-between rounded-xl bg-white p-4 shadow-sm">
            <span>{{ $j->nama_jenis }} @unless($j->diterima)<span class="text-xs text-red-600">(tidak diterima)</span>@endunless</span>
            <span class="text-sm text-slate-500">Kategori: {{ $j->kategori->nama_kategori }}</span>
        </a>
    @empty
        @if ($q !== '')<p class="text-slate-500">Jenis sampah tidak ditemukan.</p>@endif
    @endforelse
</div>
@endsection
