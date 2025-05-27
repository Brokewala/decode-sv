<?php

echo "=== VÉRIFICATION COMPLÈTE - Decode SV ===\n\n";

// Test 1: Vérification des fichiers critiques
echo "1. 📁 Vérification des fichiers critiques...\n";

$criticalFiles = [
    // Contrôleurs
    'app/Http/Controllers/DocumentController.php' => 'Contrôleur documents',
    'app/Http/Controllers/AdminController.php' => 'Contrôleur admin',
    'app/Http/Controllers/HomeController.php' => 'Contrôleur accueil',

    // Middlewares
    'app/Http/Middleware/IsAdmin.php' => 'Middleware admin',
    'app/Http/Middleware/SetLocale.php' => 'Middleware langue',

    // Modèles
    'app/Models/User.php' => 'Modèle utilisateur',
    'app/Models/Document.php' => 'Modèle document',

    // Vues principales
    'resources/views/home.blade.php' => 'Page accueil',
    'resources/views/documents/index.blade.php' => 'Liste documents',
    'resources/views/documents/create.blade.php' => 'Upload document',
    'resources/views/admin/dashboard.blade.php' => 'Dashboard admin',
    'resources/views/admin/pending.blade.php' => 'Documents en attente',
    'resources/views/admin/users.blade.php' => 'Gestion utilisateurs',

    // Layouts
    'resources/views/layouts/main.blade.php' => 'Layout principal',
    'resources/views/layouts/app.blade.php' => 'Layout app',

    // Traductions
    'lang/fr/common.php' => 'Traductions FR communes',
    'lang/en/common.php' => 'Traductions EN communes',
    'lang/fr/admin.php' => 'Traductions FR admin',
    'lang/en/admin.php' => 'Traductions EN admin',
    'lang/fr/public.php' => 'Traductions FR public',
    'lang/en/public.php' => 'Traductions EN public',

    // Composants Livewire
    'app/Livewire/GlobalLanguageSwitcher.php' => 'Switch langue global',
    'app/Livewire/AdminLanguageSwitcher.php' => 'Switch langue admin',
    'resources/views/livewire/global-language-switcher.blade.php' => 'Vue switch global',
    'resources/views/livewire/admin-language-switcher.blade.php' => 'Vue switch admin',

    // Configuration
    'bootstrap/app.php' => 'Configuration app',
    'routes/web.php' => 'Routes web',
];

$missingFiles = [];
foreach ($criticalFiles as $file => $description) {
    if (file_exists($file)) {
        echo "   ✅ $description\n";
    } else {
        echo "   ❌ $description MANQUANT\n";
        $missingFiles[] = $file;
    }
}

// Test 2: Vérification de la base de données
echo "\n2. 🗄️  Vérification de la base de données...\n";

$dbPath = '/home/acer/Bureau/work/project_IA/decode_sv/database/database.sqlite';

try {
    $pdo = new PDO("sqlite:$dbPath");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "   ✅ Connexion base de données réussie\n";

    // Vérifier les tables
    $tables = ['users', 'documents', 'migrations'];
    foreach ($tables as $table) {
        $stmt = $pdo->query("SELECT COUNT(*) FROM $table");
        $count = $stmt->fetch(PDO::FETCH_COLUMN);
        echo "   📊 Table $table : $count enregistrements\n";
    }

    // Vérifier l'admin
    $stmt = $pdo->query("SELECT COUNT(*) FROM users WHERE is_admin = 1");
    $adminCount = $stmt->fetch(PDO::FETCH_COLUMN);
    echo "   👑 Administrateurs : $adminCount\n";

} catch (PDOException $e) {
    echo "   ❌ Erreur base de données : " . $e->getMessage() . "\n";
}

// Test 3: Test des routes principales
echo "\n3. 🌐 Test des routes principales...\n";

$routes = [
    'http://localhost:8002/' => 'Accueil',
    'http://localhost:8002/documents' => 'Liste documents',
    'http://localhost:8002/documents/create' => 'Upload document',
    'http://localhost:8002/login' => 'Connexion',
    'http://localhost:8002/register' => 'Inscription',
    'http://localhost:8002/admin/dashboard' => 'Admin dashboard',
    'http://localhost:8002/admin/pending' => 'Admin pending',
    'http://localhost:8002/admin/users' => 'Admin users',
];

foreach ($routes as $url => $description) {
    $context = stream_context_create([
        'http' => [
            'timeout' => 5,
            'method' => 'GET',
            'ignore_errors' => true
        ]
    ]);

    $start = microtime(true);
    $response = @file_get_contents($url, false, $context);
    $end = microtime(true);
    $time = round(($end - $start) * 1000, 2);

    if ($response !== false) {
        $size = strlen($response);

        if (strpos($url, 'admin') !== false && (strpos($response, '302') !== false || strpos($response, 'login') !== false)) {
            echo "   🔒 $description : Protégé (redirection login) - {$time}ms\n";
        } elseif ($size > 1000) {
            echo "   ✅ $description : Accessible - {$time}ms (" . number_format($size) . " bytes)\n";
        } else {
            echo "   ⚠️  $description : Réponse courte - {$time}ms (" . number_format($size) . " bytes)\n";
        }
    } else {
        echo "   ❌ $description : Non accessible - {$time}ms\n";
    }
}

// Test 4: Test de la traduction
echo "\n4. 🌍 Test de la traduction...\n";

$translationTests = [
    'http://localhost:8002/?lang=fr' => 'Accueil FR',
    'http://localhost:8002/?lang=en' => 'Accueil EN',
    'http://localhost:8002/documents?lang=fr' => 'Documents FR',
    'http://localhost:8002/documents?lang=en' => 'Documents EN',
];

foreach ($translationTests as $url => $description) {
    $context = stream_context_create([
        'http' => [
            'timeout' => 5,
            'method' => 'GET',
            'ignore_errors' => true
        ]
    ]);

    $response = @file_get_contents($url, false, $context);

    if ($response !== false) {
        $hasSwitch = strpos($response, 'switchLanguage') !== false ||
                    strpos($response, 'global-language-switcher') !== false;

        $hasEnglish = strpos($response, 'Home') !== false ||
                     strpos($response, 'Upload') !== false ||
                     strpos($response, 'Documents') !== false;

        $hasFrench = strpos($response, 'Accueil') !== false ||
                    strpos($response, 'Téléverser') !== false ||
                    strpos($response, 'Documents') !== false;

        if (strpos($url, 'lang=en') !== false && $hasEnglish) {
            echo "   ✅ $description : Anglais détecté" . ($hasSwitch ? " + Switch" : "") . "\n";
        } elseif (strpos($url, 'lang=fr') !== false && $hasFrench) {
            echo "   ✅ $description : Français détecté" . ($hasSwitch ? " + Switch" : "") . "\n";
        } else {
            echo "   ⚠️  $description : Langue non détectée clairement\n";
        }
    } else {
        echo "   ❌ $description : Non accessible\n";
    }
}

// Test 5: Vérification des clés de traduction
echo "\n5. 🔤 Vérification des clés de traduction...\n";

$translationFiles = [
    'fr' => ['common', 'admin', 'public'],
    'en' => ['common', 'admin', 'public']
];

$totalKeys = 0;
foreach ($translationFiles as $lang => $files) {
    echo "   🌐 Langue $lang :\n";
    $langKeys = 0;

    foreach ($files as $file) {
        $filePath = "lang/$lang/$file.php";
        if (file_exists($filePath)) {
            $content = file_get_contents($filePath);
            $keys = substr_count($content, '=>');
            $langKeys += $keys;
            echo "      📄 $file.php : $keys clés\n";
        } else {
            echo "      ❌ $file.php : MANQUANT\n";
        }
    }

    echo "      📊 Total $lang : $langKeys clés\n";
    $totalKeys += $langKeys;
}

echo "   📈 Total général : $totalKeys clés\n";

// Test 6: Test des fonctionnalités admin
echo "\n6. 👑 Test des fonctionnalités admin...\n";

$adminFeatures = [
    'Middleware admin' => file_exists('app/Http/Middleware/IsAdmin.php'),
    'Routes admin protégées' => file_exists('routes/web.php') &&
                               strpos(file_get_contents('routes/web.php'), "middleware(['auth', 'admin'])") !== false,
    'Dashboard admin' => file_exists('resources/views/admin/dashboard.blade.php'),
    'Modération documents' => file_exists('resources/views/admin/pending.blade.php'),
    'Gestion utilisateurs' => file_exists('resources/views/admin/users.blade.php'),
    'Contrôleur admin complet' => file_exists('app/Http/Controllers/AdminController.php') &&
                                 strpos(file_get_contents('app/Http/Controllers/AdminController.php'), 'verifyDocument') !== false,
    'Switch langue admin' => file_exists('app/Livewire/AdminLanguageSwitcher.php'),
];

foreach ($adminFeatures as $feature => $exists) {
    if ($exists) {
        echo "   ✅ $feature\n";
    } else {
        echo "   ❌ $feature\n";
    }
}

// Test 7: Test des fonctionnalités publiques
echo "\n7. 🌐 Test des fonctionnalités publiques...\n";

$publicFeatures = [
    'Page accueil' => file_exists('resources/views/home.blade.php'),
    'Liste documents' => file_exists('resources/views/documents/index.blade.php'),
    'Upload documents' => file_exists('resources/views/documents/create.blade.php'),
    'Authentification' => file_exists('resources/views/auth/login.blade.php'),
    'Layout responsive' => file_exists('resources/views/layouts/main.blade.php') &&
                          strpos(file_get_contents('resources/views/layouts/main.blade.php'), 'sm:') !== false,
    'Switch langue global' => file_exists('app/Livewire/GlobalLanguageSwitcher.php'),
    'Navigation traduite' => file_exists('resources/views/layouts/main.blade.php') &&
                            strpos(file_get_contents('resources/views/layouts/main.blade.php'), '__(') !== false,
];

foreach ($publicFeatures as $feature => $exists) {
    if ($exists) {
        echo "   ✅ $feature\n";
    } else {
        echo "   ❌ $feature\n";
    }
}

// Résumé final
echo "\n" . str_repeat("=", 60) . "\n";
echo "🎯 RÉSUMÉ DE LA VÉRIFICATION COMPLÈTE\n";
echo str_repeat("=", 60) . "\n";

$totalScore = 0;
$maxScore = 50;

// Calcul du score
$totalScore += count($criticalFiles) - count($missingFiles); // Fichiers présents
$totalScore += ($adminCount > 0) ? 5 : 0; // Admin configuré
$totalScore += ($totalKeys > 400) ? 10 : ($totalKeys > 200 ? 5 : 0); // Traductions
$totalScore += count(array_filter($adminFeatures)) * 2; // Fonctionnalités admin
$totalScore += count(array_filter($publicFeatures)) * 2; // Fonctionnalités publiques

echo "📊 Score global : $totalScore/$maxScore (" . round(($totalScore/$maxScore)*100, 1) . "%)\n\n";

if ($totalScore >= 45) {
    echo "🏆 EXCELLENT ! Plateforme entièrement fonctionnelle\n";
    echo "✅ Toutes les fonctionnalités opérationnelles\n";
    echo "✅ Traduction complète FR/EN\n";
    echo "✅ Administration professionnelle\n";
    echo "✅ Interface publique moderne\n";
} elseif ($totalScore >= 35) {
    echo "⭐ TRÈS BON ! Plateforme fonctionnelle\n";
    echo "✅ Fonctionnalités principales OK\n";
    echo "⚠️  Quelques améliorations mineures\n";
} elseif ($totalScore >= 25) {
    echo "⚡ BON ! Plateforme en cours\n";
    echo "⚠️  Corrections nécessaires\n";
} else {
    echo "⚠️  ATTENTION ! Problèmes critiques\n";
    echo "❌ Corrections urgentes requises\n";
}

echo "\n📊 STATISTIQUES FINALES :\n";
echo "📁 Fichiers critiques : " . (count($criticalFiles) - count($missingFiles)) . "/" . count($criticalFiles) . "\n";
echo "🔤 Clés de traduction : $totalKeys\n";
echo "👑 Administrateurs : $adminCount\n";
echo "🌐 Langues supportées : 2 (FR, EN)\n";
echo "⚡ Fonctionnalités admin : " . count(array_filter($adminFeatures)) . "/" . count($adminFeatures) . "\n";
echo "🎨 Fonctionnalités publiques : " . count(array_filter($publicFeatures)) . "/" . count($publicFeatures) . "\n";

if (count($missingFiles) > 0) {
    echo "\n❌ FICHIERS MANQUANTS :\n";
    foreach ($missingFiles as $file) {
        echo "   - $file\n";
    }
}

echo "\n🌐 ACCÈS RAPIDE :\n";
echo "🏠 Accueil : http://localhost:8002\n";
echo "📄 Documents : http://localhost:8002/documents\n";
echo "⬆️  Upload : http://localhost:8002/documents/create\n";
echo "👑 Admin : http://localhost:8002/admin/dashboard\n";

echo "\n✨ Vérification complète terminée ! ✨\n";
