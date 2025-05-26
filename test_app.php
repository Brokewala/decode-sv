<?php

// Test simple de l'application Laravel sans Artisan
require_once 'vendor/autoload.php';

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

echo "=== Test de l'application Decode SV ===\n";

try {
    // Créer l'application Laravel
    $app = require_once 'bootstrap/app.php';
    
    echo "✓ Application Laravel chargée avec succès\n";
    
    // Tester la connexion à la base de données
    $db = $app->make('db');
    $connection = $db->connection();
    
    echo "✓ Connexion à la base de données réussie\n";
    
    // Tester une requête simple
    $users = $connection->table('users')->count();
    echo "✓ Nombre d'utilisateurs dans la base : $users\n";
    
    $documents = $connection->table('documents')->count();
    echo "✓ Nombre de documents dans la base : $documents\n";
    
    // Tester les modèles
    $userModel = $app->make('App\Models\User');
    echo "✓ Modèle User chargé avec succès\n";
    
    $documentModel = $app->make('App\Models\Document');
    echo "✓ Modèle Document chargé avec succès\n";
    
    echo "\n=== Configuration de l'application ===\n";
    echo "Nom de l'app : " . config('app.name') . "\n";
    echo "Environnement : " . config('app.env') . "\n";
    echo "Debug : " . (config('app.debug') ? 'activé' : 'désactivé') . "\n";
    echo "Locale : " . config('app.locale') . "\n";
    echo "Base de données : " . config('database.default') . "\n";
    
    echo "\n=== Test terminé avec succès ===\n";
    
} catch (Exception $e) {
    echo "ERREUR : " . $e->getMessage() . "\n";
    echo "Trace : " . $e->getTraceAsString() . "\n";
}
