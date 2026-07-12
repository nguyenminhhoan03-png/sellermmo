<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\AiAccount;
use Carbon\Carbon;

class ShopController extends Controller
{
    public function show(Request $request, $username)
    {
        // Find seller or throw 404
        $seller = User::where('username', $username)->firstOrFail();

        // Get Products (Digital Goods/Source code)
        $productsQuery = Product::where('user_id', $seller->id)->where('status', 1)->orderBy('id', 'desc');
        $totalProducts = $productsQuery->count();
        $products = $productsQuery->paginate(12, ['*'], 'products_page');

        // Get Ai Accounts
        $aiQuery = AiAccount::where('seller_id', $seller->id)->where('status', 1)->withMin('variant', 'price')->withMax('variant', 'price')->orderBy('id', 'desc');
        $totalAi = $aiQuery->count();
        $aiAccounts = $aiQuery->paginate(12, ['*'], 'ai_page');

        // Calculate stats
        $joinDays = Carbon::parse($seller->created_at)->diffInDays(Carbon::now());
        if ($joinDays == 0) $joinDays = 1;

        $totalSoldProducts = Product::where('user_id', $seller->id)->sum('sold') ?? 0;
        $totalSold = $totalSoldProducts; // Total sold count
        
        // Trust score mock (since we don't have a real trust system yet)
        $trustScore = min(100, 50 + ($totalSold * 0.1) + ($joinDays * 0.05));

        return view('fe.shop.profile', [
            'pageTitle' => 'Gian hàng của ' . $seller->username,
            'seller' => $seller,
            'products' => $products,
            'aiAccounts' => $aiAccounts,
            'totalItems' => $totalProducts + $totalAi,
            'joinDays' => $joinDays,
            'totalSold' => $totalSold,
            'trustScore' => round($trustScore)
        ]);
    }
}
