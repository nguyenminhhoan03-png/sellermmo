<?php

namespace App\Http\Controllers\Hosting;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Events\PaymentSucceeded;
use App\Events\GlobalPurchaseEvent;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Logs;
use App\Models\Transaction;
use App\Models\CategoryHosting;
use App\Models\WhmInfo;
use App\Models\VoucherLog;
use App\Models\PurchasedHosting;
use App\Models\Voucher;
use App\Helpers\Helper;
use App\Models\HostingPackages;
use App\Events\HostingSuccessful;

class HostingController extends Controller
{
    public function ShowGoiHost()
    {
        $category = CategoryHosting::where('status', 1)->get();
        return view('hosting.index', [
            'pageTitle' => 'Hệ thông bán hosting giá rẻ',
            'category' => $category,
        ]);
    }
    public function ShowHistory(Request $request)
    {
        $user = User::find(auth()->user()->id);
        $host = PurchasedHosting::where('user_id', $user->id)->orderBy('id', 'desc')->get();
        return view('hosting.history', [
            'pageTitle' => 'Lịch sử mua hosting',
            'user' => $user,
            'host' => $host,
        ]);
    }
    public function giahanauto(Request $request)
    {
        if (env('PRJ_DEMO_MODE', false) === true) {
            return response()->json([
                'status' => 500,
                'message' => 'Chức năng này không hoạt động trong chế độ demo.',
            ], 500);
        }

        $messages = [
            'status.required' => 'Trường Trạng thái là bắt buộc.',
            'id.required' => 'Trường id là bắt buộc.',
        ];

        $attributes = [
            'status' => 'Trạng thái',
            'id' => 'ID Hosting',
        ];

        $payload = $request->validate([
            'status' => 'required',
            'id' => 'required',
        ], $messages, $attributes);
        $domain = PurchasedHosting::findOrFail($payload['id']);
        $status = $payload['status'];
        $domain->update([
            'giahan' => $status,
        ]);
        Helper::addLogs('Thay đổi gia hạn auto hosting thành công');

        return response()->json([
            'status' => 200,
            'message' => ('Cập nhật gia hạn thành công'),
        ]);
    }
    public function PayHost(Request $request)
    {
        if (env('PRJ_DEMO_MODE', false) === true) {
            return response()->json([
                'status' => 500,
                'message' => 'Chức năng này không hoạt động trong chế độ demo.',
            ], 500);
        }

        $messages = [
            'whm.required' => 'Trường máy chủ là bắt buộc',
            'time.required' => 'Trường Thời hạn là bắt buộc.',
            'goi.required' => 'Trường gói hosting là bắt buộc.',
            'domain.required' => 'Trường Tên Miền là bắt buộc.',
        ];
        $attributes = [
            'whm' => 'Máy Chủ',
            'time' => 'Thời hạn',
            'goi' => 'Gói hosting',
            'domain' => 'Tên miền',
        ];
        $payload = $request->validate([
            'whm' => 'required',
            'goi' => 'required',
            'time' => 'required',
            'domain' => 'required|string',
            'coupon' => '',
        ], $messages, $attributes);

        $category = CategoryHosting::find($payload['whm']);
        $goi = HostingPackages::find($payload['goi']);
        if ($category->id != $goi->category) {
            return response()->json([
                'status' => 401,
                'message' => 'Máy chủ này không tồn tại gói hosting mà bạn chọn.',
            ], 401);
        }
        $domain = $payload['domain'];
        if (isValidDomain($domain) === false) {
            return response()->json([
                'status' => 500,
                'message' => 'Tên miền không hợp lệ bạn có thể nhập VD : muabanwebsite.io.vn',
            ], 500);
        }
        $whm = WhmInfo::where('category', $category->id)->first();
        if (!$whm) {
            return response()->json([
                'status' => 401,
                'message' => 'Máy Chủ này hiện đang bảo trì quý khách vui lòng thử gói khác.',
            ], 401);
        }
        $us = Helper::random('mnbvcxzlkjhgfdsapoiuytrewq', 3);
        $user = User::find(auth()->user()->id);
        $month = $payload['time'];

        $coupon = $payload['coupon'];

        $voucher = Voucher::where('code', $coupon)->where('type', 'hosting')->first();

        if (!$voucher) {
            $ck = 0;
        } else {
            $ck = $voucher->value;
        }
        $total = $month * ($goi->price - $goi->price * ($ck / 100));
        if ($user->balance < $total) {
            return response()->json([
                'status' => 403,
                'message' => 'Tài khoản của bạn không đủ để thực hiện hành động này',
            ], 403);
        }
        $username = strtolower($us . extractDomain($domain));
        $password = Helper::random('0123456789QWERTYUIOPASDGHJKLZXCVBNM@#%mnbvcxzlkjhgfdsapoiuytrewq', rand(15, 16)) . time();
        if ($whm->whm_user == 'root') {
            $package = $goi->package_name;
        } else {
            $package = $whm->whm_user . '_' . $goi->package_name;
        }
        $vars = array(
            'api.version' => 1,
            'username' => $username,
            'domain' => $domain,
            'contactemail' => $user->email,
            'pkgname' => $package,
            'password' => $password,
        );
        $whm_link = checkIpOrHostname($whm->whm_host);

        $params = [
            'serverusername' => $whm->whm_user,
            'serverpassword' => $whm->whm_pass,
            'serverhttpprefix' => 'https',
            'serverport' => 2087,
            'serversecure' => true,
            'serveraccesshash' => $whm->accesshash,
        ];
        if ($whm_link) {
            $params['serverip'] = $whm->whm_host;
            $params['serverhostname'] = null;
        } else {
            $params['serverip'] = null;
            $params['serverhostname'] = $whm->whm_host;
        }

        $khanhdz = array(
            'api.version' => 1,
        );
        $api = cpanel_CheckDomain($params, $khanhdz);
        foreach ($api['message']['domains'] as $demo) {
            if ($demo['domain'] == $domain) {
                $checkdo = true;
            }
        }
        if (isset($checkdo)) {
            return response()->json([
                'status' => 401,
                'message' => 'Tên miền này đã tồn tại trong hệ thống',
            ], 401);
        }

        $response = cpanel_CreateAccount($params, $vars);
        if (isset($response) && $response['message'] == 1) {

            if ($user->decrement('balance', $total) === false) {
                return response()->json([
                    'status' => 500,
                    'message' => 'Đã có lỗi trong quá trình thanh toán, vui lòng liên hệ admin.',
                ], 500);
            }
            if ($voucher) {
                $voucher->decrement('qty', '1');
                VoucherLog::create(
                    [
                        'user_id' => $user->id,
                        'code' => $voucher->code,
                        'value' => $voucher->value,
                    ]
                );
            }
            $host = PurchasedHosting::create([
                'user_id' => $user->id,
                'package_id' => $goi->id,
                'ip' => $whm->ip,
                'start_date' => time(),
                'end_date' => time() + (2592000 * $month),
                'username' => $username,
                'password' => $password,
                'month' => $month,
                'email' => $user->email,
                'domain_name' => $domain,
                'server_whm' => $whm,
                'info_package' => $goi,
                'price' => $goi->price,
                'total' => $total,
                'status' => '2',
            ]);
            event(new HostingSuccessful($host));
            $trans_id = Helper::random('QWERTYUIOPASDFGHJKZXCVBNM', 2) . time();
            Transaction::create([
                'code' => $trans_id,
                'amount' => $total,
                'balance_before' => $user->balance + $total,
                'balance_after' => $user->balance,
                'type' => 'new-order',
                'status' => 'paid',
                'content' => 'Mua Hosting Gói ' . $goi->package_name . ' ; Giá tiền ' . number_format($total) . 'đ; Thanh toán thành công cho người dùng ' . $user->username,
                'extras' => [
                    'id' => $host->id,
                    'order_code' => $trans_id,
                ],
                'user_id' => $user->id,
                'username' => $user->username,
                'order_id' => $host->id,
            ]);
            Logs::create([
                'data' => '0',
                'action' => 'Mua Hosting Thuộc gói ' . $goi->package_name,
                'description' => 'Thực hiện hành động mua hosting với địa chỉ ip' . request()->ip(),
                'old_data' => 0,
                'new_data' => 0,
                'user_id' => $user->id,
                'ip' => request()->ip(),
                'data_json' => '',
            ]);

            try {
                broadcast(new GlobalPurchaseEvent([
                    'userName'     => $user->name,
                    'productName'  => 'Hosting: ' . $goi->package_name,
                    'productPrice' => number_format($total) . ' đ',
                    'location'     => 'Việt Nam',
                    'time'         => now()->toDateTimeString(),
                ]));
            } catch (\Exception $e) {}

            return response()->json([
                'status' => 200,
                'message' => 'Đã tạo hosting thành công, cảm ơn bạn đã sử dụng dịch vụ',
            ], 200);
        } else {
            $content = "Thông Báo Lỗi\n";
            $content .= 'cPanel API Response: ' . $response['message'];
            Helper::sendMessageTelegramAuto($content);
            return response()->json([
                'status' => 400,
                'message' => 'Đã xảy ra lỗi khi tạo hosting, vui lòng liên hệ admin',
            ], 400);
        }
    }
    public function PayHostCron(Request $request)
    {
        if (env('PRJ_DEMO_MODE', false) === true) {
            return response()->json([
                'status' => 500,
                'message' => 'Chức năng này không hoạt động trong chế độ demo.',
            ], 500);
        }
        $messages = [
            'whm.required' => 'Trường máy chủ là bắt buộc',
            'time.required' => 'Trường Thời hạn là bắt buộc.',
            'goi.required' => 'Trường gói hosting là bắt buộc.',
            'domain.required' => 'Trường Tên Miền là bắt buộc.',
        ];
        $attributes = [
            'whm' => 'Máy Chủ',
            'time' => 'Thời hạn',
            'goi' => 'Gói hosting',
            'domain' => 'Tên miền',
        ];
        $payload = $request->validate([
            'whm' => 'required',
            'goi' => 'required',
            'time' => 'required',
            'domain' => 'required|string',
            'coupon' => '',
        ], $messages, $attributes);

        $category = CategoryHosting::find($payload['whm']);
        $goi = HostingPackages::find($payload['goi']);
        if ($category->id != $goi->category) {
            return response()->json([
                'status' => 401,
                'message' => 'Máy chủ này không tồn tại gói hosting mà bạn chọn.',
            ], 401);
        }
        $domain = $payload['domain'];
        if (isValidDomain($domain) === false) {
            return response()->json([
                'status' => 500,
                'message' => 'Tên miền không hợp lệ bạn có thể nhập VD : muabanwebsite.io.vn',
            ], 500);
        }
        $whm = WhmInfo::where('category', $category->id)->first();
        if (!$whm) {
            return response()->json([
                'status' => 401,
                'message' => 'Máy Chủ này hiện đang bảo trì quý khách vui lòng thử gói khác.',
            ], 401);
        }
        $us = Helper::random('mnbvcxzlkjhgfdsapoiuytrewq', 3);
        $user = User::find(auth()->user()->id);
        $username = strtolower($us . extractDomain($domain));
        $password = Helper::random('0123456789QWERTYUIOPASDGHJKLZXCVBNM@#%mnbvcxzlkjhgfdsapoiuytrewq', rand(15, 16)) . time();
        if ($whm->whm_user == 'root') {
            $package = $goi->package_name;
        } else {
            $package = $whm->whm_user . '_' . $goi->package_name;
        }
        $vars = array(
            'api.version' => 1,
            'username' => $username,
            'domain' => $domain,
            'contactemail' => $user->email,
            'pkgname' => $package,
            'password' => $password,
        );
        $whm_link = checkIpOrHostname($whm->whm_host);

        $params = [
            'serverusername' => $whm->whm_user,
            'serverpassword' => $whm->whm_pass,
            'serverhttpprefix' => 'https',
            'serverport' => 2087,
            'serversecure' => true,
            'serveraccesshash' => $whm->accesshash,
        ];
        if ($whm_link) {
            $params['serverip'] = $whm->whm_host;
            $params['serverhostname'] = null;
        } else {
            $params['serverip'] = null;
            $params['serverhostname'] = $whm->whm_host;
        }
        $month = $payload['time'];
        $khanhdz = array(
            'api.version' => 1,
        );
        $api = cpanel_CheckDomain($params, $khanhdz);
        foreach ($api['message']['domains'] as $demo) {
            if ($demo['domain'] == $domain) {
                $checkdo = true;
            }
        }
        if (isset($checkdo)) {
            return response()->json([
                'status' => 401,
                'message' => 'Tên miền này đã tồn tại trong hệ thống',
            ], 401);
        }
        $coupon = $payload['coupon'];

        $voucher = Voucher::where('code', $coupon)->where('type', 'hosting')->first();

        if (!$voucher) {
            $ck = 0;
        } else {
            $ck = $voucher->value;
        }
        $total = $month * ($goi->price - $goi->price * ($ck / 100));
        if ($user->balance < $total) {
            return response()->json([
                'status' => 403,
                'message' => 'Tài khoản của bạn không đủ để thực hiện hành động này',
            ], 403);
        }
        if ($user->decrement('balance', $total) === false) {
            return response()->json([
                'status' => 500,
                'message' => 'Đã có lỗi trong quá trình thanh toán, vui lòng liên hệ admin.',
            ], 500);
        }
        if ($voucher) {
            $voucher->decrement('qty', '1');
            VoucherLog::create(
                [
                    'user_id' => $user->id,
                    'code' => $voucher->code,
                    'value' => $voucher->value,
                ]
            );
        }
        $host = PurchasedHosting::create([
            'user_id' => $user->id,
            'package_id' => $goi->id,
            'ip' => $whm->ip,
            'start_date' => time(),
            'end_date' => time() + (2592000 * $month),
            'username' => $username,
            'password' => $password,
            'month' => $month,
            'email' => $user->email,
            'domain_name' => $domain,
            'server_whm' => $whm,
            'info_package' => $goi,
            'price' => $total,
            'total' => $total,
            'status' => '1',
        ]);
        $trans_id = Helper::random('QWERTYUIOPASDFGHJKZXCVBNM', 2) . time();
        Transaction::create([
            'code' => $trans_id,
            'amount' => $total,
            'balance_before' => $user->balance + $total,
            'balance_after' => $user->balance,
            'type' => 'new-order',
            'status' => 'paid',
            'content' => 'Mua Hosting Gói ' . $goi->package_name . ' ; Giá tiền ' . number_format($total) . 'đ; Thanh toán thành công cho người dùng ' . $user->username,
            'extras' => [
                'id' => $host->id,
                'order_code' => $trans_id,
            ],
            'user_id' => $user->id,
            'username' => $user->username,
            'order_id' => $host->id,
        ]);
        Logs::create([
            'data' => '0',
            'action' => 'Mua Hosting Thuộc gói ' . $goi->package_name,
            'description' => 'Thực hiện hành động mua hosting với địa chỉ ip' . request()->ip(),
            'old_data' => 0,
            'new_data' => 0,
            'user_id' => $user->id,
            'ip' => request()->ip(),
            'data_json' => '',
        ]);
        if ($host) {
            return response()->json([
                'status' => 200,
                'message' => 'Đã tạo hosting thành công, cảm ơn bạn đã sử dụng dịch vụ',
            ], 200);
        } else {
            return response()->json([
                'status' => 500,
                'message' => 'Đã có lỗi trong quá trình tạo hosting, vui lòng liên hệ admin.',
            ], 500);
        }
    }
    public function CronJobs(Request $request)
    {
        $host = PurchasedHosting::where('status', 1)->get();
        if ($host->count() > 0) {
            foreach ($host as $hosts) {
                if ($hosts->server_whm['whm_user'] == 'root') {
                    $package = $hosts->info_package['package_name'];
                } else {
                    $package = $hosts->server_whm['whm_user'] . '_' . $hosts->info_package['package_name'];
                }
                $user = User::find($hosts->user_id);
                $vars = array(
                    'api.version' => 1,
                    'username' => $hosts->username,
                    'domain' => $hosts->domain_name,
                    'contactemail' => $user->email,
                    'pkgname' => $package,
                    'password' => $hosts->password,
                );
                $whm_link = checkIpOrHostname($hosts->server_whm['whm_host']);
                $params = [
                    'serverusername' => $hosts->server_whm['whm_user'],
                    'serverpassword' => $hosts->server_whm['whm_pass'],
                    'serverhttpprefix' => 'https',
                    'serverport' => 2087,
                    'serversecure' => true,
                    'serveraccesshash' => $hosts->server_whm['accesshash'],
                ];
                if ($whm_link) {
                    $params['serverip'] = $hosts->server_whm['whm_host'];
                    $params['serverhostname'] = null;
                } else {
                    $params['serverip'] = null;
                    $params['serverhostname'] = $hosts->server_whm['whm_host'];
                }
                $response = cpanel_CreateAccount($params, $vars);
                if (isset($response) && $response['message'] == 1) {
                    $channelName = $user->username;
                    broadcast(new PaymentSucceeded(
                        'Đã tạo hosting thành công, cảm ơn bạn đã sử dụng dịch vụ!',
                        $channelName
                    ));
                    $hosts->status = '2';
                    $hosts->save();
                    return response()->json([
                        'status' => 200,
                        'message' => 'Đã tạo hosting thành công, cảm ơn bạn đã sử dụng dịch vụ',
                    ], 200);
                } else {
                    $content = "Thông Báo Lỗi\n";
                    $content .= 'cPanel API Response: ' . $response['message'];
                    Helper::sendMessageTelegramAuto($content);
                    return response()->json([
                        'status' => 400,
                        'message' => 'Đã xảy ra lỗi khi tạo hosting, vui lòng liên hệ admin',
                    ], 400);
                }
            }
        } else {
            return response()->json([
                'status' => 500,
                'message' => 'Không có hosting nào cần tạo.',
            ], 500);
        }
    }
    public function ViewHost($id)
    {
        $user = User::find(auth()->user()->id);
        $host = PurchasedHosting::where('id', $id)->where('user_id', $user->id)->first();
        if (!$host) {
            return redirect()->route('hosting.history')->with('error', 'Chúng tôi không tìm thấy hosting này của bạn.');
        }
        $category = CategoryHosting::where('status', 1)->where('id', $host->server_whm['category'])->first();
        return view('hosting.view', [
            'pageTitle' => 'Chi tiết hosting số #' . $host->id,
            'host' => $host,
            'category' => $category,
        ]);
    }
    public function getDisk(Request $request)
    {
        $id = $request->id;
        $host = PurchasedHosting::find($id);

        $whm_link = checkIpOrHostname($host->server_whm['whm_host']);

        $params = [
            'serverusername' => $host->username,
            'serverpassword' => $host->password,
            'serverhttpprefix' => 'https',
            'serverport' => 2083,
            'serversecure' => true,
            'serveraccesshash' => '',
        ];
        if ($whm_link) {
            $params['serverip'] = $host->server_whm['whm_host'];
            $params['serverhostname'] = null;
        } else {
            $params['serverip'] = null;
            $params['serverhostname'] = $host->server_whm['whm_host'];
        }
        $result = cpanel_DiskSpace($params);
        if (is_array($result) && isset($result['message']) && is_array($result['message'])) {
            $megabyte_limit = $result['message']['megabyte_limit'] ?? 0;
            $megabytes_used = $result['message']['megabytes_used'] ?? 0;
            $megabytes_remain = $result['message']['megabytes_remain'] ?? 0;
        } else {
            die('Lỗi: Dữ liệu không đúng định dạng');
        }
        $phamtram = ($megabytes_used / $megabyte_limit) * 100;
        $disk_used = FormatDungLuong($megabytes_used);
        $disk_limit = FormatDungLuong($megabyte_limit);
        return response()->json([
            'status' => 200,
            'phamtram' => $phamtram,
            'disk_limit' => $disk_limit,
            'disk_used' => $disk_used,
            'megabytes_remain' => $megabytes_remain,
        ], 200);
    }
    public function CheckAll(Request $request)
    {
        $id = $request->id;
        $host = PurchasedHosting::find($id);

        $whm_link = checkIpOrHostname($host->server_whm['whm_host']);

        $params = [
            'serverusername' => $host->username,
            'serverpassword' => $host->password,
            'serverhttpprefix' => 'https',
            'serverport' => 2083,
            'serversecure' => true,
            'serveraccesshash' => '',
        ];
        if ($whm_link) {
            $params['serverip'] = $host->server_whm['whm_host'];
            $params['serverhostname'] = null;
        } else {
            $params['serverip'] = null;
            $params['serverhostname'] = $host->server_whm['whm_host'];
        }
        $result = cpanel_CheckSpace($params);
        $cpuData = getUsageAndMaximumById($result['message'], 'lvecpu');
        if ($cpuData !== null) {
            $cpu_max = $cpuData['maximum'];
            $cpu_usage = $cpuData['usage'];
            if ($cpu_usage != 0) {
                $cpu_phantram = ($cpu_usage / $cpu_max) * 100;
            } else {
                $cpu_phantram = 0;
            }
        } else {
            $cpu_max = 0;
            $cpu_usage = 100;
            $cpu_phantram = 0;
        }
        $cpu = [
            'cpu_max' => $cpu_max,
            'cpu_usage' => $cpu_usage,
            'cpu_phantram' => $cpu_phantram,
        ];
        $memoryData = getUsageAndMaximumById($result['message'], 'lvememphy');

        if ($memoryData !== null) {
            $ram_max = $memoryData['maximum'] / (1024 * 1024);
            $ram_usage = $memoryData['usage'] / (1024 * 1024);
            if ($ram_usage != 0) {
                $ram_phantram = ($ram_usage / $ram_max) * 100;
            } else {
                $ram_phantram = 0;
            }
        } else {
            $ram_max = 0;
            $ram_usage = 0;
            $ram_phantram = 0;
        }
        $ram = [
            'ram_max' => FormatDungLuong($ram_max),
            'ram_usage' => FormatDungLuong($ram_usage),
            'ram_phantram' => $ram_phantram,
        ];
        $quytrinhData = getUsageAndMaximumById($result['message'], 'lvenproc');
        if ($quytrinhData !== null) {
            $quytrinh_max = $quytrinhData['maximum'];
            $quytrinh_usage = $quytrinhData['usage'];
            if ($quytrinh_usage != 0) {
                $quytrinh_phantram = ($quytrinh_usage / $quytrinh_max) * 100;
            } else {
                $quytrinh_phantram = 0;
            }
        } else {
            $quytrinh_max = 0;
            $quytrinh_usage = 0;
            $quytrinh_phantram = 0;
        }
        $quytrinh = [
            'quytrinh_max' => $quytrinh_max,
            'quytrinh_usage' => $quytrinh_usage,
            'quytrinh_phantram' => $quytrinh_phantram,
        ];
        return response()->json([
            'status' => 200,
            'data' => [
                'cpu' => $cpu,
                'ram' => $ram,
                'quytrinh' => $quytrinh,
            ]
        ], 200);
    }
    public function ChangeDomain(Request $request)
    {
        if (env('PRJ_DEMO_MODE', false) === true) {
            return response()->json([
                'status' => 500,
                'message' => 'Chức năng này không hoạt động trong chế độ demo.',
            ], 500);
        }
        $user = User::find(auth()->user()->id);
        if ($user->banned !== 0) {
            return response()->json([
                'status' => 400,
                'message' => 'Tài khoản của bạn đang bị khóa, vui lòng liên hệ admin để được hỗ trợ.',
            ], 400);
        }
        $messages = [
            'domain.required' => 'Trường Tên Miền là bắt buộc.',
        ];
        $attributes = [
            'domain' => 'Tên miền',
        ];
        $payload = $request->validate([
            'id' => 'required|integer',
            'domain' => 'required|string',
        ], $messages, $attributes);
        $domain = $payload['domain'];
        if (isValidDomain($domain) === false) {
            return response()->json([
                'status' => 500,
                'message' => 'Tên miền không hợp lệ bạn có thể nhập VD : muabanwebsite.io.vn',
            ], 500);
        }
        $id = $payload['id'];
        $host = PurchasedHosting::where('id', $id)->where('user_id', $user->id)->first();
        if (!$host) {
            return response()->json([
                'status' => 404,
                'message' => 'Chúng tôi không thể tìm thấy hosting của bạn!',
            ], 404);
        }
        if ($host->domain_name == $domain) {
            return response()->json([
                'status' => 401,
                'message' => 'Vui lòng không nhập tên miền chính!',
            ], 401);
        }
        $whm_link = checkIpOrHostname($host->server_whm['whm_host']);

        $params = [
            'serverusername' => $host->server_whm['whm_user'],
            'serverpassword' => $host->server_whm['whm_pass'],
            'serverhttpprefix' => 'https',
            'serverport' => 2087,
            'serversecure' => true,
            'serveraccesshash' => '',
        ];
        if ($whm_link) {
            $params['serverip'] = $host->server_whm['whm_host'];
            $params['serverhostname'] = null;
        } else {
            $params['serverip'] = null;
            $params['serverhostname'] = $host->server_whm['whm_host'];
        }
        $khanhdz = array(
            'api.version' => 1,
        );
        $api = cpanel_CheckDomain($params, $khanhdz);
        foreach ($api['message']['domains'] as $demo) {
            if ($demo['domain'] == $domain) {
                $checkdo = true;
            }
        }
        if (isset($checkdo)) {
            return response()->json([
                'status' => 401,
                'message' => 'Tên miền này đã tồn tại trong hệ thống',
            ], 401);
        }
        $vars = array(
            'api.version' => 1,
            'user' => $host->username,
            'domain' => $domain,
        );
        $response = cpanel_ChangeDomain($params, $vars);
        if (isset($response) && $response['result'] == 1) {
            $host->domain_name = $payload['domain'];
            $host->save();
            Logs::create([
                'data' => '0',
                'action' => 'Câp nhật tên miền cho hosting, tên miền ' . $domain,
                'description' => 'Thực hiện hành động cập nhật gói Hosting với địa chỉ ip' . request()->ip(),
                'old_data' => 0,
                'new_data' => 0,
                'user_id' => $user->id,
                'ip' => request()->ip(),
                'data_json' => '',
            ]);

            return response()->json([
                'status' => 200,
                'message' => 'Cập nhật tên miền thành công',
            ], 200);
        } else {
            $content = "Thông Báo Lỗi\n";
            $content .= 'cPanel API Response: ' . $response['message'];
            Helper::sendMessageTelegramAuto($content);
            return response()->json([
                'status' => 400,
                'message' => 'Gói hosting này không hỗ trợ đổi tên miền chính',
            ], 400);
        }
    }
    public function Login(Request $request)
    {
        $payload = $request->validate([
            'action' => 'required|string',
            'id' => 'required|integer',
        ]);
        $host = PurchasedHosting::find($payload['id']);
        $whm_link = checkIpOrHostname($host->server_whm['whm_host']);

        $params = [
            'serverusername' => $host->server_whm['whm_user'],
            'serverpassword' => $host->server_whm['whm_pass'],
            'serverhttpprefix' => 'https',
            'serverport' => 2087,
            'serversecure' => true,
            'serveraccesshash' => '',
        ];

        if ($whm_link) {
            $params['serverip'] = $host->server_whm['whm_host'];
            $params['serverhostname'] = null;
        } else {
            $params['serverip'] = null;
            $params['serverhostname'] = $host->server_whm['whm_host'];
        }
        $user = $host->username;
        $service = $payload['action'];
        $app = '';
        $result = cpanel_SingleSignOn($params, $user, $service, $app);
        if ($result['success'] == true) {
            if (isset($result['redirectTo'])) {
                return response()->json([
                    'status' => 200,
                    'url' => $result['redirectTo'],
                ], 200);
            } else {
                return response()->json([
                    'status' => 400,
                    'message' => 'redirectTo không có trong kết quả trả về',
                ], 400);
            }
        } else {
            $content = "Thông Báo Lỗi\n";
            $content .= 'cPanel API Response: ' . $result['errorMsg'];
            Helper::sendMessageTelegramAuto($content);
            return $result;
        }
    }
    public function redirect(Request $request)
    {
        $payload = $request->validate([
            'app' => 'required|string',
            'id' => 'required|integer',
        ]);
        $host = PurchasedHosting::find($payload['id']);
        $whm_link = checkIpOrHostname($host->server_whm['whm_host']);

        $params = [
            'serverusername' => $host->server_whm['whm_user'],
            'serverpassword' => $host->server_whm['whm_pass'],
            'serverhttpprefix' => 'https',
            'serverport' => 2087,
            'serversecure' => true,
            'serveraccesshash' => '',
        ];

        if ($whm_link) {
            $params['serverip'] = $host->server_whm['whm_host'];
            $params['serverhostname'] = null;
        } else {
            $params['serverip'] = null;
            $params['serverhostname'] = $host->server_whm['whm_host'];
        }
        $user = $host->username;
        $service = 'cpaneld';
        $app = $payload['app'];
        $result = cpanel_SingleSignOn($params, $user, $service, $app);
        if ($result['success'] == true) {
            if (isset($result['redirectTo'])) {
                return response()->json([
                    'status' => 200,
                    'url' => $result['redirectTo'],
                ], 200);
            } else {
                return response()->json([
                    'status' => 400,
                    'message' => 'redirectTo không có trong kết quả trả về',
                ], 400);
            }
        } else {
            $content = "Thông Báo Lỗi\n";
            $content .= 'cPanel API Response: ' . $result['errorMsg'];
            Helper::sendMessageTelegramAuto($content);
            return $result;
        }
    }
    public function handle()
    {
        $hostings = PurchasedHosting::get();
        $updatedHosting = [];
        $noExpiredHosting = true;
        $threeDaysInSeconds = 3 * 24 * 60 * 60;
        $updatedHosting = [];
        $failedHosting = [];

        foreach ($hostings as $hosting) {
            $whm_link = checkIpOrHostname($hosting->server_whm['whm_host']);

            $params = [
                'serverusername' => $hosting->server_whm['whm_user'],
                'serverpassword' => $hosting->server_whm['whm_pass'],
                'serverhttpprefix' => 'https',
                'serverport' => 2087,
                'serversecure' => true,
                'serveraccesshash' => $hosting->server_whm['accesshash'],
                'type' => 'cpanelaccount',
                'username' => $hosting->username,
                'suspendreason' => 'Vui lòng gia hạn hosting',
            ];
            if ($whm_link) {
                $params['serverip'] = $hosting->server_whm['whm_host'];
                $params['serverhostname'] = null;
            } else {
                $params['serverip'] = null;
                $params['serverhostname'] = $hosting->server_whm['whm_host'];
            }

            $timeRemaining = $hosting->end_date - time();
            if ($hosting->giahan == 1) {
                if ($timeRemaining <= $threeDaysInSeconds && $hosting->status != 0) {

                    $user = User::find($hosting->user_id);
                    if (!$user) {
                        $failedHosting[] = $hosting->domain_name . ' - Không tìm thấy user.';
                        continue;
                    }
                    $value = $hosting->total;
                    if ($user->balance < $value) {
                        $response = cpanel_SuspendAccount($params);
                        if (isset($response) && $response['message'] == 1) {
                            $hosting->status = 3;
                            $hosting->save();
                            $failedHosting[] = $hosting->domain_name . ' - Không đủ số dư để gia hạn.';
                            Logs::create([
                                'data' => '0',
                                'action' => 'Tài khoản của bạn không đủ để hạn hosting auto hosting :' . $hosting->domain_name . ' ',
                                'description' => 'Không thể thực hiện gia hạn auto với địa chỉ ip' . request()->ip(),
                                'old_data' => 0,
                                'new_data' => 0,
                                'user_id' => $user->id,
                                'ip' => request()->ip(),
                                'data_json' => '',
                            ]);
                            continue;
                        } else {
                            return response()->json([
                                'status' => 400,
                                'message' => 'cPanel API Response: ' . $response['message'],
                            ], 400);
                        }
                    } else {
                        if ($user->decrement('balance', $value) === false) {
                            return response()->json([
                                'status' => 400,
                                'message' => 'Tài khoản của bạn không thể giao dịch, vui lòng ib admin.',
                            ], 400);
                        }
                        $month = $hosting->month;
                        $hosting->end_date = $hosting->end_date + (2592000 * $month);
                        $hosting->status = 2;
                        $hosting->save();
                        $trans_id = Helper::random('QWERTYUIOPASDFGHJKZXCVBNM', 2) . time();
                        Transaction::create([
                            'code' => $trans_id,
                            'amount' => $value,
                            'balance_before' => $user->balance + $value,
                            'balance_after' => $user->balance,
                            'type' => 'new-order',
                            'status' => 'paid',
                            'content' => 'Gia hạn Hosting #' . $hosting->id . ' ; Giá tiền ' . number_format($value) . 'đ; Thanh toán thành công cho người dùng ' . $user->username,
                            'extras' => [
                                'id' => $hosting->id,
                                'order_code' => $trans_id,
                            ],
                            'user_id' => $user->id,
                            'username' => $user->username,
                            'order_id' => $hosting->id,
                        ]);
                        Logs::create([
                            'data' => '0',
                            'action' => 'Gia hạn hosting auto ' . $hosting->domain_name . '',
                            'description' => 'Thực hiện hành động gia hạn hosting auto với địa chỉ ip' . request()->ip(),
                            'old_data' => 0,
                            'new_data' => 0,
                            'user_id' => $user->id,
                            'ip' => request()->ip(),
                            'data_json' => '',
                        ]);
                    }

                    $updatedHosting[] = $hosting->domain_name;
                    $noExpiredHosting = false;
                } else {
                    if ($hosting->end_date < time() && $hosting->status != 3) {

                        $hosting->status = 3;
                        $hosting->save();
                        $content = "Thông Báo Hosting hết hạn\n";
                        $content .= 'Hosting mã số #' . $hosting->id;
                        $content = "Thông Báo cho admin để admin xóa hosting nhé\n";
                        Helper::sendMessageTelegramAuto($content);
                        $updatedHosting[] = $hosting->domain_name;
                        $noExpiredHosting = false;
                    }
                }
            } else {
                if ($timeRemaining <= $threeDaysInSeconds && $hosting->status != 0 && $hosting->status != 3) {
                    $response = cpanel_SuspendAccount($params);
                    if (isset($response) && $response['message'] == 1) {
                        $hosting->status = 0;
                        $hosting->save();
                        $updatedHosting[] = $hosting->domain_name;
                        $noExpiredHosting = false;
                    } else {
                        return response()->json([
                            'status' => 400,
                            'message' => 'cPanel API Response: ' . $response['message'],
                        ], 400);
                    }
                }

                if ($hosting->end_date < time() && $hosting->status != 3) {
                    $hosting->status = 3;
                    $hosting->save();
                    $content = "Thông Báo Hosting hết hạn\n";
                    $content .= 'Hosting mã số #' . $hosting->id;
                    $content = "Thông Báo cho admin để admin xóa hosting nhé\n";
                    Helper::sendMessageTelegramAuto($content);
                    $updatedHosting[] = $hosting->domain_name;
                    $noExpiredHosting = false;
                }
            }
        }

        if (count($failedHosting) > 0) {
            return response()->json([
                'status' => 400,
                'message' => 'Lỗi gia hạn với các hosting: ' . implode(', ', $failedHosting),
            ], 400);
        }
        if (!$noExpiredHosting) {
            return response()->json([
                'status' => 200,
                'message' => 'Hosting ' . implode(', ', $updatedHosting) . ' đã được cập nhật trạng thái.',
            ], 200);
        } else {
            return response()->json([
                'status' => 400,
                'message' => 'Chưa có hosting nào cần cập nhật trạng thái.',
            ], 400);
        }
    }
    public function changePass(Request $request)
    {
        $payload = $request->validate([
            'id' => 'required|integer',
            'password' => 'required|string|min:8',
        ]);
        $hosting = PurchasedHosting::where('id', $payload['id'])->firstOrFail();
        if (!$hosting) {
            return response()->json([
                'status' => 404,
                'message' => 'Không tìm thấy hosting.',
            ], 404);
        }
        if ($hosting->password == $payload['password']) {
            return response()->json([
                'status' => 401,
                'message' => 'Vui lòng không nhập lại mật khẩu cũ.',
            ], 401);
        }
        $whm_link = checkIpOrHostname($hosting->server_whm['whm_host']);

        $params = [
            'serverusername' => $hosting->server_whm['whm_user'],
            'serverpassword' => $hosting->server_whm['whm_pass'],
            'serverhttpprefix' => 'https',
            'serverport' => 2087,
            'serversecure' => true,
            'serveraccesshash' => $hosting->server_whm['accesshash'],
            'username' => $hosting->username,
            'password' => $payload['password'],
        ];
        if ($whm_link) {
            $params['serverip'] = $hosting->server_whm['whm_host'];
            $params['serverhostname'] = null;
        } else {
            $params['serverip'] = null;
            $params['serverhostname'] = $hosting->server_whm['whm_host'];
        }
        $response = cpanel_ChangePassword($params);
        if (isset($response) && $response['message'] == 1) {

            $hosting->update([
                'password' => $payload['password'],
            ]);
            return response()->json([
                'status' => 200,
                'message' => 'Cập nhật mật khẩu cho hosting ' . $hosting->domain_name . ' thành công.',
            ], 200);
        } else {
            return response()->json([
                'status' => 400,
                'message' => 'cPanel API Response: ' . $response['message'],
            ], 400);
        }

    }
    public function changePackage(Request $request)
    {
        $payload = $request->validate([
            'id' => 'required|integer',
            'category' => 'required|integer',
        ]);
        $host = PurchasedHosting::find($payload['id']);
        if (!$host) {
            return response()->json([
                'status' => 404,
                'message' => 'Không tìm thấy hosting.',
            ], 404);
        }
        $user = User::where('id', $host->user_id)->first();
        if (!$user) {
            return response()->json([
                'status' => 404,
                'message' => 'Không tìm thấy tài khoản user này.',
            ], 404);
        }
        $pack = HostingPackages::find($payload['category']);
        if (!$pack) {
            return response()->json([
                'status' => 404,
                'message' => 'Không tìm thấy gói hosting này.',
            ], 404);
        }
        $whm_link = checkIpOrHostname($host->server_whm['whm_host']);
        if ($host->server_whm['whm_user'] == 'root') {
            $package = $pack->package_name;
        } else {
            $package = $host->server_whm['whm_user'] . '_' . $pack->package_name;
        }
        $params = [
            'serverusername' => $host->server_whm['whm_user'],
            'serverpassword' => $host->server_whm['whm_pass'],
            'serverhttpprefix' => 'https',
            'serverport' => 2087,
            'serversecure' => true,
            'serveraccesshash' => $host->server_whm['accesshash'],
            'type' => 'cpanelaccount',
            'username' => $host->username,
            'pkg' => $package,
        ];
        if ($whm_link) {
            $params['serverip'] = $host->server_whm['whm_host'];
            $params['serverhostname'] = null;
        } else {
            $params['serverip'] = null;
            $params['serverhostname'] = $host->server_whm['whm_host'];
        }
        $response = cpanel_ChangePackage($params);
        if (isset($response) && $response['message'] == 1) {
            $month = $host->month;
            $price = $pack->price;
            $total = $month * $price;

            if ($user->balance < $total - $host->total) {
                return response()->json([
                    'status' => 403,
                    'message' => 'Tài khoản của bạn không đủ để thực hiện hành động này',
                ], 403);
            }
            if ($user->decrement('balance', $total - $host->total) === false) {
                return response()->json([
                    'status' => 500,
                    'message' => 'Đã có lỗi trong quá trình thanh toán, vui lòng liên hệ admin.',
                ], 500);
            }
            $host->update([
                'info_package' => $pack,
                'price' => $host->price + ($price - $host->price),
                'total' => $host->total + ($total - $host->total),
            ]);
            $trans_id = Helper::random('QWERTYUIOPASDFGHJKZXCVBNM', 2) . time();
            Transaction::create([
                'code' => $trans_id,
                'amount' => $total,
                'balance_before' => $user->balance + $total,
                'balance_after' => $user->balance,
                'type' => 'new-order',
                'status' => 'paid',
                'content' => 'Nâng cấp gói hosting #' . $host->id . ' thành công Thanh toán thành công cho người dùng ' . $user->username,
                'extras' => [
                    'id' => $host->id,
                    'order_code' => $trans_id,
                ],
                'user_id' => $user->id,
                'username' => $user->username,
                'order_id' => $host->id,
            ]);
            Logs::create([
                'data' => '0',
                'action' => 'nâng cấp gói hosting #' . $host->id . ' với gói #' . $pack->package_name,
                'description' => 'Thực hiện hành động mua hosting với địa chỉ ip' . request()->ip(),
                'old_data' => 0,
                'new_data' => 0,
                'user_id' => $user->id,
                'ip' => request()->ip(),
                'data_json' => '',
            ]);
        }
        return response()->json([
            'status' => 200,
            'message' => 'Thay đổi gói hosting thành công',
        ], 200);
    }
    public function BlockIp(Request $request)
    {
        $payload = $request->validate([
            'id' => 'required|integer',
            'ip' => 'required|string',
        ]);
        $hosting = PurchasedHosting::where('id', $payload['id'])->firstOrFail();
        if (!$hosting) {
            return response()->json([
                'status' => 404,
                'message' => 'Không tìm thấy hosting.',
            ], 404);
        }
        $ipList = $hosting->block_ip;
        $ipArray = explode(',', $ipList);
        $inputIp = $payload['ip'];
        if (in_array($inputIp, $ipArray)) {
            return response()->json([
                'status' => 401,
                'message' => 'Hosting đã block IP ' . $inputIp . ' này rồi.',
            ], 401);
        }
        $whm_link = checkIpOrHostname($hosting->server_whm['whm_host']);

        $params = [
            'serverusername' => $hosting->username,
            'serverpassword' => $hosting->password,
            'serverhttpprefix' => 'https',
            'serverport' => 2083,
            'serversecure' => true,
            'serveraccesshash' => '',
            'ip' => $payload['ip'],
        ];
        if ($whm_link) {
            $params['serverip'] = $hosting->server_whm['whm_host'];
            $params['serverhostname'] = null;
        } else {
            $params['serverip'] = null;
            $params['serverhostname'] = $hosting->server_whm['whm_host'];
        }
        $response = cpanel_BlockIp($params);
        if (isset($response) && $response['message'] == 1) {

            if (!in_array($inputIp, $ipArray)) {
                $ipArray[] = $inputIp;
            }
            $ipList = implode(',', $ipArray);
            $hosting->update([
                'block_ip' => $ipList,
            ]);
            return response()->json([
                'status' => 200,
                'message' => 'IP ' . $inputIp . ' đã được đưa vào danh sách block.',
            ], 200);
        } else {
            return response()->json([
                'status' => 400,
                'message' => 'cPanel API Response: ' . $response['message'],
            ], 400);
        }

    }
    public function UnlBlockIp(Request $request)
    {
        $payload = $request->validate([
            'id' => 'required|integer',
            'ip' => 'required|string',
        ]);
        $hosting = PurchasedHosting::where('id', $payload['id'])->firstOrFail();
        if (!$hosting) {
            return response()->json([
                'status' => 404,
                'message' => 'Không tìm thấy hosting.',
            ], 404);
        }
        $ipList = $hosting->block_ip;
        $ipArray = explode(',', $ipList);
        $inputIp = $payload['ip'];
        $whm_link = checkIpOrHostname($hosting->server_whm['whm_host']);

        $params = [
            'serverusername' => $hosting->username,
            'serverpassword' => $hosting->password,
            'serverhttpprefix' => 'https',
            'serverport' => 2083,
            'serversecure' => true,
            'serveraccesshash' => '',
            'ip' => $payload['ip'],
        ];
        if ($whm_link) {
            $params['serverip'] = $hosting->server_whm['whm_host'];
            $params['serverhostname'] = null;
        } else {
            $params['serverip'] = null;
            $params['serverhostname'] = $hosting->server_whm['whm_host'];
        }
        $response = cpanel_UnlBlockIp($params);
        if (isset($response) && $response['message'] == 1) {

            if (in_array($inputIp, $ipArray)) {

                $ipArray = array_diff($ipArray, [$inputIp]);

                $newIpList = implode(',', $ipArray);

                $hosting->update([
                    'block_ip' => $newIpList,
                ]);
                return response()->json([
                    'status' => 200,
                    'message' => 'IP ' . $inputIp . ' đã được loại bỏ khỏi danh sách block.',
                ], 200);

            } else {
                return response()->json([
                    'message' => 'Không tồn tại ip này trong danh sách block'
                ]);
            }
        } else {
            return response()->json([
                'status' => 400,
                'message' => 'cPanel API Response: ' . $response['message'],
            ], 400);
        }

    }
    public function giahan(Request $request)
    {
        if (env('PRJ_DEMO_MODE', false) === true) {
            return response()->json([
                'status' => 500,
                'message' => 'Chức năng này không hoạt động trong chế độ demo.',
            ], 500);
        }
        $payload = $request->validate([
            'action' => 'required|in:giahan',
            'id' => 'required|exists:tbl_purchased_hosting,id',
            'month' => 'required',
        ]);
        $order = PurchasedHosting::find($payload['id']);
        if (!$order) {
            return response()->json([
                'status' => 404,
                'message' => 'Chúng tôi không thể tim thấy hosting này của bạn.',
            ], 404);
        }
        if ($payload['month'] < 1) {
            return response()->json([
                'status' => 404,
                'message' => 'Thời gian gia hạn không hợp lệ.',
            ], 404);
        }
        $time = $payload['month'];

        $user = User::find($order->user_id);

        $tongtien = $order->info_package['price'];
        $total = $time * $tongtien;
        if ($user->banned !== 0) {
            return response()->json([
                'status' => 400,
                'message' => 'Tài khoản của bạn đang bị khóa, vui lòng liên hệ admin để được hỗ trợ.',
            ], 400);
        }
        if ($user->balance < $total) {
            return response()->json([
                'status' => 403,
                'message' => 'Tài khoản của bạn không đủ để thực hiện thao tác này.',
            ], 403);
        }
        if ($user->decrement('balance', $total) === false) {
            return response()->json([
                'status' => 500,
                'message' => 'Đã có lỗi trong quá trình thanh toán, vui lòng liên hệ admin.',
            ], 500);
        }
        $timestamp = $order->end_date;
        $time_set = $time * 2592000;
        $expired_timestamp = $timestamp + $time_set;

        if ($payload['action'] == 'giahan') {

            $order->status = '2';
            $order->month = $order->month + $time;
            $order->total = $order->total + $total;
            $order->end_date = $expired_timestamp;
            $order->save();
            $trans_id = Helper::random('QWERTYUIOPASDFGHJKZXCVBNM', 2) . time();
            Transaction::create([
                'code' => $trans_id,
                'amount' => $total,
                'balance_before' => $user->balance + $total,
                'balance_after' => $user->balance,
                'type' => 'new-order',
                'status' => 'paid',
                'content' => 'Gia hạn hosting mã số #' . $order->id . ' ; Thanh toán thành công cho người dùng ' . $user->username,
                'extras' => [
                    'id' => $order->id,
                    'order_code' => $trans_id,
                ],
                'user_id' => $user->id,
                'username' => $user->username,
                'order_id' => $order->id,
            ]);

            Logs::create([
                'data' => '0',
                'action' => 'gia hạn hosting mã số #' . $order->id . ' Giá tiền ' . number_format($total) . 'đ',
                'description' => 'Thực hiện hành động thanh toán gia hạn hosting với địa chỉ ip' . request()->ip(),
                'old_data' => 0,
                'new_data' => 0,
                'user_id' => $user->id,
                'ip' => request()->ip(),
                'data_json' => '',
            ]);

            return response()->json([
                'status' => 200,
                'message' => 'Gia hạn hosting thành công.',
            ], 200);
        } else {
            return response()->json([
                'status' => 500,
                'message' => 'Vui lòng chạy đúng chức năng.',
            ]);
        }
    }
    public function reinstall(Request $request)
    {
        if (env('PRJ_DEMO_MODE', false) === true) {
            return response()->json([
                'status' => 500,
                'message' => 'Chức năng này không hoạt động trong chế độ demo.',
            ], 500);
        }
        $payload = $request->validate([
            'id' => 'required|exists:tbl_purchased_hosting,id',
        ]);
        $host = PurchasedHosting::find($payload['id']);
        if (!$host) {
            return response()->json([
                'status' => 404,
                'message' => 'Chúng tôi không thể tim thấy hosting này của bạn.',
            ], 404);
        }
        $whm_link = checkIpOrHostname($host->server_whm['whm_host']);

        $params = [
            'serverusername' => $host->server_whm['whm_user'],
            'serverpassword' => $host->server_whm['whm_pass'],
            'serverhttpprefix' => 'https',
            'serverport' => 2087,
            'serversecure' => true,
            'serveraccesshash' => $host->server_whm['accesshash'],
        ];

        if ($whm_link) {
            $params['serverip'] = $host->server_whm['whm_host'];
            $params['serverhostname'] = null;
        } else {
            $params['serverip'] = null;
            $params['serverhostname'] = $host->server_whm['whm_host'];
        }
        $vars = array(
            'api.version' => 1,
            'username' => $host->username,
        );
        $response = cpanel_DeleteAccount($params, $vars);
        if (isset($response) && $response['message'] == 1) {
            if ($host->server_whm['whm_user'] == 'root') {
                $package = $host->info_package['package_name'];
            } else {
                $package = $host->server_whm['whm_user'] . '_' . $host->info_package['package_name'];
            }
            $ho = array(
                'api.version' => 1,
                'username' => $host->username,
                'domain' => $host->domain_name,
                'contactemail' => $host->email,
                'pkgname' => $package,
                'password' => $host->password,
            );
            $response = cpanel_CreateAccount($params, $ho);
            if (isset($response) && $response['message'] == 1) {

                Logs::create([
                    'data' => '0',
                    'action' => 'Thục hiện cài đặt lại hosting mã số #' . $host->id,
                    'description' => 'Thực hiện hành động cài đặt lại hosting với địa chỉ ip' . request()->ip(),
                    'old_data' => 0,
                    'new_data' => 0,
                    'user_id' => $host->user_id,
                    'ip' => request()->ip(),
                    'data_json' => '',
                ]);

                return response()->json([
                    'status' => 200,
                    'message' => 'Hosting của bạn đã được cài đặt lại thành công.',
                ]);

            } else {
                $content = "Thông Báo Lỗi\n";
                $content .= 'cPanel API Response: ' . $response['message'];
                Helper::sendMessageTelegramAuto($content);
                return response()->json([
                    'status' => 400,
                    'message' => 'Đã xảy ra lỗi khi tạo hosting, vui lòng liên hệ admin',
                ], 400);
            }


        } else {
            return response()->json([
                'status' => 400,
                'message' => 'cPanel API Response: ' . $response['message'],
            ], 400);
        }
    }
}