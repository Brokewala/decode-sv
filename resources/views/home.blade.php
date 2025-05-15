<x-app-layout>
    <x-slot name="header">
        <div class="text-center py-8">
            <h1 class="text-4xl font-bold text-gray-900 dark:text-white mb-4">Bienvenue sur Decode SV</h1>
            <p class="text-xl text-gray-600 dark:text-gray-400 max-w-3xl mx-auto">
                La plateforme qui simplifie le travail des traducteurs en permettant l'échange de formats de documents.
            </p>
        </div>
    </x-slot>
    
    <!-- Section Comment ça marche -->
    <section class="mb-16">
        <div class="bg-white dark:bg-github-secondary rounded-lg shadow-md dark:shadow-lg border border-gray-200 dark:border-github-border overflow-hidden">
            <div class="px-6 py-8">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 mr-2 text-primary-600 dark:text-github-accent" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                    </svg>
                    Comment ça marche ?
                </h2>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="rounded-lg border border-gray-200 dark:border-github-border bg-gray-50 dark:bg-github-bg p-6">
                        <div class="bg-primary-100 dark:bg-github-secondary rounded-full p-3 inline-flex items-center justify-center mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-primary-600 dark:text-github-accent" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold mb-2 text-gray-900 dark:text-white">1. Déposez vos formats</h3>
                        <p class="text-gray-600 dark:text-gray-400">
                            Partagez vos formats de documents et gagnez des points pour chaque contribution validée par nos modérateurs.
                        </p>
                    </div>
                    
                    <div class="rounded-lg border border-gray-200 dark:border-github-border bg-gray-50 dark:bg-github-bg p-6">
                        <div class="bg-primary-100 dark:bg-github-secondary rounded-full p-3 inline-flex items-center justify-center mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-primary-600 dark:text-github-accent" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold mb-2 text-gray-900 dark:text-white">2. Explorez le catalogue</h3>
                        <p class="text-gray-600 dark:text-gray-400">
                            Parcourez notre bibliothèque de formats classés par pays et type de document avec des aperçus.
                        </p>
                    </div>
                    
                    <div class="rounded-lg border border-gray-200 dark:border-github-border bg-gray-50 dark:bg-github-bg p-6">
                        <div class="bg-primary-100 dark:bg-github-secondary rounded-full p-3 inline-flex items-center justify-center mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-primary-600 dark:text-github-accent" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold mb-2 text-gray-900 dark:text-white">3. Téléchargez facilement</h3>
                        <p class="text-gray-600 dark:text-gray-400">
                            Utilisez vos points pour télécharger les formats dont vous avez besoin pour vos traductions.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Section Derniers formats ajoutés -->
    <section class="mb-16">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 mr-2 text-primary-600 dark:text-github-accent" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                Derniers formats ajoutés
            </h2>
            <a href="{{ route('documents.index') }}" class="text-primary-600 dark:text-github-accent hover:text-primary-700 dark:hover:text-github-hover flex items-center">
                Voir tout
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
            </a>
        </div>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Document 1 -->
            <div class="bg-white dark:bg-github-secondary rounded-lg shadow-md dark:shadow-lg border border-gray-200 dark:border-github-border overflow-hidden transition duration-200 hover:shadow-lg dark:hover:border-github-accent/30">
                <div class="h-48 bg-gray-200 dark:bg-gray-800 relative">
                    <!-- Aperçu du document (image) -->
                    <div class="absolute inset-0 flex items-center justify-center text-gray-500 dark:text-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 opacity-50" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    
                    <!-- Badge du type de document -->
                    <div class="absolute top-2 right-2">
                        <span class="bg-gray-800 dark:bg-gray-900 text-white text-xs font-medium px-2.5 py-1 rounded-full">PDF</span>
                    </div>
                </div>
                
                <div class="p-4">
                    <h3 class="font-semibold text-gray-900 dark:text-white text-lg mb-1 truncate">Certificat de naissance</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">France</p>
                    
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-yellow-500" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/>
                            </svg>
                            <span class="text-sm ml-1 text-gray-700 dark:text-gray-300">4.5</span>
                            <span class="text-xs ml-1 text-gray-500 dark:text-gray-400">(12)</span>
                        </div>
                        <span class="inline-flex items-center bg-primary-100 dark:bg-primary-900/20 text-primary-800 dark:text-primary-300 text-xs font-medium px-2.5 py-1 rounded-full">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z" />
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd" />
                            </svg>
                            1 point
                        </span>
                    </div>
                </div>
            </div>
            
            <!-- Document 2 -->
            <div class="bg-white dark:bg-github-secondary rounded-lg shadow-md dark:shadow-lg border border-gray-200 dark:border-github-border overflow-hidden transition duration-200 hover:shadow-lg dark:hover:border-github-accent/30">
                <div class="h-48 bg-gray-200 dark:bg-gray-800 relative">
                    <div class="absolute inset-0 flex items-center justify-center text-gray-500 dark:text-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 opacity-50" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <div class="absolute top-2 right-2">
                        <span class="bg-blue-700 dark:bg-blue-900 text-white text-xs font-medium px-2.5 py-1 rounded-full">DOCX</span>
                    </div>
                </div>
                
                <div class="p-4">
                    <h3 class="font-semibold text-gray-900 dark:text-white text-lg mb-1 truncate">Contrat de travail</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">Italie</p>
                    
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-yellow-500" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/>
                            </svg>
                            <span class="text-sm ml-1 text-gray-700 dark:text-gray-300">4.2</span>
                            <span class="text-xs ml-1 text-gray-500 dark:text-gray-400">(8)</span>
                        </div>
                        <span class="inline-flex items-center bg-primary-100 dark:bg-primary-900/20 text-primary-800 dark:text-primary-300 text-xs font-medium px-2.5 py-1 rounded-full">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z" />
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd" />
                            </svg>
                            2 points
                        </span>
                    </div>
                </div>
            </div>
            
            <!-- Document 3 -->
            <div class="bg-white dark:bg-github-secondary rounded-lg shadow-md dark:shadow-lg border border-gray-200 dark:border-github-border overflow-hidden transition duration-200 hover:shadow-lg dark:hover:border-github-accent/30">
                <div class="h-48 bg-gray-200 dark:bg-gray-800 relative">
                    <div class="absolute inset-0 flex items-center justify-center text-gray-500 dark:text-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 opacity-50" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <div class="absolute top-2 right-2">
                        <span class="bg-gray-800 dark:bg-gray-900 text-white text-xs font-medium px-2.5 py-1 rounded-full">PDF</span>
                    </div>
                </div>
                
                <div class="p-4">
                    <h3 class="font-semibold text-gray-900 dark:text-white text-lg mb-1 truncate">Diplôme universitaire</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">Allemagne</p>
                    
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-yellow-500" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/>
                            </svg>
                            <span class="text-sm ml-1 text-gray-700 dark:text-gray-300">4.7</span>
                            <span class="text-xs ml-1 text-gray-500 dark:text-gray-400">(21)</span>
                        </div>
                        <span class="inline-flex items-center bg-primary-100 dark:bg-primary-900/20 text-primary-800 dark:text-primary-300 text-xs font-medium px-2.5 py-1 rounded-full">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z" />
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd" />
                            </svg>
                            1 point
                        </span>
                    </div>
                </div>
            </div>
            
            <!-- Document 4 -->
            <div class="bg-white dark:bg-github-secondary rounded-lg shadow-md dark:shadow-lg border border-gray-200 dark:border-github-border overflow-hidden transition duration-200 hover:shadow-lg dark:hover:border-github-accent/30">
                <div class="h-48 bg-gray-200 dark:bg-gray-800 relative">
                    <div class="absolute inset-0 flex items-center justify-center text-gray-500 dark:text-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 opacity-50" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <div class="absolute top-2 right-2">
                        <span class="bg-green-700 dark:bg-green-900 text-white text-xs font-medium px-2.5 py-1 rounded-full">XLSX</span>
                    </div>
                </div>
                
                <div class="p-4">
                    <h3 class="font-semibold text-gray-900 dark:text-white text-lg mb-1 truncate">Permis de conduire</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">Belgique</p>
                    
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-yellow-500" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/>
                            </svg>
                            <span class="text-sm ml-1 text-gray-700 dark:text-gray-300">4.3</span>
                            <span class="text-xs ml-1 text-gray-500 dark:text-gray-400">(16)</span>
                        </div>
                        <span class="inline-flex items-center bg-primary-100 dark:bg-primary-900/20 text-primary-800 dark:text-primary-300 text-xs font-medium px-2.5 py-1 rounded-full">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z" />
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd" />
                            </svg>
                            2 points
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Section Call to Action -->
    <section>
        <div class="bg-gradient-to-br from-primary-600 to-primary-700 dark:from-github-accent dark:to-github-hover rounded-lg shadow-md dark:shadow-lg p-8 text-white">
            <div class="text-center max-w-2xl mx-auto">
                <h2 class="text-2xl font-bold mb-4">Prêt à commencer ?</h2>
                <p class="mb-6 text-lg text-primary-100 dark:text-gray-300">
                    Rejoignez notre communauté et gagnez du temps sur vos traductions dès aujourd'hui.
                </p>
                <div class="flex flex-col sm:flex-row justify-center space-y-3 sm:space-y-0 sm:space-x-4">
                    <a href="{{ route('register') }}" class="bg-white hover:bg-gray-100 text-primary-700 dark:text-github-bg px-6 py-3 rounded-md font-medium transition-colors duration-200">
                        S'inscrire gratuitement
                    </a>
                    <a href="{{ route('documents.index') }}" class="bg-primary-700/30 hover:bg-primary-700/50 dark:bg-github-bg/20 dark:hover:bg-github-bg/30 text-white px-6 py-3 border border-primary-500/30 dark:border-github-accent/30 rounded-md font-medium transition-colors duration-200">
                        Explorer le catalogue
                    </a>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>