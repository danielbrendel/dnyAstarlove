{{--
    Astarlove (dnyAstarlove) developed by Daniel Brendel

    (C) 2021 by Daniel Brendel

    Contact: dbrendel1988<at>gmail<dot>com
    GitHub: https://github.com/danielbrendel/

    Released under the MIT license
--}}

@extends('layouts.layout_home')

@section('title', env('APP_NAME'))

@section('content')
    <div class="form">
        <h4>{{ __('app.welcome_dashboard', ['name' => $user->name]) }}</h4>

        <p>
            {!! __('app.dashboard_find_members', ['url' => url('/profiles')]) !!}
        </p>

        <p>
            {!! __('app.dashboard_new_messages', ['count' => $user->message_count, 'url' => url('/messages')]) !!}
        </p>

        <p>
            @if ($user->verify_state == \App\Models\VerifyModel::STATE_INPROGRESS)
                {{ __('app.dashboard_verification_inprogress') }}
            @elseif ($user->verify_state == \App\Models\VerifyModel::STATE_VERIFIED)
                {{ __('app.dashboard_verified') }}
            @elseif ($user->verify_state == \App\Models\VerifyModel::STATE_DECLINED)
                {!! __('app.dashboard_declined', ['url' => url('/settings?tab=membership')]) !!}
            @else
                {!! __('app.dashboard_not_verified', ['url' => url('/settings?tab=membership')]) !!}
            @endif
        </p>

        @if (env('STRIPE_ENABLE'))
            <p>
                @if ($user->promode)
                    {{ __('app.dashboard_promode_active', ['days' => $user->promode_count]) }}
                @else
                    {!! __('app.dashboard_promode_not_active', ['url' => url('/settings?tab=membership')]) !!}
                @endif
            </p>
        @endif

        <p>
            <strong>{{ __('app.last_members') }}:</strong><br>
            @include('widgets.lastmembers')
        </p>
    </div>
@endsection
