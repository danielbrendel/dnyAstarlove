
{{--
    Astarlove (dnyAstarlove) developed by Daniel Brendel

    (C) 2021 - 2022 by Daniel Brendel

    Contact: dbrendel1988<at>gmail<dot>com
    GitHub: https://github.com/danielbrendel/

    Released under the MIT license
--}}

<div class="modal" :class="{'is-active': bShowRecover}">
    <div class="modal-background"></div>
    <div class="modal-card">
        <header class="modal-card-head is-stretched">
        <p class="modal-card-title">{{ __('app.recover_password') }}</p>
        <button class="delete" aria-label="close" onclick="window.vue.bShowRecover = false;"></button>
        </header>
        <section class="modal-card-body is-stretched">
            <form method="POST" action="{{ url('/recover') }}" id="formResetPw">
                @csrf

                <div class="field">
                    <label class="label">{{ __('app.email') }}</label>
                    <div class="control">
                        <input type="email" onkeyup="invalidRecoverEmail()" onchange="invalidRecoverEmail()" onkeydown="if (event.keyCode === 13) { document.getElementById('formResetPw').submit(); }" class="input" name="email" id="recoveremail" required>
                    </div>
                </div>

                <input type="submit" id="recoverpwsubmit" class="is-hidden">
            </form>
        </section>
        <footer class="modal-card-foot is-stretched">
        <button class="button is-success" onclick="document.getElementById('recoverpwsubmit').click();">{{ __('app.recover_password') }}</button>
        <button class="button" onclick="window.vue.bShowRecover = false;">{{ __('app.cancel') }}</button>
        </footer>
    </div>
</div>