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
                <header>
                    <h1 class="font-black text-4xl leading-snug text-gray-800">
                        {{ $api->title }}
                    </h1>

                    @foreach ($api->methods as $method)
                        <div class="mt-5">
                            <x-http.invocation
                                method="{{ strtoupper($method) }}"
                                endpoint="/{{ $api->getName() }}"
                            />
                        </div>
                    @endforeach
                </header>

                <section class="reference-description pt-16 text-lg text-gray-600">
                    @if ($api->summary !== null)
                        <p>{{ $api->summary }}</p>
                    @endif

                    @if ($api->description !== null)
                        {!! $markdown->convert($api->description) !!}
                    @endif
                </section>
            </article>
        </div>
    </body>
</html>
