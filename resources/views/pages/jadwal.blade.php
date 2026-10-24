@extends('layouts.app', ['title' => 'Jadwal Pengangkutan'])
@section('content')
<h1 class="text-xl font-semibold">Jadwal Pengangkutan Sampah</h1>
<div class="mt-4 rounded-2xl bg-brand-600 p-5 text-white">
    <div class="text-sm text-white/80">Hari ini</div>
    <div class="text-xl font-bold">Jadwal Sampah {{ $hariIni?->nama_kategori ?? '-' }}</div>
</div>

<h2 class="mt-6 font-semibold">Minggu ini</h2>
<div class="mt-2 grid grid-cols-7 gap-2 text-center text-xs">
    @foreach ($minggu as $h)
        <div class="rounded-lg bg-white p-2 shadow-sm {{ $loop->first ? 'ring-2 ring-brand-600' : '' }}">
            <div class="text-slate-500">{{ $h['tanggal']->translatedFormat('D d M') }}</div>
            <div class="font-medium">{{ $h['kategori']?->nama_kategori }}</div>
        </div>
    @endforeach
</div>

<h2 class="mt-6 font-semibold">Jadwal per titik (hari ini)</h2>
<div class="mt-2 overflow-x-auto rounded-xl bg-white shadow-sm">
    <table class="w-full text-left text-sm">
        <thead class="bg-slate-50 text-xs uppercase text-slate-500"><tr><th class="px-4 py-3">Titik</th><th class="px-4 py-3">Kategori</th><th class="px-4 py-3">Angkut</th><th class="px-4 py-3">Pengingat</th></tr></thead>
        <tbody>
        @foreach ($jadwal as $j)
            <tr class="border-t">
                <td class="px-4 py-3">{{ $j->lokasi->nama_lokasi }}</td>
                <td class="px-4 py-3">{{ $j->kategori->nama_kategori }}</td>
                <td class="px-4 py-3">{{ substr($j->jam_angkut, 0, 5) }}</td>
                <td class="px-4 py-3">
                    <form method="POST" action="{{ route('jadwal.pengingat') }}" class="flex items-center gap-2">
                        @csrf
                        <input type="hidden" name="id_jadwal" value="{{ $j->id_jadwal }}">
                        <input type="time" name="waktu_pengingat" value="{{ optional($pengingat->firstWhere('id_jadwal', $j->id_jadwal))->waktu_pengingat ? substr($pengingat->firstWhere('id_jadwal', $j->id_jadwal)->waktu_pengingat, 0, 5) : '06:30' }}" class="rounded border px-2 py-1">
                        <button class="text-brand-700">Simpan</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
