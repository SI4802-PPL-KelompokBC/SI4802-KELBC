@extends('layouts.app', ['title' => 'Edit Profil'])
@section('content')
<h1 class="text-xl font-semibold">Edit Profil</h1>
<p class="text-sm text-slate-500">NIM dan email kampus hanya dapat diubah oleh admin.</p>
<div class="mt-4 grid gap-4 md:grid-cols-3">
    <form method="POST" action="{{ route('profil.update') }}" enctype="multipart/form-data" class="space-y-3 rounded-xl bg-white p-5 shadow-sm md:col-span-2">
        @csrf @method('PUT')
        <div><label class="text-sm font-medium">Foto profil (JPG/PNG, maks. 2 MB)</label><input type="file" name="foto_profil" class="mt-1 block text-sm"></div>
        <div><label class="text-sm font-medium">Nama lengkap *</label><input name="nama_lengkap" value="{{ old('nama_lengkap', $user->nama_lengkap) }}" required class="mt-1 w-full rounded-lg border px-3 py-2"></div>
        <div><label class="text-sm font-medium">Nama panggilan</label><input name="nama_panggilan" value="{{ old('nama_panggilan', $user->nama_panggilan) }}" class="mt-1 w-full rounded-lg border px-3 py-2"></div>
        <div class="grid grid-cols-2 gap-3">
            <div><label class="text-sm font-medium">NIM/NIP</label><input value="{{ $user->nim_nip }}" disabled class="mt-1 w-full rounded-lg border bg-slate-100 px-3 py-2"></div>
            <div><label class="text-sm font-medium">Email kampus</label><input value="{{ $user->email_kampus }}" disabled class="mt-1 w-full rounded-lg border bg-slate-100 px-3 py-2"></div>
        </div>
        <div><label class="text-sm font-medium">Program studi / unit</label><input name="program_studi" value="{{ old('program_studi', $user->program_studi) }}" class="mt-1 w-full rounded-lg border px-3 py-2"></div>
        <div><label class="text-sm font-medium">No. HP (opsional)</label><input name="no_hp" value="{{ old('no_hp', $user->no_hp) }}" class="mt-1 w-full rounded-lg border px-3 py-2"></div>
        <div class="flex justify-end gap-2"><a href="{{ route('profil.show') }}" class="rounded-lg border px-4 py-2 text-sm">Batal</a><button class="rounded-lg bg-brand-600 px-4 py-2 text-sm text-white">Simpan Perubahan</button></div>
    </form>

    <div class="space-y-4">
        <form method="POST" action="{{ route('profil.password') }}" class="space-y-3 rounded-xl bg-white p-5 shadow-sm">
            @csrf @method('PUT')
            <h2 class="font-semibold">Ubah Kata Sandi</h2>
            <input type="password" name="password_lama" placeholder="Kata sandi saat ini" class="w-full rounded-lg border px-3 py-2">
            <input type="password" name="kata_sandi" placeholder="Kata sandi baru (min. 8)" class="w-full rounded-lg border px-3 py-2">
            <button class="w-full rounded-lg border py-2 text-sm">Perbarui Kata Sandi</button>
        </form>
        <form method="POST" action="{{ route('profil.deactivate') }}" class="space-y-3 rounded-xl border border-red-200 bg-red-50 p-5" onsubmit="return confirm('Nonaktifkan akun?')">
            @csrf
            <h2 class="font-semibold text-red-700">Nonaktifkan Akun</h2>
            <p class="text-xs text-red-700">Riwayat aktivitas dan poin tetap tersimpan.</p>
            <input name="konfirmasi" placeholder="Ketik NONAKTIFKAN" class="w-full rounded-lg border px-3 py-2">
            <input type="password" name="password" placeholder="Kata sandi" class="w-full rounded-lg border px-3 py-2">
            <button class="w-full rounded-lg border border-red-300 py-2 text-sm text-red-700">Nonaktifkan Akun</button>
        </form>
    </div>
</div>
@endsection
