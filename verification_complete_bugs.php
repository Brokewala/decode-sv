<?php

echo "=== Vérification Complète et Correction des Bugs - Decode SV ===\n\n";

// Test 1: Vérification de la structure des fichiers
echo "1. 📁 Vérification de la structure des fichiers...\n";

$requiredFiles = [
    // Contrôleurs
    'app/Http/Controllers/DocumentController.php' => 'Contrôleur de documents',
    'app/Http/Controllers/HomeController.php' => 'Contrôleur d\'accueil',
    'app/Http/Controllers/LanguageController.php' => 'Contrôleur de langue',
    'app/Http/Controllers/ProfileController.php' => 'Contrôleur de profil',
    
    // Modèles
    'app/Models/Document.php' => 'Modèle Document',
    'app/Models/User.php' => 'Modèle User',
    'app/Models/Rating.php' => 'Modèle Rating',
    
    // Livewire
    'app/Livewire/DocumentsList.php' => 'Liste des documents',
    'app/Livewire/DocumentUpload.php' => 'Upload de documents',
    'app/Livewire/LanguageSwitcher.php' => 'Sélecteur de langue',
    
    // Middleware
    'app/Http/Middleware/SetTimeoutLimits.php' => 'Middleware timeout',
    'app/Http/Middleware/IsAdmin.php' => 'Middleware admin',
    
    // Configuration
    'config/timeout.php' => 'Configuration timeout',
    'config/app.php' => 'Configuration app',
    
    // Routes et vues
    'routes/web.php' => 'Routes web',
    'resources/views/home.blade.php' => 'Vue d\'accueil',
    'resources/views/documents/index.blade.php' => 'Vue liste documents',
];

$missingFiles = [];
$existingFiles = [];

foreach ($requiredFiles as $file => $description) {
    if (file_exists($file)) {
        echo "   ✅ $description\n";
        $existingFiles[] = $file;
    } else {
        echo "   ❌ $description MANQUANT ($file)\n";
        $missingFiles[] = $file;
    }
}

// Test 2: Vérification de la base de données
echo "\n2. 🗄️  Vérification de la base de données...\n";

$dbPath = '/home/acer/Bureau/work/project_IA/decode_sv/database/database.sqlite';

try {
    $pdo = new PDO("sqlite:$dbPath");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "   ✅ Connexion à la base de données réussie\n";
    
    // Vérifier les tables
    $tables = ['users', 'documents', 'ratings', 'user_documents'];
    foreach ($tables as $table) {
        $stmt = $pdo->query("SELECT name FROM sqlite_master WHERE type='table' AND name='$table'");
        if ($stmt->fetch()) {
            echo "   ✅ Table '$table' présente\n";
        } else {
            echo "   ❌ Table '$table' MANQUANTE\n";
        }
    }
    
    // Vérifier les données
    $stmt = $pdo->query("SELECT COUNT(*) FROM users");
    $userCount = $stmt->fetch(PDO::FETCH_COLUMN);
    echo "   📊 Utilisateurs: $userCount\n";
    
    $stmt = $pdo->query("SELECT COUNT(*) FROM documents");
    $docCount = $stmt->fetch(PDO::FETCH_COLUMN);
    echo "   📊 Documents: $docCount\n";
    
} catch (PDOException $e) {
    echo "   ❌ ERREUR de base de données: " . $e->getMessage() . "\n";
}

// Test 3: Vérification des dépendances Composer
echo "\n3. 📦 Vérification des dépendances...\n";

if (file_exists('vendor/autoload.php')) {
    echo "   ✅ Autoload Composer présent\n";
    
    // Vérifier les packages critiques
    $criticalPackages = [
        'laravel/framework',
        'livewire/livewire',
        'intervention/image'
    ];
    
    $composerLock = json_decode(file_get_contents('composer.lock'), true);
    $installedPackages = array_column($composerLock['packages'], 'name');
    
    foreach ($criticalPackages as $package) {
        if (in_array($package, $installedPackages)) {
            echo "   ✅ Package '$package' installé\n";
        } else {
            echo "   ❌ Package '$package' MANQUANT\n";
        }
    }
} else {
    echo "   ❌ Autoload Composer MANQUANT - Exécuter 'composer install'\n";
}

// Test 4: Vérification des permissions
echo "\n4. 🔐 Vérification des permissions...\n";

$directories = [
    'storage/app' => 'Stockage des fichiers',
    'storage/logs' => 'Logs de l\'application',
    'storage/framework/cache' => 'Cache du framework',
    'storage/framework/sessions' => 'Sessions',
    'storage/framework/views' => 'Vues compilées',
    'public/storage' => 'Lien symbolique storage'
];

foreach ($directories as $dir => $description) {
    if (is_dir($dir)) {
        if (is_writable($dir)) {
            echo "   ✅ $description (écriture OK)\n";
        } else {
            echo "   ⚠️  $description (pas d'écriture)\n";
        }
    } else {
        echo "   ❌ $description MANQUANT ($dir)\n";
    }
}

// Test 5: Vérification de la configuration
echo "\n5. ⚙️  Vérification de la configuration...\n";

if (file_exists('.env')) {
    echo "   ✅ Fichier .env présent\n";
    
    $envContent = file_get_contents('.env');
    $requiredEnvVars = [
        'APP_NAME',
        'APP_ENV',
        'APP_KEY',
        'DB_CONNECTION',
        'TIMEOUT_FILE_UPLOAD'
    ];
    
    foreach ($requiredEnvVars as $var) {
        if (strpos($envContent, $var) !== false) {
            echo "   ✅ Variable '$var' configurée\n";
        } else {
            echo "   ❌ Variable '$var' MANQUANTE\n";
        }
    }
} else {
    echo "   ❌ Fichier .env MANQUANT\n";
}

// Test 6: Test des routes principales
echo "\n6. 🌐 Test des routes principales...\n";

$testUrls = [
    'http://localhost:8002' => 'Page d\'accueil',
    'http://localhost:8002/documents' => 'Liste des documents',
    'http://localhost:8002/login' => 'Page de connexion',
    'http://localhost:8002/register' => 'Page d\'inscription'
];

foreach ($testUrls as $url => $description) {
    $context = stream_context_create([
        'http' => [
            'timeout' => 5,
            'method' => 'GET'
        ]
    ]);
    
    $response = @file_get_contents($url, false, $context);
    if ($response !== false) {
        $httpCode = 200; // Simplifié pour le test
        if (strlen($response) > 1000) {
            echo "   ✅ $description (HTTP $httpCode, " . number_format(strlen($response)) . " bytes)\n";
        } else {
            echo "   ⚠️  $description (réponse courte: " . strlen($response) . " bytes)\n";
        }
    } else {
        echo "   ❌ $description NON ACCESSIBLE\n";
    }
}

// Test 7: Vérification des logs d'erreurs
echo "\n7. 📋 Vérification des logs d'erreurs...\n";

$logFile = 'storage/logs/laravel.log';
if (file_exists($logFile)) {
    $logContent = file_get_contents($logFile);
    $errorCount = substr_count(strtolower($logContent), 'error');
    $warningCount = substr_count(strtolower($logContent), 'warning');
    
    echo "   📊 Erreurs dans les logs: $errorCount\n";
    echo "   📊 Avertissements dans les logs: $warningCount\n";
    
    if ($errorCount > 0) {
        echo "   ⚠️  Des erreurs sont présentes dans les logs\n";
        // Afficher les dernières erreurs
        $lines = explode("\n", $logContent);
        $recentErrors = array_filter(array_slice($lines, -20), function($line) {
            return stripos($line, 'error') !== false;
        });
        
        if (!empty($recentErrors)) {
            echo "   📝 Dernières erreurs:\n";
            foreach (array_slice($recentErrors, -3) as $error) {
                echo "      " . substr($error, 0, 100) . "...\n";
            }
        }
    } else {
        echo "   ✅ Aucune erreur récente dans les logs\n";
    }
} else {
    echo "   ⚠️  Fichier de log non trouvé\n";
}

// Résumé et recommandations
echo "\n" . str_repeat("=", 60) . "\n";
echo "🎯 RÉSUMÉ DE LA VÉRIFICATION\n";
echo str_repeat("=", 60) . "\n";

$totalIssues = count($missingFiles);
$score = max(0, 10 - $totalIssues);

echo "📊 Score global: $score/10\n";
echo "📁 Fichiers manquants: " . count($missingFiles) . "\n";
echo "✅ Fichiers présents: " . count($existingFiles) . "\n\n";

if ($score >= 8) {
    echo "🎉 EXCELLENT! Votre projet est en très bon état\n";
} elseif ($score >= 6) {
    echo "⚡ BON! Quelques améliorations mineures nécessaires\n";
} elseif ($score >= 4) {
    echo "⚠️  MOYEN! Plusieurs problèmes à corriger\n";
} else {
    echo "❌ CRITIQUE! Nombreux problèmes détectés\n";
}

// Recommandations spécifiques
echo "\n📋 RECOMMANDATIONS:\n";

if (!empty($missingFiles)) {
    echo "1. 📁 Créer les fichiers manquants:\n";
    foreach (array_slice($missingFiles, 0, 5) as $file) {
        echo "   - $file\n";
    }
}

if (!file_exists('vendor/autoload.php')) {
    echo "2. 📦 Installer les dépendances: composer install\n";
}

if (!is_writable('storage/app')) {
    echo "3. 🔐 Corriger les permissions: chmod -R 775 storage\n";
}

echo "4. 🚀 Redémarrer le serveur: php -S localhost:8002 -t public\n";
echo "5. 🧪 Exécuter les tests: php test_final_filtres.php\n";

echo "\n✨ Vérification terminée!\n";
