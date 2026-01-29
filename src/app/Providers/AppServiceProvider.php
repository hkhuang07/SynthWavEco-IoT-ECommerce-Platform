<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use App\View\Composers\CategoriesComposer;

use Illuminate\Support\Facades;
use Illuminate\View\View;



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
		//Paginator::useBootstrapFive();
		//Facades\View::composer('layouts.frontend',CategoriesComposer::class);
		//Facades\View::composer('layouts.frontend',ChuDeComposer::class);

	}
}

