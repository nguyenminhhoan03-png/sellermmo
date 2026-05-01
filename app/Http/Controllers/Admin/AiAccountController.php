<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\AiAccount;
use App\Models\AiAccountCategory;
use App\Models\AiAccountOrder;
use App\Models\AiAccountVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class AiAccountController extends Controller
{
    // ─── Danh sách tài khoản AI ──────────────────────────────────────────────

    public function index(Request $request)
    {
        $accounts   = AiAccount::with(['variant'])->withCount('variant')->orderBy('id', 'desc')->paginate(20);
        $categories = DB::table('ai_account_categories')->where('is_active', 1)->orderBy('id')->get();

        return view('admin.ai.index', compact('accounts', 'categories'));
    }

    public function create()
    {
        $categories = DB::table('ai_account_categories')->where('is_active', 1)->orderBy('id')->get();

        return view('admin.ai.form', compact('categories'));
    }

    public function edit(int $id)
    {
        $account    = AiAccount::with('variant')->findOrFail($id);
        $categories = DB::table('ai_account_categories')->where('is_active', 1)->orderBy('id')->get();

        return view('admin.ai.form', compact('account', 'categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'account_info'=> 'nullable|string|max:500',
            'category_id' => 'nullable|integer',
            'status'      => 'required|integer',
            'image'       => 'nullable|image|mimes:jpeg,jpg,png,gif,webp|max:4096',
        ]);

        if ($request->hasFile('image')) {
            $file     = $request->file('image');
            $filename = time() . '_' . Str::slug($data['name']) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/ai'), $filename);
            $data['image'] = 'uploads/ai/' . $filename;
        }

        $account = AiAccount::create($data);

        // Lưu các biến thể được xếp hàng từ trang tạo mới
        if ($request->has('variants')) {
            foreach ($request->input('variants') as $v) {
                if (empty($v['variant_name']) || !isset($v['price'])) continue;
                AiAccountVariant::create([
                    'account_id'     => $account->id,
                    'variant_name'   => $v['variant_name'],
                    'price'          => $v['price'],
                    'old_price'      => $v['old_price'] ?? 0,
                    'stock_quantity' => $v['stock_quantity'] ?? 999,
                    'duration_days'  => $v['duration_days'] ?: null,
                    'sku'            => $v['sku'] ?: null,
                ]);
            }
        }

        Helper::addLogs('Thêm tài khoản AI #' . $account->id . ': ' . $account->name);

        return redirect()->route('admin.ai.edit', $account->id)->with('success', 'Tạo tài khoản AI thành công! Bạn có thể quản lý biến thể bên dưới.');
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'id'          => 'required|integer',
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'account_info'=> 'nullable|string|max:500',
            'category_id' => 'nullable|integer',
            'status'      => 'required|integer',
            'image'       => 'nullable|image|mimes:jpeg,jpg,png,gif,webp|max:4096',
        ]);

        $account = AiAccount::findOrFail($data['id']);

        if ($request->hasFile('image')) {
            if ($account->image && File::exists(public_path($account->image))) {
                File::delete(public_path($account->image));
            }
            $file     = $request->file('image');
            $filename = time() . '_' . Str::slug($data['name']) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/ai'), $filename);
            $data['image'] = 'uploads/ai/' . $filename;
        } else {
            $data['image'] = $account->image;
        }

        $account->update($data);

        Helper::addLogs('Cập nhật tài khoản AI #' . $account->id);

        return redirect()->route('admin.ai.index')->with('success', 'Cập nhật tài khoản AI thành công!');
    }

    public function updateStatus(Request $request)
    {
        $data = $request->validate([
            'id'     => 'required|integer',
            'status' => 'required|boolean',
        ]);

        AiAccount::where('id', $data['id'])->update(['status' => $data['status']]);

        return response()->json(['status' => 200, 'message' => 'Cập nhật trạng thái thành công.']);
    }

    public function delete(Request $request)
    {
        $data = $request->validate([
            'id' => 'required|integer',
        ]);

        $account = AiAccount::findOrFail($data['id']);

        if ($account->image && File::exists(public_path($account->image))) {
            File::delete(public_path($account->image));
        }

        $account->delete();

        Helper::addLogs('Xóa tài khoản AI #' . $data['id']);

        return response()->json(['status' => 200, 'message' => 'Xóa tài khoản AI thành công.']);
    }

    // ─── Đơn hàng AI ─────────────────────────────────────────────────────────

    public function orders(Request $request)
    {
        $orders = AiAccountOrder::with(['user'])
            ->orderBy('id', 'desc')
            ->paginate(30);

        return view('admin.ai.orders', compact('orders'));
    }

    public function updateOrderStatus(Request $request)
    {
        $data = $request->validate([
            'id'     => 'required|integer',
            'status' => 'required|string|in:pending,paid,delivered,canceled',
        ]);

        $order = AiAccountOrder::findOrFail($data['id']);
        $order->update(['status' => $data['status']]);

        return redirect()->back()->with('success', 'Cập nhật trạng thái đơn hàng thành công!');
    }

    // ─── Biến thể (Variant) ───────────────────────────────────────────────────

    public function storeVariant(Request $request)
    {
        $data = $request->validate([
            'account_id'     => 'required|integer',
            'variant_name'   => 'required|string|max:255',
            'price'          => 'required|numeric|min:0',
            'old_price'      => 'nullable|numeric|min:0',
            'stock_quantity' => 'nullable|integer|min:0',
            'duration_days'  => 'nullable|integer|min:0',
            'sku'            => 'nullable|string|max:100',
        ]);

        $variant = AiAccountVariant::create($data);

        if (request()->expectsJson()) {
            return response()->json(['status' => 200, 'id' => $variant->id, 'message' => 'Thêm biến thể thành công.']);
        }

        return redirect()->back()->with('success', 'Thêm biến thể thành công!');
    }

    public function updateVariant(Request $request)
    {
        $data = $request->validate([
            'id'             => 'required|integer',
            'variant_name'   => 'required|string|max:255',
            'price'          => 'required|numeric|min:0',
            'old_price'      => 'nullable|numeric|min:0',
            'stock_quantity' => 'nullable|integer|min:0',
            'duration_days'  => 'nullable|integer|min:0',
            'sku'            => 'nullable|string|max:100',
        ]);

        $variant = AiAccountVariant::findOrFail($data['id']);
        $variant->update($data);

        return response()->json(['status' => 200, 'message' => 'Cập nhật biến thể thành công.']);
    }

    public function deleteVariant(Request $request)
    {
        $data = $request->validate(['id' => 'required|integer']);
        AiAccountVariant::findOrFail($data['id'])->delete();

        return response()->json(['status' => 200, 'message' => 'Xóa biến thể thành công.']);
    }

    // ─── Danh mục AI ─────────────────────────────────────────────────────────

    public function categories(Request $request)
    {
        $categories = DB::table('ai_account_categories')->orderBy('id')->get();

        return view('admin.ai.categories', compact('categories'));
    }

    public function storeCategory(Request $request)
    {
        $data = $request->validate([
            'name'      => 'required|string|max:100',
            'slug'      => 'required|string|max:100|unique:ai_account_categories,slug',
            'icon_url'  => 'nullable|string|max:255',
            'is_active' => 'required|boolean',
        ]);

        DB::table('ai_account_categories')->insert(array_merge($data, [
            'created_at' => now(),
            'updated_at' => now(),
        ]));

        return redirect()->back()->with('success', 'Thêm danh mục thành công!');
    }

    public function updateCategory(Request $request)
    {
        $data = $request->validate([
            'id'        => 'required|integer',
            'name'      => 'required|string|max:100',
            'slug'      => 'required|string|max:100',
            'icon_url'  => 'nullable|string|max:255',
            'is_active' => 'required|boolean',
        ]);

        DB::table('ai_account_categories')->where('id', $data['id'])->update([
            'name'      => $data['name'],
            'slug'      => $data['slug'],
            'icon_url'  => $data['icon_url'] ?? null,
            'is_active' => $data['is_active'],
            'updated_at'=> now(),
        ]);

        return redirect()->back()->with('success', 'Cập nhật danh mục thành công!');
    }

    public function deleteCategory(Request $request)
    {
        $data = $request->validate(['id' => 'required|integer']);
        DB::table('ai_account_categories')->where('id', $data['id'])->delete();

        return response()->json(['status' => 200, 'message' => 'Xóa danh mục thành công.']);
    }
}
