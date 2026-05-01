<?php
 namespace App\Http\Controllers\Code;

use App\Helpers\Helper;
use App\Models\Product;
use App\Models\Slug;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Voucher;
use App\Models\VoucherLog;
use App\Models\Logs;
use App\Models\Hisproduct;
use App\Models\Transaction;
use App\Models\Licenses;
use App\Events\GlobalPurchaseEvent;

 class CodeController extends Controller
 {
     public function showViewCode(string $slug)
     {
         // Tra cứu theo slug trước, nếu không có thì thử theo id (backward compat)
         $slugRow = Slug::find($slug, 'code');
         $code    = $slugRow
             ? Product::find($slugRow->slug_id)
             : (is_numeric($slug) ? Product::find((int) $slug) : null);

         if (!$code) {
             return redirect()->route('home')->with('error', 'Chúng tôi không thể tìm thấy sản phẩm code này');
         }
         if ($code->status != 1) {
             return redirect()->route('home')->with('error', 'Sản phẩm này đang bảo trì');
         }

         // Nếu URL vào bằng id cũ → redirect 301 sang slug chuẩn
         if (!$slugRow && is_numeric($slug)) {
             $canonicalSlug = $code->slug;
             if ($canonicalSlug) {
                 return redirect()->route('code.index', $canonicalSlug, 301);
             }
         }

         $code->increment('view');
         $user = User::where('id', $code->user_id)->first();
         return view('code.index', [
             'pageTitle' => 'Mã nguồn ' . $code->name,
             'code'      => $code,
             'user'      => $user,
         ]);

     }
     public function paymentcode(Request $request)
    {
      if (env('PRJ_DEMO_MODE', false) === true) {
        return response()->json([
          'status'  => 500,
          'message' => 'Chức năng này không hoạt động trong chế độ demo.',
      ], 500);
      }
        $payload = $request->validate([
            'code' => '',
            'id' => 'required|exists:tbl_list_code,id',
        ]);
        $product = Product::findOrFail($payload['id']);

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

        $voucher = Voucher::where('code', $code)->where('type', 'code')->first();

        if (!$voucher) {  
           $ck  = $product->ck;
        } else {
            $ck = $voucher->value + $product->ck;
        }

        $value = $product->price - ($product->price * $ck / 100);
        
        if ($user->banned !== 0) {
            return response()->json([
                'status'  => 400,
                'message' => 'Tài khoản của bạn đang bị khóa, vui lòng liên hệ admin để được hỗ trợ.',
            ], 400);
        }
        if ($user->balance < $value) {
            return response()->json([
              'status'  => 403,
              'message' => 'Tài khoản của bạn không đủ để thực hiện mua code',
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
            VoucherLog::create(
              [
                'user_id' => $user->id,
                'code' => $voucher->code,
                'value' => $voucher->value,
              ]
            );
          } 
          $license_key = md5($user->username .$product->id .time());
          Licenses::create([
            'user_id' => $user->id,
            'license_key' => $license_key,
            'domain' => [],
            'status' => 'active',
            'cmt' => 'noti',
            'expiry_date' => date('Y-m-d', time() + 31536000),
          ]);
          $trans_id = Helper::random('QWERTYUIOPASDFGHJKZXCVBNM', 2).time();
          Hisproduct::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'trans_id' => $trans_id,
            'price' => $value,
          ]);
          $product->increment('sold');
           Transaction::create([
            'code'           => $trans_id,
            'amount'         => $value,
            'balance_before' => $user->balance + $value,
            'balance_after'  => $user->balance,
            'type'           => 'new-order',
            'status'         => 'paid',
            'content'        => '[' . $product->name . '] ; mã số ' . $product->id . '; Thanh toán thành công cho người dùng ' . $user->username,
            'extras'         => [
              'id'         => $product->id,
              'order_code' => $trans_id,
            ],
            'user_id'        => $user->id,
            'lickey' => $license_key,
            'username'       => $user->username,
            'order_id'       => $product->id,
          ]);
          $content = 'Thành toán mã nguồn '.$product->name.' Mã số '.$product->id;
          Logs::create([
            'data'       => '0',
            'action'    => $content,
            'description' => "Thực hiện hành động " .$content. " với địa chỉ ip".request()->ip(),
            'old_data' => 0,
            'new_data' => 0,
            'user_id'    => $user->id,
            'ip' => request()->ip(),
            'data_json' => '',
          ]);
          
          $user_ctv = User::where('id', $product->user_id)->first();
          if ($user_ctv) {
            if ($user_ctv->level == 2) {
            $user_ctv->increment('balance_ctv', $value);
            $trans_id_code = Helper::random('QWERTYUIOPASDFGHJKZXCVBNM', 2).time();
            Transaction::create([
              'code'           => $trans_id_code,
              'amount'         => $value,
              'balance_before' => $user_ctv->balance + $value,
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
            $content = 'Cộng tiền cho người bán hàng '.$product->name.' Mã số '.$product->id;
            Logs::create([
              'data'       => '0',
              'action'    => $content,
              'description' => "Thực hiện hành động " .$content. " với địa chỉ ip".request()->ip(),
              'old_data' => 0,
              'new_data' => 0,
              'user_id'    => $user_ctv->id,
              'ip' => request()->ip(),
              'data_json' => '',
            ]);
           }
          }
          
          try {
              broadcast(new GlobalPurchaseEvent([
                  'userName' => $user->name,
                  'productName' => $product->name,
                  'productPrice' => number_format($value) . ' đ',
                  'location' => 'Việt Nam', // Minimal location info
                  'time' => now()->toDateTimeString()
              ]));
          } catch (\Exception $e) {
              \Illuminate\Support\Facades\Log::error('GlobalPurchaseEvent Error: ' . $e->getMessage());
          }

        return response()->json([
            'status'  => 200,
            'message' => 'Mua mã nguồn thành công.',
        ], 200);
    }
 }
 