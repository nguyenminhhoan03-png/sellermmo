<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Createweb;
use App\Models\Logs;
use App\Models\Web;
use App\Helpers\Helper;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;

class WebController extends Controller
{
  public function index(Request $request)
  {
    $web = Web::get();

    return view('admin.web.index', compact('web'));
  }
  public function updateStatus(Request $request)
  {
    $payload = $request->validate([
      'id'     => 'required|integer',
      'status' => 'required|boolean',
    ]);

    $web = Web::where('id', $payload['id'])->firstOrFail();
    if ($payload['status']) {
        $status = 1;
    } else {
        $status = 0;
    }
    $web->update([
      'status' => $status,
    ]);

    return response()->json([
      'status'  => 200,
      'message' => 'Web status updated successfully.',
    ]);
  }
  public function delete(Request $request)
  {
    if ($request->has('ids')) {
        $payload = $request->validate([
            'ids' => 'required|array',
        ]);

        $ids = array_map('intval', $payload['ids']);
        $webs = Web::whereIn('id', $ids)->get();

        foreach ($webs as $web) {
            if ($web->images && File::exists(public_path($web->images))) {
                File::delete(public_path($web->images));
            }
            if ($web->list_images) {
                $listImages = explode("\n", $web->list_images);
                foreach ($listImages as $img) {
                    $img = trim($img);
                    if ($img && File::exists(public_path($img))) {
                        File::delete(public_path($img));
                    }
                }
            }

            $web->delete();
        }

        Helper::addLogs(__('Thực hiện thao tác xóa nhiều web cùng lúc; số lượng: :count', ['count' => $webs->count()]));

        return response()->json([
            'status'  => 200,
            'message' => 'web deleted successfully.',
        ]);
    }

    $payload = $request->validate([
        'id' => 'required|integer',
    ]);

    $web = Web::findOrFail($payload['id']);
    
    if ($web->images && File::exists(public_path($web->images))) {
        File::delete(public_path($web->images));
    }
    if ($web->list_images) {
        $listImages = explode("\n", $web->list_images);
        foreach ($listImages as $img) {
            $img = trim($img);
            if ($img && File::exists(public_path($img))) {
                File::delete(public_path($img));
            }
        }
    }

    $web->delete();

    Helper::addLogs('Xóa sản phẩm #' . $web->name);

    return response()->json([
        'status'  => 200,
        'message' => 'web deleted successfully.',
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
        'description.required'  => 'Trường mô tả là bắt buộc.',
        'status.required'  => 'Trường trạng thái là bắt buộc.',
        'images.required'  => 'Trường hình ảnh là bắt buộc.',
        'extend.required' => 'Trường số tiền gia hạn là bắt buộc.',
        'list_images.required'  => 'Trường danh sách ảnh là bắt buộc.',
        'ck.required'  => 'Trường % chiết khấu là bắt buộc.',
        'images.mimes' => 'Hình ảnh phải là jpeg, jpg, png, gif',
      ];
      $attributes = [
        'name' => 'Tên sản phẩm',
        'price'    => 'Giá',
        'description' => 'Mô tả',
        'images' => 'Hình Ảnh',
        'list_images' => 'Danh sách ảnh',
        'ck' => '% chiết khấu',
        'extend' => 'gia hạn',
        'status' => 'Trạng thái',
      ];
      $payload = $request->validate([
       'images' => 'required|mimes:jpeg,jpg,png,gif',
       'list_images' => 'required|array',
       'list_images.*' => 'mimes:jpeg,jpg,png,gif',
       'ck' => 'required|numeric',
       'name' => 'required|string|max:255',
       'price' => 'required|numeric|min:0',
       'description' => 'required|string',
       'extend' => 'required|numeric|min:0',
       'status' => 'required',
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
        $payload['images'] = $url;
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

      $web = Web::create([
        'user_id' => $user->id,
        'name' => $payload['name'],
        'price' => $payload['price'],
        'extend' => $payload['extend'],
        'images' => $payload['images'],
        'list_images' => $payload['list_images'],
        'status' => $payload['status'],
        'description' => $payload['description'],
        'ck' => $payload['ck'],
      ]);
      Logs::create([
        'data'       => '0',
        'action'    => 'Đăng tải website ' . $payload['name'] . 'với giá ' . number_format($payload['price']) . 'đ',
        'description' => 'Thực hiện hành động đăng website với địa chỉ ip' . request()->ip(),
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
       if ($web) {
        return redirect()->back()->with('success', 'Thêm sản phẩm thành công');
       } else {
        return redirect()->back()->with('error', 'Không thể tạo sản phẩm, hãy thử lại!');
       }
  }
  public function history(Request $request)
    {
      $hisweb = Createweb::get();
  
      return view('admin.web.history', compact('hisweb'));
  }
  public function UpdateHistory(Request $request)
  {
    
    $payload = $request->validate([
      'id'     => 'required|integer',
      'status' => 'required',
      'pointer' => 'required',
    ]);

    $hisweb = Createweb::where('id', $payload['id'])->firstOrFail();
     if ($hisweb) {
       $hisweb->update([
       'status' => $payload['status'],
       'pointer' => $payload['pointer'],
      ]);
    }
    return redirect()->back()->with('success', 'Cập nhật đơn hàng tạo web thành công #' . $hisweb->id);
    }
   public function deleteHistory(Request $request)
  {

    if ($request->has('ids')) {
      $payload = $request->validate([
        'ids' => 'required|array',
      ]);

      $ids = array_map('intval', $payload['ids']);

      $web = Createweb::whereIn('id', $ids)->get();

      foreach ($web as $webs) {
        $webs->delete();
      }

      Helper::addLogs(__('Thực hiện thao tác xóa nhiều đơn tạo web cùng lúc; số lượng: :count', ['count' => $web->count()]));

      return response()->json([
        'status'  => 200,
        'message' => 'Đơn tạo web deleted successfully.',
      ]);
    }

    $payload = $request->validate([
      'id' => 'required|integer',
    ]);

    $web = Createweb::where('id', $payload['id'])->firstOrFail();
    $web->delete();

    Helper::addLogs('Xóa đơn tạo web #' . $web->trans_id);

    return response()->json([
      'status'  => 200,
      'message' => 'Đơn tạo web deleted successfully.',
    ]);
  }    
  public function updateWeb(Request $request)
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
        'extend.required'  => 'Trường số tiền gia hạn là bắt buộc.',
        'description.required'  => 'Trường mô tả là bắt buộc.',
        'status.required'  => 'Trường trạng thái là bắt buộc.',
        'ck.required'  => 'Trường % chiết khấu là bắt buộc.',
        'images.mimes' => 'Hình ảnh phải là jpeg, jpg, png, gif',
      ];
      $attributes = [
        'name' => 'Tên sản phẩm',
        'price'    => 'Giá',
        'extend'    => 'Giá gia hạn',
        'description' => 'Mô tả',
        'images' => 'Hình Ảnh',
        'list_images' => 'Danh sách ảnh',
        'ck' => '% chiết khấu',
        'status' => 'Trạng thái',
      ];
      $payload = $request->validate([
       'images' => 'mimes:jpeg,jpg,png,gif',
       'list_images' => 'array',
       'list_images.*' => 'mimes:jpeg,jpg,png,gif',
       'ck' => 'required|numeric',
       'name' => 'required|string|max:255',
       'price' => 'required|numeric|min:0',
       'extend' => 'required|numeric|min:0',
       'description' => 'required|string',
       'status' => 'required',
      ], $messages, $attributes);
      $id = $request->input('id');
      $web = Web::find($id);

      if (!$web) {
        return redirect()->route('admin.web.index')->with('error', 'Không tìm thấy website #' . $payload['id']);
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
        $payload['images'] = $web->images;
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
        $payload['list_images'] = $web->list_images;
      }
      
      $web->update($payload);

      Logs::create([
        'data'       => '0',
        'action'    => 'Cập nhật website' . $payload['name'] . 'với giá ' . number_format($payload['price']) . 'đ',
        'description' => 'Thực hiện hành động cập nhật website với địa chỉ ip' . request()->ip(),
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
       
      return redirect()->back()->with('success', 'Cập nhật website thành công #' . $web->id);
  } 
}