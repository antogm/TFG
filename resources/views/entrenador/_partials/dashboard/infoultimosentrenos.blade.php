<div class="w-full rounded-xl border-l-4 border-indigo-500 bg-white p-8 shadow-sm dark:bg-gray-800">
    <h2 class="mb-2 text-2xl font-bold text-gray-900 dark:text-gray-100">
        {{ __('views.latest_client_workouts') }}
    </h2>

    <p class="mb-6 text-sm text-gray-600 dark:text-gray-300">
        {{ __('views.latest_client_workouts_intro') }}
    </p>

    <div class="space-y-3">
        @forelse ($ultimosEntrenosClientes as $entreno)
            <div class="grid gap-3 rounded-lg bg-gray-50 px-4 py-3 dark:bg-gray-700/50 md:grid-cols-[minmax(0,1.2fr)_minmax(0,1fr)_auto] md:items-center md:gap-4">
                <p class="truncate font-medium text-gray-900 dark:text-gray-100">{{ $entreno['cliente'] }}</p>
                <p class="truncate text-sm text-gray-600 dark:text-gray-300">{{ $entreno['entreno'] }}</p>
                <p class="text-sm text-gray-600 dark:text-gray-300">{{ $entreno['fecha'] }}</p>
            </div>
        @empty
            <div class="rounded-lg border border-dashed border-gray-300 bg-gray-50 px-4 py-6 text-sm text-gray-600 dark:border-gray-600 dark:bg-gray-900/20 dark:text-gray-300">
                {{ __('views.no_workout_registers_available') }}
            </div>
        @endforelse
    </div>
</div>
