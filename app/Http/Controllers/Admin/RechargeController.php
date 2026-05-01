<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Helpers\Helper;
use App\Models\BankAccount;
use App\Models\ApiLogo;
use App\Models\ApiConfig;
use App\Models\CardList;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class RechargeController extends Controller
{
    public function bank(Request $request)
    {
        $rechargebank = Transaction::where('extras->loai', 'bank')->get();
        
        $stats['bank']   = [
            'total_pay_full'            => Transaction::where('extras->loai', 'bank')->sum('amount'),
            'total_pay_month' => Transaction::where('extras->loai', 'bank')->whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'))->sum('amount'),
            'total_pay_week'    => Transaction::where('extras->loai', 'bank')->whereBetween('created_at', [date('Y-m-d', strtotime('last monday')), date('Y-m-d', strtotime('next sunday'))])->sum('amount'),
            'total_pay_payment' => Transaction::where('extras->loai', 'bank')->whereDate('created_at', date('Y-m-d'))->sum('amount'),
            
        ];
          $stats['t_bank'] = [
            'total_pay_week'    => [
              'label' => __('Tổng tiền trong tuần'),
              'color' => 'warning',
              'format' => 'currency',
            ],
            'total_pay_month'   => [
              'label' => __('Tổng tiền tháng :month', ['month' => date('m/Y')]),
              'color' => 'info',
              'format' => 'currency',
            ],
            'total_pay_payment' => [
              'label'  => __('Tổng tiền :day', ['day' => date('d/m/Y')]),
              'color'  => 'success',
              'format' => 'currency',
            ],
            'total_pay_full' => [
              'label'  => __('Tổng thanh toán'),
              'color'  => 'danger',
              'format' => 'currency',
            ],
          ];  
          $chartCategories = [];
          for ($i = 1; $i <= date('d'); $i++) {
            $chartCategories[] = date('Y-m-d', strtotime(date('Y-m') . '-' . $i));
          }
          $chartDeposit = [];
      
          foreach ($chartCategories as $chartCategory) {
            $chartDeposit[]   = Transaction::where('extras->loai', 'bank')->whereDate('created_at', $chartCategory)->sum('amount');
          }
        return view('admin.recharge.bank', compact('rechargebank', 'stats', 'chartCategories', 'chartDeposit'));
    }
    public function configBank()
    {
        $bankaccount = BankAccount::get();
        $logo = ApiLogo::get();
        return view('admin.recharge.config', compact('bankaccount', 'logo'));
    }
    public function updateBank(Request $request)
  {
    
    $payload = $request->validate([
      'id'     => 'required|integer',
      'status' => 'required|boolean',
    ]);

    $product = BankAccount::where('id', $payload['id'])->firstOrFail();

    $product->update([
      'status' => $payload['status'],
    ]);

    return response()->json([
      'status'  => 200,
      'message' => 'BankAccount status updated successfully.',
    ]);
    }
    public function deleteBank(Request $request)
  {

    if ($request->has('ids')) {
      $payload = $request->validate([
        'ids' => 'required|array',
      ]);

      $ids = array_map('intval', $payload['ids']);

      $bank = BankAccount::whereIn('id', $ids)->get();

      foreach ($bank as $banks) {
        $banks->delete();
      }

      Helper::addLogs(__('Thực hiện thao tác xóa nhiều ngân hàng cùng lúc; số lượng: :count', ['count' => $bank->count()]));

      return response()->json([
        'status'  => 200,
        'message' => 'BankAccount deleted successfully.',
      ]);
    }

    $payload = $request->validate([
      'id' => 'required|integer',
    ]);

    $bank = BankAccount::where('id', $payload['id'])->firstOrFail();
    $bank->delete();

    Helper::addLogs('Xóa ngân hàng thành công #' . $bank->name);

    return response()->json([
      'status'  => 200,
      'message' => 'BankAccount deleted successfully.',
    ]);
    }
    public function storeBank(Request $request)
  {
    $payload = $request->validate([
      'name'   => 'required|string',
      'owner'  => 'required|string',
      'number' => 'required|string',
      'status' => 'nullable|in:0,1',
    ]);

    BankAccount::create($payload);

    Helper::addLogs('Thêm tài khoản ' . $payload['number'] . ', ngân hàng ' . $payload['name']);

    return redirect()->back()->with('success', 'Thêm tài khoản ngân hàng thành công.');
    }
    public function card(Request $request)
    {
      $apis = [];

    foreach (ApiConfig::get() as $item) {
      $apis[strtolower($item->name)] = $item->value;
    }
        $rechargecard = CardList::get();
        
        $stats['card']   = [
            'total_pay_full'            => Transaction::where('extras->loai', 'card')->sum('amount'),
            'total_pay_month' => Transaction::where('extras->loai', 'card')->whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'))->sum('amount'),
            'total_pay_week'    => Transaction::where('extras->loai', 'card')->whereBetween('created_at', [date('Y-m-d', strtotime('last monday')), date('Y-m-d', strtotime('next sunday'))])->sum('amount'),
            'total_pay_payment' => Transaction::where('extras->loai', 'card')->whereDate('created_at', date('Y-m-d'))->sum('amount'),
            
        ];
          $stats['t_card'] = [
            'total_pay_week'    => [
              'label' => __('Tổng tiền trong tuần'),
              'color' => 'warning',
              'format' => 'currency',
            ],
            'total_pay_month'   => [
              'label' => __('Tổng tiền tháng :month', ['month' => date('m/Y')]),
              'color' => 'info',
              'format' => 'currency',
            ],
            'total_pay_payment' => [
              'label'  => __('Tổng tiền :day', ['day' => date('d/m/Y')]),
              'color'  => 'success',
              'format' => 'currency',
            ],
            'total_pay_full' => [
              'label'  => __('Tổng thanh toán'),
              'color'  => 'danger',
              'format' => 'currency',
            ],
          ];  
          $chartCategories = [];
          for ($i = 1; $i <= date('d'); $i++) {
            $chartCategories[] = date('Y-m-d', strtotime(date('Y-m') . '-' . $i));
          }
          $chartDeposit = [];
      
          foreach ($chartCategories as $chartCategory) {
            $chartDeposit[]   = Transaction::where('extras->loai', 'card')->whereDate('created_at', $chartCategory)->sum('amount');
          }
        return view('admin.recharge.card', $apis, compact('rechargecard', 'stats', 'chartCategories', 'chartDeposit'));
    }
    public function updateCard(Request $request)
  {
    $type  = $request->input('type', null);
    $value = [];

    if ($type === 'charging_card') {
      $value = $request->validate([
        'fees'        => 'nullable|array',
        'api_url'     => 'nullable|url|max:255',
        'partner_id'  => 'nullable|string|max:255',
        'partner_key' => 'nullable|string|max:255',
      ]);
    } else {
      return response()->json([
        'status'  => 400,
        'message' => 'API type not found.',
      ]);
    }

    $config = ApiConfig::firstOrCreate(['name' => $type], ['value' => []]);

    $config->update([
      'value' => $value,
    ]);

    Helper::addLogs("Cập nhật cài đặt API; Loại " . $type);

    return response()->json([
      'status'  => 200,
      'message' => 'Đã cập nhật thành công api ' . $type . '.',
    ]);
    }
    public function apibank()
    {
    $apis = [];

    foreach (ApiConfig::get() as $item) {
      $apis[strtolower($item->name)] = $item->value;
    }
    $url = env('LINK_API_NAP', 'https://thueapi.pro');
        $modifiedUrl = str_replace('https://', '', $url);
        $modifiedUrl = strtoupper($modifiedUrl);
    return view('admin.recharge.apibank', $apis, compact('modifiedUrl'));
    }
    public function updateApi(Request $request)
  {
    $type  = $request->input('type', null);
    $value = [];

    if (in_array($type, ['dvr_vietcombank', 'dvr_mbbank', 'dvr_acb', 'dvr_tpbank', 'dvr_bidv','dvr_tsr'])) {
      $value = $request->validate([
        'api_token'        => 'nullable|string|max:255',
      ]);
    }  elseif ($type === 'dvr_momo') {
      $value = $request->validate([
        'api_token' => 'nullable|string|max:255',
      ]);
    } else if ($type === 'telegram') {
      $value = $request->validate([
        'status'    => 'nullable|boolean',
        'chat_id'   => 'nullable|string',
        'bot_token' => 'nullable|string',
      ]);
    } else {
      return response()->json([
        'status'  => 400,
        'message' => 'API type not found.',
      ]);
    }
    $config = ApiConfig::firstOrCreate(['name' => $type], ['value' => []]);

    $config->update([
      'value' => $value,
    ]);

    Helper::addLogs("Cập nhật cài đặt API; Loại " . $type);

    return response()->json([
      'status'  => 200,
      'message' => 'Đã cập nhật thành công api ' . $type . '.',
    ]);
  }

}