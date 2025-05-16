<x-app-layout>
    <x-slot name="header">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Inscription</h1>
        <p class="mt-2 text-gray-600 dark:text-gray-400">
            Rejoignez notre communauté de traducteurs et partagez vos formats de documents.
        </p>
    </x-slot>
    
    <div class="flex justify-center">
        <div class="w-full max-w-md">
            <div class="bg-white dark:bg-dark-surface rounded-lg shadow-md dark:shadow-lg border border-gray-200 dark:border-dark-border overflow-hidden">
                <div class="p-6">
                    <form method="POST" action="{{ route('register.post') }}" class="space-y-6">
                        @csrf
                        
                        <!-- Nom -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Nom complet
                            </label>
                            <div class="mt-1">
                                <input id="name" name="name" type="text" autocomplete="name" required value="{{ old('name') }}"
                                       class="appearance-none block w-full px-3 py-2 border border-gray-300 dark:border-dark-border rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-primary-500 dark:focus:ring-dark-accent focus:border-primary-500 dark:focus:border-dark-accent dark:bg-dark-bg dark:text-white sm:text-sm">
                            </div>
                            @error('name')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Adresse email
                            </label>
                            <div class="mt-1">
                                <input id="email" name="email" type="email" autocomplete="email" required value="{{ old('email') }}"
                                       class="appearance-none block w-full px-3 py-2 border border-gray-300 dark:border-dark-border rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-primary-500 dark:focus:ring-dark-accent focus:border-primary-500 dark:focus:border-dark-accent dark:bg-dark-bg dark:text-white sm:text-sm">
                            </div>
                            @error('email')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- Mot de passe -->
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Mot de passe
                            </label>
                            <div class="mt-1">
                                <input id="password" name="password" type="password" autocomplete="new-password" required
                                       class="appearance-none block w-full px-3 py-2 border border-gray-300 dark:border-dark-border rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-primary-500 dark:focus:ring-dark-accent focus:border-primary-500 dark:focus:border-dark-accent dark:bg-dark-bg dark:text-white sm:text-sm">
                            </div>
                            @error('password')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- Confirmation du mot de passe -->
                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Confirmez le mot de passe
                            </label>
                            <div class="mt-1">
                                <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" required
                                       class="appearance-none block w-full px-3 py-2 border border-gray-300 dark:border-dark-border rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-primary-500 dark:focus:ring-dark-accent focus:border-primary-500 dark:focus:border-dark-accent dark:bg-dark-bg dark:text-white sm:text-sm">
                            </div>
                        </div>
                        
                        <!-- Conditions d'utilisation -->
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <input id="terms" name="terms" type="checkbox" required
                                       class="h-4 w-4 text-primary-600 dark:text-dark-accent focus:ring-primary-500 dark:focus:ring-dark-accent border-gray-300 dark:border-dark-border rounded dark:bg-dark-bg">
                            </div>
                            <div class="ml-3">
                                <label for="terms" class="text-sm text-gray-700 dark:text-gray-300">
                                    J'accepte les <a href="#" class="text-primary-600 dark:text-dark-accent hover:text-primary-500 dark:hover:text-dark-accentHover">conditions d'utilisation</a> et la <a href="#" class="text-primary-600 dark:text-dark-accent hover:text-primary-500 dark:hover:text-dark-accentHover">politique de confidentialité</a>.
                                </label>
                            </div>
                        </div>
                        
                        <div>
                            <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-primary-600 dark:bg-dark-button hover:bg-primary-700 dark:hover:bg-dark-buttonHover focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 dark:focus:ring-dark-accent dark:focus:ring-offset-dark-bg">
                                Créer un compte
                            </button>
                        </div>
                    </form>
                    
                    <div class="mt-6">
                        <div class="relative">
                            <div class="absolute inset-0 flex items-center">
                                <div class="w-full border-t border-gray-300 dark:border-dark-border"></div>
                            </div>
                            <div class="relative flex justify-center text-sm">
                                <span class="px-2 bg-white dark:bg-dark-surface text-gray-500 dark:text-gray-400">
                                    Ou
                                </span>
                            </div>
                        </div>
                        
                        <div class="mt-6">
                            <p class="text-center text-sm text-gray-600 dark:text-gray-400">
                                Déjà inscrit ?
                                <a href="{{ route('login') }}" class="font-medium text-primary-600 dark:text-dark-accent hover:text-primary-500 dark:hover:text-dark-accentHover">
                                    Connectez-vous
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>