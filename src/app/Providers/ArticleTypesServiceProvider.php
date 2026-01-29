<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\ArticleType;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
//use Illuminate\Support\Facades;
//use Illuminate\View\View;


class ArticleTypesServiceProvider extends ServiceProvider
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
            $article_types = ArticleType::orderBy('name')->get();
            $view->with('globalArticleTypes', $article_types);
        });
    }
}
