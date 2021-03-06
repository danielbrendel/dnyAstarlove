{{--
    Astarlove (dnyAstarlove) developed by Daniel Brendel

    (C) 2021 - 2022 by Daniel Brendel

    Contact: dbrendel1988<at>gmail<dot>com
    GitHub: https://github.com/danielbrendel/

    Released under the MIT license
--}}

@extends('layouts.layout_home')

@section('title', env('APP_NAME') . ' - ' . __('app.random'))

@section('content')
    <div class="form">
        @include('widgets.profile', ['user' => $user, 'hide_back_link' => true])

        <div>
            <br/><br/>
            <a href="{{ url('/random') }}" class="button is-link">{{ __('app.next_profile') }}</a>
        </div>
    </div>
@endsection
