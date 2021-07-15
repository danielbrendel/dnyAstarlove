{{--
    Astarlove (dnyAstarlove) developed by Daniel Brendel

    (C) 2021 by Daniel Brendel

    Contact: dbrendel1988<at>gmail<dot>com
    GitHub: https://github.com/danielbrendel/

    Released under the MIT license
--}}

<nav class="navbar" role="navigation" aria-label="main navigation">
  <div class="navbar-brand">
    <a class="navbar-item" href="{{ url('/') }}">
        <strong>{{ env('APP_NAME') }}</strong>
    </a>

    @auth
        @if (\App\Models\User::isAdmin(auth()->id()))
            <div class="is-fixed-admin-icon" title="{{ __('app.admin_area') }}" onclick="location.href = '{{ url('/admin') }}';">&nbsp;<i class="fas fa-cog is-pointer"></i></div>
        @endif
    @endauth

    <a id="navbarBurger" role="button" class="navbar-burger" aria-label="menu" aria-expanded="false" data-target="navbarMenu" onclick="window.menuVisible = !document.getElementById('navbarMenu').classList.contains('is-active');">
      <span aria-hidden="true"></span>
      <span aria-hidden="true"></span>
      <span aria-hidden="true"></span>
      <span id="burger-notification"></span>
    </a>
  </div>

  <div id="navbarMenu" class="navbar-menu">
    <div class="navbar-start"></div>

    <div class="navbar-end">
        @auth

        <a class="navbar-item" href="{{ url('/profiles') }}">
            {{ __('app.profiles') }}
        </a>

        <a class="navbar-item" href="{{ url('/random') }}">
            {{ __('app.random') }}
        </a>

        <a class="navbar-item" href="{{ url('/events') }}">
            {{ __('app.events') }}
        </a>

        <a class="navbar-item" href="javascript:void(0);" onclick="window.vue.toggleOverlay('favorites'); if (window.menuVisible) { document.getElementById('navbarMenu').classList.remove('is-active'); document.getElementById('navbarBurger').classList.remove('is-active'); }">
            {{ __('app.favorites') }}
        </a>

        <a class="navbar-item" href="{{ url('/messages') }}">
            {{ __('app.messages') }}
        </a>

        <a class="navbar-item notification-badge" href="javascript:void(0);" onclick="window.vue.toggleOverlay('notifications'); document.getElementById('navbar-notify-wrapper').classList.add('is-hidden'); document.getElementById('burger-notification').style.display = 'none'; window.vue.markSeen(); if (window.menuVisible) { document.getElementById('navbarMenu').classList.remove('is-active'); document.getElementById('navbarBurger').classList.remove('is-active'); }">
            <span class="navbar-fixed-left">{{ __('app.notifications') }}</span>
            <span class="notify-badge is-hidden" id="navbar-notify-wrapper"><span class="notify-badge-count" id="navbar-notify-count"></span></span>
        </a>

        <a class="navbar-item" href="{{ url('/user/' . \App\Models\User::get(auth()->id())->name) }}">
            {{ __('app.profile') }}
        </a>

        <a class="navbar-item" href="{{ url('/settings') }}">
            {{ __('app.settings') }}
        </a>
        @endauth

        @guest
        <div class="navbar-item">
            <div class="buttons">
                <a href="javascript:void(0);" onclick="window.vue.bShowRegister = true;" class="button is-light is-outlined is-hover-black">
                    <strong>{{ __('app.register') }}</strong>
                </a>
            </div>
        </div>

        <a href="javascript:void(0);" onclick="window.vue.bShowLogin = true;" class="navbar-item is-underline">
            {{ __('app.login') }}
        </a>
        @endguest

        @auth
            <a href="{{ url('/logout') }}" class="navbar-item">
                {{ __('app.logout') }}
            </a>
        @endauth
    </div>
  </div>
</nav>