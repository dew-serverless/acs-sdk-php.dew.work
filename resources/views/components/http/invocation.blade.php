@props(['method', 'endpoint'])

@php
    $methodBg = match (strtoupper($method)) {
        'GET' => 'bg-emerald-600',
        'POST' => 'bg-cyan-600',
        'PUT' => 'bg-blue-600',
        'DELETE' => 'bg-rose-600',
        'PATCH' => 'bg-indogo-600',
        default => '',
    };
@endphp

<div class="leading-none">
    <div class="inline-flex items-center pl-4 pr-6 py-3 text-sm text-white bg-slate-100 rounded-md">
        <div class="px-5 py-2 text-center {{ $methodBg }} leading-none rounded-md w-20">
            {{ $method }}
        </div>

        <div class="ml-3 font-mono text-gray-800 select-all">
            {{ $endpoint }}
        </div>
    </div>
</div>
