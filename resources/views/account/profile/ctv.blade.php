@php use App\Helpers\Helper; @endphp 
@php use App\Models\Product; @endphp
@extends('layouts.app') 
@section('title', $pageTitle) 
@section('content')
<div class="toolbar d-flex flex-stack py-3 py-lg-5" id="kt_toolbar">
    <div id="kt_toolbar_container" class="container-xxl d-flex flex-stack flex-wrap">
        <div class="page-title d-flex flex-column me-3">
            <h1 class="d-flex text-gray-900 fw-bold my-1 fs-3">Quản lý doanh thu</h1>
            <ul class="breadcrumb breadcrumb-dot fw-semibold text-gray-600 fs-7 my-1">
                <li class="breadcrumb-item text-gray-600">
                    <a href="/" class="text-gray-600 text-hover-primary">
                        Home
                    </a>
                </li>
                <li class="breadcrumb-item text-gray-600">{{ auth()->user()->username ?? 'Chưa đăng nhập' }}</li>
                <li class="breadcrumb-item text-gray-500">Doanh Thu</li>
            </ul>
        </div>
    </div>
</div>
<div id="kt_content_container" class="d-flex flex-column-fluid align-items-start container-xxl">
    <div class="content flex-row-fluid" id="kt_content">
        <div class="row gy-4 dashboard-row-wrapper">
            <div class="col-12 mb-5">
                <div class="row gy-3">
                    <div class="col-lg-3 col-sm-6">
                        <div class="p-3 rounded-3 d-flex align-items-center justify-content-between dashboard-widget border shadow-sm">
                            <div>
                                <h3 class="dashboard-widget-title text-dark-300">
                                    {{ number_format($totalDeposit, 0, ',', ',') }}đ
                                </h3>
                                <p class="text-18 text-dark-200">Tổng thu nhập</p>
                            </div>
                            <div class="">
                                <img src="/assets/images/optimization.png" width="75" height="71">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <div class="p-3 rounded-3 d-flex align-items-center justify-content-between dashboard-widget border shadow-sm">
                            <div>
                                <h3 class="dashboard-widget-title text-dark-300">
                                    {{ number_format($totalDepositInToday) }}đ
                                </h3>
                                <p class="text-18 text-dark-200">Thu nhập hôm nay</p>
                            </div>
                            <div class="">
                                <img src="/assets/images/salary.png" width="75" height="71">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <div class="p-3 rounded-3 d-flex align-items-center justify-content-between dashboard-widget border shadow-sm">
                            <div>
                                <h3 class="dashboard-widget-title text-dark-300">
                                    {{ number_format($totalDepositInWeek) }}đ
                                </h3>
                                <p class="text-18 text-dark-200">Thu nhập tuần này</p>
                            </div>
                            <div class="">
                                <img src="/assets/images/moneyweek.png" width="75" height="71">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <div class="p-3 rounded-3 d-flex align-items-center justify-content-between dashboard-widget border shadow-sm">
                            <div>
                                <h3 class="dashboard-widget-title text-dark-300">
                                    {{ number_format($totalDepositInMonth) }}đ
                                </h3>
                                <p class="text-18 text-dark-200">Thu nhập tháng này</p>
                            </div>
                            <div class="">
                                <img src="/assets/images/moneys.png" width="75" height="71">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header border-0 pt-6">
                        <div class="card-title">
                            <div class="d-flex align-items-center position-relative my-1">
                                <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-5">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                                <input
                                    type="text"
                                    data-kt-customer-table-filter="search"
                                    class="form-control form-control-solid w-250px ps-12"
                                    placeholder="Tìm kiếm giao dịch"
                                />
                            </div>
                            
                        </div>
                        <div class="card-toolbar">
                            <div class="d-flex justify-content-end" data-kt-customer-table-toolbar="base">
                                <a href="/account/withdraw" class="btn btn-sm btn-primary">
                                    Rút Tiền
                                </a>
                            </div>
                            </div>
                    </div>
                    <div class="card-body pt-0">
                        <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_customers_table">
                            <thead>
                                <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                                    <th class="min-w-150px">Sản phẩm | Ngày</th>
                                    <th class="min-w-125px">Mã mua hàng</th>
                                    <th class="min-w-125px">Giấy phép</th>
                                    <th class="min-w-125px">Thu nhập</th>
                                </tr>
                                
                            </thead>
                            <tbody class="fw-semibold text-gray-600">
                                @foreach($hisctv as $hisctvs)
                                <tr>
                                    
                                    <td>
                                        {{ Product::getCode($hisctvs->order_id, 'name') }} |  {{ $hisctvs->created_at}}
                                    </td>
                                    <td>
                                        {{ $hisctvs->code }}
                                    </td>
                                    <td data-filter="mb">
                                        {{ $hisctvs->lickey }}
                                    </td>
                                    <td>
                                       {{ number_format($hisctvs->amount) }}đ
                                    </td>
                                </tr>
                                @endforeach
                                </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--end::Post-->
</div>
@endsection
@section('scripts')
  <script>
$("#kt_datatable_zero_configuration").DataTable();
  </script>
@endsection
