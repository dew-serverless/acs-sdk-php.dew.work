@props([
    'name' => '*',
    'schema',
    'markdown',

    // hide header and description
    'compact' => false,

    // slots
    'childType' => null,
])

@unless ($compact)
    <header class="flex items-center">
        <h4 class="font-bold text-base">
            {{ $name }}
        </h4>

        @if (isset($schema['type']))
            <div class="ml-2 text-sm text-slate-600">
                @if ($childType === null)
                    {{ $schema['type']}}
                @else
                    {{ $schema['type'] }}&lt;{{ $childType }}&gt;
                @endif
            </div>
        @endif

        @if (isset($schema['required']) && $schema['required'] === true)
            <div class="ml-auto text-sm text-amber-600 uppercase">
                {{ __('required') }}
            </div>
        @endif
    </header>
@endunless

@if (! $compact && isset($schema['description']) && $schema['description'] !== '')
    <div class="mt-3 text-sm text-slate-600 markdown markdown-base">
        {!! $markdown->convert($schema['description']) !!}
    </div>
@endif

@if (isset($schema['example']))
    <div class="mt-5 text-xs text-slate-600">
        {{ __('Example:') }}
        <code class="py-1 px-2 text-slate-600 bg-slate-100 rounded-md">
            {{ $schema['example'] }}
        </code>
    </div>
@endif

@if (isset($schema['default']))
    <div class="mt-5 text-xs text-slate-600">
        {{ __('Default:') }}
        <code class="py-1 px-2 text-slate-600 bg-slate-100 rounded-md">
            {{ $schema['default'] }}
        </code>
    </div>
@endif

{{ $slot }}
