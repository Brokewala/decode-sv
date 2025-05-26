<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ErrorHandler
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
        try {
            $response = $next($request);
            
            // Log des requêtes réussies pour le debug
            if (config('app.debug') && $request->isMethod('post')) {
                Log::info('Requête POST réussie', [
                    'url' => $request->url(),
                    'user_id' => auth()->id(),
                    'ip' => $request->ip()
                ]);
            }
            
            return $response;
            
        } catch (\Throwable $e) {
            // Log structuré des erreurs
            Log::error('Erreur dans la requête', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'url' => $request->url(),
                'method' => $request->method(),
                'user_id' => auth()->id(),
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent()
            ]);
            
            // Retourner une réponse d'erreur appropriée
            if ($request->expectsJson()) {
                return response()->json([
                    'error' => 'Une erreur est survenue',
                    'message' => config('app.debug') ? $e->getMessage() : 'Erreur interne'
                ], 500);
            }
            
            // Pour les requêtes web, rediriger avec un message d'erreur
            return back()->withErrors(['error' => 'Une erreur est survenue. Veuillez réessayer.']);
        }
    }
}
