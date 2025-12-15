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
                    <div class="d-flex parent-chat-box" id="image_chat_box">
                        <div class="chat-box w-xs-100">
                            <div class="chat-box-inner p-9" data-simplebar>
                                <div class="text-center">
                                    <img src="{{ asset('assets') }}/images/breadcrumb/ChatBc.png" alt="modernize-img"
                                        class="img-fluid mb-n4" />
                                </div>
                            </div>
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


@push('js')

@endpush
