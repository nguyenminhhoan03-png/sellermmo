@php use App\Helpers\Helper; @endphp
@extends('admin.layouts.master')

@section('css')
<style>
    .chat-app {
        display: flex;
        height: calc(100vh - 150px);
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.05);
        overflow: hidden;
        border: 1px solid #ebedf2;
    }
    
    /* Left Sidebar: User List */
    .chat-sidebar {
        width: 350px;
        border-right: 1px solid #ebedf2;
        display: flex;
        flex-direction: column;
        background: #fdfdfd;
    }
    .chat-sidebar-header {
        padding: 20px;
        border-bottom: 1px solid #ebedf2;
    }
    .chat-search input {
        width: 100%;
        padding: 10px 15px;
        border-radius: 20px;
        border: 1px solid #e1e5eb;
        outline: none;
        background: #f4f6f9;
        transition: border 0.2s;
    }
    .chat-search input:focus {
        border-color: #1e88e5;
        background: #fff;
    }
    .chat-user-list {
        flex: 1;
        overflow-y: auto;
        list-style: none;
        padding: 0;
        margin: 0;
    }
    .chat-user-item {
        padding: 15px 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        border-bottom: 1px solid #f1f3f7;
        cursor: pointer;
        transition: background 0.2s;
        position: relative;
    }
    .chat-user-item:hover {
        background: #f4f6f9;
    }
    .chat-user-item.active {
        background: #eef5fb;
        border-right: 3px solid #1e88e5;
    }
    .user-avatar {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        background: #1e88e5;
        color: white;
        display: flex;
        justify-content: center;
        align-items: center;
        font-weight: bold;
        font-size: 18px;
        margin-right: 15px;
        position: relative;
    }
    .online-indicator {
        position: absolute;
        bottom: 2px;
        right: 2px;
        width: 12px;
        height: 12px;
        background: #28c76f;
        border: 2px solid #fff;
        border-radius: 50%;
    }
    .user-info {
        flex: 1;
        overflow: hidden;
        min-width: 0;
    }
    .user-name {
        font-weight: 600;
        color: #333;
        margin-bottom: 3px;
        font-size: 15px;
        white-space: nowrap;
        text-overflow: ellipsis;
        overflow: hidden;
    }
    .last-message {
        font-size: 13px;
        color: #888;
        white-space: nowrap;
        text-overflow: ellipsis;
        overflow: hidden;
    }
    .unread-badge {
        background: #ea5455;
        color: white;
        font-size: 11px;
        min-width: 18px;
        height: 18px;
        padding: 0 5px;
        border-radius: 999px;
        font-weight: bold;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        line-height: 1;
        flex-shrink: 0;
    }

    /* Right Main: Chat Area */
    .chat-main {
        flex: 1;
        display: flex;
        flex-direction: column;
        background: #fafafa;
    }
    .chat-main-header {
        padding: 15px 25px;
        border-bottom: 1px solid #ebedf2;
        display: flex;
        align-items: center;
        justify-content: space-between;
        background: #fff;
    }
    .chat-main-header .current-user {
        display: flex;
        align-items: center;
        gap: 15px;
    }
    .chat-actions button {
        background: none;
        border: none;
        color: #666;
        font-size: 18px;
        cursor: pointer;
        transition: color 0.2s;
    }
    .chat-actions button:hover {
        color: #1e88e5;
    }
    .chat-history {
        flex: 1;
        padding: 25px;
        overflow-y: auto;
        display: flex;
        flex-direction: column;
        gap: 15px;
        background: #f4f7f6;
    }
    .message {
        display: flex;
        flex-direction: column;
        max-width: 70%;
    }
    .message.received {
        align-self: flex-start;
    }
    .message.sent {
        align-self: flex-end;
    }
    .message-text {
        padding: 12px 18px;
        border-radius: 18px;
        font-size: 15px;
        line-height: 1.5;
        box-shadow: 0 2px 5px rgba(0,0,0,0.05);
    }
    .received .message-text {
        background: #fff;
        color: #333;
        border-bottom-left-radius: 4px;
        border: 1px solid #ebedf2;
    }
    .sent .message-text {
        background: #1e88e5;
        color: #fff;
        border-bottom-right-radius: 4px;
    }
    .message-time {
        font-size: 11px;
        color: #999;
        margin-top: 5px;
    }
    .sent .message-time {
        align-self: flex-end;
    }
    .chat-input-area {
        padding: 20px 25px;
        background: #fff;
        border-top: 1px solid #ebedf2;
    }
    .chat-input-group {
        display: flex;
        align-items: center;
        gap: 15px;
    }
    .chat-input-group textarea {
        flex: 1;
        padding: 12px 20px;
        border: 1px solid #ddd;
        border-radius: 24px;
        resize: none;
        height: 50px;
        outline: none;
        font-size: 15px;
        transition: border 0.2s;
    }
    .chat-input-group textarea:focus {
        border-color: #1e88e5;
    }
    .btn-send {
        background: #1e88e5;
        color: white;
        border: none;
        width: 50px;
        height: 50px;
        border-radius: 50%;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 20px;
        cursor: pointer;
        transition: transform 0.2s, background 0.2s;
        box-shadow: 0 4px 10px rgba(30,136,229,0.3);
    }
    .btn-send:hover {
        background: #1565c0;
        transform: scale(1.05);
    }
    .quick-replies {
        margin-bottom: 10px;
        display: flex;
        gap: 10px;
        overflow-x: auto;
    }
    .quick-reply-btn {
        background: #eef5fb;
        color: #1e88e5;
        border: 1px solid #d4ebfd;
        padding: 5px 12px;
        border-radius: 15px;
        font-size: 12px;
        cursor: pointer;
        white-space: nowrap;
        transition: background 0.2s;
    }
    .quick-reply-btn:hover {
        background: #1e88e5;
        color: white;
    }
</style>
@endsection

@section('content')
<section>
    <div class="mb-3 d-flex justify-content-between align-items-center">
        <h4><i class="bi bi-chat-dots-fill text-primary"></i> Quản Lý Chat Hỗ Trợ</h4>
        <button class="btn btn-outline-primary btn-sm"><i class="bi bi-gear"></i> Cài đặt Chat</button>
    </div>

    <div class="chat-app">
        <!-- Sidebar Danh sách người dùng -->
        <div class="chat-sidebar">
            <div class="chat-sidebar-header">
                <div class="chat-search">
                    <input type="text" placeholder="Tìm kiếm khách hàng...">
                </div>
            </div>
            
            <ul class="chat-user-list">
                @forelse ($conversations as $conv)
                @php
                    $name = $conv->user ? $conv->user->name : 'Khách vãng lai #'.$conv->id;
                    $avatarLetter = mb_substr($name, 0, 1);
                    $colors = ['#1e88e5', '#ea5455', '#ff9f43', '#28c76f', '#7367f0'];
                    $bgColor = $colors[$conv->id % count($colors)];
                    $isActive = isset($activeConversation) && $activeConversation->id === $conv->id;
                @endphp
                <li class="chat-user-item {{ $isActive ? 'active' : '' }}" onclick="window.location.href='?room={{ $conv->id }}'">
                    <div class="user-avatar" style="background:{{ $bgColor }}">
                        {{ mb_strtoupper($avatarLetter) }}
                        <span class="online-indicator"></span>
                    </div>
                    <div class="user-info">
                        <div class="user-name">{{ $name }}</div>
                        <div class="last-message">{{ $conv->last_message ?: 'Chưa có tin nhắn' }}</div>
                    </div>
                    @if($conv->unread_admin > 0)
                    <div class="unread-badge">{{ $conv->unread_admin }}</div>
                    @endif
                </li>
                @empty
                <li class="p-4 text-center text-muted">Chưa có ai nhắn tin.</li>
                @endforelse
            </ul>
        </div>

        <!-- Vùng Chat Chính -->
        <div class="chat-main">
            @if(isset($activeConversation))
            @php
                $activeName = $activeConversation->user ? $activeConversation->user->name : 'Khách vãng lai #'.$activeConversation->id;
                $activeLetter = mb_substr($activeName, 0, 1);
            @endphp
            <!-- Header chat -->
            <div class="chat-main-header">
                @php
                    $isAiMode = !\Illuminate\Support\Facades\Cache::get("chat_conv_ai_disabled_{$activeConversation->id}", false);
                @endphp
                <div class="current-user">
                    <div class="user-avatar" style="background: #1e88e5">{{ mb_strtoupper($activeLetter) }}</div>
                    <div>
                        <div class="user-name mb-0 d-flex align-items-center">
                            {{ $activeName }}
                            <span id="aiStatusBadge" class="badge {{ $isAiMode ? 'bg-info' : 'bg-warning' }} ms-2" style="font-size: 11px; font-weight: 500;">
                                <i class="bi {{ $isAiMode ? 'bi-robot' : 'bi-person-fill' }}"></i> {{ $isAiMode ? 'AI Trả lời' : 'Admin Trực' }}
                            </span>
                        </div>
                        <small class="text-success" style="font-size: 12px;"><i class="bi bi-circle-fill" style="font-size: 8px;"></i> Cập nhật gần nhất: {{ $activeConversation->last_message_at ? $activeConversation->last_message_at->diffForHumans() : 'Mới tạo' }}</small>
                    </div>
                </div>
                <div class="chat-actions d-flex align-items-center">
                    <button id="toggleAiBtn" onclick="toggleAiMode({{ $activeConversation->id }})" title="{{ $isAiMode ? 'Tắt AI tự động' : 'Bật AI tự động' }}" class="btn btn-sm {{ $isAiMode ? 'btn-outline-warning' : 'btn-outline-info' }} me-2 py-1 px-2 d-flex align-items-center gap-1" style="font-size: 12px;">
                        <i class="bi bi-robot"></i> <span id="toggleAiText">{{ $isAiMode ? 'Tắt AI' : 'Bật AI' }}</span>
                    </button>
                    <button title="Lịch sử giao dịch"><i class="bi bi-receipt"></i></button>
                    <button title="Xóa hội thoại"><i class="bi bi-trash"></i></button>
                    <button title="Đánh dấu đã xong"><i class="bi bi-check2-all"></i></button>
                </div>
            </div>

            <!-- Nội dung chat -->
            <div class="chat-history" id="adminChatBody">
                <div class="text-center w-100 my-2">
                    <span class="badge bg-light text-muted">Tin nhắn gần đây</span>
                </div>
                
                @foreach ($messages as $index => $msg)
                <div class="message {{ $msg->sender_type == 'admin' ? 'sent' : 'received' }}">
                    <div class="message-text">{{ $msg->content }}</div>
                    <div class="message-time">{{ $msg->created_at->format('h:i A') }}</div>
                </div>
                {{-- Nếu là tin nhắn cuối cùng của Admin và đã đọc thì hiện Đã xem --}}
                @if($msg->sender_type == 'admin' && $index == count($messages) - 1 && $msg->is_read)
                    <div class="seen-status" style="text-align:right; font-size:11px; color:#999; margin-top:-10px; margin-right:10px;">Đã xem</div>
                @endif
                @endforeach
            </div>

            <!-- Khung nhập text -->
            <div class="chat-input-area">
                <div class="quick-replies">
                    <button class="quick-reply-btn" onclick="$('#adminChatInput').val('Xin chào!');">Xin chào!</button>
                    <button class="quick-reply-btn" onclick="$('#adminChatInput').val('Bạn đọc kĩ nội dung dịch vụ nhé.');">Bạn đọc kĩ nội dung dịch vụ nhé.</button>
                    <button class="quick-reply-btn" onclick="$('#adminChatInput').val('Cảm ơn bạn đã sử dụng dịch vụ.');">Cảm ơn bạn đã sử dụng dịch vụ.</button>
                </div>
                <div class="chat-input-group">
                    <button class="btn btn-light rounded-circle" style="width:45px; height:45px;"><i class="bi bi-paperclip fs-5"></i></button>
                    <textarea id="adminChatInput" placeholder="Nhắn tin với {{ $activeName }}..."></textarea>
                    <button class="btn-send"><i class="bi bi-send-fill fs-5"></i></button>
                </div>
            </div>
            @else
            <!-- Màn hình chờ khi trống -->
            <div class="d-flex flex-column h-100 justify-content-center align-items-center">
                <i class="bi bi-chat-heart text-muted" style="font-size: 5rem;"></i>
                <h5 class="text-muted mt-3">Chọn một cuộc trò chuyện để bắt đầu</h5>
            </div>
            @endif
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
<script>
    var activeRoomId = {{ isset($activeConversation) ? $activeConversation->id : 'null' }};

    // Khởi tạo Pusher
    var pusher = new Pusher('{{ config('app.app_pusher') }}', {
        cluster: 'ap1',
    });
    
    var channel = pusher.subscribe('admin-chat-channel');
    
    channel.bind('new-message', function(data) {
        if (data.message.sender_type === 'user') {
            let msgHtml = `
                <div class="message received">
                    <div class="message-text">${data.message.content}</div>
                    <div class="message-time">Vừa xong</div>
                </div>`;
            $('#adminChatBody').append(msgHtml);
            scrollToBottom();
            markAdminRead();
        }
    });

    // Nghe event báo đã xem từ khách hàng
    channel.bind('conversation-read', function(data) {
        if (data.conversationId == activeRoomId && data.readerType === 'user') {
            if (!$('.seen-status').length) {
                $('#adminChatBody').append('<div class="seen-status" style="text-align:right; font-size:11px; color:#999; margin-top:-10px; margin-right:10px;">Đã xem</div>');
                scrollToBottom();
            }
        }
    });

    // Hàm Send AJAX
    function sendAdminMessage(msgText) {
        if (!msgText) return;

        if (!activeRoomId) return alert('Chưa chọn khách hàng!');
        
        // Xóa indicator Đã xem cũ
        $('.seen-status').remove();

        let dataPayload = {
            _token: '{{ csrf_token() }}',
            message: msgText,
            conversation_id: activeRoomId
        };

        // Append UI Ảo trước
        let myMsgHtml = `
            <div class="message sent">
                <div class="message-text">${msgText}</div>
                <div class="message-time">Đang gửi...</div>
            </div>`;
        let lastMsg = $('#adminChatBody').append(myMsgHtml).children().last();
        scrollToBottom();
        $('#adminChatInput').val('');

        $.ajax({
            url: '{{ route("admin.chat.send") }}',
            type: 'POST',
            data: dataPayload,
            success: function(res) {
                lastMsg.find('.message-time').text(res.time);
            },
            error: function(err) {
                lastMsg.find('.message-time').text('Lỗi gửi!').css('color', 'red');
            }
        });
    }

    // Tự động mark as read khi có tin nhắn mới mà mình đang ở trong room
    function markAdminRead() {
        if (!activeRoomId) return;
        $.post('{{ route("admin.chat.mark-as-read") }}', {
            _token: '{{ csrf_token() }}',
            conversation_id: activeRoomId,
            reader_type: 'admin'
        });
    }

    // Sự kiện Click Gửi
    $('.btn-send').click(function() {
        let msg = $('#adminChatInput').val().trim();
        sendAdminMessage(msg);
    });

    // Bấm Enter gửi (Tránh Alt+Enter/Shift+Enter)
    $('#adminChatInput').on('keypress', function (e) {
        if(e.which === 13 && !e.shiftKey) {
            e.preventDefault();
            $('.btn-send').click();
        }
    });

    // Cuộn xuống dòng mới nhất
    function scrollToBottom() {
        let box = document.getElementById('adminChatBody');
        if (box) {
            box.scrollTop = box.scrollHeight;
        }
    }

    function toggleAiMode(convId) {
        $.ajax({
            url: '{{ route("admin.chat.toggle-ai") }}',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                conversation_id: convId
            },
            success: function(res) {
                if (res.status === 'success') {
                    const badge = $('#aiStatusBadge');
                    const btn = $('#toggleAiBtn');
                    const btnText = $('#toggleAiText');
                    
                    if (res.is_ai_mode) {
                        badge.removeClass('bg-warning').addClass('bg-info').html('<i class="bi bi-robot"></i> AI Trả lời');
                        btn.removeClass('btn-outline-info').addClass('btn-outline-warning').attr('title', 'Tắt AI tự động');
                        btnText.text('Tắt AI');
                    } else {
                        badge.removeClass('bg-info').addClass('bg-warning').html('<i class="bi bi-person-fill"></i> Admin Trực');
                        btn.removeClass('btn-outline-warning').addClass('btn-outline-info').attr('title', 'Bật AI tự động');
                        btnText.text('Bật AI');
                    }
                    
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            title: 'Thành công',
                            text: res.message,
                            icon: 'success',
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 2000
                        });
                    }
                }
            }
        });
    }
</script>
@endsection
