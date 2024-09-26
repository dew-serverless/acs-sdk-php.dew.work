<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ $api->title }} - {{ $version }} - {{ $product }} - ACS SDK PHP</title>

        @vite('resources/css/app.css')
    </head>
    <body class="font-sans antialiased">
        <div class="container mx-auto pt-16 pb-32 max-w-3xl">
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

                    @if ($api->getQueryParameters() !== [])
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

                    @if ($api->getRequestBody() !== null)
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

                <section class="mt-16">
                    <div class="flex">
                        <h2 class="font-bold text-3xl">
                            {{ __('Response') }}
                        </h2>

                        <div class="ml-8 flex">
                            <div class="px-4 font-bold text-base text-white bg-emerald-600 leading-9 rounded-md cursor-pointer">
                                200
                            </div>
                        </div>
                    </div>

                    @if (isset($api->responses['200']['schema']))
                        <h3 class="mt-16 font-bold text-xl">
                            {{ __('Body') }}
                        </h3>

                        <div class="mt-10 max-w-xl">
                            <x-api.schema
                                name="{}"
                                :schema="$api->getResponse('200')->getSchema()"
                                :markdown="$markdown"
                            />
                        </div>
                    @endif
                </section>
            </article>
        </div>
    </body>
</html>
