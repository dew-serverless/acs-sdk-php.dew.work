@props([
    'name',
    'schema',
    'markdown',
])

<x-api.schema.base
    :name="$name"
    :schema="$schema"
    :markdown="$markdown"
>
    @if (isset($schema['items']))
        <x-slot:child-type>
            {{ $schema['items']['type'] }}
        </x-slot:child-type>

        <x-api.schema
            :schema="$schema['items']"
            :markdown="$markdown"
        />
    @endif
</x-api.schema.base>
