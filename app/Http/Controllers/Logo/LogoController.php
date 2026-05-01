<?php

namespace App\Http\Controllers\Logo;

use App\Http\Controllers\Controller;
use App\Models\Logs;
use App\Models\Logo;
use App\Models\Slug;
use App\Helpers\Helper;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Hislogo;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use App\Events\GlobalPurchaseEvent;

class LogoController extends Controller
{
    public function showLogo()
    {
        $logo = Logo::where('status', 1)->get();
        return view('logo.index', [
            'pageTitle' => 'Hệ thống tạo logo giá rẻ',
            'logo' => $logo,
        ]);
    }
    public function ShowViewLogo(string $slug)
    {
        $slugRow = Slug::find($slug, 'logo');
        $id      = $slugRow ? $slugRow->slug_id : (is_numeric($slug) ? (int) $slug : null);

        $logo = $id ? Logo::where('status', 1)->where('id', $id)->first() : null;

        if (!$logo) {
            return redirect()->route('logo.index')->with('error', 'Logo không tồn tại hoặc đã bị ẩn.');
        }

        // Redirect 301 về slug chuẩn nếu vào bằng id cũ
        if (!$slugRow && is_numeric($slug)) {
            $canonical = $logo->slug;
            if ($canonical) {
                return redirect()->route('logo.view', $canonical, 301);
            }
        }

        return view('logo.view', [
            'pageTitle' => 'Hệ thống tạo logo giá rẻ | ' . $logo->name,
            'logo'      => $logo,
        ]);
    }
    public function PaymentLogo(Request $request)
    {
      if (env('PRJ_DEMO_MODE', false) === true) {
        return response()->json([
          'status'  => 500,
          'message' => 'Chức năng này không hoạt động trong chế độ demo.',
      ], 500);
      }
        $payload = $request->validate([
            'name' => 'required',
            'id' => 'required|exists:logos,id',
        ]);
        $logo = Logo::findOrFail($payload['id']);

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
        $ck  = $logo->ck;

        $value = $logo->price - ($logo->price * $ck / 100);
        
        if ($user->banned !== 0) {
            return response()->json([
                'status'  => 400,
                'message' => 'Tài khoản của bạn đang bị khóa, vui lòng liên hệ admin để được hỗ trợ.',
            ], 400);
        }
        if ($user->balance < $value) {
            return response()->json([
              'status'  => 403,
              'message' => 'Tài khoản của bạn không đủ để thực hiện tạo logo',
            ], 403);
          }
          if ($user->decrement('balance', $value) === false) {
            return response()->json([
              'status'  => 500,
              'message' => 'Đã có lỗi trong quá trình thanh toán, vui lòng liên hệ admin.',
            ], 500);
          }
          $trans_id = Helper::random('QWERTYUIOPASDFGHJKZXCVBNM', 2).time();
           Hislogo::create([
             'user_id' => $user->id,
             'logo_id' => $logo->id,
             'trans_id' => $trans_id,
             'price' => $value,
             'name' => $payload['name'],
             'status' => 0,
           ]);
           Transaction::create([
            'code'           => $trans_id,
            'amount'         => $value,
            'balance_before' => $user->balance + $value,
            'balance_after'  => $user->balance,
            'type'           => 'new-order',
            'status'         => 'paid',
            'content'        => '[' . $logo->name . '] ; mã số ' . $logo->id . '; Thanh toán thành công cho người dùng ' . $user->username,
            'extras'         => [
              'id'         => $logo->id,
              'order_code' => $trans_id,
            ],
            'user_id'        => $user->id,
            'username'       => $user->username,
            'order_id'       => $logo->id,
          ]);
         $content = "┏━━━━━━━━━━━━━━━┓\n";
         $content .= "┣➤ ".$user->name."\n";
         $content .= "┣➤ Loại Logo".$logo->name."\n";
         $content .= "┣➤ GIÁ: ".number_format($logo->price)."đ\n";
         $content .= "┣➤ Yêu cầu của khách hàng: " . $payload['name']."\n";
         $content .= "┗━━━━━━━━━━━━━━━┛\n";
         Helper::sendMessageTelegramAuto($content);
          $content = 'Thành toán logo '.$logo->name.' Mã số '.$logo->id;
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
          
           try {
              broadcast(new GlobalPurchaseEvent([
                  'userName' => $user->name,
                  'productName' => 'Logo: ' . $logo->name,
                  'productPrice' => number_format($value) . ' đ',
                  'location' => 'Việt Nam',
                  'time' => now()->toDateTimeString()
              ]));
          } catch (\Exception $e) {
              \Illuminate\Support\Facades\Log::error('GlobalPurchaseEvent Error: ' . $e->getMessage());
          }

        return response()->json([
            'status'  => 200,
            'message' => 'Thanh toán logo thành công.',
        ], 200);
    }
    public function showHisLogo()
     {
        $user = User::find(auth()->user()->id);
        $id = $user->id;

        $hislogo = Hislogo::where('user_id', $id)->orderBy('id', 'desc')->get();
         return view('logo.history', [
            'pageTitle' => 'Lịch sử tạo logo của ' . $user->name,
            'hislogo' => $hislogo,
            'user' => $user,
        ]);

     }
}