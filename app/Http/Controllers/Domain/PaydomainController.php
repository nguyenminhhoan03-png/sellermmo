<?php

namespace App\Http\Controllers\Domain;

use App\Mail\PaymentSuccessMail;
use Illuminate\Support\Facades\Mail;
use App\Models\Domain;
use App\Helpers\Helper;
use Illuminate\Http\Request;
use App\Models\Voucher;
use App\Models\VoucherLog;
use App\Models\Transaction;
use App\Models\Logs;
use App\Models\DomainOrder;
use App\Http\Controllers\Api\WhoisController;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Events\GlobalPurchaseEvent;


class PaydomainController extends Controller
{
  public function showPayDomain($domain)
  {
    $parts = explode('.', $domain);
    $extension = end($parts);
    $user = User::find(auth()->user()->id);
     
    $controller = new WhoisController();
    $response = $controller->whoisdomain($domain);
    
    $data = json_decode($response->getContent(), true);
    
   if (isset($data['code']) && $data['code'] !== '1') {
    return redirect()->route('domain.index')->with('error', 'Tên này đã được đăng ký hoặc không thể đăng ký trong lúc này');
   }
    $domains = Domain::where('name', $extension)->where('status', 1)->first();
    if (!$domains) {
      return redirect()->route('domain.index')->with('error', 'Chúng tôi không cung cấp đuôi miền này.');
    }
    $domain_check = DomainOrder::where('domain_name', $domain)->first();
    if ($domain_check) {
      return redirect()->route('domain.index')->with('error', 'Tên miền này đã được đăng ký trong hệ thống');
    }
    return view('domain.pay', [
      'pageTitle' => 'Đăng ký tên miền hỗ trợ khách hàng tốt nhất',
      'domain' => $domain,
      'domains' => $domains,
      'user' => $user,
    ]);
  }
  public function PayDomain(Request $request)
  {
    if (env('PRJ_DEMO_MODE', false) === true) {
      return response()->json([
        'status'  => 500,
        'message' => 'Chức năng này không hoạt động trong chế độ demo.',
      ], 500);
    }

    $messages = [
      'domainame.required' => 'Trường tên miền là bắt buộc',
      'time.required'  => 'Trường Thời hạn là bắt buộc.',
      'id.required'  => 'Trường id là bắt buộc.',
      'ns.required'     => 'Trường namesever là bắt buộc.',
    ];

    $attributes = [
      'domainame' => 'Tên Miền',
      'time' => 'Thời hạn',
      'code'    => 'Mã giảm giá',
      'id' => 'ID tên miền',
      'ns' => 'Namesever',
    ];

    $payload = $request->validate([
      'domainame' => 'required|string',
      'code' => '',
      'time' => 'required',
      'id' => 'required',
      'ns' => 'required',
    ], $messages, $attributes);

    $domain = Domain::findOrFail($payload['id']);
    $user = User::find(auth()->user()->id);

    if (!$user) {
      return response()->json([
        'status'  => 401,
        'message' => 'Bạn cần phải đăng nhập để sử dụng tính năng này.',
      ], 401);
    }
    $code = $payload['code'];
    $time = $payload['time'];
    $domainame = $payload['domainame'];
    $ns = $payload['ns'];

    $voucher = Voucher::where('code', $code)->where('type', 'domain')->first();
    if (!$voucher) {
      $ck = $domain->sale;
    } else {
      $ck = $voucher->value + $domain->sale;
    }
    $value = $time * ($domain->price - ($domain->price * $ck / 100));

    $giagoc = $domain->price;

    if ($user->loai == 'demo') {
      return response()->json([
        'status'  => 401,
        'message' => 'Bạn đang sử dụng tài khoản demo, vui lòng không sử dụng',
      ], 401);
    }

    if ($user->banned !== 0) {
      return response()->json([
        'status'  => 400,
        'message' => 'Tài khoản của bạn đang bị khóa, vui lòng liên hệ admin để được hỗ trợ.',
      ], 400);
    }
    $check_hisdomain = DomainOrder::where('domain_name', $domainame)->first();
    if ($check_hisdomain) {
      return response()->json([
        'status'  => 403,
        'message' => 'Tên miền này đã tồn tại trên hệ thống của chúng tôi.',
      ], 403);
    }
    if ($user->balance < $value) {
      return response()->json([
        'status'  => 403,
        'message' => 'Tài khoản của bạn không đủ để thực hiện mua tên miền',
      ], 403);
    }

    if ($user->decrement('balance', $value) === false) {
      return response()->json([
        'status'  => 500,
        'message' => 'Đã có lỗi trong quá trình thanh toán, vui lòng liên hệ admin.',
      ], 500);
    }

    if ($voucher) {
      $voucher->decrement('qty', '1');
      VoucherLog::create([
        'user_id' => $user->id,
        'code' => $voucher->code,
        'value' => $voucher->value,
      ]);
    }

    $trans_id = Helper::random('QWERTYUIOPASDFGHJKZXCVBNM', 2) . time();
    $time_set = $time * 31536000;
    $time_ex = time() + $time_set;
    $expired_date =  date("Y-m-d H:i:s", $time_ex);
    DomainOrder::create([
      'trans_id' => $trans_id,
      'user_id' => $user->id,
      'domain_name' => $domainame,
      'ns' => $ns,
      'price' => $value,
      'time_han' => $time,
      'expired_date' => $expired_date,
      'expired_timestamp' => $time_ex,
      'status' => '1',
    ]);
    Transaction::create([
      'code'           => $trans_id,
      'amount'         => $value,
      'balance_before' => $user->balance + $value,
      'balance_after'  => $user->balance,
      'type'           => 'new-order',
      'status'         => 'paid',
      'content'        => 'Tên Miền [' . $domainame . '] ; Giá tiền ' . number_format($value) . 'đ; Thanh toán thành công cho người dùng ' . $user->username,
      'extras'         => [
        'id'         => $domain->id,
        'order_code' => $trans_id,
      ],
      'user_id'        => $user->id,
      'username'       => $user->username,
      'order_id'       => $domain->id,
    ]);

    Logs::create([
      'data'       => '0',
      'action'    => 'Thành toán Tên Miền ' . $domainame . ' Giá tiền ' . number_format($value) . 'đ',
      'description' => 'Thực hiện hành động thanh toán tên miền với địa chỉ ip' . request()->ip(),
      'old_data' => 0,
      'new_data' => 0,
      'user_id'    => $user->id,
      'ip' => request()->ip(),
      'data_json' => '',
    ]);

    try {
      broadcast(new GlobalPurchaseEvent([
        'userName'     => $user->name,
        'productName'  => 'Tên miền: ' . $domainame,
        'productPrice' => number_format($value) . ' đ',
        'location'     => 'Việt Nam',
        'time'         => now()->toDateTimeString(),
      ]));
    } catch (\Exception $e) {}

    $response = response()->json([
      'status' => 200,
      'message' => 'Mua tiên miền thành công bạn vui lòng chờ để được duyệt miền nhé.',
    ], 200);

    
    $content = "🎉 Đơn hàng mới được tạo thành công!\n\n";
    $content .= "🔖 Mã đơn hàng: " . $trans_id . "\n";
    $content .= "📦 Dịch vụ: ID " . $domain->id . " - " . $trans_id . "\n";
    $content .= "🔢 Thời Hạn: " . $time . " năm\n";
    $content .= "💰 Tổng thanh toán: " . number_format($value, 0, ',', '.') . "đ\n";
    $content .= "🕒 Thời gian: " . date('d/m/Y H:i:s') . "\n";
    $content .= "👤 Người dùng: " . $user->username . "\n\n";
    $content .= "Thông báo gửi đến admin để duyệt đơn hàng\n";
    $content .= "\n\n";

    Helper::sendMessageTelegramAuto($content);

    Mail::to($user->email)->send(new PaymentSuccessMail($user, $domainame, $value, $ck, $ns,  $giagoc));

    return $response;
  }
}
