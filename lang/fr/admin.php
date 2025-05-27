<?php

return [
    // Dashboard
    'dashboard' => [
        'title' => 'Centre d\'Administration',
        'subtitle' => 'Tableau de bord exécutif - :date',
        'system_status' => 'Système Opérationnel',
        'principal_admin' => 'Administrateur Principal',
    ],

    // Metrics
    'metrics' => [
        'community' => 'Communauté',
        'active_users' => 'Utilisateurs actifs',
        'library' => 'Bibliothèque',
        'total_documents' => 'Documents totaux',
        'moderation' => 'Modération',
        'pending' => 'En attente',
        'engagement' => 'Engagement',
        'downloads' => 'Téléchargements',
        'this_month' => 'ce mois',
        'pending_docs' => 'en attente',
        'this_week' => 'cette semaine',
        'action_required' => 'Action requise',
        'up_to_date' => 'À jour',
    ],

    // Performance Analysis
    'performance' => [
        'title' => 'Analyse de Performance',
        'subtitle' => 'Métriques clés des 30 derniers jours',
        'real_time' => 'Temps réel',
        'validation_rate' => 'Taux validation',
        'dl_per_doc' => 'DL/Document',
        'dl_per_user' => 'DL/Utilisateur',
        'pending_rate' => 'En attente',
        'activity_chart' => 'Graphique d\'activité',
        'chartjs_available' => 'Intégration Chart.js disponible',
    ],

    // Control Center
    'control_center' => [
        'moderation_title' => 'Modération',
        'moderation_subtitle' => 'Action requise',
        'pending_documents' => 'Documents en attente',
        'moderate_now' => 'Modérer Maintenant',
        'community_title' => 'Communauté',
        'members' => ':count membres',
        'active_users' => 'Utilisateurs actifs',
        'average_engagement' => 'Engagement moyen',
        'manage_users' => 'Gérer Utilisateurs',
        'system_title' => 'Système',
        'everything_working' => 'Tout fonctionne',
        'database_operational' => 'Base de données opérationnelle',
        'uploads_functional' => 'Uploads fonctionnels',
        'security_active' => 'Sécurité active',
    ],

    // Navigation
    'navigation' => [
        'pending_documents' => 'Documents en attente',
        'moderate_submissions' => 'Modérer les soumissions',
        'user_management' => 'Gestion des utilisateurs',
        'promote_admins' => 'Promouvoir des admins',
        'view_documents' => 'Voir les documents',
        'public_interface' => 'Interface publique',
        'back_to_dashboard' => 'Retour au dashboard',
    ],

    // Pending Documents
    'pending' => [
        'title' => 'Documents en Attente de Validation',
        'filters' => [
            'search' => 'Recherche',
            'search_placeholder' => 'Titre, pays, description...',
            'country' => 'Pays',
            'all_countries' => 'Tous les pays',
            'format' => 'Format',
            'all_formats' => 'Tous les formats',
            'filter' => 'Filtrer',
        ],
        'document_info' => [
            'author' => 'Auteur',
            'email' => 'Email',
            'country' => 'Pays',
            'format' => 'Format',
            'price' => 'Prix',
            'points' => 'point(s)',
            'submitted_on' => 'Soumis le',
            'description' => 'Description',
        ],
        'actions' => [
            'validate' => 'Valider',
            'reject' => 'Rejeter',
            'validate_confirm' => 'Êtes-vous sûr de vouloir valider ce document ? :points point(s) seront attribués à :user.',
            'reject_confirm' => 'Êtes-vous sûr de vouloir rejeter et supprimer ce document ? Cette action est irréversible.',
        ],
        'no_documents' => [
            'title' => 'Aucun document en attente',
            'subtitle' => 'Tous les documents ont été traités ou aucun document n\'a été soumis.',
        ],
    ],

    // User Management
    'users' => [
        'title' => 'Gestion des Utilisateurs',
        'filters' => [
            'search' => 'Recherche',
            'search_placeholder' => 'Nom ou email...',
            'sort' => 'Tri',
            'newest' => 'Plus récents',
            'oldest' => 'Plus anciens',
            'name' => 'Nom A-Z',
            'points_desc' => 'Plus de points',
            'points_asc' => 'Moins de points',
            'filter' => 'Filtrer',
        ],
        'table' => [
            'user' => 'Utilisateur',
            'status' => 'Statut',
            'points' => 'Points',
            'registration' => 'Inscription',
            'actions' => 'Actions',
            'administrator' => 'Administrateur',
            'user_role' => 'Utilisateur',
            'yourself' => 'Vous-même',
            'remove_admin' => 'Retirer admin',
            'promote_admin' => 'Promouvoir admin',
            'remove_confirm' => 'Êtes-vous sûr de vouloir retirer les droits d\'administrateur à :user ?',
            'promote_confirm' => 'Êtes-vous sûr de vouloir promouvoir :user en administrateur ?',
        ],
        'stats' => [
            'administrators' => 'Administrateurs',
            'users' => 'Utilisateurs',
            'total_points' => 'Points totaux',
        ],
        'no_users' => [
            'title' => 'Aucun utilisateur trouvé',
            'subtitle' => 'Aucun utilisateur ne correspond aux critères de recherche.',
        ],
    ],

    // Messages
    'messages' => [
        'document_validated' => 'Le document a été validé avec succès et :points points ont été attribués à :user.',
        'document_rejected' => 'Le document \':title\' de :user a été rejeté et supprimé.',
        'already_validated' => 'Ce document a déjà été validé.',
        'cannot_reject_validated' => 'Impossible de rejeter un document déjà validé.',
        'admin_promoted' => ':user a été promu administrateur.',
        'admin_removed' => 'Les droits d\'administrateur ont été retirés à :user.',
        'cannot_modify_yourself' => 'Vous ne pouvez pas modifier votre propre statut d\'administrateur.',
    ],

    // Common
    'common' => [
        'loading' => 'Chargement...',
        'save' => 'Enregistrer',
        'cancel' => 'Annuler',
        'delete' => 'Supprimer',
        'edit' => 'Modifier',
        'view' => 'Voir',
        'search' => 'Rechercher',
        'filter' => 'Filtrer',
        'reset' => 'Réinitialiser',
        'export' => 'Exporter',
        'import' => 'Importer',
        'yes' => 'Oui',
        'no' => 'Non',
        'confirm' => 'Confirmer',
        'success' => 'Succès',
        'error' => 'Erreur',
        'warning' => 'Attention',
        'info' => 'Information',
    ],
];
