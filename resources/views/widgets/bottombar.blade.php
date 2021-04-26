{{--
    Astarlove (dnyAstarlove) developed by Daniel Brendel

    (C) 2021 by Daniel Brendel

    Contact: dbrendel1988<at>gmail<dot>com
    GitHub: https://github.com/danielbrendel/

    Released under the MIT license
--}}

<div class="bottombar">
    <div class="bottombar-content">
        &copy {{ date('Y') }} {{ env('APP_NAME') }} | @if (env('TWITTER_NEWS', null) !== null) <a href="{{ url('/news') }}" class="is-link-grey">{{ __('app.news') }}</a>&nbsp;&nbsp; @endif <a href="{{ url('/faq') }}" class="is-link-grey">{{ __('app.faq') }}</a>&nbsp;&nbsp;<a href="{{ url('/tos') }}" class="is-link-grey">{{ __('app.tos') }}</a>&nbsp;&nbsp;@if (env('HELPREALM_ENABLE', false)) <a href="{{ url('/contact') }}" class="is-link-grey">{{ __('app.contact') }}</a>&nbsp;&nbsp;@endif<a href="{{ url('/imprint') }}" class="is-link-grey">{{ __('app.imprint') }}</a>
    </div>
</div>