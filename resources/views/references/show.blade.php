<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ $title }}</title>

        @vite('resources/css/app.css')

        @vite('resources/js/app.js')
    </head>
    <body class="font-sans antialiased">
        <div class="flex min-h-screen">
            @include('references.sidebar')

            @include('references.article')
        </div>
    </body>
</html>
