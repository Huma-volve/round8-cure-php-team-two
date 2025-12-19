@extends('layouts.dashboard.app')
@push('css')
    <style>
        /* Main container - fixed height with no external scroll */
        .chat-application {
            height: calc(100vh - 100px) !important; /* زيادة الارتفاع */
            display: flex !important;
            overflow: hidden;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        /* Flex layout for three columns */
        .chat-application .d-flex.w-100.h-100 {
            display: flex !important;
            width: 100% !important;
            height: 100% !important;
        }

        /* Left sidebar - user list */
        .user-chat-box {
            width: 320px;
            flex-shrink: 0;
            border-right: 1px solid #e0e0e0;
            display: flex;
            flex-direction: column;
            background: #ffffff;
            overflow: hidden;
        }

        .app-chat {
            flex: 1;
            overflow-y: auto;
            overflow-x: hidden;
        }

        /* Scrollbar styling */
        .app-chat::-webkit-scrollbar {
            width: 6px;
        }

        .app-chat::-webkit-scrollbar-thumb {
            background-color: #d1d5db;
            border-radius: 3px;
        }

        /* Middle section - chat container */
        .chat-container {
            flex: 1;
            display: flex;
            flex-direction: column;
            height: 100%;
            min-width: 0;
            background: #f8f9fa;
        }

        .chat-box-inner-part {
            display: flex;
            flex-direction: column;
            height: 100%;
            width: 100%;
        }

        /* Messages area - takes all available space */
        #messages-wrapper {
            flex: 1;
            overflow-y: auto;
            overflow-x: hidden;
            padding: 20px 25px;
            background: linear-gradient(180deg, #f8f9fa 0%, #ffffff 100%);
            display: flex;
            flex-direction: column;
        }

        #messages-wrapper::-webkit-scrollbar {
            width: 8px;
        }

        #messages-wrapper::-webkit-scrollbar-thumb {
            background-color: #cbd5e0;
            border-radius: 4px;
        }

        #messages-wrapper::-webkit-scrollbar-track {
            background-color: #f1f3f5;
        }

        /* Send message area - fixed at bottom */
        .chat-send-area {
            padding: 15px 20px;
            background: #ffffff;
            border-top: 1px solid #e0e0e0;
            flex-shrink: 0;
        }

        /* Right sidebar - favorites */
        .app-chat-offcanvas {
            width: 300px;
            flex-shrink: 0;
            border-left: 1px solid #e0e0e0;
            background: #ffffff;
            overflow-y: auto;
        }

        /* Message bubbles styling */
        .bg-primary-subtle {
            background: linear-gradient(135deg, #5d87ff 0%, #4570ea 100%) !important;
            color: white !important;
            border-radius: 18px 18px 4px 18px;
            padding: 12px 18px !important;
            max-width: 70%;
            min-width: 80px;
            word-wrap: break-word;
            word-break: break-word;
            box-shadow: 0 2px 8px rgba(93, 135, 255, 0.3);
            font-size: 1rem;
            line-height: 1.6;
            white-space: pre-wrap;
            overflow-wrap: break-word;
        }

        .bg-light {
            background-color: #ffffff !important;
            color: #2a3547 !important;
            border-radius: 18px 18px 18px 4px;
            border: 1px solid #e8eaed;
            padding: 12px 18px !important;
            max-width: 70%;
            min-width: 80px;
            word-wrap: break-word;
            word-break: break-word;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
            font-size: 1rem;
            line-height: 1.6;
            white-space: pre-wrap;
            overflow-wrap: break-word;
        }

        /* Chat list item styling */
        .click_chat {
            cursor: pointer;
            transition: all 0.3s ease;
            border-radius: 12px;
            margin: 4px 10px;
            padding: 14px !important;
            border-left: 3px solid transparent;
        }

        .click_chat:hover {
            background-color: #f8f9fa !important;
            transform: translateX(-2px);
        }

        .click_chat.active-chat {
            background: linear-gradient(90deg, #e3f2fd 0%, #f5f9ff 100%) !important;
            border-left: 3px solid #5d87ff !important;
            box-shadow: 0 2px 8px rgba(93, 135, 255, 0.1);
        }

        /* Header styling */
        .chat-box-inner-part .p-3 {
            border-bottom: 1px solid #e0e0e0 !important;
            background: #ffffff !important;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        }

        /* Input field styling */
        #message-input {
            border: 1px solid #e0e0e0 !important;
            border-radius: 24px !important;
            padding: 10px 20px !important;
            background: #f8f9fa !important;
        }

        #message-input:focus {
            background: #ffffff !important;
            border-color: #5d87ff !important;
            box-shadow: 0 0 0 3px rgba(93, 135, 255, 0.1) !important;
        }

        /* Button styling */
        .chat-send-area .btn-primary {
            border-radius: 50%;
            width: 40px;
            height: 40px;
            padding: 0 !important;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .chat-send-area .btn-link {
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .chat-send-area .btn-link:hover {
            background-color: #f1f3f5;
        }

        /* Favorite button styling */
        .favorite-chat-btn {
            transition: all 0.2s ease;
        }

        .favorite-chat-btn.is-favorite,
        .favorite-chat-btn.text-warning {
            color: #ffc107 !important;
        }

        .favorite-chat-btn:hover {
            transform: scale(1.1);
        }

        /* Empty state styling */
        .chat-not-selected {
            background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
        }

        /* Time stamp styling */
        .text-muted.fs-2 {
            font-size: 0.75rem !important;
            opacity: 0.7;
        }

        /* Image message styling */
        .chat-list img.rounded {
            border-radius: 12px !important;
            max-width: 100%;
            height: auto;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            cursor: pointer;
            transition: transform 0.2s ease;
        }

        .chat-list img.rounded:hover {
            transform: scale(1.02);
        }

        /* File preview area */
        #file-preview-area {
            padding: 8px 12px;
            background: #e8f0fe;
            border-radius: 8px;
            font-size: 0.85rem !important;
        }

        /* Loading spinner */
        .spinner-border {
            width: 2rem;
            height: 2rem;
        }

        /* Responsive adjustments */
        @media (max-width: 1199px) {
            .user-chat-box {
                width: 280px;
            }
        }

        @media (max-width: 991px) {
            .app-chat-offcanvas {
                display: none !important;
            }
        }
    </style>
@endpush

@section('content')
    <div class="card overflow-hidden chat-application">
        <div class="d-flex w-100 h-100">
            <!-- Left Sidebar: User List -->
            <div class="user-chat-box d-none d-lg-flex">
                @include('doctor.chat.inc.doctor-info')
                <div class="app-chat">
                    @include('doctor.chat.inc.chat-list', ['chats' => $chats])
                </div>
            </div>

            <!-- Middle: Chat Area -->
            <div class="chat-container">
                <div class="chat-box-inner-part">
                    <!-- Empty State -->
                    <div class="chat-not-selected h-100 d-flex flex-column align-items-center justify-content-center"
                         id="chat_image_box">
                        <img src="{{ asset('assets/images/breadcrumb/ChatBc.png') }}" alt="" class="img-fluid mb-4"
                             width="200">
                        <h5 class="text-muted">Select a conversation to start messaging</h5>
                    </div>

                    <!-- Active Chat -->
                    <div class="chat-box d-none h-100 flex-column" id="chat_box_view">
                        <!-- Chat Header -->
                        <div class="p-3 border-bottom d-flex align-items-center justify-content-between bg-white flex-shrink-0">
                            <h6 class="mb-0 fw-semibold" id="active-chat-username">User Name</h6>
                        </div>

                        <!-- Messages Area -->
                        <div class="chat-list chat active-chat" id="messages-wrapper">
                        </div>

                        <!-- Send Message Area -->
                        <div class="chat-send-area">
                            <form id="message-form">
                                @csrf
                                <input type="hidden" id="chat-id" name="chat_id" value="">
                                <input type="hidden" id="message-type" name="type" value="text">

                                <div class="d-flex align-items-center gap-2">
                                    <input type="text" id="message-input" name="content"
                                           class="form-control p-2 flex-1" placeholder="Type a message..."
                                           autocomplete="off">

                                    <div class="d-flex align-items-center gap-1">
                                        <a href="javascript:void(0)" id="image-btn"
                                           class="btn btn-link text-dark p-1" title="Attach Image">
                                            <i class="ti ti-photo fs-5"></i>
                                        </a>
                                        <input type="file" id="message-image" name="content" accept="image/*"
                                               class="d-none">

                                        <button type="submit" class="btn btn-primary" title="Send">
                                            <i class="ti ti-send fs-5"></i>
                                        </button>
                                    </div>
                                </div>
                                <div id="file-preview-area" class="mt-2"></div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Sidebar: Favorites -->
            <div class="d-none d-xl-block h-100">
                @include('doctor.chat.inc.fav', ['favChats' => $favChats])
            </div>
        </div>
    </div>
@endsection

{{--@push('js')--}}
{{--    <script>--}}
{{--        $(document).ready(function () {--}}
{{--            // CSRF Token Setup--}}
{{--            $.ajaxSetup({--}}
{{--                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}--}}
{{--            });--}}

{{--            // Scroll to bottom of messages--}}
{{--            function scrollToBottom() {--}}
{{--                const box = $('#messages-wrapper');--}}
{{--                if (box.length) {--}}
{{--                    box.animate({scrollTop: box[0].scrollHeight}, 300);--}}
{{--                }--}}
{{--            }--}}

{{--            // Append message to chat--}}
{{--            function appendMessage(msg, user) {--}}
{{--                // Handle undefined or null message--}}
{{--                if (!msg || !msg.sender_type || !msg.content) {--}}
{{--                    console.warn('Invalid message:', msg);--}}
{{--                    return;--}}
{{--                }--}}

{{--                const isMe = (msg.sender_type === 'doctor' ||--}}
{{--                    msg.sender_type.includes('Doctor') ||--}}
{{--                    msg.sender_type.toLowerCase() === 'doctor');--}}
{{--                const align = isMe ? 'justify-content-end' : 'justify-content-start';--}}
{{--                const bg = isMe ? 'bg-primary-subtle' : 'bg-light';--}}

{{--                // Handle time formatting--}}
{{--                let time = 'Now';--}}
{{--                try {--}}
{{--                    if (msg.created_at) {--}}
{{--                        time = new Date(msg.created_at).toLocaleTimeString('ar-EG', {--}}
{{--                            hour: '2-digit',--}}
{{--                            minute: '2-digit',--}}
{{--                            hour12: true--}}
{{--                        });--}}
{{--                    }--}}
{{--                } catch (e) {--}}
{{--                    console.warn('Error formatting time:', e);--}}
{{--                }--}}

{{--                let content = '';--}}
{{--                if (msg.type === 'text') {--}}
{{--                    // إزالة أي HTML وعرض النص بشكل صحيح--}}
{{--                    const cleanText = String(msg.content).replace(/<[^>]*>/g, '');--}}
{{--                    content = `<div class="${bg}" style="display: inline-block;">${cleanText}</div>`;--}}
{{--                } else if (msg.type === 'image') {--}}
{{--                    content = `<div class="p-1 d-inline-block"><img src="${msg.content}" width="250" class="rounded" alt="Image" onclick="window.open('${msg.content}', '_blank')"></div>`;--}}
{{--                } else {--}}
{{--                    // Handle other types or default to text--}}
{{--                    const cleanText = String(msg.content).replace(/<[^>]*>/g, '');--}}
{{--                    content = `<div class="${bg}" style="display: inline-block;">${cleanText}</div>`;--}}
{{--                }--}}

{{--                // User image - only show for received messages--}}
{{--                const userImage = (!isMe && user && user.image)--}}
{{--                    ? `<img src="${user.image}" width="40" height="40" class="rounded-circle" alt="User">`--}}
{{--                    : '';--}}

{{--                const html = `--}}
{{--                <div class="hstack gap-3 align-items-start mb-3 ${align}">--}}
{{--                    ${userImage}--}}
{{--                    <div style="max-width: 70%;">--}}
{{--                        ${content}--}}
{{--                        <div class="d-block text-muted ${isMe ? 'text-end' : ''}" style="font-size: 0.75rem; margin-top: 4px;">${time}</div>--}}
{{--                    </div>--}}
{{--                </div>`;--}}

{{--                $('#messages-wrapper').append(html);--}}
{{--            }--}}

{{--            // Escape HTML to prevent XSS--}}
{{--            function escapeHtml(text) {--}}
{{--                const map = {--}}
{{--                    '&': '&amp;',--}}
{{--                    '<': '&lt;',--}}
{{--                    '>': '&gt;',--}}
{{--                    '"': '&quot;',--}}
{{--                    "'": '&#039;'--}}
{{--                };--}}
{{--                return text.replace(/[&<>"']/g, m => map[m]);--}}
{{--            }--}}

{{--            // Open chat conversation--}}
{{--            $(document).on('click', '.click_chat', function () {--}}
{{--                const chatId = $(this).data('chat-id');--}}
{{--                const userName = $(this).find('.chat-title').text().trim();--}}

{{--                // Update UI--}}
{{--                $('.click_chat').removeClass('active-chat');--}}
{{--                $(this).addClass('active-chat');--}}

{{--                $('#chat_image_box').addClass('d-none');--}}
{{--                $('#chat_box_view').removeClass('d-none').addClass('d-flex');--}}
{{--                $('#chat-id').val(chatId);--}}
{{--                $('#active-chat-username').text(userName);--}}

{{--                // Show loading--}}
{{--                $('#messages-wrapper').html(--}}
{{--                    '<div class="d-flex align-items-center justify-content-center h-100">' +--}}
{{--                    '<div class="spinner-border text-primary"></div>' +--}}
{{--                    '</div>'--}}
{{--                );--}}

{{--                // Fetch messages with better error handling--}}
{{--                $.ajax({--}}
{{--                    url: `{{ route('doctor.chat.index') }}/${chatId}/messages`,--}}
{{--                    type: 'GET',--}}
{{--                    dataType: 'json',--}}
{{--                    success: function (res) {--}}
{{--                        console.log('Messages response:', res); // Debug log--}}
{{--                        $('#messages-wrapper').empty();--}}

{{--                        // Handle different response structures--}}
{{--                        let messages = [];--}}
{{--                        let user = null;--}}

{{--                        if (res.data) {--}}
{{--                            messages = res.data.messages || res.data;--}}
{{--                            user = res.data.user;--}}
{{--                        } else if (Array.isArray(res)) {--}}
{{--                            messages = res;--}}
{{--                        } else if (res.messages) {--}}
{{--                            messages = res.messages;--}}
{{--                            user = res.user;--}}
{{--                        }--}}

{{--                        if (messages && messages.length > 0) {--}}
{{--                            messages.forEach(msg => appendMessage(msg, user));--}}
{{--                            scrollToBottom();--}}
{{--                        } else {--}}
{{--                            $('#messages-wrapper').html(--}}
{{--                                '<div class="text-center text-muted mt-5">' +--}}
{{--                                '<i class="ti ti-message-off fs-1 mb-3"></i><br>' +--}}
{{--                                'No messages yet. Start the conversation!' +--}}
{{--                                '</div>'--}}
{{--                            );--}}
{{--                        }--}}
{{--                    },--}}
{{--                    error: function(xhr, status, error) {--}}
{{--                        console.error('Error loading messages:', xhr.responseText); // Debug log--}}
{{--                        $('#messages-wrapper').html(--}}
{{--                            '<div class="text-center text-danger mt-5">' +--}}
{{--                            '<i class="ti ti-alert-circle fs-1 mb-3"></i><br>' +--}}
{{--                            'Failed to load messages<br>' +--}}
{{--                            '<small>' + (xhr.responseJSON?.message || error) + '</small>' +--}}
{{--                            '</div>'--}}
{{--                        );--}}
{{--                    }--}}
{{--                });--}}
{{--            });--}}

{{--            // Send message--}}
{{--            $('#message-form').on('submit', function (e) {--}}
{{--                e.preventDefault();--}}

{{--                const chatId = $('#chat-id').val();--}}
{{--                const messageText = $('#message-input').val().trim();--}}
{{--                const imageFile = $('#message-image')[0].files.length;--}}

{{--                if (!messageText && !imageFile) return;--}}

{{--                const formData = new FormData(this);--}}
{{--                const $submitBtn = $(this).find('button[type="submit"]');--}}
{{--                $submitBtn.prop('disabled', true);--}}

{{--                $.ajax({--}}
{{--                    url: `{{ route('doctor.chat.index') }}/${chatId}/message`,--}}
{{--                    type: "POST",--}}
{{--                    data: formData,--}}
{{--                    processData: false,--}}
{{--                    contentType: false,--}}
{{--                    success: function (res) {--}}
{{--                        if (res.data) {--}}
{{--                            appendMessage(res.data, null);--}}

{{--                            // Update sidebar preview--}}
{{--                            const previewText = res.data.type === 'text'--}}
{{--                                ? res.data.content--}}
{{--                                : '📷 Image';--}}
{{--                            $(`#chat_${chatId} .text-truncate`).text(previewText);--}}

{{--                            // Reset form--}}
{{--                            $('#message-input').val('');--}}
{{--                            $('#message-image').val('');--}}
{{--                            $('#file-preview-area').empty();--}}
{{--                            $('#message-type').val('text');--}}

{{--                            scrollToBottom();--}}
{{--                        }--}}
{{--                    },--}}
{{--                    error: function() {--}}
{{--                        alert('Failed to send message. Please try again.');--}}
{{--                    },--}}
{{--                    complete: function() {--}}
{{--                        $submitBtn.prop('disabled', false);--}}
{{--                    }--}}
{{--                });--}}
{{--            });--}}

{{--            // Toggle favorite--}}
{{--            $(document).on('click', '.favorite-chat-btn', function (e) {--}}
{{--                e.preventDefault();--}}
{{--                e.stopPropagation();--}}

{{--                const $btn = $(this);--}}
{{--                const chatId = $btn.data('chat-id');--}}
{{--                const isFav = $btn.hasClass('is-favorite') ||--}}
{{--                    $btn.find('i').hasClass('ti-star-filled') ||--}}
{{--                    $btn.find('i').hasClass('ti-trash');--}}

{{--                const url = isFav--}}
{{--                    ? "{{ route('doctor.chat.favorite.remove') }}"--}}
{{--                    : "{{ route('doctor.chat.favorite.add') }}";--}}

{{--                $.post(url, {chat_id: chatId}, function (res) {--}}
{{--                    if (!isFav) {--}}
{{--                        // Add to favorites--}}
{{--                        $btn.addClass('is-favorite text-warning')--}}
{{--                            .find('i')--}}
{{--                            .removeClass('ti-star')--}}
{{--                            .addClass('ti-star-filled');--}}

{{--                        // Reload to update favorites sidebar--}}
{{--                        setTimeout(() => location.reload(), 300);--}}
{{--                    } else {--}}
{{--                        // Remove from favorites--}}
{{--                        $(`li[data-fav-chat-id="${chatId}"]`).fadeOut(300);--}}
{{--                        $(`#chat_${chatId}`)--}}
{{--                            .find('.favorite-chat-btn')--}}
{{--                            .removeClass('is-favorite text-warning')--}}
{{--                            .find('i')--}}
{{--                            .removeClass('ti-star-filled')--}}
{{--                            .addClass('ti-star');--}}
{{--                    }--}}
{{--                }).fail(function() {--}}
{{--                    alert('Failed to update favorite status');--}}
{{--                });--}}
{{--            });--}}

{{--            // Image upload button--}}
{{--            $('#image-btn').on('click', function() {--}}
{{--                $('#message-image').click();--}}
{{--            });--}}

{{--            // Image file selection--}}
{{--            $('#message-image').on('change', function () {--}}
{{--                const file = this.files[0];--}}
{{--                if (file) {--}}
{{--                    // Validate file size (max 5MB)--}}
{{--                    if (file.size > 5 * 1024 * 1024) {--}}
{{--                        alert('File size must be less than 5MB');--}}
{{--                        $(this).val('');--}}
{{--                        return;--}}
{{--                    }--}}

{{--                    $('#message-type').val('image');--}}
{{--                    $('#file-preview-area').html(--}}
{{--                        `<i class="ti ti-photo"></i> Selected: <strong>${file.name}</strong>`--}}
{{--                    );--}}
{{--                } else {--}}
{{--                    $('#message-type').val('text');--}}
{{--                    $('#file-preview-area').empty();--}}
{{--                }--}}
{{--            });--}}

{{--            // Auto-focus on message input when chat is opened--}}
{{--            $(document).on('click', '.click_chat', function() {--}}
{{--                setTimeout(() => $('#message-input').focus(), 500);--}}
{{--            });--}}
{{--        });--}}
{{--    </script>--}}
{{--@endpush--}}