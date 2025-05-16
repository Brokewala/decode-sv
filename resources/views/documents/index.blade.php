<x-app-layout>
    <x-slot name="header">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Catalogue de documents</h1>
        <p class="mt-2 text-gray-600 dark:text-gray-400">
            Parcourez notre bibliothèque de formats classés par pays et type de document.
        </p>
    </x-slot>
    
    <div class="flex flex-col md:flex-row md:space-x-6">
        <!-- Filtres (Sidebar) -->
        <div class="w-full md:w-1/4 mb-6 md:mb-0">
            <div class="bg-white dark:bg-dark-surface rounded-lg shadow-md dark:shadow-lg border border-gray-200 dark:border-dark-border overflow-hidden">
                <div class="p-5 border-b border-gray-200 dark:border-dark-border">
                    <h2 class="font-semibold text-xl text-gray-800 dark:text-white leading-tight">Filtres</h2>
                </div>
                
                <div class="p-5">
                    <form action="{{ route('documents.index') }}" method="GET">
                        <!-- Recherche -->
                        <div class="mb-4">
                            <label for="search" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Recherche</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400 dark:text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <input type="text" id="search" name="search" value="{{ request('search') }}" 
                                       class="pl-10 w-full rounded-md border-gray-300 dark:border-dark-border shadow-sm focus:border-primary-500 dark:focus:border-dark-accent focus:ring-primary-500 dark:focus:ring-dark-accent dark:bg-dark-bg dark:text-white sm:text-sm"
                                       placeholder="Titre, pays...">
                            </div>
                        </div>
                        
                        <!-- Pays -->
                        <div class="mb-4">
                            <label for="country" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Pays</label>
                            <select id="country" name="country" 
                                    class="w-full rounded-md border-gray-300 dark:border-dark-border shadow-sm focus:border-primary-500 dark:focus:border-dark-accent focus:ring-primary-500 dark:focus:ring-dark-accent dark:bg-dark-bg dark:text-white sm:text-sm">
                                <option value="">Tous les pays</option>
                                <option value="international" {{ request('country') == 'international' ? 'selected' : '' }}>International</option>
                                <option value="france" {{ request('country') == 'france' ? 'selected' : '' }}>France</option>
                                <option value="allemagne" {{ request('country') == 'allemagne' ? 'selected' : '' }}>Allemagne</option>
                                <option value="belgique" {{ request('country') == 'belgique' ? 'selected' : '' }}>Belgique</option>
                                <option value="suisse" {{ request('country') == 'suisse' ? 'selected' : '' }}>Suisse</option>
                                <option value="italie" {{ request('country') == 'italie' ? 'selected' : '' }}>Italie</option>
                                <option value="espagne" {{ request('country') == 'espagne' ? 'selected' : '' }}>Espagne</option>
                                <option value="royaume-uni" {{ request('country') == 'royaume-uni' ? 'selected' : '' }}>Royaume-Uni</option>
                                <option value="canada" {{ request('country') == 'canada' ? 'selected' : '' }}>Canada</option>
                                <option value="etats-unis" {{ request('country') == 'etats-unis' ? 'selected' : '' }}>États-Unis</option>
                            </select>
                        </div>
                        
                        <!-- Format -->
                        <div class="mb-4">
                            <label for="format" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Format</label>
                            <select id="format" name="format" 
                                    class="w-full rounded-md border-gray-300 dark:border-dark-border shadow-sm focus:border-primary-500 dark:focus:border-dark-accent focus:ring-primary-500 dark:focus:ring-dark-accent dark:bg-dark-bg dark:text-white sm:text-sm">
                                <option value="">Tous les formats</option>
                                <option value="pdf" {{ request('format') == 'pdf' ? 'selected' : '' }}>PDF</option>
                                <option value="doc" {{ request('format') == 'doc' ? 'selected' : '' }}>Word (DOC/DOCX)</option>
                                <option value="xls" {{ request('format') == 'xls' ? 'selected' : '' }}>Excel (XLS/XLSX)</option>
                            </select>
                        </div>
                        
                        <!-- Tri -->
                        <div class="mb-6">
                            <label for="sort" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Trier par</label>
                            <select id="sort" name="sort" 
                                    class="w-full rounded-md border-gray-300 dark:border-dark-border shadow-sm focus:border-primary-500 dark:focus:border-dark-accent focus:ring-primary-500 dark:focus:ring-dark-accent dark:bg-dark-bg dark:text-white sm:text-sm">
                                <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Plus récents</option>
                                <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Plus anciens</option>
                                <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>Mieux notés</option>
                                <option value="downloads" {{ request('sort') == 'downloads' ? 'selected' : '' }}>Plus téléchargés</option>
                                <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Prix croissant</option>
                                <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Prix décroissant</option>
                            </select>
                        </div>
                        
                        <!-- Boutons -->
                        <div class="flex flex-col space-y-2">
                            <button type="submit" class="w-full flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-primary-600 dark:bg-dark-button hover:bg-primary-700 dark:hover:bg-dark-buttonHover focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 dark:focus:ring-dark-accent dark:focus:ring-offset-dark-bg">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z" clip-rule="evenodd" />
                                </svg>
                                Appliquer les filtres
                            </button>
                            <a href="{{ route('documents.index') }}" class="w-full flex justify-center items-center px-4 py-2 border border-gray-300 dark:border-dark-border text-sm font-medium rounded-md text-gray-700 dark:text-gray-300 bg-white dark:bg-dark-surface hover:bg-gray-50 dark:hover:bg-dark-surface focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 dark:focus:ring-dark-accent dark:focus:ring-offset-dark-bg">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z" clip-rule="evenodd" />
                                </svg>
                                Réinitialiser
                            </a>
                        </div>
                    </form>
                </div>
            </div>
            
            <!-- Points utilisateur -->
            @auth
            <div class="mt-6 bg-white dark:bg-dark-surface rounded-lg shadow-md dark:shadow-lg border border-gray-200 dark:border-dark-border overflow-hidden">
                <div class="p-5 flex justify-between items-center">
                    <div>
                        <h3 class="font-semibold text-gray-800 dark:text-white">Vos points</h3>
                        <div class="flex items-center mt-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary-600 dark:text-dark-accent" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z" />
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd" />
                            </svg>
                            <span class="ml-1 text-2xl font-bold text-gray-900 dark:text-white">{{ auth()->user()->points ?? 0 }}</span>
                        </div>
                    </div>
                    <a href="{{ route('documents.create') }}" class="text-primary-600 dark:text-dark-accent hover:text-primary-700 dark:hover:text-dark-accentHover text-sm font-medium">
                        + Gagner des points
                    </a>
                </div>
            </div>
            @endauth
        </div>
        
        <!-- Liste des documents -->
        <div class="w-full md:w-3/4">
            <div class="mb-6 flex justify-between items-center">
                <p class="text-gray-700 dark:text-gray-300">
                    <span class="font-semibold text-gray-900 dark:text-white">{{ $documents->total() }}</span> documents trouvés
                </p>
                <div class="flex items-center space-x-2">
                    <span class="text-sm text-gray-700 dark:text-gray-300">Affichage:</span>
                    <button type="button" id="grid-view" class="p-1.5 rounded-md bg-white dark:bg-dark-surface border border-gray-300 dark:border-dark-border text-gray-500 dark:text-gray-400 hover:text-primary-600 dark:hover:text-dark-accent hover:border-primary-600 dark:hover:border-dark-accent transition-colors duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM11 13a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                        </svg>
                    </button>
                    <button type="button" id="list-view" class="p-1.5 rounded-md bg-primary-50 dark:bg-dark-surface border border-primary-600 dark:border-github-accent text-primary-600 dark:text-dark-accent transition-colors duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            </div>
            
            <!-- Documents -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse ($documents as $document)
                    <!-- Document -->
                    <div class="bg-white dark:bg-dark-surface rounded-lg shadow-md dark:shadow-lg border border-gray-200 dark:border-dark-border overflow-hidden transition duration-300 hover:shadow-lg dark:hover:border-dark-accent/30 hover:-translate-y-1">
                        <div class="h-48 bg-gray-200 dark:bg-gray-800 relative">
                            @if ($document->preview_path)
                                <img src="{{ Storage::url($document->preview_path) }}" alt="{{ $document->title }}" class="h-full w-full object-cover object-center">
                            @else
                                <div class="absolute inset-0 flex items-center justify-center text-gray-500 dark:text-gray-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 opacity-50" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                </div>
                            @endif
                            
                            <div class="absolute top-2 right-2">
                                @php
                                    $format = strtolower($document->format);
                                    $formatClass = '';
                                    
                                    if ($format === 'pdf') {
                                        $formatClass = 'bg-gray-800 dark:bg-gray-900';
                                    } elseif (in_array($format, ['doc', 'docx'])) {
                                        $formatClass = 'bg-blue-700 dark:bg-blue-900';
                                    } elseif (in_array($format, ['xls', 'xlsx'])) {
                                        $formatClass = 'bg-green-700 dark:bg-green-900';
                                    }
                                @endphp
                                <span class="{{ $formatClass }} text-white text-xs font-medium px-2.5 py-1 rounded-full">
                                    {{ strtoupper($document->format) }}
                                </span>
                            </div>
                        </div>
                        
                        <div class="p-4">
                            <h3 class="font-semibold text-gray-900 dark:text-white text-lg mb-1 truncate">{{ $document->title }}</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">{{ $document->country }}</p>
                            
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-yellow-500" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/>
                                    </svg>
                                    <span class="text-sm ml-1 text-gray-700 dark:text-gray-300">{{ number_format($document->getAverageRatingAttribute(), 1) }}</span>
                                    <span class="text-xs ml-1 text-gray-500 dark:text-gray-400">({{ $document->ratings->count() }})</span>
                                </div>
                                <span class="inline-flex items-center bg-primary-100 dark:bg-dark-surface/80 text-primary-800 dark:text-primary-300 text-xs font-medium px-2.5 py-1 rounded-full">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z" />
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd" />
                                    </svg>
                                    {{ $document->price }} {{ $document->price > 1 ? 'points' : 'point' }}
                                </span>
                            </div>
                            
                            <a href="{{ route('documents.show', $document) }}" 
                               class="mt-3 w-full inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-primary-600 dark:bg-dark-button hover:bg-primary-700 dark:hover:bg-dark-buttonHover focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 dark:focus:ring-dark-accent dark:focus:ring-offset-dark-bg transition-colors duration-300">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1.5" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                    <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                </svg>
                                Voir le détail
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full">
                        <div class="bg-white dark:bg-dark-surface rounded-lg shadow-md dark:shadow-lg border border-gray-200 dark:border-dark-border p-8 text-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-400 dark:text-gray-500 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">Aucun document trouvé</h3>
                            <p class="text-gray-500 dark:text-gray-400 mb-6">Aucun document ne correspond à vos critères de recherche.</p>
                            <a href="{{ route('documents.index') }}" class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-primary-600 dark:bg-dark-button hover:bg-primary-700 dark:hover:bg-dark-buttonHover focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 dark:focus:ring-dark-accent dark:focus:ring-offset-dark-bg">
                                Réinitialiser les filtres
                            </a>
                        </div>
                    </div>
                @endforelse
            </div>
            
            <!-- Pagination -->
            <div class="mt-8">
                @if ($documents->hasPages())
                    <div class="pagination-wrapper">
                        {{ $documents->withQueryString()->links() }}
                    </div>
                    
                    <style>
                        .pagination-wrapper nav {
                            display: flex;
                            justify-content: center;
                        }
                        
                        .pagination-wrapper nav div:first-child {
                            display: none;
                        }
                        
                        .pagination-wrapper nav span.relative,
                        .pagination-wrapper nav a.relative {
                            display: inline-flex;
                            align-items: center;
                            padding: 0.5rem 0.75rem;
                            border-width: 1px;
                            font-size: 0.875rem;
                            line-height: 1.25rem;
                        }
                        
                        .pagination-wrapper nav span.relative.text-gray-500 {
                            color: theme('colors.gray.500');
                            background-color: theme('colors.white');
                            border-color: theme('colors.gray.300');
                        }
                        
                        .pagination-wrapper nav span.relative.bg-white {
                            color: theme('colors.primary.600');
                            background-color: theme('colors.primary.50') !important;
                            border-color: theme('colors.primary.300');
                        }
                        
                        .pagination-wrapper nav a.relative {
                            color: theme('colors.gray.500');
                            background-color: theme('colors.white');
                            border-color: theme('colors.gray.300');
                            transition: all 200ms;
                        }
                        
                        .pagination-wrapper nav a.relative:hover {
                            background-color: theme('colors.gray.100');
                            color: theme('colors.gray.700');
                        }
                        
                        /* Dark mode styles */
                        .dark .pagination-wrapper nav span.relative.text-gray-500 {
                            color: theme('colors.gray.400');
                            background-color: theme('colors.github.secondary');
                            border-color: theme('colors.github.border');
                        }
                        
                        .dark .pagination-wrapper nav span.relative.bg-white {
                            color: theme('colors.github.accent');
                            background-color: theme('colors.github.header') !important;
                            border-color: rgba(88, 166, 255, 0.5);
                        }
                        
                        .dark .pagination-wrapper nav a.relative {
                            color: theme('colors.gray.400');
                            background-color: theme('colors.github.secondary');
                            border-color: theme('colors.github.border');
                        }
                        
                        .dark .pagination-wrapper nav a.relative:hover {
                            background-color: theme('colors.github.header');
                            color: theme('colors.white');
                        }
                        
                        /* Adding rounded corners */
                        .pagination-wrapper nav span:first-of-type,
                        .pagination-wrapper nav a:first-of-type {
                            border-top-left-radius: 0.5rem;
                            border-bottom-left-radius: 0.5rem;
                        }
                        
                        .pagination-wrapper nav span:last-of-type,
                        .pagination-wrapper nav a:last-of-type {
                            border-top-right-radius: 0.5rem;
                            border-bottom-right-radius: 0.5rem;
                        }
                    </style>
                @endif
            </div>
        </div>
    </div>
    
    <!-- We'll remove the preview modal from this page since we're now linking directly to the show page -->
    @push('scripts')
        <script>
            // View toggle functionality
            document.addEventListener('DOMContentLoaded', function() {
                const gridView = document.getElementById('grid-view');
                const listView = document.getElementById('list-view');
                const documentsGrid = document.querySelector('.grid');
                
                if (gridView && listView && documentsGrid) {
                    // Function to save view preference
                    function saveViewPreference(isGrid) {
                        localStorage.setItem('documents-view', isGrid ? 'grid' : 'list');
                    }
                    
                    // Function to load view preference
                    function loadViewPreference() {
                        return localStorage.getItem('documents-view') || 'grid';
                    }
                    
                    // Function to apply grid view
                    function applyGridView() {
                        documentsGrid.classList.remove('grid-cols-1');
                        documentsGrid.classList.add('sm:grid-cols-2', 'lg:grid-cols-3');
                        
                        gridView.classList.remove('bg-white', 'dark:bg-dark-surface', 'text-gray-500', 'dark:text-gray-400');
                        gridView.classList.add('bg-primary-50', 'dark:bg-dark-surface', 'text-primary-600', 'dark:text-dark-accent');
                        
                        listView.classList.remove('bg-primary-50', 'dark:bg-dark-surface', 'text-primary-600', 'dark:text-dark-accent');
                        listView.classList.add('bg-white', 'dark:bg-dark-surface', 'text-gray-500', 'dark:text-gray-400');
                        
                        gridView.classList.add('border-primary-600', 'dark:border-github-accent');
                        listView.classList.remove('border-primary-600', 'dark:border-github-accent');
                        listView.classList.add('border-gray-300', 'dark:border-dark-border');
                        
                        saveViewPreference(true);
                    }
                    
                    // Function to apply list view
                    function applyListView() {
                        documentsGrid.classList.add('grid-cols-1');
                        documentsGrid.classList.remove('sm:grid-cols-2', 'lg:grid-cols-3');
                        
                        listView.classList.remove('bg-white', 'dark:bg-dark-surface', 'text-gray-500', 'dark:text-gray-400');
                        listView.classList.add('bg-primary-50', 'dark:bg-dark-surface', 'text-primary-600', 'dark:text-dark-accent');
                        
                        gridView.classList.remove('bg-primary-50', 'dark:bg-dark-surface', 'text-primary-600', 'dark:text-dark-accent');
                        gridView.classList.add('bg-white', 'dark:bg-dark-surface', 'text-gray-500', 'dark:text-gray-400');
                        
                        listView.classList.add('border-primary-600', 'dark:border-github-accent');
                        gridView.classList.remove('border-primary-600', 'dark:border-github-accent');
                        gridView.classList.add('border-gray-300', 'dark:border-dark-border');
                        
                        saveViewPreference(false);
                    }
                    
                    // Load saved preference
                    const savedView = loadViewPreference();
                    if (savedView === 'list') {
                        applyListView();
                    } else {
                        applyGridView();
                    }
                    
                    // Add event listeners
                    gridView.addEventListener('click', applyGridView);
                    listView.addEventListener('click', applyListView);
                }
            });
        </script>
    @endpush
</x-app-layout>