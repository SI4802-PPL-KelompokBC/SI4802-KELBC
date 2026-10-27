@extends('layouts.app', ['title' => 'Poin Saya'])

@section('content')
<div class="space-y-6 p-6">

    {{-- Header Row --}}
    <div class="flex items-start justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Poin Saya</h1>
            <p class="mt-0.5 text-sm text-slate-500">Saldo poin dihitung dari seluruh transaksi reward yang tercatat.</p>
        </div>
        <a href="{{ route('poin.riwayat') }}"
           class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50 transition shadow-sm">
            Riwayat Transaksi
        </a>
    </div>

    {{-- Saldo Hero Banner --}}
    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-emerald-700 via-emerald-800 to-teal-900 p-6 text-white">
        <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(circle at 70% 50%, #fff 0%, transparent 60%)"></div>
        <div class="relative flex flex-col md:flex-row md:items-center gap-6">
            {{-- Saldo utama --}}
            <div class="flex-1">
                <p class="text-sm font-medium text-emerald-200 mb-1">Saldo Reward Point</p>
                <div class="flex items-baseline gap-2">
                    <span class="text-6xl font-black tracking-tight">{{ number_format($saldo, 0, ',', '.') }}</span>
                    <span class="text-2xl font-semibold text-emerald-200">poin</span>
                </div>
                <p class="mt-2 text-xs text-emerald-200/80">
                    Dihitung dari {{ $transaksi->count() > 0 ? $transaksi->count() : 0 }} transaksi terbaru &bull; diperbarui {{ now()->translatedFormat('d M Y, H:i') }}
                </p>
            </div>

            {{-- Mini stats --}}
            <div class="flex gap-3 md:gap-4">
                <div class="rounded-xl bg-white/10 border border-white/15 px-4 py-3 text-center min-w-[90px]">
                    <p class="text-[11px] font-medium text-emerald-200 mb-1">Masuk bulan ini</p>
                    <p class="text-xl font-black text-white">+95</p>
                </div>
                <div class="rounded-xl bg-white/10 border border-white/15 px-4 py-3 text-center min-w-[90px]">
                    <p class="text-[11px] font-medium text-emerald-200 mb-1">Koreksi bulan ini</p>
                    <p class="text-xl font-black text-rose-300">-15</p>
                </div>
                <div class="rounded-xl bg-white/10 border border-white/15 px-4 py-3 text-center min-w-[90px]">
                    <p class="text-[11px] font-medium text-emerald-200 mb-1">Aktivitas terverifikasi</p>
                    <p class="text-xl font-black text-white">19</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Charts + Info row --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">

        {{-- Weekly Bar Chart --}}
        <div class="lg:col-span-2 rounded-2xl bg-white border border-slate-200/80 p-5 shadow-sm">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-sm font-bold text-slate-900">Poin Masuk per Minggu</h2>
                <span class="text-xs text-slate-400">6 minggu terakhir</span>
            </div>
            {{-- Bar chart built with CSS --}}
            @php
                $weekData = [
                    ['label' => '31 Agu', 'val' => 35, 'today' => false],
                    ['label' => '7 Sep',  'val' => 50, 'today' => false],
                    ['label' => '14 Sep', 'val' => 25, 'today' => false],
                    ['label' => '21 Sep', 'val' => 60, 'today' => false],
                    ['label' => '28 Sep', 'val' => 45, 'today' => false],
                    ['label' => '5 Okt',  'val' => 70, 'today' => true],
                ];
                $maxVal = max(array_column($weekData, 'val'));
            @endphp
            <div class="flex items-end justify-between gap-2 h-40">
                @foreach ($weekData as $w)
                    @php $pct = $maxVal > 0 ? round(($w['val'] / $maxVal) * 100) : 0; @endphp
                    <div class="flex flex-col items-center gap-1 flex-1">
                        <span class="text-[10px] font-bold text-slate-600">{{ $w['val'] }}</span>
                        <div class="w-full rounded-t-lg transition-all"
                             style="height: {{ $pct }}%; background: {{ $w['today'] ? '#16a34a' : '#bbf7d0' }}; min-height: 8px;"></div>
                        <span class="text-[10px] text-slate-400 whitespace-nowrap">{{ $w['label'] }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Cara Mendapat Poin + Notice --}}
        <div class="flex flex-col gap-4">
            <div class="rounded-2xl bg-white border border-slate-200/80 p-5 shadow-sm flex-1">
                <h2 class="text-sm font-bold text-slate-900 mb-3">Cara Mendapatkan Poin</h2>
                <div class="space-y-2.5">
                    <div class="flex items-center justify-between text-sm">
                        <span class="flex items-center gap-2"><span class="h-2.5 w-2.5 rounded-full bg-blue-500 inline-block"></span> Plastik</span>
                        <span class="font-bold text-emerald-600">+5 / item</span>
                    </div>
                    <div class="flex items-center justify-between text-sm">
                        <span class="flex items-center gap-2"><span class="h-2.5 w-2.5 rounded-full bg-amber-500 inline-block"></span> Kertas</span>
                        <span class="font-bold text-emerald-600">+5 / item</span>
                    </div>
                    <div class="flex items-center justify-between text-sm">
                        <span class="flex items-center gap-2"><span class="h-2.5 w-2.5 rounded-full bg-emerald-600 inline-block"></span> Organik</span>
                        <span class="font-bold text-emerald-600">+10 / kg</span>
                    </div>
                    <div class="flex items-center justify-between text-sm">
                        <span class="flex items-center gap-2"><span class="h-2.5 w-2.5 rounded-full bg-emerald-500 inline-block"></span> Bonus 5 hari sesuai jadwal</span>
                        <span class="font-bold text-emerald-600">+15</span>
                    </div>
                    <div class="flex items-center justify-between text-sm">
                        <span class="flex items-center gap-2"><span class="h-2.5 w-2.5 rounded-full bg-rose-500 inline-block"></span> Salah kategori</span>
                        <span class="font-bold text-rose-500">-10</span>
                    </div>
                </div>
                <p class="mt-3 text-[11px] text-slate-400 leading-relaxed">Poin hanya diberikan setelah aktivitas terverifikasi petugas.</p>
            </div>

            {{-- Penukaran notice --}}
            <div class="rounded-2xl bg-amber-50 border border-amber-200 p-4">
                <p class="text-xs font-bold text-amber-800">Penukaran poin belum tersedia</p>
                <p class="mt-1 text-[11px] text-amber-700 leading-relaxed">Pada tahap ini reward point digunakan sebagai gamifikasi dan belum dapat ditukar dengan hadiah.</p>
            </div>
        </div>
    </div>

    {{-- Transaksi Terbaru --}}
    <div class="rounded-2xl bg-white border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="flex items-center justify-between px-5 py-4 border-b border-slate-100">
            <h2 class="text-sm font-bold text-slate-900">Transaksi Terbaru</h2>
            <a href="{{ route('poin.riwayat') }}" class="text-sm font-semibold text-emerald-600 hover:text-emerald-700">
                Lihat semua riwayat &rarr;
            </a>
        </div>
        <div class="divide-y divide-slate-100">
            @forelse ($transaksi as $t)
                <div class="flex items-center gap-4 px-5 py-3.5">
                    <div class="h-8 w-8 flex items-center justify-center rounded-full border text-base
                        {{ $t->jumlah_poin < 0 ? 'border-rose-200 bg-rose-50 text-rose-500' : 'border-emerald-200 bg-emerald-50 text-emerald-600' }}">
                        {{ $t->jumlah_poin < 0 ? '−' : '+' }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold text-slate-900 truncate">{{ $t->keterangan }}</p>
                        <p class="text-xs text-slate-400">{{ $t->tanggal->translatedFormat('d M Y') }}</p>
                    </div>
                    <span class="text-sm font-bold {{ $t->jumlah_poin < 0 ? 'text-rose-600' : 'text-emerald-600' }}">
                        {{ $t->jumlah_poin > 0 ? '+' : '' }}{{ $t->jumlah_poin }}
                    </span>
                </div>
            @empty
                <div class="px-5 py-10 text-center text-sm text-slate-400">
                    Belum ada transaksi poin yang tercatat.
                </div>
            @endforelse
        </div>
    </div>

</div>
@endsection
