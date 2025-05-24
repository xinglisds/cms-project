<?php

namespace App\Providers;

use App\Models\Article;
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
        // Configure route model binding for Article by slug
        Route::model('article', Article::class);
        
        // Alternative explicit binding (if needed for more control)
        Route::bind('slug', function (string $value) {
            return Article::where('slug', $value)->firstOrFail();
        });
    }
}
