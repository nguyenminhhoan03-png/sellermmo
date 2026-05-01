@php use App\Helpers\Helper; @endphp
@extends('layouts.app')
@section('title', $pageTitle)
@section('content')
<style>
.page-hero-banner {
  background: linear-gradient(135deg, #2d1b69 0%, #11998e 100%);
  border-radius: 20px;
  padding: 44px 40px;
  margin-bottom: 32px;
  position: relative;
  overflow: hidden;
}
.page-hero-banner::before {
  content: '';
  position: absolute;
  top: -60px; right: -60px;
  width: 280px; height: 280px;
  border-radius: 50%;
  background: rgba(255,255,255,.07);
  pointer-events: none;
}
.page-hero-banner h1 { color: #fff; font-size: 1.9rem; font-weight: 800; margin-bottom: 10px; }
.page-hero-banner p  { color: rgba(255,255,255,.75); font-size: .95rem; margin: 0; }
.page-hero-badge {
  display: inline-block;
  background: rgba(255,255,255,.18);
  border: 1px solid rgba(255,255,255,.3);
  color: #fff; border-radius: 20px;
  padding: 4px 14px; font-size: .8rem;
  margin-bottom: 12px;
}
.hero-chips { display: flex; gap: 10px; flex-wrap: wrap; margin-top: 20px; }
.hero-chip {
  display: flex; align-items: center; gap: 6px;
  background: rgba(255,255,255,.12); border: 1px solid rgba(255,255,255,.2);
  color: rgba(255,255,255,.88); border-radius: 20px;
  padding: 5px 14px; font-size: .8rem;
}

/* Logo cards */
.logo-card {
  background: #fff; border-radius: 18px;
  border: 1px solid #edf1f5;
  overflow: hidden;
  transition: transform .18s, box-shadow .18s;
  box-shadow: 0 2px 10px rgba(0,0,0,.07);
  height: 100%; display: flex; flex-direction: column;
}
.logo-card:hover { transform: translateY(-5px); box-shadow: 0 12px 32px rgba(0,0,0,.14); }

.logo-card-img {
  position: relative; overflow: hidden;
  background: #f8f9fc;
}
.logo-card-img img {
  width: 100%; aspect-ratio: 3/2;
  object-fit: contain; padding: 20px;
  transition: transform .3s;
  display: block;
}
.logo-card:hover .logo-card-img img { transform: scale(1.06); }
.logo-card-img .img-overlay {
  position: absolute; inset: 0;
  background: rgba(45,27,105,.55);
  display: flex; align-items: center; justify-content: center;
  opacity: 0; transition: opacity .2s;
}
.logo-card:hover .img-overlay { opacity: 1; }
.logo-preview-btn {
  background: #fff; color: #2d1b69;
  border: none; border-radius: 9px; padding: 7px 20px;
  font-size: .82rem; font-weight: 700;
  transform: translateY(8px); transition: transform .2s;
}
.logo-card:hover .logo-preview-btn { transform: translateY(0); }

.logo-card-body { padding: 14px 16px; flex: 1; display: flex; flex-direction: column; }
.logo-card-name {
  font-weight: 700; font-size: .93rem; color: #1e1e2d;
  display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;
  margin-bottom: 10px; line-height: 1.4;
}
.logo-card-footer {
  margin-top: auto;
  display: flex; align-items: center; justify-content: space-between; gap: 8px;
  padding-top: 10px; border-top: 1px dashed #edf1f5;
}
.logo-card-price { font-size: 1rem; font-weight: 800; color: #11998e; }
.btn-logo-view {
  background: linear-gradient(135deg, #2d1b69, #11998e);
  color: #fff; border: none;
  border-radius: 9px; padding: 7px 18px; font-size: .82rem; font-weight: 700;
  white-space: nowrap; transition: opacity .15s, transform .15s;
}
.btn-logo-view:hover { opacity: .88; color: #fff; transform: translateY(-1px); }

/* badge "Nổi bật" */
.logo-badge-hot {
  position: absolute; top: 10px; left: 10px;
  background: #e94560; color: #fff;
  border-radius: 8px; padding: 3px 10px;
  font-size: .72rem; font-weight: 700;
  z-index: 2;
}

[data-bs-theme="dark"] .logo-card { background: #1c1c2e; border-color: #2d2d44; }
[data-bs-theme="dark"] .logo-card-name { color: #e9edf0; }
[data-bs-theme="dark"] .logo-card-img { background: #15152a; }
[data-bs-theme="dark"] .logo-card-footer { border-color: #2d2d44; }
</style>

{{-- Hero --}}
<div class="container-xxl pt-5 px-5">
  <div class="page-hero-banner">
    <span class="page-hero-badge">🎨 Dịch vụ thiết kế</span>
    <h1>Thiết Kế Logo Chuyên Nghiệp</h1>
    <p>Logo độc quyền, sáng tạo – nhận file vector, PNG với độ phân giải cao trong thời gian ngắn.</p>
    <div class="hero-chips">
      <span class="hero-chip">🖼 File Vector</span>
      <span class="hero-chip">✏️ Thiết kế riêng</span>
      <span class="hero-chip">🔄 Chỉnh sửa miễn phí</span>
      <span class="hero-chip">📦 Bàn giao nhanh</span>
    </div>
  </div>
</div>

{{-- Grid --}}
<div id="kt_content_container" class="d-flex flex-column-fluid align-items-start container-xxl">
  <div class="content flex-row-fluid" id="kt_content">

    <div class="d-flex align-items-center justify-content-between mb-5">
      <div>
        <h2 style="font-size:1.15rem;font-weight:800;color:#1e1e2d;margin:0;">🎨 Danh sách dịch vụ logo</h2>
        <div style="font-size:.82rem;color:#a1a5b7;margin-top:3px;">{{ $logo->count() }} dịch vụ đang có sẵn</div>
      </div>
    </div>

    @if($logo->count())
    <div class="row g-4">
      @foreach ($logo as $value)
      @php
        $logoSlug = \App\Models\Slug::of('logo', $value->id) ?? $value->id;
        $price    = $value->price - $value->price * $value->ck / 100;
      @endphp
      <div class="col-6 col-sm-6 col-md-4 col-lg-3">
        <div class="logo-card">
          <div class="logo-card-img">
            @if($loop->index < 3)
              <span class="logo-badge-hot">🔥 Hot</span>
            @endif
            <img src="{{ img_url($value->image) }}" alt="{{ $value->name }}"
                 onerror="this.src='{{ asset('assets/media/svg/files/ai.svg') }}'">
            <div class="img-overlay">
              <a href="{{ route('logo.view', $logoSlug) }}" class="logo-preview-btn">👁 Xem chi tiết</a>
            </div>
          </div>
          <div class="logo-card-body">
            <a href="{{ route('logo.view', $logoSlug) }}" class="logo-card-name text-decoration-none">{{ $value->name }}</a>
            <div class="logo-card-footer">
              <span class="logo-card-price">{{ number_format($price, 0, ',', '.') }}đ</span>
              <a href="{{ route('logo.view', $logoSlug) }}" class="btn-logo-view">Xem Ngay</a>
            </div>
          </div>
        </div>
      </div>
      @endforeach
    </div>
    @else
    <div style="text-align:center;padding:60px 20px;">
      <div style="font-size:3.5rem;margin-bottom:16px;">🎨</div>
      <h4 style="font-weight:700;color:#1e1e2d;margin-bottom:8px;">Chưa có dịch vụ logo</h4>
      <p style="color:#a1a5b7;font-size:.9rem;">Vui lòng quay lại sau hoặc liên hệ admin.</p>
    </div>
    @endif

  </div>
</div>
@endsection
