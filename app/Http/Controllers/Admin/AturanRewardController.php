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
        return view('pages.table', [
            'title' => 'Aturan Reward Point',
            'subtitle' => 'Aturan hanya berlaku untuk aktivitas terverifikasi.',
            'columns' => ['Aturan', 'Kategori', 'Jenis', 'Nilai', 'Batas/hari', 'Status', 'Aksi'],
            'rows' => AturanReward::with('kategori')->get()->map(fn ($a) => [
                $a->nama_aturan, $a->kategori?->nama_kategori ?? '-', ucfirst($a->jenis), $a->poin_per_satuan,
                $a->batas_per_hari ?? '-', ucfirst($a->status),
                ['post' => route('admin.reward.toggle', $a), 'label' => $a->status === 'aktif' ? 'Nonaktifkan' : 'Aktifkan'],
            ])->all(),
        ]);
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
