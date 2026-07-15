@extends('layouts.app')
@section('title', $pageTitle)
@section('content')
<style>
.shop-banner {
    background: #fff;
    border-radius: 16px;
    padding: 30px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.05);
    margin-bottom: 30px;
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    flex-wrap: wrap;
    gap: 20px;
}
.shop-avatar-box {
    display: flex;
    align-items: center;
    gap: 20px;
}
.shop-avatar {
    width: 100px;
    height: 100px;
    border-radius: 20px;
    background: linear-gradient(135deg, #fcd000, #ff9a00);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    font-size: 3rem;
    font-weight: bold;
    box-shadow: 0 4px 10px rgba(252, 208, 0, 0.3);
}
.shop-info h1 {
    font-size: 1.8rem;
    font-weight: 800;
    color: #1e1e2d;
    margin-bottom: 5px;
    display: flex;
    align-items: center;
    gap: 10px;
}
.shop-badges {
    display: flex;
    gap: 10px;
    margin-bottom: 10px;
}
.badge-level {
    background: #e8f4ff;
    color: #1a73e8;
    padding: 5px 12px;
    border-radius: 8px;
    font-size: 0.8rem;
    font-weight: 700;
}
.badge-trust {
    background: #e8f9f4;
    color: #17a589;
    padding: 5px 12px;
    border-radius: 8px;
    font-size: 0.8rem;
    font-weight: 700;
}
.shop-desc {
    color: #7e8299;
    font-size: 0.95rem;
    margin-bottom: 15px;
    max-width: 600px;
}
.shop-stats {
    display: flex;
    gap: 20px;
    flex-wrap: wrap;
    font-size: 0.9rem;
    color: #5e6278;
}
.shop-stats div i {
    color: #a1a5b7;
    margin-right: 5px;
}
.shop-actions {
    display: flex;
    gap: 10px;
}
.btn-chat-now {
    background: #fcd000;
    color: #1e1e2d;
    font-weight: 700;
    padding: 12px 24px;
    border-radius: 12px;
    border: none;
    display: flex;
    align-items: center;
    gap: 8px;
    transition: all 0.2s;
}
.btn-chat-now:hover {
    background: #e5bc00;
    transform: translateY(-2px);
}
.btn-favorite {
    background: #fff;
    color: #e94560;
    font-weight: 700;
    padding: 12px 24px;
    border-radius: 12px;
    border: 1px solid #e94560;
    display: flex;
    align-items: center;
    gap: 8px;
    transition: all 0.2s;
}
.btn-favorite:hover {
    background: #fff0f3;
}
/* Product Section */
.shop-section-title {
    background: #fcd000;
    padding: 15px 25px;
    border-radius: 12px;
    font-size: 1.2rem;
    font-weight: 800;
    color: #1e1e2d;
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}
.product-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 20px;
}
/* Product Card */
.product-card {
    background: #fff;
    border-radius: 16px;
    border: 1px solid #edf1f5;
    overflow: hidden;
    transition: transform 0.2s, box-shadow 0.2s;
    display: flex;
    flex-direction: column;
}
.product-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.08);
}
.product-img {
    width: 100%;
    aspect-ratio: 4/3;
    object-fit: cover;
}
.product-info {
    padding: 15px;
    flex: 1;
    display: flex;
    flex-direction: column;
}
.product-name {
    font-size: 1.1rem;
    font-weight: 700;
    color: #1e1e2d;
    margin-bottom: 10px;
    line-height: 1.4;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
.product-price {
    font-size: 1.2rem;
    font-weight: 800;
    color: #e94560;
    margin-top: auto;
}
.product-meta {
    display: flex;
    justify-content: space-between;
    font-size: 0.8rem;
    color: #a1a5b7;
    margin-top: 10px;
    padding-top: 10px;
    border-top: 1px dashed #edf1f5;
}
.nav-tabs-shop {
    border-bottom: 2px solid #edf1f5;
    margin-bottom: 20px;
}
.nav-tabs-shop .nav-link {
    border: none;
    color: #7e8299;
    font-weight: 600;
    font-size: 1rem;
    padding: 12px 20px;
    border-bottom: 3px solid transparent;
}
.nav-tabs-shop .nav-link.active {
    color: #1e1e2d;
    border-bottom-color: #fcd000;
    background: transparent;
}
</style>

<div class="container-xxl mt-8 mb-10">
    <!-- Breadcrumb -->
    <ul class="breadcrumb breadcrumb-dot fw-semibold text-gray-600 fs-7 my-4">
        <li class="breadcrumb-item text-gray-600">
            <a href="/" class="text-gray-600 text-hover-primary">Trang chủ</a>
        </li>
        <li class="breadcrumb-item text-gray-600">Gian hàng</li>
        <li class="breadcrumb-item text-gray-900 fw-bold">{{ $seller->username }}</li>
    </ul>

    <!-- Banner -->
    <div class="shop-banner">
        <div class="shop-avatar-box">
            <div class="shop-avatar">
                <i class="bi bi-shop"></i>
            </div>
            <div class="shop-info">
                <h1>
                    {{ $seller->username }}
                    <i class="bi bi-check-circle-fill text-success fs-4" title="Đã xác thực"></i>
                </h1>
                <div class="shop-badges">
                    <span class="badge-level"><i class="bi bi-fire me-1"></i> Level {{ $seller->level ?? 1 }}</span>
                    <span class="badge-trust"><i class="bi bi-star-fill text-warning me-1"></i> Tín nhiệm: {{ $trustScore }}</span>
                    <span class="badge-level bg-light-success text-success"><i class="bi bi-circle-fill me-1" style="font-size:8px;"></i> Online gần đây</span>
                </div>
                <p class="shop-desc">Gian hàng uy tín trên nền tảng. Cung cấp sản phẩm chất lượng, hỗ trợ tận tâm, mua sắm an tâm.</p>
                <div class="shop-stats">
                    <div><i class="bi bi-calendar-check"></i> Tham gia: {{ \Carbon\Carbon::parse($seller->created_at)->format('d/m/Y') }} ({{ $joinDays }} ngày)</div>
                    <div><i class="bi bi-cart-check"></i> Đã bán: {{ number_format($totalSold) }}</div>
                    <div><i class="bi bi-box-seam"></i> Tổng sản phẩm: {{ $totalItems }}</div>
                </div>
            </div>
        </div>
        <div class="shop-actions">
            <a href="{{ route('account.chat', ['seller_id' => $seller->id]) }}" class="btn-chat-now" style="text-decoration: none; display: inline-flex; align-items: center; gap: 8px;">
                <i class="bi bi-chat-dots-fill"></i> Chat ngay
            </a>
            <button class="btn-favorite">
                <i class="bi bi-heart"></i> Yêu thích
            </button>
        </div>
    </div>

    <!-- Product Tabs -->
    <ul class="nav nav-tabs nav-tabs-shop" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#tab-products" type="button" role="tab">Sản Phẩm Số ({{ $products->total() }})</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-ai" type="button" role="tab">Tài Khoản AI ({{ $aiAccounts->total() }})</button>
        </li>
    </ul>

    <!-- Tab Content -->
    <div class="tab-content">
        <!-- Tab 1: Products -->
        <div class="tab-pane fade show active" id="tab-products" role="tabpanel">
            @if($products->isEmpty())
                <div class="text-center py-10">
                    <img src="{{ asset('assets/media/illustrations/sketchy-1/5.png') }}" alt="" class="mw-100 mb-5 h-200px">
                    <div class="fs-4 fw-bold text-gray-500">Chưa có sản phẩm số nào.</div>
                </div>
            @else
                <div class="product-grid mb-8">
                    @foreach($products as $product)
                        <a href="{{ route('code.index', $product->slug ?? $product->id) }}" class="product-card text-decoration-none">
                            <img src="{{ $product->images }}" alt="{{ $product->name }}" class="product-img" onerror="this.src='{{ asset('assets/media/stock/600x400/img-1.jpg') }}'">
                            <div class="product-info">
                                <div class="product-name">{{ $product->name }}</div>
                                <div class="product-price">{{ number_format($product->price) }}đ</div>
                                <div class="product-meta">
                                    <span><i class="bi bi-cart me-1"></i>Đã bán: {{ number_format($product->sold) }}</span>
                                    <span><i class="bi bi-eye me-1"></i>{{ number_format($product->view) }}</span>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
                {{ $products->links() }}
            @endif
        </div>

        <!-- Tab 2: AI Accounts -->
        <div class="tab-pane fade" id="tab-ai" role="tabpanel">
            @if($aiAccounts->isEmpty())
                <div class="text-center py-10">
                    <img src="{{ asset('assets/media/illustrations/sketchy-1/5.png') }}" alt="" class="mw-100 mb-5 h-200px">
                    <div class="fs-4 fw-bold text-gray-500">Chưa có tài khoản AI nào.</div>
                </div>
            @else
                <div class="product-grid mb-8">
                    @foreach($aiAccounts as $ai)
                        <a href="{{ route('ai-account.detail', $ai->slug ?? $ai->id) }}" class="product-card text-decoration-none">
                            <img src="{{ $ai->image }}" alt="{{ $ai->name }}" class="product-img" onerror="this.src='{{ asset('assets/media/stock/600x400/img-2.jpg') }}'">
                            <div class="product-info">
                                <div class="product-name">{{ $ai->name }}</div>
                                <div class="product-price">
                                    @if($ai->variant_min_price)
                                        Từ {{ number_format($ai->variant_min_price) }}đ
                                    @else
                                        Liên hệ
                                    @endif
                                </div>
                                <div class="product-meta">
                                    <span><i class="bi bi-person-badge me-1"></i>Người bán: {{ $seller->username }}</span>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
                {{ $aiAccounts->links() }}
            @endif
        </div>
    </div>

</div>

<!-- Include Seller Chat Drawer -->


@endsection
