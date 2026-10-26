@extends('layouts.app', ['title' => 'Panduan Sampah ' . $kategori->nama_kategori])

@section('content')
<div class="space-y-6 p-6">

    {{-- Breadcrumb --}}
    <nav class="flex items-center gap-1.5 text-xs text-slate-400">
        <a href="{{ route('panduan.index') }}" class="hover:text-emerald-600 transition">Panduan Pemilahan</a>
        <span>/</span>
        <span class="text-slate-400">Kategori</span>
        <span>/</span>
        <span class="font-semibold text-slate-700">{{ $kategori->nama_kategori }}</span>
    </nav>

    @php
        $kName = strtolower($kategori->nama_kategori);
        $theme = match($kName) {
            'organik' => ['initial' => 'O', 'bg' => 'bg-emerald-500', 'border' => 'border-emerald-200', 'text' => 'text-emerald-700', 'badge' => 'bg-emerald-50 text-emerald-700 border-emerald-200'],
            'kertas'  => ['initial' => 'K', 'bg' => 'bg-amber-500',   'border' => 'border-amber-200',   'text' => 'text-amber-700',   'badge' => 'bg-amber-50 text-amber-700 border-amber-200'],
            default   => ['initial' => 'P', 'bg' => 'bg-blue-600',    'border' => 'border-blue-200',    'text' => 'text-blue-700',    'badge' => 'bg-blue-50 text-blue-700 border-blue-200'],
        };
    @endphp

    {{-- Top Hero Card (Matching Group 11 screen 2) --}}
    <div class="rounded-2xl bg-white border border-slate-200/80 p-6 shadow-sm">
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6">
            <div class="flex items-start gap-4">
                {{-- Initial Circle --}}
                <div class="h-16 w-16 rounded-full {{ $theme['bg'] }} text-white flex items-center justify-center text-3xl font-black shrink-0 shadow-sm">
                    {{ $theme['initial'] }}
                </div>
                <div>
                    <div class="flex items-center gap-2">
                        <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Sampah {{ $kategori->nama_kategori }}</h1>
                        <span class="rounded-md bg-slate-100 border border-slate-200 px-2 py-0.5 text-xs font-semibold text-slate-600">
                            Kode {{ $kategori->kode }}
                        </span>
                    </div>
                    <p class="mt-1 text-xs sm:text-sm text-slate-600 max-w-2xl leading-relaxed">
                        {{ $kategori->deskripsi ?? 'Kemasan dan barang berbahan plastik yang dapat didaur ulang setelah dibersihkan dari sisa makanan atau minuman.' }}
                    </p>
                    
                    {{-- Sub info pills --}}
                    <div class="mt-3 flex flex-wrap items-center gap-2 text-xs">
                        <span class="inline-flex items-center gap-1 rounded-full bg-slate-50 border border-slate-200 px-3 py-1 text-slate-600 font-medium">
                            Jadwal: Rab 14 &amp; Sab 17 Okt
                        </span>
                        <span class="inline-flex items-center gap-1 rounded-full bg-slate-50 border border-slate-200 px-3 py-1 text-slate-600 font-medium">
                            Diterima di 14 titik
                        </span>
                        <span class="inline-flex items-center gap-1 rounded-full bg-slate-50 border border-slate-200 px-3 py-1 text-slate-600 font-medium">
                            Diolah di Bank Sampah kampus
                        </span>
                    </div>
                </div>
            </div>

            {{-- Action buttons --}}
            <div class="flex flex-row lg:flex-col gap-2 shrink-0">
                <a href="{{ route('aktivitas.create') }}"
                   class="rounded-xl bg-[#1fa959] hover:bg-[#188e4a] text-white px-4 py-2 text-xs font-semibold text-center transition shadow-sm">
                    Catat Aktivitas
                </a>
                <a href="{{ route('peta.index') }}"
                   class="rounded-xl border border-slate-200 bg-white hover:bg-slate-50 text-slate-700 px-4 py-2 text-xs font-semibold text-center transition shadow-2xs">
                    Cari di Peta
                </a>
            </div>
        </div>
    </div>

    {{-- Main 2 Column Grid --}}
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">

        {{-- Left Column (7 Cols): Contoh Sampah & Cara Penanganan --}}
        <div class="lg:col-span-7 space-y-6">

            {{-- Contoh Sampah Grid (4x2 cards) --}}
            <div class="rounded-2xl bg-white border border-slate-200/80 p-5 shadow-sm space-y-4">
                <h3 class="text-sm font-bold text-slate-900">Contoh Sampah {{ $kategori->nama_kategori }}</h3>
                
                @php
                    $samples = match($kName) {
                        'organik' => [
                            ['title' => 'Kulit buah & sayur', 'sub' => 'Potong ukuran sedang'],
                            ['title' => 'Sisa nasi & lauk',   'sub' => 'Pisahkan dari plastik'],
                            ['title' => 'Ampas kopi & teh',   'sub' => 'Boleh langsung dibuang'],
                            ['title' => 'Daun & ranting',     'sub' => 'Masukkan ke wadah'],
                            ['title' => 'Cangkang telur',     'sub' => 'Remas agar hancur'],
                            ['title' => 'Sisa roti & kue',    'sub' => 'Tanpa kemasan'],
                            ['title' => 'Biji buah',          'sub' => 'Mudah terurai'],
                            ['title' => 'Tulang kecil',       'sub' => 'Bisa dikomposkan'],
                        ],
                        'kertas' => [
                            ['title' => 'Kertas HVS bekas',   'sub' => 'Lepas klip & staples'],
                            ['title' => 'Kardus & karton',    'sub' => 'Lipat & pipihkan'],
                            ['title' => 'Koran & majalah',    'sub' => 'Ikat rapi'],
                            ['title' => 'Buku tulis bekas',   'sub' => 'Lepas sampul plastik'],
                            ['title' => 'Paper bag bersih',   'sub' => 'Pastikan kering'],
                            ['title' => 'Brosur & pamflet',   'sub' => 'Kering & bersih'],
                            ['title' => 'Karton telur',       'sub' => 'Kondisi bersih'],
                            ['title' => 'Amplop surat',       'sub' => 'Keluarkan isi'],
                        ],
                        default => [
                            ['title' => 'Botol air mineral',  'sub' => 'Lepas label & tutup'],
                            ['title' => 'Gelas plastik',      'sub' => 'Kosongkan sisa es'],
                            ['title' => 'Sedotan & sendok',   'sub' => 'Termasuk plastik'],
                            ['title' => 'Kantong kresek',     'sub' => 'Lipat & satukan'],
                            ['title' => 'Bungkus snack',      'sub' => 'Bersihkan remahan'],
                            ['title' => 'Tutup botol',        'sub' => 'Boleh digabung'],
                            ['title' => 'Wadah makanan',      'sub' => 'Bilas dahulu'],
                            ['title' => 'Jerigen kecil',      'sub' => 'Kosong & kering'],
                        ],
                    };
                @endphp

                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                    @foreach ($samples as $s)
                        <div class="rounded-xl border border-slate-100 bg-slate-50/50 p-3 text-center space-y-2">
                            <div class="h-12 w-12 rounded-full bg-emerald-100/60 mx-auto flex items-center justify-center">
                                <span class="h-4 w-4 rounded-full bg-[#1fa959]/50 inline-block"></span>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-slate-800 leading-snug">{{ $s['title'] }}</p>
                                <p class="text-[10px] text-slate-400 mt-0.5 leading-tight">{{ $s['sub'] }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Cara Penanganan 4 Steps --}}
            <div class="rounded-2xl bg-white border border-slate-200/80 p-5 shadow-sm space-y-4">
                <h3 class="text-sm font-bold text-slate-900">Cara Penanganan</h3>
                
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                    <div class="space-y-1">
                        <div class="h-6 w-6 rounded-full {{ $theme['bg'] }} text-white flex items-center justify-center text-xs font-bold">1</div>
                        <h4 class="text-xs font-bold text-slate-800">Kosongkan</h4>
                        <p class="text-[11px] text-slate-500 leading-relaxed">Buang sisa makanan atau minuman.</p>
                    </div>

                    <div class="space-y-1">
                        <div class="h-6 w-6 rounded-full {{ $theme['bg'] }} text-white flex items-center justify-center text-xs font-bold">2</div>
                        <h4 class="text-xs font-bold text-slate-800">Bilas singkat</h4>
                        <p class="text-[11px] text-slate-500 leading-relaxed">Hilangkan sisa minyak/gula.</p>
                    </div>

                    <div class="space-y-1">
                        <div class="h-6 w-6 rounded-full {{ $theme['bg'] }} text-white flex items-center justify-center text-xs font-bold">3</div>
                        <h4 class="text-xs font-bold text-slate-800">Pipihkan</h4>
                        <p class="text-[11px] text-slate-500 leading-relaxed">Hemat ruang di tong sampah.</p>
                    </div>

                    <div class="space-y-1">
                        <div class="h-6 w-6 rounded-full {{ $theme['bg'] }} text-white flex items-center justify-center text-xs font-bold">4</div>
                        <h4 class="text-xs font-bold text-slate-800">Buang sesuai jadwal</h4>
                        <p class="text-[11px] text-slate-500 leading-relaxed">Tong {{ $kName === 'plastik' ? 'biru' : ($kName === 'organik' ? 'hijau' : 'kuning') }}, hari {{ $kategori->nama_kategori }}.</p>
                    </div>
                </div>
            </div>

        </div>

        {{-- Right Column (5 Cols): Karakteristik, Diterima/Tidak, Setelah Dibuang --}}
        <div class="lg:col-span-5 space-y-5">

            {{-- Karakteristik Card --}}
            <div class="rounded-2xl bg-white border border-slate-200/80 p-5 shadow-sm space-y-3">
                <h3 class="text-sm font-bold text-slate-900">Karakteristik</h3>
                <ul class="space-y-2 text-xs text-slate-600">
                    <li class="flex items-start gap-2">
                        <span class="h-1.5 w-1.5 rounded-full bg-blue-500 mt-1.5 shrink-0"></span>
                        <span>Ringan, tidak mudah terurai</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="h-1.5 w-1.5 rounded-full bg-blue-500 mt-1.5 shrink-0"></span>
                        <span>Bertanda kode daur ulang (1&ndash;7)</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="h-1.5 w-1.5 rounded-full bg-blue-500 mt-1.5 shrink-0"></span>
                        <span>Dapat dipadatkan atau dipipihkan</span>
                    </li>
                </ul>
            </div>

            {{-- Diterima / Tidak Diterima Card --}}
            <div class="rounded-2xl bg-white border border-slate-200/80 p-5 shadow-sm space-y-3">
                <h3 class="text-sm font-bold text-slate-900">Diterima / Tidak Diterima</h3>
                <div class="space-y-2 text-xs">
                    <div class="flex items-start gap-2 text-emerald-700 font-medium">
                        <svg class="h-4 w-4 text-emerald-600 mt-0.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                        <span>Botol &amp; gelas plastik bersih</span>
                    </div>
                    <div class="flex items-start gap-2 text-emerald-700 font-medium">
                        <svg class="h-4 w-4 text-emerald-600 mt-0.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                        <span>Kemasan sachet kering</span>
                    </div>
                    <div class="flex items-start gap-2 text-rose-600 font-medium">
                        <svg class="h-4 w-4 text-rose-500 mt-0.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                        <span>Styrofoam bekas makanan</span>
                    </div>
                    <div class="flex items-start gap-2 text-rose-600 font-medium">
                        <svg class="h-4 w-4 text-rose-500 mt-0.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                        <span>Plastik berisi sisa makanan</span>
                    </div>
                </div>
            </div>

            {{-- Setelah Dibuang Card --}}
            <div class="rounded-2xl bg-white border border-slate-200/80 p-5 shadow-sm space-y-3">
                <h3 class="text-sm font-bold text-slate-900">Setelah Dibuang</h3>
                <ul class="space-y-2 text-xs text-slate-600">
                    <li class="flex items-start gap-2">
                        <span class="h-2 w-2 rounded-full bg-emerald-500 mt-1 shrink-0"></span>
                        <span>Dikumpulkan di titik tempat sampah</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="h-2 w-2 rounded-full bg-emerald-500 mt-1 shrink-0"></span>
                        <span>Diangkut petugas pukul 16.00</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="h-2 w-2 rounded-full bg-emerald-500 mt-1 shrink-0"></span>
                        <span>Dipilah ulang di TPS kampus</span>
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="h-2 w-2 rounded-full bg-emerald-500 mt-1 shrink-0"></span>
                        <span>Didaur ulang melalui Bank Sampah</span>
                    </li>
                </ul>
            </div>

        </div>

    </div>

</div>
@endsection
