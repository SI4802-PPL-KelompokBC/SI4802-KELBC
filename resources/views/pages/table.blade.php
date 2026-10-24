@extends('layouts.app', ['title' => $title])
@section('content')
<h1 class="text-xl font-semibold">{{ $title }}</h1>
@isset($subtitle)<p class="text-sm text-slate-500">{{ $subtitle }}</p>@endisset

<div class="mt-4 overflow-x-auto rounded-xl bg-white shadow-sm">
    <table class="w-full text-left text-sm">
        <thead class="bg-slate-50 text-xs uppercase text-slate-500">
            <tr>@foreach ($columns as $c)<th class="px-4 py-3">{{ $c }}</th>@endforeach</tr>
        </thead>
        <tbody>
        @forelse ($rows as $row)
            <tr class="border-t">
                @foreach ($row as $cell)
                    <td class="px-4 py-3">
                        @if (is_array($cell) && isset($cell['href']))
                            <a href="{{ $cell['href'] }}" class="font-medium text-brand-700">{{ $cell['label'] }}</a>
                        @elseif (is_array($cell) && isset($cell['post']))
                            <form method="POST" action="{{ $cell['post'] }}">@csrf <button class="font-medium text-brand-700">{{ $cell['label'] }}</button></form>
                        @else
                            {{ $cell }}
                        @endif
                    </td>
                @endforeach
            </tr>
        @empty
            <tr><td colspan="{{ count($columns) }}" class="px-4 py-6 text-center text-slate-500">Belum ada data.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>

@isset($paginator)<div class="mt-4">{{ $paginator->links() }}</div>@endisset

{{-- TODO (PIC modul): tambahkan form tambah/ubah. Endpoint store/update sudah tersedia di routes/web.php. --}}
@endsection
