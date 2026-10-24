<?php

namespace App\Services;

use App\Models\AktivitasPemilahan;
use App\Models\AturanReward;
use App\Models\Pengguna;
use App\Models\TransaksiPoin;
use Illuminate\Support\Facades\DB;
use RuntimeException;

/**
 * Point Engine: poin hanya dihitung setelah petugas menyetujui aktivitas.
 * Hasilnya selalu dicatat sebagai transaksi poin; saldo = SUM(jumlah_poin).
 */
class PointEngine
{
    public function saldo(Pengguna $user): int
    {
        return (int) TransaksiPoin::where('id_pengguna', $user->id_pengguna)->sum('jumlah_poin');
    }

    public function approve(AktivitasPemilahan $aktivitas, Pengguna $petugas): TransaksiPoin
    {
        return DB::transaction(function () use ($aktivitas, $petugas) {
            $a = AktivitasPemilahan::lockForUpdate()->findOrFail($aktivitas->id_aktivitas);

            if ($a->status_verifikasi !== AktivitasPemilahan::MENUNGGU) {
                throw new RuntimeException('Aktivitas sudah divalidasi.');
            }

            $poin = $this->hitungPoin($a);

            $a->update([
                'status_verifikasi' => AktivitasPemilahan::TERVERIFIKASI,
                'alasan_penolakan' => null,
                'poin_diperoleh' => $poin,
                'divalidasi_oleh' => $petugas->id_pengguna,
                'divalidasi_pada' => now(),
            ]);

            return TransaksiPoin::create([
                'id_pengguna' => $a->id_pengguna,
                'id_aktivitas' => $a->id_aktivitas,
                'tanggal' => now(),
                'jenis' => TransaksiPoin::MASUK,
                'jumlah_poin' => $poin,
                'keterangan' => 'Aktivitas terverifikasi - ' . $a->kategori->nama_kategori . ' ' . $a->jumlah,
            ]);
        });
    }

    public function reject(AktivitasPemilahan $aktivitas, Pengguna $petugas, string $alasan): AktivitasPemilahan
    {
        return DB::transaction(function () use ($aktivitas, $petugas, $alasan) {
            $a = AktivitasPemilahan::lockForUpdate()->findOrFail($aktivitas->id_aktivitas);

            if ($a->status_verifikasi !== AktivitasPemilahan::MENUNGGU) {
                throw new RuntimeException('Aktivitas sudah divalidasi.');
            }

            $a->update([
                'status_verifikasi' => AktivitasPemilahan::DITOLAK,
                'alasan_penolakan' => $alasan,
                'poin_diperoleh' => 0,
                'divalidasi_oleh' => $petugas->id_pengguna,
                'divalidasi_pada' => now(),
            ]);

            return $a;
        });
    }

    /** Pengurangan poin (FR-12), disimpan sebagai transaksi bernilai negatif. */
    public function koreksi(Pengguna $user, int $jumlah, string $keterangan): TransaksiPoin
    {
        return TransaksiPoin::create([
            'id_pengguna' => $user->id_pengguna,
            'id_aktivitas' => null,
            'tanggal' => now(),
            'jenis' => TransaksiPoin::KOREKSI,
            'jumlah_poin' => -abs($jumlah),
            'keterangan' => $keterangan,
        ]);
    }

    /**
     * poin = jumlah x poin_per_satuan (aturan aktif untuk kategori), dibatasi batas_per_hari.
     * TODO: aturan bonus tanpa kategori (mis. bonus konsistensi 5 hari) belum dihitung.
     */
    private function hitungPoin(AktivitasPemilahan $a): int
    {
        $rule = AturanReward::aktif()
            ->where('jenis', 'penambahan')
            ->where('id_kategori', $a->id_kategori)
            ->first();

        if (! $rule) {
            return 0;
        }

        $poin = (int) floor($a->jumlah * $rule->poin_per_satuan);

        if ($rule->batas_per_hari !== null) {
            $sudahHariIni = (int) TransaksiPoin::where('id_pengguna', $a->id_pengguna)
                ->where('jenis', TransaksiPoin::MASUK)
                ->whereDate('tanggal', today())
                ->whereHas('aktivitas', fn ($q) => $q->where('id_kategori', $a->id_kategori))
                ->sum('jumlah_poin');

            $poin = min($poin, max(0, $rule->batas_per_hari - $sudahHariIni));
        }

        return max(0, $poin);
    }
}
