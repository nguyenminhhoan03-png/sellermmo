@php use App\Helpers\Helper; @endphp
@php use App\Models\HostingPackages; @endphp
@extends('layouts.app')
@section('title', $pageTitle)
@section('content')
    <style>
        .card .pricing-radius-box {
            -webkit-border-radius: 60px 0 60px 0;
            -moz-border-radius: 60px 0 60px 0;
            -ms-border-radius: 60px 0 60px 0;
            -o-border-radius: 60px 0 60px 0;
            border-radius: 60px 0 60px 0;
        }

        .pricing-header {
            padding: 20px 0;
            background: #f5f6f9;
            -webkit-border-radius: 10px 10px 50% 50%;
            -moz-border-radius: 10px 10px 50% 50%;
            -ms-border-radius: 10px 10px 50% 50%;
            -o-border-radius: 10px 10px 50% 50%;
            border-radius: 10px 10px 50% 50%;
            -webkit-transition: all 0.3s ease-in-out;
            -moz-transition: all 0.3s ease-in-out;
            -ms-transition: all 0.3s ease-in-out;
            -o-transition: all 0.3s ease-in-out;
            transition: all 0.3s ease-in-out;
            margin-bottom: 20px;
        }

        .pricing-details .icon-data {
            font-size: 50px;
        }

        .pricing-custom-tab .tab-pane.fade.active.show {
            display: block;
        }

        .pricing-custom-tab .tab-pane.fade {
            display: none;
        }

        .pricing-custom-tab li.nav-item .nav-link {
            border: 1px solid #f1f1f1;
            color: #01041b;
            font-size: 16px;
            padding: 12px 35px;
            -webkit-border-radius: 0;
            -moz-border-radius: 0;
            -ms-border-radius: 0;
            -o-border-radius: 0;
            border-radius: 0;
        }

        .pricing-custom-tab li.nav-item .nav-link.active {
            color: #fff;
            background: #FF0000;
        }

        .pricing-custom-tab li.nav-item .star-circle {
            background-color: #FF0000;
            -webkit-border-radius: 50%;
            -moz-border-radius: 50%;
            -ms-border-radius: 50%;
            -o-border-radius: 50%;
            border-radius: 50%;
            -webkit-box-shadow: 0 0 0 3px rgba(255, 255, 255, 0.5);
            -moz-box-shadow: 0 0 0 3px rgba(255, 255, 255, 0.5);
            -ms-box-shadow: 0 0 0 3px rgba(255, 255, 255, 0.5);
            -o-box-shadow: 0 0 0 3px rgba(255, 255, 255, 0.5);
            box-shadow: 0 0 0 3px rgba(255, 255, 255, 0.5);
            color: #fff;
            display: block;
            font-size: 13px;
            height: 25px;
            padding: 0;
            line-height: 23px;
            text-align: center;
            width: 20px;
            position: absolute;
            top: -14px;
            left: -14px;
            z-index: 1;
        }

        .btn-dvr {
            padding: 8px 12px !important;
            font-size: 14px !important;
            display: inline-flex;
            align-items: center;
        }

        .form-check-input {
            width: 16px !important;
            height: 16px !important;
        }

        .flex-grow-1 h2 {
            display: flex;
            align-items: center;
            margin: 0;
        }
    </style>
    <div class="toolbar d-flex flex-stack py-3 py-lg-5 mb-5" id="kt_toolbar">
        <div id="kt_toolbar_container" class="container-xxl d-flex flex-stack flex-wrap">
            <div class="page-title d-flex flex-column me-3">
                <h1 class="d-flex text-gray-900 fw-bold my-1 fs-3">
                    Danh Sách Máy Chủ
                </h1>
                <ul class="breadcrumb breadcrumb-dot fw-semibold text-gray-600 fs-7 my-1">
                    <li class="breadcrumb-item text-gray-600">
                        <a href="/" class="text-gray-600 text-hover-primary">
                            Home
                        </a>
                    </li>
                    <li class="breadcrumb-item text-gray-600">Hosing</li>
                    <li class="breadcrumb-item text-gray-500">Trang Chủ</li>
                </ul>
            </div>

        </div>
    </div>
    <div id="kt_content_container" class="d-flex flex-column-fluid align-items-start  container-xxl ">
        <div class="content flex-row-fluid" id="kt_content">
            <form action="@if (setting('hosting') == 1) {{ route('hosting.post') }} @else {{ route('hosting.post.cron') }} @endif" method="POST" class="axios-form" data-confirm="true">
                @csrf
                <div class="col-lg-12 col-xl-12 mb-10">
                    <div class="card card-flush">
                        <div class="card-header pt-7" id="kt_chat_contacts_header">
                            <div class="card-title">
                                <h2>Máy Chủ Hosting</h2>
                            </div>
                        </div>
                        <div class="card-body pt-5">
                            <div class="row m-0">
                                <div class="row g-3 d-flex">
                                    @foreach ($category as $index => $categorys)
                                        <div id="gid-{{ $categorys->id }}" class="col-lg-3 col-md-4 col-6">
                                            <input type="radio" name="whm" hidden value="{{ $categorys->id }}">
                                            <div
                                                class="card hover-elevate-up shadow-sm parent-hover d-flex flex-column p-3 rounded border border-1 border-secondary hover-border-primary cursor-pointer text-center">
                                                <div class="ribbon ribbon-triangle ribbon-top-end border-primary"
                                                    style="display: none;">
                                                    <div class="ribbon-icon mt-n5 me-n6">
                                                        <i class="bi bi-check2 fs-2 text-white"></i>
                                                    </div>
                                                </div>
                                                <div class="symbol symbol-50px">
                                                    <img src="{{ $categorys->anh }}" alt="group-icon" class="mb-2" loading="lazy" decoding="async">
                                                </div>
                                                <span
                                                    class="fw-bold text-center parent-hover-primary">{{ $categorys->name }}</span>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>


                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 col-xl-12 mb-10">
                    <div class="card card-flush">
                        <div class="card-header pt-7" id="kt_chat_contacts_header">
                            <div class="card-title">
                                <h2>Danh Sách Các Gói Hosting</h2>
                            </div>
                        </div>
                        <div class="card-body pt-5">
                            @php
                                $packHostsByCategory = HostingPackages::where('status', 1)
                                    ->get()
                                    ->groupBy('category');
                            @endphp
                            @foreach ($category as $index => $categorys)
                                @php
                                    $pack_host = $packHostsByCategory[$categorys->id] ?? collect();
                                @endphp
                                <div class="col-md-12 mb-10" id="goi-{{ $categorys->id }}" style="display: none;">
                                    <div class="row m-0">
                                        @if ($pack_host->isEmpty())
                                            <div class="text-center comment-null">
                                                <img style="width: 280px; opacity: 0.7;" src="/assets/images/null.svg">
                                                <p>Máy chủ này chưa có gói hosting nào</p>
                                            </div>
                                        @else
                                            @foreach ($pack_host as $pack_hosts)
                                                <div class="col-lg-3 col-sm-6 mb-3">
                                                    <div
                                                        class="card hover-elevate-up shadow-sm parent-hover card-block card-stretch card-height blog pricing-details shadow-sm">
                                                        <input type="radio" name="goi" hidden
                                                            value="{{ $pack_hosts->id }}">
                                                        <div class="ribbon ribbon-triangle ribbon-top-end border-primary"
                                                            style="display: none;">
                                                            <div class="ribbon-icon mt-n5 me-n6">
                                                                <i class="bi bi-check2 fs-2 text-white"></i>
                                                            </div>
                                                        </div>
                                                        <div class="card-body border text-center rounded">
                                                            <div class="pricing-header text-white"
                                                                style="background: linear-gradient(282deg,#00b0ff 5.54%,#3e98eb)!important;">
                                                                <div class="icon-data">
                                                                    <img src="{{ $categorys->anh }}">
                                                                </div>
                                                                <h2 class="mb-4 font-weight-bolder text-white">
                                                                    {{ number_format($pack_hosts->price) }}đ</h2>
                                                            </div>
                                                            <h3 class="mb-3">{{ $pack_hosts->package_name }}</h3>
                                                            <p></p>
                                                            <div class="w-100 mb-10">
                                                                <div class="d-flex align-items-center mb-5">
                                                                    <span
                                                                        class="fw-semibold fs-6 text-gray-800 flex-grow-1 pe-3">
                                                                        Dung Lượng:
                                                                        {{ FormatDungLuong($pack_hosts->disk_quota) }}
                                                                    </span>
                                                                </div>
                                                                <div class="d-flex align-items-center mb-5">
                                                                    <span
                                                                        class="fw-semibold fs-6 text-gray-800 flex-grow-1 pe-3">
                                                                        Băng Thông:
                                                                        {{ FormatBandwidth($pack_hosts->bandwidth_limit) }}
                                                                    </span>
                                                                </div>
                                                                <div class="d-flex align-items-center mb-5">
                                                                    <span
                                                                        class="fw-semibold fs-6 text-gray-800 flex-grow-1 pe-3">
                                                                        Miễn Phí Chứng Chỉ SSL
                                                                    </span>
                                                                </div>
                                                                <div class="d-flex align-items-center mb-5">
                                                                    <span
                                                                        class="fw-semibold fs-6 text-gray-800 flex-grow-1 pe-3">
                                                                        Miền Khác:
                                                                        {{ FormatDuLieu($pack_hosts->max_addon_domains) }}
                                                                    </span>
                                                                </div>
                                                                <div class="d-flex align-items-center mb-5">
                                                                    <span
                                                                        class="fw-semibold fs-6 text-gray-800 flex-grow-1 pe-3">
                                                                        Miền Bí Danh:
                                                                        {{ FormatDuLieu($pack_hosts->max_subdomains) }}
                                                                    </span>
                                                                </div>

                                                                <div class="d-flex align-items-center mb-5">
                                                                    <span
                                                                        class="fw-semibold fs-6 text-gray-800 flex-grow-1 pe-3">
                                                                        Máy chủ: {{ $categorys->name }} </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                            <div class="col-md-12 mb-10" id="goi-0" style="display: block;">
                                <div class="row m-0">
                                    <div class="text-center">
                                        <img style="width: 370px;"
                                            src="https://vietnix.vn/wp-content/uploads/2024/10/img-web-hosting-2.webp">
                                        <p>Hãy chọn gói hosting</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 col-xl-12 mb-10">
                    <div class="card card-flush">
                        <div class="card-header pt-7" id="kt_chat_contacts_header">
                            <div class="card-title">
                                <h2>Chu kỳ thanh toán</h2>
                            </div>
                        </div>
                        <div class="card-body pt-5">
                            <div class="row row-cols-2 row-cols-sm-3 row-cols-md-6 g-3">
                                <div class="col">
                                    <label
                                        class="btn btn-outline btn-outline-dashed btn-active-light-primary d-flex flex-stack text-start p-6 btn-dvr">
                                        <div class="d-flex align-items-center me-2">
                                            <div
                                                class="form-check form-check-custom form-check-solid form-check-primary me-6">
                                                <input class="form-check-input" type="radio" name="time"
                                                    value="1" checked />
                                            </div>
                                            <div class="flex-grow-1">
                                                <h2 class="d-flex align-items-center fs-4 fw-bold flex-wrap">
                                                    1 Tháng
                                                </h2>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                                <div class="col">
                                    <label
                                        class="btn btn-outline btn-outline-dashed btn-active-light-primary d-flex flex-stack text-start p-6 btn-dvr">
                                        <div class="d-flex align-items-center me-2">
                                            <div
                                                class="form-check form-check-custom form-check-solid form-check-primary me-6">
                                                <input class="form-check-input" type="radio" name="time"
                                                    value="2" />
                                            </div>
                                            <div class="flex-grow-1">
                                                <h2 class="d-flex align-items-center fs-4 fw-bold flex-wrap">
                                                    2 Tháng
                                                </h2>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                                <div class="col">
                                    <label
                                        class="btn btn-outline btn-outline-dashed btn-active-light-primary d-flex flex-stack text-start p-6 btn-dvr">
                                        <div class="d-flex align-items-center me-2">
                                            <div
                                                class="form-check form-check-custom form-check-solid form-check-primary me-6">
                                                <input class="form-check-input" type="radio" name="time"
                                                    value="3" />
                                            </div>
                                            <div class="flex-grow-1">
                                                <h2 class="d-flex align-items-center fs-4 fw-bold flex-wrap">
                                                    3 Tháng
                                                </h2>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                                <div class="col">
                                    <label
                                        class="btn btn-outline btn-outline-dashed btn-active-light-primary d-flex flex-stack text-start p-6 btn-dvr">
                                        <div class="d-flex align-items-center me-2">
                                            <div
                                                class="form-check form-check-custom form-check-solid form-check-primary me-6">
                                                <input class="form-check-input" type="radio" name="time"
                                                    value="6" />
                                            </div>
                                            <div class="flex-grow-1">
                                                <h2 class="d-flex align-items-center fs-4 fw-bold flex-wrap">
                                                    6 Tháng
                                                </h2>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                                <div class="col">
                                    <label
                                        class="btn btn-outline btn-outline-dashed btn-active-light-primary d-flex flex-stack text-start p-6 btn-dvr">
                                        <div class="d-flex align-items-center me-2">
                                            <div
                                                class="form-check form-check-custom form-check-solid form-check-primary me-6">
                                                <input class="form-check-input" type="radio" name="time"
                                                    value="9" />
                                            </div>
                                            <div class="flex-grow-1">
                                                <h2 class="d-flex align-items-center fs-4 fw-bold flex-wrap">
                                                    9 Tháng
                                                </h2>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                                <div class="col">
                                    <label
                                        class="btn btn-outline btn-outline-dashed btn-active-light-primary d-flex flex-stack text-start p-6 btn-dvr">
                                        <div class="d-flex align-items-center me-2">
                                            <div
                                                class="form-check form-check-custom form-check-solid form-check-primary me-6">
                                                <input class="form-check-input" type="radio" name="time"
                                                    value="12" />
                                            </div>
                                            <div class="flex-grow-1">
                                                <h2 class="d-flex align-items-center fs-4 fw-bold flex-wrap">
                                                    12 Tháng
                                                </h2>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 col-xl-12">
                    <div class="card card-flush">
                        <div class="card-header pt-7" id="kt_chat_contacts_header">
                            <div class="card-title">
                                <h2>Thông tin hóa đơn</h2>
                            </div>
                        </div>
                        <div class="card-body pt-5">
                            <div class="d-flex flex-column gap-5 mb-5">
                                <div class="d-flex flex-stack">
                                    <a href="#"
                                        class="fs-6 fw-bold text-gray-800 text-hover-primary text-active-primary active">Loại
                                        Máy Chủ</a>
                                    <span id="maychuwhm">Chọn loại máy chủ</span>
                                </div>
                                <div class="d-flex flex-stack">
                                    <a href="#"
                                        class="fs-6 fw-bold text-gray-800 text-hover-primary text-active-primary active">Loại
                                        Gói Hosting</a>
                                    <span id="goihosting">Chọn gói hosting</span>
                                </div>
                                <div class="d-flex flex-stack">
                                    <a href="#" class="fs-6 fw-bold text-danger text-hover-primary">Giá Hosting</a>
                                    <div class="badge badge-light-primary" id="giahosting">Hãy chọn hosting</div>
                                </div>
                            </div>
                            <div class="input-group mb-1">
                                <input type="text" class="form-control form-control-solid" id="coupon" name="coupon"
                                    placeholder="Nhập mã giảm giá" aria-describedby="basic-addon2">
                                <button type="button" class="btn btn-icon btn-danger" id="btnGiamgGia"><i
                                        class="fas fa-cart-arrow-down mr-1"></i></button>
                            </div>
                            <div class="separator my-7"></div>
                            <label class="fs-6 fw-semibold form-label">Tên Miền Của Bạn</label>

                            <div class="input-group">
                                <input type="text" class="form-control form-control-solid" name="domain"
                                    placeholder="muabanwebsite.io.vn">
                                <button type="button" class="btn btn-icon btn-light">
                                    <i class="ki-duotone ki-magnifier fs-2"><span class="path1"></span><span
                                            class="path2"></span><span class="path3"></span></i> </button>
                            </div>
                            <div class="separator my-7"></div>
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="ki-duotone ki-handcart fs-2"><span class="path1"></span><span
                                        class="path2"></span><span class="path3"></span><span
                                        class="path4"></span><span class="path5"></span><span class="path6"></span>
                                </i>Thanh toán
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection
@section('scripts')
    <script>
        $("#btnGiamgGia").click(function() {
            const goiRadios = document.querySelectorAll('input[name="goi"]');
            const selectedGoi = Array.from(goiRadios).find(radio => radio.checked)?.value;
            const timeRadios = document.querySelectorAll('input[name="time"]');
            const selectedTime = Array.from(timeRadios).find(radio => radio.checked)?.value || 1;

            const couponValue = $("#coupon").val();
            $('#btnGiamgGia').html('<i class="fa fa-spinner fa-spin"></i>').prop('disabled',
                true);
            var thoigiangiahan = $("#thoigiangiahan").val();
            $.ajax({
                url: "{{ route('hosting.view.voucherhosting') }}",
                method: "POST",
                dataType: "JSON",
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                data: {
                    time: selectedTime,
                    id: selectedGoi,
                    code: couponValue,
                },
                success: function(response) {
                    $("#giahosting").html(response.value);

                    $('#btnGiamgGia').html('<i class="fa fa-times-circle mr-1"></i>')
                        .prop('disabled', false);

                    $("#btnGiamgGia").off('click').on('click', function() {
                        location.reload();
                    });
                },
                error: function(xhr, status, error) {
                    var responseMessage = xhr.responseJSON ? xhr.responseJSON.message :
                        'Không thể tính kết quả thanh toán';
                    showMessage(responseMessage, 'error');
                    $('#btnGiamgGia').html('<i class="fa fa-cart-plus mr-1"></i>').prop(
                        'disabled', false);
                },
            });
        });
        function applyCouponIfNeeded() {
            const goiRadios = document.querySelectorAll('input[name="goi"]');
            const selectedGoi = Array.from(goiRadios).find(radio => radio.checked)?.value;
            const timeRadios = document.querySelectorAll('input[name="time"]');
            const selectedTime = Array.from(timeRadios).find(radio => radio.checked)?.value || 1;

            const couponValue = $("#coupon").val();
            if (!couponValue) {
                return;
            }
            $('#btnGiamgGia').html('<i class="fa fa-spinner fa-spin"></i>').prop('disabled',
                true);
            var thoigiangiahan = $("#thoigiangiahan").val();
            $.ajax({
                url: "{{ route('hosting.view.voucherhosting') }}",
                method: "POST",
                dataType: "JSON",
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                data: {
                    time: selectedTime,
                    id: selectedGoi,
                    code: couponValue,
                },
                success: function(response) {
                    $("#giahosting").html(response.value);

                    $('#btnGiamgGia').html('<i class="fa fa-times-circle mr-1"></i>')
                        .prop('disabled', false);

                    $("#btnGiamgGia").off('click').on('click', function() {
                        location.reload();
                    });
                },
                error: function(xhr, status, error) {
                    var responseMessage = xhr.responseJSON ? xhr.responseJSON.message :
                        'Không thể tính kết quả thanh toán';
                    showMessage(responseMessage, 'error');
                    $('#btnGiamgGia').html('<i class="fa fa-cart-plus mr-1"></i>').prop(
                        'disabled', false);
                },
            });
        }
       
        document.addEventListener("DOMContentLoaded", function() {
            const categories = [
                @foreach ($category as $categoryz)
                    {
                        id: {{ $categoryz->id }},
                        name: "{{ $categoryz->name }}",
                        packages: [
                            @php
                                $pack_hostz = HostingPackages::where('status', 1)->where('category', $categoryz->id)->get();
                            @endphp
                            @foreach ($pack_hostz as $pack_hostp)
                                {
                                    id: {{ $pack_hostp->id }},
                                    name: "{{ $pack_hostp->package_name }}",
                                    price: {{ $pack_hostp->price }}
                                },
                            @endforeach
                        ]
                    },
                @endforeach
            ];

            const whmRadios = document.querySelectorAll('input[name="whm"]');
            const goiRadios = document.querySelectorAll('input[name="goi"]');
            const timeRadios = document.querySelectorAll('input[name="time"]');

            const mayChuWhmSpan = document.getElementById("maychuwhm");
            const goiHostingSpan = document.getElementById("goihosting");
            const giaHosting = document.getElementById("giahosting");

            function calculateAndDisplay() {
                const selectedWhm = Array.from(whmRadios).find(radio => radio.checked)?.value;
                const selectedGoi = Array.from(goiRadios).find(radio => radio.checked)?.value;
                const selectedTime = Array.from(timeRadios).find(radio => radio.checked)?.value || 1;

                if (selectedWhm && selectedGoi) {
                    const selectedCategory = categories.find(cat => cat.id == selectedWhm);

                    if (selectedCategory) {
                        const selectedPackage = selectedCategory.packages.find(pkg => pkg.id == selectedGoi);

                        if (selectedPackage) {
                            const totalPrice = selectedPackage.price * selectedTime;

                            mayChuWhmSpan.textContent = selectedCategory.name;
                            goiHostingSpan.textContent = `${selectedPackage.name}`;
                            giaHosting.textContent = `${totalPrice.toLocaleString()}đ`;
                        } else {
                            goiHostingSpan.textContent = "Gói hosting không hợp lệ.";
                        }
                    } else {
                        mayChuWhmSpan.textContent = "Máy chủ không hợp lệ.";
                        goiHostingSpan.textContent = "";
                    }
                }
            }
            timeRadios.forEach(radio => {
                radio.addEventListener("change", function() {
                    selectedTime = parseInt(this.value) || 1;
                    applyCouponIfNeeded();
                    calculateAndDisplay();
                });
            });

            document.querySelectorAll('[id^="gid-"]').forEach((element) => {
                element.addEventListener('click', function() {
                    document.querySelectorAll('[id^="gid-"]').forEach((el) => {
                        el.removeAttribute('style');
                        const ribbon = el.querySelector('.ribbon');
                        if (ribbon) ribbon.style.display = 'none';
                    });

                    const clickedId = this.id;
                    const gidNumber = clickedId.split('-')[1];

                    document.querySelectorAll('[id^="goi-"]').forEach((goiElement) => {
                        goiElement.style.display = 'none';
                    });

                    const targetElement = document.getElementById(`goi-${gidNumber}`);
                    if (targetElement) {
                        targetElement.style.display = 'block';
                    }

                    const ribbon = this.querySelector('.ribbon');
                    if (ribbon) {
                        ribbon.style.display = 'block';
                    }

                    const radio = this.querySelector('input[type="radio"]');
                    if (radio) {
                        radio.checked = true;
                    }

                    calculateAndDisplay();
                });
            });

            document.querySelectorAll('.pricing-details').forEach(card => {
                card.addEventListener('click', function() {
                    const isHostCard = card.closest('[id^="goi-"]');

                    document.querySelectorAll('.pricing-details').forEach(c => {
                        const ribbon = c.querySelector('.ribbon');
                        const otherRadio = c.querySelector('input[type="radio"]');

                        if ((isHostCard && c.closest('[id^="goi-"]')) || (!isHostCard && !c
                                .closest('[id^="goi-"]'))) {
                            if (ribbon) ribbon.style.display = 'none';
                            if (otherRadio) otherRadio.checked = false;
                            c.style.border = '';
                        }
                    });

                    card.style.border = '2px solid #0d9de0';
                    card.style.borderRadius = '10px';

                    const ribbon = card.querySelector('.ribbon');
                    if (ribbon) ribbon.style.display = 'block';

                    const radio = card.querySelector('input[type="radio"]');
                    if (radio) {
                        radio.checked = true;
                    }
                    applyCouponIfNeeded();
                    calculateAndDisplay();
                });
            });
        });
    </script>
@endsection
