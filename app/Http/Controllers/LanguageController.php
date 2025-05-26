<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

class LanguageController extends Controller
{
    /**
     * Change the application language.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function switch(Request $request)
    {
        $locale = $request->input('locale');
        
        // Vérifier que la langue est supportée
        if (!in_array($locale, array_keys(config('app.available_locales')))) {
            return back()->with('error', 'Langue non supportée.');
        }
        
        // Sauvegarder la langue en session
        Session::put('locale', $locale);
        
        // Rediriger vers la page précédente avec un message de succès
        return back()->with('success', 'Langue changée avec succès.');
    }
    
    /**
     * Get available locales for API or AJAX requests.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAvailableLocales()
    {
        return response()->json([
            'current' => app()->getLocale(),
            'available' => config('app.available_locales')
        ]);
    }
}
