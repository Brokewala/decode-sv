<?php

echo "=== Création d'un Administrateur - Decode SV ===\n\n";

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

// Lister les utilisateurs existants
echo "\n📋 Utilisateurs existants :\n";
$stmt = $pdo->query("SELECT id, name, email, is_admin, points FROM users ORDER BY id");
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (empty($users)) {
    echo "   ⚠️  Aucun utilisateur trouvé\n";
    echo "   💡 Créez d'abord un compte via l'interface web\n";
    exit(1);
}

foreach ($users as $user) {
    $adminStatus = $user['is_admin'] ? '👑 ADMIN' : '👤 USER';
    echo "   {$user['id']}. {$user['name']} ({$user['email']}) - {$adminStatus} - {$user['points']} points\n";
}

// Demander quel utilisateur promouvoir
echo "\n🔧 Quel utilisateur promouvoir en administrateur ?\n";
echo "Entrez l'ID de l'utilisateur (ou 'all' pour voir les détails) : ";

$handle = fopen("php://stdin", "r");
$input = trim(fgets($handle));
fclose($handle);

if ($input === 'all') {
    echo "\n📊 Détails des utilisateurs :\n";
    foreach ($users as $user) {
        echo "   ID: {$user['id']}\n";
        echo "   Nom: {$user['name']}\n";
        echo "   Email: {$user['email']}\n";
        echo "   Admin: " . ($user['is_admin'] ? 'Oui' : 'Non') . "\n";
        echo "   Points: {$user['points']}\n";
        echo "   " . str_repeat("-", 30) . "\n";
    }
    exit(0);
}

// Valider l'ID
$userId = (int)$input;
$selectedUser = null;

foreach ($users as $user) {
    if ($user['id'] == $userId) {
        $selectedUser = $user;
        break;
    }
}

if (!$selectedUser) {
    echo "❌ Utilisateur avec l'ID $userId non trouvé\n";
    exit(1);
}

// Vérifier si déjà admin
if ($selectedUser['is_admin']) {
    echo "ℹ️  {$selectedUser['name']} est déjà administrateur\n";
    
    echo "Voulez-vous retirer les droits d'admin ? (y/N) : ";
    $handle = fopen("php://stdin", "r");
    $confirm = trim(fgets($handle));
    fclose($handle);
    
    if (strtolower($confirm) === 'y') {
        // Retirer les droits admin
        $stmt = $pdo->prepare("UPDATE users SET is_admin = 0 WHERE id = ?");
        $stmt->execute([$userId]);
        echo "✅ Droits d'administrateur retirés pour {$selectedUser['name']}\n";
    } else {
        echo "❌ Opération annulée\n";
    }
    exit(0);
}

// Confirmer la promotion
echo "\n🔐 Promouvoir {$selectedUser['name']} ({$selectedUser['email']}) en administrateur ?\n";
echo "Cette action donnera tous les droits d'administration. (y/N) : ";

$handle = fopen("php://stdin", "r");
$confirm = trim(fgets($handle));
fclose($handle);

if (strtolower($confirm) !== 'y') {
    echo "❌ Opération annulée\n";
    exit(0);
}

// Promouvoir l'utilisateur
try {
    $stmt = $pdo->prepare("UPDATE users SET is_admin = 1 WHERE id = ?");
    $stmt->execute([$userId]);
    
    echo "✅ {$selectedUser['name']} a été promu administrateur avec succès !\n";
    
    // Vérifier la promotion
    $stmt = $pdo->prepare("SELECT is_admin FROM users WHERE id = ?");
    $stmt->execute([$userId]);
    $isAdmin = $stmt->fetch(PDO::FETCH_COLUMN);
    
    if ($isAdmin) {
        echo "✅ Vérification : Statut admin confirmé\n";
    } else {
        echo "❌ Erreur : Statut admin non confirmé\n";
    }
    
} catch (PDOException $e) {
    echo "❌ Erreur lors de la promotion : " . $e->getMessage() . "\n";
    exit(1);
}

// Afficher les statistiques finales
echo "\n📊 Statistiques finales :\n";
$stmt = $pdo->query("SELECT COUNT(*) FROM users WHERE is_admin = 1");
$adminCount = $stmt->fetch(PDO::FETCH_COLUMN);
echo "   👑 Administrateurs : $adminCount\n";

$stmt = $pdo->query("SELECT COUNT(*) FROM users WHERE is_admin = 0");
$userCount = $stmt->fetch(PDO::FETCH_COLUMN);
echo "   👤 Utilisateurs : $userCount\n";

echo "\n🌐 L'administrateur peut maintenant accéder à :\n";
echo "   - http://localhost:8002/admin/dashboard\n";
echo "   - http://localhost:8002/admin/pending\n";
echo "   - http://localhost:8002/admin/users\n";

echo "\n🔧 Actions disponibles pour l'admin :\n";
echo "   ✅ Valider les documents en attente\n";
echo "   ❌ Rejeter les documents inappropriés\n";
echo "   👥 Gérer les utilisateurs\n";
echo "   👑 Promouvoir d'autres administrateurs\n";
echo "   📊 Voir les statistiques de la plateforme\n";

echo "\n🎉 Configuration de l'administration terminée !\n";
