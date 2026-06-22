@php
    $clientesAsignados = $rutina->clientesAsignados->sortBy('name')->values();
@endphp

@component('components.modal', ['name' => 'asignarClientesRutinaModal-' . $rutina->id, 'maxWidth' => '2xl'])
<div class="p-6">
    <div class="flex flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
        <div>
            <h2 class="mb-2 text-lg font-medium text-gray-900 dark:text-white">
                {{ __('views.assign_clients_to_routine', ['name' => $rutina->nombre]) }}
            </h2>
            <p class="text-sm text-gray-600 dark:text-gray-300">
                {{ __('views.assign_clients_to_routine_intro') }}
            </p>
        </div>
    </div>

    @if($clientesAsignados->isEmpty() && $clientesSinRutina->isEmpty())
        <div class="mt-6 rounded-lg border border-dashed border-gray-300 bg-gray-50 p-5 text-sm text-gray-600 dark:border-gray-600 dark:bg-gray-900/60 dark:text-gray-300">
            {{ __('views.no_clients_available_for_routine') }}
        </div>

        <div class="mt-6 flex justify-center">
            <button type="button" class="rounded-lg bg-gray-200 px-4 py-2 text-sm font-semibold text-gray-800 transition hover:bg-gray-300 dark:bg-gray-700 dark:text-gray-100 dark:hover:bg-gray-600"
                @click="$dispatch('close-modal', 'asignarClientesRutinaModal-{{ $rutina->id }}')">
                {{ __('views.cancel') }}
            </button>
        </div>
    @else
        <form method="POST" action="{{ route('rutinas.clientes.asignar', $rutina->id) }}"
            @submit="$dispatch('close-modal', 'asignarClientesRutinaModal-{{ $rutina->id }}')">
            @csrf
            @method('PATCH')

            <div class="mt-6">
                @component('components.list-search', [
                    'id' => 'buscar_clientes_rutina_' . $rutina->id,
                    'target' => 'clientes_rutina_' . $rutina->id,
                    'placeholder' => __('views.search_by_name'),
                ])
                @endcomponent
            </div>

            <div id="clientes_rutina_{{ $rutina->id }}" class="mt-4 max-h-96 space-y-5 overflow-y-auto pr-1">
                @if($clientesAsignados->isNotEmpty())
                    <section>
                        <h3 class="mb-3 text-sm font-semibold text-gray-900 dark:text-gray-100">
                            {{ __('views.currently_assigned_clients') }}
                        </h3>

                        <div class="space-y-3">
                            @foreach($clientesAsignados as $cliente)
                                <label data-search-item data-search-text="{{ \Illuminate\Support\Str::lower($cliente->name . ' ' . $cliente->email) }}" class="flex cursor-pointer gap-3 rounded-lg border border-gray-200 p-4 transition hover:bg-gray-50 dark:border-gray-700 dark:hover:bg-gray-900">
                                    <input type="checkbox" name="clientes[]" value="{{ $cliente->id }}"
                                        class="mt-1 rounded border-gray-300 text-emerald-600 shadow-sm focus:ring-emerald-500"
                                        checked>
                                    <span class="min-w-0 flex-1">
                                        <span class="block text-sm font-semibold text-gray-900 dark:text-gray-100">{{ $cliente->name }}</span>
                                        <span class="mt-1 block text-sm text-gray-600 dark:text-gray-300">{{ $cliente->email }}</span>
                                    </span>
                                </label>
                            @endforeach
                        </div>
                    </section>
                @endif

                @if($clientesSinRutina->isNotEmpty())
                    <section>
                        <h3 class="mb-3 text-sm font-semibold text-gray-900 dark:text-gray-100">
                            {{ __('views.clients_without_active_routine') }}
                        </h3>

                        <div class="space-y-3">
                            @foreach($clientesSinRutina as $cliente)
                                <label data-search-item data-search-text="{{ \Illuminate\Support\Str::lower($cliente->name . ' ' . $cliente->email) }}" class="flex cursor-pointer gap-3 rounded-lg border border-gray-200 p-4 transition hover:bg-gray-50 dark:border-gray-700 dark:hover:bg-gray-900">
                                    <input type="checkbox" name="clientes[]" value="{{ $cliente->id }}"
                                        class="mt-1 rounded border-gray-300 text-emerald-600 shadow-sm focus:ring-emerald-500">
                                    <span class="min-w-0 flex-1">
                                        <span class="block text-sm font-semibold text-gray-900 dark:text-gray-100">{{ $cliente->name }}</span>
                                        <span class="mt-1 block text-sm text-gray-600 dark:text-gray-300">{{ $cliente->email }}</span>
                                    </span>
                                </label>
                            @endforeach
                        </div>
                    </section>
                @endif
            </div>

            <div class="mt-6 flex justify-center gap-4">
                <button type="submit" class="rounded-lg bg-emerald-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-emerald-700">
                    {{ __('views.update_routine_assignments') }}
                </button>
                <button type="button" class="rounded-lg bg-gray-200 px-4 py-2 text-sm font-semibold text-gray-800 transition hover:bg-gray-300 dark:bg-gray-700 dark:text-gray-100 dark:hover:bg-gray-600"
                    @click="$dispatch('close-modal', 'asignarClientesRutinaModal-{{ $rutina->id }}')">
                    {{ __('views.cancel') }}
                </button>
            </div>
        </form>
    @endif
</div>
@endcomponent
