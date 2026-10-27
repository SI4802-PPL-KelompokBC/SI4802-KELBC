<?php

namespace App\Console\Commands;

use App\Models\PengingatJadwal;
use App\Services\JadwalSiklus;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class KirimPengingatJadwal extends Command
{
    protected $signature = 'pilahku:kirim-pengingat';
    protected $description = 'Kirim pengingat jadwal pembuangan yang waktunya tiba (dijalankan tiap menit oleh scheduler).';

    public function handle(JadwalSiklus $siklus): int
    {
        $sekarang = now()->format('H:i');
        $kategori = $siklus->kategoriUntuk(now());

        $daftar = PengingatJadwal::with(['pengguna', 'jadwal.kategori'])
            ->where('aktif', true)
            ->whereRaw("substr(waktu_pengingat, 1, 5) = ?", [$sekarang])
            ->whereHas('pengguna', fn ($q) => $q->where('status_akun', 'aktif'))
            ->get();

        foreach ($daftar as $p) {
            // TODO (PBI-09): ganti Log dengan Notification (mail ke email kampus / web push).
            Log::info('Pengingat pembuangan', [
                'email' => $p->pengguna->email_kampus,
                'kategori_hari_ini' => $kategori?->nama_kategori,
            ]);
        }

        $this->info("Pengingat diproses: {$daftar->count()}");

        return self::SUCCESS;
    }
}
