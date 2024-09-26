@props([
    'current',
    'languages' => [
        ['locale' => 'en', 'label' => 'English'],
        ['locale' => 'zh_Hans', 'label' => '简体中文'],
    ],
])

<form method="POST" action="/languages">
    @csrf

    <ul class="flex space-x-3 text-sm text-slate-500">
        @foreach ($languages as $language)
            <li>
                <button
                    {{ $attributes->merge([
                        'type' => $current === $language['locale'] ? 'button' : 'submit',
                    ]) }}
                    {{ $attributes->class([
                        'font-bold' => $current === $language['locale'],
                        'text-slate-600' => $current === $language['locale'],
                        'cursor-pointer',
                        'hover:underline' => $current !== $language['locale'],
                    ]) }}
                    name="locale"
                    value="{{ $language['locale'] }}"
                >
                    {{ $language['label'] }}
                </button>
            </li>
        @endforeach
    </ul>
</form>
