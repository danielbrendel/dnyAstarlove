{{--
    Astarlove (dnyAstarlove) developed by Daniel Brendel

    (C) 2021 - 2022 by Daniel Brendel

    Contact: dbrendel1988<at>gmail<dot>com
    GitHub: https://github.com/danielbrendel/

    Released under the MIT license
--}}

@extends('layouts.layout_home')

@section('title', env('APP_NAME') . ' - ' . __('app.profiles'))

@section('content')
    <div class="form">
        <h2>{{ __('app.profiles_title') }}<span>&nbsp;<i class="fas fa-sync-alt is-pointer" onclick="document.getElementById('profiles-content').innerHTML = ''; window.paginate = null; window.queryProfiles();"></i></span></h2>
        <br/>

        <div class="profiles-filter">
            <i class="fas fa-filter"></i>&nbsp;<a href="javascript:void(0);" onclick="document.getElementById('filter-options').classList.toggle('is-hidden')">{{ __('app.toggle_filter') }}</a>
            <br/>

            <div class="profiles-filter-options is-hidden" id="filter-options">
                <div class="field">
                    <label class="label">{{ __('app.geo_range') }}</label>
                    <div class="control">
                        <input id="geo-slider" data-on-change="window.searchGeoRange = arguments[0]; window.vue.setSearchGeoRange(arguments[0]);" data-role="slider" data-return-type="value" data-hint="true" data-hint-position="top" data-min="1" data-max="{{ env('APP_GEOMAX', 1000) }}">
                    </div>
                </div>

                <div class="field">
                    <label class="label">{{ __('app.genders') }}</label>
                    <div class="control">
                        <div class="btn-margin"><button id="btnMale" class="button is-outline is-light is-inline-block" onclick="window.toggleGenderMaleButton(this);">{{ __('app.gender_male') }}</button></div>
                        <div class="btn-margin"><button id="btnFemale" class="button is-outline is-light is-inline-block" onclick="window.toggleGenderFemaleButton(this);">{{ __('app.gender_female') }}</button></div>
                        <div class="btn-margin"><button id="btnDiverse" class="button is-outline is-light is-inline-block" onclick="window.toggleGenderDiverseButton(this);">{{ __('app.gender_diverse') }}</button></div>
                    </div>
                </div>

                <div class="field">
                    <label class="label">{{ __('app.orientation') }}</label>
                    <div class="control">
                        <div class="btn-margin"><button id="btnHeterosexual" class="button is-outline is-light is-inline-block" onclick="window.toggleOrientationHeterosexualButton(this);">{{ __('app.orientation_hetero') }}</button></div>
                        <div class="btn-margin"><button id="btnBisexual" class="button is-outline is-light is-inline-block" onclick="window.toggleOrientationBisexualButton(this);">{{ __('app.orientation_bi') }}</button></div>
                        <div class="btn-margin"><button id="btnHomosexual" class="button is-outline is-light is-inline-block" onclick="window.toggleOrientationHomosexualButton(this);">{{ __('app.orientation_homo') }}</button></div>
                    </div>
                </div>

                <div class="field">
                    <label class="label">{{ __('app.age_range') }}</label>
                    <div class="control">
                        {{ __('app.from') }}: <input class="input" type="number" id="ageFrom" min="18" onchange="window.vue.setSearchAgeFrom(this.value); window.searchAgeFrom = this.value;" onkeyup="window.vue.setSearchAgeFrom(this.value); window.searchAgeFrom = this.value;">
                        {{ __('app.till') }}: <input class="input" type="number" id="ageTill" min="18" onchange="window.vue.setSearchAgeTill(this.value); window.searchAgeTill = this.value;" onkeyup="window.vue.setSearchAgeTill(this.value); window.searchAgeTill = this.value;">
                    </div>
                </div>

                <div class="field">
                    <div class="control">
                        <input type="checkbox" id="onlyonline" data-role="checkbox" data-style="2" value="1" data-caption="{{ __('app.only_online_profiles') }}" onclick="window.vue.setSearchOnlyOnline(this.checked ? 1 : 0); window.searchOnlyOnline = this.checked ? 1 : 0;">
                    </div>
                </div>

                <div class="field">
                    <div class="control">
                        <input type="checkbox" id="onlyverified" data-role="checkbox" data-style="2" value="1" data-caption="{{ __('app.only_verified_profiles') }}" onclick="window.vue.setSearchOnlyVerified(this.checked ? 1 : 0); window.searchOnlyVerified = this.checked ? 1 : 0;">
                    </div>
                </div>

                <div class="field">
                    <div class="control">
                        <button class="button is-link" onclick="document.getElementById('profiles-content').innerHTML = ''; window.paginate = null; window.queryProfiles();">{{ __('app.search') }}</button>
                    </div>
                </div>
            </div>
        </div>

        <div><hr/></div>

        <div class="profiles-content" id="profiles-content"></div>
    </div>
@endsection

@section('javascript')
    <script>
        window.searchGeoRange = {{ env('APP_GEOMAX', 1000) }};
        window.searchGenderMale = true;
        window.searchGenderFemale = true;
        window.searchGenderDiverse = true;
        window.searchOrientationHeterosexual = 1;
        window.searchOrientationBisexual = 1;
        window.searchOrientationHomosexual = 0;
        window.searchAgeFrom = 18;
        window.searchAgeTill = 100;
        window.searchOnlyOnline = false;
        window.searchOnlyVerified = false;
        window.paginate = null;

        window.toggleGenderMaleButton = function(obj) {
            if (obj.classList.contains('is-light')) {
                obj.classList.remove('is-light');
                obj.classList.add('is-success');
                window.vue.setSearchGenderMale(1);
                window.searchGenderMale = 1;
            } else {
                obj.classList.add('is-light');
                obj.classList.remove('is-success');
                window.vue.setSearchGenderMale(0);
                window.searchGenderMale = 0;
            }
        };

        window.toggleGenderFemaleButton = function(obj) {
            if (obj.classList.contains('is-light')) {
                obj.classList.remove('is-light');
                obj.classList.add('is-success');
                window.vue.setSearchGenderFemale(1);
                window.searchGenderFemale = 1;
            } else {
                obj.classList.add('is-light');
                obj.classList.remove('is-success');
                window.vue.setSearchGenderFemale(0);
                window.searchGenderFemale = 0;
            }
        };

        window.toggleGenderDiverseButton = function(obj) {
            if (obj.classList.contains('is-light')) {
                obj.classList.remove('is-light');
                obj.classList.add('is-success');
                window.vue.setSearchGenderDiverse(1);
                window.searchGenderDiverse = 1;
            } else {
                obj.classList.add('is-light');
                obj.classList.remove('is-success');
                window.vue.setSearchGenderDiverse(0);
                window.searchGenderDiverse = 0;
            }
        };

        window.toggleOrientationHeterosexualButton = function(obj) {
            if (obj.classList.contains('is-light')) {
                obj.classList.remove('is-light');
                obj.classList.add('is-success');
                window.vue.setSearchOrientationHeterosexual(1);
                window.searchOrientationHeterosexual = 1;
            } else {
                obj.classList.add('is-light');
                obj.classList.remove('is-success');
                window.vue.setSearchOrientationHeterosexual(0);
                window.searchOrientationHeterosexual = 0;
            }
        };

        window.toggleOrientationBisexualButton = function(obj) {
            if (obj.classList.contains('is-light')) {
                obj.classList.remove('is-light');
                obj.classList.add('is-success');
                window.vue.setSearchOrientationBisexual(1);
                window.searchOrientationBisexual = 1;
            } else {
                obj.classList.add('is-light');
                obj.classList.remove('is-success');
                window.vue.setSearchOrientationBisexual(0);
                window.searchOrientationBisexual = 0;
            }
        };

        window.toggleOrientationHomosexualButton = function(obj) {
            if (obj.classList.contains('is-light')) {
                obj.classList.remove('is-light');
                obj.classList.add('is-success');
                window.vue.setSearchOrientationHomosexual(1);
                window.searchOrientationHomosexual = 1;
            } else {
                obj.classList.add('is-light');
                obj.classList.remove('is-success');
                window.vue.setSearchOrientationHomosexual(0);
                window.searchOrientationHomosexual = 0;
            }
        };

        window.initSearchOptions = function() {
            window.searchGeoRange = window.vue.getSearchGeoRange();
            window.searchGenderMale = window.vue.getSearchGenderMale();
            window.searchGenderFemale = window.vue.getSearchGenderFemale();
            window.searchGenderDiverse = window.vue.getSearchGenderDiverse();
            window.searchOrientationHeterosexual = window.vue.getSearchOrientationHeterosexual();
            window.searchOrientationBisexual = window.vue.getSearchOrientationBisexual();
            window.searchOrientationHomosexual = window.vue.getSearchOrientationHomosexual();
            window.searchAgeFrom = window.vue.getSearchAgeFrom();
            window.searchAgeTill = window.vue.getSearchAgeTill();
            window.searchOnlyOnline = window.vue.getSearchOnlyOnline();
            window.searchOnlyVerified = window.vue.getSearchOnlyVerified();

            document.getElementById('geo-slider').setAttribute('data-value', window.searchGeoRange);

            if (window.searchGenderMale) {
                document.getElementById('btnMale').classList.remove('is-light');
                document.getElementById('btnMale').classList.add('is-success');
            } else {
                document.getElementById('btnMale').classList.add('is-light');
                document.getElementById('btnMale').classList.remove('is-success');
            }

            if (window.searchGenderFemale) {
                document.getElementById('btnFemale').classList.remove('is-light');
                document.getElementById('btnFemale').classList.add('is-success');
            } else {
                document.getElementById('btnFemale').classList.add('is-light');
                document.getElementById('btnFemale').classList.remove('is-success');
            }

            if (window.searchGenderDiverse) {
                document.getElementById('btnDiverse').classList.remove('is-light');
                document.getElementById('btnDiverse').classList.add('is-success');
            } else {
                document.getElementById('btnDiverse').classList.add('is-light');
                document.getElementById('btnDiverse').classList.remove('is-success');
            }

            if (window.searchOrientationHeterosexual) {
                document.getElementById('btnHeterosexual').classList.remove('is-light');
                document.getElementById('btnHeterosexual').classList.add('is-success');
            } else {
                document.getElementById('btnHeterosexual').classList.add('is-light');
                document.getElementById('btnHeterosexual').classList.remove('is-success');
            }

            if (window.searchOrientationBisexual) {
                document.getElementById('btnBisexual').classList.remove('is-light');
                document.getElementById('btnBisexual').classList.add('is-success');
            } else {
                document.getElementById('btnBisexual').classList.add('is-light');
                document.getElementById('btnBisexual').classList.remove('is-success');
            }

            if (window.searchOrientationHomosexual) {
                document.getElementById('btnHomosexual').classList.remove('is-light');
                document.getElementById('btnHomosexual').classList.add('is-success');
            } else {
                document.getElementById('btnHomosexual').classList.add('is-light');
                document.getElementById('btnHomosexual').classList.remove('is-success');
            }

            document.getElementById('ageFrom').value = window.searchAgeFrom;
            document.getElementById('ageTill').value = window.searchAgeTill;

            document.getElementById('onlyonline').checked = window.searchOnlyOnline;
            document.getElementById('onlyverified').checked = window.searchOnlyVerified;
        };

        window.queryProfiles = function() {
            let content = document.getElementById('profiles-content');

            content.innerHTML += '<div id="spinner"><center><i class="fa fa-spinner fa-spin"></i></center></div>';

            let loadmore = document.getElementById('loadmore');
            if (loadmore) {
                loadmore.remove();
            }

            window.vue.ajaxRequest('post', '{{ url('/profiles/query') }}', {
                georange: window.searchGeoRange,
                male: window.searchGenderMale,
                female: window.searchGenderFemale,
                diverse: window.searchGenderDiverse,
                heterosexual: window.searchOrientationHeterosexual,
                bisexual: window.searchOrientationBisexual,
                homosexual: window.searchOrientationHomosexual,
                from: window.searchAgeFrom,
                till: window.searchAgeTill,
                online: window.searchOnlyOnline,
                verified: window.searchOnlyVerified,
                paginate: window.paginate
            },
            function(response) {
                if (response.code == 200) {
                    response.data.forEach(function(elem, index) {
                        let html = window.vue.renderProfileForm(elem);

                        content.innerHTML += html;
                    });

                    if (response.data.length > 0) {
                        window.paginate = response.data[response.data.length - 1].last_action;
                    }

                    let spinner = document.getElementById('spinner');
                    if (spinner) {
                        spinner.remove();
                    }

                    if (response.data.length === 0) {
                        content.innerHTML += '<div><br/>{{ __('app.no_more_profiles') }}</div>';
                    } else {
                        content.innerHTML += '<div id="loadmore"><center><br/><i class="fas fa-plus is-pointer" onclick="window.queryProfiles();"></i></center></div>';
                    }
                } else {
                    console.error(response.msg);
                }
            });
        };

        window.initSearchOptions();

        document.addEventListener('DOMContentLoaded', function() {
            window.queryProfiles();
        });
    </script>
@endsection
