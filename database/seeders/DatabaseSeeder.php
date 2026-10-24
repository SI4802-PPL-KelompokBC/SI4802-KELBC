<?php

namespace Database\Seeders;

use App\Models\AturanReward;
use App\Models\JadwalPengangkutan;
use App\Models\JenisSampah;
use App\Models\KategoriSampah;
use App\Models\LokasiTempatSampah;
use App\Models\Pengguna;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ---- Akun demo (kata sandi: password123) ----
        Pengguna::create(['nama_lengkap' => 'Admin PilahKu', 'peran' => 'admin', 'email_kampus' => 'admin@telkomuniversity.ac.id', 'kata_sandi' => 'password123', 'tanggal_bergabung' => today()]);
        Pengguna::create(['nama_lengkap' => 'Rina Pratiwi', 'peran' => 'petugas', 'email_kampus' => 'petugas@telkomuniversity.ac.id', 'kata_sandi' => 'password123', 'tanggal_bergabung' => today()]);
        Pengguna::create(['nama_lengkap' => 'Nadia Putri', 'nama_panggilan' => 'Nadia', 'peran' => 'mahasiswa', 'nim_nip' => '1202240017', 'email_kampus' => 'nadiaputri@student.telkomuniversity.ac.id', 'program_studi' => 'S1 Informatika', 'kata_sandi' => 'password123', 'tanggal_bergabung' => today()]);

        // ---- Kategori ----
        $kat = [];
        foreach ([
            ['ORG', 'Organik', 'green', 'Sisa makanan, daun, dan bahan alami yang mudah terurai.', 'Mudah busuk, berbau, dapat dikomposkan.', 'Pisahkan dari pembungkus, buang ke tong berlabel hijau.', 'aktif'],
            ['PLS', 'Plastik', 'blue', 'Kemasan dan barang berbahan plastik yang dapat didaur ulang setelah dibersihkan.', 'Ringan, tidak mudah terurai, bertanda kode daur ulang.', 'Kosongkan, bilas singkat, pipihkan, buang sesuai jadwal.', 'aktif'],
            ['KRT', 'Kertas', 'amber', 'Kertas dan kardus dalam kondisi kering dan tidak berminyak.', 'Kering, mudah sobek, dapat didaur ulang.', 'Lipat, jaga tetap kering, buang ke tong berlabel kuning.', 'aktif'],
            ['B3', 'B3 & Elektronik', 'purple', 'Baterai, lampu, dan limbah elektronik.', 'Berbahaya bila tercampur.', 'Serahkan ke titik khusus.', 'nonaktif'],
        ] as [$kode, $nama, $warna, $desk, $kar, $cara, $status]) {
            $kat[$kode] = KategoriSampah::create([
                'kode' => $kode, 'nama_kategori' => $nama, 'warna_label' => $warna,
                'deskripsi' => $desk, 'karakteristik' => $kar, 'cara_pembuangan' => $cara, 'status' => $status,
            ]);
        }

        foreach ([
            'ORG' => ['Kulit pisang', 'Sisa nasi', 'Daun kering', 'Kulit buah', 'Bonggol pisang'],
            'PLS' => ['Botol air mineral', 'Gelas plastik', 'Sedotan', 'Kantong kresek', 'Tutup botol'],
            'KRT' => ['Kertas HVS', 'Kardus', 'Koran'],
        ] as $kode => $daftar) {
            foreach ($daftar as $nama) {
                JenisSampah::create(['id_kategori' => $kat[$kode]->id_kategori, 'nama_jenis' => $nama, 'diterima' => true]);
            }
        }
        JenisSampah::create(['id_kategori' => $kat['PLS']->id_kategori, 'nama_jenis' => 'Styrofoam bekas makanan', 'diterima' => false]);

        // ---- Lokasi (koordinat contoh, sesuaikan dengan titik asli) ----
        $lokasi = [];
        foreach ([
            ['A1', 'Kantin TULT - A1', -6.974700, 107.630400, ['PLS']],
            ['A2', 'Kantin TULT - A2', -6.974600, 107.630500, ['PLS', 'KRT']],
            ['B1', 'Gedung Selaru - B1', -6.975200, 107.629700, ['KRT']],
            ['C3', 'Kantin Asrama - C3', -6.976000, 107.631200, ['ORG']],
            ['D1', 'Pendopo - D1', -6.975500, 107.630800, ['PLS', 'KRT']],
            ['E2', 'Parkiran TULT - E2', -6.974200, 107.631000, ['PLS']],
        ] as [$kode, $nama, $lat, $lng, $kodeKat]) {
            $l = LokasiTempatSampah::create(['kode_titik' => $kode, 'nama_lokasi' => $nama, 'latitude' => $lat, 'longitude' => $lng, 'status' => 'aktif']);
            $l->kategori()->sync(collect($kodeKat)->map(fn ($k) => $kat[$k]->id_kategori)->all());
            $lokasi[$kode] = $l;
        }

        // ---- Jadwal pengangkutan (siklus 3 hari, kategori diatur config/pilahku.php) ----
        foreach ($lokasi as $l) {
            foreach ($l->kategori as $k) {
                JadwalPengangkutan::create(['id_kategori' => $k->id_kategori, 'id_lokasi' => $l->id_lokasi, 'hari' => null, 'jam_angkut' => '16:00', 'catatan' => 'Siklus 3 hari', 'status' => 'aktif']);
            }
        }

        // ---- Aturan reward ----
        AturanReward::create(['nama_aturan' => 'Pemilahan Plastik', 'id_kategori' => $kat['PLS']->id_kategori, 'jenis' => 'penambahan', 'poin_per_satuan' => 5, 'batas_per_hari' => 50]);
        AturanReward::create(['nama_aturan' => 'Pemilahan Kertas', 'id_kategori' => $kat['KRT']->id_kategori, 'jenis' => 'penambahan', 'poin_per_satuan' => 5, 'batas_per_hari' => 50]);
        AturanReward::create(['nama_aturan' => 'Pemilahan Organik', 'id_kategori' => $kat['ORG']->id_kategori, 'jenis' => 'penambahan', 'poin_per_satuan' => 10, 'batas_per_hari' => 50]);
    }
}
