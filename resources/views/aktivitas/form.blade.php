@extends('layouts.app', ['title' => $aktivitas->exists ? 'Edit Pengajuan' : 'Catat Aktivitas Pemilahan'])

@section('content')
<div class="mx-auto max-w-3xl space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <div class="flex items-center gap-2 text-xs font-semibold uppercase tracking-wider text-slate-400 mb-1">
                <a href="{{ route('aktivitas.index') }}" class="hover:text-slate-600 transition">&larr; Kembali ke Riwayat</a>
                <span>&bull;</span>
                <span class="text-emerald-600 font-bold">Form Catat</span>
            </div>
            <h2 class="text-2xl font-extrabold text-slate-900 tracking-tight">
                {{ $aktivitas->exists ? 'Edit Pengajuan ' . $aktivitas->kode : 'Form Catat Pemilahan Sampah' }}
            </h2>
            <p class="mt-1 text-xs sm:text-sm text-slate-500">
                Unggah bukti pemilahan sampah Anda secara jujur. Poin reward akan otomatis ditambahkan setelah divalidasi petugas.
            </p>
        </div>
    </div>

    @if ($kategoriHariIni)
        <div class="flex items-center gap-3 rounded-2xl bg-emerald-50 border border-emerald-200/80 p-4 text-xs sm:text-sm text-emerald-900 shadow-2xs">
            <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-xl bg-emerald-600 text-white font-bold">
                ✓
            </span>
            <div>
                <span class="font-bold">Prioritas Jadwal Hari Ini:</span>
                Sampah <b>{{ $kategoriHariIni->nama_kategori }}</b> sedang dalam jadwal pengangkutan aktif kampus.
            </div>
        </div>
    @endif

    <!-- Main Form Card -->
    <form 
        method="POST" 
        enctype="multipart/form-data" 
        class="space-y-6 rounded-3xl bg-white p-6 sm:p-8 border border-slate-200/80 shadow-xs"
        action="{{ $aktivitas->exists ? route('aktivitas.update', $aktivitas) : route('aktivitas.store') }}"
    >
        @csrf
        @if ($aktivitas->exists) 
            @method('PUT') 
        @endif

        <!-- Step 1: Kategori Sampah (Visual Cards) -->
        <div>
            <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                1. Pilih Kategori Sampah <span class="text-emerald-600">*</span>
            </label>
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                @foreach ($kategori as $k)
                    @php $checked = old('id_kategori', $aktivitas->id_kategori) == $k->id_kategori; @endphp
                    <label class="relative flex flex-col justify-between rounded-2xl border p-4 cursor-pointer transition-all duration-200 hover:border-emerald-400 {{ $checked ? 'border-emerald-600 bg-emerald-50/40 shadow-xs' : 'border-slate-200 bg-slate-50/50' }}">
                        <input 
                            type="radio" 
                            name="id_kategori" 
                            value="{{ $k->id_kategori }}" 
                            @checked($checked) 
                            required
                            class="sr-only"
                            onchange="document.querySelectorAll('input[name=id_kategori]').forEach(r => r.closest('label').classList.remove('border-emerald-600', 'bg-emerald-50/40', 'shadow-xs')); this.closest('label').classList.add('border-emerald-600', 'bg-emerald-50/40', 'shadow-xs')"
                        >
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-xs font-bold text-slate-900">{{ $k->nama_kategori }}</span>
                            <span class="text-[10px] font-mono font-bold text-slate-500 bg-white px-1.5 py-0.5 rounded border border-slate-200">{{ $k->kode }}</span>
                        </div>
                        <p class="text-[11px] text-slate-500 line-clamp-2 leading-relaxed">{{ $k->deskripsi }}</p>
                    </label>
                @endforeach
            </div>
            @error('id_kategori')
                <p class="mt-1.5 text-xs font-medium text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Step 2: Lokasi Tempat Sampah -->
        <div>
            <label for="id_lokasi" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                2. Lokasi Tempat Sampah <span class="text-emerald-600">*</span>
            </label>
            <select 
                id="id_lokasi"
                name="id_lokasi" 
                required 
                class="block w-full rounded-xl border border-slate-200 bg-slate-50/50 px-3.5 py-2.5 text-sm text-slate-800 transition focus:border-emerald-600 focus:bg-white focus:outline-none focus:ring-4 focus:ring-emerald-500/10 @error('id_lokasi') border-red-500 bg-red-50/30 @enderror"
            >
                @foreach ($lokasi as $l)
                    <option value="{{ $l->id_lokasi }}" @selected(old('id_lokasi', $aktivitas->id_lokasi) == $l->id_lokasi)>
                        [{{ $l->kode_titik }}] {{ $l->nama_lokasi }} &bull; Menerima: {{ $l->kategori->pluck('nama_kategori')->implode(', ') }}
                    </option>
                @endforeach
            </select>
            @error('id_lokasi')
                <p class="mt-1.5 text-xs font-medium text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Step 3: Tanggal & Jumlah Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label for="tanggal_waktu" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                    Tanggal & Waktu Pembuangan <span class="text-emerald-600">*</span>
                </label>
                <input 
                    type="datetime-local" 
                    id="tanggal_waktu"
                    name="tanggal_waktu" 
                    value="{{ old('tanggal_waktu', optional($aktivitas->tanggal_waktu)->format('Y-m-d\TH:i')) }}" 
                    required 
                    class="block w-full rounded-xl border border-slate-200 bg-slate-50/50 px-3.5 py-2.5 text-sm text-slate-800 transition focus:border-emerald-600 focus:bg-white focus:outline-none focus:ring-4 focus:ring-emerald-500/10 @error('tanggal_waktu') border-red-500 bg-red-50/30 @enderror"
                >
                @error('tanggal_waktu')
                    <p class="mt-1.5 text-xs font-medium text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="jumlah" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                    Jumlah (Satuan: item / kg) <span class="text-emerald-600">*</span>
                </label>
                <input 
                    type="number" 
                    step="0.01" 
                    min="0.01" 
                    id="jumlah"
                    name="jumlah" 
                    value="{{ old('jumlah', $aktivitas->jumlah) }}" 
                    required 
                    placeholder="mis. 5 atau 0.75"
                    class="block w-full rounded-xl border border-slate-200 bg-slate-50/50 px-3.5 py-2.5 text-sm text-slate-800 transition focus:border-emerald-600 focus:bg-white focus:outline-none focus:ring-4 focus:ring-emerald-500/10 @error('jumlah') border-red-500 bg-red-50/30 @enderror"
                >
                @error('jumlah')
                    <p class="mt-1.5 text-xs font-medium text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Step 4: Foto Bukti Upload Area -->
        <div>
            <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                Foto Bukti Pemilahan {{ $aktivitas->exists ? '(Opsional jika tidak diubah)' : '*' }}
            </label>
            <div class="relative rounded-2xl border border-dashed border-emerald-300 bg-emerald-50/20 p-6 text-center hover:bg-emerald-50/40 transition cursor-pointer" onclick="document.getElementById('foto_bukti').click()">
                <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-2xl bg-emerald-50 text-emerald-600 mb-3">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
                <div class="text-sm font-semibold text-slate-700">
                    <span class="text-emerald-600 hover:underline">Pilih file foto</span> atau seret ke sini
                </div>
                <p class="mt-1 text-xs text-slate-400">Format JPG atau PNG, ukuran maksimal 5 MB</p>
                <input 
                    type="file" 
                    id="foto_bukti"
                    name="foto_bukti" 
                    accept="image/png,image/jpeg" 
                    class="sr-only"
                    onchange="previewImage(this)"
                >

                <!-- Live Preview -->
                <div id="preview-container" class="mt-4 {{ $aktivitas->foto_bukti ? '' : 'hidden' }}">
                    <p class="text-xs font-semibold text-slate-500 mb-1">Foto Bukti:</p>
                    <img 
                        id="preview-img" 
                        src="{{ $aktivitas->foto_bukti ? asset('storage/' . $aktivitas->foto_bukti) : '#' }}" 
                        class="mx-auto max-h-48 rounded-xl object-contain border border-slate-200 shadow-xs" 
                        alt="Bukti foto"
                    />
                </div>
            </div>
            @error('foto_bukti')
                <p class="mt-1.5 text-xs font-medium text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Step 5: Catatan Tambahan -->
        <div>
            <label for="catatan" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                Catatan Tambahan (Opsional)
            </label>
            <textarea 
                id="catatan"
                name="catatan" 
                rows="2" 
                placeholder="mis. Sampah botol plastik sudah dibilas dan dipipihkan."
                class="block w-full rounded-xl border border-slate-200 bg-slate-50/50 px-3.5 py-2.5 text-sm text-slate-800 placeholder-slate-400 transition focus:border-emerald-600 focus:bg-white focus:outline-none focus:ring-4 focus:ring-emerald-500/10"
            >{{ old('catatan', $aktivitas->catatan) }}</textarea>
            @error('catatan')
                <p class="mt-1.5 text-xs font-medium text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Step 6: Pernyataan Kejujuran -->
        <div class="rounded-2xl bg-slate-50 border border-slate-200/80 p-4">
            <label class="flex items-start gap-3 cursor-pointer text-xs sm:text-sm text-slate-700">
                <input 
                    type="checkbox" 
                    name="pernyataan" 
                    value="1" 
                    class="mt-1 h-4 w-4 rounded-md border-slate-300 text-emerald-600 focus:ring-emerald-500"
                >
                <span>Saya menyatakan dengan jujur bahwa sampah sudah dipilah sesuai kategori dan dibuang ke tempat sampah yang tepat di kawasan Telkom University.</span>
            </label>
            @error('pernyataan')
                <p class="mt-2 text-xs font-medium text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Action Buttons -->
        <div class="flex items-center justify-end gap-3 pt-2 border-t border-slate-100">
            <a 
                href="{{ route('aktivitas.index') }}" 
                class="rounded-xl border border-slate-200 bg-white px-5 py-2.5 text-xs font-bold text-slate-700 hover:bg-slate-50 transition"
            >
                Batal
            </a>
            <button 
                type="submit" 
                class="rounded-xl bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 px-6 py-2.5 text-xs font-bold text-white shadow-sm transition active:scale-98"
            >
                {{ $aktivitas->exists ? 'Simpan Perubahan' : 'Ajukan Aktivitas' }}
            </button>
        </div>
    </form>
</div>

<script>
    function previewImage(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('preview-img').src = e.target.result;
                document.getElementById('preview-container').classList.remove('hidden');
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection
