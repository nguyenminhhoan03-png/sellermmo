<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Voucher;
use App\Models\Domain;
use Illuminate\Http\Request;

class VoucherDomainController extends Controller
{
    public function voucherdomain(Request $request)
    {   
        if (env('PRJ_DEMO_MODE', false) === true) {
            return response()->json([
              'status'  => 500,
              'message' => 'Chức năng này không hoạt động trong chế độ demo.',
          ], 500);
          }
        $messages = [
            'time.required'  => 'Trường Thời hạn là bắt buộc.',
            'code.required'  => 'Trường mã giảm giá là bắt buộc.',
            'code.string'    => 'Trường mã giảm giá phải là một chuỗi.',
            'id.required'  => 'Trường id là bắt buộc.',
            'access_token.required'     => 'Trường access_token là bắt buộc.',
          ];
          $attributes = [
            'time' => 'Thời hạn',
            'code'    => 'Mã giảm giá',
            'id' => 'ID tên miền',
            'access_token' => 'Token',
          ]; 
        $payload = $request->validate([
            'time' => 'required',
            'code' => 'required|string',
            'id' => 'required',
            'access_token' => 'required',
        ], $messages, $attributes);

        $domain = Domain::findOrFail($payload['id']);
        $voucher = Voucher::where('code', $payload['code'])->first();
        if (!$voucher) {
            return response()->json([
                'status'  => 401,
                'message' => 'Mã giảm giá không tồn tại',
            ], 401);
        }
        if ($voucher->type != 'domain') {
            return response()->json([
                'status'  => 401,
                'message' => 'Mã giảm giá này không được áp dụng cho thanh toán tên miền',
            ], 401);
        }
        
        $user = User::where('access_token', $payload['access_token'])->first();
        if (!$user) {
            return response()->json([
                'status'  => 401,
                'message' => 'Bạn cần phải đăng nhập để sử dụng tính năng này.',
            ], 401);
        }
        $code = $payload['code'];
        $time = $payload['time'];
        if (now()->greaterThan($voucher->expire_date)) {
            return response()->json([
                'status'  => 400,
                'message' => 'Mã quà tặng này đã hết hạn sử dụng.',
            ], 400);
        }
        $value = $time * ($domain->price - ($domain->price * ($voucher->value + $domain->sale) / 100));
        $ck = $voucher->value + $domain->sale;
        $total = ($time * $domain->price) -  $value;

        $exists = Voucher::where('code', $code)->where('qty', 0)->where('type', 'domain')->first();
        if ($exists) {
            return response()->json([
                'status'  => 400,
                'message' => 'Mã quà tặng này đã hết lượt sử dụng.',
            ], 400);
        }
        if ($user->banned !== 0) {
            return response()->json([
                'status'  => 400,
                'message' => 'Tài khoản của bạn đang bị khóa, vui lòng liên hệ admin để được hỗ trợ.',
            ], 400);
        }

        return response()->json([
            'status'  => 200,
            'ck' => '' . ($ck) . '%',
            'reduce' => '' . number_format($total) . '₫',
            'remaining' => '' . number_format($value) . '₫',
        ], 200);
    }
    public function totalnam(Request $request)
    {
        $messages = [
            'time.required'  => 'Trường Thời hạn là bắt buộc.',
            'id.required'  => 'Trường id là bắt buộc.',
            'access_token.required'     => 'Trường access_token là bắt buộc.',
          ];
          $attributes = [
            'time' => 'Thời hạn',
            'code'    => 'Mã giảm giá',
            'id' => 'ID tên miền',
            'access_token' => 'Token',
          ]; 
        $payload = $request->validate([
            'time' => 'required',
            'code' => '',
            'id' => 'required',
            'access_token' => 'required',
        ], $messages, $attributes);

        $domain = Domain::findOrFail($payload['id']);

     if (!empty($payload['code'])) {
        $voucher = Voucher::where('code', $payload['code'])->first();
        if (!$voucher) {
            return response()->json([
                'status'  => 401,
                'message' => 'Mã giảm giá không tồn tại',
            ], 401);
        }
        if ($voucher->type != 'domain') {
            return response()->json([
                'status'  => 401,
                'message' => 'Mã giảm giá này không được áp dụng cho thanh toán tên miền',
            ], 401);
        }  
        $user = User::where('access_token', $payload['access_token'])->first();
        if (!$user) {
            return response()->json([
                'status'  => 401,
                'message' => 'Bạn cần phải đăng nhập để sử dụng tính năng này.',
            ], 401);
        }
        $code = $payload['code'];
        $time = $payload['time'];
        if (now()->greaterThan($voucher->expire_date)) {
            return response()->json([
                'status'  => 400,
                'message' => 'Mã quà tặng này đã hết hạn sử dụng.',
            ], 400);
        }
        $value = $time * ($domain->price - ($domain->price * ($voucher->value + $domain->sale) / 100));
        $ck = $voucher->value + $domain->sale;
        $total = ($time * $domain->price) -  $value;

        $exists = Voucher::where('code', $code)->where('qty', 0)->where('type', 'domain')->first();
        if ($exists) {
            return response()->json([
                'status'  => 400,
                'message' => 'Mã quà tặng này đã hết lượt sử dụng.',
            ], 400);
        }
        if ($user->banned !== 0) {
            return response()->json([
                'status'  => 400,
                'message' => 'Tài khoản của bạn đang bị khóa, vui lòng liên hệ admin để được hỗ trợ.',
            ], 400);
        }

        return response()->json([
            'status'  => 200,
            'ck' => '' . ($ck) . '%',
            'reduce' => '' . number_format($total) . '₫',
            'remaining' => '' . number_format($value) . '₫',
        ], 200);
    } else {

        $user = User::where('access_token', $payload['access_token'])->first();
        if (!$user) {
            return response()->json([
                'status'  => 401,
                'message' => 'Bạn cần phải đăng nhập để sử dụng tính năng này.',
            ], 401);
        }
        if ($user->banned !== 0) {
            return response()->json([
                'status'  => 400,
                'message' => 'Tài khoản của bạn đang bị khóa, vui lòng liên hệ admin để được hỗ trợ.',
            ], 400);
        }
        $time = $payload['time'];
        $value = $time * ($domain->price - ($domain->price * $domain->sale / 100));
        $ck =  $domain->sale;
        $total = ($time * $domain->price) - $value;

        return response()->json([
            'status'  => 200,
            'ck' => '' . ($ck) . '%',
            'reduce' => '' . number_format($total) . '₫',
            'remaining' => '' . number_format($value) . '₫',
        ], 200);
    }
  }
}
