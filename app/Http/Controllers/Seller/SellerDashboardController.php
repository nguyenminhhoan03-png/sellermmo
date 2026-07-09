<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Product;
use App\Models\Hisproduct;
use App\Models\Transaction;
use App\Models\WithdrawCtv;
use App\Models\Logs;
use App\Helpers\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SellerDashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $sellerId = $user->id;

        // Statistics
        $totalRevenue = DB::table('tbl_his_code')
            ->join('tbl_list_code', 'tbl_his_code.product_id', '=', 'tbl_list_code.id')
            ->where('tbl_list_code.user_id', $sellerId)
            ->sum('tbl_his_code.price');

        $todayRevenue = DB::table('tbl_his_code')
            ->join('tbl_list_code', 'tbl_his_code.product_id', '=', 'tbl_list_code.id')
            ->where('tbl_list_code.user_id', $sellerId)
            ->whereDate('tbl_his_code.created_at', Carbon::today())
            ->sum('tbl_his_code.price');

        $monthRevenue = DB::table('tbl_his_code')
            ->join('tbl_list_code', 'tbl_his_code.product_id', '=', 'tbl_list_code.id')
            ->where('tbl_list_code.user_id', $sellerId)
            ->whereMonth('tbl_his_code.created_at', Carbon::now()->month)
            ->whereYear('tbl_his_code.created_at', Carbon::now()->year)
            ->sum('tbl_his_code.price');

        $totalProducts = Product::where('user_id', $sellerId)->count();
        $totalSold = Product::where('user_id', $sellerId)->sum('sold');

        // Recent sales history
        $latestSales = DB::table('tbl_his_code')
            ->select('tbl_his_code.*', 'tbl_list_code.name as product_name', 'users.username as buyer_name')
            ->join('tbl_list_code', 'tbl_his_code.product_id', '=', 'tbl_list_code.id')
            ->join('users', 'tbl_his_code.user_id', '=', 'users.id')
            ->where('tbl_list_code.user_id', $sellerId)
            ->orderBy('tbl_his_code.id', 'desc')
            ->limit(5)
            ->get();

        return view('seller.dashboard', [
            'pageTitle' => 'Tổng quan Kênh Người Bán',
            'user' => $user,
            'totalRevenue' => $totalRevenue,
            'todayRevenue' => $todayRevenue,
            'monthRevenue' => $monthRevenue,
            'totalProducts' => $totalProducts,
            'totalSold' => $totalSold,
            'latestSales' => $latestSales
        ]);
    }

    public function revenue()
    {
        $user = auth()->user();
        $sellerId = $user->id;

        $sales = DB::table('tbl_his_code')
            ->select('tbl_his_code.*', 'tbl_list_code.name as product_name', 'users.username as buyer_name')
            ->join('tbl_list_code', 'tbl_his_code.product_id', '=', 'tbl_list_code.id')
            ->join('users', 'tbl_his_code.user_id', '=', 'users.id')
            ->where('tbl_list_code.user_id', $sellerId)
            ->orderBy('tbl_his_code.id', 'desc')
            ->paginate(15);

        return view('seller.revenue', [
            'pageTitle' => 'Lịch sử doanh thu',
            'user' => $user,
            'sales' => $sales
        ]);
    }

    public function withdraw()
    {
        $user = auth()->user();
        $withdrawals = WithdrawCtv::where('user_id', $user->id)->orderBy('id', 'desc')->paginate(15);

        return view('seller.withdraw', [
            'pageTitle' => 'Rút tiền doanh thu',
            'user' => $user,
            'withdrawals' => $withdrawals
        ]);
    }

    public function withdrawPost(Request $request)
    {
        $message = [
            'amount.required' => 'Vui lòng nhập số tiền muốn rút.',
            'amount.integer' => 'Số tiền muốn rút phải là số.',
            'bank.required' => 'Vui lòng chọn ngân hàng rút tiền.',
            'stk.required' => 'Vui lòng nhập số tài khoản.',
            'ctk.required' => 'Vui lòng nhập chủ tài khoản.',
        ];

        $payload = $request->validate([
            'amount' => 'required|integer|min:10000',
            'bank' => 'required|string|max:12',
            'stk' => 'required|string|max:128',
            'ctk' => 'required|string|max:128',
        ], $message);

        $user = User::find(auth()->user()->id);
        $user_id = $user->id;

        $config = Helper::getConfig('general');
        $min_withdraw = $config['minctv'] ?? 0;

        if ($payload['amount'] < $min_withdraw) {
            return redirect()->back()->with('error', 'Số tiền rút tối thiểu là ' . number_format($min_withdraw) . 'đ.');
        }

        if ($payload['amount'] > $user->balance_ctv) {
            return redirect()->back()->with('error', 'Bạn không đủ số dư để thực hiện rút tiền.');
        }

        $trans_id = Helper::random('QWERTYUIOPASDFGHJKZXCVBNM', 2) . time();
        $setting = setting('rutctv');

        if ($setting === 'auto') {
            $description = 'rutctv' . $user->id;
            $walletOrders = WithdrawCtv::create([
                'user_id' => $user_id,
                'price' => $payload['amount'],
                'bank' => $payload['bank'],
                'stk' => $payload['stk'],
                'ctk' => $payload['ctk'],
                'status' => '0',
                'url' => env('LINK_API_RUTTIEN'),
            ]);

            $apiRutController = new \App\Http\Controllers\Account\ApiRutController();
            $dvr = $apiRutController->transferWebme($walletOrders, $description);

            if ($dvr != 1) {
                return redirect()->back()->with('error', $dvr);
            }

            if ($user->decrement('balance_ctv', $payload['amount']) === false) {
                return redirect()->back()->with('error', 'Đã có lỗi trong quá trình thanh toán, vui lòng liên hệ admin.');
            }

            $reg = redirect()->back()->with('success', 'Rút tiền tự động thành công!');
        } else {
            $with = WithdrawCtv::create([
                'user_id' => $user_id,
                'trans_id' => $trans_id,
                'price' => $payload['amount'],
                'bank' => $payload['bank'],
                'stk' => $payload['stk'],
                'ctk' => $payload['ctk'],
                'status' => '0',
                'url' => 'localhost',
            ]);

            Transaction::create([
                'code' => $trans_id,
                'amount' => $payload['amount'],
                'balance_before' => $user->balance_ctv + $payload['amount'],
                'balance_after' => $user->balance_ctv,
                'type' => 'new-order',
                'status' => 'paid',
                'content' => 'Rút tiền CTV; số tiền :' . number_format($payload['amount']) . 'đ; Thanh toán thành công cho người dùng ' . $user->username,
                'extras' => [
                    'id' => $with->id,
                    'order_code' => $trans_id,
                ],
                'user_id' => $user->id,
                'username' => $user->username,
                'order_id' => $with->id,
            ]);

            Logs::create([
                'data' => '0',
                'action' => 'Rút tiền CTV số tiền' . number_format($payload['amount']) . 'đ',
                'description' => 'Thực hiện hành động rút tiền ctv qua địa chỉ ip ' . request()->ip(),
                'old_data' => 0,
                'new_data' => 0,
                'user_id' => $user->id,
                'ip' => request()->ip(),
                'data_json' => '',
            ]);

            if ($user->decrement('balance_ctv', $payload['amount']) === false) {
                return redirect()->back()->with('error', 'Đã có lỗi trong quá trình thanh toán, vui lòng liên hệ admin.');
            }

            $content = "┏━━━━━━━━━━━━━━━┓\n";
            $content .= "┣➤ " . $user->name . "\n";
            $content .= "┣➤ Mã Giao Dịch: " . $trans_id . "\n";
            $content .= "┣➤ NGÂN HÀNG: " . $payload['bank'] . "\n";
            $content .= "┣➤ CHỦ TÀI KHOẢN: " . $payload['ctk'] . "\n";
            $content .= "┣➤ SỐ TÀI KHOẢN: " . $payload['stk'] . "\n";
            $content .= "┣➤ Trạng Thái: CHỜ DUYỆT\n";
            $content .= "┣➤ Tiền rút: " . number_format($payload['amount']) . " đ\n";
            $content .= "┣➤ PHƯƠNG THỨC: DUYỆT TAY\n";
            $content .= "┗━━━━━━━━━━━━━━━┛\n";

            Helper::sendMessageTelegramAuto($content);
            $reg = redirect()->back()->with('success', 'Cảm ơn bạn đã gửi đơn rút tiền, chúng tôi sẽ duyệt sớm nhất!');
        }

        return $reg;
    }

    public function settings()
    {
        $user = auth()->user();
        return view('seller.settings', [
            'pageTitle' => 'Cấu hình gian hàng',
            'user' => $user
        ]);
    }

    public function settingsPost(Request $request)
    {
        $user = User::find(auth()->user()->id);
        $payload = $request->validate([
            'name' => 'required|string|max:255',
            'gioi_thieu' => 'nullable|string|max:1000',
            'skill' => 'nullable|string|max:255',
        ]);

        $user->update($payload);

        return redirect()->back()->with('success', 'Cập nhật cấu hình gian hàng thành công!');
    }
}
