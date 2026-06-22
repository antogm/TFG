@extends('layouts.app')

@section('title', __('views.titles_routine_show'))

@section('content')

    <div class="min-h-screen py-16">
        <div class="flex flex-col gap-8 px-4 sm:px-6 lg:px-8">
            <header class="rounded-xl border-b border-gray-300 bg-white p-4 dark:bg-gray-800">
                <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
                    <div>
                        <a href="{{ url()->previous() }}"
                            class="inline-flex items-center rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 dark:hover:bg-gray-600">
                            {{ __('views.back') }}
                        </a>
                    </div>

                    @if ($puedeEditarRutina || $puedeEliminarRutina)
                        <div class="flex flex-wrap gap-3 sm:self-start">
                            @if ($puedeEditarRutina)
                                <a href="{{ route('rutinas.edit', $rutina->id) }}"
                                    class="inline-flex items-center justify-center rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-indigo-700">
                                    {{ __('views.edit') }}
                                </a>
                            @endif

                            @if ($puedeEliminarRutina)
                                <form method="POST" action="{{ route('rutinas.delete', $rutina->id) }}"
                                    onsubmit="return confirm(@js(__('views.confirm_delete_routine')));">
                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                        class="inline-flex items-center justify-center rounded-lg border border-red-300 bg-white px-4 py-2 text-sm font-semibold text-red-700 transition hover:bg-red-50 dark:border-red-800 dark:bg-gray-800 dark:text-red-300 dark:hover:bg-red-950/30">
                                        {{ __('views.delete') }}
                                    </button>
                                </form>
                            @endif
                        </div>
                    @endif
                </div>

                <h1 class="mt-6 text-3xl font-bold text-gray-900 dark:text-gray-100">
                    {{ __('views.routine_show_heading') }}
                </h1>
                <p class="mt-2 text-gray-600 dark:text-gray-300">
                    {{ __('views.routine_show_intro') }}
                </p>
            </header>

            <section>
                <div class="rounded-xl border-l-4 border-indigo-500 bg-white p-8 shadow-sm dark:bg-gray-800">
                    <div class="flex flex-col gap-6 xl:flex-row xl:items-start xl:justify-between">
                        <div class="max-w-3xl">
                            <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                                {{ $rutina->nombre }}
                            </h2>
                            <p class="mt-2 text-sm leading-6 text-gray-600 dark:text-gray-300">
                                {{ $rutina->descripcion ?: __('views.no_description') }}
                            </p>
                        </div>

                        @if ($rutina->autor)
                            <div class="rounded-lg bg-gray-50 px-4 py-3 text-sm text-gray-600 dark:bg-gray-900 dark:text-gray-300 xl:shrink-0">
                                <span class="font-medium text-gray-900 dark:text-gray-100">{{ __('views.author') }}:</span>
                                {{ $rutina->autor->name }}
                            </div>
                        @endif
                    </div>

                    <div class="mt-6 grid gap-3 sm:grid-cols-2 xl:grid-cols-4">
                        <div class="rounded-lg bg-gray-50 p-4 dark:bg-gray-900">
                            <p class="text-xs font-medium uppercase tracking-wide text-gray-500 dark:text-gray-400">{{ __('views.days') }}</p>
                            <p class="mt-2 text-lg font-bold text-gray-950 dark:text-gray-50">{{ $rutina->dias_entreno ?? "--" }} {{ __("views.per_week_short") }}</p>
                        </div>
                        <div class="rounded-lg bg-gray-50 p-4 dark:bg-gray-900">
                            <p class="text-xs font-medium uppercase tracking-wide text-gray-500 dark:text-gray-400">{{ __('views.duration') }}</p>
                            <p class="mt-2 text-lg font-bold text-gray-950 dark:text-gray-50">{{ $rutina->duracion_aproximada_min ?? '--' }} min</p>
                        </div>
                        <div class="rounded-lg bg-gray-50 p-4 dark:bg-gray-900">
                            <p class="text-xs font-medium uppercase tracking-wide text-gray-500 dark:text-gray-400">{{ __('views.target_kcal') }}</p>
                            <p class="mt-2 text-lg font-bold text-gray-950 dark:text-gray-50">{{ $rutina->kcal_objetivo ?? '--' }}</p>
                        </div>
                        <div class="rounded-lg bg-gray-50 p-4 dark:bg-gray-900">
                            <p class="text-xs font-medium uppercase tracking-wide text-gray-500 dark:text-gray-400">{{ __('views.target_steps') }}</p>
                            <p class="mt-2 text-lg font-bold text-gray-950 dark:text-gray-50">{{ $rutina->pasos_objetivo ?? '--' }}</p>
                        </div>
                    </div>
                </div>
            </section>

            <section>
                <div class="rounded-xl border-l-4 border-amber-500 bg-white p-8 shadow-sm dark:bg-gray-800" x-data="{ activeDay: {{ old('dia_activo_id', $diaInicialId ?? 'null') }} }">
                    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                                {{ __('views.training_days') }}
                            </h2>
                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-300">
                                {{ $modoRegistro ? __('views.routine_log_intro') : __('views.routine_detail_intro') }}
                            </p>
                        </div>
                    </div>

                    @if ($diasEntreno->isNotEmpty())
                        <div class="mb-6 flex flex-wrap gap-3">
                            @foreach ($diasEntreno as $dia)
                                <button
                                    type="button"
                                    x-on:click="activeDay = {{ $dia->id }}"
                                    x-bind:class="activeDay === {{ $dia->id }} ? 'border-indigo-600 bg-indigo-600 text-white' : 'border-gray-300 bg-white text-gray-700 hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-200 dark:hover:bg-gray-700'"
                                    class="inline-flex items-center rounded-lg border px-4 py-2 text-sm font-medium transition"
                                >
                                    {{ $dia->nombre_detalle }}
                                </button>
                            @endforeach
                        </div>

                        @if ($modoRegistro)
                            <form method="POST"
                                @if ($modoEdicionRegistro)
                                    action="{{ route('usuario.historial-entreno.update', ['id' => $registroEntrenamiento->usuario_id, 'registroEntrenamiento' => $registroEntrenamiento->id]) }}"
                                @else
                                    action="{{ route('rutinas.registro-entrenamiento.store', $rutina->id) }}"
                                @endif
                                class="space-y-6">
                                @csrf
                                @if ($modoEdicionRegistro)
                                    @method('PATCH')
                                @endif
                                <input type="hidden" name="dia_activo_id" x-model="activeDay">

                                @if ($errors->any())
                                    <div class="rounded-lg border border-red-200 bg-red-50 p-4 text-sm text-red-700 dark:border-red-800 dark:bg-red-950/40 dark:text-red-200">
                                        <p class="font-semibold">{{ __('views.review_form_errors') }}</p>
                                        <ul class="mt-2 list-disc pl-5">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                        @endif

                        @foreach ($diasEntreno as $dia)
                            @if ($modoRegistro)
                                <fieldset x-show="activeDay === {{ $dia->id }}" x-cloak x-bind:disabled="activeDay !== {{ $dia->id }}" class="space-y-6">
                            @else
                                <div x-show="activeDay === {{ $dia->id }}" x-cloak class="space-y-6">
                            @endif
                                <div class="rounded-xl border border-gray-200 bg-gray-50 p-5 dark:border-gray-700 dark:bg-gray-900/40">
                                    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                                        <div>
                                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                                {{ $dia->nombre_detalle }}
                                            </h3>
                                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-300">
                                                {{ $dia->numero_ejercicios_label }}
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="overflow-hidden rounded-xl border border-gray-200 bg-white dark:border-gray-700 dark:bg-gray-900/40">
                                    @forelse ($dia->ejerciciosDetalle as $ejercicioProgramado)
                                        <article class="border-b border-gray-200 px-5 py-5 last:border-b-0 dark:border-gray-700">
                                            <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                                                <div class="flex min-w-0 items-center gap-4 lg:w-[20rem] lg:flex-none">
                                                    <div class="h-16 w-16 shrink-0 overflow-hidden rounded-xl border border-gray-200 bg-gray-100 dark:border-gray-700 dark:bg-gray-800">
                                                        @if ($ejercicioProgramado->ejercicio->imagen)
                                                            <img src="{{ Storage::url($ejercicioProgramado->ejercicio->imagen) }}"
                                                                alt="{{ $ejercicioProgramado->ejercicio->nombre }}"
                                                                class="h-full w-full object-cover">
                                                        @else
                                                            <div class="flex h-full w-full items-center justify-center text-xs font-semibold uppercase tracking-[0.2em] text-gray-500 dark:text-gray-300">
                                                                {{ strtoupper(mb_substr($ejercicioProgramado->ejercicio->nombre, 0, 2)) }}
                                                            </div>
                                                        @endif
                                                    </div>

                                                    <div class="min-w-0">
                                                        <h4 class="text-base font-semibold text-gray-900 dark:text-gray-100">
                                                            {{ $ejercicioProgramado->ejercicio->nombre }}
                                                        </h4>
                                                        <p class="mt-1 text-sm text-gray-600 dark:text-gray-300">
                                                            {{ $ejercicioProgramado->ejercicio->gruposMusculares->pluck('nombre')->join(', ') ?: __('views.no_muscle_groups') }}
                                                        </p>
                                                    </div>
                                                </div>

                                                <div class="grid flex-1 gap-3 sm:grid-cols-2 xl:grid-cols-4">
                                                    @if ($modoRegistro)
                                                        <div>
                                                            <label class="block text-xs font-medium uppercase tracking-wide text-gray-500 dark:text-gray-400">{{ __('views.sets') }}</label>
                                                            <input type="number" min="0" name="registro[{{ $dia->id }}][{{ $ejercicioProgramado->id }}][series]"
                                                                value="{{ old('registro.' . $dia->id . '.' . $ejercicioProgramado->id . '.series', $ejercicioProgramado->series_registro) }}"
                                                                class="mt-2 block w-full rounded-lg border-gray-300 bg-white text-sm text-gray-900 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100">
                                                        </div>
                                                        <div>
                                                            <label class="block text-xs font-medium uppercase tracking-wide text-gray-500 dark:text-gray-400">{{ __('views.reps') }}</label>
                                                            <input type="number" min="0" name="registro[{{ $dia->id }}][{{ $ejercicioProgramado->id }}][repeticiones]"
                                                                value="{{ old('registro.' . $dia->id . '.' . $ejercicioProgramado->id . '.repeticiones', $ejercicioProgramado->repeticiones_registro) }}"
                                                                class="mt-2 block w-full rounded-lg border-gray-300 bg-white text-sm text-gray-900 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100">
                                                        </div>
                                                        <div>
                                                            <label class="block text-xs font-medium uppercase tracking-wide text-gray-500 dark:text-gray-400">{{ __('views.load') }}</label>
                                                            <input type="number" min="0" name="registro[{{ $dia->id }}][{{ $ejercicioProgramado->id }}][carga]"
                                                                value="{{ old('registro.' . $dia->id . '.' . $ejercicioProgramado->id . '.carga', $ejercicioProgramado->carga_registro) }}"
                                                                class="mt-2 block w-full rounded-lg border-gray-300 bg-white text-sm text-gray-900 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100">
                                                        </div>
                                                        <div>
                                                            <label class="block text-xs font-medium uppercase tracking-wide text-gray-500 dark:text-gray-400">{{ __('views.duration') }}</label>
                                                            <input type="number" min="0" name="registro[{{ $dia->id }}][{{ $ejercicioProgramado->id }}][duracion_segundos]"
                                                                value="{{ old('registro.' . $dia->id . '.' . $ejercicioProgramado->id . '.duracion_segundos', $ejercicioProgramado->duracion_registro) }}"
                                                                class="mt-2 block w-full rounded-lg border-gray-300 bg-white text-sm text-gray-900 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100">
                                                        </div>
                                                    @else
                                                        <div class="rounded-lg bg-gray-50 p-3 dark:bg-gray-800">
                                                            <p class="text-xs font-medium uppercase tracking-wide text-gray-500 dark:text-gray-400">{{ __('views.sets') }}</p>
                                                            <p class="mt-2 text-sm font-semibold text-gray-900 dark:text-gray-100">{{ $ejercicioProgramado->series }}</p>
                                                        </div>
                                                        <div class="rounded-lg bg-gray-50 p-3 dark:bg-gray-800">
                                                            <p class="text-xs font-medium uppercase tracking-wide text-gray-500 dark:text-gray-400">{{ __('views.reps') }}</p>
                                                            <p class="mt-2 text-sm font-semibold text-gray-900 dark:text-gray-100">{{ $ejercicioProgramado->repeticiones }}</p>
                                                        </div>
                                                        <div class="rounded-lg bg-gray-50 p-3 dark:bg-gray-800">
                                                            <p class="text-xs font-medium uppercase tracking-wide text-gray-500 dark:text-gray-400">{{ __('views.load') }}</p>
                                                            <p class="mt-2 text-sm font-semibold text-gray-900 dark:text-gray-100">{{ $ejercicioProgramado->carga ?? '--' }}</p>
                                                        </div>
                                                        <div class="rounded-lg bg-gray-50 p-3 dark:bg-gray-800">
                                                            <p class="text-xs font-medium uppercase tracking-wide text-gray-500 dark:text-gray-400">{{ __('views.duration') }}</p>
                                                            <p class="mt-2 text-sm font-semibold text-gray-900 dark:text-gray-100">{{ $ejercicioProgramado->duracion_segundos ? $ejercicioProgramado->duracion_segundos . ' s' : '--' }}</p>
                                                        </div>
                                                    @endif
                                                </div>

                                                <div class="flex justify-end lg:flex-none">
                                                    <a href="{{ route('ejercicios.ver', $ejercicioProgramado->ejercicio->id) }}"
                                                        class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-200 dark:hover:bg-gray-700">
                                                        {{ __('views.details') }}
                                                    </a>
                                                </div>
                                            </div>
                                        </article>
                                    @empty
                                        <div class="rounded-xl border border-dashed border-gray-300 bg-gray-50 p-6 text-sm text-gray-600 dark:border-gray-600 dark:bg-gray-900/20 dark:text-gray-300">
                                            {{ __('views.no_exercises_day') }}
                                        </div>
                                    @endforelse
                                </div>

                                @if ($modoRegistro)
                                    <div class="rounded-xl border border-gray-200 bg-white p-5 dark:border-gray-700 dark:bg-gray-900/40">
                                        <h4 class="text-base font-semibold text-gray-900 dark:text-gray-100">
                                            {{ __('views.workout_summary') }}
                                        </h4>

                                        <div class="mt-4 grid gap-6 lg:grid-cols-2">
                                            <div>
                                                <label for="pasos_realizados_{{ $dia->id }}"
                                                    class="block text-sm font-medium text-gray-700 dark:text-gray-200">
                                                    {{ __('views.steps_completed') }}
                                                </label>
                                                <input
                                                    id="pasos_realizados_{{ $dia->id }}"
                                                    type="number"
                                                    min="0"
                                                    required
                                                    name="registro_resumen[{{ $dia->id }}][pasos_realizados]"
                                                    value="{{ old('registro_resumen.' . $dia->id . '.pasos_realizados', $pasosRealizadosGuardados) }}"
                                                    class="mt-2 block w-full rounded-lg border-gray-300 bg-white text-sm text-gray-900 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100">
                                            </div>

                                            <fieldset>
                                                <legend class="block text-sm font-medium text-gray-700 dark:text-gray-200">
                                                    {{ __('views.diet_adherence') }}
                                                </legend>

                                                <div class="mt-3 flex flex-wrap gap-3">
                                                    <label for="adherencia_dieta_si_{{ $dia->id }}"
                                                        class="inline-flex items-center gap-2 rounded-lg border border-gray-300 px-4 py-2 text-sm text-gray-700 dark:border-gray-600 dark:text-gray-200">
                                                        <input
                                                            id="adherencia_dieta_si_{{ $dia->id }}"
                                                            type="radio"
                                                            name="registro_resumen[{{ $dia->id }}][adherencia_dieta]"
                                                            value="1"
                                                            required
                                                            @checked(old('registro_resumen.' . $dia->id . '.adherencia_dieta', $adherenciaDietaGuardada) === '1')
                                                            class="border-gray-300 text-indigo-600 focus:ring-indigo-500 dark:border-gray-600 dark:bg-gray-800">
                                                        <span>{{ __('views.yes') }}</span>
                                                    </label>

                                                    <label for="adherencia_dieta_no_{{ $dia->id }}"
                                                        class="inline-flex items-center gap-2 rounded-lg border border-gray-300 px-4 py-2 text-sm text-gray-700 dark:border-gray-600 dark:text-gray-200">
                                                        <input
                                                            id="adherencia_dieta_no_{{ $dia->id }}"
                                                            type="radio"
                                                            name="registro_resumen[{{ $dia->id }}][adherencia_dieta]"
                                                            value="0"
                                                            required
                                                            @checked(old('registro_resumen.' . $dia->id . '.adherencia_dieta', $adherenciaDietaGuardada) === '0')
                                                            class="border-gray-300 text-indigo-600 focus:ring-indigo-500 dark:border-gray-600 dark:bg-gray-800">
                                                        <span>{{ __('views.no') }}</span>
                                                    </label>
                                                </div>
                                            </fieldset>


                                            <div class="lg:col-span-2">
                                                <label for="notas_{{ $dia->id }}"
                                                    class="block text-sm font-medium text-gray-700 dark:text-gray-200">
                                                    {{ __('views.workout_notes') }}
                                                </label>
                                                <input
                                                    id="notas_{{ $dia->id }}"
                                                    type="text"
                                                    name="registro_resumen[{{ $dia->id }}][notas]"
                                                    value="{{ old('registro_resumen.' . $dia->id . '.notas', $notasGuardadas) }}"
                                                    maxlength="1000"
                                                    placeholder="{{ __('views.workout_notes_placeholder') }}"
                                                    class="mt-2 block w-full rounded-lg border-gray-300 bg-white text-sm text-gray-900 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100">
                                                <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                                                    {{ __('views.workout_notes_help') }}
                                                </p>
                                                <x-input-error :messages="$errors->get('registro_resumen.' . $dia->id . '.notas')" class="mt-2" />
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @if ($modoRegistro)
                                </fieldset>
                            @else
                                </div>
                            @endif
                        @endforeach

                        @if ($modoRegistro)
                                <div class="pt-2">
                                    <button type="submit"
                                        class="inline-flex items-center justify-center rounded-lg bg-emerald-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-emerald-700">
                                        {{ __('views.save_changes') }}
                                    </button>
                                </div>
                            </form>
                        @endif
                    @else
                        <div class="rounded-xl border border-dashed border-gray-300 bg-gray-50 p-6 text-sm text-gray-600 dark:border-gray-600 dark:bg-gray-900/20 dark:text-gray-300">
                            {{ __('views.no_exercises_available') }}
                        </div>
                    @endif
                </div>
            </section>

            @if (!empty($mostrarBotonRegistro))
                <div class="flex justify-end">
                    <a href="{{ route('rutinas.registro-entrenamiento.create', $rutina->id) }}"
                        class="inline-flex items-center justify-center rounded-lg bg-emerald-600 px-5 py-3 text-sm font-semibold text-white transition hover:bg-emerald-700">
                        {{ __('views.log_workout') }}
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection
