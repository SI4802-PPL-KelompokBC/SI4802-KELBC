<?php

return [
    // Siklus pembuangan 3 hari (urutan kode kategori) dan tanggal hari pertama siklus.
    // Contoh: 11 Okt 2026 = Plastik, 12 Okt = Organik, 13 Okt = Kertas (sesuai mockup).
    "cycle_order" => ["ORG", "KRT", "PLS"],
    "cycle_start" => env("PILAHKU_CYCLE_START", "2026-10-09"),

    // Domain email kampus yang diizinkan saat registrasi.
    "email_regex" => "/@(student\\.)?telkomuniversity\\.ac\\.id$/i",
];
