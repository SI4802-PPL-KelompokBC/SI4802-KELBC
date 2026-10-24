@extends('layouts.app', ['title' => 'Profil Saya'])
@section('content')
<div class="flex items-center justify-between">
    <h1 class="text-xl font-semibold">Profil Saya</h1>
    <a href="{{ route('profil.edit') }}" class="rounded-lg bg-brand-600 px-4 py-2 text-sm text-white">Edit Profil</a>
</div>
<div class="mt-4 grid gap-4 md:grid-cols-3">
    <div class="rounded-xl bg-white p-5 shadow-sm">
        <div class="mx-auto grid size-20 place-items-center overflow-hidden rounded-full bg-brand-600 text-2xl font-bold text-white">
            @if ($user->foto_profil)<img src="{{ asset('storage/' . $user->foto_profil) }}" class="size-full object-cover" alt="">@else {{ strtoupper(substr($user->nama_lengkap, 0, 2)) }} @endif
        </div>
        <div class="mt-3 text-center font-semibold">{{ $user->nama_lengkap }}</div>
        <div class="text-center text-sm text-slate-500">{{ ucfirst($user->peran) }} {{ $user->program_studi ? '- ' . $user->program_studi : '' }}</div>
        <dl class="mt-4 space-y-2 text-sm">
            <div><dt class="text-xs text-slate-500">NIM/NIP</dt><dd>{{ $user->nim_nip }}</dd></div>
            <div><dt class="text-xs text-slate-500">Email kampus</dt><dd>{{ $user->email_kampus }}</dd></div>
            <div><dt class="text-xs text-slate-500">No. HP</dt><dd>{{ $user->no_hp ?? '-' }}</dd></div>
            <div><dt class="text-xs text-slate-500">Bergabung sejak</dt><dd>{{ $user->tanggal_bergabung?->translatedFormat('d M Y') }}</dd></div>
        </dl>
    </div>
    <div class="space-y-4 md:col-span-2">
        <div class="grid grid-cols-3 gap-4">
            @foreach ([['Total Aktivitas', $total], ['Terverifikasi', $terverifikasi], ['Saldo Poin', number_format($saldo, 0, ',', '.')]] as [$l, $v])
                <div class="rounded-xl bg-white p-4 shadow-sm"><div class="text-xs text-slate-500">{{ $l }}</div><div class="text-2xl font-bold">{{ $v }}</div></div>
            @endforeach
        </div>
        <div class="rounded-xl bg-white p-4 shadow-sm">
            <h2 class="mb-2 font-semibold">Aktivitas Terbaru</h2>
            @forelse ($terbaru as $a)
                <div class="flex justify-between border-t py-2 text-sm"><span>{{ $a->kode }} - {{ $a->kategori->nama_kategori }}</span>@include('partials.badge', ['status' => $a->status_verifikasi])</div>
            @empty <p class="text-sm text-slate-500">Belum ada aktivitas.</p> @endforelse
        </div>
    </div>
</div>
@endsection
