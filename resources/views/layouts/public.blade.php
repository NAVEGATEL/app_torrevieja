<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />

        
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
        
        <!-- Scripts -->
        @vite(['resources/sass/app.scss', 'resources/js/app.js'])
        
        
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}" /> 
    </head>
    <body>
        <div id="app" class="bg-light">
            @include('layouts.partials.navbar')

            <main class="py-4 bg-light">@yield('content')</main>

            @include('layouts.partials.footbar')
        </div>
    </body>
</html>
