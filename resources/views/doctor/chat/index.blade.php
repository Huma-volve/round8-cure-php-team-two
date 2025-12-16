@extends('layouts.dashboard.app')
@push('css')
    <style>
        .click_chat.active-chat {
            background-color: #e3f2fd !important;
            border-left: 4px solid #2196F3;
        }

        .unread-badge {
            background: #dc3545;
            color: white;
            border-radius: 50%;
            padding: 2px 8px;
            font-size: 12px;
        }

        .favorite-chat-btn.is-favorite {
            color: #ffc107;
        }

        .chat-box-inner {
            height: 500px;
            overflow-y: auto;
        }

        .typing-indicator {
            animation: fadeIn 0.3s;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }
    </style>
@endpush

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
                            <div class="px-9 py-6 border-top chat-send-message-footer">
                                <form id="message-form" enctype="multipart/form-data">
                                    @csrf
                                    <!-- CHAT -->
                                    <input type="hidden" id="chat-id" name="chat_id" value="">
                                    <!-- TYPE -->
                                    <input type="hidden" id="message-type" name="type" value="text">

                                    <div class="d-flex align-items-center justify-content-between">

                                        <div class="d-flex align-items-center gap-2 w-85">
                                            <a class="position-relative nav-icon-hover z-index-5" href="javascript:void(0)">
                                                <i class="ti ti-heart text-dark bg-hover-primary fs-7"></i>
                                            </a>

                                            <input type="text" id="message-input" name="content"
                                                class="form-control message-type-box text-muted border-0 p-0 ms-2"
                                                placeholder="Type a Message">
                                        </div>

                                        <ul class="list-unstyledn mb-0 d-flex align-items-center">

                                            <!-- IMAGE -->
                                            <li>
                                                <a id="image-btn"
                                                    class="text-dark px-2 fs-7 bg-hover-primary nav-icon-hover"
                                                    href="javascript:void(0)">
                                                    <i class="ti ti-photo-plus"></i>
                                                    <input type="file" id="message-image" name="content" accept="image/*"
                                                        class="d-none">
                                                </a>
                                            </li>

                                            <!-- AUDIO -->
                                            <li>
                                                <a id="audio-btn"
                                                    class="text-dark px-2 fs-7 bg-hover-primary nav-icon-hover"
                                                    href="javascript:void(0)">
                                                    <i class="ti ti-microphone"></i>
                                                    <input type="file" id="message-audio" name="content" accept="audio/*"
                                                        class="d-none">
                                                </a>
                                            </li>

                                        </ul>
                                    </div>
                                </form>
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



{{-- @include('doctor.chat.inc.script.get-chat-message')


@include('doctor.chat.inc.script.send-messages') --}}

@push('js')
    <script>
        /**
         * Complete Chat System - jQuery Implementation
         */

        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            let currentChatId = null;
            let isAtBottom = true;

            /* UTILITY FUNCTIONS */
            window.formatDate = function(date) {
                const d = new Date(date);
                const day = ('0' + d.getDate()).slice(-2);
                const month = ('0' + (d.getMonth() + 1)).slice(-2);
                const hours = ('0' + d.getHours()).slice(-2);
                const minutes = ('0' + d.getMinutes()).slice(-2);
                return `${day}-${month} ${hours}:${minutes}`;
            };

            function scrollToBottom(smooth = true) {
                const chatBox = $('.chat-box-inner')[0];
                if (!chatBox) return;

                if (smooth) {
                    $(chatBox).animate({
                        scrollTop: chatBox.scrollHeight
                    }, 300);
                } else {
                    chatBox.scrollTop = chatBox.scrollHeight;
                }
                isAtBottom = true;
            }

            function checkIfAtBottom() {
                const chatBox = $('.chat-box-inner')[0];
                if (!chatBox) return true;

                const threshold = 100;
                isAtBottom = (chatBox.scrollHeight - chatBox.scrollTop - chatBox.clientHeight) < threshold;
                return isAtBottom;
            }

            $('.chat-box-inner').on('scroll', function() {
                checkIfAtBottom();
            });

            function showTypingIndicator() {
                const indicator = `
            <div class="typing-indicator mb-3" id="typing-indicator">
                <div class="hstack gap-3 align-items-start justify-content-start">
                    <div class="spinner-border spinner-border-sm text-muted" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <span class="text-muted fs-3">Sending...</span>
                </div>
            </div>
        `;
                $('#messages-wrapper').append(indicator);
                scrollToBottom();
            }

            function hideTypingIndicator() {
                $('#typing-indicator').remove();
            }

            /* LOAD CHAT MESSAGES */
            $(document).on('click', '.click_chat', function(e) {
                e.preventDefault();

                const $chatElement = $(this);
                const chatId = $chatElement.data('chat-id');
                currentChatId = chatId;

                $('.click_chat').removeClass('active-chat');
                $chatElement.addClass('active-chat');

                const url = $chatElement.attr('href') || `/doctor/chat/${chatId}/messages`;

                $('#chat_image_box').hide();
                $('#chat_box_view').removeClass('d-none');
                $('#messages-wrapper').html(
                    '<div class="text-center py-5"><div class="spinner-border" role="status"></div></div>'
                );

                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function(res) {
                        const wrapper = $('#messages-wrapper');
                        wrapper.html('');

                        const messages = res.data.messages;
                        const user = res.data.user;

                        $('#chat-id').val(chatId);

                        if (messages.length === 0) {
                            wrapper.html(
                                '<div class="text-center text-muted py-5">No messages yet. Start the conversation!</div>'
                            );
                        } else {
                            $.each(messages, function(index, message) {
                                appendMessageToUI(message, user);
                            });
                        }

                        $chatElement.find('#unread_message').text('');

                        setTimeout(() => scrollToBottom(false), 100);

                        $('#message-input').prop('disabled', false).focus();
                    },
                    error: function(xhr) {
                        const errorMsg = xhr.responseJSON?.message || 'Error loading messages';
                        $('#messages-wrapper').html(`
                    <div class="alert alert-danger m-3" role="alert">
                        ${errorMsg}
                    </div>
                `);
                        console.error('Error fetching messages:', errorMsg);
                    }
                });
            });

            function appendMessageToUI(message, user) {
                const wrapper = $('#messages-wrapper');
                let contentHtml = '';

                switch (message.type) {
                    case 'text':
                        contentHtml =
                            `<div class="p-2 text-bg-light rounded-1 fs-3">${escapeHtml(message.content)}</div>`;
                        break;

                    case 'image':
                        contentHtml = `
                    <div class="rounded-2 overflow-hidden">
                        <a href="${message.content}" target="_blank">
                            <img src="${message.content}" class="w-100" alt="image" style="max-width: 300px;" />
                        </a>
                    </div>
                `;
                        break;

                    case 'video':
                        contentHtml = `
                    <div class="rounded-2 overflow-hidden">
                        <video controls class="w-100" style="max-width: 400px;">
                            <source src="${message.content}" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                    </div>
                `;
                        break;

                    case 'audio':
                        contentHtml = `
                    <div class="overflow-hidden">
                        <audio controls>
                            <source src="${message.content}" type="audio/mpeg">
                            Your browser does not support the audio element.
                        </audio>
                    </div>
                `;
                        break;

                    default:
                        contentHtml =
                            `<div class="p-2 text-bg-light rounded-1 fs-3">${escapeHtml(message.content)}</div>`;
                }

                let bubble = '';
                const formattedTime = formatDate(message.created_at);

                if (message.sender_type === 'user') {
                    bubble = `
                <div class="hstack gap-3 align-items-start mb-7 justify-content-start">
                    <img src="${user.image}" width="40" height="40" class="rounded-circle" alt="${user.name}" />
                    <div>
                        <h6 class="fs-2 text-muted">${formattedTime}</h6>
                        ${contentHtml}
                    </div>
                </div>
            `;
                } else if (message.sender_type === 'doctor') {
                    bubble = `
                <div class="hstack gap-3 align-items-start mb-7 justify-content-end">
                    <div class="text-end">
                        <h6 class="fs-2 text-muted">${formattedTime}</h6>
                        ${contentHtml}
                    </div>
                </div>
            `;
                }

                wrapper.append(bubble);
            }

            function escapeHtml(text) {
                const map = {
                    '&': '&amp;',
                    '<': '&lt;',
                    '>': '&gt;',
                    '"': '&quot;',
                    "'": '&#039;'
                };
                return text.replace(/[&<>"']/g, m => map[m]);
            }

            /* SEND MESSAGE */
            $('#message-input').on('input', function() {
                if ($(this).val().trim() !== '') {
                    $('#message-type').val('text');
                }
            });

            $('#image-btn').on('click', function(e) {
                e.preventDefault();
                $('#message-image').trigger('click');
            });

            $('#message-image').on('click', function(e) {
                e.stopPropagation();
            });

            $('#message-image').on('change', function() {
                if (this.files.length > 0) {
                    $('#message-type').val('image');
                    $('#message-input').val('');
                    showFilePreview(this.files[0], 'image');
                }
            });

            $('#audio-btn').on('click', function(e) {
                e.preventDefault();
                $('#message-audio').trigger('click');
            });

            $('#message-audio').on('click', function(e) {
                e.stopPropagation();
            });

            $('#message-audio').on('change', function() {
                if (this.files.length > 0) {
                    $('#message-type').val('audio');
                    $('#message-input').val('');
                    showFilePreview(this.files[0], 'audio');
                }
            });

            $('#video-btn').on('click', function(e) {
                e.preventDefault();
                $('#message-video').trigger('click');
            });

            $('#message-video').on('click', function(e) {
                e.stopPropagation();
            });

            $('#message-video').on('change', function() {
                if (this.files.length > 0) {
                    $('#message-type').val('video');
                    $('#message-input').val('');
                    showFilePreview(this.files[0], 'video');
                }
            });

            function showFilePreview(file, type) {
                const previewHTML = `
            <div class="alert alert-info alert-dismissible fade show" id="file-preview">
                <strong>Selected ${type}:</strong> ${file.name} (${formatFileSize(file.size)})
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `;
                $('#file-preview').remove();
                $('#message-form').prepend(previewHTML);
            }

            function formatFileSize(bytes) {
                if (bytes === 0) return '0 Bytes';
                const k = 1024;
                const sizes = ['Bytes', 'KB', 'MB', 'GB'];
                const i = Math.floor(Math.log(bytes) / Math.log(k));
                return Math.round(bytes / Math.pow(k, i) * 100) / 100 + ' ' + sizes[i];
            }

            $('#message-form').on('submit', function(e) {
                e.preventDefault();

                if (!currentChatId) {
                    alert('Please select a chat first');
                    return;
                }

                const formData = new FormData();
                const type = $('#message-type').val();
                const chatId = $('#chat-id').val();

                formData.append('type', type);
                formData.append('chat_id', chatId);

                if (type === 'text') {
                    const textContent = $('#message-input').val().trim();
                    if (!textContent) {
                        alert('Please enter a message');
                        return;
                    }
                    formData.append('content', textContent);
                } else if (type === 'image') {
                    const imageFile = $('#message-image')[0].files[0];
                    if (!imageFile) {
                        alert('Please select an image');
                        return;
                    }
                    formData.append('content', imageFile);
                } else if (type === 'audio') {
                    const audioFile = $('#message-audio')[0].files[0];
                    if (!audioFile) {
                        alert('Please select an audio file');
                        return;
                    }
                    formData.append('content', audioFile);
                } else if (type === 'video') {
                    const videoFile = $('#message-video')[0].files[0];
                    if (!videoFile) {
                        alert('Please select a video file');
                        return;
                    }
                    formData.append('content', videoFile);
                }

                const $submitBtn = $('#message-form button[type="submit"]');
                $submitBtn.prop('disabled', true);

                showTypingIndicator();

                const url = `/doctor/chat/${chatId}/message`;

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(res) {
                        hideTypingIndicator();

                        if (res.success) {
                            const userData = {
                                image: '/default-avatar.png'
                            };

                            appendMessageToUI(res.data, userData);

                            resetForm();

                            if (isAtBottom) {
                                scrollToBottom();
                            }

                            $('#message-input').focus();
                        }
                    },
                    error: function(xhr) {
                        hideTypingIndicator();

                        let errorMsg = 'Error sending message';
                        if (xhr.responseJSON?.errors) {
                            errorMsg = Object.values(xhr.responseJSON.errors).flat().join('\n');
                        } else if (xhr.responseJSON?.message) {
                            errorMsg = xhr.responseJSON.message;
                        }

                        alert(errorMsg);
                        console.error('Send message error:', xhr.responseText);
                    },
                    complete: function() {
                        $submitBtn.prop('disabled', false);
                    }
                });
            });

            function resetForm() {
                $('#message-input').val('');
                $('#message-image').val('');
                $('#message-audio').val('');
                $('#message-video').val('');
                $('#message-type').val('text');
                $('#file-preview').remove();
            }

            /* FAVORITE CHAT */
            $(document).on('click', '.favorite-chat-btn', function(e) {
                e.preventDefault();
                e.stopPropagation();

                const $btn = $(this);
                const chatId = $btn.data('chat-id');
                const isFavorite = $btn.hasClass('is-favorite');

                const url = isFavorite ? '/doctor/chat/favorite/remove' : '/doctor/chat/favorite/add';

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: {
                        chat_id: chatId
                    },
                    success: function(res) {
                        if (res.message) {
                            $btn.toggleClass('is-favorite');

                            const $icon = $btn.find('i');
                            if ($btn.hasClass('is-favorite')) {
                                $icon.removeClass('ti-star').addClass('ti-star-filled');
                                $btn.attr('title', 'Remove from favorites');
                            } else {
                                $icon.removeClass('ti-star-filled').addClass('ti-star');
                                $btn.attr('title', 'Add to favorites');
                            }

                            showToast(res.message, 'success');
                        }
                    },
                    error: function(xhr) {
                        const errorMsg = xhr.responseJSON?.message ||
                            'Error updating favorites';
                        showToast(errorMsg, 'error');
                    }
                });
            });

            function showToast(message, type = 'info') {
                const toast = $(`
            <div class="toast-notification ${type}" style="position: fixed; top: 20px; right: 20px; z-index: 9999;">
                <div class="alert alert-${type === 'error' ? 'danger' : 'success'} alert-dismissible fade show">
                    ${message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            </div>
        `);

                $('body').append(toast);

                setTimeout(() => {
                    toast.fadeOut(300, function() {
                        $(this).remove();
                    });
                }, 3000);
            }

            /* SEARCH */
            $('#text-srh').on('keyup', function() {
                const searchTerm = $(this).val().toLowerCase();

                $('.click_chat').each(function() {
                    const chatName = $(this).find('.chat-title').text().toLowerCase();
                    const lastMessage = $(this).find('.text-truncate').text().toLowerCase();

                    if (chatName.includes(searchTerm) || lastMessage.includes(searchTerm)) {
                        $(this).parent().show();
                    } else {
                        $(this).parent().hide();
                    }
                });
            });

            /* KEYBOARD SHORTCUTS */
            $('#message-input').on('keydown', function(e) {
                if (e.ctrlKey && e.key === 'Enter') {
                    e.preventDefault();
                    $('#message-form').submit();
                }
            });

            $('#message-input').prop('disabled', true).attr('placeholder', 'Select a chat to start messaging');

            console.log('Chat system initialized successfully');
        });
    </script>
@endpush
