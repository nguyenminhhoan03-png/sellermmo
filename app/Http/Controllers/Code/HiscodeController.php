<?php
 namespace App\Http\Controllers\Code;

 use App\Models\Product;
 use Illuminate\Http\Request;
 use App\Http\Controllers\Controller;
 use App\Models\User;
 use App\Models\Hisproduct;
 
 class HiscodeController extends Controller
 {
     public function showHisCode()
     {
        $user = User::find(auth()->user()->id);
        $id = $user->id;

        $hiscode = Hisproduct::where('user_id', $id)->orderBy('id', 'desc')->get();
         return view('code.history', [
            'pageTitle' => 'Lịch sử mua mã nguồn của ' . $user->name,
            'hiscode' => $hiscode,
            'user' => $user,
        ]);

     }
 }
 