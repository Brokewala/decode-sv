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

<!-- Sélecteur de langue desktop - Version isolée -->
<div class="relative language-switcher-container">
    <a href="{{ request()->fullUrlWithQuery(['lang' => $nextLang]) }}"
       class="language-switcher-link inline-flex items-center px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-primary-500 dark:focus:ring-dark-accent transition-all duration-200 shadow-sm"
       title="{{ __('common.switch_to') }} {{ $nextLanguage['name'] }}"
       data-lang="{{ $nextLang }}"
       onclick="event.stopPropagation(); event.stopImmediatePropagation(); return true;">

        <!-- Langue actuelle -->
        <span class="text-base mr-2">{{ $currentLanguage['flag'] }}</span>
        <span class="font-medium text-sm">{{ $currentLanguage['short'] }}</span>

        <!-- Icône de switch -->
        <svg class="ml-2 h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
        </svg>

        <!-- Langue suivante -->
        <span class="text-sm ml-2 opacity-60">{{ $nextLanguage['flag'] }}</span>
    </a>
</div>
