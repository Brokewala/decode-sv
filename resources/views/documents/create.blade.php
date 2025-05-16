<x-app-layout>
    <x-slot name="header">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Déposer un document</h1>
        <p class="mt-2 text-gray-600 dark:text-gray-400">
            Partagez vos formats de documents et gagnez des points pour télécharger ceux des autres.
        </p>
    </x-slot>
    
    @livewire('document-upload')
</x-app-layout>