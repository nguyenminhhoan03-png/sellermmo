@php use App\Helpers\Helper; @endphp 
@php use App\Models\ApiLogo; @endphp
@extends('layouts.app') 
@section('title', $pageTitle) 
@section('content')
<style>
    .custom-card {
      margin-bottom: 50px;
    }
  </style>
<style type="text/css" data-styled-jsx="">.qrcode__scan__container.jsx-d22f6bd0771ae323{padding:15px;background-color:white;width:230px;height:230px;-webkit-border-radius:20px;-moz-border-radius:20px;border-radius:20px;-webkit-border-radius:15px;-moz-border-radius:15px;border-radius:15px;margin:0 auto}.qrcode__image.jsx-d22f6bd0771ae323{width:100%}.qrcode__image.jsx-d22f6bd0771ae323 img.jsx-d22f6bd0771ae323{width:100%}.qrcode__scan.jsx-d22f6bd0771ae323{width:200px;height:200px;margin:0 auto;overflow:hidden;background-color:white;position:relative;display:-webkit-box;display:-webkit-flex;display:-moz-box;display:-ms-flexbox;display:flex;-webkit-box-align:center;-webkit-align-items:center;-moz-box-align:center;-ms-flex-align:center;align-items:center;-webkit-box-pack:center;-webkit-justify-content:center;-moz-box-pack:center;-ms-flex-pack:center;justify-content:center}.qrcode__border.jsx-d22f6bd0771ae323{position:absolute;width:100%;height:100%;top:0;left:0;z-index:5;opacity:.9;pointer-events:none}.qrcode__gradient.jsx-d22f6bd0771ae323{position:absolute;opacity:.6;width:98%;height:98%;top:1%;left:1%;z-index:6;-webkit-transform:translate3d(0,-110%,0);-moz-transform:translate3d(0,-110%,0);transform:translate3d(0,-110%,0);-webkit-animation:QRCodeScan 3s infinite cubic-bezier(.45,.03,.81,.63);-moz-animation:QRCodeScan 3s infinite cubic-bezier(.45,.03,.81,.63);-o-animation:QRCodeScan 3s infinite cubic-bezier(.45,.03,.81,.63);animation:QRCodeScan 3s infinite cubic-bezier(.45,.03,.81,.63);-webkit-backface-visibility:hidden;-moz-backface-visibility:hidden;backface-visibility:hidden}@-webkit-keyframes QRCodeScan{0%{-webkit-transform:translate3d(0,-110%,0);transform:translate3d(0,-110%,0)}90%{-webkit-transform:translate3d(0,30%,0);transform:translate3d(0,30%,0)}100%{-webkit-transform:translate3d(0,30%,0);transform:translate3d(0,30%,0)}}@-moz-keyframes QRCodeScan{0%{-moz-transform:translate3d(0,-110%,0);transform:translate3d(0,-110%,0)}90%{-moz-transform:translate3d(0,30%,0);transform:translate3d(0,30%,0)}100%{-moz-transform:translate3d(0,30%,0);transform:translate3d(0,30%,0)}}@-o-keyframes QRCodeScan{0%{transform:translate3d(0,-110%,0)}90%{transform:translate3d(0,30%,0)}100%{transform:translate3d(0,30%,0)}}@keyframes QRCodeScan{0%{-webkit-transform:translate3d(0,-110%,0);-moz-transform:translate3d(0,-110%,0);transform:translate3d(0,-110%,0)}90%{-webkit-transform:translate3d(0,30%,0);-moz-transform:translate3d(0,30%,0);transform:translate3d(0,30%,0)}100%{-webkit-transform:translate3d(0,30%,0);-moz-transform:translate3d(0,30%,0);transform:translate3d(0,30%,0)}}</style>
<div class="toolbar d-flex flex-stack py-3 py-lg-5 mb-5" id="kt_toolbar">
    <div id="kt_toolbar_container" class="container-xxl d-flex flex-stack flex-wrap">
        <div class="page-title d-flex flex-column me-3">
            <h1 class="d-flex text-gray-900 fw-bold my-1 fs-3">
                Cổng Nạp Tiền
            </h1>
            <ul class="breadcrumb breadcrumb-dot fw-semibold text-gray-600 fs-7 my-1">
                <li class="breadcrumb-item text-gray-600">
                    <a href="/" class="text-gray-600 text-hover-primary">
                        Home
                    </a>
                </li>
                <li class="breadcrumb-item text-gray-600">Recharge</li>
                <li class="breadcrumb-item text-gray-500">ATM</li>
            </ul>
        </div>
    </div>
</div>
<div id="kt_content_container" class="d-flex flex-column-fluid align-items-start container-xxl">
    <div class="content flex-row-fluid" id="kt_content">
        <div class="col-xl-12">
            <div class="alert alert-primary d-flex align-items-center p-5">
                <i class="bi bi-megaphone-fill fs-2x me-5 text-primary"></i>
                <div class="d-flex flex-column">
                    <h4 class="mb-1 text-dark">Thông Báo:</h4>
                    {!! base64_decode(Helper::getNotice('page_deposit')) !!}
                </div>
            </div>
          </div>
          <div class="row gy-5 g-xl-12 mb-5">
        @foreach($recharge as $recharges)
        <div class="col-xl-4">
                <div class="card card-xl-stretch mb-3 mb-xl-3 posts-item shadow-sm">
                    <div class="card-body">
                        <div class="flex h-auto w-full items-center justify-center rounded mb-5" style="background: url(&quot;/assets/media/payments/qrcode-pattern.webp&quot;) 10px 10px no-repeat, linear-gradient(to top, rgb(3, 70, 64), rgb(6, 53, 31));">
                            <div class="px-8 py-7 text-center">
                                <div class="jsx-d22f6bd0771ae323 qrcode__scan__container">
                                    <div class="jsx-d22f6bd0771ae323 qrcode__scan">
                                        <div class="jsx-d22f6bd0771ae323 qrcode__border">
                                            <img alt="" src="/assets/media/payments/border-qrcode.svg" class="img-fluid">
                                        </div>
                                        <div class="jsx-d22f6bd0771ae323 qrcode__image p-4 w-200px h-200px">
                                            @if ($recharges->name == 'Thesieure')
                                            <img class="lazyload" src="{{ asset('assets/media/payments/border-qrcode.svg') }}" data-src="{{ setting('thesieure_qr') ?: asset('assets/media/payments/border-qrcode.svg') }}" width="175" height="175">
                                            @else
                                            <img class="lazyload" src="{{ asset('assets/media/payments/border-qrcode.svg') }}" data-src="https://qr.sepay.vn/img?bank={{ $recharges->name }}&acc={{ $recharges->number }}&template=compact&amount=0&des={{ $deposit_prefix }}" width="175" height="175">
                                            @endif                                     
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-3 text-sm text-white">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="mr-1 inline w-20px h-20px me-2">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path>
                                    </svg>Sử dụng App MoMo hoặc<br>ứng dụng Camera hỗ trợ QR code để quét mã.
                                </div>
                            </div>
                        </div>
                        <div class="d-flex flex-stack">
                            <img src="{{ ApiLogo::GetApiBank($recharges->name, 'shortName', 'logo') }}" class="me-4 w-30px" alt="">
                            <div class="d-flex align-items-center flex-stack flex-wrap flex-row-fluid d-grid gap-2">
                                <div class="me-5">
                                    <a href="#" class="text-gray-700 fw-bold text-hover-primary fs-6">{{ $recharges->name }}</a>
                                    <span class="fw-semibold fs-7 d-block text-start ps-0">{{ ApiLogo::GetApiBank($recharges->name, 'shortName', 'name') }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="separator separator-dashed my-3"></div>
                        <div class="d-flex flex-stack">
                            <div class="d-flex align-items-center flex-stack flex-wrap flex-row-fluid d-grid gap-2">
                                <div class="me-5">
                                    <a href="#" class="text-gray-700 fw-bold text-hover-primary fs-6">Tên tài khoản</a>
                                    <span id="copyCTK{{ $recharges->id }}" class="fw-semibold fs-7 d-block text-start ps-0">{{ $recharges->owner }}</span>
                                </div>
                                <div class="d-flex align-items-center">
                                    <div class="m-0">
                                        <button type="button" data-clipboard-target="#copyCTK{{ $recharges->id }}" class="copy btn btn-active-color-primary btn-color-gray-500 btn-icon btn-sm btn-outline-light" onclick="copy()">
                                            <i class="ki-duotone ki-copy fs-2"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="separator separator-dashed my-3"></div>
                        <div class="d-flex flex-stack">
                            <div class="d-flex align-items-center flex-stack flex-wrap flex-row-fluid d-grid gap-2">
                                <div class="me-5">
                                    <a href="#" class="text-gray-700 fw-bold text-hover-primary fs-6">Số tài khoản</a>
                                    <span id="copySTK{{ $recharges->id }}" class="fw-semibold fs-7 d-block text-start ps-0">{{ $recharges->number }}</span>
                                </div>
                                <div class="d-flex align-items-center">
                                    <div class="m-0">
                                        <button type="button" data-clipboard-target="#copySTK{{ $recharges->id }}" class="copy btn btn-active-color-primary btn-color-gray-500 btn-icon btn-sm btn-outline-light" onclick="copy()">
                                            <i class="ki-duotone ki-copy fs-2"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="separator separator-dashed my-3"></div>
                        <div class="d-flex flex-stack">
                            <div class="d-flex align-items-center flex-stack flex-wrap flex-row-fluid d-grid gap-2">
                                <div class="me-5">
                                    <a href="#" class="text-gray-700 fw-bold fs-6">Nội dung chuyển khoản</a>
                                    <span id="copyNoiDung{{ $recharges->id }}" class=" fw-semibold fs-7 d-block text-start ps-0">{{ $deposit_prefix }}</span>
                                </div>
                                <div class="d-flex align-items-center">
                                    <div class="m-0">
                                        <button type="button" data-clipboard-target="#copyNoiDung{{ $recharges->id }}" class="copy btn btn-active-color-primary btn-color-gray-500 btn-icon btn-sm btn-outline-light" onclick="copy()">
                                            <i class="ki-duotone ki-copy fs-2"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
              </div>  
              @endforeach    
           </div>
         
           <div class="card">
            <!--begin::Card header-->
            <div class="card-header border-0 pt-6">
                <!--begin::Card title-->
                <div class="card-title">
                    <!--begin::Search-->
                    <div
                        class="d-flex align-items-center position-relative my-1"
                    >
                        <i
                            class="ki-duotone ki-magnifier fs-3 position-absolute ms-5"
                            ><span class="path1"></span
                            ><span class="path2"></span
                        ></i>
                        <input
                            type="text"
                            data-kt-customer-table-filter="search"
                            class="form-control form-control-solid w-250px ps-12"
                            placeholder="Tìm kiếm giao dịch"
                        />
                    </div>
                </div>
            </div>
            <div class="card-body pt-0">
                <!--begin::Table-->
                <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_customers_table">
                    <thead>
                        <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                            <th class="w-10px pe-2">
                                <div
                                    class="form-check form-check-sm form-check-custom form-check-solid me-3"
                                >
                                    <input
                                        class="form-check-input"
                                        type="checkbox"
                                        data-kt-check="true"
                                        data-kt-check-target="#kt_customers_table .form-check-input"
                                        value="1"
                                    />
                                </div>
                            </th>
                            <th class="min-w-125px">MÃ GIAO DỊCH</th>
                            <th class="min-w-125px">SỐ TIỀN</th>
                            <th class="min-w-125px">NỘI DUNG</th>
                            <th class="min-w-125px">NGÀY NẠP</th>
                        </tr>
                    </thead>
                    <tbody class="fw-semibold text-gray-600">
                        @foreach($hispay as $hispays)
                        <tr>
                            <td>
                                <div class="form-check form-check-sm form-check-custom form-check-solid">
                                    <input class="form-check-input" type="checkbox" value="1"/>
                                </div>
                            </td>
                            <td>
                                {{ $hispays->code }}
                            </td>
                            <td>
                                {{ number_format($hispays->amount) }}đ
                            </td>
                            <td data-filter="mb">
                                {{ $hispays->content }}
                            </td>
                            <td>
                               {{ $hispays->created_at}}
                            </td>
                           
                        </tr>
                        @endforeach
                        </tbody>
                </table>
                <!--end::Table-->
            </div>
            <!--end::Card body-->
        </div>

    </div>
</div>
@endsection
@section('scripts')
@endsection
