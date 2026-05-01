<?php

namespace App\Http\Controllers\Domain;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\Helper;
use App\Models\User;
use App\Models\Domain;
use App\Models\DomainOrder;
use App\Models\Transaction;

class HisdomainController extends Controller
{
  public function showHisDomain()
  {
    $user = User::find(auth()->user()->id);
    $id = $user->id;
    $domain = Domain::where('status', 1)->get();
    $hisdomain = DomainOrder::where('user_id', $id)->get();
    return view('domain.history', [
      'pageTitle' => 'Lịch sử mua tên miền của ' . $user->name,
      'hisdomain' => $hisdomain,
      'domain' => $domain,
      'user' => $user,
    ]);
  }
  public function giahanauto(Request $request)
  {
    if (env('PRJ_DEMO_MODE', false) === true) {
      return response()->json([
        'status'  => 500,
        'message' => 'Chức năng này không hoạt động trong chế độ demo.',
      ], 500);
    }

    $messages = [
      'status.required'  => 'Trường Trạng thái là bắt buộc.',
      'id.required'  => 'Trường id là bắt buộc.',
    ];

    $attributes = [
      'status' => 'Trạng thái',
      'id' => 'ID tên miền',
    ];

    $payload = $request->validate([
      'status' => 'required',
      'id' => 'required',
    ], $messages, $attributes);
    $domain = DomainOrder::findOrFail($payload['id']);
    $status = $payload['status'];
    $domain->update([
      'giahan' => $status,
    ]);

    Helper::addLogs('Thay đổi gia hạn auto tên miền thành công');

    return response()->json([
      'status'  => 200,
      'message' => ('Cập nhật gia hạn thành công'),
    ]);
  }
  public function updateNS(Request $request)
  {
    $validated = $request->validate([
      'id' => 'required|integer',
      'ns' => 'required|string'
    ]);

    $domain = DomainOrder::find($validated['id']);
    if ($domain->status == 3) {
      return response()->json([
        'status'  => 500,
        'message' => 'Tên miền này không còn hoạt động không thể thay đổi ns',
      ], 500);
    }
    if ($domain) {
      $domain->ns = $validated['ns'];
      $domain->save();

      Helper::addLogs('Cập nhật nameserver tên miền thành công');
      $user = User::find(auth()->user()->id);

      $res = response()->json([
        'status'  => 200,
        'message' => 'Cập nhật ns thành công',
      ], 200);
      $ns = $validated['ns'];
      $lines = explode(",", $ns);

      $content = "🎮 *CẬP NHẬT NS*\n";
      $content .= "├─ Người dùng: " . $user->username . "\n";
      $content .= "├─ Dịch vụ: ID " . $domain->id . " - " . $domain->trans_id . "\n";
      $content .= "├─ Tên Miền: " . $domain->domain_name . "\n";
      $content .= "├─ NS: [ " . implode(",", $lines) . " ]\n";
      $content .= "└─ Thời gian: " . date('d/m/Y H:i:s') . "\n";

      Helper::sendMessageTelegramAuto($content);

      return $res;
    }
    return response()->json([
        'status'  => 404,
        'message' => 'Không tìm thấy domain!',
      ], 404);
  }
  public function updateUser(Request $request)
  {
    $validated = $request->validate([
      'id' => 'required|integer',
      'user' => 'required|string'
    ]);
    $username = $validated['user'];
    $user_doamin = User::where('username', $username)->first();
    if (!$user_doamin) {
      return response()->json([
        'status'  => 404,
        'message' => 'Không tìm thấy user này!',
      ], 404);
    }
    $domain_check = DomainOrder::find($username);
    if ($domain_check) {
      return response()->json([
        'status'  => 401,
        'message' => 'Vui lòng không nhập lại username chính mình!',
      ], 401);
    }
    $user_id = $user_doamin->id;
    $user = User::find(auth()->user()->id);
    if ($user->banned !== 0) {
      return response()->json([
        'status'  => 400,
        'message' => 'Tài khoản của bạn đang bị khóa, vui lòng liên hệ admin để được hỗ trợ.',
      ], 400);
    }
    if ($user->balance < 1000) {
      return response()->json([
        'status'  => 403,
        'message' => 'Tài khoản của bạn không đủ để thực hiện đổi chủ tên miền',
      ], 403);
    }
    if ($user->decrement('balance', 1000) === false) {
      return response()->json([
        'status'  => 500,
        'message' => 'Đã có lỗi trong quá trình thanh toán, vui lòng liên hệ admin.',
      ], 500);
    }
    $id_domian = $validated['id'];
    $trans_id = Helper::random('QWERTYUIOPASDFGHJKZXCVBNM', 2) . time();
    Transaction::create([
      'code'           => $trans_id,
      'amount'         => 1000,
      'balance_before' => $user->balance + 1000,
      'balance_after'  => $user->balance,
      'type'           => 'new-order',
      'status'         => 'paid',
      'content'        => 'chuyển nhượng tên miền  thành công cho ' . $user_doamin->name . '; Thanh toán thành công cho người dùng ' . $user->username,
      'extras'         => [
        'id'         => $id_domian,
        'order_code' => $trans_id,
      ],
      'user_id'        => $user->id,
      'username'       => $user->username,
      'order_id'       => $id_domian,
    ]);
    $domain = DomainOrder::find($validated['id']);
    if ($domain) {
      $domain->user_id = $user_id;
      $domain->save();
      Helper::addLogs('Chuyển chủ tên miền thành công');
      return response()->json([
        'status'  => 200,
        'message' => 'Cập nhật thành công!',
      ]);
    }
    return response()->json([
      'status'  => 404,
      'message' => 'Không tìm thấy domain!',
    ], 404);
  }
  public function domaingiahan(Request $request)
  {
    if (env('PRJ_DEMO_MODE', false) === true) {
      return response()->json([
        'status'  => 500,
        'message' => 'Chức năng này không hoạt động trong chế độ demo.',
      ], 500);
    }

    $messages = [
      'giahan.required'  => 'Trường thời gian là bắt buộc.',
      'id.required'  => 'Trường id là bắt buộc.',
    ];

    $attributes = [
      'giahan' => 'Thời Gian',
      'id' => 'ID tên miền',
    ];

    $payload = $request->validate([
      'giahan' => 'required',
      'id' => 'required',
    ], $messages, $attributes);
    $domain = DomainOrder::findOrFail($payload['id']);

    $giahan = $payload['giahan'];
    $parts = explode('.', $domain->domain_name);
    $name = end($parts);

    $domain_check = Domain::where('name', $name)->first();
    if (!$domain_check) {
      return response()->json([
        'status'  => 404,
        'message' => 'Đuôi miền này hình như đang không được hỗ trợ gia hạn.',
      ], 404);
    }
    $value = $giahan * ($domain_check->extend_price - ($domain_check->extend_price * $domain_check->ck / 100));
    
    $time_his = $giahan * 31536000;
    $time = $domain->expired_timestamp + $time_his;
    $expired_date = date('Y-m-d H:i:s', $time);
    $domain->update([
      'expired_timestamp' => $time,
      'expired_date' => $expired_date,
    ]);
    $user = User::find(auth()->user()->id);
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
    $trans_id = Helper::random('QWERTYUIOPASDFGHJKZXCVBNM', 2) . time();
    Transaction::create([
      'code'           => $trans_id,
      'amount'         => $value,
      'balance_before' => $user->balance + $value,
      'balance_after'  => $user->balance,
      'type'           => 'new-order',
      'status'         => 'paid',
      'content'        => 'Tên Miền [' . $domain->domain_name . '] ; Giá tiền ' . number_format($value) . 'đ; Thanh toán thành công cho người dùng ' . $user->username,
      'extras'         => [
        'id'         => $domain->id,
        'order_code' => $trans_id,
      ],
      'user_id'        => $user->id,
      'username'       => $user->username,
      'order_id'       => $domain->id,
    ]);
    Helper::addLogs('Gia hạn tên miền thành công');
    $content = "┏━━━━━━━━━━━━━━━┓\n";
    $content .= "┣➤ ".$user->name."\n";
    $content .= "┣➤ Tên miền: ".$domain->domain_name."\n";
    $content .= "┣➤ GIÁ: ".number_format($value)."đ\n";
    $content .= "┣➤ HÀNH ĐỘNG: Gia Hạn\n";
    $content .= "┣➤ Số Time Gia Hạn: ".$payload['giahan']." Năm\n";
    $content .= "┗━━━━━━━━━━━━━━━┛\n";
    Helper::sendMessageTelegramAuto($content);

    return response()->json([
      'status'  => 200,
      'message' => ('gia hạn tên miền thành công'),
    ]);
  }
}
