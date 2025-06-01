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

    <!-- Améliorations responsive du header -->
    <link rel="stylesheet" href="{{ asset('css/header-responsive.css') }}">
</head>
<body class="flex flex-col min-h-screen font-sans antialiased text-gray-800 bg-white dark:bg-dark-bg dark:text-dark-text">
    <!-- Header -->
    <header class="sticky top-0 z-50 bg-white border-b border-gray-200 header-container dark:bg-dark-header dark:border-dark-border">
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
                        @auth
                            @if(auth()->user()->is_admin)
                                <a href="{{ route('admin.dashboard') }}" class="px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('admin.*') ? 'text-red-700 dark:text-red-400 bg-red-50 dark:bg-red-900/20' : 'text-red-600 dark:text-red-400 hover:text-red-700 dark:hover:text-red-300 hover:bg-red-50 dark:hover:bg-red-900/20' }}">
                                    <div class="flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z" clip-rule="evenodd" />
                                        </svg>
                                        {{ __('common.nav.admin') }}
                                    </div>
                                </a>
                            @endif
                        @endauth
                    </nav>
                </div>

                <!-- Actions utilisateur -->
                <div class="flex items-center space-x-2 header-actions sm:space-x-3">
                    <!-- Sélecteur de langue global (desktop) -->
                    <div class="hidden sm:block" @click.stop>
                        @include('components.language-switcher')
                    </div>

                    @auth
                        <!-- Indicateur de points (masqué sur très petits écrans) -->
                        <div class="items-center hidden px-2 py-1 text-xs font-medium bg-gray-100 rounded-full points-indicator md:flex sm:px-3 sm:text-sm dark:bg-dark-surface">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 mr-1 sm:w-4 sm:h-4 text-primary-600 dark:text-dark-accent" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z" />
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd" />
                            </svg>
                            <span class="whitespace-nowrap">{{ auth()->user()->points ?? 0 }} points</span>
                        </div>

                        <!-- Menu utilisateur -->
                        <div class="relative ml-1 sm:ml-3" x-data="{ open: false }" @click.away="open = false" @keydown.escape="open = false">
                            <div>
                                <button @click="open = !open" class="flex text-sm transition-all duration-200 rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 dark:focus:ring-dark-accent dark:focus:ring-offset-dark-bg" id="user-menu-button" :aria-expanded="open" aria-haspopup="true">
                                    <img class="transition-colors duration-200 border-2 border-transparent rounded-full w-7 h-7 sm:w-8 sm:h-8 hover:border-primary-300 dark:hover:border-dark-accent" src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=0D8ABC&color=fff" alt="{{ auth()->user()->name }}">
                                </button>
                            </div>
                            <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="transform opacity-0 scale-95 translate-y-1" x-transition:enter-end="transform opacity-100 scale-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="transform opacity-100 scale-100 translate-y-0" x-transition:leave-end="transform opacity-0 scale-95 translate-y-1" class="absolute right-0 top-full z-[9999] w-52 mt-2 origin-top-right bg-white divide-y divide-gray-100 rounded-lg shadow-lg user-menu-dropdown dropdown-menu dark:bg-dark-surface ring-1 ring-black ring-opacity-5 dark:divide-dark-border border border-gray-200 dark:border-dark-border" style="z-index: 9999 !important;" id="user-menu-dropdown">
                                <div class="py-1">
                                    <a href="{{ route('documents.my') }}" class="flex items-center px-4 py-2 text-sm font-medium text-gray-700 transition-colors duration-200 dark:text-gray-200 hover:bg-primary-50 dark:hover:bg-dark-surface hover:text-primary-600 dark:hover:text-dark-accent">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                        {{ __('common.nav.my_documents') }}
                                    </a>
                                    <a href="{{ route('profile.edit') }}" class="flex items-center px-4 py-2 text-sm font-medium text-gray-700 transition-colors duration-200 dark:text-gray-200 hover:bg-primary-50 dark:hover:bg-dark-surface hover:text-primary-600 dark:hover:text-dark-accent">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                        {{ __('common.nav.profile') }}
                                    </a>
                                    @if(auth()->user()->is_admin)
                                        <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-2 text-sm font-medium text-red-600 transition-colors duration-200 admin-link dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 hover:text-red-700 dark:hover:text-red-300">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-3" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z" clip-rule="evenodd" />
                                            </svg>
                                            {{ __('common.nav.admin') }}
                                        </a>
                                    @endif
                                </div>
                                <div class="py-1">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="flex items-center w-full px-4 py-2 text-sm font-medium text-left text-gray-700 transition-colors duration-200 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-dark-surface hover:text-gray-900 dark:hover:text-white">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                            </svg>
                                            {{ __('common.nav.logout') }}
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @else
                        <!-- Boutons auth pour desktop -->
                        <div class="hidden sm:flex sm:items-center sm:space-x-3">
                            <a href="{{ route('login') }}" class="px-3 py-2 text-sm font-medium text-gray-500 transition-colors duration-200 dark:text-gray-300 hover:text-primary-600 dark:hover:text-dark-accent">{{ __('common.nav.login') }}</a>
                            <a href="{{ route('register') }}" class="px-4 py-2 text-sm font-medium text-white transition-colors duration-200 rounded-md bg-primary-600 dark:bg-dark-button hover:bg-primary-700 dark:hover:bg-dark-buttonHover">{{ __('common.nav.register') }}</a>
                        </div>
                    @endauth

                    <!-- Section mobile (sélecteur langue + hamburger) -->
                    <div class="flex items-center space-x-2 sm:hidden">
                        <!-- Sélecteur de langue mobile -->
                        <div @click.stop>
                            @include('components.language-switcher-compact')
                        </div>

                        <!-- Menu mobile (hamburger) -->
                        <button type="button" class="p-2 text-gray-500 transition-colors duration-200 rounded-md mobile-button header-interactive dark:text-gray-400 hover:text-gray-700 dark:hover:text-white focus:outline-none focus:ring-2 focus:ring-primary-500 dark:focus:ring-dark-accent" id="mobile-menu-button" aria-label="Menu mobile" aria-expanded="false">
                            <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Menu mobile -->
            <div class="hidden mobile-menu sm:hidden" id="mobile-menu">
                <div class="px-2 pt-2 pb-3 space-y-1">
                    <a href="{{ route('home') }}" class="block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('home') ? 'text-primary-700 dark:text-dark-accent bg-primary-50 dark:bg-dark-surface' : 'text-gray-500 dark:text-gray-300 hover:text-primary-700 dark:hover:text-white hover:bg-gray-50 dark:hover:bg-dark-surface' }}">{{ __('common.nav.home') }}</a>
                    <a href="{{ route('documents.index') }}" class="block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('documents.index') ? 'text-primary-700 dark:text-dark-accent bg-primary-50 dark:bg-dark-surface' : 'text-gray-500 dark:text-gray-300 hover:text-primary-700 dark:hover:text-white hover:bg-gray-50 dark:hover:bg-dark-surface' }}">{{ __('common.nav.documents') }}</a>
                    <a href="{{ route('documents.create') }}" class="block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('documents.create') ? 'text-primary-700 dark:text-dark-accent bg-primary-50 dark:bg-dark-surface' : 'text-gray-500 dark:text-gray-300 hover:text-primary-700 dark:hover:text-white hover:bg-gray-50 dark:hover:bg-dark-surface' }}">{{ __('common.nav.upload') }}</a>
                    @auth
                        <a href="{{ route('documents.my') }}" class="block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('documents.my') ? 'text-primary-700 dark:text-dark-accent bg-primary-50 dark:bg-dark-surface' : 'text-gray-500 dark:text-gray-300 hover:text-primary-700 dark:hover:text-white hover:bg-gray-50 dark:hover:bg-dark-surface' }}">{{ __('common.nav.my_documents') }}</a>
                        <a href="{{ route('profile.edit') }}" class="block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('profile.edit') ? 'text-primary-700 dark:text-dark-accent bg-primary-50 dark:bg-dark-surface' : 'text-gray-500 dark:text-gray-300 hover:text-primary-700 dark:hover:text-white hover:bg-gray-50 dark:hover:bg-dark-surface' }}">{{ __('common.nav.profile') }}</a>
                        @if(auth()->user()->is_admin)
                            <a href="{{ route('admin.dashboard') }}" class="block px-3 py-2 rounded-md text-base font-medium {{ request()->routeIs('admin.*') ? 'text-red-700 dark:text-red-400 bg-red-50 dark:bg-red-900/20' : 'text-red-600 dark:text-red-400 hover:text-red-700 dark:hover:text-red-300 hover:bg-red-50 dark:hover:bg-red-900/20' }}">
                                <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z" clip-rule="evenodd" />
                                    </svg>
                                    {{ __('common.nav.admin') }}
                                </div>
                            </a>
                        @endif
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="block w-full px-3 py-2 text-base font-medium text-left text-gray-500 rounded-md dark:text-gray-300 hover:text-primary-700 dark:hover:text-white hover:bg-gray-50 dark:hover:bg-dark-surface">{{ __('common.nav.logout') }}</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="block px-3 py-2 text-base font-medium text-gray-500 rounded-md dark:text-gray-300 hover:text-primary-700 dark:hover:text-white hover:bg-gray-50 dark:hover:bg-dark-surface">{{ __('common.nav.login') }}</a>
                        <a href="{{ route('register') }}" class="block px-3 py-2 text-base font-medium text-gray-500 rounded-md dark:text-gray-300 hover:text-primary-700 dark:hover:text-white hover:bg-gray-50 dark:hover:bg-dark-surface">{{ __('common.nav.register') }}</a>
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
            </div>
        </div>
    </footer>

    <!-- Script pour le menu mobile et les alertes -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            const mobileMenu = document.getElementById('mobile-menu');

            // S'assurer que tous les menus sont fermés au chargement
            if (mobileMenu) {
                mobileMenu.classList.add('hidden');
            }

            // Debug Alpine.js
            console.log('Alpine.js loaded:', typeof window.Alpine !== 'undefined');

            // Vérifier que le menu utilisateur fonctionne
            const userMenuButton = document.getElementById('user-menu-button');
            const userMenuDropdown = document.getElementById('user-menu-dropdown');

            if (userMenuButton) {
                console.log('User menu button found:', userMenuButton);

                // Ajouter un listener de debug
                userMenuButton.addEventListener('click', function(e) {
                    console.log('User menu button clicked!', e);

                    // S'assurer que le menu a le z-index optimal
                    if (userMenuDropdown) {
                        userMenuDropdown.style.zIndex = '9999';
                        console.log('Menu z-index set to:', userMenuDropdown.style.zIndex);
                        console.log('Menu position: relative to button');
                    }
                });
            }

            // Menu mobile avec isolation des événements
            if (mobileMenuButton && mobileMenu) {
                mobileMenuButton.addEventListener('click', function(event) {
                    event.stopPropagation();
                    event.preventDefault();
                    mobileMenu.classList.toggle('hidden');

                    // Mettre à jour l'attribut aria-expanded
                    const isExpanded = !mobileMenu.classList.contains('hidden');
                    mobileMenuButton.setAttribute('aria-expanded', isExpanded);
                });

                // Fermer le menu mobile en cliquant ailleurs
                document.addEventListener('click', function(event) {
                    if (!mobileMenuButton.contains(event.target) && !mobileMenu.contains(event.target)) {
                        mobileMenu.classList.add('hidden');
                        mobileMenuButton.setAttribute('aria-expanded', 'false');
                    }
                });

                // Fermer le menu mobile avec la touche Escape
                document.addEventListener('keydown', function(event) {
                    if (event.key === 'Escape' && !mobileMenu.classList.contains('hidden')) {
                        mobileMenu.classList.add('hidden');
                        mobileMenuButton.setAttribute('aria-expanded', 'false');
                        mobileMenuButton.focus();
                    }
                });
            }

            // Isolation complète des sélecteurs de langue
            const languageSwitchers = document.querySelectorAll('.language-switcher-link, .language-switcher-link-mobile');
            languageSwitchers.forEach(function(switcher) {
                // Empêcher tous les événements de se propager
                switcher.addEventListener('click', function(event) {
                    event.stopPropagation();
                    event.stopImmediatePropagation();
                    console.log('Language switcher clicked, navigating to:', event.target.href);
                    // Permettre la navigation normale
                    return true;
                });

                // Empêcher aussi les événements mousedown et mouseup
                switcher.addEventListener('mousedown', function(event) {
                    event.stopPropagation();
                });

                switcher.addEventListener('mouseup', function(event) {
                    event.stopPropagation();
                });
            });

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
