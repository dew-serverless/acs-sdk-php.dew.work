<div class="ml-80">
    <div class="ml-16 px-4 max-w-3xl">
        <div class="mt-16">
            <x-language current="{{ Request::route('locale') }}" />
        </div>

        <article class="mb-32">
            <header class="mt-2">
                <h1 class="font-black text-4xl leading-snug text-gray-800">
                    {{ $api->title }}
                </h1>

                @foreach ($api->getHttpInvocations() as $invocation)
                    <div class="mt-5">
                        <x-api.invocation
                            :method="$invocation->method"
                            :endpoint="$invocation->endpoint"
                        />
                    </div>
                @endforeach
            </header>

            @include('references.description')

            @include('references.request')

            @include('references.response')
        </article>
    </div>
</div>
