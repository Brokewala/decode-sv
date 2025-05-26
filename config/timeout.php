<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Timeout Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration des timeouts pour différentes opérations
    |
    */

    // Timeout pour l'upload de fichiers (en secondes)
    'file_upload' => env('TIMEOUT_FILE_UPLOAD', 120),

    // Timeout pour le traitement d'images (en secondes)
    'image_processing' => env('TIMEOUT_IMAGE_PROCESSING', 60),

    // Timeout pour les requêtes de base de données (en secondes)
    'database_query' => env('TIMEOUT_DATABASE_QUERY', 30),

    // Timeout pour les opérations Livewire (en secondes)
    'livewire_operation' => env('TIMEOUT_LIVEWIRE_OPERATION', 60),

    // Timeout pour les exports/imports (en secondes)
    'export_import' => env('TIMEOUT_EXPORT_IMPORT', 300),

];
