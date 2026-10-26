@extends('layouts.app', ['title' => 'Kelola Jadwal Pengangkutan'])

@section('content')
<div class="space-y-6 p-6">

    {{-- Breadcrumb + Header --}}
    <div>
        <nav class="flex items-center gap-1.5 text-xs text-slate-400 mb-2">
            <span class="hover:text-emerald-600 transition">Admin</span>
            <span>/</span>
            <span class="font-semibold text-slate-700">Jadwal Pengangkutan</span>
        </nav>
        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Kelola Jadwal Pengangkutan</h1>
                <p class="mt-0.5 text-sm text-slate-500">Atur jadwal pembuangan dan pengangkutan per kategori dan area. Jadwal yang tidak berlaku dinonaktifkan, bukan dihapus.</p>
            </div>
            <button type="button" onclick="document.getElementById('formJadwalPanel').scrollIntoView({behavior: 'smooth'})"
                    class="inline-flex items-center gap-1.5 rounded-xl bg-[#1fa959] hover:bg-[#188e4a] px-4 py-2 text-sm font-semibold text-white transition shadow-sm shrink-0">
                <span>+</span>
                <span>Tambah Jadwal</span>
            </button>
        </div>
    </div>

    {{-- Filter Tabs (Aktif / Nonaktif) --}}
    @php $curStatus = request('status', 'aktif'); @endphp
    <div class="flex items-center gap-2">
        <a href="{{ route('admin.jadwal.index', ['status' => 'aktif']) }}"
           class="inline-flex items-center gap-1.5 rounded-full px-3.5 py-1 text-xs font-bold transition
                  {{ $curStatus === 'aktif' ? 'bg-[#1fa959] text-white shadow-2xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
            <span>Aktif</span>
            <span class="rounded-full px-1.5 py-0.2 text-[10px] {{ $curStatus === 'aktif' ? 'bg-white/20 text-white' : 'bg-slate-200 text-slate-600' }}">
                {{ $schedules->where('status', 'aktif')->count() }}
            </span>
        </a>
        <a href="{{ route('admin.jadwal.index', ['status' => 'nonaktif']) }}"
           class="inline-flex items-center gap-1.5 rounded-full px-3.5 py-1 text-xs font-bold transition
                  {{ $curStatus === 'nonaktif' ? 'bg-[#1fa959] text-white shadow-2xs' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
            <span>Nonaktif</span>
            <span class="rounded-full px-1.5 py-0.2 text-[10px] {{ $curStatus === 'nonaktif' ? 'bg-white/20 text-white' : 'bg-slate-200 text-slate-600' }}">
                {{ $schedules->where('status', 'nonaktif')->count() }}
            </span>
        </a>
    </div>

    {{-- Main Grid: Table Left, Form Panel Right --}}
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">

        {{-- Left Table (7 Cols) --}}
        <div class="lg:col-span-7 rounded-2xl bg-white border border-slate-200/80 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="border-b border-slate-100 bg-slate-50/60">
                        <tr class="text-[11px] font-bold uppercase tracking-wider text-slate-400">
                            <th class="px-4 py-3.5">Kategori</th>
                            <th class="px-4 py-3.5">Area</th>
                            <th class="px-4 py-3.5">Pola</th>
                            <th class="px-4 py-3.5">Angkut</th>
                            <th class="px-4 py-3.5">Status</th>
                            <th class="px-4 py-3.5 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-xs">
                        @forelse ($schedules as $j)
                            @php
                                $cName = $j->kategori?->nama_kategori ?? 'Semua';
                                $cDot = match(strtolower($cName)) {
                                    'organik' => 'bg-emerald-500',
                                    'kertas'  => 'bg-amber-500',
                                    default   => 'bg-blue-500',
                                };
                            @endphp
                            <tr class="hover:bg-slate-50/60 transition-colors">
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center gap-1.5 font-bold text-slate-800">
                                        <span class="h-2 w-2 rounded-full {{ $cDot }} inline-block"></span>
                                        {{ $cName }}
                                    </span>
                                </td>
                                <td class="px-4 py-4 text-slate-700 font-medium">
                                    {{ $j->lokasi?->nama_lokasi ?? 'Semua area' }}
                                </td>
                                <td class="px-4 py-4">
                                    <p class="font-bold text-slate-800">Siklus 3 hari</p>
                                    <p class="text-[11px] text-slate-400">{{ $j->hari ?? 'Hari ke-1' }}</p>
                                </td>
                                <td class="px-4 py-4 font-semibold text-slate-800 whitespace-nowrap">
                                    {{ $j->status === 'aktif' ? substr($j->jam_angkut, 0, 5) : '—' }}
                                </td>
                                <td class="px-4 py-4 whitespace-nowrap">
                                    @if ($j->status === 'aktif')
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
                                    <form method="POST" action="{{ route('admin.jadwal.toggle', $j) }}" class="inline">
                                        @csrf
                                        <button type="submit" class="text-xs font-semibold {{ $j->status === 'aktif' ? 'text-rose-600 hover:text-rose-700' : 'text-emerald-600 hover:text-emerald-700' }}">
                                            {{ $j->status === 'aktif' ? 'Nonaktif' : 'Aktifkan' }}
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-10 text-center text-slate-400 text-xs">
                                    Belum ada data jadwal untuk status ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Right Edit Panel (5 Cols matching 3.3) --}}
        <div id="formJadwalPanel" class="lg:col-span-5 rounded-2xl bg-white border border-slate-200/80 p-5 shadow-sm space-y-4">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <h3 class="text-sm font-bold text-slate-900">Edit Jadwal: Plastik</h3>
                <button type="button" class="text-slate-400 hover:text-slate-600 text-sm">✕</button>
            </div>

            <form method="POST" action="{{ route('admin.jadwal.store') }}" class="space-y-4 text-xs">
                @csrf

                {{-- Kategori --}}
                <div class="space-y-1">
                    <label class="font-bold text-slate-700">Kategori <span class="text-rose-500">*</span></label>
                    <select name="id_kategori" class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2 text-xs font-medium text-slate-800 focus:outline-none focus:border-emerald-500">
                        @foreach ($kategoris as $kat)
                            <option value="{{ $kat->id_kategori }}">{{ $kat->nama_kategori }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Area / Titik Pills --}}
                <div class="space-y-1.5">
                    <label class="font-bold text-slate-700">Area / Titik</label>
                    <div class="flex flex-wrap items-center gap-1.5">
                        <button type="button" class="rounded-full border border-emerald-500 bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-800">
                            Semua area
                        </button>
                        @foreach ($lokasis->take(3) as $lok)
                            <button type="button" class="rounded-full border border-slate-200 bg-white px-3 py-1 text-xs font-medium text-slate-600 hover:border-emerald-300">
                                {{ $lok->nama_lokasi }}
                            </button>
                        @endforeach
                    </div>
                    <input type="hidden" name="id_lokasi" value="{{ $lokasis->first()?->id_lokasi ?? 1 }}">
                </div>

                {{-- Pola Pengulangan --}}
                <div class="space-y-1.5">
                    <label class="font-bold text-slate-700">Pola Pengulangan</label>
                    <div class="grid grid-cols-3 gap-1 rounded-xl bg-slate-100 p-1 text-center">
                        <button type="button" class="rounded-lg bg-white py-1.5 text-xs font-bold text-slate-900 shadow-2xs">
                            Siklus 3 hari
                        </button>
                        <button type="button" class="rounded-lg py-1.5 text-xs font-medium text-slate-500 hover:text-slate-800">
                            Mingguan
                        </button>
                        <button type="button" class="rounded-lg py-1.5 text-xs font-medium text-slate-500 hover:text-slate-800">
                            Sekali
                        </button>
                    </div>
                </div>

                {{-- Hari ke & Mulai berlaku --}}
                <div class="grid grid-cols-2 gap-3">
                    <div class="space-y-1">
                        <label class="font-bold text-slate-700">Hari ke-</label>
                        <select name="hari" class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2 text-xs font-medium text-slate-800 focus:outline-none focus:border-emerald-500">
                            <option value="Hari ke-1">1</option>
                            <option value="Hari ke-2">2</option>
                            <option value="Hari ke-3" selected>3</option>
                        </select>
                    </div>
                    <div class="space-y-1">
                        <label class="font-bold text-slate-700">Mulai berlaku</label>
                        <input type="text" value="11 Okt 2026" class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2 text-xs font-medium text-slate-800">
                    </div>
                </div>

                {{-- Jam buang & Jam angkut --}}
                <div class="grid grid-cols-2 gap-3">
                    <div class="space-y-1">
                        <label class="font-bold text-slate-700">Jam buang</label>
                        <input type="text" value="07.00 – 15.00" class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2 text-xs font-medium text-slate-800">
                    </div>
                    <div class="space-y-1">
                        <label class="font-bold text-slate-700">Jam angkut</label>
                        <input type="text" name="jam_angkut" value="16:00" class="w-full rounded-xl border-2 border-[#1fa959] bg-white px-3 py-2 text-xs font-bold text-slate-900 focus:outline-none">
                    </div>
                </div>

                {{-- Berlaku sampai --}}
                <div class="space-y-1">
                    <label class="font-bold text-slate-700">Berlaku sampai</label>
                    <input type="text" value="31 Des 2026" class="w-full rounded-xl border border-slate-200 bg-white px-3 py-2 text-xs font-medium text-slate-800">
                </div>

                {{-- Kirim pengingat ke pengguna toggle --}}
                <div class="flex items-center justify-between pt-2">
                    <div>
                        <p class="font-bold text-slate-800">Kirim pengingat ke pengguna</p>
                        <p class="text-[11px] text-slate-400">Pengguna menerima notifikasi jadwal ini</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" checked class="sr-only peer">
                        <div class="w-10 h-5 bg-slate-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-[#1fa959]"></div>
                    </label>
                </div>

                {{-- Action buttons --}}
                <div class="flex items-center justify-end gap-2 pt-3 border-t border-slate-100">
                    <button type="button" class="rounded-xl border border-slate-200 bg-white px-4 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-50">
                        Batal
                    </button>
                    <button type="submit" class="rounded-xl bg-[#1fa959] hover:bg-[#188e4a] px-4 py-2 text-xs font-semibold text-white transition shadow-sm">
                        Simpan Jadwal
                    </button>
                </div>
            </form>
        </div>

    </div>

</div>
@endsection
