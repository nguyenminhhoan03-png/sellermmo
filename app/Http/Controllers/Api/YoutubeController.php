<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\Helper;

class YoutubeController extends Controller
{
    public function youtube(Request $request)
    {
        $url = $request->query('url');
        if (!$url) {
            return response()->json(['error' => 'Bạn đang thiếu URL'], 400);
        }
        $url = trim($url);
        $apiUrl = "https://ytdown.io/proxy.php";

        try {
            $response = Helper::curlPost($apiUrl, ['url' => $url]);
            if ($response === false) {
                return response()->json(['code' => 'error'], 500);
            }

            return response($response, 200)->header('Content-Type', 'application/json');
        } catch (\Exception $e) {
            return response()->json(['error' => 'Không thể kết nối đến API'], 500);
        }
    }


}
