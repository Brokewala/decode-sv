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
        // Note: Les sélecteurs de langue utilisent maintenant des composants simples sans Livewire
    }
}
