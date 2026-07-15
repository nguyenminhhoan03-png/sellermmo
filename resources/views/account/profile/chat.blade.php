@php use App\Helpers\Helper; @endphp 
@extends('layouts.app') 
@section('title', $pageTitle) 
@section('content')
<style>
.chat-app {
    display: flex;
    height: calc(100vh - 200px);
    background: #fff;
    border-radius: 14px;
    box-shadow: 0 4px 24px rgba(0,0,0,0.07);
    overflow: hidden;
    border: 1px solid #ebedf2;
    margin-top: 20px;
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
    word-break: break-word;
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
<div class="toolbar d-flex flex-stack py-3 py-lg-5" id="kt_toolbar">
    <!--begin::Container-->
    <div id="kt_toolbar_container" class="container-xxl d-flex flex-stack flex-wrap">
        <!--begin::Page title-->
        <div class="page-title d-flex flex-column me-3">
            <h1 class="d-flex text-gray-900 fw-bold my-1 fs-3">Thông tin tài khoản</h1>
            <ul class="breadcrumb breadcrumb-dot fw-semibold text-gray-600 fs-7 my-1">
                <li class="breadcrumb-item text-gray-600">
                    <a href="/" class="text-gray-600 text-hover-primary">Home</a>
                </li>
                <li class="breadcrumb-item text-gray-600">User Profile</li>
                <li class="breadcrumb-item text-gray-500">{{ auth()->user()->username ?? 'Chưa đăng nhập' }}</li>
            </ul>
        </div>
        <!--end::Page title-->
    </div>
</div>
<div id="kt_content_container" class="d-flex flex-column-fluid align-items-start container-xxl">
    <!--begin::Post-->
    <div class="content flex-row-fluid" id="kt_content">
        <!--begin::Navbar-->
        <div class="card mb-5 mb-xxl-8">
            <div class="card-body pt-9 pb-0">
                <!--begin::Details-->
                <div class="d-flex flex-wrap flex-sm-nowrap">
                    <!--begin: Pic-->
                    <div class="me-7 mb-4">
                        <div class="symbol symbol-100px symbol-lg-160px symbol-fixed position-relative">
                            <img src="{{ asset('assets/media/avatars/user-placeholder.svg') }}" alt="image" />
                            <div class="position-absolute translate-middle bottom-0 start-100 mb-6 bg-success rounded-circle border border-4 border-body h-20px w-20px"></div>
                        </div>
                    </div>
                    <!--end::Pic-->
                    <!--begin::Info-->
                    <div class="flex-grow-1">
                        <!--begin::Title-->
                        <div class="d-flex justify-content-between align-items-start flex-wrap mb-2">
                            <!--begin::User-->
                            <div class="d-flex flex-column">
                                <!--begin::Name-->
                                <div class="d-flex align-items-center mb-2">
                                    <a href="#" class="text-gray-900 text-hover-primary fs-2 fw-bold me-1">{{ auth()->user()->username ?? 'Chưa đăng nhập' }}</a>
                                    <a href="#"><i class="ki-duotone ki-verify fs-1 text-primary"><span class="path1"></span><span class="path2"></span></i></a>
                                </div>
                                <!--end::Name-->
                                <!--begin::Info-->
                                <div class="d-flex flex-wrap fw-semibold fs-6 mb-4 pe-2">
                                    @if ($user->level == 1)
                                        <a href="#" class="d-flex align-items-center text-gray-500 text-hover-primary me-5 mb-2">
                                            <i class="ki-duotone ki-profile-circle fs-4 me-1"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>Admin
                                        </a>
                                    @elseif ($user->level == 2)                                  
                                        <a href="#" class="d-flex align-items-center text-gray-500 text-hover-primary me-5 mb-2">
                                            <i class="ki-duotone ki-profile-circle fs-4 me-1"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>Người Bán
                                        </a>
                                    @else 
                                        <a href="#" class="d-flex align-items-center text-gray-500 text-hover-primary me-5 mb-2">
                                            <i class="ki-duotone ki-profile-circle fs-4 me-1"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>Thành Viên
                                        </a>
                                    @endif
                                    <a href="#" class="d-flex align-items-center text-gray-500 text-hover-primary me-5 mb-2">
                                        <i class="ki-duotone ki-geolocation fs-4 me-1"><span class="path1"></span><span class="path2"></span></i>Việt Nam
                                    </a>
                                    <a href="#" class="d-flex align-items-center text-gray-500 text-hover-primary mb-2">
                                        <i class="ki-duotone ki-sms fs-4 me-1"><span class="path1"></span><span class="path2"></span></i>{{ auth()->user()->email ?? 'example@local' }}
                                    </a>
                                </div>
                                <!--end::Info-->
                            </div>
                            <!--end::User-->
                        </div>
                        <!--end::Title-->
                    </div>
                    <!--end::Info-->
                </div>
                <!--end::Details-->

                <!--begin::Navs-->
                <ul class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bold mt-5">
                    <li class="nav-item">
                        <a class="nav-link text-active-primary ms-0 me-10 py-5" href="/account/profile">Thông tin chi tiết</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-active-primary ms-0 me-10 py-5" href="/account/history">Nhật ký hoạt động</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-active-primary ms-0 me-10 py-5" href="/account/transactions">Lịch sử dòng tiền</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-active-primary ms-0 me-10 py-5" href="/account/orders">Lịch sử mua hàng</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-active-primary ms-0 me-10 py-5 active" href="/account/chat">Tin nhắn</a>
                    </li>
                </ul>
                <!--begin::Navs-->
            </div>
        </div>
        <!--end::Navbar-->

        <!--begin::Chat App-->
        <div class="chat-app">
            {{-- Sidebar --}}
            <div class="chat-sidebar">
                <div class="chat-sidebar-header">
                    <i class="bi bi-shop text-primary"></i> Gian hàng ({{ $conversations->count() }})
                </div>
                <ul class="chat-user-list">
                    @forelse($conversations as $conv)
                    @php
                        $sellerUser = $conv->seller;
                        $sname      = $sellerUser?->name ?? 'Người bán #' . $conv->seller_id;
                        $sletter    = mb_strtoupper(mb_substr($sname, 0, 1));
                        $colors     = ['#1e88e5','#ea5455','#ff9f43','#28c76f','#7367f0'];
                        $bgColor    = $colors[$conv->seller_id % count($colors)];
                        $isActive   = isset($activeConversation) && $activeConversation->id === $conv->id;
                    @endphp
                    <li class="chat-user-item {{ $isActive ? 'active' : '' }}"
                        onclick="window.location.href='?room={{ $conv->id }}&seller_id={{ $conv->seller_id }}'">
                        <div class="user-avatar" style="background:{{ $bgColor }}">{{ $sletter }}</div>
                        <div class="user-info">
                            <div class="user-name">{{ $sname }}</div>
                            <div class="last-msg">{{ $conv->last_message ?: 'Chưa có tin nhắn' }}</div>
                        </div>
                        @if($conv->unread_user > 0)
                            <div class="unread-badge">{{ $conv->unread_user }}</div>
                        @endif
                    </li>
                    @empty
                    <li class="p-4 text-center text-muted fs-6">
                        <i class="bi bi-chat-dots fs-1 d-block mb-2"></i>Chưa có cuộc trò chuyện nào.
                    </li>
                    @endforelse
                </ul>
            </div>

            {{-- Main Chat --}}
            <div class="chat-main">
                @if(isset($activeConversation) && $activeConversation)
                @php
                    $sellerUser = $activeConversation->seller;
                    $sname      = $sellerUser?->name ?? 'Người bán #' . $activeConversation->seller_id;
                    $sletter    = mb_strtoupper(mb_substr($sname, 0, 1));
                @endphp
                <div class="chat-main-header">
                    <div class="d-flex align-items-center gap-3">
                        <div class="user-avatar" style="background:#1e88e5;width:38px;height:38px;font-size:15px;">{{ $sletter }}</div>
                        <div>
                            <div class="fw-bold"><a href="{{ route('shop.profile', ['username' => $sellerUser->username ?? $sellerUser->id]) }}" target="_blank" class="text-dark text-hover-primary">{{ $sname }} <i class="bi bi-box-arrow-up-right ms-1 fs-7"></i></a></div>
                        </div>
                    </div>
                    <small class="text-muted">
                        {{ $activeConversation->last_message_at ? \Carbon\Carbon::parse($activeConversation->last_message_at)->diffForHumans() : 'Mới tạo' }}
                    </small>
                </div>

                <div class="chat-history" id="userChatBody">
                    @foreach($messages as $msg)
                    <div class="message {{ $msg->sender_type === 'user' ? 'sent' : 'received' }}">
                        <div class="message-text">{{ $msg->content }}</div>
                        <div class="message-time">{{ $msg->created_at->format('H:i d/m') }}</div>
                    </div>
                    @endforeach
                </div>

                <div class="chat-input-area">
                    <div class="chat-input-group">
                        <textarea id="userChatInput"
                                  placeholder="Nhắn tin cho {{ $sname }}..."
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
        <!--end::Chat App-->
    </div>
    <!--end::Post-->
</div>
@endsection

@section('scripts')
<script>
const SELLER_ID = {{ isset($activeConversation) && $activeConversation ? $activeConversation->seller_id : 'null' }};
const CSRF      = '{{ csrf_token() }}';

function scrollBottom() {
    const el = document.getElementById('userChatBody');
    if (el) el.scrollTop = el.scrollHeight;
}
scrollBottom();

function sendReply() {
    const inp = document.getElementById('userChatInput');
    const msg = inp.value.trim();
    if (!msg || !SELLER_ID) return;

    // Optimistic UI
    const body = document.getElementById('userChatBody');
    const div  = document.createElement('div');
    div.className = 'message sent';
    div.innerHTML = `<div class="message-text">${msg}</div><div class="message-time">Đang gửi...</div>`;
    body.appendChild(div);
    scrollBottom();
    inp.value = '';

    fetch('{{ route("seller.chat.user.send") }}', {
        method : 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF },
        body   : JSON.stringify({ seller_id: SELLER_ID, message: msg })
    }).then(r => r.json()).then(d => {
        if (d.status === 200 || d.status === 'success') {
            div.querySelector('.message-time').textContent = d.time || new Date().toLocaleTimeString('vi-VN',{hour:'2-digit',minute:'2-digit'});
        } else {
            div.querySelector('.message-time').textContent = 'Lỗi!';
            div.querySelector('.message-time').style.color = 'red';
            toastr.error(d.message || "Không thể gửi tin nhắn");
        }
    }).catch(err => {
        div.querySelector('.message-time').textContent = 'Lỗi kết nối!';
        div.querySelector('.message-time').style.color = 'red';
        console.error(err);
    });
}

function handleEnter(e) {
    if (e.key === 'Enter' && !e.shiftKey) { e.preventDefault(); sendReply(); }
}

// Polling tin nhắn mới từ khách mỗi 5 giây
@if(isset($activeConversation) && $activeConversation)
setInterval(function() {
    fetch('{{ route("seller.chat.user.get", ["seller_id" => $activeConversation->seller_id]) }}')
        .then(r => r.json())
        .then(data => {
            const body = document.getElementById('userChatBody');
            if (data.status === 'success' && data.messages) {
                const currentCount = body.querySelectorAll('.message').length;
                if (data.messages.length > currentCount) {
                    // Render tin nhắn mới
                    const extras = data.messages.slice(currentCount);
                    extras.forEach(m => {
                        const div = document.createElement('div');
                        div.className = 'message ' + (m.sender_type === 'user' ? 'sent' : 'received');
                        div.innerHTML = `<div class="message-text">${m.content}</div>
                            <div class="message-time">${m.time || new Date(m.created_at).toLocaleTimeString('vi-VN',{hour:'2-digit',minute:'2-digit'})}</div>`;
                        body.appendChild(div);
                    });
                    scrollBottom();
                }
            }
        });
}, 5000);
@endif
</script>
@endsection
