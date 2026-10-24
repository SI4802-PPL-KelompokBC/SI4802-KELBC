@php
    $map = [
        'menunggu' => ['Menunggu Validasi', 'bg-amber-100 text-amber-800'],
        'terverifikasi' => ['Terverifikasi', 'bg-green-100 text-green-800'],
        'ditolak' => ['Ditolak', 'bg-red-100 text-red-800'],
    ];
    [$label, $cls] = $map[$status] ?? [ucfirst($status), 'bg-slate-100 text-slate-700'];
@endphp
<span class="rounded-full px-2 py-0.5 text-xs font-medium {{ $cls }}">{{ $label }}</span>
