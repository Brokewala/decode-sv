<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? config('app.name', 'Decode SV') }}</title>
    <meta name="description" content="Plateforme d'échange de formats de documents pour traducteurs du monde entier">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Scripts et Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Livewire Styles -->
    @livewireStyles

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('favicon.ico') }}">


    <!-- Fix pour le contraste en mode clair -->
    <link rel="stylesheet" href="{{ asset('css/fix-contrast.css') }}">
</head>
<body class="flex flex-col min-h-screen font-sans antialiased text-gray-800 bg-white dark:bg-dark-bg dark:text-dark-text">
    <!-- Header -->
    <header class="sticky top-0 z-10 bg-white border-b border-gray-200 dark:bg-dark-header dark:border-dark-border">
        <div class="container px-4 mx-auto sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <!-- Logo et Navigation principale -->
                <div class="flex">
                    <div class="flex items-center flex-shrink-0">
                        <a href="/" class="text-2xl font-bold text-gray-900 dark:text-white">
                            <span class="text-primary-600 dark:text-dark-accent">Decode</span>SV
                        </a>
                    </div>
                    <nav class="items-center hidden sm:ml-6 sm:flex sm:space-x-4">
                        <a href="{{ route('home') }}" class="px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('home') ? 'text-primary-700 dark:text-dark-accent bg-primary-50 dark:bg-dark-surface' : 'text-gray-500 dark:text-gray-300 hover:text-primary-700 dark:hover:text-white hover:bg-gray-50 dark:hover:bg-dark-surface' }}">
                        {{ __('common.home') }}
                        </a>
                        <a href="{{ route('documents.index') }}" class="px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('documents.index') ? 'text-primary-700 dark:text-dark-accent bg-primary-50 dark:bg-dark-surface' : 'text-gray-500 dark:text-gray-300 hover:text-primary-700 dark:hover:text-white hover:bg-gray-50 dark:hover:bg-dark-surface' }}">
                        {{ __('common.documents') }}
                        </a>
                        <a href="{{ route('documents.create') }}" class="px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('documents.create') ? 'text-primary-700 dark:text-dark-accent bg-primary-50 dark:bg-dark-surface' : 'text-gray-500 dark:text-gray-300 hover:text-primary-700 dark:hover:text-white hover:bg-gray-50 dark:hover:bg-dark-surface' }}">
                        {{ __('common.upload') }}
                        </a>
                    </nav>
                </div>

                <!-- Actions utilisateur -->
                <div class="flex items-center space-x-3">
                    <!-- Sélecteur de langue global -->
                    <div class="hidden sm:block">
                        @include('components.language-switcher')
                    </div>

                    @auth
                        <!-- Indicateur de points -->
                        <div class="flex items-center px-3 py-1 text-sm font-medium bg-gray-100 rounded-full dark:bg-dark-surface">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-1 text-primary-600 dark:text-dark-accent" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z" />
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd" />
                            </svg>
                            <span>{{ auth()->user()->points ?? 0 }} points</span>
                        </div>

                        <!-- Menu utilisateur -->
                        <div class="relative ml-3" x-data="{ open: false }">
                            <div>
                                <button @click="open = !open" class="flex text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 dark:focus:ring-dark-accent dark:focus:ring-offset-dark-bg" id="user-menu-button">
                                    <img class="w-8 h-8 rounded-full" src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=0D8ABC&color=fff" alt="{{ auth()->user()->name }}">
                                </button>
                            </div>

                            <div x-show="open"
                                 @click.away="open = false"
                                 x-transition:enter="transition ease-out duration-100"
                                 x-transition:enter-start="transform opacity-0 scale-95"
                                 x-transition:enter-end="transform opacity-100 scale-100"
                                 x-transition:leave="transition ease-in duration-75"
                                 x-transition:leave-start="transform opacity-100 scale-100"
                                 x-transition:leave-end="transform opacity-0 scale-95"
                                 class="absolute right-0 w-48 mt-2 origin-top-right bg-white divide-y divide-gray-100 rounded-md shadow-lg dark:bg-dark-surface ring-1 ring-black ring-opacity-5 dark:divide-dark-border">
                                <div class="py-1">
                                    <a href="{{ route('documents.my') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-dark-surface">/\s+{{ __('common.nav.my_documents') }}\s+/</a>
                                    <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-dark-surface">/\s+{{ __('common.nav.profile') }}\s+/</a>
                                </div>
                                <div class="py-1">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="block w-full px-4 py-2 text-sm text-left text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-dark-surface">/\s+{{ __('common.nav.logout') }}\s+/</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="px-3 py-2 text-sm font-medium text-gray-500 dark:text-gray-300 hover:text-primary-600 dark:hover:text-dark-accent">/\s+{{ __('common.nav.login') }}\s+/</a>
                        <a href="{{ route('register') }}" class="px-4 py-2 text-sm font-medium text-white rounded-md bg-primary-600 dark:bg-dark-button hover:bg-primary-700 dark:hover:bg-dark-buttonHover">/\s+{{ __('common.nav.register') }}\s+/</a>
                    @endauth

                    <!-- Sélecteur de langue mobile -->
                    <div class="sm:hidden">
                        @include('components.language-switcher-compact')
                    </div>

                    <!-- Menu mobile (hamburger) -->
                    <div class="flex sm:hidden">
                        <button type="button" class="text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-white" id="mobile-menu-button">
                            <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Menu mobile -->
            <div class="hidden sm:hidden" id="mobile-menu">
                <div class="px-2 pt-2 pb-3 space-y-1">
                    <a href="{{ route('home') }}" class="block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('home') ? 'text-primary-700 dark:text-dark-accent bg-primary-50 dark:bg-dark-surface' : 'text-gray-500 dark:text-gray-300 hover:text-primary-700 dark:hover:text-white hover:bg-gray-50 dark:hover:bg-dark-surface' }}">/\s+{{ __('common.nav.home') }}\s+/</a>
                    <a href="{{ route('documents.index') }}" class="block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('documents.index') ? 'text-primary-700 dark:text-dark-accent bg-primary-50 dark:bg-dark-surface' : 'text-gray-500 dark:text-gray-300 hover:text-primary-700 dark:hover:text-white hover:bg-gray-50 dark:hover:bg-dark-surface' }}">/\s+{{ __('common.nav.documents') }}\s+/</a>
                    <a href="{{ route('documents.create') }}" class="block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('documents.create') ? 'text-primary-700 dark:text-dark-accent bg-primary-50 dark:bg-dark-surface' : 'text-gray-500 dark:text-gray-300 hover:text-primary-700 dark:hover:text-white hover:bg-gray-50 dark:hover:bg-dark-surface' }}">/\s+{{ __('common.nav.upload') }}\s+/</a>

                    @auth
                        <a href="{{ route('documents.my') }}" class="block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('documents.my') ? 'text-primary-700 dark:text-dark-accent bg-primary-50 dark:bg-dark-surface' : 'text-gray-500 dark:text-gray-300 hover:text-primary-700 dark:hover:text-white hover:bg-gray-50 dark:hover:bg-dark-surface' }}">/\s+{{ __('common.nav.my_documents') }}\s+/</a>
                        <a href="{{ route('profile.edit') }}" class="block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('profile.edit') ? 'text-primary-700 dark:text-dark-accent bg-primary-50 dark:bg-dark-surface' : 'text-gray-500 dark:text-gray-300 hover:text-primary-700 dark:hover:text-white hover:bg-gray-50 dark:hover:bg-dark-surface' }}">/\s+{{ __('common.nav.profile') }}\s+/</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="block w-full px-3 py-2 text-base font-medium text-left text-gray-500 rounded-md dark:text-gray-300 hover:text-primary-700 dark:hover:text-white hover:bg-gray-50 dark:hover:bg-dark-surface">/\s+{{ __('common.nav.logout') }}\s+/</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="block px-3 py-2 text-base font-medium text-gray-500 rounded-md dark:text-gray-300 hover:text-primary-700 dark:hover:text-white hover:bg-gray-50 dark:hover:bg-dark-surface">/\s+{{ __('common.nav.login') }}\s+/</a>
                        <a href="{{ route('register') }}" class="block px-3 py-2 text-base font-medium text-gray-500 rounded-md dark:text-gray-300 hover:text-primary-700 dark:hover:text-white hover:bg-gray-50 dark:hover:bg-dark-surface">/\s+{{ __('common.nav.register') }}\s+/</a>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <!-- Contenu principal -->
    <main class="flex-grow">
        @if(isset($header))
            <header class="bg-white border-b border-gray-200 shadow dark:bg-dark-header dark:border-dark-border">
                <div class="container px-4 py-6 mx-auto sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endif

        <div class="container px-4 py-8 mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div id="success-alert" class="p-4 mb-6 border-l-4 border-green-500 bg-green-50 dark:bg-green-900/20 dark:border-green-600">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="w-5 h-5 text-green-500 dark:text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-green-700 dark:text-green-400">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            @if (session('error'))
                <div id="error-alert" class="p-4 mb-6 border-l-4 border-red-500 bg-red-50 dark:bg-red-900/20 dark:border-red-600">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="w-5 h-5 text-red-500 dark:text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-red-700 dark:text-red-400">{{ session('error') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            {{ $slot }}
        </div>
    </main>

    <!-- Footer -->
    <footer class="py-8 bg-white border-t border-gray-200 dark:bg-dark-header dark:border-dark-border">
        <div class="container px-4 mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 gap-8 md:grid-cols-4">
                <div class="col-span-1 md:col-span-2">
                    <h2 class="mb-4 text-xl font-bold text-gray-900 dark:text-white">
                        <span class="text-primary-600 dark:text-dark-accent">Decode</span>SV
                    </h2>
                    <p class="mb-4 text-gray-600 dark:text-gray-400">
                        {{ __('common.footer.description') }}
                        {{ __('common.footer.subtitle') }}
                    </p>
                </div>

                <div>
                    <h3 class="mb-4 text-sm font-semibold tracking-wider text-gray-600 uppercase dark:text-gray-400">{{ __('common.footer.navigation') }}</h3>
                    <ul class="space-y-2">
                        <li>
                            <a href="{{ route('home') }}" class="text-gray-600 dark:text-gray-400 hover:text-primary-600 dark:hover:text-dark-accent">{{ __('common.nav.home') }}</a>
                        </li>
                        <li>
                            <a href="{{ route('documents.index') }}" class="text-gray-600 dark:text-gray-400 hover:text-primary-600 dark:hover:text-dark-accent">{{ __('common.nav.documents') }}</a>
                        </li>
                        <li>
                            <a href="{{ route('documents.create') }}" class="text-gray-600 dark:text-gray-400 hover:text-primary-600 dark:hover:text-dark-accent">{{ __('common.nav.upload') }}</a>
                        </li>
                    </ul>
                </div>

                <div>
                    <h3 class="mb-4 text-sm font-semibold tracking-wider text-gray-600 uppercase dark:text-gray-400">{{ __('common.footer.contact') }}</h3>
                    <ul class="space-y-2">
                        <li>
                            <a href="#" class="text-gray-600 dark:text-gray-400 hover:text-primary-600 dark:hover:text-dark-accent">{{ __('common.footer.about') }}</a>
                        </li>
                        <li>
                            <a href="#" class="text-gray-600 dark:text-gray-400 hover:text-primary-600 dark:hover:text-dark-accent">{{ __('common.footer.legal') }}</a>
                        </li>
                        <li>
                            <a href="mailto:contact@decode-sv.com" class="text-gray-600 dark:text-gray-400 hover:text-primary-600 dark:hover:text-dark-accent">
                                contact@decode-sv.com
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="flex flex-col pt-8 mt-8 border-t border-gray-200 dark:border-dark-border md:flex-row md:justify-between md:items-center">
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    &copy; {{ date('Y') }} Decode SV. {{ __('common.footer.copyright') }}
                </p>
                <div class="flex mt-4 space-x-6 md:mt-0">
                    <a href="#" class="text-gray-500 dark:text-gray-400 hover:text-primary-600 dark:hover:text-dark-accent">
                        <span class="sr-only">Facebook</span>
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd" />
                        </svg>
                    </a>
                    <a href="#" class="text-gray-500 dark:text-gray-400 hover:text-primary-600 dark:hover:text-dark-accent">
                        <span class="sr-only">Twitter</span>
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84" />
                        </svg>
                    </a>
                    <a href="#" class="text-gray-500 dark:text-gray-400 hover:text-primary-600 dark:hover:text-dark-accent">
                        <span class="sr-only">LinkedIn</span>
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path fill-rule="evenodd" d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z" clip-rule="evenodd" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Script pour le menu mobile et les alertes -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            const mobileMenu = document.getElementById('mobile-menu');

            // Menu mobile
            if (mobileMenuButton && mobileMenu) {
                mobileMenuButton.addEventListener('click', function() {
                    mobileMenu.classList.toggle('hidden');
                });
            }

            // Auto-disparition des alertes
            const successAlert = document.getElementById('success-alert');
            const errorAlert = document.getElementById('error-alert');

            if (successAlert) {
                setTimeout(function() {
                    successAlert.style.opacity = '0';
                    successAlert.style.transition = 'opacity 1s ease';
                    setTimeout(function() {
                        successAlert.style.display = 'none';
                    }, 1000);
                }, 5000);
            }

            if (errorAlert) {
                setTimeout(function() {
                    errorAlert.style.opacity = '0';
                    errorAlert.style.transition = 'opacity 1s ease';
                    setTimeout(function() {
                        errorAlert.style.display = 'none';
                    }, 1000);
                }, 5000);
            }
        });
    </script>

    <!-- Scripts supplémentaires -->
    @stack('scripts')

    <!-- Livewire Scripts -->
    @livewireScripts
</body>
</html>
