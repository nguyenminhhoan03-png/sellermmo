@php use App\Helpers\Helper; @endphp
@extends('layouts.app')
@section('title', $pageTitle)
@section('content')

<style>
.hidden { display: none; }
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
.card:hover {
    transform: translateY(-3px);
    transition: 0.3s;
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
}
</style>

<div class="toolbar d-flex flex-stack py-3 py-lg-5" id="kt_toolbar">
    <div id="kt_toolbar_container" class="container-xxl d-flex flex-stack flex-wrap">
        <div class="page-title d-flex flex-column me-3">
            <h1 class="d-flex text-gray-900 fw-bold my-1 fs-3">Tạo website giá rẻ</h1>
            <ul class="breadcrumb breadcrumb-dot fw-semibold text-gray-600 fs-7 my-1">
                <li class="breadcrumb-item text-gray-600">
                    <a href="/" class="text-gray-600 text-hover-primary">Home</a>
                </li>
                <li class="breadcrumb-item text-gray-600">Thuê website</li>
                <li class="breadcrumb-item text-gray-500">{{ $web->name }}</li>
            </ul>
        </div>
    </div>
</div>

<div id="kt_content_container" class="d-flex flex-column-fluid align-items-start container-xxl">
    <div class="content flex-row-fluid" id="kt_content">
        <div class="row g-5">
            <!-- Left Column: Slider/Images -->
            <div class="col-lg-7 text-center mb-4">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden h-100" style="background: #f8f9fa;">
                    <div class="card-body d-flex align-items-center justify-content-center p-0">
                        <div class="tns w-100" style="direction: ltr">
                            <div data-tns="true" data-tns-nav-position="bottom" data-tns-mouse-drag="true" data-tns-controls="false">
                               @php
                                        $lines = explode("\n", $web->list_images); 
                               @endphp         
                                @foreach ($lines as $line)
                                    @if(trim($line) !== '')
                                        <div class="text-center">
                                            <a class="d-block overlay" data-fslightbox="lightbox-hot-sales" href="{{ trim($line) }}">
                                                <img src="{{ trim($line) }}" class="img-fluid" style="width: 100%; object-fit: cover;" alt="{{ $web->name }}" loading="lazy" decoding="async" />
                                                <div class="overlay-layer card-rounded bg-dark bg-opacity-25">
                                                    <i class="bi bi-eye-fill fs-2x text-white"></i>
                                                </div>
                                            </a>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Right Column: Order Form -->
            <div class="col-lg-5">
               <div class="card border-0 shadow-sm rounded-4">
                  <div class="card-body p-6 p-lg-8">
                     <h2 class="text-gray-900 fs-2 fw-bolder mb-5">{{ $web->name }}</h2>
                     
                     <form id="shopForm" class="form">
                        <div class="mb-5">
                           <label class="form-label fw-semibold text-gray-700">Tài khoản Admin:</label>
                           <input type="text" id="tk" class="form-control form-control-solid" placeholder="Tối thiểu 6 ký tự" required>
                        </div>
                        <div class="mb-5">
                           <label class="form-label fw-semibold text-gray-700">Mật khẩu Admin:</label>
                           <input type="password" id="mk" class="form-control form-control-solid" placeholder="Nhập mật khẩu" required>
                        </div>

                        <div class="mb-5">
                           <label class="form-label fw-semibold text-gray-700 d-block mb-3">Tên miền:</label>
                           <div class="d-flex gap-4">
                               <div class="form-check form-check-custom form-check-solid">
                                  <input class="form-check-input" type="radio" name="domainOption" id="domainOwn" value="own" checked>
                                  <label class="form-check-label fw-medium text-gray-700" for="domainOwn">Đã có tên miền</label>
                               </div>
                               <div class="form-check form-check-custom form-check-solid">
                                  <input class="form-check-input" type="radio" name="domainOption" id="domainBuy" value="buy">
                                  <label class="form-check-label fw-medium text-gray-700" for="domainBuy">Mua tên miền mới</label>
                               </div>
                           </div>
                        </div>

                        <div id="domainInputArea" class="row g-3 mb-5">
                           <div class="col-md-12">
                              <input type="text" id="domainName" class="form-control form-control-solid" placeholder="Nhập tên miền (VD: example.com)">
                           </div>
                           <div class="col-md-12" id="domainSelectWrap" style="display:none;">
                              <select class="form-select form-select-solid" id="domainPrice" data-control="select2" data-hide-search="true">
                                 <option value="" data-price="0">-- Chọn đuôi tên miền --</option>
                                 @foreach ($domains as $domain)
                                 <option value="{{ $domain->name }}" data-price="{{ $domain->price }}">.{{ $domain->name }} (+{{ number_format($domain->price) }}đ)</option>
                                 @endforeach
                              </select>
                           </div>
                        </div>

                        <div class="mb-5">
                           <label class="form-label fw-semibold text-gray-700">Thời gian thuê:</label>
                           <select class="form-select form-select-solid" id="timePrice" data-control="select2" data-hide-search="true">
                             <option value="" data-month="0" data-web-price="0">-- Chọn số tháng --</option>
                             @for ($i = 1; $i <= 12; $i++)
                              <option value="{{ $i }}" data-month="{{ $i }}" data-web-price="{{ $web->price * $i }}">
                                {{ $i }} tháng (Tạo: {{ number_format( ($web->price * $i) -(($web->price * $i) * $web->ck / 100)) }}đ | Gia hạn: {{ number_format($web->extend * $i) }}đ)
                              </option>
                             @endfor
                           </select>
                        </div>

                        <div class="alert bg-light-primary border border-primary border-dashed d-flex align-items-center p-5 mb-5 rounded-3">
                           <i class="bi bi-wallet2 fs-2hx text-primary me-4"></i>
                           <div class="d-flex flex-column">
                               <h4 class="mb-1 text-primary">Tổng thanh toán</h4>
                               <span id="totalPrice" class="fs-1 fw-bolder text-danger">0đ</span>
                           </div>
                        </div>

                        <div class="form-check form-check-custom form-check-solid mb-7">
                           <input class="form-check-input" type="checkbox" id="agree" required>
                           <label class="form-check-label fw-medium text-gray-600" for="agree">
                               Tôi đã đọc và đồng ý với <a href="{{ route('terms.condition') }}" class="text-primary fw-bold" target="_blank">điều khoản dịch vụ</a>
                           </label>
                        </div>

                        <button type="button" id="btnBuy" class="btn btn-primary w-100 py-3 fs-4 fw-bold">
                            <i class="fas fa-rocket me-2"></i> Xác nhận & Khởi tạo
                        </button>
                     </form>
                  </div>
               </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-4 mt-6">
            <div class="card-header border-0 pt-6">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold fs-3 mb-1">Chi tiết sản phẩm</span>
                    <span class="text-muted mt-1 fw-semibold fs-7">Thông tin giới thiệu về mẫu website này</span>
                </h3>
            </div>
            <div class="card-body py-4">
                <div class="fs-5 text-gray-700" style="white-space: pre-line; line-height: 1.6;">
                    {{ $web->description }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener("DOMContentLoaded", function () {
    const domainOwn = document.getElementById("domainOwn");
    const domainBuy = document.getElementById("domainBuy");
    const domainSelectWrap = document.getElementById("domainSelectWrap");
    const domainPrice = document.getElementById("domainPrice");
    const timePrice = document.getElementById("timePrice");
    const totalPriceEl = document.getElementById("totalPrice");

    function calculateTotal() {
        let total = 0;
        let webPrice = parseInt(timePrice.selectedOptions[0].dataset.webPrice) || 0;
        total += webPrice;

        if (domainBuy.checked) {
            let domainPriceValue = parseInt(domainPrice.selectedOptions[0].dataset.price) || 0;
            total += domainPriceValue;
        }

        totalPriceEl.textContent = total.toLocaleString("vi-VN") + "đ";
    }
    function toggleDomainSelect() {
        if (domainBuy.checked) {
            domainSelectWrap.style.display = "block";
        } else {
            domainSelectWrap.style.display = "none";
        }
        calculateTotal();
    }

    domainOwn.addEventListener("change", toggleDomainSelect);
    domainBuy.addEventListener("change", toggleDomainSelect);
    domainPrice.addEventListener("change", calculateTotal);
    timePrice.addEventListener("change", calculateTotal);

    toggleDomainSelect();
});
</script>
<script>
$('#btnBuy').on('click', function () {
    const agree = document.getElementById('agree');
    if (!agree.checked) {
        showMessage('Bạn phải đồng ý với điều khoản trước khi tiếp tục!', 'error');
        return;
    }
    let option_domain = $('input[name="domainOption"]:checked').val();
    
    const tk = $('#tk').val().trim();
    if (!tk) {
        showMessage('Vui lòng nhập tài khoản admin!', 'error');
        return;
    }
    const mk = $('#mk').val().trim();
    if (!mk) {
        showMessage('Vui lòng nhập mật khẩu admin!', 'error');
        return;
    }
    const domainName = $('#domainName').val().trim();
    const domainPrice = $('#domainPrice').val().trim();
    const timePrice = $('#timePrice').val().trim();
    const $btn = $(this);
    $btn.html('<i class="fa fa-spinner fa-spin"></i> Đang xử lý...').prop('disabled', true);

    $.ajax({
        url: "/web/payment",
        method: "POST",
        dataType: "JSON",
        data: {
            _token: '{{ csrf_token() }}',
            id: "{{ $web->id }}",
            tk: tk,
            mk: mk,
            option_domain: option_domain,
            domainName: domainName,
            domainPrice: domainPrice,
            timePrice: timePrice,
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
                        window.location.href = '/web/history';
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
