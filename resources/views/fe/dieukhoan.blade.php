@php use App\Helpers\Helper; @endphp
@extends('layouts.app')
@section('title', 'Điều khoản của website')
@section('content')
    <div class="toolbar d-flex flex-stack py-3 py-lg-5" id="kt_toolbar">
        <div id="kt_toolbar_container" class="container-xxl d-flex flex-stack flex-wrap">
            <div class="page-title d-flex flex-column me-3">
                <h1 class="d-flex text-gray-900 fw-bold my-1 fs-3">
                    Điều Khoản Dịch Vụ
                </h1>
                <ul class="breadcrumb breadcrumb-dot fw-semibold text-gray-600 fs-7 my-1">
                    <li class="breadcrumb-item text-gray-600">
                        <a href="/" class="text-gray-600 text-hover-primary">
                            Home
                        </a>
                    </li>
                    <li class="breadcrumb-item text-gray-600">Điều Khoản</li>
                </ul>
            </div>
        </div>
    </div>
    <div id="kt_content_container" class="d-flex flex-column-fluid align-items-start  container-xxl ">
        <div class="content flex-row-fluid" id="kt_content">
            <div class="card">
                <div class="card-body p-5 px-lg-19 py-lg-16">
                    <div class="mb-14 ">
                        <div class="mb-15">
                            <h1 class="fs-2x text-gray-900 mb-6 text-center">Điều Khoản Sử Dụng Website</h1>
                            <div class="fs-5 text-gray-600 fw-semibold">
                                {!! base64_decode(Helper::getNotice('page_privacy_policy')) !!}
                            </div>
                        </div>
                       
                    </div>
                    <div class="card mb-4 bg-light text-center mb-4">
                        <div class="card-body py-12">
                            <a href="#" class="mx-4">
                                <img src="/assets/media/svg/brand-logos/facebook-4.svg" class="h-30px my-2" alt="">
                            </a>
                            <a href="#" class="mx-4">
                                <img src="/assets/media/svg/brand-logos/instagram-2-1.svg" class="h-30px my-2"
                                    alt="">
                            </a>
                            <a href="#" class="mx-4">
                                <img src="/assets/media/svg/brand-logos/github.svg" class="h-30px my-2" alt="">
                            </a>
                            <a href="#" class="mx-4">
                                <img src="/assets/media/svg/brand-logos/behance.svg" class="h-30px my-2" alt="">
                            </a>
                            <a href="#" class="mx-4">
                                <img src="/assets/media/svg/brand-logos/pinterest-p.svg" class="h-30px my-2"
                                    alt="">
                            </a>
                            <a href="#" class="mx-4">
                                <img src="/assets/media/svg/brand-logos/twitter.svg" class="h-30px my-2" alt="">
                            </a>
                            <a href="#" class="mx-4">
                                <img src="/assets/media/svg/brand-logos/dribbble-icon-1.svg" class="h-30px my-2"
                                    alt="">
                            </a>
                            <!--end::Icon-->
                        </div>
                        <!--end::Body-->
                    </div>
                    <!--end::Card-->
                </div>
                <!--end::Body-->
            </div>
        </div>
    </div>
@endsection
