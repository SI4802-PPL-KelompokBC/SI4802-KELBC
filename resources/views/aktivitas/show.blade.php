@extends('layouts.app', ['title' => 'Detail ' . $aktivitas->kode])

@section('content')
<div class="mx-auto max-w-4xl space-y-6">
    <!-- Header with Back Link & Action Buttons -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 text-xs font-semibold uppercase tracking-wider text-slate-400 mb-1">
                <a href="{{ route('aktivitas.index') }}" class="hover:text-slate-600 transition">&larr; Kembali ke Riwayat</a>
                <span>&bull;</span>
                <span class="text-emerald-700 font-bold">Detail Pengajuan</span>
            </div>
            <div class="flex items-center gap-3">
                <h2 class="text-2xl font-extrabold text-slate-900 tracking-tight">
                    Pengajuan {{ $aktivitas->kode }}
                </h2>
                @include('partials.badge', ['status' => $aktivitas->status_verifikasi])
            </div>
        </div>

        <div class="flex items-center gap-2">
            @if ($aktivitas->status_verifikasi === 'menunggu')
                <form method="POST" action="{{ route('aktivitas.destroy', $aktivitas) }}" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan pengajuan pemilahan ini?')">
                    @csrf 
                    @method('DELETE')
                    <button type="submit" class="rounded-xl border border-rose-200 bg-rose-50 px-4 py-2.5 text-xs font-bold text-rose-700 hover:bg-rose-100 transition shadow-2xs">
                        Batalkan Pengajuan
                    </button>
                </form>
            @endif

            @if ($aktivitas->bisa_diubah)
                <a 
                    href="{{ route('aktivitas.edit', $aktivitas) }}" 
                    class="rounded-xl bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 px-4 py-2.5 text-xs font-bold text-white shadow-xs transition"
                >
                    {{ $aktivitas->status_verifikasi === 'ditolak' ? 'Ajukan Ulang dengan Revisi' : 'Edit Pengajuan' }}
                </a>
            @endif
        </div>
    </div>

    <!-- Status Banner Message -->
    @if ($aktivitas->status_verifikasi === 'menunggu')
        <div class="flex items-start gap-3 rounded-2xl bg-amber-50 border border-amber-200 p-4 text-xs sm:text-sm text-amber-900 shadow-2xs">
            <span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-xl bg-amber-500 text-white font-bold">
                ⏳
            </span>
            <div>
                <span class="font-bold">Menunggu Validasi Petugas:</span>
                Pengajuan Anda sedang dalam antrean verifikasi tim kebersihan dan pengelolaan sampah Telkom University. Anda masih dapat mengedit atau membatalkan data ini.
            </div>
        </div>
    @elseif ($aktivitas->status_verifikasi === 'terverifikasi')
        <div class="flex items-start gap-3 rounded-2xl bg-emerald-50 border border-emerald-200 p-4 text-xs sm:text-sm text-emerald-900 shadow-2xs">
            <span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-xl bg-emerald-500 text-white font-bold">
                ✓
            </span>
            <div>
                <span class="font-bold text-emerald-950">Aktivitas Berhasil Divalidasi!</span>
                <p class="mt-0.5 text-emerald-800">
                    Selamat, Anda memperoleh <b>+{{ $aktivitas->poin_diperoleh }} Poin</b> reward! 
                    @if ($aktivitas->petugas)
                        Divalidasi oleh petugas: <b>{{ $aktivitas->petugas->nama_lengkap }}</b>.
                    @endif
                </p>
            </div>
        </div>
    @else
        <div class="flex items-start gap-3 rounded-2xl bg-rose-50 border border-rose-200 p-4 text-xs sm:text-sm text-rose-900 shadow-2xs">
            <span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-xl bg-rose-600 text-white font-bold">
                ✕
            </span>
            <div>
                <span class="font-bold text-rose-950">Pengajuan Ditolak Petugas:</span>
                <p class="mt-0.5 text-rose-800">
                    <b>Alasan:</b> {{ $aktivitas->alasan_penolakan ?? 'Foto bukti atau kategori tidak sesuai dengan pembuangan sebenarnya.' }}
                </p>
                <p class="mt-1 text-xs text-rose-700">Silakan perbaiki data atau foto bukti dan klik "Ajukan Ulang dengan Revisi".</p>
            </div>
        </div>
    @endif

    <!-- Detail Information Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Main Details (2 cols) -->
        <div class="md:col-span-2 space-y-6">
            <div class="rounded-3xl bg-white p-6 border border-slate-200/80 shadow-xs">
                <h3 class="text-sm font-bold uppercase tracking-wider text-slate-600 mb-4 pb-2 border-b border-slate-100">
                    Informasi Pemilahan
                </h3>

                <dl class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                    <div class="rounded-2xl bg-slate-50 p-4 border border-slate-100">
                        <dt class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Kategori Sampah</dt>
                        <dd class="mt-1 font-bold text-slate-900 text-base flex items-center gap-2">
                            <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
                            {{ $aktivitas->kategori->nama_kategori }}
                        </dd>
                    </div>

                    <div class="rounded-2xl bg-slate-50 p-4 border border-slate-100">
                        <dt class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Titik Lokasi</dt>
                        <dd class="mt-1 font-bold text-slate-900 text-base">
                            {{ $aktivitas->lokasi->nama_lokasi }}
                        </dd>
                    </div>

                    <div class="rounded-2xl bg-slate-50 p-4 border border-slate-100">
                        <dt class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Waktu Pembuangan</dt>
                        <dd class="mt-1 font-semibold text-slate-800">
                            {{ $aktivitas->tanggal_waktu->translatedFormat('l, d F Y - H:i') }} WIB
                        </dd>
                    </div>

                    <div class="rounded-2xl bg-slate-50 p-4 border border-slate-100">
                        <dt class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Estimasi Jumlah</dt>
                        <dd class="mt-1 font-semibold text-slate-800">
                            {{ $aktivitas->jumlah }} item / kg
                        </dd>
                    </div>

                    <div class="sm:col-span-2 rounded-2xl bg-slate-50 p-4 border border-slate-100">
                        <dt class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Catatan Pengaju</dt>
                        <dd class="mt-1 text-slate-700 italic">
                            "{{ $aktivitas->catatan ?: 'Tidak ada catatan tambahan.' }}"
                        </dd>
                    </div>
                </dl>
            </div>
        </div>

        <!-- Photo Proof Preview (1 col) -->
        <div class="md:col-span-1">
            <div class="rounded-3xl bg-white p-5 border border-slate-200/80 shadow-xs">
                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-600 mb-3">
                    Foto Bukti Pemilahan
                </h3>
                @if ($aktivitas->foto_bukti)
                    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-slate-950">
                        <a href="{{ asset('storage/' . $aktivitas->foto_bukti) }}" target="_blank" title="Buka ukuran penuh">
                            <img 
                                src="{{ asset('storage/' . $aktivitas->foto_bukti) }}" 
                                class="w-full h-64 object-cover hover:scale-105 transition-transform duration-300" 
                                alt="Foto bukti pemilahan"
                            >
                        </a>
                    </div>
                    <p class="mt-2 text-center text-[11px] text-slate-400">Klik foto untuk melihat ukuran penuh</p>
                @else
                    <div class="flex h-48 items-center justify-center rounded-2xl bg-slate-100 text-xs text-slate-400">
                        Foto bukti tidak tersedia
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
