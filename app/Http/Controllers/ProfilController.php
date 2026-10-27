<?php

namespace App\Http\Controllers;

use App\Models\AktivitasPemilahan;
use App\Services\PointEngine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

/** PBI-01 (CRUD profil) & PBI-02 (detail profil) */
class ProfilController extends Controller
{
    public function show(PointEngine $poin)
    {
        $user = auth()->user();

        return view('profil.show', [
            'user' => $user,
            'saldo' => $poin->saldo($user),
            'total' => $user->aktivitas()->count(),
            'terverifikasi' => $user->aktivitas()->where('status_verifikasi', AktivitasPemilahan::TERVERIFIKASI)->count(),
            'terbaru' => $user->aktivitas()->with(['kategori', 'lokasi'])->latest('tanggal_waktu')->limit(4)->get(),
        ]);
    }

    public function edit()
    {
        return view('profil.edit', ['user' => auth()->user()]);
    }

    public function update(Request $request)
    {
        // NIM/NIP dan email kampus hanya bisa diubah admin.
        $data = $request->validate([
            'nama_lengkap' => ['required', 'string', 'max:100'],
            'nama_panggilan' => ['nullable', 'string', 'max:50'],
            'program_studi' => ['nullable', 'string', 'max:100'],
            'no_hp' => ['nullable', 'string', 'max:15'],
            'foto_profil' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ]);

        $user = $request->user();

        if ($request->hasFile('foto_profil')) {
            if ($user->foto_profil) {
                Storage::disk('public')->delete($user->foto_profil);
            }
            $data['foto_profil'] = $request->file('foto_profil')->store('profil', 'public');
        } else {
            unset($data['foto_profil']);
        }

        $user->update($data);

        return redirect()->route('profil.show')->with('status', 'Perubahan berhasil disimpan.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'password_lama' => ['required', 'string'],
            'kata_sandi' => ['required', 'string', 'min:8', 'regex:/[A-Za-z]/', 'regex:/\d/'],
        ]);

        $user = $request->user();

        if (! Hash::check($request->password_lama, $user->kata_sandi)) {
            throw ValidationException::withMessages(['password_lama' => 'Kata sandi saat ini salah.']);
        }

        $user->update(['kata_sandi' => $request->kata_sandi]);

        return back()->with('status', 'Kata sandi diperbarui.');
    }

    /** Nonaktifkan (soft) - riwayat aktivitas dan poin tetap tersimpan. */
    public function deactivate(Request $request)
    {
        $request->validate([
            'konfirmasi' => ['required', 'in:NONAKTIFKAN'],
            'password' => ['required', 'string'],
        ]);

        $user = $request->user();

        if (! Hash::check($request->password, $user->kata_sandi)) {
            throw ValidationException::withMessages(['password' => 'Kata sandi salah.']);
        }

        $user->update(['status_akun' => 'nonaktif']);

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('status', 'Akun dinonaktifkan.');
    }
}
