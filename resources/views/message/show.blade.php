{{--
    Astarlove (dnyAstarlove) developed by Daniel Brendel

    (C) 2021 by Daniel Brendel

    Contact: dbrendel1988<at>gmail<dot>com
    GitHub: https://github.com/danielbrendel/

    Released under the MIT license
--}}

@extends('layouts.layout_home')

@section('title', env('APP_NAME') . ' - ' . __('app.messages'))

@section('content')
    <div class="form">
        <div>
            <div><h1>{{ __('app.message_thread', ['name' => $msg->message_partner]) }}</h1></div>
            <div class="is-action-right is-top-negative-41"><a href="{{ url('/messages') }}">{{ __('app.back') }}</a></div>
        </div>

        <div class="member-form is-default-padding member-form-fixed-top">
            <form method="POST" action="{{ url('/messages/send') }}" id="frmSendMessage">
                @csrf

                <input type="hidden" name="username" value="{{ $msg->message_partner }}">

                <div class="field">
                    <label class="label">{{ __('app.subject') }}</label>
                    <div class="control">
                        <input type="text" name="subject" value="{{ $msg->subject }}">
                    </div>
                </div>

                <div class="field">
                    <label class="label">{{ __('app.text') }}</label>
                    <div class="control">
                        <div id="input-text"></div>
                        <textarea name="text" id="post-text" class="is-hidden" placeholder="{{ __('app.type_something') }}"></textarea>
                    </div>
                </div>
            </form>

            <form method="POST" action="{{ url('/messages/image') }}" enctype="multipart/form-data" id="frmSendImage">
                @csrf

                <input type="hidden" name="username" value="{{ $msg->message_partner }}">
                <input type="hidden" name="subject" value="{{ $msg->subject }}">

                <input type="file" name="image" id="inpImage" class="is-hidden">
            </form>

            <div class="field is-margin-top-10">
                <span><a class="button is-link" href="javascript:void(0);" onclick="document.getElementById('frmSendMessage').submit();">{{ __('app.send') }}</a></span>
                <span>&nbsp;<a class="is-underline" href="javascript:void(0);" onclick="window.sendImage();">{{ __('app.send_image') }}</a></span>
            </div>

            <br/><br/>
        </div>

        <div id="message-thread-content"></div>
    </div>
@endsection

@section('javascript')
    <script>
        var quillEditor = new Quill('#input-text', {
            theme: 'snow',
            placeholder: '{{ __('app.type_something') }}',
        });

        quillEditor.on('editor-change', function(eventName, ...args) {
            document.getElementById('post-text').value = quillEditor.root.innerHTML;
        });

        window.paginate = null;

        window.queryMessages = function() {
            let content = document.getElementById('message-thread-content');

            content.innerHTML += '<div id="spinner"><center><i class="fa fa-spinner fa-spin"></i></center></div>';

            let loadmore = document.getElementById('loadmore');
            if (loadmore) {
                loadmore.remove();
            }

            window.vue.ajaxRequest('post', '{{ url('/messages/query') }}', {
                id: '{{ $msg->channel }}',
                paginate: window.paginate
            },
            function(response) {
                if (response.code == 200) {
                    response.data.forEach(function(elem, index) {
                        let html = window.vue.renderMessageItem(elem, {{ auth()->id() }});

                        content.innerHTML += html;
                    });

                    if (response.data.length > 0) {
                        window.paginate = response.data[response.data.length - 1].id;
                    }

                    let spinner = document.getElementById('spinner');
                    if (spinner) {
                        spinner.remove();
                    }

                    if (response.data.length > 0) {
                        content.innerHTML += '<div id="loadmore"><center><br/><i class="fas fa-plus is-pointer" onclick="window.queryMessages();"></i></center></div>';
                    }
                } else {
                    console.error(response.msg);
                }
            });
        };

        window.sendImage = function() {
            document.getElementById('inpImage').onchange = function() {
                document.getElementById('frmSendImage').submit();
            };

            document.getElementById('inpImage').click();
        };

        document.addEventListener('DOMContentLoaded', function() {
            window.queryMessages();
        });
    </script>
@endsection
