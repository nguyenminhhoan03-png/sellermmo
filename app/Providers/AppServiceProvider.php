<?php

namespace App\Providers;

use App\Models\BankAccount;
use App\Models\PostCategory;
use App\Models\Product;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

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
        View::composer('*', function ($view) {
            $search = Product::query()->where('status', 1)->orderByDesc('id')->get();
            $bank = BankAccount::query()->where('status', 1)->get();
            $categoryPost = PostCategory::query()->where('status', 1)->get();

            $view->with([
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
