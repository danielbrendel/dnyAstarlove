
{{--
    Astarlove (dnyAstarlove) developed by Daniel Brendel

    (C) 2021 by Daniel Brendel

    Contact: dbrendel1988<at>gmail<dot>com
    GitHub: https://github.com/danielbrendel/

    Released under the MIT license
--}}

@foreach (\App\Models\User::getLastRegisteredMembers(env('APP_LASTREGPROFILESCOUNT')) as $member)
    <div class="home-member">
        <div class="home-member-avatar">
            <img src="{{ asset('gfx/avatars/' . $member->avatar) }}" class="is-pointer" onclick="@auth {{ 'window.location = \'' . url('/user/' . $member->name) . '\';' }} @elseguest {{ 'window.vue.bShowLogin = true;' }} @endauth" alt="avatar">

            @if (\App\Models\User::isMemberOnline($member->id))
                <span class="is-online" title="{{ Illuminate\Support\Carbon::parse($member->last_action)->diffForHumans() }}"></span>
            @endif 
        </div>

        <div class="home-member-name">
            <a class="is-color-white" href="javascript:void(0);" onclick="@auth {{ 'window.location = \'' . url('/user/' . $member->name) . '\';' }} @elseguest {{ 'window.vue.bShowLogin = true;' }} @endauth">{{ $member->name }}</a>
        </div>
    </div>
@endforeach