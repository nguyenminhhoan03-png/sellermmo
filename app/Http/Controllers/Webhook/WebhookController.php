<?php

declare(strict_types=1);

namespace App\Http\Controllers\Webhook;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\TransferOrder;
use App\Models\Transaction;
use App\Helpers\Helper;
use App\Models\Product;
use App\Models\Domain;
use App\Models\DomainOrder;
use App\Models\Hisproduct;
use App\Models\AiAccountOrder;
use App\Models\Licenses;
use App\Models\Logs;
use App\Models\WalletLog;
use App\Events\PaymentSucceeded;
use App\Events\GlobalPurchaseEvent;
use Illuminate\Support\Facades\Mail;
use App\Mail\PaymentSuccessMail;
use Illuminate\Support\Facades\Log;

class WebhookController extends Controller
{
    public function sepay(Request $request)
    {
        // 1. Lấy token cấu hình webhook từ Sepay (nếu bạn có cài đặt API key trên SePay)
        // $sepayToken = $request->header('Authorization');
        // if ($sepayToken !== 'Bearer THAY_BANG_TOKEN_CUA_BAN_NEU_CAN') {
        //     return response()->json(['message' => 'Unauthorized'], 401);
        // }

        $amount = (float) $request->input('transferAmount');
        $content = strtoupper($request->input('content') ?? '');
        $transactionID = (string) $request->input('id'); 
        $type = $request->input('transferType'); // 'in' or 'out'
        
        if ($type !== 'in') {
            return response()->json(['success' => false, 'message' => 'Not an income transaction']);
        }

        // Lấy config prefix của hệ thống
        $infoDeposit = Helper::getConfig('deposit_info');
        $prefixTransfer = strtoupper($infoDeposit['transfer'] ?? 'THANHTOAN');
        $prefixDepositAcc  = strtoupper($infoDeposit['prefix'] ?? 'GCI');

        // ======================================================================
        // XỬ LÝ 1: THANH TOÁN ĐƠN HÀNG TRỰC TIẾP (TRANSFER ORDER - QUA MÃ THANHTOAN)
        // ======================================================================
        $id_tranfer = Helper::parseOrderId($content, $prefixTransfer);
        if ($id_tranfer && $id_tranfer > 0) {
            $tranfer = TransferOrder::find($id_tranfer);
            
            // Tìm thấy đơn hàng đang kẹt + số tiền chuyển >= hóa đơn -> Duyệt!
            if ($tranfer && $tranfer->status == 1 && $amount >= $tranfer->price) {
                
                // Tránh lỗi nạp đúp giao dịch
                if (TransferOrder::where('transactionID', $transactionID)->first()) {
                    return response()->json(['success' => true, 'message' => 'Duplicate transfer transaction']);
                }

                $tranfer->update([
                    'status' => 2,
                    'transactionID' => $transactionID,
                ]);

                $user = User::find($tranfer->user_id);
                
                // 1A) Xử lý khi mua mã nguồn (Code)
                if ($tranfer->content['type'] === 'code') {
                    $product = Product::find($tranfer->content['product_id']);
                    $license_key = md5($user->username . $product->id . time());
                    
                    Licenses::create([
                        'user_id' => $user->id,
                        'license_key' => $license_key,
                        'domain' => [],
                        'status' => 'active',
                        'cmt' => 'noti',
                        'expiry_date' => date('Y-m-d', time() + 31536000),
                    ]);
                    $trans_id = Helper::random('QWERTYUIOPASDFGHJKZXCVBNM', 2) . time();
                    Hisproduct::create([
                        'user_id' => $user->id,
                        'product_id' => $product->id,
                        'trans_id' => $trans_id,
                        'price' => $tranfer->price,
                    ]);
                    $product->increment('sold');
                    
                    Transaction::create([
                        'code'           => $trans_id,
                        'amount'         => $tranfer->price,
                        'balance_before' => $user->balance + $tranfer->price, // Hiển thị giả lập
                        'balance_after'  => $user->balance,
                        'type'           => 'new-order',
                        'status'         => 'paid',
                        'content'        => '[' . $product->name . '] ; mã số ' . $product->id . '; Thanh toán hóa đơn mượt qua SePay',
                        'extras'         => ['id' => $product->id, 'order_code' => $trans_id],
                        'user_id'        => $user->id,
                        'lickey'         => $license_key,
                        'username'       => $user->username,
                        'order_id'       => $product->id,
                    ]);
                    
                    Logs::create([
                        'data' => '0', 'old_data' => 0, 'new_data' => 0,
                        'action' => 'Thành toán chuyển khoản mã nguồn ' . $product->name . ' Mã số ' . $product->id,
                        'user_id' => $user->id, 'ip' => request()->ip(), 'data_json' => '',
                    ]);

                    try {
                        broadcast(new GlobalPurchaseEvent([
                            'userName' => $user->name,
                            'productName' => 'Mã nguồn: ' . $product->name,
                            'productPrice' => number_format($tranfer->price) . ' đ',
                            'location' => 'Việt Nam',
                            'time' => now()->toDateTimeString()
                        ]));
                    } catch (\Exception $e) { }

                    // Cộng tiền CTV nếu có
                    $user_ctv = User::where('id', $product->user_id)->first();
                    if ($user_ctv && $user_ctv->level == 2) {
                        $user_ctv->increment('balance_ctv', $tranfer->price);
                        $trans_id_code = Helper::random('QWERTYUIOPASDFGHJKZXCVBNM', 2) . time();
                        Transaction::create([
                            'code'           => $trans_id_code,
                            'amount'         => $tranfer->price,
                            'balance_before' => $user_ctv->balance + $tranfer->price,
                            'balance_after'  => $user_ctv->balance,
                            'type'           => 'new-order',
                            'status'         => 'paid',
                            'sys_note'       => 'ctv',
                            'content'        => '[' . $product->name . '] ; mã số ' . $product->id . '; Hoa hồngCTV',
                            'extras'         => ['id' => $product->id, 'order_code' => $trans_id_code],
                            'user_id'        => $user_ctv->id,
                            'lickey'         => $license_key,
                            'username'       => $user_ctv->username,
                            'order_id'       => $product->id,
                        ]);
                    }
                }
                // 1B1) Xử lý khi mua Tài Khoản AI (qua chuyển khoản)
                elseif ($tranfer->content['type'] === 'ai') {
                    $variantId  = $tranfer->content['variant_id'] ?? null;
                    $accountId  = $tranfer->content['account_id'] ?? null;
                    $variant    = \Illuminate\Support\Facades\DB::table('ai_accounts_variant')->where('id', $variantId)->first();

                    if ($variant) {
                        \Illuminate\Support\Facades\DB::table('ai_accounts_variant')->where('id', $variantId)->decrement('stock_quantity');
                        $expiry_date = $variant->duration_days ? now()->addDays((int) $variant->duration_days) : null;
                        $trans_id    = Helper::random('QWERTYUIOPASDFGHJKZXCVBNM', 2) . time();

                        AiAccountOrder::create([
                            'user_id'       => $user->id,
                            'ai_account_id' => $accountId,
                            'variant_id'    => $variantId,
                            'trans_id'      => $trans_id,
                            'price'         => $tranfer->price,
                            'status'        => 'paid',
                            'note'          => $variant->variant_name ?? '',
                            'expiry_date'   => $expiry_date,
                        ]);

                        Transaction::create([
                            'code'           => $trans_id,
                            'amount'         => $tranfer->price,
                            'balance_before' => $user->balance,
                            'balance_after'  => $user->balance,
                            'type'           => 'new-order',
                            'status'         => 'paid',
                            'content'        => '[AI] ' . ($variant->variant_name ?? '') . ' ; Thanh toán qua SePay cho ' . $user->username,
                            'extras'         => ['account_id' => $accountId, 'variant_id' => $variantId, 'order_code' => $trans_id],
                            'user_id'        => $user->id,
                            'username'       => $user->username,
                            'order_id'       => $accountId,
                        ]);

                        Logs::create([
                            'data' => '0', 'old_data' => 0, 'new_data' => 0,
                            'action'      => 'Thanh toán chuyển khoản AI: ' . ($variant->variant_name ?? ''),
                            'description' => 'Webhook SePay ip: ' . request()->ip(),
                            'user_id'     => $user->id, 'ip' => request()->ip(), 'data_json' => '',
                        ]);

                        $aiAccount = \App\Models\AiAccount::find($accountId);
                        try {
                            broadcast(new GlobalPurchaseEvent([
                                'userName'     => $user->name,
                                'productName'  => 'Tài khoản AI: ' . ($aiAccount->name ?? '') . ($variant->variant_name ? ' – ' . $variant->variant_name : ''),
                                'productPrice' => number_format($tranfer->price) . ' đ',
                                'location'     => 'Việt Nam',
                                'time'         => now()->toDateTimeString(),
                            ]));
                        } catch (\Exception $e) { }
                    }
                }
                // 1B2) Xử lý khi mua Tên Miền (Domain)
                elseif ($tranfer->content['type'] === 'domain') {
                    $domain = Domain::find($tranfer->content['domain_id']);
                    $trans_id = Helper::random('QWERTYUIOPASDFGHJKZXCVBNM', 2) . time();
                    $time_set = $tranfer->content['time'] * 31536000;
                    $time_ex = time() + $time_set;
                    $expired_date =  date("Y-m-d H:i:s", $time_ex);
                    
                    DomainOrder::create([
                        'trans_id' => $trans_id, 'user_id' => $user->id,
                        'domain_name' => $tranfer->content['domain'],
                        'ns' => $tranfer->content['ns'], 'price' => $tranfer->price,
                        'time_han' => $tranfer->content['time'], 'expired_date' => $expired_date,
                        'expired_timestamp' => $time_ex, 'status' => '1',
                    ]);
                    
                    Transaction::create([
                        'code'           => $trans_id, 'amount' => $tranfer->price,
                        'balance_before' => $user->balance + $tranfer->price, 'balance_after' => $user->balance,
                        'type'           => 'new-order', 'status' => 'paid',
                        'content'        => 'Tên miền [' . $tranfer->content['domain'] . '] ; Giá: ' . number_format($tranfer->price) . 'đ; Auto SePay',
                        'extras'         => ['id' => $domain->id, 'order_code' => $trans_id],
                        'user_id'        => $user->id, 'username' => $user->username, 'order_id' => $domain->id,
                    ]);
                    
                    try {
                        broadcast(new GlobalPurchaseEvent([
                            'userName' => $user->name,
                            'productName' => 'Tên miền: ' . $tranfer->content['domain'],
                            'productPrice' => number_format($tranfer->price) . ' đ',
                            'location' => 'Việt Nam',
                            'time' => now()->toDateTimeString()
                        ]));
                    } catch (\Exception $e) { }
                    
                    $msg = "🎉 ĐƠN HÀNG TÊN MIỀN (SEPAY)!\n🔖 Mã đơn hàng: " . $trans_id . "\n📦 Dịch vụ: ID " . $domain->id . " - " . $trans_id . "\n🔢 Thời Hạn: " . $tranfer->content['time'] . " năm\n💰 Thanh toán: " . number_format($tranfer->price) . "đ\n👤 Khách: " . $user->username . "\n";
                    try { Helper::sendMessageTelegramAuto($msg); } catch (\Exception $e) {}
                    try { Mail::to($user->email)->send(new PaymentSuccessMail($user, $tranfer->content['domain'], $tranfer->price, $tranfer->content['ck'], $tranfer->content['ns'], $domain->price)); } catch (\Exception $e) { }
                }

                $user->increment('total_deposit', $tranfer->price);
                return response()->json(['success' => true, 'message' => 'Processed Order Transfer']);
            }
        }

        // ======================================================================
        // XỬ LÝ 2: NẠP TIỀN SỐ DƯ TÀI KHOẢN (DEPOSIT - QUA MÃ GCI)
        // ======================================================================
        $userId = Helper::parseOrderId($content, $prefixDepositAcc);
        if ($userId && $userId > 0) {
            $user = User::find($userId);
            if ($user && $amount > 0) {
                
                // Tránh lỗi nạp đúp
                if (Transaction::where('order_id', $transactionID)->first()) {
                    return response()->json(['success' => true, 'message' => 'Duplicate deposit transaction']);
                }

                // Check Khuyến Mãi Nạp theo Cấu Hình
                $discount = (int) ($infoDeposit['discount'] ?? 0);
                $min_amount = (int) ($infoDeposit['min_amount'] ?? 0);
                $finalAmount = $amount;
                $onDiscount = false;
                if ($discount > 0 && $amount >= $min_amount) {
                    $finalAmount = $amount + ($amount * $discount) / 100;
                    $onDiscount = true;
                }

                // Thực thi cộng tiền cho người dùng
                $user->increment('balance', $finalAmount);
                $user->increment('total_deposit', $finalAmount);

                $code = 'SEPAY-' . Helper::randomString(7, true);
                $user->transactions()->create([
                    'code'           => $code, 'amount' => $finalAmount, 'real_amount' => $amount,
                    'order_id'       => $transactionID, 'balance_after' => $user->balance,
                    'balance_before' => $user->balance - $finalAmount, 'type' => 'deposit',
                    'extras'         => ['loai' => 'bank'], 'status' => 'paid',
                    'content'        => 'Auto Deposit SePay - ' . $transactionID . ' - Nhận: ' . number_format($amount) . ' - Bonus: ' . ($onDiscount ? $discount : 0) . '%',
                    'user_id'        => $user->id, 'username' => $user->username,
                ]);

                // Cộng hoa hồng đa cấp
                $this->updateCommision($user->id, $amount);

                // Bắn Trigger Laravel Echo Realtime lên góc màn hình trình duyệt (nếu đang bật Pusher)
                try {
                    broadcast(new PaymentSucceeded('Bạn đã nạp ' . number_format($finalAmount) . 'đ thành công!', $user->username));
                } catch (\Exception $e) { }

                return response()->json(['success' => true, 'message' => 'Processed Deposit Account']);
            }
        }

        return response()->json(['success' => false, 'message' => 'Not a valid pattern']);
    }

    // Hàm Phụ: Tính Hoa hồng hệ thống Affiliates
    private function updateCommision($userId, $amount)
    {
        $user = User::find($userId);
        if ($user === null || $user->referrer === null || $user->referrer->parent === null) return;

        $affliate = $user->referrer;
        $parent = $affliate->parent;

        $percent    = setting('comm_percent', 10);
        $commission = ($amount * $percent) / 100;

        $affliate->increment('total_deposit', $amount);
        $affliate->increment('total_commission', $commission);
        $parent->increment('balance_1', $commission);

        WalletLog::create([
            'type'           => 'commission', 'amount' => $commission, 'status' => 'Completed',
            'user_id'        => $parent->id, 'order_id' => 'COM-' . Helper::randomString(7, true),
            'username'       => $parent->username, 'sys_note' => $user->username,
            'user_note'      => 'Referral commission; Rev ' . $percent . '%', 'user_action' => 'increment',
            'ip_address'     => '127.0.0.1', 'balance_after' => $parent->balance_1, 'balance_before' => $parent->balance_1 - $commission
        ]);
    }
}