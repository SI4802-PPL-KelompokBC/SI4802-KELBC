<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VerifikasiSampah extends Model
{
    protected $table = 'verifikasi_sampah';
    protected $primaryKey = 'id_verifikasi';
    protected $fillable = ['id_aktivitas', 'tahap', 'hasil', 'skor_keyakinan', 'label_terdeteksi', 'foto_sampah', 'waktu_verifikasi', 'keterangan'];
    protected $casts = ['waktu_verifikasi' => 'datetime'];

    public function aktivitas(): BelongsTo { return $this->belongsTo(AktivitasPemilahan::class, 'id_aktivitas'); }
}
