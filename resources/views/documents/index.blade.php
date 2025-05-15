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
            <div class="bg-white dark:bg-github-secondary rounded-lg shadow-md dark:shadow-lg border border-gray-200 dark:border-github-border overflow-hidden">
                <div class="p-5 border-b border-gray-200 dark:border-github-border">
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
                                       class="pl-10 w-full rounded-md border-gray-300 dark:border-github-border shadow-sm focus:border-primary-500 dark:focus:border-github-accent focus:ring-primary-500 dark:focus:ring-github-accent dark:bg-github-bg dark:text-white sm:text-sm"
                                       placeholder="Titre, pays...">
                            </div>
                        </div>
                        
                        <!-- Pays -->
                        <div class="mb-4">
                            <label for="country" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Pays</label>
                            <select id="country" name="country" 
                                    class="w-full rounded-md border-gray-300 dark:border-github-border shadow-sm focus:border-primary-500 dark:focus:border-github-accent focus:ring-primary-500 dark:focus:ring-github-accent dark:bg-github-bg dark:text-white sm:text-sm">
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
                                    class="w-full rounded-md border-gray-300 dark:border-github-border shadow-sm focus:border-primary-500 dark:focus:border-github-accent focus:ring-primary-500 dark:focus:ring-github-accent dark:bg-github-bg dark:text-white sm:text-sm">
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
                                    class="w-full rounded-md border-gray-300 dark:border-github-border shadow-sm focus:border-primary-500 dark:focus:border-github-accent focus:ring-primary-500 dark:focus:ring-github-accent dark:bg-github-bg dark:text-white sm:text-sm">
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
                            <button type="submit" class="w-full flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-primary-600 dark:bg-github-button hover:bg-primary-700 dark:hover:bg-github-buttonHover focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 dark:focus:ring-github-accent dark:focus:ring-offset-github-bg">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z" clip-rule="evenodd" />
                                </svg>
                                Appliquer les filtres
                            </button>
                            <a href="{{ route('documents.index') }}" class="w-full flex justify-center items-center px-4 py-2 border border-gray-300 dark:border-github-border text-sm font-medium rounded-md text-gray-700 dark:text-gray-300 bg-white dark:bg-github-secondary hover:bg-gray-50 dark:hover:bg-github-header focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 dark:focus:ring-github-accent dark:focus:ring-offset-github-bg">
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
            <div class="mt-6 bg-white dark:bg-github-secondary rounded-lg shadow-md dark:shadow-lg border border-gray-200 dark:border-github-border overflow-hidden">
                <div class="p-5 flex justify-between items-center">
                    <div>
                        <h3 class="font-semibold text-gray-800 dark:text-white">Vos points</h3>
                        <div class="flex items-center mt-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary-600 dark:text-github-accent" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z" />
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd" />
                            </svg>
                            <span class="ml-1 text-2xl font-bold text-gray-900 dark:text-white">{{ auth()->user()->points ?? 0 }}</span>
                        </div>
                    </div>
                    <a href="{{ route('documents.create') }}" class="text-primary-600 dark:text-github-accent hover:text-primary-700 dark:hover:text-github-hover text-sm font-medium">
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
                    <span class="font-semibold text-gray-900 dark:text-white">16</span> documents trouvés
                </p>
                <div class="flex items-center space-x-2">
                    <span class="text-sm text-gray-700 dark:text-gray-300">Affichage:</span>
                    <button type="button" class="p-1.5 rounded-md bg-white dark:bg-github-secondary border border-gray-300 dark:border-github-border text-gray-500 dark:text-gray-400 hover:text-primary-600 dark:hover:text-github-accent hover:border-primary-600 dark:hover:border-github-accent">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM11 13a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                        </svg>
                    </button>
                    <button type="button" class="p-1.5 rounded-md bg-primary-50 dark:bg-github-hover border border-primary-600 dark:border-github-accent text-primary-600 dark:text-github-accent">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            </div>
            
            <!-- Documents -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @for ($i = 1; $i <= 9; $i++)
                    <!-- Document -->
                    <div class="bg-white dark:bg-github-secondary rounded-lg shadow-md dark:shadow-lg border border-gray-200 dark:border-github-border overflow-hidden transition duration-200 hover:shadow-lg dark:hover:border-github-accent/30">
                        <div class="h-48 bg-gray-200 dark:bg-gray-800 relative">
                            <div class="absolute inset-0 flex items-center justify-center text-gray-500 dark:text-gray-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 opacity-50" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <div class="absolute top-2 right-2">
                                @if ($i % 3 == 0)
                                    <span class="bg-green-700 dark:bg-green-900 text-white text-xs font-medium px-2.5 py-1 rounded-full">XLSX</span>
                                @elseif ($i % 3 == 1)
                                    <span class="bg-gray-800 dark:bg-gray-900 text-white text-xs font-medium px-2.5 py-1 rounded-full">PDF</span>
                                @else
                                    <span class="bg-blue-700 dark:bg-blue-900 text-white text-xs font-medium px-2.5 py-1 rounded-full">DOCX</span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="p-4">
                            <h3 class="font-semibold text-gray-900 dark:text-white text-lg mb-1 truncate">
                                @if ($i % 4 == 0)
                                    Certificat de naissance
                                @elseif ($i % 4 == 1)
                                    Contrat de travail
                                @elseif ($i % 4 == 2)
                                    Diplôme universitaire
                                @else
                                    Permis de conduire
                                @endif
                            </h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">
                                @if ($i % 7 == 0)
                                    France
                                @elseif ($i % 7 == 1)
                                    Allemagne
                                @elseif ($i % 7 == 2)
                                    Belgique
                                @elseif ($i % 7 == 3)
                                    Suisse
                                @elseif ($i % 7 == 4)
                                    Italie
                                @elseif ($i % 7 == 5)
                                    Espagne
                                @else
                                    Canada
                                @endif
                            </p>
                            
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-yellow-500" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/>
                                    </svg>
                                    <span class="text-sm ml-1 text-gray-700 dark:text-gray-300">{{ number_format(3.5 + ($i % 15) / 10, 1) }}</span>
                                    <span class="text-xs ml-1 text-gray-500 dark:text-gray-400">({{ 3 + ($i * 2) }})</span>
                                </div>
                                <span class="inline-flex items-center bg-primary-100 dark:bg-primary-900/20 text-primary-800 dark:text-primary-300 text-xs font-medium px-2.5 py-1 rounded-full">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z" />
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd" />
                                    </svg>
                                    {{ $i % 2 == 0 ? 2 : 1 }} {{ ($i % 2 == 0 ? 2 : 1) > 1 ? 'points' : 'point' }}
                                </span>
                            </div>
                            
                            <button type="button" onclick="openPreviewModal()" 
                                    class="mt-3 w-full inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-primary-600 dark:bg-github-button hover:bg-primary-700 dark:hover:bg-github-buttonHover focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 dark:focus:ring-github-accent dark:focus:ring-offset-github-bg">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1.5" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                    <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                </svg>
                                Voir le détail
                            </button>
                        </div>
                    </div>
                @endfor
            </div>
            
            <!-- Pagination -->
            <div class="mt-8">
                <nav class="flex justify-center">
                    <ul class="inline-flex -space-x-px">
                        <li>
                            <a href="#" class="px-3 py-2 ml-0 leading-tight text-gray-500 dark:text-gray-400 bg-white dark:bg-github-secondary border border-gray-300 dark:border-github-border rounded-l-lg hover:bg-gray-100 dark:hover:bg-github-header hover:text-gray-700 dark:hover:text-white">
                                Précédent
                            </a>
                        </li>
                        <li>
                            <a href="#" class="px-3 py-2 leading-tight text-gray-500 dark:text-gray-400 bg-white dark:bg-github-secondary border border-gray-300 dark:border-github-border hover:bg-gray-100 dark:hover:bg-github-header hover:text-gray-700 dark:hover:text-white">1</a>
                        </li>
                        <li>
                            <a href="#" aria-current="page" class="px-3 py-2 text-primary-600 dark:text-github-accent border border-primary-300 dark:border-github-accent/50 bg-primary-50 dark:bg-github-header hover:bg-primary-100 dark:hover:bg-github-hover/20 hover:text-primary-700 dark:hover:text-white">2</a>
                        </li>
                        <li>
                            <a href="#" class="px-3 py-2 leading-tight text-gray-500 dark:text-gray-400 bg-white dark:bg-github-secondary border border-gray-300 dark:border-github-border hover:bg-gray-100 dark:hover:bg-github-header hover:text-gray-700 dark:hover:text-white">3</a>
                        </li>
                        <li>
                            <a href="#" class="px-3 py-2 leading-tight text-gray-500 dark:text-gray-400 bg-white dark:bg-github-secondary border border-gray-300 dark:border-github-border rounded-r-lg hover:bg-gray-100 dark:hover:bg-github-header hover:text-gray-700 dark:hover:text-white">
                                Suivant
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
    
    <!-- Modal de prévisualisation -->
    <div id="preview-modal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <!-- Overlay -->
            <div class="fixed inset-0 bg-gray-500 dark:bg-gray-900 bg-opacity-75 dark:bg-opacity-75 transition-opacity" aria-hidden="true"></div>
            
            <!-- Modal -->
            <div class="inline-block align-bottom bg-white dark:bg-github-secondary rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
                <div class="bg-white dark:bg-github-secondary px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white" id="modal-title">
                                Certificat de naissance
                            </h3>
                            <div class="mt-5">
                                <!-- Aperçu du document -->
                                <div class="h-64 bg-gray-200 dark:bg-gray-800 flex items-center justify-center mb-5 rounded-md">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24 text-gray-400 dark:text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                </div>
                                
                                <!-- Informations du document -->
                                <div class="grid grid-cols-2 gap-4 mb-5">
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">Pays</h4>
                                        <p class="text-gray-900 dark:text-white">France</p>
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">Format</h4>
                                        <p class="text-gray-900 dark:text-white">PDF</p>
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">Date d'ajout</h4>
                                        <p class="text-gray-900 dark:text-white">10/05/2025</p>
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">Téléchargements</h4>
                                        <p class="text-gray-900 dark:text-white">42</p>
                                    </div>
                                </div>
                                
                                <!-- Description -->
                                <div class="mb-5">
                                    <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">Description</h4>
                                    <p class="text-gray-900 dark:text-white mt-1">Format officiel du certificat de naissance français. Ce document inclut les champs pour les informations personnelles, les informations des parents, ainsi que les emplacements pour les tampons et signatures officiels.</p>
                                </div>
                                
                                <!-- Évaluations -->
                                <div>
                                    <div class="flex items-center">
                                        <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400 mr-2">Évaluation</h4>
                                        <div class="flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-500" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/>
                                            </svg>
                                            <span class="ml-1 text-gray-900 dark:text-white">4.5</span>
                                            <span class="ml-1 text-sm text-gray-500 dark:text-gray-400">(12 avis)</span>
                                        </div>
                                    </div>
                                    
                                    <div class="mt-2 border-t border-gray-200 dark:border-github-border pt-2">
                                        <div class="flex items-start space-x-3">
                                            <div class="flex-shrink-0">
                                                <div class="h-8 w-8 rounded-full bg-primary-600 dark:bg-github-accent flex items-center justify-center text-white font-medium">
                                                    JD
                                                </div>
                                            </div>
                                            <div>
                                                <div class="flex items-center">
                                                    <span class="text-sm font-medium text-gray-900 dark:text-white">Jean Dupont</span>
                                                    <div class="ml-2 flex">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-yellow-500" fill="currentColor" viewBox="0 0 24 24">
                                                            <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/>
                                                        </svg>
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-yellow-500" fill="currentColor" viewBox="0 0 24 24">
                                                            <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/>
                                                        </svg>
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-yellow-500" fill="currentColor" viewBox="0 0 24 24">
                                                            <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/>
                                                        </svg>
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-yellow-500" fill="currentColor" viewBox="0 0 24 24">
                                                            <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/>
                                                        </svg>
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-yellow-500" fill="currentColor" viewBox="0 0 24 24">
                                                            <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/>
                                                        </svg>
                                                    </div>
                                                </div>
                                                <p class="text-sm text-gray-700 dark:text-gray-300 mt-1">Format parfait, exactement comme le document officiel. M'a fait gagner beaucoup de temps !</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="bg-gray-50 dark:bg-github-bg px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse border-t border-gray-200 dark:border-github-border">
                    <div class="flex items-center justify-between w-full">
                        <div class="flex items-center">
                            <span class="font-semibold text-gray-900 dark:text-white mr-2">Prix:</span>
                            <span class="inline-flex items-center bg-primary-100 dark:bg-primary-900/20 text-primary-800 dark:text-primary-300 px-2.5 py-1 rounded-full font-medium">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z" />
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd" />
                                </svg>
                                1 point
                            </span>
                        </div>
                        
                        <div class="flex space-x-3">
                            <button type="button" class="w-full inline-flex justify-center rounded-md border border-gray-300 dark:border-github-border shadow-sm px-4 py-2 bg-white dark:bg-github-secondary text-base font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-github-header focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 dark:focus:ring-github-accent dark:focus:ring-offset-github-bg sm:w-auto sm:text-sm" onclick="closePreviewModal()">
                                Fermer
                            </button>
                            <button type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-primary-600 dark:bg-github-button text-base font-medium text-white hover:bg-primary-700 dark:hover:bg-github-buttonHover focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 dark:focus:ring-github-accent dark:focus:ring-offset-github-bg sm:w-auto sm:text-sm">
                                Télécharger (1 point)
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    @push('scripts')
        <script>
            function openPreviewModal() {
                document.getElementById('preview-modal').classList.remove('hidden');
                document.body.classList.add('overflow-hidden');
            }
            
            function closePreviewModal() {
                document.getElementById('preview-modal').classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            }
        </script>
    @endpush
</x-app-layout>