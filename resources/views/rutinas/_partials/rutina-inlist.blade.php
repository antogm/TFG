<li
    data-search-item data-search-text="{{ strtolower($rutina->nombre) }}"
    class="flex flex-col border-b border-gray-200 pb-4 pt-2 last:border-b-0 sm:flex-row sm:items-center sm:justify-between">

    {{-- INFO --}}
    <div>
        <p class="text-lg font-medium text-gray-900 dark:text-gray-100">
            <span>{{ __('views.routine_list_name') }} </span>{{ $rutina->nombre }}
        </p>
        <p class="text-sm text-gray-600 dark:text-gray-300">
            <span>{{ __('views.training_days') }} </span>{{ $rutina->dias_entreno }}
        </p>
        <p class="text-sm text-gray-600 dark:text-gray-300">
            <span>{{ __('views.approx_duration_per_day') }} </span>{{ $rutina->duracion_aproximada_min }}
        </p>
        <p class="text-sm text-gray-600 dark:text-gray-300">
            <span>{{ __('views.assigned_clients') }} </span>{{ $rutina->numero_clientes_asignados }}
        </p>
    </div>

    {{-- ACCIONES --}}
    <div class="mt-4 flex flex-wrap gap-3 sm:mt-0">
        <a href="{{ route('rutinas.get', $rutina->id) }}"
            class="inline-flex items-center rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-300 focus:ring-offset-2 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-200 dark:hover:bg-gray-700 dark:focus:ring-offset-gray-800">
            {{ __('views.details') }}
        </a>

        @if($rol === 'entrenador')
            <a href="{{ route('rutinas.edit', $rutina->id) }}"
                class="inline-flex items-center rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-300 focus:ring-offset-2 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-200 dark:hover:bg-gray-700 dark:focus:ring-offset-gray-800">
                {{ __('views.edit_routine') }}
            </a>

            <button type="button"
                class="inline-flex items-center rounded-lg border border-emerald-300 bg-emerald-50 px-4 py-2 text-sm font-medium text-emerald-700 transition hover:bg-emerald-100 focus:outline-none focus:ring-2 focus:ring-emerald-400 focus:ring-offset-2 dark:border-emerald-700 dark:bg-emerald-950/30 dark:text-emerald-300 dark:hover:bg-emerald-950/50 dark:focus:ring-offset-gray-800"
                x-data x-on:click="$dispatch('open-modal', 'asignarClientesRutinaModal-{{ $rutina->id }}')">
                {{ __('views.assign') }}
            </button>

            <form method="POST" action="{{ route('rutinas.delete', $rutina->id) }}"
                onsubmit="return confirm('{{ __('views.confirm_delete_routine') }}');">
                @csrf
                @method('DELETE')
                <button type="submit"
                    class="inline-flex items-center rounded-lg bg-red-600 px-4 py-2 text-sm font-medium text-white transition hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800">
                    {{ __('views.delete_routine') }}
                </button>
            </form>
        @endif
    </div>

    @if($rol === 'entrenador')
        @include('rutinas._partials.modal-asignar-clientes-rutina', ['rutina' => $rutina, 'clientesSinRutina' => $clientesSinRutina])
    @endif
</li>
