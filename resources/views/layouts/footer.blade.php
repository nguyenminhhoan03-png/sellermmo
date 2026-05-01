@php use App\Helpers\Helper; @endphp

<style>
    .loader-wrapper {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        width: 100%;
        height: 100%;
        background: #0000008c;
        z-index: 9999999;
        display: flex;
    }

    .site-loader {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        display: inline-block;
        position: relative;
        border: 3px solid;
        margin: auto;
        border-color: #FFF #FFF transparent transparent;
        -webkit-animation: rotation 1s linear infinite;
        animation: rotation 1s linear infinite;
    }

    .site-loader:after,
    .site-loader:before {
        content: "";
        position: absolute;
        left: 0;
        right: 0;
        top: 0;
        bottom: 0;
        margin: auto;
        border: 3px solid;
        border-color: transparent transparent #167408 #167408;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        -webkit-animation: rotationBack 0.5s linear infinite;
        animation: rotationBack 0.5s linear infinite;
        transform-origin: center center;
    }

    .site-loader:before {
        width: 32px;
        height: 32px;
        border-color: #FFF #FFF transparent transparent;
        -webkit-animation: rotation 1.5s linear infinite;
        animation: rotation 1.5s linear infinite;
    }

    @-webkit-keyframes rotation {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }

    @keyframes rotation {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }

    @-webkit-keyframes rotationBack {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(-360deg);
        }
    }

    @keyframes rotationBack {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(-360deg);
        }
    }

    .knw_desc {
        white-space: normal !important;
    }

    .loader-content {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        margin-top: 60px;
        text-transform: capitalize;
        color: #dfe9df;
        font-weight: 800;
        font-size: 20px;
    }

    @media (max-width: 767px) {
        .loader-content {
            font-size: 20px;
        }
    }

    @media (max-width: 575px) {
        .loader-content {
            font-size: 20px;
        }
    }
</style>
<div class="loader-wrapper d-none">
    <span class="site-loader"> </span>
    <span class="loader-content"> Loading... </span>
</div>
<footer class="footer bg-dark text-light pt-10 pb-5" id="kt_footer">
    <div class="container">
        <div class="row">
            <!-- Logo & Description -->
            <div class="col-lg-3 col-md-6 mb-5">
                <div class="footer-widget">
                    <a href="/">
                        <img src="{{ setting_asset('logo_light') }}"
                            width="150" alt="logo">
                    </a>
                    <p class="mt-4">
                        Dịch vụ thiết kế website theo yêu cầu, mua bán mã nguồn, dịch vụ uy tín, hỗ trợ nhiệt tình. Đội
                        ngũ chăm sóc khách hàng 24/24
                    </p>
                    <div class="d-flex mt-4">
                        <a href="#" class="me-3 text-white fs-4"><i class="fab fa-facebook"></i></a>
                        <a href="#" class="me-3 text-white fs-4"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="me-3 text-white fs-4"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="me-3 text-white fs-4"><i class="fab fa-google"></i></a>
                        <a href="#" class="text-white fs-4"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
            </div>

            <!-- Featured Categories -->
            <div class="col-lg-3 col-md-6 mb-5">
                <div class="footer-widget">
                    <h3 class="fw-bold text-white mb-4">Danh mục nổi bật</h3>
                    <ul class="list-unstyled">
                        <li><a href="/" class="text-light text-decoration-none">Mã Nguồn</a></li>
                        <li><a href="/domain" class="text-light text-decoration-none">Tên Miền</a></li>
                        <li><a href="/cronjob" class="text-light text-decoration-none">Cronjob</a></li>
                        <li><a href="/apidocs" class="text-light text-decoration-none">API</a></li>
                    </ul>
                </div>
            </div>

            <!-- Blog Categories -->
            <div class="col-lg-3 col-md-6 mb-5">
                <div class="footer-widget">
                    <h3 class="fw-bold text-white mb-4">Thể loại blog</h3>
                    <ul class="list-unstyled">
                        @foreach ($category_post as $category_posts)
                            <li><a href="/blogs"
                                    class="text-light text-decoration-none">{{ $category_posts->name }}</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <!-- Other Services -->
            <div class="col-lg-3 col-md-6">
                <div class="footer-widget">
                    <h3 class="fw-bold text-white mb-4">Dịch vụ khác</h3>
                    <ul class="list-unstyled">
                        <li><a href="/upanh" class="text-light text-decoration-none">Lấy URL Ảnh</a></li>
                        <li><a href="/whois" class="text-light text-decoration-none">Kiểm Tra Tên Miền</a></li>
                        <li><a href="/info-fb" class="text-light text-decoration-none">Kiểm Tra Facebook</a></li>
                        <li><a href="/tiktok" class="text-light text-decoration-none">Tải Video TikTok</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Contact Information -->
        <div class="border-top border-secondary pt-4 mt-5">
            <div class="row">
                <div class="col-lg-6 d-flex align-items-center mb-3">
                    <div class="me-3">
                        <i class="fas fa-phone-alt fs-4 text-white"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold text-white mb-0">Phone</h6>
                        <p class="mb-0">0866655803</p>
                    </div>
                </div>
                <div class="col-lg-12 d-flex align-items-center">
                    <div class="me-3">
                        <i class="fas fa-envelope fs-4 text-white"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold text-white mb-0">Email</h6>
                        <p class="mb-0">nmh201103@gmail.com</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer Bottom -->
    <div class="footer-bottom bg-darker text-light py-3 mt-5">
        <div class="container">
            <div class="row justify-content-between align-items-center">
                <div class="col-md-6 text-center text-md-start mb-2 mb-md-0">
                        <p class="mb-0">&copy; {{ date('Y') }}, All Rights Reserved | Software By
                        <a href="{{ setting('footer_link', '/') }}"
                            class="text-white">{{ setting('footer_text', 'muabanwebsite') }}</a>
                    </p>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <ul class="list-inline mb-0">
                        <li class="list-inline-item"><a href="/privacy-policy"
                                class="text-light text-decoration-none">Chính sách</a></li>
                        <li class="list-inline-item"><a href="/terms-condition"
                                class="text-light text-decoration-none">Điều khoản & Điều kiện</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</footer>
</div>
</div>
</div>

<!-- <div id="kt_scrolltop" class="scrolltop" data-kt-scrolltop="true">
    <i class="ki-duotone ki-arrow-up"><span class="path1"></span><span class="path2"></span></i>
</div> -->

<style>
/* Floating Social Buttons Redesigned */
.floating-social {
    position: fixed;
    bottom: 30px;
    right: 30px;
    display: flex;
    flex-direction: column;
    gap: 15px;
    z-index: 1000;
}
.floating-social a, .floating-chat-btn {
    width: 55px;
    height: 55px;
    border-radius: 50%;
    display: flex;
    justify-content: center;
    align-items: center;
    box-shadow: 0 4px 15px rgba(0,0,0,0.15);
    transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
    text-decoration: none;
    color: white;
    font-size: 26px;
    cursor: pointer;
    position: relative;
    border: none;
}
.floating-social a:hover, .floating-chat-btn:hover {
    transform: translateY(-5px) scale(1.05);
    box-shadow: 0 10px 25px rgba(0,0,0,0.25);
    color: white;
}
/* Pulse animation for the chat button */
@keyframes pulse-ring {
  0% { box-shadow: 0 0 0 0 rgba(30, 136, 229, 0.7); }
  70% { box-shadow: 0 0 0 15px rgba(30, 136, 229, 0); }
  100% { box-shadow: 0 0 0 0 rgba(30, 136, 229, 0); }
}
.floating-chat-btn {
    animation: pulse-ring 2s infinite;
}

.zalo-bg { background: #0068ff; }
.zalo-bg .z-text { font-weight: 800; font-family: Segoe UI, Tahoma, Geneva, Verdana, sans-serif; font-size: 22px; }
.tele-bg { background: #0088cc; }
.chat-bg { background: #1e88e5; }

/* Chat Widget Window Redesigned */
.chat-widget-window {
    position: fixed;
    bottom: 100px;
    right: 30px;
    width: 360px;
    height: 500px;
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 10px 40px rgba(0,0,0,0.2);
    display: flex;
    flex-direction: column;
    z-index: 1001;
    overflow: hidden;
    transform: translateY(20px);
    opacity: 0;
    pointer-events: none;
    transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
}
.chat-widget-window.open {
    transform: translateY(0);
    opacity: 1;
    pointer-events: auto;
}
.chat-header {
    background: #1e88e5;
    color: white;
    padding: 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.chat-header h5 { margin: 0; font-size: 18px; font-weight: 600; color: white; display:flex; align-items:center;}
.chat-header h5 i { margin-right: 8px;}
.close-chat { cursor: pointer; font-size: 20px; transition: opacity 0.2s;}
.close-chat:hover { opacity: 0.7;}
.chat-body {
    flex: 1;
    padding: 20px;
    overflow-y: auto;
    background: #f4f7f6;
    display: flex;
    flex-direction: column;
    gap: 15px;
}
.chat-msg { max-width: 75%; padding: 12px 18px; border-radius: 20px; font-size: 14px; word-break: break-word; line-height: 1.5;}
.chat-msg.admin { 
    background: #fff; 
    align-self: flex-start; 
    border-bottom-left-radius: 4px; 
    color: #333;
    box-shadow: 0 2px 5px rgba(0,0,0,0.05);
}
.chat-msg.user { 
    background: #1e88e5; 
    color: white; 
    align-self: flex-end; 
    border-bottom-right-radius: 4px; 
    box-shadow: 0 2px 5px rgba(30,136,229,0.3);
}
.chat-footer {
    padding: 15px;
    background: #fff;
    border-top: 1px solid #eee;
    display: flex;
    gap: 12px;
    align-items:center;
}
.chat-footer input {
    flex: 1;
    border: 1px solid #e1e1e1;
    background: #f9f9f9;
    border-radius: 25px;
    padding: 12px 20px;
    outline: none;
    font-size: 14px;
    transition: border-color 0.2s, background 0.2s;
}
.chat-footer input:focus {
    border-color: #1e88e5;
    background: #fff;
}
.chat-footer button {
    background: #1e88e5;
    color: white;
    border: none;
    border-radius: 50%;
    width: 45px;
    height: 45px;
    display: flex;
    justify-content: center;
    align-items: center;
    cursor: pointer;
    transition: background 0.2s, transform 0.2s;
}
.chat-footer button:hover { background: #1565c0; transform: scale(1.05);}

/* Tooltip text */
.floating-social a::after, .floating-chat-btn::after {
    content: attr(data-title);
    position: absolute;
    right: 70px;
    background: rgba(0,0,0,0.8);
    color: white;
    padding: 6px 12px;
    border-radius: 6px;
    font-size: 13px;
    white-space: nowrap;
    opacity: 0;
    pointer-events: none;
    transition: opacity 0.3s;
    font-family: inherit;
}
.floating-social a:hover::after, .floating-chat-btn:hover::after { opacity: 1; }

@media (max-width: 575px) {
    .chat-widget-window { width: calc(100% - 40px); right: 20px; bottom: 100px; }
}

/* Scrollbar for chat body */
.chat-body::-webkit-scrollbar { width: 6px; }
.chat-body::-webkit-scrollbar-thumb { background-color: #ccc; border-radius: 10px; }

.chat-time {
    font-size: 10px;
    color: #999;
    margin-top: 4px;
    display: block;
}
.chat-msg.user .chat-time { color: rgba(255,255,255,0.8); text-align: right; }
.chat-msg.admin .chat-time { color: #aaa; text-align: left; }

.seen-label {
    font-size: 11px;
    color: #1e88e5;
    align-self: flex-end;
    margin-top: -10px;
    margin-right: 10px;
    font-weight: 500;
    margin-bottom: 5px;
}
</style>

<div class="floating-social">
    <a href="https://zalo.me/0866655803" target="_blank" class="zalo-bg" data-title="Chat qua Zalo">
        <svg fill="white" width="35px" height="35px" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path d="M21.5 12.3c0-4.9-4.2-8.9-9.5-8.9C6.8 3.4 2.5 7.4 2.5 12.3c0 2.4 1 4.6 2.7 6.2 0 0-.5 1.5-.6 2.1-.1.9.3 1 1 .5 1.2-.7 3.2-1.9 3.2-1.9.9.3 2 .5 3.2.5 5.3 0 9.5-4 9.5-8.9zM15.5 14h-5.2c-.3 0-.6-.3-.6-.6s.3-.6.6-.6h5.2c.3 0 .6.3.6.6s-.3.6-.6.6zm0-2.8H8.8c-.3 0-.6-.3-.6-.6s.3-.6.6-.6h6.7c.3 0 .6.3.6.6s-.3.6-.6.6z"/>
        </svg>
    </a>
    <a href="https://t.me/your_telegram" target="_blank" class="tele-bg" data-title="Chat Telegram">
        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <line x1="22" y1="2" x2="11" y2="13"></line>
            <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
        </svg>
    </a>
    <button class="floating-chat-btn chat-bg" onclick="toggleChat()" data-title="Hỗ trợ trực tuyến">
        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path>
        </svg>
    </button>
</div>

<div class="chat-widget-window" id="chatWidget">
    <div class="chat-header">
        <h5><i class="fas fa-headset"></i> Hỗ trợ trực tuyến</h5>
        <span class="close-chat" onclick="toggleChat()"><i class="fas fa-times"></i></span>
    </div>
    <div class="chat-body" id="chatBody">
        <div class="chat-msg admin">
            Chào bạn! Cảm ơn bạn đã quan tâm. Mình có thể hỗ trợ gì cho bạn hôm nay không?
        </div>
    </div>
    <div class="chat-footer">
        <input type="text" id="chatInput" placeholder="Soạn tin nhắn ở đây..." onkeypress="handleChatPress(event)">
        <button onclick="sendUiMessage()"><i class="fas fa-paper-plane"></i></button>
    </div>
</div>

<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
<script>
const IS_AUTHENTICATED = {{ auth()->check() ? 'true' : 'false' }};
let currentConversationId = null;

function formatChatTime(dateStr) {
    if (!dateStr) return new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
    const date = new Date(dateStr);
    return date.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
}

function toggleChat() {
    const chat = document.getElementById('chatWidget');
    const isOpening = !chat.classList.contains('open');
    chat.classList.toggle('open');

    if (isOpening) {
        if (!IS_AUTHENTICATED) {
            chat.classList.remove('open');
            Swal.fire({
                title: 'Thông báo',
                text: 'Vui lòng đăng nhập để sử dụng tính năng hỗ trợ trực tuyến!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Đăng nhập ngay',
                cancelButtonText: 'Để sau'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '{{ route("login") }}';
                }
            });
            return;
        }
        $.ajax({
            url: '{{ route("client.chat.get") }}',
            type: 'GET',
            dataType: 'json',
            success: function(res) {
                const chatBody = document.getElementById('chatBody');
                currentConversationId = res.conversation_id;
                
                chatBody.innerHTML = `
                    <div class="chat-msg admin">
                        Chào bạn! Cảm ơn bạn đã quan tâm. Mình có thể hỗ trợ gì cho bạn hôm nay không?
                        <span class="chat-time">${formatChatTime()}</span>
                    </div>
                `;
                
                if (res.messages && res.messages.length > 0) {
                    res.messages.forEach(function(msg, index) {
                        const msgDiv = document.createElement('div');
                        msgDiv.className = 'chat-msg mb-2 ' + (msg.sender_type === 'user' ? 'user' : 'admin');
                        msgDiv.innerHTML = `${msg.content} <span class="chat-time">${formatChatTime(msg.created_at)}</span>`;
                        chatBody.appendChild(msgDiv);
                        
                        if (msg.sender_type === 'user' && index === res.messages.length - 1 && msg.is_read) {
                            const seen = document.createElement('div');
                            seen.className = 'seen-label';
                            seen.id = 'seen-status';
                            seen.textContent = 'Đã xem';
                            chatBody.appendChild(seen);
                        }
                    });
                    chatBody.scrollTop = chatBody.scrollHeight;
                    markAsRead('user');
                }
                
                if (res.conversation_id && !window.clientSubscribed) {
                    if (typeof Pusher !== 'undefined') {
                        var pusherClient = new Pusher('{{ config('app.app_pusher') }}', { cluster: 'ap1' });
                        var clientChannel = pusherClient.subscribe('client-chat-channel-' + res.conversation_id);
                        
                        clientChannel.bind('new-message', function(data) {
                            if (data.message.sender_type === 'admin') {
                                $('#seen-status').remove();
                                const msgDiv = document.createElement('div');
                                msgDiv.className = 'chat-msg admin mb-2';
                                msgDiv.innerHTML = `${data.message.content} <span class="chat-time">${formatChatTime(data.message.created_at)}</span>`;
                                chatBody.appendChild(msgDiv);
                                chatBody.scrollTop = chatBody.scrollHeight;
                                
                                if (document.getElementById('chatWidget').classList.contains('open')) {
                                    markAsRead('user');
                                }
                            }
                        });

                        clientChannel.bind('conversation-read', function(data) {
                            if (data.readerType === 'admin') {
                                $('#seen-status').remove();
                                const seen = document.createElement('div');
                                seen.className = 'seen-label';
                                seen.id = 'seen-status';
                                seen.textContent = 'Đã xem';
                                chatBody.appendChild(seen);
                                chatBody.scrollTop = chatBody.scrollHeight;
                            }
                        });
                        window.clientSubscribed = true;
                    }
                }
            }
        });
    }
}

function markAsRead(type) {
    if (!currentConversationId) return;
    $.post('{{ route("admin.chat.mark-as-read") }}', {
        _token: '{{ csrf_token() }}',
        conversation_id: currentConversationId,
        reader_type: type
    });
}

function sendUiMessage() {
    if (!IS_AUTHENTICATED) {
        Swal.fire({
            title: 'Thông báo',
            text: 'Vui lòng đăng nhập để sử dụng tính năng hỗ trợ trực tuyến!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Đăng nhập ngay',
            cancelButtonText: 'Để sau'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '{{ route("login") }}';
            }
        });
        return;
    }
    const input = document.getElementById('chatInput');
    const msg = input.value.trim();
    if (!msg) return;

    const chatBody = document.getElementById('chatBody');
    $('#seen-status').remove();

    const msgDiv = document.createElement('div');
    msgDiv.className = 'chat-msg user mb-2';
    msgDiv.innerHTML = `${msg} <span class="chat-time">${formatChatTime()}</span>`;
    chatBody.appendChild(msgDiv);
    chatBody.scrollTop = chatBody.scrollHeight;
    
    input.value = '';
    
    $.ajax({
        url: '{{ route("client.chat.send") }}',
        type: 'POST',
        data: { _token: '{{ csrf_token() }}', message: msg },
        error: function(xhr) {
            msgDiv.style.color = 'red';
            msgDiv.title = 'Lỗi gửi tin nhắn';
        }
    });
}

function handleChatPress(e) {
    if (e.key === 'Enter') {
        sendUiMessage();
    }
}
</script>

<script>
    $('.axios-form').submit(function(e) {
        e.preventDefault();

        let reload = $(this).data('reload'),
            button = $(this).find('button[type="submit"]'),
            confirm = $(this).data('confirm'),
            callback = $(this).data('callback');

        if (confirm) {
            Swal.fire({
                title: 'Xác nhận hành động!',
                text: 'Bạn có chắc chắn muốn thực hiện hành đồng này không?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Đồng ý',
                cancelButtonText: 'No, cancel!',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    submitForm();
                }
            });
        } else {
            submitForm();
        }

        function submitForm() {
            let form = $('.axios-form');
            let url = form.attr('action');
            let method = form.attr('method');
            let data = form.serialize();

            Swal.fire({
                icon: 'info',
                title: 'Processing...',
                text: 'Vui lòng đợi xử lý, không được tắt trang!',
                padding: '2em',
                customClass: 'sweet-alerts',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                },
            });

            $.ajax({
                url: url,
                method: method,
                data: data,
                success: function(response) {
                    if (response.status == 200) {
                        Swal.close();
                        showMessage(response.message, 'success');
                        setTimeout(() => {
                            window.location.replace(
                            '/hosting/history');
                        }, 1000);
                    } else {
                        Swal.close();
                        showMessage(response.message, 'error');
                    }
                },
                error: function(xhr) {
                    Swal.close();
                    showMessage(xhr.responseJSON.message, 'error');
                },
            });
        }
    });

    window.gtranslateSettings = {
        "default_language": "vi",
        "native_language_names": true,
        "globe_color": "#66aaff",
        "wrapper_selector": ".gtranslate_wrapper",
        "flag_size": 28,
        "alt_flags": {
            "en": "usa"
        },
        "globe_size": 24
    }
    new ClipboardJS(".copy");

    function copy() {
        showMessage('Đã sao chép vào bộ nhớ tạm', 'success');
    }
</script>

<script src="https://cdn.gtranslate.net/widgets/latest/globe.js" defer></script>
<script>
    var hostUrl = "/assets/";
</script>

<!--begin::Global Javascript Bundle(mandatory for all pages)-->
<script src="/assets/plugins/global/plugins.bundle.js"></script>
<script src="/assets/js/scripts.bundle.js"></script>
<!--end::Global Javascript Bundle-->


<!--begin::Vendors Javascript(used for this page only)-->

@stack('vendor-scripts')

<!--end::Vendors Javascript-->

<!--begin::Custom Javascript(used for this page only)-->
@stack('custom-scripts')
<!--end::Custom Javascript-->
<script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js" defer></script>
@auth
<script src="https://js.pusher.com/8.2.0/pusher.min.js" defer></script>
<script>
  window.__lazyScriptQueue = window.__lazyScriptQueue || [];
  window.__lazyScriptQueue.push(function () {
    if (typeof Pusher === 'undefined' || typeof Swal === 'undefined') return;

    var pusher = new Pusher('{{ config('app.app_pusher') }}', {
      cluster: 'ap1',
    });
    var channel = pusher.subscribe('{{ auth()->user()->username ?? '' }}');
    channel.bind('realtime', function(data) {
      Swal.fire({
        title: 'Thành công!',
        html: `
          <div style="font-size: 15px; margin-bottom: 15px; color: #333;">${data.message}</div>
          <div style="padding: 12px; background: #eef5fb; border-radius: 8px; border: 1px solid #d4ebfd; color: #1565c0; text-align: left; font-size: 14px; line-height: 1.5;">
            <i class="fas fa-info-circle" style="margin-right: 5px;"></i> <b>Cần hỗ trợ về đơn hàng?</b><br>
            Nếu bạn cần hỏi thêm hoặc đơn hàng cần xử lý gấp, vui lòng nhấn vào nút <b>Chat</b>, <b>Zalo</b> hoặc <b>Telegram</b> ở góc phải bên dưới màn hình để gặp Admin nhé!
          </div>
        `,
        icon: 'success',
        confirmButtonText: 'Đã hiểu và Tải lại trang'
      }).then(() => {
        window.location.reload();
      });
    });

    var pageEnteredAt = Date.now();
    var publicChannel = pusher.subscribe('public-notifications');
    publicChannel.bind('purchase.occurred', function(data) {
      var payload = data.data || data;
      var payloadTime = payload.time ? new Date(payload.time).getTime() : NaN;
      if (!isNaN(payloadTime) && payloadTime < pageEnteredAt) return;

      showPurchaseToast({
        userName: payload.userName || 'Khách hàng',
        productName: payload.productName || 'Sản phẩm',
        productPrice: payload.productPrice || '',
        location: payload.location || 'Việt Nam',
        timeAgo: 'vừa xong',
        avatarColor: null,
      });
    });

    function showPurchaseToast(data) {
      var container = document.getElementById('purchase-toast-container');
      if (!container) return;

      var name = data.userName || 'Khách';
      var letter = data.avatarLetter || name.charAt(0).toUpperCase();
      var color = data.avatarColor || '#6c63ff';
      var price = data.productPrice || '';
      var loc = data.location || 'Việt Nam';
      var time = data.timeAgo || 'vừa xong';
      var prod = (data.productName || '').substring(0, 52) + ((data.productName || '').length > 52 ? '…' : '');

      var toast = document.createElement('div');
      toast.className = 'purchase-toast';
      toast.innerHTML = '<div class="toast-header"><div class="badge-buy"><i class="fas fa-star" style="font-size:8px"></i> Vừa mua</div><div class="verify-status"><i class="fas fa-check-circle" style="color:#00ca72"></i> Đã xác minh</div></div><div class="user-info"><div class="avatar" style="background:' + color + '">' + letter + '</div><div class="user-details"><div class="user-name">' + name + '</div><div class="user-action">vừa mua thành công</div></div></div><div class="product-box"><div class="product-name">' + prod + '</div><div class="product-meta">' + (price ? '<span class="price">' + price + '</span>' : '') + '<span class="time">' + time + '</span></div></div><div class="location"><i class="fas fa-location-dot"></i> ' + loc + '</div>';

      container.appendChild(toast);
      setTimeout(function() { toast.classList.add('show'); }, 100);
      setTimeout(function() {
        toast.classList.remove('show');
        setTimeout(function() { if (toast.parentNode) toast.parentNode.removeChild(toast); }, 600);
      }, 7000);
    }
  });
</script>
@endauth

<!--end::Javascript-->
</body>
<!-- Mobile Menu -->
<div class="mobile-menu d-md-none">
    <a href="{{ route('home') }}" class="text-center {{ request()->routeIs('home') ? 'active' : '' }}"
        title="Trang chủ">
        <i class="fas fa-home"></i>
        <span>Trang chủ</span>
    </a>
    <a class="text-center" title="Danh Mục" id="kt_aside_toggle">
        <i class="fas fa-list"></i>
        <span>Danh Mục</span>
    </a>
    <a href="{{ route('recharge') }}" class="text-center {{ request()->routeIs('recharge') ? 'active' : '' }}"
        title="Nạp tiền">
        <i class="fa-solid fa-building-columns"></i>
        <span>Nạp tiền</span>
    </a>
    <a href="{{ route('account.profile.index') }}"
        class="text-center {{ request()->routeIs('account.profile.index') ? 'active' : '' }}" title="Thông tin">
        <i class="fa-solid fa-user"></i>
        <span>Thông tin</span>
    </a>
</div>

<style>
    div.usercm {
        background-color: #f9f9f9;
        font-size: 14px;
        width: 150px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        position: absolute;
        display: none;
        z-index: 10000;
        border-radius: 8px;
        overflow: hidden;
    }

    div.usercm ul {
        list-style: none;
        margin: 0;
        padding: 0;
    }

    div.usercm ul li {
        margin: 0;
        padding: 0;
    }

    div.usercm ul li a {
        color: #333;
        padding: 10px 15px;
        display: block;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    div.usercm ul li a:hover {
        color: #fff;
        background: linear-gradient(9deg, #0e2e4b, #2e6868) !important;
    }

    div.usercm ul li a i {
        margin-right: 8px;
    }

    a.disabled {
        color: #bdbdbd !important;
        cursor: not-allowed;
    }

    a.disabled:hover {
        background-color: transparent !important;
    }

    .hk-bg-animate {
        animation: animateBg 3s linear infinite;
    }

    @keyframes animateBg {
        0% {
            filter: hue-rotate(0deg);
        }

        100% {
            filter: hue-rotate(360deg);
        }
    }

    /* Real-time Purchase Toast Notification */
    #purchase-toast-container {
        position: fixed;
        bottom: 48px;
        left: 20px;
        z-index: 9999;
        display: flex;
        flex-direction: column;
        gap: 10px;
        pointer-events: none;
    }

    .purchase-toast {
        background: #1a1e26;
        color: #fff;
        padding: 15px;
        border-radius: 12px;
        width: 320px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.4);
        display: flex;
        flex-direction: column;
        gap: 10px;
        transform: translateX(-120%);
        transition: transform 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        border: 1px solid #2d323c;
        pointer-events: auto;
    }

    .purchase-toast.show {
        transform: translateX(0);
    }

    .purchase-toast .toast-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .purchase-toast .badge-buy {
        background: #00ca72;
        color: #fff;
        font-size: 10px;
        padding: 2px 8px;
        border-radius: 20px;
        display: flex;
        align-items: center;
        gap: 4px;
        font-weight: bold;
    }

    .purchase-toast .verify-status {
        color: #8b8e94;
        font-size: 10px;
        display: flex;
        align-items: center;
        gap: 3px;
    }

    .purchase-toast .user-info {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .purchase-toast .avatar {
        width: 36px;
        height: 36px;
        background: #3d4451;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        color: #fff;
        position: relative;
    }

    .purchase-toast .avatar::after {
        content: '\f058';
        font-family: 'Font Awesome 6 Free';
        font-weight: 900;
        position: absolute;
        bottom: -2px;
        right: -2px;
        color: #00ca72;
        font-size: 12px;
        background: #1a1e26;
        border-radius: 50%;
    }

    .purchase-toast .user-details {
        display: flex;
        flex-direction: column;
    }

    .purchase-toast .user-name {
        font-weight: bold;
        font-size: 13px;
    }

    .purchase-toast .user-action {
        font-size: 11px;
        color: #8b8e94;
    }

    .purchase-toast .product-box {
        background: #111419;
        border-radius: 8px;
        padding: 10px;
        border-left: 3px solid #00ca72;
    }

    .purchase-toast .product-name {
        font-size: 12px;
        font-weight: bold;
        margin-bottom: 4px;
        white-space: nowrap;
        overflow: hidden;
        text-truncate: ellipsis;
        display: block;
    }

    .purchase-toast .product-meta {
        display: flex;
        gap: 10px;
        font-size: 11px;
    }

    .purchase-toast .price {
        color: #00ca72;
        font-weight: bold;
    }

    .purchase-toast .time {
        color: #8b8e94;
    }

    .purchase-toast .location {
        font-size: 10px;
        color: #8b8e94;
        display: flex;
        align-items: center;
        gap: 4px;
    }
</style>

<div id="purchase-toast-container"></div>
<div class="usercm" style="left: 199px; top: 5px; display: none;">
    <ul>
        <li><a href="javascript:void(0);" onclick="HkCopy();"><i class="fa fa-copy fa-fw"></i><span>Sao
                    chép</span></a></li>
        <li><a href="javascript:window.location.reload();"><i class="fa fa-refresh fa-fw"></i><span>Tải lại
                    trang</span></a></li>
        <li><a href="/"><i class="fa fa-home fa-fw"></i><span>Trang chủ</span></a></li>
        <li><a href="javascript:history.go(1);"><i class="fa fa-arrow-right fa-fw"></i><span>Trang kế</span></a></li>
        <li><a href="javascript:history.go(-1);"><i class="fa fa-arrow-left fa-fw"></i><span>Trang sau</span></a></li>
        <li><a href="/terms-condition"><i class="fa fa-copyright"></i><span>Điều khoản</span></a></li>
    </ul>
</div>
<script>
    window.__lazyScriptQueue = window.__lazyScriptQueue || [];
    window.__lazyScriptQueue.push(function () {
      if (typeof Notyf === 'undefined') return;
      const notyf = new Notyf();

      window.HkCopy = function() {
          const selectedText = window.getSelection ? window.getSelection().toString().trim() : document.selection
              .createRange().text.trim();
          if (selectedText === "") {
              notyf.error('Không tìm thấy nội dung sao chép!');
          } else {
              navigator.clipboard.writeText(selectedText)
                  .then(() => notyf.success("Đã sao chép vào bộ nhớ tạm!"))
                  .catch(err => notyf.error("Lỗi khi sao chép nội dung!"));
          }
      };

      if (typeof jQuery === 'undefined') return;
      (function($) {
          $.extend({
              mouseMoveShow: function(selector) {
                  let windowWidth = 0,
                      windowHeight = 0,
                      mouseX = 0,
                      mouseY = 0,
                      pageX = 0,
                      pageY = 0;

                  $(window).mousemove(function(e) {
                      windowWidth = $(window).width();
                      windowHeight = $(window).height();
                      mouseX = e.clientX;
                      mouseY = e.clientY;
                      pageX = e.pageX;
                      pageY = e.pageY;
                      if (mouseX + $(selector).width() >= windowWidth) {
                          pageX = pageX - $(selector).width() - 5;
                      }
                      if (mouseY + $(selector).height() >= windowHeight) {
                          pageY = pageY - $(selector).height() - 5;
                      }
                      $("html").on({
                          contextmenu: function(e) {
                              if (e.which === 3) {
                                  $(selector).css({
                                      left: pageX,
                                      top: pageY
                                  }).show();
                              }
                              return false;
                          },
                          click: function() {
                              $(selector).hide();
                          }
                      });
                  });
              },
              disabledContextMenu: function() {
                  window.oncontextmenu = function() {
                      return false;
                  };
              }
          });
      }(jQuery));

      $(function() {
          const isMobile = (() => {
              const userAgent = navigator.userAgent;
              const mobileDevices = ["Android", "iPhone", "SymbianOS", "Windows Phone", "iPad", "iPod"];
              return mobileDevices.some(device => userAgent.indexOf(device) > -1);
          })();

          if (!isMobile) {
              $.mouseMoveShow(".usercm");
              $.disabledContextMenu();
          }
      });
    });
</script>
{!! base64_decode(Helper::getNotice('footer_script')) !!}

</html>
