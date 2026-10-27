@extends('layouts.guest', ['title' => 'Daftar Akun - PilahKu Telkom University'])

@section('content')
<div class="py-2">
    <!-- Header -->
    <div class="mb-6">
        <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-700 border border-emerald-200 mb-3">
            <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
            Registrasi Baru
        </span>
        <h2 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-slate-900">
            Daftar Akun PilahKu
        </h2>
        <p class="mt-1 text-sm text-slate-500">
            Khusus civitas academica Telkom University (Mahasiswa, Dosen, dan Tendik).
        </p>
    </div>

    <!-- Registration Form -->
    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <!-- Nama Lengkap -->
        <div>
            <label for="nama_lengkap" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">
                Nama Lengkap <span class="text-emerald-600">*</span>
            </label>
            <input 
                type="text" 
                id="nama_lengkap"
                name="nama_lengkap" 
                value="{{ old('nama_lengkap') }}" 
                required 
                placeholder="mis. Muhammad Raihan"
                class="block w-full rounded-xl border border-slate-200 bg-slate-50/50 px-3.5 py-2.5 text-sm text-slate-800 placeholder-slate-400 transition focus:border-emerald-600 focus:bg-white focus:outline-none focus:ring-4 focus:ring-emerald-500/10 @error('nama_lengkap') border-red-500 bg-red-50/30 @enderror"
            >
            @error('nama_lengkap')
                <p class="mt-1 text-xs font-medium text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Peran & NIM/NIP -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
            <div>
                <label for="peran" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">
                    Peran Kampus <span class="text-emerald-600">*</span>
                </label>
                <select 
                    id="peran"
                    name="peran" 
                    required
                    class="block w-full rounded-xl border border-slate-200 bg-slate-50/50 px-3 py-2.5 text-sm text-slate-800 transition focus:border-emerald-600 focus:bg-white focus:outline-none focus:ring-4 focus:ring-emerald-500/10"
                >
                    @foreach (['mahasiswa' => 'Mahasiswa', 'dosen' => 'Dosen', 'tendik' => 'Tenaga Kependidikan'] as $v => $l)
                        <option value="{{ $v }}" @selected(old('peran') === $v)>{{ $l }}</option>
                    @endforeach
                </select>
                @error('peran')
                    <p class="mt-1 text-xs font-medium text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="nim_nip" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">
                    NIM / NIP <span class="text-emerald-600">*</span>
                </label>
                <input 
                    type="text" 
                    id="nim_nip"
                    name="nim_nip" 
                    value="{{ old('nim_nip') }}" 
                    required 
                    placeholder="mis. 1202210001"
                    class="block w-full rounded-xl border border-slate-200 bg-slate-50/50 px-3.5 py-2.5 text-sm text-slate-800 placeholder-slate-400 transition focus:border-emerald-600 focus:bg-white focus:outline-none focus:ring-4 focus:ring-emerald-500/10 @error('nim_nip') border-red-500 bg-red-50/30 @enderror"
                >
                @error('nim_nip')
                    <p class="mt-1 text-xs font-medium text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Email Kampus -->
        <div>
            <label for="email_kampus" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">
                Email Kampus Telkom <span class="text-emerald-600">*</span>
            </label>
            <input 
                type="email" 
                id="email_kampus"
                name="email_kampus" 
                value="{{ old('email_kampus') }}" 
                required 
                placeholder="nama@student.telkomuniversity.ac.id"
                class="block w-full rounded-xl border border-slate-200 bg-slate-50/50 px-3.5 py-2.5 text-sm text-slate-800 placeholder-slate-400 transition focus:border-emerald-600 focus:bg-white focus:outline-none focus:ring-4 focus:ring-emerald-500/10 @error('email_kampus') border-red-500 bg-red-50/30 @enderror"
            >
            <p class="mt-1 text-[11px] text-slate-500">Wajib menggunakan domain @telkomuniversity.ac.id</p>
            @error('email_kampus')
                <p class="mt-1 text-xs font-medium text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Program Studi / Unit -->
        <div>
            <label for="program_studi" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">
                Program Studi / Unit Kerja
            </label>
            <input 
                type="text" 
                id="program_studi"
                name="program_studi" 
                value="{{ old('program_studi') }}" 
                placeholder="mis. S1 Sistem Informasi / FRI"
                class="block w-full rounded-xl border border-slate-200 bg-slate-50/50 px-3.5 py-2.5 text-sm text-slate-800 placeholder-slate-400 transition focus:border-emerald-600 focus:bg-white focus:outline-none focus:ring-4 focus:ring-emerald-500/10"
            >
            @error('program_studi')
                <p class="mt-1 text-xs font-medium text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
            <div>
                <label for="kata_sandi" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">
                    Kata Sandi <span class="text-emerald-600">*</span>
                </label>
                <input 
                    type="password" 
                    id="kata_sandi"
                    name="kata_sandi" 
                    required 
                    placeholder="Min. 8 karakter"
                    class="block w-full rounded-xl border border-slate-200 bg-slate-50/50 px-3.5 py-2.5 text-sm text-slate-800 placeholder-slate-400 transition focus:border-emerald-600 focus:bg-white focus:outline-none focus:ring-4 focus:ring-emerald-500/10 @error('kata_sandi') border-red-500 bg-red-50/30 @enderror"
                >
            </div>
            <div>
                <label for="kata_sandi_confirmation" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">
                    Ulangi Kata Sandi <span class="text-emerald-600">*</span>
                </label>
                <input 
                    type="password" 
                    id="kata_sandi_confirmation"
                    name="kata_sandi_confirmation" 
                    required 
                    placeholder="Ulangi kata sandi"
                    class="block w-full rounded-xl border border-slate-200 bg-slate-50/50 px-3.5 py-2.5 text-sm text-slate-800 placeholder-slate-400 transition focus:border-emerald-600 focus:bg-white focus:outline-none focus:ring-4 focus:ring-emerald-500/10"
                >
            </div>
        </div>
        <p class="text-[11px] text-slate-400">Kata sandi harus kombinasi huruf dan angka minimal 8 karakter.</p>
        @error('kata_sandi')
            <p class="text-xs font-medium text-red-600">{{ $message }}</p>
        @enderror

        <!-- Agreement Checkbox -->
        <div class="pt-2">
            <label class="flex items-start gap-2.5 cursor-pointer text-xs text-slate-600 hover:text-slate-800">
                <input 
                    type="checkbox" 
                    name="setuju" 
                    value="1" 
                    class="mt-0.5 h-4 w-4 rounded-md border-slate-300 text-emerald-600 focus:ring-emerald-500"
                >
                <span>Saya menyetujui ketentuan penggunaan dan kebijakan privasi data PilahKu Telkom University.</span>
            </label>
            @error('setuju')
                <p class="mt-1 text-xs font-medium text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Submit Button (Green Gradient) -->
        <button 
            type="submit" 
            class="group relative flex w-full justify-center items-center gap-2 rounded-xl bg-gradient-to-r from-emerald-600 via-teal-600 to-green-700 py-3.5 px-4 text-sm font-semibold text-white shadow-lg shadow-emerald-600/25 transition-all duration-200 hover:from-emerald-700 hover:via-teal-700 hover:to-green-800 hover:shadow-xl hover:shadow-emerald-600/30 active:scale-[0.99] focus:outline-none focus:ring-4 focus:ring-emerald-500/30"
        >
            <span>Daftar & Buat Profil</span>
            <svg class="h-4 w-4 transition-transform duration-200 group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
            </svg>
        </button>
    </form>

    <!-- Back to Login -->
    <p class="mt-6 text-center text-sm text-slate-500">
        Sudah memiliki akun? 
        <a href="{{ route('login') }}" class="font-bold text-emerald-600 hover:text-emerald-700 hover:underline transition">
            Masuk Sekarang
        </a>
    </p>
</div>
@endsection
