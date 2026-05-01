<?php
 namespace App\Http\Controllers\Domain;

 use App\Models\Product;
 use Illuminate\Http\Request;
 use App\Http\Controllers\Controller;
 use App\Helpers\Helper;
 use App\Models\User;
 use App\Models\Domain;
 use App\Models\DomainOrder;
 
 class ViewHistoryController extends Controller
 {
     public function showViewDomain($id) {
     
      $user = User::find(auth()->user()->id);
      $id_user = $user->id;

      $domain = DomainOrder::where('id', $id)->where('user_id', $id_user)->first();

      if (!$domain) {
        return redirect()->route('domain.history')->with('error', 'Chúng tôi không tìm thấy tên miền này trên lịch sử mua miền của bạn.');
      }
      return view('domain.view', [
            'pageTitle' => 'Thông tin chi tiết tên miền của ' . $user->name,
            'domain' => $domain,
            'user' => $user,
        ]);
     }
  
 }
 