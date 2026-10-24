@extends('layouts.app', ['title' => $title])
@section('content')
@isset($back)<a href="{{ $back }}" class="text-sm text-brand-700">&larr; Kembali</a>@endisset
<div class="mt-2 flex items-center justify-between">
    <h1 class="text-xl font-semibold">{{ $title }}</h1>
    @isset($action)<a href="{{ $action['href'] }}" class="rounded-lg bg-brand-600 px-4 py-2 text-sm text-white">{{ $action['label'] }}</a>@endisset
</div>
<dl class="mt-4 space-y-4 rounded-xl bg-white p-5 shadow-sm">
    @foreach ($items as $label => $value)
        <div><dt class="text-xs uppercase text-slate-500">{{ $label }}</dt><dd class="mt-1">{{ $value ?: '-' }}</dd></div>
    @endforeach
</dl>
@endsection
