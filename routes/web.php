<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\AktivitasController;
use App\Http\Controllers\AlurController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\PanduanController;
use App\Http\Controllers\PetaController;
use App\Http\Controllers\PoinController;
use App\Http\Controllers\ProfilController;
use App\Http\Middleware\EnsureRole;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => redirect()->route(auth()->check() ? 'dashboard' : 'login'));

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:10,1');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // ---------- Civitas academica ----------
    Route::middleware(EnsureRole::class . ':civitas')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // PBI-01/02 Profil
        Route::get('/profil', [ProfilController::class, 'show'])->name('profil.show');
        Route::get('/profil/edit', [ProfilController::class, 'edit'])->name('profil.edit');
        Route::put('/profil', [ProfilController::class, 'update'])->name('profil.update');
        Route::put('/profil/kata-sandi', [ProfilController::class, 'updatePassword'])->name('profil.password');
        Route::post('/profil/nonaktifkan', [ProfilController::class, 'deactivate'])->name('profil.deactivate');

        // PBI-03/05/06 Panduan & pencarian
        Route::get('/panduan', [PanduanController::class, 'index'])->name('panduan.index');
        Route::get('/panduan/cari', [PanduanController::class, 'cari'])->name('panduan.cari');
        Route::get('/panduan/{kategori}', [PanduanController::class, 'show'])->name('panduan.show');

        // PBI-08/09 Jadwal & pengingat
        Route::get('/jadwal', [JadwalController::class, 'index'])->name('jadwal.index');
        Route::post('/jadwal/pengingat', [JadwalController::class, 'simpanPengingat'])->name('jadwal.pengingat');

        // PBI-11/12 Peta
        Route::get('/peta', [PetaController::class, 'index'])->name('peta.index');
        Route::get('/peta/data', [PetaController::class, 'data'])->name('peta.data');
        Route::get('/peta/{lokasi}', [PetaController::class, 'show'])->name('peta.show');

        // PBI-13/14/15 Aktivitas
        Route::resource('aktivitas', AktivitasController::class)->parameters(['aktivitas' => 'aktivitas']);

        // PBI-17/18 Poin
        Route::get('/poin', [PoinController::class, 'index'])->name('poin.index');
        Route::get('/poin/riwayat', [PoinController::class, 'riwayat'])->name('poin.riwayat');

        Route::get('/alur', [AlurController::class, 'index'])->name('alur.index');
    });

    // ---------- Admin / Petugas ----------
    Route::prefix('admin')->name('admin.')->group(function () {
        // Validasi aktivitas: admin dan petugas
        Route::middleware(EnsureRole::class . ':admin,petugas')->group(function () {
            Route::get('/validasi', [Admin\ValidasiController::class, 'index'])->name('validasi.index');
            Route::get('/validasi/{aktivitas}', [Admin\ValidasiController::class, 'show'])->name('validasi.show');
            Route::post('/validasi/{aktivitas}/setujui', [Admin\ValidasiController::class, 'approve'])->name('validasi.approve');
            Route::post('/validasi/{aktivitas}/tolak', [Admin\ValidasiController::class, 'reject'])->name('validasi.reject');
            Route::post('/validasi/{aktivitas}/koreksi', [Admin\ValidasiController::class, 'koreksi'])->name('validasi.koreksi');
        });

        // Data master: admin saja
        Route::middleware(EnsureRole::class . ':admin')->group(function () {
            Route::get('/kategori', [Admin\KategoriController::class, 'index'])->name('kategori.index');
            Route::post('/kategori', [Admin\KategoriController::class, 'store'])->name('kategori.store');
            Route::put('/kategori/{kategori}', [Admin\KategoriController::class, 'update'])->name('kategori.update');
            Route::post('/kategori/{kategori}/toggle', [Admin\KategoriController::class, 'toggle'])->name('kategori.toggle');

            Route::get('/lokasi', [Admin\LokasiController::class, 'index'])->name('lokasi.index');
            Route::post('/lokasi', [Admin\LokasiController::class, 'store'])->name('lokasi.store');
            Route::put('/lokasi/{lokasi}', [Admin\LokasiController::class, 'update'])->name('lokasi.update');
            Route::post('/lokasi/{lokasi}/toggle', [Admin\LokasiController::class, 'toggle'])->name('lokasi.toggle');

            Route::get('/jadwal', [Admin\JadwalController::class, 'index'])->name('jadwal.index');
            Route::post('/jadwal', [Admin\JadwalController::class, 'store'])->name('jadwal.store');
            Route::put('/jadwal/{jadwal}', [Admin\JadwalController::class, 'update'])->name('jadwal.update');
            Route::post('/jadwal/{jadwal}/toggle', [Admin\JadwalController::class, 'toggle'])->name('jadwal.toggle');

            Route::get('/reward', [Admin\AturanRewardController::class, 'index'])->name('reward.index');
            Route::post('/reward', [Admin\AturanRewardController::class, 'store'])->name('reward.store');
            Route::put('/reward/{reward}', [Admin\AturanRewardController::class, 'update'])->name('reward.update');
            Route::post('/reward/{reward}/toggle', [Admin\AturanRewardController::class, 'toggle'])->name('reward.toggle');
        });
    });
});
