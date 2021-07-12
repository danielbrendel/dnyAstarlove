{{--
    Astarlove (dnyAstarlove) developed by Daniel Brendel

    (C) 2021 by Daniel Brendel

    Contact: dbrendel1988<at>gmail<dot>com
    GitHub: https://github.com/danielbrendel/

    Released under the MIT license
--}}

@extends('layouts.layout_home')

@section('title', env('APP_NAME'))

@section('content')
    <div class="form">
        <h4>{{ __('app.events') }}</h4>

        <div>
            <a href="javascript:void(0);" class="button is-success" onclick="window.vue.bShowCreateEvent = true;">{{ __('app.create') }}</a>
        </div>

        <div id="events-content"></div>
    </div>

    <div class="modal" :class="{'is-active': bShowCreateEvent}">
        <div class="modal-background"></div>
        <div class="modal-card">
            <header class="modal-card-head is-stretched">
                <p class="modal-card-title">{{ __('app.event_create') }}</p>
                <button class="delete" aria-label="close" onclick="vue.bShowCreateEvent = false;"></button>
            </header>
            <section class="modal-card-body is-stretched">
                <form method="POST" action="{{ url('/events/create') }}" id="formCreateEvent">
                    @csrf

                    <div class="field is-stretched">
                        <label class="label">{{ __('app.name') }}</label>
                        <div class="control">
                            <input type="text" name="name" required>
                        </div>
                    </div>

                    <div class="field is-stretched">
                        <label class="label">{{ __('app.description') }}</label>
                        <div class="control">
                            <div id="input-text"></div>
                            <textarea class="is-hidden" name="content" id="post-text"></textarea>
                        </div>
                    </div>

                    <div class="field is-stretched">
                        <label class="label">{{ __('app.dateOfEvent') }}</label>
                        <div class="control">
                            <input type="date" class="input" name="dateOfEvent" required>
                        </div>
                    </div>

                    <div class="field is-stretched">
                        <label class="label">{{ __('app.location') }}</label>
                        <div class="control">
                            <input type="text" name="location" required>
                        </div>
                    </div>
                </form>
            </section>
            <footer class="modal-card-foot is-stretched">
                <button class="button is-success" onclick="document.getElementById('formCreateEvent').submit();">{{ __('app.save') }}</button>
                <button class="button" onclick="vue.bShowCreateEvent = false;">{{ __('app.cancel') }}</button>
            </footer>
        </div>
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

        window.queryEvents = function() {
            let content = document.getElementById('events-content');

            let loadmore = document.getElementById('loadmore');
            if (loadmore) {
                loadmore.remove();
            }

            content.innerHTML += '<div id="spinner"><br/><center><i class="fas fa-spinner fa-spin"></i></center></div>';

            window.vue.ajaxRequest('post', '{{ url('/events/query') }}', { paginate: window.paginate }, function(response) {
                if (response.code == 200) {
                    let spinner = document.getElementById('spinner');
                    if (spinner) {
                        spinner.remove();
                    }

                    response.data.forEach(function(elem, index){
                        let html = window.vue.renderEvent(elem);

                        content.innerHTML += html;
                    });

                    if (response.data.length > 0) {
                        window.paginate = response.data[response.data.length - 1].dateOfEvent;

                        content.innerHTML += '<div id="loadmore" class="is-pointer" onclick="window.queryEvents();"><br/><center><i class="fas fa-arrow-down"></i></center></div>';
                    } else {
                        content.innerHTML += '<div><br/><center>{{ __('app.no_more_events') }}</center></div>';
                    }
                } else {
                    console.error(response.msg);
                }
            });
        };

        document.addEventListener('DOMContentLoaded', function() {
            window.queryEvents();
        });
    </script>
@endsection