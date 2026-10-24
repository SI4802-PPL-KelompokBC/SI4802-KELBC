@extends('layouts.guest', ['title' => 'Daftar - PilahKu'])
@section('content')
<h2 class="text-xl font-semibold">Buat Akun PilahKu</h2>
<p class="text-sm text-slate-500">Gunakan email kampus agar akun dapat diverifikasi.</p>
<form method="POST" action="{{ route('register') }}" class="mt-6 space-y-3">
    @csrf
    <div>
        <label class="text-sm font-medium">Nama lengkap *</label>
        <input name="nama_lengkap" value="{{ old('nama_lengkap') }}" required class="mt-1 w-full rounded-lg border px-3 py-2">
    </div>
    <div class="grid grid-cols-2 gap-3">
        <div>
            <label class="text-sm font-medium">Peran *</label>
            <select name="peran" class="mt-1 w-full rounded-lg border px-3 py-2">
                @foreach (['mahasiswa' => 'Mahasiswa', 'dosen' => 'Dosen', 'tendik' => 'Tenaga Kependidikan'] as $v => $l)
                    <option value="{{ $v }}" @selected(old('peran') === $v)>{{ $l }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="text-sm font-medium">NIM / NIP *</label>
            <input name="nim_nip" value="{{ old('nim_nip') }}" required class="mt-1 w-full rounded-lg border px-3 py-2">
        </div>
    </div>
    <div>
        <label class="text-sm font-medium">Email kampus *</label>
        <input type="email" name="email_kampus" value="{{ old('email_kampus') }}" required class="mt-1 w-full rounded-lg border px-3 py-2">
    </div>
    <div>
        <label class="text-sm font-medium">Program studi / unit</label>
        <input name="program_studi" value="{{ old('program_studi') }}" class="mt-1 w-full rounded-lg border px-3 py-2">
    </div>
    <div class="grid grid-cols-2 gap-3">
        <div>
            <label class="text-sm font-medium">Kata sandi *</label>
            <input type="password" name="kata_sandi" required class="mt-1 w-full rounded-lg border px-3 py-2">
        </div>
        <div>
            <label class="text-sm font-medium">Ulangi kata sandi *</label>
            <input type="password" name="kata_sandi_confirmation" required class="mt-1 w-full rounded-lg border px-3 py-2">
        </div>
    </div>
    <p class="text-xs text-slate-500">Minimal 8 karakter, kombinasi huruf dan angka.</p>
    <label class="flex items-start gap-2 text-sm"><input type="checkbox" name="setuju" value="1" class="mt-1"> Saya menyetujui ketentuan penggunaan dan kebijakan privasi data PilahKu.</label>
    <button class="w-full rounded-lg bg-brand-600 py-2 font-medium text-white hover:bg-brand-700">Daftar & Buat Profil</button>
</form>
<p class="mt-4 text-center text-sm">Sudah punya akun? <a href="{{ route('login') }}" class="font-medium text-brand-700">Masuk</a></p>
@endsection
