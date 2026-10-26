@extends('layouts.app', ['title' => 'Aturan Reward Point'])

@section('content')
<div class="space-y-6 p-6">

    {{-- Breadcrumb + Header --}}
    <div>
        <nav class="flex items-center gap-1.5 text-xs text-slate-400 mb-2">
            <span class="hover:text-emerald-600 transition">Admin</span>
            <span>/</span>
            <span class="font-semibold text-slate-700">Aturan Reward Point</span>
        </nav>
        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Aturan Reward Point</h1>
                <p class="mt-0.5 text-sm text-slate-500">Tentukan nilai dan syarat poin untuk aktivitas yang memenuhi ketentuan.</p>
            </div>
            <button type="button" onclick="document.getElementById('formRewardPanel').scrollIntoView({behavior: 'smooth'})"
                    class="inline-flex items-center gap-1.5 rounded-xl bg-[#1fa959] hover:bg-[#188e4a] px-4 py-2 text-sm font-semibold text-white transition shadow-sm shrink-0">
                <span>+</span>
                <span>Tambah Aturan</span>
            </button>
        </div>
    </div>

    {{-- Info Alert Box (Matching 6.3) --}}
    <div class="flex items-start gap-3 rounded-2xl bg-[#eaf8ef] border border-emerald-200/70 p-4">
        <div class="h-6 w-6 rounded-full bg-[#1fa959] text-white flex items-center justify-center font-bold text-xs shrink-0 mt-0.5 shadow-2xs">
            i
        </div>
        <div>
            <h4 class="text-xs font-bold text-emerald-900">Aturan hanya berlaku untuk aktivitas terverifikasi</h4>
            <p class="text-xs text-emerald-800 mt-0.5 leading-relaxed">
                Perubahan nilai poin berlaku untuk aktivitas berikutnya dan tidak mengubah transaksi yang sudah tercatat.
            </p>
        </div>
    </div>

    {{-- Main Grid: Table Left, Edit Panel Right --}}
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">

        {{-- Left Table (7 Cols) --}}
        <div class="lg:col-span-7 rounded-2xl bg-white border border-slate-200/80 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="border-b border-slate-100 bg-slate-50/60">
                        <tr class="text-[11px] font-bold uppercase tracking-wider text-slate-400">
                            <th class="px-4 py-3.5">Kode</th>
                            <th class="px-4 py-3.5">Aturan</th>
                            <th class="px-4 py-3.5">Nilai</th>
                            <th class="px-4 py-3.5">Status</th>
                            <th class="px-4 py-3.5 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-xs">
                        @forelse ($rewards as $idx => $r)
                            @php
                                $rCode = 'RWD-' . str_pad($r->id_aturan ?? ($idx + 1), 2, '0', STR_PAD_LEFT);
                                $isPositive = ($r->jenis === 'penambahan');
                            @endphp
                            <tr class="hover:bg-slate-50/60 transition-colors">
                                <td class="px-4 py-4 font-mono font-semibold text-slate-500 whitespace-nowrap">
                                    {{ $rCode }}
                                </td>
                                <td class="px-4 py-4">
                                    <p class="font-bold text-slate-900">{{ $r->nama_aturan }}</p>
                                    <p class="text-[11px] text-slate-400 mt-0.5">
                                        Terverifikasi &bull; {{ $r->kategori?->nama_kategori ? 'kategori ' . $r->kategori->nama_kategori : 'semua kategori' }}
                                    </p>
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <span class="font-bold {{ $isPositive ? 'text-[#1fa959]' : 'text-rose-600' }}">
                                        {{ $isPositive ? '+' : '-' }}{{ $r->poin_per_satuan }} {{ $r->kategori && strtolower($r->kategori->nama_kategori) === 'organik' ? '/ kg' : '/ item' }}
                                    </span>
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap">
                                    @if ($r->status === 'aktif')
                                        <span class="inline-flex items-center gap-1 rounded-full bg-emerald-50 border border-emerald-200 px-2 py-0.5 text-[11px] font-bold text-emerald-700">
                                            <span class="h-1.5 w-1.5 rounded-full bg-emerald-500 inline-block"></span>
                                            Aktif
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 rounded-full bg-slate-100 border border-slate-200 px-2 py-0.5 text-[11px] font-bold text-slate-500">
                                            <span class="h-1.5 w-1.5 rounded-full bg-slate-400 inline-block"></span>
                                            Nonaktif
                                        </span>
                                    @endif
                                </td>
                                <td class="px-4 py-4 text-right whitespace-nowrap space-x-2">
                                    <button type="button" class="text-xs font-semibold text-slate-700 hover:text-emerald-700">
                                        Edit
                                    </button>
                                    <form method="POST" action="{{ route('admin.reward.toggle', $r) }}" class="inline">
                                        @csrf
                                        <button type="submit" class="text-xs font-semibold {{ $r->status === 'aktif' ? 'text-rose-600 hover:text-rose-700' : 'text-emerald-600 hover:text-emerald-700' }}">
                                            {{ $r->status === 'aktif' ? 'Nonaktifkan' : 'Aktifkan' }}
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-10 text-center text-slate-400 text-xs">
                                    Belum ada data aturan reward point.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Right Form Panel (5 Cols matching 6.3) --}}
        <div id="formRewardPanel" class="lg:col-span-5 rounded-2xl bg-white border border-slate-200/80 p-5 shadow-sm space-y-4">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <h3 class="text-sm font-bold text-slate-900">Edit Aturan: RWD-01</h3>
                <button type="button" class="text-slate-400 hover:text-slate-600 text-sm">✕</button>
            </div>

            <form method="POST" action="{{ route('admin.reward.store') }}" class="space-y-4 text-xs">
                @csrf

                {{-- Nama Aturan --}}
                <div class="space-y-1">
                    <label class="font-bold text-slate-700">Nama Aturan <span class="text-rose-500">*</span></label>
                    <input type="text" name="nama_aturan" value="Pemilahan Plastik" required
                           class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2 text-xs font-medium text-slate-800 focus:outline-none focus:border-emerald-500">
                </div>

                {{-- Jenis Aturan Segmented --}}
                <div class="space-y-1.5">
                    <label class="font-bold text-slate-700">Jenis Aturan</label>
                    <div class="grid grid-cols-2 gap-1 rounded-xl bg-slate-100 p-1 text-center">
                        <button type="button" class="rounded-lg bg-white py-1.5 text-xs font-bold text-slate-900 shadow-2xs">
                            Penambahan
                        </button>
                        <button type="button" class="rounded-lg py-1.5 text-xs font-medium text-slate-500 hover:text-slate-800">
                            Pengurangan
                        </button>
                    </div>
                    <input type="hidden" name="jenis" value="penambahan">
                </div>

                {{-- Kategori --}}
                <div class="space-y-1">
                    <label class="font-bold text-slate-700">Kategori <span class="text-rose-500">*</span></label>
                    <select name="id_kategori" class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2 text-xs font-medium text-slate-800 focus:outline-none focus:border-emerald-500">
                        @foreach ($kategoris as $kat)
                            <option value="{{ $kat->id_kategori }}">{{ $kat->nama_kategori }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Syarat Checkboxes --}}
                <div class="space-y-2">
                    <label class="font-bold text-slate-700 block">Syarat</label>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" checked class="h-4 w-4 rounded text-emerald-600 focus:ring-emerald-500 border-slate-300">
                        <span class="text-slate-700">Aktivitas terverifikasi petugas (wajib)</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" checked class="h-4 w-4 rounded text-emerald-600 focus:ring-emerald-500 border-slate-300">
                        <span class="text-slate-700">Sesuai jadwal kategori hari itu</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" checked class="h-4 w-4 rounded text-emerald-600 focus:ring-emerald-500 border-slate-300">
                        <span class="text-slate-700">Minimal 1 item per pengajuan</span>
                    </label>
                </div>

                {{-- Nilai Poin & Satuan --}}
                <div class="grid grid-cols-2 gap-3">
                    <div class="space-y-1">
                        <label class="font-bold text-slate-700">Nilai Poin</label>
                        <div class="relative">
                            <input type="number" name="poin_per_satuan" value="5" class="w-full rounded-xl border border-slate-200 bg-white pl-3 pr-10 py-2 text-xs font-bold text-slate-900 focus:outline-none focus:border-emerald-500">
                            <span class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 text-xs">poin</span>
                        </div>
                    </div>
                    <div class="space-y-1">
                        <label class="font-bold text-slate-700">Satuan</label>
                        <select class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2 text-xs font-medium text-slate-800 focus:outline-none focus:border-emerald-500">
                            <option selected>per item</option>
                            <option>per kg</option>
                        </select>
                    </div>
                </div>

                {{-- Batas Harian & Berlaku Mulai --}}
                <div class="grid grid-cols-2 gap-3">
                    <div class="space-y-1">
                        <label class="font-bold text-slate-700">Batas harian</label>
                        <div class="relative">
                            <input type="number" name="batas_per_hari" value="50" class="w-full rounded-xl border border-slate-200 bg-white pl-3 pr-10 py-2 text-xs font-medium text-slate-800 focus:outline-none focus:border-emerald-500">
                            <span class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 text-xs">poin</span>
                        </div>
                    </div>
                    <div class="space-y-1">
                        <label class="font-bold text-slate-700">Berlaku mulai</label>
                        <input type="text" value="01 Sep 2026" class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2 text-xs font-medium text-slate-800">
                    </div>
                </div>

                {{-- Aturan aktif toggle --}}
                <div class="flex items-center justify-between pt-2">
                    <div>
                        <p class="font-bold text-slate-800">Aturan aktif</p>
                        <p class="text-[11px] text-slate-400">Digunakan untuk perhitungan poin</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" checked class="sr-only peer">
                        <div class="w-10 h-5 bg-slate-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-[#1fa959]"></div>
                    </label>
                </div>

                {{-- Buttons --}}
                <div class="flex items-center justify-end gap-2 pt-3 border-t border-slate-100">
                    <button type="button" class="rounded-xl border border-slate-200 bg-white px-4 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-50">
                        Batal
                    </button>
                    <button type="submit" class="rounded-xl bg-[#1fa959] hover:bg-[#188e4a] px-4 py-2 text-xs font-semibold text-white transition shadow-sm">
                        Simpan Aturan
                    </button>
                </div>
            </form>
        </div>

    </div>

</div>
@endsection
