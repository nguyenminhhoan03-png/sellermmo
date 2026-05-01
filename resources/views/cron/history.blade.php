@php use App\Helpers\Helper; @endphp 
@extends('layouts.app') 
@section('title', $pageTitle) 
@section('content')
<style>
    .action-buttons button {
        padding: 2px 6px;
        margin-right: 4px;
        font-size: 0.75rem;
        border: 1px solid transparent;
        border-radius: 4px;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .action-buttons button:hover {
        background-color: #e5e7eb;
    }

    .action-buttons button.run {
        background-color: #10b981;
        color: white;
    }

    .action-buttons button.pause {
        background-color: #f59e0b;
        color: white;
    }

    .action-buttons button.edit {
        background-color: #3b82f6;
        color: white;
    }

    .action-buttons button.extend {
        background-color: #6b46c1;
        color: white;
    }
    .table td {
    white-space: nowrap;
}

</style>
<div class="toolbar d-flex flex-stack py-3 py-lg-5" id="kt_toolbar">
    <div id="kt_toolbar_container" class="container-xxl d-flex flex-stack flex-wrap">
        <div class="page-title d-flex flex-column me-3">
            <h1 class="d-flex text-gray-900 fw-bold my-1 fs-3">
                Lịch sử thuê cron
            </h1>
            <ul class="breadcrumb breadcrumb-dot fw-semibold text-gray-600 fs-7 my-1">
                <li class="breadcrumb-item text-gray-600">
                    <a href="/" class="text-gray-600 text-hover-primary">
                        Home
                    </a>
                </li>
                <li class="breadcrumb-item text-gray-600">{{ $user->name }}</li>
                <li class="breadcrumb-item text-gray-500">Lịch sử thuê cron</li>
            </ul>
        </div>
    </div>
</div>
<div id="kt_content_container" class="d-flex flex-column-fluid align-items-start container-xxl">
    <div class="content flex-row-fluid" id="kt_content">
        <div class="hu hu-danger hu-dismissible fade show custom-hu-icon shadow-sm" style="margin-top: -3px;" role="hu">
            <svg class="svg-danger" xmlns="http://www.w3.org/2000/svg" height="1.5rem" viewBox="0 0 24 24" width="1.5rem" fill="#000000">
                <path d="M0 0h24v24H0z" fill="none"></path>
                <path d="M15.73 3H8.27L3 8.27v7.46L8.27 21h7.46L21 15.73V8.27L15.73 3zM12 17.3c-.72 0-1.3-.58-1.3-1.3 0-.72.58-1.3 1.3-1.3.72 0 1.3.58 1.3 1.3 0 .72-.58 1.3-1.3 1.3zm1-4.3h-2V7h2v6z"></path>
            </svg>
            Sử dụng hệ thống CRON đúng mục đích: Chúng tôi có quyền tạm ngừng hoặc hủy vĩnh viễn các liên kết CRON vi phạm.
            <svg class="feather feather-chevrons-right" height="24" width="24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <polyline points="13 17 18 12 13 7"></polyline>
                <polyline points="6 17 11 12 6 7"></polyline>
            </svg>
        </div>
        <div class="row g-5 g-xl-8 b-5 mb-5">
            @foreach ($stats['cron'] as $key => $value)
            <div class="col-xl-3">
        <a href="#" class="card bg-{{ $stats['t_cron'][$key]['color'] ?? 'primary' }} hoverable card-xl-stretch mb-xl-8">
            <div class="card-body">
                <i class="{{ $stats['t_cron'][$key]['icon'] ?? 'calendar' }}"><span class="path1"></span><span class="path2"></span></i>
                <div class="text-gray-800 fw-bold fs-2 mb-2 mt-5">           
                    {{ number_format($value) }}                
                </div>
        
                <div class="fw-semibold text-gray-400">
                    {{ $stats['t_cron'][$key]['label'] ?? $key }}        </div>
            </div>
        </a>
       </div>
       @endforeach
        </div> 
        <div class="card card-flush card-bordered">
                <div class="card-header justify-content-end ribbon ribbon-start">
                    <div class="ribbon-label bg-dark">LỊCH SỬ THUÊ CRON</div>
                    <div class="card-title"><button type="button" class="btn btn-sm btn-danger float-end mb-5" data-bs-toggle="modal" data-bs-target="#kt_modal_scrollable_2">
                        Mã lỗi cần biết
                    </button></div>
                </div>
        <div class="card-body pt-0">
            <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_customers_table">
                <thead>
                    <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                       
                        <th class="min-w-120px">Link Cron</th>
                        <th class="min-w-70px">Vòng lặp</th>
                        <th class="min-w-125px">Trạng thái</th>
                        <th class="min-w-125px">Chạy gần đây</th>
                        <th class="min-w-125px">Response</th>
                        <th class="min-w-125px">Thời gian hết hạn</th>
                        <th class="text-end min-w-70px">Thao Tác</th>
                    </tr>
                </thead>
                <tbody class="fw-semibold text-gray-600">
                    @foreach($listcron as $listcrons)
                    <tr>
                        <td>
                           {{ $listcrons->url }}
                        </td>
                        <td>
                           {{ $listcrons->second }}
                         </td>
                        <td>
                            {!! Helper::status_server_cron($listcrons->status) !!}
                         </td>
                         <td>
                            {{ $listcrons->time_his }}
                         </td>
                         <td>
                            {{ $listcrons->response }}
                         </td>
                        <td>
                           {{ $listcrons->expired_date}}
                        </td>
                        <td class="text-end">
                            <div class="action-buttons">
                                <button class="run mb-5" onclick="action('{{ $listcrons->id }}','run')">
                                    <i class="bx bx-play"></i> Chạy
                                </button>
                                <button class="pause mb-5" onclick="action('{{ $listcrons->id }}','pause')">
                                    <i class="bx bx-pause"></i> Tạm dừng
                                </button>
                                <button class="edit mb-5" onclick="edit('{{ $listcrons->id }}')">
                                    <i class="bx bx-edit"></i> Chỉnh sửa
                                </button>
                                <button class="extend mb-5" onclick="extend('{{ $listcrons->id }}')">
                                    <i class="bx bx-time"></i> Gia hạn
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
            </table>
            <!--end::Table-->
        </div>
        </div>
    </div>
</div> 
<script>
    function action(id, action) {
        var loadingLayer = layer.open({
            type: 2, 
            content: '<div>Đang xử lý...</div>',
            shade: [0.7, '#000'], 
            shadeClose: false,
            time: 0 
        });
        $.ajax({
            url: '{{ route('cronjob.action') }}', 
            method: 'POST',
            dataType: 'JSON',
            headers: {
              'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            data: {
                id: id,
                action: action
            },
            success: function(data) {
                layer.close(loadingLayer);
                if (data.status == '200') {
                showMessage(data.message, 'success');
                window.location.href = ('{{ route('cronjob.history') }}');
               }
            },
            error: function (xhr, status, error) {
                layer.close(loadingLayer);
            var responseMessage = xhr.responseJSON
                ? xhr.responseJSON.message
                : 'Không thể thực hiện';
            showMessage(responseMessage, 'error');
           },
        });
    }
    function edit(id) {
        var loadingLayer = layer.open({
            type: 2, 
            content: '<div>Đang xử lý...</div>',
            shade: [0.7, '#000'], 
            shadeClose: false,
            time: 0 
        });
        $.ajax({
            url: '{{ route('cronjob.show-edit') }}',
            method: 'POST',
            headers: {
              'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            data: {
                id: id
            },
            success: function(response) {
                layer.close(loadingLayer);
                $('#modalViewEdit').html(response);
                $('#modalEdit').modal('show');
            },
            error: function (xhr, status, error) {
                layer.close(loadingLayer);
            var responseMessage = xhr.responseJSON
                ? xhr.responseJSON.message
                : 'Không thể thực hiện';
            showMessage(responseMessage, 'error');
           },
        });
    }
    function extend(id) {
        var loadingLayer = layer.open({
            type: 2, 
            content: '<div>Đang xử lý...</div>',
            shade: [0.7, '#000'], 
            shadeClose: false,
            time: 0 
        });
        $.ajax({
            url: '{{ route('cronjob.show-giahan') }}',
            method: 'POST',
            headers: {
              'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            data: {
                id: id
            },
            success: function(response) {
                layer.close(loadingLayer);
                $('#modalViewExtend').html(response);
                $('#modalExtend').modal('show');
            },
            error: function (xhr, status, error) {
                layer.close(loadingLayer);
            var responseMessage = xhr.responseJSON
                ? xhr.responseJSON.message
                : 'Không thể thực hiện';
            showMessage(responseMessage, 'error');
           },
        });
    }
   </script> 
<div class="modal fade" id="modalEdit" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Chỉnh sửa link Cron</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <div id="modalViewEdit">
            </div>
    </div>
</div>
</div>
</div>
<div class="modal fade modal-animate" id="modalExtend" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Gia Hạn Cron</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <div id="modalViewExtend">
            </div>
    </div>
</div>
</div>
</div>
<div class="modal fade" tabindex="-1" id="kt_modal_scrollable_2">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Mã lỗi cần biết</h5>

                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <i class="ki-duotone ki-cross fs-2x"><span class="path1"></span><span class="path2"></span></i>
                </div>
                <!--end::Close-->
            </div>

            <div class="modal-body">
                <p>Dưới đây là danh sách đầy đủ các mã trạng thái HTTP (HTTP Status Codes) nếu bạn gặp phải lỗi:</p>

                <h3><span style="color:#e74c3c">1xx Phản hồi thông tin</span></h3>
                
                <ul>
                    <li><strong>100 Tiếp tục</strong> : Máy chủ đã nhận được tiêu đề yêu cầu và máy khách phải tiến hành gửi nội dung yêu cầu.</li>
                    <li><strong>101 Chuyển đổi giao thức</strong> : Người yêu cầu đã yêu cầu máy chủ chuyển đổi giao thức và máy chủ đã đồng ý thực hiện việc đó.</li>
                    <li><strong>102 Đang xử lý</strong> : WebDAV; máy chủ đã nhận được và đang xử lý yêu cầu, nhưng vẫn chưa có phản hồi nào.</li>
                    <li><strong>103 Gợi ý sớm</strong> : Được sử dụng để trả về một số tiêu đề phản hồi trước tin nhắn HTTP cuối cùng.</li>
                </ul>
                
                <h3><span style="color:#e74c3c">2xx Thành công</span></h3>
                
                <ul>
                    <li><strong>200 OK</strong> : Yêu cầu đã thành công.</li>
                    <li><strong>201 Đã tạo</strong> : Yêu cầu đã được thực hiện, dẫn đến việc tạo ra một tài nguyên mới.</li>
                    <li><strong>202 Đã chấp nhận</strong> : Yêu cầu đã được chấp nhận để xử lý, nhưng quá trình xử lý chưa hoàn tất.</li>
                    <li><strong>203 Thông tin không có thẩm quyền</strong> : Yêu cầu đã thành công nhưng nội dung được đính kèm đã bị sửa đổi bởi một proxy chuyển đổi.</li>
                    <li><strong>204 Không có nội dung</strong> : Máy chủ đã xử lý yêu cầu thành công và không trả về bất kỳ nội dung nào.</li>
                    <li><strong>205 Đặt lại nội dung</strong> : Máy chủ đã xử lý yêu cầu thành công, yêu cầu người yêu cầu đặt lại chế độ xem tài liệu.</li>
                    <li><strong>206 Nội dung một phần</strong> : Máy chủ chỉ cung cấp một phần tài nguyên do tiêu đề phạm vi được máy khách gửi.</li>
                    <li><strong>207 Đa trạng thái</strong> : WebDAV; nội dung tin nhắn theo sau theo mặc định là tin nhắn XML và có thể chứa một số mã phản hồi riêng biệt.</li>
                    <li><strong>208 Đã báo cáo</strong> : WebDAV; các thành viên của liên kết DAV đã được liệt kê trong phản hồi trước đó cho yêu cầu này.</li>
                    <li><strong>226 IM đã sử dụng</strong> : Máy chủ đã thực hiện yêu cầu GET cho tài nguyên và phản hồi là biểu diễn kết quả của một hoặc nhiều thao tác áp dụng cho phiên bản hiện tại.</li>
                </ul>
                
                <h3><span style="color:#e74c3c">Chuyển hướng 3xx</span></h3>
                
                <ul>
                    <li><strong>300 Nhiều lựa chọn</strong> : Yêu cầu có nhiều hơn một phản hồi có thể. Tác nhân người dùng hoặc người dùng phải chọn một trong số chúng.</li>
                    <li><strong>301 Đã di chuyển vĩnh viễn</strong> : URL của tài nguyên được yêu cầu đã được thay đổi vĩnh viễn. URL mới được cung cấp trong phản hồi.</li>
                    <li><strong>302 Đã tìm thấy</strong> : URL của tài nguyên được yêu cầu đã được thay đổi tạm thời. Những thay đổi tiếp theo trong URL có thể được thực hiện trong tương lai.</li>
                    <li><strong>303 Xem Khác</strong> : Phản hồi cho yêu cầu có thể được tìm thấy trong URL khác bằng cách sử dụng phương thức GET.</li>
                    <li><strong>304 Không sửa đổi</strong> : Chỉ ra rằng tài nguyên chưa được sửa đổi kể từ phiên bản được chỉ định bởi tiêu đề yêu cầu.</li>
                    <li><strong>305 Sử dụng Proxy</strong> : Đã lỗi thời, được sử dụng trong phiên bản trước của thông số kỹ thuật HTTP/1.1.</li>
                    <li><strong>306 Switch Proxy</strong> : Không còn được sử dụng nữa. Ban đầu có nghĩa là "Các yêu cầu tiếp theo nên sử dụng proxy đã chỉ định."</li>
                    <li><strong>307 Chuyển hướng tạm thời</strong> : Trong trường hợp này, yêu cầu phải được lặp lại với một URI khác; tuy nhiên, các yêu cầu trong tương lai vẫn phải sử dụng URI ban đầu.</li>
                    <li><strong>308 Chuyển hướng vĩnh viễn</strong> : Yêu cầu và tất cả các yêu cầu trong tương lai phải được lặp lại bằng cách sử dụng một URI khác.</li>
                </ul>
                
                <h3><span style="color:#e74c3c">Lỗi của khách hàng 4xx</span></h3>
                
                <ul>
                    <li><strong>400 Yêu cầu không hợp lệ</strong> : Máy chủ không thể hiểu được yêu cầu do cú pháp không hợp lệ.</li>
                    <li><strong>401 Không được phép</strong> : Máy khách phải tự xác thực để nhận được phản hồi theo yêu cầu.</li>
                    <li><strong>402 Yêu cầu thanh toán</strong> : Mã phản hồi này được dành riêng cho mục đích sử dụng sau này.</li>
                    <li><strong>403 Bị cấm</strong> : Máy khách không có quyền truy cập vào nội dung.</li>
                    <li><strong>404 Không tìm thấy</strong> : Máy chủ không tìm thấy tài nguyên được yêu cầu.</li>
                    <li><strong>405 Phương pháp không được phép</strong> : Phương pháp yêu cầu được máy chủ biết đến nhưng đã bị vô hiệu hóa và không thể sử dụng.</li>
                    <li><strong>406 Không chấp nhận</strong> : Máy chủ chỉ có thể tạo phản hồi không được máy khách chấp nhận.</li>
                    <li><strong>407 Yêu cầu xác thực proxy</strong> : Trước tiên, máy khách phải xác thực với proxy.</li>
                    <li><strong>408 Hết thời gian yêu cầu</strong> : Máy chủ muốn tắt kết nối không sử dụng này.</li>
                    <li><strong>409 Xung đột</strong> : Yêu cầu xung đột với trạng thái hiện tại của máy chủ.</li>
                    <li><strong>410 Đã mất</strong> : Nội dung được yêu cầu đã bị xóa vĩnh viễn khỏi máy chủ.</li>
                    <li><strong>411 Yêu cầu về độ dài</strong> : Máy chủ từ chối chấp nhận yêu cầu nếu không có tiêu đề Content-Length được xác định.</li>
                    <li><strong>412 Điều kiện tiên quyết không thành công</strong> : Máy khách đã chỉ ra các điều kiện tiên quyết trong tiêu đề mà máy chủ không đáp ứng.</li>
                    <li><strong>413 Tải trọng quá lớn</strong> : Thực thể yêu cầu lớn hơn giới hạn do máy chủ xác định.</li>
                    <li><strong>414 URI quá dài</strong> : URI mà máy khách yêu cầu dài hơn mức máy chủ có thể hiểu được.</li>
                    <li><strong>415 Loại phương tiện không được hỗ trợ</strong> : Định dạng phương tiện của dữ liệu được yêu cầu không được máy chủ hỗ trợ.</li>
                    <li><strong>416 Phạm vi không thỏa mãn</strong> : Phạm vi được chỉ định bởi trường tiêu đề Phạm vi trong yêu cầu không thể thỏa mãn.</li>
                    <li><strong>417 Không đạt kỳ vọng</strong> : Kỳ vọng được đưa ra trong tiêu đề Expect của yêu cầu không thể đạt được.</li>
                    <li><strong>418 Tôi là một chiếc ấm trà</strong> : Mã này được định nghĩa vào năm 1998 như một trong những trò đùa Cá tháng Tư truyền thống của IETF, trong RFC 2324, Giao thức điều khiển ấm cà phê siêu văn bản.</li>
                    <li><strong>421 Yêu cầu sai hướng</strong> : Yêu cầu được chuyển đến một máy chủ không thể đưa ra phản hồi.</li>
                    <li><strong>422 Thực thể không thể xử lý</strong> : WebDAV; yêu cầu được định dạng tốt nhưng không thể thực hiện được do lỗi ngữ nghĩa.</li>
                    <li><strong>423 Đã khóa</strong> : WebDAV; tài nguyên đang được truy cập đã bị khóa.</li>
                    <li><strong>424 Lỗi phụ thuộc</strong> : WebDAV; yêu cầu không thành công do yêu cầu trước đó không thành công.</li>
                    <li><strong>425 Quá sớm</strong> : Chỉ ra rằng máy chủ không muốn mạo hiểm xử lý một yêu cầu có thể bị phát lại.</li>
                    <li><strong>426 Yêu cầu nâng cấp</strong> : Máy khách phải chuyển sang giao thức khác như TLS/1.0, được cung cấp trong trường tiêu đề Nâng cấp.</li>
                    <li><strong>428 Điều kiện tiên quyết bắt buộc</strong> : Máy chủ gốc yêu cầu yêu cầu phải có điều kiện.</li>
                    <li><strong>429 Quá nhiều yêu cầu</strong> : Người dùng đã gửi quá nhiều yêu cầu trong một khoảng thời gian nhất định ("giới hạn tốc độ").</li>
                    <li><strong>431 Trường tiêu đề yêu cầu quá lớn</strong> : Máy chủ không muốn xử lý yêu cầu vì trường tiêu đề quá lớn.</li>
                    <li><strong>451 Không khả dụng vì lý do pháp lý</strong> : Người dùng yêu cầu một tài nguyên bất hợp pháp, chẳng hạn như một trang web bị chính phủ kiểm duyệt.</li>
                </ul>
                
                <h3><span style="color:#e74c3c">Lỗi máy chủ 5xx</span></h3>
                
                <ul>
                    <li><strong>Lỗi máy chủ nội bộ 500</strong> : Máy chủ đã gặp phải tình huống không biết cách xử lý.</li>
                    <li><strong>501 Không triển khai</strong> : Phương thức yêu cầu không được máy chủ hỗ trợ và không thể xử lý.</li>
                    <li><strong>502 Bad Gateway</strong> : Máy chủ khi hoạt động như một cổng để nhận phản hồi cần thiết để xử lý yêu cầu đã nhận được phản hồi không hợp lệ.</li>
                    <li><strong>503 Dịch vụ không khả dụng</strong> : Máy chủ không sẵn sàng xử lý yêu cầu.</li>
                    <li><strong>504 Hết thời gian chờ cổng</strong> : Máy chủ đang hoạt động như một cổng và không thể nhận được phản hồi kịp thời.</li>
                    <li><strong>505 Phiên bản HTTP không được hỗ trợ</strong> : Phiên bản HTTP được sử dụng trong yêu cầu không được máy chủ hỗ trợ.</li>
                    <li><strong>Biến thể 506 cũng đàm phán</strong> : Đàm phán nội dung minh bạch cho kết quả yêu cầu trong một tham chiếu vòng tròn.</li>
                    <li><strong>507 Không đủ dung lượng lưu trữ</strong> : WebDAV; máy chủ không thể lưu trữ dữ liệu cần thiết để hoàn tất yêu cầu.</li>
                    <li><strong>508 Phát hiện vòng lặp</strong> : WebDAV; máy chủ phát hiện vòng lặp vô hạn trong khi xử lý yêu cầu.</li>
                    <li><strong>510 Không mở rộng</strong> : Yêu cầu cần được mở rộng thêm để máy chủ có thể thực hiện được.</li>
                    <li><strong>511 Yêu cầu xác thực mạng</strong> : Máy khách cần xác thực để có thể truy cập mạng.</li>
                    <li><strong>522 Kết nối hết thời gian</strong> : Máy chủ không nhận được phản hồi kịp thời từ máy chủ thượng nguồn mà nó cần truy cập để hoàn tất yêu cầu. Điều này thường thấy trong bối cảnh của Cloudflare và các mạng phân phối nội dung khác</li>
                    <li><strong>524 Đã xảy ra thời gian chờ</strong> : Máy chủ có thể thiết lập kết nối với máy chủ phía thượng nguồn nhưng không nhận được phản hồi HTTP kịp thời</li>
                </ul>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Đã hiểu</button>
            </div>
        </div>
    </div>
</div>
@endsection