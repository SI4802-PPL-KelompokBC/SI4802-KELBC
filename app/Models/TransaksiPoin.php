<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TransaksiPoin extends Model
{
    public const MASUK = 'masuk';
    public const KOREKSI = 'koreksi';

    protected $table = 'transaksi_poin';
    protected $primaryKey = 'id_transaksi';
    protected $fillable = ['id_pengguna', 'id_aktivitas', 'tanggal', 'jenis', 'jumlah_poin', 'keterangan'];
    protected $casts = ['tanggal' => 'datetime', 'jumlah_poin' => 'integer'];

    public function pengguna(): BelongsTo { return $this->belongsTo(Pengguna::class, 'id_pengguna'); }
    public function aktivitas(): BelongsTo { return $this->belongsTo(AktivitasPemilahan::class, 'id_aktivitas'); }
}
