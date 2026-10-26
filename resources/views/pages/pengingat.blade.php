@extends('layouts.app', ['title' => 'Pengingat Jadwal'])

@section('content')
<div class="space-y-6 p-6">

    {{-- Breadcrumb + Header --}}
    <div>
        <nav class="flex items-center gap-1.5 text-xs text-slate-400 mb-2">
            <a href="{{ route('jadwal.index') }}" class="hover:text-emerald-600 transition">Jadwal Pengangkutan</a>
            <span>/</span>
            <span class="font-semibold text-slate-700">Pengingat</span>
        </nav>
        <div class="flex items-start justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Pengingat Jadwal</h1>
                <p class="mt-0.5 text-sm text-slate-500">Atur kapan dan lewat mana kamu menerima pengingat jadwal pembuangan dan pengangkutan sampah.</p>
            </div>
        </div>
    </div>

    @if (session('status'))
        <div class="rounded-xl bg-emerald-50 border border-emerald-200 p-4 text-sm font-semibold text-emerald-800 flex items-center justify-between">
            <span>{{ session('status') }}</span>
        </div>
    @endif

    {{-- Main Grid: Form Left, Previews Right --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Left Form Column (2 Cols) --}}
        <div class="lg:col-span-2 rounded-2xl bg-white border border-slate-200/80 p-6 shadow-sm space-y-6">

            {{-- Top Green Highlight Banner with Master Toggle --}}
            <div class="rounded-xl bg-[#eaf8ef] border border-emerald-200/60 p-4 flex items-center justify-between">
                <div>
                    <h3 class="text-sm font-bold text-slate-900">Aktifkan pengingat</h3>
                    <p class="text-xs text-slate-500 mt-0.5">Semua pengingat jadwal untuk akun kamu</p>
                </div>
                {{-- Master Switch --}}
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" checked class="sr-only peer">
                    <div class="w-11 h-6 bg-slate-300 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#1fa959]"></div>
                </label>
            </div>

            {{-- Reminder Rules List --}}
            <div class="divide-y divide-slate-100">
                {{-- 1. Pengingat Pagi --}}
                <div class="py-4 flex items-center justify-between gap-4">
                    <div class="flex-1">
                        <h4 class="text-sm font-bold text-slate-800">Pengingat pagi</h4>
                        <p class="text-xs text-slate-500 mt-0.5">Ringkasan kategori yang dijadwalkan hari ini</p>
                    </div>
                    <div class="flex items-center gap-3">
                        <select class="rounded-xl border border-slate-200 bg-white px-3 py-1.5 text-xs font-semibold text-slate-700 shadow-2xs focus:outline-none focus:border-emerald-500">
                            <option selected>06.30</option>
                            <option>06.00</option>
                            <option>07.00</option>
                        </select>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" checked class="sr-only peer">
                            <div class="w-10 h-5 bg-slate-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-[#1fa959]"></div>
                        </label>
                    </div>
                </div>

                {{-- 2. Sebelum Pengangkutan --}}
                <div class="py-4 flex items-center justify-between gap-4">
                    <div class="flex-1">
                        <h4 class="text-sm font-bold text-slate-800">Sebelum pengangkutan</h4>
                        <p class="text-xs text-slate-500 mt-0.5">Diingatkan sebelum petugas mengangkut sampah di titik favorit</p>
                    </div>
                    <div class="flex items-center gap-3">
                        <select class="rounded-xl border border-slate-200 bg-white px-3 py-1.5 text-xs font-semibold text-slate-700 shadow-2xs focus:outline-none focus:border-emerald-500">
                            <option selected>1 jam sebelum</option>
                            <option>30 menit sebelum</option>
                            <option>2 jam sebelum</option>
                        </select>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" checked class="sr-only peer">
                            <div class="w-10 h-5 bg-slate-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-[#1fa959]"></div>
                        </label>
                    </div>
                </div>

                {{-- 3. Perubahan Jadwal --}}
                <div class="py-4 flex items-center justify-between gap-4">
                    <div class="flex-1">
                        <h4 class="text-sm font-bold text-slate-800">Perubahan jadwal</h4>
                        <p class="text-xs text-slate-500 mt-0.5">Pemberitahuan jika jadwal diubah atau dinonaktifkan admin</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" checked class="sr-only peer">
                        <div class="w-10 h-5 bg-slate-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-[#1fa959]"></div>
                    </label>
                </div>

                {{-- 4. Rekap Mingguan --}}
                <div class="py-4 flex items-center justify-between gap-4">
                    <div class="flex-1">
                        <h4 class="text-sm font-bold text-slate-800">Rekap mingguan</h4>
                        <p class="text-xs text-slate-500 mt-0.5">Ringkasan jadwal setiap Minggu malam</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" class="sr-only peer">
                        <div class="w-10 h-5 bg-slate-200 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-[#1fa959]"></div>
                    </label>
                </div>
            </div>

            {{-- Channel Options --}}
            <div class="space-y-2 pt-2">
                <label class="text-xs font-bold text-slate-900 block">Kirim melalui</label>
                <div class="flex flex-wrap items-center gap-2">
                    <button type="button" class="inline-flex items-center gap-1.5 rounded-full border border-[#1fa959] bg-[#eaf8ef] px-4 py-1.5 text-xs font-semibold text-[#1fa959] shadow-2xs">
                        <span>Notifikasi browser</span>
                    </button>
                    <button type="button" class="inline-flex items-center gap-1.5 rounded-full border border-[#1fa959] bg-white px-4 py-1.5 text-xs font-semibold text-[#1fa959] shadow-2xs">
                        <span>Email kampus</span>
                    </button>
                    <button type="button" disabled class="inline-flex items-center gap-1.5 rounded-full border border-slate-200 bg-slate-50 px-4 py-1.5 text-xs font-medium text-slate-400 cursor-not-allowed">
                        <span>WhatsApp (segera hadir)</span>
                    </button>
                </div>
            </div>

            {{-- Categories --}}
            <div class="space-y-2">
                <label class="text-xs font-bold text-slate-900 block">Kategori yang diingatkan</label>
                <div class="flex flex-wrap items-center gap-2">
                    <button type="button" class="inline-flex items-center gap-1.5 rounded-full border border-emerald-500 bg-white px-3.5 py-1 text-xs font-semibold text-slate-800 shadow-2xs">
                        <span class="h-2 w-2 rounded-full bg-emerald-500 inline-block"></span>
                        <span>Organik</span>
                    </button>
                    <button type="button" class="inline-flex items-center gap-1.5 rounded-full border border-emerald-500 bg-white px-3.5 py-1 text-xs font-semibold text-slate-800 shadow-2xs">
                        <span class="h-2 w-2 rounded-full bg-blue-500 inline-block"></span>
                        <span>Plastik</span>
                    </button>
                    <button type="button" class="inline-flex items-center gap-1.5 rounded-full border border-emerald-500 bg-white px-3.5 py-1 text-xs font-semibold text-slate-800 shadow-2xs">
                        <span class="h-2 w-2 rounded-full bg-amber-500 inline-block"></span>
                        <span>Kertas</span>
                    </button>
                </div>
            </div>

            {{-- Favorite Points --}}
            <div class="space-y-2">
                <label class="text-xs font-bold text-slate-900 block">Titik favorit</label>
                <div class="flex flex-wrap items-center gap-2">
                    <span class="inline-flex items-center gap-1.5 rounded-full border border-emerald-500 bg-white px-3.5 py-1 text-xs font-semibold text-slate-800 shadow-2xs">
                        Kantin TULT – A2
                    </span>
                    <span class="inline-flex items-center gap-1.5 rounded-full border border-emerald-500 bg-white px-3.5 py-1 text-xs font-semibold text-slate-800 shadow-2xs">
                        Gedung Selaru – B1
                    </span>
                    <button type="button" class="inline-flex items-center gap-1 rounded-full border border-dashed border-slate-300 bg-slate-50 px-3 py-1 text-xs font-medium text-slate-600 hover:border-emerald-400 hover:text-emerald-700 transition">
                        + Tambah titik
                    </button>
                </div>
            </div>

            {{-- Submit Button --}}
            <div class="pt-4 flex justify-end">
                <button type="button" onclick="alert('Pengaturan pengingat berhasil disimpan!')"
                        class="rounded-xl bg-[#1fa959] hover:bg-[#188e4a] text-white px-6 py-2.5 text-sm font-semibold transition shadow-sm">
                    Simpan Pengaturan
                </button>
            </div>

        </div>

        {{-- Right Side Column (1 Col): Preview & History --}}
        <div class="space-y-5">

            {{-- Pratinjau Pengingat Card --}}
            <div class="rounded-2xl bg-white border border-slate-200/80 p-5 shadow-sm space-y-3">
                <h3 class="text-sm font-bold text-slate-900">Pratinjau Pengingat</h3>
                
                {{-- Dark Notification Card --}}
                <div class="rounded-2xl bg-[#143e2b] text-white p-4 shadow-sm flex items-start gap-3">
                    <div class="h-9 w-9 rounded-full bg-[#1fa959] flex items-center justify-center font-black text-sm text-white shrink-0 shadow-2xs">
                        P
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-[11px] text-emerald-200/90 font-medium">PilahKu &bull; 06.30</p>
                        <h4 class="text-sm font-bold text-white mt-0.5">Hari ini jadwal Plastik!</h4>
                        <p class="text-xs text-emerald-100/80 mt-1 leading-relaxed">
                            Pilah botol &amp; gelas plastikmu. Pengangkutan pukul 16.00 di Kantin TULT &ndash; A2.
                        </p>
                    </div>
                </div>
            </div>

            {{-- Notifikasi Terbaru --}}
            <div class="rounded-2xl bg-white border border-slate-200/80 p-5 shadow-sm space-y-3">
                <h3 class="text-sm font-bold text-slate-900">Notifikasi Terbaru</h3>
                <div class="divide-y divide-slate-100 text-xs">
                    <div class="py-3 flex items-start justify-between gap-2">
                        <div class="flex items-start gap-2.5">
                            <span class="h-2 w-2 rounded-full bg-blue-500 mt-1.5 shrink-0"></span>
                            <div>
                                <p class="font-semibold text-slate-800">Hari ini jadwal Plastik</p>
                                <p class="text-[11px] text-slate-400 mt-0.5">Hari ini, 06.30</p>
                            </div>
                        </div>
                        <span class="h-2 w-2 rounded-full bg-[#1fa959] mt-1.5 shrink-0"></span>
                    </div>

                    <div class="py-3 flex items-start justify-between gap-2">
                        <div class="flex items-start gap-2.5">
                            <span class="h-2 w-2 rounded-full bg-amber-500 mt-1.5 shrink-0"></span>
                            <div>
                                <p class="font-semibold text-slate-800">Pengangkutan Kertas 1 jam lagi</p>
                                <p class="text-[11px] text-slate-400 mt-0.5">Kemarin, 15.00</p>
                            </div>
                        </div>
                    </div>

                    <div class="py-3 flex items-start justify-between gap-2">
                        <div class="flex items-start gap-2.5">
                            <span class="h-2 w-2 rounded-full bg-amber-500 mt-1.5 shrink-0"></span>
                            <div>
                                <p class="font-semibold text-slate-800">Jadwal Pendopo diubah ke 12.00</p>
                                <p class="text-[11px] text-slate-400 mt-0.5">Kemarin, 09.12</p>
                            </div>
                        </div>
                    </div>

                    <div class="py-3 flex items-start justify-between gap-2">
                        <div class="flex items-start gap-2.5">
                            <span class="h-2 w-2 rounded-full bg-emerald-500 mt-1.5 shrink-0"></span>
                            <div>
                                <p class="font-semibold text-slate-800">Hari ini jadwal Organik</p>
                                <p class="text-[11px] text-slate-400 mt-0.5">09 Okt, 06.30</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Catatan Ruang Lingkup --}}
            <div class="rounded-2xl border border-dashed border-slate-300 bg-slate-50/60 p-4">
                <h4 class="text-xs font-bold text-slate-700">Catatan ruang lingkup</h4>
                <p class="text-xs text-slate-500 mt-1 leading-relaxed">
                    Pengingat untuk petugas pengangkut akan dikembangkan pada tahap berikutnya (di luar MVP).
                </p>
            </div>

        </div>

    </div>

</div>
@endsection
