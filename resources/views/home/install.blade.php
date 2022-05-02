{{--
    Astarlove (dnyAstarlove) developed by Daniel Brendel

    (C) 2021 - 2022 by Daniel Brendel

    Contact: dbrendel1988<at>gmail<dot>com
    GitHub: https://github.com/danielbrendel/

    Released under the MIT license
--}}

<!doctype html>
<html lang="{{ str_replace('_', '-', App::getLocale()) }}">
    <head>
        <meta charset="utf-8">

        <link rel="stylesheet" type="text/css" href="{{ asset('css/bulma.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/metro-all.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}">

        <script src="{{ asset('js/fontawesome.js') }}"></script>
        <script src="{{ asset('js/metro.min.js') }}"></script>
        @if (env('APP_ENV') === 'local')
            <script src="{{ asset('js/vue.js') }}"></script>
        @else
            <script src="{{ asset('js/vue.min.js') }}"></script>
        @endif

        <title>Astarlove - Installation</title>
    </head>

    <body>
        <div id="main" class="container">
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

            <div class="columns is-vcentered is-multiline">
                <div class="column is-2"></div>

                <div class="column is-8">
                    <h1>Install Astarlove</h1>
                    <br/>
                    <span>
                        Welcome to the installation of Astarlove. The installation is intended to be fast. Just fill out and submit the form
                        and the system will perform the installation. If everything goes well you will then be redirected to the index page.
                        <br/><br/>
                    </span>

                    <div class="member-form is-default-padding">
                        <form method="POST" action="{{ url('/install') }}">
                            @csrf

                            <div class="field">
                                <label class="label">E-Mail address</label>
                                <div class="control">
                                    <input type="text" name="email" placeholder="name@domain.tld" required>
                                </div>
                            </div>

                            <div class="field">
                                <label class="label">Database name</label>
                                <div class="control">
                                    <input type="text" name="database" value="astarlove" required>
                                </div>
                            </div>

                            <div class="field">
                                <label class="label">Database user</label>
                                <div class="control">
                                    <input type="text" name="dbuser" value="root" required>
                                </div>
                            </div>

                            <div class="field">
                                <label class="label">Database password</label>
                                <div class="control">
                                    <input type="password" name="dbpassword" value="">
                                </div>
                            </div>

                            <div class="field">
                                <label class="label">Database host</label>
                                <div class="control">
                                    <input type="text" name="dbhost" value="127.0.0.1" required>
                                </div>
                            </div>

                            <div class="field">
                                <label class="label">Database port</label>
                                <div class="control">
                                    <input type="text" name="dbport" value="3306" required>
                                </div>
                            </div>

                            <div class="field">
                                <label class="label">SMTP Host</label>
                                <div class="control">
                                    <input type="text" name="smtphost" value="127.0.0.1" required>
                                </div>
                            </div>

                            <div class="field">
                                <label class="label">SMTP User</label>
                                <div class="control">
                                    <input type="text" name="smtpuser" required>
                                </div>
                            </div>

                            <div class="field">
                                <label class="label">SMTP Password</label>
                                <div class="control">
                                    <input type="password" name="smtppassword" required>
                                </div>
                            </div>

                            <div class="field">
                                <label class="label">SMTP From-Address</label>
                                <div class="control">
                                    <input type="email" name="smtpfromaddress" required>
                                </div>
                            </div>

                            <br/>

                            <input type="submit" value="Install">
                        </form>
                    </div>
                </div>

                <div class="column is-2 is-sidespacing"></div>
        </div>

        <br/><br/><br/><br/><br/>

        <nav class="navbar is-fixed-bottom">
            <div class="install-bottombar has-text-centered is-uppercase">
                &copy; {{ date('Y') }} by Daniel Brendel | <a href="https://github.com/danielbrendel/" target="_blank">GitHub</a>&nbsp;&nbsp;<a href="mailto:dbrendel1988<at>gmail<dot>com" target="_blank">Contact</a>
            </div>
        </nav>
    </div>

    <script>
        document.getElementsByClassName('container')[0].style.marginTop = '5px';
    </script>
</body>
</html>
