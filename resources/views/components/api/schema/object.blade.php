@props([
    'name' => '{}',
    'schema',
    'markdown',

    // hide header and description
    'compact' => false,
])

<x-api.schema.base
    :name="$name"
    :schema="$schema"
    :markdown="$markdown"
    :compact="$compact"
>
    @if (isset($schema['properties']))
        <div class="pl-10">
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
    @endif
</x-api.schema>
