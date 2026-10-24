<?php

use Illuminate\Support\Facades\Schedule;

// Pengingat jadwal pembuangan (PBI-09). Di server: * * * * * php artisan schedule:run
Schedule::command('pilahku:kirim-pengingat')->everyMinute()->withoutOverlapping();
