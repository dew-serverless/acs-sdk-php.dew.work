<section
    class="mt-16"
    x-data="{
        response: '{{ $api->firstResponseCode() }}'
    }"
>
    <div class="flex">
        <h2 class="font-bold text-3xl">
            {{ __('Response') }}
        </h2>

        <div class="ml-8 flex space-x-2">
            @foreach ($api->responses as $status => $response)
                <div
                    x-data="{
                        status: '{{ $status }}',
                        current: false,
                        get isSuccessful() { return this.status[0] === '2' },
                        get isClientError() { return this.status[0] === '4' },
                        get isServerError() { return this.status[0] === '5' }
                    }"
                    x-effect="current = response === status"
                    class="px-4 text-base leading-9 rounded-md cursor-pointer"
                    :class="{
                        'font-bold text-white': current,

                        'bg-emerald-600': isSuccessful && current,
                        'text-emerald-600 hover:bg-emerald-100': isSuccessful && !current,

                        'bg-amber-600': isClientError && current,
                        'text-amber-600 hover:bg-amber-100': isClientError && !current,

                        'bg-rose-600': isServerError && current,
                        'text-rose-600 hover:bg-rose-100': isServerError && !current,
                    }"
                    @click="response = status"
                >
                    {{ $status }}
                </div>
            @endforeach
        </div>
    </div>

    @foreach ($api->responses as $status => $response)
        @if (is_string($response['description'] ?? null))
            <p
                class="mt-10 text-lg text-gray-600"
                x-show="response === '{{ $status }}'"
            >
                {{ $response['description'] }}
            </p>
        @endif
    @endforeach

    <div class="max-w-xl">
        @foreach ($api->responses as $status => $response)
            <div x-show="response === '{{ $status }}'">
                @if (isset($response['headers']))
                    <h3 class="mt-16 font-bold text-xl">
                        {{ __('HTTP Headers') }}
                    </h3>

                    @foreach ($response['headers'] as $name => $header)
                        @if (isset($header['schema']))
                            <div class="mt-10">
                                <x-api.schema
                                    :name="$name"
                                    :schema="$header['schema']"
                                    :$markdown
                                />
                            </div>
                        @endif
                    @endforeach
                @endif

                @if (isset($response['schema']))
                    <h3 class="mt-16 font-bold text-xl">
                        {{ __('Body') }}
                    </h3>

                    <div class="mt-10">
                        <x-api.schema
                            :schema="$api->getResponse($status)->getSchema()"
                            :$markdown
                        />
                    </div>
                @endif
            </div>
        @endforeach
    </div>
</section>
