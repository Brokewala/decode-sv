<x-app-layout>
    <x-slot name="header">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Connexion</h1>
        <p class="mt-2 text-gray-600 dark:text-gray-400">
            Accédez à votre compte pour télécharger et partager des documents.
        </p>
    </x-slot>
    
    <div class="flex justify-center">
        <div class="w-full max-w-md">
            <div class="bg-white dark:bg-github-secondary rounded-lg shadow-md dark:shadow-lg border border-gray-200 dark:border-github-border overflow-hidden">
                <div class="p-6">
                    <form method="POST" action="{{ route('login.post') }}" class="space-y-6">
                        @csrf
                        
                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                Adresse email
                            </label>
                            <div class="mt-1">
                                <input id="email" name="email" type="email" autocomplete="email" required value="{{ old('email') }}"
                                       class="appearance-none block w-full px-3 py-2 border border-gray-300 dark:border-github-border rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-primary-500 dark:focus:ring-github-accent focus:border-primary-500 dark:focus:border-github-accent dark:bg-github-bg dark:text-white sm:text-sm">
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
                                <input id="password" name="password" type="password" autocomplete="current-password" required
                                       class="appearance-none block w-full px-3 py-2 border border-gray-300 dark:border-github-border rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-primary-500 dark:focus:ring-github-accent focus:border-primary-500 dark:focus:border-github-accent dark:bg-github-bg dark:text-white sm:text-sm">
                            </div>
                            @error('password')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- Remember Me -->
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <input id="remember" name="remember" type="checkbox" 
                                       class="h-4 w-4 text-primary-600 dark:text-github-accent focus:ring-primary-500 dark:focus:ring-github-accent border-gray-300 dark:border-github-border rounded dark:bg-github-bg">
                                <label for="remember" class="ml-2 block text-sm text-gray-700 dark:text-gray-300">
                                    Se souvenir de moi
                                </label>
                            </div>
                            
                            <div class="text-sm">
                                <a href="#" class="font-medium text-primary-600 dark:text-github-accent hover:text-primary-500 dark:hover:text-github-hover">
                                    Mot de passe oublié ?
                                </a>
                            </div>
                        </div>
                        
                        <div>
                            <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-primary-600 dark:bg-github-button hover:bg-primary-700 dark:hover:bg-github-buttonHover focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 dark:focus:ring-github-accent dark:focus:ring-offset-github-bg">
                                Se connecter
                            </button>
                        </div>
                    </form>
                    
                    <div class="mt-6">
                        <div class="relative">
                            <div class="absolute inset-0 flex items-center">
                                <div class="w-full border-t border-gray-300 dark:border-github-border"></div>
                            </div>
                            <div class="relative flex justify-center text-sm">
                                <span class="px-2 bg-white dark:bg-github-secondary text-gray-500 dark:text-gray-400">
                                    Ou
                                </span>
                            </div>
                        </div>
                        
                        <div class="mt-6">
                            <p class="text-center text-sm text-gray-600 dark:text-gray-400">
                                Pas encore de compte ?
                                <a href="{{ route('register') }}" class="font-medium text-primary-600 dark:text-github-accent hover:text-primary-500 dark:hover:text-github-hover">
                                    Inscrivez-vous gratuitement
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>