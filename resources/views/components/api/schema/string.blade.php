@props([
    'name',
    'schema',
    'markdown',
])

<x-api.schema.base
    :name="$name"
    :schema="$schema"
    :markdown="$markdown"
/>
