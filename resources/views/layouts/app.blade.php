<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'PilahKu' }} - PilahKu</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('head')
</head>
<body class="bg-brand-50 text-slate-800 antialiased">
@php
    $u = auth()->user();
    $menu = $u->isStaff()
        ? array_filter([
            ['Validasi Aktivitas', 'admin.validasi.index', 'admin/validasi*'],
            $u->isAdmin() ? ['Aturan Reward Point', 'admin.reward.index', 'admin/reward*'] : null,
            $u->isAdmin() ? ['Kategori Sampah', 'admin.kategori.index', 'admin/kategori*'] : null,
            $u->isAdmin() ? ['Jadwal Pengangkutan', 'admin.jadwal.index', 'admin/jadwal*'] : null,
            $u->isAdmin() ? ['Lokasi Tempat Sampah', 'admin.lokasi.index', 'admin/lokasi*'] : null,
        ])
        : [
            ['Beranda', 'dashboard', 'dashboard'],
            ['Panduan Pemilahan', 'panduan.index', 'panduan*'],
            ['Jadwal Pengangkutan', 'jadwal.index', 'jadwal*'],
            ['Peta Tempat Sampah', 'peta.index', 'peta*'],
            ['Aktivitas Saya', 'aktivitas.index', 'aktivitas*'],
            ['Poin Saya', 'poin.index', 'poin*'],
            ['Alur Pengelolaan', 'alur.index', 'alur*'],
        ];
@endphp
<div class="flex min-h-screen">
    <aside class="hidden w-60 shrink-0 flex-col bg-brand-900 p-4 text-white md:flex">
        <a href="{{ $u->isStaff() ? route('admin.validasi.index') : route('dashboard') }}" class="mb-6 flex items-center gap-2">
            <span class="grid size-8 place-items-center rounded-full bg-brand-600 font-bold">P</span>
            <span><span class="block text-sm font-semibold">PilahKu</span><span class="block text-xs text-white/60">Kampus Berkelanjutan</span></span>
        </a>
        <nav class="space-y-1 text-sm">
            @foreach ($menu as [$label, $route, $pattern])
                <a href="{{ route($route) }}" class="block rounded-lg px-3 py-2 {{ request()->is($pattern) ? 'bg-brand-600' : 'hover:bg-white/10' }}">{{ $label }}</a>
            @endforeach
        </nav>
        <div class="mt-auto rounded-lg bg-white/10 p-3 text-xs">
            <div class="font-medium">{{ $u->nama_lengkap }}</div>
            <div class="text-white/60">{{ ucfirst($u->peran) }}</div>
        </div>
    </aside>

    <div class="flex-1">
        <header class="flex items-center justify-between border-b bg-white px-6 py-3 text-sm">
            <span class="font-medium">{{ $title ?? '' }}</span>
            <div class="flex items-center gap-3">
                @if ($u->isCivitas())
                    <a href="{{ route('poin.index') }}" class="rounded-full bg-brand-100 px-3 py-1 font-medium text-brand-700">{{ number_format(app(\App\Services\PointEngine::class)->saldo($u), 0, ',', '.') }} poin</a>
                    <a href="{{ route('profil.show') }}" class="text-slate-600 hover:underline">Profil</a>
                @endif
                <form method="POST" action="{{ route('logout') }}">@csrf <button class="text-slate-600 hover:underline">Keluar</button></form>
            </div>
        </header>

        <main class="mx-auto max-w-6xl p-6">
            @include('partials.flash')
            @yield('content')
        </main>
    </div>
</div>
</body>
</html>
