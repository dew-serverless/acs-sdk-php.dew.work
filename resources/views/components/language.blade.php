@props([
    'current',
    'languages' => [
        ['locale' => 'en-us', 'label' => 'English'],
        ['locale' => 'zh-cn', 'label' => '简体中文'],
    ],
])

<ul class="flex space-x-3 text-sm text-slate-500">
    @foreach ($languages as $language)
        <li>
            <a
                {{ $attributes->class([
                    'font-bold' => $current === $language['locale'],
                    'text-slate-600' => $current === $language['locale'],
                    'cursor-pointer',
                    'hover:underline' => $current !== $language['locale'],
                ]) }}
                href="{{ route('references.apis.show', [
                    'locale' => $language['locale'],
                    'product' => Request::route('product'),
                    'version' => Request::route('version'),
                    'api' => Request::route('api'),
                ]) }}"
            >
                {{ $language['label'] }}
            </a>
        </li>
    @endforeach
</ul>
