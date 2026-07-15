@php use App\Helpers\Helper; @endphp
@extends('layouts.app')
@section('title', $pageTitle)
@section('content')
    <div class="toolbar d-flex flex-stack py-3 py-lg-5" id="kt_toolbar">
        <div id="kt_toolbar_container" class="container-xxl d-flex flex-stack flex-wrap">
            <div class="page-title d-flex flex-column me-3">
                <h1 class="d-flex text-gray-900 fw-bold my-1 fs-3">Thông tin tài khoản</h1>
                <ul class="breadcrumb breadcrumb-dot fw-semibold text-gray-600 fs-7 my-1">
                    <li class="breadcrumb-item text-gray-600">
                        <a href="/" class="text-gray-600 text-hover-primary">
                            Home
                        </a>
                    </li>
                    <li class="breadcrumb-item text-gray-600">User Profile</li>
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
                    <a href="#" class="btn btn-sm btn-flex btn-light btn-active-primary fw-bold"
                        data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                        <i class="ki-duotone ki-filter fs-5 text-gray-500 me-1"><span class="path1"></span><span
                                class="path2"></span></i>
                        Filter
                    </a>

                    <!--begin::Menu 1-->
                    <div class="menu menu-sub menu-sub-dropdown w-250px w-md-300px" data-kt-menu="true"
                        id="kt_menu_67309706460af">
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
                                <label class="form-label fw-semibold">Status:</label>
                                <!--end::Label-->

                                <!--begin::Input-->
                                <div>
                                    <select class="form-select form-select-solid select2-hidden-accessible" multiple=""
                                        data-kt-select2="true" data-close-on-select="false" data-placeholder="Select option"
                                        data-dropdown-parent="#kt_menu_67309706460af" data-allow-clear="true"
                                        data-select2-id="select2-data-7-zs47" tabindex="-1" aria-hidden="true"
                                        data-kt-initialized="1">
                                        <option></option>
                                        <option value="1">Approved</option>
                                        <option value="2">Pending</option>
                                        <option value="2">In Process</option>
                                        <option value="2">Rejected</option>
                                    </select><span class="select2 select2-container select2-container--bootstrap5"
                                        dir="ltr" data-select2-id="select2-data-8-7wdb" style="width: 100%"><span
                                            class="selection"><span
                                                class="select2-selection select2-selection--multiple form-select form-select-solid"
                                                role="combobox" aria-haspopup="true" aria-expanded="false" tabindex="-1"
                                                aria-disabled="false">
                                                <ul class="select2-selection__rendered" id="select2-hauc-container"></ul>
                                                <span class="select2-search select2-search--inline">
                                                    <textarea class="select2-search__field" type="search" tabindex="0" autocorrect="off" autocapitalize="none"
                                                        spellcheck="false" role="searchbox" aria-autocomplete="list" autocomplete="off" aria-label="Search"
                                                        aria-describedby="select2-hauc-container" placeholder="Select option" style="width: 100%"></textarea>
                                                </span>
                                            </span></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>
                                </div>
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->

                            <!--begin::Input group-->
                            <div class="mb-10">
                                <!--begin::Label-->
                                <label class="form-label fw-semibold">Member Type:</label>
                                <!--end::Label-->

                                <!--begin::Options-->
                                <div class="d-flex">
                                    <!--begin::Options-->
                                    <label class="form-check form-check-sm form-check-custom form-check-solid me-5">
                                        <input class="form-check-input" type="checkbox" value="1" />
                                        <span class="form-check-label">
                                            Author
                                        </span>
                                    </label>
                                    <!--end::Options-->

                                    <!--begin::Options-->
                                    <label class="form-check form-check-sm form-check-custom form-check-solid">
                                        <input class="form-check-input" type="checkbox" value="2" checked="checked" />
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
                                <label class="form-label fw-semibold">Notifications:</label>
                                <!--end::Label-->

                                <!--begin::Switch-->
                                <div class="form-check form-switch form-switch-sm form-check-custom form-check-solid">
                                    <input class="form-check-input" type="checkbox" value="" name="notifications"
                                        checked="" />
                                    <label class="form-check-label">
                                        Enabled
                                    </label>
                                </div>
                                <!--end::Switch-->
                            </div>
                            <!--end::Input group-->

                            <!--begin::Actions-->
                            <div class="d-flex justify-content-end">
                                <button type="reset" class="btn btn-sm btn-light btn-active-light-primary me-2"
                                    data-kt-menu-dismiss="true">
                                    Reset
                                </button>

                                <button type="submit" class="btn btn-sm btn-primary" data-kt-menu-dismiss="true">
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
                <a href="#" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                    data-bs-target="#kt_modal_create_app" id="kt_toolbar_primary_button">
                    Create
                </a>
                <!--end::Button-->
            </div>
            <!--end::Actions-->
        </div>
        <!--end::Container-->
    </div>
    <div id="kt_content_container" class="d-flex flex-column-fluid align-items-start container-xxl">
        <!--begin::Post-->
        <div class="content flex-row-fluid" id="kt_content">
            <!--begin::Navbar-->
            <div class="card mb-5 mb-xxl-8">
                <div class="card-body pt-9 pb-0">
                    <!--begin::Details-->
                    <div class="d-flex flex-wrap flex-sm-nowrap">
                        <!--begin: Pic-->
                        <div class="me-7 mb-4">
                            <div class="symbol symbol-100px symbol-lg-160px symbol-fixed position-relative">
                                <img src="{{ asset('assets/media/avatars/user-placeholder.svg') }}" alt="image" />
                                <div
                                    class="position-absolute translate-middle bottom-0 start-100 mb-6 bg-success rounded-circle border border-4 border-body h-20px w-20px">
                                </div>
                            </div>
                        </div>
                        <!--end::Pic-->

                        <!--begin::Info-->
                        <div class="flex-grow-1">
                            <!--begin::Title-->
                            <div class="d-flex justify-content-between align-items-start flex-wrap mb-2">
                                <!--begin::User-->
                                <div class="d-flex flex-column">
                                    <!--begin::Name-->
                                    <div class="d-flex align-items-center mb-2">
                                        <a href="#"
                                            class="text-gray-900 text-hover-primary fs-2 fw-bold me-1">{{ auth()->user()->username ?? 'Chưa đăng nhập' }}</a>
                                        <a href="#"><i class="ki-duotone ki-verify fs-1 text-primary"><span
                                                    class="path1"></span><span class="path2"></span></i></a>
                                    </div>
                                    <!--end::Name-->

                                    <!--begin::Info-->
                                    <div class="d-flex flex-wrap fw-semibold fs-6 mb-4 pe-2">
                                        @if ($user->level == 1)
                                            <a href="#"
                                                class="d-flex align-items-center text-gray-500 text-hover-primary me-5 mb-2">
                                                <i class="ki-duotone ki-profile-circle fs-4 me-1">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                    <span class="path3"></span>
                                                </i>
                                                Admin
                                            </a>
                                        @elseif ($user->level == 2)
                                            <a href="#"
                                                class="d-flex align-items-center text-gray-500 text-hover-primary me-5 mb-2">
                                                <i class="ki-duotone ki-profile-circle fs-4 me-1">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                    <span class="path3"></span>
                                                </i>
                                                Người Bán
                                            </a>
                                        @else
                                            <a href="#"
                                                class="d-flex align-items-center text-gray-500 text-hover-primary me-5 mb-2">
                                                <i class="ki-duotone ki-profile-circle fs-4 me-1">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                    <span class="path3"></span>
                                                </i>
                                                Thành Viên
                                            </a>
                                        @endif
                                        <a href="#"
                                            class="d-flex align-items-center text-gray-500 text-hover-primary me-5 mb-2">
                                            <i class="ki-duotone ki-geolocation fs-4 me-1"><span
                                                    class="path1"></span><span class="path2"></span></i>
                                            Việt Nam
                                        </a>
                                        <a href="#"
                                            class="d-flex align-items-center text-gray-500 text-hover-primary mb-2">
                                            <i class="ki-duotone ki-sms fs-4 me-1"><span class="path1"></span><span
                                                    class="path2"></span></i>
                                            {{ auth()->user()->email ?? 'example@local' }}
                                        </a>
                                    </div>
                                    <!--end::Info-->
                                </div>
                                <!--end::User-->

                                <!--begin::Actions-->
                                <div class="d-flex my-4">
                                    <a href="#" class="btn btn-sm btn-light me-2" id="kt_user_follow_button">
                                        <i class="ki-duotone ki-check fs-3 d-none"></i>
                                        <!--begin::Indicator label-->
                                        <span class="indicator-label"> Follow</span>
                                        <!--end::Indicator label-->

                                        <!--begin::Indicator progress-->
                                        <span class="indicator-progress">
                                            Please wait...
                                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
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
                                            class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                            <!--begin::Number-->
                                            <div class="d-flex align-items-center">
                                                <i class="ki-duotone ki-arrow-up fs-3 text-success me-2"><span
                                                        class="path1"></span><span class="path2"></span></i>
                                                <div class="fs-2 fw-bold counted" data-kt-countup="true"
                                                    data-kt-countup-value="4500" data-kt-countup-prefix="$"
                                                    data-kt-initialized="1">
                                                    <small>{{ number_format($user->balance ?? 0) }}</small>₫
                                                </div>
                                            </div>
                                            <!--end::Number-->

                                            <!--begin::Label-->
                                            <div class="fw-semibold fs-6 text-gray-500">
                                                Số dư
                                            </div>
                                            <!--end::Label-->
                                        </div>
                                        <!--end::Stat-->

                                        <!--begin::Stat-->
                                        <div
                                            class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                            <!--begin::Number-->
                                            <div class="d-flex align-items-center">
                                                <i class="ki-duotone ki-arrow-down fs-3 text-danger me-2"><span
                                                        class="path1"></span><span class="path2"></span></i>
                                                <div class="fs-2 fw-bold counted" data-kt-countup="true"
                                                    data-kt-countup-value="80" data-kt-initialized="1">
                                                    <small>{{ number_format(($user->total_deposit ?? 0) - ($user->balance ?? 0)) }}</small>₫
                                                </div>
                                            </div>
                                            <!--end::Number-->

                                            <!--begin::Label-->
                                            <div class="fw-semibold fs-6 text-gray-500">
                                                Tổng chi
                                            </div>
                                            <!--end::Label-->
                                        </div>
                                        <!--end::Stat-->

                                        <!--begin::Stat-->
                                        <div
                                            class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                            <!--begin::Number-->
                                            <div class="d-flex align-items-center">
                                                <i class="ki-duotone ki-arrow-up fs-3 text-success me-2"><span
                                                        class="path1"></span><span class="path2"></span></i>
                                                <div class="fs-2 fw-bold counted" data-kt-countup="true"
                                                    data-kt-countup-value="60" data-kt-countup-prefix="%"
                                                    data-kt-initialized="1">
                                                    <small>{{ number_format($user->total_deposit ?? 0) }}</small>₫
                                                </div>
                                            </div>
                                            <!--end::Number-->

                                            <!--begin::Label-->
                                            <div class="fw-semibold fs-6 text-gray-500">
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
                        <!--begin::Navs-->
                    <ul class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bold mt-5">
                        <li class="nav-item">
                            <a class="nav-link text-active-primary ms-0 me-10 py-5" href="/account/profile">
                                Thông tin chi tiết
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-active-primary ms-0 me-10 py-5" href="/account/history">
                                Nhật ký hoạt động
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-active-primary ms-0 me-10 py-5" href="/account/transactions">
                                Lịch sử dòng tiền
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-active-primary ms-0 me-10 py-5 active" href="/account/orders">
                                Lịch sử mua hàng
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-active-primary ms-0 me-10 py-5" href="/account/chat">
                                Tin nhắn
                            </a>
                        </li>
                    </ul>
                    <!--begin::Navs-->
                </div>
            </div>
            <!--end::Navbar-->
            <!--begin::Row-->
            <div class="card shadow-sm mb-5 mb-xxl-8" style="border-radius: 16px; border: none;">
                <div class="card-header border-0 pt-6">
                    <div class="card-title">
                        <div class="d-flex align-items-center position-relative my-1">
                            <i class="ki-duotone ki-handcart fs-2 text-primary me-2"><span class="path1"></span><span class="path2"></span></i>
                            <h3 class="fw-bold m-0 fs-3">Lịch sử mua hàng</h3>
                        </div>
                    </div>
                </div>
                <div class="card-body pt-0 pb-5">
                    
                    <!-- Sub Tabs for Categories -->
                    <ul class="nav nav-pills nav-pills-custom mb-3" style="border-bottom: 1px solid #EFF2F5;">
                        <li class="nav-item mb-3 me-3 me-lg-6">
                            <a class="nav-link d-flex justify-content-between flex-column flex-center overflow-hidden {{ $tab == 'ai' ? 'active bg-light-primary' : '' }} w-120px h-85px py-4" href="/account/orders?tab=ai" style="border-radius: 12px;">
                                <i class="ki-duotone ki-robot fs-2x mb-2 {{ $tab == 'ai' ? 'text-primary' : '' }}"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                                <span class="nav-text text-gray-700 fw-bold fs-6 lh-1">Tài khoản AI</span>
                                <span class="bullet-custom position-absolute bottom-0 w-100 h-4px bg-primary {{ $tab == 'ai' ? '' : 'd-none' }}"></span>
                            </a>
                        </li>
                        <li class="nav-item mb-3 me-3 me-lg-6">
                            <a class="nav-link d-flex justify-content-between flex-column flex-center overflow-hidden {{ $tab == 'code' ? 'active bg-light-primary' : '' }} w-120px h-85px py-4" href="/account/orders?tab=code" style="border-radius: 12px;">
                                <i class="ki-duotone ki-code fs-2x mb-2 {{ $tab == 'code' ? 'text-primary' : '' }}"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></i>
                                <span class="nav-text text-gray-700 fw-bold fs-6 lh-1">Mã Nguồn</span>
                                <span class="bullet-custom position-absolute bottom-0 w-100 h-4px bg-primary {{ $tab == 'code' ? '' : 'd-none' }}"></span>
                            </a>
                        </li>
                        <li class="nav-item mb-3 me-3 me-lg-6">
                            <a class="nav-link d-flex justify-content-between flex-column flex-center overflow-hidden {{ $tab == 'domain' ? 'active bg-light-primary' : '' }} w-120px h-85px py-4" href="/account/orders?tab=domain" style="border-radius: 12px;">
                                <i class="ki-duotone ki-pill fs-2x mb-2 {{ $tab == 'domain' ? 'text-primary' : '' }}"><span class="path1"></span><span class="path2"></span></i>
                                <span class="nav-text text-gray-700 fw-bold fs-6 lh-1">Tên Miền</span>
                                <span class="bullet-custom position-absolute bottom-0 w-100 h-4px bg-primary {{ $tab == 'domain' ? '' : 'd-none' }}"></span>
                            </a>
                        </li>
                        <li class="nav-item mb-3 me-3 me-lg-6">
                            <a class="nav-link d-flex justify-content-between flex-column flex-center overflow-hidden {{ $tab == 'hosting' ? 'active bg-light-primary' : '' }} w-120px h-85px py-4" href="/account/orders?tab=hosting" style="border-radius: 12px;">
                                <i class="ki-duotone ki-cloud-add fs-2x mb-2 {{ $tab == 'hosting' ? 'text-primary' : '' }}"><span class="path1"></span><span class="path2"></span></i>
                                <span class="nav-text text-gray-700 fw-bold fs-6 lh-1">Hosting</span>
                                <span class="bullet-custom position-absolute bottom-0 w-100 h-4px bg-primary {{ $tab == 'hosting' ? '' : 'd-none' }}"></span>
                            </a>
                        </li>
                        <li class="nav-item mb-3 me-3 me-lg-6">
                            <a class="nav-link d-flex justify-content-between flex-column flex-center overflow-hidden {{ $tab == 'web' ? 'active bg-light-primary' : '' }} w-120px h-85px py-4" href="/account/orders?tab=web" style="border-radius: 12px;">
                                <i class="ki-duotone ki-chrome fs-2x mb-2 {{ $tab == 'web' ? 'text-primary' : '' }}"><span class="path1"></span><span class="path2"></span></i>
                                <span class="nav-text text-gray-700 fw-bold fs-6 lh-1">Website</span>
                                <span class="bullet-custom position-absolute bottom-0 w-100 h-4px bg-primary {{ $tab == 'web' ? '' : 'd-none' }}"></span>
                            </a>
                        </li>
                        <li class="nav-item mb-3 me-3 me-lg-6">
                            <a class="nav-link d-flex justify-content-between flex-column flex-center overflow-hidden {{ $tab == 'logo' ? 'active bg-light-primary' : '' }} w-120px h-85px py-4" href="/account/orders?tab=logo" style="border-radius: 12px;">
                                <i class="ki-duotone ki-picture fs-2x mb-2 {{ $tab == 'logo' ? 'text-primary' : '' }}"><span class="path1"></span><span class="path2"></span></i>
                                <span class="nav-text text-gray-700 fw-bold fs-6 lh-1">Thiết Kế Logo</span>
                                <span class="bullet-custom position-absolute bottom-0 w-100 h-4px bg-primary {{ $tab == 'logo' ? '' : 'd-none' }}"></span>
                            </a>
                        </li>
                    </ul>
                    
                    <div class="separator mb-5"></div>
                    
                    <!-- Table Content based on Tab -->
                    <div class="table-responsive">
                        <table id="kt_datatable_orders" class="table align-middle table-row-dashed fs-6 gy-5">
                            <thead>
                                @if($tab == 'ai')
                                    <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                                        <th class="min-w-50px">STT</th>
                                        <th class="min-w-250px">Tài Khoản AI</th>
                                        <th class="min-w-150px">Gói Dịch Vụ</th>
                                        <th class="min-w-100px">Số Lượng</th>
                                        <th class="min-w-150px">Tổng Tiền</th>
                                        <th class="min-w-150px">Thông Tin Nhận</th>
                                        <th class="min-w-150px">Ngày Mua</th>
                                        <th class="min-w-100px">Hành Động</th>
                                    </tr>
                                @elseif($tab == 'code')
                                    <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                                        <th class="min-w-50px">STT</th>
                                        <th class="min-w-250px">Tên Mã Nguồn</th>
                                        <th class="min-w-150px">Giá</th>
                                        <th class="min-w-150px">Ngày Mua</th>
                                        <th class="min-w-100px">Hành Động</th>
                                    </tr>
                                @elseif($tab == 'domain')
                                    <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                                        <th class="min-w-50px">STT</th>
                                        <th class="min-w-250px">Tên Miền</th>
                                        <th class="min-w-150px">Giá</th>
                                        <th class="min-w-150px">Trạng Thái</th>
                                        <th class="min-w-150px">Ngày Mua</th>
                                        <th class="min-w-100px">Hành Động</th>
                                    </tr>
                                @elseif($tab == 'hosting')
                                    <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                                        <th class="min-w-50px">STT</th>
                                        <th class="min-w-250px">Tên Miền</th>
                                        <th class="min-w-150px">IP Host</th>
                                        <th class="min-w-150px">Giá</th>
                                        <th class="min-w-150px">Trạng Thái</th>
                                        <th class="min-w-150px">Ngày Hết Hạn</th>
                                        <th class="min-w-100px">Hành Động</th>
                                    </tr>
                                @elseif($tab == 'logo')
                                    <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                                        <th class="min-w-50px">STT</th>
                                        <th class="min-w-250px">Tên Yêu Cầu</th>
                                        <th class="min-w-150px">Giá</th>
                                        <th class="min-w-150px">Trạng Thái</th>
                                        <th class="min-w-150px">Ngày Mua</th>
                                        <th class="min-w-100px">Hành Động</th>
                                    </tr>
                                @elseif($tab == 'web')
                                    <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                                        <th class="min-w-50px">STT</th>
                                        <th class="min-w-250px">Tên Miền</th>
                                        <th class="min-w-150px">Trạng Thái</th>
                                        <th class="min-w-150px">Giá</th>
                                        <th class="min-w-150px">Hết Hạn</th>
                                        <th class="min-w-100px">Hành Động</th>
                                    </tr>
                                @endif
                            </thead>
                            <tbody class="text-gray-600 fw-semibold">
                                @php $i = 1; @endphp
                                @foreach ($data['orders'] ?? [] as $order)
                                    @if($tab == 'ai')
                                        <tr>
                                            <td><span class="badge badge-light-primary fs-7 fw-bold">{{ $i++ }}</span></td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    @if(isset($order->aiAccount) && $order->aiAccount->image)
                                                        <div class="symbol symbol-50px me-3" style="border-radius: 8px; overflow: hidden;">
                                                            <img src="{{ $order->aiAccount->image }}" class="" alt="">
                                                        </div>
                                                    @endif
                                                    <div class="d-flex justify-content-start flex-column">
                                                        <a href="/ai-account/{{ $order->aiAccount->slug ?? $order->ai_account_id }}" class="text-gray-800 fw-bold text-hover-primary mb-1 fs-6">
                                                            {{ $order->aiAccount->name ?? 'Tài khoản đã bị xóa' }}
                                                        </a>
                                                        <span class="text-gray-500 fw-semibold d-block fs-7">
                                                            Người bán: 
                                                            @if(isset($order->seller))
                                                                <a href="{{ route('account.chat', ['seller_id' => $order->seller->id]) }}" class="badge badge-light-success text-hover-primary" title="Chat với người bán">
                                                                    <i class="ki-duotone ki-messages fs-8 text-success me-1"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span></i> {{ $order->seller->username }}
                                                                </a>
                                                            @else
                                                                @php
                                                                    $admin = \App\Models\User::where('level', 2)->first();
                                                                    $adminUsername = $admin->username ?? 'admin';
                                                                    $adminId = $admin->id ?? 1;
                                                                @endphp
                                                                <a href="{{ route('account.chat', ['seller_id' => $adminId]) }}" class="badge badge-light-success text-hover-primary" title="Chat với admin">
                                                                    <i class="ki-duotone ki-messages fs-8 text-success me-1"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span></i> {{ $adminUsername }}
                                                                </a>
                                                            @endif
                                                        </span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge badge-light-info fs-7">{{ $order->variant->name ?? 'N/A' }}</span>
                                            </td>
                                            <td>
                                                <span class="badge badge-light-dark fs-7">1</span>
                                            </td>
                                            <td>
                                                <span class="text-success fw-bold">{{ number_format($order->price ?? 0) }}đ</span>
                                            </td>
                                            <td>
                                                @php
                                                    $sellerUsername = isset($order->seller) ? $order->seller->username : (\App\Models\User::where('level', 2)->first()->username ?? 'admin');
                                                @endphp
                                                @if(isset($order->aiAccount))
                                                    <a href="{{ route('shop.profile', $sellerUsername) }}" target="_blank" class="btn btn-sm btn-light-primary">
                                                        Xem thông tin
                                                    </a>
                                                @else
                                                    <span class="text-muted">Không có thông tin</span>
                                                @endif
                                            </td>
                                            <td>
                                                {{ \Carbon\Carbon::parse($order->created_at)->format('d/m/Y H:i') }}
                                            </td>
                                            <td>
                                                <a href="/ai-account/{{ $order->aiAccount->slug ?? $order->ai_account_id }}" class="btn btn-sm btn-icon btn-light-primary">
                                                    <i class="ki-duotone ki-eye fs-2"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @elseif($tab == 'code')
                                        @php
                                            $seller = $order->product ? $order->product->user : null;
                                        @endphp
                                        <tr>
                                            <td><span class="badge badge-light-primary fs-7 fw-bold">{{ $i++ }}</span></td>
                                            <td>
                                                <div class="d-flex justify-content-start flex-column">
                                                    <a href="#" class="text-gray-800 fw-bold text-hover-primary mb-1 fs-6">
                                                        {{ $order->product->name ?? 'Mã nguồn đã bị xóa' }}
                                                    </a>
                                                    <span class="text-gray-500 fw-semibold d-block fs-7">
                                                        Người bán: 
                                                        @if(isset($seller))
                                                            <a href="{{ route('account.chat', ['seller_id' => $seller->id]) }}" class="badge badge-light-success text-hover-primary" title="Chat với người bán">
                                                                <i class="ki-duotone ki-messages fs-8 text-success me-1"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span></i> {{ $seller->username }}
                                                            </a>
                                                        @else
                                                            @php
                                                                $admin = \App\Models\User::where('level', 2)->first();
                                                                $adminUsername = $admin->username ?? 'admin';
                                                                $adminId = $admin->id ?? 1;
                                                            @endphp
                                                            <a href="{{ route('account.chat', ['seller_id' => $adminId]) }}" class="badge badge-light-success text-hover-primary" title="Chat với admin">
                                                                <i class="ki-duotone ki-messages fs-8 text-success me-1"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span></i> {{ $adminUsername }}
                                                            </a>
                                                        @endif
                                                    </span>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="text-success fw-bold">{{ number_format($order->price ?? 0) }}đ</span>
                                            </td>
                                            <td>
                                                {{ \Carbon\Carbon::parse($order->created_at)->format('d/m/Y H:i') }}
                                            </td>
                                            <td>
                                                @if(optional($order->product)->link_down)
                                                <a href="{{ Helper::muabanwebsite_dec($order->product->link_down) }}" target="_blank" class="btn btn-sm btn-primary">
                                                    <i class="ki-duotone ki-cloud-download fs-2"><span class="path1"></span><span class="path2"></span></i> Tải về
                                                </a>
                                                @endif
                                            </td>
                                        </tr>
                                    @elseif($tab == 'domain')
                                        <tr>
                                            <td><span class="badge badge-light-primary fs-7 fw-bold">{{ $i++ }}</span></td>
                                            <td>
                                                <div class="d-flex justify-content-start flex-column">
                                                    <span class="text-gray-800 fw-bold mb-1 fs-6">
                                                        {{ $order->domain_name ?? 'Tên miền đã bị xóa' }}
                                                    </span>
                                                    <span class="text-gray-500 fw-semibold d-block fs-7">
                                                        Nhà cung cấp: <span class="badge badge-light-success">Hệ Thống</span>
                                                    </span>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="text-success fw-bold">{{ number_format($order->price ?? 0) }}đ</span>
                                            </td>
                                            <td>
                                                @if($order->status == '1')
                                                    <span class="badge badge-light-success">Đang hoạt động</span>
                                                @elseif($order->status == '2')
                                                    <span class="badge badge-light-danger">Hết hạn</span>
                                                @else
                                                    <span class="badge badge-light-warning">Chờ xử lý</span>
                                                @endif
                                            </td>
                                            <td>
                                                {{ \Carbon\Carbon::parse($order->created_at)->format('d/m/Y H:i') }}
                                            </td>
                                            <td>
                                                <a href="/domain/history" class="btn btn-sm btn-light-primary">
                                                    Quản lý
                                                </a>
                                            </td>
                                        </tr>
                                    @elseif($tab == 'hosting')
                                        <tr>
                                            <td><span class="badge badge-light-primary fs-7 fw-bold">{{ $i++ }}</span></td>
                                            <td>
                                                <div class="d-flex justify-content-start flex-column">
                                                    <span class="text-gray-800 fw-bold mb-1 fs-6">
                                                        {{ $order->domain_name }}
                                                    </span>
                                                    <span class="text-gray-500 fw-semibold d-block fs-7">
                                                        Username: <span class="badge badge-light-info">{{ $order->username }}</span>
                                                    </span>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge badge-light-dark fs-7">{{ $order->ip }}</span>
                                            </td>
                                            <td>
                                                <span class="text-success fw-bold">{{ number_format($order->total ?? 0) }}đ</span>
                                            </td>
                                            <td>
                                                @if($order->status == '1')
                                                    <span class="badge badge-light-warning">Chờ xử lý</span>
                                                @elseif($order->status == '2')
                                                    <span class="badge badge-light-success">Đang hoạt động</span>
                                                @elseif($order->status == '3')
                                                    <span class="badge badge-light-danger">Tạm khóa</span>
                                                @else
                                                    <span class="badge badge-light-dark">Hết hạn</span>
                                                @endif
                                            </td>
                                            <td>
                                                {{ date('d/m/Y H:i', $order->end_date) }}
                                            </td>
                                            <td>
                                                <a href="{{ route('hosting.view', ['id' => $order->id]) }}" class="btn btn-sm btn-light-primary">
                                                    Quản lý
                                                </a>
                                            </td>
                                        </tr>
                                    @elseif($tab == 'logo')
                                        <tr>
                                            <td><span class="badge badge-light-primary fs-7 fw-bold">{{ $i++ }}</span></td>
                                            <td>
                                                <div class="d-flex justify-content-start flex-column">
                                                    <span class="text-gray-800 fw-bold mb-1 fs-6">
                                                        {{ $order->name }}
                                                    </span>
                                                    <span class="text-gray-500 fw-semibold d-block fs-7">
                                                        Mã GD: <span class="badge badge-light-info">{{ $order->trans_id }}</span>
                                                    </span>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="text-success fw-bold">{{ number_format($order->price ?? 0) }}đ</span>
                                            </td>
                                            <td>
                                                @if($order->status == '1')
                                                    <span class="badge badge-light-success">Đã hoàn thành</span>
                                                @else
                                                    <span class="badge badge-light-warning">Đang thiết kế</span>
                                                @endif
                                            </td>
                                            <td>
                                                {{ \Carbon\Carbon::parse($order->created_at)->format('d/m/Y H:i') }}
                                            </td>
                                            <td>
                                                @if($order->status == '1')
                                                    <a href="{{ $order->link_dow }}" target="_blank" class="btn btn-sm btn-primary">
                                                        <i class="ki-duotone ki-cloud-download fs-2"><span class="path1"></span><span class="path2"></span></i> Nhận Logo
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                                    @elseif($tab == 'web')
                                        <tr>
                                            <td><span class="badge badge-light-primary fs-7 fw-bold">{{ $i++ }}</span></td>
                                            <td>
                                                <div class="d-flex justify-content-start flex-column">
                                                    <span class="text-gray-800 fw-bold mb-1 fs-6">
                                                        {{ $order->domain }}
                                                    </span>
                                                    <span class="text-gray-500 fw-semibold d-block fs-7">
                                                        User: <span class="badge badge-light-info">{{ $order->tk }}</span>
                                                    </span>
                                                </div>
                                            </td>
                                            <td>
                                                @if($order->status == '1' || $order->status == '2')
                                                    <span class="badge badge-light-success">Đang hoạt động</span>
                                                @elseif($order->status == '3')
                                                    <span class="badge badge-light-danger">Tạm khóa</span>
                                                @elseif($order->status == '4')
                                                    <span class="badge badge-light-dark">Hết hạn</span>
                                                @else
                                                    <span class="badge badge-light-warning">Chờ xử lý</span>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="text-success fw-bold">{{ number_format($order->price ?? 0) }}đ</span>
                                            </td>
                                            <td>
                                                {{ date('d/m/Y H:i', $order->time_exp) }}
                                            </td>
                                            <td>
                                                <a href="/web/history" class="btn btn-sm btn-light-primary">
                                                    Quản lý
                                                </a>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!--end::Post-->
    </div>
    
    <!-- Modal for Account Info -->
    <div class="modal fade" tabindex="-1" id="accountInfoModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content shadow-sm" style="border-radius: 16px; border: 1px solid rgba(255, 255, 255, 0.15);">
                <div class="modal-header border-0 pb-0">
                    <h3 class="modal-title fw-bolder fs-2 text-gray-900">Thông tin tài khoản</h3>
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close" style="border-radius: 50%;">
                        <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                    </div>
                </div>
                <div class="modal-body py-5">
                    <div class="p-5 bg-light-primary rounded" style="border: 1px dashed #009ef7;">
                        <p id="accountInfoContent" class="fs-5 text-gray-800 fw-semibold m-0" style="white-space: pre-wrap; word-break: break-all;"></p>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0 justify-content-between">
                    <button type="button" class="btn btn-light rounded-pill px-6" data-bs-dismiss="modal">Đóng</button>
                    <button type="button" class="btn btn-primary rounded-pill px-8 fw-bold btn-copy-info shadow-sm">
                        <i class="ki-duotone ki-copy fs-2 me-2"><span class="path1"></span><span class="path2"></span></i> Copy Thông Tin
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Include Seller Chat Drawer -->

@endsection
@section('scripts')
    <script>
        $("#kt_datatable_orders").DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.13.6/i18n/vi.json"
            }
        });
        
        $(document).on('click', '.btn-view-info', function() {
            var info = $(this).data('info');
            $('#accountInfoContent').html(info);
            $('#accountInfoModal').modal('show');
        });
        
        $('.btn-copy-info').on('click', function() {
            var text = $('#accountInfoContent').text();
            navigator.clipboard.writeText(text).then(function() {
                toastr.success("Đã copy thông tin tài khoản");
            }, function(err) {
                toastr.error("Lỗi khi copy");
            });
        });
    </script>
@endsection
