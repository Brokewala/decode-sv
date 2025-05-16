<x-app-layout>
    <x-slot name="header">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Catalogue de documents</h1>
        <p class="mt-2 text-gray-600 dark:text-gray-400">
            Parcourez notre bibliothèque de formats classés par pays et type de document.
        </p>
    </x-slot>
    
    @livewire('documents-list')
</x-app-layout>