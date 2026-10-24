<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('kategori_sampah', function (Blueprint $t) {
            $t->id('id_kategori');
            $t->string('nama_kategori', 50);
            $t->string('kode', 10)->unique();
            $t->string('warna_label', 20)->nullable();
            $t->text('deskripsi')->nullable();
            $t->text('karakteristik')->nullable();
            $t->text('cara_pembuangan')->nullable();
            $t->string('status', 15)->default('aktif');
            $t->timestamps();
        });

        Schema::create('jenis_sampah', function (Blueprint $t) {
            $t->id('id_jenis');
            $t->foreignId('id_kategori')->constrained('kategori_sampah', 'id_kategori')->cascadeOnDelete();
            $t->string('nama_jenis', 100);
            $t->boolean('diterima')->default(true);
            $t->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jenis_sampah');
        Schema::dropIfExists('kategori_sampah');
    }
};
