@extends('seller.layouts.master')

@section('title', 'Thiết lập shop')

@section('content')
<div class="mb-4">
    <h1 class="page-title">Cấu hình gian hàng</h1>
    <p class="text-muted mb-0">Cập nhật thông tin nhận diện thương hiệu của bạn hiển thị với khách hàng.</p>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="row">
    <div class="col-lg-8">
        <div class="premium-card">
            <h4 class="fw-bold mb-4"><i class="fas fa-store text-warning me-2"></i>Thông tin gian hàng</h4>
            
            <form action="{{ route('seller.settings.post') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label required fw-semibold" for="name">Tên gian hàng hiển thị (Shop Name)</label>
                    <input type="text" class="form-control shadow-none" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                    <small class="text-muted d-block mt-2">Tên này sẽ hiển thị làm tên đại diện shop trên trang chi tiết cửa hàng.</small>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold" for="skill">Lĩnh vực hoạt động (Thẻ tags - ngăn cách bằng dấu phẩy)</label>
                    <input type="text" class="form-control shadow-none" id="skill" name="skill" value="{{ old('skill', $user->skill) }}" placeholder="Ví dụ: Gmail, Clone, Via, TikTok, Source Code">
                    <small class="text-muted d-block mt-2">Giúp định vị mặt hàng nổi bật của bạn trên hồ sơ đối tác.</small>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold" for="gioi_thieu">Mô tả giới thiệu ngắn về Shop của bạn</label>
                    <textarea class="form-control shadow-none" id="gioi_thieu" name="gioi_thieu" rows="5" placeholder="Ví dụ: Chuyên cung cấp các loại tài khoản Gmail cổ chất lượng cao, các loại clone TikTok cổ và via Facebook uy tín, hỗ trợ bảo hành nhiệt tình...">{{ old('gioi_thieu', $user->gioi_thieu) }}</textarea>
                </div>

                <div class="d-grid justify-content-end">
                    <button class="btn btn-warning fw-bold text-dark px-4 py-2.5" type="submit">
                        <i class="fas fa-save me-2"></i>Lưu cấu hình
                    </button>
                </div>
            </form>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="premium-card text-center py-5">
            <img src="/assets/media/avatars/user-placeholder.svg" alt="Preview Profile" class="rounded-circle border border-3 border-warning mb-3" width="90" height="90">
            <h5 class="fw-bold mb-1">{{ $user->name ?? $user->username }}</h5>
            <span class="badge bg-warning-subtle text-warning-emphasis mb-3 px-3 py-1.5 fs-7 rounded-pill">Người Bán Hàng</span>
            <p class="text-muted fs-7 px-3">Thông tin hồ sơ bán hàng của bạn sẽ được hiển thị công khai trên trang cửa hàng riêng của bạn.</p>
            <a href="/resller/{{ $user->id }}" target="_blank" class="btn btn-sm btn-outline-warning px-4">
                <i class="fas fa-external-link-alt me-1"></i>Xem trang cá nhân
            </a>
        </div>
    </div>
</div>
@endsection
