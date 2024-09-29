<div class="ml-80">
    <div class="ml-16 pt-16 pb-32 max-w-3xl">
        <article class="px-4">
            <x-language
                current="{{ App::currentLocale() }}"
            />

            <header class="mt-2">
                <h1 class="font-black text-4xl leading-snug text-gray-800">
                    {{ $api->title }}
                </h1>

                @foreach ($api->getHttpInvocations() as $invocation)
                    <div class="mt-5">
                        <x-http.invocation
                            :method="$invocation->method"
                            :endpoint="$invocation->endpoint"
                        />
                    </div>
                @endforeach
            </header>

            <section class="pt-16 text-lg text-gray-600 markdown markdown-loose">
                @if ($api->summary !== null)
                    <p>{{ $api->summary }}</p>
                @endif

                @if ($api->description !== null)
                    {!! $markdown->convert($api->description) !!}
                @endif
            </section>

            <section class="mt-16">
                <h2 class="font-bold text-3xl">
                    {{ __('Request') }}
                </h2>

                @if ($api->hasPathParameters())
                    <h3 class="mt-16 font-bold text-xl">
                        {{ __('Path Parameters') }}
                    </h3>

                    @foreach ($api->getPathParameters() as $parameter)
                        <div class="mt-10 max-w-xl">
                            <x-api.schema
                                :name="$parameter->name"
                                :schema="$parameter->getSchema()"
                                :markdown="$markdown"
                            />
                        </div>
                    @endforeach
                @endif

                @if ($api->hasQueryParameters())
                    <h3 class="mt-16 font-bold text-xl">
                        {{ __('Query Parameters') }}
                    </h3>

                    @foreach ($api->getQueryParameters() as $parameter)
                        <div class="mt-10 max-w-xl">
                            <x-api.schema
                                :name="$parameter->name"
                                :schema="$parameter->getSchema()"
                                :markdown="$markdown"
                            />
                        </div>
                    @endforeach
                @endif

                @if ($api->hasRequestBody())
                    <h3 class="mt-16 font-bold text-xl">
                        {{ __('Body') }}
                    </h3>

                    <div class="mt-10 max-w-xl">
                        <x-api.schema
                            :schema="$api->getRequestBody()->getSchema()"
                            :markdown="$markdown"
                        />
                    </div>
                @endif
            </section>

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

                <h3 class="mt-16 font-bold text-xl">
                    {{ __('Body') }}
                </h3>

                <div class="mt-10 max-w-xl">
                    @foreach ($api->responses as $status => $response)
                        <div x-show="response === '{{ $status }}'">
                            <x-api.schema
                                name="{}"
                                :schema="$api->getResponse($status)->getSchema()"
                                :markdown="$markdown"
                            />
                        </div>
                    @endforeach
                </div>
            </section>
        </article>
    </div>
</div>
