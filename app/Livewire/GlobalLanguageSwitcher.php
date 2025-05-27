<?php

namespace App\Livewire;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class GlobalLanguageSwitcher extends Component
{
    public $currentLanguage;
    public $isCompact;

    public function mount($compact = false)
    {
        $this->currentLanguage = App::getLocale();
        $this->isCompact = $compact;
    }

    public function switchLanguage()
    {
        // Toggle entre français et anglais
        $newLanguage = $this->currentLanguage === 'fr' ? 'en' : 'fr';

        // Changer la langue de l'application
        App::setLocale($newLanguage);

        // Sauvegarder en session
        Session::put('locale', $newLanguage);

        // Mettre à jour la propriété
        $this->currentLanguage = $newLanguage;

        // Construire l'URL avec le paramètre lang
        $currentUrl = request()->url();
        $queryParams = request()->query();
        $queryParams['lang'] = $newLanguage;

        $newUrl = $currentUrl . '?' . http_build_query($queryParams);

        // Rediriger vers la nouvelle URL
        return redirect()->to($newUrl);
    }

    public function getLanguageData()
    {
        return [
            'fr' => [
                'name' => 'Français',
                'short' => 'FR',
                'flag' => '🇫🇷',
                'code' => 'fr'
            ],
            'en' => [
                'name' => 'English',
                'short' => 'EN',
                'flag' => '🇺🇸',
                'code' => 'en'
            ]
        ];
    }

    public function getCurrentLanguageData()
    {
        $languages = $this->getLanguageData();
        return $languages[$this->currentLanguage];
    }

    public function getNextLanguageData()
    {
        $languages = $this->getLanguageData();
        $nextLang = $this->currentLanguage === 'fr' ? 'en' : 'fr';
        return $languages[$nextLang];
    }

    public function render()
    {
        return view('livewire.global-language-switcher');
    }
}
