<?php

namespace Tests\Feature;

use App\Models\Pengguna;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_routes_render_successfully(): void
    {
        $this->get('/')->assertRedirect('/login');
        
        $loginRes = $this->get('/login');
        $loginRes->assertStatus(200);
        $loginRes->assertSee('Banner-Telkom-University.jpg');
        $loginRes->assertSee('PilahKu');

        $registerRes = $this->get('/register');
        $registerRes->assertStatus(200);
        $registerRes->assertSee('Daftar Akun PilahKu');
    }

    public function test_civitas_pages_render_successfully(): void
    {
        $this->seed(DatabaseSeeder::class);

        $user = Pengguna::where('peran', 'mahasiswa')->first();
        $this->actingAs($user);

        $this->get('/dashboard')->assertStatus(200)->assertSee('Beranda');
        $this->get('/peta')->assertStatus(200)->assertSee('Peta');
        $this->get('/peta/data')->assertStatus(200);
        $this->get('/aktivitas')->assertStatus(200)->assertSee('Riwayat Aktivitas');
        $this->get('/aktivitas/create')->assertStatus(200)->assertSee('Kategori Sampah');
        $this->get('/profil')->assertStatus(200)->assertSee('Profil');
        $this->get('/profil/edit')->assertStatus(200)->assertSee('Pengaturan Profil');
        $this->get('/jadwal')->assertStatus(200)->assertSee('Jadwal');
        $this->get('/jadwal/pengingat')->assertStatus(200)->assertSee('Pengingat');
        $this->get('/poin')->assertStatus(200)->assertSee('Poin');
        $this->get('/poin/riwayat')->assertStatus(200)->assertSee('Riwayat Transaksi');
        $this->get('/panduan')->assertStatus(200)->assertSee('Panduan');
        $this->get('/panduan/1')->assertStatus(200)->assertSee('Sampah');
        $this->get('/alur')->assertStatus(200)->assertSee('Alur');
    }

    public function test_admin_pages_render_successfully(): void
    {
        $this->seed(DatabaseSeeder::class);

        $admin = Pengguna::where('peran', 'admin')->first();
        $this->actingAs($admin);
        
        $this->get('/admin/validasi')->assertStatus(200)->assertSee('Validasi');
        $this->get('/admin/kategori')->assertStatus(200)->assertSee('Kelola Kategori');
        $this->get('/admin/lokasi')->assertStatus(200)->assertSee('Kelola Lokasi');
        $this->get('/admin/jadwal')->assertStatus(200)->assertSee('Kelola Jadwal');
        $this->get('/admin/reward')->assertStatus(200)->assertSee('Reward');
    }
}
