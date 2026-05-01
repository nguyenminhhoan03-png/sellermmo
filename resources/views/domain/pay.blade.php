@php use App\Helpers\Helper; @endphp 
@php use Illuminate\Support\Str; @endphp
@php use App\Models\Domain; @endphp
@php use App\Models\ApiLogo; @endphp
@extends('layouts.app') 
@section('title', $pageTitle) 
@section('content')

<div class="toolbar d-flex flex-stack py-3 py-lg-5" id="kt_toolbar">
    <!--begin::Container-->
    <div
        id="kt_toolbar_container"
        class="container-xxl d-flex flex-stack flex-wrap"
    >
        <!--begin::Page title-->
        <div class="page-title d-flex flex-column me-3">
            <!--begin::Title-->
            <h1 class="d-flex text-gray-900 fw-bold my-1 fs-3">
                Đăng ký tên miền
            </h1>
            <!--end::Title-->

            <!--begin::Breadcrumb-->
            <ul
                class="breadcrumb breadcrumb-dot fw-semibold text-gray-600 fs-7 my-1"
            >
                <!--begin::Item-->
                <li class="breadcrumb-item text-gray-600">
                    <a
                        href="/"
                        class="text-gray-600 text-hover-primary"
                    >
                        Home
                    </a>
                </li>
                <!--end::Item-->
                <!--begin::Item-->
                <li class="breadcrumb-item text-gray-600">Mua Miền</li>
                <!--end::Item-->
                <!--begin::Item-->
                <li class="breadcrumb-item text-gray-500">{{ $domain }}</li>
                <!--end::Item-->
            </ul>
            <!--end::Breadcrumb-->
        </div>
        <!--end::Page title-->
        <!--begin::Actions-->
        <div class="d-flex align-items-center py-2">
            <!--begin::Wrapper-->
            <div class="me-4">
                <!--begin::Menu-->
                <a
                    href="#"
                    class="btn btn-sm btn-flex btn-light btn-active-primary fw-bold"
                    data-kt-menu-trigger="click"
                    data-kt-menu-placement="bottom-end"
                >
                    <i class="ki-duotone ki-filter fs-5 text-gray-500 me-1"
                        ><span class="path1"></span><span class="path2"></span
                    ></i>
                    Filter
                </a>

                <!--begin::Menu 1-->
                <div
                    class="menu menu-sub menu-sub-dropdown w-250px w-md-300px"
                    data-kt-menu="true"
                    id="kt_menu_6739b0e589661"
                >
                    <!--begin::Header-->
                    <div class="px-7 py-5">
                        <div class="fs-5 text-gray-900 fw-bold">
                            Filter Options
                        </div>
                    </div>
                    <!--end::Header-->

                    <!--begin::Menu separator-->
                    <div class="separator border-gray-200"></div>
                    <!--end::Menu separator-->

                    <!--begin::Form-->
                    <div class="px-7 py-5">
                        <!--begin::Input group-->
                        <div class="mb-10">
                            <!--begin::Label-->
                            <label class="form-label fw-semibold"
                                >Status:</label
                            >
                            <!--end::Label-->

                            <!--begin::Input-->
                            <div>
                                <select
                                    class="form-select form-select-solid"
                                    multiple
                                    data-kt-select2="true"
                                    data-close-on-select="false"
                                    data-placeholder="Select option"
                                    data-dropdown-parent="#kt_menu_6739b0e589661"
                                    data-allow-clear="true"
                                >
                                    <option></option>
                                    <option value="1">Approved</option>
                                    <option value="2">Pending</option>
                                    <option value="2">In Process</option>
                                    <option value="2">Rejected</option>
                                </select>
                            </div>
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="mb-10">
                            <!--begin::Label-->
                            <label class="form-label fw-semibold"
                                >Member Type:</label
                            >
                            <!--end::Label-->

                            <!--begin::Options-->
                            <div class="d-flex">
                                <!--begin::Options-->
                                <label
                                    class="form-check form-check-sm form-check-custom form-check-solid me-5"
                                >
                                    <input
                                        class="form-check-input"
                                        type="checkbox"
                                        value="1"
                                    />
                                    <span class="form-check-label">
                                        Author
                                    </span>
                                </label>
                                <!--end::Options-->

                                <!--begin::Options-->
                                <label
                                    class="form-check form-check-sm form-check-custom form-check-solid"
                                >
                                    <input
                                        class="form-check-input"
                                        type="checkbox"
                                        value="2"
                                        checked="checked"
                                    />
                                    <span class="form-check-label">
                                        Customer
                                    </span>
                                </label>
                                <!--end::Options-->
                            </div>
                            <!--end::Options-->
                        </div>
                        <!--end::Input group-->

                        <!--begin::Input group-->
                        <div class="mb-10">
                            <!--begin::Label-->
                            <label class="form-label fw-semibold"
                                >Notifications:</label
                            >
                            <!--end::Label-->

                            <!--begin::Switch-->
                            <div
                                class="form-check form-switch form-switch-sm form-check-custom form-check-solid"
                            >
                                <input
                                    class="form-check-input"
                                    type="checkbox"
                                    value=""
                                    name="notifications"
                                    checked
                                />
                                <label class="form-check-label">
                                    Enabled
                                </label>
                            </div>
                            <!--end::Switch-->
                        </div>
                        <!--end::Input group-->

                        <!--begin::Actions-->
                        <div class="d-flex justify-content-end">
                            <button
                                type="reset"
                                class="btn btn-sm btn-light btn-active-light-primary me-2"
                                data-kt-menu-dismiss="true"
                            >
                                Reset
                            </button>

                            <button
                                type="submit"
                                class="btn btn-sm btn-primary"
                                data-kt-menu-dismiss="true"
                            >
                                Apply
                            </button>
                        </div>
                        <!--end::Actions-->
                    </div>
                    <!--end::Form-->
                </div>
                <!--end::Menu 1-->
                <!--end::Menu-->
            </div>
            <!--end::Wrapper-->

            <!--begin::Button-->
            <a
                href="#"
                class="btn btn-sm btn-primary"
                data-bs-toggle="modal"
                data-bs-target="#kt_modal_create_app"
                id="kt_toolbar_primary_button"
            >
                Create
            </a>
            <!--end::Button-->
        </div>
        <!--end::Actions-->
    </div>
    <!--end::Container-->
</div>
<!--end::Toolbar-->

<!--begin::Container-->
<div id="kt_content_container" class="d-flex flex-column-fluid align-items-start container-xxl">
    <!--begin::Post-->
    <div class="content flex-row-fluid" id="kt_content">
        <!--begin::Card-->
        <div class="card">
            <div class="card-body p-5">
              <!-- Title -->
              <h3 class="fw-bold mb-3">{{ $domain }}</h3>
              @php 
              $parts = explode('.', $domain);
              $extension = end($parts);  
              $duoimien = Str::upper($extension);
              @endphp
              <p class="text-muted mb-4">.{{ $duoimien }} domain registration</p>
          
              <!-- Period -->
              <div class="mb-4">
                <label for="period" class="form-label fw-semibold">Thời hạn</label>
                <select class="form-select" id="thoigiangiahan" onchange="tongtien()" data-control="select2">
                  <option value="1" selected>1 năm</option>
                  <option value="2">2 năm</option>
                  <option value="3">3 năm</option>
                </select>
              </div>
              <div class="mb-4">
                <label for="period" class="form-label fw-semibold">NameSever</label>
                <textarea class="form-control" placeholder="ns1.muabanwebsite.io.vn,ns2.muabanwebsite.io.vn" id="nameserver" style="height: 100px"></textarea>
              </div>
              <!-- Pricing -->
              <div class="d-flex align-items-center justify-content-between mb-4">
                <div>
                  <span class="text-muted text-decoration-line-through me-2">{{ number_format($domains->price) }}đ</span>
                  <span class="text-dark fw-bold">{{ number_format(($domains->price * (1 - $domains->sale / 100)), 0, ',', '.') }}đ/1st yr</span>
                  <p class="text-muted mb-0">Bạn có thể sử dụng mã giảm giá để thanh toán lên đến 90%</p>
                </div>
                <div>
                  <span class="badge badge-light-success py-2 px-3">SAVE {{ $domains->sale }}%</span>
                </div>
              </div>
          
              <!-- Free Domain Protection -->
              <div class="alert alert-success d-flex align-items-center mb-4">
                <span class="svg-icon svg-icon-success me-2">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor">
                    <path d="M12 0L9.1 7H0l7.3 5.3L4.4 20 12 14.9 19.6 20l-2.9-7.7L24 7h-9.1z"/>
                  </svg>
                </span>
                <span class="fw-semibold">Bạn sẽ được miễn phí quyền bảo mật riêng tư của tên miền</span>
              </div>
            </div>
          </div>
          
          <!-- Subtotal Section -->
          <div class="card mt-4">
            <div class="card-body p-5">
              <div class="d-flex justify-content-between align-items-center mb-3">
                <span class="text-muted text-decoration-line-through">{{ number_format($domains->price) }}₫</span>
                <span class="fs-4 fw-bold"><span id="remaining">{{ number_format(($domains->price * (1 - $domains->sale / 100)), 0, ',', '.') }}<span>₫</span>
              </div>
              <div class="d-flex justify-content-between align-items-center mb-4">
                <span class="text-muted">Tiết kiệm -<b id="sale">{{ $domains->sale }}<b>%</span>
                <span class="text-success fw-semibold">-<b id="reduce">{{ number_format(($domains->price) - ($domains->price * (1 - $domains->sale / 100))) }}<b>₫</span>
              </div>
              <div>
                <div class="input-group mb-5">
                    <input type="text" class="form-control" id="coupon" placeholder="Nhập mã giảm giá" aria-describedby="basic-addon2">
                    <button class="input-group-text btn btn-danger" id="btnGiamgGia"><i class="fas fa-cart-arrow-down mr-1"></i>Áp Dụng</button>
                </div>
              </div>
              <div class="mt-3">
                <button class="btn btn-primary w-100" type="button" data-bs-toggle="modal" data-bs-target="#kt_modal_stacked_1"><i class="fa fa-cart-plus mr-1"></i>Thanh Toán</button>
              </div>
            </div>
          </div>
          
    </div>
    <!--end::Post-->
</div>
<div class="modal fade" tabindex="-1" id="kt_modal_stacked_1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title fw-bold text-primary">Xác nhận thanh toán</h3>

                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="order-status">
                    <div class="mb-4">
                        <h5 class="fw-bold text-gray-800">{{ $domain }}</h5>
                        <ul class="list-unstyled text-muted">
                            <li><strong>ID:</strong> #{{ $domains->id }}</li>
                            <li><strong>Ngày cập nhật:</strong> {{ $domains->created_at }}</li>
                        </ul>
                    </div>
                    <div class="mb-4">
                        <h6 class="fw-semibold text-primary">Chi tiết thanh toán</h6>
                        <div class="detail-table table-responsive">
                            <table class="table table-borderless">
                                <tbody>
                                    <tr>
                                        <td class="fw-bold">Tên Miền</td>
                                        <td class="text-primary fw-bold">{{ $domain }}
                                        </td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th class="fw-bold">Tổng tiền</th>
                                        <th class="text-primary fw-bold" id="total">{{ number_format(($domains->price * (1 - $domains->sale / 100)), 0, ',', '.') }}₫</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                    <div class="mb-4">
                        <h6 class="fw-semibold text-primary">Hình thức thanh toán</h6>
                        <div class="payment-options">
                            <input type="radio" class="btn-check" name="paymentMethod" value="balance" id="paymentMethodBalance" checked />
                            <label class="btn btn-outline btn-outline-dashed btn-active-light-primary p-4 d-flex align-items-center mb-3" for="paymentMethodBalance">
                                <i class="ki-duotone ki-wallet fs-2x me-3"><span class="path1"></span><span class="path2"></span></i>
                                <span>
                                    <span class="fw-bold text-gray-900">Số dư tài khoản</span>
                                    <span class="text-muted d-block">Thanh toán trực tiếp từ số dư của bạn</span>
                                </span>
                            </label>
                            <input type="radio" class="btn-check" name="paymentMethod" value="transfer" id="paymentMethodTransfer" />
                            <label class="btn btn-outline btn-outline-dashed btn-active-light-primary p-4 d-flex align-items-center" for="paymentMethodTransfer">
                                <i class="ki-duotone ki-bank fs-2x me-3"><span class="path1"></span><span class="path2"></span></i>
                                <span>
                                    <span class="fw-bold text-gray-900">Chuyển khoản ngân hàng</span>
                                    <span class="text-muted d-block">Tạo hóa đơn và chuyển khoản ngân hàng</span>
                                </span>
                            </label>
                        </div>
                    </div>
                    <div class="mb-4 bank-selection d-none">
                        <h6 class="fw-semibold text-primary">Chọn ngân hàng</h6>
                        <select class="form-select" data-control="select2" id="bank" name="bank">
                            @foreach ($bank as $banks)
                            <option value="{{ $banks->name }}">{{ ApiLogo::GetApiBank($banks->name, 'shortName', 'name') }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="row gx-2">
                        <div class="col-6">
                            <button type="button" class="btn btn-secondary w-100" data-bs-dismiss="modal">Đóng</button>
                        </div>
                        <div class="col-6">
                            <button type="button" class="btn btn-primary w-100" id="btnBuy" onclick="processPayment()">
                                <i class="fa-solid fa-cart-shopping me-2"></i>Thanh toán
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function processPayment() {
        const paymentMethod = document.querySelector('input[name="paymentMethod"]:checked').value;

        if (paymentMethod === 'balance') {
            buyProduct();
        } else if (paymentMethod === 'transfer') {
            transferPayment();
        }
    }
    document.querySelectorAll('input[name="paymentMethod"]').forEach((radio) => {
    radio.addEventListener('change', () => {
        const bankSelection = document.querySelector('.bank-selection');
        if (radio.value === 'transfer') {
            bankSelection.classList.remove('d-none');
        } else {
            bankSelection.classList.add('d-none');
        }
    });
});
function buyProduct() {
        $('#btnBuy').html('<i class="fa fa-spinner fa-spin"></i> Đang xử lý...').prop(
            'disabled',
            true);
        $.ajax({
            url: '/domain/pay/dvr',
            type: 'POST',
            dataType: "json",
            data: {
                _token: '{{ csrf_token() }}',
                domainame: '{{ $domain }}',
                ns: $('#nameserver').val(),
                time: $('#thoigiangiahan').val(),
                id: {{ $domains->id }},
                code: $("#coupon").val(),
            },
            success: function(result) {
                if (result.status == '200') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Thành công !',
                        text: result.message,
                        showDenyButton: true,
                        confirmButtonText: 'Mua thêm',
                        denyButtonText: `Xem chi tiết đơn hàng`,
                    }).then((result) => {
                        if (result.isConfirmed) {
                            location.reload();
                        } else if (result.isDenied) {
                            window.location.href =
                                '/domain/history';
                        }
                    });
                } else {
                    showMessage(result.message, 'error');
                }
                },
            error: function (xhr, status, error) {
            var responseMessage = xhr.responseJSON
                ? xhr.responseJSON.message
                : 'Không thể tính kết quả thanh toán';
            showMessage(responseMessage, 'error');
            $('#btnBuy').html('<i class="fa fa-cart-plus mr-1"></i>Thanh Toán').prop('disabled', false);
           },
        });
    }
    
    function transferPayment() {
    const selectedBank = document.getElementById('bank').value;
    $('#btnBuy').html('<i class="fa fa-spinner fa-spin"></i> Đang xử lý...').prop('disabled', true);
    $.ajax({
        url: "/transfer/payment",
        method: "POST",
        dataType: "JSON",
        headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
        data: {
            type: 'domain',
            domainname: '{{ $domain }}',
            ns: $('#nameserver').val(),
            time: $('#thoigiangiahan').val(),
            id: "{{ $domains->id }}",
            code: $("#coupon").val(),
            bank: selectedBank
        },
        success: function (result) {
            if (result.status == '200') {
                showMessage(result.message, 'success');
                window.location.href = result.redirect_url;
            } else {
                showMessage(result.message, 'error');
            }
            $('#btnBuy').html('<i class="fa-solid fa-cart-shopping"></i> <span>Thanh toán</span>').prop('disabled', false);
        },
        error: function(xhr, status, error) {
            var responseMessage = xhr.responseJSON ? xhr.responseJSON.message : 'Vui lòng liên hệ Developer';
            showMessage(responseMessage, 'error');
            $('#btnBuy').html(
                    '<i class="fa-solid fa-cart-shopping"></i> <span>Thanh toán</span>').prop(
                    'disabled',
                    false);
        }
    });
} 
function tongtien() {
        var thoigiangiahan = $("#thoigiangiahan").val();
        var accessToken = "{{ $user->access_token }}";
        if(thoigiangiahan != '') {
            $.ajax({
                url: '/api/vouchers/totalnam',
                type: 'POST',
                data: {
                    time: thoigiangiahan,
                    access_token: accessToken,
                    id: {{ $domains->id }},
                    ns: $("#ns").val(),
                    code: $("#coupon").val(),
                },
                success: function(result) {
                    $("#total").html(result.remaining);
                    $("#remaining").html(result.remaining);
                    $("#sale").html(result.ck);
                    $("#reduce").html(result.reduce);
                },
            error: function (xhr, status, error) {
            var responseMessage = xhr.responseJSON
                ? xhr.responseJSON.message
                : 'Không thể tính kết quả thanh toán';
            showMessage(responseMessage, 'error');
        },
            });
        } else {
            showMessage("Đã có lỗi xảy ra vui lòng ib admin", 'error');
        }
    }
$("#btnGiamgGia").click(function () {
    $('#btnGiamgGia').html('<i class="fa fa-spinner fa-spin"></i> Đang xử lý...').prop('disabled',
    true);
    var thoigiangiahan = $("#thoigiangiahan").val();
    var accessToken = "{{ $user->access_token }}";
    $.ajax({
        url: "/api/vouchers/voucherdomain",
        method: "POST",
        dataType: "JSON",
        data: {
            time: thoigiangiahan,
            access_token: accessToken,
            id: {{ $domains->id }},
            code: $("#coupon").val(),
        },
        success: function (response) {
            $("#total").html(response.remaining);
            $("#remaining").html(response.remaining);
            $("#sale").html(response.ck);
            $("#reduce").html(response.reduce);
            $('#btnGiamgGia').html('<i class="fa fa-times-circle mr-1"></i>Hủy áp dụng').prop('disabled',
            false);

            $("#btnGiamgGia").off('click').on('click', function () {
                location.reload();
            });
        },
        error: function (xhr, status, error) {
            var responseMessage = xhr.responseJSON
                ? xhr.responseJSON.message
                : 'Không thể tính kết quả thanh toán';
            showMessage(responseMessage, 'error');
            $('#btnGiamgGia').html('<i class="fa fa-cart-plus mr-1"></i>Áp Dụng').prop('disabled',
            false);
        },
    });
});
</script>
@endsection
