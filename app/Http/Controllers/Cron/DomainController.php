<?php

namespace App\Http\Controllers\Cron;

use App\Http\Controllers\Controller;
use App\Models\DomainOrder;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Logs;
use App\Models\Domain;
use App\Helpers\Helper;

class DomainController extends Controller
{
    public function handle()
    {
        $type = request()->get('type');

        if ($type == 'auto') {
            $domainOrders = DomainOrder::where('giahan', 1)->get();

            $updatedDomains = [];
            $failedDomains = [];
            $noExpiredDomains = true;

            foreach ($domainOrders as $domainOrder) {
                if ($domainOrder->expired_timestamp < time()) {

                    $user = User::find($domainOrder->user_id);
                    if (!$user) {
                        $failedDomains[] = $domainOrder->domain_name . ' - Không tìm thấy user.';
                        continue;
                    }

                    $parts = explode('.', $domainOrder->domain_name);
                    $name = end($parts);

                    $domain_check = Domain::where('name', $name)->first();
                    if (!$domain_check) {
                        $failedDomains[] = $domainOrder->domain_name . ' - Đuôi miền này hình như không được hỗ trợ gia hạn.';
                        continue;
                    }

                    $value = $domain_check->extend_price - ($domain_check->extend_price * $domain_check->ck / 100);

                    if ($user->balance < $value) {
                        $domainOrder->status = 3;
                        $domainOrder->save();
                        $failedDomains[] = $domainOrder->domain_name . ' - Không đủ số dư để gia hạn.';
                        Logs::create([
                            'data'       => '0',
                            'action'    => 'Tài khoản của bạn không đủ để hạn miền auto tên miền :' . $domainOrder->domain_name . ' ',
                            'description' => 'Không thể thực hiện gia hạn auto với địa chỉ ip' . request()->ip(),
                            'old_data' => 0,
                            'new_data' => 0,
                            'user_id'    => $user->id,
                            'ip' => request()->ip(),
                            'data_json' => '',
                          ]);
                        continue;
                    } else {
                        if ($user->decrement('balance', $value) === false) {
                            return response()->json([
                                'status'  => 400,
                                'message' => 'Tài khoản của bạn không thể giao dịch, vui lòng ib admin.',
                            ], 400);
                        }
                        $domainOrder->expired_timestamp = $domainOrder->expired_timestamp + 31536000;
                        $domainOrder->expired_date = date('Y-m-d', $domainOrder->expired_timestamp);
                        $domainOrder->status = 2;
                        $domainOrder->save();
                        $trans_id = Helper::random('QWERTYUIOPASDFGHJKZXCVBNM', 2) . time();
                        Transaction::create([
                            'code'           => $trans_id,
                            'amount'         => $value,
                            'balance_before' => $user->balance + $value,
                            'balance_after'  => $user->balance,
                            'type'           => 'new-order',
                            'status'         => 'paid',
                            'content'        => 'Tên Miền [' . $domainOrder->domain_name . '] ; Giá tiền ' . number_format($value) . 'đ; Thanh toán thành công auto cho người dùng ' . $user->username,
                            'extras'         => [
                                'id'         => $domainOrder->id,
                                'order_code' => $trans_id,
                            ],
                            'user_id'        => $user->id,
                            'username'       => $user->username,
                            'order_id'       => $domainOrder->id,
                        ]);
                        Logs::create([
                            'data'       => '0',
                            'action'    => 'Gia hạn miền auto ' . $domainOrder->domain_name . '',
                            'description' => 'Thực hiện hành động gia hạn miền auto phẩm với địa chỉ ip' . request()->ip(),
                            'old_data' => 0,
                            'new_data' => 0,
                            'user_id'    => $user->id,
                            'ip' => request()->ip(),
                            'data_json' => '',
                          ]);
                    }

                    $updatedDomains[] = $domainOrder->domain_name;
                    $noExpiredDomains = false;
                }
            }
            if (!$noExpiredDomains) {
                return response()->json([
                    'status'  => 200,
                    'message' => 'Miền đã được gia hạn: ' . implode(', ', $updatedDomains),
                ], 200);
            }

            if (count($failedDomains) > 0) {
                return response()->json([
                    'status'  => 400,
                    'message' => 'Lỗi gia hạn với các miền: ' . implode(', ', $failedDomains),
                ], 400);
            }

            return response()->json([
                'status'  => 400,
                'message' => 'Chưa có miền nào hết hạn.',
            ], 400);
        } elseif ($type == 'tay') {
            $expiredDomains = DomainOrder::where('giahan', 0)->get();

            $updatedDomains = [];
            $noExpiredDomains = true;

            foreach ($expiredDomains as $domain) {
                if ($domain->expired_timestamp < time() && $domain->status != 3) {
                    $domain->status = 3;
                    $domain->save();

                    $updatedDomains[] = $domain->domain_name;
                    $noExpiredDomains = false;
                }
            }
            if (!$noExpiredDomains) {
                return response()->json([
                    'status'  => 200,
                    'message' => 'Miền ' . implode(', ', $updatedDomains) . ' đã được cập nhật trạng thái.',
                ], 200);
            } else {
                return response()->json([
                    'status'  => 400,
                    'message' => 'Chưa có miền nào hết hạn.',
                ], 400);
            }
        } else {
            return response()->json([
                'status'  => 400,
                'message' => 'Tham số type không hợp lệ.',
            ], 400);
        }
    }
}
