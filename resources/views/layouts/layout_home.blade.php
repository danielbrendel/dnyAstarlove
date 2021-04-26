{{--
    Astarlove (dnyAstarlove) developed by Daniel Brendel

    (C) 2021 by Daniel Brendel

    Contact: dbrendel1988<at>gmail<dot>com
    GitHub: https://github.com/danielbrendel/

    Released under the MIT license
--}}

<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="author" content="{{ env('APP_AUTHOR') }}">
        <meta name="description" content="{{ env('APP_DESCRIPTION') }}">
        <meta name="keywords" content="{{ env('APP_KEYWORDS') }}">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@yield('title')</title>

        <link rel="stylesheet" type="text/css" href="{{ asset('css/bulma.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/metro-all.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}">

        @if (env('APP_ENV') === 'production')
            <script src="{{ asset('js/vue.js') }}"></script>
        @else
            <script src="{{ asset('js/vue.js') }}"></script>
        @endif
        <script src="{{ asset('js/fontawesome.js') }}"></script>
        <script src="{{ asset('js/metro.min.js') }}"></script>
    </head>

    <body style="background-image: url('{{ asset('gfx/backgrounds/' . \App\Models\AppModel::getBackground()) }}');">
        <div id="main" style="background-color: rgba(0, 0, 0, {{ \App\Models\AppModel::getAlphaChannel() }});">
            @include('layouts.navbar')

            <div class="content">
                @if ($errors->any())
                    <div id="error-message-1" class="is-z-index-3">
                        <article class="message is-danger">
                            <div class="message-header">
                                <p>{{ __('app.error') }}</p>
                                <button class="delete" aria-label="delete" onclick="document.getElementById('error-message-1').style.display = 'none';"></button>
                            </div>
                            <div class="message-body">
                                @foreach ($errors->all() as $error)
                                    {{ $error }}<br/>
                                @endforeach
                            </div>
                        </article>
                        <br/>
                    </div>
                @endif

                @if (Session::has('error'))
                    <div id="error-message-2" class="is-z-index-3">
                        <article class="message is-danger">
                            <div class="message-header">
                                <p>{{ __('app.error') }}</p>
                                <button class="delete" aria-label="delete" onclick="document.getElementById('error-message-2').style.display = 'none';"></button>
                            </div>
                            <div class="message-body">
                                {!! Session::get('error') !!}
                            </div>
                        </article>
                        <br/>
                    </div>
                @endif

                <div class="flash is-flash-error" id="flash-error">
                    <p id="flash-error-content">
                        @if (Session::has('flash.error'))
                            {!! Session::get('flash.error') !!}
                        @endif
                    </p>
                </div>

                <div class="flash is-flash-success" id="flash-success">
                    <p id="flash-success-content">
                        @if (Session::has('flash.success'))
                            {!! Session::get('flash.success') !!}
                        @endif
                    </p>
                </div>

                @if (Session::has('notice'))
                    <div id="notice-message" class="is-z-index-3">
                        <article class="message is-info">
                            <div class="message-header">
                                <p>{{ __('app.notice') }}</p>
                                <button class="delete" aria-label="delete" onclick="document.getElementById('notice-message').style.display = 'none';"></button>
                            </div>
                            <div class="message-body">
                                {!! Session::get('notice') !!}
                            </div>
                        </article>
                        <br/>
                    </div>
                @endif

                @if (Session::has('success'))
                    <div id="success-message" class="is-z-index-3">
                        <article class="message is-success">
                            <div class="message-header">
                                <p>{{ __('app.success') }}</p>
                                <button class="delete" aria-label="delete" onclick="document.getElementById('success-message').style.display = 'none';"></button>
                            </div>
                            <div class="message-body">
                                {!! Session::get('success') !!}
                            </div>
                        </article>
                        <br/>
                    </div>
                @endif

                <div class="container">
                    <div class="columns">
                        <div class="column is-2"></div>

                        <div class="column is-8">
                            @yield('content')
                        </div>

                        <div class="column is-2"></div>
                    </div>
                </div>

                @guest
                    @include('widgets.login')
                    @include('widgets.register')
                    @include('widgets.recover')
                @endguest
            </div>

            @include('widgets.bottombar')
        </div>

        <script src="{{ asset('js/app.js') }}"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                @if (Session::has('flash.error'))
                    setTimeout('window.vue.showError()', 500);
                @endif

                @if (Session::has('flash.success'))
                    setTimeout('window.vue.showSuccess()', 500);
                @endif
            });
        </script>
    </body>
</html>