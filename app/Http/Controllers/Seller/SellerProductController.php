<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Product;
use App\Models\ProductAccount;
use App\Models\ProductVariant;
use App\Models\Logs;
use App\Helpers\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class SellerProductController extends Controller
{
    public function index(Request $request)
    {
        $sellerId = auth()->user()->id;
        $query = Product::where('user_id', $sellerId);

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->input('search') . '%');
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        $products = $query->orderBy('id', 'desc')->get();

        foreach ($products as $product) {
            if (in_array($product->category, ['account', 'mail', 'via_bm', 'clone'])) {
                $product->stock_count = ProductAccount::where('product_id', $product->id)->where('status', 0)->count();
                $product->sold_stock_count = ProductAccount::where('product_id', $product->id)->where('status', 1)->count();
                $product->has_variants = $product->variants()->exists();
                if ($product->has_variants) {
                    $product->variants_summary = $product->variants()->withCount(['accounts' => function($q) {
                        $q->where('status', 0);
                    }])->get();
                }
            } else {
                $product->stock_count = null;
                $product->sold_stock_count = null;
                $product->has_variants = false;
            }
        }

        return view('seller.products.index', [
            'pageTitle' => 'Quản lý sản phẩm',
            'products' => $products
        ]);
    }

    public function create()
    {
        return view('seller.products.upload', [
            'pageTitle' => 'Đăng bán sản phẩm mới'
        ]);
    }

    public function store(Request $request)
    {
        if (env('PRJ_DEMO_MODE', false) === true) {
            return response()->json(['status' => 500, 'message' => 'Chức năng này không hoạt động trong chế độ demo.'], 500);
        }

        $user = User::find(auth()->user()->id);
        if ($user->banned !== 0) {
            return response()->json(['status' => 400, 'message' => 'Tài khoản của bạn đang bị khóa.'], 400);
        }

        $payload = $request->validate([
            'product_name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'ck' => 'nullable|numeric|min:0|max:100',
            'category' => 'required|string',
            'description' => 'required|string',
            'images' => 'required|image|mimes:jpeg,jpg,png,gif,webp|max:4096',
            'list_images' => 'nullable|string',
            'link_demo' => 'nullable|string',
            'link_down' => 'required_unless:category,account,mail,via_bm,clone|nullable|string',
            'accounts_list' => [
                Rule::requiredIf(function () use ($request) {
                    $cat = $request->input('category');
                    $hasVariants = $request->input('has_variants', 0);
                    return in_array($cat, ['account', 'mail', 'via_bm', 'clone']) && empty($hasVariants);
                }),
                'nullable',
                'string',
            ],
        ], [
            'product_name.required' => 'Tên sản phẩm là bắt buộc.',
            'price.required' => 'Giá sản phẩm là bắt buộc.',
            'category.required' => 'Danh mục là bắt buộc.',
            'description.required' => 'Mô tả là bắt buộc.',
            'images.required' => 'Ảnh đại diện là bắt buộc.',
            'link_down.required_unless' => 'Link tải xuống là bắt buộc đối với loại này.',
        ]);

        // Image upload with Local Fallback
        $photo = $request->file('images');
        $url = null;
        try {
            $client_id = "4ec3406826c04ac";
            $response = Http::timeout(8)->withHeaders([
                'Authorization' => 'Client-ID ' . $client_id
            ])->post('https://api.imgur.com/3/image.json', [
                'image' => base64_encode(file_get_contents($photo->getRealPath()))
            ]);
            
            $reply = $response->json();
            if ($reply['success'] ?? false) {
                $url = $reply['data']['link'];
            }
        } catch (\Exception $e) {
            // Log or ignore to use local fallback
        }

        if (!$url) {
            // Local upload fallback
            $filename = time() . '_' . str()->random(8) . '.' . $photo->getClientOriginalExtension();
            $photo->move(public_path('uploads/products'), $filename);
            $url = '/uploads/products/' . $filename;
        }

        $variants = $request->input('variants');
        $hasVariants = $request->input('has_variants', 0);
        $finalPrice = $payload['price'];
        if ($hasVariants && !empty($variants)) {
            $firstVar = reset($variants);
            if (isset($firstVar['price']) && is_numeric($firstVar['price']) && $firstVar['price'] >= 0) {
                $finalPrice = $firstVar['price'];
            }
        }

        $product = Product::create([
            'name' => $payload['product_name'],
            'user_id' => $user->id,
            'price' => $finalPrice,
            'images' => $url,
            'list_images' => $payload['list_images'] ?? '',
            'intro' => $payload['description'],
            'view' => 0,
            'sold' => 0,
            'link_down' => isset($payload['link_down']) ? Helper::muabanwebsite_enc($payload['link_down']) : '',
            'link_demo' => $payload['link_demo'] ?? '',
            'status' => 2, // Pending admin approval
            'ck' => $payload['ck'] ?? 0,
            'category' => $payload['category'],
        ]);

        if (in_array($payload['category'], ['account', 'mail', 'via_bm', 'clone'])) {
            if ($hasVariants && $request->has('variants')) {
                foreach ($request->input('variants') as $v) {
                    if (empty($v['name']) || !isset($v['price']) || !is_numeric($v['price']) || $v['price'] < 0) continue;
                    $variant = ProductVariant::create([
                        'product_id' => $product->id,
                        'name' => $v['name'],
                        'price' => $v['price'],
                        'old_price' => $v['old_price'] ?? 0,
                    ]);

                    if (!empty($v['accounts'])) {
                        $lines = explode("\n", str_replace("\r", "", $v['accounts']));
                        foreach ($lines as $line) {
                            $line = trim($line);
                            if (empty($line)) continue;
                            ProductAccount::create([
                                'product_id' => $product->id,
                                'variant_id' => $variant->id,
                                'account_info' => $line,
                                'status' => 0,
                            ]);
                        }
                    }
                }
            } else if (!empty($payload['accounts_list'])) {
                $lines = explode("\n", str_replace("\r", "", $payload['accounts_list']));
                foreach ($lines as $line) {
                    $line = trim($line);
                    if (empty($line)) continue;
                    ProductAccount::create([
                        'product_id' => $product->id,
                        'variant_id' => null,
                        'account_info' => $line,
                        'status' => 0,
                    ]);
                }
            }
        }

        Logs::create([
            'data' => '0',
            'action' => 'Đăng tải sản phẩm ' . $payload['product_name'] . ' với giá ' . number_format($payload['price']) . 'đ',
            'description' => 'Đăng sản phẩm mới qua địa chỉ IP ' . request()->ip(),
            'old_data' => 0,
            'new_data' => 0,
            'user_id' => $user->id,
            'ip' => request()->ip(),
            'data_json' => '',
        ]);

        $content = "┏━━━━━━━━━━━━━━━┓\n";
        $content .= "┣➤ Người bán: " . $user->name . "\n";
        $content .= "┣➤ Tên sản phẩm: " . $payload['product_name'] . "\n";
        $content .= "┣➤ Phân loại: " . (Product::CATEGORIES[$payload['category']]['label'] ?? $payload['category']) . "\n";
        $content .= "┣➤ GIÁ: " . number_format($payload['price']) . "đ\n";
        $content .= "┣➤ TRẠNG THÁI: CHỜ DUYỆT\n";
        $content .= "┗━━━━━━━━━━━━━━━┛\n";
        Helper::sendMessageTelegramAuto($content);

        return response()->json(['status' => 200, 'message' => 'Gửi sản phẩm thành công! Vui lòng chờ quản trị viên phê duyệt.'], 200);
    }

    public function edit(int $id)
    {
        $product = Product::findOrFail($id);
        if ($product->user_id != auth()->user()->id && auth()->user()->level != 1) {
            return abort(403, 'Bạn không có quyền chỉnh sửa sản phẩm này.');
        }

        $stockCount = ProductAccount::where('product_id', $product->id)->where('status', 0)->count();
        $soldCount = ProductAccount::where('product_id', $product->id)->where('status', 1)->count();
        
        $variants = $product->variants()->withCount(['accounts' => function($q) {
            $q->where('status', 0);
        }])->get();

        return view('seller.products.edit', [
            'pageTitle' => 'Chỉnh sửa sản phẩm',
            'product' => $product,
            'stockCount' => $stockCount,
            'soldCount' => $soldCount,
            'variants' => $variants
        ]);
    }

    public function update(Request $request, int $id)
    {
        $product = Product::findOrFail($id);
        if ($product->user_id != auth()->user()->id && auth()->user()->level != 1) {
            return abort(403);
        }

        $payload = $request->validate([
            'product_name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'ck' => 'nullable|numeric|min:0|max:100',
            'category' => 'required|string',
            'description' => 'required|string',
            'images' => 'nullable|image|mimes:jpeg,jpg,png,gif,webp|max:4096',
            'list_images' => 'nullable|string',
            'link_demo' => 'nullable|string',
            'link_down' => 'required_unless:category,account,mail,via_bm,clone|nullable|string',
            'add_accounts_list' => 'nullable|string',
        ], [
            'product_name.required' => 'Tên sản phẩm là bắt buộc.',
            'price.required' => 'Giá sản phẩm là bắt buộc.',
            'category.required' => 'Danh mục là bắt buộc.',
            'description.required' => 'Mô tả là bắt buộc.',
            'link_down.required_unless' => 'Link tải xuống là bắt buộc đối với loại này.',
        ]);

        $url = $product->images;
        if ($request->hasFile('images')) {
            $photo = $request->file('images');
            try {
                $client_id = "4ec3406826c04ac";
                $response = Http::timeout(8)->withHeaders([
                    'Authorization' => 'Client-ID ' . $client_id
                ])->post('https://api.imgur.com/3/image.json', [
                    'image' => base64_encode(file_get_contents($photo->getRealPath()))
                ]);
                
                $reply = $response->json();
                if ($reply['success'] ?? false) {
                    $url = $reply['data']['link'];
                }
            } catch (\Exception $e) {
                // Fallback to local
            }

            if ($url === $product->images) {
                // Local upload fallback
                $filename = time() . '_' . str()->random(8) . '.' . $photo->getClientOriginalExtension();
                $photo->move(public_path('uploads/products'), $filename);
                $url = '/uploads/products/' . $filename;
            }
        }

        $variants = $request->input('variants');
        $hasVariants = $request->input('has_variants', 0);
        $finalPrice = $payload['price'];
        if ($hasVariants && !empty($variants)) {
            $firstVar = reset($variants);
            if (isset($firstVar['price']) && is_numeric($firstVar['price']) && $firstVar['price'] >= 0) {
                $finalPrice = $firstVar['price'];
            }
        }

        $product->update([
            'name' => $payload['product_name'],
            'price' => $finalPrice,
            'images' => $url,
            'list_images' => $payload['list_images'] ?? '',
            'intro' => $payload['description'],
            'link_down' => isset($payload['link_down']) ? Helper::muabanwebsite_enc($payload['link_down']) : $product->link_down,
            'link_demo' => $payload['link_demo'] ?? '',
            'ck' => $payload['ck'] ?? 0,
            'category' => $payload['category'],
        ]);

        if (in_array($payload['category'], ['account', 'mail', 'via_bm', 'clone'])) {
            if ($hasVariants && $request->has('variants')) {
                $activeVariantIds = [];
                
                foreach ($request->input('variants') as $key => $v) {
                    if (empty($v['name']) || !isset($v['price']) || !is_numeric($v['price']) || $v['price'] < 0) continue;
                    
                    if (is_numeric($key)) {
                        $variant = ProductVariant::where('product_id', $product->id)->find($key);
                        if ($variant) {
                            $variant->update([
                                'name' => $v['name'],
                                'price' => $v['price'],
                                'old_price' => $v['old_price'] ?? 0,
                            ]);
                            $activeVariantIds[] = $variant->id;
                        }
                    } else {
                        $variant = ProductVariant::create([
                            'product_id' => $product->id,
                            'name' => $v['name'],
                            'price' => $v['price'],
                            'old_price' => $v['old_price'] ?? 0,
                        ]);
                        $activeVariantIds[] = $variant->id;
                    }

                    if (!empty($v['add_accounts'])) {
                        $lines = explode("\n", str_replace("\r", "", $v['add_accounts']));
                        foreach ($lines as $line) {
                            $line = trim($line);
                            if (empty($line)) continue;
                            ProductAccount::create([
                                'product_id' => $product->id,
                                'variant_id' => $variant->id,
                                'account_info' => $line,
                                'status' => 0,
                            ]);
                        }
                    }
                }
                
                // Cleanup removed variants
                $deletedVariants = ProductVariant::where('product_id', $product->id)
                    ->whereNotIn('id', $activeVariantIds)
                    ->get();
                foreach ($deletedVariants as $dv) {
                    ProductAccount::where('variant_id', $dv->id)->delete();
                    $dv->delete();
                }
            } else {
                // Delete existing variants
                $deletedVariants = ProductVariant::where('product_id', $product->id)->get();
                foreach ($deletedVariants as $dv) {
                    ProductAccount::where('variant_id', $dv->id)->delete();
                    $dv->delete();
                }

                if (!empty($payload['add_accounts_list'])) {
                    $lines = explode("\n", str_replace("\r", "", $payload['add_accounts_list']));
                    foreach ($lines as $line) {
                        $line = trim($line);
                        if (empty($line)) continue;
                        ProductAccount::create([
                            'product_id' => $product->id,
                            'variant_id' => null,
                            'account_info' => $line,
                            'status' => 0,
                        ]);
                    }
                }
            }
        }

        return redirect()->route('seller.products')->with('success', 'Cập nhật sản phẩm thành công!');
    }

    public function delete(Request $request)
    {
        $id = $request->input('id');
        $product = Product::findOrFail($id);
        if ($product->user_id != auth()->user()->id && auth()->user()->level != 1) {
            return response()->json(['status' => 403, 'message' => 'Bạn không có quyền thực hiện hành động này.'], 403);
        }

        ProductAccount::where('product_id', $product->id)->delete();
        ProductVariant::where('product_id', $product->id)->delete();
        $product->delete();

        return response()->json(['status' => 200, 'message' => 'Xóa sản phẩm thành công.'], 200);
    }

    public function toggleStatus(Request $request)
    {
        $id = $request->input('id');
        $product = Product::findOrFail($id);
        if ($product->user_id != auth()->user()->id && auth()->user()->level != 1) {
            return response()->json(['status' => 403, 'message' => 'Bạn không có quyền thực hiện hành động này.'], 403);
        }

        if ($product->status == 2) {
            return response()->json(['status' => 400, 'message' => 'Sản phẩm đang chờ Admin duyệt, không thể thay đổi trạng thái.'], 400);
        }

        $newStatus = $product->status == 1 ? 0 : 1;
        $product->update(['status' => $newStatus]);

        $statusText = $newStatus == 1 ? 'HIỂN THỊ (ĐANG BÁN)' : 'ẨN SẢN PHẨM';
        return response()->json([
            'status' => 200,
            'message' => 'Đã cập nhật trạng thái thành công.',
            'new_status' => $newStatus,
            'status_text' => $statusText
        ], 200);
    }
}
