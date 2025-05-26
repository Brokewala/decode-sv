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
        // Vérifier si une langue est demandée via paramètre GET
        if ($request->has('lang')) {
            $locale = $request->get('lang');
            
            // Vérifier que la langue est supportée
            if (in_array($locale, array_keys(config('app.available_locales')))) {
                Session::put('locale', $locale);
                App::setLocale($locale);
            }
        }
        // Sinon, utiliser la langue en session
        elseif (Session::has('locale')) {
            $locale = Session::get('locale');
            
            // Vérifier que la langue est toujours supportée
            if (in_array($locale, array_keys(config('app.available_locales')))) {
                App::setLocale($locale);
            }
        }
        // Sinon, utiliser la langue par défaut
        else {
            App::setLocale(config('app.locale'));
        }

        return $next($request);
    }
}
