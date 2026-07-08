<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Config;


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
        Schema::defaultStringLength(191);
        // Register SetLocale middleware to the web group so locale is applied per request
        if ($this->app->bound('router')) {
            $this->app['router']->pushMiddlewareToGroup('web', \App\Http\Middleware\SetLocale::class);
        }
    }
}
