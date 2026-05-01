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
        <div class="row">
            <div class="col-md-6 text-center mb-4 rounded border-danger border border-dashed">
                <div class="tns mb-2" style="direction: ltr">
                    <div data-tns="true" data-tns-nav-position="bottom" data-tns-mouse-drag="true" data-tns-controls="false">
                       @php
                                $lines = explode("\n", $web->list_images); 
                       @endphp         
                                    @foreach ($lines as $line)
                                        <div class="text-center px-5 pt-5 pt-lg-10 px-lg-10 mb-1">
                                            <a class="overlay" data-fslightbox="lightbox-hot-sales" href="{{ $line }}">
                                            <img src="{{ $line }}" class="card-rounded shadow mw-100 mb-5" alt="" loading="lazy" decoding="async" />
                                        </a>
                                        </div>
                                    @endforeach
                        ...
                    </div>
                </div>
            </div>
            <div class="col-md-6">
   <div class="card shadow-sm">
      <div class="card-body">
          <span class="text-gray-800 fs-1 fw-bold">{{{ $web->name }}}</span>
         <form id="shopForm" class="mt-4">
            <div class="mb-3">
               <label class="form-label">Tài khoản shop:</label>
               <input type="text" id="tk" class="form-control" placeholder="Tối thiểu 6 ký tự" required>
            </div>
            <div class="mb-3">
               <label class="form-label">Mật khẩu shop:</label>
               <input type="password" id="mk" class="form-control" placeholder="Nhập mật khẩu Admin" required>
            </div>
            <div class="mb-3">
               <label class="form-label">Tên miền:</label><br>
               <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="domainOption" id="domainOwn" value="own" checked>
                  <label class="form-check-label" for="domainOwn">Đã có tên miền</label>
               </div>
               <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="domainOption" id="domainBuy" value="buy">
                  <label class="form-check-label" for="domainBuy">Mua tên miền mới</label>
               </div>
            </div>
            <div id="domainInputArea" class="row g-2 mb-3">
               <div class="col-md-6">
                  <input type="text" id="domainName" class="form-control"  placeholder="Nhập tên miền (VD: example.com)">
               </div>
               <div class="col-md-6" id="domainSelectWrap" style="display:none;">
                  <select class="form-select" id="domainPrice">
                     <option value="" data-price="0">Chọn đuôi miền</option>
                     @foreach ($domains as $domain)
                     <option value="{{ $domain->name }}" data-price="{{ $domain->price }}">.{{ $domain->name }} (+{{ number_format($domain->price) }}đ)</option>
                     @endforeach
                  </select>
               </div>
            </div>
            <div class="mb-3">
               <label class="form-label">Thời gian:</label>
               <select class="form-select" id="timePrice">
                 <option value="" data-month="0" data-web-price="0">Chọn tháng</option>
                 @for ($i = 1; $i <= 12; $i++)
                  <option value="{{ $i }}" data-month="{{ $i }}" data-web-price="{{ $web->price * $i }}">
                    {{ $i }} tháng - Giá tạo ({{ number_format( ($web->price * $i) -(($web->price * $i) * $web->ck / 100)) }}đ) - Gia hạn ({{ number_format($web->extend * $i) }}đ)
                  </option>
                 @endfor
               </select>
            </div>
            <div class="mb-3">
               <strong>Tổng tiền: </strong><span id="totalPrice" class="text-danger fw-bold">0đ</span>
            </div>
            <div class="form-check mb-3">
               <input class="form-check-input" type="checkbox" id="agree" required>
               <label class="form-check-label" for="agree">Tôi đồng ý với điều khoản</label>
            </div>
            <button type="button" id="btnBuy" class="btn btn-success">Xác nhận</button>
         </form>
      </div>
   </div>
</div>
        </div>
        <div class="card mt-5">
            <div class="card-body">
                <h5 class="fw-bold mb-3">Chi tiết sản phẩm</h5>
                <p style="white-space: pre-line;">{{ $web->description }}</p>
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
