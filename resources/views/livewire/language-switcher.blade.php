<div class="relative" x-data="{ open: false }">
    <!-- Bouton du sélecteur de langue -->
    <button @click="open = !open" 
            class="flex items-center space-x-2 px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white transition-colors duration-200">
        <!-- Icône globe -->
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                  d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9v-3a5 5 0 00-5-5 5 5 0 00-5 5v3m9-9a9 9 0 00-9-9"></path>
        </svg>
        
        <!-- Langue actuelle -->
        <span>{{ $availableLocales[$currentLocale] ?? 'Français' }}</span>
        
        <!-- Icône flèche -->
        <svg class="w-4 h-4 transition-transform duration-200" 
             :class="{ 'rotate-180': open }" 
             fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
        </svg>
    </button>

    <!-- Menu déroulant -->
    <div x-show="open" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-75"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         @click.away="open = false"
         class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-md shadow-lg ring-1 ring-black ring-opacity-5 z-50">
        
        <div class="py-1">
            @foreach($availableLocales as $locale => $name)
                <button wire:click="switchLanguage('{{ $locale }}')"
                        @click="open = false"
                        class="flex items-center w-full px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-200 {{ $currentLocale === $locale ? 'bg-gray-50 dark:bg-gray-700 font-medium' : '' }}">
                    
                    <!-- Flag ou icône pour chaque langue -->
                    @if($locale === 'fr')
                        <span class="mr-3 text-lg">🇫🇷</span>
                    @elseif($locale === 'en')
                        <span class="mr-3 text-lg">🇬🇧</span>
                    @endif
                    
                    <span>{{ $name }}</span>
                    
                    <!-- Indicateur de langue active -->
                    @if($currentLocale === $locale)
                        <svg class="ml-auto w-4 h-4 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                    @endif
                </button>
            @endforeach
        </div>
    </div>
</div>
