{{--
    Astarlove (dnyAstarlove) developed by Daniel Brendel

    (C) 2021 - 2022 by Daniel Brendel

    Contact: dbrendel1988<at>gmail<dot>com
    GitHub: https://github.com/danielbrendel/

    Released under the MIT license
--}}

@extends('layouts.layout_home')

@section('title', env('APP_NAME') . ' - ' . __('app.messages'))

@section('content')
    <div class="form">
        <div class="member-form is-default-padding member-form-fixed-top">
            <div>
                <h1>{{ __('app.messages') }}</h1>
            </div>

			<!--div>
				<button type="button" class="button" onclick="location.href = '{{ url('/messages/create') }}';">{{ __('app.create') }}</button><br/><br/>
			</div-->

            <div class="messages">
                <div class="messages-list" id="messages-list"></div>
            </div>
        </div>
    </div>

    <div class="column is-2 is-sidespacing"></div>
@endsection

@section('javascript')
    <script>
        window.paginateList = null;
        window.previousMsgId = null;
        window.msgListCounter = 1;

        window.fetchMessageList = function() {
            document.getElementById('messages-list').innerHTML += '<div id="spinner"><i class="fas fa-spinner fa-spin"></i></div>';

            if (document.getElementById('loadmore') !== null) {
                document.getElementById('loadmore').remove();
            }
            
            window.vue.ajaxRequest('get', '{{ url('/messages/list') }}' + ((window.paginateList !== null) ? '?paginate=' + window.paginateList : ''), {}, function(response) {
                if (response.code === 200) {  
                    if (document.getElementById('spinner') !== null) {
                        document.getElementById('spinner').remove();
                    }

                    response.data.forEach(function(elem, index){
                        let html = window.vue.renderMessageListItem(elem);

                        document.getElementById('messages-list').innerHTML += html;
                    });

                    if (response.data.length > 0) {
                        window.paginateList = response.data[response.data.length - 1].updated_at;

                        document.getElementById('messages-list').innerHTML += '<div id="loadmore" class="is-pointer" onclick="window.fetchMessageList();"><br/><center><i class="fas fa-plus"></i></center></div>';
                    } else {
                        document.getElementById('messages-list').innerHTML += "<div><br/>{{ __('app.no_more_messages') }}</div>"
                    }
                }
          });
        };

        document.addEventListener('DOMContentLoaded', function() {
           window.fetchMessageList();
        });
    </script>
@endsection
