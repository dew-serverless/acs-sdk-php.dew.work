@props([
    'name' => null,
    'schema',
    'markdown',
    'compact' => null,
])

@if (isset($schema['type']))
    <x-dynamic-component
        :component="'api.schema.'.$schema['type']"
        :$name
        :$schema
        :$markdown
        :$compact
    />
@endif
