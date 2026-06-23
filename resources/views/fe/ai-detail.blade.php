@extends('layouts.app')
@section('title', $account->name . ' – Tài khoản AI')
@section('content')
<style>
/* ===== LAYOUT ===== */
.detail-wrap { display: grid; grid-template-columns: 420px 1fr; gap: 28px; align-items: start; }
@media(max-width:991px){ .detail-wrap{ grid-template-columns: 1fr; } }

/* ===== MEDIA PANEL ===== */
.ai-media-panel { position: sticky; top: 90px; align-self: start; z-index: 1; }
@media(max-width:991px){
  .ai-media-panel {
    position: static;
    top: auto;
    z-index: auto;
  }
}
.ai-main-img {
  border-radius: 20px; overflow: hidden;
  border: 1px solid #edf1f5;
  box-shadow: 0 4px 20px rgba(0,0,0,.09);
}
.ai-main-img img {
  width: 100%; aspect-ratio: 1/1;
  object-fit: cover; display: block;
}
.ai-img-placeholder {
  width: 100%; aspect-ratio: 1/1;
  background: linear-gradient(135deg,#f0f0ff 0%,#e0d4ff 100%);
  display: flex; flex-direction: column;
  align-items: center; justify-content: center;
  border-radius: 20px;
}
.ai-img-placeholder span { font-size:4rem; }
.ai-img-placeholder p { font-size:.85rem; color:#7c6fcd; font-weight:600; margin-top:8px; }

/* ===== INFO PANEL ===== */
.ai-info-panel {
  background: #fff; border-radius: 20px;
  border: 1px solid #edf1f5;
  box-shadow: 0 2px 16px rgba(0,0,0,.07);
  padding: 28px;
}
.ai-cat-badge {
  display: inline-flex; align-items: center; gap: 5px;
  background: #f0f0ff; color: #5b4fcf;
  border-radius: 20px; padding: 4px 14px;
  font-size: .78rem; font-weight: 700;
  margin-bottom: 14px;
}
.ai-name { font-size: 1.5rem; font-weight: 800; color: #1e1e2d; margin-bottom: 6px; line-height: 1.3; }
.ai-desc-short { font-size: .9rem; color: #7e8299; margin-bottom: 18px; }
.ai-price-row { display: flex; align-items: baseline; gap: 10px; margin-bottom: 8px; }
.ai-price-now { font-size: 2rem; font-weight: 800; color: #e94560; }
.ai-price-old { font-size: 1rem; color: #a1a5b7; text-decoration: line-through; }
.ai-badges { display: flex; flex-wrap: wrap; gap: 8px; margin-bottom: 22px; }
.ai-badge-item {
  display: inline-flex; align-items: center; gap: 5px;
  border-radius: 8px; padding: 5px 12px; font-size: .78rem; font-weight: 600;
}
.ai-badge-info  { background: #e8f9f4; color: #17a589; }
.ai-badge-stock { background: #fff3cd; color: #856404; }
.ai-badge-dur   { background: #e8f4ff; color: #1a73e8; }

/* ===== VARIANT SELECTOR ===== */
.variant-title { font-size: .92rem; font-weight: 700; color: #1e1e2d; margin-bottom: 12px; }
.variant-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-bottom: 22px; }
@media(max-width:480px){ .variant-grid{ grid-template-columns: 1fr; } }
.variant-radio { display: none; }
.variant-label {
  display: block; cursor: pointer;
  border: 2px solid #edf1f5; border-radius: 14px; padding: 12px 14px;
  transition: all .15s; background: #f9fafc;
}
.variant-radio:checked + .variant-label {
  border-color: #e94560; background: #fff0f3;
}
.variant-label:hover { border-color: #e94560; }
.variant-label-name { font-weight: 700; font-size: .88rem; color: #1e1e2d; margin-bottom: 3px; }
.variant-label-price { font-size: 1rem; font-weight: 800; color: #e94560; }
.variant-label-meta { font-size: .72rem; color: #a1a5b7; margin-top: 4px; }

/* ===== BUY BUTTON ===== */
.btn-buy-ai {
  width: 100%; padding: 14px; border-radius: 14px; font-size: 1rem; font-weight: 800;
  background: linear-gradient(135deg, #e94560, #c73652);
  color: #fff; border: none;
  box-shadow: 0 4px 18px rgba(233,69,96,.35);
  transition: transform .15s, box-shadow .15s;
}
.btn-buy-ai:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(233,69,96,.45); color:#fff; }
.btn-login-ai {
  width: 100%; padding: 14px; border-radius: 14px; font-size: 1rem; font-weight: 700;
  background: #f5f5f5; color: #1e1e2d; border: 2px solid #edf1f5;
  transition: background .15s;
}
.btn-login-ai:hover { background: #edf1f5; color: #1e1e2d; }

/* ===== DIVIDER ===== */
.section-divider { border: none; border-top: 1px solid #edf1f5; margin: 22px 0; }

/* ===== SECURE BADGES ===== */
.secure-row { display: flex; gap: 16px; flex-wrap: wrap; }
.secure-item { display: flex; align-items: center; gap: 5px; font-size: .77rem; color: #7e8299; }

/* ===== RELATED SECTION ===== */
.related-card {
  display: flex; align-items: center; gap: 12px;
  background: #fff; border-radius: 14px; border: 1px solid #edf1f5;
  padding: 12px 14px; text-decoration: none;
  transition: transform .15s, box-shadow .15s;
  box-shadow: 0 1px 6px rgba(0,0,0,.05);
}
.related-card:hover { transform: translateY(-3px); box-shadow: 0 6px 20px rgba(0,0,0,.1); }
.related-card img { width: 56px; height: 56px; border-radius: 10px; object-fit: cover; flex-shrink: 0; }
.related-card-body .name { font-weight: 700; font-size: .88rem; color: #1e1e2d; margin-bottom: 2px; }
.related-card-body .sub  { font-size: .75rem; color: #a1a5b7; }

/* ===== CATEGORY TAGS ===== */
.cat-tag {
  display: inline-block; background: #f0f0ff; color: #5b4fcf;
  border-radius: 8px; padding: 5px 14px; font-size: .8rem; font-weight: 600;
  text-decoration: none; transition: background .15s;
}
.cat-tag:hover { background: #e0d4ff; color: #5b4fcf; }

/* ===== COMMENTS ===== */
.comment-box { background: #fff; border-radius: 20px; border: 1px solid #edf1f5; padding: 24px; }
.comment-form-wrap { display: flex; align-items: flex-start; gap: 12px; margin-bottom: 20px; }
.comment-avatar-char {
  width: 40px; height: 40px; border-radius: 50%;
  background: linear-gradient(135deg,#e94560,#c73652);
  color: #fff; font-weight: 800; font-size: 1rem;
  display: flex; align-items: center; justify-content: center; flex-shrink: 0;
}
.comment-textarea {
  flex: 1; border: 1.5px solid #edf1f5; border-radius: 12px;
  padding: 10px 14px; font-size: .88rem; resize: none;
  transition: border-color .15s;
  background: #f9fafc;
}
.comment-textarea:focus { outline: none; border-color: #e94560; background: #fff; }
.btn-comment-submit {
  background: #e94560; color: #fff; border: none;
  border-radius: 10px; padding: 8px 22px; font-size: .85rem; font-weight: 700;
  white-space: nowrap; transition: background .15s;
}
.btn-comment-submit:hover { background: #c73652; color: #fff; }
#comment-section .comment { padding: 12px 0; border-bottom: 1px solid #f0f0f0; }
#comment-section .comment .user { display: flex; align-items: center; gap: 8px; margin-bottom: 6px; }
#comment-section .comment .avatar {
  width: 34px; height: 34px; border-radius: 50%;
  background: linear-gradient(135deg,#667eea,#764ba2);
  color: #fff; font-weight: 700; font-size: .85rem;
  display: flex; align-items: center; justify-content: center; flex-shrink: 0;
}
#comment-section .comment .user > span { color: #a1a5b7; font-size: .75rem; }
#comment-section .comment .content {
  margin-left: 42px; background: #f9fafc;
  padding: 10px 14px; border-radius: 10px;
  color: #3f4254; font-size: .88rem; word-break: break-word;
}
#comment-section .comment .content .reply {
  color: #e94560; font-size: .75rem; font-weight: 600; cursor: pointer; margin-top: 6px;
}
#comment-section .reply-comment { margin-left: 42px; margin-top: 8px; }

[data-bs-theme="dark"] .ai-info-panel,
[data-bs-theme="dark"] .comment-box,
[data-bs-theme="dark"] .related-card { background: #1c1c2e; border-color: #2d2d44; }
[data-bs-theme="dark"] .ai-name { color: #e9edf0; }
[data-bs-theme="dark"] .variant-label { background: #15152a; border-color: #2d2d44; }
[data-bs-theme="dark"] .variant-radio:checked + .variant-label { background: #2d1020; border-color: #e94560; }
[data-bs-theme="dark"] .comment-textarea { background: #15152a; border-color: #2d2d44; color: #e9edf0; }
</style>

<div id="kt_content_container" class="d-flex flex-column-fluid align-items-start container-xxl py-6">
  <div class="content flex-row-fluid" id="kt_content">

    {{-- ── BREADCRUMB ── --}}
    <nav class="mb-5" style="font-size:.82rem;color:#a1a5b7;">
      <a href="/" style="color:#a1a5b7;text-decoration:none;">Trang chủ</a>
      <span class="mx-2">/</span>
      <a href="/ai-account" style="color:#a1a5b7;text-decoration:none;">Tài khoản AI</a>
      <span class="mx-2">/</span>
      <span style="color:#1e1e2d;font-weight:600;">{{ Str::limit($account->name, 40) }}</span>
    </nav>

    {{-- ── MAIN DETAIL ── --}}
    <div class="detail-wrap mb-8">

      {{-- LEFT: image --}}
      <div class="ai-media-panel">
        @php
          $accountImage = $account->image ?? '';
          if ($accountImage) {
              if (!preg_match('#^https?://#i', $accountImage)) {
                  $accountImage = img_url($accountImage);
              }
          }
        @endphp
        @if(!empty($accountImage))
          <div class="ai-main-img">
            <img src="{{ $accountImage }}" alt="{{ $account->name }}" loading="lazy" decoding="async" onerror="this.onerror=null;this.src='{{ asset('assets/media/logos/default-small.svg') }}'">
          </div>
        @else
          <div class="ai-img-placeholder">
            <span>🤖</span>
            <p>{{ Str::limit($account->name, 24) }}</p>
          </div>
        @endif
      </div>

      {{-- RIGHT: info --}}
      <div class="ai-info-panel">
        <div class="ai-cat-badge">🤖 {{ $account->category_name ?: 'AI Account' }}</div>
        <h1 class="ai-name">{{ $account->name }}</h1>
        <p class="ai-desc-short">{{ $account->description ?: 'Tài khoản AI chính hãng, sẵn sàng cung cấp ngay sau khi thanh toán.' }}</p>

        <div class="ai-price-row">
          <span class="ai-price-now" id="display-price">{{ number_format((float)$account->price, 0, ',', '.') }}đ</span>
          <span class="ai-price-old d-none" id="display-old-price">0đ</span>
        </div>

        <div class="ai-badges">
          <span class="ai-badge-item ai-badge-info" id="display-info">✅ {{ $account->account_info ?: 'Sẵn sàng cung cấp' }}</span>
          <span class="ai-badge-item ai-badge-stock" id="display-stock">📦 Kho: –</span>
          <span class="ai-badge-item ai-badge-dur"   id="display-duration">⏱ Thời hạn: –</span>
        </div>

        <hr class="section-divider">

        <div class="variant-title">Chọn gói khả dụng</div>
        <div class="variant-grid" id="variant-list">
          @forelse($variants as $index => $variant)
          <div>
            <input class="variant-radio ai-variant-radio" type="radio" name="ai_variant"
              id="ai_variant_{{ $variant->id }}" value="{{ $variant->id }}"
              data-name="{{ $variant->variant_name }}"
              data-price="{{ (float)$variant->price }}"
              data-old-price="{{ (float)$variant->old_price }}"
              data-stock="{{ (int)$variant->stock_quantity }}"
              data-duration="{{ $variant->duration_days ? (int)$variant->duration_days : 0 }}"
              data-sku="{{ $variant->sku ?: '-' }}"
              @checked($index === 0)>
            <label class="variant-label" for="ai_variant_{{ $variant->id }}">
              <div class="variant-label-name">{{ $variant->variant_name }}</div>
              <div class="variant-label-price">{{ number_format((float)$variant->price, 0, ',', '.') }}đ</div>
              <div class="variant-label-meta">SKU: {{ $variant->sku ?: '–' }} · Kho: {{ (int)$variant->stock_quantity }} · {{ $variant->duration_days ? (int)$variant->duration_days.' ngày' : '∞' }}</div>
            </label>
          </div>
          @empty
          <div class="col-span-2">
            <div style="background:#fff3cd;border-radius:12px;padding:12px 16px;font-size:.85rem;color:#856404;">⚠️ Sản phẩm chưa có gói biến thể. Vui lòng liên hệ admin.</div>
          </div>
          @endforelse
        </div>

        <div id="ai-comment-config" data-auth="{{ auth()->check() ? '1' : '0' }}" data-post-id="{{ $commentPostId }}"></div>

        @auth
        <button type="button" class="btn-buy-ai mb-4" id="buy-now-btn"
          data-bs-toggle="modal" data-bs-target="#kt_modal_ai_payment">
          🛒 Mua gói đã chọn
        </button>
        @else
        <a href="{{ route('login') }}" class="btn-login-ai d-block text-center mb-4 text-decoration-none">
          🔐 Đăng nhập để mua
        </a>
        @endauth

        <hr class="section-divider">
        <div class="secure-row">
          <span class="secure-item">🔒 Thanh toán an toàn</span>
          <span class="secure-item">⚡ Giao ngay tức thì</span>
          <span class="secure-item">🔄 Hỗ trợ sau mua</span>
        </div>
      </div>
    </div>

    {{-- ── RELATED + CATEGORIES ── --}}
    <div class="row g-4 mb-8">
      <div class="col-lg-8">
        <div style="font-size:1.05rem;font-weight:800;color:#1e1e2d;margin-bottom:14px;">🔗 Tài khoản liên quan</div>
        <div class="row g-3">
          @forelse($relatedAccounts as $related)
          @php $rSlug = \App\Models\Slug::of('ai', $related->id) ?? $related->id; @endphp
          <div class="col-md-6">
            <a href="{{ route('ai-account.detail', $rSlug) }}" class="related-card">
              @if($related->image)
                <img src="{{ img_url($related->image) }}" alt="{{ $related->name }}" loading="lazy" decoding="async">
              @else
                <div style="width:56px;height:56px;border-radius:10px;background:linear-gradient(135deg,#f0f0ff,#e0d4ff);display:flex;align-items:center;justify-content:center;font-size:1.5rem;flex-shrink:0;">🤖</div>
              @endif
              <div class="related-card-body min-w-0">
                <div class="name text-truncate">{{ $related->name }}</div>
                <div class="sub">{{ $related->account_info ?: 'Sẵn sàng cung cấp' }}</div>
              </div>
            </a>
          </div>
          @empty
          <div class="col-12" style="color:#a1a5b7;font-size:.88rem;">Chưa có tài khoản liên quan.</div>
          @endforelse
        </div>
      </div>

      <div class="col-lg-4">
        <div style="background:#fff;border-radius:20px;border:1px solid #edf1f5;padding:20px;box-shadow:0 2px 10px rgba(0,0,0,.05);">
          <div style="font-size:1.05rem;font-weight:800;color:#1e1e2d;margin-bottom:14px;">🏷 Danh mục AI</div>
          <div style="display:flex;flex-wrap:wrap;gap:8px;">
            @forelse($aiCategories as $category)
              <span class="cat-tag">{{ $category->name }}</span>
            @empty
              <span style="color:#a1a5b7;font-size:.85rem;">Chưa có danh mục.</span>
            @endforelse
          </div>
        </div>
      </div>
    </div>

    {{-- ── COMMENTS ── --}}
    <div class="comment-box">
      <div style="font-size:1.05rem;font-weight:800;color:#1e1e2d;margin-bottom:18px;">💬 Bình luận</div>

      @auth
      <form id="comment-form">
        <input type="hidden" name="post_id" value="{{ $commentPostId }}">
        <input type="hidden" name="parent_id" id="parent_id" value="">
        <div class="comment-form-wrap">
          <div class="comment-avatar-char">{{ mb_substr(auth()->user()->name, 0, 1, 'UTF-8') }}</div>
          <textarea class="comment-textarea" rows="2" name="content" placeholder="Bạn đang nghĩ gì..?"></textarea>
        </div>
        <div class="text-end mb-4">
          <button type="submit" class="btn-comment-submit">Bình Luận</button>
        </div>
      </form>
      @else
      <div style="background:#f0f4ff;border-radius:12px;padding:14px 18px;display:flex;align-items:center;justify-content:space-between;margin-bottom:18px;">
        <span style="font-size:.88rem;color:#5b4fcf;">Đăng nhập để tham gia bình luận</span>
        <a href="{{ route('login') }}" style="background:#5b4fcf;color:#fff;border-radius:8px;padding:6px 18px;font-size:.82rem;font-weight:700;text-decoration:none;">Đăng nhập</a>
      </div>
      @endauth

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
</div>

{{-- ── PAYMENT MODAL ── --}}
@auth
<div class="modal fade" tabindex="-1" id="kt_modal_ai_payment">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content" style="border-radius:20px;border:none;">
      <div class="modal-header border-0 pb-0">
        <h4 class="modal-title fw-bold">🛒 Xác nhận thanh toán</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body pt-3">
        <div style="background:#f9fafc;border-radius:14px;padding:14px 16px;margin-bottom:18px;">
          <div style="font-weight:700;color:#1e1e2d;margin-bottom:3px;">{{ $account->name }}</div>
          <div style="font-size:.82rem;color:#a1a5b7;">Gói: <strong class="text-danger" id="modal-variant-name">–</strong></div>
        </div>

        <div class="mb-4">
          <label style="font-size:.82rem;font-weight:600;color:#5e6278;margin-bottom:6px;display:block;">Mã giảm giá</label>
          <input type="text" class="form-control form-control-solid" id="ai-coupon" name="coupon"
            placeholder="Nhập mã (nếu có)" onchange="aiTotalPayment()" onkeyup="aiTotalPayment()">
        </div>

        <div style="display:flex;align-items:center;justify-content:space-between;background:#fff0f3;border-radius:12px;padding:12px 16px;margin-bottom:18px;">
          <span style="font-weight:700;color:#1e1e2d;">Tổng tiền</span>
          <span class="text-danger fw-bold fs-4" id="modal-total">0₫</span>
        </div>

        <div class="mb-3">
          <label style="font-size:.82rem;font-weight:600;color:#5e6278;margin-bottom:10px;display:block;">Hình thức thanh toán</label>
          <div style="display:flex;flex-direction:column;gap:8px;">
            <input type="radio" class="btn-check" name="aiPaymentMethod" value="balance" id="aiPayBalance" checked>
            <label class="btn btn-outline btn-outline-dashed btn-active-light-primary p-3 d-flex align-items-center" for="aiPayBalance">
              <i class="ki-duotone ki-wallet fs-2x me-3 text-primary"><span class="path1"></span><span class="path2"></span></i>
              <span class="text-start">
                <span class="fw-bold text-gray-900 d-block">Số dư tài khoản</span>
                <span class="text-muted fs-7">Trừ tiền trực tiếp từ ví</span>
              </span>
            </label>
            <input type="radio" class="btn-check" name="aiPaymentMethod" value="transfer" id="aiPayTransfer">
            <label class="btn btn-outline btn-outline-dashed btn-active-light-primary p-3 d-flex align-items-center" for="aiPayTransfer">
              <i class="ki-duotone ki-bank fs-2x me-3 text-success"><span class="path1"></span><span class="path2"></span></i>
              <span class="text-start">
                <span class="fw-bold text-gray-900 d-block">Chuyển khoản ngân hàng</span>
                <span class="text-muted fs-7">Quét mã QR tự động</span>
              </span>
            </label>
          </div>
        </div>

        <div class="mb-3 ai-bank-selection d-none">
          <label style="font-size:.82rem;font-weight:600;color:#5e6278;margin-bottom:6px;display:block;">Chọn ngân hàng</label>
          <select class="form-select form-select-solid" data-control="select2" id="ai-bank" name="ai_bank" data-dropdown-parent="#kt_modal_ai_payment">
            @foreach (\App\Models\BankAccount::where('status',1)->get() as $banks)
            <option value="{{ $banks->name }}">{{ \App\Models\ApiLogo::GetApiBank($banks->name, 'shortName', 'name') ?: $banks->name }}</option>
            @endforeach
          </select>
        </div>
      </div>
      <div class="modal-footer border-0 pt-0 gap-2">
        <button type="button" class="btn btn-light flex-grow-1" data-bs-dismiss="modal">Đóng</button>
        <button type="button" class="btn btn-danger flex-grow-1" id="btnAiBuy" onclick="processAiPayment()">
          <i class="fa-solid fa-cart-shopping me-2"></i>Thanh toán
        </button>
      </div>
    </div>
  </div>
</div>
@endauth

@endsection
@section('scripts')
<script>
function timeAgo(timestamp) {
  const now = new Date(), diff = now - timestamp * 1000;
  const s=Math.floor(diff/1e3),m=Math.floor(s/60),h=Math.floor(m/60),d=Math.floor(h/24),mo=Math.floor(d/30),y=Math.floor(mo/12);
  if(y>0) return `${y} năm trước`; if(mo>0) return `${mo} tháng trước`;
  if(d>0) return `${d} ngày trước`; if(h>0) return `${h} giờ trước`;
  if(m>0) return `${m} phút trước`; return `${s} giây trước`;
}
function reply(parentId) {
  document.getElementById('parent_id').value = parentId;
  document.querySelector('textarea[name="content"]')?.focus();
}
const commentConfig = document.getElementById('ai-comment-config');
const isAuthenticated = commentConfig?.dataset.auth === '1';
const commentPostId   = commentConfig?.dataset.postId || '';
const commentsStoreUrl = '{{ route("comments.store") }}';
function formatMoney(v){ return Number(v||0).toLocaleString('vi-VN')+'đ'; }
function applySelectedVariant(radio) {
  if (!radio) return;
  const name=radio.dataset.name||'–', price=Number(radio.dataset.price||0),
        oldPrice=Number(radio.dataset.oldPrice||0), stock=Number(radio.dataset.stock||0),
        duration=Number(radio.dataset.duration||0), sku=radio.dataset.sku||'–';
  const el = (id) => document.getElementById(id);
  if(el('display-price')) el('display-price').textContent = formatMoney(price);
  if(el('display-old-price')){ if(oldPrice>0){ el('display-old-price').textContent=formatMoney(oldPrice); el('display-old-price').classList.remove('d-none'); } else { el('display-old-price').classList.add('d-none'); } }
  if(el('display-stock')) el('display-stock').textContent = `📦 Kho: ${stock}`;
  if(el('display-duration')) el('display-duration').textContent = `⏱ Thời hạn: ${duration>0?duration+' ngày':'Không giới hạn'}`;
  const buyBtn = el('buy-now-btn');
  if(buyBtn){ buyBtn.textContent = `🛒 Mua gói: ${name}`; buyBtn.classList.toggle('disabled', stock<=0); }
}
if(isAuthenticated && document.getElementById('comment-form')) {
  $('#comment-form').on('submit', function(e) {
    e.preventDefault();
    $.ajax({ url: commentsStoreUrl, method: 'POST', data: new FormData(this), processData: false, contentType: false,
      headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
      success: function(data){ if(data.success){ loadComments(); $('#comment-form')[0].reset(); $('#parent_id').val(''); } },
      error: function(){ if(typeof notyf!=='undefined') notyf.error('Gửi bình luận thất bại'); }
    });
  });
}
var pusher = new Pusher('{{ config("app.app_pusher") }}', { cluster: 'ap1' });
pusher.subscribe(`code-${commentPostId}`).bind('comments', function(c){ if(Array.isArray(c.message)) renderComments(c.message); });
function renderComments(comments) {
  const sec = document.getElementById('comment-section');
  if(!sec) return;
  sec.innerHTML = '';
  if(comments.length===0){
    sec.innerHTML = `<div class="text-center py-8"><img style="width:180px;opacity:.5;" src="/assets/images/null.svg"><p style="color:#a1a5b7;margin-top:10px;">Chưa có bình luận nào</p></div>`;
    return;
  }
  comments.forEach(c => {
    let t=timeAgo(c.id), html=`<div class="comment"><div class="user"><div class="avatar">${c.user.charAt(0)}</div>${c.user}<span>${t}</span></div><div class="content">${c.content}${isAuthenticated?`<div class="reply" onclick="reply(${c.id})">↩ Trả lời</div>`:''}</div>`;
    if(c.replies?.length){ html+='<div class="reply-comment">'; c.replies.forEach(r=>{ html+=`<div class="user"><div class="avatar">${r.user.charAt(0)}</div>${r.user}<span>${t}</span></div><div class="content">${r.content}</div>`; }); html+='</div>'; }
    html+='</div>'; sec.innerHTML+=html;
  });
}
function loadComments() {
  $.ajax({ url:`/comments/${commentPostId}`, type:'GET', dataType:'json',
    success: function(c){ renderComments(Array.isArray(c)?c:[]); },
    error: function(){ renderComments([]); }
  });
}
document.addEventListener('DOMContentLoaded', function() {
  const radios = document.querySelectorAll('.ai-variant-radio');
  if(radios.length>0){ applySelectedVariant(document.querySelector('.ai-variant-radio:checked')||radios[0]); radios.forEach(r=>r.addEventListener('change',function(){ applySelectedVariant(this); })); }
  loadComments();
});
let selectedVariantId=null, selectedVariantPrice=0, selectedVariantName='';
document.getElementById('kt_modal_ai_payment')?.addEventListener('show.bs.modal', function(){
  const checked = document.querySelector('.ai-variant-radio:checked');
  if(checked){ selectedVariantId=checked.value; selectedVariantPrice=Number(checked.dataset.price||0); selectedVariantName=checked.dataset.name||'–'; }
  const mn=document.getElementById('modal-variant-name'); if(mn) mn.textContent=selectedVariantName;
  $('#ai-coupon').val(''); aiTotalPayment();
});
document.querySelectorAll('input[name="aiPaymentMethod"]').forEach(r=>{ r.addEventListener('change',()=>{ const b=document.querySelector('.ai-bank-selection'); if(r.value==='transfer'){ b?.classList.remove('d-none'); if($.fn.select2) $('#ai-bank').select2({minimumResultsForSearch:Infinity}); } else b?.classList.add('d-none'); }); });
function aiTotalPayment() {
  if(!selectedVariantId) return;
  $('#modal-total').html('<i class="fa fa-spinner fa-spin"></i>');
  $.ajax({ url:'/api/vouchers/aivoucher', method:'POST', dataType:'JSON',
    data:{ access_token:'{{ auth()->user()->access_token ?? "" }}', variant_id:selectedVariantId, code:$('#ai-coupon').val() },
    success:function(r){ $('#modal-total').html(r.message); }, error:function(){ $('#modal-total').html('Lỗi'); }
  });
}
function processAiPayment(){ document.querySelector('input[name="aiPaymentMethod"]:checked')?.value==='balance'?aiPayByBalance():aiPayByTransfer(); }
function aiPayByBalance(){
  $('#btnAiBuy').html('<i class="fa fa-spinner fa-spin"></i> Đang xử lý...').prop('disabled',true);
  $.ajax({ url:'{{ route("ai-account.payment") }}', method:'POST', dataType:'JSON',
    data:{ _token:'{{ csrf_token() }}', account_id:'{{ $account->id }}', variant_id:selectedVariantId, coupon:$('#ai-coupon').val() },
    success:function(r){
      if(r.status==200){ Swal.fire({icon:'success',title:'Thành công!',text:r.message,showDenyButton:true,confirmButtonText:'Mua tiếp',denyButtonText:'Lịch sử mua'}).then(res=>{ if(res.isConfirmed) location.reload(); else if(res.isDenied) window.location.href='/ai-account/history'; }); }
      else showMessage(r.message,'error');
      $('#btnAiBuy').html('<i class="fa-solid fa-cart-shopping me-2"></i>Thanh toán').prop('disabled',false);
    }, error:function(xhr){ showMessage(xhr.responseJSON?.message||'Lỗi','error'); $('#btnAiBuy').html('<i class="fa-solid fa-cart-shopping me-2"></i>Thanh toán').prop('disabled',false); }
  });
}
function aiPayByTransfer(){
  const bank=document.getElementById('ai-bank')?.value;
  $('#btnAiBuy').html('<i class="fa fa-spinner fa-spin"></i> Đang xử lý...').prop('disabled',true);
  $.ajax({ url:'{{ route("ai-account.transfer-payment") }}', method:'POST', dataType:'JSON',
    data:{ _token:'{{ csrf_token() }}', account_id:'{{ $account->id }}', variant_id:selectedVariantId, bank:bank, coupon:$('#ai-coupon').val() },
    success:function(r){ if(r.status==200){ showMessage(r.message,'success'); window.location.href=r.redirect_url; } else showMessage(r.message,'error'); $('#btnAiBuy').html('<i class="fa-solid fa-cart-shopping me-2"></i>Thanh toán').prop('disabled',false); },
    error:function(xhr){ showMessage(xhr.responseJSON?.message||'Lỗi','error'); $('#btnAiBuy').html('<i class="fa-solid fa-cart-shopping me-2"></i>Thanh toán').prop('disabled',false); }
  });
}
</script>
@endsection
