@extends('layouts.app', ['title' => $aktivitas->exists ? 'Edit Pengajuan' : 'Catat Aktivitas'])
@section('content')
<h1 class="text-xl font-semibold">{{ $aktivitas->exists ? 'Edit Pengajuan ' . $aktivitas->kode : 'Catat Aktivitas Pemilahan' }}</h1>
<p class="text-sm text-slate-500">Poin diberikan setelah petugas memvalidasi bukti.</p>
@if ($kategoriHariIni)
    <div class="mt-3 rounded-lg bg-green-50 p-3 text-sm text-green-800">Jadwal hari ini: <b>Sampah {{ $kategoriHariIni->nama_kategori }}</b>.</div>
@endif

<form method="POST" enctype="multipart/form-data" class="mt-4 space-y-4 rounded-xl bg-white p-5 shadow-sm"
      action="{{ $aktivitas->exists ? route('aktivitas.update', $aktivitas) : route('aktivitas.store') }}">
    @csrf
    @if ($aktivitas->exists) @method('PUT') @endif

    <div>
        <label class="text-sm font-medium">Kategori sampah *</label>
        <div class="mt-1 flex gap-4 text-sm">
            @foreach ($kategori as $k)
                <label class="flex items-center gap-1"><input type="radio" name="id_kategori" value="{{ $k->id_kategori }}" @checked(old('id_kategori', $aktivitas->id_kategori) == $k->id_kategori) required> {{ $k->nama_kategori }}</label>
            @endforeach
        </div>
    </div>

    <div>
        <label class="text-sm font-medium">Lokasi tempat sampah *</label>
        <select name="id_lokasi" required class="mt-1 w-full rounded-lg border px-3 py-2">
            @foreach ($lokasi as $l)
                <option value="{{ $l->id_lokasi }}" @selected(old('id_lokasi', $aktivitas->id_lokasi) == $l->id_lokasi)>{{ $l->nama_lokasi }} (menerima {{ $l->kategori->pluck('nama_kategori')->implode(' & ') }})</option>
            @endforeach
        </select>
    </div>

    <div class="grid grid-cols-2 gap-3">
        <div><label class="text-sm font-medium">Tanggal & waktu *</label><input type="datetime-local" name="tanggal_waktu" value="{{ old('tanggal_waktu', optional($aktivitas->tanggal_waktu)->format('Y-m-d\TH:i')) }}" required class="mt-1 w-full rounded-lg border px-3 py-2"></div>
        <div><label class="text-sm font-medium">Jumlah (item / kg) *</label><input type="number" step="0.01" min="0.01" name="jumlah" value="{{ old('jumlah', $aktivitas->jumlah) }}" required class="mt-1 w-full rounded-lg border px-3 py-2"></div>
    </div>

    <div>
        <label class="text-sm font-medium">Foto bukti pemilahan {{ $aktivitas->exists ? '' : '*' }} (JPG/PNG, maks. 5 MB)</label>
        <input type="file" name="foto_bukti" accept="image/png,image/jpeg" class="mt-1 block text-sm">
        @if ($aktivitas->foto_bukti)<img src="{{ asset('storage/' . $aktivitas->foto_bukti) }}" class="mt-2 h-24 rounded" alt="Bukti saat ini">@endif
    </div>

    <div><label class="text-sm font-medium">Catatan (opsional)</label><textarea name="catatan" rows="2" class="mt-1 w-full rounded-lg border px-3 py-2">{{ old('catatan', $aktivitas->catatan) }}</textarea></div>

    <label class="flex items-center gap-2 text-sm"><input type="checkbox" name="pernyataan" value="1"> Saya menyatakan sampah sudah dipilah dan dibuang sesuai kategori.</label>

    <div class="flex justify-end gap-2">
        <a href="{{ route('aktivitas.index') }}" class="rounded-lg border px-4 py-2 text-sm">Batal</a>
        <button class="rounded-lg bg-brand-600 px-4 py-2 text-sm text-white">{{ $aktivitas->exists ? 'Simpan Perubahan' : 'Ajukan Aktivitas' }}</button>
    </div>
</form>
@endsection
