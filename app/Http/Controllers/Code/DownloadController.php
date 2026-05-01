<?php

namespace App\Http\Controllers\Code;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\Hisproduct;
use App\Models\Logs;
use App\Models\Product;
use App\Models\Slug;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class DownloadController extends Controller
{
    /**
     * Trang trung gian cho sản phẩm FREE (price = 0).
     * - Ghi nhận lượt tải (Hisproduct, Transaction)
     * - Render trang với Adsterra popunder + Linkvertise nút tải
     */
    public function freeDownload(Request $request, int $id)
    {
        $product = Product::where('id', $id)->where('status', 1)->firstOrFail();

        // Bảo vệ: chỉ áp dụng cho sản phẩm miễn phí
        $realPrice = $product->price - ($product->price * $product->ck / 100);
        if ($realPrice > 0) {
            return redirect()->route('code.index', Slug::of('code', $product->id) ?? $product->id)
                ->with('error', 'Sản phẩm này không miễn phí.');
        }

        $user = auth()->user();

        // Ghi lịch sử nếu chưa từng tải
        $already = Hisproduct::where('user_id', $user->id)
            ->where('product_id', $product->id)
            ->exists();

        if (!$already) {
            $trans_id = Helper::random('QWERTYUIOPASDFGHJKZXCVBNM', 2) . time();

            Hisproduct::create([
                'user_id'    => $user->id,
                'product_id' => $product->id,
                'trans_id'   => $trans_id,
                'price'      => 0,
            ]);

            Transaction::create([
                'code'           => $trans_id,
                'amount'         => 0,
                'balance_before' => $user->balance,
                'balance_after'  => $user->balance,
                'type'           => 'new-order',
                'status'         => 'paid',
                'content'        => '[FREE] ' . $product->name . ' - Tải miễn phí',
                'extras'         => ['id' => $product->id, 'order_code' => $trans_id],
                'user_id'        => $user->id,
                'lickey'         => '',
                'username'       => $user->username,
                'order_id'       => $product->id,
            ]);

            $product->increment('sold');

            Logs::create([
                'data'        => '0',
                'action'      => 'Tải miễn phí: ' . $product->name,
                'description' => 'User ' . $user->username . ' tải miễn phí sản phẩm #' . $product->id . ' IP: ' . $request->ip(),
                'old_data'    => 0,
                'new_data'    => 0,
                'user_id'     => $user->id,
                'ip'          => $request->ip(),
                'data_json'   => '',
            ]);
        }

        // Giải mã link thật
        $realLink = Helper::muabanwebsite_dec($product->link_down);

        // Slug để back về trang sản phẩm
        $productSlug = Slug::of('code', $product->id) ?? $product->id;

        return view('code.download', compact('product', 'realLink', 'productSlug'));
    }
}
