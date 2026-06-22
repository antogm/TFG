<div class="w-full rounded-xl border-l-4 border-red-500 bg-white p-8 shadow-sm dark:bg-gray-800">
    <h2 class="mb-2 text-2xl font-bold text-gray-900 dark:text-gray-100">
        {{ __('views.clients_without_routine_count', ['count' => $clientesSinRutina->count()]) }}
    </h2>

    <p class="mb-6 text-sm text-gray-600 dark:text-gray-300">
        {{ $clientesSinRutina->isEmpty() ? __('views.clients_without_routine_empty') : __('views.clients_without_routine_hint') }}
    </p>

    @if ($clientesSinRutina->isNotEmpty())
        <div class="space-y-3">
            @foreach ($clientesSinRutina->take(5) as $cliente)
                <div class="flex items-center justify-between gap-4 rounded-lg bg-gray-50 px-4 py-3 dark:bg-gray-700/50">
                    <div class="min-w-0">
                        <p class="truncate font-medium text-gray-900 dark:text-gray-100">{{ $cliente->name }}</p>
                        <p class="truncate text-sm text-gray-600 dark:text-gray-300">{{ $cliente->email }}</p>
                    </div>

                    <a href="{{ route('usuario.progreso', $cliente->id) }}"
                        class="inline-flex shrink-0 items-center rounded-lg bg-red-600 px-3 py-2 text-sm font-medium text-white transition hover:bg-red-700">
                        {{ __('views.review_progress') }}
                    </a>
                </div>
            @endforeach
        </div>
    @endif
</div>
