{{--
    Astarlove (dnyAstarlove) developed by Daniel Brendel

    (C) 2021 by Daniel Brendel

    Contact: dbrendel1988<at>gmail<dot>com
    GitHub: https://github.com/danielbrendel/

    Released under the MIT license
--}}

@extends('layouts.layout_home')

@section('content')
    <div class="form">
        <h1>{{ __('app.password_reset') }}</h1>

        <div class="member-form is-default-padding">
            <form method="POST" action="{{ url('/reset?hash=' . $hash) }}">
                @csrf

                <div class="field">
                    <label class="label">{{ __('app.password') }}</label>
                    <p class="control has-icons-left">
                        <input class="input" type="password" name="password" placeholder="{{ __('app.password') }}">
                        <span class="icon is-small is-left">
                            <i class="fas fa-lock"></i>
                        </span>
                    </p>
                </div>

                <div class="field">
                    <label class="label">{{ __('app.password_confirm') }}</label>
                    <p class="control has-icons-left">
                        <input class="input" type="password" name="password_confirm" placeholder="{{ __('app.password_confirm') }}">
                        <span class="icon is-small is-left">
                            <i class="fas fa-lock"></i>
                        </span>
                    </p>
                </div>

                <div class="field">
                    <input class="button is-stretched is-info" type="submit" value="{{ __('app.reset') }}">
                </div>
            </form>
        </div>
    </div>
@endsection
