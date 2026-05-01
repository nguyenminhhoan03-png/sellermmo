<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Admin
{
  /**
   * Handle an incoming request.
   *
   * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
   */
  public function handle(Request $request, Closure $next): Response
  {
    if (Auth::check() === false) {
      return redirect()->route('login');
    }

    if (Auth::user()->level != '1') {
      return abort(403);
    }
    if (
      env('PRJ_DEMO_MODE', false) === true
      && (
        $request->routeIs('admin.domain.upload')
        || $request->routeIs('admin.manguon.upcode')
        || $request->getMethod() === 'post'
      )
    ) {
      return redirect()->back()->with('error', 'This action is disabled in the demo.');
    }

    if (env('PRJ_DEMO_MODE', false) === true && ($request->isMethod('post') || $request->isMethod('put') || $request->isMethod('delete'))) {
      return response()->json(['status' => 403, 'message' => 'This action is disabled in the demo.'], 403);
    }

    return $next($request);
  }
}
