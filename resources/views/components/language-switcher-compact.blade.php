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

<!-- Sélecteur de langue mobile - Version compacte isolée -->
<a href="{{ request()->fullUrlWithQuery(['lang' => $nextLang]) }}"
   class="language-switcher-link-mobile inline-flex items-center justify-center p-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-primary-500 dark:focus:ring-dark-accent transition duration-200 shadow-sm"
   title="{{ __('common.switch_to') }} {{ $nextLanguage['name'] }}"
   data-lang="{{ $nextLang }}"
   onclick="event.stopPropagation(); event.stopImmediatePropagation(); return true;">

    <span class="text-lg">{{ $currentLanguage['flag'] }}</span>
    <span class="ml-1 text-xs font-medium">{{ $currentLanguage['short'] }}</span>
</a>
