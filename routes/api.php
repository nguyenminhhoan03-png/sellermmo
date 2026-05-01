<?php

use App\Http\Middleware\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\WhoisController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
  $user = $request->user();

  $user->balance_formatted = number_format($user->balance);

  return $user;
});
Route::prefix('/vouchers')->group(function () {
    Route::post('/redeem', [App\Http\Controllers\Api\VoucherController::class, 'redeem']);
    Route::post('/aivoucher', [App\Http\Controllers\Api\VoucherController::class, 'aivoucher']);
  });
  Route::prefix('/vouchers')->group(function () {
    Route::post('/voucherdomain', [App\Http\Controllers\Api\VoucherDomainController::class, 'voucherdomain']);
    Route::post('/totalnam', [App\Http\Controllers\Api\VoucherDomainController::class, 'totalnam']);
  });
  Route::get('/whois', [WhoisController::class, 'checkDomain'])->name('api.whois');
  Route::get('/infofb', [App\Http\Controllers\Api\InfoFbController::class, 'uidfb'])->name('api.infofb');
  Route::get('/tiktok', [App\Http\Controllers\Api\TiktokController::class, 'getlinktiktok'])->name('api.tiktok');
  Route::get('/youtube', [App\Http\Controllers\Api\YoutubeController::class, 'youtube'])->name('api.youtube');
  Route::post('/product', [App\Http\Controllers\Api\ProductController::class, 'fetchProducts']);
// webhook telegram
Route::post('/telegram/webhook', [App\Http\Controllers\Telegram\BotController::class, 'handleWebhook']);
// Admin Routes
Route::middleware(['auth:sanctum', Admin::class])->prefix('/Cpanel')->group(function () {
// code
Route::prefix('/code')->group(function () {
  Route::get('/', [App\Http\Controllers\Api\Admin\CodeApiController::class, 'index']);
});
// domain
Route::prefix('/domain')->group(function () {
  Route::get('/', [App\Http\Controllers\Api\Admin\DomainApiController::class, 'index']);
});
// cron
Route::prefix('/cron')->group(function () {
  Route::get('/', [App\Http\Controllers\Api\Admin\CronApiController::class, 'index']);
});
// users
Route::prefix('/users')->group(function () {
  Route::get('/', [App\Http\Controllers\Api\Admin\UserController::class, 'index']);
});

});
// slug
Route::post('/slug', [App\Http\Controllers\Api\SlugController::class, 'Slug'])->name('slug');

// SePay Webhook - Nơi nhận dòng tiền chảy về
// Route::post('/sepay/webhook', [\App\Http\Controllers\Webhook\WebhookController::class, 'sepay'])->name('api.webhook.sepay');
// API WHM
Route::get('/get-account-count', [App\Http\Controllers\Api\Admin\HostingApiController::class, 'getAccountCount']);
// API GET DISK
Route::get('/get-disk', [App\Http\Controllers\Hosting\HostingController::class, 'getDisk']);
// API Check All
Route::get('/get-all', [App\Http\Controllers\Hosting\HostingController::class, 'CheckAll']);
// APi List Url Cron
Route::get('/cron', [App\Http\Controllers\Api\CronController::class, 'getCronData']);
// Api Update Url Cron
Route::post('/update-cron', [App\Http\Controllers\Api\CronController::class, 'updateCron']);
Route::get('/update-cron', [App\Http\Controllers\Api\CronController::class, 'updateCron403']);
// Recent purchases (public – used by purchase toast widget)
Route::get('/recent-purchases', [App\Http\Controllers\Api\RecentPurchaseController::class, 'index'])->name('api.recent-purchases');