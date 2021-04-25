<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="author" content="{{ env('APP_AUTHOR') }}">
        <meta name="description" content="{{ env('APP_DESCRIPTION') }}">
        <meta name="keywords" content="{{ env('APP_KEYWORDS') }}">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ env('APP_NAME') }}</title>

        <link rel="stylesheet" type="text/css" href="{{ asset('css/bulma.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/metro-all.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}">

        @if (env('APP_ENV') === 'production')
            <script src="{{ asset('js/vue.js') }}"></script>
        @else
            <script src="{{ asset('js/vue.js') }}"></script>
        @endif
        <script src="{{ asset('js/fontawesome.js') }}"></script>
        <script src="{{ asset('js/app.js') }}"></script>
    </head>

    <body style="background-image: url('{{ asset('gfx/backgrounds/' . \App\Models\AppModel::getBackground()) }}');">
        <div id="main" style="background-color: rgba(0, 0, 0, {{ \App\Models\AppModel::getAlphaChannel() }});">
            @include('layouts.navbar')

            <div class="content">
                <div class="container">
                    <div class="columns">
                        <div class="column is-2"></div>

                        <div class="column is-8">
                            @yield('content')
                        </div>

                        <div class="column is-2"></div>
                    </div>
                </div>
            </div>

            @include('widgets.bottombar')
        </div>
    </body>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            //
        });
    </script>
</html>