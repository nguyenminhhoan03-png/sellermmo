<style>
/* ─── Drawer Panel ─────────────────────────────────────── */
.sc-drawer {
    position: fixed; top: 0; right: 0; width: 400px; height: 100vh;
    background: #fff; box-shadow: -5px 0 25px rgba(0,0,0,0.1);
    z-index: 1000; transform: translateX(100%);
    transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    display: flex; flex-direction: column;
}
.sc-drawer.open { transform: translateX(0); }

.sc-backdrop {
    position: fixed; top: 0; left: 0; width: 100vw; height: 100vh;
    background: rgba(0,0,0,0.4); z-index: 999;
    opacity: 0; visibility: hidden; transition: all 0.3s ease;
}
.sc-backdrop.open { opacity: 1; visibility: visible; }

/* Header */
.sc-header {
    background: linear-gradient(135deg, #2c3e50, #3498db);
    color: #fff; padding: 16px 20px;
    display: flex; justify-content: space-between; align-items: center;
}
.sc-header-info { display: flex; align-items: center; gap: 12px; }
.sc-header-avatar {
    width: 42px; height: 42px; border-radius: 50%;
    background: #fff; color: #3498db;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.2rem; font-weight: 800;
}
.sc-header-title { font-size: 1.1rem; font-weight: 700; margin-bottom: 2px; }
.sc-header-sub { font-size: 0.8rem; opacity: 0.8; }
.sc-close-btn { background: rgba(255,255,255,0.2); border: none; color: #fff; width: 32px; height: 32px; border-radius: 50%; cursor: pointer; transition: background 0.2s; }
.sc-close-btn:hover { background: rgba(255,255,255,0.4); }

/* Tabs */
.sc-tabs { display: flex; border-bottom: 1px solid #edf1f5; }
.sc-tab { flex: 1; text-align: center; padding: 12px 0; cursor: pointer; font-weight: 600; color: #a1a5b7; transition: all 0.2s; border-bottom: 2px solid transparent; }
.sc-tab.active { color: #3498db; border-bottom-color: #3498db; }
.sc-tab:hover { color: #3498db; }

/* Body Area */
.sc-body-wrap { flex: 1; position: relative; overflow: hidden; background: #f9fafc; }
.sc-tab-content { position: absolute; top: 0; left: 0; width: 100%; height: 100%; overflow-y: auto; padding: 20px; opacity: 0; visibility: hidden; transition: opacity 0.2s; }
.sc-tab-content.active { opacity: 1; visibility: visible; }

/* Info Tab */
.sc-info-card { background: #fff; border-radius: 12px; border: 1px solid #edf1f5; padding: 16px; margin-bottom: 16px; text-align: center; }
.sc-info-card i { font-size: 2rem; color: #3498db; margin-bottom: 10px; }
.sc-info-title { font-weight: 700; color: #1e1e2d; margin-bottom: 6px; }
.sc-info-text { font-size: 0.85rem; color: #7e8299; margin-bottom: 12px; }
.sc-btn-tele { display: inline-flex; align-items: center; justify-content: center; background: #0088cc; color: #fff; padding: 8px 20px; border-radius: 8px; font-size: 0.85rem; font-weight: 600; text-decoration: none; transition: background 0.2s; }
.sc-btn-tele:hover { background: #006699; color: #fff; }

/* Chat Tab */
.sc-chat-area { display: flex; flex-direction: column; height: 100%; }
.sc-chat-messages { flex: 1; overflow-y: auto; padding: 15px; display: flex; flex-direction: column; gap: 12px; }
.sc-msg { display: flex; max-width: 85%; }
.sc-msg.me { align-self: flex-end; flex-direction: row-reverse; }
.sc-msg.them { align-self: flex-start; }
.sc-msg-bubble { padding: 10px 14px; border-radius: 14px; font-size: 0.9rem; line-height: 1.4; position: relative; word-break: break-word; }
.sc-msg.them .sc-msg-bubble { background: #fff; color: #1e1e2d; border: 1px solid #edf1f5; border-bottom-left-radius: 4px; box-shadow: 0 1px 4px rgba(0,0,0,0.02); }
.sc-msg.me .sc-msg-bubble { background: linear-gradient(135deg, #3498db, #2980b9); color: #fff; border-bottom-right-radius: 4px; box-shadow: 0 2px 6px rgba(52,152,219,0.2); }
.sc-msg-time { font-size: 0.7rem; color: #a1a5b7; margin-top: 4px; }
.sc-msg.me .sc-msg-time { text-align: right; }

/* Chat Input */
.sc-chat-input-area { background: #fff; border-top: 1px solid #edf1f5; padding: 14px; display: flex; align-items: flex-end; gap: 10px; }
.sc-textarea { flex: 1; background: #f9fafc; border: 1px solid #edf1f5; border-radius: 12px; padding: 10px 14px; resize: none; font-size: 0.9rem; max-height: 100px; outline: none; transition: border-color 0.2s; }
.sc-textarea:focus { border-color: #3498db; background: #fff; }
.sc-send-btn { width: 40px; height: 40px; border-radius: 50%; background: #3498db; color: #fff; border: none; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: background 0.2s, transform 0.1s; flex-shrink: 0; }
.sc-send-btn:hover { background: #2980b9; transform: scale(1.05); }

@media(max-width:575px){ .sc-drawer{ width: 100vw; } }
</style>

{{-- ── Backdrop ── --}}
<div class="sc-backdrop" id="scBackdrop" onclick="closePanel()"></div>

{{-- ── Drawer ── --}}
<div class="sc-drawer" id="scDrawer">
    <!-- Header -->
    <div class="sc-header">
        <div class="sc-header-info">
            <div class="sc-header-avatar" id="scAvatar">?</div>
            <div>
                <div class="sc-header-title" id="scName">Người bán</div>
                <div class="sc-header-sub">Sẵn sàng hỗ trợ</div>
            </div>
        </div>
        <button class="sc-close-btn" onclick="closePanel()">
            <i class="bi bi-x-lg"></i>
        </button>
    </div>

    <!-- Tabs -->
    <div class="sc-tabs">
        <div class="sc-tab active" data-target="#scTabInfo" onclick="switchScTab(this)">
            <i class="bi bi-info-circle me-1"></i> Thông tin
        </div>
        <div class="sc-tab" data-target="#scTabChat" onclick="switchScTab(this)">
            <i class="bi bi-chat-dots me-1"></i> Nhắn tin
        </div>
    </div>

    <!-- Body -->
    <div class="sc-body-wrap">
        <!-- Tab Info -->
        <div class="sc-tab-content active" id="scTabInfo">
            <div class="sc-info-card">
                <i class="bi bi-shop"></i>
                <div class="sc-info-title" id="scInfoName">Người bán</div>
                <div class="sc-info-text">Tài khoản Telegram liên hệ: <span id="scInfoTele" style="font-weight:600;color:#1e1e2d;">–</span></div>
                <a href="#" target="_blank" class="sc-btn-tele" id="scTeleBtn" style="display:none;">
                    <i class="bi bi-telegram me-2"></i> Chat qua Telegram
                </a>
            </div>
            
            <div class="sc-info-card">
                <i class="bi bi-shield-check" style="color:#2ecc71;"></i>
                <div class="sc-info-title">Giao dịch an toàn</div>
                <div class="sc-info-text">Hệ thống đảm bảo giao dịch an toàn. Vui lòng chat trên hệ thống để được bảo vệ.</div>
            </div>
        </div>

        <!-- Tab Chat -->
        <div class="sc-tab-content p-0" id="scTabChat">
            <div class="sc-chat-area">
                <div class="sc-chat-messages" id="scMessages">
                    <!-- Loading / Messages here -->
                </div>
                <div class="sc-chat-input-area">
                    <textarea class="sc-textarea" id="scInput" rows="1" placeholder="Nhập tin nhắn..."></textarea>
                    <button class="sc-send-btn" onclick="sendScMessage()">
                        <i class="bi bi-send-fill"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
let currentScSellerId = null;
let currentScOrderRef = null;
let scLoadInterval = null;

function switchScTab(el) {
    document.querySelectorAll('.sc-tab').forEach(t => t.classList.remove('active'));
    document.querySelectorAll('.sc-tab-content').forEach(c => c.classList.remove('active'));
    el.classList.add('active');
    document.querySelector(el.dataset.target).classList.add('active');
    
    if(el.dataset.target === '#scTabChat') {
        scrollToScBottom();
        if(currentScSellerId) {
            loadScMessages();
            if(!scLoadInterval) scLoadInterval = setInterval(loadScMessages, 5000);
        }
    } else {
        if(scLoadInterval) { clearInterval(scLoadInterval); scLoadInterval = null; }
    }
}

function openPanel(sellerId, name, username, telegram, orderRef) {
    currentScSellerId = sellerId;
    currentScOrderRef = orderRef;
    
    document.getElementById('scName').textContent = name;
    document.getElementById('scAvatar').textContent = name.charAt(0).toUpperCase();
    document.getElementById('scInfoName').textContent = name;
    
    const teleLabel = document.getElementById('scInfoTele');
    const teleBtn = document.getElementById('scTeleBtn');
    if(telegram && telegram !== '') {
        teleLabel.textContent = '@' + telegram;
        teleBtn.href = 'https://t.me/' + telegram;
        teleBtn.style.display = 'inline-flex';
    } else {
        teleLabel.textContent = 'Chưa cập nhật';
        teleBtn.style.display = 'none';
    }

    document.getElementById('scBackdrop').classList.add('open');
    document.getElementById('scDrawer').classList.add('open');

    // Mặc định mở tab Nhắn tin luôn cho tiện lợi
    switchScTab(document.querySelector('.sc-tab[data-target="#scTabChat"]'));
}

function closePanel() {
    document.getElementById('scBackdrop').classList.remove('open');
    document.getElementById('scDrawer').classList.remove('open');
    if(scLoadInterval) { clearInterval(scLoadInterval); scLoadInterval = null; }
}

function renderScMessages(msgs) {
    const box = document.getElementById('scMessages');
    if(!msgs || msgs.length === 0) {
        box.innerHTML = `<div style="text-align:center; padding:30px; color:#a1a5b7; font-size:0.9rem;">
            Chưa có tin nhắn nào. <br>Hãy gửi lời chào đến người bán!
        </div>`;
        return;
    }

    let html = '';
    msgs.forEach(m => {
        const isMe = (m.sender_type === 'user');
        const time = new Date(m.created_at).toLocaleTimeString('vi-VN', {hour:'2-digit', minute:'2-digit'});
        html += `
        <div class="sc-msg ${isMe ? 'me' : 'them'}">
            <div>
                <div class="sc-msg-bubble">${m.message}</div>
                <div class="sc-msg-time">${time}</div>
            </div>
        </div>`;
    });
    
    const isAtBottom = box.scrollHeight - box.scrollTop <= box.clientHeight + 50;
    box.innerHTML = html;
    if(isAtBottom) scrollToScBottom();
}

function loadScMessages() {
    if(!currentScSellerId) return;
    $.ajax({
        url: '{{ route("seller.chat.user.get", "") }}/' + currentScSellerId,
        type: 'GET',
        data: { order_ref: currentScOrderRef },
        success: function(res) {
            if(res.status === 200) {
                renderScMessages(res.messages);
            }
        }
    });
}

function sendScMessage() {
    const input = document.getElementById('scInput');
    const msg = input.value.trim();
    if(msg === '' || !currentScSellerId) return;

    input.value = '';
    
    const box = document.getElementById('scMessages');
    const time = new Date().toLocaleTimeString('vi-VN', {hour:'2-digit', minute:'2-digit'});
    // Giả lập UI trước
    const html = `
        <div class="sc-msg me">
            <div>
                <div class="sc-msg-bubble" style="opacity:0.7;">${msg}</div>
                <div class="sc-msg-time">${time}</div>
            </div>
        </div>`;
    if(box.querySelector('.sc-msg')) {
        box.innerHTML += html;
    } else {
        box.innerHTML = html;
    }
    scrollToScBottom();

    $.ajax({
        url: '{{ route("seller.chat.user.send") }}',
        type: 'POST',
        data: {
            _token: '{{ csrf_token() }}',
            seller_id: currentScSellerId,
            order_ref: currentScOrderRef,
            message: msg
        },
        success: function(res) {
            if(res.status === 200) {
                loadScMessages(); // reload to get actual DB record
            } else {
                showMessage(res.message, 'error');
            }
        },
        error: function(xhr) {
            showMessage(xhr.responseJSON?.message || 'Có lỗi xảy ra', 'error');
        }
    });
}

function scrollToScBottom() {
    const box = document.getElementById('scMessages');
    box.scrollTop = box.scrollHeight;
}

// Enter to send
document.getElementById('scInput')?.addEventListener('keypress', function(e) {
    if(e.key === 'Enter' && !e.shiftKey) {
        e.preventDefault();
        sendScMessage();
    }
});
</script>
