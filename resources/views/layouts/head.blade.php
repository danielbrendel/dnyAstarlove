{{--
    Astarlove (dnyAstarlove) developed by Daniel Brendel

    (C) 2021 by Daniel Brendel

    Contact: dbrendel1988<at>gmail<dot>com
    GitHub: https://github.com/danielbrendel/

    Released under the MIT license
--}}

<meta charset="utf-8">
<meta name="author" content="{{ env('APP_AUTHOR') }}">
<meta name="description" content="{{ env('APP_DESCRIPTION') }}">
<meta name="keywords" content="{{ env('APP_KEYWORDS') }}">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>@yield('title')</title>

<link rel="stylesheet" type="text/css" href="{{ asset('css/bulma.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('css/metro-all.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('css/quill.core.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('css/quill.snow.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}">

<link rel="icon" type="image/png" href="{{ asset('logo.png') }}">

@if (env('APP_ENV') === 'production')
    <script src="{{ asset('js/vue.js') }}"></script>
@else
    <script src="{{ asset('js/vue.js') }}"></script>
@endif
<script src="{{ asset('js/fontawesome.js') }}"></script>
<script src="{{ asset('js/metro.min.js') }}"></script>
<script src="{{ asset('js/quill.min.js') }}"></script>
<script src="{{ asset('js/push.min.js') }}"></script>
@auth
    @if (env('STRIPE_ENABLE'))
        <script src="https://js.stripe.com/v3/"></script>
    @endif
@endauth

{!! \App\Models\AppModel::getHeadCode() !!}
