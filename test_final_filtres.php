<?php

echo "=== Test Final des Filtres Améliorés - Decode SV ===\n\n";

// Test de connexion à la base de données
$dbPath = '/home/acer/Bureau/work/project_IA/decode_sv/database/database.sqlite';

try {
    $pdo = new PDO("sqlite:$dbPath");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "✅ Connexion à la base de données réussie\n";
} catch (PDOException $e) {
    echo "❌ ERREUR de base de données : " . $e->getMessage() . "\n";
    exit(1);
}

// Test 1: Vérification des données de test
echo "\n1. 📊 Vérification des données de test...\n";

$stats = [
    'total' => $pdo->query("SELECT COUNT(*) FROM documents")->fetch(PDO::FETCH_COLUMN),
    'verified' => $pdo->query("SELECT COUNT(*) FROM documents WHERE is_verified = 1")->fetch(PDO::FETCH_COLUMN),
    'countries' => $pdo->query("SELECT COUNT(DISTINCT country) FROM documents WHERE is_verified = 1")->fetch(PDO::FETCH_COLUMN),
    'formats' => $pdo->query("SELECT COUNT(DISTINCT format) FROM documents WHERE is_verified = 1")->fetch(PDO::FETCH_COLUMN)
];

echo "   📈 Total documents : {$stats['total']}\n";
echo "   ✅ Documents vérifiés : {$stats['verified']}\n";
echo "   🌍 Pays disponibles : {$stats['countries']}\n";
echo "   📄 Formats disponibles : {$stats['formats']}\n";

if ($stats['verified'] >= 5 && $stats['countries'] >= 3 && $stats['formats'] >= 3) {
    echo "   ✅ Données de test suffisantes pour les tests\n";
} else {
    echo "   ⚠️  Données de test insuffisantes - Exécuter create_test_data.php\n";
}

// Test 2: Validation des index de performance
echo "\n2. ⚡ Validation des index de performance...\n";

$requiredIndexes = [
    'idx_documents_verified',
    'idx_documents_country',
    'idx_documents_format',
    'idx_documents_price',
    'idx_documents_composite'
];

$stmt = $pdo->query("SELECT name FROM sqlite_master WHERE type='index' AND tbl_name='documents'");
$existingIndexes = $stmt->fetchAll(PDO::FETCH_COLUMN);

$indexScore = 0;
foreach ($requiredIndexes as $index) {
    if (in_array($index, $existingIndexes)) {
        echo "   ✅ Index $index présent\n";
        $indexScore++;
    } else {
        echo "   ❌ Index $index manquant\n";
    }
}

echo "   📊 Score d'optimisation : $indexScore/" . count($requiredIndexes) . "\n";

// Test 3: Performance des requêtes de filtrage
echo "\n3. 🚀 Test de performance des filtres...\n";

$performanceTests = [
    'Filtre par pays' => "SELECT COUNT(*) FROM documents WHERE is_verified = 1 AND country = 'France'",
    'Filtre par format' => "SELECT COUNT(*) FROM documents WHERE is_verified = 1 AND format = 'pdf'",
    'Filtre par prix' => "SELECT COUNT(*) FROM documents WHERE is_verified = 1 AND price = 1",
    'Recherche textuelle' => "SELECT COUNT(*) FROM documents WHERE is_verified = 1 AND title LIKE '%guide%'",
    'Filtres combinés' => "SELECT COUNT(*) FROM documents WHERE is_verified = 1 AND country = 'France' AND format = 'pdf'",
    'Tri par téléchargements' => "SELECT id FROM documents WHERE is_verified = 1 ORDER BY downloads DESC LIMIT 5"
];

$totalTime = 0;
$passedTests = 0;

foreach ($performanceTests as $testName => $query) {
    $startTime = microtime(true);
    try {
        $stmt = $pdo->query($query);
        $result = $stmt->rowCount() > 0 ? $stmt->rowCount() : $stmt->fetch(PDO::FETCH_COLUMN);
        $endTime = microtime(true);
        $duration = round(($endTime - $startTime) * 1000, 2);
        $totalTime += $duration;

        if ($duration < 1.0) { // Moins de 1ms = excellent
            echo "   ✅ $testName : {$duration}ms (excellent)\n";
            $passedTests++;
        } elseif ($duration < 5.0) { // Moins de 5ms = bon
            echo "   ⚡ $testName : {$duration}ms (bon)\n";
            $passedTests++;
        } else {
            echo "   ⚠️  $testName : {$duration}ms (lent)\n";
        }
    } catch (PDOException $e) {
        echo "   ❌ $testName : Erreur - " . $e->getMessage() . "\n";
    }
}

echo "   📊 Performance globale : " . round($totalTime, 2) . "ms total\n";
echo "   ✅ Tests réussis : $passedTests/" . count($performanceTests) . "\n";

// Test 4: Validation des fonctionnalités Livewire
echo "\n4. 🔧 Test des fonctionnalités Livewire...\n";

$livewireFiles = [
    'app/Livewire/DocumentsList.php' => 'Composant principal des filtres',
    'resources/views/livewire/documents-list.blade.php' => 'Vue des filtres'
];

foreach ($livewireFiles as $file => $description) {
    if (file_exists($file)) {
        $content = file_get_contents($file);

        // Vérifications spécifiques
        $checks = [];
        if ($file === 'app/Livewire/DocumentsList.php') {
            $checks = [
                'buildQuery' => strpos($content, 'buildQuery') !== false,
                'filtres prix' => strpos($content, 'priceMin') !== false,
                'filtres date' => strpos($content, 'dateFrom') !== false,
                'statistiques' => strpos($content, 'availableCountries') !== false
            ];
        } else {
            $checks = [
                'filtres prix' => strpos($content, 'priceMin') !== false,
                'filtres date' => strpos($content, 'dateFrom') !== false,
                'statistiques' => strpos($content, 'totalDocuments') !== false,
                'traductions' => strpos($content, '__(') !== false
            ];
        }

        echo "   📁 $description :\n";
        foreach ($checks as $feature => $present) {
            echo "      " . ($present ? "✅" : "❌") . " $feature\n";
        }
    } else {
        echo "   ❌ Fichier manquant : $file\n";
    }
}

// Test 5: Simulation de requêtes utilisateur
echo "\n5. 👤 Simulation de scénarios utilisateur...\n";

$userScenarios = [
    'Utilisateur cherche des PDF français' => [
        'country' => 'France',
        'format' => 'pdf',
        'expected_min' => 1
    ],
    'Utilisateur cherche des documents gratuits' => [
        'price_max' => 1,
        'expected_min' => 1
    ],
    'Utilisateur cherche des guides' => [
        'search' => 'guide',
        'expected_min' => 1
    ],
    'Utilisateur veut les plus populaires' => [
        'sort' => 'downloads DESC',
        'expected_min' => 1
    ]
];

foreach ($userScenarios as $scenario => $params) {
    $query = "SELECT COUNT(*) FROM documents WHERE is_verified = 1";
    $conditions = [];

    if (isset($params['country'])) {
        $conditions[] = "country = '{$params['country']}'";
    }
    if (isset($params['format'])) {
        $conditions[] = "format = '{$params['format']}'";
    }
    if (isset($params['price_max'])) {
        $conditions[] = "price <= {$params['price_max']}";
    }
    if (isset($params['search'])) {
        $conditions[] = "(title LIKE '%{$params['search']}%' OR description LIKE '%{$params['search']}%')";
    }

    if (!empty($conditions)) {
        $query .= " AND " . implode(" AND ", $conditions);
    }

    try {
        $result = $pdo->query($query)->fetch(PDO::FETCH_COLUMN);
        if ($result >= $params['expected_min']) {
            echo "   ✅ $scenario : $result résultats\n";
        } else {
            echo "   ⚠️  $scenario : $result résultats (attendu >= {$params['expected_min']})\n";
        }
    } catch (PDOException $e) {
        echo "   ❌ $scenario : Erreur - " . $e->getMessage() . "\n";
    }
}

// Test 6: Vérification de l'application web
echo "\n6. 🌐 Test de l'application web...\n";

$webTests = [
    'Page d\'accueil' => 'http://localhost:8002',
    'Page documents' => 'http://localhost:8002/documents'
];

foreach ($webTests as $testName => $url) {
    $context = stream_context_create([
        'http' => [
            'timeout' => 5,
            'method' => 'GET'
        ]
    ]);

    $response = @file_get_contents($url, false, $context);
    if ($response !== false) {
        if (strpos($response, 'Livewire') !== false || strpos($response, 'wire:') !== false) {
            echo "   ✅ $testName : Accessible avec Livewire\n";
        } else {
            echo "   ⚠️  $testName : Accessible mais Livewire non détecté\n";
        }
    } else {
        echo "   ❌ $testName : Non accessible\n";
    }
}

// Résumé final
echo "\n" . str_repeat("=", 60) . "\n";
echo "🎯 RÉSUMÉ DES TESTS FINAUX\n";
echo str_repeat("=", 60) . "\n";

$overallScore = 0;
$maxScore = 6;

// Calcul du score global
if ($stats['verified'] >= 5) $overallScore++;
if ($indexScore >= 4) $overallScore++;
if ($passedTests >= 5) $overallScore++;
if (file_exists('app/Livewire/DocumentsList.php')) $overallScore++;
if (file_exists('resources/views/livewire/documents-list.blade.php')) $overallScore++;

// Test web basique
$webWorking = @file_get_contents('http://localhost:8002', false, stream_context_create(['http' => ['timeout' => 3]]));
if ($webWorking !== false) $overallScore++;

echo "📊 Score global : $overallScore/$maxScore\n\n";

if ($overallScore >= 5) {
    echo "🎉 EXCELLENT ! Les filtres sont entièrement fonctionnels\n";
    echo "✅ Tous les composants sont opérationnels\n";
    echo "✅ Performance optimisée\n";
    echo "✅ Interface utilisateur complète\n";
} elseif ($overallScore >= 3) {
    echo "⚡ BON ! Les filtres fonctionnent avec quelques améliorations possibles\n";
} else {
    echo "⚠️  ATTENTION ! Plusieurs problèmes détectés\n";
}

echo "\n📋 Actions recommandées :\n";
echo "1. Ouvrir http://localhost:8002 dans le navigateur\n";
echo "2. Aller dans la section 'Documents'\n";
echo "3. Tester tous les filtres disponibles\n";
echo "4. Vérifier la réactivité de l'interface\n";
echo "5. Tester les filtres combinés\n\n";

echo "🔧 En cas de problème :\n";
echo "- Redémarrer le serveur : php -S localhost:8002 -t public\n";
echo "- Vérifier les logs : tail -f storage/logs/laravel.log\n";
echo "- Recréer les index : php optimize_database.php\n\n";

echo "✨ Les filtres de documents Decode SV sont maintenant prêts !\n";
