 <div class="app-chat">
    <ul class="chat-users mb-0 mh-n100" data-simplebar>
        @foreach ($chats as $chat)
        <li>
            <a href="javascript:void(0)"
                class="px-4 py-3 bg-hover-light-black d-flex align-items-start justify-content-between chat-user bg-light-subtle"
                id="chat_user_1" data-user-id="1">
                <div class="d-flex align-items-center">
                    <span class="position-relative">
                        <img src="{{ $chat->user->image }}" alt="user1"
                            width="48" height="48" class="rounded-circle" />

                    </span>
                    <div class="ms-3 d-inline-block w-75">
                        <h6 class="mb-1 fw-semibold chat-title"
                            data-username="James Anderson">
                            {{ $chat->user->name }}
                        </h6>
                        <span class="fs-3 text-truncate text-body-color d-block">{{ $chat->lastMessage?->content }}</span>
                    </div>
                </div>
                <p class="fs-2 mb-0 text-muted">{{ $chat->last_message_at->diffForHumans() }}</p>
                <span class="fs-2 mb-0">{{  $chat->messages->count() }}</span>

            </a>
        </li>
        @endforeach
    </ul>
</div>
