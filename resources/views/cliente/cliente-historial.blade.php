@extends('layouts.list')

@section('title', __('views.titles_client_history'))

@section('header-actions')
    <a href="{{ route('usuario.progreso', $user->id) }}"
        class="inline-flex items-center rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 dark:hover:bg-gray-600">
        {{ __('views.back') }}
    </a>
@endsection

@section('header-title', __('views.client_history_heading'))
@section('header-subtitle', __('views.client_history_subtitle'))

@section('list-content')
    <div x-data="{ activeTab: '{{ $historialTabInicial }}' }" class="space-y-6">
        <div class="flex flex-wrap gap-3">
            <button
                type="button"
                x-on:click="activeTab = 'historial_corporal'"
                x-bind:class="activeTab === 'historial_corporal' ? 'border-indigo-600 bg-indigo-600 text-white' : 'border-gray-300 bg-white text-gray-700 hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-200 dark:hover:bg-gray-700'"
                class="inline-flex items-center rounded-lg border px-4 py-2 text-sm font-medium transition"
            >
                {{ __('views.body_records') }}
            </button>

            <button
                type="button"
                x-on:click="activeTab = 'historial_entrenos'"
                x-bind:class="activeTab === 'historial_entrenos' ? 'border-indigo-600 bg-indigo-600 text-white' : 'border-gray-300 bg-white text-gray-700 hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-200 dark:hover:bg-gray-700'"
                class="inline-flex items-center rounded-lg border px-4 py-2 text-sm font-medium transition"
            >
                {{ __('views.workout_records') }}
            </button>
        </div>

        <div x-show="activeTab === 'historial_corporal'" x-cloak>
            <div class="overflow-x-auto rounded-xl border border-gray-200 dark:border-gray-700">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700" data-sortable-table>
                    <thead class="bg-gray-50 dark:bg-gray-900">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">
                                <button type="button" class="inline-flex items-center gap-1 hover:text-gray-700 dark:hover:text-gray-200" data-sort-key="fecha_registro" data-sort-type="date">
                                    <span>{{ __('views.date') }}</span>
                                    <span data-sort-indicator></span>
                                </button>
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">
                                <button type="button" class="inline-flex items-center gap-1 hover:text-gray-700 dark:hover:text-gray-200" data-sort-key="peso" data-sort-type="number">
                                    <span>{{ __('views.weight') }}</span>
                                    <span data-sort-indicator></span>
                                </button>
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">
                                <button type="button" class="inline-flex items-center gap-1 hover:text-gray-700 dark:hover:text-gray-200" data-sort-key="masa_muscular" data-sort-type="number">
                                    <span>{{ __('views.muscle_mass') }}</span>
                                    <span data-sort-indicator></span>
                                </button>
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">
                                <button type="button" class="inline-flex items-center gap-1 hover:text-gray-700 dark:hover:text-gray-200" data-sort-key="porcentaje_grasa" data-sort-type="number">
                                    <span>{{ __('views.body_fat_percent') }}</span>
                                    <span data-sort-indicator></span>
                                </button>
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">
                                <button type="button" class="inline-flex items-center gap-1 hover:text-gray-700 dark:hover:text-gray-200" data-sort-key="fecha_edicion" data-sort-type="date">
                                    <span>{{ __('views.edited') }}</span>
                                    <span data-sort-indicator></span>
                                </button>
                            </th>
                            <th class="px-4 py-3 text-center text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">
                                {{ __('views.actions') }}
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white dark:divide-gray-700 dark:bg-gray-800">
                        @forelse ($registrosCorporales as $registroCorporal)
                            @include('cliente._partials.historial.registroCorporal-inlist', [
                                'registroCorporal' => $registroCorporal,
                                'esPropietario' => $esPropietario,
                                'esPropietarioHistorial' => $puedeEditarHistorial,
                            ])
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-6 text-sm text-gray-600 dark:text-gray-300">
                                    {{ __('views.no_corporal_registers_available') }}
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-6">
                {{ $registrosCorporales->appends(['tab' => 'historial_corporal'])->links() }}
            </div>
        </div>

        <div x-show="activeTab === 'historial_entrenos'" x-cloak>
            <div class="overflow-x-auto rounded-xl border border-gray-200 dark:border-gray-700">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700" data-sortable-table>
                    <thead class="bg-gray-50 dark:bg-gray-900">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">
                                <button type="button" class="inline-flex items-center gap-1 hover:text-gray-700 dark:hover:text-gray-200" data-sort-key="fecha" data-sort-type="date">
                                    <span>{{ __('views.date') }}</span>
                                    <span data-sort-indicator></span>
                                </button>
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">
                                <button type="button" class="inline-flex items-center gap-1 hover:text-gray-700 dark:hover:text-gray-200" data-sort-key="nombre" data-sort-type="text">
                                    <span>{{ __('views.workout') }}</span>
                                    <span data-sort-indicator></span>
                                </button>
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">
                                <button type="button" class="inline-flex items-center gap-1 hover:text-gray-700 dark:hover:text-gray-200" data-sort-key="rutina" data-sort-type="text">
                                    <span>{{ __('views.routine') }}</span>
                                    <span data-sort-indicator></span>
                                </button>
                            </th>
                            <th class="px-4 py-3 text-center text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">
                                {{ __('views.actions') }}
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white dark:divide-gray-700 dark:bg-gray-800">
                        @forelse ($registrosEntrenos as $registroEntreno)
                            <tr
                                data-fecha="{{ data_get($registroEntreno, 'fecha_orden') ?? data_get($registroEntreno, 'fecha') ?? data_get($registroEntreno, 'created_at')?->format('Y-m-d') ?? '' }}"
                                data-nombre="{{ data_get($registroEntreno, 'nombre') ?? '' }}"
                                data-rutina="{{ data_get($registroEntreno, 'rutina') ?? '' }}"
                            >
                                <td class="px-4 py-4 text-sm text-gray-900 dark:text-gray-100">
                                    {{ data_get($registroEntreno, 'fecha') ?? (data_get($registroEntreno, 'created_at') ? data_get($registroEntreno, 'created_at')->format('d/m/Y') : '-') }}
                                </td>
                                <td class="px-4 py-4 text-sm text-gray-900 dark:text-gray-100">
                                    {{ data_get($registroEntreno, 'nombre') ?? '-' }}
                                </td>
                                <td class="px-4 py-4 text-sm text-gray-900 dark:text-gray-100">
                                    {{ data_get($registroEntreno, 'rutina') ?? '-' }}
                                </td>
                                <td class="px-4 py-4 text-center text-sm">
                                    <div class="flex flex-wrap justify-center gap-2">
                                        <a href="{{ route('usuario.historial-entreno.detalle', ['id' => $user->id, 'registroEntrenamiento' => data_get($registroEntreno, 'id')]) }}"
                                            class="inline-flex items-center rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-200 dark:hover:bg-gray-700">
                                            {{ __('views.details') }}
                                        </a>

                                        @if($puedeEditarHistorial)
                                            <a href="{{ route('usuario.historial-entreno.edit', ['id' => $user->id, 'registroEntrenamiento' => data_get($registroEntreno, 'id')]) }}"
                                                class="inline-flex items-center rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-200 dark:hover:bg-gray-700">
                                                {{ __('views.edit') }}
                                            </a>

                                            <form method="POST" action="{{ route('usuario.historial-entreno.delete', ['id' => $user->id, 'registroEntrenamiento' => data_get($registroEntreno, 'id')]) }}"
                                                onsubmit="return confirm(@js(__('views.confirm_delete_workout_record', ['name' => data_get($registroEntreno, 'nombre') ?? '-'])));">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit"
                                                    class="inline-flex items-center rounded-lg border border-red-300 bg-white px-3 py-2 text-sm font-medium text-red-700 transition hover:bg-red-50 dark:border-red-800 dark:bg-gray-800 dark:text-red-300 dark:hover:bg-red-950/30">
                                                    {{ __('views.delete') }}
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-4 py-6 text-sm text-gray-600 dark:text-gray-300">
                                    {{ __('views.no_workout_registers_available') }}
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-6">
                {{ $registrosEntrenos->appends(['tab' => 'historial_entrenos'])->links() }}
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    @vite('resources/js/cliente/historial.js')
@endpush
