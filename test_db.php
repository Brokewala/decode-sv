<?php

// Test de connexion à la base de données SQLite
$dbPath = '/home/acer/Bureau/work/project_IA/decode_sv/database/database.sqlite';

echo "Test de connexion à la base de données SQLite\n";
echo "Chemin de la base de données : $dbPath\n";

// Vérifier si le fichier existe
if (!file_exists($dbPath)) {
    echo "ERREUR : Le fichier de base de données n'existe pas.\n";
    exit(1);
}

// Vérifier les permissions
if (!is_readable($dbPath)) {
    echo "ERREUR : Le fichier de base de données n'est pas lisible.\n";
    exit(1);
}

if (!is_writable($dbPath)) {
    echo "ERREUR : Le fichier de base de données n'est pas accessible en écriture.\n";
    exit(1);
}

// Tester la connexion PDO
try {
    $pdo = new PDO("sqlite:$dbPath");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "SUCCESS : Connexion PDO réussie.\n";
    
    // Tester une requête simple
    $stmt = $pdo->query("SELECT name FROM sqlite_master WHERE type='table'");
    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
    echo "Tables trouvées : " . implode(', ', $tables) . "\n";
    
} catch (PDOException $e) {
    echo "ERREUR PDO : " . $e->getMessage() . "\n";
    exit(1);
}

// Tester la connexion SQLite3
try {
    $sqlite = new SQLite3($dbPath);
    echo "SUCCESS : Connexion SQLite3 réussie.\n";
    $sqlite->close();
} catch (Exception $e) {
    echo "ERREUR SQLite3 : " . $e->getMessage() . "\n";
}

echo "Test terminé avec succès.\n";
