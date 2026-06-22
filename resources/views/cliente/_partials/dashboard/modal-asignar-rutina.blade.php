{{-- MODAL ASIGNAR/CAMBIAR RUTINA --}}
@component('components.modal', ['name' => 'asignarRutinaModal-' . $user->id, 'maxWidth' => '2xl'])
<div class="p-6">
    <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
        <div>
            <h2 class="text-lg font-medium mb-2 text-gray-900 dark:text-white">
                {{ $rutinaAsignada ? __('views.change_routine') : __('views.assign_routine') }}
            </h2>
            <p class="text-sm text-gray-600 dark:text-gray-300">
                {{ __('views.select_routine_for_client', ['name' => $user->name]) }}
            </p>
        </div>

        <a href="{{ route('rutinas.create') }}" class="inline-flex shrink-0 items-center justify-center rounded-lg bg-white px-4 py-2 text-sm font-semibold text-gray-800 ring-1 ring-gray-300 transition hover:bg-gray-50 dark:bg-gray-800 dark:text-gray-100 dark:ring-gray-600 dark:hover:bg-gray-700">
            {{ __('views.create_new_routine') }}
        </a>
    </div>

    @if($rutinaAsignada)
        <p class="mt-3 rounded-lg bg-amber-50 px-4 py-3 text-sm text-amber-800 ring-1 ring-amber-200 dark:bg-amber-950/30 dark:text-amber-300 dark:ring-amber-800">
            {{ __('views.replace_current_routine_notice') }}
        </p>
    @endif

    @if($rutinasDisponibles->isEmpty())
        <div class="mt-6 rounded-lg border border-dashed border-gray-300 bg-gray-50 p-5 text-sm text-gray-600 dark:border-gray-600 dark:bg-gray-900/60 dark:text-gray-300">
            {{ __('views.no_routines_available_to_assign') }}
        </div>

        <div class="mt-6 flex justify-center gap-4">
            <a href="{{ route('rutinas.create') }}" class="rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-indigo-700">
                {{ __('views.create_new_routine') }}
            </a>
            <button type="button" class="rounded-lg bg-gray-200 px-4 py-2 text-sm font-semibold text-gray-800 transition hover:bg-gray-300 dark:bg-gray-700 dark:text-gray-100 dark:hover:bg-gray-600"
                @click="$dispatch('close-modal', 'asignarRutinaModal-{{ $user->id }}')">
                {{ __('views.cancel') }}
            </button>
        </div>
    @else
        <form method="POST" action="{{ route('clientes.rutina.asignar', $user->id) }}"
            @submit="$dispatch('close-modal', 'asignarRutinaModal-{{ $user->id }}')">
            @csrf
            @method('PATCH')

            <div class="mt-6">
                @component('components.list-search', [
                    'id' => 'buscar_rutinas_asignables_' . $user->id,
                    'target' => 'rutinas_asignables_' . $user->id,
                    'placeholder' => __('views.search_by_name'),
                ])
                @endcomponent
            </div>

            <div id="rutinas_asignables_{{ $user->id }}" class="mt-4 max-h-96 space-y-3 overflow-y-auto pr-1">
                @foreach($rutinasDisponibles as $rutina)
                    <label data-search-item data-search-text="{{ \Illuminate\Support\Str::lower($rutina->nombre) }}" class="flex cursor-pointer gap-3 rounded-lg border border-gray-200 p-4 transition hover:bg-gray-50 dark:border-gray-700 dark:hover:bg-gray-900">
                        <input type="radio" name="rutina_id" value="{{ $rutina->id }}"
                            class="mt-1 border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                            @checked($rutinaAsignada?->id === $rutina->id || (!$rutinaAsignada && $loop->first)) required>
                        <span class="min-w-0 flex-1">
                            <span class="block text-sm font-semibold text-gray-900 dark:text-gray-100">{{ $rutina->nombre }}</span>
                            <span class="mt-1 block text-sm text-gray-600 dark:text-gray-300">{{ $rutina->descripcion ?? __('views.no_description') }}</span>
                            <span class="mt-3 flex flex-wrap gap-2 text-xs font-medium text-gray-500 dark:text-gray-400">
                                <span>{{ __('views.days') }}: {{ $rutina->dias_entreno ?? '--' }}</span>
                                <span>{{ __('views.duration') }}: {{ $rutina->duracion_aproximada_min ?? '--' }} min</span>
                            </span>
                        </span>
                    </label>
                @endforeach
            </div>

            <div class="mt-6 flex justify-center gap-4">
                <button type="submit" class="rounded-lg bg-emerald-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-emerald-700">
                    {{ __('views.assign_selected_routine') }}
                </button>
                <button type="button" class="rounded-lg bg-gray-200 px-4 py-2 text-sm font-semibold text-gray-800 transition hover:bg-gray-300 dark:bg-gray-700 dark:text-gray-100 dark:hover:bg-gray-600"
                    @click="$dispatch('close-modal', 'asignarRutinaModal-{{ $user->id }}')">
                    {{ __('views.cancel') }}
                </button>
            </div>
        </form>
    @endif
</div>
@endcomponent
