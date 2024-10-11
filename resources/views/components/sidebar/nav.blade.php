@props([
    'locale',
    'product',
    'version',
    'api',
    'active' => false,
])

<a
    href="{{ route('references.apis.show', [
        'locale' => $locale,
        'product' => $product,
        'version' => $version,
        'api' => $api,
    ]) }}"
    {{ $attributes->class([
        'block', 'py-2', 'px-4',
        'text-base', 'leading-tight',
        'overflow-hidden', 'overflow-ellipsis',
        'cursor-pointer',
        ...$active
            ? ['text-sky-600', 'font-bold']
            : ['text-slate-600', 'hover:text-slate-400'],
    ]) }}
>
    {{ $api }}
</a>
