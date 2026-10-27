<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JadwalPengangkutan;
use Illuminate\Http\Request;

/** PBI-07 - CRUD jadwal pengangkutan (admin). */
class JadwalController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status');
        $schedules = JadwalPengangkutan::with(['kategori', 'lokasi'])
            ->when($status, fn ($q) => $q->where('status', $status))
            ->get();

        $kategoris = \App\Models\KategoriSampah::aktif()->get();
        $lokasis = \App\Models\LokasiTempatSampah::aktif()->get();

        return view('admin.jadwal', compact('schedules', 'kategoris', 'lokasis'));
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
