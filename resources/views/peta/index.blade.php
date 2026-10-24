@extends('layouts.app', ['title' => 'Peta Tempat Sampah'])
@push('head')
    {{-- TR-07: Leaflet + OpenStreetMap (tanpa API key) --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
@endpush
@section('content')
<h1 class="text-xl font-semibold">Peta Tempat Sampah</h1>
<div class="mt-3 flex flex-wrap gap-2 text-sm">
    <a href="{{ route('peta.index') }}" class="rounded-full border bg-white px-3 py-1 {{ $dipilih ? '' : 'ring-2 ring-brand-600' }}">Semua</a>
    @foreach ($kategori as $k)
        <a href="{{ route('peta.index', ['kategori' => $k->id_kategori]) }}" class="rounded-full border bg-white px-3 py-1 {{ $dipilih == $k->id_kategori ? 'ring-2 ring-brand-600' : '' }}">{{ $k->nama_kategori }}</a>
    @endforeach
</div>
<div id="map" class="mt-4 h-[28rem] rounded-xl"></div>
<div id="daftar" class="mt-4 space-y-2"></div>

<script>
    const map = L.map('map').setView([-6.9746, 107.6305], 17);
    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', { maxZoom: 19, attribution: '&copy; OpenStreetMap' }).addTo(map);

    fetch(@json(route('peta.data', array_filter(['kategori' => $dipilih]))))
        .then(r => r.json())
        .then(titik => {
            const daftar = document.getElementById('daftar');
            titik.forEach(t => {
                L.marker([t.lat, t.lng]).addTo(map).bindPopup(`<b>${t.nama}</b><br>${t.kategori.join(', ')}<br><a href="${t.url}">Detail</a>`);
                const a = document.createElement('a');
                a.href = t.url;
                a.className = 'block rounded-xl bg-white p-3 text-sm shadow-sm';
                a.textContent = `${t.kode} - ${t.nama} (${t.kategori.join(', ')})`;
                daftar.appendChild(a);
            });
            if (titik.length) map.fitBounds(titik.map(t => [t.lat, t.lng]), { padding: [40, 40], maxZoom: 18 });
        });
</script>
@endsection
