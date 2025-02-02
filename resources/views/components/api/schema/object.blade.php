@props([
    'name' => '{}',
    'schema',
    'markdown',

    // hide header and description
    'compact' => false,
])

<x-api.schema.base
    :$name
    :$schema
    :$markdown
    :$compact
>
    @if (isset($schema['properties']))
        <div class="{{ $compact ? '' : 'pl-7 border-l border-l-slate-300 border-solid' }}">
            @foreach ($schema['properties'] as $property => $propSchema)
                <div class="mt-7">
                    <x-api.schema
                        :name="$property"
                        :schema="$propSchema"
                        :markdown="$markdown"
                    />
                </div>
            @endforeach
        </div>
    @elseif (isset($schema['additionalProperties']))
        <div class="{{ $compact ? '' : 'pl-7 border-l border-l-slate-300 border-solid' }}">
            <div class="mt-7">
                <x-api.schema
                    :schema="$schema['additionalProperties']"
                    :markdown="$markdown"
                />
            </div>
        </div>
    @endif
</x-api.schema>
