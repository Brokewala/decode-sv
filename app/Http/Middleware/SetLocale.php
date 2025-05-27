<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Langues supportées
        $supportedLocales = ['fr', 'en'];

        $locale = null;

        // 1. Vérifier le paramètre URL (?lang=en)
        if ($request->has('lang') && in_array($request->get('lang'), $supportedLocales)) {
            $locale = $request->get('lang');
            Session::put('locale', $locale);
        }

        // 2. Vérifier la session
        if (!$locale && Session::has('locale') && in_array(Session::get('locale'), $supportedLocales)) {
            $locale = Session::get('locale');
        }

        // 3. Vérifier le header Accept-Language
        if (!$locale) {
            $acceptLanguage = $request->header('Accept-Language');
            if ($acceptLanguage) {
                $languages = explode(',', $acceptLanguage);
                foreach ($languages as $language) {
                    $lang = trim(explode(';', $language)[0]);
                    $lang = substr($lang, 0, 2);

                    if (in_array($lang, $supportedLocales)) {
                        $locale = $lang;
                        break;
                    }
                }
            }
        }

        // 4. Langue par défaut
        if (!$locale) {
            $locale = 'fr';
        }

        // Appliquer la langue
        App::setLocale($locale);

        // Sauvegarder en session
        Session::put('locale', $locale);

        return $next($request);
    }
}
