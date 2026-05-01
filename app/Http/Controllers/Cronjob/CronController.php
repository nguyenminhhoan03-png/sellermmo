<?php

namespace App\Http\Controllers\Cronjob;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\CronOrder;
use App\Models\User;
use App\Models\SeverCron;
use App\Models\Logs;
use App\Models\Transaction;
use App\Events\GlobalPurchaseEvent;
use Illuminate\Http\Request;


class CronController extends Controller
{
  public function index()
  {
    $user = User::find(auth()->user()->id);
    $server = SeverCron::where('status', 1)->get();
    return view('cron.index', [
      'pageTitle' => 'Cronjob tự động hóa công việc',
      'server' => $server,
      'user' => $user,
    ]);
  }
  public function payment(Request $request)
  {
    if (env('PRJ_DEMO_MODE', false) === true) {
      return response()->json([
        'status'  => 500,
        'message' => 'Chức năng này không hoạt động trong chế độ demo.',
      ], 500);
    }
    $payload = $request->validate([
      'server' => 'required|integer',
      'thoigiangiahan' => 'required|integer',
      'url' => 'required|string',
      'sogiay' => 'required|integer',

    ]);
    $user = User::find(auth()->user()->id);
    $maychucron = $payload['server'];
    $linkcron = $payload['url'];
    $timeloop = (int)$payload['sogiay'];
    $thoigiangiahan = (int)$payload['thoigiangiahan'];
    if ($timeloop < 1) {
      return response()->json([
        'status'  => 500,
        'message' => 'Số giây không hợp lệ rồi!',
      ], 500);
    }
    if ($thoigiangiahan < 1) {
      return response()->json([
        'status'  => 500,
        'message' => 'Thời gian tối thiểu là tháng.',
      ], 500);
    }
    $server = SeverCron::where('status', 1)->where('id', $maychucron)->firstOrFail();
    if (!$server) {
      return response()->json([
        'status'  => 500,
        'message' => 'Có vẻ như máy chủ này không hoạt động hoặc không tồn tại trên hệ thống.',
      ], 500);
    }
    if ($server->quantity < 1) {
      return response()->json([
        'status'  => 500,
        'message' => 'Có vẻ như máy chủ này đã đầy vui lòng chọn máy chủ khác.',
      ], 500);
    }
    $tongtien = $server->price - ($server->price * ($server->ck / 100));
    if ($user->banned !== 0) {
      return response()->json([
        'status'  => 400,
        'message' => 'Tài khoản của bạn đang bị khóa, vui lòng liên hệ admin để được hỗ trợ.',
      ], 400);
    }
    if ($user->balance < $tongtien) {
      return response()->json([
        'status'  => 403,
        'message' => 'Tài khoản của bạn không đủ để thực hiện thao tác này',
      ], 403);
    }
    if ($user->decrement('balance', $tongtien) === false) {
      return response()->json([
        'status'  => 500,
        'message' => 'Đã có lỗi trong quá trình thanh toán, vui lòng liên hệ admin.',
      ], 500);
    }
    $trans_id = Helper::random('QWERTYUIOPASDFGHJKZXCVBNM', 2) . time();
    $time_set = $thoigiangiahan * 2592000;
    $time = time() + $time_set;
    $expired_date =  date("Y-m-d H:i:s", $time);
    $list = CronOrder::create([
      'user_id' => $user->id,
      'id_server' => $maychucron,
      'url' => $linkcron,
      'status' => 'hoatdong',
      'price' => $tongtien,
      'second' => $timeloop,
      'response' => 'Đang Xử Lý',
      'time_his' => date("Y-m-d H:i:s"),
      'trans_id' => $trans_id,
      'expired_date' => $expired_date,
      'expired_timestamp' => $time,
    ]);
    $server->decrement('quantity', '1');
    Transaction::create([
      'code'           => $trans_id,
      'amount'         => $tongtien,
      'balance_before' => $user->balance + $tongtien,
      'balance_after'  => $user->balance,
      'type'           => 'new-order',
      'status'         => 'paid',
      'content'        => '[' . $server->name . '] ; mã số ' . $server->id . '; Thanh toán thành công cho người dùng ' . $user->username,
      'extras'         => [
        'id'         => $server->id,
        'order_code' => $trans_id,
      ],
      'user_id'        => $user->id,
      'lickey' => '',
      'username'       => $user->username,
      'order_id'       => $server->id,
    ]);
    $content = 'Thành toán cron máy chủ ' . $server->name . ' Mã số ' . $server->id;
    Logs::create([
      'data'       => '0',
      'action'    => $content,
      'description' => "Thực hiện hành động " . $content . " với địa chỉ ip" . request()->ip(),
      'old_data' => 0,
      'new_data' => 0,
      'user_id'    => $user->id,
      'ip' => request()->ip(),
      'data_json' => '',
    ]);
    if ($list) {
      try {
        broadcast(new GlobalPurchaseEvent([
          'userName'     => $user->name,
          'productName'  => 'CronJob: ' . $server->name,
          'productPrice' => number_format($tongtien) . ' đ',
          'location'     => 'Việt Nam',
          'time'         => now()->toDateTimeString(),
        ]));
      } catch (\Exception $e) {}

      return response()->json([
        'status' => 200,
        'message' => 'Thuê Cron Thành Công.',
        'data' => [
          'redirect' => route('cronjob.history'),
        ],
      ]);
    } else {
      return response()->json([
        'status'  => 500,
        'message' => 'Đã có lỗi trong quá trình thanh toán, vui lòng liên hệ admin.',
      ], 500);
    }
  }
  public function history()
  {
    $stats = [];


    $user = User::find(auth()->user()->id);
    $listcron = CronOrder::where('user_id', $user->id)->get();
    $stats['cron'] = [
      'hoatdong'  => CronOrder::where('user_id', $user->id)->where('status', 'hoatdong')->count(),
      'tamdung'   => CronOrder::where('user_id', $user->id)->where('status', 'tamdung')->count(),
      'loi'       => CronOrder::where('user_id', $user->id)->where('status', 'loi')->count(),
      'hethan'       => CronOrder::where('user_id', $user->id)->where('status', 'hethan')->count(),
    ];
    $stats['t_cron'] = [
      'hoatdong'               => [
        'label' => 'Đang hoạt động',
        'color' => 'body',
        'icon' => 'ki-duotone ki-check-circle text-success fs-2x ms-n1',
      ],
      'tamdung'               => [
        'label' => 'Đã tạm dừng',
        'color' => 'body',
        'icon' => 'ki-duotone ki-cross-circle text-warning fs-2x ms-n1',
      ],
      'loi'               => [
        'label' => 'Đang bị lỗi',
        'color' => 'body',
        'icon' => 'fa-solid fa-circle-pause text-danger fs-2x ms-n1',
      ],
      'hethan'               => [
        'label' => 'Đã hết hạn',
        'color' => 'body',
        'icon' => 'ki-duotone ki-calendar text-primary fs-2x ms-n1',
      ],
    ];
    return view('cron.history', [
      'pageTitle' => 'Lịch sử thuê cron',
      'listcron' => $listcron,
      'user' => $user,
      'stats' => $stats,
    ]);
  }
  public function action(Request $request)
  {
    if (env('PRJ_DEMO_MODE', false) === true) {
      return response()->json([
        'status'  => 500,
        'message' => 'Chức năng này không hoạt động trong chế độ demo.',
      ], 500);
    }
    $payload = $request->validate([
      'action' => 'required|in:run,pause',
      'id' => 'required|exists:list_url_cron,id',
    ]);
    $order = CronOrder::find($payload['id']);
    if (!$order) {
      return response()->json([
        'status'  => 404,
        'message' => 'Chúng tôi không thể tim thấy link cron này của bạn.',
      ], 404);
    }
    if ($payload['action'] == 'run') {
      $order->response = '';
      $order->status = 'hoatdong';
      $order->save();
      return response()->json([
        'status'  => 200,
        'message' => 'Khởi chạy thành công.',
      ]);
    }
    if ($payload['action'] == 'pause') {
      if ($order->status == 'hethan') {
        return response()->json([
          'status'  => 500,
          'message' => 'Link này đã hết hạn ko thể tạm dừng.',
        ], 500);
      }
      $order->response = 'Đang dừng xe';
      $order->status = 'tamdung';
      $order->save();
      return response()->json([
        'status'  => 200,
        'message' => 'Đã tạm dừng thành công.',
      ]);
    }
  }
  public function ShoweditModal(Request $request)
  {
    if (env('PRJ_DEMO_MODE', false) === true) {
      return response()->json([
        'status'  => 500,
        'message' => 'Chức năng không hoạt động trong chế độ demo.',
      ], 500);
    }
    $payload = $request->validate([
      'id' => 'required|exists:list_url_cron,id',
    ]);
    $order = CronOrder::find($payload['id']);
    if (!$order) {
      return response()->json([
        'status'  => 404,
        'message' => 'Chúng tôi không thể tìm thấy link cron bạn.',
      ], 404);
    }
    return '
  <div class="modal-body">
      <div class="mb-4">
          <label for="trans_id" class="block text-gray-700">Đơn hàng:</label>
          <input type="text" value="' . ($order['trans_id']) . '" disabled class="form-control text-danger">
      </div>
      <div class="mb-4">
          <label for="url" class="block text-gray-700">Link cron:</label>
          <input type="text" value="' . htmlspecialchars($order['url']) . '" id="url" class="form-control required">
      </div>
      <div class="mb-4">
          <label for="second" class="block text-gray-700">Số giây:</label>
          <input type="number" value="' . htmlspecialchars($order['second']) . '" id="second" class="form-control required">
      </div>
  </div>
      <div class="modal-footer">
                  <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button> 
                  <button type="button" id="edit" class="btn btn-primary shadow-2" onclick="editCron(' . ($order['id']) . ')">Cập Nhật</button></div>
          </div>
  <script>
      function editCron(id) {
          $("#edit").html("Đang xử lý...").prop("disabled",
              true);
           var loadingLayer = layer.open({
            type: 2, 
            content: "<div>Đang xử lý...</div>",
            shade: [0.7, "#000"], 
            shadeClose: false,
            time: 0 
          });
          $.ajax({
              url: "' . route('cronjob.edit') . '",
              method: "POST",
               headers: {
              "X-CSRF-TOKEN": "' . csrf_token() . '"
             },
              data: {
                  id: id,
                  action: "edit",
                  url: $("#url").val(),
                  second: $("#second").val()
              },
              success: function(response) {
                 layer.close(loadingLayer);
                  if (response.status == "200") {
                showMessage(response.message, "success");
                window.location.href = ("' . route("cronjob.history") . '");
               }
                $("#edit").html(
                          "Cập Nhật")
                      .prop("disabled", false);
              },
              error: function (xhr, status, error) {
                layer.close(loadingLayer);
            var responseMessage = xhr.responseJSON
                ? xhr.responseJSON.message
                : "Không thể thực hiện";
            showMessage(responseMessage, "error");
           },
          });
      }
  </script>';
  }
  public function edit(Request $request)
  {
    if (env('PRJ_DEMO_MODE', false) === true) {
      return response()->json([
        'status'  => 500,
        'message' => 'Chức năng này không hoạt động trong chế độ demo.',
      ], 500);
    }
    $payload = $request->validate([
      'action' => 'required|in:edit',
      'id' => 'required|exists:list_url_cron,id',
      'url' => 'required',
      'second' => 'required',
    ]);
    $order = CronOrder::find($payload['id']);
    if (!$order) {
      return response()->json([
        'status'  => 404,
        'message' => 'Chúng tôi không thể tim thấy link cron này của bạn.',
      ], 404);
    }
    if ($order->status == 'hoatdong') {
      return response()->json([
        'status'  => 500,
        'message' => 'Vui lòng tạm dừng cron để thực hiện thao tác này.',
      ], 500);  
    }
    if ($payload['action'] == 'edit') {
      $order->url = $payload['url'];
      $order->second = $payload['second'];
      $order->save();
      return response()->json([
        'status'  => 200,
        'message' => 'Sửa link cron thành công.',
      ], 200);
    } else {
      return response()->json([
        'status'  => 500,
        'message' => 'Vui lòng chạy đúng chức năng.',
      ]);
    }
  }
  public function ShowGiaHanModal(Request $request)
  {
    if (env('PRJ_DEMO_MODE', false) === true) {
      return response()->json([
        'status'  => 500,
        'message' => 'Chức năng không hoạt động trong chế độ demo.',
      ], 500);
    }
    $payload = $request->validate([
      'id' => 'required|exists:list_url_cron,id',
    ]);
    $order = CronOrder::find($payload['id']);
    if (!$order) {
      return response()->json([
        'status'  => 404,
        'message' => 'Chúng tôi không thể tìm thấy link cron bạn.',
      ], 404);
    }
    $id_server = $order->id;
    $server = SeverCron::where('id', $id_server)->where('status', 1)->firstOrFail();
    $ck = $server->ck;
    $price = $server->price;
    $tongtien = $price - ($price * ($ck / 100));
    return '<div class="modal-body">
    <div class="mb-4">
        <label for="name" class="block text-gray-700">Đơn hàng:</label>
        <input type="text" value="' . ($order['trans_id']) . '" disabled class="form-control text-danger">
        <input type="hidden" value="'.($tongtien) .'" id="price" />
    </div>
    <div class="mb-4">
       <input type="hidden" value="'.($tongtien) .'" id="price" />
        <label for="name" class="block text-gray-700">Link cron:</label>
        <input type="text" value="' . htmlspecialchars($order['url']) . '" disabled class="form-control text-danger">
    </div>
    <div class="mb-4">
        <label for="months" class="block text-gray-700">Thời gian:</label>

            <select id="months" class="form-select">
                                    <option value="1" selected="selected">1 Tháng</option>
                                    <option value="2">2 Tháng</option>
                                    <option value="3">3 Tháng</option>
                                    <option value="4">4 Tháng</option>
                                    <option value="5">5 Tháng</option>
                                    <option value="6">6 Tháng</option>
                                    <option value="7">7 Tháng</option>
                                    <option value="8">8 Tháng</option>
                                    <option value="9">9 Tháng</option>
                                    <option value="10">10 Tháng</option>
                                    <option value="11">11 Tháng</option>
                                    <option value="12">12 Tháng</option>
                            </select>

    </div>
    <div class="el-form-item asterisk-left">
        <div class="mt-4">
            <label class="font-medium block text-zinc-800 text-xs mb-1">Thanh toán:</label>
            <span class="font-extrabold text-red-600" id="total">'.formatCurrency($tongtien) .'</span>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button> 
    <button type="button" id="extend" class="btn btn-primary" onclick="extendCron(' . ($order['id']) . ')">Gia Hạn</button>
</div>
<script>
    document.getElementById("months").addEventListener("change", function() {
        var months = this.value;
        var price = document.getElementById("price").value;
        var totalPayment = months * price;
        document.getElementById("total").textContent = totalPayment.toLocaleString("vi-VN", { style: "currency", currency: "VND" });
    });
    function extendCron(id) {
        $("#extend").html("Đang xử lý...").prop("disabled",
            true);
            var loadingLayer = layer.open({
            type: 2, 
            content: "<div>Đang xử lý...</div>",
            shade: [0.7, "#000"], 
            shadeClose: false,
            time: 0 
          });
        $.ajax({
            url: "'. route('cronjob.giahan') .'",
            method: "POST",
            dataType: "JSON",
             headers: {
              "X-CSRF-TOKEN": "' . csrf_token() . '"
             },
            data: {
                id: id,
                action: "giahan",
                month: $("#months").val()
            },
            success: function(res) {
                layer.close(loadingLayer);
                if (res.status == "200") {
                    showMessage(res.message, "success");
                    window.location.href = "'. route('cronjob.history') .'";
                }
                $("#extend").html(
                        "Gia Hạn")
                    .prop("disabled", false);
            },
              error: function (xhr, status, error) {
                layer.close(loadingLayer);
            var responseMessage = xhr.responseJSON
                ? xhr.responseJSON.message
                : "Không thể thực hiện";
            showMessage(responseMessage, "error");
           },
        });
    }
</script>';
  }
  public function giahan(Request $request)
  {
    if (env('PRJ_DEMO_MODE', false) === true) {
      return response()->json([
        'status'  => 500,
        'message' => 'Chức năng này không hoạt động trong chế độ demo.',
      ], 500);
    }
    $payload = $request->validate([
      'action' => 'required|in:giahan',
      'id' => 'required|exists:list_url_cron,id',
      'month' => 'required',
    ]);
    $order = CronOrder::find($payload['id']);
    if (!$order) {
      return response()->json([
        'status'  => 404,
        'message' => 'Chúng tôi không thể tim thấy link cron này của bạn.',
      ], 404);
    }
    if ($payload['month'] < 1) {
      return response()->json([
        'status'  => 404,
        'message' => 'Thời gian gia hạn không hợp lệ.',
      ], 404);
    }
    $time = $payload['month'];

    $id_server = $order->id_server;
    $user = User::find($order->user_id);
    $server = SeverCron::where('id', $id_server)->where('status', 1)->firstOrFail();
    if (!$server) {
      return response()->json([
        'status'  => 500,
        'message' => 'Có vẻ như máy chủ này không hoạt động hoặc không tồn tại trên hệ thống.',
      ], 500);
    }
    $tongtien = $server->price - ($server->price * ($server->ck / 100));
    $total = $time * $tongtien;
    if ($user->banned !== 0) {
      return response()->json([
        'status'  => 400,
        'message' => 'Tài khoản của bạn đang bị khóa, vui lòng liên hệ admin để được hỗ trợ.',
      ], 400);
    }
    if ($user->balance < $total) {
      return response()->json([
        'status'  => 403,
        'message' => 'Tài khoản của bạn không đủ để thực hiện thao tác này.',
      ], 403);
    }
    if ($user->decrement('balance', $total) === false) {
      return response()->json([
        'status'  => 500,
        'message' => 'Đã có lỗi trong quá trình thanh toán, vui lòng liên hệ admin.',
      ], 500);
    }
    $timestamp = $order->expired_timestamp;
    $time_set = $time * 2592000;
    $expired_timestamp = $timestamp + $time_set;
    $expired_date =  date("Y-m-d H:i:s", $expired_timestamp);
     
    if ($payload['action'] == 'giahan') {

      $order->status = 'hoatdong';
      $order->expired_date = $expired_date;
      $order->expired_timestamp = $expired_timestamp;
      $order->save();

      Transaction::create([
        'code'           => $order->trans_id,
        'amount'         => $total,
        'balance_before' => $user->balance + $total,
        'balance_after'  => $user->balance,
        'type'           => 'new-order',
        'status'         => 'paid',
        'content'        => '[' . $server->name . '] ; mã số ' . $order->id . '; Thanh toán thành công cho người dùng ' . $user->username,
        'extras'         => [
          'id'         => $order->id,
          'order_code' => $order->trans_id,
        ],
        'user_id'        => $user->id,
        'username'       => $user->username,
        'order_id'       => $order->id,
      ]);
  
      Logs::create([
        'data'       => '0',
        'action'    => 'Thành toán gia hạn cron ' . $server->name . ' Giá tiền ' . number_format($total) . 'đ',
        'description' => 'Thực hiện hành động thanh toán gia hạn tên cron với địa chỉ ip' . request()->ip(),
        'old_data' => 0,
        'new_data' => 0,
        'user_id'    => $user->id,
        'ip' => request()->ip(),
        'data_json' => '',
      ]);

      return response()->json([
        'status'  => 200,
        'message' => 'Gia hạn link cron thành công.',
      ], 200);
    } else {
      return response()->json([
        'status'  => 500,
        'message' => 'Vui lòng chạy đúng chức năng.',
      ]);
    }
  }
}
