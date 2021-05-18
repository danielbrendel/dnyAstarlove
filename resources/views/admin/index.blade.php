{{--
    Astarlove (dnyAstarlove) developed by Daniel Brendel

    (C) 2021 by Daniel Brendel

    Contact: dbrendel1988<at>gmail<dot>com
    GitHub: https://github.com/danielbrendel/

    Released under the MIT license
--}}

@extends('layouts.layout_home')

@section('title', env('APP_NAME') . ' - ' . __('app.admin_area'))

@section('content')
    <div class="form is-default-padding member-form-fixed-top">
        <div>
            <h1>{{ __('app.admin_area') }}</h1>
        </div>

        <div>
            <div><strong>Astarlove (dnyAstarlove) v1.0 developed by Daniel Brendel (dbrendel1988@gmail.com)</strong></div>
            <div><strong>Project: </strong>{{ env('APP_NAME') }}</div>
            <div><strong>Author: </strong>{{ env('APP_AUTHOR') }}</div>
            <div><strong>Codename: </strong>{{ env('APP_CODENAME') }}</div>
            <div><strong>Contact: </strong>{{ env('APP_CONTACT') }}</div>
            <div><strong>Version: </strong>{{ env('APP_VERSION') }}</div>
            <br/>
        </div>

        <ul data-role="tabs" data-expand="true">
            <li><a href="#tab-page-1">{{ __('app.about') }}</a></li>
            <li><a href="#tab-page-2">{{ __('app.background') }}</a></li>
            <li><a href="#tab-page-3">{{ __('app.logo') }}</a></li>
            <li><a href="#tab-page-4">{{ __('app.cookie_consent') }}</a></li>
            <li><a href="#tab-page-5">{{ __('app.reg_info') }}</a></li>
            <li><a href="#tab-page-6">{{ __('app.tos') }}</a></li>
            <li><a href="#tab-page-7">{{ __('app.imprint') }}</a></li>
            <li><a href="#tab-page-8">{{ __('app.environment') }}</a></li>
            <li><a href="#tab-page-9">{{ __('app.users') }}</a></li>
            <li><a href="#tab-page-10">{{ __('app.features') }}</a></li>
            <li><a href="#tab-page-11">{{ __('app.faq') }}</a></li>
            <li><a href="#tab-page-12">{{ __('app.newsletter') }}</a></li>
            <li><a href="#tab-page-13">{{ __('app.reports') }}</a></li>
            <li><a href="#tab-page-14">{{ __('app.head_code') }}</a></li>
            <li><a href="#tab-page-15">{{ __('app.adcode') }}</a></li>
            <li><a href="#tab-page-16">{{ __('app.verification') }}</a></li>
            <li><a href="#tab-page-17">{{ __('app.approvals') }}</a></li>
        </ul>
        <div class="border bd-default no-border-top p-2">
            <div id="tab-page-1">
                <form method="POST" action="{{ url('/admin/about/save') }}">
                    @csrf

                    <div class="field">
                        <label class="label">{{ __('app.about_headline') }}</label>
                        <div class="control">
                            <input type="text" name="headline" value="{{ $settings->headline }}">
                        </div>
                    </div>

                    <div class="field">
                        <label class="label">{{ __('app.about_subline') }}</label>
                        <div class="control">
                            <input type="text" name="subline" value="{{ $settings->subline }}">
                        </div>
                    </div>

                    <div class="field">
                        <label class="label">{{ __('app.about_description') }}</label>
                        <div class="control">
                            <textarea class="textarea" name="description">{{ $settings->description }}</textarea>
                        </div>
                    </div>

                    <div class="field">
                        <div class="control">
                            <input type="submit" value="{{ __('app.save') }}">
                        </div>
                    </div>
                </form>
            </div>

            <div id="tab-page-2">
                <form method="POST" action="{{ url('/admin/background/save') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="field">
                        <label class="label">{{ __('app.background_info') }}</label>
                        <div class="control">
                            <div><img src="{{ asset('/gfx/backgrounds/' . $settings->backgroundImage) }}" alt="background"></div>
                            <div><input type="file" name="background" data-role="file"></div>
                        </div>
                    </div>

                    <div class="field">
                        <label class="label">{{ __('app.bg_alpha') }}</label>
                        <div class="control">
                            <input type="text" name="bg_alpha" value="{{ $settings->alphaChannel }}">
                        </div>
                    </div>

                    <div class="field">
                        <div class="control">
                            <input type="submit" value="{{ __('app.save') }}">
                        </div>
                    </div>
                </form>
            </div>

            <div id="tab-page-3">
                <form method="POST" action="{{ url('/admin/logo/save') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="field">
                        <label class="label">{{ __('app.logo_info') }}</label>
                        <div class="control">
                            <div><img src="{{ url('/logo.png') }}" alt="logo"></div>
                            <div><input type="file" name="logo" data-role="file"></div>
                        </div>
                    </div>

                    <div class="field">
                        <div class="control">
                            <input type="submit" value="{{ __('app.save') }}">
                        </div>
                    </div>
                </form>
            </div>

            <div id="tab-page-4">
                <form method="POST" action="{{ url('/admin/cookieconsent/save') }}">
                    @csrf

                    <div class="field">
                        <label class="label">{{ __('app.cookieconsent_description') }}</label>
                        <div class="control">
                            <textarea class="textarea" name="cookieconsent">{{ $settings->cookie_consent }}</textarea>
                        </div>
                    </div>

                    <div class="field">
                        <div class="control">
                            <input type="submit" value="{{ __('app.save') }}">
                        </div>
                    </div>
                </form>
            </div>

            <div id="tab-page-5">
                <form method="POST" action="{{ url('/admin/reginfo/save') }}">
                    @csrf

                    <div class="field">
                        <label class="label">{{ __('app.reginfo_description') }}</label>
                        <div class="control">
                            <textarea class="textarea" name="reginfo">{{ $settings->reg_info }}</textarea>
                        </div>
                    </div>

                    <div class="field">
                        <div class="control">
                            <input type="submit" value="{{ __('app.save') }}">
                        </div>
                    </div>
                </form>
            </div>

            <div id="tab-page-6">
                <form method="POST" action="{{ url('/admin/tos/save') }}">
                    @csrf

                    <div class="field">
                        <label class="label">{{ __('app.tos_description') }}</label>
                        <div class="control">
                            <textarea class="textarea" name="tos">{{ $settings->tos }}</textarea>
                        </div>
                    </div>

                    <div class="field">
                        <div class="control">
                            <input type="submit" value="{{ __('app.save') }}">
                        </div>
                    </div>
                </form>
            </div>

            <div id="tab-page-7">
                <form method="POST" action="{{ url('/admin/imprint/save') }}">
                    @csrf

                    <div class="field">
                        <label class="label">{{ __('app.imprint_description') }}</label>
                        <div class="control">
                            <textarea class="textarea" name="imprint">{{ $settings->imprint }}</textarea>
                        </div>
                    </div>

                    <div class="field">
                        <div class="control">
                            <input type="submit" value="{{ __('app.save') }}">
                        </div>
                    </div>
                </form>
            </div>

            <div id="tab-page-8">
                <form method="POST" action="{{ url('/admin/env/save') }}">
                    @csrf

                    <div class="field">
                        <label class="label">{{ __('app.project_description') }}</label>
                        <div class="control">
                            <input type="text" name="ENV_APP_DESCRIPTION" value="{{ env('APP_DESCRIPTION') }}">
                        </div>
                    </div>

                    <div class="field">
                        <label class="label">{{ __('app.project_tags') }}</label>
                        <div class="control">
                            <input type="text" name="ENV_APP_KEYWORDS" value="{{ env('APP_KEYWORDS') }}">
                        </div>
                    </div>

                    <div class="field">
                        <label class="label">{{ __('app.project_lang') }}</label>
                        <div class="control">
                            <select name="ENV_APP_LANG">
                                @foreach ($langs as $lang)
                                    <option value="{{ $lang }}" @if ($lang === env('APP_LANG')) {{ 'selected' }} @endif>{{ $lang }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="field">
                        <label class="label">{{ __('app.project_keyphrase') }}</label>
                        <div class="control">
                            <input type="text" name="ENV_APP_KEYPHRASE" value="{{ env('APP_KEYPHRASE') }}">
                        </div>
                    </div>

                    <div class="field">
                        <label class="label">{{ __('app.project_maxuploadsize') }}</label>
                        <div class="control">
                            <input type="number" name="ENV_APP_MAXUPLOADSIZE" value="{{ env('APP_MAXUPLOADSIZE') }}">
                        </div>
                    </div>

                    <div class="field">
                        <label class="label">{{ __('app.project_enableads') }}</label>
                        <div class="control">
                            <input name="ENV_APP_ENABLEADS" type="checkbox" value="1" data-role="checkbox" data-type="2" data-caption="{{ __('app.project_categories') }}" @if (env('APP_ENABLEADS')) {{ 'checked' }} @endif>
                        </div>
                    </div>

                    <div class="field">
                        <label class="label">{{ __('app.project_smtp_host') }}</label>
                        <div class="control">
                            <input type="text" name="ENV_SMTP_HOST" value="{{ env('SMTP_HOST') }}">
                        </div>
                    </div>

                    <div class="field">
                        <label class="label">{{ __('app.project_smtp_user') }}</label>
                        <div class="control">
                            <input type="text" name="ENV_SMTP_USERNAME" value="{{ env('SMTP_USERNAME') }}">
                        </div>
                    </div>

                    <div class="field">
                        <label class="label">{{ __('app.project_smtp_pw') }}</label>
                        <div class="control">
                            <input type="text" name="ENV_SMTP_PASSWORD" value="{{ env('SMTP_PASSWORD') }}">
                        </div>
                    </div>

                    <div class="field">
                        <label class="label">{{ __('app.project_smtp_fromname') }}</label>
                        <div class="control">
                            <input type="text" name="ENV_SMTP_FROMNAME" value="{{ env('SMTP_FROMNAME') }}">
                        </div>
                    </div>

                    <div class="field">
                        <label class="label">{{ __('app.project_smtp_fromaddress') }}</label>
                        <div class="control">
                            <input type="text" name="ENV_SMTP_FROMADDRESS" value="{{ env('SMTP_FROMADDRESS') }}">
                        </div>
                    </div>

                    <div class="field">
                        <label class="label">{{ __('app.project_twitter_news') }}</label>
                        <div class="control">
                            <input type="text" name="ENV_TWITTER_NEWS" value="{{ env('TWITTER_NEWS') }}">
                        </div>
                    </div>

                    <div class="field">
                        <label class="label">{{ __('app.project_helprealm_workspace') }}</label>
                        <div class="control">
                            <input type="text" name="ENV_HELPREALM_WORKSPACE" value="{{ env('HELPREALM_WORKSPACE') }}">
                        </div>
                    </div>

                    <div class="field">
                        <label class="label">{{ __('app.project_helprealm_token') }}</label>
                        <div class="control">
                            <input type="text" name="ENV_HELPREALM_TOKEN" value="{{ env('HELPREALM_TOKEN') }}">
                        </div>
                    </div>

                    <div class="field">
                        <label class="label">{{ __('app.project_helprealm_tickettypeid') }}</label>
                        <div class="control">
                            <input type="text" name="ENV_HELPREALM_TICKETTYPEID" value="{{ env('HELPREALM_TICKETTYPEID') }}">
                        </div>
                    </div>

                    <div class="field">
                        <label class="label">{{ __('app.project_stripe_enable') }}</label>
                        <div class="control">
                            <input name="ENV_STRIPE_ENABLE" type="checkbox" value="1" data-role="checkbox" data-type="2" data-caption="{{ __('app.project_stripe_enable') }}" @if (env('STRIPE_ENABLE')) {{ 'checked' }} @endif>
                        </div>
                    </div>

                    <div class="field">
                        <label class="label">{{ __('app.project_stripe_secret') }}</label>
                        <div class="control">
                            <input type="text" name="ENV_STRIPE_TOKEN_SECRET" value="{{ env('STRIPE_TOKEN_SECRET') }}">
                        </div>
                    </div>

                    <div class="field">
                        <label class="label">{{ __('app.project_stripe_public') }}</label>
                        <div class="control">
                            <input type="text" name="ENV_STRIPE_TOKEN_PUBLIC" value="{{ env('STRIPE_TOKEN_PUBLIC') }}">
                        </div>
                    </div>

                    <div class="field">
                        <label class="label">{{ __('app.project_stripe_costs_value') }}</label>
                        <div class="control">
                            <input type="number" name="ENV_STRIPE_COSTS_VALUE" value="{{ env('STRIPE_COSTS_VALUE') }}">
                        </div>
                    </div>

                    <div class="field">
                        <label class="label">{{ __('app.project_stripe_currency') }}</label>
                        <div class="control">
                            <input type="text" name="ENV_STRIPE_CURRENCY" value="{{ env('STRIPE_CURRENCY') }}">
                        </div>
                    </div>

                    <div class="field">
                        <label class="label">{{ __('app.project_stripe_costs_label') }}</label>
                        <div class="control">
                            <input type="text" name="ENV_STRIPE_COSTS_LABEL" value="{{ env('STRIPE_COSTS_LABEL') }}">
                        </div>
                    </div>

                    <div class="field">
                        <div class="control">
                            <input type="submit" value="{{ __('app.save') }}">
                        </div>
                    </div>
                </form>
            </div>

            <div id="tab-page-9">
                <div class="field">
                    <input type="text" id="userident">
                </div>

                <div class="field">
                    <input type="button" value="{{ __('app.get_user_details') }}" onclick="getUserDetails(document.getElementById('userident').value);">
                </div>

                <div id="user_settings" class="is-hidden">
                    <form method="POST" action="{{ url('/admin/user/save') }}">
                        @csrf

                        <input type="hidden" name="id" id="user_id">

                        <div class="field">
                            <label class="label">{{ __('app.username') }}</label>
                            <div class="control">
                                <input type="text" id="user_name" name="username">
                            </div>
                        </div>

                        <div class="field">
                            <label class="label">{{ __('app.email') }}</label>
                            <div class="control">
                                <input type="text" name="email" id="user_email">
                            </div>
                        </div>

                        <div class="field">
                            <div class="control">
                                <a href="javascript:void(0);" onclick="location.href = window.location.origin + '/admin/user/' + document.getElementById('user_id').value + '/resetpw';">{{ __('app.reset_password') }}</a>
                            </div>
                        </div>

                        <div class="field">
                            <div class="control">
                                <input type class="checkbox" name="deactivated" id="user_deactivated" data-role="checkbox" data-style="2" data-caption="{{ __('app.deactivated') }}" value="1">
                            </div>
                        </div>

                        <div class="field">
                            <div class="control">
                                <input type class="checkbox" name="admin" id="user_admin" data-role="checkbox" data-style="2" data-caption="{{ __('app.admin') }}" value="1">
                            </div>
                        </div>

                        <div class="field">
                            <div class="control">
                                <input type="submit" value="{{ __('app.save') }}">
                            </div>
                        </div>
                    </form>

                    <div class="field">
                        <div class="control">
                            <br/><a href="javascript:void(0);" class="button is-danger" onclick="if (confirm('{{ __('app.confirm_delete') }}')) location.href = window.location.origin + '/admin/user/' + document.getElementById('user_id').value + '/delete';">{{ __('app.delete_account') }}</a>
                        </div>
                    </div>
                </div>
            </div>

            <div id="tab-page-10">
                <table class="table striped table-border mt-4" data-role="table" data-pagination="true"
                        data-table-rows-count-title="{{ __('app.table_show_entries') }}"
                        data-table-search-title="{{ __('app.table_search') }}"
                        data-table-info-title="{{ __('app.table_row_info') }}"
                        data-pagination-prev-title="{{ __('app.table_pagination_prev') }}"
                        data-pagination-next-title="{{ __('app.table_pagination_next') }}">
                    <thead>
                    <tr>
                        <th class="text-left">{{ __('app.feature_id') }}</th>
                        <th class="text-left">{{ __('app.feature_title') }}</th>
                        <th class="text-left">{{ __('app.feature_description') }}</th>
                        <th class="text-left">{{ __('app.feature_last_updated') }}</th>
                        <th class="text-right">{{ __('app.remove') }}</th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach ($features as $feature)
                        <tr>
                            <td>
                                #{{ $feature->id }}
                            </td>

                            <td class="right">
                                <a href="javascript:void(0)" onclick="document.getElementById('feature-id').value = {{ $feature->id }}; document.getElementById('feature-title').value = '{{ $feature->title }}'; document.getElementById('feature-description').value = '{{ $feature->description }}'; vue.bShowEditFeature = true;" title="{{ __('app.feature_edit') }}">{{ $feature->title }}</a>
                            </td>

                            <td>
                                <?php
                                if (strlen($feature->description) > 20) {
                                    echo substr($feature->description, 0, 20) . '...';
                                } else {
                                    echo $feature->description;
                                }
                                ?>
                            </td>

                            <td><div title="{{ $feature->updated_at }}">{{ $feature->updated_at->diffForHumans() }}</div></td>

                            <td>
                                <a href="javascript:void(0)" onclick="if (confirm('{{ __('app.feature_remove_confirm') }}')) location.href = '{{ url('/admin/feature/' . $feature->id . '/remove') }}';">{{ __('app.feature_remove') }}</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                <br/>

                <center><a class="button" href="javascript:void(0)" onclick="location.reload();">{{ __('app.refresh') }}</a>&nbsp;&nbsp;&nbsp;&nbsp;
                <a class="button is-success" onclick="vue.bShowCreateFeature = true;">{{ __('app.create') }}</a></center><br/>
            </div>

            <div id="tab-page-11">
                <table class="table striped table-border mt-4" data-role="table" data-pagination="true"
                        data-table-rows-count-title="{{ __('app.table_show_entries') }}"
                        data-table-search-title="{{ __('app.table_search') }}"
                        data-table-info-title="{{ __('app.table_row_info') }}"
                        data-pagination-prev-title="{{ __('app.table_pagination_prev') }}"
                        data-pagination-next-title="{{ __('app.table_pagination_next') }}">
                    <thead>
                    <tr>
                        <th class="text-left">{{ __('app.faq_id') }}</th>
                        <th class="text-left">{{ __('app.faq_question') }}</th>
                        <th class="text-left">{{ __('app.faq_answer') }}</th>
                        <th class="text-left">{{ __('app.faq_last_updated') }}</th>
                        <th class="text-right">{{ __('app.remove') }}</th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach ($faqs as $faq)
                        <tr>
                            <td>
                                #{{ $faq->id }}
                            </td>

                            <td class="right">
                                <a href="javascript:void(0)" onclick="document.getElementById('faq-id').value = {{ $faq->id }}; document.getElementById('faq-question').value = '{{ $faq->question }}'; document.getElementById('faq-answer').value = '{{ $faq->answer }}'; vue.bShowEditFaq = true;" title="{{ __('app.faq_edit') }}">{{ $faq->question }}</a>
                            </td>

                            <td>
                                <?php
                                if (strlen($faq->answer) > 20) {
                                    echo substr($faq->answer, 0, 20) . '...';
                                } else {
                                    echo $faq->answer;
                                }
                                ?>
                            </td>

                            <td><div title="{{ $faq->updated_at }}">{{ $faq->updated_at->diffForHumans() }}</div></td>

                            <td>
                                <a href="javascript:void(0)" onclick="if (confirm('{{ __('app.faq_remove_confirm') }}')) location.href = '{{ url('/admin/faq/' . $faq->id . '/remove') }}';">{{ __('app.faq_remove') }}</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                <br/>

                <center><a class="button" href="javascript:void(0)" onclick="location.reload();">{{ __('app.refresh') }}</a>&nbsp;&nbsp;&nbsp;&nbsp;
                <a class="button is-success" onclick="vue.bShowCreateFaq = true;">{{ __('app.create') }}</a></center><br/>
            </div>

            <div id="tab-page-12">
                <form method="POST" action="{{ url('/admin/newsletter') }}">
                    @csrf

                    <div class="field">
                        <label class="label">{{ __('app.subject') }}</label>
                        <div class="control">
                            <input type="text" name="subject">
                        </div>
                    </div>

                    <div class="field">
                        <label class="label">{{ __('app.text') }}</label>
                        <div class="control">
                            <textarea name="content"></textarea>
                        </div>
                    </div>

                    <div class="field">
                        <div class="control">
                            <input type="submit" value="{{ __('app.send') }}">
                        </div>
                    </div>
                </form>
            </div>

            <div id="tab-page-13">
                <table class="table striped table-border mt-4" data-role="table" data-pagination="true"
                        data-table-rows-count-title="{{ __('app.table_show_entries') }}"
                        data-table-search-title="{{ __('app.table_search') }}"
                        data-table-info-title="{{ __('app.table_row_info') }}"
                        data-pagination-prev-title="{{ __('app.table_pagination_prev') }}"
                        data-pagination-next-title="{{ __('app.table_pagination_next') }}">
                    <thead>
                    <tr>
                        <th class="text-left">{{ __('app.report_id') }}</th>
                        <th class="text-left">{{ __('app.report_user') }}</th>
                        <th class="text-left">{{ __('app.report_reason') }}</th>
                        <th class="text-left">{{ __('app.report_count') }}</th>
                        <th class="text-right">{{ __('app.report_lock') }}</th>
                        <th class="text-right">{{ __('app.report_safe') }}</th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach ($reports as $item)
                        <tr>
                            <td>
                                #{{ $item['id'] }}
                            </td>

                            <td class="right">
                                <a href="{{ url('/user/' . \App\Models\User::get($item['targetId'])->name) }}" target="_blank">{{ \App\Models\User::get($item['targetId'])->name }}</a>
                            </td>

                            <td>
                                <?php
                                    $shortReason = $item['reason'];
                                    if (strlen($item['reason']) > 20) {
                                        $shortReason = substr($item['reason'], 0, 20) . '...';
                                    }
                                ?>

                                <a href="javascript:void(0);" onclick="alert(document.getElementById('reason-{{ $item['id'] }}').value);">{{ $shortReason }}</a>
                                <textarea id="reason-{{ $item->id }}" class="is-hidden">{{ $item['reason'] }}</textarea>
                            </td>

                            <td>{{ $item['count'] }}</td>

                            <td>
                                <a href="javascript:void(0)" onclick="if (confirm('{{ __('app.report_confirm_lock') }}')) location.href = '{{ url('/admin/user/' . $item['targetId'] . '/lock') }}';">{{ __('app.report_lock') }}</a>
                            </td>

                            <td>
                                <a href="javascript:void(0)" onclick="if (confirm('{{ __('app.report_confirm_safe') }}')) location.href = '{{ url('/admin/user/' . $item['targetId'] . '/safe') }}';">{{ __('app.report_safe') }}</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <div id="tab-page-14">
                <form method="POST" action="{{ url('/admin/headcode/save') }}">
                    @csrf

                    <div class="field">
                        <label class="label">{{ __('app.headcode_description') }}</label>
                        <div class="control">
                            <textarea class="textarea" name="headcode">{{ $settings->head_code }}</textarea>
                        </div>
                    </div>

                    <div class="field">
                        <div class="control">
                            <input type="submit" value="{{ __('app.save') }}">
                        </div>
                    </div>
                </form>
            </div>

            <div id="tab-page-15">
                <form method="POST" action="{{ url('/admin/adcode/save') }}">
                    @csrf

                    <div class="field">
                        <label class="label">{{ __('app.adcode_description') }}</label>
                        <div class="control">
                            <textarea class="textarea" name="adcode">{{ $settings->ad_code }}</textarea>
                        </div>
                    </div>

                    <div class="field">
                        <div class="control">
                            <input type="submit" value="{{ __('app.save') }}">
                        </div>
                    </div>
                </form>
            </div>

            <div id="tab-page-16">
                <table class="table striped table-border mt-4" data-role="table" data-pagination="true"
                        data-table-rows-count-title="{{ __('app.table_show_entries') }}"
                        data-table-search-title="{{ __('app.table_search') }}"
                        data-table-info-title="{{ __('app.table_row_info') }}"
                        data-pagination-prev-title="{{ __('app.table_pagination_prev') }}"
                        data-pagination-next-title="{{ __('app.table_pagination_next') }}">
                    <thead>
                    <tr>
                        <th class="text-left">{{ __('app.verify_id') }}</th>
                        <th class="text-left">{{ __('app.verify_user') }}</th>
                        <th class="text-left">{{ __('app.verify_idcard_front') }}</th>
                        <th class="text-left">{{ __('app.verify_idcard_back') }}</th>
                        <th class="text-right">{{ __('app.verify_approve') }}</th>
                        <th class="text-right">{{ __('app.verify_decline') }}</th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach ($verification_users as $item)
                        <tr>
                            <td>
                                #{{ $item->id }}
                            </td>

                            <td class="right">
                                <a href="{{ url('/user/' . $item->userId) }}" target="_blank">{{ $item->user->name }}</a>
                            </td>

                            <td>
                                <a href=" {{ asset('gfx/idcards/' . $item->idcard_front) }}">{{ __('app.identity_card_front') }}</a>
                            </td>

                            <td>
                                <a href="{{ asset('gfx/idcards/' . $item->idcard_back) }}">{{ __('app.identity_card_back') }}</a>
                            </td>

                            <td>
                                <a href="javascript:void(0)" onclick="location.href = '{{ url('/admin/verify/' . $item->userId . '/approve') }}';">{{ __('app.verify_approve') }}</a>
                            </td>

                            <td>
                                <a href="javascript:void(0)" onclick="let inpReason = prompt('{{ __('app.decline_reason') }}', ''); if (!inpReason) return; location.href = '{{ url('/admin/verify/' . $item->userId . '/decline?reason=') }}' + encodeURIComponent(inpReason);">{{ __('app.verify_decline') }}</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <div id="tab-page-17">
                <table class="table striped table-border mt-4" data-role="table" data-pagination="true"
                        data-table-rows-count-title="{{ __('app.table_show_entries') }}"
                        data-table-search-title="{{ __('app.table_search') }}"
                        data-table-info-title="{{ __('app.table_row_info') }}"
                        data-pagination-prev-title="{{ __('app.table_pagination_prev') }}"
                        data-pagination-next-title="{{ __('app.table_pagination_next') }}">
                    <thead>
                    <tr>
                        <th class="text-left">{{ __('app.approval_id') }}</th>
                        <th class="text-left">{{ __('app.approval_user') }}</th>
                        <th class="text-left">{{ __('app.approval_photo') }}</th>
                        <th class="text-right">{{ __('app.approve') }}</th>
                        <th class="text-right">{{ __('app.decline') }}</th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach ($approvals as $approval)
                        <tr>
                            <td>
                                #{{ $approval->id }}
                            </td>

                            <td class="right">
                                <a href="{{ url('/user/' . $approval->user->name) }}">{{ $approval->user->name }}</a>
                            </td>

                            <td>
                                {{ $approval->which }}
                            </td>

                            <td>
                                <a href="{{ url('/admin/approval/photo/' . $approval->user->id . '/' . $approval->which . '/approve') }}">{{ __('app.approve') }}</a>
                            </td>

                            <td>
                                <a href="{{ url('/admin/approval/photo/' . $approval->user->id . '/' . $approval->which . '/decline') }}">{{ __('app.decline') }}</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="modal" :class="{'is-active': bShowCreateFeature}">
            <div class="modal-background"></div>
            <div class="modal-card">
                <header class="modal-card-head is-stretched">
                    <p class="modal-card-title">{{ __('app.feature_create') }}</p>
                    <button class="delete" aria-label="close" onclick="vue.bShowCreateFeature = false;"></button>
                </header>
                <section class="modal-card-body is-stretched">
                    <form method="POST" action="{{ url('/admin/feature/create') }}" id="formCreateFeature">
                        @csrf

                        <div class="field is-stretched">
                            <label class="label">{{ __('app.feature_title') }}</label>
                            <div class="control">
                                <input type="text" name="title">
                            </div>
                        </div>

                        <div class="field is-stretched">
                            <label class="label">{{ __('app.feature_description') }}</label>
                            <div class="control">
                                <textarea name="description"></textarea>
                            </div>
                        </div>
                    </form>
                </section>
                <footer class="modal-card-foot is-stretched">
                    <button class="button is-success" onclick="document.getElementById('formCreateFeature').submit();">{{ __('app.save') }}</button>
                    <button class="button" onclick="vue.bShowCreateFeature = false;">{{ __('app.cancel') }}</button>
                </footer>
            </div>
        </div>

        <div class="modal" :class="{'is-active': bShowEditFeature}">
            <div class="modal-background"></div>
            <div class="modal-card">
                <header class="modal-card-head is-stretched">
                    <p class="modal-card-title">{{ __('app.edit_feature') }}</p>
                    <button class="delete" aria-label="close" onclick="vue.bShowEditFeature = false;"></button>
                </header>
                <section class="modal-card-body is-stretched">
                    <form method="POST" action="{{ url('/admin/feature/edit') }}" id="formEditFeature">
                        @csrf

                        <input type="hidden" name="id" id="feature-id">

                        <div class="field is-stretched">
                            <label class="label">{{ __('app.feature_title') }}</label>
                            <div class="control">
                                <input type="text" name="title" id="feature-title">
                            </div>
                        </div>

                        <div class="field is-stretched">
                            <label class="label">{{ __('app.feature_description') }}</label>
                            <div class="control">
                                <textarea name="description" id="feature-description"></textarea>
                            </div>
                        </div>
                    </form>
                </section>
                <footer class="modal-card-foot is-stretched">
                    <button class="button is-success" onclick="document.getElementById('formEditFeature').submit();">{{ __('app.save') }}</button>
                    <button class="button" onclick="vue.bShowEditFeature = false;">{{ __('app.cancel') }}</button>
                </footer>
            </div>
        </div>

        <div class="modal" :class="{'is-active': bShowCreateFaq}">
            <div class="modal-background"></div>
            <div class="modal-card">
                <header class="modal-card-head is-stretched">
                    <p class="modal-card-title">{{ __('app.faq_create') }}</p>
                    <button class="delete" aria-label="close" onclick="vue.bShowCreateFaq = false;"></button>
                </header>
                <section class="modal-card-body is-stretched">
                    <form method="POST" action="{{ url('/admin/faq/create') }}" id="formCreateFaq">
                        @csrf

                        <div class="field is-stretched">
                            <label class="label">{{ __('app.faq_question') }}</label>
                            <div class="control">
                                <input type="text" name="question">
                            </div>
                        </div>

                        <div class="field is-stretched">
                            <label class="label">{{ __('app.faq_answer') }}</label>
                            <div class="control">
                                <textarea name="answer"></textarea>
                            </div>
                        </div>
                    </form>
                </section>
                <footer class="modal-card-foot is-stretched">
                    <button class="button is-success" onclick="document.getElementById('formCreateFaq').submit();">{{ __('app.save') }}</button>
                    <button class="button" onclick="vue.bShowCreateFaq = false;">{{ __('app.cancel') }}</button>
                </footer>
            </div>
        </div>

        <div class="modal" :class="{'is-active': bShowEditFaq}">
            <div class="modal-background"></div>
            <div class="modal-card">
                <header class="modal-card-head is-stretched">
                    <p class="modal-card-title">{{ __('app.edit_faq') }}</p>
                    <button class="delete" aria-label="close" onclick="vue.bShowEditFaq = false;"></button>
                </header>
                <section class="modal-card-body is-stretched">
                    <form method="POST" action="{{ url('/admin/faq/edit') }}" id="formEditFaq">
                        @csrf

                        <input type="hidden" name="id" id="faq-id">

                        <div class="field is-stretched">
                            <label class="label">{{ __('app.faq_question') }}</label>
                            <div class="control">
                                <input type="text" name="question" id="faq-question">
                            </div>
                        </div>

                        <div class="field is-stretched">
                            <label class="label">{{ __('app.faq_answer') }}</label>
                            <div class="control">
                                <textarea name="answer" id="faq-answer"></textarea>
                            </div>
                        </div>
                    </form>
                </section>
                <footer class="modal-card-foot is-stretched">
                    <button class="button is-success" onclick="document.getElementById('formEditFaq').submit();">{{ __('app.save') }}</button>
                    <button class="button" onclick="vue.bShowEditFaq = false;">{{ __('app.cancel') }}</button>
                </footer>
            </div>
        </div>
    </div>
@endsection

@section('javascript')
    <script>
        function getUserDetails(ident)
        {
            window.vue.ajaxRequest('get', '{{ url('/admin/user/details') }}?ident=' + ident, {}, function(response) {
                if (response.code === 200) {
                    document.getElementById('user_settings').classList.remove('is-hidden');

                    document.getElementById('user_id').value = response.data.id;

                    document.getElementById('user_name').value = response.data.name;
                    document.getElementById('user_email').value = response.data.email;

                    document.getElementById('user_deactivated').checked = response.data.deactivated;
                    document.getElementById('user_admin').checked = response.data.admin;
                } else {
                    document.getElementById('user_settings').classList.add('is-hidden');
                    alert(response.msg);
                }
            });
        }
    </script>
@endsection
