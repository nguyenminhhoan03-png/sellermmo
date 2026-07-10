@php use App\Helpers\Helper; @endphp
@php use App\Models\User; @endphp
@extends('layouts.app')
@section('title', 'Trang chủ – ' . (setting('site_name') ?? config('app.name')))
@section('content')

<style>
/* ===== HERO ===== */
.home-hero {
  background: linear-gradient(135deg, #1a1a2e 0%, #16213e 40%, #0f3460 70%, #e94560 100%);
  background-size: 300% 300%;
  animation: heroGradient 10s ease infinite;
  border-radius: 20px;
  padding: 52px 40px;
  margin-bottom: 32px;
  position: relative;
  overflow: hidden;
}
@keyframes heroGradient {
  0% { background-position: 0% 50%; }
  50% { background-position: 100% 50%; }
  100% { background-position: 0% 50%; }
}
@keyframes float1 {
  0% { transform: translateY(0) scale(1); }
  50% { transform: translateY(15px) scale(1.05); }
  100% { transform: translateY(0) scale(1); }
}
@keyframes float2 {
  0% { transform: translateY(0) translateX(0) scale(1); }
  50% { transform: translateY(-15px) translateX(15px) scale(1.1); }
  100% { transform: translateY(0) translateX(0) scale(1); }
}
.home-hero::before {
  content: '';
  position: absolute;
  top: -60px; right: -60px;
  width: 320px; height: 320px;
  border-radius: 50%;
  background: rgba(233,69,96,.18);
  pointer-events: none;
  animation: float1 6s ease-in-out infinite;
}
.home-hero::after {
  content: '';
  position: absolute;
  bottom: -80px; left: -40px;
  width: 260px; height: 260px;
  border-radius: 50%;
  background: rgba(255,255,255,.05);
  pointer-events: none;
  animation: float2 7s ease-in-out infinite;
}
.home-hero .hero-badge {
  display: inline-block;
  background: rgba(255,255,255,.15);
  color: #fff;
  border: 1px solid rgba(255,255,255,.3);
  border-radius: 20px;
  padding: 4px 16px;
  font-size: 0.82rem;
  letter-spacing: .5px;
  margin-bottom: 14px;
  backdrop-filter: blur(4px);
}
.home-hero h1 { color: #fff; font-size: 2.1rem; font-weight: 800; line-height: 1.25; }
.home-hero p { color: rgba(255,255,255,.75); font-size: 1rem; margin-top: 10px; }
.hero-stat { text-align: center; }
.hero-stat .num { font-size: 1.6rem; font-weight: 800; color: #fff; }
.hero-stat .label { font-size: 0.78rem; color: rgba(255,255,255,.6); }
.hero-divider { width: 1px; background: rgba(255,255,255,.2); height: 48px; }
.hero-cta { gap: 10px; margin-top: 24px; flex-wrap: wrap; }
.btn-hero-primary {
  background: #e94560; color: #fff; border: none;
  border-radius: 10px; padding: 10px 28px; font-weight: 700;
  box-shadow: 0 4px 18px rgba(233,69,96,.45);
  transition: transform .15s, box-shadow .15s;
}
.btn-hero-primary:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(233,69,96,.55); color:#fff; }
.btn-hero-outline {
  background: rgba(255,255,255,.12); color: #fff;
  border: 1px solid rgba(255,255,255,.35);
  border-radius: 10px; padding: 10px 24px; font-weight: 600;
  backdrop-filter: blur(4px);
  transition: background .15s;
}
.btn-hero-outline:hover { background: rgba(255,255,255,.22); color: #fff; }

/* ===== CATEGORY SHORTCUTS ===== */
.cat-grid { display: grid; grid-template-columns: repeat(6,1fr); gap: 14px; margin-bottom: 32px; }
@media(max-width:991px){ .cat-grid{ grid-template-columns: repeat(3,1fr); } }
@media(max-width:575px){ .cat-grid{ grid-template-columns: repeat(2,1fr); } }
.cat-card {
  background: #fff;
  border-radius: 16px;
  padding: 20px 12px 16px;
  text-align: center;
  text-decoration: none;
  border: 1px solid #edf1f5;
  transition: transform .18s, box-shadow .18s;
  box-shadow: 0 2px 10px rgba(0,0,0,.06);
}
.cat-card:hover { transform: translateY(-4px); box-shadow: 0 8px 28px rgba(0,0,0,.12); }
.cat-icon {
  width: 56px; height: 56px; border-radius: 16px;
  display: flex; align-items: center; justify-content: center;
  font-size: 1.5rem; margin: 0 auto 10px;
}
.cat-card .cat-name { font-weight: 700; font-size: .9rem; color: #1e1e2d; margin-bottom: 2px; }
.cat-card .cat-desc { font-size: .75rem; color: #a1a5b7; }

/* ===== DOMAIN STRIP ===== */
.domain-strip {
  background: #fff;
  border-radius: 16px;
  border: 1px solid #edf1f5;
  padding: 20px 24px;
  margin-bottom: 32px;
  box-shadow: 0 2px 10px rgba(0,0,0,.05);
}
.domain-strip-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 16px; }
.domain-strip-header h3 { font-weight: 800; font-size: 1.1rem; color: #1e1e2d; margin: 0; }
.domain-item-pill {
  display: flex; align-items: center; justify-content: space-between;
  background: #f9fafc; border-radius: 12px; padding: 10px 16px;
  border: 1px solid #edf1f5; transition: border-color .15s, box-shadow .15s;
  text-decoration: none; cursor: pointer;
}
.domain-item-pill:hover { border-color: #e94560; box-shadow: 0 2px 10px rgba(233,69,96,.12); }
.domain-ext { font-weight: 800; font-size: 1rem; color: #1e1e2d; }
.domain-price-new { font-weight: 700; color: #e94560; font-size: .92rem; }
.domain-price-old { text-decoration: line-through; color: #a1a5b7; font-size: .78rem; }
.domain-badge-sale { background: #fff0f3; color: #e94560; font-size:.72rem; font-weight:700; border-radius:8px; padding:2px 8px; }

/* ===== SECTION HEADER ===== */
.section-header { display: flex; align-items: flex-end; justify-content: space-between; margin-bottom: 20px; flex-wrap: wrap; gap: 10px; }
.section-title-main { font-size: 1.25rem; font-weight: 800; color: #1e1e2d; margin: 0; }
.section-subtitle { font-size: .82rem; color: #a1a5b7; margin-top: 3px; }
.view-all-link { font-size: .85rem; font-weight: 600; color: #e94560; text-decoration: none; white-space: nowrap; }
.view-all-link:hover { color: #c73652; }

/* ===== FILTER TABS ===== */
.filter-tabs { display: flex; gap: 8px; flex-wrap: wrap; }
.filter-tab {
  display: inline-flex; align-items: center; gap: 5px;
  padding: 6px 16px; border-radius: 30px; font-size:.82rem; font-weight:600; cursor:pointer;
  border: 1.5px solid #e4e6ef; background: #fff; color: #5e6278;
  transition: all .18s; white-space: nowrap;
}
.filter-tab .ftab-icon { font-size: .9rem; }
.filter-tab.active { background: #e94560; border-color: #e94560; color: #fff; box-shadow: 0 3px 12px rgba(233,69,96,.3); }
.filter-tab:hover:not(.active) { background: #fff0f3; border-color: #e94560; color: #e94560; }
.filter-tab .ftab-count {
  background: rgba(0,0,0,.08); border-radius: 20px;
  padding: 1px 7px; font-size: .72rem; font-weight: 700;
  transition: background .18s;
}
.filter-tab.active .ftab-count { background: rgba(255,255,255,.25); }

/* Filter loading state */
.product-section-loading { opacity: .5; pointer-events: none; transition: opacity .2s; }
.filter-tab.loading { opacity: .6; cursor: wait; }

/* ===== PRODUCT CARDS ===== */
.product-card {
  background: #fff; border-radius: 16px;
  border: 1px solid #edf1f5; overflow: hidden;
  transition: transform .18s, box-shadow .18s;
  box-shadow: 0 2px 8px rgba(0,0,0,.06);
  height: 100%;
  display: flex; flex-direction: column;
}
.product-card:hover { transform: translateY(-4px); box-shadow: 0 10px 30px rgba(0,0,0,.13); }
.product-img-wrap { position: relative; overflow: hidden; }
.product-img-wrap img { width:100%; aspect-ratio:16/9; object-fit:cover; transition: transform .25s; }
.product-card:hover .product-img-wrap img { transform: scale(1.04); }
.product-card-body { padding: 12px 14px; flex: 1; display: flex; flex-direction: column; }
.product-name { font-weight: 700; font-size: .9rem; color: #1e1e2d; margin-bottom: 6px; display: -webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden; }
.product-seller { display: flex; align-items: center; gap: 6px; margin-bottom: 8px; }
.product-seller img { width:22px; height:22px; border-radius:50%; object-fit:cover; }
.product-seller span { font-size: .77rem; color: #a1a5b7; }
.product-footer { margin-top: auto; display: flex; align-items: center; justify-content: space-between; gap: 8px; }
.product-price { font-size: .92rem; font-weight: 800; color: #e94560; }
.btn-buy-now { background: #e94560; color: #fff; border: none; border-radius: 8px; padding: 5px 14px; font-size: .8rem; font-weight: 700; white-space: nowrap; transition: background .15s; }
.btn-buy-now:hover { background: #c73652; color: #fff; }

/* ===== AI CARDS ===== */
.ai-card {
  background: #fff; border-radius: 16px;
  border: 1px solid #edf1f5; overflow: hidden;
  transition: transform .18s, box-shadow .18s;
  box-shadow: 0 2px 8px rgba(0,0,0,.06);
  height: 100%; display: flex; flex-direction: column;
}
.ai-card:hover { transform: translateY(-4px); box-shadow: 0 10px 30px rgba(0,0,0,.13); }
.ai-img-wrap { position: relative; overflow: hidden; display: block; }
.ai-img-wrap img { width: 100%; aspect-ratio: 1/1; object-fit: cover; transition: transform .25s; display: block; }
.ai-card:hover .ai-img-wrap img { transform: scale(1.04); }
.ai-card-body { padding: 10px 12px 6px; flex: 1; display: flex; flex-direction: column; }
.ai-name { font-weight: 700; font-size: .88rem; color: #1e1e2d; margin-bottom: 3px; }
.ai-info { font-size: .75rem; color: #a1a5b7; display: -webkit-box; -webkit-line-clamp:1; -webkit-box-orient:vertical; overflow:hidden; }
.ai-footer { margin-top: auto; padding: 8px 12px 12px; display: flex; align-items: center; justify-content: space-between; gap: 6px; }
.ai-price { font-size: .82rem; font-weight: 800; color: #1e1e2d; }

/* ===== TRUST ===== */
.trust-grid { display: grid; grid-template-columns: repeat(4,1fr); gap: 16px; }
@media(max-width:991px){ .trust-grid{ grid-template-columns: repeat(2,1fr); } }
@media(max-width:575px){ .trust-grid{ grid-template-columns: 1fr; } }
.trust-card { background: #fff; border-radius: 16px; padding: 24px 20px; border: 1px solid #edf1f5; box-shadow: 0 2px 8px rgba(0,0,0,.05); text-align: center; }
.trust-icon { font-size: 2rem; margin-bottom: 12px; }
.trust-card h5 { font-weight: 800; font-size: .95rem; color: #1e1e2d; margin-bottom: 6px; }
.trust-card p { font-size: .82rem; color: #7e8299; margin: 0; }

/* 5-col grid */
@media(min-width:1200px){
  .col-xl-2-4 { flex: 0 0 20%; max-width: 20%; padding: 0 8px; }
}

/* Loading skeleton */
.skeleton { background: linear-gradient(90deg,#f0f0f0 25%,#e0e0e0 50%,#f0f0f0 75%); background-size: 200% 100%; animation: shimmer 1.4s infinite; border-radius: 10px; }
@keyframes shimmer { 0%{background-position:200% 0} 100%{background-position:-200% 0} }

[data-bs-theme="dark"] .cat-card,
[data-bs-theme="dark"] .domain-strip,
[data-bs-theme="dark"] .product-card,
[data-bs-theme="dark"] .ai-card,
[data-bs-theme="dark"] .trust-card { background: #1c1c2e; border-color: #2d2d44; }
[data-bs-theme="dark"] .cat-card .cat-name,
[data-bs-theme="dark"] .product-name,
[data-bs-theme="dark"] .ai-name,
[data-bs-theme="dark"] .trust-card h5,
[data-bs-theme="dark"] .section-title-main { color: #e9edf0; }
[data-bs-theme="dark"] .domain-item-pill { background: #15152a; border-color: #2d2d44; }
[data-bs-theme="dark"] .domain-ext { color: #e9edf0; }
[data-bs-theme="dark"] .filter-tab { background: #1c1c2e; border-color: #2d2d44; color: #a1a5b7; }
</style>

<div id="kt_content_container" class="d-flex flex-column-fluid align-items-start container-xxl">
  <div class="content flex-row-fluid" id="kt_content">

    {{-- ═══════════════════════════════════ HERO ═══════════════════════════════════ --}}
    <div id="heroCarousel" class="carousel slide mb-8" data-bs-ride="carousel" data-bs-interval="4000" data-bs-wrap="true">
      <div class="carousel-indicators">
        <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active" aria-current="true"></button>
        <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1"></button>
        <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="2"></button>
      </div>
      <div class="carousel-inner" style="border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,.08);">
        <div class="carousel-item active">
          <div class="home-hero mb-0">
            <div class="row align-items-center g-4">
              <div class="col-lg-7">
                <span class="hero-badge">🔥 #1 Marketplace Việt Nam</span>
                <h1>Mua &amp; Bán Dịch Vụ Số<br>Uy Tín – Giá Tốt Nhất</h1>
                <p>Mã nguồn, tài khoản AI, tên miền, hosting &amp; thiết kế logo – tất cả trong một nơi duy nhất.</p>
                <div class="d-flex hero-cta">
                  <a href="/" class="btn-hero-primary">
                    <i class="fas fa-th-large me-2"></i>Khám phá ngay
                  </a>
                  <a href="{{ route('web.index') }}" class="btn-hero-outline">
                    <i class="fas fa-globe me-2"></i>Tạo Website
                  </a>
                </div>
              </div>
              <div class="col-lg-5">
                <div class="d-flex align-items-center justify-content-lg-end justify-content-start gap-4 flex-wrap">
                  <div class="hero-stat">
                    <div class="num">500+</div>
                    <div class="label">Sản phẩm</div>
                  </div>
                  <div class="hero-divider d-none d-sm-block"></div>
                  <div class="hero-stat">
                    <div class="num">1.200+</div>
                    <div class="label">Khách hàng</div>
                  </div>
                  <div class="hero-divider d-none d-sm-block"></div>
                  <div class="hero-stat">
                    <div class="num">24/7</div>
                    <div class="label">Hỗ trợ</div>
                  </div>
                  <div class="hero-divider d-none d-sm-block"></div>
                  <div class="hero-stat">
                    <div class="num">100%</div>
                    <div class="label">Uy tín</div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="carousel-item">
          <div class="home-hero mb-0" style="background: linear-gradient(135deg, #2b1055 0%, #7597de 100%);">
            <div class="row align-items-center g-4">
              <div class="col-lg-7">
                <span class="hero-badge" style="background: rgba(255,255,255,.2); color: #fff; border-color: rgba(255,255,255,.4);">🚀 Tăng Tốc Kinh Doanh</span>
                <h1>Hosting &amp; Tên Miền<br>Tốc Độ Cao - Ổn Định</h1>
                <p>Khởi tạo website nhanh chóng với hệ thống Hosting SSD siêu tốc và đăng ký tên miền giá rẻ.</p>
                <div class="d-flex hero-cta">
                  <a href="{{ route('hosting.index') }}" class="btn-hero-primary" style="background: #ffb800; color: #1e1e2d; box-shadow: 0 4px 18px rgba(255,184,0,.45);">
                    <i class="fas fa-server me-2"></i>Mua Hosting
                  </a>
                  <a href="{{ route('domain.index') }}" class="btn-hero-outline">
                    <i class="fas fa-globe me-2"></i>Tìm Tên Miền
                  </a>
                </div>
              </div>
              <div class="col-lg-5 text-center">
                 <div style="font-size: 8rem; line-height: 1;">🚀</div>
              </div>
            </div>
          </div>
        </div>
        <div class="carousel-item">
          <div class="home-hero mb-0" style="background: linear-gradient(135deg, #0f2027 0%, #203a43 50%, #2c5364 100%);">
            <div class="row align-items-center g-4">
              <div class="col-lg-7">
                <span class="hero-badge" style="background: rgba(0,255,136,.15); color: #00ff88; border-color: rgba(0,255,136,.3);">🤖 Nâng Tầm Hiệu Suất</span>
                <h1>Tài Khoản AI Premium<br>Trợ Lý Ảo Đắc Lực</h1>
                <p>Nâng cao năng suất công việc với ChatGPT Plus, Claude, Midjourney và nhiều công cụ AI hàng đầu.</p>
                <div class="d-flex hero-cta">
                  <a href="{{ route('ai-account.index') }}" class="btn-hero-primary" style="background: #00ff88; color: #1e1e2d; box-shadow: 0 4px 18px rgba(0,255,136,.4);">
                    <i class="fas fa-robot me-2"></i>Khám Phá AI
                  </a>
                  <a href="{{ route('ai-account.index') }}" class="btn-hero-outline" style="border-color: rgba(255,255,255,.3); color: #fff;">
                    <i class="fas fa-bolt me-2"></i>Xem Bảng Giá
                  </a>
                </div>
              </div>
              <div class="col-lg-5 text-center">
                 <div style="font-size: 8rem; line-height: 1;">🤖</div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev" style="width: 5%;">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next" style="width: 5%;">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
      </button>
    </div>

    {{-- ═══════════════════════ CATEGORY SHORTCUTS ═══════════════════════ --}}
    <div class="cat-grid mb-8">
      <a href="/" class="cat-card">
        <div class="cat-icon" style="background:#fff0f3;">💻</div>
        <div class="cat-name">Mã Nguồn</div>
        <div class="cat-desc">Website, App</div>
      </a>
      <a href="{{ route('ai-account.index') }}" class="cat-card">
        <div class="cat-icon" style="background:#f0f0ff;">🤖</div>
        <div class="cat-name">Tài Khoản AI</div>
        <div class="cat-desc">ChatGPT, Claude…</div>
      </a>
      <a href="{{ route('domain.index') }}" class="cat-card">
        <div class="cat-icon" style="background:#f0fff4;">🌐</div>
        <div class="cat-name">Tên Miền</div>
        <div class="cat-desc">.com .vn .net…</div>
      </a>
      <a href="{{ route('hosting.index') }}" class="cat-card">
        <div class="cat-icon" style="background:#fff7e6;">🖥️</div>
        <div class="cat-name">Hosting</div>
        <div class="cat-desc">SSD – Nhanh – Ổn</div>
      </a>
      <a href="{{ route('logo.index') }}" class="cat-card">
        <div class="cat-icon" style="background:#f3f0ff;">🎨</div>
        <div class="cat-name">Thiết Kế Logo</div>
        <div class="cat-desc">Chuyên nghiệp</div>
      </a>
      <a href="{{ route('web.index') }}" class="cat-card">
        <div class="cat-icon" style="background:#e8f9ff;">🚀</div>
        <div class="cat-name">Tạo Website</div>
        <div class="cat-desc">Nhanh – Chuẩn SEO</div>
      </a>
    </div>

    {{-- ═══════════════════════ DOMAIN STRIP ═══════════════════════ --}}
    @if($domains->count())
    <div class="domain-strip mb-8">
      <div class="domain-strip-header">
        <div>
          <h3>🌐 Tên Miền Giá Tốt</h3>
          <div style="font-size:.8rem;color:#a1a5b7;margin-top:2px;">Đăng ký tên miền nhanh chóng, giá cạnh tranh</div>
        </div>
        <a href="{{ route('domain.index') }}" class="view-all-link">Xem tất cả →</a>
      </div>
      <div class="row g-3">
        @foreach($domains->take(12) as $domain)
        <div class="col-6 col-md-4 col-lg-2">
          <a href="{{ route('domain.index') }}" class="domain-item-pill d-block text-decoration-none">
            <div class="d-flex align-items-center justify-content-between mb-1">
              <span class="domain-ext">.{{ $domain->name }}</span>
              <span class="domain-badge-sale">-{{ $domain->sale }}%</span>
            </div>
            <div>
              <span class="domain-price-new">{{ number_format($domain->price * (1 - $domain->sale / 100), 0, ',', '.') }}₫</span>
              <span class="domain-price-old ms-1">{{ number_format($domain->price, 0, ',', '.') }}₫</span>
            </div>
            <div style="font-size:.72rem;color:#a1a5b7;margin-top:2px;">/Năm</div>
          </a>
        </div>
        @endforeach
      </div>
    </div>
    @endif

    {{-- ═══════════════════════ SẢN PHẨM NỔI BẬT ═══════════════════════ --}}
    @php
      $productCategories = \App\Models\Product::CATEGORIES;
      $categoryCounts = \App\Models\Product::where('status', 1)
          ->selectRaw('category, COUNT(*) as cnt')
          ->groupBy('category')
          ->pluck('cnt', 'category')
          ->toArray();
      $totalProducts = array_sum($categoryCounts);
    @endphp
    <div class="section-header">
      <div>
        <h2 class="section-title-main">💎 Sản Phẩm Nổi Bật</h2>
        <div class="section-subtitle">Mã nguồn chất lượng, website hoàn chỉnh giá tốt nhất</div>
      </div>
      <a href="/" class="view-all-link">Xem tất cả →</a>
    </div>

    <div class="filter-tabs filters-btns-product mb-4">
      <button class="filter-tab active" data-category="all">
        <span class="ftab-icon">🔥</span> Tất cả
        <span class="ftab-count">{{ $totalProducts }}</span>
      </button>
      @foreach($productCategories as $key => $cat)
      <button class="filter-tab" data-category="{{ $key }}">
        <span class="ftab-icon">{{ $cat['icon'] }}</span> {{ $cat['label'] }}
        <span class="ftab-count">{{ $categoryCounts[$key] ?? 0 }}</span>
      </button>
      @endforeach
    </div>

    <div class="mb-8">
      <div class="row js-product-list g-3">
        <div class="col-12 post_ajax_loader hk-loader-main mb-3">
          <div class="row g-3">
            @for($i=0;$i<10;$i++)
            <div class="col-6 col-sm-4 col-md-3 col-xl-2-4">
              <div class="skeleton" style="height:180px;border-radius:16px;"></div>
              <div class="skeleton mt-2" style="height:16px;width:80%;"></div>
              <div class="skeleton mt-1" style="height:12px;width:50%;"></div>
            </div>
            @endfor
          </div>
        </div>
      </div>
      <div class="d-flex justify-content-center mt-4">
        {{ $products->appends(['ai_page' => request('ai_page')])->links('vendor.pagination.custom') }}
      </div>
    </div>

    {{-- ═══════════════════════ TAIKHOAN AI ═══════════════════════ --}}
    <div class="section-header" id="ai-accounts-section">
      <div>
        <h2 class="section-title-main">🤖 Tài Khoản AI Giá Rẻ</h2>
        <div class="section-subtitle">ChatGPT, Claude, Gemini, Midjourney &amp; nhiều hơn nữa</div>
      </div>
      <a href="{{ route('ai-account.index') }}" class="view-all-link">Xem tất cả →</a>
    </div>

    @php $totalAi = array_sum($aiCategoryCounts) + ($aiCategoryCounts[0] ?? 0); @endphp
    <div class="filter-tabs filters-btns-ai mb-4">
      <button class="filter-tab active" data-ai-cat="all">
        <span class="ftab-icon">🤖</span> Tất cả
        <span class="ftab-count">{{ $ai->total() }}</span>
      </button>
      @foreach($aiCategories as $cat)
      <button class="filter-tab" data-ai-cat="{{ $cat->id }}">
        <span class="ftab-icon">
          @php
            $icons = ['chatgpt'=>'💬','claude'=>'✨','gemini'=>'💎','midjourney'=>'🎨','canva-ai'=>'🖌️'];
            echo $icons[$cat->slug] ?? '🤖';
          @endphp
        </span>
        {{ $cat->name }}
        <span class="ftab-count">{{ $aiCategoryCounts[$cat->id] ?? 0 }}</span>
      </button>
      @endforeach
    </div>

    <div class="mb-8">
      <div class="row g-3" id="ai-cards-row">
        @forelse ($ai as $item)
        @php $aiSlug = \App\Models\Slug::of('ai', $item->id) ?? $item->id; @endphp
        <div class="col-6 col-sm-4 col-md-3 col-xl-2 ai-card-col" data-ai-cat="{{ $item->category_id ?? 0 }}">
          <div class="ai-card">
            <a href="{{ route('ai-account.detail', $aiSlug) }}" class="ai-img-wrap"
              @if(!$item->image) style="background:linear-gradient(135deg,#f0f0ff 0%,#e8e0ff 100%);aspect-ratio:1/1;display:flex;align-items:center;justify-content:center;" @endif>
              @if($item->image)
                <img src="{{ img_url($item->image) }}" alt="{{ $item->name }}" loading="lazy" decoding="async">
              @else
                <div style="text-align:center;padding:16px;">
                  <div style="font-size:2.8rem;margin-bottom:6px;">🤖</div>
                  <div style="font-size:.75rem;font-weight:600;color:#7c6fcd;">{{ Str::limit($item->name, 20) }}</div>
                </div>
              @endif
            </a>
            <div class="ai-card-body">
              <a href="{{ route('ai-account.detail', $aiSlug) }}" class="ai-name text-decoration-none d-block text-truncate">{{ $item->name }}</a>
              <div class="ai-info text-muted">{{ $item->account_info ?? 'Sẵn sàng cung cấp' }}</div>
            </div>
            <div class="ai-footer">
              <div class="ai-price">
                @if($item->variant_min_price > 0 || $item->variant_max_price > 0)
                  {{ number_format($item->variant_min_price,0,',','.') }}₫
                  @if($item->variant_max_price > $item->variant_min_price)
                    <span style="font-size:.75rem;font-weight:500;color:#a1a5b7;"> – {{ number_format($item->variant_max_price,0,',','.') }}₫</span>
                  @endif
                @else
                  <span style="color:#a1a5b7;font-size:.82rem;">Liên hệ</span>
                @endif
              </div>
              <a href="{{ route('ai-account.detail', $aiSlug) }}" class="btn-buy-now">Mua</a>
            </div>
          </div>
        </div>
        @empty
        <div class="col-12">
          <div class="alert alert-light text-center border" style="border-radius:16px;">Chưa có tài khoản AI để hiển thị.</div>
        </div>
        @endforelse
      </div>

      {{-- AI empty state khi filter không có kết quả --}}
      <div id="ai-empty-state" class="text-center py-5 d-none">
        <div style="font-size:3rem;margin-bottom:12px;">🤖</div>
        <p style="color:#a1a5b7;font-size:.95rem;">Chưa có tài khoản AI nào trong danh mục này.</p>
      </div>

      <div class="d-flex justify-content-center mt-4">
        {{ $ai->appends(['products_page' => request('products_page')])->links('vendor.pagination.custom') }}
      </div>
    </div>

    {{-- ═══════════════════════ WEBSITE ═══════════════════════ --}}
    @if(isset($webs) && $webs->count() > 0)
    <div class="section-header mt-8">
      <div>
        <h2 class="section-title-main">🌐 Tạo Website Giá Rẻ</h2>
        <div class="section-subtitle">Sở hữu website chuyên nghiệp chỉ với vài cú click chuột</div>
      </div>
      <a href="{{ route('web.index') }}" class="view-all-link">Xem tất cả →</a>
    </div>
    <div class="mb-8">
      <div class="row g-3">
        @foreach ($webs as $item)
        @php $webSlug = \App\Models\Slug::of('web', $item->id) ?? $item->id; @endphp
        <div class="col-6 col-md-4 col-xl-3">
          <div class="product-card">
            <a href="{{ route('web.view', $webSlug) }}" class="product-img-wrap">
              <img src="{{ img_url($item->image) }}" alt="{{ $item->name }}">
            </a>
            <div class="product-card-body">
              <a href="{{ route('web.view', $webSlug) }}" class="product-name text-decoration-none">{{ $item->name }}</a>
              <div class="product-footer mt-auto pt-3">
                <div class="product-price">{{ number_format($item->price, 0, ',', '.') }}₫ <span style="font-size:0.75rem; color:#a1a5b7; font-weight:normal;">/tháng</span></div>
                <a href="{{ route('web.view', $webSlug) }}" class="btn-buy-now">Tạo Ngay</a>
              </div>
            </div>
          </div>
        </div>
        @endforeach
      </div>
    </div>
    @endif

    {{-- ═══════════════════════ HOSTING ═══════════════════════ --}}
    @if(isset($hostings) && $hostings->count() > 0)
    <div class="section-header mt-8">
      <div>
        <h2 class="section-title-main">🖥️ Hosting SSD Siêu Tốc</h2>
        <div class="section-subtitle">Dịch vụ lưu trữ tốc độ cao, ổn định và an toàn</div>
      </div>
      <a href="{{ route('hosting.index') }}" class="view-all-link">Xem tất cả →</a>
    </div>
    <div class="mb-8">
      <div class="row g-3">
        @foreach ($hostings as $item)
        <div class="col-6 col-md-4 col-xl-3">
          <div class="product-card" style="border-top: 4px solid #e94560;">
            <div class="product-card-body text-center pt-4">
              <div style="font-size: 2.5rem; margin-bottom: 10px;">☁️</div>
              <h3 class="product-name" style="font-size: 1.1rem; text-transform: uppercase;">{{ $item->package_name }}</h3>
              <div style="color: #a1a5b7; font-size: 0.85rem; margin-bottom: 15px;">Dung lượng: <strong class="text-gray-900">{{ $item->disk }} GB</strong></div>
              <div class="product-footer mt-auto pt-3 justify-content-center">
                <div class="product-price fs-4">{{ number_format($item->price, 0, ',', '.') }}₫ <span style="font-size:0.75rem; color:#a1a5b7; font-weight:normal;">/tháng</span></div>
              </div>
              <a href="{{ route('hosting.index') }}" class="btn-buy-now w-100 mt-3 py-2">Đăng Ký</a>
            </div>
          </div>
        </div>
        @endforeach
      </div>
    </div>
    @endif

    {{-- ═══════════════════════ TRUST SECTION ═══════════════════════ --}}
    <div class="trust-grid mb-6">
      <div class="trust-card">
        <div class="trust-icon">🔒</div>
        <h5>Độ An Toàn Cao</h5>
        <p>Giao dịch được bảo mật, tài khoản được xác thực đa lớp.</p>
      </div>
      <div class="trust-card">
        <div class="trust-icon">⭐</div>
        <h5>Dịch Vụ Uy Tín</h5>
        <p>Hàng nghìn khách hàng tin dùng – uy tín là số một.</p>
      </div>
      <div class="trust-card">
        <div class="trust-icon">⚡</div>
        <h5>Xử Lý Tức Thì</h5>
        <p>Hệ thống tự động, nhận sản phẩm ngay sau khi thanh toán.</p>
      </div>
      <div class="trust-card">
        <div class="trust-icon">💬</div>
        <h5>Hỗ Trợ 24/7</h5>
        <p>Đội ngũ hỗ trợ online mọi lúc, kể cả ngày lễ và cuối tuần.</p>
      </div>
    </div>

  </div>
</div>

{{-- ═══════════════════════ MODALS ═══════════════════════ --}}
@if (auth()->check() && auth()->user()->loai != 'demo')
  <div class="modal fade" tabindex="-1" id="kt_modal_1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header py-3">
          <h3 class="modal-title">THÔNG BÁO</h3>
          <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
            <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
          </div>
        </div>
        <div class="modal-body">
          {!! base64_decode(Helper::getNotice('modal_dashboard')) !!}
          <div class="d-grid gap-2">
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Đóng thông báo</button>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const loadingToast = Wstoast.loading('Đang tải dữ liệu...!', { duration: -1 });
      setTimeout(() => {
        loadingToast.close();
        const myModal = new bootstrap.Modal(document.getElementById('kt_modal_1'), { backdrop: 'true', keyboard: true });
        myModal.show();
      }, 1500);
    });
  </script>
@endif

@if (auth()->check() && auth()->user()->loai == 'demo')
  <div class="modal fade" tabindex="-1" id="kt_modal_1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header py-3">
          <h3 class="modal-title">THÔNG BÁO</h3>
          <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
            <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
          </div>
        </div>
        <div class="modal-body">
          <div class="alert alert-primary d-flex align-items-center p-5">
            <i class="bi bi-megaphone-fill fs-2x me-5 text-primary"></i>
            <div class="d-flex flex-column">
              <ol>
                <li><strong style="color:rgb(230,0,0)">Bạn đang sử dụng tài khoản demo để xem các dịch vụ trong hệ thống của chúng tôi</strong></li>
                <li><strong style="color:rgb(0,138,0)">Vì đây là tài khoản demo bạn không thể sử dụng hay mua bất cứ cái gì trên hệ thống.</strong></li>
                <li>Chúng tôi xin cảm ơn quý khách đã xem và hy vọng bạn là 1 trong những khách hàng tiềm năng.</li>
              </ol>
            </div>
          </div>
          <div class="d-grid gap-2">
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Đóng thông báo</button>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const loadingToast = Wstoast.loading('Đang tải dữ liệu...!', { duration: -1 });
      setTimeout(() => {
        loadingToast.close();
        const myModal = new bootstrap.Modal(document.getElementById('kt_modal_1'), { backdrop: 'true', keyboard: true });
        myModal.show();
      }, 1500);
    });
  </script>
@endif

<script src="/assets/js/muabanwebsite.js?v={{ time() }}" defer></script>

@endsection
@if ($errors->any())
  <script>$swal('error', '{{ $errors->first() }}')</script>
@endif
@if (session('success'))
  <script>$swal('success', '{{ session("success") }}')</script>
@elseif (session('error'))
  <script>$swal('error', '{{ session("error") }}')</script>
@endif
@yield('script')
