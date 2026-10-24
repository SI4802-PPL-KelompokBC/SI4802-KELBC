<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'PilahKu' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-brand-50 antialiased">
<div class="grid min-h-screen md:grid-cols-2">
    <div class="hidden flex-col justify-center bg-brand-900 p-12 text-white md:flex">
        <h1 class="text-3xl font-bold leading-tight">Pilah sampahmu, kumpulkan poin, wujudkan kampus hijau.</h1>
        <p class="mt-4 text-white/70">Bergabung dengan civitas academica Telkom University yang membiasakan memilah sampah sejak dari sumbernya.</p>
    </div>
    <div class="flex items-center justify-center p-6">
        <div class="w-full max-w-md rounded-2xl bg-white p-8 shadow">
            @include('partials.flash')
            @yield('content')
        </div>
    </div>
</div>
</body>
</html>
