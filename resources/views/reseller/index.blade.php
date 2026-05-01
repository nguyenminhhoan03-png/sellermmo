@php use App\Helpers\Helper; @endphp 
@php use App\Models\User; @endphp
@extends('layouts.app') 
@section('title', $pageTitle) 
@section('content')
<style>
    .muabanwebsite {
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
      display: block;
      width: 100%;
      max-width: 250px;
    }
    .posts-item {
        position: relative;
    }

      .loading-indicator {
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        background: rgba(255, 255, 255, 0.8);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 1000;
        opacity: 0;
        visibility: hidden;
        transition: opacity 0.3s ease, visibility 0.3s ease;
    }
    .loading-indicator.show {
        opacity: 1;
        visibility: visible;
    }
    .spinner {
        width: 40px;
        height: 40px;
        border: 4px solid #e41212;
        border-top-color: #fff1e7;
        border-radius: 50%;
        animation: spin 0.5s linear infinite;
    }
    
    @keyframes spin {
        to {
            transform: rotate(360deg);
        }
    }
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
            <h1 class="d-flex text-gray-900 fw-bold my-1 fs-3">Thông tin người bán</h1>
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
                <li class="breadcrumb-item text-gray-600">Reseller Profile</li>
                <!--end::Item-->
                <!--begin::Item-->
                <li class="breadcrumb-item text-gray-500">{{ $reseller->name ?? 'Chưa đăng nhập' }}</li>
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
                                        >{{ $reseller->name ?? 'Chưa đăng nhập' }}</a
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
                                @if ($reseller->level == 1)
                                    <a href="#" class="d-flex align-items-center text-gray-500 text-hover-primary me-5 mb-2">
                                        <i class="ki-duotone ki-profile-circle fs-4 me-1">
                                            <span class="path1"></span>
                                            <span class="path2"></span>
                                            <span class="path3"></span>
                                        </i>
                                        Admin
                                    </a>
                                @elseif ($reseller->level == 2)                                  
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
                                        {{ $reseller->email ?? 'example@local' }}
                                    </a>
                                </div>
                                <!--end::Info-->
                            </div>
                            <div class="d-flex my-4">
                                @php
                                $skills = explode(',', $reseller->skill);
                                @endphp
                                @foreach ($skills as $skill)
                                <a href="#" class="btn btn-sm btn-light me-2">
                                <span class="indicator-label">{{ $skill }}</span>
                                </a>
                                @endforeach
                            </div>
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
                                            <small>{{ number_format($pro_reseller->count() ?? 0) }}</small>
                                            </div>
                                        </div>
                                        <!--end::Number-->

                                        <!--begin::Label-->
                                        <div
                                            class="fw-semibold fs-6 text-gray-500"
                                        >
                                            Số sản phẩm
                                        </div>
                                        <!--end::Label-->
                                    </div>
                                    <!--end::Stat-->

                                    <!--begin::Stat-->
                                    <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
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
                                            <small>{{ number_format($pro_reseller->sum('sold') ?? 0) }}</small>
                                            </div>
                                        </div>
                                        <!--end::Number-->

                                        <!--begin::Label-->
                                        <div
                                            class="fw-semibold fs-6 text-gray-500"
                                        >
                                            Tổng bán
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
                <ul class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bold">
                            
                    <div class="col-12 mb-5">
                        
                                    <!--begin::Notice-->
                                    <div class="notice d-flex bg-light-danger rounded border-danger border border-dashed h-lg-100 p-6">
                                        
                                        <!--begin::Wrapper-->
                                        <div class="d-flex flex-stack flex-grow-1 flex-wrap flex-md-nowrap">
                                                        <!--begin::Content-->
                                                <div class="mb-3 mb-md-0 fw-semibold">
                                                                        <h4 class="text-gray-900 fw-bold">Giới thiệu về {{ $reseller->name }} : </h4>
                                                    
                                                                        <div class="fs-6 text-gray-700 pe-7">{{ $reseller->gioi_thieu ?? 'không có' }}</div>
                                                                </div>
                                                <!--end::Content-->
                                            
                                                        <!--begin::Action-->
                                                
                                                <!--end::Action-->
                                                </div>
                                        <!--end::Wrapper-->  
                                    </div>
                                    <!--end::Notice-->
                                                    </div>
                        </ul>
                <!--end::Details-->
            </div>
        </div>
       
        <div class="row mb-2 justify-content-between align-items-end">
            <div class="col-auto">
                <h2 class="fw-bold section-title">Sản phẩm của {{ $reseller->name }}</h2>
                <p class="section-desc">
                    Dưới đây là toàn bộ mã nguồn đã được chúng tôi cấp phép bán hàng
                </p>
            </div>
            <div class="col-auto mt-30 mt-xl-0 mb-5">
                <div class="filters-btns d-flex flex-wrap align-items-center gap-3">
                    <button class="btn btn-outline btn-outline-dashed btn-outline-danger btn-active-light-danger active" data-filter=".category1">
                        Tất cả
                    </button>
                    <button class="btn btn-outline btn-outline-dashed btn-outline-danger btn-active-light-danger" data-filter=".category2">
                        Bán chạy
                    </button>
                    <button class="btn btn-outline btn-outline-dashed btn-outline-danger btn-active-light-danger" data-filter=".category3">
                        Giá rẻ
                    </button>
                    <button class="btn btn-outline btn-outline-dashed btn-outline-danger btn-active-light-danger" data-filter=".category4">
                        Miễn phí
                    </button>
                </div>
            </div>
        </div>

        <div class="row gy-5 g-xl-12">
            <div id="loading-indicator" class="loading-indicator">
              <div class="spinner">
              </div>
              </div>
            <!--begin::Col-->
            <!--begin::item-->
            @if($pro_reseller->isEmpty())
    <div class="col-12 text-center">
        <svg width="184" height="152" viewBox="0 0 184 152" xmlns="http://www.w3.org/2000/svg">
            <g fill="none" fill-rule="evenodd">
                <g transform="translate(24 31.67)">
                    <ellipse fill-opacity=".8" fill="#F5F5F7" cx="67.797" cy="106.89" rx="67.797" ry="12.668"></ellipse>
                    <path d="M122.034 69.674L98.109 40.229c-1.148-1.386-2.826-2.225-4.593-2.225h-51.44c-1.766 0-3.444.839-4.592 2.225L13.56 69.674v15.383h108.475V69.674z" fill="#AEB8C2"></path>
                    <path d="M101.537 86.214L80.63 61.102c-1.001-1.207-2.507-1.867-4.048-1.867H31.724c-1.54 0-3.047.66-4.048 1.867L6.769 86.214v13.792h94.768V86.214z" fill="url(#linearGradient-1)" transform="translate(13.56)"></path>
                    <path d="M33.83 0h67.933a4 4 0 0 1 4 4v93.344a4 4 0 0 1-4 4H33.83a4 4 0 0 1-4-4V4a4 4 0 0 1 4-4z" fill="#F5F5F7"></path>
                    <path d="M42.678 9.953h50.237a2 2 0 0 1 2 2V36.91a2 2 0 0 1-2 2H42.678a2 2 0 0 1-2-2V11.953a2 2 0 0 1 2-2zM42.94 49.767h49.713a2.262 2.262 0 1 1 0 4.524H42.94a2.262 2.262 0 0 1 0-4.524zM42.94 61.53h49.713a2.262 2.262 0 1 1 0 4.525H42.94a2.262 2.262 0 0 1 0-4.525zM121.813 105.032c-.775 3.071-3.497 5.36-6.735 5.36H20.515c-3.238 0-5.96-2.29-6.734-5.36a7.309 7.309 0 0 1-.222-1.79V69.675h26.318c2.907 0 5.25 2.448 5.25 5.42v.04c0 2.971 2.37 5.37 5.277 5.37h34.785c2.907 0 5.277-2.421 5.277-5.393V75.1c0-2.972 2.343-5.426 5.25-5.426h26.318v33.569c0 .617-.077 1.216-.221 1.789z" fill="#DCE0E6"></path>
                </g>
                <path d="M149.121 33.292l-6.83 2.65a1 1 0 0 1-1.317-1.23l1.937-6.207c-2.589-2.944-4.109-6.534-4.109-10.408C138.802 8.102 148.92 0 161.402 0 173.881 0 184 8.102 184 18.097c0 9.995-10.118 18.097-22.599 18.097-4.528 0-8.744-1.066-12.28-2.902z" fill="#DCE0E6"></path>
                <g transform="translate(149.65 15.383)" fill="#FFF">
                    <ellipse cx="20.654" cy="3.167" rx="2.849" ry="2.815"></ellipse>
                    <path d="M5.698 5.63H0L2.898.704zM9.259.704h4.985V5.63H9.259z"></path>
                </g>
            </g>
        </svg>
        <p>Người bán chưa có sản phẩm nào.</p>
    </div>
@else
    @foreach($pro_reseller as $product)
        @php
            $user = User::where('id', $product->user_id)->first();
        @endphp
        <div class="col-xl-3 dvr-item category1 @if($product->sold > 100)category2 @endif @if($product->price < 1000000)category3 @endif @if($product->price == 0)category4 @endif">
            <div class="card card-xl-stretch mb-3 mb-xl-3 posts-item shadow-sm">
                <div class="w-100 d-flex flex-column flex-center rounded-3 bg-opacity-55 py-8 px-8">
                    <div class="mb-3 text-left position-relative">
                        <h1 class="text-dark mb-5 fw-bolder">
                            <a class="overlay" data-fslightbox="lightbox-hot-sales" href="{{ $product->images }}">
                                <img class="overlay-wrapper card-img-top rounded hover-elevate-up lazyload" src="{{ asset('assets/images/null.svg') }}" data-src="{{ $product->images }}" alt="{{ $product->name }}"/>
                            </a>
                        </h1>
                        <div class="separator separator-dashed border-gray-300 mt-5"></div>
                        <div class="mt-2">
                            <a href="/view/{{ $product->slug ?? $product->id }}" class="fs-4 text-gray-900 fw-bold text-hover-primary text-gray-900 lh-base muabanwebsite">
                              {{ $product->name }}
                            </a>
                            <div class="fw-semibold fs-5 text-gray-600 text-gray-900 mt-3">
                                <div class="d-flex align-items-center pe-2">
                                    <div class="symbol symbol-35px symbol-circle me-3">
                                        <img src="{{ asset('assets/media/avatars/user-placeholder.svg') }}" alt="" />
                                    </div>
                                    <div class="d-flex flex-column fs-5 fw-bold">
                                        <a href="/resller/{{ $user->id }}" class="text-gray-700 text-hover-primary">{{ $user->name }}</a>
                                        <small class="text-muted">{{ $product->created_at->diffForHumans() }}</small>
                                    </div>
                                </div>
                            </div>
                            <div class="separator separator-dashed border-gray-300 mt-5"></div>
                            <div class="fs-6 fw-bold mt-5 d-flex flex-stack">
                                <span class="badge border border-dashed fs-2 fw-bold text-gray-900 p-2">
                                    <span class="fs-6 fw-semibold text-primary">{{ number_format($product->price - $product->price * $product->ck / 100, 0, ',', ',') }}₫</span></span>
                                <a href="/view/{{ $product->slug ?? $product->id }}" class="btn btn-sm ripple btn-danger rounded-6 hover-scale">Mua Ngay</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endif
          </div>

          <script>
            document.addEventListener("DOMContentLoaded", function() {
                const filterButtons = document.querySelectorAll('.btn-outline-danger');
                const gridItems = document.querySelectorAll('.dvr-item');
                const loadingIndicator = document.getElementById('loading-indicator');
            
                filterButtons.forEach(button => {
                    button.addEventListener('click', function() {
                        // Bắt đầu loading
                        loadingIndicator.classList.add('show');
            
                        // Xóa class 'active' khỏi tất cả các nút
                        filterButtons.forEach(btn => btn.classList.remove('active'));
            
                        // Thêm class 'active' cho nút đã chọn
                        this.classList.add('active');
            
                        const filterValue = this.getAttribute('data-filter');
            
                        // Hiển thị các item dựa trên giá trị filter
                        gridItems.forEach(item => {
                            if (filterValue === '.category1' || item.classList.contains(filterValue.replace('.', ''))) {
                                item.style.display = ''; // Hiển thị item
                            } else {
                                item.style.display = 'none'; // Ẩn item
                            }
                        });
            
                        // Dừng loading sau 300ms
                        setTimeout(function() {
                            loadingIndicator.classList.remove('show');
                        }, 300);
                    });
                });
            });
            </script>

        <!--end::Navbar-->
        <!--begin::Row-->
    </div>
    <!--end::Post-->
</div>
@endsection
@section('scripts')

@endsection
