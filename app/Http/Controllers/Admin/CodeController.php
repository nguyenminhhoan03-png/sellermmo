<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Hisproduct;
use App\Models\Logs;
use App\Models\Product;
use App\Helpers\Helper;
use App\Models\User;
use App\Models\WithdrawCtv;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;

class CodeController extends Controller
{
  public function index(Request $request)
  {
    $product = Product::get();

    return view('admin.manguon.index', compact('product'));
  }
  public function upload_code(Request $request)
  {
    $product = Product::get();

    return view('admin.manguon.up', compact('product'));
  }
  public function updateStatus(Request $request)
  {
    $payload = $request->validate([
      'id'     => 'required|integer',
      'status' => 'required|boolean',
    ]);

    $product = Product::where('id', $payload['id'])->firstOrFail();

    $product->update([
      'status' => $payload['status'],
    ]);

    return response()->json([
      'status'  => 200,
      'message' => 'Product status updated successfully.',
    ]);
  }
  public function delete(Request $request)
  {

    if ($request->has('ids')) {
      $payload = $request->validate([
        'ids' => 'required|array',
      ]);

      $ids = array_map('intval', $payload['ids']);

      $product = Product::whereIn('id', $ids)->get();

      foreach ($product as $products) {
        if ($products->images && File::exists(public_path($products->images))) {
                File::delete(public_path($products->images));
            }
        if ($products->list_images) {
                $listImages = explode("\n", $products->list_images);
                foreach ($listImages as $img) {
                    $img = trim($img);
                    if ($img && File::exists(public_path($img))) {
                        File::delete(public_path($img));
                    }
                }
            }
        $products->delete();
      }

      Helper::addLogs(__('Thực hiện thao tác xóa nhiều sản phẩm cùng lúc; số lượng: :count', ['count' => $product->count()]));

      return response()->json([
        'status'  => 200,
        'message' => 'Product deleted successfully.',
      ]);
    }

    $payload = $request->validate([
      'id' => 'required|integer',
    ]);

    $productz = Product::where('id', $payload['id'])->firstOrFail();
    if ($productz->images && File::exists(public_path($productz->images))) {
        File::delete(public_path($productz->images));
    }
    if ($productz->list_images) {
        $listImages = explode("\n", $productz->list_images);
        foreach ($listImages as $img) {
            $img = trim($img);
            if ($img && File::exists(public_path($img))) {
                File::delete(public_path($img));
            }
        }
    }
    $productz->delete();

    Helper::addLogs('Xóa sản phẩm #' . $productz->name);

    return response()->json([
      'status'  => 200,
      'message' => 'Product deleted successfully.',
    ]);
  }
  public function uploadPost(Request $request)
    {
      $user = User::find(auth()->user()->id);
      if ($user->banned !== 0) {
        return response()->json([
          'status'  => 400,
          'message' => 'Tài khoản của bạn đang bị khóa, vui lòng liên hệ admin để được hỗ trợ.',
        ], 400);
      }
      if ($user->level != 1) {
        return response()->json([
          'status'  => 403,
          'message' => 'Bạn không phải là admin.',
        ], 403);
      }
      $messages = [
        'name.required' => 'Trường tên sản phẩm là bắt buộc',
        'price.required'  => 'Trường số tiền là bắt buộc.',
        'intro.required'  => 'Trường mô tả là bắt buộc.',
        'status.required'  => 'Trường trạng thái là bắt buộc.',
        'images.required'  => 'Trường hình ảnh là bắt buộc.',
        'link_down.required'  => 'Trường Link tải code là bắt buộc.',
        'link_demo.required'  => 'Trường Link demo là bắt buộc.',
        'list_images.required'  => 'Trường danh sách ảnh là bắt buộc.',
        'ck.required'  => 'Trường % chiết khấu là bắt buộc.',
        'images.mimes' => 'Hình ảnh phải là jpeg, jpg, png, gif',
      ];
      $attributes = [
        'name' => 'Tên sản phẩm',
        'price'    => 'Giá',
        'intro' => 'Mô tả',
        'images' => 'Hình Ảnh',
        'link_down' => 'Link tải code',
        'link_demo' => 'Link demo',
        'list_images' => 'Danh sách ảnh',
        'ck' => '% chiết khấu',
        'status' => 'Trạng thái',
      ];
      $payload = $request->validate([
        'images' => 'required|mimes:jpeg,jpg,png,gif',
        'link_down' => 'required|string',
        'link_demo' => 'required|string',
        'list_images.*' => 'mimes:jpeg,jpg,png,gif',
        'ck' => 'required|numeric',
        'name' => 'required|string|max:255',
        'price' => 'required|numeric|min:0',
        'intro' => 'required|string',
        'status' => 'required',
        'category' => 'nullable|string|in:website,game,phanmem,ecommerce,blog,other',
      ], $messages, $attributes);

      if (!$request->hasFile('images')) {
        return redirect()->back()->with('error', 'Hành động của bạn không hợp lệ !!!');
      }
      $photo = $request->file('images');
      $client_id = "4ec3406826c04ac";
      $url = uploadImageToImgur($photo, $client_id);
      if ($url == '0') {
        return redirect()->back()->with('error', 'Hành động của bạn không hợp lệ !!!');
      } elseif ($url == '1') {
        return redirect()->back()->with('error', 'Không thể upload ảnh của bạn, hãy thử lại!');
      } else {
        $payload['image'] = $url;
      }
      if ($request->hasFile('list_images')) {
      $listImages = [];

    foreach ($request->file('list_images') as $photo) {
        $client_id = "4ec3406826c04ac";
        $url = uploadImageToImgur($photo, $client_id);

        if ($url === '0') {
            return redirect()->back()->with('error', 'Hành động của bạn không hợp lệ !!!');
        } elseif ($url === '1') {
            return redirect()->back()->with('error', 'Không thể upload ảnh của bạn, hãy thử lại!');
        } else {
            $listImages[] = $url;
        }
     }
     $payload['list_images'] = implode("\n", $listImages);

     } else {
       return redirect()->back()->with('error', 'Bạn chưa chọn ảnh nào!');
     }
      $product = Product::create([
        'name' => $payload['name'],
        'user_id' => $user->id,
        'price' => $payload['price'],
        'images' => $payload['image'],
        'list_images' => $payload['list_images'],
        'intro' => $payload['intro'],
        'view' => 0,
        'sold' => 0,
        'link_down' => Helper::muabanwebsite_enc($payload['link_down']),
        'link_demo' => $payload['link_demo'],
        'status' => $payload['status'],
        'ck' => $payload['ck'],
        'category' => $payload['category'] ?? 'website',
      ]);
      Logs::create([
        'data'       => '0',
        'action'    => 'Đăng tải mã nguồn' . $payload['name'] . 'với giá ' . number_format($payload['price']) . 'đ',
        'description' => 'Thực hiện hành động đăng sản phẩm với địa chỉ ip' . request()->ip(),
        'old_data' => 0,
        'new_data' => 0,
        'user_id'    => $user->id,
        'ip' => request()->ip(),
        'data_json' => '',
      ]);
      $content = "┏━━━━━━━━━━━━━━━┓\n";
      $content .= "┣➤ ".$user->name."\n";
      $content .= "┣➤ Tên sản phẩm: ".$payload['name']."\n";
      $content .= "┣➤ GIÁ: ".number_format($payload['price'])."đ\n";
      $content .= "┣➤ TRẠNG THÁI: ĐÃ DUYỆT\n";
      $content .= "┣➤ sản phẩm đã được đăng tải\n";
      $content .= "┗━━━━━━━━━━━━━━━┛\n";
      Helper::sendMessageTelegramAuto($content);
       if ($product) {
        return redirect()->back()->with('success', 'Thêm sản phẩm thành công');
       } else {
        return redirect()->back()->with('error', 'Không thể tạo sản phẩm, hãy thử lại!');
       }
  }
  public function history(Request $request)
    {
      $history = Hisproduct::get();
  
      return view('admin.manguon.history', compact('history'));
  }
  public function showedit(Request $request, $id)
  {
    $product    = Product::where('id', $id)->firstOrFail();
    if (!$product) {
      return redirect()->route('admin.manguon.index')->with('error', 'Product not found');
    }
    return view('admin.manguon.edit', [
      'pageTitle' => 'Chi tiết mã nguồn #' . $product->id,
    ], compact('product'));
  }
  public function updateCode(Request $request)
    {
      $user = User::find(auth()->user()->id);
      if ($user->banned !== 0) {
        return response()->json([
          'status'  => 400,
          'message' => 'Tài khoản của bạn đang bị khóa, vui lòng liên hệ admin để được hỗ trợ.',
        ], 400);
      }
      if ($user->level != 1) {
        return response()->json([
          'status'  => 403,
          'message' => 'Bạn không phải là admin.',
        ], 403);
      }
      $messages = [
        'name.required' => 'Trường tên sản phẩm là bắt buộc',
        'price.required'  => 'Trường số tiền là bắt buộc.',
        'intro.required'  => 'Trường mô tả là bắt buộc.',
        'status.required'  => 'Trường trạng thái là bắt buộc.',
        'images.required'  => 'Trường hình ảnh là bắt buộc.',
        'link_down.required'  => 'Trường Link tải code là bắt buộc.',
        'link_demo.required'  => 'Trường Link demo là bắt buộc.',
        'list_images.required'  => 'Trường danh sách ảnh là bắt buộc.',
        'ck.required'  => 'Trường % chiết khấu là bắt buộc.',
        'images.mimes' => 'Hình ảnh phải là jpeg, jpg, png, gif',
      ];
      $attributes = [
        'name' => 'Tên sản phẩm',
        'price'    => 'Giá',
        'intro' => 'Mô tả',
        'images' => 'Hình Ảnh',
        'link_down' => 'Link tải code',
        'link_demo' => 'Link demo',
        'list_images' => 'Danh sách ảnh',
        'ck' => '% chiết khấu',
        'status' => 'Trạng thái',
      ];
      $payload = $request->validate([
        'id'          => 'required|integer',
        'images' => 'nullable|image|mimes:jpeg,png,jpg,gif',
        'link_down' => 'required|string',
        'link_demo' => 'required|string',
        'list_images' => 'array',
        'list_images.*' => 'mimes:jpeg,jpg,png,gif',
        'ck' => 'required|numeric',
        'name' => 'required|string|max:255',
        'price' => 'required|numeric|min:0',
        'intro' => 'required|string',
        'status' => 'required',
        'category' => 'nullable|string|in:website,game,phanmem,ecommerce,blog,other',
      ], $messages, $attributes);
       
      $payload['link_down'] = Helper::muabanwebsite_enc($payload['link_down']);
      
      $product = Product::find($payload['id']);

      if (!$product) {
        return redirect()->route('admin.manguon.index')->with('error', 'Không tìm thấy mã nguồn #' . $payload['id']);
      }
      if ($request->hasFile('images')) {
        $photo = $request->file('images');
        $client_id = "4ec3406826c04ac";
        $url = uploadImageToImgur($photo, $client_id);
        if ($url == '0') {
          return redirect()->back()->with('error', 'Hành động của bạn không hợp lệ !!!');
        } elseif ($url == '1') {
          return redirect()->back()->with('error', 'Không thể upload ảnh của bạn, hãy thử lại!');
        } else {
          $payload['images'] = $url;
        }
      } else {
        $payload['images'] = $product->images;
      }
      if ($request->hasFile('list_images')) {
        $listImages = [];

        foreach ($request->file('list_images') as $photo) {
         $client_id = "4ec3406826c04ac";
         $url = uploadImageToImgur($photo, $client_id);

         if ($url === '0') {
            return redirect()->back()->with('error', 'Hành động của bạn không hợp lệ !!!');
          } elseif ($url === '1') {
             return redirect()->back()->with('error', 'Không thể upload ảnh của bạn, hãy thử lại!');
          } else {
            $listImages[] = $url;
          }
        }
        $payload['list_images'] = implode("\n", $listImages);

        } else {
        $payload['list_images'] = $product->list_images;
      }
      $product->update($payload);

      Logs::create([
        'data'       => '0',
        'action'    => 'Cập nhật mã nguồn' . $payload['name'] . 'với giá ' . number_format($payload['price']) . 'đ',
        'description' => 'Thực hiện hành động cập nhật mã nguồn với địa chỉ ip' . request()->ip(),
        'old_data' => 0,
        'new_data' => 0,
        'user_id'    => $user->id,
        'ip' => request()->ip(),
        'data_json' => '',
      ]);
      $content = "┏━━━━━━━━━━━━━━━┓\n";
      $content .= "┣➤ ".$user->name."\n";
      $content .= "┣➤ Tên sản phẩm: ".$payload['name']."\n";
      $content .= "┣➤ GIÁ: ".number_format($payload['price'])."đ\n";
      $content .= "┣➤ HÀNH ĐỘNG: CẬP NHẬT\n";
      $content .= "┗━━━━━━━━━━━━━━━┛\n";
      Helper::sendMessageTelegramAuto($content);
       
      return redirect()->back()->with('success', 'Cập nhật mã nguồn thành công #' . $product->id);
  } 
  public function pay(Request $request)
  {
    $pay    = WithdrawCtv::get();

    return view('admin.manguon.pay', [
      'pageTitle' => 'Các đơn rút tiền của CTV',
    ], compact('pay'));
  }
  public function updatePay(Request $request)
  {
    $user = User::find(auth()->user()->id);
    if ($user->banned !== 0) {
      return response()->json([
        'status'  => 400,
        'message' => 'Tài khoản của baise đang bị khóa, vui số liên hệ admin để được hỗ trợ.',
      ], 400);
    }
    if ($user->level != 1) {
      return response()->json([
        'status'  => 403,
        'message' => 'Bạn không phải là admin.',
      ], 403);
    }
    $payload = $request->validate([
      'id' => 'required|numeric',
      'status' => 'required',
    ]);
    $pay = WithdrawCtv::find($payload['id']);
    if (!$pay) {
      return response()->json([
        'status'  => 404,
        'message' => 'Không tìm thấy đơn rút tiền #' . $payload['id'],
      ], 404);
    }
    $user_ctv = User::where('id', $pay->user_id)->first();
    if ($payload['status'] == 3) {
      $user_ctv->increment('balance_ctv', $pay->price);
      Logs::create([
        'user_id' => $user_ctv->id,
        'action' => 'Đơn rút tiền đã bị hủy '.$user_ctv->name.' đã hoàn lại với số tiền '.number_format($pay->price).'đ',
        'data' => 0,
        'old_data' => 0,
        'new_data' => 0,
        'ip' => request()->ip(),
        'description' => 'Thực hiện hành động Đơn rút tiền đã bị hủy ' . $user_ctv->name . ' đã hoàn lại với số tiền ' . number_format($pay->price) . 'đ địa chỉ ip ' . request()->ip(),
        'data_json' => '',

    ]);
    }
    $pay->update([
      'status' => $payload['status'],
    ]);
    return redirect()->back()->with('success', 'Cập nhật đơn rút tiền #' . $payload['id']);
  }
  public function deletePay(Request $request)
  {

    if ($request->has('ids')) {
      $payload = $request->validate([
        'ids' => 'required|array',
      ]);

      $ids = array_map('intval', $payload['ids']);

      $pay = WithdrawCtv::whereIn('id', $ids)->get();

      foreach ($pay as $pays) {
        $pays->delete();
      }

      Helper::addLogs(__('Thực hiện thao tác xóa nhiều đơn rút tiền cùng lúc; số lượng: :count', ['count' => $pay->count()]));

      return response()->json([
        'status'  => 200,
        'message' => 'Withdraw deleted successfully.',
      ]);
    }

    $payload = $request->validate([
      'id' => 'required|integer',
    ]);

    $pay = WithdrawCtv::where('id', $payload['id'])->firstOrFail();
    $pay->delete();

    Helper::addLogs('Xóa đơn rút tiền #' . $pay->trans_id);

    return response()->json([
      'status'  => 200,
      'message' => 'Withdraw deleted successfully.',
    ]);
  }
}
