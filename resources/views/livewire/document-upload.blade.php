<div>
    <div class="max-w-3xl mx-auto">
        <!-- Formulaire principal -->
        <div class="overflow-hidden bg-white border border-gray-200 rounded-lg shadow-md dark:bg-dark-surface dark:shadow-lg dark:border-dark-border">
            <div class="p-6 border-b border-gray-200 dark:border-dark-border">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white">{{ __('public.upload.title') }}</h2>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    {{ __('public.upload.subtitle') }}
                </p>
            </div>

            <form wire:submit.prevent="submit" class="p-6 space-y-6">
                <!-- Titre -->
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        {{ __('public.upload.form_title') }}
                    </label>
                    <div class="mt-1">
                        <input type="text" id="title" wire:model.defer="title"
                            class="block w-full border-gray-300 rounded-md shadow-sm dark:border-dark-border focus:border-primary-500 dark:focus:border-dark-accent focus:ring-primary-500 dark:focus:ring-dark-accent dark:bg-dark-bg dark:text-white sm:text-sm"
                            placeholder="{{ __('public.upload.title_placeholder') }}">
                    </div>
                    @error('title')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Pays -->
                <div>
                    <label for="country" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        {{ __('public.upload.form_country') }}
                    </label>
                    <div class="mt-1">
                        <select id="country" wire:model.defer="country"
                            class="block w-full border-gray-300 rounded-md shadow-sm dark:border-dark-border focus:border-primary-500 dark:focus:border-dark-accent focus:ring-primary-500 dark:focus:ring-dark-accent dark:bg-dark-bg dark:text-white sm:text-sm">
                            <option value="">{{ __('public.upload.select_country') }}</option>
                            <option value="international">{{ __('public.upload.countries.international') }}</option>
                            <option value="france">{{ __('public.upload.countries.france') }}</option>
                            <option value="allemagne">{{ __('public.upload.countries.germany') }}</option>
                            <option value="belgique">{{ __('public.upload.countries.belgium') }}</option>
                            <option value="suisse">{{ __('public.upload.countries.switzerland') }}</option>
                            <option value="italie">{{ __('public.upload.countries.italy') }}</option>
                            <option value="espagne">{{ __('public.upload.countries.spain') }}</option>
                            <option value="royaume-uni">{{ __('public.upload.countries.uk') }}</option>
                            <option value="canada">{{ __('public.upload.countries.canada') }}</option>
                            <option value="etats-unis">{{ __('public.upload.countries.usa') }}</option>
                        </select>
                    </div>
                    @error('country')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Fichier -->
                <div>
                    <label for="file" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        {{ __('public.upload.document_label') }}
                    </label>
                    <div class="flex justify-center px-6 pt-5 pb-6 mt-1 border-2 border-gray-300 border-dashed rounded-md dark:border-dark-border">
                        <div class="space-y-1 text-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 mx-auto text-gray-400 dark:text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <div class="flex text-sm text-gray-600 dark:text-gray-400">
                                <label for="file" class="relative font-medium bg-white rounded-md cursor-pointer dark:bg-dark-surface text-primary-600 dark:text-dark-accent hover:text-primary-500 dark:hover:text-dark-accentHover focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-primary-500 dark:focus-within:ring-dark-accent dark:focus-within:ring-offset-dark-bg">
                                    <span>{{ __('public.upload.select_file') }}</span>
                                    <input id="file" wire:model="file" type="file" class="sr-only" accept=".pdf,.doc,.docx,.xls,.xlsx">
                                </label>
                                <p class="pl-1">{{ __('public.upload.or_drag_drop') }}</p>
                            </div>
                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                {{ __('public.upload.file_requirements') }}
                            </p>
                        </div>
                    </div>
                    @error('file')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror

                    @if ($file)
                        <div class="flex items-center mt-3 space-x-3">
                            <div class="inline-flex items-center justify-center flex-shrink-0 w-10 h-10 rounded bg-primary-100 dark:bg-primary-900/20 text-primary-600 dark:text-primary-400">
                                @php
                                    $ext = strtolower($file->getClientOriginalExtension());
                                    $icon = match($ext) {
                                        'pdf' => '<svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd" /></svg>',
                                        'doc', 'docx' => '<svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd" /></svg>',
                                        'xls', 'xlsx' => '<svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd" /></svg>',
                                        default => '<svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd" /></svg>'
                                    };
                                @endphp
                                {!! $icon !!}
                            </div>
                            <div class="flex items-center justify-between flex-1">
                                <div>
                                    <p class="text-sm font-medium text-gray-900 dark:text-white">
                                        {{ $file->getClientOriginalName() }}
                                    </p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">
                                        {{ number_format($file->getSize() / 1024 / 1024, 2) }} {{ __('public.upload.mb') }}
                                    </p>
                                </div>
                                <button type="button" wire:click="$set('file', null)" class="text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        {{ __('public.upload.form_description') }}
                    </label>
                    <div class="mt-1">
                        <textarea id="description" wire:model.defer="description" rows="4"
                            class="block w-full border-gray-300 rounded-md shadow-sm dark:border-dark-border focus:border-primary-500 dark:focus:border-dark-accent focus:ring-primary-500 dark:focus:ring-dark-accent dark:bg-dark-bg dark:text-white sm:text-sm"
                            placeholder="{{ __('public.upload.description_placeholder') }}"></textarea>
                    </div>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Termes et conditions -->
                <div class="relative flex items-start">
                    <div class="flex items-center h-5">
                        <input id="terms" wire:model.defer="terms" type="checkbox"
                            class="w-4 h-4 border-gray-300 rounded text-primary-600 dark:text-dark-accent focus:ring-primary-500 dark:focus:ring-dark-accent dark:border-dark-border">
                    </div>
                    <div class="ml-3 text-sm">
                        <label for="terms" class="font-medium text-gray-700 dark:text-gray-300">
                            {{ __('public.upload.accept_terms') }}
                        </label>
                        <p class="text-gray-500 dark:text-gray-400">
                            {{ __('public.upload.terms_description') }}
                        </p>
                    </div>
                </div>
                @error('terms')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror

                <!-- Boutons -->
                <div class="flex justify-end space-x-3">
                    <a href="{{ route('documents.index') }}"
                        class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm dark:border-dark-border dark:text-gray-300 dark:bg-dark-surface hover:bg-gray-50 dark:hover:bg-dark-surface focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 dark:focus:ring-dark-accent dark:focus:ring-offset-dark-bg">
                        {{ __('common.cancel') }}
                    </a>
                    <button type="submit"
                        class="inline-flex justify-center px-4 py-2 text-sm font-medium text-white border border-transparent rounded-md shadow-sm bg-primary-600 dark:bg-dark-button hover:bg-primary-700 dark:hover:bg-dark-buttonHover focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 dark:focus:ring-dark-accent dark:focus:ring-offset-dark-bg">
                        <svg wire:loading wire:target="submit" class="w-4 h-4 mr-2 -ml-1 text-white animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        {{ __('public.upload.submit') }}
                    </button>
                </div>
            </form>
        </div>

        <!-- Information sur les points -->
        <div class="mt-8 overflow-hidden bg-white border border-gray-200 rounded-lg shadow-md dark:bg-dark-surface dark:shadow-lg dark:border-dark-border">
            <div class="p-6 border-b border-gray-200 dark:border-dark-border">
                <h2 class="text-lg font-medium text-gray-900 dark:text-white">{{ __('public.upload.points_info.title') }}</h2>
            </div>
            <div class="p-6">
                <div class="prose-sm prose dark:prose-invert max-w-none">
                    <p>{{ __('public.upload.points_info.description') }}</p>
                    <ul>
                        <li>{{ __('public.upload.points_info.pdf_points') }}</li>
                        <li>{{ __('public.upload.points_info.office_points') }}</li>
                    </ul>
                    <p>{{ __('public.upload.points_info.usage') }}</p>
                    <p>{{ __('public.upload.points_info.verification') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>