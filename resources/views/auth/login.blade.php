@extends('layouts.guest', ['title' => 'Masuk - PilahKu'])
@section('content')
<h2 class="text-xl font-semibold">Masuk ke PilahKu</h2>
<form method="POST" action="{{ route('login') }}" class="mt-6 space-y-4">
    @csrf
    <div>
        <label class="text-sm font-medium">Email kampus</label>
        <input type="email" name="email_kampus" value="{{ old('email_kampus') }}" required autofocus class="mt-1 w-full rounded-lg border px-3 py-2">
    </div>
    <div>
        <label class="text-sm font-medium">Kata sandi</label>
        <input type="password" name="password" required class="mt-1 w-full rounded-lg border px-3 py-2">
    </div>
    <label class="flex items-center gap-2 text-sm"><input type="checkbox" name="remember"> Ingat saya</label>
    <button class="w-full rounded-lg bg-brand-600 py-2 font-medium text-white hover:bg-brand-700">Masuk</button>
</form>
<p class="mt-4 text-center text-sm">Belum punya akun? <a href="{{ route('register') }}" class="font-medium text-brand-700">Daftar</a></p>
@endsection
