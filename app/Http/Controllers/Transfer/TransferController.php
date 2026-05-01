<?php

namespace App\Http\Controllers\Transfer;

use App\Helpers\Helper;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Domain;
use App\Models\User;
use App\Models\Voucher;
use App\Models\VoucherLog;
use App\Models\BankAccount;
use App\Models\TransferOrder;


class TransferController extends Controller
{ 
    public function ShowPayment(Request $request)
    {
        $user = User::find(auth()->user()->id);
        $transfer = TransferOrder::where('user_id', $user->id)->get();
        return view('transfer.view', [
            'pageTitle' => 'Thanh toán hóa đơn',
            'user' => $user,
            'transfer' => $transfer
        ]);
    }
    public function index($id)
     {
         $transfer = TransferOrder::find($id);
 
         if (!$transfer) {
             return redirect()->route('transfer.view')->with('error', 'Chúng tôi không thể tìm thấy sản hóa đơn này');
         }
         $user = User::find(auth()->user()->id);
         if ($user->id != $transfer->user_id) {
             return redirect()->route('transfer.view')->with('error', ' bạn không phải là chủ của hóa đơn này');
         }
         if ($transfer->status == 2) {
            return redirect()->route('transfer.view')->with('error', 'Hóa đơn này đã được thanh toán thành công');
         }
         if ($transfer->status == 3) {
            return redirect()->route('transfer.view')->with('error', 'Hóa đơn này đã được hủy');
         }
         $bank = BankAccount::where('name' , $transfer->bank)->where('status', 1)->first();
         if (!$bank) {
            return redirect()->route('transfer.view')->with('error', 'Chúng tôi không hỗ trợ ngân hàng này');
         }
         return view('transfer.index', [
            'pageTitle' => 'Thanh toán hóa đơn #' . $transfer->trans_id,
            'transfer' => $transfer,
            'user' => $user,
            'bank' => $bank
        ]);

     }
    public function transfer(Request $request)
    {
        $type = $request->input('type');
        if (env('PRJ_DEMO_MODE', false) === true) {
            return response()->json([
                'status'  => 500,
                'message' => 'Chức năng này không hoạt động trong chế độ demo.',
            ], 500);
        }
        if (($type) == 'code') {
            $messages = [
                'id.required'  => 'Trường số thứ tự là bắt buộc.',
                'type.required'     => 'Trường thuộc tính là bắt buộc.',
                'bank.required' => 'Trương ngân hành là bắt buộc',
              ];
              $attributes = [
                'code'    => 'Mã giảm giá',
                'id' => 'Số thứ tự',
                'type' => 'Loại',
                'bank' => 'Ngân hàng',
              ];
            $payload = $request->validate([
                'code' => '',
                'id' => 'required|integer',
                'type' => 'required',
                'bank' => 'required',
            ],$messages, $attributes);
            $sanpham = Product::findOrFail($payload['id']);
        } elseif (($type) == 'domain') {
            $messages = [
                'id.required'  => 'Trường số thứ tự là bắt buộc.',
                'type.required'     => 'Trường thuộc tính là bắt buộc.',
                'bank.required' => 'Trương ngân hành là bắt buộc',
                'domainname.required' => 'Trường tên miền là bắt buộc',
                'time.required'  => 'Trường Thời hạn là bắt buộc.',
                'ns.required'     => 'Trường namesever là bắt buộc.',
              ];
              $attributes = [
                'domainname' => 'Tên Miền',
                'time' => 'Thời hạn',
                'ns' => 'Namesever',
                'code'    => 'Mã giảm giá',
                'id' => 'Số thứ tự',
                'type' => 'Loại',
                'bank' => 'Ngân hàng',
              ];
            $payload = $request->validate([
                'domainname' => 'required|string',
                'time' => 'required',
                'ns' => 'required',
                'code' => '',
                'id' => 'required|integer',
                'type' => 'required',
                'bank' => 'required',
            ],$messages, $attributes);
            $sanpham = Domain::findOrFail($payload['id']);
        }

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
        $code = $payload['code'];


        if (($type) == 'code') {
            $voucher = Voucher::where('code', $code)->where('type', 'code')->first();
            if (!$voucher) {
                $ck  = $sanpham->ck;
            } else {
                $ck = $voucher->value + $sanpham->ck;
            }
        } elseif (($type) == 'domain') {
            $voucher = Voucher::where('code', $code)->where('type', 'domain')->first();
            if (!$voucher) {
                $ck = $sanpham->sale;
            } else {
                $ck = $voucher->value + $sanpham->sale;
            }
        }
        $value = $sanpham->price - ($sanpham->price * $ck / 100);
        if ($value == 0) {
            return response()->json([
                'status'  => 400,
                'message' => 'Sản phẩm này miễn phí phương thức chuyển khoản không khả dụ.',
            ], 400);
        }
        if ($user->banned !== 0) {
            return response()->json([
                'status'  => 400,
                'message' => 'Tài khoản của bạn đang bị khóa, vui lòng liên hệ admin để được hỗ trợ.',
            ], 400);
        }
        if ($voucher) {
            $voucher->decrement('qty', '1');
            VoucherLog::create(
                [
                    'user_id' => $user->id,
                    'code' => $voucher->code,
                    'value' => $voucher->value,
                ]
            );
        }
        $info             = Helper::getConfig('deposit_info');
        $trans_id = Helper::random('QWERTYUIOPASDFGHJKZXCVBNM', 2) . time();
        if (($type) == 'code') {
        $content = [
            'type' => $type,
            'product_id' => $sanpham->id,
            'ck' => $ck,
        ];
        } elseif (($type) == 'domain') {
            $content = [
                'type' => $type,
                'domain_id' => $sanpham->id,
                'ck' => $ck,
                'domain' => $payload['domainname'],
                'ns' => $payload['ns'],
                'time' => $payload['time'],
            ];
        }
        $count = TransferOrder::where('user_id', $user->id)->where('status', '1')->count();
        if ($count >= 3) {
            return response()->json([
                'status'  => 400,
                'message' => 'Bạn chỉ được phép có tối đa 3 hóa đơn chờ xử lý',
            ], 400);
         }
        $transfer_order = TransferOrder::create([
            'user_id' => $user->id,
            'trans_id' => $trans_id,
            'noidung' => '',
            'bank' => $payload['bank'],
            'price' => $value,
            'content' => $content,
            'status' => 1,
        ]); 
        $prefix  = $info['transfer'] ?? 'THANHTOAN';
        $noidung = $prefix . $transfer_order->id;
        $transfer_order->update(['noidung' => $noidung]);

        return response()->json([
            'status'  => 200,
            'message' => 'Tạo hóa đơn thành công.',
            'redirect_url' => route('transfer.checkout', ['id' => $transfer_order->id]),
        ], 200);
    }
    public function get_status(Request $request)
    {
        $id = $request->query('id');
        if (!$id) {
            return response()->json(['error' => 'Bạn đang thiếu ID'], 400);
        }
        $transfer = TransferOrder::find($id);
        if (!$transfer) {
            return response()->json(['error' => 'Hóa đơn không tìm thấy'], 404);
        } else {
            $status = $transfer->status;
            if ($status == 2) {
                $message = 'Thanh toán thành công';
            } elseif ($status == 3) {
                $message = 'Thanh toán không thành công';
            } else {
                $message = 'Đang chờ thanh toán';
            }
            return response()->json(['status' => $status, 'message' => $message], 200)->header('Content-Type', 'application/json');

        }
       
    }
    public function updateStatus(Request $request)
  {
    $payload = $request->validate([
      'id'     => 'required|integer',
      'status' => 'required',
    ]);

    $transfer = TransferOrder::where('id', $payload['id'])->firstOrFail();

    $transfer->update([
      'status' => $payload['status'],
    ]);

    return response()->json([
      'status'  => 200,
      'message' => 'Đơn hàng đã được hủy',
    ]);
  }

  public function destroy($id)
  {
      $transfer = TransferOrder::where('id', $id)->where('user_id', auth()->user()->id)->firstOrFail();
      $transfer->delete();

      return redirect()->back()->with('success', 'Xóa hóa đơn thành công');
  }
}

