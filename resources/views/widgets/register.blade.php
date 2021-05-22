{{--
    Astarlove (dnyAstarlove) developed by Daniel Brendel

    (C) 2021 by Daniel Brendel

    Contact: dbrendel1988<at>gmail<dot>com
    GitHub: https://github.com/danielbrendel/

    Released under the MIT license
--}}

<div class="modal" :class="{'is-active': bShowRegister}">
    <div class="modal-background"></div>
    <div class="modal-card">
        <header class="modal-card-head is-stretched">
            <p class="modal-card-title">{{ __('app.register') }}</p>
            <button class="delete" aria-label="close" onclick="vue.bShowRegister = false;"></button>
        </header>
        <section class="modal-card-body is-stretched">
            <form id="regform" method="POST" action="{{ url('/register') }}">
                @csrf

                <div class="field">
                    <label class="label">{{ __('app.register_username') }}</label>
                    <div class="control">
                        <input class="input" type="text" name="username" onchange="window.vue.showUsernameValidity(this.value, document.getElementById('reg-username-validity'));" onkeyup="window.vue.showUsernameValidity(this.value, document.getElementById('reg-username-validity'));" value="{{ old('username') }}" required>
                    </div>
                    <p id="reg-username-validity" class="help"></p>
                </div>

                <div class="field">
                    <label class="label">{{ __('app.register_email') }}</label>
                    <div class="control">
                        <input class="input" type="email" name="email" value="{{ old('email') }}" required>
                    </div>
                </div>

                <div class="field">
                    <label class="label">{{ __('app.register_birthday') }}</label>
                    <div class="control">
                        <input class="input" type="date" name="birthday" value="{{ old('birthday') }}" onchange="window.vue.showValidAge(this.value, document.getElementById('reg-birthday-validity'));" required>
                    </div>
                    <p id="reg-birthday-validity" class="help"></p>
                </div>

                <div class="field">
                    <label class="label">{{ __('app.register_password') }}</label>
                    <div class="control">
                        <input class="input" type="password" name="password" id="reg-password" onchange="window.vue.showPasswordMatching(document.getElementById('reg-password-confirm').value, this.value, document.getElementById('reg-password-matching'));" onkeyup="window.vue.showPasswordMatching(document.getElementById('reg-password-confirm').value, this.value, document.getElementById('reg-password-matching'));" required>
                    </div>
                </div>

                <div class="field">
                    <label class="label">{{ __('app.register_password_confirmation') }}</label>
                    <div class="control">
                        <input class="input" type="password" name="password_confirmation" id="reg-password-confirm" onchange="window.vue.showPasswordMatching(document.getElementById('reg-password').value, this.value, document.getElementById('reg-password-matching'));" onkeyup="window.vue.showPasswordMatching(document.getElementById('reg-password').value, this.value, document.getElementById('reg-password-matching'));" required>
                    </div>
                    <p id="reg-password-matching" class="help"></p>
                </div>

                <div class="field">
                    <label class="label">Captcha: {{ $captchadata[0] }} + {{ $captchadata[1] }} = ?</label>
                    <div class="control">
                        <input class="input" type="text" name="captcha" required>
                    </div>
                </div>

                <div class="field">
                    {!! \App\Models\AppModel::getRegInfo()  !!}
                </div>
            </form>
        </section>
        <footer class="modal-card-foot is-stretched">
            <span>
                <button class="button is-success" onclick="document.getElementById('regform').submit();">{{ __('app.register') }}</button>
                <button class="button" onclick="vue.bShowRegister = false;">{{ __('app.cancel') }}</button>
            </span>
        </footer>
    </div>
</div>