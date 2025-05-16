<x-app-layout>
    <x-slot name="header">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Déposer un document</h1>
        <p class="mt-2 text-gray-600 dark:text-gray-400">
            Partagez vos formats de documents et gagnez des points.
        </p>
    </x-slot>
    
    <div class="max-w-3xl mx-auto">
        <div class="bg-white dark:bg-dark-surface rounded-lg shadow-md dark:shadow-lg border border-gray-200 dark:border-dark-border overflow-hidden">
            <!-- Introduction -->
            <div class="p-6 border-b border-gray-200 dark:border-dark-border">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-primary-600 dark:text-dark-accent" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h2 class="text-lg font-medium text-gray-900 dark:text-white">Comment gagner des points ?</h2>
                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                            Déposez vos formats de documents pour gagner des points. Les documents Word et Excel vous rapportent <span class="font-medium text-primary-600 dark:text-dark-accent">2 points</span>, tandis que les PDF vous rapportent <span class="font-medium text-primary-600 dark:text-dark-accent">1 point</span>.
                        </p>
                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                            Les documents sont vérifiés par nos modérateurs avant publication. Vous recevrez vos points une fois le document validé.
                        </p>
                    </div>
                </div>
            </div>
            
            <!-- Formulaire -->
            <form action="{{ route('documents.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
                @csrf
                
                <!-- Titre -->
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Titre du document <span class="text-red-600 dark:text-red-400">*</span>
                    </label>
                    <div class="mt-1">
                        <input type="text" name="title" id="title" required 
                               class="block w-full rounded-md border-gray-300 dark:border-dark-border shadow-sm focus:border-primary-500 dark:focus:border-dark-accent focus:ring-primary-500 dark:focus:ring-dark-accent dark:bg-dark-bg dark:text-white sm:text-sm"
                               placeholder="Ex: Certificat de naissance, Contrat de travail, etc.">
                    </div>
                    @error('title')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Pays -->
                <div>
                    <label for="country" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Pays d'origine <span class="text-red-600 dark:text-red-400">*</span>
                    </label>
                    <div class="mt-1">
                        <select id="country" name="country" required
                                class="block w-full rounded-md border-gray-300 dark:border-dark-border shadow-sm focus:border-primary-500 dark:focus:border-dark-accent focus:ring-primary-500 dark:focus:ring-dark-accent dark:bg-dark-bg dark:text-white sm:text-sm">
                            <option value="" selected disabled>Sélectionnez un pays</option>
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
                            <!-- Plus de pays... -->
                        </select>
                    </div>
                    @error('country')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Document -->
                <div>
                    <label for="file" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Fichier <span class="text-red-600 dark:text-red-400">*</span>
                    </label>
                    <div class="mt-1" x-data="{ fileName: '' }">
                        <div class="flex items-center justify-center w-full">
                            <label class="flex flex-col w-full h-32 border-2 border-dashed rounded-md border-gray-300 dark:border-dark-border cursor-pointer hover:bg-gray-50 dark:hover:bg-github-bg/50" x-on:dragover.prevent x-on:drop="
                                if ($event.dataTransfer.files.length > 0) {
                                    document.getElementById('file').files = $event.dataTransfer.files;
                                    fileName = $event.dataTransfer.files[0].name;
                                    updatePoints();
                                }
                            ">
                                <div class="flex flex-col items-center justify-center pt-7" x-show="!fileName">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-gray-400 dark:text-gray-500 group-hover:text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                    </svg>
                                    <p class="pt-1 text-sm tracking-wider text-gray-600 dark:text-gray-400 group-hover:text-gray-600">
                                        Glissez-déposez ou cliquez pour sélectionner
                                    </p>
                                    <p class="text-xs text-gray-500 dark:text-gray-500">
                                        Formats acceptés : PDF, Word (DOC/DOCX), Excel (XLS/XLSX)
                                    </p>
                                </div>
                                <div class="flex flex-col items-center justify-center pt-7" x-show="fileName">
                                    <p class="text-sm font-medium text-primary-600 dark:text-dark-accent" x-text="fileName"></p>
                                    <p class="text-xs text-gray-500 dark:text-gray-500 mt-1">
                                        Cliquez pour changer de fichier
                                    </p>
                                </div>
                                <input id="file" name="file" type="file" accept=".pdf,.doc,.docx,.xls,.xlsx" class="hidden" required 
                                    x-on:change="
                                        fileName = $event.target.files[0].name;
                                        updatePoints();
                                    ">
                            </label>
                        </div>
                    </div>
                    @error('file')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Description <span class="text-gray-500 dark:text-gray-400 font-normal">(optionnel)</span>
                    </label>
                    <div class="mt-1">
                        <textarea id="description" name="description" rows="4"
                                  class="block w-full rounded-md border-gray-300 dark:border-dark-border shadow-sm focus:border-primary-500 dark:focus:border-dark-accent focus:ring-primary-500 dark:focus:ring-dark-accent dark:bg-dark-bg dark:text-white sm:text-sm"
                                  placeholder="Décrivez brièvement ce document, son utilité, ses particularités..."></textarea>
                    </div>
                </div>
                
                <!-- Prix en points -->
                <div class="bg-gray-50 dark:bg-dark-bg rounded-md p-4">
                    <h3 class="font-medium text-gray-700 dark:text-gray-300">Points que vous allez gagner :</h3>
                    <div class="mt-2">
                        <div class="inline-flex items-center bg-primary-100 dark:bg-dark-surface/80 px-3 py-1.5 rounded-full">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary-600 dark:text-dark-accent mr-1.5" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z" />
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd" />
                            </svg>
                            <span id="pointsPreview" class="text-lg font-semibold text-primary-800 dark:text-primary-300">En attente du fichier...</span>
                        </div>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1.5">
                            Le nombre de points est déterminé automatiquement en fonction du format de fichier.
                        </p>
                    </div>
                </div>
                
                <!-- Conditions et bouton de soumission -->
                <div>
                    <div class="flex items-start mb-4">
                        <div class="flex-shrink-0">
                            <input id="terms" name="terms" type="checkbox" required
                                   class="h-4 w-4 rounded border-gray-300 dark:border-dark-border text-primary-600 dark:text-dark-accent focus:ring-primary-500 dark:focus:ring-dark-accent dark:bg-dark-bg">
                        </div>
                        <div class="ml-3">
                            <label for="terms" class="text-sm text-gray-600 dark:text-gray-400">
                                J'accepte que ce document soit partagé sur la plateforme et je certifie avoir les droits nécessaires pour le partager.
                            </label>
                        </div>
                    </div>
                    
                    <button type="submit" class="w-full flex justify-center items-center px-4 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-primary-600 dark:bg-dark-button hover:bg-primary-700 dark:hover:bg-dark-buttonHover focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 dark:focus:ring-dark-accent dark:focus:ring-offset-dark-bg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM6.293 6.707a1 1 0 010-1.414l3-3a1 1 0 011.414 0l3 3a1 1 0 01-1.414 1.414L11 5.414V13a1 1 0 11-2 0V5.414L7.707 6.707a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                        </svg>
                        Soumettre le document
                    </button>
                </div>
            </form>
        </div>
    </div>
    
    @push('scripts')
        <script>
            function updatePoints() {
                const fileInput = document.getElementById('file');
                const pointsPreview = document.getElementById('pointsPreview');
                
                if (fileInput && fileInput.files && fileInput.files[0]) {
                    const fileName = fileInput.files[0].name;
                    const fileExtension = fileName.split('.').pop().toLowerCase();
                    
                    let points = 0;
                    
                    if (fileExtension === 'pdf') {
                        points = 1;
                    } else if (['doc', 'docx', 'xls', 'xlsx'].includes(fileExtension)) {
                        points = 2;
                    }
                    
                    if (points > 0) {
                        pointsPreview.textContent = points + (points > 1 ? ' points' : ' point');
                    } else {
                        pointsPreview.textContent = 'Format de fichier non reconnu';
                    }
                } else {
                    pointsPreview.textContent = 'En attente du fichier...';
                }
            }
            
            document.addEventListener('DOMContentLoaded', function() {
                const fileInput = document.getElementById('file');
                
                if (fileInput) {
                    fileInput.addEventListener('change', updatePoints);
                }
            });
        </script>
    @endpush
</x-app-layout>