<?php
 namespace App\Http\Controllers\Reseller;

 use App\Models\User;
 use App\Models\Product;
 use Illuminate\Http\Request;
 use App\Http\Controllers\Controller;
 
 class ResellerController extends Controller
 {
     public function showReseller($id)
     {
         $reseller = User::find($id);
 
         if (!$reseller) {
             return redirect()->route('home')->with('error', 'Chúng tôi không thể tìm thấy người bán này');
         }
         if ($reseller->level != 1 && $reseller->level != 2) {
            return redirect()->route('home')->with('error', 'Người dùng này không phải là người bán hàng');
          }
          $pro_reseller = Product::where('status', 1)->where('user_id', $id)->orderBy('id', 'desc')->get();


         return view('reseller.index', [
            'pageTitle' => 'Cửa Hàng Của Người Bán',
            'reseller' => $reseller,
            'pro_reseller' => $pro_reseller,
        ]);

     }
 }
 