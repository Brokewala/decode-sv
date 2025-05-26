<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Session;

class LanguageSwitcher extends Component
{
    public $currentLocale;
    public $availableLocales;

    public function mount()
    {
        $this->currentLocale = app()->getLocale();
        $this->availableLocales = config('app.available_locales');
    }

    public function switchLanguage($locale)
    {
        // Vérifier que la langue est supportée
        if (!array_key_exists($locale, $this->availableLocales)) {
            session()->flash('error', 'Langue non supportée.');
            return;
        }

        // Sauvegarder la langue en session
        Session::put('locale', $locale);
        
        // Rediriger pour appliquer le changement
        return redirect()->to(request()->url() . '?lang=' . $locale);
    }

    public function render()
    {
        return view('livewire.language-switcher');
    }
}
