@extends('layouts.app', ['title' => 'Jadwal Pengangkutan Sampah'])

@section('content')
<div class="space-y-6 p-6">

    {{-- Breadcrumb + Header --}}
    <div>
        <p class="text-xs text-slate-400 mb-1.5 font-medium">Jadwal Pengangkutan</p>
        <div class="flex items-start justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Jadwal Pengangkutan Sampah</h1>
                <p class="mt-0.5 text-sm text-slate-500">Buang sampah sesuai kategori hari ini sebelum diangkut petugas.</p>
            </div>
            <a href="{{ route('jadwal.pengingat') }}"
               class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-50 transition shadow-sm">
                Atur Pengingat
            </a>
        </div>
    </div>

    {{-- Today Hero Banner (Solid Vibrant Green matching 3.1) --}}
    @php
        $todaySchedule = $minggu[0] ?? null;
        $kategoriHariIni = $todaySchedule['kategori'] ?? null;
        $catName = $kategoriHariIni?->nama_kategori ?? 'Plastik';
        $initial = strtoupper(substr($kategoriHariIni?->kode ?? 'PLS', 0, 1));
        if ($catName === 'Plastik') $initial = 'P';
        elseif ($catName === 'Organik') $initial = 'O';
        elseif ($catName === 'Kertas') $initial = 'K';
    @endphp
    <div class="relative overflow-hidden rounded-2xl bg-[#1fa959] p-6 text-white shadow-sm">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-5">
            <div class="flex items-center gap-5">
                {{-- Category initial white circle --}}
                <div class="h-16 w-16 rounded-full bg-white flex items-center justify-center text-3xl font-black text-[#1fa959] shadow-md shrink-0">
                    {{ $initial }}
                </div>
                <div>
                    <p class="text-xs font-semibold text-emerald-100">Hari ini &bull; {{ now()->translatedFormat('l, d M Y') }}</p>
                    <h2 class="text-2xl font-black tracking-tight text-white mt-0.5">Jadwal Sampah {{ $catName }}</h2>
                    <p class="mt-1 text-xs text-emerald-100/90 font-medium">
                        Buang pukul 07.00&ndash;15.00 &bull; Pengangkutan mulai 16.00 di semua titik
                    </p>
                </div>
            </div>

            {{-- Countdown Pill Card --}}
            <div class="shrink-0 rounded-2xl bg-white/20 border border-white/25 px-5 py-3 text-right backdrop-blur-2xs">
                <p class="text-xs text-emerald-100 font-medium">Pengangkutan dalam</p>
                <p class="text-2xl font-black text-white mt-0.5">
                    @php
                        $diffH = now()->diffInHours(now()->setTime(16, 0), false);
                        $diffM = now()->diffInMinutes(now()->setTime(16, 0), false) % 60;
                    @endphp
                    @if ($diffH > 0)
                        {{ $diffH }} jam {{ abs($diffM) }} mnt
                    @elseif ($diffH == 0 && $diffM > 0)
                        {{ abs($diffM) }} menit
                    @else
                        3 jam 42 mnt
                    @endif
                </p>
            </div>
        </div>
    </div>

    {{-- Minggu Ini - 7 Day Calendar Row --}}
    <div>
        <h2 class="text-sm font-bold text-slate-800 mb-3">Minggu Ini</h2>
        <div class="grid grid-cols-2 sm:grid-cols-4 md:grid-cols-7 gap-3">
            @foreach ($minggu as $idx => $h)
                @php
                    $isToday = ($idx === 0);
                    $k = $h['kategori'];
                    $kName = $k?->nama_kategori ?? 'Plastik';
                    $pillClass = match(strtolower($kName)) {
                        'organik' => ['dot' => 'bg-emerald-500', 'badge' => 'bg-emerald-50 text-emerald-700 border-emerald-200'],
                        'kertas'  => ['dot' => 'bg-amber-500',   'badge' => 'bg-amber-50 text-amber-700 border-amber-200'],
                        default   => ['dot' => 'bg-blue-500',    'badge' => 'bg-blue-50 text-blue-700 border-blue-200'],
                    };
                @endphp
                <div class="rounded-2xl p-4 text-center transition-all bg-white shadow-2xs
                    {{ $isToday ? 'border-2 border-[#1fa959] ring-2 ring-[#1fa959]/15' : 'border border-slate-200/80' }}">
                    <p class="text-[11px] font-bold uppercase tracking-wider {{ $isToday ? 'text-[#1fa959]' : 'text-slate-400' }}">
                        {{ $isToday ? 'Min • Hari ini' : $h['tanggal']->translatedFormat('D') }}
                    </p>
                    <p class="text-lg font-black text-slate-900 mt-1">
                        {{ $h['tanggal']->translatedFormat('d M') }}
                    </p>
                    <div class="mt-2 flex justify-center">
                        <span class="inline-flex items-center gap-1 rounded-full border px-2.5 py-0.5 text-[11px] font-semibold {{ $pillClass['badge'] }}">
                            <span class="h-1.5 w-1.5 rounded-full {{ $pillClass['dot'] }} inline-block"></span>
                            {{ $kName }}
                        </span>
                    </div>
                    <p class="text-[10px] text-slate-400 mt-2">Angkut 16.00</p>
                </div>
            @endforeach
        </div>
    </div>

    {{-- Main Area Table + Right Sidebar --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Left Area Table (2 cols) --}}
        <div class="lg:col-span-2 rounded-2xl bg-white border border-slate-200/80 shadow-sm overflow-hidden">
            <div class="px-5 py-4 border-b border-slate-100">
                <h2 class="text-sm font-bold text-slate-900">Jadwal per Area &ndash; Hari Ini</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="border-b border-slate-100 bg-slate-50/60">
                        <tr class="text-[11px] font-bold uppercase tracking-wider text-slate-400">
                            <th class="px-5 py-3.5">Area</th>
                            <th class="px-5 py-3.5">Titik</th>
                            <th class="px-5 py-3.5">Kategori</th>
                            <th class="px-5 py-3.5">Jam Buang</th>
                            <th class="px-5 py-3.5">Angkut</th>
                            <th class="px-5 py-3.5">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-xs">
                        @php
                            $mockRows = [
                                ['area' => 'Kantin TULT',     'titik' => 'A1–A4', 'cat' => $catName, 'buang' => '07.00–15.00', 'angkut' => '16.00', 'status' => 'terjadwal'],
                                ['area' => 'Gedung Selaru',   'titik' => 'B1–B3', 'cat' => $catName, 'buang' => '07.00–14.30', 'angkut' => '15.30', 'status' => 'terjadwal'],
                                ['area' => 'Kantin Asrama',   'titik' => 'C1–C5', 'cat' => $catName, 'buang' => '07.00–15.30', 'angkut' => '16.30', 'status' => 'terjadwal'],
                                ['area' => 'Pendopo',         'titik' => 'D1–D2', 'cat' => $catName, 'buang' => '07.00–11.00', 'angkut' => '12.00', 'status' => 'diangkut'],
                                ['area' => 'Parkiran TULT',   'titik' => 'E1–E2', 'cat' => $catName, 'buang' => '07.00–16.00', 'angkut' => '17.00', 'status' => 'terjadwal'],
                            ];
                        @endphp
                        @foreach ($mockRows as $r)
                            @php
                                $rCat = match(strtolower($r['cat'])) {
                                    'organik' => ['dot' => 'bg-emerald-500', 'text' => 'text-emerald-700'],
                                    'kertas'  => ['dot' => 'bg-amber-500',   'text' => 'text-amber-700'],
                                    default   => ['dot' => 'bg-blue-500',    'text' => 'text-blue-700'],
                                };
                            @endphp
                            <tr class="hover:bg-slate-50/60 transition-colors">
                                <td class="px-5 py-3.5 font-bold text-slate-800">{{ $r['area'] }}</td>
                                <td class="px-5 py-3.5 text-slate-500 font-mono">{{ $r['titik'] }}</td>
                                <td class="px-5 py-3.5">
                                    <span class="inline-flex items-center gap-1.5 font-semibold text-slate-700">
                                        <span class="h-2 w-2 rounded-full {{ $rCat['dot'] }} inline-block"></span>
                                        {{ $r['cat'] }}
                                    </span>
                                </td>
                                <td class="px-5 py-3.5 text-slate-600">{{ $r['buang'] }}</td>
                                <td class="px-5 py-3.5 font-semibold text-slate-800">{{ $r['angkut'] }}</td>
                                <td class="px-5 py-3.5">
                                    @if ($r['status'] === 'diangkut')
                                        <span class="inline-flex items-center gap-1 rounded-full bg-emerald-50 border border-emerald-200 px-2.5 py-0.5 text-[11px] font-bold text-emerald-700">
                                            <span class="h-1.5 w-1.5 rounded-full bg-emerald-500 inline-block"></span>
                                            Sudah diangkut
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 rounded-full bg-amber-50 border border-amber-200 px-2.5 py-0.5 text-[11px] font-bold text-amber-700">
                                            <span class="h-1.5 w-1.5 rounded-full bg-amber-500 inline-block"></span>
                                            Terjadwal
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Right Side Column (1 col): Pengingat Kamu + Siklus 3 Hari --}}
        <div class="space-y-5">

            {{-- Pengingat Kamu Card --}}
            <div class="rounded-2xl bg-white border border-slate-200/80 p-5 shadow-sm space-y-4">
                <h3 class="text-sm font-bold text-slate-900">Pengingat Kamu</h3>
                
                {{-- Item 1: Pengingat Pagi --}}
                <div class="flex items-center justify-between gap-3">
                    <div>
                        <h4 class="text-xs font-bold text-slate-800">Pengingat pagi</h4>
                        <p class="text-[11px] text-slate-400 mt-0.5">Setiap hari pukul 06.30</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" checked class="sr-only peer">
                        <div class="w-10 h-5 bg-slate-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-[#1fa959]"></div>
                    </label>
                </div>

                {{-- Item 2: Sebelum Pengangkutan --}}
                <div class="flex items-center justify-between gap-3">
                    <div>
                        <h4 class="text-xs font-bold text-slate-800">Sebelum pengangkutan</h4>
                        <p class="text-[11px] text-slate-400 mt-0.5">1 jam sebelum petugas datang</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" checked class="sr-only peer">
                        <div class="w-10 h-5 bg-slate-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-[#1fa959]"></div>
                    </label>
                </div>

                <div class="pt-2 border-t border-slate-100">
                    <a href="{{ route('jadwal.pengingat') }}" class="text-xs font-semibold text-[#1fa959] hover:text-[#188e4a] inline-flex items-center gap-1">
                        <span>Atur pengingat</span>
                        <span>&rarr;</span>
                    </a>
                </div>
            </div>

            {{-- Siklus 3 Hari Card --}}
            <div class="rounded-2xl bg-white border border-slate-200/80 p-5 shadow-sm space-y-3">
                <h3 class="text-sm font-bold text-slate-900">Siklus 3 Hari</h3>
                
                <div class="flex items-center justify-between gap-1 text-xs">
                    <span class="inline-flex items-center gap-1 rounded-full border border-slate-200 px-2 py-0.5 font-semibold text-slate-700 bg-slate-50">
                        <span class="h-2 w-2 rounded-full bg-emerald-500 inline-block"></span>
                        Organik
                    </span>
                    <span class="text-slate-300">&rarr;</span>
                    <span class="inline-flex items-center gap-1 rounded-full border border-slate-200 px-2 py-0.5 font-semibold text-slate-700 bg-slate-50">
                        <span class="h-2 w-2 rounded-full bg-amber-500 inline-block"></span>
                        Kertas
                    </span>
                    <span class="text-slate-300">&rarr;</span>
                    <span class="inline-flex items-center gap-1 rounded-full border border-slate-200 px-2 py-0.5 font-semibold text-slate-700 bg-slate-50">
                        <span class="h-2 w-2 rounded-full bg-blue-500 inline-block"></span>
                        Plastik
                    </span>
                </div>

                <p class="text-xs text-slate-500 leading-relaxed">
                    Siklus berulang setiap 3 hari. Perubahan jadwal akan diumumkan lewat notifikasi.
                </p>
            </div>

        </div>

    </div>

</div>
@endsection
