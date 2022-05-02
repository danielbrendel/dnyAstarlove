{{--
    Astarlove (dnyAstarlove) developed by Daniel Brendel

    (C) 2021 - 2022 by Daniel Brendel

    Contact: dbrendel1988<at>gmail<dot>com
    GitHub: https://github.com/danielbrendel/

    Released under the MIT license
--}}

<div class="cookienotice" id="cookie-consent">
    <div class="cookienotice-title">{{ __('app.cookie_notice') }}</div>

    <div class="cookienotice-body">{!! \App\Models\AppModel::getCookieConsentText() !!}</div>

    <div class="cookienotice-footer">
        <a href="javascript:void(0);" onclick="window.vue.clickedCookieConsentButton();">{{ __('app.cookie_close') }}</a>
    </div>
</div>