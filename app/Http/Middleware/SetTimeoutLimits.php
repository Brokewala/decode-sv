<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SetTimeoutLimits
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $timeout = null)
    {
        // Définir les timeouts selon le type de requête
        $timeoutSeconds = $this->getTimeoutForRequest($request, $timeout);
        
        // Augmenter la limite d'exécution PHP
        if ($timeoutSeconds) {
            set_time_limit($timeoutSeconds);
            ini_set('max_execution_time', $timeoutSeconds);
        }
        
        // Augmenter la limite de mémoire si nécessaire
        if ($this->isFileUploadRequest($request)) {
            ini_set('memory_limit', '256M');
            ini_set('upload_max_filesize', '10M');
            ini_set('post_max_size', '12M');
        }

        return $next($request);
    }

    /**
     * Déterminer le timeout approprié pour la requête
     */
    private function getTimeoutForRequest(Request $request, $customTimeout = null)
    {
        // Si un timeout personnalisé est spécifié
        if ($customTimeout) {
            return (int) $customTimeout;
        }

        // Upload de fichiers
        if ($this->isFileUploadRequest($request)) {
            return config('timeout.file_upload', 120);
        }

        // Requêtes Livewire
        if ($this->isLivewireRequest($request)) {
            return config('timeout.livewire_operation', 60);
        }

        // Opérations d'export/import
        if ($this->isExportImportRequest($request)) {
            return config('timeout.export_import', 300);
        }

        // Traitement d'images
        if ($this->isImageProcessingRequest($request)) {
            return config('timeout.image_processing', 60);
        }

        // Timeout par défaut
        return 60;
    }

    /**
     * Vérifier si c'est une requête d'upload de fichier
     */
    private function isFileUploadRequest(Request $request)
    {
        return $request->hasFile('file') || 
               $request->is('*/upload*') || 
               $request->is('documents/store') ||
               str_contains($request->getPathInfo(), 'upload');
    }

    /**
     * Vérifier si c'est une requête Livewire
     */
    private function isLivewireRequest(Request $request)
    {
        return $request->header('X-Livewire') || 
               str_contains($request->getPathInfo(), 'livewire');
    }

    /**
     * Vérifier si c'est une requête d'export/import
     */
    private function isExportImportRequest(Request $request)
    {
        return $request->is('*/export*') || 
               $request->is('*/import*') ||
               str_contains($request->getPathInfo(), 'export') ||
               str_contains($request->getPathInfo(), 'import');
    }

    /**
     * Vérifier si c'est une requête de traitement d'image
     */
    private function isImageProcessingRequest(Request $request)
    {
        return str_contains($request->getPathInfo(), 'preview') ||
               str_contains($request->getPathInfo(), 'thumbnail') ||
               $request->is('*/image*');
    }
}
