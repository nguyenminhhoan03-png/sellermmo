<?php

namespace App\Http\Controllers\Ai;

use App\Http\Controllers\Controller;
use App\Helpers\Helper;
use App\Models\AiAccount;
use App\Models\AiAccountOrder;
use App\Models\Logs;
use App\Models\Slug;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Events\GlobalPurchaseEvent;
use App\Models\TransferOrder;

class AiAccountController extends Controller
{
    public function index(Request $request)
    {
        $categoryId = $request->query('category_id');
        $q = $request->query('q');

        $query = AiAccount::where('status', 1)
            ->withMin('variant', 'price')
            ->withMax('variant', 'price')
            ->orderBy('id', 'desc');

        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }

        if ($q) {
            $query->where('name', 'like', '%' . $q . '%');
        }

        $aiAccounts = $query->paginate(24)->withQueryString();

        $aiCategories = DB::table('ai_account_categories')
            ->where('is_active', 1)
            ->orderBy('name', 'asc')
            ->get();

        $aiCategoryCounts = AiAccount::where('status', 1)
            ->selectRaw('category_id, COUNT(*) as cnt')
            ->groupBy('category_id')
            ->pluck('cnt', 'category_id')
            ->toArray();

        return view('ai.index', [
            'pageTitle' => 'Tài Khoản AI Giá Rẻ – Mua Bán AI Accounts Tự Động',
            'aiAccounts' => $aiAccounts,
            'aiCategories' => $aiCategories,
            'aiCategoryCounts' => $aiCategoryCounts,
            'selectedCategoryId' => $categoryId,
            'q' => $q
        ]);
    }

    public function payment(Request $request)
    {
        if (env('PRJ_DEMO_MODE', false) === true) {
            return response()->json(['status' => 500, 'message' => 'Chức năng này không hoạt động trong chế độ demo.'], 500);
        }
        $payload = $request->validate([
            'variant_id' => 'required|integer',
            'account_id' => 'required|integer',
            'coupon'     => 'nullable|string',
        ]);

        $variant = DB::table('ai_accounts_variant')->where('id', $payload['variant_id'])->where('account_id', $payload['account_id'])->first();
        if (!$variant) {
            return response()->json(['status' => 404, 'message' => 'Không tìm thấy gói AI này.'], 404);
        }
        if ($variant->stock_quantity <= 0) {
            return response()->json(['status' => 400, 'message' => 'Gói này đã hết hàng, vui lòng chọn gói khác.'], 400);
        }

        $user = User::find(auth()->user()->id);
        if (!$user) {
            return response()->json(['status' => 401, 'message' => 'Bạn cần phải đăng nhập để sử dụng tính năng này.'], 401);
        }
        if ($user->loai == 'demo') {
            return response()->json(['status' => 401, 'message' => 'Bạn đang sử dụng tài khoản demo'], 401);
        }
        if ($user->banned !== 0) {
            return response()->json(['status' => 400, 'message' => 'Tài khoản của bạn đang bị khóa, vui lòng liên hệ admin để được hỗ trợ.'], 400);
        }

        $price = (float) $variant->price;
        $coupon = $payload['coupon'] ?? null;
        if ($coupon) {
            $voucher = \App\Models\Voucher::where('code', $coupon)->where('type', 'ai')->where('qty', '>', 0)->first();
            if ($voucher && now()->lessThanOrEqualTo($voucher->expire_date)) {
                $price = $price - ($price * $voucher->value / 100);
                $voucher->decrement('qty');
            }
        }

        if ($user->balance < $price) {
            return response()->json(['status' => 403, 'message' => 'Số dư tài khoản không đủ để mua gói này.'], 403);
        }

        if ($user->decrement('balance', $price) === false) {
            return response()->json(['status' => 500, 'message' => 'Đã có lỗi trong quá trình thanh toán, vui lòng liên hệ admin.'], 500);
        }

        // Giảm tồn kho
        DB::table('ai_accounts_variant')->where('id', $variant->id)->decrement('stock_quantity');

        $trans_id = Helper::random('QWERTYUIOPASDFGHJKZXCVBNM', 2) . time();
        $expiry_date = $variant->duration_days ? now()->addDays((int) $variant->duration_days) : null;

        $order = AiAccountOrder::create([
            'user_id'       => $user->id,
            'ai_account_id' => $payload['account_id'],
            'variant_id'    => $variant->id,
            'trans_id'      => $trans_id,
            'price'         => $price,
            'status'        => 'paid',
            'note'          => $variant->variant_name,
            'expiry_date'   => $expiry_date,
        ]);

        Transaction::create([
            'code'           => $trans_id,
            'amount'         => $price,
            'balance_before' => $user->balance + $price,
            'balance_after'  => $user->balance,
            'type'           => 'new-order',
            'status'         => 'paid',
            'content'        => '[AI] ' . $variant->variant_name . ' ; Thanh toán thành công cho người dùng ' . $user->username,
            'extras'         => ['order_id' => $order->id, 'order_code' => $trans_id],
            'user_id'        => $user->id,
            'username'       => $user->username,
            'order_id'       => $order->id,
        ]);
        // Ghi log mua tài khoản AI
        Logs::create([
            'data'        => '0',
            'action'      => 'Mua tài khoản AI: ' . $variant->variant_name,
            'description' => 'Thực hiện mua AI với địa chỉ ip ' . request()->ip(),
            'old_data'    => 0,
            'new_data'    => 0,
            'user_id'     => $user->id,
            'ip'          => request()->ip(),
            'data_json'   => '',
        ]);

         try {
            broadcast(new GlobalPurchaseEvent([
                'userName' => $user->name,
                'productName' => 'AI Account: ' . $variant->variant_name,
                'productPrice' => number_format($price) . ' đ',
                'location' => 'Việt Nam',
                'time' => now()->toDateTimeString()
            ]));
        } catch (\Exception $e) {
            // Ghi log lỗi
            \Illuminate\Support\Facades\Log::error('GlobalPurchaseEvent Error: ' . $e->getMessage());
        }

        return response()->json([
            'status'  => 200,
            'message' => 'Mua tài khoản AI thành công!',
        ], 200);
    }

    public function transferPayment(Request $request)
    {
        if (env('PRJ_DEMO_MODE', false) === true) {
            return response()->json(['status' => 500, 'message' => 'Chức năng này không hoạt động trong chế độ demo.'], 500);
        }
        $payload = $request->validate([
            'variant_id' => 'required|integer',
            'account_id' => 'required|integer',
            'bank'       => 'required|string',
            'coupon'     => 'nullable|string',
        ]);

        $variant = DB::table('ai_accounts_variant')->where('id', $payload['variant_id'])->where('account_id', $payload['account_id'])->first();
        if (!$variant) {
            return response()->json(['status' => 404, 'message' => 'Không tìm thấy gói AI này.'], 404);
        }
        if ($variant->stock_quantity <= 0) {
            return response()->json(['status' => 400, 'message' => 'Gói này đã hết hàng, vui lòng chọn gói khác.'], 400);
        }

        $user = User::find(auth()->user()->id);
        if ($user->loai == 'demo') {
            return response()->json(['status' => 401, 'message' => 'Bạn đang sử dụng tài khoản demo'], 401);
        }
        if ($user->banned !== 0) {
            return response()->json(['status' => 400, 'message' => 'Tài khoản của bạn đang bị khóa.'], 400);
        }

        $price = (float) $variant->price;
        $coupon = $payload['coupon'] ?? null;
        if ($coupon) {
            $voucher = \App\Models\Voucher::where('code', $coupon)->where('type', 'ai')->where('qty', '>', 0)->first();
            if ($voucher && now()->lessThanOrEqualTo($voucher->expire_date)) {
                $price = $price - ($price * $voucher->value / 100);
            }
        }

        if ($price == 0) {
            return response()->json(['status' => 400, 'message' => 'Gói này miễn phí, không cần chuyển khoản.'], 400);
        }

        $count = TransferOrder::where('user_id', $user->id)->where('status', '1')->count();
        if ($count >= 3) {
            return response()->json(['status' => 400, 'message' => 'Bạn chỉ được phép có tối đa 3 hóa đơn chờ xử lý'], 400);
        }

        $info     = Helper::getConfig('deposit_info');
        $trans_id = Helper::random('QWERTYUIOPASDFGHJKZXCVBNM', 2) . time();

        $content = [
            'type'       => 'ai',
            'account_id' => $payload['account_id'],
            'variant_id' => $payload['variant_id'],
        ];

        $transfer_order = TransferOrder::create([
            'user_id'  => $user->id,
            'trans_id' => $trans_id,
            'noidung'  => '',
            'bank'     => $payload['bank'],
            'price'    => $price,
            'content'  => $content,
            'status'   => 1,
        ]);

        $prefix  = $info['transfer'] ?? 'THANHTOAN';
        $noidung = $prefix . $transfer_order->id;
        $transfer_order->update(['noidung' => $noidung]);

        return response()->json([
            'status'       => 200,
            'message'      => 'Tạo hóa đơn thành công.',
            'redirect_url' => route('transfer.checkout', ['id' => $transfer_order->id]),
        ], 200);
    }

    public function detail(string $slug)
    {
        // Tra cứu theo slug trước, fallback về id số (backward compat)
        $slugRow = Slug::find($slug, 'ai');
        $id      = $slugRow ? $slugRow->slug_id : (is_numeric($slug) ? (int) $slug : null);

        if (!$id) {
            abort(404, 'Không tìm thấy tài khoản AI.');
        }

        $account = DB::table('ai_accounts as a')
            ->leftJoin('ai_account_categories as c', 'a.category_id', '=', 'c.id')
            ->select(
                'a.id',
                'a.name',
                'a.image',
                'a.category_id',
                'a.description',
                'a.account_info',
                'a.status',
                'a.created_at',
                'c.name as category_name',
                'c.slug as category_slug'
            )
            ->where('a.id', $id)
            ->where('a.status', 1)
            ->first();

        // Redirect 301 về slug chuẩn nếu vào bằng id cũ
        if ($account && !$slugRow && is_numeric($slug)) {
            $canonicalSlug = Slug::of('ai', $account->id);
            if ($canonicalSlug) {
                return redirect()->route('ai-account.detail', $canonicalSlug, 301);
            }
        }

        if (!$account) {
            abort(404, 'Không tìm thấy tài khoản AI.');
        }

        $variants = DB::table('ai_accounts_variant')
            ->where('account_id', $account->id)
            ->orderBy('price', 'asc')
            ->get();

        $relatedAccounts = DB::table('ai_accounts')
            ->select('id', 'name', 'image', 'account_info')
            ->where('status', 1)
            ->where('id', '!=', $account->id)
            ->where('category_id', $account->category_id ?? 0)
            ->orderBy('id', 'desc')
            ->limit(6)
            ->get();

        // Fallback: if same-category accounts are not enough, fill with newest AI accounts.
        if ($relatedAccounts->count() < 6) {
            $excludeIds = $relatedAccounts->pluck('id')->push($account->id)->all();
            $fallbackAccounts = DB::table('ai_accounts')
                ->select('id', 'name', 'image', 'account_info')
                ->where('status', 1)
                ->whereNotIn('id', $excludeIds)
                ->orderBy('id', 'desc')
                ->limit(6 - $relatedAccounts->count())
                ->get();

            $relatedAccounts = $relatedAccounts->concat($fallbackAccounts);
        }

        $aiCategories = DB::table('ai_account_categories')
            ->select('id', 'name', 'slug')
            ->where('is_active', 1)
            ->orderBy('name', 'asc')
            ->get();

        // The ai_accounts table in this project does not have a price column.
        // Use the cheapest variant as display price on detail page.
        $account->price = $variants->min('price') ?? 0;

        // Keep AI comments separate from code comments in the shared comments table.
        $commentPostId = 1000000 + (int) $account->id;

        return view('fe.ai-detail', compact('account', 'variants', 'commentPostId', 'relatedAccounts', 'aiCategories'));
    }
}
