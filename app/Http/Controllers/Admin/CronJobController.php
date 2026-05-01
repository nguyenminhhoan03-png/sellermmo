<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Logs;
use App\Models\SeverCron;
use App\Models\CronOrder;
use App\Helpers\Helper;
use App\Models\User;
use App\Models\Transaction;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class CronJobController extends Controller
{
  public function index(Request $request)
  {
    $server = SeverCron::get();

    return view('admin.cron.index', compact('server'));
  }
  public function uploadCron(Request $request)
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
      'limit_second.required'  => 'Trường thời gian giới hạn là bắt buộc.',
      'status.required'  => 'Trường trạng thái là bắt buộc.',
      'quantity.required'  => 'Trường số lượng là bắt buộc.',
      'ck.required'  => 'Trường % chiết khấu là bắt buộc.',
    ];
    $attributes = [
      'name' => 'Tên sản phẩm',
      'price'    => 'Giá sản phẩm',
      'quantity' => 'Số lượng',
      'limit_second' => 'Thời gian giới hạn',
      'status' => 'Trạng thái',
      'ck' => '% chiết khấu',
    ];
    $payload = $request->validate([
      'quantity' => 'required|numeric',
      'name' => 'required|string|max:255',
      'price' => 'required|numeric|min:0',
      'limit_second' => 'required|numeric|min:0',
      'status' => 'required',
      'ck' => 'required',

    ], $messages, $attributes);

    $server = SeverCron::create([
      'name' => $payload['name'],
      'price' => $payload['price'],
      'limit_second' => $payload['limit_second'],
      'quantity' => $payload['quantity'],
      'status' => $payload['status'],
      'ck' => $payload['ck'],
    ]);
    Logs::create([
      'data'       => '0',
      'action'    => 'Đăng tải máy chủ cron' . $payload['name'] . 'với giá ' . number_format($payload['price']) . 'đ',
      'description' => 'Thực hiện hành động đăng máy chủ cron với địa chỉ ip' . request()->ip(),
      'old_data' => 0,
      'new_data' => 0,
      'user_id'    => $user->id,
      'ip' => request()->ip(),
      'data_json' => '',
    ]);
    $content = "┏━━━━━━━━━━━━━━━┓\n";
    $content .= "┣➤ ".$user->name."\n";
    $content .= "┣➤ Máy chủ cron : ".$payload['name']."\n";
    $content .= "┣➤ Giá: ".number_format($payload['price'])."đ\n";
    $content .= "┣➤ Chiết Khấu: ".($payload['ck'])."%\n";
    $content .= "┣➤ máy chủ đã được đăng tải\n";
    $content .= "┗━━━━━━━━━━━━━━━┛\n";
    Helper::sendMessageTelegramAuto($content);
     if ($server) {
      return redirect()->back()->with('success', 'Thêm máy chủ cron thành công');
     } else {
      return redirect()->back()->with('error', 'Không thể tạo máy chủ cron, hãy thử lại!');
     }
  }
  public function UpdateServerCron(Request $request)
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
        'limit_second.required'  => 'Trường thời gian giới hạn là bắt buộc.',
        'status.required'  => 'Trường trạng thái là bắt buộc.',
        'quantity.required'  => 'Trường số lượng là bắt buộc.',
        'ck.required'  => 'Trường % chiết khấu là bắt buộc.',
      ];
      $attributes = [
        'name' => 'Tên sản phẩm',
        'price'    => 'Giá sản phẩm',
        'quantity' => 'Số lượng',
        'limit_second' => 'Thời gian giới hạn',
        'status' => 'Trạng thái',
        'ck' => '% chiết khấu',
      ];
      $payload = $request->validate([
        'id'          => 'required|integer',
        'quantity' => 'required|numeric',
        'name' => 'required|string|max:255',
        'price' => 'required|numeric|min:0',
        'limit_second' => 'required|numeric|min:0',
        'status' => 'required',
        'ck' => 'required',
  
      ], $messages, $attributes);
      
      $server = SeverCron::find($payload['id']);

      if (!$server) {
        return redirect()->route('admin.cron.index')->with('error', 'Không tìm thấy máy chủ cron #' . $payload['id']);
      }
      $server->update($payload);

      Logs::create([
        'data'       => '0',
        'action'    => 'Cập nhật máy chủ cron' . $payload['name'] . 'với giá ' . number_format($payload['price']) . 'đ',
        'description' => 'Thực hiện hành động cập nhật máy chủ cron với địa chỉ ip' . request()->ip(),
        'old_data' => 0,
        'new_data' => 0,
        'user_id'    => $user->id,
        'ip' => request()->ip(),
        'data_json' => '',
      ]);
      $content = "┏━━━━━━━━━━━━━━━┓\n";
      $content .= "┣➤ ".$user->name."\n";
      $content .= "┣➤ Máy chủ cron: ".$payload['name']."\n";
      $content .= "┣➤ giá: ".number_format($payload['price'])."đ\n";
      $content .= "┣➤ Chiết Khấu: ".($payload['ck'])."%\n";
      $content .= "┣➤ Hành động: cập nhật\n";
      $content .= "┗━━━━━━━━━━━━━━━┛\n";
      Helper::sendMessageTelegramAuto($content);
       
      return redirect()->back()->with('success', 'Cập nhật máy chủ cron thành công #' . $server->id);
  }
  public function deleteServer(Request $request)
  {

    if ($request->has('ids')) {
      $payload = $request->validate([
        'ids' => 'required|array',
      ]);

      $ids = array_map('intval', $payload['ids']);

      $server = SeverCron::whereIn('id', $ids)->get();

      foreach ($server as $servers) {
        $servers->delete();
      }

      Helper::addLogs(__('Thực hiện thao tác xóa nhiều máy chủ cron cùng lúc; số lượng: :count', ['count' => $server->count()]));

      return response()->json([
        'status'  => 200,
        'message' => 'Server deleted successfully.',
      ]);
    }

    $payload = $request->validate([
      'id' => 'required|integer',
    ]);

    $serverz = SeverCron::where('id', $payload['id'])->firstOrFail();
    $serverz->delete();

    Helper::addLogs('Xóa máy chủ cron #' . $serverz->name);

    return response()->json([
      'status'  => 200,
      'message' => 'Server deleted successfully.',
    ]);
  }
  public function showlist(Request $request)
   {
    $order = CronOrder::get();
    $total = CronOrder::sum('price');
    $hethan = CronOrder::where('status', 'hethan')->get();
    return view('admin.cron.list', compact('order', 'total', 'hethan'));
   }
  public function deleteList(Request $request)
  {

    if ($request->has('ids')) {
      $payload = $request->validate([
        'ids' => 'required|array',
      ]);

      $ids = array_map('intval', $payload['ids']);

      $server = CronOrder::whereIn('id', $ids)->get();

      foreach ($server as $servers) {
        $servers->delete();
      }

      Helper::addLogs(__('Thực hiện thao tác xóa nhiều link cron cron cùng lúc; số lượng: :count', ['count' => $server->count()]));

      return response()->json([
        'status'  => 200,
        'message' => 'Link Cron deleted successfully.',
      ]);
    }

    $payload = $request->validate([
      'id' => 'required|integer',
    ]);

    $serverz = CronOrder::where('id', $payload['id'])->firstOrFail();
    $serverz->delete();

    Helper::addLogs('Xóa link cron #' . $serverz->id);

    return response()->json([
      'status'  => 200,
      'message' => 'Link Cron deleted successfully.',
    ]);
   }
  public function action(Request $request)
   {
     $payload = $request->validate([
       'action' => 'required|in:activeCron,pauseCron',
       'id' => 'required|exists:list_url_cron,id',
     ]);
     $order = CronOrder::find($payload['id']);
     if (!$order) {
       return response()->json([
         'status'  => 404,
         'message' => 'Không tìm thấy link cron.',
       ], 404);
     }
     if ($payload['action'] == 'activeCron') {
       $order->response = '';
       $order->status = 'hoatdong';
       $order->save();
       return response()->json([
         'status'  => 200,
         'message' => 'Khởi chạy thành công.',
       ], 200);
     }
     if ($payload['action'] == 'pauseCron') {
      if ($order->status == 'hethan') {
        return response()->json([
          'status'  => 500,
          'message' => 'Link này đã hết hạn ko thể tạm dừng.',
        ], 500);
      }
       $order->response = 'Đang dừng xe';
       $order->status = 'tamdung';
       $order->save();
       return response()->json([
         'status'  => 200,
         'message' => 'Đã tạm dừng thành công.',
       ], 200);
     }
   }
   public function giahan(Request $request)
  {
    $payload = $request->validate([
      'action' => 'required',
      'id' => 'required|exists:list_url_cron,id',
      'month' => 'required',
    ]);
    $order = CronOrder::find($payload['id']);
    if (!$order) {
      return response()->json([
        'status'  => 404,
        'message' => 'Không tìm thấy link cron này.',
      ], 404);
    }
    if ($payload['month'] < 1) {
      return response()->json([
        'status'  => 404,
        'message' => 'Thời gian gia hạn không hợp lệ.',
      ], 404);
    }
    $time = $payload['month'];

    $id_server = $order->id_server;
    $user = User::find($order->user_id);
    $server = SeverCron::where('id', $id_server)->where('status', 1)->firstOrFail();
    if (!$server) {
      return response()->json([
        'status'  => 500,
        'message' => 'Có vẻ như máy chủ này không hoạt động hoặc không tồn tại trên hệ thống.',
      ], 500);
    }
    $tongtien = $server->price - ($server->price * ($server->ck / 100));
    $total = $time * $tongtien;
  if ($payload['action'] == 1) {
    if ($user->banned !== 0) {
      return response()->json([
        'status'  => 400,
        'message' => 'Tài khoản của ['.$user->username.'] đang bị khóa, vui lòng liên hệ admin để được hỗ trợ.',
      ], 400);
    }
    if ($user->balance < $total) {
      return response()->json([
        'status'  => 403,
        'message' => 'Tài khoản của ['.$user->username.'] không đủ để thực hiện thao tác này.',
      ], 403);
    }
    if ($user->decrement('balance', $total) === false) {
      return response()->json([
        'status'  => 500,
        'message' => 'Đã có lỗi trong quá trình thanh toán, vui lòng liên hệ admin.',
      ], 500);
    }
    Transaction::create([
      'code'           => $order->trans_id,
      'amount'         => $total,
      'balance_before' => $user->balance + $total,
      'balance_after'  => $user->balance,
      'type'           => 'new-order',
      'status'         => 'paid',
      'content'        => '[' . $server->name . '] ; mã số ' . $order->id . '; Thanh toán thành công cho người dùng ' . $user->username,
      'extras'         => [
        'id'         => $order->id,
        'order_code' => $order->trans_id,
      ],
      'user_id'        => $user->id,
      'username'       => $user->username,
      'order_id'       => $order->id,
    ]);
    }
    $timestamp = $order['expired_timestamp'];
    $time_set = $time * 2592000;
    $expired_timestamp = $timestamp + $time_set;
    $expired_date =  date("Y-m-d H:i:s", $expired_timestamp);
     

      $order->status = 'hoatdong';
      $order->expired_date = $expired_date;
      $order->expired_timestamp = $expired_timestamp;
      $order->save();

      Logs::create([
        'data'       => '0',
        'action'    => 'Thành toán gia hạn cron ' . $server->name . ' Giá tiền ' . number_format($total) . 'đ',
        'description' => 'Thực hiện hành động thanh toán gia hạn tên cron với địa chỉ ip' . request()->ip(),
        'old_data' => 0,
        'new_data' => 0,
        'user_id'    => $user->id,
        'ip' => request()->ip(),
        'data_json' => '',
      ]);
      return response()->json([
        'status'  => 200,
        'message' => 'Gia hạn link cron thành công.',
      ], 200);

  }
  public function showedit(Request $request, $id)
  {
    $order = CronOrder::where('id', $id)->firstOrFail();
    if (!$order) {
      return redirect()->route('admin.cron.list')->with('error', 'Link cron not found');
    }
    $server = SeverCron::where('status', 1)->get();
   
    return view('admin.cron.edit', [
      'pageTitle' => 'Chi tiết link cron #' . $order->trans_id,
    ], compact('order', 'server'));
  }
  public function update_edit(Request $request)
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
      $payload = $request->validate([
        'id'          => 'required|integer',
        'url' => 'required|string',
        'second' => 'required|numeric|min:1',
        'server' => 'required|numeric',
        'status' => 'required',
  
      ]);
      
      $order = CronOrder::find($payload['id']);

      if (!$order) {
        return redirect()->route('admin.cron.list')->with('error', 'Không tìm thấy link cron #' . $payload['id']);
      }
      $order->update($payload);

      Logs::create([
        'data'       => '0',
        'action'    => 'Cập nhật link cron #' . $order->trans_id . '',
        'description' => 'Thực hiện hành động cập nhật link cron với địa chỉ ip' . request()->ip(),
        'old_data' => 0,
        'new_data' => 0,
        'user_id'    => $user->id,
        'ip' => request()->ip(),
        'data_json' => '',
      ]);
       $content = "┏━━━━━━━━━━━━━━━┓\n";
      $content .= "┣➤ ".$user->name."\n";
      $content .= "┣➤ Cập nhật link cron: #".$order->trans_id."\n";
      $content .= "┣➤ Hành động: cập nhật link cron\n";
      $content .= "┗━━━━━━━━━━━━━━━┛\n";
      Helper::sendMessageTelegramAuto($content);
       
      return redirect()->back()->with('success', 'Cập nhật link cron thành công #' . $order->trans_id);
  }
}