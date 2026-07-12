@extends('seller.layouts.master')
@section('title', 'Inbox - Chat với khách hàng')

@section('css')
<style>
.chat-app {
    display: flex;
    height: calc(100vh - 160px);
    background: #fff;
    border-radius: 14px;
    box-shadow: 0 4px 24px rgba(0,0,0,0.07);
    overflow: hidden;
    border: 1px solid #ebedf2;
}
.chat-sidebar {
    width: 320px;
    border-right: 1px solid #ebedf2;
    display: flex;
    flex-direction: column;
    background: #fdfdfd;
}
.chat-sidebar-header {
    padding: 16px 18px;
    border-bottom: 1px solid #ebedf2;
    font-weight: 700;
    font-size: 15px;
    display: flex;
    align-items: center;
    gap: 8px;
}
.chat-user-list { flex:1; overflow-y:auto; list-style:none; padding:0; margin:0; }
.chat-user-item {
    padding: 13px 18px;
    display: flex;
    align-items: center;
    gap: 12px;
    border-bottom: 1px solid #f1f3f7;
    cursor: pointer;
    transition: background 0.15s;
}
.chat-user-item:hover { background: #f4f6f9; }
.chat-user-item.active { background: #eef5fb; border-right: 3px solid #1e88e5; }
.user-avatar {
    width: 42px; height: 42px; border-radius: 50%;
    color: white; display: flex; justify-content: center;
    align-items: center; font-weight: bold; font-size: 17px;
    flex-shrink: 0;
}
.user-info { flex:1; overflow:hidden; min-width:0; }
.user-name { font-weight:600; color:#333; font-size:14px; white-space:nowrap; text-overflow:ellipsis; overflow:hidden; }
.last-msg { font-size:12px; color:#999; white-space:nowrap; text-overflow:ellipsis; overflow:hidden; }
.order-ref-tag { font-size:10px; background:#eef5fb; color:#1e88e5; border-radius:4px; padding:1px 5px; display:inline-block; margin-top:2px; }
.unread-badge {
    background: #ea5455; color: white; font-size: 11px;
    min-width: 18px; height: 18px; padding: 0 5px;
    border-radius: 999px; font-weight: bold;
    display: inline-flex; align-items: center; justify-content: center;
    flex-shrink: 0;
}

/* Chat main */
.chat-main { flex:1; display:flex; flex-direction:column; background:#fafafa; }
.chat-main-header {
    padding: 14px 22px; border-bottom: 1px solid #ebedf2;
    display: flex; align-items: center; justify-content: space-between;
    background: #fff;
}
.chat-history {
    flex:1; padding:20px; overflow-y:auto;
    display:flex; flex-direction:column; gap:12px; background:#f4f7f6;
}
.message { display:flex; flex-direction:column; max-width:70%; }
.message.received { align-self:flex-start; }
.message.sent { align-self:flex-end; }
.message-text {
    padding: 10px 16px; border-radius: 18px;
    font-size: 14px; line-height: 1.5;
    box-shadow: 0 2px 5px rgba(0,0,0,0.05);
}
.received .message-text { background:#fff; color:#333; border-bottom-left-radius:4px; border:1px solid #ebedf2; }
.sent .message-text { background:#1e88e5; color:#fff; border-bottom-right-radius:4px; }
.message-time { font-size:11px; color:#aaa; margin-top:4px; }
.sent .message-time { align-self:flex-end; }

.chat-input-area { padding:16px 22px; background:#fff; border-top:1px solid #ebedf2; }
.chat-input-group { display:flex; align-items:center; gap:12px; }
.chat-input-group textarea {
    flex:1; padding:10px 18px; border:1px solid #ddd;
    border-radius:22px; resize:none; height:46px; outline:none;
    font-size:14px; transition:border 0.2s;
}
.chat-input-group textarea:focus { border-color:#1e88e5; }
.btn-send {
    background:#1e88e5; color:white; border:none; width:46px; height:46px;
    border-radius:50%; display:flex; justify-content:center; align-items:center;
    cursor:pointer; transition:background 0.2s;
    box-shadow: 0 3px 10px rgba(30,136,229,0.3);
}
.btn-send:hover { background:#1565c0; }
</style>
@endsection

@section('content')
<div class="d-flex align-items-center justify-content-between mb-3">
    <h4 class="mb-0 fw-bold"><i class="bi bi-inbox text-primary me-2"></i>Inbox Khách Hàng</h4>
    @if($totalUnread > 0)
        <span class="badge bg-danger">{{ $totalUnread }} tin chưa đọc</span>
    @endif
</div>

<div class="chat-app">
    {{-- Sidebar --}}
    <div class="chat-sidebar">
        <div class="chat-sidebar-header">
            <i class="bi bi-people text-primary"></i> Khách hàng ({{ $conversations->count() }})
        </div>
        <ul class="chat-user-list">
            @forelse($conversations as $conv)
            @php
                $buyer    = $conv->user;
                $bname    = $buyer?->name ?? 'Khách #' . $conv->id;
                $bletter  = mb_strtoupper(mb_substr($bname, 0, 1));
                $colors   = ['#1e88e5','#ea5455','#ff9f43','#28c76f','#7367f0'];
                $bgColor  = $colors[$conv->id % count($colors)];
                $isActive = isset($activeConversation) && $activeConversation->id === $conv->id;
            @endphp
            <li class="chat-user-item {{ $isActive ? 'active' : '' }}"
                onclick="window.location.href='?room={{ $conv->id }}'">
                <div class="user-avatar" style="background:{{ $bgColor }}">{{ $bletter }}</div>
                <div class="user-info">
                    <div class="user-name">{{ $bname }}</div>
                    <div class="last-msg">{{ $conv->last_message ?: 'Chưa có tin nhắn' }}</div>
                    @if($conv->order_ref)
                        <span class="order-ref-tag">🧾 {{ $conv->order_ref }}</span>
                    @endif
                </div>
                @if($conv->unread_seller > 0)
                    <div class="unread-badge">{{ $conv->unread_seller }}</div>
                @endif
            </li>
            @empty
            <li class="p-4 text-center text-muted fs-6">
                <i class="bi bi-inbox fs-1 d-block mb-2"></i>Chưa có khách hàng nào nhắn tin.
            </li>
            @endforelse
        </ul>
    </div>

    {{-- Main Chat --}}
    <div class="chat-main">
        @if(isset($activeConversation) && $activeConversation)
        @php
            $buyer   = $activeConversation->user;
            $bname   = $buyer?->name ?? 'Khách #' . $activeConversation->id;
            $bletter = mb_strtoupper(mb_substr($bname, 0, 1));
        @endphp
        <div class="chat-main-header">
            <div class="d-flex align-items-center gap-3">
                <div class="user-avatar" style="background:#1e88e5;width:38px;height:38px;font-size:15px;">{{ $bletter }}</div>
                <div>
                    <div class="fw-bold">{{ $bname }}</div>
                    @if($activeConversation->order_ref)
                        <small class="text-muted">Đơn: <code>{{ $activeConversation->order_ref }}</code></small>
                    @endif
                </div>
            </div>
            <small class="text-muted">
                {{ $activeConversation->last_message_at?->diffForHumans() ?? 'Mới tạo' }}
            </small>
        </div>

        <div class="chat-history" id="sellerChatBody">
            @foreach($messages as $msg)
            <div class="message {{ $msg->sender_type === 'seller' ? 'sent' : 'received' }}">
                <div class="message-text">{{ $msg->content }}</div>
                <div class="message-time">{{ $msg->created_at->format('H:i d/m') }}</div>
            </div>
            @endforeach
        </div>

        <div class="chat-input-area">
            <div class="chat-input-group">
                <textarea id="sellerChatInput"
                          placeholder="Trả lời {{ $bname }}..."
                          onkeypress="handleEnter(event)"></textarea>
                <button class="btn-send" onclick="sendReply()">
                    <i class="bi bi-send-fill"></i>
                </button>
            </div>
        </div>

        @else
        <div class="d-flex flex-column h-100 justify-content-center align-items-center text-muted">
            <i class="bi bi-chat-heart" style="font-size:4rem;"></i>
            <h5 class="mt-3">Chọn một cuộc trò chuyện bên trái</h5>
        </div>
        @endif
    </div>
</div>
@endsection

@section('scripts')
<script>
const CONV_ID   = {{ isset($activeConversation) && $activeConversation ? $activeConversation->id : 'null' }};
const CSRF      = '{{ csrf_token() }}';

function scrollBottom() {
    const el = document.getElementById('sellerChatBody');
    if (el) el.scrollTop = el.scrollHeight;
}
scrollBottom();

function sendReply() {
    const inp = document.getElementById('sellerChatInput');
    const msg = inp.value.trim();
    if (!msg || !CONV_ID) return;

    // Optimistic UI
    const body = document.getElementById('sellerChatBody');
    const div  = document.createElement('div');
    div.className = 'message sent';
    div.innerHTML = `<div class="message-text">${msg}</div><div class="message-time">Đang gửi...</div>`;
    body.appendChild(div);
    scrollBottom();
    inp.value = '';

    fetch('{{ route("seller.chat.reply") }}', {
        method : 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF },
        body   : JSON.stringify({ conversation_id: CONV_ID, message: msg })
    }).then(r => r.json()).then(d => {
        if (d.status === 'success') {
            div.querySelector('.message-time').textContent = d.time;
        } else {
            div.querySelector('.message-time').textContent = 'Lỗi!';
            div.querySelector('.message-time').style.color = 'red';
        }
    });
}

function handleEnter(e) {
    if (e.key === 'Enter' && !e.shiftKey) { e.preventDefault(); sendReply(); }
}

// Polling tin nhắn mới từ khách mỗi 5 giây
@if(isset($activeConversation) && $activeConversation)
setInterval(function() {
    fetch('{{ route("seller.chat.conversation", ["conversation_id" => $activeConversation->id]) }}')
        .then(r => r.json())
        .then(data => {
            const body = document.getElementById('sellerChatBody');
            const currentCount = body.querySelectorAll('.message').length;
            if (data.messages && data.messages.length > currentCount) {
                // Render tin nhắn mới
                const extras = data.messages.slice(currentCount);
                extras.forEach(m => {
                    const div = document.createElement('div');
                    div.className = 'message ' + (m.sender_type === 'seller' ? 'sent' : 'received');
                    div.innerHTML = `<div class="message-text">${m.content}</div>
                        <div class="message-time">${new Date(m.created_at).toLocaleTimeString('vi-VN',{hour:'2-digit',minute:'2-digit'})}</div>`;
                    body.appendChild(div);
                });
                scrollBottom();
            }
        });
}, 5000);
@endif
</script>
@endsection
