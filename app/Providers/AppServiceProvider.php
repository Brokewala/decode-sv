<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Register components
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Default string length for MySQL
        Schema::defaultStringLength(191);
        
        // Register components
        Blade::component('layouts.main', 'main-layout');
        Blade::component('layouts.app', 'app-layout');
    }
}
