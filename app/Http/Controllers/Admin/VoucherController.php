<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Voucher;
use App\Models\VoucherLog;
use App\Helpers\Helper;
use App\Models\User;
use Illuminate\Http\Request;

class VoucherController extends Controller
{
  public function index(Request $request)
  {
    $voucher = Voucher::get();

    return view('admin.voucher.index', compact('voucher'));
  }
  public function ShowhistoryModal(Request $request)
{
    $payload = $request->validate([
        'id' => 'required|exists:vouchers,id',
    ]);
    $voucher = Voucher::find($payload['id']);
    if (!$voucher) {
        return response()->json([
            'status'  => 404,
            'message' => 'Chúng tôi không thể tìm thấy mã giảm giá bạn yêu cầu.',
        ], 404);
    }

    $code = $voucher->code;
    $voucher_log = VoucherLog::where('code', $code)->get();

    $html = '
    <form
        action=""
        method="POST">
        <div class="modal-header">
            <h6 class="modal-title" id="staticBackdropLabel2">
                <i class="fa-solid fa-clock-rotate-left"></i> Nhật ký sử dụng mã giảm giá
                <span class="text-primary">' . htmlspecialchars($code) . '</span>
            </h6>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <table id="datatable-basic" class="table text-nowrap table-striped table-hover table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Username</th>
                        <th>Mã giảm giá</th>
                        <th>Giảm</th>
                        <th>Thời gian</th>
                    </tr>
                </thead>
                <tbody>';
    
    foreach ($voucher_log as $index => $log) {
      $user = User::find($log->user_id);
        $html .= '
                    <tr>
                        <td>' . ($index + 1) . '</td>
                        <td>
                            <a class="text-primary" href="/Cpanel/users/edit/' . $log->user_id . '">
                                ' . htmlspecialchars($user->username) . ' [ID ' . $log->user_id . ']
                            </a>
                        </td>
                        <td>' . htmlspecialchars($log->code) . '</td>
                         <td>' . htmlspecialchars($log->value) . '%</td>
                        <td>' . htmlspecialchars($log->created_at) . '</td>
                    </tr>';
    }

    $html .= '
                </tbody>
            </table>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">
                <i class="fa fa-fw fa-times me-1"></i> Close
            </button>
        </div>
    </form>
    <script>
        $("#datatable-basic").DataTable({
            language: {
                searchPlaceholder: "Search...",
                sSearch: "",
            },
            pageLength: 10
        });
    </script>';

    return response($html, 200)->header('Content-Type', 'text/html');
  }
  public function update(Request $request)
  {
    $payload = $request->validate([
      'id' => 'required|exists:vouchers,id',
      'code' => 'required',
      'value' => 'required',
      'qty' => 'required|numeric|min:1',
      'start_date' => 'required',
      'expire_date' => 'required',
    ]);
    $voucher = Voucher::find($payload['id']);
    if (!$voucher) {
      return response()->json([
        'status'  => 404,
        'message' => 'Chúng tôi không thể tìm thấy má giảm giá.',
      ], 404);
     }
      $voucher->code = $payload['code'];
      $voucher->value = $payload['value'];
      $voucher->qty = $payload['qty'];
      $voucher->start_date = $payload['start_date'];
      $voucher->expire_date = $payload['expire_date'];
      $khanh = $voucher->save();
   if ($khanh) {
    return redirect()->back()->with('success', 'Cập nhật mã giảm giá #' . $voucher->code . ' thành công');
   } else {
    return redirect()->back()->with('error', 'Cập nhật thất bại');
   }
  }
  public function upload(Request $request)
  {
    $user = auth()->user();
    $payload = $request->validate([
      'code' => 'required',
      'value' => 'required',
      'type' => 'required',
      'soluong' => 'required|numeric|min:1',
      'start_date' => 'required',
      'expire_date' => 'required',
    ]);
    $soluong = (int) $payload['soluong'];
    $khanh = Voucher::create([
      'code' => $payload['code'],
      'value' => $payload['value'],
      'type' => $payload['type'],
      'qty' => $soluong,
      'start_date' => $payload['start_date'],
      'username' => $user->username,
      'expire_date' => $payload['expire_date'],
    ]);
    Helper::addLogs('Tạo mã giảm giá thành công #' . $khanh->name);
    if ($khanh) {
      return redirect()->back()->with('success', 'Tạo mã giảm giá #' . $khanh->code . ' thành công');
    } else {
      return redirect()->back()->with('error', 'Tạo mã giảm giá thất bại');
    }
  }
  public function delete(Request $request)
  {
    $payload = $request->validate([
      'id' => 'required|exists:vouchers,id',
    ]);
    $voucher = Voucher::find($payload['id']);
    if ($voucher) {
      $voucher->delete();
      Helper::addLogs('Xóa mã giảm giá #' . $voucher->name);
     return response()->json([
      'status'  => 200,
      'message' => 'Voucher deleted successfully.',
     ]);
    } else {
      return response()->json([
        'status'  => 404,
        'message' => 'Voucher not found.',
      ], 404);
    }
  }
}
