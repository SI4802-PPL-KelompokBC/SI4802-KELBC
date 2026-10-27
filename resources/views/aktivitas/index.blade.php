@extends('layouts.app', ['title' => 'Riwayat Aktivitas'])

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 text-xs font-semibold uppercase tracking-wider text-slate-400 mb-1">
                <a href="{{ route('dashboard') }}" class="hover:text-slate-600 transition">Beranda</a>
                <span>&bull;</span>
                <span class="text-emerald-600 font-bold">Aktivitas Pemilahan</span>
            </div>
            <h2 class="text-2xl font-extrabold text-slate-900 tracking-tight">
                Riwayat Aktivitas Pemilahan
            </h2>
            <p class="mt-1 text-xs sm:text-sm text-slate-500">
                Daftar seluruh pencatatan pemilahan sampah yang telah Anda ajukan untuk mendapatkan reward poin.
            </p>
        </div>

        <a 
            href="{{ route('aktivitas.create') }}" 
            class="inline-flex items-center gap-2 rounded-xl bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 px-4 py-2.5 text-xs font-bold text-white shadow-sm transition active:scale-98"
        >
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
            </svg>
            <span>Catat Aktivitas Baru</span>
        </a>
    </div>

    <!-- Filter Status Tabs -->
    <div class="flex items-center gap-2 overflow-x-auto pb-1 text-xs font-semibold">
        @php $curStatus = request('status'); @endphp
        <a 
            href="{{ route('aktivitas.index') }}" 
            class="rounded-xl px-4 py-2 transition-all {{ !$curStatus ? 'bg-emerald-600 text-white shadow-xs' : 'bg-white text-slate-600 border border-slate-200/80 hover:bg-slate-50' }}"
        >
            Semua Status
        </a>
        @foreach (['menunggu' => 'Menunggu Validasi', 'terverifikasi' => 'Terverifikasi', 'ditolak' => 'Ditolak'] as $v => $l)
            <a 
                href="{{ route('aktivitas.index', ['status' => $v]) }}" 
                class="rounded-xl px-4 py-2 transition-all {{ $curStatus === $v ? 'bg-emerald-600 text-white shadow-xs' : 'bg-white text-slate-600 border border-slate-200/80 hover:bg-slate-50' }}"
            >
                {{ $l }}
            </a>
        @endforeach
    </div>

    <!-- Data Table Container -->
    <div class="overflow-hidden rounded-3xl bg-white border border-slate-200/80 shadow-xs">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-slate-50/75 border-b border-slate-100 text-[11px] font-bold uppercase tracking-wider text-slate-500">
                    <tr>
                        <th class="px-5 py-3.5">ID Pengajuan</th>
                        <th class="px-5 py-3.5">Waktu & Tanggal</th>
                        <th class="px-5 py-3.5">Kategori</th>
                        <th class="px-5 py-3.5">Lokasi Tempat Sampah</th>
                        <th class="px-5 py-3.5">Jumlah</th>
                        <th class="px-5 py-3.5">Status</th>
                        <th class="px-5 py-3.5">Poin</th>
                        <th class="px-5 py-3.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                @forelse ($aktivitas as $a)
                    <tr class="hover:bg-slate-50/60 transition-colors">
                        <td class="px-5 py-4 font-bold text-slate-900">
                            <span class="rounded-lg bg-slate-100 px-2 py-1 text-xs font-mono text-slate-800">
                                {{ $a->kode }}
                            </span>
                        </td>
                        <td class="px-5 py-4 text-xs text-slate-600">
                            {{ $a->tanggal_waktu->translatedFormat('d M Y, H:i') }}
                        </td>
                        <td class="px-5 py-4">
                            <span class="inline-flex items-center gap-1 rounded-md bg-emerald-50 px-2 py-0.5 text-xs font-semibold text-emerald-700 border border-emerald-200/60">
                                {{ $a->kategori->nama_kategori }}
                            </span>
                        </td>
                        <td class="px-5 py-4 text-xs font-medium text-slate-700">
                            {{ $a->lokasi->nama_lokasi }}
                        </td>
                        <td class="px-5 py-4 text-xs font-semibold text-slate-800">
                            {{ $a->jumlah }} item/kg
                        </td>
                        <td class="px-5 py-4">
                            @include('partials.badge', ['status' => $a->status_verifikasi])
                        </td>
                        <td class="px-5 py-4 font-bold text-xs">
                            @if ($a->status_verifikasi === 'terverifikasi')
                                <span class="text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded-md border border-emerald-200">
                                    +{{ $a->poin_diperoleh }} Poin
                                </span>
                            @else
                                <span class="text-slate-400">-</span>
                            @endif
                        </td>
                        <td class="px-5 py-4 text-right">
                            <a 
                                href="{{ route('aktivitas.show', $a) }}" 
                                class="inline-flex items-center gap-1 rounded-lg border border-slate-200 bg-white px-2.5 py-1 text-xs font-semibold text-slate-700 hover:border-emerald-300 hover:text-emerald-700 transition shadow-2xs"
                            >
                                <span>Detail</span>
                                <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="px-5 py-16 text-center">
                            <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-slate-100 text-slate-400 mb-3">
                                <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                            </div>
                            <h4 class="text-sm font-bold text-slate-800">Tidak ada data aktivitas</h4>
                            <p class="mt-1 text-xs text-slate-500">
                                @if (request('status'))
                                    Tidak ada aktivitas dengan status "{{ request('status') }}".
                                @else
                                    Anda belum pernah mencatat aktivitas pemilahan sampah.
                                @endif
                            </p>
                            <a 
                                href="{{ route('aktivitas.create') }}" 
                                class="mt-4 inline-flex items-center gap-1.5 rounded-xl bg-emerald-600 px-4 py-2 text-xs font-bold text-white shadow-xs hover:bg-emerald-700 transition"
                            >
                                + Catat Aktivitas Sekarang
                            </a>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        @if ($aktivitas->hasPages())
            <div class="border-t border-slate-100 p-4">
                {{ $aktivitas->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
