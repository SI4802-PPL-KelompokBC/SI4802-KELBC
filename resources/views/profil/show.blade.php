@extends('layouts.app', ['title' => 'Profil Civitas Kampus'])

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 text-xs font-semibold uppercase tracking-wider text-slate-400 mb-1">
                <a href="{{ route('dashboard') }}" class="hover:text-slate-600 transition">Beranda</a>
                <span>&bull;</span>
                <span class="text-emerald-700 font-bold">Akun Pengguna</span>
            </div>
            <h2 class="text-2xl font-extrabold text-slate-900 tracking-tight">
                Profil Civitas Academica
            </h2>
            <p class="mt-1 text-xs sm:text-sm text-slate-500">
                Informasi identitas kampus, perolehan reward poin, dan ringkasan aktivitas pemilahan Anda.
            </p>
        </div>

        <a 
            href="{{ route('profil.edit') }}" 
            class="inline-flex items-center gap-2 rounded-xl bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 px-4 py-2.5 text-xs font-bold text-white shadow-xs transition"
        >
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
            </svg>
            <span>Edit Data & Pengaturan</span>
        </a>
    </div>

    <!-- Main Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
        <!-- Digital University ID Card (1 col with Thin 1px Border) -->
        <div class="lg:col-span-1 rounded-3xl bg-white border border-slate-200/80 shadow-xs overflow-hidden">
            <!-- Card Header Ribbon (Vibrant Emerald Theme) -->
            <div class="bg-gradient-to-br from-emerald-600 via-emerald-700 to-teal-800 p-6 text-white text-center relative border-b border-emerald-500/30">
                <div class="absolute top-3 right-3">
                    <span class="inline-flex items-center rounded-full bg-white/20 px-2.5 py-0.5 text-[10px] font-extrabold text-white border border-white/30 shadow-2xs">
                        {{ strtoupper($user->peran) }}
                    </span>
                </div>

                <div class="mx-auto flex h-24 w-24 items-center justify-center rounded-2xl bg-white text-emerald-800 text-3xl font-black shadow-md border border-white/90 overflow-hidden mb-3">
                    @if ($user->foto_profil)
                        <img src="{{ asset('storage/' . $user->foto_profil) }}" class="h-full w-full object-cover" alt="{{ $user->nama_lengkap }}">
                    @else
                        {{ strtoupper(substr($user->nama_lengkap, 0, 2)) }}
                    @endif
                </div>

                <h3 class="font-extrabold text-lg text-white tracking-tight drop-shadow-xs">{{ $user->nama_lengkap }}</h3>
                <p class="text-xs text-emerald-100 font-medium mt-0.5">{{ $user->program_studi ?: 'Civitas Telkom University' }}</p>
                <div class="mt-2 text-[11px] font-mono font-bold text-white bg-white/20 px-2.5 py-1 rounded-lg inline-block border border-white/25">
                    NIM/NIP: {{ $user->nim_nip }}
                </div>
            </div>

            <!-- Card Details Body -->
            <div class="p-6 space-y-4 text-xs">
                <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                    <span class="text-slate-400 font-semibold uppercase tracking-wider">Email Kampus</span>
                    <span class="font-bold text-slate-800">{{ $user->email_kampus }}</span>
                </div>

                <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                    <span class="text-slate-400 font-semibold uppercase tracking-wider">No. Handphone</span>
                    <span class="font-medium text-slate-700">{{ $user->no_hp ?? '-' }}</span>
                </div>

                <div class="flex items-center justify-between pb-3 border-b border-slate-100">
                    <span class="text-slate-400 font-semibold uppercase tracking-wider">Status Akun</span>
                    <span class="inline-flex items-center gap-1 font-bold text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded-full border border-emerald-200">
                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                        {{ ucfirst($user->status_akun) }}
                    </span>
                </div>

                <div class="flex items-center justify-between">
                    <span class="text-slate-400 font-semibold uppercase tracking-wider">Bergabung Sejak</span>
                    <span class="font-medium text-slate-700">{{ $user->tanggal_bergabung?->translatedFormat('d F Y') }}</span>
                </div>
            </div>
        </div>

        <!-- Statistics & Activity Log (2 cols) -->
        <div class="lg:col-span-2 space-y-6">
            <!-- 3 Mini Stats -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="rounded-2xl bg-white p-5 border border-slate-200/80 shadow-2xs">
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Total Pengajuan</span>
                    <div class="mt-2 text-3xl font-extrabold text-slate-900">{{ $total }}</div>
                    <p class="mt-1 text-[11px] text-slate-400">Seluruh riwayat aksi</p>
                </div>

                <div class="rounded-2xl bg-white p-5 border border-slate-200/80 shadow-2xs">
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Terverifikasi</span>
                    <div class="mt-2 text-3xl font-extrabold text-emerald-600">{{ $terverifikasi }}</div>
                    <p class="mt-1 text-[11px] text-slate-400">Tervalidasi sukses</p>
                </div>

                <div class="rounded-2xl bg-white p-5 border border-slate-200/80 shadow-2xs">
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Saldo Poin</span>
                    <div class="mt-2 text-3xl font-extrabold text-amber-600">{{ number_format($saldo, 0, ',', '.') }}</div>
                    <p class="mt-1 text-[11px] text-slate-400">Dapat ditukarkan nanti</p>
                </div>
            </div>

            <!-- Recent Activity List -->
            <div class="rounded-3xl bg-white border border-slate-200/80 shadow-xs p-6">
                <div class="flex items-center justify-between border-b border-slate-100 pb-4 mb-4">
                    <h3 class="font-bold text-sm text-slate-900 flex items-center gap-2">
                        <svg class="h-4 w-4 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Aktivitas Terbaru
                    </h3>
                    <a href="{{ route('aktivitas.index') }}" class="text-xs font-bold text-emerald-600 hover:text-emerald-700 hover:underline">
                        Lihat Selengkapnya &rarr;
                    </a>
                </div>

                <div class="divide-y divide-slate-100">
                    @forelse ($terbaru as $a)
                        <div class="flex items-center justify-between py-3">
                            <div class="flex items-center gap-3">
                                <span class="rounded bg-slate-100 px-2 py-0.5 text-xs font-mono font-bold text-slate-800">
                                    {{ $a->kode }}
                                </span>
                                <div>
                                    <span class="text-xs font-bold text-slate-800">Sampah {{ $a->kategori->nama_kategori }}</span>
                                    <span class="block text-[11px] text-slate-400">{{ $a->tanggal_waktu->translatedFormat('d M Y, H:i') }}</span>
                                </div>
                            </div>
                            @include('partials.badge', ['status' => $a->status_verifikasi])
                        </div>
                    @empty
                        <p class="text-center py-8 text-xs text-slate-400">Belum ada aktivitas yang tercatat pada akun ini.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
