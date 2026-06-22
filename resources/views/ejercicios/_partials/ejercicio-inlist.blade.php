<li data-search-item data-search-text="{{ strtolower($ejercicio->nombre) }}" class="flex flex-col gap-4 border-b border-gray-200 pt-3 pb-4 last:border-b-0 sm:flex-row sm:items-stretch sm:justify-between">

    {{-- INFO --}}
    <div class="flex min-w-0 flex-1 gap-4">
        @if ($ejercicio->imagen)
            <div class="relative min-h-24 w-24 shrink-0 overflow-hidden rounded-lg bg-gray-100 dark:bg-gray-900 sm:w-28">
                <img src="{{ Storage::url($ejercicio->imagen) }}" alt="{{ $ejercicio->nombre }}"
                    class="absolute inset-0 h-full w-full object-cover">
            </div>
        @endif

        <div class="min-w-0">
            <p class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ $ejercicio->nombre }}
            </p>
            <p class="text-gray-600 dark:text-gray-300 text-sm">
                {{ $ejercicio->descripcion }}
            </p>
            <p class="text-gray-400 dark:text-gray-500 text-sm">
                {{ $ejercicio->gruposMusculares->pluck('nombre')->join(', ') ?: __('views.no_muscle_groups') }}
            </p>
            <p class="text-gray-600 dark:text-gray-300 text-sm">
                @if ($ejercicio->link_youtube)
                    <a href="{{ $ejercicio->link_youtube }}" target="_blank" rel="noopener noreferrer"
                        class="text-emerald-600 hover:text-emerald-700 dark:text-emerald-400 dark:hover:text-emerald-300">
                        {{ __('views.watch_video') }}
                    </a>
                @endif
            </p>
        </div>
    </div>

    {{-- ACCIONES --}}
    <div class="flex shrink-0 gap-3 sm:items-center">
        <a href="{{ route('ejercicios.ver', $ejercicio->id) }}"
            class="inline-flex items-center px-4 py-2 text-sm font-medium rounded-lg border border-gray-300 bg-white text-gray-700 transition hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-300 focus:ring-offset-2 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-200 dark:hover:bg-gray-700 dark:focus:ring-offset-gray-800">
            {{ __('views.details') }}
        </a>
        @if($rol === 'entrenador')
            <a href="{{ route('ejercicios.edit', $ejercicio->id) }}"
                class="inline-flex items-center px-4 py-2 text-sm font-medium rounded-lg border border-gray-300 bg-white text-gray-700 transition hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-300 focus:ring-offset-2 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-200 dark:hover:bg-gray-700 dark:focus:ring-offset-gray-800">
                {{ __('views.edit_exercise') }}
            </a>
        @endif
    </div>
</li>
