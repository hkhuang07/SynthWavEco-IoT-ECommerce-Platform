<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Category;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
//use Illuminate\Support\Facades;
//use Illuminate\View\View;


class CategoriesServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        View::composer('layouts.frontend', function ($view) {
            $categories = Category::orderBy('name')->get();
            $view->with('globalCategories', $categories);
        });
    }
}
