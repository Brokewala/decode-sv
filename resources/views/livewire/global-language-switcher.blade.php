<div class="relative group">
    @if($isCompact)
        <!-- Version compacte pour mobile -->
        <button wire:click="switchLanguage"
                class="inline-flex items-center justify-center p-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition duration-200 shadow-sm"
                title="{{ $this->getNextLanguageData()['name'] }}">
            <span class="text-lg">{{ $this->getCurrentLanguageData()['flag'] }}</span>
            <span class="ml-1 text-xs font-medium">{{ $this->getCurrentLanguageData()['short'] }}</span>
        </button>
    @else
        <!-- Version complète pour desktop -->
        <button wire:click="switchLanguage"
                class="inline-flex items-center px-4 py-2 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all duration-200 shadow-sm hover:shadow-md transform hover:scale-105"
                title="{{ __('common.switch_to') }} {{ $this->getNextLanguageData()['name'] }}">

            <!-- Langue actuelle -->
            <div class="flex items-center">
                <span class="text-lg mr-2">{{ $this->getCurrentLanguageData()['flag'] }}</span>
                <span class="font-medium text-sm">{{ $this->getCurrentLanguageData()['name'] }}</span>
            </div>

            <!-- Icône de switch -->
            <svg class="ml-3 h-4 w-4 text-gray-400 group-hover:text-gray-600 dark:group-hover:text-gray-300 transition-colors duration-200"
                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
            </svg>

            <!-- Langue suivante (preview) -->
            <div class="flex items-center ml-2 opacity-60 group-hover:opacity-100 transition-opacity duration-200">
                <span class="text-sm mr-1">{{ $this->getNextLanguageData()['flag'] }}</span>
                <span class="text-xs font-medium">{{ $this->getNextLanguageData()['short'] }}</span>
            </div>
        </button>
    @endif

    <!-- Loading indicator -->
    <div wire:loading wire:target="switchLanguage"
         class="absolute inset-0 bg-white dark:bg-gray-800 bg-opacity-75 rounded-xl flex items-center justify-center">
        <div class="flex items-center space-x-2">
            <svg class="animate-spin h-4 w-4 text-indigo-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <span class="text-xs text-gray-600 dark:text-gray-400">
                {{ $currentLanguage === 'fr' ? 'Changement...' : 'Switching...' }}
            </span>
        </div>
    </div>

    <!-- Tooltip informatif (optionnel) -->
    <div class="hidden group-hover:block absolute top-full left-1/2 transform -translate-x-1/2 mt-2 z-50">
        <div class="bg-gray-900 text-white text-xs rounded-lg px-3 py-2 whitespace-nowrap">
            {{ __('common.click_to_switch') }} {{ $this->getNextLanguageData()['name'] }}
            <div class="absolute -top-1 left-1/2 transform -translate-x-1/2 w-2 h-2 bg-gray-900 rotate-45"></div>
        </div>
    </div>
</div>
