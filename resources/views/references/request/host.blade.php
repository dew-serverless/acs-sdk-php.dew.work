@if ($api->hasHostParameters())
    <h3 class="mt-16 font-bold text-xl">
        {{ __('Host Parameters') }}
    </h3>

    @foreach ($api->getHostParameters() as $parameter)
        <div class="mt-10 max-w-xl">
            <x-api.schema
                :name="$parameter->name"
                :schema="$parameter->getSchema()"
                :markdown="$markdown"
            />
        </div>
    @endforeach
@endif
