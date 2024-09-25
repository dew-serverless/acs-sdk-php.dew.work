@props([
    'name',
    'schema',
    'markdown',
])

<x-dynamic-component
    :component="'api.schema.'.$schema['type']"
    :name="$parameter['name'] ?? ''"
    :schema="$schema"
    :markdown="$markdown"
/>
