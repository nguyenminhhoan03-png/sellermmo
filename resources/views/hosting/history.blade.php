@php use App\Helpers\Helper; @endphp
@php use App\Models\Product; @endphp
@php use App\Models\Domain; @endphp
@extends('layouts.app')
@section('title', $pageTitle)
@section('content')
    <div class="toolbar d-flex flex-stack py-3 py-lg-5" id="kt_toolbar">
        <div id="kt_toolbar_container" class="container-xxl d-flex flex-stack flex-wrap">
            <div class="page-title d-flex flex-column me-3">
                <h1 class="d-flex text-gray-900 fw-bold my-1 fs-3">
                    Lịch sử mua hosting
                </h1>
                <ul class="breadcrumb breadcrumb-dot fw-semibold text-gray-600 fs-7 my-1">
                    <li class="breadcrumb-item text-gray-600">
                        <a href="/" class="text-gray-600 text-hover-primary">
                            Home
                        </a>
                    </li>
                    <li class="breadcrumb-item text-gray-600">{{ $user->name }}</li>
                    <li class="breadcrumb-item text-gray-500">Lịch sử mua hosting</li>
                </ul>
            </div>
        </div>
    </div>

    <div id="kt_content_container" class="d-flex flex-column-fluid align-items-start container-xxl">
        <div class="content flex-row-fluid" id="kt_content">
            <div class="card">
                <div class="card-header border-0 pt-6">
                    <div class="card-title">
                        <div class="d-flex align-items-center position-relative my-1">
                            <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-5"><span class="path1"></span><span
                                    class="path2"></span></i>
                            <input type="text" data-kt-customer-table-filter="search"
                                class="form-control form-control-solid w-250px ps-12" placeholder="Tìm kiếm hosting" />
                        </div>
                    </div>                
                </div>
                <div class="card-body pt-0">
                    <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_customers_table">
                        <thead>
                            <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                                <th class="min-w-125px">Tên gói</th>
                                <th class="min-w-125px">Giá</th>
                                <th class="min-w-125px">Chu kỳ</th>
                                <th class="min-w-125px">Tên miền</th>
                                <th class="min-w-125px">IP</th>
                                <th class="min-w-125px">Trạng thái</th>
                                <th class="min-w-125px">Tự gia hạn</th>
                                <th class="min-w-125px">Ngày Hết Hạn</th>
                                <th class="text-end min-w-70px">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="fw-semibold text-gray-600">
                            @foreach ($host as $hosts)
                                <tr>
                                    <td>{{ $hosts->info_package['package_name'] }}</td>
                                    <td>{{ formatCurrency($hosts->total) }}</td>
                                    <td>{{ checkYearOrMonth($hosts->month) }}</td>
                                    <td>{{ $hosts->domain_name }}</td>
                                    <td>{{ $hosts->ip }}</td>
                                    <td>{!! Helper::status_hosting($hosts->status) !!}</td>
                                    <td>
                                        <div
                                            class="form-check form-switch form-check-custom form-check-danger form-check-solid">
                                            <input type="checkbox" class="form-check-input Switch"
                                                data-table="status_domain" data-id="{{ $hosts->id }}" data-col="status"
                                                id="customSwitch{{ $hosts->id }}"
                                                @if ($hosts->giahan == 1) checked @endif />
                                        </div>
                                    </td>
                                    <td>{{ date('Y-m-d', $hosts->end_date) }}</td>
                                   <td class="text-end">
                                        <a href="{{ route('hosting.view', $hosts->id) }}" class="btn btn-outline btn-outline-dashed btn-outline-danger btn-active-light-danger btn-sm btn-icon"><i class="ki-duotone ki-to-right fs-3"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script>
         $(document).ready(function() {
            $(".Switch").on('click', function() {
                var switchElement = $(this);
                var isChecked = $(this).prop('checked');
                Swal.fire({
                    title: isChecked ? 'Bật gia hạn auto?' :
                        'Bạn có chắc chắn muốn hủy gia hạn auto?',
                    text: "Hành động này sẽ thay đổi trạng thái gia hạn!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Đồng ý",
                    cancelButtonText: "Hủy"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('hosting.view.giahan') }}",
                            type: "post",
                            dataType: "json",
                            data: {
                                _token: "{{ csrf_token() }}",
                                table: switchElement.attr('data-table'),
                                col: switchElement.attr('data-col'),
                                id: switchElement.attr('data-id'),
                                status: isChecked ? 1 : 0,
                            },
                            success: function(result) {
                                if (result.status == '200') {
                                    showMessage(result.message, 'success');
                                } else {
                                    showMessage(result.message, 'error');
                                }
                            },
                            error: function(xhr, status, error) {
                                var responseMessage = xhr.responseJSON ? xhr
                                    .responseJSON.message :
                                    'Vui lòng liên hệ Developer';
                                showMessage(responseMessage, 'error');
                            }
                        });
                    } else {
                        switchElement.prop('checked', !isChecked);
                    }
                });
            });
        });
    </script>
@endsection
