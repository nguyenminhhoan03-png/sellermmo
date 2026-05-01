<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Domain;
use App\Models\Logs;
use App\Models\DomainOrder;
use App\Helpers\Helper;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use App\Mail\DomainSuccessMail;
use Illuminate\Support\Facades\Mail;

class DomainController extends Controller
{
    public function index(Request $request)
    {
        $domain = Domain::get();

        return view('admin.domain.index', compact('domain'));
    }
    public function updateStatus(Request $request)
  {
    
    $payload = $request->validate([
      'id'     => 'required|integer',
      'status' => 'required|boolean',
    ]);

    $product = Domain::where('id', $payload['id'])->firstOrFail();

    $product->update([
      'status' => $payload['status'],
    ]);

    return response()->json([
      'status'  => 200,
      'message' => 'Domain status updated successfully.',
    ]);
    }
    public function uploadDomain(Request $request)
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
        'extend_price.required'  => 'Trường giá gia hạn là bắt buộc.',
        'status.required'  => 'Trường trạng thái là bắt buộc.',
        'sale.required'  => 'Trường % giảm giá là bắt buộc.',
      ];
      $attributes = [
        'name' => 'Tên sản phẩm',
        'price'    => 'Giá',
        'extend_price' => 'Giá gia hạn',
        'sale' => '% giảm giá',
        'status' => 'Trạng thái',
      ];
      $payload = $request->validate([
        'sale' => 'required|numeric',
        'name' => 'required|string|max:255',
        'price' => 'required|numeric|min:0',
        'extend_price' => 'required|numeric|min:0',
        'status' => 'required',

      ], $messages, $attributes);

      $product = Domain::create([
        'name' => $payload['name'],
        'price' => $payload['price'],
        'extend_price' => $payload['extend_price'],
        'sale' => $payload['sale'],
        'status' => $payload['status'],
      ]);
      Logs::create([
        'data'       => '0',
        'action'    => 'Đăng tải tên miền' . $payload['name'] . 'với giá ' . number_format($payload['price']) . 'đ',
        'description' => 'Thực hiện hành động đăng sản phẩm với địa chỉ ip' . request()->ip(),
        'old_data' => 0,
        'new_data' => 0,
        'user_id'    => $user->id,
        'ip' => request()->ip(),
        'data_json' => '',
      ]);
      $content = "┏━━━━━━━━━━━━━━━┓\n";
      $content .= "┣➤ ".$user->name."\n";
      $content .= "┣➤ Tên miền: .".$payload['name']."\n";
      $content .= "┣➤ GIÁ: ".number_format($payload['price'])."đ\n";
      $content .= "┣➤ TRẠNG THÁI: ĐÃ DUYỆT\n";
      $content .= "┣➤ sản phẩm đã được đăng tải\n";
      $content .= "┗━━━━━━━━━━━━━━━┛\n";
      Helper::sendMessageTelegramAuto($content);
       if ($product) {
        return redirect()->back()->with('success', 'Thêm tên miền thành công');
       } else {
        return redirect()->back()->with('error', 'Không thể tạo tên miền, hãy thử lại!');
       }
    }
    public function delete(Request $request)
  {

    if ($request->has('ids')) {
      $payload = $request->validate([
        'ids' => 'required|array',
      ]);

      $ids = array_map('intval', $payload['ids']);

      $product = Domain::whereIn('id', $ids)->get();

      foreach ($product as $products) {
        $products->delete();
      }

      Helper::addLogs(__('Thực hiện thao tác xóa nhiều tên miền cùng lúc; số lượng: :count', ['count' => $product->count()]));

      return response()->json([
        'status'  => 200,
        'message' => 'Domain deleted successfully.',
      ]);
    }

    $payload = $request->validate([
      'id' => 'required|integer',
    ]);

    $productz = Domain::where('id', $payload['id'])->firstOrFail();
    $productz->delete();

    Helper::addLogs('Xóa tên miền #' . $productz->name);

    return response()->json([
      'status'  => 200,
      'message' => 'Domain deleted successfully.',
    ]);
    }
    public function showedit(Request $request, $id)
  {
    $domain    = Domain::where('id', $id)->firstOrFail();
    if (!$domain) {
      return redirect()->route('admin.domain.index')->with('error', 'Domain not found');
    }
    return view('admin.domain.edit', [
      'pageTitle' => 'Chi tiết tên miền #' . $domain->id,
    ], compact('domain'));
    }
    public function updateDomain(Request $request)
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
        'extend_price.required'  => 'Trường giá gia hạn là bắt buộc.',
        'status.required'  => 'Trường trạng thái là bắt buộc.',
        'sale.required'  => 'Trường % giảm giá là bắt buộc.',
      ];
      $attributes = [
        'name' => 'Tên sản phẩm',
        'price'    => 'Giá',
        'extend_price' => 'Giá gia hạn',
        'sale' => '% giảm giá',
        'status' => 'Trạng thái',
      ];
      $payload = $request->validate([
        'id'          => 'required|integer',
        'sale' => 'required|numeric',
        'name' => 'required|string|max:255',
        'price' => 'required|numeric|min:0',
        'extend_price' => 'required|numeric|min:0',
        'status' => 'required',

      ], $messages, $attributes);
      
      $product = Domain::find($payload['id']);

      if (!$product) {
        return redirect()->route('admin.domain.index')->with('error', 'Không tìm thấy tên miền #' . $payload['id']);
      }
      $product->update($payload);

      Logs::create([
        'data'       => '0',
        'action'    => 'Cập nhật tên miền' . $payload['name'] . 'với giá ' . number_format($payload['price']) . 'đ',
        'description' => 'Thực hiện hành động cập nhật tên miền với địa chỉ ip' . request()->ip(),
        'old_data' => 0,
        'new_data' => 0,
        'user_id'    => $user->id,
        'ip' => request()->ip(),
        'data_json' => '',
      ]);
      $content = "┏━━━━━━━━━━━━━━━┓\n";
      $content .= "┣➤ ".$user->name."\n";
      $content .= "┣➤ Tên miền: .".$payload['name']."\n";
      $content .= "┣➤ GIÁ: ".number_format($payload['price'])."đ\n";
      $content .= "┣➤ HÀNH ĐỘNG: CẬP NHẬT\n";
      $content .= "┗━━━━━━━━━━━━━━━┛\n";
      Helper::sendMessageTelegramAuto($content);
       
      return redirect()->back()->with('success', 'Cập nhật tên miền thành công #' . $product->id);
    }
    public function history(Request $request)
    {
      $history = DomainOrder::get();
  
      return view('admin.domain.history', compact('history'));
    }
    public function historyupdate(Request $request)
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
        'status.required'  => 'Trường trạng thái là bắt buộc.',
         'ns.required'  => 'Trường nameserver là bắt buộc.',
      ];
      $attributes = [
        'name' => 'Tên sản phẩm',
        'ns'    => 'Nameserver',
        'status' => 'Trạng thái',
      ];
      $payload = $request->validate([
        'id'          => 'required|integer',
        'name' => 'required|string|max:255',
        'ns' => 'required|string',
        'status' => 'required',

      ], $messages, $attributes);
      
      $product = DomainOrder::find($payload['id']);

      $price = $product->price;

      if (!$product) {
        return redirect()->route('admin.domain.history')->with('error', 'Không tìm thấy tên miền #' . $payload['id']);
      }
      $product->update($payload);

      Logs::create([
        'data'       => '0',
        'action'    => 'Cập nhật tên miền' . $payload['name'] . 'với giá ' . number_format($price) . 'đ',
        'description' => 'Thực hiện hành động cập nhật tên miền với địa chỉ ip' . request()->ip(),
        'old_data' => 0,
        'new_data' => 0,
        'user_id'    => $user->id,
        'ip' => request()->ip(),
        'data_json' => '',
      ]);
      $user_domain = User::find($product->user_id);
      $domainame = $product->domain_name;
      $value = $product->price;
      $ns = $product->ns;
      if ($payload['status'] == 2){
        Mail::to($user_domain->email)->send(new DomainSuccessMail($user, $domainame, $value, $ns));
      }
       $content = "┏━━━━━━━━━━━━━━━┓\n";
      $content .= "┣➤ ".$user->name."\n";
      $content .= "┣➤ Tên miền: ".$payload['name']."\n";
      $content .= "┣➤ GIÁ: ".number_format($price)."đ\n";
      $content .= "┣➤ HÀNH ĐỘNG: CẬP NHẬT\n";
      $content .= "┣➤ Trạng Thái: ".$payload['status']."\n";
      $content .= "┗━━━━━━━━━━━━━━━┛\n";
      Helper::sendMessageTelegramAuto($content);
       
      return redirect()->back()->with('success', 'Cập nhật tên miền thành công #' . $product->id);
    }
    public function update_status_history(Request $request)
  {
    
    $payload = $request->validate([
      'id'     => 'required|integer',
      'status' => 'required|boolean',
    ]);

    $product = DomainOrder::where('id', $payload['id'])->firstOrFail();

    $product->update([
      'giahan' => $payload['status'],
    ]);

    return response()->json([
      'status'  => 200,
      'message' => 'Cập nhật gia hạn auto thành công.',
    ]);
    }
    public function deleteHistory(Request $request)
  {

    if ($request->has('ids')) {
      $payload = $request->validate([
        'ids' => 'required|array',
      ]);

      $ids = array_map('intval', $payload['ids']);

      $product = DomainOrder::whereIn('id', $ids)->get();

      foreach ($product as $products) {
        $products->delete();
      }

      Helper::addLogs(__('Thực hiện thao tác xóa nhiều tên miền cùng lúc; số lượng: :count', ['count' => $product->count()]));

      return response()->json([
        'status'  => 200,
        'message' => 'Domain deleted successfully.',
      ]);
    }

    $payload = $request->validate([
      'id' => 'required|integer',
    ]);

    $productz = DomainOrder::where('id', $payload['id'])->firstOrFail();
    $productz->delete();

    Helper::addLogs('Xóa tên miền #' . $productz->name);

    return response()->json([
      'status'  => 200,
      'message' => 'Domain deleted successfully.',
    ]);
    }
}