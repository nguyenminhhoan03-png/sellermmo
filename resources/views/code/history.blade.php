@php use App\Helpers\Helper; @endphp 
@php use App\Models\Product; @endphp
@php use App\Models\Transaction; @endphp
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
                Lịch sử mua mã nguồn
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
                <li class="breadcrumb-item text-gray-500">Lịch sử mua code</li>
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
                            placeholder="Tìm kiếm mã nguồn"
                        />
                    </div>
                    <!--end::Search-->
                </div>
                <!--begin::Card title-->

                <!--begin::Card toolbar-->
                <div class="card-toolbar">
                    <!--begin::Toolbar-->
                    <div
                        class="d-flex justify-content-end"
                        data-kt-customer-table-toolbar="base"
                    >
                        <!--begin::Filter-->
                        <button
                            type="button"
                            class="btn btn-light-primary me-3"
                            data-kt-menu-trigger="click"
                            data-kt-menu-placement="bottom-end"
                        >
                            <i class="ki-duotone ki-filter fs-2"
                                ><span class="path1"></span
                                ><span class="path2"></span
                            ></i>
                            Filter
                        </button>
                        <!--begin::Menu 1-->
                        <div class="menu menu-sub menu-sub-dropdown w-300px w-md-325px" data-kt-menu="true" id="kt-toolbar-filter">
                            <!--begin::Header-->
                            <div class="px-7 py-5">
                                <div class="fs-4 text-gray-900 fw-bold">
                                    Filter Options
                                </div>
                            </div>
                            <!--end::Header-->

                            <!--begin::Separator-->
                            <div class="separator border-gray-200"></div>
                            <!--end::Separator-->

                            <!--begin::Content-->
                            <div class="px-7 py-5">
                                <!--begin::Input group-->
                                <div class="mb-10">
                                    <!--begin::Label-->
                                    <label
                                        class="form-label fs-5 fw-semibold mb-3"
                                        >Month:</label
                                    >
                                    <!--end::Label-->

                                    <!--begin::Input-->
                                    <select
                                        class="form-select form-select-solid fw-bold"
                                        data-kt-select2="true"
                                        data-placeholder="Select option"
                                        data-allow-clear="true"
                                        data-kt-customer-table-filter="month"
                                        data-dropdown-parent="#kt-toolbar-filter"
                                    >
                                        <option></option>
                                        <option value="aug">August</option>
                                        <option value="sep">September</option>
                                        <option value="oct">October</option>
                                        <option value="nov">November</option>
                                        <option value="dec">December</option>
                                    </select>
                                    <!--end::Input-->
                                </div>
                                <!--end::Input group-->

                                <!--begin::Input group-->
                                <div class="mb-10">
                                    <!--begin::Label-->
                                    <label
                                        class="form-label fs-5 fw-semibold mb-3"
                                        >Payment Type:</label
                                    >
                                    <!--end::Label-->

                                    <!--begin::Options-->
                                    <div
                                        class="d-flex flex-column flex-wrap fw-semibold"
                                        data-kt-customer-table-filter="payment_type"
                                    >
                                        <!--begin::Option-->
                                        <label
                                            class="form-check form-check-sm form-check-custom form-check-solid mb-3 me-5"
                                        >
                                            <input
                                                class="form-check-input"
                                                type="radio"
                                                name="payment_type"
                                                value="all"
                                                checked="checked"
                                            />
                                            <span
                                                class="form-check-label text-gray-600"
                                            >
                                                All
                                            </span>
                                        </label>
                                        <!--end::Option-->

                                        <!--begin::Option-->
                                        <label
                                            class="form-check form-check-sm form-check-custom form-check-solid mb-3 me-5"
                                        >
                                            <input
                                                class="form-check-input"
                                                type="radio"
                                                name="payment_type"
                                                value="free"
                                            />
                                            <span
                                                class="form-check-label text-gray-600"
                                            >
                                                Miễn Phí
                                            </span>
                                        </label>
                                        <!--end::Option-->

                                        <!--begin::Option-->
                                        <label
                                            class="form-check form-check-sm form-check-custom form-check-solid mb-3"
                                        >
                                            <input
                                                class="form-check-input"
                                                type="radio"
                                                name="payment_type"
                                                value="matphi"
                                            />
                                            <span
                                                class="form-check-label text-gray-600"
                                            >
                                                Mất Phí
                                            </span>
                                        </label>
                                    </div>
                                    <!--end::Options-->
                                </div>
                                <!--end::Input group-->

                                <!--begin::Actions-->
                                <div class="d-flex justify-content-end">
                                    <button
                                        type="reset"
                                        class="btn btn-light btn-active-light-primary me-2"
                                        data-kt-menu-dismiss="true"
                                        data-kt-customer-table-filter="reset"
                                    >
                                        Reset
                                    </button>

                                    <button
                                        type="submit"
                                        class="btn btn-primary"
                                        data-kt-menu-dismiss="true"
                                        data-kt-customer-table-filter="filter"
                                    >
                                        Apply
                                    </button>
                                </div>
                                <!--end::Actions-->
                            </div>
                            <!--end::Content-->
                        </div>
                    </div>
                    <!--end::Toolbar-->

                    <!--begin::Group actions-->
                    <div
                        class="d-flex justify-content-end align-items-center d-none"
                        data-kt-customer-table-toolbar="selected"
                    >
                        <div class="fw-bold me-5">
                            <span
                                class="me-2"
                                data-kt-customer-table-select="selected_count"
                            ></span>
                            Selected
                        </div>

                        <button
                            type="button"
                            class="btn btn-danger"
                            data-kt-customer-table-select="delete_selected"
                        >
                            Delete Selected
                        </button>
                    </div>
                    <!--end::Group actions-->
                </div>
                <!--end::Card toolbar-->
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
                            <th class="min-w-125px">Mã Nguồn</th>
                            <th class="min-w-125px">giá tiền</th>
                            <th class="min-w-125px">Trạng Thái</th>
                            <th class="min-w-125px">Ngày Mua</th>
                            <th class="text-end min-w-70px">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="fw-semibold text-gray-600">
                        @foreach($hiscode as $hiscodes)
                        @php
                        $trans_id = $hiscodes->trans_id;
                        $lickeys = Transaction::where('code', $trans_id)->first();
                        @endphp
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
                                {{ $hiscodes->trans_id }}
                            </td>
                            <td>
                               {{ Product::getCode($hiscodes->product_id, 'name') }}
                            </td>
                            <td data-filter="@if ($hiscodes->price == 0) free @else matphi @endif">
                                {{ number_format($hiscodes->price) }}đ
                             </td>
                             <td>
                                {!! Helper::formatStatus(Transaction::Getpay($hiscodes->trans_id, 'status')) !!}
                             </td>
                            <td>
                               {{ $hiscodes->created_at}}
                            </td>
                            <td class="text-end">
                                <a
                                    href="#"
                                    class="btn btn-sm btn-light btn-flex btn-center btn-active-light-primary"
                                    data-kt-menu-trigger="click"
                                    data-kt-menu-placement="bottom-end"
                                > 
                                    <i class="ki-duotone ki-down fs-5 ms-1"></i>
                                </a>
                                <!--begin::Menu-->
                                <div
                                    class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4"
                                    data-kt-menu="true"
                                >
                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3">
                                        <a
                                            href="{{ Helper::muabanwebsite_dec(Product::getCode($hiscodes->product_id, 'link_down')) }}"
                                            class="menu-link px-3"
                                        >
                                            Tải Xuống
                                        </a>
                                    </div>
                                    <div class="menu-item px-3">
                                        <a href="#" class="menu-link px-3" data-bs-toggle="modal" data-bs-target="#modal-lickey-{{ $hiscodes->id }}">Key Code</a>
                                    </div>
                                    <!--end::Menu item-->

                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3">
                                        <a
                                            href="#"
                                            class="menu-link px-3"
                                            data-kt-customer-table-filter="delete_row"
                                        >
                                            Delete
                                        </a>
                                    </div>
                                    <!--end::Menu item-->
                                </div>
                                <!--end::Menu-->
                            </td>
                        </tr>
                        <div class="modal fade " tabindex="-1" id="modal-lickey-{{ $hiscodes->id }}">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h3 class="modal-title">Mã bản quyền {{ $hiscodes->domain_name }}</h3>
                                        <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                                            <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                                        </div>
                                    </div>
                                    <div class="modal-body">
                                        <div class="alert alert-danger">
                                            Dưới đây là mã key bản quyền của code chỉ dành riêng cho code này vui lòng ko sử dụng cho sản phẩm khác
                                        </div>
                                        <div class="form-floating mb-7">
                                            <input type="text" class="form-control" id="lickey" value="{{ $lickeys->lickey }}" readonly onclick="this.select(); document.execCommand('copy');" placeholder="muabanwebsite"/>
                                            <label for="floatingInput">Mã bản quyền</label>
                                        </div>
                                    </div>
                                    
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Đóng</button>
                                    </div>
                                </div>
                            </div>
                        </div>
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
