<div class="relative">
    <div class="relative inline-block text-left" x-data="{ open: false }">
        <!-- Bouton du sélecteur -->
        <div>
            <button @click="open = !open"
                    type="button"
                    class="inline-flex items-center justify-center w-full px-4 py-2 text-sm font-medium text-gray-700 transition duration-150 ease-in-out bg-white border border-gray-300 rounded-md shadow-sm dark:border-gray-600 dark:bg-gray-800 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    id="language-menu"
                    aria-expanded="true"
                    aria-haspopup="true">

                <!-- Langue actuelle -->
                <span class="mr-2 text-lg">{{ $availableLanguages[$currentLanguage]['flag'] }}</span>
                <span class="hidden sm:inline">{{ $availableLanguages[$currentLanguage]['name'] }}</span>
                <span class="sm:hidden">{{ strtoupper($currentLanguage) }}</span>

                <!-- Icône flèche -->
                <svg class="w-5 h-5 ml-2 -mr-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
            </button>
        </div>

        <!-- Menu déroulant -->
        <div x-show="open"
             @click.away="open = false"
             x-transition:enter="transition ease-out duration-100"
             x-transition:enter-start="transform opacity-0 scale-95"
             x-transition:enter-end="transform opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-75"
             x-transition:leave-start="transform opacity-100 scale-100"
             x-transition:leave-end="transform opacity-0 scale-95"
             class="absolute right-0 z-50 w-48 mt-2 origin-top-right bg-white rounded-md shadow-lg dark:bg-gray-800 ring-1 ring-black ring-opacity-5 focus:outline-none"
             role="menu"
             aria-orientation="vertical"
             aria-labelledby="language-menu">

            <div class="py-1" role="none">
                @foreach($availableLanguages as $code => $language)
                    <button wire:click="switchLanguage('{{ $code }}')"
                            @click="open = false"
                            class="group flex items-center w-full px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white transition duration-150 ease-in-out {{ $currentLanguage === $code ? 'bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-white' : '' }}"
                            role="menuitem">

                        <!-- Drapeau -->
                        <span class="mr-3 text-lg">{{ $language['flag'] }}</span>

                        <!-- Nom de la langue -->
                        <span class="flex-1 text-left">{{ $language['name'] }}</span>

                        <!-- Indicateur de langue active -->
                        @if($currentLanguage === $code)
                            <svg class="w-4 h-4 ml-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        @endif
                    </button>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Loading indicator -->
    <div wire:loading wire:target="switchLanguage" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
        <div class="flex items-center p-6 space-x-3 bg-white rounded-lg dark:bg-gray-800">
            <svg class="w-5 h-5 text-indigo-600 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <span class="text-gray-700 dark:text-gray-200">
                {{ $currentLanguage === 'fr' ? 'Changement de langue...' : 'Changing language...' }}
            </span>
        </div>
    </div>
</div>
