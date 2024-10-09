@props([
    'definition',
    'displayDivider' => false,
])

@if ($displayDivider && is_array($definition))
    <div class="m-4 h-px bg-slate-200 first:bg-transparent"></div>
@endif

@if (isset($definition['title']))
    <h1 class="px-4 py-2 font-bold text-slate-400 text-sm">
        {{ $definition['title'] }}
    </h1>
@endif

@if (
    is_array($definition) &&
    ($definition['type'] ?? null) === 'directory' &&
    is_array($definition['children'] ?? null)
)
    <ul>
        @foreach ($definition['children'] as $item)
            @if (is_string($item))
                <li>
                    <a
                        href="{{ route('references.apis.show', [
                            'locale' => Request::route('locale'),
                            'product' => Request::route('product'),
                            'version' => Request::route('version'),
                            'api' => $item,
                        ]) }}"
                        class="block py-2 px-4 text-base leading-tight overflow-hidden overflow-ellipsis cursor-pointer {{ Request::route('api') === $item ? 'text-sky-600 font-bold' : 'text-slate-600 hover:text-slate-400' }}"
                    >
                        {{ $item }}
                    </a>
                </li>
            @elseif (is_array($item))
                <x-sidebar.navigation
                    :definition="$item"
                />
            @endif
        @endforeach
    </ul>
@elseif (is_string($definition))
    <a
        href="{{ route('references.apis.show', [
            'locale' => Request::route('locale'),
            'product' => Request::route('product'),
            'version' => Request::route('version'),
            'api' => $definition,
        ]) }}"
        class="block py-2 px-4 text-base leading-tight overflow-hidden overflow-ellipsis cursor-pointer {{ Request::route('api') === $definition ? 'text-sky-600 font-bold' : 'text-slate-600 hover:text-slate-400' }}"
    >
        {{ $definition }}
    </a>
@endif
