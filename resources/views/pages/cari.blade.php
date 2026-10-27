@extends('layouts.app', ['title' => 'Cari Jenis Sampah'])

@section('content')
<div class="mx-auto max-w-3xl space-y-6">
    <!-- Header -->
    <div>
        <div class="flex items-center gap-2 text-xs font-semibold uppercase tracking-wider text-slate-400 mb-1">
            <a href="{{ route('panduan.index') }}" class="hover:text-slate-600 transition">&larr; Kembali ke Panduan</a>
            <span>&bull;</span>
            <span class="text-emerald-700 font-bold">Pencarian Cepat</span>
        </div>
        <h2 class="text-2xl font-extrabold text-slate-900 tracking-tight">
            Cari Jenis Sampah Kampus
        </h2>
        <p class="mt-1 text-xs sm:text-sm text-slate-500">
            Ketik nama barang atau sampah untuk mengetahui kategori tong sampah yang sesuai (mis. botol plastik, kulit buah, kardus).
        </p>
    </div>

    <!-- Modern Search Bar -->
    <form method="GET" action="{{ route('panduan.cari') }}" class="relative flex items-center">
        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
        </div>
        <input 
            type="text" 
            name="q" 
            value="{{ $q }}" 
            placeholder="Cari jenis sampah, mis. botol plastik, kulit pisang, kertas..." 
            class="block w-full rounded-2xl border border-slate-200 bg-white pl-12 pr-28 py-3.5 text-sm text-slate-800 placeholder-slate-400 shadow-xs transition focus:border-emerald-600 focus:outline-none focus:ring-4 focus:ring-emerald-500/10" 
            autofocus
        >
        <button 
            type="submit" 
            class="absolute right-2 rounded-xl bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 px-4 py-2 text-xs font-bold text-white shadow-xs transition"
        >
            Cari Sampah
        </button>
    </form>

    <!-- Search Results List -->
    <div class="space-y-3">
        @if ($q !== '')
            <div class="flex items-center justify-between text-xs text-slate-500 px-1">
                <span>Hasil pencarian untuk "<b class="text-slate-800">{{ $q }}</b>":</span>
                <span>{{ $hasil->count() }} hasil ditemukan</span>
            </div>
        @endif

        @forelse ($hasil as $j)
            <a 
                href="{{ route('panduan.show', $j->kategori) }}" 
                class="group flex items-center justify-between rounded-2xl bg-white p-4 sm:p-5 border border-slate-200/80 shadow-2xs hover:border-emerald-300 hover:shadow-xs transition-all duration-200 hover:-translate-y-0.5"
            >
                <div class="flex items-center gap-3.5">
                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl {{ $j->diterima ? 'bg-emerald-50 text-emerald-600' : 'bg-rose-50 text-rose-600' }}">
                        @if ($j->diterima)
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        @else
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        @endif
                    </div>
                    <div>
                        <div class="flex items-center gap-2">
                            <h4 class="font-bold text-sm text-slate-900 group-hover:text-emerald-600 transition">
                                {{ $j->nama_jenis }}
                            </h4>
                            @unless($j->diterima)
                                <span class="rounded-md bg-rose-50 border border-rose-200 px-1.5 py-0.5 text-[10px] font-bold text-rose-600">
                                    Tidak Diterima di TPS Kampus
                                </span>
                            @endunless
                        </div>
                        <p class="mt-0.5 text-xs text-slate-500">
                            Kategori Tempat Sampah: <b class="text-slate-700">{{ $j->kategori->nama_kategori }}</b>
                        </p>
                    </div>
                </div>

                <div class="flex items-center gap-1 text-xs font-bold text-slate-400 group-hover:text-emerald-600 transition">
                    <span class="hidden sm:inline">Panduan</span>
                    <svg class="h-4 w-4 group-hover:translate-x-1 transition" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </div>
            </a>
        @empty
            @if ($q !== '')
                <div class="rounded-3xl bg-white border border-slate-200/80 p-12 text-center">
                    <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-slate-100 text-slate-400 mb-3">
                        <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <h4 class="text-sm font-bold text-slate-800">Jenis Sampah Tidak Ditemukan</h4>
                    <p class="mt-1 text-xs text-slate-500 max-w-sm mx-auto">
                        Kata kunci "{{ $q }}" belum terdaftar di panduan. Coba cari dengan istilah umum seperti "kertas", "plastik", atau "sisa makanan".
                    </p>
                </div>
            @endif
        @endforelse
    </div>
</div>
@endsection
