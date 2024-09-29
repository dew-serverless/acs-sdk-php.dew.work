<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ $api->title }} - {{ $version }} - {{ $product }} - ACS SDK PHP</title>

        @vite('resources/css/app.css')

        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.1/dist/cdn.min.js"></script>
    </head>
    <body class="font-sans antialiased">
        <div class="flex min-h-screen">
            @include('reference.sidebar')

            @include('reference.article')
        </div>
    </body>
</html>
