<div>
    <div class="max-w-3xl mx-auto">
        <div class="bg-white dark:bg-dark-surface rounded-lg shadow-md dark:shadow-lg border border-gray-200 dark:border-dark-border overflow-hidden">
            <div class="p-6 border-b border-gray-200 dark:border-dark-border">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Déposer un document</h2>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    Partagez vos formats de documents avec d'autres traducteurs et gagnez des points.
                </p>
            </div>
            
            <form wire:submit.prevent="upload" class="p-6 space-y-6">
                <!-- Titre -->
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Titre du document</label>
                    <div class="mt-1">
                        <input type="text" id="title" wire:model="title" 
                               class="block w-full rounded-md border-gray-300 dark:border-dark-border shadow-sm focus:border-primary-500 dark:focus:border-dark-accent focus:ring-primary-500 dark:focus:ring-dark-accent dark:bg-dark-bg dark:text-white sm:text-sm"
                               placeholder="Exemple : Certificat de naissance - France">
                    </div>
                    @error('title') <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                </div>
                
                <!-- Pays -->
                <div>
                    <label for="country" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Pays d'origine</label>
                    <div class="mt-1">
                        <select id="country" wire:model="country" 
                                class="block w-full rounded-md border-gray-300 dark:border-dark-border shadow-sm focus:border-primary-500 dark:focus:border-dark-accent focus:ring-primary-500 dark:focus:ring-dark-accent dark:bg-dark-bg dark:text-white sm:text-sm">
                            <option value="">Sélectionnez un pays</option>
                            <option value="international">International</option>
                            <option value="france">France</option>
                            <option value="allemagne">Allemagne</option>
                            <option value="belgique">Belgique</option>
                            <option value="suisse">Suisse</option>
                            <option value="italie">Italie</option>
                            <option value="espagne">Espagne</option>
                            <option value="royaume-uni">Royaume-Uni</option>
                            <option value="canada">Canada</option>
                            <option value="etats-unis">États-Unis</option>
                        </select>
                    </div>
                    @error('country') <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                </div>
                
                <!-- Fichier -->
                <div>
                    <label for="file" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Document</label>
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 dark:border-dark-border border-dashed rounded-md">
                        <div class="space-y-1 text-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-12 w-12 text-gray-400 dark:text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <div class="flex text-sm text-gray-600 dark:text-gray-400">
                                <label for="file" class="relative cursor-pointer bg-white dark:bg-dark-surface rounded-md font-medium text-primary-600 dark:text-dark-accent hover:text-primary-500 dark:hover:text-dark-accentHover focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-primary-500 dark:focus-within:ring-dark-accent dark:focus-within:ring-offset-dark-bg">
                                    <span>Choisir un fichier</span>
                                    <input id="file" wire:model="file" type="file" class="sr-only">
                                </label>
                                <p class="pl-1">ou glisser-déposer</p>
                            </div>
                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                PDF, DOC, DOCX, XLS, XLSX jusqu'à 10 Mo
                            </p>
                        </div>
                    </div>
                    @error('file') <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                    
                    @if ($file)
                    <div class="mt-3 flex items-center space-x-3">
                        <div class="flex-shrink-0 inline-flex items-center justify-center h-10 w-10 rounded bg-primary-100 dark:bg-primary-900/20 text-primary-600 dark:text-primary-400">
                            @php
                                $ext = strtolower($file->getClientOriginalExtension());
                                $icon = match($ext) {
                                    'pdf' => '<svg class="h-6 w-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd" /></svg>',
                                    'doc', 'docx' => '<svg class="h-6 w-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd" /></svg>',
                                    'xls', 'xlsx' => '<svg class="h-6 w-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd" /></svg>',
                                    default => '<svg class="h-6 w-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd" /></svg>'
                                };
                            @endphp
                            {!! $icon !!}
                        </div>
                        <div class="flex-1 flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-900 dark:text-white">
                                    {{ $file->getClientOriginalName() }}
                                </p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                    {{ number_format($file->getSize() / 1024 / 1024, 2) }} Mo
                                </p>
                            </div>
                            <button type="button" wire:click="$set('file', null)" class="text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400">
                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>
                    </div>
                    @endif
                </div>
                
                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Description (optionnelle)</label>
                    <div class="mt-1">
                        <textarea id="description" wire:model="description" rows="4" 
                                  class="block w-full rounded-md border-gray-300 dark:border-dark-border shadow-sm focus:border-primary-500 dark:focus:border-dark-accent focus:ring-primary-500 dark:focus:ring-dark-accent dark:bg-dark-bg dark:text-white sm:text-sm"
                                  placeholder="Expliquez brièvement le contexte d'utilisation de ce document..."></textarea>
                    </div>
                    @error('description') <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                </div>
                
                <!-- Termes et conditions -->
                <div class="relative flex items-start">
                    <div class="flex items-center h-5">
                        <input id="terms" wire:model="terms" type="checkbox" 
                               class="h-4 w-4 text-primary-600 dark:text-dark-accent focus:ring-primary-500 dark:focus:ring-dark-accent border-gray-300 dark:border-dark-border rounded">
                    </div>
                    <div class="ml-3 text-sm">
                        <label for="terms" class="font-medium text-gray-700 dark:text-gray-300">J'accepte les conditions d'utilisation</label>
                        <p class="text-gray-500 dark:text-gray-400">
                            Je certifie que ce document ne contient pas d'informations confidentielles ou personnelles identifiables.
                        </p>
                    </div>
                </div>
                @error('terms') <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p> @enderror
                
                <!-- Boutons -->
                <div class="flex justify-end space-x-3">
                    <a href="{{ route('documents.index') }}" class="px-4 py-2 border border-gray-300 dark:border-dark-border shadow-sm text-sm font-medium rounded-md text-gray-700 dark:text-gray-300 bg-white dark:bg-dark-surface hover:bg-gray-50 dark:hover:bg-dark-surface focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 dark:focus:ring-dark-accent dark:focus:ring-offset-dark-bg">
                        Annuler
                    </a>
                    <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-primary-600 dark:bg-dark-button hover:bg-primary-700 dark:hover:bg-dark-buttonHover focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 dark:focus:ring-dark-accent dark:focus:ring-offset-dark-bg">
                        <svg wire:loading wire:target="upload" class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Soumettre le document
                    </button>
                </div>
            </form>
        </div>
        
        <!-- Information sur les points -->
        <div class="mt-8 bg-white dark:bg-dark-surface rounded-lg shadow-md dark:shadow-lg border border-gray-200 dark:border-dark-border overflow-hidden">
            <div class="p-6 border-b border-gray-200 dark:border-dark-border">
                <h2 class="text-lg font-medium text-gray-900 dark:text-white">Comment gagner des points ?</h2>
            </div>
            
            <div class="p-6">
                <div class="prose prose-sm dark:prose-invert max-w-none">
                    <p>
                        Chaque document que vous partagez vous permet de gagner des points, selon le format :
                    </p>
                    <ul>
                        <li><strong>1 point</strong> pour chaque document PDF</li>
                        <li><strong>2 points</strong> pour chaque document Word (DOC/DOCX) ou Excel (XLS/XLSX)</li>
                    </ul>
                    <p>
                        Ces points vous permettent de télécharger des documents partagés par d'autres traducteurs. 
                        Plus vous partagez, plus vous pouvez télécharger !
                    </p>
                    <p>
                        Notez que chaque document soumis est vérifié par notre équipe avant d'être approuvé. 
                        Les points sont crédités sur votre compte une fois le document validé.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>