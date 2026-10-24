<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KategoriSampah;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

/** PBI-04 - CRUD kategori sampah (admin). Kategori dinonaktifkan, bukan dihapus. */
class KategoriController extends Controller
{
    public function index()
    {
        return view('pages.table', [
            'title' => 'Kelola Kategori Sampah',
            'subtitle' => 'Tambah, ubah, atau nonaktifkan kategori yang tampil di panduan dan pencarian.',
            'columns' => ['Kode', 'Kategori', 'Status', 'Aksi'],
            'rows' => KategoriSampah::all()->map(fn ($k) => [
                $k->kode, $k->nama_kategori, ucfirst($k->status),
                ['post' => route('admin.kategori.toggle', $k), 'label' => $k->status === 'aktif' ? 'Nonaktifkan' : 'Aktifkan'],
            ])->all(),
        ]);
    }

    public function store(Request $request)
    {
        KategoriSampah::create($this->rules($request) + ['status' => 'aktif']);

        return back()->with('status', 'Kategori ditambahkan.');
    }

    public function update(Request $request, KategoriSampah $kategori)
    {
        $kategori->update($this->rules($request, $kategori));

        return back()->with('status', 'Kategori diperbarui.');
    }

    public function toggle(KategoriSampah $kategori)
    {
        $kategori->update(['status' => $kategori->status === 'aktif' ? 'nonaktif' : 'aktif']);

        return back()->with('status', 'Status kategori diperbarui.');
    }

    private function rules(Request $request, ?KategoriSampah $k = null): array
    {
        return $request->validate([
            'nama_kategori' => ['required', 'string', 'max:50'],
            'kode' => ['required', 'string', 'max:10', Rule::unique('kategori_sampah', 'kode')->ignore($k?->id_kategori, 'id_kategori')],
            'warna_label' => ['nullable', 'string', 'max:20'],
            'deskripsi' => ['nullable', 'string'],
            'karakteristik' => ['nullable', 'string'],
            'cara_pembuangan' => ['nullable', 'string'],
        ]);
    }
}
