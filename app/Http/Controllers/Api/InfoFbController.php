<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class InfoFbController extends Controller
{
    public function getInfoFB()
    {
        return view('fe.fb', [
           'pageTitle' => 'Lấy UID FB siêu cấp vip pro mát',
       ]);

    }
    public function uidfb(Request $request)
    {
        $uidfb = $request->query('uidfb');
        if (!$uidfb) {
            return response()->json(['error' => 'Bạn đang thiếu UID'], 400);
        }
        $uidfb = trim($uidfb);
        $apiUrl = "https://api.subvip.top/tools/facebook/get-uid?link={$uidfb}";

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
