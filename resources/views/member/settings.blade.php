{{--
    Astarlove (dnyAstarlove) developed by Daniel Brendel

    (C) 2021 by Daniel Brendel

    Contact: dbrendel1988<at>gmail<dot>com
    GitHub: https://github.com/danielbrendel/

    Released under the MIT license
--}}

@extends('layouts.layout_home')

@section('title', env('APP_NAME') . ' - ' . __('app.settings'))

@section('content')
    <div class="form">
        <h2>{{ __('app.settings') }}</h2>
        <br/>

        <div class="tabs">
            <ul>
                <li id="tabVisitors" class="is-active"><a href="javascript:void(0);" onclick="window.vue.showTabMenu('tabVisitors');">{{ __('app.visitors') }}</a></li>
                <li id="tabProfile"><a href="javascript:void(0);" onclick="window.vue.showTabMenu('tabProfile');">{{ __('app.profile') }}</a></li>
                <li id="tabPhotos"><a href="javascript:void(0);" onclick="window.vue.showTabMenu('tabPhotos');">{{ __('app.photos') }}</a></li>
                <li id="tabSecurity"><a href="javascript:void(0);" onclick="window.vue.showTabMenu('tabSecurity');">{{ __('app.security') }}</a></li>
                <li id="tabNotifications"><a href="javascript:void(0);" onclick="window.vue.showTabMenu('tabNotifications');">{{ __('app.notifications') }}</a></li>
                <li id="tabIgnoreList"><a href="javascript:void(0);" onclick="window.vue.showTabMenu('tabIgnoreList');">{{ __('app.ignore_list') }}</a></li>
                <li id="tabMembership"><a href="javascript:void(0);" onclick="window.vue.showTabMenu('tabMembership');">{{ __('app.membership') }}</a></li>
            </ul>
        </div>

        <div id="tabVisitors-form" class="tab-content">
            <div id="visitor-content"></div>
        </div>

        <div id="tabProfile-form" class="tab-content is-hidden">
            <form method="POST" action="{{ url('/member/profile/save') }}">
                @csrf

                <div class="field">
                    <label class="label">{{ __('app.register_username') }}</label>
                    <div class="control">
                        <input class="input" type="text" name="username" onchange="if (this.value !== '{{ $user->name }}') window.vue.showUsernameValidity(this.value, document.getElementById('settings-username-validity')); else document.getElementById('settings-username-validity').innerHTML = '';" onkeyup="if (this.value !== '{{ $user->name }}') window.vue.showUsernameValidity(this.value, document.getElementById('settings-username-validity')); else document.getElementById('settings-username-validity').innerHTML = '';" value="{{ $user->name }}" required>
                    </div>
                    <p id="settings-username-validity" class="help"></p>
                </div>

                <div class="field">
                    <label class="label">{{ __('app.realname') }}</label>
                    <div class="control">
                        <input type="text" class="input" name="realname" value="{{ $user->realname }}">
                    </div>
                </div>

                <div class="field">
                    <label class="label">{{ __('app.birthday') }}</label>
                    <div class="control">
                        <input type="date" class="input" name="birthday" value="{{ $user->birthday }}">
                    </div>
                </div>

                <div class="field">
                    <label class="label">{{ __('app.gender') }}</label>
                    <div class="control">
                        <select name="gender">
                            <option value="{{ \App\Models\User::GENDER_MALE }}" @if ($user->gender === \App\Models\User::GENDER_MALE) {{ 'selected' }} @endif>{{ __('app.gender_male') }}</option>
                            <option value="{{ \App\Models\User::GENDER_FEMALE }}" @if ($user->gender === \App\Models\User::GENDER_FEMALE) {{ 'selected' }} @endif>{{ __('app.gender_female') }}</option>
                            <option value="{{ \App\Models\User::GENDER_DIVERSE }}" @if ($user->gender === \App\Models\User::GENDER_DIVERSE) {{ 'selected' }} @endif>{{ __('app.gender_diverse') }}</option>
                        </select>
                    </div>
                </div>

                <div class="field">
                    <label class="label">{{ __('app.height') }}</label>
                    <div class="control">
                        <input type="number" class="input" name="height" value="{{ $user->height }}">
                    </div>
                </div>

                <div class="field">
                    <label class="label">{{ __('app.weight') }}</label>
                    <div class="control">
                        <input type="number" class="input" name="weight" value="{{ $user->weight }}">
                    </div>
                </div>

                <div class="field">
                    <label class="label">{{ __('app.relationship_status') }}</label>
                    <div class="control">
                        <input type="text" class="input" name="rel_status" value="{{ $user->rel_status }}">
                    </div>
                </div>

                <div class="field">
                    <label class="label">{{ __('app.location') }}</label>
                    <div class="control">
                        <input type="text" class="input" name="location" value="{{ $user->location }}">
                    </div>
                </div>

                <div class="field">
                    <label class="label">{{ __('app.job') }}</label>
                    <div class="control">
                        <input type="text" class="input" name="job" value="{{ $user->job }}">
                    </div>
                </div>

                <div class="field form">
                    <label class="label">{{ __('app.introduction') }}</label>
                    <div class="control">
                        <div id="text-introduction"></div>
                        <textarea name="introduction" id="post-text-introduction" class="is-hidden" placeholder="{{ __('app.type_something') }}">{{ $user->introduction }}</textarea>
                    </div>
                </div>

                <div class="field form">
                    <label class="label">{{ __('app.interests') }}</label>
                    <div class="control">
                        <div id="text-interests"></div>
                        <textarea name="interests" id="post-text-interests" class="is-hidden" placeholder="{{ __('app.type_something') }}">{{ $user->interests }}</textarea>
                    </div>
                </div>

                <div class="field form">
                    <label class="label">{{ __('app.music') }}</label>
                    <div class="control">
                        <div id="text-music"></div>
                        <textarea name="music" id="post-text-music" class="is-hidden" placeholder="{{ __('app.type_something') }}">{{ $user->music }}</textarea>
                    </div>
                </div>

                <div class="field">
                    <div class="control">
                        <br/>
                        <button class="button is-success" type="submit">{{ __('app.save') }}</button>
                    </div>
                </div>
            </form>
        </div>

        <div id="tabPhotos-form" class="tab-content is-hidden">
        c
        </div>

        <div id="tabSecurity-form" class="tab-content is-hidden">
            <form method="POST" action="{{ url('/member/password/save') }}">
                @csrf

                <div class="field">
                    <label class="label">{{ __('app.password') }}</label>
                    <div class="control">
                        <input type="password" name="password">
                    </div>
                </div>

                <div class="field">
                    <label class="label">{{ __('app.password_confirmation') }}</label>
                    <div class="control">
                        <input type="password" name="password_confirmation">
                    </div>
                </div>

                <div class="field">
                    <div class="control">
                        <button class="button is-success" type="submit">{{ __('app.save') }}</button>
                    </div>
                </div>
            </form>

            <hr/>

            <form method="POST" action="{{ url('/member/email/save') }}">
                @csrf

                <div class="field">
                    <label class="label">{{ __('app.email') }}</label>
                    <div class="control">
                        <input type="text" name="email" value="{{ $user->email }}">
                    </div>
                </div>

                <div class="field">
                    <div class="control">
                        <button class="button is-success" type="submit">{{ __('app.save') }}</button>
                    </div>
                </div>
            </form>
        </div>

        <div id="tabNotifications-form" class="tab-content is-hidden">
            <form method="POST" action="{{ url('/member/notifications/save') }}">
                @csrf
                
                <div class="field">
                    <div class="control">
                        <input type="checkbox" name="mail_on_message" data-role="checkbox" data-style="2" value="1" data-caption="{{ __('app.mail_on_message') }}" @if ($user->mail_on_message) {{ 'checked' }} @endif>
                    </div>
                </div>

                <div class="field">
                    <div class="control">
                        <input type="checkbox" name="newsletter" data-role="checkbox" data-style="2" value="1" data-caption="{{ __('app.newsletter_notice') }}" @if ($user->newsletter) {{ 'checked' }} @endif>
                    </div>
                </div>

                <div class="field">
                    <div class="control">
                        <button class="button is-success" type="submit">{{ __('app.save') }}</button>
                    </div>
                </div>
            </form>
        </div>

        <div id="tabIgnoreList-form" class="tab-content is-hidden">
        f
        </div>

        <div id="tabMembership-form" class="tab-content is-hidden">
            <form method="POST" action="{{ url('/member/account/delete') }}">
                @csrf

                <p>
                    {{ __('app.account_removal_hint') }}
                </p>

                <div class="field">
                    <label class="label">{!! __('app.enter_keyphrase', ['phrase' => env('APP_KEYPHRASE')]) !!}</label>
                    <div class="control">
                        <input type="text" name="keyphrase">
                    </div>
                </div>

                <div class="field">
                    <div class="control">
                        <button class="button is-danger" type="submit">{{ __('app.delete') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('javascript')
    <script>
        window.paginateVisitors = null;

        var quillIntroduction = new Quill('#text-introduction', {
            theme: 'snow',
            placeholder: '{{ __('app.type_something') }}',
        });

        quillIntroduction.root.innerHTML = document.getElementById('post-text-introduction').value;

        quillIntroduction.on('editor-change', function(eventName, ...args) {
            document.getElementById('post-text-introduction').value = quillIntroduction.root.innerHTML;
        });

        var quillInterests = new Quill('#text-interests', {
            theme: 'snow',
            placeholder: '{{ __('app.type_something') }}',
        });

        quillInterests.root.innerHTML = document.getElementById('post-text-interests').value;

        quillInterests.on('editor-change', function(eventName, ...args) {
            document.getElementById('post-text-interests').value = quillInterests.root.innerHTML;
        });

        var quillMusic = new Quill('#text-music', {
            theme: 'snow',
            placeholder: '{{ __('app.type_something') }}',
        });

        quillMusic.root.innerHTML = document.getElementById('post-text-music').value;

        quillMusic.on('editor-change', function(eventName, ...args) {
            document.getElementById('post-text-music').value = quillMusic.root.innerHTML;
        });

        window.queryVisitors = function() {
            let content = document.getElementById('visitor-content');

            let loadmore = document.getElementById('visitor-loadmore');
            if (loadmore) {
                loadmore.remove();
            }

            content.innerHTML += '<div id="visitor-spinner"><center><i class="fa fa-spinner fa-spin"></i></center></div>';

            window.vue.ajaxRequest('post', '{{ url('/member/visitors/query') }}', { paginate: window.paginateVisitors }, function(response){
                if (response.code == 200) {
                    let spinner = document.getElementById('visitor-spinner');
                    if (spinner) {
                        spinner.remove();
                    }

                    response.data.forEach(function(elem, index){
                        let html = window.vue.renderVisitorProfile(elem);

                        content.innerHTML += html;
                    });

                    if (response.data.length === 0) {
                        content.innerHTML += '<div><br/>{{ __('app.no_more_visitors') }}</div>';
                    } else {
                        window.paginateVisitors = response.data[response.data.length - 1].updated_at;

                        content.innerHTML += '<div id="visitor-loadmore"><br/><center><i class="fas fa-arrow-down is-pointer" onclick="window.queryVisitors();"></i></center></div>';
                    }
                } else {
                    console.error(response);
                }
            });
        };

        document.addEventListener('DOMContentLoaded', function() {
            window.queryVisitors();
        });
    </script>
@endsection
