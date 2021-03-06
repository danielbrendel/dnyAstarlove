{{--
    Astarlove (dnyAstarlove) developed by Daniel Brendel

    (C) 2021 - 2022 by Daniel Brendel

    Contact: dbrendel1988<at>gmail<dot>com
    GitHub: https://github.com/danielbrendel/

    Released under the MIT license
--}}

<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('layouts.head')
    </head>

    <body style="background-image: url('{{ asset('gfx/backgrounds/' . \App\Models\AppModel::getBackground()) }}');">
        <div id="main" style="background-color: rgba(0, 0, 0, {{ \App\Models\AppModel::getAlphaChannel() }});">
            @include('layouts.navbar')

            <div class="content">
                @if ($errors->any())
                    <div id="error-message-1" class="is-z-index-3">
                        <article class="message is-danger">
                            <div class="message-header">
                                <p>{{ __('app.error') }}</p>
                                <button class="delete" aria-label="delete" onclick="document.getElementById('error-message-1').style.display = 'none';"></button>
                            </div>
                            <div class="message-body">
                                @foreach ($errors->all() as $error)
                                    {{ $error }}<br/>
                                @endforeach
                            </div>
                        </article>
                        <br/>
                    </div>
                @endif

                @if (Session::has('error'))
                    <div id="error-message-2" class="is-z-index-3">
                        <article class="message is-danger">
                            <div class="message-header">
                                <p>{{ __('app.error') }}</p>
                                <button class="delete" aria-label="delete" onclick="document.getElementById('error-message-2').style.display = 'none';"></button>
                            </div>
                            <div class="message-body">
                                {!! Session::get('error') !!}
                            </div>
                        </article>
                        <br/>
                    </div>
                @endif

                <div class="flash is-flash-error" id="flash-error">
                    <p id="flash-error-content">
                        @if (Session::has('flash.error'))
                            {!! Session::get('flash.error') !!}
                        @endif
                    </p>
                </div>

                <div class="flash is-flash-success" id="flash-success">
                    <p id="flash-success-content">
                        @if (Session::has('flash.success'))
                            {!! Session::get('flash.success') !!}
                        @endif
                    </p>
                </div>

                @if (Session::has('notice'))
                    <div id="notice-message" class="is-z-index-3">
                        <article class="message is-info">
                            <div class="message-header">
                                <p>{{ __('app.notice') }}</p>
                                <button class="delete" aria-label="delete" onclick="document.getElementById('notice-message').style.display = 'none';"></button>
                            </div>
                            <div class="message-body">
                                {!! Session::get('notice') !!}
                            </div>
                        </article>
                        <br/>
                    </div>
                @endif

                @if (Session::has('success'))
                    <div id="success-message" class="is-z-index-3">
                        <article class="message is-success">
                            <div class="message-header">
                                <p>{{ __('app.success') }}</p>
                                <button class="delete" aria-label="delete" onclick="document.getElementById('success-message').style.display = 'none';"></button>
                            </div>
                            <div class="message-body">
                                {!! Session::get('success') !!}
                            </div>
                        </article>
                        <br/>
                    </div>
                @endif

                @yield('announcements')

                <div class="container">
                    <div class="app-overlay" id="notifications">
                        <center><div class="overlay-arrow-up"></div></center>

                        <div>
                            <div class="is-inline-block"></div>
                            <div class="is-inline-block float-right overlay-close-action is-pointer" onclick="window.vue.toggleOverlay('notifications'); if (window.menuVisible) { document.getElementById('navbarMenu').classList.remove('is-active'); document.getElementById('navbarBurger').classList.remove('is-active'); }">{{ __('app.close') }}</div>
                        </div>

                        <div class="overlay-content" id="notification-content"></div>
                    </div>

                    <div class="app-overlay is-right-favorites" id="favorites">
                        <center><div class="overlay-arrow-up"></div></center>

                        <div>
                            <div class="is-inline-block"></div>
                            <div class="is-inline-block float-right overlay-close-action is-pointer" onclick="window.vue.toggleOverlay('favorites'); if (window.menuVisible) { document.getElementById('navbarMenu').classList.remove('is-active'); document.getElementById('navbarBurger').classList.remove('is-active'); }">{{ __('app.close') }}</div>
                        </div>

                        <div class="overlay-content" id="favorites-content"></div>
                    </div>

                    @if (env('APP_ENABLEADS'))
                        @include('widgets.bannerad')
                    @else 
                        <div class="columns">
                            <div class="column is-2"></div>

                            <div class="column is-8">
                                @yield('content')
                            </div>

                            <div class="column is-2"></div>
                        </div>
                    @endif
                </div>

                @guest
                    @include('widgets.login')
                    @include('widgets.register')
                    @include('widgets.recover')
                @endguest
            </div>

            @include('widgets.cookienotice')
            @include('widgets.bottombar')
        </div>

        <script src="{{ asset('js/app.js') }}"></script>
        <script>
            window.menuVisible = false;

            window.pushClientNotification = function(msg) {
                Push.create('{{ env('APP_NAME') }}', {
                    body: msg,
                    icon: '{{ asset('logo.png') }}',
                    timeout: 4000,
                    onClick: function () {
                        window.focus();
                        this.close();
                    }
                });
            };

            window.transferGeolocation = function(geodata) {
                let latitude = geodata.coords.latitude;
                let longitude = geodata.coords.longitude;

                window.vue.ajaxRequest('post', '{{ url('/member/geo') }}', { latitude: latitude, longitude: longitude }, function(response) {
                    if (response.code == 500) {
                        console.error(response.msg);
                    }
                });
            };

            window.queryGeoLocation = function() {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(window.transferGeolocation);
                }
            };

            window.gotNewNotifications = false;
            window.fetchNotifications = function() {
                window.vue.ajaxRequest('get', '{{ url('/notifications/list?mark=0') }}', {}, function(response){
                    if (response.code === 200) {
                        if (response.data.length > 0) {
                            window.gotNewNotifications = true;

                            let noyet = document.getElementById('no-notifications-yet');
                            if (noyet) {
                                noyet.remove();
                            }

                            let indicator = document.getElementById('navbar-notify-wrapper');
                            if (indicator) {
                                indicator.classList.remove('is-hidden');

                                count = document.getElementById('navbar-notify-count');
                                if (count) {
                                    count.innerHTML = response.data.length;
                                }
                            }

                            let burgerSpan = document.getElementById('burger-notification');
                            if (burgerSpan) {
                                burgerSpan.style.display = 'unset';
                            }

                            response.data.forEach(function(elem, index) {
                                if (document.getElementById('notification-item-' + elem.id) === null) {
                                    @if (isset($_GET['clep_push_handler']))
                                        if (typeof window['{{ $_GET['clep_push_handler'] }}'] === 'function') {
                                            window['{{ $_GET['clep_push_handler'] }}'](elem.shortMsg, elem.longMsg);
                                        }
                                    @else
                                        window.pushClientNotification(elem.shortMsg);
                                    @endif

                                    let html = window.vue.renderNotification(elem, true); 
                                    document.getElementById('notification-content').innerHTML = html + document.getElementById('notification-content').innerHTML;
                                }
                            });
                        }
                    }
                });

                setTimeout('fetchNotifications()', 50000);
            };

            window.notificationPagination = null;
            window.fetchNotificationList = function() {
                document.getElementById('notification-content').innerHTML += '<center><i id="notification-spinner" class="fas fa-spinner fa-spin"></i></center>';

                let loader = document.getElementById('load-more-notifications');
                if (loader) {
                    loader.remove();
                }

                window.vue.ajaxRequest('get', '{{ url('/notifications/fetch') }}' + ((window.notificationPagination) ? '?paginate=' + window.notificationPagination : ''), {}, function(response) {
                    if (response.code === 200) {
                        if (response.data.length > 0) {
                            let noyet = document.getElementById('no-notifications-yet');
                            if (noyet) {
                                noyet.remove();
                            }

                            response.data.forEach(function(elem, index) {
                                let html = window.vue.renderNotification(elem);

                                document.getElementById('notification-content').innerHTML += html;
                            });

                            window.notificationPagination = response.data[response.data.length-1].id;

                            document.getElementById('notification-content').innerHTML += '<center><i id="load-more-notifications" class="fas fa-plus is-pointer" onclick="fetchNotificationList()"></i></center>';
                            document.getElementById('notification-spinner').remove();
                        } else {
                            if ((window.notificationPagination === null) && (!window.gotNewNotifications)) {
                                document.getElementById('notification-content').innerHTML = '<div id="no-notifications-yet"><center><i>{{ __('app.no_notifications_yet') }}</i></center></div>';
                            }

                            let loader = document.getElementById('load-more-notifications');
                            if (loader) {
                                loader.remove();
                            }

                            let spinner = document.getElementById('notification-spinner');
                            if (spinner) {
                                spinner.remove();
                            }
                        }
                    }
                });
            };

            window.favoritesPagination = null;
            window.fetchFavorites = function() {
                document.getElementById('favorites-content').innerHTML += '<div id="favorites-spinner"><br/><center><i class="fas fa-spinner fa-spin"></i></center></div>';

                if (document.getElementById('favorites-loadmore') !== null) {
                    document.getElementById('favorites-loadmore').remove();
                }
                
                window.vue.ajaxRequest('post', '{{ url('/member/favorites/query') }}', { paginate: window.favoritesPagination }, function(response) {
                    if (response.code == 200) {
                        if (document.getElementById('favorites-spinner') !== null) {
                            document.getElementById('favorites-spinner').remove();
                        }

                        response.data.forEach(function(elem, index) {
                            let html = window.vue.renderFavoriteItem(elem);

                            document.getElementById('favorites-content').innerHTML += html;
                        });

                        if (response.data.length > 0) {
                            window.favoritesPagination = response.data[response.data.length - 1].id;

                            document.getElementById('favorites-content').innerHTML += '<div id="favorites-loadmore" class="is-pointer" onclick="window.fetchFavorites();"><br/><center><i class="fas fa-plus"></i></center></div>';
                        } else {
                            if (window.favoritesPagination === null) {
                                document.getElementById('favorites-content').innerHTML = '<div><br/><center>{{ __('app.no_favorites_yet') }}</center></div>';
                            }
                        }
                    } else {
                        console.error(response);
                    }
                });
            };

            document.addEventListener('DOMContentLoaded', function() {
                window.vue.translationTable.usernameOk = '{{ __('app.usernameOk') }}';
                window.vue.translationTable.invalidUsername = '{{ __('app.invalidUsername') }}';
                window.vue.translationTable.nonavailableUsername = '{{ __('app.nonavailableUsername') }}';
                window.vue.translationTable.passwordMismatching = '{{ __('app.passwordMismatching') }}';
                window.vue.translationTable.passwordMatching = '{{ __('app.passwordMatching') }}';
                window.vue.translationTable.age = '{{ __('app.age') }}';
                window.vue.translationTable.status = '{{ __('app.status') }}';
                window.vue.translationTable.location = '{{ __('app.location') }}';
                window.vue.translationTable.gender = '{{ __('app.gender') }}';
                window.vue.translationTable.isnew = '{{ __('app.isnew') }}';
                window.vue.translationTable.removeIgnore = '{{ __('app.removeIgnore') }}';
                window.vue.translationTable.verifiedProfile = '{{ __('app.verified_profile') }}';
                window.vue.translationTable.viewProfile = '{{ __('app.view_profile') }}';
                window.vue.translationTable.online = '{{ __('app.online') }}';
                window.vue.translationTable.message = '{{ __('app.message') }}';
                window.vue.translationTable.birthdayTooYoung = '{{ __('app.register_min_age', ['min' => env('APP_MINREGISTERAGE')]) }}';
                window.vue.translationTable.report = '{{ __('app.report') }}';
                window.vue.translationTable.edit = '{{ __('app.edit') }}';
                window.vue.translationTable.lock = '{{ __('app.lock') }}';
                window.vue.translationTable.delete = '{{ __('app.delete') }}';
                window.vue.translationTable.edited = '{{ __('app.edited') }}';
                window.vue.translationTable.confirmDeleteEvent = '{{ __('app.confirm_delete_event') }}';
                window.vue.translationTable.enterReportReason = '{{ __('app.enter_report_reason') }}';
                window.vue.translationTable.forumPostEdited = '{{ __('app.forumPostEdited') }}';
                window.vue.translationTable.confirmLockForumPost = '{{ __('app.confirmLockForumPost') }}';
                window.vue.settingsTable.minRegAge = {{ env('APP_MINREGISTERAGE') }};

                @auth
                    window.userProMode = {{ (\App\Models\User::promodeExpired(\App\Models\User::get(auth()->id()))) ? 'false' : 'true' }};
                @elseguest
                    window.userProMode = false;
                @endauth

                @if (Session::has('flash.error'))
                    setTimeout('window.vue.showError()', 500);
                @endif

                @if (Session::has('flash.success'))
                    setTimeout('window.vue.showSuccess()', 500);
                @endif

                window.vue.handleCookieConsent();

                @auth
                    setTimeout('fetchNotifications()', 100);
                    setTimeout('fetchNotificationList()', 200);
                    setTimeout('fetchFavorites()', 300);

                    window.geoLoopTransmission = function() {
                        window.queryGeoLocation();

                        setTimeout('window.geoLoopTransmission()', 5000)
                    };

                    @if ((!isset($_GET['clep_geo'])) || ($_GET['clep_geo'] == 0))
                        setTimeout('window.geoLoopTransmission()', 1000);
                    @endif
                @endauth

                @if (env('APP_ENABLEADS'))
                    if (!window.userProMode) {
                        window.vue.loadAd(document.getElementById('adform'));
                    } else {
                        let obj = document.getElementById('adform');
                        if (obj) {
                            obj.remove();
                        }
                    }
                @endif
            });
        </script>
        @yield('javascript')
    </body>
</html>