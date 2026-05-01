@php use App\Helpers\Helper; @endphp
@php use App\Models\User; @endphp
@php use App\Models\ApiLogo; @endphp
@extends('layouts.app')
@section('title', $pageTitle)
@section('content')
<style>
/* ===== LAYOUT ===== */
.code-detail-grid { display: grid; grid-template-columns: 1fr 380px; gap: 28px; align-items: start; }
@media(max-width:991px){ .code-detail-grid{ grid-template-columns:1fr; } }

/* ===== LEFT: SLIDER ===== */
.code-slider-wrap {
  background: #fff; border-radius: 20px;
  border: 1px solid #edf1f5;
  box-shadow: 0 2px 16px rgba(0,0,0,.07);
  overflow: hidden;
}
.code-slider-wrap .tns { margin: 0; }
.code-slide-img { width: 100%; height: 420px; object-fit: cover; object-position: top; display: block; }
@media(max-width:767px){ .code-slide-img{ height: 240px; } }

/* ===== RIGHT: INFO CARD ===== */
.code-info-card {
  background: #fff; border-radius: 20px;
  border: 1px solid #edf1f5;
  box-shadow: 0 2px 16px rgba(0,0,0,.07);
  padding: 24px;
  position: sticky; top: 90px;
}
.code-id-badge {
  display: inline-flex; align-items: center; gap: 5px;
  background: #e8f9f4; color: #17a589;
  border-radius: 8px; padding: 4px 12px; font-size: .77rem; font-weight: 700;
  margin-bottom: 14px;
}
.code-name {
  font-size: 1.25rem; font-weight: 800; color: #1e1e2d;
  line-height: 1.35; margin-bottom: 14px;
}
.seller-row { display: flex; align-items: center; gap: 10px; margin-bottom: 16px; }
.seller-avatar { width: 36px; height: 36px; border-radius: 50%; object-fit: cover; }
.seller-info .seller-level { font-size: .72rem; color: #a1a5b7; font-weight: 600; }
.seller-info .seller-name { font-size: .88rem; font-weight: 700; color: #1e1e2d; text-decoration: none; }
.seller-info .seller-name:hover { color: #e94560; }

.code-divider { border: none; border-top: 1px solid #edf1f5; margin: 16px 0; }

.stats-row { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-bottom: 16px; }
.stat-box {
  background: #f9fafc; border-radius: 12px; padding: 10px 14px;
  border: 1px solid #edf1f5;
}
.stat-box .stat-label { font-size: .72rem; color: #a1a5b7; font-weight: 600; margin-bottom: 2px; }
.stat-box .stat-val   { font-size: 1.1rem; font-weight: 800; color: #1e1e2d; }

.verified-notice {
  display: flex; align-items: center; gap: 8px;
  background: #e8f9f4; border-radius: 12px; padding: 10px 14px;
  margin-bottom: 16px;
}
.verified-notice span { font-size: .82rem; color: #17a589; font-weight: 600; }

.price-buy-row {
  display: flex; align-items: center; gap: 12px;
  background: #f9fafc; border-radius: 14px; padding: 14px 16px;
}
.price-buy-row .price-label { font-size: .75rem; color: #a1a5b7; font-weight: 600; margin-bottom: 2px; }
.price-buy-row .price-val   { font-size: 1.3rem; font-weight: 800; color: #e94560; }
.btn-buy-code {
  margin-left: auto;
  background: linear-gradient(135deg,#e94560,#c73652);
  color: #fff; border: none; border-radius: 12px;
  padding: 10px 22px; font-size: .92rem; font-weight: 800;
  white-space: nowrap;
  box-shadow: 0 4px 16px rgba(233,69,96,.3);
  transition: transform .15s, box-shadow .15s;
}
.btn-buy-code:hover { transform: translateY(-2px); box-shadow: 0 8px 22px rgba(233,69,96,.4); color:#fff; }

/* ===== DESCRIPTION ===== */
.desc-section {
  background: #fff; border-radius: 20px;
  border: 1px solid #edf1f5;
  box-shadow: 0 2px 10px rgba(0,0,0,.06);
  padding: 28px; margin-top: 28px;
}
.desc-section h2 { font-size: 1.15rem; font-weight: 800; color: #1e1e2d; margin-bottom: 14px; }
.desc-section h3 { font-size: 1rem; font-weight: 700; color: #1e1e2d; margin-bottom: 12px; }
.desc-section ul { padding-left: 18px; }
.desc-section ul li { font-size: .9rem; color: #5e6278; margin-bottom: 8px; line-height: 1.6; }
.desc-intro { font-size: .9rem; color: #5e6278; line-height: 1.7; }

/* ===== COMMENTS ===== */
.comment-box { background: #fff; border-radius: 20px; border: 1px solid #edf1f5; padding: 24px; margin-top: 20px; box-shadow: 0 2px 10px rgba(0,0,0,.06); }
.comment-form-row { display: flex; align-items: flex-start; gap: 12px; margin-bottom: 16px; }
.cmt-avatar-char {
  width: 38px; height: 38px; border-radius: 50%;
  background: linear-gradient(135deg,#e94560,#c73652);
  color: #fff; font-weight: 800; font-size: .95rem;
  display: flex; align-items: center; justify-content: center; flex-shrink: 0;
}
.cmt-textarea {
  flex: 1; border: 1.5px solid #edf1f5; border-radius: 12px;
  padding: 10px 14px; font-size: .88rem; resize: none; background: #f9fafc;
  transition: border-color .15s;
}
.cmt-textarea:focus { outline: none; border-color: #e94560; background: #fff; }
.btn-cmt { background: #e94560; color: #fff; border: none; border-radius: 10px; padding: 8px 22px; font-weight: 700; font-size: .85rem; }
.btn-cmt:hover { background: #c73652; color: #fff; }
#comment-section .comment { padding: 12px 0; border-bottom: 1px solid #f5f5f5; }
#comment-section .comment .user { display: flex; align-items: center; gap: 8px; margin-bottom: 6px; }
#comment-section .comment .avatar {
  width: 34px; height: 34px; border-radius: 50%;
  background: linear-gradient(135deg,#667eea,#764ba2);
  color: #fff; font-weight: 700; font-size: .82rem;
  display: flex; align-items: center; justify-content: center; flex-shrink: 0;
}
#comment-section .comment .user > span { color: #a1a5b7; font-size: .75rem; }
#comment-section .comment .content {
  margin-left: 42px; background: #f9fafc; padding: 10px 14px;
  border-radius: 10px; color: #3f4254; font-size: .88rem; word-break: break-word;
}
#comment-section .comment .content .reply { color: #e94560; font-size: .75rem; font-weight: 600; cursor: pointer; margin-top: 5px; }
#comment-section .reply-comment { margin-left: 42px; margin-top: 6px; }

[data-bs-theme="dark"] .code-slider-wrap,
[data-bs-theme="dark"] .code-info-card,
[data-bs-theme="dark"] .desc-section,
[data-bs-theme="dark"] .comment-box { background: #1c1c2e; border-color: #2d2d44; }
[data-bs-theme="dark"] .code-name { color: #e9edf0; }
[data-bs-theme="dark"] .stat-box { background: #15152a; border-color: #2d2d44; }
[data-bs-theme="dark"] .price-buy-row { background: #15152a; }
[data-bs-theme="dark"] .cmt-textarea { background: #15152a; border-color: #2d2d44; color:#e9edf0; }
</style>

{{-- BREADCRUMB --}}
<div class="container-xxl pt-4 pb-2 px-5">
  <nav style="font-size:.82rem;color:#a1a5b7;">
    <a href="/" style="color:#a1a5b7;text-decoration:none;">Trang chủ</a>
    <span class="mx-2">/</span>
    <a href="/" style="color:#a1a5b7;text-decoration:none;">Mã nguồn</a>
    <span class="mx-2">/</span>
    <span style="color:#1e1e2d;font-weight:600;">{{ Str::limit($code->name ?? '', 50) }}</span>
    <a href="#" class="ms-3" style="color:#e94560;font-size:1rem;" title="Yêu thích">♥</a>
  </nav>
</div>

<div id="kt_content_container" class="d-flex flex-column-fluid align-items-start container-xxl">
  <div class="content flex-row-fluid" id="kt_content">

    <div class="code-detail-grid">

      {{-- ── LEFT: SLIDER ── --}}
      <div>
        <div class="code-slider-wrap">
          <div class="tns" style="direction:ltr;">
            <div data-tns="true" data-tns-nav-position="bottom" data-tns-mouse-drag="true" data-tns-controls="false">
              @php $lines = array_filter(array_map('trim', explode("\n", $code->list_images))); @endphp
              @foreach($lines as $line)
              <div>
                <a data-fslightbox="lightbox-code" href="{{ $line }}">
                  <img src="{{ $line }}" class="code-slide-img" alt="{{ $code->name }}" loading="lazy" decoding="async">
                </a>
              </div>
              @endforeach
            </div>
          </div>
        </div>

        {{-- DESCRIPTION --}}
        <div class="desc-section">
          <h2>📋 Mã nguồn chính hãng, đảm bảo chất lượng và sự tin cậy</h2>
          <ul>
            <li>Mã nguồn chính chủ, được kiểm tra nghiêm ngặt bởi chuyên gia trước khi bàn giao, đảm bảo an toàn tuyệt đối, không có keylog hay backdoor.</li>
            <li>Đội ngũ hỗ trợ sẵn sàng giúp bạn khắc phục sự cố, đảm bảo hệ thống hoạt động ổn định và hiệu quả.</li>
            <li>Bạn nhận đầy đủ mã nguồn như cam kết, tự do chỉnh sửa theo nhu cầu sử dụng riêng.</li>
            <li>Hỗ trợ thiết lập và triển khai, giúp tiết kiệm thời gian cấu hình hệ thống.</li>
          </ul>

          <h3>✨ Ưu đãi đặc biệt và quyền lợi miễn phí</h3>
          <ul>
            <li>Nhận ưu đãi và quyền lợi miễn phí đi kèm, khai thác tối đa giá trị mà không phải trả thêm.</li>
            <li>Lấy khách hàng làm trọng tâm, mang lại nhiều giá trị và sự hài lòng cao nhất.</li>
            <li>Cam kết không ngừng cải thiện để phục vụ bạn tốt hơn mỗi ngày.</li>
          </ul>

          @if($code->intro)
          <div class="desc-intro mt-4 pt-4" style="border-top:1px solid #edf1f5;">
            {!! $code->intro !!}
          </div>
          @endif
        </div>

        {{-- COMMENTS --}}
        <div class="comment-box">
          <div style="font-size:1.05rem;font-weight:800;color:#1e1e2d;margin-bottom:18px;">💬 Bình luận</div>

          @auth
          <form id="comment-form">
            <input type="hidden" name="post_id" value="{{ $code->id }}">
            <input type="hidden" name="parent_id" id="parent_id" value="">
            <div class="comment-form-row">
              <div class="cmt-avatar-char">{{ mb_substr(auth()->user()->name, 0, 1, "UTF-8") }}</div>
              <textarea class="cmt-textarea" rows="2" name="content" placeholder="Bạn đang nghĩ gì..?"></textarea>
            </div>
            <div class="text-end mb-4">
              <button type="submit" class="btn-cmt">Bình Luận</button>
            </div>
          </form>
          @else
          <div style="background:#f0f4ff;border-radius:12px;padding:14px 18px;display:flex;align-items:center;justify-content:space-between;margin-bottom:18px;">
            <span style="font-size:.88rem;color:#5b4fcf;">Đăng nhập để tham gia bình luận</span>
            <a href="{{ route('login') }}" style="background:#5b4fcf;color:#fff;border-radius:8px;padding:6px 18px;font-size:.82rem;font-weight:700;text-decoration:none;">Đăng nhập</a>
          </div>
          @endauth

          <div style="font-size:.77rem;font-weight:700;color:#a1a5b7;text-transform:uppercase;letter-spacing:.5px;margin-bottom:12px;">Chi tiết bình luận</div>
          <div id="comment-section">
            <div class="comment" id="no-comments">
              <div class="post_ajax_loader hk-loader-main">
                <div class="theme-box box-body ajax-loading text-center">
                  <span class="hk-loader-text c-yellow">Đang tải bình luận...</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      {{-- ── RIGHT: INFO CARD ── --}}
      <div class="code-info-card">
        <div class="code-id-badge">✅ Mã: #{{ $code->id }}</div>
        <h1 class="code-name">{{ $code->name }}</h1>

        <div class="seller-row">
          <img src="{{ asset('assets/media/avatars/user-placeholder.svg') }}" class="seller-avatar" alt="">
          <div class="seller-info">
            <div class="seller-level">{{ getuser($user->level) }}</div>
            <a href="/resller/{{ $user->id }}" class="seller-name">{{ $user->name }}</a>
          </div>
        </div>

        <hr class="code-divider">

        <div class="verified-notice">
          <span style="font-size:1.2rem;">🔰</span>
          <span>Sản phẩm đã được kiểm duyệt và cấp phép bán hàng</span>
        </div>

        <div class="stats-row">
          <div class="stat-box">
            <div class="stat-label">👁 Lượt xem</div>
            <div class="stat-val">{{ number_format($code->view) }}</div>
          </div>
          <div class="stat-box">
            <div class="stat-label">🛒 Lượt mua</div>
            <div class="stat-val">{{ number_format($code->sold) }}</div>
          </div>
        </div>

        <hr class="code-divider">

        @php $realPrice = $code->price - ($code->price * $code->ck / 100); @endphp
        @if($realPrice <= 0)
        {{-- FREE product: go to intermediate download page --}}
        <div class="price-buy-row">
          <div>
            <div class="price-label" style="color:#17a589;font-weight:700;">🎁 Miễn phí</div>
            <div class="price-val" style="color:#17a589;">0₫</div>
          </div>
          @auth
          <a href="{{ route('download.free', $code->id) }}" class="btn-buy-code" style="background:linear-gradient(135deg,#17a589,#138d75);">
            ⬇️ Tải miễn phí
          </a>
          @else
          <a href="{{ route('login') }}" class="btn-buy-code" style="background:linear-gradient(135deg,#17a589,#138d75);">
            🔐 Đăng nhập để tải
          </a>
          @endauth
        </div>
        <div style="background:#e8f9f4;border-radius:10px;padding:8px 12px;margin-top:10px;font-size:.78rem;color:#17a589;">
          ⚡ Sản phẩm miễn phí – nhận ngay sau khi đăng nhập, không mất phí.
        </div>
        @else
        {{-- PAID product: normal modal --}}
        <div class="price-buy-row">
          <div>
            <div class="price-label">{{ checkprice($code->price) }}</div>
            <div class="price-val">{{ number_format($realPrice) }}₫</div>
          </div>
          <button type="button" data-bs-toggle="modal" data-bs-target="#kt_modal_stacked_1" class="btn-buy-code">
            🛒 Mua ngay
          </button>
        </div>
        @endif

        <hr class="code-divider">
        <div style="display:flex;flex-direction:column;gap:8px;">
          <div style="display:flex;align-items:center;gap:8px;font-size:.8rem;color:#7e8299;"><span>🔒</span> Thanh toán an toàn &amp; bảo mật</div>
          <div style="display:flex;align-items:center;gap:8px;font-size:.8rem;color:#7e8299;"><span>⚡</span> Nhận link tải ngay sau thanh toán</div>
          <div style="display:flex;align-items:center;gap:8px;font-size:.8rem;color:#7e8299;"><span>🔄</span> Hỗ trợ kỹ thuật sau mua hàng</div>
        </div>
      </div>

    </div>
  </div>
</div>

{{-- PAYMENT MODAL (chỉ hiện với sản phẩm có phí) --}}
@php $realPriceCheck = $code->price - ($code->price * $code->ck / 100); @endphp
@if($realPriceCheck > 0)
<div class="modal fade" tabindex="-1" id="kt_modal_stacked_1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content" style="border-radius:20px;border:none;">
      <div class="modal-header border-0 pb-0">
        <h4 class="modal-title fw-bold">🛒 Xác nhận thanh toán</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body pt-3">
        <div style="background:#f9fafc;border-radius:14px;padding:14px 16px;margin-bottom:18px;">
          <div style="font-weight:700;color:#1e1e2d;margin-bottom:4px;">{{ $code->name }}</div>
          <div style="font-size:.8rem;color:#a1a5b7;">#{{ $code->id }} · {{ $code->created_at->format('d/m/Y') }}</div>
        </div>

        <div style="background:#f9fafc;border-radius:14px;padding:12px 16px;display:flex;align-items:center;gap:12px;margin-bottom:18px;">
          <img src="{{ asset('assets/media/avatars/user-placeholder.svg') }}" style="width:36px;height:36px;border-radius:50%;" alt="">
          <div>
            <div style="font-size:.72rem;color:#a1a5b7;font-weight:600;">{{ getuser($user->level) }}</div>
            <a href="/resller/{{ $user->id }}" style="font-weight:700;color:#1e1e2d;text-decoration:none;font-size:.88rem;">{{ $user->name }}</a>
          </div>
        </div>

        <div class="mb-4">
          <label style="font-size:.82rem;font-weight:600;color:#5e6278;margin-bottom:6px;display:block;">Mã giảm giá</label>
          <input type="text" class="form-control form-control-solid" id="coupon" name="coupon"
            onchange="totalPayment()" onkeyup="totalPayment()" placeholder="Nhập mã giảm giá (nếu có)">
        </div>

        <div style="display:flex;align-items:center;justify-content:space-between;background:#fff0f3;border-radius:12px;padding:12px 16px;margin-bottom:18px;">
          <span style="font-weight:700;color:#1e1e2d;">Tổng tiền</span>
          <span class="text-danger fw-bold fs-4" id="total">{{ number_format($code->price) }}₫</span>
        </div>

        <div class="mb-3">
          <label style="font-size:.82rem;font-weight:600;color:#5e6278;margin-bottom:10px;display:block;">Hình thức thanh toán</label>
          <div style="display:flex;flex-direction:column;gap:8px;">
            <input type="radio" class="btn-check" name="paymentMethod" value="balance" id="paymentMethodBalance" checked>
            <label class="btn btn-outline btn-outline-dashed btn-active-light-primary p-3 d-flex align-items-center" for="paymentMethodBalance">
              <i class="ki-duotone ki-wallet fs-2x me-3"><span class="path1"></span><span class="path2"></span></i>
              <span><span class="fw-bold text-gray-900 d-block">Số dư tài khoản</span><span class="text-muted fs-7">Thanh toán trực tiếp từ số dư</span></span>
            </label>
            <input type="radio" class="btn-check" name="paymentMethod" value="transfer" id="paymentMethodTransfer">
            <label class="btn btn-outline btn-outline-dashed btn-active-light-primary p-3 d-flex align-items-center" for="paymentMethodTransfer">
              <i class="ki-duotone ki-bank fs-2x me-3"><span class="path1"></span><span class="path2"></span></i>
              <span><span class="fw-bold text-gray-900 d-block">Chuyển khoản ngân hàng</span><span class="text-muted fs-7">Tạo hóa đơn và quét QR</span></span>
            </label>
          </div>
        </div>

        <div class="mb-3 bank-selection d-none">
          <label style="font-size:.82rem;font-weight:600;color:#5e6278;margin-bottom:6px;display:block;">Chọn ngân hàng</label>
          <select class="form-select" data-control="select2" id="bank" name="bank">
            @foreach ($bank as $banks)
            <option value="{{ $banks->name }}">{{ ApiLogo::GetApiBank($banks->name, 'shortName', 'name') }}</option>
            @endforeach
          </select>
        </div>
      </div>
      <div class="modal-footer border-0 pt-0 gap-2">
        <button type="button" class="btn btn-light flex-grow-1" data-bs-dismiss="modal">Đóng</button>
        <button type="button" class="btn btn-danger flex-grow-1" id="btnBuy" onclick="processPayment()">
          <i class="fa-solid fa-cart-shopping me-2"></i>Thanh toán
        </button>
      </div>
    </div>
  </div>
</div>
@endif {{-- end @if($realPriceCheck > 0) --}}

@endsection
@section('scripts')
<script>
function timeAgo(timestamp) {
  const now=new Date(),diff=now-timestamp*1e3,s=Math.floor(diff/1e3),m=Math.floor(s/60),h=Math.floor(m/60),d=Math.floor(h/24),mo=Math.floor(d/30),y=Math.floor(mo/12);
  if(y>0)return`${y} năm trước`;if(mo>0)return`${mo} tháng trước`;if(d>0)return`${d} ngày trước`;if(h>0)return`${h} giờ trước`;if(m>0)return`${m} phút trước`;return`${s} giây trước`;
}
function reply(parentId){ document.getElementById('parent_id').value=parentId; document.querySelector('textarea[name="content"]')?.focus(); }

$('#comment-form').on('submit',function(e){
  e.preventDefault();
  $.ajax({ url:'{{ route("comments.store") }}', method:'POST', data:new FormData(this), processData:false, contentType:false,
    headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')},
    success:function(data){ if(data.success){ loadComments(); $('#comment-form')[0].reset(); $('#parent_id').val(''); } },
    error:function(){ console.error('Comment error'); }
  });
});

var pusher=new Pusher('{{ config("app.app_pusher") }}',{cluster:'ap1'});
pusher.subscribe('code-{{ $code->id }}').bind('comments',function(c){
  if(!Array.isArray(c.message)) return;
  const sec=document.getElementById('comment-section'); sec.innerHTML='';
  if(c.message.length===0){ sec.innerHTML=`<div class="text-center py-6"><img style="width:160px;opacity:.5;" src="/assets/images/null.svg"><p style="color:#a1a5b7;margin-top:8px;">Chưa có bình luận nào</p></div>`; return; }
  c.message.forEach(cm=>{ let t=timeAgo(cm.id),html=`<div class="comment"><div class="user"><div class="avatar">${cm.user.charAt(0)}</div>${cm.user}<span>${t}</span></div><div class="content">${cm.content}<div class="reply" onclick="reply(${cm.id})">↩ Trả lời</div></div>`;
    if(cm.replies?.length){html+='<div class="reply-comment">';cm.replies.forEach(r=>{html+=`<div class="user"><div class="avatar">${r.user.charAt(0)}</div>${r.user}<span>${t}</span></div><div class="content">${r.content}</div>`;});html+='</div>';}
    html+='</div>'; sec.innerHTML+=html; });
});

function loadComments(){
  $.ajax({ url:'/comments/{{ $code->id }}', type:'GET', dataType:'json',
    success:function(comments){
      const sec=document.getElementById('comment-section'); sec.innerHTML='';
      if(!Array.isArray(comments)||comments.length===0){ sec.innerHTML=`<div class="text-center py-6"><img style="width:160px;opacity:.5;" src="/assets/images/null.svg"><p style="color:#a1a5b7;margin-top:8px;">Chưa có bình luận nào</p></div>`; return; }
      comments.forEach(cm=>{ let t=timeAgo(cm.id),html=`<div class="comment"><div class="user"><div class="avatar">${cm.user.charAt(0)}</div>${cm.user}<span>${t}</span></div><div class="content">${cm.content}<div class="reply" onclick="reply(${cm.id})">↩ Trả lời</div></div>`;
        if(cm.replies?.length){html+='<div class="reply-comment">';cm.replies.forEach(r=>{html+=`<div class="user"><div class="avatar">${r.user.charAt(0)}</div>${r.user}<span>${t}</span></div><div class="content">${r.content}</div>`;});html+='</div>';}
        html+='</div>'; sec.innerHTML+=html; });
    }, error:function(){ document.getElementById('comment-section').innerHTML='<div style="color:#a1a5b7;padding:12px;">Không tải được bình luận.</div>'; }
  });
}
document.addEventListener('DOMContentLoaded',function(){ loadComments(); });

document.querySelectorAll('input[name="paymentMethod"]').forEach(r=>{ r.addEventListener('change',()=>{ document.querySelector('.bank-selection').classList.toggle('d-none', r.value!=='transfer'); }); });

function processPayment(){ const m=document.querySelector('input[name="paymentMethod"]:checked').value; if(m==='balance') buyProduct(); else if(m==='transfer') transferPayment(); }

function buyProduct(){
  $('#btnBuy').html('<i class="fa fa-spinner fa-spin"></i> Đang xử lý...').prop('disabled',true);
  $.ajax({ url:"/view/payment", method:"POST", dataType:"JSON",
    data:{ _token:'{{ csrf_token() }}', id:"{{ $code->id }}", code:$("#coupon").val() },
    success:function(r){ if(r.status=='200'){ Swal.fire({icon:'success',title:'Thành công!',text:r.message,showDenyButton:true,confirmButtonText:'Mua thêm',denyButtonText:'Xem đơn hàng'}).then(res=>{ if(res.isConfirmed) location.reload(); else if(res.isDenied) window.location.href='/code/history'; }); } else showMessage(r.message,'error'); $('#btnBuy').html('<i class="fa-solid fa-cart-shopping me-2"></i>Thanh toán').prop('disabled',false); },
    error:function(xhr){ showMessage(xhr.responseJSON?.message||'Lỗi','error'); $('#btnBuy').html('<i class="fa-solid fa-cart-shopping me-2"></i>Thanh toán').prop('disabled',false); }
  });
}

function transferPayment(){
  $('#btnBuy').html('<i class="fa fa-spinner fa-spin"></i> Đang xử lý...').prop('disabled',true);
  $.ajax({ url:"/transfer/payment", method:"POST", dataType:"JSON", headers:{'X-CSRF-TOKEN':'{{ csrf_token() }}'},
    data:{ type:'code', id:"{{ $code->id }}", code:$("#coupon").val(), bank:document.getElementById('bank').value },
    success:function(r){ if(r.status=='200'){ showMessage(r.message,'success'); window.location.href=r.redirect_url; } else showMessage(r.message,'error'); $('#btnBuy').html('<i class="fa-solid fa-cart-shopping me-2"></i>Thanh toán').prop('disabled',false); },
    error:function(xhr){ showMessage(xhr.responseJSON?.message||'Lỗi','error'); $('#btnBuy').html('<i class="fa-solid fa-cart-shopping me-2"></i>Thanh toán').prop('disabled',false); }
  });
}

function totalPayment(){
  $('#total').html('<i class="fa fa-spinner fa-spin"></i>');
  $.ajax({ url:"/api/vouchers/redeem", method:"POST", dataType:"JSON",
    data:{ access_token:"{{ $user->access_token }}", id:{{ $code->id }}, code:$("#coupon").val() },
    success:function(r){ $('#total').html(r.message); },
    error:function(xhr){ showMessage(xhr.responseJSON?.message||'Không thể tính','error'); }
  });
}
</script>
@endsection
