@extends('layouts.dashboard.app')


@section('content')
    <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
        <div class="card-body px-4 py-3">
            {{-- breadcrumb --}}
            <div class="row align-items-center">
                <div class="col-9">
                    <h4 class="fw-semibold mb-8">Chat</h4>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a class="text-muted text-decoration-none" href="../main/index.html">Home</a>
                            </li>
                            <li class="breadcrumb-item" aria-current="page">Chat</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-3">
                    <div class="text-center mb-n5">
                        <img src="{{ asset('assets') }}/images/breadcrumb/ChatBc.png" alt="modernize-img"
                            class="img-fluid mb-n4" />
                    </div>
                </div>
            </div>
            {{-- end breadcrumb --}}
        </div>
    </div>
    <div class="card overflow-hidden chat-application">
        <div class="d-flex">
            {{-- user chat box --}}
            <div class="w-30 d-none d-lg-block border-end user-chat-box">
                {{-- doctor info with search --}}
                @include('doctor.chat.inc.doctor-info')
                {{-- end doctor info with search --}}

                {{-- chat list --}}
                @include('doctor.chat.inc.chat-list', ['chats' => $chats])
                {{-- end chat list --}}

            </div>
            {{-- end user chat box --}}
            <div class="w-70 w-xs-100 chat-container">
                <div class="chatting-box d-block">
                    <div class="d-flex parent-chat-box" id="parent-chat-box">

                        <div class="chat-box w-xs-100" id="chat_image_box">
                            <div class="chat-box-inner p-9" data-simplebar>
                                <div class="text-center">
                                    <img src="{{ asset('assets') }}/images/breadcrumb/ChatBc.png" alt="modernize-img"
                                        class="img-fluid mb-n4" />
                                </div>
                            </div>
                        </div>


                        <div class="chat-box w-xs-100 d-none" id="chat_box_view">
                            <div class="chat-box-inner p-9" data-simplebar>
                                {{-- chat list --}}

                                <div class="chat-list chat active-chat" id="messages-wrapper">

                                </div>
                                {{-- end chat list --}}

                            </div>

                            {{-- chat send message footer --}}
                            <div class="px-9
                                    py-6 border-top chat-send-message-footer">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-center gap-2 w-85">
                                        <a class="position-relative nav-icon-hover z-index-5" href="javascript:void(0)">
                                            <i class="ti ti-heart text-dark bg-hover-primary fs-7"></i>
                                        </a>
                                        <input type="text"
                                            class="form-control message-type-box text-muted border-0 p-0 ms-2"
                                            placeholder="Type a Message" fdprocessedid="0p3op" />
                                    </div>
                                    <ul class="list-unstyledn mb-0 d-flex align-items-center">
                                        <li>
                                            <a class="text-dark px-2 fs-7 bg-hover-primary nav-icon-hover position-relative z-index-5"
                                                href="javascript:void(0)">
                                                <i class="ti ti-photo-plus"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a class="text-dark px-2 fs-7 bg-hover-primary nav-icon-hover position-relative z-index-5"
                                                href="javascript:void(0)">
                                                <i class="ti ti-paperclip"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a class="text-dark px-2 fs-7 bg-hover-primary nav-icon-hover position-relative z-index-5"
                                                href="javascript:void(0)">
                                                <i class="ti ti-microphone"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            {{-- end chat send message footer --}}
                        </div>


                        {{-- chat offcanvas --}}
                        @include('doctor.chat.inc.fav', ['favChats' => $favChats])
                        {{-- end chat offcanvas --}}
                    </div>

                </div>
            </div>
        </div>
    </div>
    </div>
@endsection



@include('doctor.chat.inc.script.get-chat-message')




