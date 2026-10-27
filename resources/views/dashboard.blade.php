@extends('layouts.app', ['title' => 'Beranda Dashboard'])

@section('content')
<div class="space-y-6 sm:space-y-8">
    <!-- Hero Banner Card (Vibrant Eco Green Theme with High Contrast & Thin Border) -->
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-emerald-600 via-emerald-700 to-teal-800 p-6 sm:p-8 text-white shadow-lg shadow-emerald-900/15 border border-emerald-500/40">
        <!-- Background Decorative Glow -->
        <div class="absolute -right-12 -bottom-12 h-64 w-64 rounded-full bg-white/10 blur-3xl pointer-events-none"></div>

        <div class="relative z-10 flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
            <div class="max-w-2xl">
                <div class="flex flex-wrap items-center gap-2 mb-3">
                    <span class="inline-flex items-center gap-1.5 rounded-full bg-white/20 px-3 py-1 text-xs font-semibold text-white backdrop-blur-xs border border-white/25 shadow-2xs">
                        <svg class="h-3.5 w-3.5 text-emerald-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        {{ now()->translatedFormat('l, d F Y') }}
                    </span>
                    <span class="inline-flex items-center gap-1.5 rounded-full bg-white/20 px-3 py-1 text-xs font-bold text-white border border-white/25 shadow-2xs">
                        Telkom University Eco System
                    </span>
                </div>

                <h2 class="text-2xl sm:text-3xl font-black tracking-tight text-white leading-tight drop-shadow-xs">
                    Semangat Pagi, {{ auth()->user()->nama_panggilan ?? auth()->user()->nama_lengkap }}! 🌱
                </h2>

                <div class="mt-3 flex items-center gap-2 text-sm text-emerald-100 font-medium">
                    <span>Jadwal pengangkutan sampah hari ini:</span>
                    <span class="inline-flex items-center gap-1 font-bold text-white bg-white/20 px-2.5 py-0.5 rounded-lg border border-white/30">
                        Sampah {{ $kategoriHariIni?->nama_kategori ?? 'Semua Jenis' }}
                    </span>
                </div>

                <p class="mt-2 text-xs sm:text-sm text-emerald-50/95 leading-relaxed font-medium">
                    Pastikan sampah dipilah sesuai kategori sebelum dibuang ke titik pembuangan terdekat untuk memperoleh reward poin kampus.
                </p>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-wrap sm:flex-nowrap items-center gap-3">
                <a 
                    href="{{ route('aktivitas.create') }}" 
                    class="group inline-flex items-center justify-center gap-2 rounded-xl bg-white px-5 py-3 text-sm font-extrabold text-emerald-800 shadow-md shadow-emerald-950/20 transition-all duration-200 hover:bg-emerald-50 hover:shadow-lg hover:scale-102 active:scale-98"
                >
                    <svg class="h-4 w-4 text-emerald-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                    </svg>
                    <span>Catat Aktivitas</span>
                </a>

                <a 
                    href="{{ route('peta.index') }}" 
                    class="inline-flex items-center justify-center gap-2 rounded-xl bg-white/20 hover:bg-white/30 px-4 py-3 text-sm font-bold text-white border border-white/30 backdrop-blur-xs transition-all hover:scale-102 shadow-2xs"
                >
                    <svg class="h-4 w-4 text-emerald-100" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <span>Cari Titik Sampah</span>
                </a>
            </div>
        </div>
    </div>

    <!-- 4 Modern Stat Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-5">
        <!-- Saldo Poin -->
        <a href="{{ route('poin.index') }}" class="group relative overflow-hidden rounded-2xl bg-white p-5 border border-slate-200/80 shadow-2xs hover:shadow-md hover:border-emerald-300 transition-all duration-200 hover:-translate-y-0.5">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold uppercase tracking-wider text-slate-500">Saldo Poin</span>
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600 border border-emerald-200/60 group-hover:scale-110 transition-transform">
                    <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 2a1 1 0 011 1v1.323l3.954 1.582 1.599-.8a1 1 0 01.894 1.79l-1.233.616 1.738 5.42a1 1 0 01-.285 1.05A3.989 3.989 0 0115 15a3.989 3.989 0 01-2.667-1.019 1 1 0 01-.285-1.05l1.715-5.349L11 6.477V16h2a1 1 0 110 2H7a1 1 0 110-2h2V6.477L6.237 7.582l1.715 5.349a1 1 0 01-.285 1.05A3.989 3.989 0 015 15a3.989 3.989 0 01-2.667-1.019 1 1 0 01-.285-1.05l1.738-5.42-1.233-.617a1 1 0 01.894-1.788l1.599.799L9 4.323V3a1 1 0 011-1z" clip-rule="evenodd"/>
                    </svg>
                </div>
            </div>
            <div class="mt-3 flex items-baseline gap-2">
                <span class="text-3xl font-extrabold tracking-tight text-slate-900">{{ number_format($saldo, 0, ',', '.') }}</span>
                <span class="text-xs font-semibold text-emerald-700 uppercase">Poin</span>
            </div>
            <p class="mt-1 text-[11px] text-slate-400">Total reward terakumulasi</p>
        </a>

        <!-- Total Aktivitas -->
        <a href="{{ route('aktivitas.index') }}" class="group relative overflow-hidden rounded-2xl bg-white p-5 border border-slate-200/80 shadow-2xs hover:shadow-md hover:border-slate-300 transition-all duration-200 hover:-translate-y-0.5">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold uppercase tracking-wider text-slate-500">Total Pengajuan</span>
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-slate-100 text-slate-700 border border-slate-200/60 group-hover:scale-110 transition-transform">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                    </svg>
                </div>
            </div>
            <div class="mt-3 flex items-baseline gap-2">
                <span class="text-3xl font-extrabold tracking-tight text-slate-900">{{ $totalAktivitas }}</span>
                <span class="text-xs font-medium text-slate-500">kali</span>
            </div>
            <p class="mt-1 text-[11px] text-slate-400">Seluruh riwayat aksi</p>
        </a>

        <!-- Terverifikasi -->
        <div class="group relative overflow-hidden rounded-2xl bg-white p-5 border border-slate-200/80 shadow-2xs hover:shadow-md hover:border-emerald-300 transition-all duration-200 hover:-translate-y-0.5">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold uppercase tracking-wider text-slate-500">Terverifikasi</span>
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600 border border-emerald-200/60 group-hover:scale-110 transition-transform">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <div class="mt-3 flex items-baseline gap-2">
                <span class="text-3xl font-extrabold tracking-tight text-emerald-700">{{ $terverifikasi }}</span>
                <span class="text-xs font-medium text-slate-500">berhasil</span>
            </div>
            <p class="mt-1 text-[11px] text-slate-400">Poin telah dikreditkan</p>
        </div>

        <!-- Menunggu Validasi -->
        <div class="group relative overflow-hidden rounded-2xl bg-white p-5 border border-slate-200/80 shadow-2xs hover:shadow-md hover:border-amber-300 transition-all duration-200 hover:-translate-y-0.5">
            <div class="flex items-center justify-between">
                <span class="text-xs font-bold uppercase tracking-wider text-slate-500">Menunggu Validasi</span>
                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-amber-50 text-amber-600 border border-amber-200/60 group-hover:scale-110 transition-transform">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <div class="mt-3 flex items-baseline gap-2">
                <span class="text-3xl font-extrabold tracking-tight text-amber-600">{{ $menunggu }}</span>
                <span class="text-xs font-medium text-slate-500">antrean</span>
            </div>
            <p class="mt-1 text-[11px] text-slate-400">Sedang ditinjau petugas</p>
        </div>
    </div>

    <!-- Quick Shortcuts Grid -->
    <div>
        <h3 class="text-sm font-bold uppercase tracking-wider text-slate-600 mb-3">Layanan Civitas Kampus</h3>
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 sm:gap-4">
            <a href="{{ route('panduan.index') }}" class="group flex flex-col items-center justify-center rounded-2xl bg-white p-4 border border-slate-200/80 shadow-2xs hover:border-emerald-300 hover:shadow-sm transition-all text-center">
                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-emerald-50 text-emerald-700 mb-2 group-hover:scale-110 transition-transform">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>
                <span class="text-xs font-bold text-slate-800">Panduan Sampah</span>
                <span class="text-[10px] text-slate-400 mt-0.5">Klasifikasi & Tips</span>
            </a>

            <a href="{{ route('jadwal.index') }}" class="group flex flex-col items-center justify-center rounded-2xl bg-white p-4 border border-slate-200/80 shadow-2xs hover:border-emerald-300 hover:shadow-sm transition-all text-center">
                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-teal-50 text-teal-700 mb-2 group-hover:scale-110 transition-transform">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <span class="text-xs font-bold text-slate-800">Jadwal Angkut</span>
                <span class="text-[10px] text-slate-400 mt-0.5">Kalender & Jam</span>
            </a>

            <a href="{{ route('peta.index') }}" class="group flex flex-col items-center justify-center rounded-2xl bg-white p-4 border border-slate-200/80 shadow-2xs hover:border-emerald-300 hover:shadow-sm transition-all text-center">
                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600 mb-2 group-hover:scale-110 transition-transform">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <span class="text-xs font-bold text-slate-800">Peta Lokasi</span>
                <span class="text-[10px] text-slate-400 mt-0.5">Navigasi Titik Drop</span>
            </a>

            <a href="{{ route('alur.index') }}" class="group flex flex-col items-center justify-center rounded-2xl bg-white p-4 border border-slate-200/80 shadow-2xs hover:border-emerald-300 hover:shadow-sm transition-all text-center">
                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-green-50 text-green-700 mb-2 group-hover:scale-110 transition-transform">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                </div>
                <span class="text-xs font-bold text-slate-800">Alur Kampus</span>
                <span class="text-[10px] text-slate-400 mt-0.5">Siklus Pengolahan</span>
            </a>
        </div>
    </div>

    <!-- Recent Activities Section -->
    <div class="rounded-3xl bg-white border border-slate-200/80 shadow-xs overflow-hidden">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 p-5 sm:p-6 border-b border-slate-100 bg-slate-50/50">
            <div>
                <h3 class="text-base font-bold text-slate-900 flex items-center gap-2">
                    <svg class="h-5 w-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Aktivitas Pemilahan Terbaru
                </h3>
                <p class="text-xs text-slate-500 mt-0.5">Pantau status verifikasi dan bukti yang telah Anda unggah</p>
            </div>
            
            <a 
                href="{{ route('aktivitas.index') }}" 
                class="inline-flex items-center gap-1.5 text-xs font-bold text-emerald-600 hover:text-emerald-700 hover:underline"
            >
                <span>Lihat Semua Riwayat</span>
                <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        </div>

        <div class="divide-y divide-slate-100">
            @forelse ($terbaru as $a)
                <a 
                    href="{{ route('aktivitas.show', $a) }}" 
                    class="group flex flex-col sm:flex-row sm:items-center justify-between p-4 sm:p-5 hover:bg-slate-50/80 transition-colors gap-3"
                >
                    <div class="flex items-start sm:items-center gap-3.5">
                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-slate-100 group-hover:bg-emerald-50 text-slate-600 group-hover:text-emerald-600 transition-colors border border-slate-200/60">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                            </svg>
                        </div>
                        <div>
                            <div class="flex items-center gap-2">
                                <span class="font-bold text-sm text-slate-900 group-hover:text-emerald-600 transition-colors">
                                    {{ $a->kode }}
                                </span>
                                <span class="text-xs text-slate-400">&bull;</span>
                                <span class="text-xs font-semibold text-slate-700">
                                    Sampah {{ $a->kategori->nama_kategori }}
                                </span>
                            </div>
                            <div class="mt-1 flex flex-wrap items-center gap-x-3 gap-y-1 text-xs text-slate-500">
                                <span class="flex items-center gap-1">
                                    <svg class="h-3.5 w-3.5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    {{ $a->lokasi->nama_lokasi }}
                                </span>
                                <span>&bull;</span>
                                <span>{{ $a->tanggal_waktu->translatedFormat('d M Y, H:i') }}</span>
                                <span>&bull;</span>
                                <span class="font-medium text-slate-700">{{ $a->jumlah }} item/kg</span>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-between sm:justify-end gap-3 shrink-0">
                        @include('partials.badge', ['status' => $a->status_verifikasi])
                        <svg class="h-4 w-4 text-slate-400 group-hover:text-slate-600 group-hover:translate-x-1 transition" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </div>
                </a>
            @empty
                <div class="p-12 text-center">
                    <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-slate-100 text-slate-400 mb-3">
                        <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                        </svg>
                    </div>
                    <h4 class="text-sm font-bold text-slate-800">Belum ada aktivitas tercatat</h4>
                    <p class="mt-1 text-xs text-slate-500 max-w-sm mx-auto">
                        Mulai pilah sampah Anda sekarang dan dapatkan reward poin kampus Telkom University.
                    </p>
                    <a 
                        href="{{ route('aktivitas.create') }}" 
                        class="mt-4 inline-flex items-center gap-1.5 rounded-xl bg-emerald-600 px-4 py-2 text-xs font-bold text-white shadow-xs hover:bg-emerald-700 transition"
                    >
                        Catat Aktivitas Pertama
                    </a>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
