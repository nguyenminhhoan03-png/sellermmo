@php use App\Helpers\Helper; @endphp
@extends('layouts.app')
@section('title', $pageTitle)
@section('content')
<style>
.page-hero-banner {
  background: linear-gradient(135deg, #0f3460 0%, #16213e 50%, #1a1a2e 100%);
  border-radius: 20px;
  padding: 44px 40px;
  margin-bottom: 32px;
  position: relative;
  overflow: hidden;
}
.page-hero-banner::after {
  content: '';
  position: absolute;
  top: -80px; right: -80px;
  width: 300px; height: 300px;
  border-radius: 50%;
  background: rgba(233,69,96,.12);
  pointer-events: none;
}
.page-hero-banner h1 { color: #fff; font-size: 1.9rem; font-weight: 800; margin-bottom: 10px; }
.page-hero-banner p  { color: rgba(255,255,255,.7); font-size: .95rem; margin: 0; }
.page-hero-badge {
  display: inline-block;
  background: rgba(255,255,255,.15);
  border: 1px solid rgba(255,255,255,.25);
  color: #fff; border-radius: 20px;
  padding: 4px 14px; font-size: .8rem;
  margin-bottom: 12px;
}
.hero-chips { display: flex; gap: 10px; flex-wrap: wrap; margin-top: 20px; }
.hero-chip {
  display: flex; align-items: center; gap: 6px;
  background: rgba(255,255,255,.1); border: 1px solid rgba(255,255,255,.2);
  color: rgba(255,255,255,.85); border-radius: 20px;
  padding: 5px 14px; font-size: .8rem;
}

/* Web cards */
.web-card {
  background: #fff; border-radius: 18px;
  border: 1px solid #edf1f5;
  overflow: hidden;
  transition: transform .18s, box-shadow .18s;
  box-shadow: 0 2px 10px rgba(0,0,0,.07);
  height: 100%; display: flex; flex-direction: column;
}
.web-card:hover { transform: translateY(-5px); box-shadow: 0 12px 32px rgba(0,0,0,.14); }
.web-card-img { position: relative; overflow: hidden; }
.web-card-img img {
  width: 100%; aspect-ratio: 16/9;
  object-fit: cover;
  transition: transform .3s;
  display: block;
}
.web-card:hover .web-card-img img { transform: scale(1.05); }
.web-card-img .img-overlay {
  position: absolute; inset: 0;
  background: linear-gradient(to top, rgba(0,0,0,.55) 0%, transparent 50%);
  opacity: 0; transition: opacity .2s;
}
.web-card:hover .img-overlay { opacity: 1; }
.web-card-img .preview-btn {
  position: absolute; bottom: 12px; left: 50%; transform: translateX(-50%) translateY(8px);
  background: rgba(255,255,255,.95); color: #1e1e2d;
  border: none; border-radius: 8px; padding: 6px 18px;
  font-size: .8rem; font-weight: 700; white-space: nowrap;
  opacity: 0; transition: all .2s;
}
.web-card:hover .preview-btn { opacity: 1; transform: translateX(-50%) translateY(0); }
.web-card-body { padding: 14px 16px; flex: 1; display: flex; flex-direction: column; }
.web-card-name {
  font-weight: 700; font-size: .93rem; color: #1e1e2d;
  display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;
  margin-bottom: 8px; line-height: 1.4;
}
.web-card-seller { display: flex; align-items: center; gap: 7px; margin-bottom: 10px; }
.web-card-seller img { width: 24px; height: 24px; border-radius: 50%; object-fit: cover; }
.web-card-seller span { font-size: .77rem; color: #a1a5b7; }
.web-card-footer {
  margin-top: auto;
  display: flex; align-items: center; justify-content: space-between; gap: 8px;
  padding-top: 10px; border-top: 1px dashed #edf1f5;
}
.web-card-price { font-size: 1rem; font-weight: 800; color: #e94560; }
.btn-create {
  background: #e94560; color: #fff; border: none;
  border-radius: 9px; padding: 7px 18px; font-size: .82rem; font-weight: 700;
  white-space: nowrap; transition: background .15s, transform .15s;
}
.btn-create:hover { background: #c73652; color: #fff; transform: translateY(-1px); }

/* Empty state */
.empty-state { text-align: center; padding: 60px 20px; }
.empty-state .empty-icon { font-size: 3.5rem; margin-bottom: 16px; }
.empty-state h4 { font-weight: 700; color: #1e1e2d; margin-bottom: 8px; }
.empty-state p { color: #a1a5b7; font-size: .9rem; }

[data-bs-theme="dark"] .web-card { background: #1c1c2e; border-color: #2d2d44; }
[data-bs-theme="dark"] .web-card-name { color: #e9edf0; }
[data-bs-theme="dark"] .web-card-footer { border-color: #2d2d44; }
</style>

{{-- Hero --}}
<div class="container-xxl pt-5 px-5">
  <div class="page-hero-banner">
    <span class="page-hero-badge">🚀 Dịch vụ thiết kế</span>
    <h1>Tạo Website Chuyên Nghiệp</h1>
    <p>Giao diện đẹp, chuẩn SEO, tích hợp đầy đủ tính năng – bàn giao nhanh trong 24h.</p>
    <div class="hero-chips">
      <span class="hero-chip">✅ Chuẩn SEO</span>
      <span class="hero-chip">⚡ Bàn giao 24h</span>
      <span class="hero-chip">📱 Responsive</span>
      <span class="hero-chip">🔒 Bảo mật cao</span>
      <span class="hero-chip">💬 Hỗ trợ 24/7</span>
    </div>
  </div>
</div>

{{-- Grid --}}
<div id="kt_content_container" class="d-flex flex-column-fluid align-items-start container-xxl">
  <div class="content flex-row-fluid" id="kt_content">

    <div class="d-flex align-items-center justify-content-between mb-5">
      <div>
        <h2 style="font-size:1.15rem;font-weight:800;color:#1e1e2d;margin:0;">🖥️ Danh sách mẫu website</h2>
        <div style="font-size:.82rem;color:#a1a5b7;margin-top:3px;">{{ $web->count() }} mẫu đang có sẵn</div>
      </div>
    </div>

    @if($web->count())
    <div class="row g-4">
      @foreach ($web as $value)
      @php
        $webSlug = \App\Models\Slug::of('web', $value->id) ?? $value->id;
        $user    = $value->user;
        $price   = $value->price - $value->price * $value->ck / 100;
      @endphp
      <div class="col-6 col-sm-6 col-md-4 col-lg-3">
        <div class="web-card">
          <div class="web-card-img">
            <img src="{{ img_url($value->images) }}" alt="{{ $value->name }}" loading="lazy" decoding="async"
                 onerror="this.src='{{ asset('assets/media/svg/files/doc.svg') }}'">
            <div class="img-overlay"></div>
            <a href="{{ route('web.view', $webSlug) }}" class="preview-btn">👁 Xem chi tiết</a>
          </div>
          <div class="web-card-body">
            <a href="{{ route('web.view', $webSlug) }}" class="web-card-name text-decoration-none">{{ $value->name }}</a>
            @if($user)
            <div class="web-card-seller">
              <img src="{{ asset('assets/media/avatars/user-placeholder.svg') }}" alt="">
              <span>{{ $user->name }} · {{ $value->created_at->diffForHumans() }}</span>
            </div>
            @endif
            <div class="web-card-footer">
              <span class="web-card-price">{{ number_format($price, 0, ',', '.') }}đ</span>
              <a href="{{ route('web.view', $webSlug) }}" class="btn-create">Tạo Ngay</a>
            </div>
          </div>
        </div>
      </div>
      @endforeach
    </div>
    @else
    <div class="empty-state">
      <div class="empty-icon">🖥️</div>
      <h4>Chưa có mẫu website</h4>
      <p>Vui lòng quay lại sau hoặc liên hệ admin để được tư vấn.</p>
    </div>
    @endif

  </div>
</div>
@endsection
