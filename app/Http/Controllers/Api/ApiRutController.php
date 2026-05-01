<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\WithdrawCtv;
use App\Helpers\Helper;
class ApiRutController
{

    public function transferWebme($walletOrders, $description)
    {
        $dataPost = [
            'api_key'              => env('TOKEN_RUT'),
            'currency_code'        => 'VND',
            'bank_code'            => $walletOrders['bank'],
            'receive_account_number' => $walletOrders['stk'],
            'receive_account_name' => $walletOrders['ctk'],
            'amount'               => $walletOrders['price'],
            'description'          => $description,
        ];
    
        $response = Helper::curlPost(env('LINK_API_RUTTIEN') . '/api/client/withdraw', $dataPost);
        $result = json_decode($response, true);
    
        if ($result && isset($result['status']) && $result['status'] == 1) {
            $this->updateWalletOrders($walletOrders, $result, '1', 'Đang chuyển tiền');
            return 1;
        } else {
            $status = $result['status'] ?? 404;
            $message = $result['message'] ?? 'Lỗi không xác định';
    
            // Lưu lại trạng thái và thông báo lỗi từ API
            $this->updateWalletOrders($walletOrders, $result, '3', $message, true);
    
            return $this->checkStatusApiWebme($status, $message);
        }
    }
    private function updateWalletOrders($walletOrders, $result, $status, $errorMessage = null)
   {
    $updateData = [
        'status'    => $status,
        'message'   => $this->checkStatusApiWebme($result['status'] ?? 0, $result['message'] ?? $errorMessage ?? 'Lỗi không xác định'),
        'trans_id'  => $result['data']['order_code'] ?? '',
    ];
    WithdrawCtv::where('id', $walletOrders['id'])->update($updateData);
    }
    public function historyWebme($token, $orderCode)
    {
        $dataPost = [
            'api_key'   => $token,
            'order_code' => $orderCode,
        ];

        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->post(env('LINK_API_RUTTIEN') . '/api/client/get_order', $dataPost);

            return $response->json();
        } catch (\Exception $e) {
            Log::error('History Webme Error: ' . $e->getMessage());
            return null;
        }
    }

    public function getHistoryMomo($token)
    {
        // Implement the logic as needed
        return 0;
    }

    public function balanceMomo($token)
    {
        // Implement the logic as needed
        return 0;
    }

    public function listBank()
    {
        $dataPost = [
            'api_key' => '',
        ];

        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->post(env('LINK_API_RUTTIEN') . '/api/client/withdraw_banks', $dataPost);

            return $response->json();
        } catch (\Exception $e) {
            Log::error('List Bank Error: ' . $e->getMessage());
            return null;
        }
    }

    private function checkStatusApiWebme($status, $message)
    {
        // Implement your logic to check status and message
        return $message;
    }
}