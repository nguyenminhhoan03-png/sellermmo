<?php
 namespace App\Http\Controllers\Domain;

 use App\Models\Domain;
 use Illuminate\Http\Request;
 use App\Http\Controllers\Controller;
 use App\Models\User;

 
 class WhoisApiController extends Controller
 {
     public function showWhoisDomain()
     {
         return view('domain.whois', [
            'pageTitle' => 'Kiểm tra - Tra cứu thông tin tên miền ',
        ]);

     }
 }
 