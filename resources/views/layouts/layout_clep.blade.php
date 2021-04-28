{{--
    Astarlove (dnyAstarlove) developed by Daniel Brendel

    (C) 2021 by Daniel Brendel

    Contact: dbrendel1988<at>gmail<dot>com
    GitHub: https://github.com/danielbrendel/

    Released under the MIT license
--}}

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', App::getLocale()) }}" class="clep-outer">
    <head>
        @include('layouts.head')
    </head>

    <body class="clep-outer" @if (file_exists(public_path() . '/clep.png')) style="background-image: url('{{ asset('clep.png') }}');" @endif>
        <div id="main" @if (file_exists(public_path() . '/clep.png')) style="background-color: rgba(0, 0, 0, {{ \App\Models\AppModel::getAlphaChannel() }});" @endif>
            <div class="clep-content">
                @if ($errors->any())
                    <div id="error-message-1">
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
                    </div>
                    <br/>
                @endif

                @if (Session::has('error'))
                    <div id="error-message-2">
                        <article class="message is-danger">
                            <div class="message-header">
                                <p>{{ __('app.error') }}</p>
                                <button class="delete" aria-label="delete" onclick="document.getElementById('error-message-2').style.display = 'none';"></button>
                            </div>
                            <div class="message-body">
                                {{ Session::get('error') }}
                            </div>
                        </article>
                    </div>
                    <br/>
                @endif

                @if (Session::has('success'))
                    <div id="success-message">
                        <article class="message is-success">
                            <div class="message-header">
                                <p>{{ __('app.success') }}</p>
                                <button class="delete" aria-label="delete" onclick="document.getElementById('success-message').style.display = 'none';"></button>
                            </div>
                            <div class="message-body">
                                {{ Session::get('success') }}
                            </div>
                        </article>
                    </div>
                    <br/>
                @endif

                @yield('content')
            </div>

            @include('widgets.register')
            @include('widgets.recover')
        </div>
    </body>
    <script src="{{ asset('js/app.js') }}"></script>
</html>
