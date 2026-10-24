<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class AktivitasPemilahan extends Model
{
    public const MENUNGGU = 'menunggu';
    public const TERVERIFIKASI = 'terverifikasi';
    public const DITOLAK = 'ditolak';

    protected $table = 'aktivitas_pemilahan';
    protected $primaryKey = 'id_aktivitas';

    protected $fillable = [
        'id_pengguna', 'id_kategori', 'id_lokasi', 'tanggal_waktu', 'jumlah', 'foto_bukti', 'catatan',
        'status_verifikasi', 'alasan_penolakan', 'poin_diperoleh', 'divalidasi_oleh', 'divalidasi_pada',
    ];

    protected $casts = [
        'tanggal_waktu' => 'datetime',
        'divalidasi_pada' => 'datetime',
        'jumlah' => 'float',
        'poin_diperoleh' => 'integer',
    ];

    public function pengguna(): BelongsTo { return $this->belongsTo(Pengguna::class, 'id_pengguna'); }
    public function kategori(): BelongsTo { return $this->belongsTo(KategoriSampah::class, 'id_kategori'); }
    public function lokasi(): BelongsTo { return $this->belongsTo(LokasiTempatSampah::class, 'id_lokasi'); }
    public function petugas(): BelongsTo { return $this->belongsTo(Pengguna::class, 'divalidasi_oleh'); }
    public function transaksi(): HasOne { return $this->hasOne(TransaksiPoin::class, 'id_aktivitas'); }
    public function verifikasi(): HasMany { return $this->hasMany(VerifikasiSampah::class, 'id_aktivitas'); }

    // Kode tampil seperti di mockup: AKT-0124
    public function getKodeAttribute(): string
    {
        return 'AKT-' . str_pad((string) $this->id_aktivitas, 4, '0', STR_PAD_LEFT);
    }

    public function getBisaDiubahAttribute(): bool
    {
        return in_array($this->status_verifikasi, [self::MENUNGGU, self::DITOLAK], true);
    }
}
