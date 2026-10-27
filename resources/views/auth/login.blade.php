@extends('layouts.guest', ['title' => 'Masuk - PilahKu Telkom University'])

@section('content')
<div>
    <!-- Header -->
    <div class="mb-8">
        <div class="hidden lg:flex items-center gap-2 mb-3">
            <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-700 border border-emerald-200">
                <span class="h-1.5 w-1.5 rounded-full bg-emerald-600"></span>
                Portal Civitas Academica
            </span>
        </div>
        <h2 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-slate-900">
            Selamat Datang Kembali
        </h2>
        <p class="mt-2 text-sm text-slate-500">
            Masuk dengan akun email resmi Telkom University untuk mulai memilah dan mengumpulkan poin.
        </p>
    </div>

    <!-- Login Form -->
    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <!-- Email Kampus -->
        <div>
            <label for="email_kampus" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                Email Kampus
            </label>
            <div class="relative rounded-xl shadow-xs">
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                    </svg>
                </div>
                <input 
                    type="email" 
                    id="email_kampus"
                    name="email_kampus" 
                    value="{{ old('email_kampus') }}" 
                    required 
                    autofocus 
                    placeholder="nama@student.telkomuniversity.ac.id" 
                    class="block w-full rounded-xl border border-slate-200 bg-slate-50/50 pl-11 pr-4 py-3 text-sm text-slate-800 placeholder-slate-400 transition focus:border-emerald-600 focus:bg-white focus:outline-none focus:ring-4 focus:ring-emerald-500/10 @error('email_kampus') border-red-500 bg-red-50/30 @enderror"
                >
            </div>
            @error('email_kampus')
                <p class="mt-1.5 text-xs font-medium text-red-600 flex items-center gap-1">
                    <svg class="h-3.5 w-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" /></svg>
                    {{ $message }}
                </p>
            @enderror
        </div>

        <!-- Password -->
        <div>
            <div class="flex items-center justify-between mb-1.5">
                <label for="password" class="block text-xs font-bold uppercase tracking-wider text-slate-700">
                    Kata Sandi
                </label>
            </div>
            <div class="relative rounded-xl shadow-xs">
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </div>
                <input 
                    type="password" 
                    id="password"
                    name="password" 
                    required 
                    placeholder="Masukkan kata sandi" 
                    class="block w-full rounded-xl border border-slate-200 bg-slate-50/50 pl-11 pr-11 py-3 text-sm text-slate-800 placeholder-slate-400 transition focus:border-emerald-600 focus:bg-white focus:outline-none focus:ring-4 focus:ring-emerald-500/10 @error('password') border-red-500 bg-red-50/30 @enderror"
                >
                <button 
                    type="button" 
                    onclick="togglePassword()" 
                    class="absolute inset-y-0 right-0 flex items-center pr-3.5 text-slate-400 hover:text-slate-600 focus:outline-none"
                    tabindex="-1"
                >
                    <svg id="eye-icon" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                </button>
            </div>
            @error('password')
                <p class="mt-1.5 text-xs font-medium text-red-600 flex items-center gap-1">
                    <svg class="h-3.5 w-3.5 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" /></svg>
                    {{ $message }}
                </p>
            @enderror
        </div>

        <!-- Remember Me Checkbox -->
        <div class="flex items-center justify-between">
            <label class="flex items-center gap-2.5 cursor-pointer text-sm text-slate-600 hover:text-slate-800">
                <input 
                    type="checkbox" 
                    name="remember" 
                    class="h-4 w-4 rounded-md border-slate-300 text-emerald-600 focus:ring-emerald-500"
                >
                <span>Ingat saya di perangkat ini</span>
            </label>
        </div>

        <!-- Submit Button (Green Gradient) -->
        <button 
            type="submit" 
            class="group relative flex w-full justify-center items-center gap-2 rounded-xl bg-gradient-to-r from-emerald-600 via-teal-600 to-green-700 py-3.5 px-4 text-sm font-semibold text-white shadow-lg shadow-emerald-600/25 transition-all duration-200 hover:from-emerald-700 hover:via-teal-700 hover:to-green-800 hover:shadow-xl hover:shadow-emerald-600/30 active:scale-[0.99] focus:outline-none focus:ring-4 focus:ring-emerald-500/30"
        >
            <span>Masuk ke Akun</span>
            <svg class="h-4 w-4 transition-transform duration-200 group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
            </svg>
        </button>
    </form>

    <!-- Quick Demo Accounts Switcher -->
    <div class="mt-8 pt-6 border-t border-slate-100">
        <div class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2.5 flex items-center gap-1.5">
            <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
            Akun Demo Pengujian:
        </div>
        <div class="grid grid-cols-3 gap-2">
            <button 
                type="button" 
                onclick="fillAccount('nadiaputri@student.telkomuniversity.ac.id', 'password123')"
                class="rounded-lg bg-slate-50 hover:bg-emerald-50 hover:text-emerald-700 hover:border-emerald-200 border border-slate-200 p-2 text-left transition"
            >
                <div class="text-[11px] font-bold text-slate-700">Mahasiswa</div>
                <div class="text-[10px] text-slate-400 truncate">Nadia Putri</div>
            </button>
            <button 
                type="button" 
                onclick="fillAccount('petugas@telkomuniversity.ac.id', 'password123')"
                class="rounded-lg bg-slate-50 hover:bg-emerald-50 hover:text-emerald-700 hover:border-emerald-200 border border-slate-200 p-2 text-left transition"
            >
                <div class="text-[11px] font-bold text-slate-700">Petugas</div>
                <div class="text-[10px] text-slate-400 truncate">Rina Pratiwi</div>
            </button>
            <button 
                type="button" 
                onclick="fillAccount('admin@telkomuniversity.ac.id', 'password123')"
                class="rounded-lg bg-slate-50 hover:bg-emerald-50 hover:text-emerald-700 hover:border-emerald-200 border border-slate-200 p-2 text-left transition"
            >
                <div class="text-[11px] font-bold text-slate-700">Admin</div>
                <div class="text-[10px] text-slate-400 truncate">Admin PilahKu</div>
            </button>
        </div>
    </div>

    <!-- Register Link -->
    <p class="mt-6 text-center text-sm text-slate-500">
        Belum memiliki akun civitas? 
        <a href="{{ route('register') }}" class="font-bold text-emerald-600 hover:text-emerald-700 hover:underline transition">
            Daftar Sekarang
        </a>
    </p>
</div>

<script>
    function togglePassword() {
        const input = document.getElementById('password');
        const icon = document.getElementById('eye-icon');
        if (input.type === 'password') {
            input.type = 'text';
            icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />';
        } else {
            input.type = 'password';
            icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />';
        }
    }

    function fillAccount(email, password) {
        document.getElementById('email_kampus').value = email;
        document.getElementById('password').value = password;
    }
</script>
@endsection
