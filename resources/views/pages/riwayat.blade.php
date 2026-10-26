@extends('layouts.app', ['title' => 'Riwayat Transaksi Poin'])

@section('content')
<div class="space-y-6 p-6">

    {{-- Breadcrumb + Header --}}
    <div>
        <nav class="flex items-center gap-1.5 text-xs text-slate-400 mb-2">
            <a href="{{ route('poin.index') }}" class="hover:text-emerald-600 transition">Poin Saya</a>
            <span>/</span>
            <span class="font-semibold text-slate-700">Riwayat Transaksi</span>
        </nav>
        <div class="flex items-start justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Riwayat Transaksi Poin</h1>
                <p class="mt-0.5 text-sm text-slate-500">Semua poin masuk dan koreksi beserta keterangannya. Saldo selalu dapat ditelusuri dari transaksi.</p>
            </div>
            <div>
                <select class="rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm font-medium text-slate-700 shadow-sm focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-400">
                    <option>Periode: Okt 2026</option>
                    <option>Sep 2026</option>
                    <option>Agu 2026</option>
                </select>
            </div>
        </div>
    </div>

    {{-- Summary Cards --}}
    @php
        $totalMasuk   = $transaksi->where('jumlah_poin', '>', 0)->sum('jumlah_poin');
        $totalKoreksi = $transaksi->where('jumlah_poin', '<', 0)->sum('jumlah_poin');
        $jmlMasuk     = $transaksi->where('jumlah_poin', '>', 0)->count();
        $jmlKoreksi   = $transaksi->where('jumlah_poin', '<', 0)->count();
        $saldoHitung  = $totalMasuk + $totalKoreksi;
    @endphp
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="rounded-2xl bg-white border border-slate-200/80 p-5 shadow-sm">
            <div class="flex items-center gap-2 text-emerald-500 mb-2">
                <span class="h-2.5 w-2.5 rounded-full bg-emerald-500 inline-block"></span>
                <span class="text-sm font-semibold text-slate-600">Total Poin Masuk</span>
            </div>
            <p class="text-3xl font-black text-slate-900">+{{ number_format($totalMasuk, 0, ',', '.') }}</p>
            <p class="mt-1 text-xs text-slate-400">sejak bergabung &bull; {{ $jmlMasuk }} transaksi</p>
        </div>
        <div class="rounded-2xl bg-white border border-slate-200/80 p-5 shadow-sm">
            <div class="flex items-center gap-2 mb-2">
                <span class="h-2.5 w-2.5 rounded-full bg-rose-500 inline-block"></span>
                <span class="text-sm font-semibold text-slate-600">Total Koreksi</span>
            </div>
            <p class="text-3xl font-black text-rose-500">{{ $totalKoreksi }}</p>
            <p class="mt-1 text-xs text-slate-400">{{ $jmlKoreksi }} transaksi koreksi</p>
        </div>
        <div class="rounded-2xl bg-white border border-slate-200/80 p-5 shadow-sm">
            <div class="flex items-center gap-2 mb-2">
                <span class="h-2.5 w-2.5 rounded-full bg-emerald-500 inline-block"></span>
                <span class="text-sm font-semibold text-slate-600">Saldo Saat Ini</span>
            </div>
            <p class="text-3xl font-black text-slate-900">{{ number_format($saldoHitung, 0, ',', '.') }}</p>
            <p class="mt-1 text-xs text-slate-400">= poin masuk &minus; koreksi</p>
        </div>
    </div>

    {{-- Filter Tabs + Search --}}
    @php $curJenis = request('jenis'); @endphp
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <div class="flex items-center gap-2">
            <a href="{{ route('poin.riwayat') }}"
               class="inline-flex items-center gap-1.5 rounded-full px-4 py-1.5 text-xs font-bold transition
                      {{ !$curJenis ? 'bg-[#1fa959] text-white shadow-2xs' : 'bg-white text-slate-700 border border-slate-200 hover:bg-slate-50' }}">
                <span>Semua</span>
                <span class="rounded-full px-1.5 py-0.2 text-[10px] {{ !$curJenis ? 'bg-white/20 text-white' : 'bg-slate-100 text-slate-600' }}">
                    {{ $transaksi->total() }}
                </span>
            </a>
            <a href="{{ route('poin.riwayat', ['jenis' => 'masuk']) }}"
               class="inline-flex items-center gap-1.5 rounded-full px-4 py-1.5 text-xs font-bold transition
                      {{ $curJenis === 'masuk' ? 'bg-[#1fa959] text-white shadow-2xs' : 'bg-white text-slate-700 border border-slate-200 hover:bg-slate-50' }}">
                <span>Poin Masuk</span>
                <span class="rounded-full px-1.5 py-0.2 text-[10px] {{ $curJenis === 'masuk' ? 'bg-white/20 text-white' : 'bg-slate-100 text-slate-600' }}">
                    {{ $jmlMasuk }}
                </span>
            </a>
            <a href="{{ route('poin.riwayat', ['jenis' => 'koreksi']) }}"
               class="inline-flex items-center gap-1.5 rounded-full px-4 py-1.5 text-xs font-bold transition
                      {{ $curJenis === 'koreksi' ? 'bg-[#1fa959] text-white shadow-2xs' : 'bg-white text-slate-700 border border-slate-200 hover:bg-slate-50' }}">
                <span>Koreksi</span>
                <span class="rounded-full px-1.5 py-0.2 text-[10px] {{ $curJenis === 'koreksi' ? 'bg-white/20 text-white' : 'bg-slate-100 text-slate-600' }}">
                    {{ $jmlKoreksi }}
                </span>
            </a>
        </div>
        <div class="relative">
            <input type="text" placeholder="Cari keterangan atau ID..."
                   class="w-full sm:w-72 rounded-xl border border-slate-200 bg-white pl-9 pr-4 py-2 text-xs text-slate-700 placeholder-slate-400 focus:outline-none focus:border-emerald-400 focus:ring-2 focus:ring-emerald-500/20">
            <svg class="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
        </div>
    </div>

    {{-- Transactions Table --}}
    <div class="rounded-2xl bg-white border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="border-b border-slate-100 bg-slate-50/60">
                    <tr class="text-[11px] font-bold uppercase tracking-wider text-slate-400">
                        <th class="px-5 py-3.5">Tanggal</th>
                        <th class="px-5 py-3.5">ID</th>
                        <th class="px-5 py-3.5">Keterangan</th>
                        <th class="px-5 py-3.5">Sumber</th>
                        <th class="px-5 py-3.5">Jenis</th>
                        <th class="px-5 py-3.5 text-right">Jumlah</th>
                        <th class="px-5 py-3.5 text-right">Saldo</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @php $running = $currentSaldo ?? $saldoHitung; @endphp
                    @forelse ($transaksi as $i => $t)
                        @php
                            $rowSaldo = $running;
                            $running -= $t->jumlah_poin;
                        @endphp
                        <tr class="hover:bg-slate-50/60 transition-colors">
                            <td class="px-5 py-4 text-xs text-slate-600 whitespace-nowrap">
                                {{ $t->tanggal->translatedFormat('d M, H:i') }}
                            </td>
                            <td class="px-5 py-4">
                                <span class="font-mono text-xs font-semibold text-slate-700">TRX-{{ str_pad($t->id_transaksi, 4, '0', STR_PAD_LEFT) }}</span>
                            </td>
                            <td class="px-5 py-4 text-xs text-slate-700 max-w-xs">{{ $t->keterangan }}</td>
                            <td class="px-5 py-4">
                                @if ($t->jenis === 'koreksi')
                                    <span class="text-xs font-semibold text-orange-600">Petugas</span>
                                @elseif ($t->id_aktivitas)
                                    <span class="text-xs font-semibold text-emerald-600">AKT-{{ str_pad($t->id_aktivitas, 4, '0', STR_PAD_LEFT) }}</span>
                                @else
                                    <span class="text-xs font-semibold text-emerald-600">RWD-{{ str_pad($t->id_transaksi, 2, '0', STR_PAD_LEFT) }}</span>
                                @endif
                            </td>
                            <td class="px-5 py-4">
                                @if ($t->jenis === 'koreksi')
                                    <span class="inline-flex items-center gap-1 rounded-full bg-rose-50 border border-rose-200 px-2.5 py-0.5 text-[11px] font-bold text-rose-600">
                                        <span class="h-1.5 w-1.5 rounded-full bg-rose-500 inline-block"></span>
                                        Koreksi
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 rounded-full bg-emerald-50 border border-emerald-200 px-2.5 py-0.5 text-[11px] font-bold text-emerald-700">
                                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-500 inline-block"></span>
                                        Poin Masuk
                                    </span>
                                @endif
                            </td>
                            <td class="px-5 py-4 text-right font-bold text-sm {{ $t->jumlah_poin < 0 ? 'text-rose-600' : 'text-slate-900' }}">
                                {{ $t->jumlah_poin > 0 ? '+' : '' }}{{ $t->jumlah_poin }}
                            </td>
                            <td class="px-5 py-4 text-right text-xs text-slate-700 font-semibold whitespace-nowrap">
                                {{ number_format($rowSaldo, 0, ',', '.') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-5 py-14 text-center text-sm text-slate-400">
                                Belum ada transaksi yang cocok dengan filter ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if ($transaksi->hasPages())
            <div class="flex items-center justify-between border-t border-slate-100 px-5 py-3">
                <p class="text-xs text-slate-500">
                    Menampilkan {{ $transaksi->firstItem() }}&ndash;{{ $transaksi->lastItem() }} dari {{ $transaksi->total() }} transaksi
                </p>
                {{ $transaksi->links() }}
            </div>
        @else
            <div class="border-t border-slate-100 px-5 py-3">
                <p class="text-xs text-slate-500">Menampilkan {{ $transaksi->count() }} dari {{ $transaksi->total() }} transaksi</p>
            </div>
        @endif
    </div>

    {{-- Info Note matching 6.2 --}}
    <div class="flex items-start gap-3 rounded-2xl bg-[#eaf8ef] border border-emerald-200/70 p-4">
        <div class="h-6 w-6 rounded-full bg-[#1fa959] text-white flex items-center justify-center font-bold text-xs shrink-0 mt-0.5 shadow-2xs">i</div>
        <div>
            <h4 class="text-xs font-bold text-emerald-900">Saldo dihitung dari transaksi</h4>
            <p class="text-xs text-emerald-800 mt-0.5 leading-relaxed">
                Setiap penambahan atau koreksi poin dicatat sebagai transaksi dengan keterangan dan sumbernya, sehingga saldo selalu bisa ditelusuri.
            </p>
        </div>
    </div>

</div>
@endsection
