<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Voucher;
use App\Models\Product;
use App\Models\HostingPackages;
use Illuminate\Http\Request;

class VoucherController extends Controller
{
    public function redeem(Request $request)
    {
        if (env('PRJ_DEMO_MODE', false) === true) {
            return response()->json([
              'status'  => 500,
              'message' => 'Chức năng này không hoạt động trong chế độ demo.',
          ], 500);
          }
        $payload = $request->validate([
            'code' => '',
            'id' => 'required|exists:tbl_list_code,id',
            'access_token' => 'required|exists:users,access_token',
        ]);
        $product = Product::findOrFail($payload['id']);
        
        if (empty($payload['code'])) {
            return response()->json([
                'status'  => 200,
                'message' => '' . number_format($product->price) . '₫',
            ], 200);
        }

        $voucher = Voucher::where('code', $payload['code'])->where('type', 'code')->first();

        if (!$voucher) {
            return response()->json([
                'status'  => 200,
                'message' => '' . number_format($product->price) . '₫',
            ], 200);
        }
        $user = User::where('access_token', $payload['access_token'])->first();
        if (!$user) {
            return response()->json([
                'status'  => 401,
                'message' => 'Bạn cần phải đăng nhập để sử dụng tính năng này.',
            ], 401);
        }
        $code = $payload['code'];

        $voucher = Voucher::where('code', $code)->where('type', 'code')->first();

        if (now()->greaterThan($voucher->expire_date)) {
            return response()->json([
                'status'  => 400,
                'message' => 'Mã quà tặng này đã hết hạn sử dụng.',
            ], 400);
        }

        $value = $product->price - ($product->price * $voucher->value / 100);

        $exists = Voucher::where('code', $code)->where('qty', 0)->where('type', 'code')->first();
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
            'message' => '' . number_format($value) . '₫',
        ], 200);
    }
    public function voucherhosting(Request $request)
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
          ];
          $attributes = [
            'time' => 'Thời hạn',
            'code'    => 'Mã giảm giá',
            'id' => 'ID tên miền',
          ]; 
        $payload = $request->validate([
            'time' => 'required',
            'code' => 'required|string',
            'id' => 'required',
        ], $messages, $attributes);

        $packages = HostingPackages::findOrFail($payload['id']);
        $voucher = Voucher::where('code', $payload['code'])->first();
        if (!$voucher) {
            return response()->json([
                'status'  => 401,
                'message' => 'Mã giảm giá không tồn tại',
            ], 401);
        }
        if ($voucher->type != 'hosting') {
            return response()->json([
                'status'  => 401,
                'message' => 'Mã giảm giá này không được áp dụng cho thanh toán hosting',
            ], 401);
        }
        
        $user = User::find(auth()->user()->id);
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
        $value = $time * ($packages->price - ($packages->price * ($voucher->value / 100)));

        $exists = Voucher::where('code', $code)->where('qty', 0)->where('type', 'hosting')->first();
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
            'value' => number_format($value).'đ',
        ], 200);
    }

    public function aivoucher(Request $request)
    {
        if (env('PRJ_DEMO_MODE', false) === true) {
            return response()->json(['status' => 500, 'message' => 'Chức năng này không hoạt động trong chế độ demo.'], 500);
        }
        $payload = $request->validate([
            'variant_id'   => 'required|integer',
            'code'         => 'nullable|string',
            'access_token' => 'required|exists:users,access_token',
        ]);

        $variant = \Illuminate\Support\Facades\DB::table('ai_accounts_variant')->where('id', $payload['variant_id'])->first();
        if (!$variant) {
            return response()->json(['status' => 404, 'message' => 'Không tìm thấy gói AI.'], 404);
        }

        $price = (float) $variant->price;
        if (empty($payload['code'])) {
            return response()->json(['status' => 200, 'message' => number_format($price) . '₫'], 200);
        }

        $voucher = Voucher::where('code', $payload['code'])->where('type', 'ai')->first();
        if (!$voucher) {
            return response()->json(['status' => 200, 'message' => number_format($price) . '₫'], 200);
        }

        if (now()->greaterThan($voucher->expire_date)) {
            return response()->json(['status' => 400, 'message' => 'Mã giảm giá này đã hết hạn.'], 400);
        }
        if ($voucher->qty <= 0) {
            return response()->json(['status' => 400, 'message' => 'Mã giảm giá này đã hết lượt dùng.'], 400);
        }

        $discountedPrice = $price - ($price * $voucher->value / 100);

        return response()->json([
            'status'  => 200,
            'message' => number_format($discountedPrice) . '₫',
        ], 200);
    }
}
