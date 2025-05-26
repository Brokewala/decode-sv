# Guide d'installation et de résolution des problèmes - Decode SV

## Problèmes résolus ✅

### 1. Erreur SQLite "could not find driver"

**Problème :** `Illuminate\Database\QueryException: could not find driver (Connection: sqlite)`

**Solution appliquée :**
- ✅ Extensions SQLite vérifiées et fonctionnelles
- ✅ Configuration de la base de données corrigée dans `.env`
- ✅ Sessions et cache configurés pour utiliser des fichiers au lieu de la base de données
- ✅ Chemin absolu de la base de données SQLite configuré

**Changements effectués :**
```env
# Dans .env
SESSION_DRIVER=file          # au lieu de database
CACHE_STORE=file            # au lieu de database  
QUEUE_CONNECTION=sync       # au lieu de database
DB_DATABASE=/home/acer/Bureau/work/project_IA/decode_sv/database/database.sqlite
```

### 2. Correction du bouton "Soumettre un document"

**Problèmes résolus :**
- ✅ Erreur Intervention Image corrigée
- ✅ Validation des fichiers améliorée
- ✅ Gestion d'erreurs robuste avec transactions DB
- ✅ Sécurité des uploads renforcée

**Améliorations apportées :**
- Validation MIME type des fichiers
- Noms de fichiers sécurisés avec uniqid()
- Transactions de base de données pour la cohérence
- Gestion d'erreurs complète avec rollback
- Prévisualisation avec fallback sur images génériques

### 3. Système de traduction implémenté

**Fonctionnalités ajoutées :**
- ✅ Configuration multilinguisme (FR/EN)
- ✅ Fichiers de traduction créés
- ✅ Locale par défaut configurée en français
- ✅ Structure prête pour le sélecteur de langue

## Extensions PHP requises

### Extensions installées ✅
- sqlite3
- pdo_sqlite
- openssl
- json
- tokenizer
- xml
- ctype
- fileinfo

### Extensions manquantes (optionnelles)
- mbstring (pour Artisan/Termwind)
- gd (pour traitement d'images avancé)

## Installation des extensions manquantes

### Ubuntu/Debian
```bash
sudo apt update
sudo apt install php8.4-mbstring php8.4-gd php8.4-curl php8.4-xml
```

### Alternative sans sudo
L'application fonctionne sans ces extensions, mais certaines fonctionnalités Artisan peuvent être limitées.

## Démarrage de l'application

### Serveur de développement
```bash
# Port 8001 (8000 déjà utilisé)
php -S localhost:8001 -t public
```

### Accès
- URL : http://localhost:8001
- Status : ✅ Fonctionnel

## Tests de fonctionnement

### Test de base de données
```bash
php test_db.php
```

### Test de l'application
```bash
php test_app.php
```

## Prochaines étapes

### 1. Finaliser le système de traduction
- [ ] Créer le sélecteur de langue (Alpine.js)
- [ ] Traduire toutes les vues
- [ ] Implémenter la persistance de langue

### 2. Corriger les filtres du catalogue
- [ ] Tester les filtres Livewire
- [ ] Optimiser les requêtes

### 3. Fonctionnalités avancées
- [ ] Système de points avec observers
- [ ] Prévisualisation des documents
- [ ] Tests PHPUnit

## Commandes utiles

### Vérifier les extensions PHP
```bash
php -m | sort
```

### Tester la connexion SQLite
```bash
sqlite3 database/database.sqlite ".tables"
```

### Vérifier les logs Laravel
```bash
tail -f storage/logs/laravel.log
```

## Résolution de problèmes

### Si le serveur ne démarre pas
1. Vérifier que le port n'est pas utilisé : `netstat -tlnp | grep :8001`
2. Essayer un autre port : `php -S localhost:8002 -t public`

### Si les sessions ne fonctionnent pas
1. Vérifier les permissions : `chmod -R 755 storage/`
2. Nettoyer le cache : `rm -rf storage/framework/sessions/*`

### Si la base de données ne fonctionne pas
1. Vérifier les permissions : `chmod 664 database/database.sqlite`
2. Vérifier le chemin dans `.env`

## Status actuel

✅ **Application fonctionnelle**
✅ **Base de données opérationnelle** 
✅ **Upload de documents corrigé**
✅ **Système de traduction configuré**
🔄 **En cours : Finalisation des fonctionnalités**
