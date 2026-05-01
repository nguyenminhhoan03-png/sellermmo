@php use App\Helpers\Helper; @endphp 
@php use App\Models\Product; @endphp
@php use App\Models\Domain; @endphp
@extends('layouts.app') 
@section('title', $pageTitle) 
@section('content')
<style>
.min-vh-25 {
    min-height: 25vh !important;
}
.dvr {
    border-radius: 15px;
}    
    .bg-primary {
    background-color: #0056b3; /* Chọn màu xanh giống ảnh */
}

.input-group .form-control {
    border-radius: 15px;
    height: 50px;
}

.input-group .btn {
    height: 50px;
    border-radius: 0 15px 15px 0;
}

.bg-primary {
    background-image: url('https://inet.vn/public/img/svg/whois-domain-bg.svg');
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
}
.loading-spinner {
            border: 4px solid #f3f3f3;
            border-top: 4px solid #3498db;
            border-radius: 50%;
            width: 16px;
            height: 16px;
            animation: spin 1s linear infinite;
            display: inline-block;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

    /* CSS Custom */
    .table-responsive {
        display: block;
        overflow-x: auto;
        white-space: nowrap;
    }
    th, td {
        white-space: nowrap; /* Không cho nội dung xuống dòng */
        text-align: center; /* Canh giữa nội dung */
    }
    /* Ẩn cột trên thiết bị nhỏ */
   
</style>
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
                <li class="breadcrumb-item text-gray-600">Domain</li>
                <!--end::Item-->
                <!--begin::Item-->
                <li class="breadcrumb-item text-gray-500">Kiểm tra tên miền</li>
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
            
            <!--begin::Card body-->
            <div class="card-body pt-6">
                <!--begin::Table-->
                <form id="domain-form">
                    <div class="d-flex flex-column align-items-center justify-content-center min-vh-25 bg-primary dvr mb-5">
                        <h1 class="text-white font-weight-bold mb-3">ĐĂNG KÝ TÊN MIỀN</h1>
                        <p class="text-white mb-4">Bảo vệ thương hiệu của bạn trên Internet</p>
                        <div class="input-group w-75 rounded">
                            <input type="text" id="domain-input" class="form-control" placeholder="Nhập tên miền bạn muốn đăng ký tại đây" required>
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-warning font-weight-bold">KIỂM TRA</button>
                            </div>
                        </div>
                    </div>
                    
                </form>
            
                <div class="table-responsive">
                    <table id="muabanwebsite" class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4">
                        <!--begin::Table head-->
                        <thead>
                            <tr class="fw-bold fs-6 text-gray-800 text-center border-0 bg-light">                       
                                <th class="min-w-140px rounded-start">Tên miền</th>
                                <th class="min-w-110px">Trạng thái</th>
                                <th class="min-w-110px">Ngày hết hạn</th>
                                <th class="min-w-110px">Giá tiền</th>
                                <th class="min-w-110px">Gia hạn</th>
                                <th class="min-w-100px rounded-end">Hành Động</th>
                            </tr>
                        </thead>
                        <!--end::Table head-->
                        <!--begin::Table body-->
                        <tbody id="results-body" class="border-bottom border-dashed">
                            @foreach ($domain as $domains)
                            <tr>
                                <td>.{{ $domains->name }}</td>
                                <td><span class="badge badge-success text-center">Có thể đăng ký</span></td>
                                <td><span class="badge badge-danger text-center">Hạn sử dụng 1 năm</span></td>
                                <td>{{ number_format(Domain::Getmoney($domains->name, 'price')) }}đ</td>
                                <td>{{ number_format(Domain::Getextend($domains->name, 'extend_price')) }}đ</td>
                                <td>
                                    <span class="badge badge-warning text-center">Whois miền để mua</span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <!--end::Table body-->
                    </table>
                </div>
                <!--end::Table-->
            </div>
            <!--end::Card body-->
        </div>
    </div>
    <!--end::Post-->
</div>
@php
    $prices = [];
    $extendprices = [];
    foreach ($domain as $domains) {
        $prices[$domains->name] = number_format(Domain::Getmoney($domains->name, 'price'));
        $extendprices[$domains->name] = number_format(Domain::Getextend($domains->name, 'extend_price'));
    }
@endphp
<script>
function getParameterByName(name) {
    const url = new URL(window.location.href);
    return url.searchParams.get(name);
}
const dvrParam = getParameterByName('dvr');
if (dvrParam) {
    document.getElementById('domain-input').value = dvrParam;
}
const domainPrices = @json($prices);
const ExtendDomainPrices = @json($extendprices);
 document.getElementById('domain-form').addEventListener('submit', function (event) {
        event.preventDefault();

        const domainInput = document.getElementById('domain-input').value.trim();
        const domain = domainInput.replace(/\.[a-z]+$/i, '');
        if (domain.length < 5) {
        $swal('error', 'Bạn không thể mua tên miền đặc biệt');
        return;
        } 
        const extensions = [@foreach($domain as $domains) '.{{ $domains->name }}', @endforeach];

        const resultsTable = document.getElementById('muabanwebsite');
        const resultsBody = document.getElementById('results-body');

        resultsTable.style.display = '';
        resultsBody.innerHTML = '';

        extensions.forEach(ext => {
            const fullDomain = domain + ext;

            const row = document.createElement('tr');
            row.innerHTML = `
                <td class="fw-semibold fs-6 text-gray-800 text-center">${fullDomain}</td>
                <td class="text-start ps-6 fs-4"><span class="loading-spinner"></span> Đang kiểm tra...</td>
                <td class="text-center"><span class="loading-spinner"></span></td>
                <td class="text-center"><span class="loading-spinner"></span></td>
                <td class="text-center"><span class="loading-spinner"></span></td>
                <td class="text-center"><span class="loading-spinner"></span></td>
            `;
            resultsBody.appendChild(row);

            fetch(`api/whois?domain=${encodeURIComponent(fullDomain)}`)
                .then(response => response.json())
                .then(data => {
                    if (data.code === "1") {
                        const domainName = data.domainName;
                        const domainExtension = domainName.split('.').pop();

                        row.children[1].innerHTML = '<span class="text-center ps-6 fs-4 d-flex align-items-center"><i class="ki-duotone ki-check fs-2x text-success"></i><span class="ms-2">Tên miền chưa được đăng ký</span></span>';
                        row.children[2].innerHTML = `<span class="badge badge-danger text-center">Chưa được đăng ký</span>`;
                        row.children[3].innerHTML = `<span class="badge badge-success text-center">${domainPrices[domainExtension] || '-'}đ / 1 năm</span>`;
                        row.children[4].innerHTML = `<span class="badge badge-success text-center">${ExtendDomainPrices[domainExtension] || 'Không xác định'}đ / 1 năm</span>`;
                        row.children[5].innerHTML = `<a type="button" href="/domain/pay/${domainName}" class="btn btn-sm btn-danger rounded-6 hover-scale"><span id="button1" class="indicator-label">Mua ngay</span></a>`;
                    } else if (data.code === "0") {
                        
                        row.children[1].innerHTML = '<span class="text-center ps-6 fs-4 d-flex align-items-center"><i class="ki-duotone ki-cross fs-2x text-danger me-2"><span class="path1"></span><span class="path2"></span></i><span class="ms-2">Đã được đăng ký</span></span>';
                        row.children[2].innerHTML = `<span class="badge badge-success text-center">${data.expirationDate || '-'}</span>`;
                        row.children[3].innerHTML = `<span class="badge badge-danger text-center">Đã được đăng ký</span>`;
                        row.children[4].innerHTML = `<span class="badge badge-danger text-center">Đã được đăng ký</span>`;
                        row.children[5].innerHTML = `<i class="ki-duotone ki-cross fs-2x text-danger"><span class="path1"></span><span class="path2"></span></i>`;
                    } else {
                        row.children[1].innerHTML = '<span class="text-center ps-6 fs-4 d-flex align-items-center"><i class="ki-duotone ki-cross fs-2x text-danger me-2"><span class="path1"></span><span class="path2"></span></i><span class="ms-2">Lỗi kiểm tra</span></span>';
                        row.children[2].innerHTML = '<span class="badge badge-danger text-center">Không thể xác định</span>';
                        row.children[3].innerHTML = `<span class="badge badge-warning text-center">Không xác được giá</span>`;
                        row.children[4].innerHTML = `<span class="badge badge-warning text-center">Không xác được giá gia hạn</span>`;
                        row.children[5].innerHTML = '<i class="ki-duotone ki-cross fs-2x text-danger"><span class="path1"></span><span class="path2"></span></i>';
                    }
                })
                .catch(() => {
                    row.children[1].innerHTML = '<span class="text-center ps-6 fs-4 d-flex align-items-center"><i class="ki-duotone ki-cross fs-2x text-danger me-2"><span class="path1"></span><span class="path2"></span></i><span class="ms-2">Lỗi kiểm tra</span></span>';
                    row.children[2].innerHTML = '<span class="badge badge-danger text-center">Không thể xác định</span>';
                    row.children[3].innerHTML = `<span class="badge badge-warning text-center">Không xác được giá</span>`;
                    row.children[4].innerHTML = `<span class="badge badge-warning text-center">Không xác được giá gia hạn</span>`;
                    row.children[5].innerHTML = '<i class="ki-duotone ki-cross fs-2x text-danger"><span class="path1"></span><span class="path2"></span></i>';
                });
        });
    });
</script>
@endsection
