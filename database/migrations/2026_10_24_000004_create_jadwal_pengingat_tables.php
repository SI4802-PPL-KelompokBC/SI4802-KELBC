<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('jadwal_pengangkutan', function (Blueprint $t) {
            $t->id('id_jadwal');
            $t->foreignId('id_kategori')->constrained('kategori_sampah', 'id_kategori');
            $t->foreignId('id_lokasi')->constrained('lokasi_tempat_sampah', 'id_lokasi');
            $t->string('hari', 10)->nullable();
            $t->time('jam_angkut');
            $t->string('catatan', 255)->nullable();
            $t->string('status', 15)->default('aktif');
            $t->timestamps();
        });

        Schema::create('pengingat_jadwal', function (Blueprint $t) {
            $t->id('id_pengingat');
            $t->foreignId('id_pengguna')->constrained('pengguna', 'id_pengguna')->cascadeOnDelete();
            $t->foreignId('id_jadwal')->constrained('jadwal_pengangkutan', 'id_jadwal')->cascadeOnDelete();
            $t->time('waktu_pengingat');
            $t->boolean('aktif')->default(true);
            $t->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengingat_jadwal');
        Schema::dropIfExists('jadwal_pengangkutan');
    }
};
