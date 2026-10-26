@extends('layouts.app', ['title' => $title])

@section('content')
<div class="mx-auto max-w-4xl space-y-6">
    <!-- Header with Back & Action -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            @isset($back)
                <div class="mb-1">
                    <a href="{{ $back }}" class="text-xs font-semibold text-slate-500 hover:text-emerald-700 transition inline-flex items-center gap-1">
                        &larr; Kembali
                    </a>
                </div>
            @endisset
            <h2 class="text-2xl font-extrabold text-slate-900 tracking-tight">
                {{ $title }}
            </h2>
        </div>

        @isset($action)
            <a 
                href="{{ $action['href'] }}" 
                class="inline-flex items-center gap-2 rounded-xl bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 px-5 py-2.5 text-xs font-bold text-white shadow-xs transition"
            >
                <span>{{ $action['label'] }}</span>
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                </svg>
            </a>
        @endisset
    </div>

    <!-- Details Card -->
    <div class="rounded-3xl bg-white border border-slate-200/80 shadow-xs p-6 sm:p-8">
        <dl class="grid grid-cols-1 gap-4 sm:gap-6">
            @foreach ($items as $label => $value)
                <div class="rounded-2xl bg-slate-50/70 p-4 sm:p-5 border border-slate-100">
                    <dt class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-1">{{ $label }}</dt>
                    <dd class="text-sm font-semibold text-slate-800 leading-relaxed">{{ $value ?: '-' }}</dd>
                </div>
            @endforeach
        </dl>
    </div>
</div>
@endsection
