<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Decode SV') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 min-h-screen font-sans">
    <header class="bg-blue-600 text-white shadow-md">
        <div class="container mx-auto px-4 py-4 flex items-center justify-between">
            <a href="/" class="text-2xl font-bold">Decode SV</a>
            
            <nav class="space-x-4">
                <a href="/" class="hover:text-blue-200">Accueil</a>
                <a href="/documents" class="hover:text-blue-200">Catalogue</a>
                <a href="/documents/create" class="hover:text-blue-200">Déposer un document</a>
                <a href="/login" class="hover:text-blue-200">Connexion</a>
                <a href="/register" class="bg-white text-blue-600 px-4 py-2 rounded hover:bg-blue-100">Inscription</a>
            </nav>
        </div>
    </header>
    
    <main class="container mx-auto px-4 py-8">
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-800 mb-4">Bienvenue sur Decode SV</h1>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                La plateforme qui simplifie le travail des traducteurs en permettant l'échange de formats de documents.
            </p>
        </div>
        
        <div class="bg-white rounded-lg shadow-lg p-8 mb-12">
            <h2 class="text-2xl font-bold text-blue-600 mb-6">Comment ça marche ?</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="text-center">
                    <div class="bg-blue-100 rounded-full p-4 inline-block mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">1. Déposez vos formats</h3>
                    <p class="text-gray-600">
                        Partagez vos formats de documents et gagnez des points pour chaque contribution validée.
                    </p>
                </div>
                
                <div class="text-center">
                    <div class="bg-blue-100 rounded-full p-4 inline-block mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">2. Explorez le catalogue</h3>
                    <p class="text-gray-600">
                        Parcourez notre bibliothèque de formats classés par pays et type de document.
                    </p>
                </div>
                
                <div class="text-center">
                    <div class="bg-blue-100 rounded-full p-4 inline-block mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">3. Téléchargez facilement</h3>
                    <p class="text-gray-600">
                        Utilisez vos points pour télécharger les formats dont vous avez besoin pour vos traductions.
                    </p>
                </div>
            </div>
        </div>
        
        <div class="mb-12">
            <h2 class="text-2xl font-bold text-center mb-8">Derniers formats ajoutés</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="bg-gray-200 h-48 flex items-center justify-center">
                        <span class="text-gray-500">Aperçu</span>
                    </div>
                    <div class="p-4">
                        <h3 class="font-bold">Certificat de naissance</h3>
                        <p class="text-sm text-gray-600">France</p>
                        <div class="flex items-center justify-between mt-2">
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-yellow-500" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/>
                                </svg>
                                <span class="text-sm ml-1">4.5</span>
                            </div>
                            <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full">2 points</span>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="bg-gray-200 h-48 flex items-center justify-center">
                        <span class="text-gray-500">Aperçu</span>
                    </div>
                    <div class="p-4">
                        <h3 class="font-bold">Contrat de travail</h3>
                        <p class="text-sm text-gray-600">Italie</p>
                        <div class="flex items-center justify-between mt-2">
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-yellow-500" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/>
                                </svg>
                                <span class="text-sm ml-1">4.2</span>
                            </div>
                            <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full">1 point</span>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="bg-gray-200 h-48 flex items-center justify-center">
                        <span class="text-gray-500">Aperçu</span>
                    </div>
                    <div class="p-4">
                        <h3 class="font-bold">Diplôme universitaire</h3>
                        <p class="text-sm text-gray-600">Allemagne</p>
                        <div class="flex items-center justify-between mt-2">
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-yellow-500" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/>
                                </svg>
                                <span class="text-sm ml-1">4.7</span>
                            </div>
                            <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full">2 points</span>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="bg-gray-200 h-48 flex items-center justify-center">
                        <span class="text-gray-500">Aperçu</span>
                    </div>
                    <div class="p-4">
                        <h3 class="font-bold">Permis de conduire</h3>
                        <p class="text-sm text-gray-600">Belgique</p>
                        <div class="flex items-center justify-between mt-2">
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-yellow-500" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/>
                                </svg>
                                <span class="text-sm ml-1">4.3</span>
                            </div>
                            <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full">1 point</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="bg-blue-50 rounded-lg p-8 text-center">
            <h2 class="text-2xl font-bold text-blue-800 mb-4">Prêt à commencer ?</h2>
            <p class="text-blue-600 mb-6">
                Rejoignez notre communauté et gagnez du temps sur vos traductions dès aujourd'hui.
            </p>
            <a href="/register" class="bg-blue-600 text-white px-6 py-3 rounded-lg font-medium hover:bg-blue-700 transition duration-200">
                S'inscrire gratuitement
            </a>
        </div>
    </main>
    
    <footer class="bg-gray-800 text-white py-8">
        <div class="container mx-auto px-4">
            <div class="flex flex-wrap justify-between">
                <div class="w-full md:w-1/3 mb-6 md:mb-0">
                    <h3 class="text-xl font-bold mb-4">Decode SV</h3>
                    <p class="text-gray-400">
                        Plateforme d'échange de formats de documents pour traducteurs du monde entier.
                    </p>
                </div>
                
                <div class="w-full md:w-1/3 mb-6 md:mb-0">
                    <h3 class="text-xl font-bold mb-4">Liens rapides</h3>
                    <ul class="space-y-2">
                        <li><a href="/" class="text-gray-400 hover:text-white">Accueil</a></li>
                        <li><a href="/documents" class="text-gray-400 hover:text-white">Catalogue</a></li>
                        <li><a href="/documents/create" class="text-gray-400 hover:text-white">Déposer un document</a></li>
                        <li><a href="/contact" class="text-gray-400 hover:text-white">Contact</a></li>
                    </ul>
                </div>
                
                <div class="w-full md:w-1/3">
                    <h3 class="text-xl font-bold mb-4">Contact</h3>
                    <p class="text-gray-400">
                        Pour toute question ou suggestion, n'hésitez pas à nous contacter :
                        <br>
                        <a href="mailto:contact@decode-sv.com" class="hover:text-white">contact@decode-sv.com</a>
                    </p>
                </div>
            </div>
            
            <div class="mt-8 pt-8 border-t border-gray-700 text-center text-gray-400">
                <p>&copy; {{ date('Y') }} Decode SV. Tous droits réservés.</p>
            </div>
        </div>
    </footer>
</body>
</html>