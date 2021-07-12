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
        <div>
            <div class="event-header">
                {{ $event->name }}
            </div>

            @if ($event->ownerOrAdmin)
            <div class="dropdown event-dropdown is-right" id="event-options">
                <div class="dropdown-trigger">
                    <i class="fas fa-ellipsis-v is-pointer" onclick="window.vue.toggleContextMenu(document.getElementById('event-options'));"></i>
                </div>
                
                <div class="dropdown-menu" role="menu">
                    <div class="dropdown-content">
                    <a onclick="window.vue.bShowEditEvent = true; window.vue.toggleContextMenu(document.getElementById('event-options'));" href="javascript:void(0)" class="dropdown-item">
                            <i class="far fa-edit"></i>&nbsp;{{ __('app.edit') }}
                        </a>

                        <a onclick="window.vue.deleteEvent({{ $event->id }}); window.vue.toggleContextMenu(document.getElementById('event-options'));" href="javascript:void(0)" class="dropdown-item">
                            <i class="fas fa-times"></i>&nbsp;{{ __('app.delete') }}
                        </a>
                    </div>
                </div>
            </div>
            @endif
        </div>

        <div class="event-info">
            <span><i class="fas fa-clock"></i>&nbsp;{{ date('Y-m-d', strtotime($event->dateOfEvent)) }}</span>
            <span><i class="fas fa-map-marker-alt"></i>&nbsp;{{ ucfirst($event->location) }}</span>
        </div>

        @if ((!$event->initialApproved) || (!$event->approved))
        <div class="event-approval">
            {{ __('app.not_approved_yet') }}
        </div>
        @endif

        <div class="event-content">
            {!! $event->content !!}
        </div>

        <div class="event-participants">
            <div class="event-small-headline">{{ __('app.participants') }}</div>

            <div>
                @if (count($event->participants) === 0)
                    <i>{{ __('app.no_participants_yet') }}</i>
                @endif

                <div class="events-userlist">
                    @foreach ($event->participants as $item)
                        <div class="event-user-item">
                            <div class="event-user-avatar">
                                <a href="{{ url('/user/' . $item->user->name) }}"><img src="{{ asset('gfx/avatars/' . $item->user->avatar) }}" alt="avatar" title="{{ $item->user->name }}"/></a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div>
                @if ($event->self_participating)
                    <a href="{{ url('/events/' . $event->id . '/participate/remove') }}" class="button is-primary is-outlined">{{ __('app.no_participating_anymore') }}</a>
                @else
                    <a href="{{ url('/events/' . $event->id . '/participate/add') }}" class="button is-primary">{{ __('app.do_participate') }}</a>
                @endif
            </div>

            <hr/>
        </div>

        <div class="event-interested">
            <div class="event-small-headline">{{ __('app.interested') }}</div>

            <div>
                @if (count($event->participants) === 0)
                    <i>{{ __('app.no_interested_yet') }}</i>
                @endif

                <div class="events-userlist">
                    @foreach ($event->interested as $item)
                        <div class="event-user-item">
                            <div class="event-user-avatar">
                                <a href="{{ url('/user/' . $item->user->name) }}"><img src="{{ asset('gfx/avatars/' . $item->user->avatar) }}" alt="avatar" title="{{ $item->user->name }}"/></a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div>
                @if ($event->self_interested)
                    <a href="{{ url('/events/' . $event->id . '/interested/remove') }}" class="button is-info is-outlined">{{ __('app.not_interested_anymore') }}</a>
                @else
                    <a href="{{ url('/events/' . $event->id . '/interested/add') }}" class="button is-info">{{ __('app.do_set_interested') }}</a>
                @endif
            </div>

            <hr/>
        </div>

        <div class="event-thread">
            <div class="event-small-headline">{{ __('app.comments') }}</div>

            <div class="event-thread-form">
                <form method="POST" action="{{ url('/events/' . $event->id . '/thread/add') }}">
                    @csrf

                    <div class="field">
                        <div class="control">
                            <div id="input-text-comment"></div>
                            <textarea class="is-hidden" name="content" id="post-text-comment">{{ $event->content }}</textarea>
                        </div>
                    </div>

                    <div class="field">
                        <div class="control">
                            <input type="submit" class="button is-success" value="{{ __('app.send') }}">
                        </div>
                    </div>
                </form>
            </div>

            <div class="event-thread-content" id="event-thread-content"></div>
        </div>
    </div>

    <div class="modal" :class="{'is-active': bShowEditEvent}">
        <div class="modal-background"></div>
        <div class="modal-card">
            <header class="modal-card-head is-stretched">
                <p class="modal-card-title">{{ __('app.event_edit') }}</p>
                <button class="delete" aria-label="close" onclick="vue.bShowEditEvent = false;"></button>
            </header>
            <section class="modal-card-body is-stretched">
                <form method="POST" action="{{ url('/events/edit/' . $event->id) }}" id="formEditEvent">
                    @csrf

                    <div class="field is-stretched">
                        <label class="label">{{ __('app.name') }}</label>
                        <div class="control">
                            <input type="text" name="name" value="{{ $event->name }}" required>
                        </div>
                    </div>

                    <div class="field is-stretched">
                        <label class="label">{{ __('app.description') }}</label>
                        <div class="control">
                            <textarea name="content" id="post-text">{{ $event->content }}</textarea>
                        </div>
                    </div>

                    <div class="field is-stretched">
                        <label class="label">{{ __('app.dateOfEvent') }}</label>
                        <div class="control">
                            <input type="date" class="input" name="dateOfEvent" value="{{ date('Y-m-d', strtotime($event->dateOfEvent)) }}" required>
                        </div>
                    </div>

                    <div class="field is-stretched">
                        <label class="label">{{ __('app.location') }}</label>
                        <div class="control">
                            <input type="text" name="location" value="{{ ucfirst($event->location) }}" required>
                        </div>
                    </div>
                </form>
            </section>
            <footer class="modal-card-foot is-stretched">
                <button class="button is-success" onclick="document.getElementById('formEditEvent').submit();">{{ __('app.save') }}</button>
                <button class="button" onclick="vue.bShowEditEvent = false;">{{ __('app.cancel') }}</button>
            </footer>
        </div>
    </div>

    <div class="modal" :class="{'is-active': bShowEditEventComment}">
        <div class="modal-background"></div>
        <div class="modal-card">
            <header class="modal-card-head is-stretched">
            <p class="modal-card-title">{{ __('app.edit_event_comment') }}</p>
            <button class="delete" aria-label="close" onclick="window.vue.bShowEditEventComment = false;"></button>
            </header>
            <section class="modal-card-body is-stretched">
                <form method="POST" action="{{ url('/events/thread/edit') }}" id="formEditEventComment">
                    @csrf

                    <input type="hidden" name="id" id="comment_entry_id" value=""/>

                    <div class="field">
                        <label class="label">{{ __('app.text') }}</label>
                        <div class="control">
                            <textarea name="content" id="comment_entry_content"></textarea>
                        </div>
                    </div>

                    <input type="submit" id="editeventcmtsubmit" class="is-hidden">
                </form>
            </section>
            <footer class="modal-card-foot is-stretched">
            <button class="button is-success" onclick="document.getElementById('editeventcmtsubmit').click();">{{ __('app.save') }}</button>
            <button class="button" onclick="window.vue.bShowEditEventComment = false;">{{ __('app.cancel') }}</button>
            </footer>
        </div>
    </div>
@endsection

@section('javascript')
    <script>
        var quillEditorComment = new Quill('#input-text-comment', {
            theme: 'snow',
            placeholder: '{{ __('app.type_something') }}',
        });

        quillEditorComment.on('editor-change', function(eventName, ...args) {
            document.getElementById('post-text-comment').value = quillEditorComment.root.innerHTML;
        });

        window.paginate = null;

        window.queryComments = function() {
            let content = document.getElementById('event-thread-content');

            let loadmore = document.getElementById('loadmore');
            if (loadmore) {
                loadmore.remove();
            }

            content.innerHTML += '<div id="spinner"><br/><center><i class="fas fa-spinner fa-spin"></i></center></div>';

            window.vue.ajaxRequest('post', '{{ url('/events/' . $event->id . '/thread/query') }}', { paginate: window.paginate }, function(response) {
                if (response.code == 200) {
                    let spinner = document.getElementById('spinner');
                    if (spinner) {
                        spinner.remove();
                    }

                    response.data.forEach(function(elem, index){
                        let html = window.vue.renderEventComment(elem);

                        content.innerHTML += html;
                    });

                    if (response.data.length > 0) {
                        window.paginate = response.data[response.data.length - 1].id;

                        content.innerHTML += '<div id="loadmore" class="is-pointer" onclick="window.queryComments();"><br/><center><i class="fas fa-plus"></i></center></div>';
                    } else {
                        content.innerHTML += '<div><br/><center>{{ __('app.no_more_comments') }}</center></div>';
                    }
                } else {
                    console.error(response.msg);
                }
            });
        };

        document.addEventListener('DOMContentLoaded', function() {
            window.queryComments();
        });
    </script>
@endsection