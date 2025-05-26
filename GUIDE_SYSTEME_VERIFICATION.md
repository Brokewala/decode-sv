# Guide du Système de Vérification - Decode SV

## 📋 Comment Fonctionne le Système de Vérification

### 🔄 **Workflow Complet de Validation**

```
1. UPLOAD → 2. EN ATTENTE → 3. MODÉRATION → 4. VALIDATION → 5. PUBLICATION
```

## 1. **Phase d'Upload (is_verified = false)**

### Quand un utilisateur soumet un document :

**Fichiers impliqués :**
- `app/Livewire/DocumentUpload.php` (ligne 100)
- `app/Http/Controllers/DocumentController.php` (ligne 132)

**Code de création :**
```php
Document::create([
    'user_id' => Auth::id(),
    'title' => $this->title,
    'country' => $this->country,
    'format' => $format,
    'description' => $this->description,
    'price' => $price,
    'file_path' => $filePath,
    'preview_path' => $previewPath,
    'is_verified' => false, // ← STATUT INITIAL
    'downloads' => 0,
]);
```

**Résultat :** Le document est créé avec `is_verified = false`

## 2. **Phase de Modération (Documents en Attente)**

### Qui peut voir les documents en attente :
- **Administrateurs uniquement** (middleware `admin`)
- Accès via `AdminController::pendingDocuments()`

### Où sont listés les documents en attente :
- **Contrôleur :** `app/Http/Controllers/AdminController.php` (ligne 37)
- **Vue :** `resources/views/admin/pending.blade.php`
- **Route :** `/admin/pending` (à ajouter)

**Code de récupération :**
```php
public function pendingDocuments(Request $request)
{
    $query = Document::where('is_verified', false) // ← DOCUMENTS EN ATTENTE
                    ->with('user');
    
    $documents = $query->paginate(10);
    return view('admin.pending', compact('documents'));
}
```

## 3. **Phase de Validation (Changement de Statut)**

### Qui peut valider :
- **Administrateurs uniquement** (middleware `admin`)
- Via la méthode `AdminController::verifyDocument()`

### Comment le statut change :
**Fichier :** `app/Http/Controllers/AdminController.php` (ligne 85)

```php
public function verifyDocument(Document $document)
{
    // Vérifier si déjà validé
    if ($document->is_verified) {
        return back()->with('info', 'Ce document a déjà été validé.');
    }

    // CHANGEMENT DE STATUT ICI ↓
    $document->is_verified = true; // ← VALIDATION
    $document->save();

    // Attribution des points à l'auteur
    $user = $document->user;
    $pointsToAdd = $document->price;
    $user->points += $pointsToAdd;
    $user->save();

    return back()->with('success', "Document validé et {$pointsToAdd} points attribués.");
}
```

## 4. **Phase de Publication (is_verified = true)**

### Où apparaissent les documents validés :
- **Page publique :** `/documents` (tous les utilisateurs)
- **Filtres :** Seuls les documents avec `is_verified = true` sont affichés

**Code de filtrage :**
```php
// Dans DocumentsList.php et DocumentController.php
Document::where('is_verified', true) // ← SEULS LES VALIDÉS
```

## 🔐 **Système d'Administration**

### Middleware de Protection
**Fichier :** `app/Http/Middleware/IsAdmin.php`

```php
public function handle(Request $request, Closure $next): Response
{
    if (Auth::check() && Auth::user()->isAdmin()) {
        return $next($request); // ← ACCÈS AUTORISÉ
    }
    
    abort(403, 'Accès non autorisé'); // ← ACCÈS REFUSÉ
}
```

### Comment devenir Administrateur
**Méthode 1 :** Via un autre admin
```php
// AdminController::toggleAdmin()
$user->is_admin = !$user->is_admin;
$user->save();
```

**Méthode 2 :** Directement en base de données
```sql
UPDATE users SET is_admin = 1 WHERE email = 'admin@example.com';
```

## 📊 **États des Documents**

### Statuts Possibles
| Statut | is_verified | Visible Public | Téléchargeable | Points Attribués |
|--------|-------------|----------------|----------------|------------------|
| **En attente** | `false` | ❌ Non | ❌ Non | ❌ Non |
| **Validé** | `true` | ✅ Oui | ✅ Oui | ✅ Oui |
| **Rejeté** | `false` + supprimé | ❌ Non | ❌ Non | ❌ Non |

### Requêtes de Vérification
```php
// Documents en attente
Document::where('is_verified', false)->get();

// Documents validés
Document::where('is_verified', true)->get();

// Compter les documents en attente
Document::where('is_verified', false)->count();
```

## 🛠️ **Interface d'Administration**

### Dashboard Admin
**Route :** `/admin/dashboard`
**Contrôleur :** `AdminController::dashboard()`
**Statistiques affichées :**
- Total utilisateurs
- Total documents
- Documents en attente
- Total téléchargements

### Gestion des Documents en Attente
**Route :** `/admin/pending`
**Contrôleur :** `AdminController::pendingDocuments()`
**Fonctionnalités :**
- Liste des documents non validés
- Filtres (recherche, pays, format)
- Tri par date
- Actions : Valider/Rejeter

### Actions Disponibles
1. **Valider :** `POST /admin/documents/{id}/verify`
2. **Rejeter :** `DELETE /admin/documents/{id}/reject`
3. **Voir détails :** `GET /admin/documents/{id}`

## 🔄 **Processus de Validation Détaillé**

### 1. Utilisateur Upload Document
```
User → DocumentUpload.php → Document créé (is_verified = false)
```

### 2. Admin Voit Document en Attente
```
Admin → /admin/pending → Liste des documents non validés
```

### 3. Admin Valide Document
```
Admin → Clic "Valider" → verifyDocument() → is_verified = true + Points attribués
```

### 4. Document Devient Public
```
Document validé → Apparaît dans /documents → Téléchargeable par tous
```

## ⚠️ **Points Importants**

### Sécurité
- ✅ Seuls les admins peuvent valider
- ✅ Middleware `admin` protège toutes les routes admin
- ✅ Vérification du statut avant validation

### Attribution des Points
- ✅ Points attribués SEULEMENT à la validation
- ✅ Montant = `document.price`
- ✅ Ajoutés au solde de l'auteur

### Visibilité
- ✅ Documents non validés = INVISIBLES au public
- ✅ Seuls les documents `is_verified = true` sont publics
- ✅ Filtres automatiques dans toutes les vues publiques

## 🚀 **Routes d'Administration Manquantes**

**À ajouter dans `routes/web.php` :**
```php
// Routes d'administration
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/pending', [AdminController::class, 'pendingDocuments'])->name('admin.pending');
    Route::post('/documents/{document}/verify', [AdminController::class, 'verifyDocument'])->name('admin.verify');
    Route::delete('/documents/{document}/reject', [AdminController::class, 'rejectDocument'])->name('admin.reject');
    Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
    Route::post('/users/{user}/toggle-admin', [AdminController::class, 'toggleAdmin'])->name('admin.toggle-admin');
});
```

---

## 📝 **Résumé du Fonctionnement**

1. **Upload** : `is_verified = false` (document invisible)
2. **Modération** : Admin voit dans `/admin/pending`
3. **Validation** : Admin clique "Valider" → `is_verified = true`
4. **Publication** : Document devient visible et téléchargeable
5. **Points** : Auteur reçoit les points à la validation

**Le changement de statut se fait UNIQUEMENT par un administrateur via l'interface d'administration !**
