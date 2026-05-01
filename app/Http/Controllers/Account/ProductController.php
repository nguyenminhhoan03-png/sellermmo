<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Models\Logs;
use App\Models\User;
use App\Models\Product;
use App\Helpers\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;


class ProductController extends Controller
{
  public function index()
  {
    $user                = User::find(auth()->user()->id);
    $id = $user->id;
    $products = Product::where('status', 1)->where('user_id', $id)->orderBy('id', 'desc')->get();
    if ($user->level != 2) {
      return redirect()->route('home')->with('error', 'Bạn không phải là người bán hàng.');
    }
    return view('account.profile.product', [
      'pageTitle' => ('Danh sách sản phẩm'),
    ], compact('user', 'products'));
  }
  public function upload()
  {
    $user                = User::find(auth()->user()->id);
    $id = $user->id;
    if ($user->level != 2) {
      return redirect()->route('home')->with('error', 'Bạn không phải là người bán hàng.');
    }
    $products = Product::where('status', 1)->where('user_id', $id)->orderBy('id', 'desc')->get();

    return view('account.profile.upload', [
      'pageTitle' => ('Danh sách sản phẩm'),
    ], compact('user', 'products'));
  }
  public function uploadPost(Request $request)
    {
      if (env('PRJ_DEMO_MODE', false) === true) {
        return response()->json([
          'status'  => 500,
          'message' => 'Chức năng này không hoạt động trong chế độ demo.',
        ], 500);
      }
      $user = User::find(auth()->user()->id);
      if ($user->banned !== 0) {
        return response()->json([
          'status'  => 400,
          'message' => 'Tài khoản của bạn đang bị khóa, vui lòng liên hệ admin để được hỗ trợ.',
        ], 400);
      }
      if ($user->level != 2) {
        return response()->json([
          'status'  => 403,
          'message' => 'Tài khoản của bạn không phải là cộng tác viên.',
        ], 403);
      }
      $messages = [
        'product_name.required' => 'Trường tên sản phẩm là bắt buộc',
        'price.required'  => 'Trường số tiền là bắt buộc.',
        'description.required'  => 'Trường mô tả là bắt buộc.',
      ];
  
      $attributes = [
        'product_name' => 'Tên sản phẩm',
        'price'    => 'Giá',
        'description' => 'Mô tả',
        'images' => 'Hình Ảnh',
        'link_down' => 'Link tải code',
        'link_demo' => 'Link demo',
        'list_images' => 'Danh sách ảnh',
        'dicsounted_price' => '% chiết khấu',
      ];
      $payload = $request->validate([
        'images' => 'required|mimes:jpeg,jpg,png,gif',
        'link_down' => 'string',
        'link_demo' => 'string',
        'list_images' => 'string',
        'dicsounted_price' => 'numeric',
        'product_name' => 'required|string|max:255',
        'price' => 'required|numeric|min:0',
        'description' => 'required|string',

      ], $messages, $attributes);

      if (!$request->hasFile('images')) {
        return response()->json(['status' => 400, 'message' => 'Hành động của bạn không hợp lệ !!!'], 400);
      }
      $photo = $request->file('images');
      $allowedExtensions = [".gif", ".png", ".jpg", ".jpeg"];
      $extension = "." . $photo->getClientOriginalExtension();
      if (!in_array(strtolower($extension), $allowedExtensions)) {
          return response()->json(['status' => 400, 'message' => 'Định Dạng Ảnh Không Được Phép Upload'], 400);
      }
      $client_id = "4ec3406826c04ac";
      $response = Http::withHeaders([
          'Authorization' => 'Client-ID ' . $client_id
      ])->post('https://api.imgur.com/3/image.json', [
          'image' => base64_encode(file_get_contents($photo->getRealPath()))
      ]);
      $reply = $response->json();
      if ($reply['success'] ?? false) {
       $url = $reply['data']['link'];
      } else {
        return response()->json(['status' => '400', 'message' => 'Không thể upload ảnh của bạn, hãy thử lại!'], 400);
      }
      $product = Product::create([
        'name' => $payload['product_name'],
        'user_id' => $user->id,
        'price' => $payload['price'],
        'images' => $url,
        'list_images' => $payload['list_images'],
        'intro' => $payload['description'],
        'view' => 0,
        'sold' => 0,
        'link_down' => Helper::muabanwebsite_enc($payload['link_down']),
        'link_demo' => $payload['link_demo'],
        'status' => 2,
        'ck' => $payload['dicsounted_price'],
      ]);
      Logs::create([
        'data'       => '0',
        'action'    => 'Đăng tải mã nguồn ' . $payload['product_name'] . ' với giá ' . number_format($payload['price']) . 'đ',
        'description' => 'Thực hiện hành động đăng sản phẩm với địa chỉ ip' . request()->ip(),
        'old_data' => 0,
        'new_data' => 0,
        'user_id'    => $user->id,
        'ip' => request()->ip(),
        'data_json' => '',
      ]);
       $content = "┏━━━━━━━━━━━━━━━┓\n";
      $content .= "┣➤ ".$user->name."\n";
      $content .= "┣➤ Tên sản phẩm: ".$payload['product_name']."\n";
      $content .= "┣➤ GIÁ: ".number_format($payload['price'])."đ\n";
      $content .= "┣➤ TRẠNG THÁI: ĐANG CHỜ ADMIN DUYỆT\n";
      $content .= "┣➤ Thông báo gửi tới admin\n";
      $content .= "┗━━━━━━━━━━━━━━━┛\n";
      Helper::sendMessageTelegramAuto($content);
       if ($product) {
        return response()->json(['status' => 200, 'message' => 'Vui lòng chờ quản trị viên duyệt sản phẩm của bạn'], 200);
       } else {
        return response()->json(['status' => 500, 'message' => 'Không thể tạo sản phẩm, hãy thử lại!'], 500);
       }
    }
}
