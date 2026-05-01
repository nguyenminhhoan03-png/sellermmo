@php use App\Helpers\Helper; @endphp
@extends('layouts.app')
@section('title', $pageTitle)
@section('content')
<style>
.min-vh-20 {
    min-height: 20vh !important;
}
.dvr-hero {
    border-radius: 16px;
    background: linear-gradient(135deg, #1f1c2c 0%, #928dab 100%);
    background-size: cover;
    background-position: center;
}
[data-bs-theme="dark"] .dvr-hero {
    background: linear-gradient(135deg, #0f0c1b 0%, #201a30 100%);
}
.search-group .form-control {
    border-radius: 12px 0 0 12px;
    height: 48px;
    border: 1px solid rgba(255, 255, 255, 0.25);
    background: rgba(255, 255, 255, 0.1);
    color: #fff;
}
.search-group .form-control::placeholder {
    color: rgba(255, 255, 255, 0.6);
}
.search-group .btn {
    height: 48px;
    border-radius: 0 12px 12px 0;
    font-weight: 700;
}

/* ===== FILTER TABS ===== */
.filter-tabs { display: flex; gap: 8px; flex-wrap: wrap; }
.filter-tab {
  display: inline-flex; align-items: center; gap: 5px;
  padding: 8px 18px; border-radius: 30px; font-size:.82rem; font-weight:600; cursor:pointer;
  border: 1.5px solid #e4e6ef; background: #fff; color: #5e6278;
  transition: all .18s; white-space: nowrap;
  text-decoration: none;
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
.ai-card-body { padding: 12px 14px 8px; flex: 1; display: flex; flex-direction: column; }
.ai-name { font-weight: 700; font-size: .9rem; color: #1e1e2d; margin-bottom: 5px; }
.ai-info { font-size: .77rem; color: #a1a5b7; display: -webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden; min-height: 34px; }
.ai-footer { margin-top: auto; padding: 10px 14px 14px; display: flex; align-items: center; justify-content: space-between; gap: 6px; border-top: 1px solid #f8f9fa; }
.ai-price { font-size: .88rem; font-weight: 800; color: #1e1e2d; }
.btn-buy-now { background: #e94560; color: #fff; border: none; border-radius: 8px; padding: 6px 16px; font-size: .82rem; font-weight: 700; white-space: nowrap; transition: background .15s; text-decoration: none; }
.btn-buy-now:hover { background: #c73652; color: #fff; }

[data-bs-theme="dark"] .filter-tab { background: #1c1c2e; border-color: #2d2d44; color: #a1a5b7; }
[data-bs-theme="dark"] .ai-card { background: #1c1c2e; border-color: #2d2d44; }
[data-bs-theme="dark"] .ai-name { color: #e9edf0; }
[data-bs-theme="dark"] .ai-price { color: #e9edf0; }
[data-bs-theme="dark"] .ai-footer { border-top-color: #2d2d44; }
</style>

<div class="toolbar d-flex flex-stack py-3 py-lg-5 mb-5" id="kt_toolbar">
    <div id="kt_toolbar_container" class="container-xxl d-flex flex-stack flex-wrap">
        <div class="page-title d-flex flex-column me-3">
            <h1 class="d-flex text-gray-900 fw-bold my-1 fs-3">
                Tài Khoản AI Giá Rẻ
            </h1>
            <ul class="breadcrumb breadcrumb-dot fw-semibold text-gray-600 fs-7 my-1">
                <li class="breadcrumb-item text-gray-600">
                    <a href="/" class="text-gray-600 text-hover-primary">
                        Home
                    </a>
                </li>
                <li class="breadcrumb-item text-gray-600">AI Accounts</li>
                <li class="breadcrumb-item text-gray-500">Danh Sách</li>
            </ul>
        </div>
    </div>
</div>

<div id="kt_content_container" class="d-flex flex-column-fluid align-items-start container-xxl">
    <div class="content flex-row-fluid" id="kt_content">
        <!-- Hero Search Section -->
        <div class="card mb-8">
            <div class="card-body p-0">
                <div class="d-flex flex-column align-items-center justify-content-center min-vh-20 dvr-hero p-8 text-center">
                    <h1 class="text-white font-weight-bold mb-2 fs-2x">DANH SÁCH TÀI KHOẢN AI TỰ ĐỘNG</h1>
                    <p class="text-white opacity-75 mb-6 fs-6">Sở hữu ngay tài khoản ChatGPT, Claude, Gemini Premium với giá siêu rẻ</p>
                    <form action="{{ route('ai-account.index') }}" method="GET" class="w-100 max-w-600px">
                        @if($selectedCategoryId)
                            <input type="hidden" name="category_id" value="{{ $selectedCategoryId }}">
                        @endif
                        <div class="input-group search-group">
                            <input type="text" name="q" value="{{ $q }}" class="form-control text-white" placeholder="Tìm kiếm tài khoản AI..." aria-label="Tìm kiếm tài khoản AI">
                            <button type="submit" class="btn btn-warning font-weight-bold text-dark">TÌM KIẾM</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Filter Categories Section -->
        @php 
            $totalAi = array_sum($aiCategoryCounts);
        @endphp
        <div class="filter-tabs mb-6">
            <a href="{{ route('ai-account.index', array_filter(['q' => $q])) }}" class="filter-tab @if(!$selectedCategoryId) active @endif">
                <span class="ftab-icon">🤖</span> Tất cả
                <span class="ftab-count">{{ $totalAi }}</span>
            </a>
            @foreach($aiCategories as $cat)
                @if(($aiCategoryCounts[$cat->id] ?? 0) > 0)
                    <a href="{{ route('ai-account.index', array_filter(['category_id' => $cat->id, 'q' => $q])) }}" class="filter-tab @if($selectedCategoryId == $cat->id) active @endif">
                        <span class="ftab-icon">
                            @php
                                $icons = ['chatgpt'=>'💬','claude'=>'✨','gemini'=>'💎','midjourney'=>'🎨','canva-ai'=>'🖌️'];
                                echo $icons[$cat->slug] ?? '🤖';
                            @endphp
                        </span>
                        {{ $cat->name }}
                        <span class="ftab-count">{{ $aiCategoryCounts[$cat->id] ?? 0 }}</span>
                    </a>
                @endif
            @endforeach
        </div>

        <!-- Grid of AI accounts -->
        <div class="row g-4">
            @forelse($aiAccounts as $item)
                @php $aiSlug = \App\Models\Slug::of('ai', $item->id) ?? $item->id; @endphp
                <div class="col-6 col-md-4 col-lg-3 col-xl-2">
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
                            <a href="{{ route('ai-account.detail', $aiSlug) }}" class="ai-name text-decoration-none d-block text-truncate" title="{{ $item->name }}">{{ $item->name }}</a>
                            <div class="ai-info text-muted">{{ $item->account_info ?? 'Sẵn sàng cung cấp tự động' }}</div>
                        </div>
                        <div class="ai-footer">
                            <div class="ai-price">
                                @if($item->variant_min_price > 0 || $item->variant_max_price > 0)
                                    {{ number_format($item->variant_min_price, 0, ',', '.') }}₫
                                    @if($item->variant_max_price > $item->variant_min_price)
                                        <span style="font-size:.72rem;font-weight:500;color:#a1a5b7;">- {{ number_format($item->variant_max_price, 0, ',', '.') }}₫</span>
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
                    <div class="card">
                        <div class="card-body text-center py-12">
                            <div style="font-size:4rem;margin-bottom:16px;">🤖</div>
                            <h3 class="fw-bold text-gray-800 mb-2">Không tìm thấy tài khoản AI nào</h3>
                            <p class="text-gray-500 fs-6">Vui lòng thử lại với từ khóa hoặc danh mục khác.</p>
                            <a href="{{ route('ai-account.index') }}" class="btn btn-primary mt-4">Xem tất cả tài khoản AI</a>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Pagination Section -->
        <div class="d-flex justify-content-center mt-8">
            {{ $aiAccounts->links('vendor.pagination.custom') }}
        </div>
    </div>
</div>
@endsection
