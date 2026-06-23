<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\Admin;
use App\Http\Middleware\CheckLastLogin;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Ai\AiAccountController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Domain\DomainController;
use App\Models\User;

Route::redirect('.env', 'https://www.youtube.com/watch?v=dQw4w9WgXcQ');
Route::redirect('/admin', 'https://www.youtube.com/watch?v=dQw4w9WgXcQ');
Route::redirect('/wp-admin', 'https://www.youtube.com/watch?v=dQw4w9WgXcQ');
Route::redirect('/wp-login.php', 'https://www.youtube.com/watch?v=dQw4w9WgXcQ');

// login demo
Route::post('/demo-login', function () {
  $demoUser = User::firstOrCreate(
    ['email' => 'guest@gmail.com'],
    [
      'password' => bcrypt('guest@gmail.com'),
    ]
  );
  Auth::login($demoUser);
  return response()->json([
    'success' => true,
    'message' => 'Đăng nhập thành công!',
  ]);
});


// nojs
Route::get('/nojs', function () {
  return view('errors.nojs');
});
// API CMT
Route::post('/comments', [App\Http\Controllers\CommentController::class, 'store'])->name('comments.store');
Route::get('/comments/{postId}', [App\Http\Controllers\CommentController::class, 'getComments']);


// login đăng ký
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/ai-account', [AiAccountController::class, 'index'])->name('ai-account.index');

Route::middleware(['auth'])->group(function () {
  Route::get('/ai-account/history', [AiAccountController::class, 'history'])->name('ai-account.history');
  Route::post('/ai-account/payment', [AiAccountController::class, 'payment'])->name('ai-account.payment');
  Route::post('/ai-account/transfer-payment', [AiAccountController::class, 'transferPayment'])->name('ai-account.transfer-payment');
});

// Hỗ trợ cả slug (SEO) lẫn id cũ (backward compat)
Route::get('/ai-account/{slug}', [AiAccountController::class, 'detail'])->name('ai-account.detail');
Route::get('/terms-condition', [HomeController::class, 'terms_condition'])->name('terms.condition');
Route::get('/home', [HomeController::class, 'home'])->name('dvr');
Route::get('/login/google', [AuthController::class, 'LoginGoogle'])->name('login.google');
Route::get('/google/callback', [AuthController::class, 'LoginGoogleCallback'])->name('login.google.callback');
// user
Route::middleware(['auth', CheckLastLogin::class])->prefix('/account')->group(function () {
  Route::prefix('/profile')->group(function () {
    Route::get('/', [App\Http\Controllers\Account\ProfileController::class, 'index'])->name('account.profile.index');
    Route::post('/update', [App\Http\Controllers\Account\ProfileController::class, 'update'])->name('account.profile.update');
    Route::post('/token-update', [App\Http\Controllers\Account\ProfileController::class, 'tokenUpdate'])->name('account.profile.token-update');
    Route::post('/currency-update', [App\Http\Controllers\Account\ProfileController::class, 'currencyUpdate'])->name('account.profile.currency-update');
    Route::post('/password-update', [App\Http\Controllers\Account\ProfileController::class, 'passwordUpdate'])->name('account.profile.password-update');
  });
  Route::get('/history', [App\Http\Controllers\Account\ProfileController::class, 'Showhistory'])->name('account.profile.history');
  Route::get('/transactions', [App\Http\Controllers\Account\ProfileController::class, 'transactions'])->name('account.transactions');
  Route::get('/author-form', [App\Http\Controllers\Account\ProfileController::class, 'authorform'])->name('author-form');
  Route::post('/author-form', [App\Http\Controllers\Account\ProfileController::class, 'authorformPost']);
  Route::get('/ctv', [App\Http\Controllers\Account\ProfileController::class, 'CtvView'])->name('account.ctv');
  Route::get('/withdraw', [App\Http\Controllers\Account\ProfileController::class, 'withdrawView'])->name('account.withdraw');
  Route::post('/withdraw', [App\Http\Controllers\Account\ProfileController::class, 'withdrawPost']);
  Route::get('/product', [App\Http\Controllers\Account\ProductController::class, 'index'])->name('account.product');
  Route::get('/product/upload', [App\Http\Controllers\Account\ProductController::class, 'upload'])->name('account.product.upload');
  Route::post('/product/uploads', [App\Http\Controllers\Account\ProductController::class, 'uploadPost'])->name('account.upload.post');
});
// người bán hàng
Route::middleware(['auth', CheckLastLogin::class])->prefix('/resller')->group(function () {
  Route::get('/{id}', [App\Http\Controllers\Reseller\ResellerController::class, 'showReseller'])->name('reseller.index');
});
Route::post('/sepay/webhook', [App\Http\Controllers\Webhook\WebhookController::class, 'sepay'])->name('webhook.sepay');

// Chat client
Route::post('/chat/client-send', [App\Http\Controllers\Chat\ChatController::class, 'sendClientMessage'])->name('client.chat.send');
Route::get('/chat/client-get-message', [App\Http\Controllers\Chat\ChatController::class, 'getClientMessages'])->name('client.chat.get');

// tạo logo 
Route::get('logo/', [App\Http\Controllers\Logo\LogoController::class, 'showLogo'])->name('logo.index');
Route::middleware(['auth', CheckLastLogin::class])->prefix('/logo')->group(function () {
  Route::post('/payment', [App\Http\Controllers\Logo\LogoController::class, 'PaymentLogo'])->name('logo.pay');
  Route::get('/history', [App\Http\Controllers\Logo\LogoController::class, 'showHisLogo'])->name('logo.history');
});
// Hỗ trợ cả slug (SEO) lẫn id cũ (backward compat)
Route::get('/logo/{slug}', [App\Http\Controllers\Logo\LogoController::class, 'ShowViewLogo'])->name('logo.view');
// tạo website 
Route::get('/web', [App\Http\Controllers\Web\WebController::class, 'showWeb'])->name('web.index');
Route::middleware(['auth', CheckLastLogin::class])->prefix('/web')->group(function () {
  Route::post('/payment', [App\Http\Controllers\Web\WebController::class, 'PaymentWeb'])->name('web.pay');
  Route::get('/history', [App\Http\Controllers\Web\WebController::class, 'showHisWeb'])->name('web.history');
  Route::post('/show-giahan', [App\Http\Controllers\Web\WebController::class, 'ShowGiaHanModal'])->name('web.show-giahan');
  Route::post('/giahan', [App\Http\Controllers\Web\WebController::class, 'giahan'])->name('web.giahan');
  Route::post('/action', [App\Http\Controllers\Web\WebController::class, 'action'])->name('web.action');
});
// Hỗ trợ cả slug (SEO) lẫn id cũ (backward compat)
Route::get('/web/{slug}', [App\Http\Controllers\Web\WebController::class, 'ShowViewWeb'])->name('web.view');
Route::get('/cron/web/extend', [App\Http\Controllers\Web\WebController::class, 'checkExpiredOrders'])->name('web.extend');
// mã nguồn
Route::middleware(['auth', CheckLastLogin::class])->prefix('/view')->group(function () {
  Route::post('/payment', [App\Http\Controllers\Code\CodeController::class, 'paymentcode']);
  Route::get('/{slug}', [App\Http\Controllers\Code\CodeController::class, 'showViewCode'])->name('code.index');
});
// Trang trung gian tải miễn phí (Adsterra + Linkvertise)
Route::middleware(['auth', CheckLastLogin::class])->group(function () {
  Route::get('/download/free/{id}', [App\Http\Controllers\Code\DownloadController::class, 'freeDownload'])->name('download.free');
});
Route::middleware(['auth', CheckLastLogin::class])->prefix('/code')->group(function () {
  Route::get('/history', [App\Http\Controllers\Code\HiscodeController::class, 'showHisCode'])->name('code.history');
});
// tên miền
Route::get('/domain', [DomainController::class, 'showDomain'])->name('domain.index');
Route::get('/cron/giahan-auto', [App\Http\Controllers\Cron\DomainController::class, 'handle'])->name('domain.giahan.auto');
Route::middleware(['auth', CheckLastLogin::class])->prefix('/domain')->group(function () {
  Route::get('/view/{id}', [App\Http\Controllers\Domain\ViewHistoryController::class, 'showViewDomain'])->name('domain.view');
  Route::get('/history', [App\Http\Controllers\Domain\HisdomainController::class, 'showHisDomain'])->name('domain.history');
  Route::post('/status-update', [App\Http\Controllers\Domain\HisdomainController::class, 'giahanauto']);
  Route::post('/ns-update', [App\Http\Controllers\Domain\HisdomainController::class, 'updateNS']);
  Route::post('/user-update', [App\Http\Controllers\Domain\HisdomainController::class, 'updateUser']);
  Route::post('/giahan', [App\Http\Controllers\Domain\HisdomainController::class, 'domaingiahan']);
});
Route::middleware(['auth', CheckLastLogin::class])->prefix('/domain/pay')->group(function () {
  Route::get('/{domain}', [App\Http\Controllers\Domain\PaydomainController::class, 'showPayDomain'])->name('domain.pay');
  Route::post('/dvr', [App\Http\Controllers\Domain\PaydomainController::class, 'PayDomain']);
});
// upload ảnh
Route::get('/upanh', [App\Http\Controllers\Upload\UploadAnhController::class, 'showUpAnh'])->name('upanh.index');
Route::post('/upanh', [App\Http\Controllers\Upload\UploadAnhController::class, 'upload']);
// whoisdomain
Route::get('/whois', [App\Http\Controllers\Domain\WhoisApiController::class, 'showWhoisDomain'])->name('whois');
// nạp tiền
Route::middleware(['auth', CheckLastLogin::class])->prefix('/portal')->group(function () {
  Route::get('/recharge', [App\Http\Controllers\Recharge\RechargeController::class, 'showRecharge'])->name('recharge');
  Route::get('/recharge-card', [App\Http\Controllers\Recharge\RechargeController::class, 'showRechargeCard'])->name('recharge-card');
  Route::post('/recharge-card', [App\Http\Controllers\Recharge\RechargeController::class, 'sendCard']);
});
// getinfo FB
Route::get('/info-fb', [App\Http\Controllers\Api\InfoFbController::class, 'getInfoFB'])->name('getinfo');
// getlink tiktok
Route::get('/tiktok', [App\Http\Controllers\Api\TiktokController::class, 'getTikTok'])->name('tiktok');
// Cron Routes
Route::prefix('/payment')->group(function () {
  Route::get('/check', [App\Http\Controllers\Cron\DepositController::class, 'check'])->name('cron.deposit.check');
  Route::match(['post', 'get'], '/card-callback', [App\Http\Controllers\Cron\DepositController::class, 'cardCallback'])->name('cron.deposit.card-callback');
  // Route::get('/transfer', [App\Http\Controllers\Cron\TransferController::class, 'transfer'])->name('cron.deposit.transfer');
  Route::get('/withdraw', [App\Http\Controllers\Cron\WithdrawController::class, 'handle'])->name('cron.deposit.withdraw');
});
// api document
Route::get('/apidocs', [App\Http\Controllers\Api\ApiDocController::class, 'ApiDocs'])->name('apidocs');
// Tin Tức
Route::get('/blogs', [App\Http\Controllers\Blogs\BlogController::class, 'showBlogs'])->name('blogs');
Route::get('/blogs/{slug}', [App\Http\Controllers\Blogs\BlogController::class, 'viewBlogs'])->name('blogs.view');
// Hosting
Route::middleware(['auth', CheckLastLogin::class])->prefix('/hosting')->group(function () {
  Route::get('/', [App\Http\Controllers\Hosting\HostingController::class, 'ShowGoiHost'])->name('hosting.index');
  Route::post('/pay', [App\Http\Controllers\Hosting\HostingController::class, 'PayHost'])->name('hosting.post');
  Route::post('/paycron', [App\Http\Controllers\Hosting\HostingController::class, 'PayHostCron'])->name('hosting.post.cron');
  Route::get('/view-host/{id}', [App\Http\Controllers\Hosting\HostingController::class, 'ViewHost'])->name('hosting.view');
  Route::get('/history', [App\Http\Controllers\Hosting\HostingController::class, 'ShowHistory'])->name('hosting.history');
  Route::post('/giahan-update', [App\Http\Controllers\Hosting\HostingController::class, 'giahanauto'])->name('hosting.view.giahan');
  // change domain
  Route::post('/change-domain', [App\Http\Controllers\Hosting\HostingController::class, 'ChangeDomain'])->name('hosting.view.domain');
  // login cpanel
  Route::post('/login-hosting', [App\Http\Controllers\Hosting\HostingController::class, 'Login'])->name('hosting.view.login');
  // login app
  Route::post('/redirect-hosting', [App\Http\Controllers\Hosting\HostingController::class, 'redirect'])->name('hosting.view.redirect');
  // cron gia hạn hosting auto
  Route::get('/cron-auto', [App\Http\Controllers\Hosting\HostingController::class, 'handle'])->name('hosting.cron.auto');
  // change pass cpanel 
  Route::post('/change-pass', [App\Http\Controllers\Hosting\HostingController::class, 'changePass'])->name('hosting.view.changepass');
  // change pack hosting
  Route::post('/change-pack', [App\Http\Controllers\Hosting\HostingController::class, 'changePackage'])->name('hosting.view.changepackage');
  // block ip 
  Route::post('/block-ip', [App\Http\Controllers\Hosting\HostingController::class, 'BlockIp'])->name('hosting.view.blockip');
  Route::post('/unl-block-ip', [App\Http\Controllers\Hosting\HostingController::class, 'UnlBlockIp'])->name('hosting.view.unlblockip');
  // gia hạn
  Route::post('/gia-han-host', [App\Http\Controllers\Hosting\HostingController::class, 'giahan'])->name('hosting.view.extend');
  // cài đặt lại host
  Route::post('/reinstall', [App\Http\Controllers\Hosting\HostingController::class, 'reinstall'])->name('hosting.view.reinstall');
  // api voucher
  Route::post('/vouchers', [App\Http\Controllers\Api\VoucherController::class, 'voucherhosting'])->name('hosting.view.voucherhosting');
});
Route::middleware(['auth', CheckLastLogin::class])->prefix('/logo')->group(function () {});
Route::get('/hostings/create', [App\Http\Controllers\Hosting\HostingController::class, 'CronJobs'])->name('hosting.cron');
// thanh toán chuyển khoản
Route::middleware(['auth', CheckLastLogin::class])->prefix('/transfer')->group(function () {
  Route::get('/', [App\Http\Controllers\Transfer\TransferController::class, 'ShowPayment'])->name('transfer.view');
  Route::post('/payment', [App\Http\Controllers\Transfer\TransferController::class, 'transfer']);
  Route::get('/pay/{id}', [App\Http\Controllers\Transfer\TransferController::class, 'index'])->name('transfer.checkout');
  Route::get('/transfer-status', [App\Http\Controllers\Transfer\TransferController::class, 'get_status'])->name('transfer.status');
  Route::post('/transfer-status', [App\Http\Controllers\Transfer\TransferController::class, 'updateStatus']);
  Route::get('/delete/{id}', [App\Http\Controllers\Transfer\TransferController::class, 'destroy'])->name('transfer.delete');
});
// thuê cron
Route::middleware(['auth', CheckLastLogin::class])->prefix('/cronjob')->group(function () {
  Route::get('/', [App\Http\Controllers\Cronjob\CronController::class, 'index'])->name('cronjob.index');
  Route::post('/', [App\Http\Controllers\Cronjob\CronController::class, 'payment'])->name('cronjob.index.post');
  Route::get('/history', [App\Http\Controllers\Cronjob\CronController::class, 'history'])->name('cronjob.history');
  Route::post('/action', [App\Http\Controllers\Cronjob\CronController::class, 'action'])->name('cronjob.action');
  Route::post('/show-edit', [App\Http\Controllers\Cronjob\CronController::class, 'ShoweditModal'])->name('cronjob.show-edit');
  Route::post('/edit', [App\Http\Controllers\Cronjob\CronController::class, 'edit'])->name('cronjob.edit');;
  Route::post('/show-giahan', [App\Http\Controllers\Cronjob\CronController::class, 'ShowGiaHanModal'])->name('cronjob.show-giahan');
  Route::post('/giahan', [App\Http\Controllers\Cronjob\CronController::class, 'giahan'])->name('cronjob.giahan');
});
// admin 
Route::middleware(['auth', Admin::class, CheckLastLogin::class])->prefix('/Cpanel')->group(function () {
  // Dashboard
  Route::get('/', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('admin.dashboard');
  // logs
  Route::get('/logs', [App\Http\Controllers\Admin\DashboardController::class, 'logs'])->name('admin.dashboard.logs');
  // transactions
  Route::get('/transactions', [App\Http\Controllers\Admin\DashboardController::class, 'transactions'])->name('admin.dashboard.transactions');
  // list mã nguồn
  Route::prefix('/code')->group(function () {
    Route::get('/', [App\Http\Controllers\Admin\CodeController::class, 'index'])->name('admin.manguon.index');
    Route::get('/upload', [App\Http\Controllers\Admin\CodeController::class, 'upload_code'])->name('admin.manguon.upload-code');
    Route::post('/update-status', [App\Http\Controllers\Admin\CodeController::class, 'updateStatus'])->name('admin.manguon.update-status');
    Route::post('/delete', [App\Http\Controllers\Admin\CodeController::class, 'delete'])->name('admin.manguon.delete');
    Route::post('/upcode', [App\Http\Controllers\Admin\CodeController::class, 'uploadPost'])->name('admin.manguon.upcode');
    Route::get('/edit/{id}', [App\Http\Controllers\Admin\CodeController::class, 'showedit'])->name('admin.manguon.edit');
    Route::get('/history', [App\Http\Controllers\Admin\CodeController::class, 'history'])->name('admin.manguon.history');
    Route::post('/update', [App\Http\Controllers\Admin\CodeController::class, 'updateCode'])->name('admin.manguon.update');
    Route::get('/pay', [App\Http\Controllers\Admin\CodeController::class, 'pay'])->name('admin.manguon.pay');
    Route::post('/update-pay', [App\Http\Controllers\Admin\CodeController::class, 'updatePay'])->name('admin.manguon.update-pay');
    Route::post('/delete-pay', [App\Http\Controllers\Admin\CodeController::class, 'deletePay'])->name('admin.manguon.delete-pay');
  });
  // list domain
  Route::prefix('/domain')->group(function () {
    Route::get('/', [App\Http\Controllers\Admin\DomainController::class, 'index'])->name('admin.domain.index');
    Route::post('/update-status', [App\Http\Controllers\Admin\DomainController::class, 'updateStatus'])->name('admin.domain.update-status');
    Route::post('/upload-domain', [App\Http\Controllers\Admin\DomainController::class, 'uploadDomain'])->name('admin.domain.upload');
    Route::post('/delete', [App\Http\Controllers\Admin\DomainController::class, 'delete'])->name('admin.domain.delete');
    Route::get('/edit/{id}', [App\Http\Controllers\Admin\DomainController::class, 'showedit'])->name('admin.domain.edit');
    Route::post('/update', [App\Http\Controllers\Admin\DomainController::class, 'updateDomain'])->name('admin.domain.update');
    Route::get('/history', [App\Http\Controllers\Admin\DomainController::class, 'history'])->name('admin.domain.history');
    Route::post('/update-domain', [App\Http\Controllers\Admin\DomainController::class, 'historyupdate'])->name('admin.domain.update-domain');
    Route::post('/update-status-history', [App\Http\Controllers\Admin\DomainController::class, 'update_status_history'])->name('admin.domain.update-status-history');
    Route::post('/delete-history', [App\Http\Controllers\Admin\DomainController::class, 'deleteHistory'])->name('admin.domain.delete-history');
  });
  // tạo logo
  Route::prefix('/logo')->group(function () {
    Route::get('/', [App\Http\Controllers\Admin\LogoController::class, 'index'])->name('admin.logo.index');
    Route::post('/update-status', [App\Http\Controllers\Admin\LogoController::class, 'updateStatus'])->name('admin.logo.update-status');
    Route::post('/upload-logo', [App\Http\Controllers\Admin\LogoController::class, 'uploadPost'])->name('admin.logo.store');
    Route::post('/delete', [App\Http\Controllers\Admin\LogoController::class, 'delete'])->name('admin.logo.delete');
    Route::post('/update', [App\Http\Controllers\Admin\LogoController::class, 'updateDomain'])->name('admin.logo.update');
    Route::get('/history', [App\Http\Controllers\Admin\LogoController::class, 'history'])->name('admin.logo.history');
    Route::post('/update-logo', [App\Http\Controllers\Admin\LogoController::class, 'updateLogo'])->name('admin.logo.update');
    Route::post('/update-history', [App\Http\Controllers\Admin\LogoController::class, 'UpdateHistory'])->name('admin.logo.update-logo');
    Route::post('/delete-history', [App\Http\Controllers\Admin\LogoController::class, 'deleteHistory'])->name('admin.logo.delete-history');
  });
  // Tài khoản AI
  Route::prefix('/ai-accounts')->group(function () {
    Route::get('/', [App\Http\Controllers\Admin\AiAccountController::class, 'index'])->name('admin.ai.index');
    Route::get('/create', [App\Http\Controllers\Admin\AiAccountController::class, 'create'])->name('admin.ai.create');
    Route::get('/edit/{id}', [App\Http\Controllers\Admin\AiAccountController::class, 'edit'])->name('admin.ai.edit');
    Route::post('/store', [App\Http\Controllers\Admin\AiAccountController::class, 'store'])->name('admin.ai.store');
    Route::post('/update', [App\Http\Controllers\Admin\AiAccountController::class, 'update'])->name('admin.ai.update');
    Route::post('/update-status', [App\Http\Controllers\Admin\AiAccountController::class, 'updateStatus'])->name('admin.ai.update-status');
    Route::post('/delete', [App\Http\Controllers\Admin\AiAccountController::class, 'delete'])->name('admin.ai.delete');
    Route::get('/orders', [App\Http\Controllers\Admin\AiAccountController::class, 'orders'])->name('admin.ai.orders');
    Route::post('/orders/update-status', [App\Http\Controllers\Admin\AiAccountController::class, 'updateOrderStatus'])->name('admin.ai.orders.update-status');
    Route::post('/variant/store', [App\Http\Controllers\Admin\AiAccountController::class, 'storeVariant'])->name('admin.ai.variant.store');
    Route::post('/variant/update', [App\Http\Controllers\Admin\AiAccountController::class, 'updateVariant'])->name('admin.ai.variant.update');
    Route::post('/variant/delete', [App\Http\Controllers\Admin\AiAccountController::class, 'deleteVariant'])->name('admin.ai.variant.delete');
    Route::get('/categories', [App\Http\Controllers\Admin\AiAccountController::class, 'categories'])->name('admin.ai.categories');
    Route::post('/categories/store', [App\Http\Controllers\Admin\AiAccountController::class, 'storeCategory'])->name('admin.ai.categories.store');
    Route::post('/categories/update', [App\Http\Controllers\Admin\AiAccountController::class, 'updateCategory'])->name('admin.ai.categories.update');
    Route::post('/categories/delete', [App\Http\Controllers\Admin\AiAccountController::class, 'deleteCategory'])->name('admin.ai.categories.delete');
  });
  // tạo website
  Route::prefix('/web')->group(function () {
    Route::get('/', [App\Http\Controllers\Admin\WebController::class, 'index'])->name('admin.web.index');
    Route::post('/update-status', [App\Http\Controllers\Admin\WebController::class, 'updateStatus'])->name('admin.web.update-status');
    Route::post('/upload-web', [App\Http\Controllers\Admin\WebController::class, 'uploadPost'])->name('admin.web.store');
    Route::post('/delete', [App\Http\Controllers\Admin\WebController::class, 'delete'])->name('admin.web.delete');
    Route::post('/update', [App\Http\Controllers\Admin\WebController::class, 'updateWeb'])->name('admin.web.update');
    Route::get('/history', [App\Http\Controllers\Admin\WebController::class, 'history'])->name('admin.web.history');
    Route::post('/update-history', [App\Http\Controllers\Admin\WebController::class, 'UpdateHistory'])->name('admin.web.update-web');
    Route::post('/delete-history', [App\Http\Controllers\Admin\WebController::class, 'deleteHistory'])->name('admin.web.delete-history');
  });
  // list cronjob
  Route::prefix('/cron')->group(function () {
    Route::get('/', [App\Http\Controllers\Admin\CronJobController::class, 'index'])->name('admin.cron.index');
    Route::post('/upload-cron', [App\Http\Controllers\Admin\CronJobController::class, 'uploadCron'])->name('admin.cron.upload');
    Route::post('/update-cron', [App\Http\Controllers\Admin\CronJobController::class, 'UpdateServerCron'])->name('admin.cron.update-cron');
    Route::post('/delete', [App\Http\Controllers\Admin\CronJobController::class, 'deleteServer'])->name('admin.cron.delete');
    Route::get('/list', [App\Http\Controllers\Admin\CronJobController::class, 'showlist'])->name('admin.cron.list');
    Route::post('/list/delete', [App\Http\Controllers\Admin\CronJobController::class, 'deleteList'])->name('admin.cron.list.delete');
    Route::post('/list/action', [App\Http\Controllers\Admin\CronJobController::class, 'action'])->name('admin.cron.list.action');
    Route::post('/list/giahan', [App\Http\Controllers\Admin\CronJobController::class, 'giahan'])->name('admin.cron.list.giahan');
    Route::get('/list/edit/{id}', [App\Http\Controllers\Admin\CronJobController::class, 'showedit'])->name('admin.cron.list.edit');
    Route::post('/update-list-cron', [App\Http\Controllers\Admin\CronJobController::class, 'update_edit'])->name('admin.cron.list.update');
  });
  // Hosting
  Route::prefix('/hosting')->group(function () {
    // danh mục host
    Route::get('/category', [App\Http\Controllers\Admin\HostingController::class, 'category_hosting_view'])->name('admin.hosting.category');
    Route::post('/category', [App\Http\Controllers\Admin\HostingController::class, 'category_hosting_store'])->name('admin.hosting.category.store');
    Route::post('/category/update', [App\Http\Controllers\Admin\HostingController::class, 'category_hosting_update'])->name('admin.hosting.category.update');
    Route::post('/category/delete', [App\Http\Controllers\Admin\HostingController::class, 'category_hosting_delete'])->name('admin.hosting.category.delete');
    // máy chủ
    Route::get('/whm', [App\Http\Controllers\Admin\HostingController::class, 'whm_info_view'])->name('admin.hosting.whm');
    Route::post('/whm', [App\Http\Controllers\Admin\HostingController::class, 'whm_info_store'])->name('admin.hosting.whm.store');
    Route::post('/whm-login', [App\Http\Controllers\Admin\HostingController::class, 'whm_info_login'])->name('admin.hosting.whm.login');
    Route::post('/whm-link-login', [App\Http\Controllers\Admin\HostingController::class, 'whm_info_link_login'])->name('admin.hosting.whm.link.login');
    Route::post('/whm/update', [App\Http\Controllers\Admin\HostingController::class, 'whm_info_update'])->name('admin.hosting.whm.update');
    Route::post('/whm/delete', [App\Http\Controllers\Admin\HostingController::class, 'whm_info_delete'])->name('admin.hosting.whm.delete');
    // gói host
    Route::get('/packages', [App\Http\Controllers\Admin\HostingController::class, 'hosting_packages_view'])->name('admin.hosting.packages');
    Route::post('/packages', [App\Http\Controllers\Admin\HostingController::class, 'hosting_packages_store'])->name('admin.hosting.packages.store');
    Route::post('/packages/update', [App\Http\Controllers\Admin\HostingController::class, 'hosting_packages_update'])->name('admin.hosting.packages.update');
    Route::post('/packages/delete', [App\Http\Controllers\Admin\HostingController::class, 'hosting_packages_delete'])->name('admin.hosting.packages.delete');
    // quản lý host
    Route::get('/list', [App\Http\Controllers\Admin\HostingController::class, 'hosting_list_view'])->name('admin.hosting.list');
    Route::post('/list/giahan-auto', [App\Http\Controllers\Admin\HostingController::class, 'update_giahan'])->name('admin.hosting.list.giahan.auto');
    Route::post('/list/lock', [App\Http\Controllers\Admin\HostingController::class, 'hosting_SuspendAccount'])->name('admin.hosting.list.lock');
    Route::post('/list/unlock', [App\Http\Controllers\Admin\HostingController::class, 'hosting_UnsuspendAccount'])->name('admin.hosting.list.unlock');
    Route::post('/list/delete', [App\Http\Controllers\Admin\HostingController::class, 'hosting_DeleteAccount'])->name('admin.hosting.list.delete');
    Route::post('/list/login', [App\Http\Controllers\Admin\HostingController::class, 'Login'])->name('admin.hosting.list.login');
    Route::post('/list/changePackage', [App\Http\Controllers\Admin\HostingController::class, 'changePackage'])->name('admin.hosting.list.changepackage');
  });
  // voucher
  Route::prefix('/voucher')->group(function () {
    Route::get('/', [App\Http\Controllers\Admin\VoucherController::class, 'index'])->name('admin.voucher.index');
    Route::post('/show-history', [App\Http\Controllers\Admin\VoucherController::class, 'ShowhistoryModal'])->name('admin.voucher.show-history');
    Route::post('/update', [App\Http\Controllers\Admin\VoucherController::class, 'update'])->name('admin.voucher.update');
    Route::post('/upload', [App\Http\Controllers\Admin\VoucherController::class, 'upload'])->name('admin.voucher.upload');
    Route::post('/delete', [App\Http\Controllers\Admin\VoucherController::class, 'delete'])->name('admin.voucher.delete');
  });
  // thành viên
  Route::prefix('/users')->group(function () {
    Route::get('/', [App\Http\Controllers\Admin\UserController::class, 'index'])->name('admin.users.index');
    Route::get('/edit/{id}', [App\Http\Controllers\Admin\UserController::class, 'edit'])->name('admin.users.edit');
    Route::post('/update/{id}', [App\Http\Controllers\Admin\UserController::class, 'update'])->name('admin.users.update');
    Route::get('/login-to/{username}', [App\Http\Controllers\Admin\UserController::class, 'loginTo'])->name('admin.users.login-to');
  });
  // hóa đơn
  Route::prefix('/transfer')->group(function () {
    Route::get('/', [App\Http\Controllers\Admin\TransferController::class, 'index'])->name('admin.transfer.index');
    Route::post('/update', [App\Http\Controllers\Admin\TransferController::class, 'update'])->name('admin.transfer.update');
    Route::post('/delete', [App\Http\Controllers\Admin\TransferController::class, 'delete'])->name('admin.transfer.delete');
  });
  // ngân hàng
  Route::prefix('/recharge')->group(function () {
    Route::get('/bank', [App\Http\Controllers\Admin\RechargeController::class, 'bank'])->name('admin.recharge.bank');
    Route::get('/bank/config', [App\Http\Controllers\Admin\RechargeController::class, 'configBank'])->name('admin.recharge.bank.config');
    Route::post('/bank/update', [App\Http\Controllers\Admin\RechargeController::class, 'updateBank'])->name('admin.recharge.bank.config.update');
    Route::post('/bank/delete', [App\Http\Controllers\Admin\RechargeController::class, 'deleteBank'])->name('admin.recharge.bank.delete');
    Route::post('/bank/store', [App\Http\Controllers\Admin\RechargeController::class, 'storeBank'])->name('admin.recharge.bank.store');
    Route::get('/card', [App\Http\Controllers\Admin\RechargeController::class, 'card'])->name('admin.recharge.card');
    Route::post('/card/update', [App\Http\Controllers\Admin\RechargeController::class, 'updateCard'])->name('admin.recharge.card.update');
    Route::get('/api', [App\Http\Controllers\Admin\RechargeController::class, 'apibank'])->name('admin.recharge.apibank');
    Route::post('/api/update', [App\Http\Controllers\Admin\RechargeController::class, 'updateApi'])->name('admin.recharge.apibank.update');
  });
  // bài viết
  Route::prefix('/blog')->group(function () {
    // blog
    Route::get('/', [App\Http\Controllers\Admin\BlogController::class, 'index'])->name('admin.blog.index');
    Route::get('/add', [App\Http\Controllers\Admin\BlogController::class, 'blog'])->name('admin.blog.add');
    Route::post('/add', [App\Http\Controllers\Admin\BlogController::class, 'blogPost'])->name('admin.blog.add.post');
    Route::get('/crawl', [App\Http\Controllers\Admin\BlogController::class, 'crawlPage'])->name('admin.blog.crawl.page');
    Route::post('/crawl/single', [App\Http\Controllers\Admin\BlogController::class, 'crawlSinglePost'])->name('admin.blog.crawl.single');
    Route::post('/crawl/category', [App\Http\Controllers\Admin\BlogController::class, 'crawlCategory'])->name('admin.blog.crawl.category');
    Route::post('/crawl/feed', [App\Http\Controllers\Admin\BlogController::class, 'crawlFeed'])->name('admin.blog.crawl.feed');
    Route::match(['GET', 'POST'], '/ckeditor-upload', [App\Http\Controllers\Admin\BlogController::class, 'ckeditorUpload'])->name('admin.blog.ckeditor-upload');
    Route::post('/delete', [App\Http\Controllers\Admin\BlogController::class, 'PostDelete'])->name('admin.blog.delete');
    Route::get('/edit/{id}', [App\Http\Controllers\Admin\BlogController::class, 'edit'])->name('admin.blog.edit');
    Route::post('/edit', [App\Http\Controllers\Admin\BlogController::class, 'editPost'])->name('admin.blog.edit.post');
    // category
    Route::get('/category', [App\Http\Controllers\Admin\BlogController::class, 'category'])->name('admin.blog.category');
    Route::post('/category', [App\Http\Controllers\Admin\BlogController::class, 'categoryPost'])->name('admin.blog.category.post');
    Route::post('/category/update', [App\Http\Controllers\Admin\BlogController::class, 'categoryUpdate'])->name('admin.blog.category.update');
    Route::post('/category/delete', [App\Http\Controllers\Admin\BlogController::class, 'categoryDelete'])->name('admin.blog.category.delete');
  });
  // chat support 
  Route::get('/chat', [App\Http\Controllers\Chat\ChatController::class, 'index'])->name('admin.chat.index');
  Route::post('/chat/mark-as-read', [App\Http\Controllers\Chat\ChatController::class, 'markAsRead'])->name('admin.chat.mark-as-read');
  Route::post('/chat/send', [App\Http\Controllers\Chat\ChatController::class, 'sendMessage'])->name('admin.chat.send');
  Route::post('/chat/toggle-ai', [App\Http\Controllers\Chat\ChatController::class, 'toggleAiMode'])->name('admin.chat.toggle-ai');

  // setting 
  Route::prefix('/settings')->group(function () {

    Route::get('/general', [App\Http\Controllers\Admin\SettingController::class, 'index'])->name('admin.settings.general');
    Route::post('/general', [App\Http\Controllers\Admin\SettingController::class, 'update'])->name('admin.settings.general.update');

    Route::get('/notices', [App\Http\Controllers\Admin\SettingController::class, 'notices'])->name('admin.setting.notices');
    Route::post('/notices', [App\Http\Controllers\Admin\SettingController::class, 'updateNotices'])->name('admin.settings.notices.update');
  });
});
