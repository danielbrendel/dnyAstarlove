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

    <a role="button" class="navbar-burger" aria-label="menu" aria-expanded="false" data-target="navbarMenu">
      <span aria-hidden="true"></span>
      <span aria-hidden="true"></span>
      <span aria-hidden="true"></span>
    </a>
  </div>

  <div id="navbarMenu" class="navbar-menu">
    <div class="navbar-start"></div>

    <div class="navbar-end">
        @auth
        <a class="navbar-item">
            Home
        </a>

        <a class="navbar-item">
            Documentation
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
            <a href="{{ url('/logout') }}" class="navbar-item is-underline">
                {{ __('app.logout') }}
            </a>
        @endauth
    </div>
  </div>
</nav>