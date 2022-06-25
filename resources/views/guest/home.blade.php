{{--
    Astarlove (dnyAstarlove) developed by Daniel Brendel

    (C) 2021 - 2022 by Daniel Brendel

    Contact: dbrendel1988<at>gmail<dot>com
    GitHub: https://github.com/danielbrendel/

    Released under the MIT license
--}}

@extends('layouts.layout_home')

@section('title', env('APP_NAME'))

@section('content')
    <div class="home-headline">
        <h1>{{ $settings->headline }}</h1>
    </div>

    <div class="home-subline">
        <h2>{{ $settings->subline }}</h2>
    </div>

    <div class="home-description">
        {!! $settings->description !!}
    </div>

    <div class="home-features">
        @foreach ($features as $feature)
            <div class="feature-item">
                <div class="feature-item-header">
                    <div class="feature-item-icon"><i class="far fa-heart is-red"></i></div>
                    <div class="feature-item-title">{{ $feature->title }}</div>
                </div>

                <div class="feature-item-description">
                    {{ $feature->description }}
                </div>
            </div>
        @endforeach
    </div>

    <h3 class="is-color-white">{{ __('app.latest_members') }}</h3>
    <div class="home-members">
        @include('widgets.lastmembers')
    </div>
@endsection