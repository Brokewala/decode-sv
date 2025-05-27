<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

class LivewireServiceProvider extends ServiceProvider
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
        // Configuration des routes Livewire avec support GET et POST
        Livewire::setUpdateRoute(function ($handle) {
            return \Illuminate\Support\Facades\Route::match(['GET', 'POST'], '/livewire/update', $handle)
                ->middleware(['web']);
        });

        // Enregistrement des composants Livewire
        Livewire::component('global-language-switcher', \App\Livewire\GlobalLanguageSwitcher::class);
        Livewire::component('admin-language-switcher', \App\Livewire\AdminLanguageSwitcher::class);
    }
}
