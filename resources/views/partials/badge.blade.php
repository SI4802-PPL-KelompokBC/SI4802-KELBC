@php
    $map = [
        'menunggu' => [
            'label' => 'Menunggu Validasi',
            'classes' => 'bg-amber-50 text-amber-700 border-amber-200/80',
            'dot' => 'bg-amber-500 animate-pulse',
        ],
        'terverifikasi' => [
            'label' => 'Terverifikasi',
            'classes' => 'bg-emerald-50 text-emerald-700 border-emerald-200/80',
            'dot' => 'bg-emerald-500',
        ],
        'ditolak' => [
            'label' => 'Ditolak',
            'classes' => 'bg-rose-50 text-rose-700 border-rose-200/80',
            'dot' => 'bg-rose-500',
        ],
        'aktif' => [
            'label' => 'Aktif',
            'classes' => 'bg-emerald-50 text-emerald-700 border-emerald-200/80',
            'dot' => 'bg-emerald-500',
        ],
        'nonaktif' => [
            'label' => 'Nonaktif',
            'classes' => 'bg-slate-100 text-slate-600 border-slate-200',
            'dot' => 'bg-slate-400',
        ],
    ];

    $cfg = $map[$status] ?? [
        'label' => ucfirst($status),
        'classes' => 'bg-slate-50 text-slate-700 border-slate-200',
        'dot' => 'bg-slate-400',
    ];
@endphp

<span class="inline-flex items-center gap-1.5 rounded-full border px-2.5 py-0.5 text-xs font-medium tracking-wide shadow-2xs {{ $cfg['classes'] }}">
    <span class="h-1.5 w-1.5 rounded-full {{ $cfg['dot'] }}"></span>
    {{ $cfg['label'] }}
</span>
