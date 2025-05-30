@php
    $currentLang = app()->getLocale();
    $languages = [
        'fr' => [
            'name' => __('common.languages.french'),
            'short' => 'FR',
            'flag' => '🇫🇷',
            'code' => 'fr'
        ],
        'en' => [
            'name' => __('common.languages.english'),
            'short' => 'EN',
            'flag' => '🇺🇸',
            'code' => 'en'
        ]
    ];
    $currentLanguage = $languages[$currentLang];
    $nextLang = $currentLang === 'fr' ? 'en' : 'fr';
    $nextLanguage = $languages[$nextLang];
@endphp

<div class="relative group">
    <!-- Bouton switch de langue -->
    <a href="{{ request()->fullUrlWithQuery(['lang' => $nextLang]) }}" 
       class="inline-flex items-center px-4 py-2 rounded-xl border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all duration-200 shadow-sm hover:shadow-md transform hover:scale-105"
       title="{{ __('common.switch_to') }} {{ $nextLanguage['name'] }}">
        
        <!-- Langue actuelle -->
        <div class="flex items-center">
            <span class="text-lg mr-2">{{ $currentLanguage['flag'] }}</span>
            <span class="font-medium text-sm">{{ $currentLanguage['name'] }}</span>
        </div>
        
        <!-- Icône de switch -->
        <svg class="ml-3 h-4 w-4 text-gray-400 group-hover:text-gray-600 dark:group-hover:text-gray-300 transition-colors duration-200" 
             fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                  d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
        </svg>
        
        <!-- Langue suivante (preview) -->
        <div class="flex items-center ml-2 opacity-60 group-hover:opacity-100 transition-opacity duration-200">
            <span class="text-sm mr-1">{{ $nextLanguage['flag'] }}</span>
            <span class="text-xs font-medium">{{ $nextLanguage['short'] }}</span>
        </div>
    </a>

    <!-- Tooltip informatif -->
    <div class="hidden group-hover:block absolute top-full left-1/2 transform -translate-x-1/2 mt-2 z-50">
        <div class="bg-gray-900 text-white text-xs rounded-lg px-3 py-2 whitespace-nowrap">
            {{ __('common.click_to_switch') }} {{ $nextLanguage['name'] }}
            <div class="absolute -top-1 left-1/2 transform -translate-x-1/2 w-2 h-2 bg-gray-900 rotate-45"></div>
        </div>
    </div>
</div>
