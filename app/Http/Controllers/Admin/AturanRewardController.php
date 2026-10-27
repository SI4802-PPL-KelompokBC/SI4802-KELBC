<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AturanReward;
use Illuminate\Http\Request;

/**
 * PBI-16 - CRUD aturan reward point (admin).
 * Perubahan aturan hanya berlaku untuk aktivitas berikutnya; transaksi yang sudah tercatat tidak berubah.
 */
class AturanRewardController extends Controller
{
    public function index()
    {
        $rewards = AturanReward::with('kategori')->get();
        $kategoris = \App\Models\KategoriSampah::aktif()->get();

        return view('admin.reward', compact('rewards', 'kategoris'));
    }

    public function store(Request $request)
    {
        AturanReward::create($this->validated($request) + ['status' => 'aktif']);

        return back()->with('status', 'Aturan disimpan.');
    }

    public function update(Request $request, AturanReward $reward)
    {
        $reward->update($this->validated($request));

        return back()->with('status', 'Aturan diperbarui.');
    }

    public function toggle(AturanReward $reward)
    {
        $reward->update(['status' => $reward->status === 'aktif' ? 'nonaktif' : 'aktif']);

        return back()->with('status', 'Status aturan diperbarui.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'nama_aturan' => ['required', 'string', 'max:100'],
            'id_kategori' => ['nullable', 'exists:kategori_sampah,id_kategori'],
            'jenis' => ['required', 'in:penambahan,pengurangan'],
            'poin_per_satuan' => ['required', 'integer', 'min:1', 'max:1000'],
            'batas_per_hari' => ['nullable', 'integer', 'min:1'],
        ]);
    }
}
