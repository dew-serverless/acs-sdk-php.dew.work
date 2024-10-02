@if ($api->hasHeaderParameters())
    <h3 class="mt-16 font-bold text-xl">
        {{ __('Header Parameters') }}
    </h3>

    @foreach ($api->getHeaderParameters() as $parameter)
        <div class="mt-10 max-w-xl">
            <x-api.schema
                :name="$parameter->name"
                :schema="$parameter->getSchema()"
                :markdown="$markdown"
            />
        </div>
    @endforeach
@endif
