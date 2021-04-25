
@foreach (\App\Models\User::getLastRegisteredMembers(env('APP_LASTREGPROFILESCOUNT')) as $member)
    <div class="home-member">
        <div class="home-member-avatar">
            <img src="{{ asset('gfx/avatars/' . $member->avatar) }}" alt="avatar">

            @if (\App\Models\User::isMemberOnline($member->id))
                <span class="is-online" title="{{ Illuminate\Support\Carbon::parse($member->last_action)->diffForHumans() }}"></span>
            @endif 
        </div>

        <div class="home-member-name">{{ $member->name }}</div>
    </div>
@endforeach