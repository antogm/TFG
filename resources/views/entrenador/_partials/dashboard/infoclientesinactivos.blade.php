<div class="w-full rounded-xl border-l-4 border-orange-500 bg-white p-8 shadow-sm dark:bg-gray-800">
    <h2 class="mb-2 text-2xl font-bold text-gray-900 dark:text-gray-100">
        {{ __('views.inactive_clients_count', ['count' => $clientesInactivos->count()]) }}
    </h2>

    <p class="mb-6 text-sm text-gray-600 dark:text-gray-300">
        {{ $clientesInactivos->isEmpty() ? __('views.inactive_clients_empty') : __('views.inactive_clients_hint') }}
    </p>

    @if ($clientesInactivos->isNotEmpty())
        <div class="space-y-3">
            @foreach ($clientesInactivos->take(5) as $item)
                <div class="flex items-center justify-between gap-4 rounded-lg bg-gray-50 px-4 py-3 dark:bg-gray-700/50">
                    <div class="min-w-0">
                        <p class="truncate font-medium text-gray-900 dark:text-gray-100">{{ $item['cliente']->name }}</p>
                        <p class="truncate text-sm text-gray-600 dark:text-gray-300">
                            {{ __('views.last_activity') }}:
                            {{ $item['ultimaActividad'] ? $item['ultimaActividad']->format('d/m/Y') : __('views.no_activity_logged') }}
                        </p>
                    </div>

                    <a href="{{ route('usuario.progreso', $item['cliente']->id) }}"
                        class="inline-flex shrink-0 items-center rounded-lg bg-orange-500 px-3 py-2 text-sm font-medium text-white transition hover:bg-orange-600">
                        {{ __('views.review_progress') }}
                    </a>
                </div>
            @endforeach
        </div>
    @endif
</div>
