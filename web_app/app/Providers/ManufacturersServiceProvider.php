<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Manufacturer;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
//use Illuminate\Support\Facades;
//use Illuminate\View\View;


class ManufacturersServiceProvider extends ServiceProvider
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
            $manufactures = Manufacturer::orderBy('name')->get();
            $view->with('globalManufactures', $manufactures);
        });
    }
}
