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
                <li id="tabLikes"><a href="javascript:void(0);" onclick="window.vue.showTabMenu('tabLikes'); document.getElementById('link-received-likes').click();">{{ __('app.likes') }}</a></li>
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

        <div id="tabLikes-form" class="tab-content">
            <div class="tabs">
                <ul>
                    <li id="tabLikes-Received" class="is-active"><a id="link-received-likes" href="javascript:void(0);" onclick="window.vue.showLikeTab('received'); document.getElementById('received-content').innerHTML = ''; document.getElementById('given-content').innerHTML = ''; window.paginateReceivedLikes = null; window.queryReceivedLikeList();">{{ __('app.received_likes') }}</a></li>
                    <li id="tabLikes-Given" class="is-active"><a href="javascript:void(0);" onclick="window.vue.showLikeTab('given'); document.getElementById('given-content').innerHTML = ''; document.getElementById('given-content').innerHTML = ''; window.paginateGivenLikes = null; window.queryGivenLikeList();">{{ __('app.given_likes') }}</a></li>
                </ul>
            </div>

            <div class="tab-content" id="tabLikes-Received-form">
                <div id="received-content"></div>
            </div>

            <div class="tab-content" id="tabLikes-Given-form">
                <div id="given-content"></div>
            </div>
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

                <div class="field form">
                    <label class="label">{{ __('app.language') }}</label>
                    <div class="control">
                        <select name="language">
                            @foreach (\App\Models\AppModel::getLanguageList() as $language)
                                <option value="{{ $language }}" @if ($user->language == $language) {{ 'selected' }} @endif>{{ $language }}</option>
                            @endforeach
                        </select>
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
            <form method="POST" action="{{ url('/member/photo/save') }}" enctype="multipart/form-data">
                @csrf

                <input type="hidden" name="which" value="avatar">

                <div class="field">
                    <div class="control">
                        <span class="settings-photo-image"><img src="{{ asset('gfx/avatars/' . $user->avatar) }}" alt="avatar"></span>
                        <span class="settings-photo-input"><input type="file" data-role="file" data-button-title="{{ __('app.select_photo') }}" name="image"></span>
                        <span><button class="button is-success" type="submit">{{ __('app.save') }}</button></span>
                    </div>
                </div>
            </form>

            <br/>

            <form method="POST" action="{{ url('/member/photo/save') }}" enctype="multipart/form-data">
                @csrf

                <input type="hidden" name="which" value="photo1">

                <div class="field">
                    <div class="control">
                        <span class="settings-photo-image"><img src="{{ asset('gfx/avatars/' . $user->photo1) }}" alt="photo"></span>
                        <span class="settings-photo-input"><input type="file" data-role="file" data-button-title="{{ __('app.select_photo') }}" name="image"></span>
                        <span><button class="button is-success" type="submit">{{ __('app.save') }}</button></span>
                    </div>
                </div>
            </form>

            <br/>

            <form method="POST" action="{{ url('/member/photo/save') }}" enctype="multipart/form-data">
                @csrf

                <input type="hidden" name="which" value="photo2">

                <div class="field">
                    <div class="control">
                        <span class="settings-photo-image"><img src="{{ asset('gfx/avatars/' . $user->photo2) }}" alt="photo"></span>
                        <span class="settings-photo-input"><input type="file" data-role="file" data-button-title="{{ __('app.select_photo') }}" name="image"></span>
                        <span><button class="button is-success" type="submit">{{ __('app.save') }}</button></span>
                    </div>
                </div>
            </form>

            <br/>

            <form method="POST" action="{{ url('/member/photo/save') }}" enctype="multipart/form-data">
                @csrf

                <input type="hidden" name="which" value="photo3">

                <div class="field">
                    <div class="control">
                        <span class="settings-photo-image"><img src="{{ asset('gfx/avatars/' . $user->photo3) }}" alt="photo"></span>
                        <span class="settings-photo-input"><input type="file" data-role="file" data-button-title="{{ __('app.select_photo') }}" name="image"></span>
                        <span><button class="button is-success" type="submit">{{ __('app.save') }}</button></span>
                    </div>
                </div>
            </form>
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

            @if ($user->admin)
                <hr/>

                <form method="POST" action="{{ url('member/geoexclude/save') }}">
                    @csrf

                    <div class="field">
                        <div class="control">
                            <input type="checkbox" name="geoexclude" data-role="checkbox" data-style="2" value="1" data-caption="{{ __('app.geoexclude_notice') }}" @if ($user->geo_exclude) {{ 'checked' }} @endif>
                        </div>
                    </div>

                    <div class="field">
                        <div class="control">
                            <button class="button is-success" type="submit">{{ __('app.save') }}</button>
                        </div>
                    </div>
                </form>
            @endif
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
            <div id="ignore-content"></div>
        </div>

        <div id="tabMembership-form" class="tab-content is-hidden">
            <div>
                @if ($user->state === \App\Models\VerifyModel::STATE_INPROGRESS)
                    <strong>{{ __('app.verification_in_progress') }}</strong>
                @elseif ($user->state === \App\Models\VerifyModel::STATE_VERIFIED)
                    <strong>{{ __('app.verification_succeeded') }}</strong>
                @else
                    <form method="POST" action="{{ url('/member/account/verify') }}" id="frmVerify" enctype="multipart/form-data">
                        @csrf

                        <div class="field">
                            <label class="label">
                                {{ __('app.verify_account') }}
                            </label>
                        </div>

                        <div class="field">
                            <label class="label">{{ __('app.identity_card_front') }}</label>
                            <div class="control">
                                <input type="file" name="idcard_front" data-role="file" data-type="2">
                            </div>
                        </div>

                        <div class="field">
                            <label class="label">{{ __('app.identity_card_back') }}</label>
                            <div class="control">
                                <input type="file" name="idcard_back" data-role="file" data-type="2">
                            </div>
                        </div>

                        <div class="field">
                            <div class="control">
                                <input type="checkbox" name="confirmation" data-role="checkbox" data-style="2" data-caption="{{ __('app.confirm_verify_permission') }}" value="1" onclick="if (this.checked) { document.getElementById('btnVerify').disabled = false; } else { document.getElementById('btnVerify').disabled = true; }">
                            </div>
                        </div>

                        <div class="field">
                            <div class="control">
                                <input type="button" class="button is-link" id="btnVerify" value="{{ __('app.submit') }}" onclick="if (!this.disabled) { document.getElementById('frmVerify').submit(); }" disabled>
                            </div>
                        </div>
                    </form>
                @endif

                <hr/>
            </div>

            <div>
                @if (env('STRIPE_ENABLE'))
                    @if (\App\Models\User::promodeExpired($user))   
                        <div class="field">
                            <div class="control">
                                <a href="javascript:void(0)" onclick="window.vue.bShowBuyProMode = true; window.vue.bShowEditProfile = false;" class="button is-success">{{ __('app.purchase_pro_mode') }}</a>
                            </div>
                        </div> 
                    @else
                        <strong>{{ __('app.promode_still_active', ['days' => env('STRIPE_EXPIRE_DAY_COUNT') - (\Illuminate\Support\Carbon::parse($user->last_payed)->diffInDays(\Illuminate\Support\Carbon::now()))]) }}</strong>
                    @endif

                    <hr/>
                @endif
            </div>

            <div>
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
    </div>

    @if (env('STRIPE_ENABLE') == true)
    <div class="modal" :class="{'is-active': bShowBuyProMode}">
        <div class="modal-background"></div>
        <div class="modal-card">
            <header class="modal-card-head is-stretched">
                <p class="modal-card-title">{{ __('app.buy_pro_mode_title') }}</p>
                <button class="delete" aria-label="close" onclick="vue.bShowBuyProMode = false;"></button>
            </header>
            <section class="modal-card-body is-stretched">
                <div class="field">
                    {!! __('app.buy_pro_mode_info', ['costs' => env('STRIPE_COSTS_LABEL'), 'days' => env('STRIPE_EXPIRE_DAY_COUNT')]) !!}
                </div>

                <form action="{{ url('/payment/charge') }}" method="post" id="payment-form" class="stripe">
                    @csrf

                    <div class="form-row">
                        <label for="card-element">
                            {{ __('app.credit_or_debit_card') }}
                        </label>
                        <div id="card-element"></div>

                        <div id="card-errors" role="alert"></div>
                    </div>

                    <br/>

                    <button class="button is-link">{{ __('app.submit_payment') }}</button>
                </form>
            </section>
            <footer class="modal-card-foot is-stretched">
                <button class="button" onclick="vue.bShowBuyProMode = false;">{{ __('app.close') }}</button>
            </footer>
        </div>
    </div>
    @endif
@endsection

@section('javascript')
    <script>
        window.paginateVisitors = null;
        window.paginateIgnoreList = null;
        window.paginateReceivedLikes = null;
        window.paginateGivenLikes = null;

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

        window.queryReceivedLikeList = function() {
            let content = document.getElementById('received-content');

            let loadmore = document.getElementById('received-loadmore');
            if (loadmore) {
                loadmore.remove();
            }

            content.innerHTML += '<div id="received-spinner"><center><i class="fa fa-spinner fa-spin"></i></center></div>';

            window.vue.ajaxRequest('post', '{{ url('/member/likes/received/query') }}', { paginate: window.paginateReceivedLikes }, function(response){
                if (response.code == 200) {
                    let spinner = document.getElementById('received-spinner');
                    if (spinner) {
                        spinner.remove();
                    }

                    response.data.forEach(function(elem, index){
                        let html = window.vue.renderLikedProfile(elem);

                        content.innerHTML += html;
                    });

                    if (response.data.length === 0) {
                        content.innerHTML += '<div><br/>{{ __('app.no_more_users') }}</div>';
                    } else {
                        window.paginateReceivedLikes = response.data[response.data.length - 1].id;

                        content.innerHTML += '<div id="received-loadmore"><br/><center><i class="fas fa-arrow-down is-pointer" onclick="window.queryReceivedLikeList();"></i></center></div>';
                    }
                } else {
                    console.error(response);
                }
            });
        };

        window.queryGivenLikeList = function() {
            let content = document.getElementById('given-content');

            let loadmore = document.getElementById('given-loadmore');
            if (loadmore) {
                loadmore.remove();
            }

            content.innerHTML += '<div id="given-spinner"><center><i class="fa fa-spinner fa-spin"></i></center></div>';

            window.vue.ajaxRequest('post', '{{ url('/member/likes/given/query') }}', { paginate: window.paginateGivenLikes }, function(response){
                if (response.code == 200) {
                    let spinner = document.getElementById('given-spinner');
                    if (spinner) {
                        spinner.remove();
                    }

                    response.data.forEach(function(elem, index){
                        let html = window.vue.renderLikedProfile(elem);

                        content.innerHTML += html;
                    });

                    if (response.data.length === 0) {
                        content.innerHTML += '<div><br/>{{ __('app.no_more_users') }}</div>';
                    } else {
                        window.paginateGivenLikes = response.data[response.data.length - 1].id;

                        content.innerHTML += '<div id="given-loadmore"><br/><center><i class="fas fa-arrow-down is-pointer" onclick="window.queryGivenLikeList();"></i></center></div>';
                    }
                } else {
                    console.error(response);
                }
            });
        };

        window.queryIgnoreList = function() {
            let content = document.getElementById('ignore-content');

            let loadmore = document.getElementById('ignore-loadmore');
            if (loadmore) {
                loadmore.remove();
            }

            content.innerHTML += '<div id="ignore-spinner"><center><i class="fa fa-spinner fa-spin"></i></center></div>';

            window.vue.ajaxRequest('post', '{{ url('/member/ignores/query') }}', { paginate: window.paginateIgnoreList }, function(response){
                if (response.code == 200) {
                    let spinner = document.getElementById('ignore-spinner');
                    if (spinner) {
                        spinner.remove();
                    }

                    response.data.forEach(function(elem, index){
                        let html = window.vue.renderIgnoreProfile(elem);

                        content.innerHTML += html;
                    });

                    if (response.data.length === 0) {
                        content.innerHTML += '<div><br/>{{ __('app.no_more_users') }}</div>';
                    } else {
                        window.paginateIgnoreList = response.data[response.data.length - 1].id;

                        content.innerHTML += '<div id="ignore-loadmore"><br/><center><i class="fas fa-arrow-down is-pointer" onclick="window.queryIgnoreList();"></i></center></div>';
                    }
                } else {
                    console.error(response);
                }
            });
        };

        const stripeTokenHandler = (token) => {
            const form = document.getElementById('payment-form');
            const hiddenInput = document.createElement('input');
            hiddenInput.setAttribute('type', 'hidden');
            hiddenInput.setAttribute('name', 'stripeToken');
            hiddenInput.setAttribute('value', token.id);
            form.appendChild(hiddenInput);
            form.submit();
        }

        document.addEventListener('DOMContentLoaded', function() {
            window.queryVisitors();
            window.queryIgnoreList();

            @if (isset($_GET['tab']))
                @if ($_GET['tab'] === 'visitors')
                    window.vue.showTabMenu('tabVisitors');
                @elseif ($_GET['tab'] === 'likes')
                    window.vue.showTabMenu('tabLikes');
                    document.getElementById('link-received-likes').click();
                @elseif ($_GET['tab'] === 'profile')
                    window.vue.showTabMenu('tabProfile');
                @elseif ($_GET['tab'] === 'photos')
                    window.vue.showTabMenu('tabPhotos');
                @elseif ($_GET['tab'] === 'security')
                    window.vue.showTabMenu('tabSecurity');
                @elseif ($_GET['tab'] === 'notifications')
                    window.vue.showTabMenu('tabNotifications');
                @elseif ($_GET['tab'] === 'ignorelist')
                    window.vue.showTabMenu('tabIgnoreList');
                @elseif ($_GET['tab'] === 'membership')
                    window.vue.showTabMenu('tabMembership');
                @endif
            @endif

            @if (env('STRIPE_ENABLE') == true)
				var stripe = Stripe('{{ env('STRIPE_TOKEN_PUBLIC') }}');
				var elements = stripe.elements();

				const style = {
					base: {
						fontSize: '16px',
						color: '#32325d',
					},
				};

				const card = elements.create('card', {style});
				card.mount('#card-element');

				const form = document.getElementById('payment-form');
				form.addEventListener('submit', async (event) => {
					event.preventDefault();

					const {token, error} = await stripe.createToken(card);

					if (error) {
						const errorElement = document.getElementById('card-errors');
						errorElement.textContent = error.message;
					} else {
						stripeTokenHandler(token);
					}
				});
			@endif
        });
    </script>
@endsection
