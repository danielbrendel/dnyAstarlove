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
        b
        </div>

        <div id="tabSecurity-form" class="tab-content is-hidden">
        c
        </div>

        <div id="tabNotifications-form" class="tab-content is-hidden">
        d
        </div>

        <div id="tabIgnoreList-form" class="tab-content is-hidden">
        e
        </div>

        <div id="tabMembership-form" class="tab-content is-hidden">
        f
        </div>
    </div>
@endsection

@section('javascript')
    <script>
        window.paginateVisitors = null;

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
                        window.paginateVisitors = response.data[response.data.length - 1].updated_at;console.log(window.paginateVisitors);

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
