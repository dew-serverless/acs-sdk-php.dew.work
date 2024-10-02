@props([
    'name',
    'schema',
    'markdown',
])

<x-api.schema.base
    :$name
    :$schema
    :$markdown
>
    @if (isset($schema['items']))
        <x-slot:child-type>
            {{ $schema['items']['type'] }}
        </x-slot:child-type>

        <div class="pl-7 border-l border-l-slate-300 border-solid">
            <div class="mt-7">
                <x-api.schema
                    name="*"
                    :schema="$schema['items']"
                    :markdown="$markdown"
                    :compact="true"
                />
            </div>
        </div>
    @endif
</x-api.schema.base>
