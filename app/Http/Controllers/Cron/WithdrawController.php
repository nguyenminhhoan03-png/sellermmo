<?php

namespace App\Http\Controllers\Cron;

use App\Http\Controllers\Controller;
use App\Helpers\Helper;
use App\Models\User;
use App\Models\WithdrawCtv;
use App\Http\Controllers\Api\ApiRutController;

class WithdrawController extends Controller
{
    public function handle()
    {  
        $token = env('TOKEN_RUT'); 
        $withdraws = WithdrawCtv::where('status', 0)->get();
        if (!$withdraws) {
            return response()->json(['message' => 'Không có đơn rút tiền'], 404);
        }
        foreach ($withdraws as $key => $value) {
            $user = User::find($value->user_id);
            $controller = new ApiRutController();
            $response = $controller->historyWebme($token, $value->trans_id);
            if ($response['status'] == 404) {
                return response()->json(['message' => $response['message']], 404);
            }
            if($response['status'] == 1)
            {
            if($response['data']['status'] == 'completed')
             {   
                   $value->status = 2;
                   $value->message = 'Chuyển tiền thành công';
                   $value->save();

                continue;
            }
              else if( $response['data']['status'] == 'canceled' )
             {
                $user->increment('balance_ctv', $value->price);
                Helper::addLogs('Đơn rút tiền đã bị hủy '.$user->name.' đã hoàn lại với số tiền '.number_format($value->price).'đ');

                $value->status = 3;
                $value->message = 'Đơn rút bị hủy, có thể do sai stk, ngân hàng nhận bảo trì, hoặc do hạn mức(nếu là momo)... vui lòng báo admin hoặc kiểm tra thông tin và rút lại sau';
                $value->save();

               exit();
              }
             }
            }
        }
        
}
