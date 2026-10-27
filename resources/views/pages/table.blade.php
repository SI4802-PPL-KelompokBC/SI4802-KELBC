@extends('layouts.app', ['title' => $title])

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 text-xs font-semibold uppercase tracking-wider text-slate-400 mb-1">
                <a href="{{ route('dashboard') }}" class="hover:text-slate-600 transition">Beranda</a>
                <span>&bull;</span>
                <span class="text-emerald-700 font-bold">Data Master & Tabel</span>
            </div>
            <h2 class="text-2xl font-extrabold text-slate-900 tracking-tight">
                {{ $title }}
            </h2>
            @isset($subtitle)
                <p class="mt-1 text-xs sm:text-sm text-slate-500">
                    {{ $subtitle }}
                </p>
            @endisset
        </div>
    </div>

    <!-- Data Table Container -->
    <div class="overflow-hidden rounded-3xl bg-white border border-slate-200/80 shadow-xs">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-slate-50/75 border-b border-slate-100 text-[11px] font-bold uppercase tracking-wider text-slate-500">
                    <tr>
                        @foreach ($columns as $c)
                            <th class="px-5 py-3.5">{{ $c }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                @forelse ($rows as $row)
                    <tr class="hover:bg-slate-50/60 transition-colors">
                        @foreach ($row as $cell)
                            <td class="px-5 py-4 text-xs font-medium text-slate-700">
                                @if (is_array($cell) && isset($cell['href']))
                                    <a 
                                        href="{{ $cell['href'] }}" 
                                        class="inline-flex items-center gap-1.5 rounded-lg border border-slate-200 bg-white px-3 py-1.5 text-xs font-bold text-slate-800 hover:border-emerald-300 hover:text-emerald-700 transition shadow-2xs"
                                    >
                                        <span>{{ $cell['label'] }}</span>
                                        <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                        </svg>
                                    </a>
                                @elseif (is_array($cell) && isset($cell['post']))
                                    <form method="POST" action="{{ $cell['post'] }}" class="inline">
                                        @csrf 
                                        <button 
                                            type="submit" 
                                            class="inline-flex items-center gap-1 rounded-lg border px-3 py-1 text-xs font-bold transition shadow-2xs {{ $cell['label'] === 'Nonaktifkan' ? 'border-rose-200 bg-rose-50 text-rose-700 hover:bg-rose-100' : 'border-emerald-200 bg-emerald-50 text-emerald-700 hover:bg-emerald-100' }}"
                                        >
                                            {{ $cell['label'] }}
                                        </button>
                                    </form>
                                @elseif (is_string($cell) && in_array(strtolower($cell), ['aktif', 'nonaktif']))
                                    @include('partials.badge', ['status' => strtolower($cell)])
                                @elseif (is_string($cell) && str_starts_with($cell, '+'))
                                    <span class="inline-flex items-center font-bold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-md border border-emerald-200">
                                        {{ $cell }}
                                    </span>
                                @elseif (is_string($cell) && str_starts_with($cell, '-'))
                                    <span class="inline-flex items-center font-bold text-rose-600 bg-rose-50 px-2 py-0.5 rounded-md border border-rose-200">
                                        {{ $cell }}
                                    </span>
                                @else
                                    {{ $cell }}
                                @endif
                            </td>
                        @endforeach
                    </tr>
                @empty
                    <tr>
                        <td colspan="{{ count($columns) }}" class="px-5 py-12 text-center text-slate-400 text-xs">
                            <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-slate-100 text-slate-400 mb-2">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                </svg>
                            </div>
                            Belum ada baris data pada tabel ini.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        @isset($paginator)
            @if ($paginator->hasPages())
                <div class="border-t border-slate-100 p-4">
                    {{ $paginator->links() }}
                </div>
            @endif
        @endisset
    </div>
</div>
@endsection
