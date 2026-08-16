<?php

namespace App\Providers;
use Illuminate\Pagination\Paginator;


use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        
        \Illuminate\Auth\Middleware\Authenticate::redirectUsing(function ($request) {
        return route('customer.login');
    });
            
            
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
       Paginator::useBootstrapFive();
    }
}
