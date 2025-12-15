<div class="app-chat-offcanvas border-start">
    <div class="custom-app-scroll mh-n100" data-simplebar>
        <h3 class="m-3">Favourites Chat</h3>
        <div class="app-chat">
            <ul class="chat-users mb-0 mh-n100" data-simplebar>
                @foreach ($favChats as $fav)
                <li>
                    <a href="javascript:void(0)"
                        class="px-4 py-3 bg-hover-light-black d-flex align-items-start justify-content-between chat-user bg-light-subtle"
                        id="chat_user_1" data-user-id="1">
                        <div class="d-flex align-items-center">
                            <span class="position-relative">
                                <img src="{{ $fav->user->image }}" alt="user1"
                                    width="48" height="48" class="rounded-circle" />

                            </span>
                            <div class="ms-3 d-inline-block w-75">
                                <h6 class="mb-1 fw-semibold chat-title"
                                    data-username="James Anderson">
                                    {{ $fav->user->name }}
                                </h6>
                                <span class="fs-3 text-truncate text-body-color d-block">{{ $fav->lastMessage?->content }}</span>
                            </div>
                        </div>
                       <span class="fs-2 mb-0">{{ $fav->messages->count() }}</span>
                    </a>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
