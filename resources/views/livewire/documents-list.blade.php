<div>
    <div class="flex flex-col md:flex-row md:space-x-6">
        <!-- Filtres (Sidebar) -->
        <div class="w-full mb-6 md:w-1/4 md:mb-0">
            <div class="overflow-hidden bg-white border border-gray-200 rounded-lg shadow-md dark:bg-dark-surface dark:shadow-lg dark:border-dark-border">
                <div class="p-5 border-b border-gray-200 dark:border-dark-border">
                    <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-white">{{ __('public.documents.filters') }}</h2>
                </div>
                <div class="p-5">
                    <div class="space-y-4">
                        <!-- Recherche -->
                        <div class="mb-4">
                            <label for="search" class="block mb-1 text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('public.documents.search') }}</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400 dark:text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <input type="text" id="search" wire:model.debounce.300ms="search"
                                    class="w-full pl-10 border-gray-300 rounded-md shadow-sm dark:border-dark-border focus:border-primary-500 dark:focus:border-dark-accent focus:ring-primary-500 dark:focus:ring-dark-accent dark:bg-dark-bg dark:text-white sm:text-sm"
                                    placeholder="{{ __('public.documents.search_placeholder') }}">
                            </div>
                        </div>

                        <!-- Pays -->
                        <div class="mb-4">
                            <label for="country" class="block mb-1 text-sm font-medium text-gray-700 dark:text-gray-300">
                                {{ __('app.country') }}
                            </label>
                            <select id="country" wire:model="country"
                                class="w-full border-gray-300 rounded-md shadow-sm dark:border-dark-border focus:border-primary-500 dark:focus:border-dark-accent focus:ring-primary-500 dark:focus:ring-dark-accent dark:bg-dark-bg dark:text-white sm:text-sm">
                                <option value="">{{ __('app.all_countries') }}</option>
                                @foreach($availableCountries as $countryOption)
                                    <option value="{{ $countryOption }}">{{ ucfirst($countryOption) }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Format -->
                        <div class="mb-4">
                            <label for="format" class="block mb-1 text-sm font-medium text-gray-700 dark:text-gray-300">
                                {{ __('app.format') }}
                            </label>
                            <select id="format" wire:model="format"
                                class="w-full border-gray-300 rounded-md shadow-sm dark:border-dark-border focus:border-primary-500 dark:focus:border-dark-accent focus:ring-primary-500 dark:focus:ring-dark-accent dark:bg-dark-bg dark:text-white sm:text-sm">
                                <option value="">{{ __('app.all_formats') }}</option>
                                <option value="pdf">PDF</option>
                                <option value="doc">Word (DOC/DOCX)</option>
                                <option value="xls">Excel (XLS/XLSX)</option>
                            </select>
                        </div>

                        <!-- Filtres de prix -->
                        <div class="mb-4">
                            <label class="block mb-1 text-sm font-medium text-gray-700 dark:text-gray-300">
                                {{ __('app.price') }} ({{ __('app.points') }})
                            </label>
                            <div class="grid grid-cols-2 gap-2">
                                <input type="number" wire:model.debounce.300ms="priceMin" placeholder="{{ __('public.documents.price_min') }}" min="0" step="1"
                                    class="w-full border-gray-300 rounded-md shadow-sm dark:border-dark-border focus:border-primary-500 dark:focus:border-dark-accent focus:ring-primary-500 dark:focus:ring-dark-accent dark:bg-dark-bg dark:text-white sm:text-sm">
                                <input type="number" wire:model.debounce.300ms="priceMax" placeholder="{{ __('public.documents.price_max') }}" min="0" step="1"
                                    class="w-full border-gray-300 rounded-md shadow-sm dark:border-dark-border focus:border-primary-500 dark:focus:border-dark-accent focus:ring-primary-500 dark:focus:ring-dark-accent dark:bg-dark-bg dark:text-white sm:text-sm">
                            </div>
                        </div>

                        <!-- Filtres de date -->
                        <div class="mb-4">
                            <label class="block mb-1 text-sm font-medium text-gray-700 dark:text-gray-300">
                                {{ __('public.documents.publication_period') }}
                            </label>
                            <div class="space-y-2">
                                <input type="date" wire:model="dateFrom"
                                    class="w-full border-gray-300 rounded-md shadow-sm dark:border-dark-border focus:border-primary-500 dark:focus:border-dark-accent focus:ring-primary-500 dark:focus:ring-dark-accent dark:bg-dark-bg dark:text-white sm:text-sm">
                                <input type="date" wire:model="dateTo"
                                    class="w-full border-gray-300 rounded-md shadow-sm dark:border-dark-border focus:border-primary-500 dark:focus:border-dark-accent focus:ring-primary-500 dark:focus:ring-dark-accent dark:bg-dark-bg dark:text-white sm:text-sm">
                            </div>
                        </div>

                        <!-- Tri -->
                        <div class="mb-6">
                            <label for="sort" class="block mb-1 text-sm font-medium text-gray-700 dark:text-gray-300">
                                {{ __('app.sort') }}
                            </label>
                            <select id="sort" wire:model="sort"
                                class="w-full border-gray-300 rounded-md shadow-sm dark:border-dark-border focus:border-primary-500 dark:focus:border-dark-accent focus:ring-primary-500 dark:focus:ring-dark-accent dark:bg-dark-bg dark:text-white sm:text-sm">
                                <option value="newest">{{ __('app.newest') }}</option>
                                <option value="oldest">{{ __('app.oldest') }}</option>
                                <option value="rating">{{ __('app.best_rated') }}</option>
                                <option value="downloads">{{ __('app.most_downloaded') }}</option>
                                <option value="price_asc">{{ __('app.price_low_high') }}</option>
                                <option value="price_desc">{{ __('app.price_high_low') }}</option>
                                <option value="title_asc">{{ __('public.documents.title_a_z') }}</option>
                                <option value="title_desc">{{ __('public.documents.title_z_a') }}</option>
                            </select>
                        </div>

                        <!-- Boutons -->
                        <div class="flex flex-col space-y-2">
                            <button wire:click="resetFilters" type="button"
                                class="flex items-center justify-center w-full px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md dark:border-dark-border dark:text-gray-300 dark:bg-dark-surface hover:bg-gray-50 dark:hover:bg-dark-surface focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 dark:focus:ring-dark-accent dark:focus:ring-offset-dark-bg">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z" clip-rule="evenodd"></path>
                                </svg>
                                {{ __('common.reset') }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Points utilisateur -->
            @auth
                <div class="mt-6 overflow-hidden bg-white border border-gray-200 rounded-lg shadow-md dark:bg-dark-surface dark:shadow-lg dark:border-dark-border">
                    <div class="flex items-center justify-between p-5">
                        <div>
                            <h3 class="font-semibold text-gray-800 dark:text-white">{{ __('public.documents.your_points') }}</h3>
                            <div class="flex items-center mt-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-primary-600 dark:text-dark-accent" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z" />
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="ml-1 text-2xl font-bold text-gray-900 dark:text-white">{{ auth()->user()->points }}</span>
                            </div>
                        </div>
                        <a href="{{ route('documents.create') }}" class="text-sm font-medium text-primary-600 dark:text-dark-accent hover:text-primary-700 dark:hover:text-dark-accentHover">
                            {{ __('public.documents.earn_points') }}
                        </a>
                    </div>
                </div>
            @endauth
        </div>

        <!-- Liste des documents -->
        <div class="w-full md:w-3/4">
            <!-- Statistiques -->
            <div class="grid grid-cols-1 gap-4 mb-6 sm:grid-cols-3">
                <div class="p-4 bg-white border border-gray-200 rounded-lg dark:bg-dark-surface dark:border-dark-border">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="w-8 h-8 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('public.documents.total_documents') }}</p>
                            <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ number_format($totalDocuments) }}</p>
                        </div>
                    </div>
                </div>
                <div class="p-4 bg-white border border-gray-200 rounded-lg dark:bg-dark-surface dark:border-dark-border">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="w-8 h-8 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('public.documents.filtered_results') }}</p>
                            <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ number_format($filteredCount) }}</p>
                        </div>
                    </div>
                </div>
                <div class="p-4 bg-white border border-gray-200 rounded-lg dark:bg-dark-surface dark:border-dark-border">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="w-8 h-8 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('public.documents.available_countries') }}</p>
                            <p class="text-2xl font-semibold text-gray-900 dark:text-white">{{ count($availableCountries) }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-between mb-6">
                <p class="text-gray-700 dark:text-gray-300">
                    <span class="font-semibold text-gray-900 dark:text-white">{{ $documents->total() }}</span> {{ __('public.documents.documents_found') }}
                    @if($search || $country || $format || $priceMin || $priceMax || $dateFrom || $dateTo)
                        <span class="ml-2 text-sm text-gray-500 dark:text-gray-400">
                            ({{ __('public.documents.filtered_on') }} {{ number_format($totalDocuments) }} {{ __('public.documents.total') }})
                        </span>
                    @endif
                </p>
                <div class="flex items-center space-x-2">
                    <span class="text-sm text-gray-700 dark:text-gray-300">{{ __('public.documents.display') }}:</span>
                    <button type="button" wire:click="$set('viewMode', 'grid')"
                        class="p-1.5 rounded-md {{ $viewMode === 'grid' ? 'bg-primary-50 dark:bg-dark-surface border-primary-600 dark:border-github-accent text-primary-600 dark:text-dark-accent' : 'bg-white dark:bg-dark-surface border border-gray-300 dark:border-dark-border text-gray-500 dark:text-gray-400 hover:text-primary-600 dark:hover:text-dark-accent hover:border-primary-600 dark:hover:border-dark-accent transition-colors duration-200' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM11 13a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                        </svg>
                    </button>
                    <button type="button" wire:click="$set('viewMode', 'list')"
                        class="p-1.5 rounded-md {{ $viewMode === 'list' ? 'bg-primary-50 dark:bg-dark-surface border-primary-600 dark:border-github-accent text-primary-600 dark:text-dark-accent' : 'bg-white dark:bg-dark-surface border border-gray-300 dark:border-dark-border text-gray-500 dark:text-gray-400 hover:text-primary-600 dark:hover:text-dark-accent hover:border-primary-600 dark:hover:border-dark-accent transition-colors duration-200' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Documents -->
            <div class="grid grid-cols-1 {{ $viewMode === 'grid' ? 'sm:grid-cols-2 lg:grid-cols-3' : '' }} gap-6" wire:loading.class="opacity-50">
                @forelse ($documents as $document)
                    <!-- Document -->
                    <div class="overflow-hidden transition duration-300 bg-white border border-gray-200 rounded-lg shadow-md dark:bg-dark-surface dark:shadow-lg dark:border-dark-border hover:shadow-lg dark:hover:border-dark-accent/30 hover:-translate-y-1">
                        <div class="relative h-48 bg-gray-200 dark:bg-gray-800">
                            @if ($document->preview_path)
                                <img src="{{ Storage::url($document->preview_path) }}" alt="{{ $document->title }}" class="object-cover object-center w-full h-full">
                            @else
                                <div class="absolute inset-0 flex items-center justify-center text-gray-500 dark:text-gray-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 opacity-50" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
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
                            <h3 class="mb-1 text-lg font-semibold text-gray-900 truncate dark:text-white">{{ $document->title }}</h3>
                            <p class="mb-3 text-sm text-gray-600 dark:text-gray-400">{{ $document->country }}</p>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-yellow-500" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"></path>
                                    </svg>
                                    <span class="ml-1 text-sm text-gray-700 dark:text-gray-300">{{ number_format($document->average_rating, 1) }}</span>
                                    <span class="ml-1 text-xs text-gray-500 dark:text-gray-400">({{ $document->ratings_count }})</span>
                                </div>
                                <span class="inline-flex items-center bg-primary-100 dark:bg-dark-surface/80 text-primary-800 dark:text-primary-300 text-xs font-medium px-2.5 py-1 rounded-full">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z" />
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd"></path>
                                    </svg>
                                    {{ $document->price }} {{ $document->price > 1 ? __('common.points') : __('common.point') }}
                                </span>
                            </div>
                            <a href="{{ route('documents.show', $document) }}"
                                class="inline-flex items-center justify-center w-full px-4 py-2 mt-3 text-sm font-medium text-white transition-colors duration-300 border border-transparent rounded-md shadow-sm bg-primary-600 dark:bg-dark-button hover:bg-primary-700 dark:hover:bg-dark-buttonHover focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 dark:focus:ring-dark-accent dark:focus:ring-offset-dark-bg">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1.5" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                    <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"></path>
                                </svg>
                                {{ __('public.documents.view_details') }}
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full">
                        <div class="p-8 text-center bg-white border border-gray-200 rounded-lg shadow-md dark:bg-dark-surface dark:shadow-lg dark:border-dark-border">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-16 h-16 mx-auto mb-4 text-gray-400 dark:text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <h3 class="mb-2 text-lg font-medium text-gray-900 dark:text-white">{{ __('public.documents.no_documents_found') }}</h3>
                            <p class="mb-6 text-gray-500 dark:text-gray-400">{{ __('public.documents.no_documents_match') }}</p>
                            <button wire:click="resetFilters"
                                class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white border border-transparent rounded-md shadow-sm bg-primary-600 dark:bg-dark-button hover:bg-primary-700 dark:hover:bg-dark-buttonHover focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 dark:focus:ring-dark-accent dark:focus:ring-offset-dark-bg">
                                {{ __('public.documents.reset_filters') }}
                            </button>
                        </div>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $documents->links() }}
            </div>
        </div>
    </div>
</div>
