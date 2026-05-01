<?php

namespace App\Http\Controllers\Cron;


use App\Http\Controllers\Controller;
use App\Libraries\BaseAPI;
use App\Events\PaymentSucceeded;
use App\Models\CardList;
use App\Models\Transaction;
use App\Models\User;
use App\Models\WalletLog;
use App\Helpers\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class DepositController extends Controller
{
    public function check(Request $request)
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
        } elseif ($type === 'card') {
            return $this->checkCard($request);
        }

        $info             = Helper::getConfig('deposit_info');
        $prefix           = $info['prefix'] ?? 'GCI';
        $discount         = (int) ($info['discount'] ?? 0);
        $min_amount       = (int) ($info['min_amount'] ?? 0);
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

            if (!str_contains(strtolower($transaction['description']), strtolower($prefix))) {
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
             

            $userId = Helper::parseOrderId($item['description'], $prefix);

            if ($userId === null || $userId === 0) {
                if ($show) {
                    echo 'Không tìm thấy user id trong giao dịch #' . $item['transactionID'] . ' / ' . $item['description'] . '<br />';
                }

                continue;
            }

            $user = User::find($userId);

            if ($user === null) {
                if ($show) {
                    echo 'Không tìm thấy user #' . $userId . ' trong giao dịch hệ thống [MySQL]<br />';
                }

                continue;
            }

            $code            = 'ATM-' . Helper::randomString(7, true);
            $realAmount      = (float) $item['amount'];
            $description     = $item['description'];
            $transactionID   = (string) $item['transactionID'];
            $transactionDate = $item['transactionDate'];

            $exists = $this->checkInvoice($transactionID);

            if ($exists !== null) {
                if ($show) {
                    echo 'Giao dịch #' . $transactionID . ' đã tồn tại trong hệ thống [MySQL]<br />';
                }

                continue;
            }

            $amount     = $realAmount;
            $onDiscount = false;


            if ($discount > 0 && $amount >= $min_amount) {
                $amount     = $amount + ($amount * $discount) / 100;
                $onDiscount = true;
            }
            
            $user->increment('balance', $amount);
            $user->increment('total_deposit', $amount);
            $channelName = $user->username;
            broadcast(new PaymentSucceeded(
                'Bạn đã nạp tiền ' . number_format($amount) . 'đ thành công!',
                $channelName
            ));
            if (is_string($item)) {
                $item = json_decode($item, true);
            }
            if (is_array($item)) {
                $item['bank'] = $type;
                $item['loai'] = 'bank';
                $itemJSON = $item;

            } else {
                return response()->json([
                    'status'  => 500,
                    'message' => 'dữ liệu từ api không hợp lệ',
                ], 500);
            }
            $user->transactions()->create([
                'code'           => $code,
                'amount'         => $amount,
                'real_amount'    => $realAmount,
                'order_id'       => (string) $transactionID,
                'balance_after'  => $user->balance,
                'balance_before' => $user->balance - $amount,
                'type'           => 'deposit',
                'extras'         => $itemJSON,
                'status'         => 'paid',
                'content'        => 'AUTO Deposit ' . strtoupper($type) . ' - ' . $transactionID . ' - Rev: ' . number_format($realAmount) . ' - Discount: ' . ($onDiscount ? $discount : 0) . '%',
                'user_id'        => $user->id,
                'username'       => $user->username,
            ]);

            $this->updateCommision($user->id, $realAmount);

            if ($show) {
                echo 'Giao dịch #' . $transactionID . ', số tiền ' . number_format($amount) . ' thành công<br />';
            }
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
            return 'Completed check transactions';
        }
    }
   

    private function checkCard(Request $request)
    {

        $config = Helper::getApiConfig('charging_card');

        if (!isset($config['api_url']) || !isset($config['partner_id']) || !isset($config['partner_key'])) {
            return response()->json([
                'status'  => 400,
                'message' => 'API Token is not set',
            ], 400);
        }

        $cards = CardList::where('status', 'Processing')->get();

        if (count($cards) === 0) {
            return response()->json([
                'status'  => 200,
                'message' => 'No cards found',
            ], 200);
        }

        foreach ($cards as $item) {
            $fees = $config['fees'][strtoupper($item->type)] ?? 20;

            $result = Http::post($config['api_url'] . '/chargingws/v2', [
                'telco'      => strtoupper($item->type),
                'code'       => $item->code,
                'serial'     => $item->serial,
                'amount'     => $item->amount,
                'request_id' => $item->request_id,
                'partner_id' => $config['partner_id'],
                'sign'       => md5($config['partner_key'] . $item->code . $item->serial),
                'command'    => 'check',
            ])->json();

            if (!isset($result['status'])) {
                continue;
            }

            switch ($result['status']) {
                case 1:
                    $client = User::find($item->user_id);
                    if ($client === null) {
                        echo '<span style="color: green">' . $item->id . '</span>/<span style="color: red">' . $item->serial . '</span> => KHÔNG TÌM THẤY USER';
                        break;
                    }

                    $amount = $result['declared_value'];

                    $real_amount = $amount - ($amount * $fees) / 100;

                    $code = 'CARD-' . Helper::randomString(6, true);

                    $client->increment('balance', $real_amount);
                    $client->increment('total_deposit', $real_amount);

                    $client->transactions()->create([
                        'code'           => $code,
                        'amount'         => $real_amount,
                        'balance_after'  => $client->balance,
                        'balance_before' => $client->balance - $real_amount,
                        'type'           => 'deposit',
                        'extras'         => [
                            'card_id' => $item->id,
                            'loai' => 'card',
                        ],
                        'status'         => 'paid',
                        'content'        => 'Nạp thẻ thành công #' . $item->serial . '; phí ' . $fees . '%',
                        'user_id'        => $client->id,
                        'username'       => $client->username,
                    ]);
                    $this->updateCommision($client->id, $real_amount);

                    $item->update([
                        'value'            => $amount,
                        'status'           => 'Completed',
                        'amount'           => $real_amount,
                        'content'          => $result['message'],
                        'transaction_code' => $code,
                    ]);

                    echo '<span style="color: green">ID: ' . $item->id . '</span>; <span style="color: red">' . $item->serial . '</span> => ' . ($result['message'] ?? 'Unknow error') . '<br />';
                    break;
                case 2:
                    $item->update([
                        'status'  => 'Cancelled',
                        'amount'  => 0,
                        'content' => $result['message'] ?? 'Unknow error',
                    ]);
                    echo 'ID: <span style="color: green">' . $item->id . '</span>; SERIAL: <span style="color: red">' . $item->serial . '</span> => ' . ($result['message'] ?? 'Unknow error') . '<br />';
                    break;
                case 3:
                    $item->update([
                        'status'  => 'Error',
                        'amount'  => 0,
                        'content' => $result['message'] ?? 'Unknow error',
                    ]);
                    echo 'ID: <span style="color: green">' . $item->id . '</span>; SERIAL: <span style="color: red">' . $item->serial . '</span> => ' . ($result['message'] ?? 'Unknow error') . '<br />';
                    break;
                case 4:
                    echo ' Hệ thống bảo trì';
                    break;
                case 99:
                    echo 'ID: <span style="color: green">' . $item->id . '</span>; SERIAL: <span style="color: red">' . $item->serial . '</span> => ' . ($result['message'] ?? 'Unknow error') . '<br />';
                    break;
                default:
                    echo '<span style="color: green">' . $item->id . '</span>/<span style="color: red">' . $item->serial . '</span> => ' . ($result['message'] ?? 'Unknow error') . '<br />';
                    break;
            }
        }
    }

    public function cardCallback(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'status'         => 'required|integer',
            'message'        => 'required|string',
            'request_id'     => 'required',
            'declared_value' => 'required|integer',
            'value'          => 'required|integer',
            'amount'         => 'required|integer',
            'code'           => 'required|string',
            'serial'         => 'required|string',
            'telco'          => 'required|string',
            'trans_id'       => 'required|integer',
            'callback_sign'  => 'required|string',
        ]);


        if ($validate->fails()) {
            return response()->json([
                'status'  => 400,
                'message' => 'Dữ liệu không hợp lệ',
            ], 400);
        }

        $payload = $request->all();

        $config = Helper::getApiConfig('charging_card');

        if (!isset($config['partner_key']) || !isset($config['fees'])) {
            return response()->json([
                'status'  => 400,
                'message' => 'API Token is not set',
            ], 400);
        }

        $fees = $config['fees'][$payload['telco']] ?? 20;

        $item = CardList::where('request_id', $payload['request_id'])
            ->where('order_id', $payload['trans_id'])
            ->where('status', 'Processing')
            ->first();

        if ($item === null) {
            return response()->json([
                'status'  => 400,
                'message' => 'Không tìm thấy giao dịch này',
            ], 400);
        }

        $sign = md5($config['partner_key'] . $payload['code'] . $payload['serial']);

        if ($sign !== $payload['callback_sign']) {
            return response()->json([
                'status'  => 400,
                'message' => 'Sai chữ ký',
            ], 400);
        }

        switch ($payload['status']) {
            case 1:
                $client = User::find($item->user_id);
                if ($client === null) {
                    return response()->json([
                        'status'  => 400,
                        'message' => 'Không tìm thấy user',
                    ], 400);
                }

                $amount = $payload['declared_value'];

                $real_amount = $amount - ($amount * $fees) / 100;

                $code = 'CARD-' . Helper::randomString(6, true);

                $client->increment('balance', $real_amount);
                $client->increment('total_deposit', $real_amount);

                $client->transactions()->create([
                    'code'           => $code,
                    'amount'         => $real_amount,
                    'balance_after'  => $client->balance,
                    'balance_before' => $client->balance - $real_amount,
                    'type'           => 'deposit',
                    'extras'         => [
                        'card_id' => $item->id,
                    ],
                    'status'         => 'paid',
                    'content'        => 'Nạp thẻ thành công #' . $item->serial . '; phí ' . $fees . '%',
                    'user_id'        => $client->id,
                    'username'       => $client->username,
                ]);

                $item->update([
                    'value'            => $amount,
                    'status'           => 'Completed',
                    'amount'           => $real_amount,
                    'content'          => $payload['message'],
                    'transaction_code' => $code,
                ]);
                $this->updateCommision($client->id, $real_amount);

                return response()->json([
                    'data'    => [
                        'code'    => $code,
                        'amount'  => $real_amount,
                        'balance' => $client->balance,
                    ],
                    'status'  => 200,
                    'message' => 'Nạp thẻ thành công',
                ], 200);
            case 2:
                $item->update([
                    'status'  => 'Cancelled',
                    'amount'  => 0,
                    'content' => $payload['message'] ?? 'Unknow error',
                ]);

                return response()->json([
                    'data'    => [
                        'id'     => $item->id,
                        'serial' => $item->serial,
                    ],
                    'status'  => 400,
                    'message' => $payload['message'] ?? 'Unknow error',
                ], 400);
            case 3:
                $item->update([
                    'status'  => 'Error',
                    'amount'  => 0,
                    'content' => $payload['message'] ?? 'Unknow error',
                ]);

                return response()->json([
                    'data'    => [
                        'id'     => $item->id,
                        'serial' => $item->serial,
                    ],
                    'status'  => 400,
                    'message' => $payload['message'] ?? 'Unknow error',
                ], 400);
            case 4:
                echo ' Hệ thống bảo trì';
                break;
            default:
                return response()->json([
                    'data'    => [
                        'id'     => $item->id,
                        'serial' => $item->serial,
                        'status' => $payload['status'],
                    ],
                    'status'  => 400,
                    'message' => $payload['message'] ?? 'Unknow error',
                ], 400);
        }
    }
    private function checkInvoice($transactionID)
    {
        return Transaction::where('order_id', $transactionID)->first();
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
