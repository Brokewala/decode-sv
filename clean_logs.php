<?php

echo "=== Nettoyage des Logs - Decode SV ===\n\n";

$logFile = 'storage/logs/laravel.log';

if (file_exists($logFile)) {
    $originalSize = filesize($logFile);
    echo "📊 Taille originale du log: " . number_format($originalSize) . " bytes\n";
    
    // Lire le contenu du log
    $logContent = file_get_contents($logFile);
    $lines = explode("\n", $logContent);
    
    echo "📊 Nombre de lignes: " . count($lines) . "\n";
    
    // Compter les types d'erreurs
    $errorTypes = [
        'ERROR' => 0,
        'WARNING' => 0,
        'INFO' => 0,
        'DEBUG' => 0
    ];
    
    foreach ($lines as $line) {
        foreach ($errorTypes as $type => $count) {
            if (stripos($line, $type) !== false) {
                $errorTypes[$type]++;
            }
        }
    }
    
    echo "\n📈 Répartition des logs:\n";
    foreach ($errorTypes as $type => $count) {
        echo "   $type: $count\n";
    }
    
    // Garder seulement les logs des 7 derniers jours
    $cutoffDate = date('Y-m-d', strtotime('-7 days'));
    $filteredLines = [];
    
    foreach ($lines as $line) {
        // Extraire la date du log (format: [2025-05-26 19:25:36])
        if (preg_match('/\[(\d{4}-\d{2}-\d{2})/', $line, $matches)) {
            $logDate = $matches[1];
            if ($logDate >= $cutoffDate) {
                $filteredLines[] = $line;
            }
        } else if (!empty(trim($line))) {
            // Garder les lignes sans date (continuation d'erreurs)
            $filteredLines[] = $line;
        }
    }
    
    // Sauvegarder une copie de sauvegarde
    $backupFile = 'storage/logs/laravel_backup_' . date('Y-m-d_H-i-s') . '.log';
    copy($logFile, $backupFile);
    echo "\n💾 Sauvegarde créée: $backupFile\n";
    
    // Écrire le nouveau contenu filtré
    file_put_contents($logFile, implode("\n", $filteredLines));
    
    $newSize = filesize($logFile);
    $reduction = $originalSize - $newSize;
    $reductionPercent = round(($reduction / $originalSize) * 100, 1);
    
    echo "✅ Nettoyage terminé\n";
    echo "📊 Nouvelle taille: " . number_format($newSize) . " bytes\n";
    echo "📉 Réduction: " . number_format($reduction) . " bytes ($reductionPercent%)\n";
    echo "📊 Lignes conservées: " . count($filteredLines) . "/" . count($lines) . "\n";
    
} else {
    echo "⚠️  Fichier de log non trouvé: $logFile\n";
}

// Nettoyer aussi les autres logs
$otherLogs = [
    'storage/logs/laravel-*.log',
    'storage/framework/cache/data/*',
    'storage/framework/sessions/*',
    'storage/framework/views/*'
];

echo "\n🧹 Nettoyage des autres fichiers temporaires...\n";

foreach ($otherLogs as $pattern) {
    $files = glob($pattern);
    if ($files) {
        foreach ($files as $file) {
            if (is_file($file) && filemtime($file) < strtotime('-7 days')) {
                unlink($file);
                echo "   🗑️  Supprimé: " . basename($file) . "\n";
            }
        }
    }
}

// Optimiser la base de données
echo "\n🗄️  Optimisation de la base de données...\n";

$dbPath = '/home/acer/Bureau/work/project_IA/decode_sv/database/database.sqlite';

try {
    $pdo = new PDO("sqlite:$dbPath");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // VACUUM pour optimiser l'espace
    $pdo->exec("VACUUM");
    echo "   ✅ VACUUM exécuté\n";
    
    // ANALYZE pour mettre à jour les statistiques
    $pdo->exec("ANALYZE");
    echo "   ✅ ANALYZE exécuté\n";
    
    // Vérifier la taille de la base
    $dbSize = filesize($dbPath);
    echo "   📊 Taille de la base: " . number_format($dbSize) . " bytes\n";
    
} catch (PDOException $e) {
    echo "   ❌ Erreur DB: " . $e->getMessage() . "\n";
}

// Créer un rapport de santé
echo "\n📋 Création du rapport de santé...\n";

$healthReport = [
    'timestamp' => date('Y-m-d H:i:s'),
    'log_size_before' => $originalSize ?? 0,
    'log_size_after' => $newSize ?? 0,
    'reduction_percent' => $reductionPercent ?? 0,
    'error_types' => $errorTypes ?? [],
    'db_size' => $dbSize ?? 0,
    'php_memory_limit' => ini_get('memory_limit'),
    'php_max_execution_time' => ini_get('max_execution_time'),
    'disk_free_space' => disk_free_space('.'),
];

file_put_contents('storage/logs/health_report.json', json_encode($healthReport, JSON_PRETTY_PRINT));
echo "   ✅ Rapport sauvegardé: storage/logs/health_report.json\n";

echo "\n🎉 Nettoyage complet terminé!\n";
echo "\n📋 Recommandations:\n";
echo "1. Surveiller les nouveaux logs pour détecter les erreurs récurrentes\n";
echo "2. Exécuter ce script régulièrement (hebdomadaire)\n";
echo "3. Vérifier les performances après nettoyage\n";
echo "4. Configurer une rotation automatique des logs en production\n\n";
