@if ($api->summary !== null || $api->description !== null)
    <section class="pt-16 text-lg text-gray-600 markdown markdown-loose">
        @if ($api->summary !== null)
            <p>{{ $api->summary }}</p>
        @endif

        @if ($api->description !== null)
            {!! $markdown->convert($api->description) !!}
        @endif
    </section>
@endif
