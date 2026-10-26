# 🌿 PilahKu — Sistem Informasi Pemilahan Sampah & Reward Kampus Berkelanjutan

> **SI4802 Pengembangan Perangkat Lunak (PPL) — Kelompok BC**  
> Mendukung pencapaian **SDGs 12: Responsible Consumption and Production** di lingkungan **Telkom University**.

---

## 📌 Daftar Isi
1. [Tentang Aplikasi](#-tentang-aplikasi)
2. [Latar Belakang & SDGs 12](#-latar-belakang--sdgs-12)
3. [Tim Pengembang (Kelompok BC)](#-tim-pengembang-kelompok-bc---si4802)
4. [Kredensial Akun Demo](#-kredensial-akun-demo-default-credentials)
5. [Matriks Product Backlog Items (PBI 01 - 18)](#-matriks-fitur--product-backlog-items-pbi)
6. [Fitur Unggulan & Pembaruan UI/UX](#-fitur-unggulan--pembaruan-uiux)
7. [Daftar Rute & Endpoint Aplikasi](#-daftar-rute--endpoint-aplikasi)
8. [Struktur Direktori Proyek](#-struktur-direktori-proyek)
9. [Teknologi yang Digunakan](#-teknologi-yang-digunakan)
10. [Panduan Instalasi & Menjalankan Proyek](#-panduan-instalasi--menjalankan-proyek)
11. [Menjalankan Pengujian Otomatis](#-menjalankan-pengujian-otomatis)
12. [Lisensi & Hak Cipta](#-lisensi)

---

## 📖 Tentang Aplikasi

**PilahKu** adalah platform informasi dan gamifikasi pemilahan sampah berbasis web yang dirancang khusus untuk civitas akademika Telkom University. Aplikasi ini memfasilitasi mahasiswa, dosen, dan staf kampus untuk:
* Memilah sampah secara tepat sesuai kategori, warna tempat sampah, dan panduan teknis 4 langkah.
* Mengetahui jadwal rotasi pengangkutan sampah harian dan mengatur pengingat notifikasi.
* Menemukan titik tempat sampah terdekat di area kampus via peta interaktif berbasis Leaflet.js.
* Mencatat aktivitas pemilahan sampah dengan bukti foto.
* Memperoleh reward point atas kontribusi pemilahan sampah yang tervalidasi oleh petugas kebersihan kampus.

---

## 🎯 Latar Belakang & SDGs 12

Aplikasi ini dikembangkan selaras dengan tujuan **Tujuan Pembangunan Berkelanjutan (Sustainable Development Goals / SDGs) Nomor 12: Konsumsi dan Produksi yang Bertanggung Jawab**, khususnya:
* **Target 12.5**: Mengurangi produksi limbah secara substansial melalui pencegahan, pengurangan, daur ulang, dan penggunaan kembali.
* **Target 12.8**: Menjamin bahwa masyarakat di mana pun memiliki informasi dan kesadaran yang relevan untuk pembangunan berkelanjutan dan gaya hidup yang selaras dengan alam.

---

## 👥 Tim Pengembang (Kelompok BC - SI4802)

| No | Nama Lengkap | NIM | Peran Utama |
| :---: | :--- | :---: | :--- |
| 1 | **Rayhan Aliffio Wibowo** | `102022500103` | Developer |
| 2 | **Ali Rahman Bayanaka** | `102022400053` | Full-Stack Developer & UI/UX Specialist |
| 3 | **Fahthur Rizki Rahmadi** | `102022580007` | Developer |
| 4 | **Dhiny Setya** | `102022400172` | Developer |
| 5 | **Zahra** | `102022400022` | Developer |
| 6 | **Dea** | `10202240403` | Developer |

---

## 🔑 Kredensial Akun Demo (Default Credentials)

Sistem telah dilengkapi data awal (seed) dengan 3 peran berbeda. Seluruh akun menggunakan kata sandi standar: **`password123`**

| Peran (Role) | Nama Pengguna | Email Login | Password | Hak Akses Utama |
| :--- | :--- | :--- | :--- | :--- |
| 🛡️ **Admin** | Admin PilahKu | `admin@telkomuniversity.ac.id` | `password123` | Kelola Kategori, Kelola Jadwal, Aturan Reward, Validasi |
| 👷 **Petugas** | Rina Pratiwi | `petugas@telkomuniversity.ac.id` | `password123` | Validasi & Koreksi Setoran Pemilahan Sampah |
| 🎓 **Mahasiswa** | Nadia Putri | `nadiaputri@student.telkomuniversity.ac.id` | `password123` | Poin Saya, Riwayat Poin, Jadwal, Pengingat, Panduan, Peta, Setor Sampah |

---

## 🚀 Matriks Fitur & Product Backlog Items (PBI)

| ID PBI | Nama Fitur | Peran | Status | Deskripsi Singkat |
| :---: | :--- | :---: | :---: | :--- |
| **PBI-01** | Registrasi Civitas Kampus | Tamu | ✅ Selesai | Pendaftaran akun dengan validasi ketat email Telkom University (`@student.telkomuniversity.ac.id` atau `@telkomuniversity.ac.id`). |
| **PBI-02** | Login & Profil Multi-Peran | Semua | ✅ Selesai | Autentikasi multi-role (Civitas, Petugas, Admin), pengaturan profil, dan ganti kata sandi. |
| **PBI-03** | Pencarian Cepat Sampah | Civitas | ✅ Selesai | Pencarian jenis sampah untuk menentukan tempat pembuangan yang tepat secara instan. |
| **PBI-04** | Kelola Kategori Sampah (CRUD) | Admin | ✅ Selesai | Tambah, ubah, dan hapus kategori sampah, kode warna tempat sampah, dan karakteristiknya. |
| **PBI-05** | Panduan Pemilahan Sampah | Civitas | ✅ Selesai | Edukasi 3 langkah pemilahan, kartu kategori, daftar kesalahan umum, dan arti warna tong sampah. |
| **PBI-06** | Detail Kategori Sampah | Civitas | ✅ Selesai | Detail mendalam: 8 contoh item berilustrasi, karakteristik, kriteria diterima/tidak, alur 4 langkah penanganan, dan siklus pasca buang. |
| **PBI-07** | Kelola Jadwal Pengangkutan (CRUD) | Admin | ✅ Selesai | Manajemen jadwal pengangkutan per area kampus, frekuensi rotasi (3 hari/mingguan), dan jam operasional. |
| **PBI-08** | Jadwal Pengangkutan Sampah | Civitas | ✅ Selesai | Tampilan jadwal aktif harian, hitung mundur truk pengangkut, kalender 7 hari, dan status pengangkutan per area. |
| **PBI-09** | Pengingat Jadwal Pengangkutan | Civitas | ✅ Selesai | Konfigurasi pengingat (notifikasi pagi, sebelum angkut, rekap mingguan), channel notifikasi, dan titik favorit. |
| **PBI-10** | Alur Pengelolaan Sampah | Civitas | ✅ Selesai | Visualisasi alur sampah dari tempat pembuangan awal hingga pemrosesan akhir / bank sampah kampus. |
| **PBI-11** | Peta Interaktif Tempat Sampah | Civitas | ✅ Selesai | Peta kampus berbasis Leaflet.js dengan filter kategori sampah dan penanda koordinat lokasi presisi. |
| **PBI-12** | Detail Titik Tempat Sampah | Civitas | ✅ Selesai | Informasi detail lokasi tempat sampah, foto fisik, jam operasional, dan integrasi penunjuk arah Google Maps. |
| **PBI-13** | Catat Aktivitas Pemilahan | Civitas | ✅ Selesai | Pengajuan bukti pemilahan sampah dengan unggah foto dan input jumlah barang/berat untuk klaim reward point. |
| **PBI-14** | Riwayat Aktivitas Pemilahan | Civitas | ✅ Selesai | Daftar pengajuan pemilahan dengan filter status (*Menunggu*, *Terverifikasi*, *Ditolak*). |
| **PBI-15** | Validasi Pemilahan Sampah | Petugas & Admin | ✅ Selesai | Halaman petugas untuk memverifikasi foto, menyetujui, menolak, atau memberi koreksi pada aktivitas pemilahan. |
| **PBI-16** | Aturan Reward Point (CRUD) | Admin | ✅ Selesai | Pengaturan bobot poin reward per kategori sampah, batas poin harian, dan syarat verifikasi minimum. |
| **PBI-17** | Saldo Reward Point (Poin Saya) | Civitas | ✅ Selesai | Dashboard saldo poin, ringkasan perolehan bulanan, chart bar mingguan, level badge (*Eco Champion*), dan transaksi terkini. |
| **PBI-18** | Riwayat Transaksi Reward Point | Civitas | ✅ Selesai | Buku besar saldo poin dengan filter kategori (Semua, Masuk, Koreksi), running saldo, dan pencarian transaksi. |

---

## 🎨 Fitur Unggulan & Pembaruan UI/UX

1. **Desain Modern Tema Eco-Green Kampus**:
   - Skema warna hijau alami ramah lingkungan (`#1fa959`, `#143e2b`, emerald/mint tints) yang mencerminkan semangat kampus hijau berkelanjutan.
   - Tipografi modern Inter/Plus Jakarta Sans dengan hierarki kontras tinggi dan garis tepi tipis (1px border).

2. **Stationary Sidebar & Independent Scroll Content**:
   - Sidebar navigasi desktop dan Navbar atas bersifat statis (terkunci di tempat), sehingga navigasi tetap dapat diakses tanpa bergeser.
   - Area konten utama di sebelah kanan memiliki mekanisme scroll mandiri (`overflow-y-auto`), menciptakan pengalaman navigasi yang mulus seperti aplikasi web modern (SPA-like feel).

3. **Presisi 1-ke-1 Sesuai Dokumen Referensi Desain (`referensi_isi/`)**:
   - `6.1 · Poin Saya – Saldo Reward Point (PBI-17)`: Banner saldo hijau gelap, kartu stat mingguan, grafik bar interaktif, dan transaksi terbaru.
   - `6.2 · Riwayat Transaksi Reward Point (PBI-18)`: Kartu ringkasan poin, pill tab filter, pencarian, dan tabel buku besar running balance.
   - `3.1 · Jadwal Pengangkutan Sampah (PBI-08)`: Banner jadwal aktif dengan hitung mundur, row kalender 7 hari, tabel status area, dan kartu pengingat.
   - `3.2 · Pengingat Jadwal Pengangkutan (PBI-09)`: Banner switch pengingat aktif, preferensi waktu pengingat, opsi channel, dan pratinjau kartu notifikasi.
   - `3.3 · Admin – Kelola Jadwal (PBI-07 CRUD)`: Tampilan panel ganda (tabel daftar jadwal di kiri dan formulir edit jadwal di kanan).
   - `6.3 · Admin – Aturan Reward Point (PBI-16 CRUD)`: Manajemen aturan poin dengan kode `RWD-xx`, status aktif/nonaktif, dan formulir pengeditan.
   - `Group 11 · Panduan & Kategori (PBI-04, 05, 06)`: Panduan 3 langkah, kartu kategori, 8 item contoh berilustrasi, karakteristik, alur penanganan 4 tahap, dan panel admin kategori.

---

## 🗺️ Daftar Rute & Endpoint Aplikasi

### 1. Rute Publik (Tamu)
* `GET /` — Halaman depan / Landing Page PilahKu
* `GET /login` — Form login multi-role
* `POST /login` — Proses autentikasi
* `GET /register` — Form pendaftaran civitas akademika
* `POST /register` — Simpan pendaftaran akun civitas

### 2. Rute Civitas Akademika (Mahasiswa / Dosen / Staf)
* `GET /dashboard` — Dashboard utama civitas
* `GET /poin` — Halaman Saldo Reward Point (*Poin Saya* - PBI-17)
* `GET /poin/riwayat` — Riwayat Transaksi Reward Point (PBI-18)
* `GET /jadwal` — Jadwal Pengangkutan Sampah Aktif (PBI-08)
* `GET /jadwal/pengingat` — Pengaturan Notifikasi & Pengingat Jadwal (PBI-09)
* `POST /jadwal/pengingat` — Simpan preferensi pengingat
* `GET /panduan` — Panduan Edukasi Pemilahan Sampah (PBI-05)
* `GET /panduan/{id}` — Detail Kategori Sampah & Alur Penanganan (PBI-06)
* `GET /peta` — Peta Interaktif Titik Tempat Sampah (PBI-11 & PBI-12)
* `GET /aktivitas/create` — Form Pencatatan Pemilahan Sampah (PBI-13)
* `POST /aktivitas` — Kirim pengajuan pemilahan sampah
* `GET /aktivitas/riwayat` — Riwayat status pengajuan pemilahan (PBI-14)
* `GET /profil` — Pengaturan profil dan kata sandi

### 3. Rute Petugas Kebersihan & Admin
* `GET /admin/validasi` — Antrean validasi setoran pemilahan sampah (PBI-15)
* `POST /admin/validasi/{id}` — Verifikasi / tolak setoran sampah

### 4. Rute Khusus Administrator
* `GET /admin/kategori` — Kelola Kategori Sampah (PBI-04)
* `POST /admin/kategori` — Tambah kategori baru
* `PUT /admin/kategori/{id}` — Perbarui kategori sampah
* `DELETE /admin/kategori/{id}` — Hapus kategori sampah
* `GET /admin/jadwal` — Kelola Jadwal Pengangkutan (PBI-07)
* `POST /admin/jadwal` — Tambah jadwal pengangkutan
* `PUT /admin/jadwal/{id}` — Perbarui jadwal pengangkutan
* `DELETE /admin/jadwal/{id}` — Hapus jadwal pengangkutan
* `GET /admin/reward` — Kelola Aturan Reward Point (PBI-16)
* `POST /admin/reward` — Tambah aturan reward
* `PUT /admin/reward/{id}` — Perbarui aturan reward

---

## 📁 Struktur Direktori Proyek

```text
SI4802-KELBC/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/
│   │   │   │   ├── AturanRewardController.php   # Controller Aturan Poin Admin (PBI-16)
│   │   │   │   ├── JadwalController.php         # Controller Kelola Jadwal Admin (PBI-07)
│   │   │   │   ├── KategoriController.php       # Controller Kategori Admin (PBI-04)
│   │   │   │   └── ValidasiController.php       # Controller Validasi Petugas/Admin (PBI-15)
│   │   │   ├── AktivitasController.php          # Controller Setor Sampah Civitas (PBI-13, 14)
│   │   │   ├── AuthController.php               # Controller Login & Registrasi (PBI-01, 02)
│   │   │   ├── DashboardController.php          # Controller Ringkasan Dashboard
│   │   │   ├── JadwalController.php             # Controller Jadwal & Pengingat (PBI-08, 09)
│   │   │   ├── PanduanController.php            # Controller Edukasi & Detail (PBI-05, 06)
│   │   │   ├── PetaController.php               # Controller Peta Interaktif (PBI-11, 12)
│   │   │   ├── PoinController.php               # Controller Poin & Riwayat (PBI-17, 18)
│   │   │   └── ProfilController.php             # Controller Profil Pengguna
│   │   └── Middleware/
│   │       └── EnsureRole.php                   # Middleware Otorisasi Multi-Peran
│   └── Models/
│       ├── AktivitasPemilahan.php
│       ├── AturanReward.php
│       ├── JadwalPengangkutan.php
│       ├── KategoriSampah.php
│       ├── LokasiTempatSampah.php
│       ├── PengingatJadwal.php
│       ├── TransaksiPoin.php
│       └── User.php
├── database/
│   ├── migrations/                              # Skema database relasional
│   └── seeders/                                 # Dummy data bawaan (Admin, Petugas, Civitas)
├── Documentations/                              # Catatan kelompok & NIM
├── referensi_isi/                               # Mockup & referensi UI asli
├── resources/
│   ├── css/
│   │   └── app.css                              # Tailwind CSS v4 konfigurasi tema
│   ├── js/
│   │   └── app.js                               # Script frontend
│   └── views/
│       ├── admin/                               # Blade view untuk area admin & petugas
│       ├── auth/                                # Blade view login, register, profil
│       ├── components/                          # Blade UI reusable components
│       ├── layouts/                             # Layout utama (app.blade.php & guest.blade.php)
│       └── pages/                               # Halaman civitas (poin, jadwal, panduan, peta)
├── routes/
│   └── web.php                                  # Definisi rute web aplikasi
├── tests/
│   └── Feature/ExampleTest.php                  # Pengujian otomatis rute dan peran
└── README.md                                    # Dokumentasi resmi proyek
```

---

## 🛠️ Teknologi yang Digunakan

* **Backend Framework**: [Laravel 12.x](https://laravel.com/) (PHP 8.2+)
* **Database**: MySQL / MariaDB (via Laragon / XAMPP)
* **Frontend CSS Engine**: [Tailwind CSS v4](https://tailwindcss.com/)
* **Asset Bundler**: [Vite](https://vitejs.dev/)
* **Peta Interaktif**: [Leaflet.js](https://leafletjs.com/) & OpenStreetMap Tiles
* **Iconography**: [Heroicons](https://heroicons.com/) (Inline SVG)
* **Automated Testing**: PHPUnit / Pest Testing Framework

---

## 💻 Panduan Instalasi & Menjalankan Proyek

### 1. Kebutuhan Perangkat Lunak
* **PHP** versi 8.2 atau lebih tinggi dengan ekstensi `pdo_mysql`, `mbstring`, `openssl`, `curl`.
* **Composer** versi 2.x
* **Node.js** versi 18.x atau 20.x dan **NPM**
* **MySQL / MariaDB Server** (disarankan menggunakan stack **Laragon** di Windows)

### 2. Langkah Instalasi Langkah-demi-Langkah

1. **Clone Repositori**:
   ```bash
   git clone https://github.com/SI4802-PPL-KelompokBC/SI4802-KELBC.git
   cd SI4802-KELBC
   ```

2. **Instalasi Paket PHP & Node**:
   ```bash
   composer install
   npm install
   ```

3. **Konfigurasi Lingkungan (`.env`)**:
   Salin berkas `.env.example` menjadi `.env`:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
   Pastikan pengaturan koneksi database di `.env` sesuai dengan server lokal Anda:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=si4802_kelbc
   DB_USERNAME=root
   DB_PASSWORD=
   ```

4. **Jalankan Migrasi Database & Seeder**:
   Buat database bernama `si4802_kelbc` pada database manager Anda (HeidiSQL/phpMyAdmin), kemudian jalankan:
   ```bash
   php artisan migrate:fresh --seed
   ```
   *Perintah ini akan membuat semua tabel dan mengisi akun bawaan (Admin, Petugas, Mahasiswa), kategori sampah, titik peta, jadwal, dan aturan reward.*

5. **Kompilasi Aset Frontend (Tailwind CSS)**:
   * Untuk pengembangan dengan live-reload:
     ```bash
     npm run dev
     ```
   * Untuk kompilasi bundle produksi:
     ```bash
     npm run build
     ```

6. **Jalankan Server Lokal Laravel**:
   ```bash
   php artisan serve
   ```
   Buka peramban dan akses alamat:
   **`http://127.0.0.1:8000`**

---

## 🧪 Menjalankan Pengujian Otomatis

Aplikasi telah dilengkapi pengujian otomatis untuk memverifikasi fungsionalitas rute, akses per role, dan endpoint utama:

```bash
php artisan test
```

Contoh hasil pengujian:
```text
   PASS  Tests\Unit\ExampleTest
  ✓ that true is true

   PASS  Tests\Feature\ExampleTest
  ✓ the application returns a successful response
  ✓ civitas can access dashboard and poin
  ✓ admin can access kategori admin
  ✓ petuagas or admin can access validasi
  ✓ civitas can access jadwal pengingat and poin riwayat
  ✓ civitas can access panduan detail

  Tests:    7 passed (45 assertions)
  Duration: 0.85s
```

---

## 📄 Lisensi

Proyek aplikasi **PilahKu** ini dikembangkan sebagai pemenuhan tugas akademik mata kuliah **SI4802 Pengembangan Perangkat Lunak**, Program Studi Sistem Informasi, Fakultas Rekayasa Industri, **Telkom University**.

Hak cipta dilindungi oleh **Kelompok BC — SI4802 (Tahun Akademik 2024/2026)**.
Semua hak dilindungi undang-undang.
