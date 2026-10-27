<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JenisSampah extends Model
{
    protected $table = 'jenis_sampah';
    protected $primaryKey = 'id_jenis';
    protected $fillable = ['id_kategori', 'nama_jenis', 'diterima'];
    protected $casts = ['diterima' => 'boolean'];

    public function kategori(): BelongsTo { return $this->belongsTo(KategoriSampah::class, 'id_kategori'); }
}
