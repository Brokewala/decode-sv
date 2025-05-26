<?php

echo "=== Création de données de test pour les filtres ===\n\n";

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

// Vérifier si des documents existent déjà
$stmt = $pdo->query("SELECT COUNT(*) as count FROM documents");
$existingCount = $stmt->fetch(PDO::FETCH_ASSOC)['count'];

if ($existingCount > 0) {
    echo "📊 $existingCount documents existants trouvés\n";
    echo "Voulez-vous ajouter des données de test supplémentaires ? (y/N): ";
    $handle = fopen("php://stdin", "r");
    $line = fgets($handle);
    if (trim($line) !== 'y' && trim($line) !== 'Y') {
        echo "Arrêt du script.\n";
        exit(0);
    }
    fclose($handle);
}

// Données de test
$testDocuments = [
    [
        'title' => 'Guide de traduction français-anglais',
        'country' => 'France',
        'format' => 'pdf',
        'description' => 'Guide complet pour la traduction français-anglais avec exemples pratiques',
        'price' => 1,
        'file_path' => 'documents/original/test_guide_fr_en.pdf',
        'preview_path' => 'documents/previews/generic-pdf.jpg',
        'is_verified' => 1,
        'downloads' => 15
    ],
    [
        'title' => 'Modèle de contrat commercial',
        'country' => 'Belgique',
        'format' => 'docx',
        'description' => 'Modèle de contrat commercial en français avec clauses standards',
        'price' => 2,
        'file_path' => 'documents/original/test_contrat_commercial.docx',
        'preview_path' => 'documents/previews/generic-docx.jpg',
        'is_verified' => 1,
        'downloads' => 8
    ],
    [
        'title' => 'Tableau de conjugaison allemande',
        'country' => 'Allemagne',
        'format' => 'xlsx',
        'description' => 'Tableau Excel avec toutes les conjugaisons allemandes',
        'price' => 2,
        'file_path' => 'documents/original/test_conjugaison_de.xlsx',
        'preview_path' => 'documents/previews/generic-xlsx.jpg',
        'is_verified' => 1,
        'downloads' => 22
    ],
    [
        'title' => 'Lexique juridique international',
        'country' => 'Suisse',
        'format' => 'pdf',
        'description' => 'Lexique des termes juridiques en français, allemand et italien',
        'price' => 1,
        'file_path' => 'documents/original/test_lexique_juridique.pdf',
        'preview_path' => 'documents/previews/generic-pdf.jpg',
        'is_verified' => 1,
        'downloads' => 31
    ],
    [
        'title' => 'Formulaire de demande de visa',
        'country' => 'Canada',
        'format' => 'doc',
        'description' => 'Formulaire officiel de demande de visa pour le Canada',
        'price' => 2,
        'file_path' => 'documents/original/test_visa_canada.doc',
        'preview_path' => 'documents/previews/generic-doc.jpg',
        'is_verified' => 1,
        'downloads' => 12
    ],
    [
        'title' => 'Guide de style typographique',
        'country' => 'France',
        'format' => 'pdf',
        'description' => 'Règles de typographie française pour les traducteurs',
        'price' => 1,
        'file_path' => 'documents/original/test_typo_fr.pdf',
        'preview_path' => 'documents/previews/generic-pdf.jpg',
        'is_verified' => 1,
        'downloads' => 7
    ],
    [
        'title' => 'Modèle de CV européen',
        'country' => 'International',
        'format' => 'docx',
        'description' => 'Modèle de CV au format Europass',
        'price' => 2,
        'file_path' => 'documents/original/test_cv_europass.docx',
        'preview_path' => 'documents/previews/generic-docx.jpg',
        'is_verified' => 1,
        'downloads' => 45
    ],
    [
        'title' => 'Glossaire médical multilingue',
        'country' => 'Espagne',
        'format' => 'xlsx',
        'description' => 'Glossaire des termes médicaux en espagnol, français et anglais',
        'price' => 2,
        'file_path' => 'documents/original/test_medical_es.xlsx',
        'preview_path' => 'documents/previews/generic-xlsx.jpg',
        'is_verified' => 1,
        'downloads' => 18
    ],
    [
        'title' => 'Document en attente de validation',
        'country' => 'Italie',
        'format' => 'pdf',
        'description' => 'Ce document est en attente de validation par les modérateurs',
        'price' => 1,
        'file_path' => 'documents/original/test_pending.pdf',
        'preview_path' => 'documents/previews/generic-pdf.jpg',
        'is_verified' => 0,
        'downloads' => 0
    ],
    [
        'title' => 'Manuel de traduction technique',
        'country' => 'Royaume-Uni',
        'format' => 'pdf',
        'description' => 'Guide pour la traduction de documents techniques anglais-français',
        'price' => 1,
        'file_path' => 'documents/original/test_tech_uk.pdf',
        'preview_path' => 'documents/previews/generic-pdf.jpg',
        'is_verified' => 1,
        'downloads' => 9
    ]
];

// Insérer les données de test
echo "\n📝 Insertion des données de test...\n";

$insertStmt = $pdo->prepare("
    INSERT INTO documents (
        user_id, title, country, format, description, price, 
        file_path, preview_path, is_verified, downloads, created_at, updated_at
    ) VALUES (
        1, ?, ?, ?, ?, ?, ?, ?, ?, ?, datetime('now'), datetime('now')
    )
");

$inserted = 0;
foreach ($testDocuments as $doc) {
    try {
        $insertStmt->execute([
            $doc['title'],
            $doc['country'],
            $doc['format'],
            $doc['description'],
            $doc['price'],
            $doc['file_path'],
            $doc['preview_path'],
            $doc['is_verified'],
            $doc['downloads']
        ]);
        $inserted++;
        echo "✅ Inséré : " . $doc['title'] . "\n";
    } catch (PDOException $e) {
        echo "❌ Erreur pour '" . $doc['title'] . "' : " . $e->getMessage() . "\n";
    }
}

echo "\n📊 Résumé de l'insertion :\n";
echo "   - Documents insérés : $inserted\n";
echo "   - Documents échoués : " . (count($testDocuments) - $inserted) . "\n";

// Vérifier les statistiques finales
$stmt = $pdo->query("SELECT COUNT(*) as total FROM documents");
$totalDocs = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

$stmt = $pdo->query("SELECT COUNT(*) as verified FROM documents WHERE is_verified = 1");
$verifiedDocs = $stmt->fetch(PDO::FETCH_ASSOC)['verified'];

echo "\n📈 Statistiques finales :\n";
echo "   - Total documents : $totalDocs\n";
echo "   - Documents vérifiés : $verifiedDocs\n";
echo "   - Documents en attente : " . ($totalDocs - $verifiedDocs) . "\n";

// Afficher les statistiques par pays et format
echo "\n🌍 Répartition par pays :\n";
$stmt = $pdo->query("SELECT country, COUNT(*) as count FROM documents WHERE is_verified = 1 GROUP BY country ORDER BY count DESC");
$countries = $stmt->fetchAll(PDO::FETCH_ASSOC);
foreach ($countries as $country) {
    echo "   - " . $country['country'] . " : " . $country['count'] . " documents\n";
}

echo "\n📄 Répartition par format :\n";
$stmt = $pdo->query("SELECT format, COUNT(*) as count FROM documents WHERE is_verified = 1 GROUP BY format ORDER BY count DESC");
$formats = $stmt->fetchAll(PDO::FETCH_ASSOC);
foreach ($formats as $format) {
    echo "   - " . strtoupper($format['format']) . " : " . $format['count'] . " documents\n";
}

echo "\n🎉 Données de test créées avec succès !\n";
echo "\nVous pouvez maintenant tester les filtres :\n";
echo "1. Lancer le serveur : php -S localhost:8001 -t public\n";
echo "2. Ouvrir http://localhost:8001 dans le navigateur\n";
echo "3. Aller dans la section 'Documents'\n";
echo "4. Tester les différents filtres (pays, format, prix, recherche)\n\n";
