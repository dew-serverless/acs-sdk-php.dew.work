@props([
    'name',
    'schema',
    'markdown',
])

@if (isset($schema['properties']))
    <div class="pl-10">
        @foreach ($schema['properties'] as $property => $propSchema)
            <div class="mt-7">
                <x-dynamic-component
                    :component="'api.schema.'.$propSchema['type']"
                    :name="$property"
                    :schema="$propSchema"
                    :markdown="$markdown"
                />
            </div>
        @endforeach
    </div>
@endif
