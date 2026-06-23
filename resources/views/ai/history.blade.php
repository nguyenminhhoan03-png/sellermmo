@php use App\Helpers\Helper; @endphp
@extends('layouts.app')
@section('title', $pageTitle)
@section('content')
<div class="toolbar d-flex flex-stack py-3 py-lg-5" id="kt_toolbar">
    <!--begin::Container-->
    <div id="kt_toolbar_container" class="container-xxl d-flex flex-stack flex-wrap">
        <!--begin::Page title-->
        <div class="page-title d-flex flex-column me-3">
            <!--begin::Title-->
            <h1 class="d-flex text-gray-900 fw-bold my-1 fs-3">
                Lịch sử mua tài khoản AI
            </h1>
            <!--end::Title-->

            <!--begin::Breadcrumb-->
            <ul class="breadcrumb breadcrumb-dot fw-semibold text-gray-600 fs-7 my-1">
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
                <li class="breadcrumb-item text-gray-500">Lịch sử tài khoản AI</li>
                <!--end::Item-->
            </ul>
            <!--end::Breadcrumb-->
        </div>
        <!--end::Page title-->
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
                    <div class="d-flex align-items-center position-relative my-1">
                        <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-5">
                            <span class="path1"></span><span class="path2"></span>
                        </i>
                        <input type="text" id="aiOrderSearch" class="form-control form-control-solid w-250px ps-12" placeholder="Tìm kiếm tài khoản AI" />
                    </div>
                    <!--end::Search-->
                </div>
                <!--end::Card title-->
            </div>
            <!--end::Card header-->

            <!--begin::Card body-->
            <div class="card-body pt-0">
                <!--begin::Table-->
                <div class="table-responsive">
                    <table class="table align-middle table-row-dashed fs-6 gy-5" id="ai_orders_table">
                        <thead>
                            <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                                <th class="min-w-100px">Mã Đơn</th>
                                <th class="min-w-150px">Tài Khoản AI</th>
                                <th class="min-w-125px">Gói/Biến Thể</th>
                                <th class="min-w-100px">Giá Tiền</th>
                                <th class="min-w-125px">Trạng Thái</th>
                                <th class="min-w-125px">Hạn Dùng</th>
                                <th class="min-w-125px">Ngày Mua</th>
                            </tr>
                        </thead>
                        <tbody class="fw-semibold text-gray-600">
                            @forelse($orders as $order)
                            @php
                                $statusMap = [
                                    'pending'   => ['label' => 'Chờ xử lý',   'class' => 'badge-light-warning'],
                                    'paid'      => ['label' => 'Đã thanh toán','class' => 'badge-light-info'],
                                    'delivered' => ['label' => 'Đã giao',      'class' => 'badge-light-success'],
                                    'canceled'  => ['label' => 'Đã hủy',       'class' => 'badge-light-danger'],
                                ];
                                $st = $statusMap[$order->status] ?? ['label' => $order->status, 'class' => 'badge-light-secondary'];
                            @endphp
                            <tr>
                                <td>
                                    <code>{{ $order->trans_id }}</code>
                                </td>
                                <td>
                                    <span class="text-gray-800 fw-bold">{{ $order->aiAccount?->name ?? 'Tài khoản #' . $order->ai_account_id }}</span>
                                </td>
                                <td>
                                    {{ $order->note ?: ($order->variant?->variant_name ?? 'Mặc định') }}
                                </td>
                                <td>
                                    {{ number_format($order->price) }}đ
                                </td>
                                <td>
                                    <span class="badge {{ $st['class'] }}">{{ $st['label'] }}</span>
                                </td>
                                <td>
                                    {{ $order->expiry_date ? \Carbon\Carbon::parse($order->expiry_date)->format('d/m/Y') : 'Vĩnh viễn' }}
                                </td>
                                <td>
                                    {{ $order->created_at->format('d/m/Y H:i') }}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center py-10 text-muted">
                                    Bạn chưa mua tài khoản AI nào.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <!--end::Table-->
            </div>
            <!--end::Card body-->
        </div>
        <!--end::Card-->
    </div>
    <!--end::Post-->
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('aiOrderSearch');
    const tableRows = document.querySelectorAll('#ai_orders_table tbody tr');

    searchInput.addEventListener('keyup', function() {
        const query = this.value.toLowerCase().trim();
        tableRows.forEach(row => {
            const text = row.innerText.toLowerCase();
            if (text.includes(query) || row.querySelector('td[colspan]')) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
});
</script>
@endsection
