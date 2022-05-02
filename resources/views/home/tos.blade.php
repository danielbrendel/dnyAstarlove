{{--
    Astarlove (dnyAstarlove) developed by Daniel Brendel

    (C) 2021 - 2022 by Daniel Brendel

    Contact: dbrendel1988<at>gmail<dot>com
    GitHub: https://github.com/danielbrendel/

    Released under the MIT license
--}}

@extends('layouts.layout_home')

@section('title', env('APP_NAME') . ' - ' . __('app.tos'))

@section('content')
    <div class="form">
        <div class="has-text-centered info-headline"><h1>{{ __('app.tos') }}</h1></div>

        <div>
            {!! $tos_content !!}
        </div>

        @if ((!isset($_GET['ngb'])) || ($_GET['ngb'] == 0))
        <div class="home-go-back">
            <a href="javascript:window.history.back();">{{ __('app.go_back') }}</a>
        </div>
        @endif
    </div>
@endsection
