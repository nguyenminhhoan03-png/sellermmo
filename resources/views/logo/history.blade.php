@php use App\Helpers\Helper; @endphp 
@php use App\Models\Logo; @endphp
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
                Lịch sử tạo logo
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
                <li class="breadcrumb-item text-gray-600">{{ $user->name }}</li>
                <!--end::Item-->
                <!--begin::Item-->
                <li class="breadcrumb-item text-gray-500">Lịch sử tạo logo</li>
                <!--end::Item-->
            </ul>
            <!--end::Breadcrumb-->
        </div>
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
                            placeholder="Tìm kiếm mẫu logo"
                        />
                    </div>
                    <!--end::Search-->
                </div>
            </div>
            <!--end::Card header-->

            <!--begin::Card body-->
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
                            <th class="min-w-125px">Mã Giao Dịch</th>
                            <th class="min-w-125px">Tên logo</th>
                            <th class="min-w-125px">Yêu cầu</th>
                            <th class="min-w-125px">giá tiền</th>
                            <th class="min-w-125px">Trạng Thái</th>
                            <th class="min-w-125px">Ngày Mua</th>
                            <th class="text-end min-w-70px">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="fw-semibold text-gray-600">
                        @foreach($hislogo as $hislogos)
                        <tr>
                            <td>
                                <div
                                    class="form-check form-check-sm form-check-custom form-check-solid"
                                >
                                    <input
                                        class="form-check-input"
                                        type="checkbox"
                                        value="1"
                                    />
                                </div>
                            </td>
                            <td>
                                {{ $hislogos->trans_id }}
                            </td>
                            <td>
                               {{ Logo::getLogo($hislogos->logo_id, 'name') ?? 'Đã bị ẩn hoặc đã xóa' }}
                            </td>
                            <td>
                                {{ $hislogos->name }}
                            </td>
                            <td>
                                {{ number_format($hislogos->price) }}đ
                             </td>
                             <td>
                                {!! Helper::status_logo_client($hislogos->status) !!}
                             </td>
                            <td>
                               {{ $hislogos->created_at}}
                            </td>
                            <td class="text-end">
                               @if ($hislogos->link != null)
                               <a href="{{ $hislogos->link }}" class="btn btn-primary btn-sm w-100 btn-hover-effect">
                                 Tải xuống
                               </a>
                               @else
                               Link chưa được cập nhật
                               @endif
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
    <!--end::Post-->
</div>

@endsection
@section('scripts')

@endsection
