<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'PilahKu - Telkom University' }}</title>
    
    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full bg-slate-50 font-sans text-slate-800 antialiased selection:bg-emerald-600 selection:text-white">
<div class="min-h-screen flex flex-col lg:flex-row">
    <!-- Left Hero Banner: Telkom University Split Screen -->
    <div class="relative hidden lg:flex lg:w-1/2 xl:w-7/12 flex-col justify-between overflow-hidden bg-slate-950 p-12 text-white">
        <!-- University Banner Background Image -->
        <img 
            src="{{ asset('picture/Banner-Telkom-University.jpg') }}" 
            alt="Telkom University Campus" 
            class="absolute inset-0 h-full w-full object-cover object-center opacity-40 scale-105 transition-transform duration-1000 ease-out hover:scale-100"
        />
        
        <!-- Gradient Overlays for Readability and Brand Aesthetics (Green & Dark Forest Tint) -->
        <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/80 to-emerald-950/50"></div>
        <div class="absolute inset-0 bg-gradient-to-r from-slate-950/90 via-transparent to-slate-950/40"></div>

        <!-- Top Header in Banner -->
        <div class="relative z-10 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-gradient-to-br from-emerald-600 to-teal-700 shadow-lg shadow-emerald-950/40 border border-white/20">
                    <svg class="w-6 h-6 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M7 19H4.815a1.83 1.83 0 0 1-1.57-.881 1.785 1.785 0 0 1-.004-1.784L7.196 9.5"/>
                        <path d="M11 19h8.203a1.83 1.83 0 0 0 1.556-.89 1.784 1.784 0 0 0 0-1.775l-1.226-2.12"/>
                        <path d="m14 16-3 3 3 3"/>
                        <path d="M8.293 13.596 11 9l2.707 4.596"/>
                        <path d="m9.67 4.14 1.77-3.07a1.83 1.83 0 0 1 3.12 0l4.246 7.36"/>
                    </svg>
                </div>
                <div>
                    <span class="text-xl font-bold tracking-tight text-white flex items-center gap-1.5">
                        Pilah<span class="text-emerald-400">Ku</span>
                    </span>
                    <span class="block text-xs font-medium text-slate-300 tracking-wider uppercase">Telkom University</span>
                </div>
            </div>

            <span class="inline-flex items-center gap-1.5 rounded-full bg-white/10 px-3 py-1 text-xs font-medium text-emerald-300 backdrop-blur-md border border-white/15">
                <span class="h-2 w-2 rounded-full bg-emerald-400 animate-pulse"></span>
                Kampus Hijau Berkelanjutan
            </span>
        </div>

        <!-- Center Quote / Mission Statement -->
        <div class="relative z-10 my-auto max-w-xl py-12">
            <div class="mb-4 inline-flex items-center gap-2 rounded-lg bg-emerald-600/20 px-3 py-1 text-xs font-semibold uppercase tracking-wider text-emerald-400 border border-emerald-500/30">
                Inisiatif Zero-Waste Kampus
            </div>
            <h1 class="text-3xl font-extrabold tracking-tight text-white sm:text-4xl lg:text-5xl leading-tight">
                Pilah sampahmu, kumpulkan poin, wujudkan kampus hijau.
            </h1>
            <p class="mt-4 text-base text-slate-300 leading-relaxed">
                Bergabung bersama civitas academica Telkom University yang membiasakan pemilahan sampah organik, anorganik, dan daur ulang langsung dari sumbernya.
            </p>

            <!-- Stat Counters in Banner -->
            <div class="mt-8 grid grid-cols-3 gap-4 border-t border-white/15 pt-6">
                <div>
                    <div class="text-2xl font-bold text-white tracking-tight">100%</div>
                    <div class="text-xs text-slate-400">Pilah Terintegrasi</div>
                </div>
                <div>
                    <div class="text-2xl font-bold text-white tracking-tight">Real-time</div>
                    <div class="text-xs text-slate-400">Peta & Titik Drop</div>
                </div>
                <div>
                    <div class="text-2xl font-bold text-white tracking-tight">Poin Reward</div>
                    <div class="text-xs text-slate-400">Tukar & Berdampak</div>
                </div>
            </div>
        </div>

        <!-- Banner Footer -->
        <div class="relative z-10 flex items-center justify-between text-xs text-slate-400 border-t border-white/10 pt-4">
            <p>&copy; {{ date('Y') }} Telkom University &bull; Sistem Informasi Pemilahan Sampah</p>
            <span class="text-slate-500">SI-48-02 Kelompok BC</span>
        </div>
    </div>

    <!-- Right Content Area (Auth Forms) -->
    <div class="flex flex-1 flex-col justify-center px-4 py-8 sm:px-6 lg:px-12 xl:px-16 bg-white min-h-screen">
        <!-- Mobile Top Brand Header -->
        <div class="lg:hidden mb-6 flex flex-col items-center text-center">
            <div class="relative w-full h-32 rounded-2xl overflow-hidden mb-4 shadow-md">
                <img 
                    src="{{ asset('picture/Banner-Telkom-University.jpg') }}" 
                    alt="Telkom University" 
                    class="w-full h-full object-cover"
                />
                <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/60 to-transparent"></div>
                <div class="absolute bottom-3 left-4 right-4 flex items-center justify-between text-white">
                    <div class="flex items-center gap-2">
                        <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-emerald-600 font-bold text-sm shadow">
                            P
                        </div>
                        <div class="text-left">
                            <span class="font-bold text-sm">Pilah<span class="text-emerald-400">Ku</span></span>
                            <span class="block text-[10px] text-slate-300">Telkom University</span>
                        </div>
                    </div>
                    <span class="text-[10px] bg-emerald-500/30 text-emerald-300 px-2 py-0.5 rounded-full border border-emerald-400/30">Kampus Hijau</span>
                </div>
            </div>
        </div>

        <div class="mx-auto w-full max-w-md">
            @include('partials.flash')
            @yield('content')
        </div>
    </div>
</div>
</body>
</html>
