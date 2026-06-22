<div class="border-t border-gray-200 px-4 py-3 dark:border-gray-600">
    <p class="text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">
        {{ __('nav.language') }}
    </p>

    <div class="mt-3 space-y-2">
        <form method="POST" action="{{ route('locale.update') }}">
            @csrf
            <input type="hidden" name="locale" value="en">
            <button type="submit"
                class="flex w-full items-center justify-between rounded-lg border border-gray-200 px-3 py-2 text-sm text-gray-700 transition hover:bg-gray-100 dark:border-gray-600 dark:text-gray-200 dark:hover:bg-gray-800">
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
                class="flex w-full items-center justify-between rounded-lg border border-gray-200 px-3 py-2 text-sm text-gray-700 transition hover:bg-gray-100 dark:border-gray-600 dark:text-gray-200 dark:hover:bg-gray-800">
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
    </div>
</div>
