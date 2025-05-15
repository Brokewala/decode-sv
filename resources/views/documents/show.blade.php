<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">{{ $document->title }}</h1>
                <p class="mt-2 text-gray-600 dark:text-gray-400">
                    {{ $document->country }} • Ajouté le {{ $document->created_at->format('d/m/Y') }}
                </p>
            </div>
            <a href="{{ route('documents.index') }}" class="inline-flex items-center text-sm font-medium text-primary-600 dark:text-github-accent hover:text-primary-500 dark:hover:text-github-hover">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                </svg>
                Retour au catalogue
            </a>
        </div>
    </x-slot>
    
    <div class="max-w-4xl mx-auto">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Prévisualisation -->
            <div class="md:col-span-2">
                <div class="bg-white dark:bg-github-secondary rounded-lg shadow-md dark:shadow-lg border border-gray-200 dark:border-github-border overflow-hidden">
                    <div class="p-6 border-b border-gray-200 dark:border-github-border">
                        <h2 class="text-lg font-medium text-gray-900 dark:text-white">Aperçu du document</h2>
                    </div>
                    
                    <div class="h-96 bg-gray-100 dark:bg-gray-800 flex items-center justify-center p-4">
                        @if($document->preview_path)
                            <img src="{{ asset('storage/' . $document->preview_path) }}" alt="{{ $document->title }}" class="max-h-full object-contain">
                        @else
                            <div class="text-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24 mx-auto text-gray-400 dark:text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <p class="mt-4 text-gray-600 dark:text-gray-400">Prévisualisation non disponible</p>
                            </div>
                        @endif
                    </div>
                </div>
                
                <!-- Description -->
                @if($document->description)
                <div class="mt-6 bg-white dark:bg-github-secondary rounded-lg shadow-md dark:shadow-lg border border-gray-200 dark:border-github-border overflow-hidden">
                    <div class="p-6 border-b border-gray-200 dark:border-github-border">
                        <h2 class="text-lg font-medium text-gray-900 dark:text-white">Description</h2>
                    </div>
                    
                    <div class="p-6">
                        <p class="text-gray-700 dark:text-gray-300">{{ $document->description }}</p>
                    </div>
                </div>
                @endif
                
                <!-- Évaluations -->
                <div class="mt-6 bg-white dark:bg-github-secondary rounded-lg shadow-md dark:shadow-lg border border-gray-200 dark:border-github-border overflow-hidden">
                    <div class="p-6 border-b border-gray-200 dark:border-github-border">
                        <div class="flex items-center justify-between">
                            <h2 class="text-lg font-medium text-gray-900 dark:text-white">Évaluations</h2>
                            <div class="flex items-center">
                                <div class="flex">
                                    @for($i = 1; $i <= 5; $i++)
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 {{ $i <= round($averageRating) ? 'text-yellow-500' : 'text-gray-300 dark:text-gray-600' }}" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                    @endfor
                                </div>
                                <span class="ml-2 text-sm font-medium text-gray-700 dark:text-gray-300">{{ number_format($averageRating, 1) }}/5</span>
                                <span class="ml-1 text-sm text-gray-500 dark:text-gray-400">({{ $document->ratings->count() }} avis)</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="divide-y divide-gray-200 dark:divide-github-border">
                        @forelse($ratings as $rating)
                            <div class="p-6">
                                <div class="flex items-start space-x-3">
                                    <div class="flex-shrink-0">
                                        <div class="h-10 w-10 rounded-full bg-primary-500 dark:bg-github-accent flex items-center justify-center text-white text-sm font-medium">
                                            {{ substr($rating->user->name, 0, 2) }}
                                        </div>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center">
                                            <h3 class="text-sm font-medium text-gray-900 dark:text-white">{{ $rating->user->name }}</h3>
                                            <span class="ml-2 text-xs text-gray-500 dark:text-gray-400">{{ $rating->created_at->format('d/m/Y') }}</span>
                                            <div class="ml-4 flex">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 {{ $i <= $rating->rating ? 'text-yellow-500' : 'text-gray-300 dark:text-gray-600' }}" viewBox="0 0 20 20" fill="currentColor">
                                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                    </svg>
                                                @endfor
                                            </div>
                                        </div>
                                        @if($rating->comment)
                                            <p class="mt-2 text-sm text-gray-700 dark:text-gray-300">{{ $rating->comment }}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="p-6 text-center">
                                <p class="text-gray-500 dark:text-gray-400">Aucune évaluation pour le moment.</p>
                            </div>
                        @endforelse
                    </div>
                    
                    @auth
                        @if(auth()->user()->downloadedDocuments()->where('document_id', $document->id)->exists())
                            <div class="p-6 border-t border-gray-200 dark:border-github-border">
                                <h3 class="text-sm font-medium text-gray-900 dark:text-white mb-3">Ajouter une évaluation</h3>
                                <form method="POST" action="{{ route('documents.rate', $document) }}" class="space-y-4">
                                    @csrf
                                    
                                    <div>
                                        <label for="rating" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Votre note</label>
                                        <div class="mt-1 flex items-center space-x-2">
                                            <div class="flex space-x-1">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <button type="button" onclick="document.getElementById('rating').value = {{ $i }}" class="rating-star" data-value="{{ $i }}">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-300 dark:text-gray-600 hover:text-yellow-500 dark:hover:text-yellow-500" viewBox="0 0 20 20" fill="currentColor">
                                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                        </svg>
                                                    </button>
                                                @endfor
                                                <input type="hidden" id="rating" name="rating" value="5">
                                            </div>
                                        </div>
                                        @error('rating')
                                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    
                                    <div>
                                        <label for="comment" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Votre commentaire (optionnel)</label>
                                        <div class="mt-1">
                                            <textarea id="comment" name="comment" rows="3" 
                                                      class="block w-full rounded-md border-gray-300 dark:border-github-border shadow-sm focus:border-primary-500 dark:focus:border-github-accent focus:ring-primary-500 dark:focus:ring-github-accent dark:bg-github-bg dark:text-white sm:text-sm"
                                                      placeholder="Partagez votre expérience avec ce format..."></textarea>
                                        </div>
                                        @error('comment')
                                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    
                                    <div>
                                        <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-primary-600 dark:bg-github-button hover:bg-primary-700 dark:hover:bg-github-buttonHover focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 dark:focus:ring-github-accent dark:focus:ring-offset-github-bg">
                                            Envoyer mon évaluation
                                        </button>
                                    </div>
                                </form>
                            </div>
                        @endif
                    @endauth
                </div>
            </div>
            
            <!-- Informations et actions -->
            <div class="md:col-span-1">
                <div class="bg-white dark:bg-github-secondary rounded-lg shadow-md dark:shadow-lg border border-gray-200 dark:border-github-border overflow-hidden mb-6">
                    <div class="p-6 border-b border-gray-200 dark:border-github-border">
                        <h2 class="text-lg font-medium text-gray-900 dark:text-white">Informations</h2>
                    </div>
                    
                    <div class="p-6 space-y-4">
                        <div>
                            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Format</h3>
                            <p class="mt-1 text-sm font-medium text-gray-900 dark:text-white">
                                <span class="inline-flex px-2 py-0.5 text-xs font-medium rounded-full
                                    @if($document->format == 'pdf') bg-gray-100 dark:bg-gray-800 text-gray-800 dark:text-gray-300
                                    @elseif(in_array($document->format, ['doc', 'docx'])) bg-blue-100 dark:bg-blue-900/20 text-blue-800 dark:text-blue-300
                                    @else bg-green-100 dark:bg-green-900/20 text-green-800 dark:text-green-300
                                    @endif">
                                    {{ strtoupper($document->format) }}
                                </span>
                            </p>
                        </div>
                        
                        <div>
                            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Pays</h3>
                            <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $document->country }}</p>
                        </div>
                        
                        <div>
                            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Ajouté par</h3>
                            <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $document->user->name }}</p>
                        </div>
                        
                        <div>
                            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Date d'ajout</h3>
                            <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $document->created_at->format('d/m/Y') }}</p>
                        </div>
                        
                        <div>
                            <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Téléchargements</h3>
                            <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $document->downloads }}</p>
                        </div>
                    </div>
                </div>
                
                <!-- Téléchargement -->
                <div class="bg-white dark:bg-github-secondary rounded-lg shadow-md dark:shadow-lg border border-gray-200 dark:border-github-border overflow-hidden">
                    <div class="p-6 border-b border-gray-200 dark:border-github-border">
                        <h2 class="text-lg font-medium text-gray-900 dark:text-white">Téléchargement</h2>
                    </div>
                    
                    <div class="p-6">
                        <div class="flex items-center mb-6">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary-600 dark:text-github-accent mr-2" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z" />
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd" />
                            </svg>
                            <span class="text-2xl font-bold text-gray-900 dark:text-white">{{ $document->price }}</span>
                            <span class="ml-1 text-sm text-gray-500 dark:text-gray-400">{{ $document->price > 1 ? 'points' : 'point' }}</span>
                        </div>
                        
                        @auth
                            @if(auth()->user()->downloadedDocuments()->where('document_id', $document->id)->exists())
                                <form method="POST" action="{{ route('documents.download', $document) }}">
                                    @csrf
                                    <button type="submit" class="w-full flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-primary-600 dark:bg-github-button hover:bg-primary-700 dark:hover:bg-github-buttonHover focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 dark:focus:ring-github-accent dark:focus:ring-offset-github-bg">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                        Télécharger à nouveau
                                    </button>
                                </form>
                            @elseif(auth()->user()->points >= $document->price)
                                <form method="POST" action="{{ route('documents.download', $document) }}">
                                    @csrf
                                    <button type="submit" class="w-full flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-primary-600 dark:bg-github-button hover:bg-primary-700 dark:hover:bg-github-buttonHover focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 dark:focus:ring-github-accent dark:focus:ring-offset-github-bg">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                        Télécharger pour {{ $document->price }} {{ $document->price > 1 ? 'points' : 'point' }}
                                    </button>
                                </form>
                            @else
                                <div class="text-center">
                                    <p class="text-sm text-red-600 dark:text-red-400 mb-3">Vous n'avez pas assez de points ({{ auth()->user()->points }} / {{ $document->price }})</p>
                                    <a href="{{ route('documents.create') }}" class="w-full flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-primary-600 dark:bg-github-button hover:bg-primary-700 dark:hover:bg-github-buttonHover focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 dark:focus:ring-github-accent dark:focus:ring-offset-github-bg">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                                        </svg>
                                        Gagnez des points
                                    </a>
                                </div>
                            @endif
                        @else
                            <a href="{{ route('login') }}" class="w-full flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-primary-600 dark:bg-github-button hover:bg-primary-700 dark:hover:bg-github-buttonHover focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 dark:focus:ring-github-accent dark:focus:ring-offset-github-bg">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z" clip-rule="evenodd" />
                                </svg>
                                Connectez-vous pour télécharger
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const stars = document.querySelectorAll('.rating-star');
                
                stars.forEach(star => {
                    star.addEventListener('click', function() {
                        const value = this.getAttribute('data-value');
                        
                        // Reset all stars
                        stars.forEach(s => {
                            s.querySelector('svg').classList.remove('text-yellow-500');
                            s.querySelector('svg').classList.add('text-gray-300', 'dark:text-gray-600');
                        });
                        
                        // Set selected stars
                        for (let i = 0; i < value; i++) {
                            stars[i].querySelector('svg').classList.remove('text-gray-300', 'dark:text-gray-600');
                            stars[i].querySelector('svg').classList.add('text-yellow-500');
                        }
                    });
                });
            });
        </script>
    @endpush
</x-app-layout>