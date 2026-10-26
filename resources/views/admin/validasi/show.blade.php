@extends('layouts.app', ['title' => 'Tinjau Validasi ' . $aktivitas->kode])

@section('content')
<div class="mx-auto max-w-4xl space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 text-xs font-semibold uppercase tracking-wider text-slate-400 mb-1">
                <a href="{{ route('admin.validasi.index') }}" class="hover:text-slate-600 transition">&larr; Kembali ke Antrean</a>
                <span>&bull;</span>
                <span class="text-emerald-700 font-bold">Reviewer Console</span>
            </div>
            <div class="flex items-center gap-3">
                <h2 class="text-2xl font-extrabold text-slate-900 tracking-tight">
                    Tinjau Pengajuan {{ $aktivitas->kode }}
                </h2>
                @include('partials.badge', ['status' => $aktivitas->status_verifikasi])
            </div>
        </div>
    </div>

    <!-- Reviewer Console Card -->
    <div class="rounded-3xl bg-white border border-slate-200/80 shadow-xs p-6 sm:p-8 space-y-6">
        <!-- Submitter Identity Header -->
        <div class="flex items-center justify-between pb-4 border-b border-slate-100">
            <div class="flex items-center gap-3">
                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-slate-900 text-white font-bold text-sm shadow-xs">
                    {{ strtoupper(substr($aktivitas->pengguna->nama_lengkap, 0, 2)) }}
                </div>
                <div>
                    <h3 class="font-bold text-slate-900 text-sm">{{ $aktivitas->pengguna->nama_lengkap }}</h3>
                    <p class="text-xs text-slate-400">
                        {{ $aktivitas->pengguna->nim_nip }} &bull; {{ $aktivitas->pengguna->program_studi ?: 'Civitas Telkom University' }}
                    </p>
                </div>
            </div>
            <span class="text-xs text-slate-400 font-mono">
                Diajukan: {{ $aktivitas->created_at?->translatedFormat('d M Y, H:i') }}
            </span>
        </div>

        <!-- Evidence Photo & Details Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-start">
            <!-- Photo Evidence -->
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-2">
                    Foto Bukti Pemilahan
                </label>
                @if ($aktivitas->foto_bukti)
                    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-slate-950">
                        <a href="{{ asset('storage/' . $aktivitas->foto_bukti) }}" target="_blank" title="Klik untuk ukuran penuh">
                            <img 
                                src="{{ asset('storage/' . $aktivitas->foto_bukti) }}" 
                                class="w-full max-h-80 object-cover hover:scale-105 transition-transform duration-300" 
                                alt="Foto bukti pemilahan"
                            >
                        </a>
                    </div>
                    <p class="mt-1.5 text-center text-[11px] text-slate-400">Klik gambar untuk membuka ukuran penuh</p>
                @else
                    <div class="flex h-56 items-center justify-center rounded-2xl bg-slate-100 text-xs text-slate-400">
                        Tidak ada foto bukti yang dilampirkan
                    </div>
                @endif
            </div>

            <!-- Audit Metrics -->
            <div class="space-y-4">
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-500">
                    Data Verifikasi
                </label>

                <div class="space-y-3 text-xs">
                    <div class="rounded-2xl bg-slate-50 p-3.5 border border-slate-100">
                        <span class="text-slate-400 block font-semibold uppercase tracking-wider text-[10px]">Kategori Sampah</span>
                        <span class="font-bold text-slate-900 text-sm mt-0.5 block">
                            {{ $aktivitas->kategori->nama_kategori }} ({{ $aktivitas->kategori->kode }})
                        </span>
                    </div>

                    <div class="rounded-2xl bg-slate-50 p-3.5 border border-slate-100">
                        <span class="text-slate-400 block font-semibold uppercase tracking-wider text-[10px]">Lokasi Tempat Sampah</span>
                        <span class="font-bold text-slate-900 text-sm mt-0.5 block">
                            {{ $aktivitas->lokasi->nama_lokasi }}
                        </span>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div class="rounded-2xl bg-slate-50 p-3.5 border border-slate-100">
                            <span class="text-slate-400 block font-semibold uppercase tracking-wider text-[10px]">Waktu Aksi</span>
                            <span class="font-semibold text-slate-800 mt-0.5 block">
                                {{ $aktivitas->tanggal_waktu->translatedFormat('d M Y, H:i') }}
                            </span>
                        </div>
                        <div class="rounded-2xl bg-slate-50 p-3.5 border border-slate-100">
                            <span class="text-slate-400 block font-semibold uppercase tracking-wider text-[10px]">Jumlah</span>
                            <span class="font-semibold text-slate-800 mt-0.5 block">
                                {{ $aktivitas->jumlah }} item/kg
                            </span>
                        </div>
                    </div>

                    @if ($aktivitas->catatan)
                        <div class="rounded-2xl bg-slate-50 p-3.5 border border-slate-100">
                            <span class="text-slate-400 block font-semibold uppercase tracking-wider text-[10px]">Catatan Pengaju</span>
                            <span class="text-slate-700 italic mt-0.5 block">
                                "{{ $aktivitas->catatan }}"
                            </span>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Approval / Rejection Actions -->
        @if ($aktivitas->status_verifikasi === 'menunggu')
            <div class="pt-6 border-t border-slate-100">
                <h4 class="text-xs font-bold uppercase tracking-wider text-slate-700 mb-4">
                    Keputusan Validasi Petugas
                </h4>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-end">
                    <!-- Reject Form -->
                    <form method="POST" action="{{ route('admin.validasi.reject', $aktivitas) }}" class="space-y-3">
                        @csrf
                        <label class="block text-xs font-bold text-slate-700">
                            Tolak Pengajuan (Tuliskan Alasan):
                        </label>
                        <textarea 
                            name="alasan_penolakan" 
                            rows="2" 
                            required 
                            placeholder="mis. Foto bukti buram atau sampah tidak sesuai kategori..." 
                            class="block w-full rounded-xl border border-slate-200 bg-slate-50 px-3 py-2 text-xs text-slate-800 focus:border-red-600 focus:bg-white focus:outline-none focus:ring-2 focus:ring-red-500/20"
                        ></textarea>
                        <button type="submit" class="rounded-xl border border-rose-300 bg-rose-50 hover:bg-rose-100 px-4 py-2 text-xs font-bold text-rose-700 transition">
                            ✕ Tolak Pengajuan
                        </button>
                    </form>

                    <!-- Approve Form -->
                    <form method="POST" action="{{ route('admin.validasi.approve', $aktivitas) }}" class="flex justify-end">
                        @csrf
                        <button type="submit" class="w-full sm:w-auto rounded-xl bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 px-6 py-3.5 text-xs font-extrabold text-white shadow-md shadow-emerald-600/20 transition active:scale-98">
                            ✓ Setujui & Berikan Reward Poin
                        </button>
                    </form>
                </div>
            </div>
        @elseif ($aktivitas->status_verifikasi === 'ditolak')
            <div class="rounded-2xl bg-rose-50 border border-rose-200 p-4 text-xs text-rose-800">
                <span class="font-bold">Pengajuan telah ditolak:</span> {{ $aktivitas->alasan_penolakan }}
            </div>
        @else
            <div class="rounded-2xl bg-emerald-50 border border-emerald-200 p-4 text-xs text-emerald-900 flex items-center justify-between">
                <div>
                    <span class="font-bold">Pengajuan telah disetujui:</span> Poin sebesar +{{ $aktivitas->poin_diperoleh }} telah dikreditkan.
                </div>
                @if ($aktivitas->petugas)
                    <span class="text-emerald-700">Petugas: {{ $aktivitas->petugas->nama_lengkap }}</span>
                @endif
            </div>
        @endif

        <!-- Koreksi Poin Form -->
        <div class="pt-6 border-t border-slate-100">
            <h4 class="text-xs font-bold uppercase tracking-wider text-slate-600 mb-2">
                Koreksi Poin Pengguna (Pengurangan Khusus)
            </h4>
            <form method="POST" action="{{ route('admin.validasi.koreksi', $aktivitas) }}" class="flex flex-col sm:flex-row items-end gap-3 text-xs">
                @csrf
                <div class="w-full sm:w-32">
                    <label class="block text-[11px] font-semibold text-slate-500 mb-1">Jumlah Poin</label>
                    <input 
                        type="number" 
                        name="jumlah" 
                        min="1" 
                        placeholder="10" 
                        required 
                        class="block w-full rounded-xl border border-slate-200 bg-slate-50 px-3 py-2 text-xs focus:border-emerald-600 focus:bg-white focus:outline-none"
                    >
                </div>
                <div class="w-full sm:flex-1">
                    <label class="block text-[11px] font-semibold text-slate-500 mb-1">Keterangan Koreksi</label>
                    <input 
                        name="keterangan" 
                        placeholder="mis. pembuangan sampah tidak sesuai kategori" 
                        required 
                        class="block w-full rounded-xl border border-slate-200 bg-slate-50 px-3 py-2 text-xs focus:border-emerald-600 focus:bg-white focus:outline-none"
                    >
                </div>
                <button type="submit" class="w-full sm:w-auto rounded-xl border border-emerald-300 bg-emerald-50 hover:bg-emerald-100 px-4 py-2 text-xs font-bold text-emerald-800 transition">
                    Catat Koreksi
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
