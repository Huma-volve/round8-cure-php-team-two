<div class="app-chat-offcanvas border-start">
    <div class="custom-app-scroll mh-n100" data-simplebar>
        <h3 class="m-3">Favourites Chat</h3>
        <div class="app-chat">
            <ul class="chat-users mb-0 mh-n100" data-simplebar id="favorite-chats-list">
                @foreach ($favChats as $chat)
                <li data-fav-chat-id="{{ $chat->id }}">
                    <div class="px-4 py-3 bg-hover-light-black d-flex align-items-start justify-content-between chat-user bg-light-subtle">
                        <a href="javascript:void(0)"
                            class="flex-grow-1 d-flex align-items-center click_chat"
                            data-chat-id="{{ $chat->id }}">
                            <span class="position-relative">
                                <img src="{{ $chat->user->image }}" alt="user1"
                                    width="48" height="48" class="rounded-circle" />
                            </span>
                            <div class="ms-3 d-inline-block flex-grow-1">
                                <h6 class="mb-1 fw-semibold chat-title">
                                    {{ $chat->user->name }}
                                </h6>
                                @php $lm = $chat->lastMessage; @endphp
                                <span class="fs-3 text-truncate text-body-color d-block">
                                    @if($lm)
                                        @if($lm->type === 'text')
                                            {{ \Illuminate\Support\Str::limit($lm->content, 40) }}
                                        @elseif($lm->type === 'image')
                                            <i class="ti ti-photo"></i> Image
                                        @elseif($lm->type === 'video')
                                            <i class="ti ti-player"></i> Video
                                        @elseif($lm->type === 'audio')
                                            <i class="ti ti-microphone"></i> Voice
                                        @else
                                            {{ \Illuminate\Support\Str::limit($lm->content, 40) }}
                                        @endif
                                    @endif
                                </span>
                            </div>
                        </a>
                        <button type="button" class="favorite-chat-btn btn btn-link p-0 text-danger ms-2"
                            data-chat-id="{{ $chat->id }}"
                            title="Remove from favorites"
                            style="min-width: 32px;">
                            <i class="ti ti-trash fs-4"></i>
                        </button>
                    </div>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
