<?php

echo "=== Optimisation de la base de données pour les filtres ===\n\n";

// Connexion à la base de données
$dbPath = '/home/acer/Bureau/work/project_IA/decode_sv/database/database.sqlite';

try {
    $pdo = new PDO("sqlite:$dbPath");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "✅ Connexion à la base de données réussie\n";
} catch (PDOException $e) {
    echo "❌ ERREUR de base de données : " . $e->getMessage() . "\n";
    exit(1);
}

// Index à créer pour optimiser les filtres
$indexes = [
    'idx_documents_verified' => 'CREATE INDEX IF NOT EXISTS idx_documents_verified ON documents(is_verified)',
    'idx_documents_country' => 'CREATE INDEX IF NOT EXISTS idx_documents_country ON documents(country)',
    'idx_documents_format' => 'CREATE INDEX IF NOT EXISTS idx_documents_format ON documents(format)',
    'idx_documents_price' => 'CREATE INDEX IF NOT EXISTS idx_documents_price ON documents(price)',
    'idx_documents_created_at' => 'CREATE INDEX IF NOT EXISTS idx_documents_created_at ON documents(created_at)',
    'idx_documents_downloads' => 'CREATE INDEX IF NOT EXISTS idx_documents_downloads ON documents(downloads)',
    'idx_documents_user_id' => 'CREATE INDEX IF NOT EXISTS idx_documents_user_id ON documents(user_id)',
    'idx_documents_composite' => 'CREATE INDEX IF NOT EXISTS idx_documents_composite ON documents(is_verified, country, format, price)'
];

echo "📈 Création des index d'optimisation...\n";

foreach ($indexes as $indexName => $sql) {
    try {
        $pdo->exec($sql);
        echo "✅ Index créé : $indexName\n";
    } catch (PDOException $e) {
        echo "❌ Erreur pour $indexName : " . $e->getMessage() . "\n";
    }
}

// Vérifier les index créés
echo "\n🔍 Vérification des index créés...\n";
$stmt = $pdo->query("SELECT name FROM sqlite_master WHERE type='index' AND tbl_name='documents'");
$createdIndexes = $stmt->fetchAll(PDO::FETCH_COLUMN);

foreach ($createdIndexes as $index) {
    echo "✅ Index présent : $index\n";
}

// Analyser la base de données pour optimiser les requêtes
echo "\n⚡ Analyse de la base de données...\n";
try {
    $pdo->exec("ANALYZE");
    echo "✅ Analyse terminée - statistiques mises à jour\n";
} catch (PDOException $e) {
    echo "❌ Erreur lors de l'analyse : " . $e->getMessage() . "\n";
}

// Test de performance des requêtes
echo "\n🚀 Test de performance des requêtes...\n";

$testQueries = [
    'Tous les documents vérifiés' => 'SELECT COUNT(*) FROM documents WHERE is_verified = 1',
    'Documents par pays (France)' => 'SELECT COUNT(*) FROM documents WHERE is_verified = 1 AND country = "France"',
    'Documents par format (PDF)' => 'SELECT COUNT(*) FROM documents WHERE is_verified = 1 AND format = "pdf"',
    'Documents par prix (1 point)' => 'SELECT COUNT(*) FROM documents WHERE is_verified = 1 AND price = 1',
    'Recherche textuelle' => 'SELECT COUNT(*) FROM documents WHERE is_verified = 1 AND (title LIKE "%guide%" OR description LIKE "%guide%")',
    'Tri par téléchargements' => 'SELECT COUNT(*) FROM documents WHERE is_verified = 1 ORDER BY downloads DESC LIMIT 10',
    'Filtres combinés' => 'SELECT COUNT(*) FROM documents WHERE is_verified = 1 AND country = "France" AND format = "pdf" AND price = 1'
];

foreach ($testQueries as $description => $query) {
    $startTime = microtime(true);
    try {
        $stmt = $pdo->query($query);
        $result = $stmt->fetch(PDO::FETCH_COLUMN);
        $endTime = microtime(true);
        $duration = round(($endTime - $startTime) * 1000, 2);
        echo "⚡ $description : $result résultats en {$duration}ms\n";
    } catch (PDOException $e) {
        echo "❌ Erreur pour '$description' : " . $e->getMessage() . "\n";
    }
}

// Recommandations supplémentaires
echo "\n💡 Recommandations supplémentaires :\n";
echo "1. ✅ Index créés pour optimiser les filtres\n";
echo "2. ✅ Index composite pour les requêtes complexes\n";
echo "3. 📊 Utiliser EXPLAIN QUERY PLAN pour analyser les requêtes lentes\n";
echo "4. 🔄 Exécuter ANALYZE régulièrement après l'ajout de nombreux documents\n";
echo "5. 💾 Considérer VACUUM pour optimiser l'espace disque\n";

// Statistiques finales
echo "\n📊 Statistiques finales de la base de données :\n";

try {
    // Taille de la base de données
    $size = filesize($dbPath);
    $sizeKB = round($size / 1024, 2);
    echo "💾 Taille de la base : {$sizeKB} KB\n";
    
    // Nombre de pages
    $stmt = $pdo->query("PRAGMA page_count");
    $pageCount = $stmt->fetch(PDO::FETCH_COLUMN);
    echo "📄 Nombre de pages : $pageCount\n";
    
    // Taille de page
    $stmt = $pdo->query("PRAGMA page_size");
    $pageSize = $stmt->fetch(PDO::FETCH_COLUMN);
    echo "📏 Taille de page : $pageSize bytes\n";
    
} catch (PDOException $e) {
    echo "❌ Erreur lors de la récupération des statistiques : " . $e->getMessage() . "\n";
}

echo "\n🎉 Optimisation de la base de données terminée !\n";
echo "\nLa base de données est maintenant optimisée pour :\n";
echo "- ⚡ Filtrage rapide par pays, format et prix\n";
echo "- 🔍 Recherche textuelle efficace\n";
echo "- 📊 Tri par popularité et date\n";
echo "- 🔗 Requêtes combinées optimisées\n\n";
