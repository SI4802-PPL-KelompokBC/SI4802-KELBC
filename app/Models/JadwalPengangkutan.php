<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JadwalPengangkutan extends Model
{
    protected $table = 'jadwal_pengangkutan';
    protected $primaryKey = 'id_jadwal';
    protected $fillable = ['id_kategori', 'id_lokasi', 'hari', 'jam_angkut', 'catatan', 'status'];

    public function scopeAktif(Builder $q): Builder { return $q->where('status', 'aktif'); }

    public function kategori(): BelongsTo { return $this->belongsTo(KategoriSampah::class, 'id_kategori'); }
    public function lokasi(): BelongsTo { return $this->belongsTo(LokasiTempatSampah::class, 'id_lokasi'); }
    public function pengingat(): HasMany { return $this->hasMany(PengingatJadwal::class, 'id_jadwal'); }
}
