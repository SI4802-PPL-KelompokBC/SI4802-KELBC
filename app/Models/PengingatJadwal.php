<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PengingatJadwal extends Model
{
    protected $table = 'pengingat_jadwal';
    protected $primaryKey = 'id_pengingat';
    protected $fillable = ['id_pengguna', 'id_jadwal', 'waktu_pengingat', 'aktif'];
    protected $casts = ['aktif' => 'boolean'];

    public function pengguna(): BelongsTo { return $this->belongsTo(Pengguna::class, 'id_pengguna'); }
    public function jadwal(): BelongsTo { return $this->belongsTo(JadwalPengangkutan::class, 'id_jadwal'); }
}
