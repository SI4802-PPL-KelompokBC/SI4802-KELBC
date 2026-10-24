<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JadwalPengangkutan;
use Illuminate\Http\Request;

/** PBI-07 - CRUD jadwal pengangkutan (admin). */
class JadwalController extends Controller
{
    public function index()
    {
        return view('pages.table', [
            'title' => 'Kelola Jadwal Pengangkutan',
            'subtitle' => 'Jadwal yang tidak berlaku dinonaktifkan, bukan dihapus.',
            'columns' => ['Kategori', 'Lokasi', 'Hari', 'Jam angkut', 'Status', 'Aksi'],
            'rows' => JadwalPengangkutan::with(['kategori', 'lokasi'])->get()->map(fn ($j) => [
                $j->kategori->nama_kategori, $j->lokasi->nama_lokasi, $j->hari ?? 'Siklus 3 hari',
                substr($j->jam_angkut, 0, 5), ucfirst($j->status),
                ['post' => route('admin.jadwal.toggle', $j), 'label' => $j->status === 'aktif' ? 'Nonaktifkan' : 'Aktifkan'],
            ])->all(),
        ]);
    }

    public function store(Request $request)
    {
        JadwalPengangkutan::create($this->validated($request) + ['status' => 'aktif']);

        return back()->with('status', 'Jadwal disimpan.');
    }

    public function update(Request $request, JadwalPengangkutan $jadwal)
    {
        $jadwal->update($this->validated($request));

        return back()->with('status', 'Jadwal diperbarui.');
    }

    public function toggle(JadwalPengangkutan $jadwal)
    {
        $jadwal->update(['status' => $jadwal->status === 'aktif' ? 'nonaktif' : 'aktif']);

        return back()->with('status', 'Status jadwal diperbarui.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'id_kategori' => ['required', 'exists:kategori_sampah,id_kategori'],
            'id_lokasi' => ['required', 'exists:lokasi_tempat_sampah,id_lokasi'],
            'hari' => ['nullable', 'string', 'max:10'],
            'jam_angkut' => ['required', 'date_format:H:i'],
            'catatan' => ['nullable', 'string', 'max:255'],
        ]);
    }
}
