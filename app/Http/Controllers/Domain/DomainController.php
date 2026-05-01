<?php
 namespace App\Http\Controllers\Domain;

 use App\Models\Domain;
 use Illuminate\Http\Request;
 use App\Http\Controllers\Controller;
 use App\Models\User;

 
 class DomainController extends Controller
 {
     public function showDomain()
     {

          $domain = Domain::where('status', 1)->get();
         return view('domain.index', [
            'pageTitle' => 'Đăng ký tên miền hỗ trợ khách hàng tốt nhất',
            'domain' => $domain,
        ]);

     }
 }
 