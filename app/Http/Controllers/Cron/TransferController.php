<?php

namespace App\Http\Controllers\Cron;

use App\Mail\PaymentSuccessMail;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use App\Models\DomainOrder;
use App\Models\Transaction;
use App\Models\Product;
use App\Models\Domain;
use App\Models\Hisproduct;
use App\Models\Licenses;
use App\Models\User;
use App\Models\Logs;
use App\Models\WalletLog;
use App\Helpers\Helper;
use App\Models\TransferOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;


class TransferController extends Controller
{
    public function transfer(Request $request)
    {

        if (Cache::has('cron_deposit')) {
            return response()->json([
                'status'  => 400,
                'message' => 'Please stop spamming, wait 30 seconds',
            ], 400);
        }
        Cache::put('cron_deposit', true, 1);

        $type             = $request->input('type', null);
        $show             = $request->input('show', true);
        $debug            = $request->input('debug', false);
        $debug_1          = $request->input('debug_1', false);
        $api_name         = null;
        $api_token        = null;
        $transactions     = [];

        if ($type === 'vietcombank') {
            $config = Helper::getApiConfig('dvr_' . $type);

            if (!isset($config['api_token'])) {
                return response()->json([
                    'status'  => 400,
                    'message' => 'API Token is not set',
                ], 400);
            }
            $api_name         = 'historyapivcbv2';
            $api_token        = $config['api_token'];
        } else if ($type === 'tpbank') {
            $config = Helper::getApiConfig('dvr_' . $type);

            if (!isset($config['api_token'])) {
                return response()->json([
                    'status'  => 400,
                    'message' => 'API Token is not set',
                ], 400);
            }
            $api_name         = 'historyapitpbv2';
            $api_token        = $config['api_token'];
        } elseif ($type === 'acb') {
            $config = Helper::getApiConfig('dvr_' . $type);

            if (!isset($config['api_token'])) {
                return response()->json([
                    'status'  => 400,
                    'message' => 'API Token is not set',
                ], 400);
            }
            $api_name         = 'historyapiacbv2';
            $api_token        = $config['api_token'];
        } elseif ($type === 'mbbank') {
            $config = Helper::getApiConfig('dvr_' . $type);

            if (!isset($config['api_token'])) {
                return response()->json([
                    'status'  => 400,
                    'message' => 'API Token is not set',
                ], 400);
            }
            $api_name         = 'historyapimbbankv2';
            $api_token        = $config['api_token'];
        } elseif ($type === 'tsr') {
            $config = Helper::getApiConfig('dvr_' . $type);

            if (!isset($config['api_token'])) {
                return response()->json([
                    'status'  => 400,
                    'message' => 'API Token is not set',
                ], 400);
            }
            $api_name         = 'historyapithesieurev2';
            $api_token        = $config['api_token'];
        } elseif ($type === 'bidv') {
            $config = Helper::getApiConfig('dvr_' . $type);

            if (!isset($config['api_token'])) {
                return response()->json([
                    'status'  => 400,
                    'message' => 'API Token is not set',
                ], 400);
            }
            $api_name         = 'historyapibidvv2';
            $api_token        = $config['api_token'];
        } elseif ($type === 'momo') {
            $config = Helper::getApiConfig('dvr_' . $type);

            if (!isset($config['api_token'])) {
                return response()->json([
                    'status'  => 400,
                    'message' => 'API Token is not set',
                ], 400);
            }
            $api_name  = 'historyapimomo';
            $api_token = $config['api_token'];
        }

        $info             = Helper::getConfig('deposit_info');
        $prz = $info['transfer'] ?? 'THANHTOAN';
        $list_transaction = [];

        if ($api_name === 'historyapimomo') {
            $linkmomo = env('LINK_API_NAP_MOMO');
            $response = Http::get($linkmomo . '/' . $api_token);

            if ($response->failed()) {
                return response()->json([
                    'data' => $response->json(),
                    'code' => $response->status(),
                ], 400);
            }

            $transactions = $response->json('momoMsg')['tranList'] ?? [];

            foreach ($transactions as $value) {
                $list_transaction[] = [
                    'type'            => 'IN',
                    'amount'          => $value['amount'],
                    'description'     => $value['comment'] ?? '',
                    'transactionID'   => $value['tranId'],
                    'transactionDate' => $value['clientTime'] ?? null,
                ];
            }
        } else {
            $linkApi = env('LINK_API_NAP');
            $response = Http::get("{$linkApi}/{$api_name}/{$api_token}");

            $transactions = $response->json('transactions') ?? [];

            foreach ($transactions as $value) {
                $list_transaction[] = [
                    'type'            => $value['type'],
                    'amount'          => $value['amount'],
                    'description'     => $value['description'],
                    'transactionID'   => $value['transactionID'],
                    'transactionDate' => $value['transactionDate'],
                ];
            }
        }

        foreach ($list_transaction as $key => $transaction) {
            if ($transaction['type'] !== 'IN') {
                unset($list_transaction[$key]);
                continue;
            }
        }

        if ($debug) {
            return response()->json([
                'data' => $response->json(),
                'code' => $response->status(),
            ], 200);
        }

        if ($debug_1) {
            return response()->json([
                'data' => $list_transaction,
                'code' => $response->status(),
            ], 200);
        }

        if (count($transactions) === 0) {
            return response()->json([
                'data'    => $response->json(),
                'status'  => 200,
                'message' => 'No transactions found #1',
            ], 200);
        }

        if (count($list_transaction) === 0) {
            return response()->json([
                'data'    => $show ? $response->json() : [],
                'status'  => 200,
                'message' => 'No transactions found #2',
            ], 200);
        }

        foreach ($list_transaction as $item) {
            $realAmount = (float) $item['amount'];
            $description = $item['description'];
            $transactionID = (string) $item['transactionID'];

            $id_tranfer = Helper::parseOrderId($item['description'], $prz);
            if ($id_tranfer === null || $id_tranfer === 0) {
                if ($show) {
                    echo 'Không tìm thấy id trong giao dịch #' . $item['transactionID'] . ' / ' . $item['description'] . '<br />';
                }
                continue;
            }
            $tranfer = TransferOrder::find($id_tranfer);
            if ($tranfer === null) {
                if ($show) {
                    echo 'Không tìm thấy giao dịch nào #' . $id_tranfer . ' trong giao dịch hệ thống [MySQL]<br />';
                }
                continue;
            }
            $exists = $this->checkTransfer($transactionID);

            if ($exists !== null) {
                if ($show) {
                    echo 'Giao dịch #' . $transactionID . ' đã tồn tại trong hệ thống [MySQL]<br />';
                }

                continue;
            }
            $khanhdz = $tranfer->update([
                'status' => 2,
                'transactionID' => $transactionID,
            ]);
            $user = User::find($tranfer->user_id);
            if ($khanhdz) {
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
                        'balance_before' => $user->balance + $tranfer->price,
                        'balance_after'  => $user->balance,
                        'type'           => 'new-order',
                        'status'         => 'paid',
                        'content'        => '[' . $product->name . '] ; mã số ' . $product->id . '; Thanh toán chuyển khoản thành công cho người dùng ' . $user->username,
                        'extras'         => [
                            'id'         => $product->id,
                            'order_code' => $trans_id,
                        ],
                        'user_id'        => $user->id,
                        'lickey' => $license_key,
                        'username'       => $user->username,
                        'order_id'       => $product->id,
                    ]);
                    $content = 'Thành toán chuyển khoản mã nguồn ' . $product->name . ' Mã số ' . $product->id;
                    Logs::create([
                        'data'       => '0',
                        'action'    => $content,
                        'description' => "Thực hiện hành động " . $content . " với địa chỉ ip" . request()->ip(),
                        'old_data' => 0,
                        'new_data' => 0,
                        'user_id'    => $user->id,
                        'ip' => request()->ip(),
                        'data_json' => '',
                    ]);

                    $user_ctv = User::where('id', $product->user_id)->first();
                    if ($user_ctv) {
                        if ($user_ctv->level == 2) {
                            $user_ctv->increment('balance_ctv', $tranfer->price);
                            $trans_id_code = Helper::random('QWERTYUIOPASDFGHJKZXCVBNM', 2) . time();
                            Transaction::create([
                                'code'           => $trans_id_code,
                                'amount'         => $tranfer->price,
                                'balance_before' => $user_ctv->balance + $tranfer->price,
                                'balance_after'  => $user_ctv->balance,
                                'type'           => 'new-order',
                                'status'         => 'paid',
                                'sys_note' => 'ctv',
                                'content'        => '[' . $product->name . '] ; mã số ' . $product->id . '; Cộng tiền cho người bán hàng ' . $user_ctv->username,
                                'extras'         => [
                                    'id'         => $product->id,
                                    'order_code' => $trans_id_code,
                                ],
                                'user_id'        => $user_ctv->id,
                                'lickey' => $license_key,
                                'username'       => $user_ctv->username,
                                'order_id'       => $product->id,
                            ]);
                            $content = 'Cộng tiền cho người bán hàng ' . $product->name . ' Mã số ' . $product->id;
                            Logs::create([
                                'data'       => '0',
                                'action'    => $content,
                                'description' => "Thực hiện hành động " . $content . " với địa chỉ ip" . request()->ip(),
                                'old_data' => 0,
                                'new_data' => 0,
                                'user_id'    => $user_ctv->id,
                                'ip' => request()->ip(),
                                'data_json' => '',
                            ]);
                        }
                    }
                } elseif ($tranfer->content['type'] === 'domain') {
                    $domain = Domain::find($tranfer->content['domain_id']);
                    $trans_id = Helper::random('QWERTYUIOPASDFGHJKZXCVBNM', 2) . time();
                    $time_set = $tranfer->content['time'] * 31536000;
                    $time_ex = time() + $time_set;
                    $expired_date =  date("Y-m-d H:i:s", $time_ex);
                    DomainOrder::create([
                        'trans_id' => $trans_id,
                        'user_id' => $user->id,
                        'domain_name' => $tranfer->content['domain'],
                        'ns' => $tranfer->content['ns'],
                        'price' => $tranfer->price,
                        'time_han' => $tranfer->content['time'],
                        'expired_date' => $expired_date,
                        'expired_timestamp' => $time_ex,
                        'status' => '1',
                    ]);
                    Transaction::create([
                        'code'           => $trans_id,
                        'amount'         => $tranfer->price,
                        'balance_before' => $user->balance + $tranfer->price,
                        'balance_after'  => $user->balance,
                        'type'           => 'new-order',
                        'status'         => 'paid',
                        'content'        => 'Tên miền [' . $tranfer->content['domain'] . '] ; Giá tiền ' . number_format($tranfer->price) . 'đ; Thanh toán thành chuyển khoản công cho người dùng ' . $user->username,
                        'extras'         => [
                            'id'         => $domain->id,
                            'order_code' => $trans_id,
                        ],
                        'user_id'        => $user->id,
                        'username'       => $user->username,
                        'order_id'       => $domain->id,
                    ]);

                    Logs::create([
                        'data'       => '0',
                        'action'    => 'Thành toán chuyển khoản Tên miền ' . $tranfer->content['domain'] . ' Giá tiền ' . number_format($tranfer->price) . 'đ',
                        'description' => 'Thực hiện hành động thanh toán chuyển khoản Tên miền với địa chỉ ip' . request()->ip(),
                        'old_data' => 0,
                        'new_data' => 0,
                        'user_id'    => $user->id,
                        'ip' => request()->ip(),
                        'data_json' => '',
                    ]);

                    $content = "🎉 Đơn hàng mới được tạo thành công!\n\n";
                    $content .= "🔖 Mã đơn hàng: " . $trans_id . "\n";
                    $content .= "📦 Dịch vụ: ID " . $domain->id . " - " . $trans_id . "\n";
                    $content .= "🔢 Thời Hạn: " . $tranfer->content['time'] . " năm\n";
                    $content .= "💰 Tổng thanh toán: " . number_format($tranfer->price, 0, ',', '.') . "đ\n";
                    $content .= "🕒 Thời gian: " . date('d/m/Y H:i:s') . "\n";
                    $content .= "👤 Người dùng: " . $user->username . "\n\n";
                    $content .= "Thông báo gửi đến admin để duyệt đơn hàng\n";
                    $content .= "\n\n";

                    Helper::sendMessageTelegramAuto($content);
                    $giagoc = $domain->price;
                    $ck = $tranfer->content['ck'];
                    Mail::to($user->email)->send(new PaymentSuccessMail($user, $tranfer->content['domain'], $tranfer->price, $ck, $tranfer->content['ns'],  $giagoc));
                }
                $user->increment('total_deposit', $tranfer->price);
                
                return response()->json([
                    'data'    => [
                        'data' => $khanhdz,
                    ],
                    'status'  => 200,
                    'message' => 'Cập nhật hóa đơn thành công',
                ], 200);
            }
            if ($show === false) {
                return response()->json([
                    'data'    => [
                        'total_valid' => count($list_transaction),
                    ],
                    'status'  => 200,
                    'message' => 'Completed check transactions',
                ], 200);
            } else {
                return 'Không có giao dịch nào cả';
            }
        }
    }

    private function checkTransfer($transactionID)
    {
        return TransferOrder::where('transactionID', $transactionID)->first();
    }
    private static function updateCommision($userId, $amount)
    {
        $user = User::find($userId);

        if ($user === null) {
            return;
        }

        $affliate = $user->referrer;

        if ($affliate === null) {
            return;
        }

        $parent = $affliate->parent;

        if ($parent === null) {
            return;
        }

        $percent    = setting('comm_percent', 10);
        $commission = ($amount * $percent) / 100;

        $affliate->increment('total_deposit', $amount);
        $affliate->increment('total_commission', $commission);

        $parent->increment('balance_1', $commission);

        $log = WalletLog::create([
            'type'           => 'commission',
            'amount'         => $commission,
            'status'         => 'Completed',
            'user_id'        => $parent->id,
            'order_id'       => 'COM-' . Helper::randomString(7, true),
            'username'       => $parent->username,
            'sys_note'       => $user->username,
            'user_note'      => 'Referral commission; Rev ' . $percent . '%',
            'user_action'    => 'increment',
            'ip_address'     => '127.0.0.1',
            'balance_after'  => $parent->balance_1,
            'balance_before' => $parent->balance_1 - $commission
        ]);

        return $log;
    }
}
