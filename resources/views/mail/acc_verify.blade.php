{{--
    Astarlove (dnyAstarlove) developed by Daniel Brendel

    (C) 2021 - 2022 by Daniel Brendel

    Contact: dbrendel1988<at>gmail<dot>com
    GitHub: https://github.com/danielbrendel/

    Released under the MIT license
--}}

@extends('layouts.layout_email')

@section('title')
    {{ __('app.mail_acc_verify_title') }}
@endsection

@section('body')
    <strong><i>{{ __('app.mail_acc_verify_info') }}</i></strong>
    <br/><br/>
    {{ __('app.mail_salutation', ['name' => $name]) }}
    <br/><br/>
    {{ __('app.mail_acc_verify_body', ['state' => $state, 'reason' => $reason]) }}
    <br/><br/>
@endsection

