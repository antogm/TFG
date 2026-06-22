@extends('layouts.app')

@section('title', __('views.workout_record_detail'))

@section('content')
    <div class="min-h-screen py-16">
        <div class="flex flex-col gap-8 px-4 sm:px-6 lg:px-8">
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('usuario.historial', ['id' => $user->id, 'tab' => 'historial_entrenos']) }}"
                    class="inline-flex items-center rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 dark:hover:bg-gray-600">
                    {{ __('views.back') }}
                </a>

                @if($puedeGestionarRegistroEntreno)
                    <a href="{{ route('usuario.historial-entreno.edit', ['id' => $user->id, 'registroEntrenamiento' => $registroEntrenamiento->id]) }}"
                        class="inline-flex items-center rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-indigo-700">
                        {{ __('views.edit') }}
                    </a>

                    <form method="POST" action="{{ route('usuario.historial-entreno.delete', ['id' => $user->id, 'registroEntrenamiento' => $registroEntrenamiento->id]) }}"
                        onsubmit="return confirm(@js(__('views.confirm_delete_workout_record', ['name' => $registroEntrenamiento->nombre ?? '-'])));">
                        @csrf
                        @method('DELETE')

                        <button type="submit"
                            class="inline-flex items-center rounded-lg border border-red-300 bg-white px-4 py-2 text-sm font-semibold text-red-700 transition hover:bg-red-50 dark:border-red-800 dark:bg-gray-800 dark:text-red-300 dark:hover:bg-red-950/30">
                            {{ __('views.delete') }}
                        </button>
                    </form>
                @endif
            </div>

            <header class="rounded-xl border-b border-gray-300 bg-white p-4 dark:bg-gray-800">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100">
                    {{ __('views.workout_record_detail') }}
                </h1>
                <p class="mt-2 text-gray-600 dark:text-gray-300">
                    {{ __('views.workout_record_detail_intro') }}
                </p>
            </header>

            <section class="rounded-xl border-l-4 border-indigo-500 bg-white p-8 shadow-sm dark:bg-gray-800">
                <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
                    <div class="rounded-lg bg-gray-50 p-4 dark:bg-gray-900">
                        <p class="text-xs font-medium uppercase tracking-wide text-gray-500 dark:text-gray-400">{{ __('views.date') }}</p>
                        <p class="mt-2 text-lg font-bold text-gray-950 dark:text-gray-50">{{ $registroEntrenamiento->fecha_entrenamiento?->format('d/m/Y') ?? '-' }}</p>
                    </div>

                    <div class="rounded-lg bg-gray-50 p-4 dark:bg-gray-900">
                        <p class="text-xs font-medium uppercase tracking-wide text-gray-500 dark:text-gray-400">{{ __('views.routine') }}</p>
                        <p class="mt-2 text-lg font-bold text-gray-950 dark:text-gray-50">{{ $registroEntrenamiento->asignacionRutina?->rutina?->nombre ?? '-' }}</p>
                    </div>

                    <div class="rounded-lg bg-gray-50 p-4 dark:bg-gray-900">
                        <p class="text-xs font-medium uppercase tracking-wide text-gray-500 dark:text-gray-400">{{ __('views.workout') }}</p>
                        <p class="mt-2 text-lg font-bold text-gray-950 dark:text-gray-50">{{ $registroEntrenamiento->nombre ?? '-' }}</p>
                    </div>

                    <div class="rounded-lg bg-gray-50 p-4 dark:bg-gray-900">
                        <p class="text-xs font-medium uppercase tracking-wide text-gray-500 dark:text-gray-400">{{ __('views.training_day') }}</p>
                        <p class="mt-2 text-lg font-bold text-gray-950 dark:text-gray-50">
                            {{ $registroEntrenamiento->diaEntreno?->nombre ?: __('views.day_number', ['number' => $registroEntrenamiento->diaEntreno?->orden ?? '-']) }}
                        </p>
                    </div>
                </div>

                <div class="mt-8 grid gap-6 lg:grid-cols-2">
                    <div class="rounded-xl border border-gray-200 p-5 dark:border-gray-700">
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ __('views.workout_summary') }}</h2>

                        <dl class="mt-4 grid gap-3 text-sm sm:grid-cols-2">
                            <div class="inline-flex items-baseline gap-2 rounded-lg bg-gray-50 px-3 py-2 dark:bg-gray-900">
                                <dt class="text-gray-500 dark:text-gray-400">{{ __('views.steps_completed') }}:</dt>
                                <dd class="font-semibold text-gray-900 dark:text-gray-100">{{ $registroEntrenamiento->pasos_realizados }}</dd>
                            </div>

                            <div class="inline-flex items-baseline gap-2 rounded-lg bg-gray-50 px-3 py-2 dark:bg-gray-900">
                                <dt class="text-gray-500 dark:text-gray-400">{{ __('views.diet_adherence') }}:</dt>
                                <dd class="font-semibold text-gray-900 dark:text-gray-100">
                                    @if($registroEntrenamiento->adherencia_dieta === null)
                                        -
                                    @elseif($registroEntrenamiento->adherencia_dieta)
                                        {{ __('views.yes') }}
                                    @else
                                        {{ __('views.no') }}
                                    @endif
                                </dd>
                            </div>
                        </dl>
                    </div>

                    <div class="rounded-xl border border-gray-200 p-5 dark:border-gray-700">
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ __('views.notes') }}</h2>
                        <p class="mt-4 whitespace-pre-line text-sm leading-6 text-gray-700 dark:text-gray-300">{{ $registroEntrenamiento->notas ?: __('views.no_notes_registered') }}</p>
                    </div>
                </div>

                <div class="mt-8 overflow-x-auto rounded-xl border border-gray-200 dark:border-gray-700">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-900">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">{{ __('views.exercise') }}</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">{{ __('views.sets') }}</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">{{ __('views.reps') }}</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500 dark:text-gray-400">{{ __('views.load') }}</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white dark:divide-gray-700 dark:bg-gray-800">
                            @forelse($registroEntrenamiento->registrosEjercicios as $registroEjercicio)
                                <tr>
                                    <td class="px-4 py-4 text-sm font-medium text-gray-900 dark:text-gray-100">
                                        {{ $registroEjercicio->diaEntrenoEjercicio?->ejercicio?->nombre ?? '-' }}
                                    </td>
                                    <td class="px-4 py-4 text-sm text-gray-700 dark:text-gray-300">
                                        {{ $registroEjercicio->series_realizadas ?? '-' }}
                                    </td>
                                    <td class="px-4 py-4 text-sm text-gray-700 dark:text-gray-300">
                                        {{ $registroEjercicio->repeticiones_realizadas ?? '-' }}
                                    </td>
                                    <td class="px-4 py-4 text-sm text-gray-700 dark:text-gray-300">
                                        @if($registroEjercicio->peso_utilizado !== null)
                                            {{ $registroEjercicio->peso_utilizado }} kg
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-4 py-6 text-sm text-gray-600 dark:text-gray-300">
                                        {{ __('views.no_exercises_available') }}
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </div>
@endsection
