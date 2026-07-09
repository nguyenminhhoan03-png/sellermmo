<?php

namespace App\Providers;

use App\Models\BankAccount;
use App\Models\PostCategory;
use App\Models\Product;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\App;
use Illuminate\Database\Eloquent\Model;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Model::preventLazyLoading(! App::isProduction());

        // 2. TỐI ƯU VIEW COMPOSER: Thay '*' bằng mảng các view layout cụ thể để tránh lỗi N+1 truy vấn
        View::composer(['layouts.app', 'layouts.master', 'client.*'], function ($view) {
            $search = Product::query()->where('status', 1)->orderByDesc('id')->get();
            $bank = BankAccount::query()->where('status', 1)->get();
            $categoryPost = PostCategory::query()->where('status', 1)->get();

            // Sửa lỗi chính tả 'seach' thành 'search', đồng thời truyền cả 'seach' để tương thích với view cũ
            $view->with([
                'search' => $search, 
                'seach' => $search, 
                'bank' => $bank,
                'category_post' => $categoryPost,
            ]);
        });

        Route::prefix('api')
            ->middleware('api')
            ->group(base_path('routes/api.php'));
    }
}
