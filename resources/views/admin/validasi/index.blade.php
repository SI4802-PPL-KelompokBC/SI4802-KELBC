@extends('layouts.app', ['title' => 'Validasi Pengajuan'])

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 text-xs font-semibold uppercase tracking-wider text-slate-400 mb-1">
                <span>Panel Petugas & Admin</span>
                <span>&bull;</span>
                <span class="text-emerald-700 font-bold">Antrean Validasi</span>
            </div>
            <h2 class="text-2xl font-extrabold text-slate-900 tracking-tight">
                Validasi Aktivitas Pemilahan Sampah
            </h2>
            <p class="mt-1 text-xs sm:text-sm text-slate-500">
                Tinjau kesesuaian foto bukti pembuangan sebelum sistem mengkreditkan reward poin kepada civitas.
            </p>
        </div>
    </div>

    <!-- Status Tabs with Badges -->
    <div class="flex items-center gap-2 overflow-x-auto pb-1 text-xs font-bold">
        @foreach (['menunggu' => 'Menunggu Validasi', 'terverifikasi' => 'Terverifikasi', 'ditolak' => 'Ditolak'] as $v => $l)
            @php $active = $status === $v; @endphp
            <a 
                href="{{ route('admin.validasi.index', ['status' => $v]) }}" 
                class="flex items-center gap-2 rounded-xl px-4 py-2.5 transition-all {{ $active ? 'bg-slate-900 text-white shadow-xs' : 'bg-white text-slate-600 border border-slate-200 hover:bg-slate-50' }}"
            >
                <span>{{ $l }}</span>
                <span class="rounded-full px-2 py-0.5 text-[10px] font-black {{ $active ? 'bg-emerald-600 text-white' : 'bg-slate-100 text-slate-700' }}">
                    {{ $jumlah[$v] ?? 0 }}
                </span>
            </a>
        @endforeach
    </div>

    <!-- Queue Table -->
    <div class="overflow-hidden rounded-3xl bg-white border border-slate-200/80 shadow-xs">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-slate-50/75 border-b border-slate-100 text-[11px] font-bold uppercase tracking-wider text-slate-500">
                    <tr>
                        <th class="px-5 py-3.5">ID Pengajuan</th>
                        <th class="px-5 py-3.5">Civitas Pengaju</th>
                        <th class="px-5 py-3.5">Kategori</th>
                        <th class="px-5 py-3.5">Lokasi Tempat Sampah</th>
                        <th class="px-5 py-3.5">Waktu Unggah</th>
                        <th class="px-5 py-3.5 text-right">Tindakan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                @forelse ($antrian as $a)
                    <tr class="hover:bg-slate-50/60 transition-colors">
                        <td class="px-5 py-4 font-bold text-slate-900">
                            <span class="rounded-lg bg-slate-100 px-2 py-1 text-xs font-mono text-slate-800">
                                {{ $a->kode }}
                            </span>
                        </td>
                        <td class="px-5 py-4">
                            <span class="font-bold text-slate-900 text-xs block">{{ $a->pengguna->nama_lengkap }}</span>
                            <span class="text-[11px] text-slate-400">{{ $a->pengguna->nim_nip }} &bull; {{ $a->pengguna->program_studi }}</span>
                        </td>
                        <td class="px-5 py-4">
                            <span class="inline-flex items-center gap-1 rounded-md bg-blue-50 px-2 py-0.5 text-xs font-semibold text-blue-700 border border-blue-200/60">
                                {{ $a->kategori->nama_kategori }}
                            </span>
                        </td>
                        <td class="px-5 py-4 text-xs font-medium text-slate-700">
                            {{ $a->lokasi->nama_lokasi }}
                        </td>
                        <td class="px-5 py-4 text-xs text-slate-500">
                            {{ $a->tanggal_waktu->translatedFormat('d M Y, H:i') }}
                        </td>
                        <td class="px-5 py-4 text-right">
                            <a 
                                href="{{ route('admin.validasi.show', $a) }}" 
                                class="inline-flex items-center gap-1.5 rounded-xl bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 px-3.5 py-1.5 text-xs font-bold text-white shadow-2xs transition"
                            >
                                <span>Tinjau Bukti</span>
                                <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                                </svg>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-5 py-12 text-center text-slate-400 text-xs">
                            <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-slate-100 text-slate-400 mb-2">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            Tidak ada pengajuan pemilahan dalam antrean ini.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        @if ($antrian->hasPages())
            <div class="border-t border-slate-100 p-4">
                {{ $antrian->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
