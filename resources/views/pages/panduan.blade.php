@extends('layouts.app', ['title' => 'Panduan Pemilahan Sampah'])

@section('content')
<div class="space-y-6 p-6">

    {{-- Header + Search --}}
    <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Panduan Pemilahan Sampah</h1>
            <p class="mt-0.5 text-sm text-slate-500">Pelajari cara memilah dan membuang sampah dengan benar di lingkungan Telkom University.</p>
        </div>
        <form method="GET" action="{{ route('panduan.cari') }}" class="flex items-center gap-2 shrink-0">
            <div class="relative">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <input type="text" name="q" placeholder="Cari jenis sampah..."
                       class="w-56 rounded-xl border border-slate-200 bg-white pl-9 pr-4 py-2 text-sm text-slate-700 placeholder-slate-400 focus:outline-none focus:border-emerald-400 focus:ring-2 focus:ring-emerald-500/20">
            </div>
            <button type="submit" class="rounded-xl bg-emerald-600 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-700 transition shadow-sm">
                Cari
            </button>
        </form>
    </div>

    {{-- How-to Steps --}}
    <div class="rounded-2xl bg-white border border-slate-200/80 p-5 shadow-sm">
        <h2 class="text-sm font-bold text-slate-900 mb-4">Cara Memilah Sampah</h2>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div class="flex items-start gap-3">
                <div class="h-8 w-8 rounded-full bg-emerald-100 text-emerald-700 font-black text-sm flex items-center justify-center shrink-0">1</div>
                <div>
                    <p class="text-sm font-semibold text-slate-800">Pilahkan sejak awal</p>
                    <p class="text-xs text-slate-500 mt-0.5 leading-relaxed">Pisahkan Organik, Plastik, dan Kertas sebelum membuang.</p>
                </div>
            </div>
            <div class="flex items-start gap-3">
                <div class="h-8 w-8 rounded-full bg-emerald-100 text-emerald-700 font-black text-sm flex items-center justify-center shrink-0">2</div>
                <div>
                    <p class="text-sm font-semibold text-slate-800">Bersihkan & keringkan</p>
                    <p class="text-xs text-slate-500 mt-0.5 leading-relaxed">Kosongkan sisa makanan agar sampah tidak terkontaminasi.</p>
                </div>
            </div>
            <div class="flex items-start gap-3">
                <div class="h-8 w-8 rounded-full bg-emerald-100 text-emerald-700 font-black text-sm flex items-center justify-center shrink-0">3</div>
                <div>
                    <p class="text-sm font-semibold text-slate-800">Buang sesuai jadwal</p>
                    <p class="text-xs text-slate-500 mt-0.5 leading-relaxed">Perhatikan hari pengangkutan agar sampah tidak menumpuk.</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Category Cards --}}
    <div>
        <h2 class="text-sm font-bold text-slate-800 mb-3">Kategori Sampah</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            @foreach ($kategoris as $k)
                @php
                    $palette = match(strtolower($k->kode ?? '')) {
                        'org', 'o' => ['bg' => 'bg-emerald-50', 'border' => 'border-emerald-200', 'icon' => 'bg-emerald-600', 'text' => 'text-emerald-700', 'dot' => 'bg-emerald-500'],
                        'pls', 'p' => ['bg' => 'bg-blue-50',    'border' => 'border-blue-200',    'icon' => 'bg-blue-600',    'text' => 'text-blue-700',    'dot' => 'bg-blue-500'],
                        default    => ['bg' => 'bg-amber-50',   'border' => 'border-amber-200',   'icon' => 'bg-amber-500',   'text' => 'text-amber-700',   'dot' => 'bg-amber-500'],
                    };
                @endphp
                <div class="rounded-2xl bg-white border border-slate-200/80 shadow-sm overflow-hidden">
                    <div class="{{ $palette['bg'] }} {{ $palette['border'] }} border-b px-5 py-4 flex items-center gap-3">
                        <div class="h-10 w-10 rounded-full {{ $palette['icon'] }} flex items-center justify-center text-white font-black text-sm shrink-0">
                            {{ strtoupper(substr($k->kode, 0, 1)) }}
                        </div>
                        <div>
                            <h3 class="font-bold text-slate-900">{{ $k->nama_kategori }}</h3>
                            <p class="text-[11px] {{ $palette['text'] }} font-semibold">Kode {{ $k->kode }}</p>
                        </div>
                    </div>
                    <div class="p-5">
                        <p class="text-xs text-slate-600 leading-relaxed mb-3">{{ $k->deskripsi }}</p>
                        {{-- Example items --}}
                        @if ($k->jenis && $k->jenis->where('diterima', true)->count() > 0)
                            <div class="flex flex-wrap gap-1.5 mb-4">
                                @foreach ($k->jenis->where('diterima', true)->take(4) as $j)
                                    <span class="inline-block rounded-md bg-slate-100 px-2 py-0.5 text-[11px] font-medium text-slate-600">{{ $j->nama_jenis }}</span>
                                @endforeach
                            </div>
                        @endif
                        <a href="{{ route('panduan.show', $k) }}"
                           class="{{ $palette['text'] }} text-xs font-semibold hover:underline">
                            Lihat detail kategori &rarr;
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    {{-- Common Mistakes --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
        <div class="rounded-2xl bg-white border border-slate-200/80 p-5 shadow-sm">
            <h3 class="text-sm font-bold text-slate-900 mb-3">Kesalahan yang sering terjadi</h3>
            <ul class="space-y-2">
                @foreach (['Gelas minuman masih berisi es', 'Styrofoam berbahan campuran', 'Sisa makanan dibuang ke Plastik', 'Kantong kresek berisi sampah campuran'] as $err)
                    <li class="flex items-start gap-2 text-xs text-slate-600">
                        <svg class="h-3.5 w-3.5 text-rose-500 mt-0.5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>
                        {{ $err }}
                    </li>
                @endforeach
            </ul>
        </div>
        <div class="rounded-2xl bg-white border border-slate-200/80 p-5 shadow-sm">
            <h3 class="text-sm font-bold text-slate-900 mb-3">Warna Tempat Sampah</h3>
            <div class="space-y-2">
                @foreach ($kategoris as $k)
                    @php
                        $warna = match(strtolower($k->kode ?? '')) {
                            'org', 'o' => ['dot' => 'bg-emerald-500', 'desc' => 'Tong berwarna hijau'],
                            'pls', 'p' => ['dot' => 'bg-blue-500',    'desc' => 'Tong berwarna biru'],
                            default    => ['dot' => 'bg-amber-500',   'desc' => 'Tong berwarna kuning'],
                        };
                    @endphp
                    <div class="flex items-center gap-2 text-xs text-slate-600">
                        <span class="h-3 w-3 rounded-full {{ $warna['dot'] }} inline-block shrink-0"></span>
                        <span class="font-semibold text-slate-800">{{ $k->nama_kategori }}</span>
                        <span class="text-slate-400">&bull;</span>
                        <span>{{ $warna['desc'] }}</span>
                    </div>
                @endforeach
            </div>
            <a href="{{ route('alur.index') }}" class="mt-3 inline-flex text-xs font-semibold text-emerald-600 hover:text-emerald-700">
                Lihat Alur Pengelolaan Sampah &rarr;
            </a>
        </div>
    </div>

</div>
@endsection
