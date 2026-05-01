@php use App\Helpers\Helper; @endphp
@extends('layouts.app')
@section('title', $pageTitle)
@section('content')
<style>
.card-img-hover {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.card-img-hover:hover {
    transform: scale(1.05);
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
}

.btn-hover-effect {
    transition: all 0.3s ease;
}

.btn-hover-effect:hover {
    background-color: #004085 !important;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
    transform: translateY(-2px);
}
</style>
<style>
.card:hover {
    transform: translateY(-3px);
    transition: 0.3s;
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
}
</style>

<div class="toolbar d-flex flex-stack py-3 py-lg-5" id="kt_toolbar">
    <div id="kt_toolbar_container" class="container-xxl d-flex flex-stack flex-wrap">
        <div class="page-title d-flex flex-column me-3">
            <h1 class="d-flex text-gray-900 fw-bold my-1 fs-3">
                Tạo logo giá rẻ
            </h1>
            <ul class="breadcrumb breadcrumb-dot fw-semibold text-gray-600 fs-7 my-1">
                <li class="breadcrumb-item text-gray-600">
                    <a href="/" class="text-gray-600 text-hover-primary">
                        Home
                    </a>
                </li>
                <li class="breadcrumb-item text-gray-600">Thuê website</li>
                <li class="breadcrumb-item text-gray-500">{{ $logo->name }}</li>
            </ul>
        </div>
    </div>
</div>
<div id="kt_content_container" class="d-flex flex-column-fluid align-items-start container-xxl">
    <div class="content flex-row-fluid" id="kt_content">
        <div class="row">
            <!-- Hình ảnh -->
            <div class="col-md-4 text-center mb-4">
                <img src="{{ img_url($logo->image) }}" alt="{{ $logo->name }}" class="img-fluid rounded">
            </div>

            <!-- Thông tin sản phẩm -->
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h4 class="fw-bold">{{ $logo->name }}</h4>
                        <p>
                            @if ($logo->ck != 0)
                            <span class="text-decoration-line-through text-muted">{{ number_format($logo->price) }}
                                đ</span>
                            <span
                                class="text-danger fw-bold fs-5">{{ number_format($logo->price - $logo->price * $logo->ck / 100, 0, ',', ',') }}
                                đ</span>
                            @else
                            <span class="text-decoration-line-through text-muted">{{ number_format($logo->price) }}0
                                đ</span>
                            @endif
                        </p>
                        <ul class="list-unstyled">
                            <li><strong>Thiết kế bởi:</strong> ADMIN</li>
                            <li><strong>File nhận:</strong> PNG,JPG,GIF</li>
                        </ul>

                        <!-- Nhập tên shop -->
                        <div class="mb-3">
                            <label for="shopName" class="form-label fw-bold">Tên shop</label>
                            <input type="text" class="form-control" id="shopName" placeholder="Nhập tên shop của bạn">
                        </div>

                        <!-- Nút hành động -->
                        <div class="d-flex gap-3">
                            <a href="/logo" class="btn btn-danger flex-fill">← Chọn mẫu khác</a>
                            <button id="btnBuy" class="btn btn-primary flex-fill">✔ Thanh toán ngay</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-5 g-4 text-center">
            <div class="col-md-3">
                <div class="card h-100 border-0 shadow-sm rounded-4 p-4">
                    <div class="fs-2 mb-3 text-primary">⏱</div>
                    <h6 class="fw-bold">Tiết kiệm thời gian</h6>
                    <p class="text-muted mb-0">Chỉ mất vài phút để tạo bộ nhận diện thương hiệu</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card h-100 border-0 shadow-sm rounded-4 p-4">
                    <div class="fs-2 mb-3 text-success">💰</div>
                    <h6 class="fw-bold">Mức giá phù hợp</h6>
                    <p class="text-muted mb-0">Tiết kiệm chi phí so với giải pháp khác</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card h-100 border-0 shadow-sm rounded-4 p-4">
                    <div class="fs-2 mb-3 text-warning">✏️</div>
                    <h6 class="fw-bold">Nguồn gốc rõ ràng</h6>
                    <p class="text-muted mb-0">Logo do chúng tôi tự tay thiết kế</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card h-100 border-0 shadow-sm rounded-4 p-4">
                    <div class="fs-2 mb-3 text-danger">🛡</div>
                    <h6 class="fw-bold">An toàn & Uy tín</h6>
                    <p class="text-muted mb-0">Hơn 5.000 khách hàng sử dụng hệ sinh thái</p>
                </div>
            </div>
        </div>
        <div class="card mt-5">
            <div class="card-body">
                <h5 class="fw-bold mb-3">Chi tiết sản phẩm</h5>
                {{ $logo->description }}
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
    $('#btnBuy').on('click', function () {
        const shopName = $('#shopName').val().trim();

        if (!shopName) {
            showMessage('Vui lòng nhập tên shop!', 'error');
            return;
        }

        const $btn = $(this);
        $btn.html('<i class="fa fa-spinner fa-spin"></i> Đang xử lý...').prop('disabled', true);

        $.ajax({
            url: "/logo/payment",
            method: "POST",
            dataType: "JSON",
            data: {
                _token: '{{ csrf_token() }}',
                id: "{{ $logo->id }}",
                name: shopName
            },
            success: function (result) {
                if (result.status == '200') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Thành công!',
                        text: result.message,
                        showDenyButton: true,
                        confirmButtonText: 'Mua thêm',
                        denyButtonText: 'Xem chi tiết đơn hàng',
                    }).then((res) => {
                        if (res.isConfirmed) {
                            location.reload();
                        } else if (res.isDenied) {
                            window.location.href = '/logo/history';
                        }
                    });
                } else {
                    showMessage(result.message || 'Đã xảy ra lỗi không xác định', 'error');
                }

                $btn.html('<i class="fa-solid fa-cart-shopping"></i> <span>Thanh toán</span>')
                    .prop('disabled', false);
            },
            error: function (xhr) {
                const errorMessage = xhr.responseJSON?.message || 'Vui lòng liên hệ Developer';
                showMessage(errorMessage, 'error');
                $btn.html('<i class="fa-solid fa-cart-shopping"></i> <span>Thanh toán</span>')
                    .prop('disabled', false);
            }
        });
    });
</script>
@endsection