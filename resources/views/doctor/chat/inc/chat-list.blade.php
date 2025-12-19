 <div class="app-chat">
     <ul class="chat-users mb-0 mh-n100" data-simplebar>
         @forelse ($chats as $chat)
             @if ($chat->lastMessage)
                 <li>
                     <a href="javascript:void(0)"
                         class="click_chat px-4 py-3 bg-hover-light-black d-flex align-items-start justify-content-between chat-user bg-light-subtle"
                         id="chat_{{ $chat->id }}" data-chat-id="{{ $chat->id }}" data-user-id="1">
                         <div class="d-flex align-items-center flex-grow-1">
                             <span class="position-relative">
                                 <img src="{{ $chat->user->image }}" alt="user1" width="48" height="48"
                                     class="rounded-circle" />

                             </span>
                             <div class="ms-3 d-inline-block flex-grow-1">
                                 <h6 class="mb-1 fw-semibold chat-title" data-username="James Anderson">
                                     {{ $chat->user->name }}
                                 </h6>
                                @php
                                    $lm = $chat->lastMessage;
                                @endphp
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
                         </div>
                         <div class="d-flex align-items-center gap-2">
                             <p class="fs-2 mb-0 text-muted">{{ $chat->last_message_at?->diffForHumans() }}</p>
                             <button type="button" class="favorite-chat-btn btn btn-link p-0 {{ $chat->isFavorite ? 'is-favorite' : '' }}"
                                 data-chat-id="{{ $chat->id }}"
                                 title="{{ $chat->isFavorite ? 'Remove from favorites' : 'Add to favorites' }}">
                                 <i class="ti ti-star{{ $chat->isFavorite ? '-filled' : '' }} fs-4"></i>
                             </button>
                             <span class="fs-2 mb-0" id="unread_message">{{ $chat->unread_messages_count > 0 ? $chat->unread_messages_count : '' }}</span>
                         </div>
                     </a>
                 </li>
             @endif
         @empty
             <p>No Chats</p>
         @endforelse
     </ul>
 </div>
