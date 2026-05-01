<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TransferOrder;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Product;
use App\Models\Logs;
use App\Models\Licenses;
use App\Models\Hisproduct;
use App\Helpers\Helper;
use App\Mail\PaymentSuccessMail;
use Illuminate\Support\Facades\Mail;
use App\Models\Domain;
use App\Models\DomainOrder;
use Illuminate\Http\Request;

class TransferController extends Controller
{
  public function index(Request $request)
  {
    $transfer = TransferOrder::get();

    return view('admin.transfer.index', compact('transfer'));
  }
  public function update(Request $request) {
    $payload = $request->validate([
      'id' => 'required|integer',
      'status' => 'required',
    ]);
    $tranfer = TransferOrder::find($payload['id']);
    $tranfer->status = $payload['status'];
    $khanhdz = $tranfer->save();
    $user = User::find($tranfer->user_id);
    if ($khanhdz) {
        if ($tranfer->content['type'] === 'code') {

            $product = Product::find($tranfer->content['product_id']);
            $license_key = md5($user->username . $product->id . time());
            Licenses::create([
                'user_id' => $user->id,
                'license_key' => $license_key,
                'domain' => [],
                'status' => 'active',
                'cmt' => 'noti',
                'expiry_date' => date('Y-m-d', time() + 31536000),
            ]);
            $trans_id = Helper::random('QWERTYUIOPASDFGHJKZXCVBNM', 2) . time();
            Hisproduct::create([
                'user_id' => $user->id,
                'product_id' => $product->id,
                'trans_id' => $trans_id,
                'price' => $tranfer->price,
            ]);
            $product->increment('sold');
            Transaction::create([
                'code'           => $trans_id,
                'amount'         => $tranfer->price,
                'balance_before' => $user->balance + $tranfer->price,
                'balance_after'  => $user->balance,
                'type'           => 'new-order',
                'status'         => 'paid',
                'content'        => '[' . $product->name . '] ; mã số ' . $product->id . '; Thanh toán chuyển khoản thành công cho người dùng ' . $user->username,
                'extras'         => [
                    'id'         => $product->id,
                    'order_code' => $trans_id,
                ],
                'user_id'        => $user->id,
                'lickey' => $license_key,
                'username'       => $user->username,
                'order_id'       => $product->id,
            ]);
            $content = 'Thành toán chuyển khoản mã nguồn ' . $product->name . ' Mã số ' . $product->id;
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

            $user_ctv = User::where('id', $product->user_id)->first();
            if ($user_ctv) {
                if ($user_ctv->level == 2) {
                    $user_ctv->increment('balance_ctv', $tranfer->price);
                    $trans_id_code = Helper::random('QWERTYUIOPASDFGHJKZXCVBNM', 2) . time();
                    Transaction::create([
                        'code'           => $trans_id_code,
                        'amount'         => $tranfer->price,
                        'balance_before' => $user_ctv->balance + $tranfer->price,
                        'balance_after'  => $user_ctv->balance,
                        'type'           => 'new-order',
                        'status'         => 'paid',
                        'sys_note' => 'ctv',
                        'content'        => '[' . $product->name . '] ; mã số ' . $product->id . '; Cộng tiền cho người bán hàng ' . $user_ctv->username,
                        'extras'         => [
                            'id'         => $product->id,
                            'order_code' => $trans_id_code,
                        ],
                        'user_id'        => $user_ctv->id,
                        'lickey' => $license_key,
                        'username'       => $user_ctv->username,
                        'order_id'       => $product->id,
                    ]);
                    $content = 'Cộng tiền cho người bán hàng ' . $product->name . ' Mã số ' . $product->id;
                    Logs::create([
                        'data'       => '0',
                        'action'    => $content,
                        'description' => "Thực hiện hành động " . $content . " với địa chỉ ip" . request()->ip(),
                        'old_data' => 0,
                        'new_data' => 0,
                        'user_id'    => $user_ctv->id,
                        'ip' => request()->ip(),
                        'data_json' => '',
                    ]);
                }
            }
        } elseif ($tranfer->content['type'] === 'domain') {
            $domain = Domain::find($tranfer->content['domain_id']);
            $trans_id = Helper::random('QWERTYUIOPASDFGHJKZXCVBNM', 2) . time();
            $time_set = $tranfer->content['time'] * 31536000;
            $time_ex = time() + $time_set;
            $expired_date =  date("Y-m-d H:i:s", $time_ex);
            DomainOrder::create([
                'trans_id' => $trans_id,
                'user_id' => $user->id,
                'domain_name' => $tranfer->content['domain'],
                'ns' => $tranfer->content['ns'],
                'price' => $tranfer->price,
                'time_han' => $tranfer->content['time'],
                'expired_date' => $expired_date,
                'expired_timestamp' => $time_ex,
                'status' => '1',
            ]);
            Transaction::create([
                'code'           => $trans_id,
                'amount'         => $tranfer->price,
                'balance_before' => $user->balance + $tranfer->price,
                'balance_after'  => $user->balance,
                'type'           => 'new-order',
                'status'         => 'paid',
                'content'        => 'Tên miền [' . $tranfer->content['domain'] . '] ; Giá tiền ' . number_format($tranfer->price) . 'đ; Thanh toán thành chuyển khoản công cho người dùng ' . $user->username,
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
                'action'    => 'Thành toán chuyển khoản Tên miền ' . $tranfer->content['domain'] . ' Giá tiền ' . number_format($tranfer->price) . 'đ',
                'description' => 'Thực hiện hành động thanh toán chuyển khoản Tên miền với địa chỉ ip' . request()->ip(),
                'old_data' => 0,
                'new_data' => 0,
                'user_id'    => $user->id,
                'ip' => request()->ip(),
                'data_json' => '',
            ]);

            $content = "🎉 Đơn hàng mới được tạo thành công!\n\n";
            $content .= "🔖 Mã đơn hàng: " . $trans_id . "\n";
            $content .= "📦 Dịch vụ: ID " . $domain->id . " - " . $trans_id . "\n";
            $content .= "🔢 Thời Hạn: " . $tranfer->content['time'] . " năm\n";
            $content .= "💰 Tổng thanh toán: " . number_format($tranfer->price, 0, ',', '.') . "đ\n";
            $content .= "🕒 Thời gian: " . date('d/m/Y H:i:s') . "\n";
            $content .= "👤 Người dùng: " . $user->username . "\n\n";
            $content .= "Thông báo gửi đến admin để duyệt đơn hàng\n";
            $content .= "\n\n";

            Helper::sendMessageTelegramAuto($content);
            $giagoc = $domain->price;
            $ck = $tranfer->content['ck'];
            Mail::to($user->email)->send(new PaymentSuccessMail($user, $tranfer->content['domain'], $tranfer->price, $ck, $tranfer->content['ns'],  $giagoc));
        }
        $user->increment('total_deposit', $tranfer->price);
        return redirect()->back()->with('success', 'Cập nhật hóa đơn thành công thành công #' . $tranfer->id);
    }
    
  }
  public function delete(Request $request)
  {

    if ($request->has('ids')) {
      $payload = $request->validate([
        'ids' => 'required|array',
      ]);

      $ids = array_map('intval', $payload['ids']);

      $tranfer = TransferOrder::whereIn('id', $ids)->get();

      foreach ($tranfer as $tranfers) {
        $tranfers->delete();
      }

      Helper::addLogs(__('Thực hiện thao tác xóa nhiều hóa đơn cùng lúc; số lượng: :count', ['count' => $tranfer->count()]));

      return response()->json([
        'status'  => 200,
        'message' => 'Transfer deleted successfully.',
      ]);
    }

    $payload = $request->validate([
      'id' => 'required|integer',
    ]);

    $tranferz = TransferOrder::where('id', $payload['id'])->firstOrFail();
    $tranferz->delete();

    Helper::addLogs('Xóa hóa đơn #' . $tranferz->name);

    return response()->json([
      'status'  => 200,
      'message' => 'Transfer deleted successfully.',
    ]);
    }
}
