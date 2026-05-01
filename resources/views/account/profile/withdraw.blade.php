@php use App\Helpers\Helper; @endphp 
@php use App\Models\Product; @endphp
@extends('layouts.app') 
@section('title', $pageTitle) 
@section('content')
<div class="toolbar d-flex flex-stack py-3 py-lg-5" id="kt_toolbar">
    <div id="kt_toolbar_container" class="container-xxl d-flex flex-stack flex-wrap">
        <div class="page-title d-flex flex-column me-3">
            <h1 class="d-flex text-gray-900 fw-bold my-1 fs-3">Rút Tiền Cộng Tác Viên</h1>
            <ul class="breadcrumb breadcrumb-dot fw-semibold text-gray-600 fs-7 my-1">
                <li class="breadcrumb-item text-gray-600">
                    <a href="/" class="text-gray-600 text-hover-primary">
                        Home
                    </a>
                </li>
                <li class="breadcrumb-item text-gray-600">{{ auth()->user()->username ?? 'Chưa đăng nhập' }}</li>
                <li class="breadcrumb-item text-gray-500">Rút Tiền</li>
            </ul>
        </div>
    </div>
</div>
<div id="kt_content_container" class="d-flex flex-column-fluid align-items-start container-xxl">
    <div class="content flex-row-fluid" id="kt_content">
        <div class="row">
            <div class="col-lg-6 mb-5">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Rút tiền bán hàng</h4>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <div class="text-success fw-bold">
                                <i>
                                    Số tiền khả dụng: <span class="text-danger">{{ number_format(auth()->user()->balance_ctv) }} ₫</span>
                                </i>
                            </div>
                            <div class="text-danger fw-bold">
                                <i>
                                    Số tiền có thể rút: từ <span class="text-success">{{ number_format(setting('minctv', '0')) }} ₫</span>
                                </i>
                            </div>
                        </div>
                        <form action="{{ route('account.withdraw') }}" method="POST">
                            @csrf
                        <div class="mb-4">
                            <label for="amount" class="form-label">Số Tiền Rút</label>
                            <input type="number" class="form-control shadow-none" id="amount" name="amount" required="">
                        </div>
                        <div class="mb-4 group_banking">
                            <label for="bank" class="form-label">Ngân Hàng</label>
                            <select name="bank" id="bank" class="form-select" data-control="select2">
                                <option>--- Chọn ngân hàng ---</option>
                                <option value="Localbank_TCB">Ngân hàng Techcombank</option>
                                <option value="Localbank_VCB">Ngân hàng Vietcombank</option>
                                <option value="Localbank_MB">Ngân hàng MB Bank</option>
                                <option value="Localbank_VIETINBANK">Ngân hàng VietinBank</option>
                                <option value="Localbank_BIDV">Ngân hàng BIDV</option>
                                <option value="Localbank_AGRIBANK">Ngân hàng Agribank</option>
                                <option value="Localbank_SACOMBANK">Ngân hàng Sacombank</option>
                                <option value="Localbank_VPBANK">Ngân hàng VPBank</option>
                                <option value="Localbank_PVCOMBANK">Ngân hàng PVcomBank</option>
                                <option value="Localbank_VIB">Ngân hàng VIB</option>
                                <option value="Localbank_TPBANK">Ngân hàng TPBank</option>
                                <option value="Localbank_HDBANK">Ngân hàng HDBank</option>
                                <option value="Localbank_OJB">Ngân hàng OceanBank</option>
                                <option value="Localbank_DONGA">Ngân hàng DongABank</option>
                                <option value="Localbank_NAMABA">Ngân hàng Nam A Bank</option>
                                <option value="Localbank_MSB">Ngân hàng MSB</option>
                                <option value="Localbank_OCB">Ngân hàng OCB</option>
                                <option value="Localbank_ACB">Ngân hàng ACB</option>
                          </select>
                        </div>
                        <div class="row mb-4 group_banking">
                            <div class="col-md-6">
                                <label for="account_number" class="form-label">Số Tài Khoản</label>
                                <input type="text" class="form-control shadow-none" id="stk" name="stk" value="" placeholder="Nhập số tài khoản">
                            </div>
                            <div class="col-md-6">
                                <label for="name" class="form-label">Chủ Tài Khoản</label>
                                <input type="text" class="form-control shadow-none" id="ctk" name="ctk" value="" placeholder="Nhập tên chủ tài khoản">
                            </div>
                        </div>

                        <div class="mb-3">
                            <button class="btn btn-primary" type="submit" id="btnWithdraw">Rút
                                Tiền Ngay</button>
                        </div>
                        </form>
                    </div> 
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Nội Quy Rút Tiền</h4>
                    </div>
                    <div class="card-body">
                        {!! base64_decode(Helper::getNotice('notectv')) !!}
                                                </div>
                </div>
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
                                <th class="min-w-125px">Mã giao dịch</th>
                                <th class="min-w-125px">Thông tin</th>
                                <th class="min-w-125px">Số tiền</th>
                                <th class="min-w-125px">Trạng thái</th>
                                <th class="min-w-125px">Ngày rút</th>
                            </tr>
                        </thead>
                        <tbody class="fw-semibold text-gray-600">
                            @foreach($whithdraw as $whithdraws)
                            <tr>
                                <td>
                                    <div class="form-check form-check-sm form-check-custom form-check-solid">
                                        <input class="form-check-input" type="checkbox" value="1"/>
                                    </div>
                                </td>
                                <td>
                                    {{ $whithdraws->trans_id }}
                                </td>
                                <td>
                                    {{ $whithdraws->bank}} | {{ $whithdraws->stk}} | {{ $whithdraws->ctk}}
                                 </td>
                                <td>
                                    {{ number_format($whithdraws->price) }}đ
                                </td>
                                <td>
                                    {!! Helper::statuswithdraw($whithdraws->status) !!}
                                </td>
                                <td>
                                   {{ $whithdraws->created_at}}
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
    <!--end::Post-->
</div>
@endsection
@section('scripts')
  <script>
$("#kt_datatable_zero_configuration").DataTable();
  </script>
@endsection
