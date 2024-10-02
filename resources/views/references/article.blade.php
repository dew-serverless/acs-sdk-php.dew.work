<div class="ml-80">
    <div class="ml-16 pt-16 px-4 pb-32 max-w-3xl">
        <x-language current="{{ App::currentLocale() }}" />

        <article>
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

            @include('references.request')

            @include('references.response')
        </article>
    </div>
</div>
