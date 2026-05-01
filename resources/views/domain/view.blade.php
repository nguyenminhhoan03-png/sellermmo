@php use App\Helpers\Helper; @endphp 
@php use App\Models\Product; @endphp
@php use App\Models\Transaction; @endphp
@extends('layouts.app') 
@section('title', $pageTitle) 
@section('content')
<div class="toolbar d-flex flex-stack py-3 py-lg-5 mb-5" id="kt_toolbar">
    <!--begin::Container-->
    <div
        id="kt_toolbar_container"
        class="container-xxl d-flex flex-stack flex-wrap"
    >
        <!--begin::Page title-->
        <div class="page-title d-flex flex-column me-3">
            <!--begin::Title-->
            <h1 class="d-flex text-gray-900 fw-bold my-1 fs-3">
                Lịch sử mua tên miền
            </h1>
            <!--end::Title-->

            <!--begin::Breadcrumb-->
            <ul
                class="breadcrumb breadcrumb-dot fw-semibold text-gray-600 fs-7 my-1"
            >
                <!--begin::Item-->
                <li class="breadcrumb-item text-gray-600">
                    <a href="/" class="text-gray-600 text-hover-primary">
                        Home
                    </a>
                </li>
                <!--end::Item-->
                <!--begin::Item-->
                <li class="breadcrumb-item text-gray-600">{{ $user->name }}</li>
                <!--end::Item-->
                <!--begin::Item-->
                <li class="breadcrumb-item text-gray-500">{{ $domain->domain_name }}</li>
                <!--end::Item-->
            </ul>
            <!--end::Breadcrumb-->
        </div>
        
    </div>
    <!--end::Container-->
</div>
<div id="kt_content_container" class="d-flex flex-column-fluid align-items-start  container-xxl ">
    <!--begin::Post-->
    <div class="content flex-row-fluid" id="kt_content">
        <div class="d-flex flex-column p-7">
            <div class="row">
                <!-- Phần 1 -->
                <div class="col-12 col-md-6 mb-5">
            <div class="card">
                <div class="card-body">
                    <div class="flex-lg-row-fluid me-xl-15 mb-20 mb-xl-0">
                        <div class="mb-0">
                            <h1 class="text-gray-900 mb-10">Chi Tiết Tên Miền</h1>
                            <div class="mb-10">
                                <div class="d-flex mb-10">
                                    <i class="ki-duotone ki-abstract-39 fs-2x me-5 ms-n1 mt-2 text-success"><span class="path1"></span><span class="path2"></span></i>
                                    <div class="d-flex flex-column">
                                        <div class="d-flex align-items-center mb-2">
                                            <a href="#" class="text-gray-900 text-hover-primary fs-4 me-3 fw-semibold">Tên Miền</a>
                                        </div>
                                        <span class="text-muted fw-semibold fs-6">{{ $domain->domain_name }}</span>
                                    </div>
                                </div>
                                <div class="d-flex mb-10">
                                    <i class="ki-duotone ki-add-files fs-2x me-5 ms-n1 mt-2 text-warning"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                                    <div class="d-flex flex-column">
                                        <div class="d-flex align-items-center mb-2">
                                            <a href="#" class="text-gray-900 text-hover-primary fs-4 me-3 fw-semibold">Nameservers</a>
                                        </div>
                                        @php
                                        $lines = explode(",", $domain->ns);
                                        @endphp         
                                        @foreach ($lines as $line)
                                        <span class="text-muted fw-semibold fs-6">{{ $line }}</span>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="d-flex mb-10">
                                    <i class="ki-duotone ki-calendar fs-2x me-5 ms-n1 mt-2 text-success"><span class="path1"></span><span class="path2"></span></i>
                                    <div class="d-flex flex-column">
                                        <div class="d-flex align-items-center mb-2">
                                            <a href="#" class="text-gray-900 text-hover-primary fs-4 me-3 fw-semibold">Ngày đăng ký</a>
                                        </div>
                                        <span class="text-muted fw-semibold fs-6">{{ $domain->created_at }}</span>
                                    </div>
                                </div>
                                <div class="d-flex mb-10">
                                    <i class="ki-duotone ki-calendar fs-2x me-5 ms-n1 mt-2 text-warning"><span class="path1"></span><span class="path2"></span></i>
                                    <div class="d-flex flex-column">
                                        <div class="d-flex align-items-center mb-2">
                                            <a href="#" class="text-gray-900 text-hover-primary fs-4 me-3 fw-semibold">Ngày hết hạn</a>
                                        </div>
                                        <span class="text-muted fw-semibold fs-6">{{ $domain->expired_date }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="flex-lg-row-fluid me-xl-15 mb-20 mb-xl-0">
                        <div class="mb-0">
                            <h1 class="text-gray-900 mb-10">Thông tin chủ sở hữu</h1>
                            <div class="mb-10">
                                <div class="d-flex mb-10">
                                    <i class="ki-duotone ki-security-user fs-2x me-5 ms-n1 mt-2 text-primary"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                                    <div class="d-flex flex-column">
                                        <div class="d-flex align-items-center mb-2">
                                            <a href="/account/profile" class="text-gray-900 text-hover-primary fs-4 me-3 fw-semibold">Kiểu chủ thể </a>
                                        </div>
                                        <span class="text-muted fw-semibold fs-6">Cá Nhân</span>
                                    </div>
                                </div>
                                <div class="d-flex mb-10">
                                    <i class="ki-duotone ki-security-user fs-2x me-5 ms-n1 mt-2 text-success"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                                    <div class="d-flex flex-column">
                                        <div class="d-flex align-items-center mb-2">
                                            <a href="/account/profile" class="text-gray-900 text-hover-primary fs-4 me-3 fw-semibold">Tên chủ thể</a>
                                        </div>
                                        <span class="text-muted fw-semibold fs-6">{{ $user->name }}</span>
                                    </div>
                                </div>
                                <div class="d-flex mb-10">
                                    <i class="ki-duotone ki-send fs-2x me-5 ms-n1 mt-2 text-success"><span class="path1"></span><span class="path2"></span></i>
                                    <div class="d-flex flex-column">
                                        <div class="d-flex align-items-center mb-2">
                                            <a href="#" class="text-gray-900 text-hover-primary fs-4 me-3 fw-semibold">Email</a>
                                        </div>
                                        <span class="text-muted fw-semibold fs-6">{{ $user->email }}</span>
                                    </div>
                                </div>
                                <div class="d-flex mb-10">
                                    <i class="ki-duotone ki-airplane  fs-2x me-5 ms-n1 mt-2 text-danger"><span class="path1"></span><span class="path2"></span></i>
                                    <div class="d-flex flex-column">
                                        <div class="d-flex align-items-center mb-2">
                                            <a href="#" class="text-gray-900 text-hover-primary fs-4 me-3 fw-semibold">Quốc gia</a>
                                        </div>
                                        <span class="text-muted fw-semibold fs-6">Việt Nam</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>                        
        </div>
        </div>
    </div>
    </div>
        </div>
@endsection
@section('scripts')
@endsection
