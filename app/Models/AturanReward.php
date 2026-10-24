<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AturanReward extends Model
{
    protected $table = 'aturan_reward';
    protected $primaryKey = 'id_aturan';
    protected $fillable = ['id_kategori', 'nama_aturan', 'jenis', 'poin_per_satuan', 'batas_per_hari', 'status'];

    public function scopeAktif(Builder $q): Builder { return $q->where('status', 'aktif'); }

    public function kategori(): BelongsTo { return $this->belongsTo(KategoriSampah::class, 'id_kategori'); }
}
