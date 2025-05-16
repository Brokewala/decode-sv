# CAHIER DES CHARGES - PLATEFORME DECODE SV

## INFORMATIONS GÉNÉRALES

**Nom du projet :** Decode SV  
**Date de création :** 15/05/2025  
**Version :** 1.0  
**Stack technique :** TALL Stack (Tailwind CSS, Alpine.js, Laravel, Livewire)

## 1. PRÉSENTATION DU PROJET

### 1.1 Contexte

Les traducteurs professionnels font face à un défi récurrent dans leur travail quotidien : le reformatage des documents à traduire. En effet, au-delà de la traduction elle-même, ils doivent souvent recréer entièrement le format du document original (mise en page, polices, bordures, signatures, etc.). Cette tâche représente une charge de travail considérable qui s'ajoute à leur mission principale de traduction.

### 1.2 Objectif du projet

Decode SV vise à créer une plateforme communautaire collaborative permettant aux traducteurs du monde entier de partager et d'échanger des formats de documents préétablis. L'objectif est de réduire significativement le temps consacré au reformatage des documents, permettant ainsi aux traducteurs de se concentrer sur leur cœur de métier : la traduction et la certification.

### 1.3 Public cible

- Traducteurs professionnels et assermentés
- Bureaux de traduction
- Entreprises de services linguistiques
- Freelances spécialisés dans la traduction

## 2. SPÉCIFICATIONS FONCTIONNELLES

### 2.1 Architecture générale

La plateforme sera construite selon une architecture MVC (Modèle-Vue-Contrôleur) en utilisant le framework Laravel et la stack TALL.

### 2.2 Fonctionnalités principales

#### 2.2.1 Système d'économie de points

- Attribution de points aux utilisateurs pour le partage de formats de documents
- Déduction de points lors du téléchargement de formats créés par d'autres utilisateurs
- Système de tarification basé sur le type de document :
  - Documents PDF : 1 point
  - Documents Word/Excel : 2 points

#### 2.2.2 Gestion des utilisateurs

- Inscription et authentification des utilisateurs
- Profil utilisateur avec suivi des points et des activités
- Historique des documents déposés et téléchargés

#### 2.2.3 Dépôt de documents

- Interface de téléversement de documents formatés
- Formulaire de soumission avec informations détaillées (titre, pays d'origine, description, etc.)
- Gestion des formats acceptés (PDF, Word, Excel)

#### 2.2.4 Modération des documents

- Interface d'administration pour la vérification des documents soumis
- Système de validation des formats avant publication
- Création de previews basse résolution pour consultation

#### 2.2.5 Catalogue de documents

- Listing des documents disponibles avec filtres et recherche
- Système de prévisualisation en basse résolution
- Mécanisme d'achat et de téléchargement via des points

#### 2.2.6 Évaluation des documents

- Système de notation des formats par les utilisateurs
- Commentaires et avis sur la qualité des documents

### 2.3 Parcours utilisateur

#### 2.3.1 Nouvel utilisateur

1. Inscription sur la plateforme (0 point initial)
2. Impossibilité de télécharger des documents sans points
3. Accompagnement pour déposer un premier format de document
4. Attente de validation par un modérateur
5. Attribution de points après validation
6. Possibilité d'utiliser ces points pour télécharger d'autres formats

#### 2.3.2 Utilisateur expérimenté

1. Consultation du catalogue de documents disponibles
2. Prévisualisation des formats proposés
3. Téléchargement contre des points
4. Possibilité de continuer à déposer de nouveaux formats pour gagner plus de points

## 3. SPÉCIFICATIONS TECHNIQUES

### 3.1 Stack technique

- **Frontend** :
  - Tailwind CSS pour le design et les composants UI
  - Alpine.js pour les interactions JavaScript côté client
  - Livewire pour les composants dynamiques sans écrire de JavaScript

- **Backend** :
  - Laravel comme framework PHP principal
  - Eloquent ORM pour la gestion de la base de données
  - Laravel Sanctum pour l'authentification API

### 3.2 Base de données

#### 3.2.1 Structure principale

- **users** : informations des utilisateurs, points accumulés
- **documents** : métadonnées des documents, status de vérification, prix en points
- **user_documents** : table pivot pour lier les utilisateurs aux documents qu'ils ont acquis
- **ratings** : système d'évaluation des documents par les utilisateurs

#### 3.2.2 Relations

- Un utilisateur peut soumettre plusieurs documents
- Un utilisateur peut télécharger plusieurs documents
- Un document peut être téléchargé par plusieurs utilisateurs
- Un utilisateur peut noter plusieurs documents

### 3.3 Sécurité

- Authentification sécurisée avec Laravel Fortify
- Protection contre les attaques CSRF
- Validation des données à l'entrée
- Protection des fichiers originaux contre le téléchargement non autorisé
- Génération de previews basse résolution pour consultation sans acquisition

## 4. INTERFACES UTILISATEUR

### 4.1 Page d'accueil / Catalogue

Interface principale listant les documents disponibles avec :
- Vignettes de prévisualisation basse résolution
- Filtres par pays, type de document, format
- Affichage des notations et prix en points
- Système de recherche

### 4.2 Page de dépôt de documents

Formulaire comprenant :
1. Champ pour le titre du document
2. Sélection du pays d'origine (liste déroulante de tous les pays + option "international")
3. Format (détecté automatiquement à l'import)
4. Champ de description (optionnel)
5. Prix en points (calculé automatiquement : 2 points pour Word/Excel, 1 point pour PDF)
6. Bouton de validation

### 4.3 Pop-up de téléchargement

- Prévisualisation agrandie du document
- Récapitulatif des informations (titre, pays, format)
- Affichage des évaluations
- Bouton "Télécharger (X points)"
- Confirmation du débit de points

### 4.4 Page "Mes documents"

Tableau récapitulatif des documents téléchargés et déposés par l'utilisateur avec colonnes :
- Titre du document
- Pays
- Format
- Note moyenne
- Bouton de téléchargement

### 4.5 Interface modérateur

- Liste des documents en attente de validation
- Filtres de recherche
- Bouton de validation
- Aperçu des documents soumis

## 5. CONTRAINTES ET EXIGENCES

### 5.1 Performances

- Temps de chargement optimisé pour les listes de documents
- Génération efficace des previews
- Optimisation du stockage des fichiers

### 5.2 Compatibilité

- Adaptation responsive pour les appareils mobiles et tablettes
- Compatibilité avec les navigateurs modernes (Chrome, Firefox, Safari, Edge)

### 5.3 Légalité

- Respect du RGPD pour les données utilisateurs
- Mise en place de CGU claires concernant les droits de partage des formats
- Non-responsabilité quant au contenu des documents partagés

## 6. PLAN DE DÉPLOIEMENT

### 6.1 Phases de développement

1. **Phase 1** : Mise en place de l'architecture TALL et du système d'authentification
2. **Phase 2** : Développement du système de dépôt et de modération
3. **Phase 3** : Implémentation du catalogue et du système de points
4. **Phase 4** : Création des interfaces utilisateur et des fonctionnalités de téléchargement
5. **Phase 5** : Tests et corrections de bugs
6. **Phase 6** : Déploiement en production

### 6.2 Maintenance et évolutions futures

- Support technique continu
- Mise à jour régulière des dépendances
- Améliorations basées sur les retours utilisateurs
- Possibilité d'extension vers d'autres types de documents
- Implémentation future d'un système de paiement réel en complément du système de points

## 7. LIVRABLES ATTENDUS

- Code source complet de l'application
- Documentation technique
- Manuel d'utilisation pour les administrateurs
- Guide de démarrage rapide pour les utilisateurs
- Document d'installation et de configuration

---

Document rédigé le 15/05/2025
Version 1.0