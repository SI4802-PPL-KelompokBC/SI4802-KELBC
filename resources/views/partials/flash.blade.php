@if (session('status'))
    <div id="flash-status" class="mb-6 flex items-start gap-3 rounded-2xl border border-emerald-200 bg-emerald-50/80 p-4 text-sm text-emerald-900 shadow-xs backdrop-blur-xs transition-all">
        <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-xl bg-emerald-500 text-white shadow-xs">
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg>
        </div>
        <div class="flex-1 pt-1 font-medium">
            {{ session('status') }}
        </div>
        <button type="button" onclick="document.getElementById('flash-status').remove()" class="text-emerald-600 hover:text-emerald-800 p-1">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
    </div>
@endif

@if ($errors->any())
    <div id="flash-errors" class="mb-6 flex items-start gap-3 rounded-2xl border border-red-200 bg-red-50/80 p-4 text-sm text-red-900 shadow-xs backdrop-blur-xs transition-all">
        <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-xl bg-red-600 text-white shadow-xs">
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
        </div>
        <div class="flex-1">
            <div class="font-bold text-red-950 mb-1">Periksa kembali data Anda:</div>
            <ul class="space-y-1 text-xs text-red-800">
                @foreach ($errors->all() as $e)
                    <li class="flex items-center gap-1.5">
                        <span class="h-1.5 w-1.5 rounded-full bg-red-500"></span>
                        <span>{{ $e }}</span>
                    </li>
                @endforeach
            </ul>
        </div>
        <button type="button" onclick="document.getElementById('flash-errors').remove()" class="text-red-600 hover:text-red-800 p-1">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
    </div>
@endif
