<x-app-layout>
    <x-slot name="header">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Contact</h1>
        <p class="mt-2 text-gray-600 dark:text-gray-400">
            Nous sommes à votre écoute pour toute question ou suggestion.
        </p>
    </x-slot>
    
    <div class="max-w-3xl mx-auto">
        <div class="bg-white dark:bg-dark-surface rounded-lg shadow-md dark:shadow-lg border border-gray-200 dark:border-dark-border overflow-hidden">
            <div class="p-6 border-b border-gray-200 dark:border-dark-border">
                <h2 class="text-lg font-medium text-gray-900 dark:text-white">Formulaire de contact</h2>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    Utilisez ce formulaire pour nous envoyer un message. Nous vous répondrons dans les plus brefs délais.
                </p>
            </div>
            
            <div class="p-6 space-y-6">
                <form action="#" method="POST" class="space-y-6">
                    @csrf
                    
                    <!-- Nom -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Nom
                        </label>
                        <div class="mt-1">
                            <input id="name" name="name" type="text" required
                                   class="block w-full rounded-md border-gray-300 dark:border-dark-border shadow-sm focus:border-primary-500 dark:focus:border-dark-accent focus:ring-primary-500 dark:focus:ring-dark-accent dark:bg-dark-bg dark:text-white sm:text-sm">
                        </div>
                    </div>
                    
                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Adresse email
                        </label>
                        <div class="mt-1">
                            <input id="email" name="email" type="email" required
                                   class="block w-full rounded-md border-gray-300 dark:border-dark-border shadow-sm focus:border-primary-500 dark:focus:border-dark-accent focus:ring-primary-500 dark:focus:ring-dark-accent dark:bg-dark-bg dark:text-white sm:text-sm">
                        </div>
                    </div>
                    
                    <!-- Sujet -->
                    <div>
                        <label for="subject" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Sujet
                        </label>
                        <div class="mt-1">
                            <input id="subject" name="subject" type="text" required
                                   class="block w-full rounded-md border-gray-300 dark:border-dark-border shadow-sm focus:border-primary-500 dark:focus:border-dark-accent focus:ring-primary-500 dark:focus:ring-dark-accent dark:bg-dark-bg dark:text-white sm:text-sm">
                        </div>
                    </div>
                    
                    <!-- Message -->
                    <div>
                        <label for="message" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                            Message
                        </label>
                        <div class="mt-1">
                            <textarea id="message" name="message" rows="6" required
                                      class="block w-full rounded-md border-gray-300 dark:border-dark-border shadow-sm focus:border-primary-500 dark:focus:border-dark-accent focus:ring-primary-500 dark:focus:ring-dark-accent dark:bg-dark-bg dark:text-white sm:text-sm"></textarea>
                        </div>
                    </div>
                    
                    <div>
                        <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-primary-600 dark:bg-dark-button hover:bg-primary-700 dark:hover:bg-dark-buttonHover focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 dark:focus:ring-dark-accent dark:focus:ring-offset-dark-bg">
                            Envoyer le message
                        </button>
                    </div>
                </form>
            </div>
        </div>
        
        <div class="mt-8 bg-white dark:bg-dark-surface rounded-lg shadow-md dark:shadow-lg border border-gray-200 dark:border-dark-border overflow-hidden">
            <div class="p-6 border-b border-gray-200 dark:border-dark-border">
                <h2 class="text-lg font-medium text-gray-900 dark:text-white">Informations de contact</h2>
            </div>
            
            <div class="p-6 space-y-4">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-primary-600 dark:text-dark-accent" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-gray-900 dark:text-white">Email</h3>
                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                            <a href="mailto:contact@decode-sv.com" class="text-primary-600 dark:text-dark-accent hover:text-primary-500 dark:hover:text-dark-accentHover">
                                contact@decode-sv.com
                            </a>
                        </p>
                    </div>
                </div>
                
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-primary-600 dark:text-dark-accent" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-gray-900 dark:text-white">Assistance</h3>
                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                            Notre équipe d'assistance est disponible du lundi au vendredi, de 9h à 18h (CET).
                        </p>
                    </div>
                </div>
                
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-primary-600 dark:text-dark-accent" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-gray-900 dark:text-white">Réseaux sociaux</h3>
                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                            Suivez-nous sur les réseaux sociaux pour rester informé des dernières actualités.
                        </p>
                        <div class="mt-2 flex space-x-4">
                            <a href="#" class="text-gray-500 dark:text-gray-400 hover:text-primary-600 dark:hover:text-dark-accent">
                                <span class="sr-only">Facebook</span>
                                <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd" />
                                </svg>
                            </a>
                            <a href="#" class="text-gray-500 dark:text-gray-400 hover:text-primary-600 dark:hover:text-dark-accent">
                                <span class="sr-only">Twitter</span>
                                <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84" />
                                </svg>
                            </a>
                            <a href="#" class="text-gray-500 dark:text-gray-400 hover:text-primary-600 dark:hover:text-dark-accent">
                                <span class="sr-only">LinkedIn</span>
                                <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z" clip-rule="evenodd" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>