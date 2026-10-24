<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Pengguna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $cred = $request->validate([
            'email_kampus' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        // Hanya akun aktif yang boleh masuk.
        $ok = Auth::attempt(
            ['email_kampus' => $cred['email_kampus'], 'password' => $cred['password'], 'status_akun' => 'aktif'],
            $request->boolean('remember')
        );

        if (! $ok) {
            return back()->withErrors(['email_kampus' => 'Email atau kata sandi salah, atau akun nonaktif.'])->onlyInput('email_kampus');
        }

        $request->session()->regenerate();

        return redirect()->intended(Auth::user()->isStaff() ? route('admin.validasi.index') : route('dashboard'));
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'nama_lengkap' => ['required', 'string', 'max:100'],
            'peran' => ['required', 'in:mahasiswa,dosen,tendik'],
            'nim_nip' => ['required', 'string', 'max:20', 'unique:pengguna,nim_nip'],
            'email_kampus' => ['required', 'email', 'max:100', 'unique:pengguna,email_kampus', 'regex:' . config('pilahku.email_regex')],
            'program_studi' => ['nullable', 'string', 'max:100'],
            'kata_sandi' => ['required', 'string', 'min:8', 'confirmed', 'regex:/[A-Za-z]/', 'regex:/\d/'],
            'setuju' => ['accepted'],
        ], [
            'email_kampus.regex' => 'Gunakan email kampus (telkomuniversity.ac.id).',
            'kata_sandi.regex' => 'Kata sandi harus kombinasi huruf dan angka.',
            'setuju.accepted' => 'Anda harus menyetujui ketentuan penggunaan dan privasi data.',
        ]);

        unset($data['setuju']);
        $user = Pengguna::create($data + ['status_akun' => 'aktif', 'tanggal_bergabung' => today()]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('dashboard')->with('status', 'Akun berhasil dibuat.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
