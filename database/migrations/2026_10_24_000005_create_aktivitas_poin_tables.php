<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // nama_aturan & jenis ditambahkan di luar ERD draft: dipakai mockup (RWD-01..06, penambahan/pengurangan).
        Schema::create('aturan_reward', function (Blueprint $t) {
            $t->id('id_aturan');
            $t->foreignId('id_kategori')->nullable()->constrained('kategori_sampah', 'id_kategori');
            $t->string('nama_aturan', 100);
            $t->string('jenis', 15)->default('penambahan'); // penambahan|pengurangan
            $t->integer('poin_per_satuan');
            $t->integer('batas_per_hari')->nullable();
            $t->string('status', 15)->default('aktif');
            $t->timestamps();
        });

        // divalidasi_oleh & divalidasi_pada ditambahkan: mockup menampilkan "Divalidasi oleh Petugas ...".
        Schema::create('aktivitas_pemilahan', function (Blueprint $t) {
            $t->id('id_aktivitas');
            $t->foreignId('id_pengguna')->constrained('pengguna', 'id_pengguna');
            $t->foreignId('id_kategori')->constrained('kategori_sampah', 'id_kategori');
            $t->foreignId('id_lokasi')->constrained('lokasi_tempat_sampah', 'id_lokasi');
            $t->dateTime('tanggal_waktu');
            $t->decimal('jumlah', 10, 2);
            $t->string('foto_bukti', 255);
            $t->string('catatan', 255)->nullable();
            $t->string('status_verifikasi', 20)->default('menunggu'); // menunggu|terverifikasi|ditolak
            $t->string('alasan_penolakan', 255)->nullable();
            $t->integer('poin_diperoleh')->default(0);
            $t->foreignId('divalidasi_oleh')->nullable()->constrained('pengguna', 'id_pengguna');
            $t->dateTime('divalidasi_pada')->nullable();
            $t->timestamps();
            $t->index(['id_pengguna', 'status_verifikasi']);
        });

        // Tahap verifikasi otomatis/ML (opsional, mis. smart bin ESP32).
        Schema::create('verifikasi_sampah', function (Blueprint $t) {
            $t->id('id_verifikasi');
            $t->foreignId('id_aktivitas')->constrained('aktivitas_pemilahan', 'id_aktivitas')->cascadeOnDelete();
            $t->unsignedTinyInteger('tahap')->default(1);
            $t->string('hasil', 15)->nullable();
            $t->decimal('skor_keyakinan', 5, 2)->nullable();
            $t->string('label_terdeteksi', 50)->nullable();
            $t->string('foto_sampah', 255)->nullable();
            $t->dateTime('waktu_verifikasi')->nullable();
            $t->string('keterangan', 255)->nullable();
            $t->timestamps();
        });

        // Saldo = SUM(jumlah_poin). Koreksi disimpan sebagai jumlah negatif.
        Schema::create('transaksi_poin', function (Blueprint $t) {
            $t->id('id_transaksi');
            $t->foreignId('id_pengguna')->constrained('pengguna', 'id_pengguna');
            $t->foreignId('id_aktivitas')->nullable()->unique()->constrained('aktivitas_pemilahan', 'id_aktivitas');
            $t->dateTime('tanggal');
            $t->string('jenis', 10); // masuk|koreksi
            $t->integer('jumlah_poin');
            $t->string('keterangan', 255)->nullable();
            $t->timestamps();
            $t->index(['id_pengguna', 'tanggal']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transaksi_poin');
        Schema::dropIfExists('verifikasi_sampah');
        Schema::dropIfExists('aktivitas_pemilahan');
        Schema::dropIfExists('aturan_reward');
    }
};
