<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KategoriSampah extends Model
{
    protected $table = 'kategori_sampah';
    protected $primaryKey = 'id_kategori';
    protected $fillable = ['nama_kategori', 'kode', 'warna_label', 'deskripsi', 'karakteristik', 'cara_pembuangan', 'status'];

    public function scopeAktif(Builder $q): Builder { return $q->where('status', 'aktif'); }

    public function jenis(): HasMany { return $this->hasMany(JenisSampah::class, 'id_kategori'); }
    public function aturanReward(): HasMany { return $this->hasMany(AturanReward::class, 'id_kategori'); }
    public function jadwal(): HasMany { return $this->hasMany(JadwalPengangkutan::class, 'id_kategori'); }

    public function lokasi(): BelongsToMany
    {
        return $this->belongsToMany(LokasiTempatSampah::class, 'kategori_lokasi', 'id_kategori', 'id_lokasi');
    }
}
