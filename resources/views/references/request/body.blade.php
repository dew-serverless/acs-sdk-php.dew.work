@if ($api->hasRequestBody())
    <h3 class="mt-16 font-bold text-xl">
        {{ __('Body') }}
    </h3>

    <div class="mt-10 max-w-xl">
        <x-api.schema
            :schema="$api->getRequestBody()->getSchema()"
            :$markdown
        />
    </div>
@endif
