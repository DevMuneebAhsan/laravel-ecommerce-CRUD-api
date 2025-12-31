<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Product;
use App\Policies\V1\CategoryPolicy;
use App\Policies\V1\ProductPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
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
        Gate::policy(Product::class, ProductPolicy::class);
        Gate::policy(Category::class, CategoryPolicy::class);
        Route::middleware('api')
            ->prefix('api/v1/')
            ->group(base_path('routes/api_v1.php'));
    }
}
