<?php 
namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Http\Json\ProductResource;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    public function fetchProducts(Request $request)
    {
        $page     = $request->input('page', 1);
        $category = $request->input('category', null);

        $query = Product::select('id', 'name', 'user_id', 'price', 'ck', 'sold', 'images', 'status', 'category', 'created_at', 'updated_at')
            ->with('user:id,name')
            ->where('status', 1)
            ->orderBy('id', 'desc');

        if ($category && $category !== 'all') {
            $query->where('category', $category);
        }

        $offset = ($page - 1) * 12;

        $products = $query->offset($offset)->limit(12)->get();

        return response()->json([
            'success' => 200,
            'products' => ProductResource::collection($products),
        ]);
    }
}
