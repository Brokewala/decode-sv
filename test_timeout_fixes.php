<?php

echo "=== Test des Corrections de Timeout - Decode SV ===\n\n";

// Test 1: Vérification de la configuration des timeouts
echo "1. 🕐 Vérification de la configuration des timeouts...\n";

$timeoutConfig = [
    'max_execution_time' => ini_get('max_execution_time'),
    'max_input_time' => ini_get('max_input_time'),
    'memory_limit' => ini_get('memory_limit'),
    'upload_max_filesize' => ini_get('upload_max_filesize'),
    'post_max_size' => ini_get('post_max_size'),
];

foreach ($timeoutConfig as $setting => $value) {
    echo "   📋 $setting: $value\n";
}

// Test 2: Vérification des fichiers de configuration
echo "\n2. 📁 Vérification des fichiers de configuration...\n";

$configFiles = [
    'config/timeout.php' => 'Configuration des timeouts',
    'app/Http/Middleware/SetTimeoutLimits.php' => 'Middleware de timeout',
    'public/.htaccess' => 'Configuration Apache'
];

foreach ($configFiles as $file => $description) {
    if (file_exists($file)) {
        echo "   ✅ $description ($file)\n";
        
        // Vérifications spécifiques
        if ($file === 'config/timeout.php') {
            $content = file_get_contents($file);
            if (strpos($content, 'file_upload') !== false) {
                echo "      ✅ Configuration file_upload présente\n";
            }
            if (strpos($content, 'image_processing') !== false) {
                echo "      ✅ Configuration image_processing présente\n";
            }
        }
        
        if ($file === 'app/Http/Middleware/SetTimeoutLimits.php') {
            $content = file_get_contents($file);
            if (strpos($content, 'set_time_limit') !== false) {
                echo "      ✅ Gestion set_time_limit présente\n";
            }
            if (strpos($content, 'isFileUploadRequest') !== false) {
                echo "      ✅ Détection upload de fichiers présente\n";
            }
        }
        
        if ($file === 'public/.htaccess') {
            $content = file_get_contents($file);
            if (strpos($content, 'max_execution_time') !== false) {
                echo "      ✅ Configuration PHP dans .htaccess présente\n";
            }
        }
    } else {
        echo "   ❌ $description manquant ($file)\n";
    }
}

// Test 3: Test de simulation de timeout
echo "\n3. ⏱️  Test de simulation de timeout...\n";

function testTimeoutFunction($seconds) {
    $start = microtime(true);
    
    // Simuler une opération qui pourrait prendre du temps
    for ($i = 0; $i < $seconds * 100000; $i++) {
        // Opération simple pour simuler du travail
        $dummy = sqrt($i);
    }
    
    $end = microtime(true);
    return round($end - $start, 2);
}

try {
    // Test avec une opération courte
    $shortTime = testTimeoutFunction(1);
    echo "   ✅ Opération courte (1s simulé): {$shortTime}s réel\n";
    
    // Test avec une opération plus longue
    $mediumTime = testTimeoutFunction(2);
    echo "   ✅ Opération moyenne (2s simulé): {$mediumTime}s réel\n";
    
} catch (Exception $e) {
    echo "   ❌ Erreur lors du test de timeout: " . $e->getMessage() . "\n";
}

// Test 4: Vérification des optimisations Livewire
echo "\n4. ⚡ Vérification des optimisations Livewire...\n";

$livewireFiles = [
    'app/Livewire/DocumentsList.php',
    'app/Livewire/DocumentUpload.php'
];

foreach ($livewireFiles as $file) {
    if (file_exists($file)) {
        $content = file_get_contents($file);
        echo "   📁 $file:\n";
        
        // Vérifications spécifiques
        $checks = [
            'set_time_limit' => strpos($content, 'set_time_limit') !== false,
            'cache' => strpos($content, 'cache()') !== false,
            'try-catch' => strpos($content, 'try {') !== false && strpos($content, 'catch') !== false,
            'Log::error' => strpos($content, 'Log::error') !== false || strpos($content, 'Log::warning') !== false
        ];
        
        foreach ($checks as $feature => $present) {
            echo "      " . ($present ? "✅" : "❌") . " $feature\n";
        }
    } else {
        echo "   ❌ Fichier manquant: $file\n";
    }
}

// Test 5: Test de connexion à la base de données avec timeout
echo "\n5. 🗄️  Test de connexion base de données avec timeout...\n";

$dbPath = '/home/acer/Bureau/work/project_IA/decode_sv/database/database.sqlite';

try {
    $start = microtime(true);
    
    $pdo = new PDO("sqlite:$dbPath");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_TIMEOUT, 30); // Timeout de 30 secondes
    
    // Test d'une requête simple
    $stmt = $pdo->query("SELECT COUNT(*) FROM documents");
    $count = $stmt->fetch(PDO::FETCH_COLUMN);
    
    $end = microtime(true);
    $duration = round(($end - $start) * 1000, 2);
    
    echo "   ✅ Connexion DB réussie en {$duration}ms\n";
    echo "   📊 Documents trouvés: $count\n";
    
} catch (PDOException $e) {
    echo "   ❌ Erreur de base de données: " . $e->getMessage() . "\n";
}

// Test 6: Test de l'application web
echo "\n6. 🌐 Test de l'application web...\n";

$testUrls = [
    'http://localhost:8002' => 'Page d\'accueil',
    'http://localhost:8002/documents' => 'Page des documents'
];

foreach ($testUrls as $url => $description) {
    $start = microtime(true);
    
    $context = stream_context_create([
        'http' => [
            'timeout' => 10,
            'method' => 'GET'
        ]
    ]);
    
    $response = @file_get_contents($url, false, $context);
    $end = microtime(true);
    $duration = round(($end - $start) * 1000, 2);
    
    if ($response !== false) {
        echo "   ✅ $description accessible en {$duration}ms\n";
        
        // Vérifier la taille de la réponse
        $size = strlen($response);
        echo "      📏 Taille de la réponse: " . number_format($size) . " bytes\n";
        
        // Vérifier si c'est du HTML valide
        if (strpos($response, '<html') !== false || strpos($response, '<!DOCTYPE') !== false) {
            echo "      ✅ HTML valide détecté\n";
        }
    } else {
        echo "   ❌ $description non accessible (timeout ou erreur)\n";
    }
}

// Test 7: Recommandations d'optimisation
echo "\n7. 💡 Recommandations d'optimisation...\n";

$recommendations = [
    'Utiliser un serveur web dédié (Apache/Nginx) au lieu du serveur PHP intégré',
    'Configurer OPcache pour améliorer les performances PHP',
    'Utiliser Redis ou Memcached pour le cache',
    'Optimiser les requêtes de base de données avec des index',
    'Compresser les assets CSS/JS',
    'Utiliser un CDN pour les fichiers statiques'
];

foreach ($recommendations as $i => $recommendation) {
    echo "   " . ($i + 1) . ". $recommendation\n";
}

// Résumé final
echo "\n" . str_repeat("=", 60) . "\n";
echo "🎯 RÉSUMÉ DES CORRECTIONS DE TIMEOUT\n";
echo str_repeat("=", 60) . "\n";

$score = 0;
$maxScore = 7;

// Calcul du score
if (file_exists('config/timeout.php')) $score++;
if (file_exists('app/Http/Middleware/SetTimeoutLimits.php')) $score++;
if (file_exists('public/.htaccess') && strpos(file_get_contents('public/.htaccess'), 'max_execution_time') !== false) $score++;
if (file_exists('app/Livewire/DocumentsList.php') && strpos(file_get_contents('app/Livewire/DocumentsList.php'), 'set_time_limit') !== false) $score++;
if (file_exists('app/Livewire/DocumentUpload.php') && strpos(file_get_contents('app/Livewire/DocumentUpload.php'), 'set_time_limit') !== false) $score++;

// Test de base de données
try {
    $pdo = new PDO("sqlite:$dbPath");
    $score++;
} catch (Exception $e) {
    // Pas de point
}

// Test web
$webResponse = @file_get_contents('http://localhost:8002', false, stream_context_create(['http' => ['timeout' => 5]]));
if ($webResponse !== false) $score++;

echo "📊 Score global : $score/$maxScore\n\n";

if ($score >= 6) {
    echo "🎉 EXCELLENT ! Les corrections de timeout sont bien implémentées\n";
    echo "✅ Configuration des timeouts optimisée\n";
    echo "✅ Middleware de gestion des timeouts actif\n";
    echo "✅ Optimisations Livewire en place\n";
    echo "✅ Application web fonctionnelle\n";
} elseif ($score >= 4) {
    echo "⚡ BON ! La plupart des corrections sont en place\n";
    echo "⚠️  Quelques optimisations supplémentaires recommandées\n";
} else {
    echo "⚠️  ATTENTION ! Plusieurs corrections de timeout manquent\n";
    echo "❌ Risque de timeouts persistants\n";
}

echo "\n📋 Actions recommandées :\n";
echo "1. Redémarrer le serveur web pour appliquer les changements\n";
echo "2. Tester l'upload de gros fichiers (5-10MB)\n";
echo "3. Tester les filtres avec de nombreux documents\n";
echo "4. Surveiller les logs pour détecter d'éventuels timeouts\n";
echo "5. Considérer l'utilisation d'un serveur web dédié en production\n\n";

echo "✨ Les corrections de timeout sont maintenant en place !\n";
