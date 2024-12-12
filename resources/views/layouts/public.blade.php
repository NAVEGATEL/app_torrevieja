<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}" />

        <title>@yield('title', config('app.name'))</title>
        <meta
            name="description"
            content="@yield('description', 'Descripción por defecto')"
        />
        <!-- Bootstrap -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
        <!-- Fonts -->
        <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />

        <!-- Scripts -->
        @vite(['resources/sass/app.scss', 'resources/js/app.js'])
        <!-- Google tag (gtag.js) -->
        <script
            async
            src="https://www.googletagmanager.com/gtag/js?id=G-DJEK07JMK4"
        ></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag() {
                dataLayer.push(arguments);
            }
            gtag("js", new Date());

            gtag("config", "G-DJEK07JMK4");
        </script>
        <style>
    html, body {
        height: 100%;
        margin: 0;
        padding: 0;
        overflow: hidden; /* Bloquea el scroll */
    }
    </style>
    </head>
    <body>
        <div id="app" class="bg-light">
            @include('layouts.partials.navbar')

            <main class="py-4 bg-light">@yield('content')</main>

            @include('layouts.partials.footbar')
        </div>
    </body>
</html>
