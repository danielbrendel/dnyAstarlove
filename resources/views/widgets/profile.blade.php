{{--
    Astarlove (dnyAstarlove) developed by Daniel Brendel

    (C) 2021 - 2022 by Daniel Brendel

    Contact: dbrendel1988<at>gmail<dot>com
    GitHub: https://github.com/danielbrendel/

    Released under the MIT license
--}}

<div class="user">
    <div class="user-frame-top">
        <div class="user-frame-left">
            <div class="user-photos">
                <div class="user-photos-avatar">
                    @if (!$user->ignored)
                        <a id="imgpreview-photo-avatar" href="javascript:void(0);" onclick="window.vue.showImagePreview('avatar', '{{ $user->avatar }}', '{{ $user->name }}');"><img src="{{ asset('gfx/avatars/' . $user->avatar) }}" alt="avatar"></a>
                    @else
                        <img src="{{ asset('gfx/avatars/default.png') }}" alt="avatar">
                    @endif
                </div>

                <div class="user-photos-photos">
                    @if (!$user->ignored)
                        <div class="user-photos-photo">
                            @if ($user->photo1 !== null)
                                <a id="imgpreview-photo-photo1" href="javascript:void(0);" onclick="window.vue.showImagePreview('photo1', '{{ $user->photo1 }}', '{{ $user->name }}');"><img src="{{ asset('gfx/avatars/' . $user->photo1) }}" alt="photo"></a>
                            @else
                                <img src="{{ asset('gfx/avatars/default.png') }}" alt="photo">
                            @endif
                        </div>

                        <div class="user-photos-photo">
                            @if ($user->photo2 !== null)
                                <a id="imgpreview-photo-photo2" href="javascript:void(0);" onclick="window.vue.showImagePreview('photo2', '{{ $user->photo2 }}', '{{ $user->name }}');"><img src="{{ asset('gfx/avatars/' . $user->photo2) }}" alt="photo"></a>
                            @else
                                <img src="{{ asset('gfx/avatars/default.png') }}" alt="photo">
                            @endif
                        </div>

                        <div class="user-photos-photo">
                            @if ($user->photo3 !== null)
                                <a id="imgpreview-photo-photo3" href="javascript:void(0);" onclick="window.vue.showImagePreview('photo3', '{{ $user->photo3 }}', '{{ $user->name }}');"><img src="{{ asset('gfx/avatars/' . $user->photo3) }}" alt="photo"></a>
                            @else
                                <img src="{{ asset('gfx/avatars/default.png') }}" alt="photo">
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="user-frame-right">
            <div class="user-name">
                <div>
                    <div>{{ '@' . $user->name }}&nbsp;@if ($user->verified) <i class="far fa-check-circle is-color-dark-blue" title="{{ __('app.verified_profile') }}"></i> @endif</div>
                    
                    @if ((!isset($hide_back_link)) || (!$hide_back_link))
                        <div class="is-action-right is-top-negative-22"><a href="javascript:window.history.back();" >{{ __('app.back') }}</a></div>
                    @endif
                </div>
            </div>

            @if (($user->realname !== null) && (strlen($user->realname) > 0))
                <div class="user-realname">
                    {{ $user->realname }}
                </div>
            @endif

            <div class="user-online">
                @if (!$user->ignored)
                    @if ($user->is_online)
                        <span class="is-color-green">{{ __('app.online') }}</span>
                    @else
                        <span class="is-color-grey">{{ __('app.last_seen', ['diff' => $user->last_seen]) }}</span>
                    @endif
                @endif
            </div>

            <div class="user-baseinfos">
                @if (!$user->ignored)
                    <span><i class="fas fa-birthday-cake" title="{{ __('app.age') }}"></i>&nbsp;{{ $user->age }}&nbsp;&nbsp;</span>
                    <span><i class="fas fa-transgender-alt" title="{{ __('app.gender') }}"></i>&nbsp;{{ $user->gender }}&nbsp;&nbsp;</span>
                    <span><i class="fas fa-map-marker-alt" title="{{ __('app.location') }}"></i>&nbsp;@if ($user->location !== null) {{ $user->location }} @else {{ 'n/a' }} @endif&nbsp;&nbsp;</span>
                    <span><i class="fas fa-heart" title="{{ __('app.relationship_status') }}"></i>&nbsp;@if ($user->rel_status !== null) {{ $user->rel_status }} @else {{ 'n/a' }} @endif&nbsp;&nbsp;</span>
                    <span><i class="fas fa-arrows-alt-v" title="{{ __('app.height') }}"></i>&nbsp;@if ($user->height !== null) {{ $user->height }} @else {{ 'n/a' }} @endif&nbsp;&nbsp;</span>
                    <span><i class="fas fa-weight" title="{{ __('app.weight') }}"></i>&nbsp;@if ($user->weight !== null) {{ $user->weight }} @else {{ 'n/a' }} @endif&nbsp;&nbsp;</span>
                    <span><i class="fas fa-user-tie" title="{{ __('app.job') }}"></i>&nbsp;@if ($user->job !== null) {{ $user->job }} @else {{ 'n/a' }} @endif&nbsp;&nbsp;</span>
                @endif
            </div>

            <div class="user-introduction">
                @if (!$user->ignored)
                    @if (($user->introduction !== null) && (strlen($user->introduction) > 0))
                        {!! $user->introduction !!}
                    @else
                        {{ __('app.no_introduction_specified') }}
                    @endif
                @endif
            </div>

            <div class="user-options">
                @if (!$user->is_self)
                    @if (!$user->ignored)
                        @if ($user->both_liked)
                            <span><a class="button is-success" href="{{ url('/messages/create?u=' . $user->name) }}">{{ __('app.message') }}</a></span>

                            @if ($user->favorited)
                                <span><a class="button is-info is-outlined" href="{{ url('/member/favorites/' . $user->id . '/remove') }}">{{ __('app.remove_favorite') }}</a></span>
                            @else
                                <span><a class="button is-info" href="{{ url('/member/favorites/' . $user->id . '/add') }}">{{ __('app.add_favorite') }}</a></span>
                            @endif

                            <span><a class="button is-danger is-outlined" href="{{ url('/member/unlike/' . $user->id) }}"><i class="fas fa-heart-broken"></i>&nbsp;{{ __('app.unlike') }}</a></span>
                        @else
                            @if ($user->self_liked)
                                <span><a class="button is-outlined" href="javascript:void(0);" onclick="alert('{{ __('app.wait_until_back_liked') }}');">{{ __('app.message') }}</a></span>
                                <span><a class="button is-danger is-outlined" href="{{ url('/member/unlike/' . $user->id) }}"><i class="fas fa-heart-broken"></i>&nbsp;{{ __('app.unlike') }}</a></span>
                            @else
                                @if ($user->liked_back)
                                    <span><a class="button is-danger" href="{{ url('/member/like/' . $user->id) }}"><i class="fas fa-heart"></i>&nbsp;{{ __('app.like_back') }}</a></span>
                                @else
                                    <span><a class="button is-danger" href="{{ url('/member/like/' . $user->id) }}"><i class="fas fa-heart"></i>&nbsp;{{ __('app.like') }}</a></span>
                                @endif
                            @endif
                        @endif


                        <span class="float-right"><a href="{{ url('/member/ignore/' . $user->id) }}">{{ __('app.ignore') }}&nbsp;</a></span>
                        <span class="float-right"><a href="javascript:void(0);" onclick="window.vue.reportUser({{ $user->id }});">{{ __('app.report') }}&nbsp;|&nbsp;</a></span>
                    @else 
                        <span class="float-right"><a href="{{ url('/member/unignore/' . $user->id) }}">{{ __('app.unignore') }}</a></span>
                    @endif
                @else
                    <span><a href="{{ url('/settings?tab=profile') }}">{{ __('app.edit_profile') }}</a> | <a href="{{ url('/settings?tab=photos') }}">{{ __('app.photos') }}</a></span>
                @endif
            </div>
        </div>
    </div>

    <div class="user-frame-bottom">
        <div>
            @foreach ($user->profileItems as $key => $item)
                <div class="user-text-info">
                    <h3>{{ $item['translation'] }}</h3>

                    @if (!$user->ignored)
                        @if (strlen($item['content']) > 0)
                            {!! $item['content'] !!}
                        @else
                            {{ __('app.no_information_specified') }}
                        @endif
                    @endif
                </div>
            @endforeach
        </div>

        @if ($user->enable_gb)
            <div>
                <h3>{{ __('app.guestbook') }}</h3>

                @if ($user->id !== auth()->id())
                    <div>
                        <form method="POST" action="{{ url('/member/' . $user->id . '/guestbook/add') }}">
                            @csrf

                            <div class="field">
                                <div class="control">
                                    <div id="input-text"></div>
                                    <textarea name="text" id="post-text" class="is-hidden" placeholder="{{ __('app.type_something') }}"></textarea>
                                </div>
                            </div>

                            <div class="field">
                                <div class="control">
                                    <input type="submit" class="button is-link" value="{{ __('app.send') }}"/>
                                </div>
                            </div>
                        </form>
                    </div>
                @endif

                <div id="gb-content"></div>
            </div>
        @endif
    </div>
</div>

<div class="modal" :class="{'is-active': bShowEditGbEntry}">
    <div class="modal-background"></div>
    <div class="modal-card">
        <header class="modal-card-head is-stretched">
        <p class="modal-card-title">{{ __('app.edit_guestbook_entry') }}</p>
        <button class="delete" aria-label="close" onclick="window.vue.bShowEditGbEntry = false;"></button>
        </header>
        <section class="modal-card-body is-stretched">
            <form method="POST" action="{{ url('/guestbook/edit') }}" id="formEditGbEntry">
                @csrf

                <input type="hidden" name="id" id="gb_entry_id" value=""/>

                <div class="field">
                    <label class="label">{{ __('app.text') }}</label>
                    <div class="control">
                        <textarea name="content" id="gb_entry_content"></textarea>
                    </div>
                </div>

                <input type="submit" id="editgbentrysubmit" class="is-hidden">
            </form>
        </section>
        <footer class="modal-card-foot is-stretched">
        <button class="button is-success" onclick="document.getElementById('editgbentrysubmit').click();">{{ __('app.save') }}</button>
        <button class="button" onclick="window.vue.bShowEditGbEntry = false;">{{ __('app.cancel') }}</button>
        </footer>
    </div>
</div>

@section('javascript')
    <script>
        @if ($user->enable_gb)
            @if ($user->id !== auth()->id())
                var quillEditor = new Quill('#input-text', {
                    theme: 'snow',
                    placeholder: '{{ __('app.type_something') }}',
                });

                quillEditor.on('editor-change', function(eventName, ...args) {
                    document.getElementById('post-text').value = quillEditor.root.innerHTML;
                });
            @endif

            window.paginateGb = null;

            window.queryGuestbook = function() {
                let content = document.getElementById('gb-content');

                content.innerHTML += '<div id="spinner"><br/><center><i class="fas fa-spinner fa-spin"></i></center></div>';

                let loadmore = document.getElementById('loadmore');
                if (loadmore) {
                    loadmore.remove();
                }

                window.vue.ajaxRequest('post', '{{ url('/member/' . $user->id . '/guestbook/fetch') }}', {paginate: window.paginateGb}, function(response) {
                    if (response.code == 200) {
                        let spinner = document.getElementById('spinner');
                        if (spinner) {
                            spinner.remove();
                        }

                        response.data.forEach(function(elem, index) {
                            let html = window.vue.renderGbEntry(elem);

                            content.innerHTML += html;
                        });

                        if (response.data.length > 0) {
                            window.paginateGb = response.data[response.data.length - 1];

                            content.innerHTML += '<div id="loadmore" onclick="window.queryGuestbook();"><br/><center><i class="fas fa-plus is-pointer"></i></center></div>';
                        } else {
                            content.innerHTML += '<div><br/><center>{{ __('app.no_more_entries_found') }}</center></div>';
                        }
                    } else {
                        console.error(response.msg);
                    }
                });
            };

            document.addEventListener('DOMContentLoaded', function() {
                window.queryGuestbook();
            });
        @endif
    </script>
@endsection

@include('widgets.imgpreview')