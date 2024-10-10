<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ $api->title }} - {{ $version }} - {{ $product }} - ACS SDK PHP</title>

        @vite('resources/css/app.css')

        <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.1/dist/cdn.min.js" integrity="sha256-NY2a+7GrW++i9IBhowd25bzXcH9BCmBrqYX5i8OxwDQ=" crossorigin="anonymous" defer></script>
    </head>
    <body class="font-sans antialiased">
        <div class="flex min-h-screen">
            @include('references.sidebar')

            @include('references.article')
        </div>
    </body>
</html>
