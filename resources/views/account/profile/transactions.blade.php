@php use App\Helpers\Helper; @endphp 
@php use App\Helpers\Funcs; @endphp 
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
            <h1 class="d-flex text-gray-900 fw-bold my-1 fs-3">Thông tin tài khoản</h1>
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
                <li class="breadcrumb-item text-gray-600">User Profile</li>
                <!--end::Item-->
                <!--begin::Item-->
                <li class="breadcrumb-item text-gray-500">{{ auth()->user()->username ?? 'Chưa đăng nhập' }}</li>
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
                    id="kt_menu_67309706460af"
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
                                    class="form-select form-select-solid select2-hidden-accessible"
                                    multiple=""
                                    data-kt-select2="true"
                                    data-close-on-select="false"
                                    data-placeholder="Select option"
                                    data-dropdown-parent="#kt_menu_67309706460af"
                                    data-allow-clear="true"
                                    data-select2-id="select2-data-7-zs47"
                                    tabindex="-1"
                                    aria-hidden="true"
                                    data-kt-initialized="1"
                                >
                                    <option></option>
                                    <option value="1">Approved</option>
                                    <option value="2">Pending</option>
                                    <option value="2">In Process</option>
                                    <option value="2">Rejected</option></select
                                ><span
                                    class="select2 select2-container select2-container--bootstrap5"
                                    dir="ltr"
                                    data-select2-id="select2-data-8-7wdb"
                                    style="width: 100%"
                                    ><span class="selection"
                                        ><span
                                            class="select2-selection select2-selection--multiple form-select form-select-solid"
                                            role="combobox"
                                            aria-haspopup="true"
                                            aria-expanded="false"
                                            tabindex="-1"
                                            aria-disabled="false"
                                            ><ul
                                                class="select2-selection__rendered"
                                                id="select2-hauc-container"
                                            ></ul>
                                            <span
                                                class="select2-search select2-search--inline"
                                            >
                                                <textarea
                                                    class="select2-search__field"
                                                    type="search"
                                                    tabindex="0"
                                                    autocorrect="off"
                                                    autocapitalize="none"
                                                    spellcheck="false"
                                                    role="searchbox"
                                                    aria-autocomplete="list"
                                                    autocomplete="off"
                                                    aria-label="Search"
                                                    aria-describedby="select2-hauc-container"
                                                    placeholder="Select option"
                                                    style="width: 100%"
                                                ></textarea></span></span></span
                                    ><span
                                        class="dropdown-wrapper"
                                        aria-hidden="true"
                                    ></span
                                ></span>
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
                                    checked=""
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
<div
    id="kt_content_container"
    class="d-flex flex-column-fluid align-items-start container-xxl"
>
    <!--begin::Post-->
    <div class="content flex-row-fluid" id="kt_content">
        <!--begin::Navbar-->
        <div class="card mb-5 mb-xxl-8">
            <div class="card-body pt-9 pb-0">
                <!--begin::Details-->
                <div class="d-flex flex-wrap flex-sm-nowrap">
                    <!--begin: Pic-->
                    <div class="me-7 mb-4">
                        <div
                            class="symbol symbol-100px symbol-lg-160px symbol-fixed position-relative"
                        >
                            <img
                                src="{{ asset('assets/media/avatars/user-placeholder.svg') }}"
                                alt="image"
                            />
                            <div
                                class="position-absolute translate-middle bottom-0 start-100 mb-6 bg-success rounded-circle border border-4 border-body h-20px w-20px"
                            ></div>
                        </div>
                    </div>
                    <!--end::Pic-->

                    <!--begin::Info-->
                    <div class="flex-grow-1">
                        <!--begin::Title-->
                        <div
                            class="d-flex justify-content-between align-items-start flex-wrap mb-2"
                        >
                            <!--begin::User-->
                            <div class="d-flex flex-column">
                                <!--begin::Name-->
                                <div class="d-flex align-items-center mb-2">
                                    <a
                                        href="#"
                                        class="text-gray-900 text-hover-primary fs-2 fw-bold me-1"
                                        >{{ auth()->user()->username ?? 'Chưa đăng nhập' }}</a
                                    >
                                    <a href="#"
                                        ><i
                                            class="ki-duotone ki-verify fs-1 text-primary"
                                            ><span class="path1"></span
                                            ><span class="path2"></span></i
                                    ></a>
                                </div>
                                <!--end::Name-->

                                <!--begin::Info-->
                                <div
                                    class="d-flex flex-wrap fw-semibold fs-6 mb-4 pe-2"
                                >
                                @if ($user->level == 1)
                                    <a href="#" class="d-flex align-items-center text-gray-500 text-hover-primary me-5 mb-2">
                                        <i class="ki-duotone ki-profile-circle fs-4 me-1">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                            <span class="path3"></span>
                                        </i>
                                        Admin
                                    </a>
                                @elseif ($user->level == 2)                                  
                                <a href="#" class="d-flex align-items-center text-gray-500 text-hover-primary me-5 mb-2">
                                    <i class="ki-duotone ki-profile-circle fs-4 me-1">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                        <span class="path3"></span>
                                    </i>
                                    Người Bán
                                </a>
                                @else 
                                <a href="#" class="d-flex align-items-center text-gray-500 text-hover-primary me-5 mb-2">
                                    <i class="ki-duotone ki-profile-circle fs-4 me-1">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                        <span class="path3"></span>
                                    </i>
                                    Thành Viên
                                </a>
                                 @endif
                                    <a
                                        href="#"
                                        class="d-flex align-items-center text-gray-500 text-hover-primary me-5 mb-2"
                                    >
                                        <i
                                            class="ki-duotone ki-geolocation fs-4 me-1"
                                            ><span class="path1"></span
                                            ><span class="path2"></span
                                        ></i>
                                        Việt Nam
                                    </a>
                                    <a
                                        href="#"
                                        class="d-flex align-items-center text-gray-500 text-hover-primary mb-2"
                                    >
                                        <i class="ki-duotone ki-sms fs-4 me-1"
                                            ><span class="path1"></span
                                            ><span class="path2"></span
                                        ></i>
                                        {{ auth()->user()->email ?? 'example@local' }}
                                    </a>
                                </div>
                                <!--end::Info-->
                            </div>
                            <!--end::User-->

                            <!--begin::Actions-->
                            <div class="d-flex my-4">
                                <a
                                    href="#"
                                    class="btn btn-sm btn-light me-2"
                                    id="kt_user_follow_button"
                                >
                                    <i
                                        class="ki-duotone ki-check fs-3 d-none"
                                    ></i>
                                    <!--begin::Indicator label-->
                                    <span class="indicator-label"> Follow</span>
                                    <!--end::Indicator label-->

                                    <!--begin::Indicator progress-->
                                    <span class="indicator-progress">
                                        Please wait...
                                        <span
                                            class="spinner-border spinner-border-sm align-middle ms-2"
                                        ></span>
                                    </span>
                                    <!--end::Indicator progress-->
                                </a>

                                

                                <!--begin::Menu-->

                                <!--end::Menu-->
                            </div>
                            <!--end::Actions-->
                        </div>
                        <!--end::Title-->

                        <!--begin::Stats-->
                        <div class="d-flex flex-wrap flex-stack">
                            <!--begin::Wrapper-->
                            <div class="d-flex flex-column flex-grow-1 pe-8">
                                <!--begin::Stats-->
                                <div class="d-flex flex-wrap">
                                    <!--begin::Stat-->
                                    <div
                                        class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3"
                                    >
                                        <!--begin::Number-->
                                        <div class="d-flex align-items-center">
                                            <i
                                                class="ki-duotone ki-arrow-up fs-3 text-success me-2"
                                                ><span class="path1"></span
                                                ><span class="path2"></span
                                            ></i>
                                            <div
                                                class="fs-2 fw-bold counted"
                                                data-kt-countup="true"
                                                data-kt-countup-value="4500"
                                                data-kt-countup-prefix="$"
                                                data-kt-initialized="1"
                                            >
                                            <small>{{ number_format($user->balance ?? 0) }}</small>₫
                                            </div>
                                        </div>
                                        <!--end::Number-->

                                        <!--begin::Label-->
                                        <div
                                            class="fw-semibold fs-6 text-gray-500"
                                        >
                                            Số dư
                                        </div>
                                        <!--end::Label-->
                                    </div>
                                    <!--end::Stat-->

                                    <!--begin::Stat-->
                                    <div
                                        class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3"
                                    >
                                        <!--begin::Number-->
                                        <div class="d-flex align-items-center">
                                            <i
                                                class="ki-duotone ki-arrow-down fs-3 text-danger me-2"
                                                ><span class="path1"></span
                                                ><span class="path2"></span
                                            ></i>
                                            <div
                                                class="fs-2 fw-bold counted"
                                                data-kt-countup="true"
                                                data-kt-countup-value="80"
                                                data-kt-initialized="1"
                                            >
                                            <small>{{ number_format(($user->total_deposit ?? 0) - ($user->balance ?? 0)) }}</small>₫
                                            </div>
                                        </div>
                                        <!--end::Number-->

                                        <!--begin::Label-->
                                        <div
                                            class="fw-semibold fs-6 text-gray-500"
                                        >
                                            Tổng chi
                                        </div>
                                        <!--end::Label-->
                                    </div>
                                    <!--end::Stat-->

                                    <!--begin::Stat-->
                                    <div
                                        class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3"
                                    >
                                        <!--begin::Number-->
                                        <div class="d-flex align-items-center">
                                            <i
                                                class="ki-duotone ki-arrow-up fs-3 text-success me-2"
                                                ><span class="path1"></span
                                                ><span class="path2"></span
                                            ></i>
                                            <div
                                                class="fs-2 fw-bold counted"
                                                data-kt-countup="true"
                                                data-kt-countup-value="60"
                                                data-kt-countup-prefix="%"
                                                data-kt-initialized="1"
                                            >
                                            <small>{{ number_format($user->total_deposit ?? 0) }}</small>₫
                                            </div>
                                        </div>
                                        <!--end::Number-->

                                        <!--begin::Label-->
                                        <div
                                            class="fw-semibold fs-6 text-gray-500"
                                        >
                                            Tổng nạp
                                        </div>
                                        <!--end::Label-->
                                    </div>
                                    <!--end::Stat-->
                                </div>
                                <!--end::Stats-->
                            </div>
                            <!--end::Wrapper-->

                            <!--begin::Progress-->

                            <!--end::Progress-->
                        </div>
                        <!--end::Stats-->
                    </div>
                    <!--end::Info-->
                </div>
                <!--end::Details-->

                <!--begin::Navs-->
                <ul class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bold">
                    <!--begin::Nav item-->
                    <li class="nav-item mt-2">
                        <a class="nav-link text-active-primary ms-0 me-10 py-5 " href="/account/profile">
                            Thông tin chi tiết
                        </a>
                    </li>
                    <li class="nav-item mt-2">
                        <a class="nav-link text-active-primary ms-0 me-10 py-5" href="/account/history">
                            Lịch sử hoạt động
                        </a>
                    </li>
                    <li class="nav-item mt-2">
                        <a class="nav-link text-active-primary ms-0 me-10 py-5 active" href="/account/transactions">
                           Lịch sử dòng tiền
                        </a>
                    </li>
            
                </ul>
                <!--begin::Navs-->
            </div>
        </div>
        <!--end::Navbar-->
        <!--begin::Row-->
        <div class="card mb-5 mb-xxl-8">
            <div class="card-body pt-9 pb-0">
                <div class="table-responsive">
                    <table id="kt_datatable_horizontal_scroll" class="table table-striped table-row-bordered gy-5 gs-7">
                        <thead>
                            <tr class="fw-semibold fs-6 text-gray-800">
                                <th class="min-w-100px">STT</th>
                                <th class="min-w-150px">Số tiền</th>
                                <th class="min-w-150px">Số tiền trước</th>
                                <th class="min-w-150px">Số tiền sau</th>
                                <th class="min-w-150px">Thời gian</th>
                                <th class="min-w-150px">Thời gian cập nhật</th>
                                <th class="min-w-250px">description</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php 
                            $i = 1;
                            @endphp
                            @foreach ($transaction as $transactions)
                            <tr>
                                <td>{{ $i++ }}</td>
                                <td>{{ formatCurrency($transactions->amount) }}</td>
                                <td>{{ formatCurrency($transactions->balance_before) }}</td>
                                <td>{{ formatCurrency($transactions->balance_after) }}</td>
                                <td>{{ $transactions->created_at }}</td>
                                <td>{{ $transactions->updated_at }}</td>
                                <td>{{ $transactions->content }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="card mb-5 mb-xxl-8">
            <div class="card-body pt-9 pb-0">
                <div id="totaltransactions" width="1112" class="overflow-hidden"></div>
            </div>
        </div>
    </div>
    <!--end::Post-->
</div>
@endsection
@section('scripts')
<script>
    function formatCurrencyc(amount) {
        return amount.toLocaleString('vi-VN', { style: 'currency', currency: 'VND' });
    }

    $("#kt_datatable_horizontal_scroll").DataTable({
        "scrollX": true
    });

    var options = {
        series: [{
            name: 'Tiền nạp',
            data: @json($chartDeposit)
        }, {
            name: 'Tiền tiêu',
            data: @json($chartSpent)
        }],
        chart: {
            type: 'line',
            height: 320,
            dropShadow: {
                enabled: true,
                opacity: 0.1,
            },
        },
        labels: @json($chartCategories),
        stroke: {
            curve: "smooth",
            width: [3, 3],
        },
        yaxis: {
            labels: {
                formatter: (val) => formatCurrencyc(val)
            }
        },
        colors: ["rgba(98, 89, 202, 1)", "rgba(249, 148, 51, 1)"],
    };

    var chart2 = new ApexCharts(document.querySelector("#totaltransactions"), options);
    chart2.render();
</script>
@endsection
