@php use App\Helpers\Helper; @endphp 
@php use App\Models\Product; @endphp
@extends('layouts.app') 
@section('title', $pageTitle) 
@section('content')

<style>
    /* Premium CSS for Seller Flow */
    :root {
        --seller-gold: #ffd700;
        --seller-gold-hover: #e6c200;
        --seller-dark: #1e1e2d;
        --seller-glass-bg: rgba(255, 255, 255, 0.85);
        --seller-glass-border: rgba(255, 255, 255, 0.4);
        --seller-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.08);
    }

    [data-bs-theme="dark"] {
        --seller-glass-bg: rgba(30, 30, 45, 0.85);
        --seller-glass-border: rgba(255, 255, 255, 0.1);
    }

    .glass-card {
        background: var(--seller-glass-bg);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border: 1px solid var(--seller-glass-border);
        border-radius: 16px;
        box-shadow: var(--seller-shadow);
        transition: all 0.3s ease;
    }

    .glass-card:hover {
        box-shadow: 0 12px 40px 0 rgba(31, 38, 135, 0.12);
    }

    /* Steps Roadmap styling */
    .steps-timeline {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 2.5rem;
        position: relative;
        padding: 0 1rem;
    }

    .steps-timeline::before {
        content: '';
        position: absolute;
        top: 24px;
        left: 4%;
        right: 4%;
        height: 3px;
        background: #e4e6ef;
        z-index: 1;
    }

    [data-bs-theme="dark"] .steps-timeline::before {
        background: #323248;
    }

    .step-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        z-index: 2;
        width: 30%;
    }

    .step-icon-wrapper {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: #ffffff;
        border: 3px solid #e4e6ef;
        color: #a1a5b7;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        font-weight: bold;
        transition: all 0.3s ease;
    }

    [data-bs-theme="dark"] .step-icon-wrapper {
        background: #1e1e2d;
        border-color: #323248;
    }

    .step-item.active .step-icon-wrapper {
        background: var(--seller-gold);
        border-color: var(--seller-gold);
        color: #1e1e2d;
        box-shadow: 0 0 15px rgba(255, 215, 0, 0.4);
    }

    .step-item.completed .step-icon-wrapper {
        background: #50cd89;
        border-color: #50cd89;
        color: #ffffff;
    }

    .step-title {
        margin-top: 0.75rem;
        font-weight: 600;
        font-size: 0.95rem;
        color: #5e6278;
    }

    .step-item.active .step-title {
        color: var(--seller-gold);
    }

    .step-desc {
        font-size: 0.8rem;
        color: #b5b5c3;
        margin-top: 0.25rem;
    }

    /* Categories Grid */
    .category-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(130px, 1fr));
        gap: 10px;
        margin-top: 10px;
    }

    .category-checkbox {
        display: none;
    }

    .category-label {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 12px 10px;
        border: 1px solid var(--seller-glass-border);
        background: rgba(255, 255, 255, 0.03);
        border-radius: 10px;
        cursor: pointer;
        transition: all 0.25s ease;
        text-align: center;
    }

    .category-label .cat-icon {
        font-size: 1.5rem;
        margin-bottom: 6px;
    }

    .category-label .cat-text {
        font-size: 0.8rem;
        font-weight: 550;
    }

    .category-checkbox:checked + .category-label {
        border-color: var(--seller-gold);
        background: rgba(255, 215, 0, 0.08);
        box-shadow: 0 0 10px rgba(255, 215, 0, 0.15);
        color: var(--seller-gold);
        transform: translateY(-2px);
    }

    .agreement-box {
        border-left: 4px solid var(--seller-gold);
        background: rgba(255, 215, 0, 0.03);
        border-radius: 0 8px 8px 0;
        padding: 15px;
    }

    /* Icon in input controls */
    .input-icon-group {
        position: relative;
    }

    .input-icon-group i {
        position: absolute;
        left: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: #a1a5b7;
    }

    .input-icon-group .form-control {
        padding-left: 42px;
    }

    /* Pulse animation for pending status */
    .pulse-status {
        animation: status-pulse 2s infinite;
    }

    @keyframes status-pulse {
        0% { transform: scale(1); opacity: 1; }
        50% { transform: scale(1.03); opacity: 0.85; }
        100% { transform: scale(1); opacity: 1; }
    }

    @media (max-width: 768px) {
        .steps-timeline {
            flex-direction: column;
            align-items: flex-start;
            gap: 20px;
            margin-bottom: 1.5rem;
        }
        .steps-timeline::before {
            display: none;
        }
        .step-item {
            flex-direction: row;
            align-items: center;
            text-align: left;
            width: 100%;
        }
        .step-title {
            margin-top: 0;
            margin-left: 15px;
        }
        .step-desc {
            display: none;
        }
    }
</style>

<div class="toolbar d-flex flex-stack py-3 py-lg-5" id="kt_toolbar">
    <div id="kt_toolbar_container" class="container-xxl d-flex flex-stack flex-wrap">
        <div class="page-title d-flex flex-column me-3">
            <h1 class="d-flex text-gray-900 fw-bold my-1 fs-3">Trở thành người bán hàng</h1>
            <ul class="breadcrumb breadcrumb-dot fw-semibold text-gray-600 fs-7 my-1">
                <li class="breadcrumb-item text-gray-600">
                    <a href="/" class="text-gray-600 text-hover-primary">Home</a>
                </li>
                <li class="breadcrumb-item text-gray-600">{{ $user->username }}</li>
                <li class="breadcrumb-item text-gray-500">Đăng ký làm người bán</li>
            </ul>
        </div>
    </div>
</div>

<div id="kt_content_container" class="d-flex flex-column-fluid align-items-start container-xxl">
    <div class="content flex-row-fluid" id="kt_content">
        <div class="container-xxl">
            <div class="row">
                <div class="col-lg-10 m-auto">

                    <!-- Road Map Steps -->
                    <div class="card glass-card mb-8 p-6">
                        <div class="steps-timeline">
                            <div class="step-item {{ !$application ? 'active' : ($application->status == 0 ? 'completed' : 'completed') }}">
                                <div class="step-icon-wrapper">
                                    @if($application)
                                        <i class="fas fa-check"></i>
                                    @else
                                        1
                                    @endif
                                </div>
                                <div class="step-title">Gửi Đăng Ký</div>
                                <div class="step-desc">Điền đầy đủ thông tin shop</div>
                            </div>
                            <div class="step-item {{ $application && $application->status == 0 ? 'active' : ($application && $application->status == 1 ? 'completed' : '') }}">
                                <div class="step-icon-wrapper">
                                    @if($application && $application->status == 1)
                                        <i class="fas fa-check"></i>
                                    @else
                                        2
                                    @endif
                                </div>
                                <div class="step-title">Chờ Kiểm Duyệt</div>
                                <div class="step-desc">Admin xác thực trong 24h</div>
                            </div>
                            <div class="step-item {{ $application && $application->status == 1 ? 'active' : '' }}">
                                <div class="step-icon-wrapper">3</div>
                                <div class="step-title">Bắt Đầu Bán</div>
                                <div class="step-desc">Upload sản phẩm, nhận doanh thu</div>
                            </div>
                        </div>
                    </div>

                    @if ($application && $application->status == '0')
                        <!-- PENDING STATE VIEW -->
                        <div class="card glass-card text-center p-10 pulse-status">
                            <div class="my-6">
                                <span class="d-inline-block p-5 bg-light-warning rounded-circle mb-5">
                                    <i class="fas fa-clock text-warning fs-3x"></i>
                                </span>
                                <h2 class="fw-bold text-gray-900 mb-2">Đơn đăng ký của bạn đang được kiểm duyệt!</h2>
                                <p class="text-gray-500 fs-6 max-w-600px m-auto mb-6">
                                    Hệ thống đã nhận được đơn của bạn và sẽ tiến hành xác thực sớm nhất (thông thường từ 1 - 12 giờ). Dưới đây là thông tin bạn đã gửi:
                                </p>
                            </div>

                            <div class="text-start max-w-600px m-auto border rounded p-6 bg-light-neutral glass-card mb-6">
                                <h4 class="fw-bold text-gray-800 border-bottom pb-3 mb-4">Thông tin gian hàng</h4>
                                <div class="row gy-3 fs-6">
                                    <div class="col-sm-4 text-muted">Tên cửa hàng:</div>
                                    <div class="col-sm-8 fw-bold text-gray-900">{{ $application->shop_name }}</div>
                                    
                                    <div class="col-sm-4 text-muted">Số điện thoại:</div>
                                    <div class="col-sm-8 fw-bold text-gray-900">{{ $application->contact_phone }}</div>
                                    
                                    @if($application->contact_facebook)
                                    <div class="col-sm-4 text-muted">Facebook:</div>
                                    <div class="col-sm-8 text-gray-900">
                                        <a href="{{ $application->contact_facebook }}" target="_blank" class="text-primary">{{ $application->contact_facebook }}</a>
                                    </div>
                                    @endif

                                    @if($application->contact_telegram)
                                    <div class="col-sm-4 text-muted">Telegram:</div>
                                    <div class="col-sm-8 fw-bold text-gray-900">{{ $application->contact_telegram }}</div>
                                    @endif

                                    <div class="col-sm-4 text-muted">Mô tả sản phẩm:</div>
                                    <div class="col-sm-8 text-gray-700">{{ $application->description }}</div>

                                    <div class="col-sm-4 text-muted">Danh mục hàng bán:</div>
                                    <div class="col-sm-8">
                                        @if(is_array($application->work_category))
                                            @foreach($application->work_category as $catKey)
                                                @php $cat = Product::CATEGORIES[$catKey] ?? null; @endphp
                                                @if($cat)
                                                    <span class="badge badge-light-primary me-2 my-1">{{ $cat['icon'] }} {{ $cat['label'] }}</span>
                                                @else
                                                    <span class="badge badge-light-secondary me-2 my-1">{{ $catKey }}</span>
                                                @endif
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-center gap-3">
                                <a href="https://t.me/{{ config('app.name_bot') }}" target="_blank" class="btn btn-warning fw-bold text-dark">
                                    <i class="fab fa-telegram me-2 text-dark"></i>Liên Hệ Hỗ Trợ
                                </a>
                                <a href="/" class="btn btn-secondary">Quay lại Trang chủ</a>
                            </div>
                        </div>

                    @else
                        <!-- FORM STATE (New Application or Rejected Re-apply) -->
                        <div class="card glass-card">
                            <div class="card-header border-0 pt-6">
                                <div class="card-title">
                                    <h3 class="card-label fw-bold text-gray-900">
                                        @if($application && $application->status == '2')
                                            Cập nhật đơn đăng ký bán hàng
                                        @else
                                            Đăng ký mở gian hàng đối tác
                                        @endif
                                    </h3>
                                </div>
                            </div>
                            <div class="card-body">
                                
                                @if($application && $application->status == '2')
                                    <div class="alert alert-danger d-flex align-items-center p-5 mb-8">
                                        <i class="fas fa-exclamation-triangle text-danger fs-2hx me-4"></i>
                                        <div class="d-flex flex-column">
                                            <h4 class="fw-bold text-danger mb-1">Đơn đăng ký trước đó của bạn đã bị từ chối</h4>
                                            <span>Bạn vui lòng cập nhật lại thông tin chính xác hơn để chúng tôi tiến hành phê duyệt lại.</span>
                                        </div>
                                    </div>
                                @endif

                                @if ($errors->any())
                                    <div class="alert alert-danger p-5 mb-8">
                                        <ul class="mb-0">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                @if (session('success'))
                                    <div class="alert alert-success p-5 mb-8">
                                        {{ session('success') }}
                                    </div>
                                @endif

                                <form action="{{ route('author-form') }}" method="POST">
                                    @csrf

                                    <h4 class="fw-bold text-gray-800 mb-5 border-bottom pb-2">
                                        <i class="fas fa-store text-warning me-2"></i>1. Thông tin gian hàng của bạn
                                    </h4>

                                    <div class="row">
                                        <div class="col-md-6 mb-6">
                                            <label class="form-label required" for="shop_name">Tên cửa hàng (Shop Name)</label>
                                            <div class="input-icon-group">
                                                <i class="fas fa-tag"></i>
                                                <input type="text" class="form-control form-control-solid shadow-none" id="shop_name" name="shop_name" value="{{ old('shop_name', $application->shop_name ?? '') }}" placeholder="Nhập tên hiển thị của gian hàng" required>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6 mb-6">
                                            <label class="form-label required" for="contact_phone">Số điện thoại liên hệ (Zalo)</label>
                                            <div class="input-icon-group">
                                                <i class="fas fa-phone-alt"></i>
                                                <input type="text" class="form-control form-control-solid shadow-none" id="contact_phone" name="contact_phone" value="{{ old('contact_phone', $application->contact_phone ?? '') }}" placeholder="Nhập số điện thoại liên hệ" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-6">
                                            <label class="form-label" for="contact_facebook">Facebook URL (không bắt buộc)</label>
                                            <div class="input-icon-group">
                                                <i class="fab fa-facebook"></i>
                                                <input type="url" class="form-control form-control-solid shadow-none" id="contact_facebook" name="contact_facebook" value="{{ old('contact_facebook', $application->contact_facebook ?? '') }}" placeholder="https://facebook.com/username">
                                            </div>
                                        </div>

                                        <div class="col-md-6 mb-6">
                                            <label class="form-label" for="contact_telegram">Telegram Username (không bắt buộc)</label>
                                            <div class="input-icon-group">
                                                <i class="fab fa-telegram"></i>
                                                <input type="text" class="form-control form-control-solid shadow-none" id="contact_telegram" name="contact_telegram" value="{{ old('contact_telegram', $application->contact_telegram ?? '') }}" placeholder="@username">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-6">
                                        <label class="form-label required" for="description">Mô tả năng lực & Các sản phẩm sẽ bán</label>
                                        <textarea class="form-control form-control-solid shadow-none" id="description" name="description" rows="3" placeholder="Mô tả ngắn gọn về kinh nghiệm bán hàng, loại mã nguồn/tài khoản bạn muốn bán trên website..." required>{{ old('description', $application->description ?? '') }}</textarea>
                                    </div>

                                    <div class="mb-8">
                                        <label class="form-label required">Chọn danh mục mặt hàng bạn sẽ đăng bán</label>
                                        <div class="category-grid">
                                            @foreach(Product::CATEGORIES as $key => $cat)
                                                @php
                                                    $checked = false;
                                                    if(is_array(old('workCategory'))) {
                                                        $checked = in_array($key, old('workCategory'));
                                                    } elseif($application && is_array($application->work_category)) {
                                                        $checked = in_array($key, $application->work_category);
                                                    }
                                                @endphp
                                                <div>
                                                    <input type="checkbox" class="category-checkbox" id="cat_{{ $key }}" name="workCategory[]" value="{{ $key }}" {{ $checked ? 'checked' : '' }}>
                                                    <label class="category-label" for="cat_{{ $key }}">
                                                        <span class="cat-icon">{{ $cat['icon'] }}</span>
                                                        <span class="cat-text">{{ $cat['label'] }}</span>
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>

                                    <h4 class="fw-bold text-gray-800 mb-5 border-bottom pb-2 mt-8">
                                        <i class="fas fa-users text-warning me-2"></i>2. Câu hỏi phụ từ quản trị viên
                                    </h4>

                                    <div class="row">
                                        <div class="col-md-6 mb-6">
                                            <label class="form-label required">Bạn hoạt động cá nhân hay theo đội nhóm?</label>
                                            <div class="d-flex gap-5 mt-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="team" id="teamNo" value="no" {{ old('team', $application->team ?? 'no') == 'no' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="teamNo">Cá nhân</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="team" id="teamYes" value="yes" {{ old('team', $application->team ?? '') == 'yes' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="teamYes">Đội nhóm</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6 mb-6">
                                            <label class="form-label" for="teamMembers">Số lượng thành viên trong nhóm của bạn</label>
                                            <select class="form-select form-select-solid" id="teamMembers" name="teamMembers">
                                                <option value="1-5" {{ old('teamMembers', $application->team_members ?? '') == '1-5' ? 'selected' : '' }}>Từ 1 đến 5 thành viên</option>
                                                <option value="6-10" {{ old('teamMembers', $application->team_members ?? '') == '6-10' ? 'selected' : '' }}>Từ 6 đến 10 thành viên</option>
                                                <option value="11-20" {{ old('teamMembers', $application->team_members ?? '') == '11-20' ? 'selected' : '' }}>Từ 11 đến 20 thành viên</option>
                                                <option value="20+" {{ old('teamMembers', $application->team_members ?? '') == '20+' ? 'selected' : '' }}>Trên 20 thành viên</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-6">
                                            <label class="form-label required">Bạn có tài khoản phụ nào khác trên sàn không?</label>
                                            <div class="d-flex gap-5 mt-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="otherAccount" id="otherNo" value="no" {{ old('otherAccount', $application->other_account ?? 'no') == 'no' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="otherNo">Không có</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="otherAccount" id="otherYes" value="yes" {{ old('otherAccount', $application->other_account ?? '') == 'yes' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="otherYes">Có tài khoản khác</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6 mb-6">
                                            <label class="form-label required">Bạn có bán hàng trên các chợ MMO khác không?</label>
                                            <div class="d-flex gap-5 mt-2">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="marketAccount" id="marketNo" value="no" {{ old('marketAccount', $application->market_account ?? 'no') == 'no' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="marketNo">Không bán</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="marketAccount" id="marketYes" value="yes" {{ old('marketAccount', $application->market_account ?? '') == 'yes' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="marketYes">Có bán ở nơi khác</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Agreement & Conditions -->
                                    <div class="agreement-box mt-8 mb-6">
                                        <h5 class="fw-bold text-gray-900 mb-2">Quy định bán hàng dành cho đối tác:</h5>
                                        <ul class="text-gray-600 mb-0 pl-4" style="font-size: 0.85rem; line-height: 1.6;">
                                            <li>Cam kết không bán mã nguồn/tài khoản kém chất lượng hoặc chứa mã độc.</li>
                                            <li>Bảo hành và hỗ trợ khách hàng mua hàng nhiệt tình, đúng theo mô tả sản phẩm.</li>
                                            <li>Giao dịch qua sàn được giữ tiền 3 ngày để bảo đảm quyền lợi khách hàng.</li>
                                            <li>Vi phạm quy chế bán hàng hoặc lừa đảo sẽ bị khóa tài khoản vĩnh viễn và đóng băng số dư.</li>
                                        </ul>
                                    </div>

                                    <div class="form-check mb-8">
                                        <input class="form-check-input" type="checkbox" id="accept_terms" required>
                                        <label class="form-check-label text-gray-700 fw-bold" for="accept_terms">Tôi đã đọc kỹ và cam kết tuân thủ quy định dành cho người bán.</label>
                                    </div>

                                    <div class="d-flex justify-content-end">
                                        <button class="btn btn-warning fw-bold text-dark px-8 py-3" type="submit">
                                            <i class="fas fa-paper-plane me-2 text-dark"></i>Gửi Đăng Ký
                                        </button>
                                    </div>

                                </form>
                            </div>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('scripts')
  <script>
    // Custom JS checks or interactive controls
  </script>
@endsection
