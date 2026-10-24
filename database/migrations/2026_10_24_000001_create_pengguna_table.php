<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pengguna', function (Blueprint $t) {
            $t->id('id_pengguna');
            $t->string('nama_lengkap', 100);
            $t->string('nama_panggilan', 50)->nullable();
            $t->string('peran', 20)->default('mahasiswa'); // mahasiswa|dosen|tendik|petugas|admin
            $t->string('nim_nip', 20)->nullable()->unique();
            $t->string('email_kampus', 100)->unique();
            $t->string('program_studi', 100)->nullable();
            $t->string('no_hp', 15)->nullable();
            $t->string('kata_sandi', 255);
            $t->string('foto_profil', 255)->nullable();
            $t->string('status_akun', 15)->default('aktif'); // aktif|nonaktif
            $t->date('tanggal_bergabung')->nullable();
            $t->rememberToken();
            $t->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengguna');
    }
};
