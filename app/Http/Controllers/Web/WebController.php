<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Logs;
use App\Models\Web;
use App\Models\Slug;
use App\Helpers\Helper;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Createweb;
use App\Models\Domain;
use App\Models\DomainOrder;
use App\Http\Controllers\Api\WhoisController;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use App\Events\GlobalPurchaseEvent;

class WebController extends Controller
{
    public function showWeb()
    {
        $web = Web::where('status', 1)->get();
        return view('web.index', [
            'pageTitle' => 'Hệ thống tạo website giá rẻ',
            'web' => $web,
        ]);
    }
    public function ShowViewWeb(string $slug)
    {
        $slugRow = Slug::find($slug, 'web');
        $id      = $slugRow ? $slugRow->slug_id : (is_numeric($slug) ? (int) $slug : null);

        $web = $id ? Web::where('status', 1)->where('id', $id)->first() : null;

        if (!$web) {
            return redirect()->route('web.index')->with('error', 'Mẫu website không tồn tại hoặc đã bị ẩn.');
        }

        // Redirect 301 về slug chuẩn nếu vào bằng id cũ
        if (!$slugRow && is_numeric($slug)) {
            $canonical = $web->slug;
            if ($canonical) {
                return redirect()->route('web.view', $canonical, 301);
            }
        }

        $domains = Domain::where('status', 1)->get();
        return view('web.view', [
            'pageTitle' => 'Hệ thống tạo web giá rẻ | ' . $web->name,
            'web'       => $web,
            'domains'   => $domains,
        ]);
    }
    public function PaymentWeb(Request $request)
    {
      if (env('PRJ_DEMO_MODE', false) === true) {
        return response()->json([
          'status'  => 500,
          'message' => 'Chức năng này không hoạt động trong chế độ demo.',
      ], 500);
      }
        $payload = $request->validate([
            'domainName' => 'required|string',
            'id' => 'required|exists:web,id',
            'tk' => 'required|string|max:255',
            'mk' => 'required|string|max:255',
            'option_domain' => 'required|string|max:255',
            'domainPrice' => 'nullable|string',
            'timePrice' => 'required|max:255',
            
        ]);
        $web = Web::findOrFail($payload['id']);

        $user = User::find(auth()->user()->id);
        if (!$user) {
            return response()->json([
                'status'  => 401,
                'message' => 'Bạn cần phải đăng nhập để sử dụng tính năng này.',
            ], 401);
        }
        if ($user->loai == 'demo') {
          return response()->json([
              'status'  => 401,
              'message' => 'Bạn đang sử dụng tài khoản demo',
          ], 401);
        }      
        $ck  = $web->ck;
        $price = ($payload['timePrice'] * $web->price) - (($payload['timePrice'] * $web->price) * $ck / 100);  
        if ($payload['option_domain'] == 'own') {
            $pointer = 0;
            $price_total = $price;
        } elseif ($payload['option_domain'] == 'buy') {
            if (empty($payload['domainPrice'])) {
              return response()->json([
              'status'  => 401,
              'message' => 'Vui lòng chọn tên miền cần mua',
              ], 401);
            }
            $controller = new WhoisController();
            $response = $controller->whoisdomain($payload['domainName']);
    
            $data = json_decode($response->getContent(), true);
    
           if (isset($data['code']) && $data['code'] !== '1') {
            return response()->json([
                'status'  => 401,
                'message' => 'Tên này đã được đăng ký hoặc không thể đăng ký trong lúc này',
            ], 401);
            }
            $pointer = 1;
            $domain = Domain::where('status', 1)->where('name', $payload['domainPrice'])->first();
            $price_total = $price + $domain->price;
        } else {
            return response()->json([
                'status'  => 401,
                'message' => 'Chúng tôi không tìm thấy bạn đang lựa chọn gì.',
            ], 401); 
        }
        $value = $price_total;
        
        if ($user->banned !== 0) {
            return response()->json([
                'status'  => 400,
                'message' => 'Tài khoản của bạn đang bị khóa, vui lòng liên hệ admin để được hỗ trợ.',
            ], 400);
        }
        if ($user->balance < $value) {
            return response()->json([
              'status'  => 403,
              'message' => 'Tài khoản của bạn không đủ để thực hiện tạo website',
            ], 403);
          }
          if ($user->decrement('balance', $value) === false) {
            return response()->json([
              'status'  => 500,
              'message' => 'Đã có lỗi trong quá trình thanh toán, vui lòng liên hệ admin.',
            ], 500);
          }
          $time_set = $payload['timePrice'] * 2592000;
          $time_exp = time() + $time_set;
          $trans_id = Helper::random('QWERTYUIOPASDFGHJKZXCVBNM', 2).time();
           Createweb::create([
             'user_id' => $user->id,
             'web_id' => $web->id,
             'trans_id' => $trans_id,
             'price' => $price_total,
             'tk' => $payload['tk'],
             'mk' => $payload['mk'],
             'domain' => $payload['domainName'],
             'pointer' => $pointer,
             'time_exp' => $time_exp,
             'status' => 0,
           ]);
           if ($payload['option_domain'] == 'buy') {
            $trans_id_domain = Helper::random('QWERTYUIOPASDFGHJKZXCVBNM', 2).time();
            $ns = setting('ns1') . "," . setting('ns2');
            $time_ex = time() + 31536000;
            $expired_date =  date("Y-m-d H:i:s", $time_ex);
            DomainOrder::create([
            'trans_id' => $trans_id_domain,
            'user_id' => $user->id,
            'domain_name' => $payload['domainName'],
            'ns' => $ns,
            'price' => $domain->price,
            'time_han' => '1',
            'expired_date' => $expired_date,
            'expired_timestamp' => $time_ex,
            'status' => '1',
            ]);
           }
           Transaction::create([
            'code'           => $trans_id,
            'amount'         => $value,
            'balance_before' => $user->balance + $value,
            'balance_after'  => $user->balance,
            'type'           => 'new-order',
            'status'         => 'paid',
            'content'        => '[' . $web->name . '] ; mã số ' . $web->id . '; Thanh toán thành công cho người dùng ' . $user->username,
            'extras'         => [
              'id'         => $web->id,
              'order_code' => $trans_id,
            ],
            'user_id'        => $user->id,
            'username'       => $user->username,
            'order_id'       => $web->id,
          ]);
          $content = "┏━━━━━━━━━━━━━━━┓\n";
         $content .= "┣➤ Người dùng: ".$user->name."\n";
         $content .= "┣➤ Loại Web: ".$web->name."\n";
         $content .= "┣➤ GIÁ: ".number_format($web->price)."đ\n";
         $content .= "┣➤ Tên miền: " . $payload['domainName']."\n";
         $content .= "┣➤ Thời gian thuê: " . $payload['timePrice'] . " tháng\n";
         $content .= "┗━━━━━━━━━━━━━━━┛\n";
         Helper::sendMessageTelegramAuto($content);
         $content = 'Tạo web '.$web->name.' - Mã số '.$web->id;
         Logs::create([
         'data'       => '0',
         'action'    => $content,
          'description' => "Thực hiện hành động " .$content. " với địa chỉ ip ".request()->ip(),
         'old_data' => 0,
         'new_data' => 0,
         'user_id'    => $user->id,
         'ip' => request()->ip(),
         'data_json' => '',
         ]);

         try {
            broadcast(new GlobalPurchaseEvent([
                'userName' => $user->name,
                'productName' => 'Website: ' . $web->name,
                'productPrice' => number_format($value) . ' đ',
                'location' => 'Việt Nam',
                'time' => now()->toDateTimeString()
            ]));
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('GlobalPurchaseEvent Error: ' . $e->getMessage());
        }

        return response()->json([
            'status'  => 200,
            'message' => 'Tạo web thành công, website của bạn sẽ sớm được kích hoạt',
        ], 200);
    }
    public function showHisWeb()
    {
        $user = User::find(auth()->user()->id);
        $id = $user->id;

        $hisweb = Createweb::where('user_id', $id)->orderBy('id', 'desc')->get();
         return view('web.history', [
            'pageTitle' => 'Lịch sử tạo website của ' . $user->name,
            'hisweb' => $hisweb,
            'user' => $user,
        ]);

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
      'id' => 'required|exists:createwebs,id',
    ]);
    $order = Createweb::find($payload['id']);
    if (!$order) {
      return response()->json([
        'status'  => 404,
        'message' => 'Chúng tôi không thể tìm thấy link cron bạn.',
      ], 404);
    }
    $id_server = $order->web_id;
    $server = Web::where('id', $id_server)->where('status', 1)->firstOrFail();
    $ck = $server->ck;
    $tongtien = $server->extend;
    return '<div class="modal-body">
    <div class="mb-4">
        <label for="name" class="block text-gray-700">Mã đơn hàng:</label>
        <input type="text" value="' . ($order['trans_id']) . '" disabled class="form-control text-danger">
        <input type="hidden" value="'.($tongtien) .'" id="price" />
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
            url: "'. route('web.giahan') .'",
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
                    window.location.href = "'. route('web.history') .'";
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
      'id' => 'required|exists:createwebs,id',
      'month' => 'required',
    ]);
    $order = Createweb::find($payload['id']);
    if (!$order) {
      return response()->json([
        'status'  => 404,
        'message' => 'Chúng tôi không thể tim thấy đơn tạo website này của bạn.',
      ], 404);
    }
    if ($payload['month'] < 1) {
      return response()->json([
        'status'  => 404,
        'message' => 'Thời gian gia hạn không hợp lệ.',
      ], 404);
    }
    $time = $payload['month'];

    $id_server = $order->web_id;
    $user = User::find($order->user_id);
    $server = Web::where('id', $id_server)->where('status', 1)->firstOrFail();
    if (!$server) {
      return response()->json([
        'status'  => 500,
        'message' => 'Có vẻ như mẫu website này không hoạt động hoặc không tồn tại trên hệ thống.',
      ], 500);
    }
    $tongtien = $server->extend;
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
    $timestamp = $order->time_exp;
    $time_set = $time * 2592000;
    $expired_timestamp = $timestamp + $time_set;
     
    if ($payload['action'] == 'giahan') {

      $order->status = '2';
      $order->time_exp = $expired_timestamp;
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
        'action'    => 'Thành toán gia hạn website ' . $server->name . ' Giá tiền ' . number_format($total) . 'đ',
        'description' => 'Thực hiện hành động thanh toán gia hạn website với địa chỉ ip' . request()->ip(),
        'old_data' => 0,
        'new_data' => 0,
        'user_id'    => $user->id,
        'ip' => request()->ip(),
        'data_json' => '',
      ]);

      return response()->json([
        'status'  => 200,
        'message' => 'Gia hạn website thành công.',
      ], 200);
    } else {
      return response()->json([
        'status'  => 500,
        'message' => 'Vui lòng chạy đúng chức năng.',
      ]);
    }
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
      'action' => 'required|in:pointer',
      'id' => 'required|exists:createwebs,id',
    ]);
    $order = Createweb::find($payload['id']);
    if (!$order) {
      return response()->json([
        'status'  => 404,
        'message' => 'Chúng tôi không thể tim thấy đơn tạo website này của bạn.',
      ], 404);
    }
    if ($payload['action'] == 'pointer') {
      $order->pointer = '1';
      $order->save();
      $user = $order->user;
      $web  = $order->web;

        $content  = "📢 KHÁCH HÀNG ĐÃ XÁC NHẬN TRỎ NS\n";
        $content .= "━━━━━━━━━━━━━━━━━━\n";
        $content .= "👤 Khách hàng: " . ($user->name ?? 'Không rõ') . "\n";
        $content .= "🌐 Loại website: " . ($web->name ?? 'Không rõ') . "\n";
        $content .= "💰 Giá: " . number_format($web->price ?? 0) . "đ\n";
        $content .= "🔗 Tên miền: " . $order->domain . "\n";
        $content .= "⏳ Thời gian hết hạn: " . date('Y-m-d H:i:s', $order->time_exp) . "\n";
        $content .= "✅ Trạng thái: Đã trỏ NS thành công\n";
        $content .= "━━━━━━━━━━━━━━━━━━\n";
        
        Helper::sendMessageTelegramAuto($content);
      return response()->json([
        'status'  => 200,
        'message' => 'Xác nhận đã trỏ NS tới máy chủ.',
      ]);
    }
  }
    public function checkExpiredOrders()
    {
    $orders = Createweb::whereNotIn('status', [4, 5])->get();

    foreach ($orders as $order) {
        if ($order->time_exp < time()) {
            $order->status = 4;
            $order->save();
            $content  = "⚠️ *THÔNG BÁO HẾT HẠN WEB*\n";
            $content .= "━━━━━━━━━━━━━━━━━\n";
            $content .= "👤 Người dùng: " . ($order->user->name ?? 'Không xác định') . "\n";
            $content .= "🌐 Tên web: " . ($order->web->name ?? 'Không xác định') . "\n";
            $content .= "🏷 Domain: " . $order->domain . "\n";
            $content .= "⏳ Hết hạn lúc: " . date('Y-m-d H:i:s', $order->time_exp) . "\n";
            $content .= "━━━━━━━━━━━━━━━━━\n";
            
            Helper::sendMessageTelegramAuto($content);
        }
    }
    return "Đã kiểm tra xong hết hạn.";
    }
}