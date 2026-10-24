<?php

namespace App\Services;

use App\Models\KategoriSampah;
use Carbon\CarbonInterface;

/** Siklus pembuangan 3 hari: tiap hari satu kategori sampah (config/pilahku.php). */
class JadwalSiklus
{
    public function kodeUntuk(CarbonInterface $tanggal): string
    {
        $order = config('pilahku.cycle_order');
        $start = \Illuminate\Support\Carbon::parse(config('pilahku.cycle_start'))->startOfDay();
        $selisih = (int) $start->diffInDays($tanggal->copy()->startOfDay(), false);

        return $order[(($selisih % count($order)) + count($order)) % count($order)];
    }

    public function kategoriUntuk(CarbonInterface $tanggal): ?KategoriSampah
    {
        return KategoriSampah::where('kode', $this->kodeUntuk($tanggal))->first();
    }
}
