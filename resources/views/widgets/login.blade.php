
{{--
    Astarlove (dnyAstarlove) developed by Daniel Brendel

    (C) 2021 - 2022 by Daniel Brendel

    Contact: dbrendel1988<at>gmail<dot>com
    GitHub: https://github.com/danielbrendel/

    Released under the MIT license
--}}

<div class="modal" :class="{'is-active': bShowLogin}">
    <div class="modal-background"></div>
    <div class="modal-card">
        <header class="modal-card-head is-stretched">
            <p class="modal-card-title">{{ __('app.login') }}</p>
            <button class="delete" aria-label="close" onclick="window.vue.bShowLogin = false;"></button>
            </header>
            <section class="modal-card-body is-stretched">
                <div>
                    <form id="loginform" method="POST" action="{{ url('/login') }}">
                        @csrf

                        <div class="field">
                            <label class="label">{{ __('app.email') }}</label>
                            <p class="control has-icons-left has-icons-right">
                                <input class="input" onkeyup="window.vue.invalidLoginEmail()" onchange="window.vue.invalidLoginEmail()" onkeydown="if (event.keyCode === 13) { document.getElementById('loginform').submit(); }" type="email" name="email" id="loginemail" placeholder="{{ __('app.enteremail') }}" required>
                                <span class="icon is-small is-left">
                                <i class="fas fa-envelope"></i>
                                </span>
                            </p>
                        </div>

                        <div class="field">
                            <label class="label">{{ __('app.password') }}</label>
                            <p class="control has-icons-left">
                                <input class="input" onkeyup="window.vue.invalidLoginPassword()" onchange="window.vue.invalidLoginPassword()" onkeydown="if (event.keyCode === 13) { document.getElementById('loginform').submit(); }" type="password" name="password" id="loginpw" placeholder="{{ __('app.enterpassword') }}" required>
                                <span class="icon is-small is-left">
                                <i class="fas fa-lock"></i>
                                </span>
                            </p>
                        </div>
                    </form>
                </div>

                <div>
                    <br/>
                    <a class="is-link-blue" href="javascript:void(0);" onclick="window.vue.bShowRegister = true; window.vue.bShowLogin = false;">{{ __('app.no_account_yet') }}</a>
                </div>
            </section>
            <footer class="modal-card-foot is-stretched">
            <span>
                <button class="button is-success" onclick="document.getElementById('loginform').submit();">{{ __('app.login') }}</button>&nbsp;&nbsp;
            </span>
            <span class="is-right">
                <div class="recover-pw">
                    <center><a class="is-link-blue" href="javascript:void(0)" onclick="window.vue.bShowRecover = true; window.vue.bShowLogin = false;">{{ __('app.recover_password') }}</a></center>
                </div>
            </span>
            </footer>
    </div>
</div>