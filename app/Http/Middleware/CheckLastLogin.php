<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\User;

class CheckLastLogin
{
  public function handle(Request $request, Closure $next)
  {
    if (!Auth::check()) {
        return redirect()->route('login')->with('error', 'Bạn cần đăng nhập để truy cập trang này.');
    }
    $user = Auth::user();
    if ($user->banned == 1) {
      Auth::logout();
      return redirect()->route('login')->with('error', 'Tài khoản của bạn đã bị khóa vui lòng ib admin');
    }
    if ($user) {
      $time = time();
      User::update_time_request($user->id, $time); 
    }
    return $next($request);
  }
}
