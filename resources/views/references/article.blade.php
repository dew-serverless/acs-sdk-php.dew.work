<div class="ml-80">
    <div class="ml-16 pt-16 px-4 pb-6 max-w-3xl">
        <x-language current="{{ App::currentLocale() }}" />

        <article>
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

            @include('references.request')

            @include('references.response')
        </article>

        <footer class="mt-32">
            <p class="text-xs text-slate-600">
                {{ __('The page is auto-generated with acs-metadata v:version - Openmeta :metadata', [
                    'version' => $pkg_version,
                    'metadata' => $pkg_metadata,
                ]) }}
            </p>
        </footer>
    </div>
</div>
