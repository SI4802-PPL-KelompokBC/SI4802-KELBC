@extends('layouts.app', ['title' => 'Peta Tempat Sampah Kampus'])

@push('head')
    {{-- Leaflet CSS & JS --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <style>
        .custom-pin {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 38px;
            height: 38px;
            border-radius: 50% 50% 50% 0;
            background: linear-gradient(135deg, #10b981, #047857);
            transform: rotate(-45deg);
            box-shadow: 0 4px 10px rgba(0,0,0,0.25);
            border: 2px solid #ffffff;
            cursor: pointer;
            transition: all 0.2s ease-in-out;
        }
        .custom-pin:hover {
            transform: rotate(-45deg) scale(1.15);
            box-shadow: 0 6px 16px rgba(16, 185, 129, 0.45);
        }
        .custom-pin-inner {
            transform: rotate(45deg);
            color: #ffffff;
            font-size: 11px;
            font-weight: 800;
        }
    </style>
@endpush

@section('content')
<div class="space-y-6">
    <!-- Header with Breadcrumbs & Actions -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 text-xs font-semibold uppercase tracking-wider text-slate-400 mb-1">
                <a href="{{ route('dashboard') }}" class="hover:text-slate-600 transition">Beranda</a>
                <span>&bull;</span>
                <span class="text-emerald-600 font-bold">Peta Fasilitas</span>
            </div>
            <h2 class="text-2xl font-extrabold text-slate-900 tracking-tight">
                Peta Titik Pembuangan Sampah
            </h2>
            <p class="mt-1 text-xs sm:text-sm text-slate-500">
                Temukan lokasi tempat sampah terdekat di seluruh kawasan kampus Telkom University Bandung.
            </p>
        </div>

        <div class="flex items-center gap-2">
            <a 
                href="{{ route('aktivitas.create') }}" 
                class="inline-flex items-center gap-1.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 px-4 py-2.5 text-xs font-bold text-white shadow-xs transition"
            >
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                <span>Catat Aktivitas di Lokasi</span>
            </a>
        </div>
    </div>

    <!-- Filter Category Pills Toolbar -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-3 rounded-2xl bg-white p-3 sm:p-4 border border-slate-200/80 shadow-2xs">
        <div class="flex items-center gap-1.5 overflow-x-auto pb-1 md:pb-0 scrollbar-none text-xs font-medium">
            <span class="text-slate-400 font-bold uppercase text-[11px] pr-2 shrink-0">Filter:</span>
            
            <a 
                href="{{ route('peta.index') }}" 
                class="shrink-0 rounded-xl px-3.5 py-1.5 transition-all font-semibold {{ $dipilih ? 'bg-slate-100 text-slate-600 hover:bg-slate-200' : 'bg-emerald-600 text-white shadow-xs font-bold' }}"
            >
                Semua Kategori
            </a>
            
            @foreach ($kategori as $k)
                <a 
                    href="{{ route('peta.index', ['kategori' => $k->id_kategori]) }}" 
                    class="shrink-0 flex items-center gap-1.5 rounded-xl px-3.5 py-1.5 transition-all font-semibold {{ $dipilih == $k->id_kategori ? 'bg-emerald-600 text-white shadow-xs font-bold' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}"
                >
                    <span class="h-1.5 w-1.5 rounded-full {{ $dipilih == $k->id_kategori ? 'bg-white' : 'bg-emerald-500' }}"></span>
                    <span>{{ $k->nama_kategori }}</span>
                </a>
            @endforeach
        </div>

        <!-- Search Finder -->
        <div class="relative w-full md:w-64 shrink-0">
            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>
            <input 
                type="text" 
                id="search-lokasi" 
                placeholder="Cari titik lokasi..." 
                oninput="filterLokasiCards(this.value)"
                class="block w-full rounded-xl border border-slate-200 bg-slate-50 pl-9 pr-3 py-1.5 text-xs text-slate-800 placeholder-slate-400 transition focus:border-emerald-600 focus:bg-white focus:outline-none focus:ring-2 focus:ring-emerald-500/20"
            />
        </div>
    </div>

    <!-- Map & Location List Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
        <!-- Interactive Map Container (8 cols) -->
        <div class="lg:col-span-8 space-y-3">
            <div class="relative rounded-3xl overflow-hidden border border-slate-200 shadow-sm bg-slate-100">
                <!-- Recenter Map Floating Button -->
                <button 
                    type="button" 
                    id="btn-recenter"
                    onclick="resetMapBounds()"
                    title="Pusatkan Seluruh Titik Kampus"
                    class="absolute top-4 right-4 z-20 flex items-center gap-1.5 rounded-xl bg-white/95 px-3 py-2 text-xs font-bold text-slate-700 shadow-md backdrop-blur-md border border-slate-200/80 hover:bg-white hover:text-emerald-600 transition"
                >
                    <svg class="h-4 w-4 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/>
                    </svg>
                    <span>Fokus Kampus</span>
                </button>

                <!-- Map Viewport -->
                <div id="map" class="h-[32rem] w-full z-10"></div>

                <!-- Bottom Map Legend Bar -->
                <div class="bg-white/95 border-t border-slate-200 px-4 py-2.5 flex flex-wrap items-center justify-between text-xs text-slate-500 gap-2">
                    <div class="flex items-center gap-3">
                        <span class="font-bold text-slate-700 flex items-center gap-1.5">
                            <span class="inline-block h-3 w-3 rounded-full bg-emerald-600"></span>
                            Titik Drop Pembuangan
                        </span>
                        <span>&bull;</span>
                        <span>Telkom University Landmark Tower & Sekitar</span>
                    </div>
                    <span id="titik-count-badge" class="font-medium text-slate-600">Memuat titik...</span>
                </div>
            </div>
        </div>

        <!-- Location List Cards Panel (4 cols) -->
        <div class="lg:col-span-4 space-y-3">
            <div class="rounded-3xl bg-white border border-slate-200/80 shadow-xs p-5">
                <div class="flex items-center justify-between border-b border-slate-100 pb-3 mb-3">
                    <h3 class="font-bold text-sm text-slate-900 flex items-center gap-2">
                        <svg class="h-4 w-4 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                        Daftar Titik Lokasi
                    </h3>
                    <span id="visible-count" class="text-xs font-semibold text-slate-400">0 titik</span>
                </div>

                <div id="daftar" class="space-y-2.5 max-h-[28rem] overflow-y-auto pr-1">
                    <!-- Cards injected via JS -->
                    <div class="py-12 text-center text-xs text-slate-400 animate-pulse">
                        Memuat data titik tempat sampah...
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    let map, markers = [], allPoints = [];

    // Initialize Leaflet Map centered on Telkom University Bandung
    map = L.map('map', {
        zoomControl: false
    }).setView([-6.9746, 107.6305], 17);

    // Zoom controls placed at bottom right for ergonomic mobile & desktop UX
    L.control.zoom({
        position: 'bottomright'
    }).addTo(map);

    // High quality OpenStreetMap tiles
    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    // Fetch drop points
    const dataUrl = @json(route('peta.data', array_filter(['kategori' => $dipilih])));

    fetch(dataUrl)
        .then(r => r.json())
        .then(titik => {
            allPoints = titik;
            const daftar = document.getElementById('daftar');
            daftar.innerHTML = '';
            
            document.getElementById('titik-count-badge').textContent = `${titik.length} Titik Sampah Terpasang`;
            document.getElementById('visible-count').textContent = `${titik.length} titik`;

            if (titik.length === 0) {
                daftar.innerHTML = `
                    <div class="p-8 text-center text-xs text-slate-400">
                        Tidak ada titik tempat sampah untuk kategori ini.
                    </div>
                `;
                return;
            }

            titik.forEach((t, idx) => {
                // Custom Leaflet DivIcon in green theme
                const icon = L.divIcon({
                    className: 'custom-pin-wrapper',
                    html: `<div class="custom-pin"><span class="custom-pin-inner">${t.kode}</span></div>`,
                    iconSize: [38, 38],
                    iconAnchor: [19, 38],
                    popupAnchor: [0, -38]
                });

                // Modern Popup Card
                const popupContent = `
                    <div class="p-4 font-sans text-slate-800">
                        <div class="flex items-center justify-between gap-2 border-b border-slate-100 pb-2 mb-2">
                            <span class="inline-flex items-center justify-center rounded-md bg-emerald-600 px-2 py-0.5 text-[10px] font-black text-white uppercase">
                                ${t.kode}
                            </span>
                            <span class="text-[10px] text-slate-400 font-mono">${t.lat.toFixed(4)}, ${t.lng.toFixed(4)}</span>
                        </div>
                        <h4 class="font-bold text-sm text-slate-900 leading-snug">${t.nama}</h4>
                        <div class="mt-2 flex flex-wrap gap-1">
                            ${t.kategori.map(k => `<span class="inline-block rounded-md bg-slate-100 border border-slate-200 px-2 py-0.5 text-[10px] font-semibold text-slate-700">${k}</span>`).join('')}
                        </div>
                        <div class="mt-3.5 pt-2.5 border-t border-slate-100 flex items-center justify-between gap-2">
                            <a href="${t.url}" class="text-xs font-bold text-emerald-600 hover:text-emerald-700 hover:underline">
                                Lihat Detail &rarr;
                            </a>
                            <a href="{{ route('aktivitas.create') }}?lokasi=${t.id}" class="rounded-lg bg-emerald-600 hover:bg-emerald-700 px-2.5 py-1 text-[11px] font-bold text-white transition">
                                Buang di Sini
                            </a>
                        </div>
                    </div>
                `;

                const marker = L.marker([t.lat, t.lng], { icon: icon }).addTo(map);
                marker.bindPopup(popupContent);
                markers.push({ id: t.id, marker: marker, data: t });

                // Create Sidebar Card
                const card = document.createElement('div');
                card.id = `card-${t.id}`;
                card.className = 'cursor-pointer rounded-2xl border border-slate-200/80 bg-white p-3.5 transition-all duration-200 hover:border-emerald-400 hover:shadow-sm hover:-translate-y-0.5';
                card.onclick = () => focusPoint(t.lat, t.lng, marker, card);

                card.innerHTML = `
                    <div class="flex items-start justify-between gap-2">
                        <div class="min-w-0">
                            <div class="flex items-center gap-1.5 mb-1">
                                <span class="rounded-md bg-slate-900 px-1.5 py-0.5 text-[10px] font-black text-white">
                                    ${t.kode}
                                </span>
                                <span class="truncate font-bold text-xs text-slate-800">${t.nama}</span>
                            </div>
                            <div class="flex flex-wrap gap-1 mt-1.5">
                                ${t.kategori.map(k => `<span class="rounded bg-slate-100 px-1.5 py-0.5 text-[10px] font-medium text-slate-600">${k}</span>`).join('')}
                            </div>
                        </div>
                        <div class="flex h-7 w-7 shrink-0 items-center justify-center rounded-lg bg-emerald-50 text-emerald-600">
                            <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                            </svg>
                        </div>
                    </div>
                `;
                daftar.appendChild(card);
            });

            if (titik.length) {
                map.fitBounds(titik.map(t => [t.lat, t.lng]), { padding: [50, 50], maxZoom: 18 });
            }
        });

    function focusPoint(lat, lng, marker, cardElement) {
        map.flyTo([lat, lng], 18, { animate: true, duration: 0.8 });
        marker.openPopup();

        // Highlight card with thin 1px border
        document.querySelectorAll('#daftar > div').forEach(c => {
            c.classList.remove('border-emerald-600', 'bg-emerald-50/40');
        });
        if (cardElement) {
            cardElement.classList.add('border-emerald-600', 'bg-emerald-50/40');
        }
    }

    function resetMapBounds() {
        if (allPoints.length) {
            map.fitBounds(allPoints.map(t => [t.lat, t.lng]), { padding: [50, 50], maxZoom: 18 });
        }
    }

    function filterLokasiCards(keyword) {
        const term = keyword.toLowerCase().trim();
        let visible = 0;
        allPoints.forEach(t => {
            const el = document.getElementById(`card-${t.id}`);
            const matched = t.nama.toLowerCase().includes(term) || t.kode.toLowerCase().includes(term);
            if (el) {
                el.style.display = matched ? 'block' : 'none';
                if (matched) visible++;
            }
        });
        document.getElementById('visible-count').textContent = `${visible} titik`;
    }
</script>
@endsection
