<?php

namespace App\Livewire;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class AdminLanguageSwitcher extends Component
{
    public $currentLanguage;
    public $availableLanguages;

    public function mount()
    {
        $this->currentLanguage = App::getLocale();
        $this->availableLanguages = [
            'fr' => [
                'name' => 'Français',
                'flag' => '🇫🇷',
                'code' => 'fr'
            ],
            'en' => [
                'name' => 'English',
                'flag' => '🇺🇸',
                'code' => 'en'
            ]
        ];
    }

    public function switchLanguage($language)
    {
        // Valider la langue
        if (!array_key_exists($language, $this->availableLanguages)) {
            return;
        }

        // Changer la langue de l'application
        App::setLocale($language);
        
        // Sauvegarder en session
        Session::put('locale', $language);
        
        // Mettre à jour la propriété
        $this->currentLanguage = $language;
        
        // Émettre un événement pour rafraîchir la page
        $this->dispatch('language-changed', $language);
        
        // Rediriger pour rafraîchir complètement la page
        return redirect()->to(request()->fullUrl());
    }

    public function render()
    {
        return view('livewire.admin-language-switcher');
    }
}
