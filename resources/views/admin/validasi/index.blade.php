@extends('layouts.app', ['title' => 'Validasi Aktivitas'])
@section('content')
<h1 class="text-xl font-semibold">Validasi Aktivitas Pemilahan</h1>
<p class="text-sm text-slate-500">Tinjau bukti pengajuan sebelum poin diberikan.</p>
<div class="mt-3 flex gap-2 text-sm">
    @foreach (['menunggu' => 'Menunggu Validasi', 'terverifikasi' => 'Terverifikasi', 'ditolak' => 'Ditolak'] as $v => $l)
        <a href="{{ route('admin.validasi.index', ['status' => $v]) }}" class="rounded-full border bg-white px-3 py-1 {{ $status === $v ? 'ring-2 ring-brand-600' : '' }}">{{ $l }} ({{ $jumlah[$v] ?? 0 }})</a>
    @endforeach
</div>
<div class="mt-4 overflow-x-auto rounded-xl bg-white shadow-sm">
    <table class="w-full text-left text-sm">
        <thead class="bg-slate-50 text-xs uppercase text-slate-500"><tr><th class="px-4 py-3">ID</th><th class="px-4 py-3">Pengguna</th><th class="px-4 py-3">Kategori</th><th class="px-4 py-3">Lokasi</th><th class="px-4 py-3">Waktu</th><th></th></tr></thead>
        <tbody>
        @forelse ($antrian as $a)
            <tr class="border-t">
                <td class="px-4 py-3 font-medium">{{ $a->kode }}</td>
                <td class="px-4 py-3">{{ $a->pengguna->nama_lengkap }}</td>
                <td class="px-4 py-3">{{ $a->kategori->nama_kategori }}</td>
                <td class="px-4 py-3">{{ $a->lokasi->nama_lokasi }}</td>
                <td class="px-4 py-3">{{ $a->tanggal_waktu->format('d M, H:i') }}</td>
                <td class="px-4 py-3"><a href="{{ route('admin.validasi.show', $a) }}" class="text-brand-700">Tinjau</a></td>
            </tr>
        @empty
            <tr><td colspan="6" class="px-4 py-6 text-center text-slate-500">Tidak ada pengajuan.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>
<div class="mt-4">{{ $antrian->links() }}</div>
@endsection
