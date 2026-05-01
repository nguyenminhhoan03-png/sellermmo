<?php

namespace App\Http\Controllers;

use App\Models\AiAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Domain;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        // Products: card render qua AJAX, chỉ cần id để paginate
        $products = Product::select('id')
            ->where('status', 1)
            ->orderBy('id', 'desc')
            ->paginate(12, ['id'], 'products_page');

        // Domains: hiển thị slider tên miền
        $domains = Domain::select('id', 'name', 'price', 'sale')
            ->where('status', 1)->get();

        // Search: autocomplete chỉ cần id + name
        $productResults = Product::select('id', 'name')->where('status', 1)->orderBy('id', 'desc')->get();
        $aiResults = AiAccount::select('id', 'name')->where('status', 1)->orderBy('id', 'desc')->get();
        $seach = $productResults->concat($aiResults);

        // AI cards + category_id để filter client-side
        $ai = AiAccount::select('id', 'name', 'image', 'account_info', 'category_id')
            ->where('status', 1)
            ->orderBy('id', 'desc')
            ->withMin('variant', 'price')
            ->withMax('variant', 'price')
            ->paginate(18, ['id', 'name', 'image', 'account_info', 'category_id'], 'ai_page');

        // Danh mục AI + số lượng thực tế
        $aiCategories = DB::table('ai_account_categories')
            ->where('is_active', 1)
            ->orderBy('id')
            ->get(['id', 'name', 'slug']);

        $aiCategoryCounts = AiAccount::where('status', 1)
            ->selectRaw('category_id, COUNT(*) as cnt')
            ->groupBy('category_id')
            ->pluck('cnt', 'category_id')
            ->toArray();

        return view('fe.dash', compact('products', 'domains', 'seach', 'ai', 'aiCategories', 'aiCategoryCounts'));
    }
    public function home()
    {
        $products = Product::select('id')
            ->where('status', 1)
            ->orderBy('id', 'desc')
            ->paginate(12, ['id'], 'products_page');

        $domains = Domain::select('id', 'name', 'price', 'sale')
            ->where('status', 1)->get();

        $productResults = Product::select('id', 'name')->where('status', 1)->orderBy('id', 'desc')->get();
        $aiResults = AiAccount::select('id', 'name')->where('status', 1)->orderBy('id', 'desc')->get();
        $seach = $productResults->concat($aiResults);

        $ai = AiAccount::select('id', 'name', 'image', 'account_info', 'category_id')
            ->where('status', 1)
            ->orderBy('id', 'desc')
            ->withMin('variant', 'price')
            ->withMax('variant', 'price')
            ->paginate(18, ['id', 'name', 'image', 'account_info', 'category_id'], 'ai_page');

        $aiCategories = DB::table('ai_account_categories')
            ->where('is_active', 1)
            ->orderBy('id')
            ->get(['id', 'name', 'slug']);

        $aiCategoryCounts = AiAccount::where('status', 1)
            ->selectRaw('category_id, COUNT(*) as cnt')
            ->groupBy('category_id')
            ->pluck('cnt', 'category_id')
            ->toArray();

        return view('fe.dash', compact('products', 'domains', 'seach', 'ai', 'aiCategories', 'aiCategoryCounts'));
    }
    public function terms_condition()
    {
        return view('fe.dieukhoan');
    }
}
