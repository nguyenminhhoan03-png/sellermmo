<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Logs;
use App\Models\Logo;
use App\Helpers\Helper;
use App\Models\User;
use App\Models\Hislogo;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;

class LogoController extends Controller
{
  public function index(Request $request)
  {
    $logo = Logo::get();

    return view('admin.logo.index', compact('logo'));
  }
  public function updateStatus(Request $request)
  {
    $payload = $request->validate([
      'id'     => 'required|integer',
      'status' => 'required|boolean',
    ]);

    $logo = Logo::where('id', $payload['id'])->firstOrFail();

    $logo->update([
      'status' => $payload['status'],
    ]);

    return response()->json([
      'status'  => 200,
      'message' => 'Logo status updated successfully.',
    ]);
  }
  public function delete(Request $request)
  {
    if ($request->has('ids')) {
        $payload = $request->validate([
            'ids' => 'required|array',
        ]);

        $ids = array_map('intval', $payload['ids']);
        $logos = Logo::whereIn('id', $ids)->get();

        foreach ($logos as $logo) {
            if ($logo->image && File::exists(public_path($logo->image))) {
                File::delete(public_path($logo->image));
            }

            $logo->delete();
        }

        Helper::addLogs(__('Thực hiện thao tác xóa nhiều logo cùng lúc; số lượng: :count', ['count' => $logos->count()]));

        return response()->json([
            'status'  => 200,
            'message' => 'Logo deleted successfully.',
        ]);
    }

    $payload = $request->validate([
        'id' => 'required|integer',
    ]);

    $logo = Logo::findOrFail($payload['id']);
    
    if ($logo->image && File::exists(public_path($logo->image))) {
        File::delete(public_path($logo->image));
    }

    $logo->delete();

    Helper::addLogs('Xóa sản phẩm #' . $logo->name);

    return response()->json([
        'status'  => 200,
        'message' => 'Logo deleted successfully.',
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
        'image.required'  => 'Trường hình ảnh là bắt buộc.',
        'ck.required'  => 'Trường % chiết khấu là bắt buộc.',
        'image.mimes' => 'Hình ảnh phải là jpeg, jpg, png, gif',
      ];
      $attributes = [
        'name' => 'Tên sản phẩm',
        'price'    => 'Giá',
        'description' => 'Mô tả',
        'image' => 'Hình Ảnh',
        'ck' => '% chiết khấu',
        'status' => 'Trạng thái',
      ];
      $payload = $request->validate([
        'image' => 'required|mimes:jpeg,jpg,png,gif',
        'ck' => 'required|numeric',
        'name' => 'required|string|max:255',
        'price' => 'required|numeric|min:0',
        'description' => 'required|string',
        'status' => 'required',

      ], $messages, $attributes);

      if (!$request->hasFile('image')) {
        return redirect()->back()->with('error', 'Thiếu ảnh kìa bro !!!');
      }
      $photo = $request->file('image');
      $client_id = "4ec3406826c04ac";
      $url = uploadImageToImgur($photo, $client_id);
      if ($url == '0') {
        return redirect()->back()->with('error', 'Hành động của bạn không hợp lệ !!!');
      } elseif ($url == '1') {
        return redirect()->back()->with('error', 'Không thể upload ảnh của bạn, hãy thử lại!');
      } else {
        $payload['image'] = $url;
      }
      Logo::create([
        'name' => $payload['name'],
        'price' => $payload['price'],
        'image' => $payload['image'],
        'description' => $payload['description'],
        'status' => $payload['status'],
        'ck' => $payload['ck'],
      ]);
     $logo = Logs::create([
        'data'       => '0',
        'action'    => 'Đăng tải logo' . $payload['name'] . 'với giá ' . number_format($payload['price']) . 'đ',
        'description' => 'Thực hiện hành động đăng logo với địa chỉ ip' . request()->ip(),
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
      $content .= "┣➤  Logo đã được đăng tải\n";
      $content .= "┗━━━━━━━━━━━━━━━┛\n";
      Helper::sendMessageTelegramAuto($content);
       if ($logo) {
        return redirect()->back()->with('success', 'Thêm logo thành công');
       } else {
        return redirect()->back()->with('error', 'Không thể tạo logo, hãy thử lại!');
       }
  }
  public function history(Request $request)
    {
      $hislogo = Hislogo::get();
  
      return view('admin.logo.history', compact('hislogo'));
  }
  public function updateLogo(Request $request)
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
        'image.required'  => 'Trường hình ảnh là bắt buộc.',
        'ck.required'  => 'Trường % chiết khấu là bắt buộc.',
        'image.mimes' => 'Hình ảnh phải là jpeg, jpg, png, gif',
      ];
      $attributes = [
        'name' => 'Tên sản phẩm',
        'price'    => 'Giá',
        'description' => 'Mô tả',
        'image' => 'Hình Ảnh',
        'ck' => '% chiết khấu',
        'status' => 'Trạng thái',
      ];
      $payload = $request->validate([
        'id'          => 'required|integer',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif',
        'ck' => 'required|numeric',
        'name' => 'required|string|max:255',
        'price' => 'required|numeric|min:0',
        'description' => 'required|string',
        'status' => 'required',

      ], $messages, $attributes);
       
      $logo = Logo::find($payload['id']);

      if (!$logo) {
        return redirect()->route('admin.logo.index')->with('error', 'Không tìm thấy Logo #' . $payload['id']);
      }
      if ($request->hasFile('image')) {
        $photo = $request->file('image');
        $client_id = "4ec3406826c04ac";
        $url = uploadImageToImgur($photo, $client_id);
        if ($url == '0') {
          return redirect()->back()->with('error', 'Hành động của bạn không hợp lệ !!!');
        } elseif ($url == '1') {
          return redirect()->back()->with('error', 'Không thể upload ảnh của bạn, hãy thử lại!');
        } else {
          $payload['image'] = $url;
        }
      } else {
        $payload['image'] = $logo->image;
      }
      $logo->update($payload);

      Logs::create([
        'data'       => '0',
        'action'    => 'Cập nhật logo ' . $payload['name'] . 'với giá ' . number_format($payload['price']) . 'đ',
        'description' => 'Thực hiện hành động cập nhật logo với địa chỉ ip' . request()->ip(),
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
       
      return redirect()->back()->with('success', 'Cập nhật logo thành công #' . $logo->id);
  } 
  public function deleteHistory(Request $request)
  {

    if ($request->has('ids')) {
      $payload = $request->validate([
        'ids' => 'required|array',
      ]);

      $ids = array_map('intval', $payload['ids']);

      $logo = Hislogo::whereIn('id', $ids)->get();

      foreach ($logo as $logos) {
        $logos->delete();
      }

      Helper::addLogs(__('Thực hiện thao tác xóa nhiều đơn tạo logo cùng lúc; số lượng: :count', ['count' => $logo->count()]));

      return response()->json([
        'status'  => 200,
        'message' => 'Đơn tạo logo deleted successfully.',
      ]);
    }

    $payload = $request->validate([
      'id' => 'required|integer',
    ]);

    $logo = Hislogo::where('id', $payload['id'])->firstOrFail();
    $logo->delete();

    Helper::addLogs('Xóa đơn tạo logo #' . $logo->trans_id);

    return response()->json([
      'status'  => 200,
      'message' => 'Đơn tạo logo deleted successfully.',
    ]);
  }
   public function UpdateHistory(Request $request)
  {
    
    $payload = $request->validate([
      'id'     => 'required|integer',
      'status' => 'required',
      'link' => 'required|string',
    ]);

    $hislogo = Hislogo::where('id', $payload['id'])->firstOrFail();
     if ($hislogo) {
       $hislogo->update([
       'status' => $payload['status'],
       'link' => $payload['link'],
      ]);
    }
    return redirect()->back()->with('success', 'Cập nhật đơn hàng logo thành công #' . $hislogo->id);
    }
}
