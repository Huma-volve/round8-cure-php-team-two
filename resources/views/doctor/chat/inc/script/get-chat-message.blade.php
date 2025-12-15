@push('js')
    <script>
        $(document).on('click', '.click_chat', function(e) {
            e.preventDefault();

            var chatId = $(this).data('chat-id');
            var url = "{{ route('doctor.chat.messages.show', ':id') }}".replace(':id', chatId);

            $.ajax({
                url: url,
                type: 'GET',
                success: function(res) {
                    // اظهار الشات
                    $('#chat_image_box').hide();
                    $('#chat_box_view').removeClass('d-none');

                    var wrapper = $('#messages-wrapper');
                    wrapper.html(''); // تفريغ الرسائل القديمة

                    var messages = res.data.messages;

                    $.each(messages, function(index, message) {
                        var contentHtml = '';

                        // تحديد نوع الرسالة
                        switch (message.type) {
                            case 'text':
                                contentHtml = '<div class="p-2 text-bg-light rounded-1 fs-3">' +
                                    message.content +
                                    '</div>';
                                break;

                            case 'image':
                                contentHtml = '<div class="rounded-2 overflow-hidden">' +
                                    '<img src="' + message.content +
                                    '" class="w-100" alt="image" />' +
                                    '</div>';
                                break;

                            case 'video':
                                contentHtml = '<div class="rounded-2 overflow-hidden">' +
                                    '<video controls class="w-100">' +
                                    '<source src="' + message.content + '" type="video/mp4">' +
                                    'Your browser does not support the video tag.' +
                                    '</video>' +
                                    '</div>';
                                break;

                            case 'audio':
                                contentHtml = '<div class="overflow-hidden">' +
                                    '<audio controls>' +
                                    '<source src="' + message.content + '" type="audio/mpeg">' +
                                    'Your browser does not support the audio element.' +
                                    '</audio>' +
                                    '</div>';
                                break;

                            default:
                                contentHtml = '<div class="p-2 text-bg-light rounded-1 fs-3">' +
                                    message.content + '</div>';
                        }

                        // تمييز User و Doctor
                        var bubble = '';
                        if (message.sender_type === 'user') {
                            bubble =
                                '<div class="hstack gap-3 align-items-start mb-7 justify-content-start">' +
                                '<img src="' + res.data.user.image +
                                '" width="40" height="40" class="rounded-circle" />' +
                                '<div>' +
                                '<h6 class="fs-2 text-muted">' + formatDate(message
                                    .created_at) + '</h6>' +
                                contentHtml +
                                '</div>' +
                                '</div>';
                        } else if (message.sender_type === 'doctor') {
                            bubble =
                                '<div class="hstack gap-3 align-items-start mb-7 justify-content-end">' +
                                '<div class="text-end">' +
                                '<h6 class="fs-2 text-muted">' + formatDate(message
                                    .created_at) + '</h6>' +
                                contentHtml +
                                '</div>' +
                                '</div>';
                        }

                        wrapper.append(bubble);
                    });

                    scrollToBottom();
                },
                error: function(xhr) {
                    console.log(xhr.responseJSON ? xhr.responseJSON.message :
                        'Error fetching messages');
                }
            });
        });

        // scroll تلقائي
        function scrollToBottom() {
            var box = $('.chat-box-inner')[0];
            if (box) box.scrollTop = box.scrollHeight;
        }

        // format التاريخ: اليوم-الشهر الساعة:الدقيقة
        function formatDate(date) {
            var d = new Date(date);
            var day = ('0' + d.getDate()).slice(-2);
            var month = ('0' + (d.getMonth() + 1)).slice(-2);
            var hours = ('0' + d.getHours()).slice(-2);
            var minutes = ('0' + d.getMinutes()).slice(-2);
            return day + '-' + month + ' ' + hours + ':' + minutes;
        }
    </script>
@endpush


{{-- <div class="hstack gap-3 align-items-start mb-7 justify-content-start">
                                        <img src="../assets/images/profile/user-8.jpg" alt="user8" width="40"
                                            height="40" class="rounded-circle" />
                                        <div>
                                            <h6 class="fs-2 text-muted">
                                                Andrew, 2 hours ago
                                            </h6>
                                            <div class="rounded-2 overflow-hidden">
                                                <img src="../assets/images/products/product-1.jpg" alt="modernize-img"
                                                    class="w-100" />
                                            </div>
                                        </div>
                                    </div> --}}
