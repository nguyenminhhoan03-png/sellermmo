<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TiktokController extends Controller
{
    public function getTikTok()
    {
        return view('fe.tiktok', [
           'pageTitle' => 'Tải video tiktok không logo cực nhanh chóng',
       ]);
    }
    public function getlinktiktok(Request $request)
    {
        $link = $request->query('link');
        if (!$link) {
            return response()->json(['error' => 'Bạn đang thiếu URL'], 400);
        }
        $link = trim($link);
        $apiUrl = "https://www.tikwm.com/api/?url={$link}";

        try {
            $response = @file_get_contents($apiUrl);
            if ($response === false) {
                return response()->json(['code' => 'error'], 500);
            }
            return response($response, 200)->header('Content-Type', 'application/json');
        } catch (\Exception $e) {
            return response()->json(['error' => 'Không thể kết nối đến API'], 500);
        }
    }


}
