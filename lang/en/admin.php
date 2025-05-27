<?php

return [
    // Dashboard
    'dashboard' => [
        'title' => 'Administration Center',
        'subtitle' => 'Executive Dashboard - :date',
        'system_status' => 'System Operational',
        'principal_admin' => 'Principal Administrator',
    ],

    // Metrics
    'metrics' => [
        'community' => 'Community',
        'active_users' => 'Active users',
        'library' => 'Library',
        'total_documents' => 'Total documents',
        'moderation' => 'Moderation',
        'pending' => 'Pending',
        'engagement' => 'Engagement',
        'downloads' => 'Downloads',
        'this_month' => 'this month',
        'pending_docs' => 'pending',
        'this_week' => 'this week',
        'action_required' => 'Action required',
        'up_to_date' => 'Up to date',
    ],

    // Performance Analysis
    'performance' => [
        'title' => 'Performance Analysis',
        'subtitle' => 'Key metrics for the last 30 days',
        'real_time' => 'Real time',
        'validation_rate' => 'Validation rate',
        'dl_per_doc' => 'DL/Document',
        'dl_per_user' => 'DL/User',
        'pending_rate' => 'Pending',
        'activity_chart' => 'Activity chart',
        'chartjs_available' => 'Chart.js integration available',
    ],

    // Control Center
    'control_center' => [
        'moderation_title' => 'Moderation',
        'moderation_subtitle' => 'Action required',
        'pending_documents' => 'Pending documents',
        'moderate_now' => 'Moderate Now',
        'community_title' => 'Community',
        'members' => ':count members',
        'active_users' => 'Active users',
        'average_engagement' => 'Average engagement',
        'manage_users' => 'Manage Users',
        'system_title' => 'System',
        'everything_working' => 'Everything working',
        'database_operational' => 'Database operational',
        'uploads_functional' => 'Uploads functional',
        'security_active' => 'Security active',
    ],

    // Navigation
    'navigation' => [
        'pending_documents' => 'Pending documents',
        'moderate_submissions' => 'Moderate submissions',
        'user_management' => 'User management',
        'promote_admins' => 'Promote admins',
        'view_documents' => 'View documents',
        'public_interface' => 'Public interface',
        'back_to_dashboard' => 'Back to dashboard',
    ],

    // Pending Documents
    'pending' => [
        'title' => 'Pending Validation Documents',
        'filters' => [
            'search' => 'Search',
            'search_placeholder' => 'Title, country, description...',
            'country' => 'Country',
            'all_countries' => 'All countries',
            'format' => 'Format',
            'all_formats' => 'All formats',
            'filter' => 'Filter',
        ],
        'document_info' => [
            'author' => 'Author',
            'email' => 'Email',
            'country' => 'Country',
            'format' => 'Format',
            'price' => 'Price',
            'points' => 'point(s)',
            'submitted_on' => 'Submitted on',
            'description' => 'Description',
        ],
        'actions' => [
            'validate' => 'Validate',
            'reject' => 'Reject',
            'validate_confirm' => 'Are you sure you want to validate this document? :points point(s) will be awarded to :user.',
            'reject_confirm' => 'Are you sure you want to reject and delete this document? This action is irreversible.',
        ],
        'no_documents' => [
            'title' => 'No pending documents',
            'subtitle' => 'All documents have been processed or no documents have been submitted.',
        ],
    ],

    // User Management
    'users' => [
        'title' => 'User Management',
        'filters' => [
            'search' => 'Search',
            'search_placeholder' => 'Name or email...',
            'sort' => 'Sort',
            'newest' => 'Newest',
            'oldest' => 'Oldest',
            'name' => 'Name A-Z',
            'points_desc' => 'Most points',
            'points_asc' => 'Least points',
            'filter' => 'Filter',
        ],
        'table' => [
            'user' => 'User',
            'status' => 'Status',
            'points' => 'Points',
            'registration' => 'Registration',
            'actions' => 'Actions',
            'administrator' => 'Administrator',
            'user_role' => 'User',
            'yourself' => 'Yourself',
            'remove_admin' => 'Remove admin',
            'promote_admin' => 'Promote admin',
            'remove_confirm' => 'Are you sure you want to remove administrator rights from :user?',
            'promote_confirm' => 'Are you sure you want to promote :user to administrator?',
        ],
        'stats' => [
            'administrators' => 'Administrators',
            'users' => 'Users',
            'total_points' => 'Total points',
        ],
        'no_users' => [
            'title' => 'No users found',
            'subtitle' => 'No users match the search criteria.',
        ],
    ],

    // Messages
    'messages' => [
        'document_validated' => 'The document has been successfully validated and :points points have been awarded to :user.',
        'document_rejected' => 'The document \':title\' by :user has been rejected and deleted.',
        'already_validated' => 'This document has already been validated.',
        'cannot_reject_validated' => 'Cannot reject an already validated document.',
        'admin_promoted' => ':user has been promoted to administrator.',
        'admin_removed' => 'Administrator rights have been removed from :user.',
        'cannot_modify_yourself' => 'You cannot modify your own administrator status.',
    ],

    // Common
    'common' => [
        'loading' => 'Loading...',
        'save' => 'Save',
        'cancel' => 'Cancel',
        'delete' => 'Delete',
        'edit' => 'Edit',
        'view' => 'View',
        'search' => 'Search',
        'filter' => 'Filter',
        'reset' => 'Reset',
        'export' => 'Export',
        'import' => 'Import',
        'yes' => 'Yes',
        'no' => 'No',
        'confirm' => 'Confirm',
        'success' => 'Success',
        'error' => 'Error',
        'warning' => 'Warning',
        'info' => 'Information',
    ],
];
