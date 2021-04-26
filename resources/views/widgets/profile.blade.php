{{--
    Astarlove (dnyAstarlove) developed by Daniel Brendel

    (C) 2021 by Daniel Brendel

    Contact: dbrendel1988<at>gmail<dot>com
    GitHub: https://github.com/danielbrendel/

    Released under the MIT license
--}}

<div class="user">
    <div class="user-frame-top">
        <div class="user-frame-left">
            <div class="user-photos">
                <div class="user-photos-avatar">
                    <img src="{{ asset('gfx/avatars/' . $user->avatar) }}" alt="avatar">
                </div>

                <div class="user-photos-photos">
                    <div class="user-photos-photo">
                        @if ($user->photo1 !== null)
                            <img src="{{ asset('gfx/avatars/' . $user->photo1) }}" alt="photo">
                        @else
                            <img src="{{ asset('gfx/avatars/default.png') }}" alt="photo">
                        @endif
                    </div>

                    <div class="user-photos-photo">
                        @if ($user->photo2 !== null)
                            <img src="{{ asset('gfx/avatars/' . $user->photo2) }}" alt="photo">
                        @else
                            <img src="{{ asset('gfx/avatars/default.png') }}" alt="photo">
                        @endif
                    </div>

                    <div class="user-photos-photo">
                        @if ($user->photo3 !== null)
                            <img src="{{ asset('gfx/avatars/' . $user->photo3) }}" alt="photo">
                        @else
                            <img src="{{ asset('gfx/avatars/default.png') }}" alt="photo">
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="user-frame-right">
            <div class="user-name">
                {{ '@' . $user->name }}
            </div>

            @if (($user->realname !== null) && (strlen($user->realname) > 0))
                <div class="user-realname">
                    {{ $user->realname }}
                </div>
            @endif

            <div class="user-online">
                @if ($user->is_online)
                    <span class="is-color-green">{{ __('app.online') }}</span>
                @else
                    <span class="is-color-grey">{{ __('app.last_seen', ['diff' => $user->last_seen]) }}</span>
                @endif
            </div>

            <div class="user-baseinfos">
                <span><i class="fas fa-birthday-cake" title="{{ __('app.age') }}"></i>&nbsp;{{ $user->age }}&nbsp;&nbsp;</span>
                <span><i class="fas fa-transgender-alt" title="{{ __('app.gender') }}"></i>&nbsp;{{ $user->gender }}&nbsp;&nbsp;</span>
                <span><i class="fas fa-map-marker-alt" title="{{ __('app.location') }}"></i>&nbsp;@if ($user->location !== null) {{ $user->location }} @else {{ 'n/a' }} @endif&nbsp;&nbsp;</span>
                <span><i class="fas fa-heart" title="{{ __('app.relationship_status') }}"></i>&nbsp;{{ $user->rel_status }}&nbsp;&nbsp;</span>
                <span><i class="fas fa-arrows-alt-v" title="{{ __('app.height') }}"></i>&nbsp;@if ($user->height !== null) {{ $user->height }} @else {{ 'n/a' }} @endif&nbsp;&nbsp;</span>
                <span><i class="fas fa-weight" title="{{ __('app.weight') }}"></i>&nbsp;@if ($user->weight !== null) {{ $user->weight }} @else {{ 'n/a' }} @endif&nbsp;&nbsp;</span>
                <span><i class="fas fa-user-tie" title="{{ __('app.job') }}"></i>&nbsp;@if ($user->job !== null) {{ $user->job }} @else {{ 'n/a' }} @endif&nbsp;&nbsp;</span>
            </div>

            <div class="user-introduction">
                @if (($user->introduction !== null) && (strlen($user->introduction) > 0))
                    {{ $user->introduction }}
                @else
                    {{ __('app.no_introduction_specified') }}
                @endif
            </div>

            <div class="user-options">
                <span><a class="button is-success">{{ __('app.message') }}</a></span>
                <span><a class="button is-link">{{ __('app.favorite') }}</a></span>
                <span class="float-right"><a href="">{{ __('app.ignore') }}&nbsp;</a></span>
                <span class="float-right"><a href="">{{ __('app.report') }}&nbsp;|&nbsp;</a></span>
            </div>
        </div>
    </div>

    <div class="user-frame-bottom">
        <div class="user-text-info">
            <h3>{{ __('app.interests') }}</h3>

            @if (($user->interests !== null) && (strlen($user->interests) > 0))
                {{ $user->interests }}
            @else
                {{ __('app.no_information_specified') }}
            @endif
        </div>

        <div class="user-text-info">
            <h3>{{ __('app.music') }}</h3>

            @if (($user->music !== null) && (strlen($user->music) > 0))
                {{ $user->music }}
            @else
                {{ __('app.no_information_specified') }}
            @endif
        </div>
    </div>
</div>