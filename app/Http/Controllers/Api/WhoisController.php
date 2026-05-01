<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WhoisController extends Controller
{
    public function checkDomain(Request $request)
    {
        $domain = $request->query('domain');
        if (!$domain) {
            return response()->json(['error' => 'Tên miền không hợp lệ'], 400);
        }

        $domain = trim($domain);
        $apiUrl = "https://whois.inet.vn/api/whois/domainspecify/{$domain}";

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
    public function whoisdomain($domain)
{
    if (!$domain) {
        return response()->json(['error' => 'Tên miền không hợp lệ'], 400);
    }

    $domain = trim($domain);
    $apiUrl = "https://whois.inet.vn/api/whois/domainspecify/{$domain}";

    try {
        $response = @file_get_contents($apiUrl);
        if ($response === false) {
            return response()->json(['code' => 'error'], 500);
        }
        $data = json_decode($response, true);
        if (isset($data['code'])) {
            return response()->json(['code' => $data['code']], 200);
        } else {
            return response()->json(['error' => 'Không tìm thấy trường code'], 400);
        }
    } catch (\Exception $e) {
        return response()->json(['error' => 'Không thể kết nối đến API'], 500);
    }
}

}
