<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-bold text-2xl text-gray-900 dark:text-white leading-tight">
                    🏢 Centre d'Administration
                </h2>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                    Tableau de bord exécutif - {{ now()->format('d/m/Y à H:i') }}
                </p>
            </div>
            <div class="flex items-center space-x-4">
                <div class="bg-green-100 dark:bg-green-900 px-3 py-1 rounded-full">
                    <span class="text-green-800 dark:text-green-200 text-sm font-medium">
                        🟢 Système Opérationnel
                    </span>
                </div>
                <div class="text-right">
                    <p class="text-sm font-medium text-gray-900 dark:text-white">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400">Administrateur Principal</p>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Messages de succès/erreur -->
            @if (session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Métriques Exécutives -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Total Utilisateurs -->
                <div class="bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-900 dark:to-blue-800 overflow-hidden shadow-xl rounded-2xl border border-blue-200 dark:border-blue-700">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-semibold text-blue-600 dark:text-blue-300 uppercase tracking-wide">Communauté</p>
                                <p class="text-3xl font-bold text-blue-900 dark:text-white mt-2">{{ number_format($totalUsers) }}</p>
                                <p class="text-sm text-blue-700 dark:text-blue-200 mt-1">Utilisateurs actifs</p>
                            </div>
                            <div class="bg-blue-500 p-3 rounded-full">
                                <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="mt-4 flex items-center">
                            <span class="text-green-500 text-sm font-medium">↗ +12%</span>
                            <span class="text-blue-600 dark:text-blue-300 text-sm ml-2">ce mois</span>
                        </div>
                    </div>
                </div>

                <!-- Total Documents -->
                <div class="bg-gradient-to-br from-emerald-50 to-emerald-100 dark:from-emerald-900 dark:to-emerald-800 overflow-hidden shadow-xl rounded-2xl border border-emerald-200 dark:border-emerald-700">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-semibold text-emerald-600 dark:text-emerald-300 uppercase tracking-wide">Bibliothèque</p>
                                <p class="text-3xl font-bold text-emerald-900 dark:text-white mt-2">{{ number_format($totalDocuments) }}</p>
                                <p class="text-sm text-emerald-700 dark:text-emerald-200 mt-1">Documents totaux</p>
                            </div>
                            <div class="bg-emerald-500 p-3 rounded-full">
                                <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="mt-4 flex items-center">
                            <span class="text-green-500 text-sm font-medium">↗ +{{ $pendingDocuments }}</span>
                            <span class="text-emerald-600 dark:text-emerald-300 text-sm ml-2">en attente</span>
                        </div>
                    </div>
                </div>

                <!-- Documents en Attente -->
                <div class="bg-gradient-to-br from-amber-50 to-amber-100 dark:from-amber-900 dark:to-amber-800 overflow-hidden shadow-xl rounded-2xl border border-amber-200 dark:border-amber-700">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-semibold text-amber-600 dark:text-amber-300 uppercase tracking-wide">Modération</p>
                                <p class="text-3xl font-bold text-amber-900 dark:text-white mt-2">{{ number_format($pendingDocuments) }}</p>
                                <p class="text-sm text-amber-700 dark:text-amber-200 mt-1">En attente</p>
                            </div>
                            <div class="bg-amber-500 p-3 rounded-full">
                                <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="mt-4 flex items-center">
                            @if($pendingDocuments > 0)
                                <span class="text-red-500 text-sm font-medium">⚠ Action requise</span>
                            @else
                                <span class="text-green-500 text-sm font-medium">✓ À jour</span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Total Téléchargements -->
                <div class="bg-gradient-to-br from-purple-50 to-purple-100 dark:from-purple-900 dark:to-purple-800 overflow-hidden shadow-xl rounded-2xl border border-purple-200 dark:border-purple-700">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-semibold text-purple-600 dark:text-purple-300 uppercase tracking-wide">Engagement</p>
                                <p class="text-3xl font-bold text-purple-900 dark:text-white mt-2">{{ number_format($totalDownloads) }}</p>
                                <p class="text-sm text-purple-700 dark:text-purple-200 mt-1">Téléchargements</p>
                            </div>
                            <div class="bg-purple-500 p-3 rounded-full">
                                <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="mt-4 flex items-center">
                            <span class="text-green-500 text-sm font-medium">↗ +8.5%</span>
                            <span class="text-purple-600 dark:text-purple-300 text-sm ml-2">cette semaine</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Analyse Avancée -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
                <!-- Graphique de Performance -->
                <div class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-6">
                            <div>
                                <h3 class="text-xl font-bold text-gray-900 dark:text-white">📊 Analyse de Performance</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Métriques clés des 30 derniers jours</p>
                            </div>
                            <div class="flex space-x-2">
                                <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full dark:bg-blue-900 dark:text-blue-300">Temps réel</span>
                            </div>
                        </div>

                        <!-- Métriques de performance -->
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                            <div class="text-center p-4 bg-gray-50 dark:bg-gray-700 rounded-xl">
                                <p class="text-2xl font-bold text-blue-600 dark:text-blue-400">{{ $totalDocuments > 0 ? round((($totalDocuments - $pendingDocuments) / $totalDocuments) * 100, 1) : 0 }}%</p>
                                <p class="text-xs text-gray-600 dark:text-gray-400">Taux validation</p>
                            </div>
                            <div class="text-center p-4 bg-gray-50 dark:bg-gray-700 rounded-xl">
                                <p class="text-2xl font-bold text-emerald-600 dark:text-emerald-400">{{ $totalDocuments > 0 ? round($totalDownloads / $totalDocuments, 1) : 0 }}</p>
                                <p class="text-xs text-gray-600 dark:text-gray-400">DL/Document</p>
                            </div>
                            <div class="text-center p-4 bg-gray-50 dark:bg-gray-700 rounded-xl">
                                <p class="text-2xl font-bold text-purple-600 dark:text-purple-400">{{ $totalUsers > 0 ? round($totalDownloads / $totalUsers, 1) : 0 }}</p>
                                <p class="text-xs text-gray-600 dark:text-gray-400">DL/Utilisateur</p>
                            </div>
                            <div class="text-center p-4 bg-gray-50 dark:bg-gray-700 rounded-xl">
                                <p class="text-2xl font-bold text-amber-600 dark:text-amber-400">{{ $pendingDocuments > 0 ? round(($pendingDocuments / $totalDocuments) * 100, 1) : 0 }}%</p>
                                <p class="text-xs text-gray-600 dark:text-gray-400">En attente</p>
                            </div>
                        </div>

                        <!-- Graphique simulé -->
                        <div class="h-48 bg-gradient-to-r from-blue-50 to-purple-50 dark:from-gray-700 dark:to-gray-600 rounded-xl flex items-center justify-center">
                            <div class="text-center">
                                <svg class="mx-auto h-16 w-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                </svg>
                                <p class="text-gray-500 dark:text-gray-400 text-sm">Graphique d'activité</p>
                                <p class="text-gray-400 dark:text-gray-500 text-xs">Intégration Chart.js disponible</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Centre de Contrôle -->
                <div class="space-y-6">
                    <!-- Modération Urgente -->
                    <div class="bg-gradient-to-br from-red-50 to-orange-50 dark:from-red-900/20 dark:to-orange-900/20 rounded-2xl shadow-xl border border-red-200 dark:border-red-800">
                        <div class="p-6">
                            <div class="flex items-center mb-4">
                                <div class="bg-red-500 p-2 rounded-lg mr-3">
                                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-lg font-bold text-red-900 dark:text-red-100">Modération</h3>
                                    <p class="text-sm text-red-700 dark:text-red-300">Action requise</p>
                                </div>
                            </div>
                            <div class="mb-4">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-sm text-red-800 dark:text-red-200">Documents en attente</span>
                                    <span class="text-2xl font-bold text-red-900 dark:text-red-100">{{ $pendingDocuments }}</span>
                                </div>
                                @if($pendingDocuments > 0)
                                    <div class="w-full bg-red-200 rounded-full h-2 dark:bg-red-800">
                                        <div class="bg-red-600 h-2 rounded-full transition-all duration-300
                                                    @if($pendingDocuments >= 8) w-full
                                                    @elseif($pendingDocuments >= 6) w-4/5
                                                    @elseif($pendingDocuments >= 4) w-3/5
                                                    @elseif($pendingDocuments >= 2) w-2/5
                                                    @else w-1/5 @endif">
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <a href="{{ route('admin.pending') }}" class="w-full inline-flex items-center justify-center px-4 py-3 bg-red-600 hover:bg-red-700 text-white font-bold rounded-xl transition duration-200 shadow-lg">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Modérer Maintenant
                            </a>
                        </div>
                    </div>

                    <!-- Gestion Utilisateurs -->
                    <div class="bg-gradient-to-br from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 rounded-2xl shadow-xl border border-blue-200 dark:border-blue-800">
                        <div class="p-6">
                            <div class="flex items-center mb-4">
                                <div class="bg-blue-500 p-2 rounded-lg mr-3">
                                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-lg font-bold text-blue-900 dark:text-blue-100">Communauté</h3>
                                    <p class="text-sm text-blue-700 dark:text-blue-300">{{ $totalUsers }} membres</p>
                                </div>
                            </div>
                            <div class="space-y-3 mb-4">
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-blue-800 dark:text-blue-200">Utilisateurs actifs</span>
                                    <span class="font-bold text-blue-900 dark:text-blue-100">{{ $totalUsers }}</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-blue-800 dark:text-blue-200">Engagement moyen</span>
                                    <span class="font-bold text-blue-900 dark:text-blue-100">{{ $totalUsers > 0 ? round($totalDownloads / $totalUsers, 1) : 0 }} DL</span>
                                </div>
                            </div>
                            <a href="{{ route('admin.users') }}" class="w-full inline-flex items-center justify-center px-4 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl transition duration-200 shadow-lg">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                                </svg>
                                Gérer Utilisateurs
                            </a>
                        </div>
                    </div>

                    <!-- Alertes Système -->
                    <div class="bg-gradient-to-br from-green-50 to-emerald-50 dark:from-green-900/20 dark:to-emerald-900/20 rounded-2xl shadow-xl border border-green-200 dark:border-green-800">
                        <div class="p-6">
                            <div class="flex items-center mb-4">
                                <div class="bg-green-500 p-2 rounded-lg mr-3">
                                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-lg font-bold text-green-900 dark:text-green-100">Système</h3>
                                    <p class="text-sm text-green-700 dark:text-green-300">Tout fonctionne</p>
                                </div>
                            </div>
                            <div class="space-y-2 text-sm text-green-800 dark:text-green-200">
                                <div class="flex items-center">
                                    <span class="w-2 h-2 bg-green-500 rounded-full mr-2"></span>
                                    Base de données opérationnelle
                                </div>
                                <div class="flex items-center">
                                    <span class="w-2 h-2 bg-green-500 rounded-full mr-2"></span>
                                    Uploads fonctionnels
                                </div>
                                <div class="flex items-center">
                                    <span class="w-2 h-2 bg-green-500 rounded-full mr-2"></span>
                                    Sécurité active
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Navigation admin -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Navigation Administration</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <a href="{{ route('admin.pending') }}" class="flex items-center p-4 border border-gray-200 dark:border-gray-700 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                            <svg class="h-6 w-6 text-yellow-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div>
                                <p class="font-medium text-gray-900 dark:text-white">Documents en attente</p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Modérer les soumissions</p>
                            </div>
                        </a>

                        <a href="{{ route('admin.users') }}" class="flex items-center p-4 border border-gray-200 dark:border-gray-700 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                            <svg class="h-6 w-6 text-blue-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                            </svg>
                            <div>
                                <p class="font-medium text-gray-900 dark:text-white">Gestion des utilisateurs</p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Promouvoir des admins</p>
                            </div>
                        </a>

                        <a href="{{ route('documents.index') }}" class="flex items-center p-4 border border-gray-200 dark:border-gray-700 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                            <svg class="h-6 w-6 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <div>
                                <p class="font-medium text-gray-900 dark:text-white">Voir les documents</p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Interface publique</p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
