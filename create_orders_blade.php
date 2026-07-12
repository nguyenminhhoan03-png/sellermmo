<?php
$history_blade = file_get_contents('resources/views/account/profile/history.blade.php');
$nav_end = strpos($history_blade, '<!--end::Navbar-->');
$header_part = substr($history_blade, 0, $nav_end + strlen('<!--end::Navbar-->'));

$header_part = str_replace('py-5 active" href="/account/history"', 'py-5" href="/account/history"', $header_part);
$header_part = str_replace('py-5" href="/account/orders"', 'py-5 active" href="/account/orders"', $header_part);

$orders_blade = $header_part . '
            <!--begin::Row-->
            <div class="card shadow-sm mb-5 mb-xxl-8" style="border-radius: 16px; border: none;">
                <div class="card-header border-0 pt-6">
                    <div class="card-title">
                        <div class="d-flex align-items-center position-relative my-1">
                            <i class="ki-duotone ki-handcart fs-2 text-primary me-2"><span class="path1"></span><span class="path2"></span></i>
                            <h3 class="fw-bold m-0 fs-3">Lịch sử mua hàng</h3>
                        </div>
                    </div>
                </div>
                <div class="card-body pt-0 pb-5">
                    
                    <!-- Sub Tabs for Categories -->
                    <ul class="nav nav-pills nav-pills-custom mb-3" style="border-bottom: 1px solid #EFF2F5;">
                        <li class="nav-item mb-3 me-3 me-lg-6">
                            <a class="nav-link d-flex justify-content-between flex-column flex-center overflow-hidden {{ $tab == \'ai\' ? \'active bg-light-primary\' : \'\' }} w-120px h-85px py-4" href="/account/orders?tab=ai" style="border-radius: 12px;">
                                <i class="ki-duotone ki-robot fs-2x mb-2 {{ $tab == \'ai\' ? \'text-primary\' : \'\' }}"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                                <span class="nav-text text-gray-700 fw-bold fs-6 lh-1">Tài khoản AI</span>
                                <span class="bullet-custom position-absolute bottom-0 w-100 h-4px bg-primary {{ $tab == \'ai\' ? \'\' : \'d-none\' }}"></span>
                            </a>
                        </li>
                        <li class="nav-item mb-3 me-3 me-lg-6">
                            <a class="nav-link d-flex justify-content-between flex-column flex-center overflow-hidden {{ $tab == \'code\' ? \'active bg-light-primary\' : \'\' }} w-120px h-85px py-4" href="/account/orders?tab=code" style="border-radius: 12px;">
                                <i class="ki-duotone ki-code fs-2x mb-2 {{ $tab == \'code\' ? \'text-primary\' : \'\' }}"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></i>
                                <span class="nav-text text-gray-700 fw-bold fs-6 lh-1">Mã Nguồn</span>
                                <span class="bullet-custom position-absolute bottom-0 w-100 h-4px bg-primary {{ $tab == \'code\' ? \'\' : \'d-none\' }}"></span>
                            </a>
                        </li>
                        <li class="nav-item mb-3 me-3 me-lg-6">
                            <a class="nav-link d-flex justify-content-between flex-column flex-center overflow-hidden {{ $tab == \'domain\' ? \'active bg-light-primary\' : \'\' }} w-120px h-85px py-4" href="/account/orders?tab=domain" style="border-radius: 12px;">
                                <i class="ki-duotone ki-pill fs-2x mb-2 {{ $tab == \'domain\' ? \'text-primary\' : \'\' }}"><span class="path1"></span><span class="path2"></span></i>
                                <span class="nav-text text-gray-700 fw-bold fs-6 lh-1">Tên Miền</span>
                                <span class="bullet-custom position-absolute bottom-0 w-100 h-4px bg-primary {{ $tab == \'domain\' ? \'\' : \'d-none\' }}"></span>
                            </a>
                        </li>
                    </ul>
                    
                    <div class="separator mb-5"></div>
                    
                    <!-- Table Content based on Tab -->
                    <div class="table-responsive">
                        <table id="kt_datatable_orders" class="table align-middle table-row-dashed fs-6 gy-5">
                            <thead>
                                @if($tab == \'ai\')
                                    <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                                        <th class="min-w-50px">STT</th>
                                        <th class="min-w-250px">Tài Khoản AI</th>
                                        <th class="min-w-150px">Gói Dịch Vụ</th>
                                        <th class="min-w-100px">Số Lượng</th>
                                        <th class="min-w-150px">Tổng Tiền</th>
                                        <th class="min-w-150px">Thông Tin Nhận</th>
                                        <th class="min-w-150px">Ngày Mua</th>
                                        <th class="min-w-100px">Hành Động</th>
                                    </tr>
                                @elseif($tab == \'code\')
                                    <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                                        <th class="min-w-50px">STT</th>
                                        <th class="min-w-250px">Tên Mã Nguồn</th>
                                        <th class="min-w-150px">Giá</th>
                                        <th class="min-w-150px">Ngày Mua</th>
                                        <th class="min-w-100px">Hành Động</th>
                                    </tr>
                                @elseif($tab == \'domain\')
                                    <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                                        <th class="min-w-50px">STT</th>
                                        <th class="min-w-250px">Tên Miền</th>
                                        <th class="min-w-150px">Giá</th>
                                        <th class="min-w-150px">Ngày Mua</th>
                                        <th class="min-w-100px">Hành Động</th>
                                    </tr>
                                @endif
                            </thead>
                            <tbody class="text-gray-600 fw-semibold">
                                @php $i = 1; @endphp
                                @foreach ($data[\'orders\'] ?? [] as $order)
                                    @if($tab == \'ai\')
                                        <tr>
                                            <td><span class="badge badge-light-primary fs-7 fw-bold">{{ $i++ }}</span></td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    @if(isset($order->aiAccount) && $order->aiAccount->image)
                                                        <div class="symbol symbol-50px me-3" style="border-radius: 8px; overflow: hidden;">
                                                            <img src="{{ $order->aiAccount->image }}" class="" alt="">
                                                        </div>
                                                    @endif
                                                    <div class="d-flex justify-content-start flex-column">
                                                        <a href="/ai-account/{{ $order->aiAccount->slug ?? $order->ai_account_id }}" class="text-gray-800 fw-bold text-hover-primary mb-1 fs-6">
                                                            {{ $order->aiAccount->name ?? \'Tài khoản đã bị xóa\' }}
                                                        </a>
                                                        <span class="text-gray-500 fw-semibold d-block fs-7">
                                                            Người bán: <span class="badge badge-light-success">{{ $order->seller->username ?? \'Admin\' }}</span>
                                                        </span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge badge-light-info fs-7">{{ $order->variant->name ?? \'N/A\' }}</span>
                                            </td>
                                            <td>
                                                <span class="badge badge-light-dark fs-7">{{ $order->quantity }}</span>
                                            </td>
                                            <td>
                                                <span class="text-success fw-bold">{{ number_format($order->total_price) }}đ</span>
                                            </td>
                                            <td>
                                                @if(isset($order->aiAccount))
                                                    <button type="button" class="btn btn-sm btn-light-primary btn-view-info" 
                                                        data-info="{{ htmlspecialchars($order->aiAccount->account_info) }}">
                                                        Xem thông tin
                                                    </button>
                                                @else
                                                    <span class="text-muted">Không có thông tin</span>
                                                @endif
                                            </td>
                                            <td>
                                                {{ \Carbon\Carbon::parse($order->created_at)->format(\'d/m/Y H:i\') }}
                                            </td>
                                            <td>
                                                <a href="/ai-account/{{ $order->aiAccount->slug ?? $order->ai_account_id }}" class="btn btn-sm btn-icon btn-light-primary">
                                                    <i class="ki-duotone ki-eye fs-2"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @elseif($tab == \'code\')
                                        <tr>
                                            <td><span class="badge badge-light-primary fs-7 fw-bold">{{ $i++ }}</span></td>
                                            <td>
                                                <div class="d-flex justify-content-start flex-column">
                                                    <a href="#" class="text-gray-800 fw-bold text-hover-primary mb-1 fs-6">
                                                        {{ $order->code->title ?? \'Mã nguồn đã bị xóa\' }}
                                                    </a>
                                                    <span class="text-gray-500 fw-semibold d-block fs-7">
                                                        Người bán: <span class="badge badge-light-success">{{ $order->seller->username ?? \'Admin\' }}</span>
                                                    </span>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="text-success fw-bold">{{ number_format($order->price ?? 0) }}đ</span>
                                            </td>
                                            <td>
                                                {{ \Carbon\Carbon::parse($order->created_at)->format(\'d/m/Y H:i\') }}
                                            </td>
                                            <td>
                                                @if(isset($order->code) && $order->code->link_dow)
                                                <a href="{{ $order->code->link_dow }}" target="_blank" class="btn btn-sm btn-primary">
                                                    <i class="ki-duotone ki-cloud-download fs-2"><span class="path1"></span><span class="path2"></span></i> Tải về
                                                </a>
                                                @endif
                                            </td>
                                        </tr>
                                    @elseif($tab == \'domain\')
                                        <tr>
                                            <td><span class="badge badge-light-primary fs-7 fw-bold">{{ $i++ }}</span></td>
                                            <td>
                                                <div class="d-flex justify-content-start flex-column">
                                                    <span class="text-gray-800 fw-bold mb-1 fs-6">
                                                        {{ $order->domain->domain ?? \'Tên miền đã bị xóa\' }}
                                                    </span>
                                                    <span class="text-gray-500 fw-semibold d-block fs-7">
                                                        Người bán: <span class="badge badge-light-success">{{ $order->seller->username ?? \'Admin\' }}</span>
                                                    </span>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="text-success fw-bold">{{ number_format($order->price ?? 0) }}đ</span>
                                            </td>
                                            <td>
                                                {{ \Carbon\Carbon::parse($order->created_at)->format(\'d/m/Y H:i\') }}
                                            </td>
                                            <td>
                                                <a href="/domain/history" class="btn btn-sm btn-primary">
                                                    Quản lý
                                                </a>
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!--end::Post-->
    </div>
    
    <!-- Modal for Account Info -->
    <div class="modal fade" tabindex="-1" id="accountInfoModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content shadow-sm" style="border-radius: 16px; border: 1px solid rgba(255, 255, 255, 0.15);">
                <div class="modal-header border-0 pb-0">
                    <h3 class="modal-title fw-bolder fs-2 text-gray-900">Thông tin tài khoản</h3>
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close" style="border-radius: 50%;">
                        <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                    </div>
                </div>
                <div class="modal-body py-5">
                    <div class="p-5 bg-light-primary rounded" style="border: 1px dashed #009ef7;">
                        <p id="accountInfoContent" class="fs-5 text-gray-800 fw-semibold m-0" style="white-space: pre-wrap; word-break: break-all;"></p>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0 justify-content-between">
                    <button type="button" class="btn btn-light rounded-pill px-6" data-bs-dismiss="modal">Đóng</button>
                    <button type="button" class="btn btn-primary rounded-pill px-8 fw-bold btn-copy-info shadow-sm">
                        <i class="ki-duotone ki-copy fs-2 me-2"><span class="path1"></span><span class="path2"></span></i> Copy Thông Tin
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section(\'scripts\')
    <script>
        $("#kt_datatable_orders").DataTable({
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.13.6/i18n/vi.json"
            }
        });
        
        $(\'.btn-view-info\').on(\'click\', function() {
            var info = $(this).data(\'info\');
            $(\'#accountInfoContent\').html(info);
            $(\'#accountInfoModal\').modal(\'show\');
        });
        
        $(\'.btn-copy-info\').on(\'click\', function() {
            var text = $(\'#accountInfoContent\').text();
            navigator.clipboard.writeText(text).then(function() {
                toastr.success("Đã copy thông tin tài khoản");
            }, function(err) {
                toastr.error("Lỗi khi copy");
            });
        });
    </script>
@endsection
';

file_put_contents('resources/views/account/profile/orders.blade.php', $orders_blade);
echo "Created resources/views/account/profile/orders.blade.php\n";
