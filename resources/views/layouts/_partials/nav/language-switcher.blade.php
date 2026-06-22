<div class="hidden sm:flex sm:items-center sm:ms-4">
    <x-dropdown align="right" width="56" contentClasses="py-2 bg-white dark:bg-gray-700">
        <x-slot name="trigger">
            <button
                type="button"
                class="inline-flex items-center justify-center rounded-full border border-gray-200 bg-white p-2 text-gray-500 transition hover:border-gray-300 hover:text-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300 dark:hover:border-gray-500 dark:hover:text-gray-100"
                aria-label="{{ __('nav.language') }}">
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <path d="M12 2.75C6.89137 2.75 2.75 6.89137 2.75 12C2.75 17.1086 6.89137 21.25 12 21.25C17.1086 21.25 21.25 17.1086 21.25 12C21.25 6.89137 17.1086 2.75 12 2.75Z" stroke="currentColor" stroke-width="1.5"/>
                    <path d="M3.5 9.25H20.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                    <path d="M3.5 14.75H20.5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                    <path d="M12 2.75C14.0711 5.02356 15.25 8.36998 15.25 12C15.25 15.63 14.0711 18.9764 12 21.25" stroke="currentColor" stroke-width="1.5"/>
                    <path d="M12 2.75C9.92893 5.02356 8.75 8.36998 8.75 12C8.75 15.63 9.92893 18.9764 12 21.25" stroke="currentColor" stroke-width="1.5"/>
                </svg>
            </button>
        </x-slot>

        <x-slot name="content">
            <form method="POST" action="{{ route('locale.update') }}">
                @csrf
                <input type="hidden" name="locale" value="en">
                <button type="submit"
                    class="flex w-full items-center justify-between gap-3 px-4 py-2 text-left text-sm text-gray-700 transition hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-800">
                    <span class="flex min-w-0 items-center gap-3">
                        <img src="{{ asset('storage/uk-flag.png') }}" alt="" class="h-6 w-6 shrink-0 rounded-sm object-cover" aria-hidden="true">
                        <span>{{ __('nav.english') }}</span>
                    </span>
                    @if (app()->getLocale() === 'en')
                        <span class="ml-[2px] flex shrink-0 items-center">
                            <svg class="h-4 w-4 text-indigo-600 dark:text-indigo-400" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                <path d="M3 8.5L6.25 11.5L13 4.5" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </span>
                    @endif
                </button>
            </form>

            <form method="POST" action="{{ route('locale.update') }}">
                @csrf
                <input type="hidden" name="locale" value="es">
                <button type="submit"
                    class="flex w-full items-center justify-between gap-3 px-4 py-2 text-left text-sm text-gray-700 transition hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-800">
                    <span class="flex min-w-0 items-center gap-3">
                        <img src="{{ asset('storage/es-flag.png') }}" alt="" class="h-6 w-6 shrink-0 rounded-sm object-cover" aria-hidden="true">
                        <span>{{ __('nav.spanish') }}</span>
                    </span>
                    @if (app()->getLocale() === 'es')
                        <span class="ml-[2px] flex shrink-0 items-center">
                            <svg class="h-4 w-4 text-indigo-600 dark:text-indigo-400" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                <path d="M3 8.5L6.25 11.5L13 4.5" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </span>
                    @endif
                </button>
            </form>
        </x-slot>
    </x-dropdown>
</div>
