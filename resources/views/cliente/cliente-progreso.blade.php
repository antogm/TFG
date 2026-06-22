@extends('layouts.app')

@section('title', __('views.titles_user_progress'))

@section('content')
    <div class="min-h-screen bg-gray-100 py-10 dark:bg-gray-900">
        <div class="mx-auto flex max-w-7xl flex-col gap-8 px-4 sm:px-6 lg:px-8">
            
			@include('cliente._partials.dashboard.cabecera', [
				'user' => $user,
				'entrenadorAsignado' => $entrenadorAsignado,
				'esSuEntrenador' => $esSuEntrenador,
			])
			
			@include('cliente._partials.dashboard.resumen-corporal', [
				'resumenCorporal' => $resumenCorporal,
				'variacionesCorporales' => $variacionesCorporales,
			])

            @include('cliente._partials.dashboard.infoentrenador', [
                'esSuEntrenador' => $esSuEntrenador,
            ])

			<!-- GRÁFICA -->
            <section class="rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-200 dark:bg-gray-800 dark:ring-gray-700" x-data="{ metric: 'peso', period: '6m' }">
                <div class="flex flex-col gap-4 border-b border-gray-200 pb-5 dark:border-gray-700 lg:flex-row lg:items-center lg:justify-between">
                    <div>
                        <h2 class="text-xl font-bold text-gray-950 dark:text-gray-50">{{ __('views.body_evolution') }}</h2>
                    </div>
                </div>

                <div class="mt-6">
                    <div class="mb-4 flex items-center justify-between gap-3">
                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('progress-chart.selected_metric') }}</p>
                            <p class="text-lg font-semibold text-gray-950 dark:text-gray-50" x-text="metric === 'peso' ? '{{ __('progress-chart.metrics.peso') }}' : metric === 'masa' ? '{{ __('progress-chart.metrics.masa') }}' : metric === 'grasa' ? '{{ __('progress-chart.metrics.grasa') }}' : '{{ __('progress-chart.metrics.pasos') }}'"></p>
                        </div>
                        <p class="text-sm text-gray-500 dark:text-gray-400" x-text="period === '7d' ? '{{ __('progress-chart.periods.7d') }}' : period === '30d' ? '{{ __('progress-chart.periods.30d') }}' : period === '6m' ? '{{ __('progress-chart.periods.6m') }}' : '{{ __('progress-chart.periods.all') }}'"></p>
                    </div>

                    <div class="mb-4 grid grid-cols-2 rounded-lg bg-gray-100 p-1 dark:bg-gray-900 sm:grid-cols-4 lg:max-w-2xl" aria-label="{{ __('progress-chart.metric_selector') }}">
                        <button type="button" x-on:click="metric = 'peso'; window.actualizarGrafica(window.datosGraficaProgreso[metric][period])" x-bind:class="metric === 'peso' ? 'bg-white text-indigo-700 shadow-sm dark:bg-gray-700 dark:text-white' : 'text-gray-600 hover:text-gray-900 dark:text-gray-300 dark:hover:text-white'" class="rounded-md px-3 py-2 text-center text-sm font-semibold transition">
                            {{ __('progress-chart.metric_buttons.peso') }}
                        </button>
                        <button type="button" x-on:click="metric = 'masa'; window.actualizarGrafica(window.datosGraficaProgreso[metric][period])" x-bind:class="metric === 'masa' ? 'bg-white text-indigo-700 shadow-sm dark:bg-gray-700 dark:text-white' : 'text-gray-600 hover:text-gray-900 dark:text-gray-300 dark:hover:text-white'" class="rounded-md px-3 py-2 text-center text-sm font-semibold transition">
                            {{ __('progress-chart.metric_buttons.masa') }}
                        </button>
                        <button type="button" x-on:click="metric = 'grasa'; window.actualizarGrafica(window.datosGraficaProgreso[metric][period])" x-bind:class="metric === 'grasa' ? 'bg-white text-indigo-700 shadow-sm dark:bg-gray-700 dark:text-white' : 'text-gray-600 hover:text-gray-900 dark:text-gray-300 dark:hover:text-white'" class="rounded-md px-3 py-2 text-center text-sm font-semibold transition">
                            {{ __('progress-chart.metric_buttons.grasa') }}
                        </button>
                        <button type="button" x-on:click="metric = 'pasos'; window.actualizarGrafica(window.datosGraficaProgreso[metric][period])" x-bind:class="metric === 'pasos' ? 'bg-white text-indigo-700 shadow-sm dark:bg-gray-700 dark:text-white' : 'text-gray-600 hover:text-gray-900 dark:text-gray-300 dark:hover:text-white'" class="rounded-md px-3 py-2 text-center text-sm font-semibold transition">
                            {{ __('progress-chart.metric_buttons.pasos') }}
                        </button>
                    </div>

                    <div class="relative h-80 overflow-hidden rounded-lg border border-gray-200 bg-gray-50 p-4 dark:border-gray-700 dark:bg-gray-900">
                        <canvas id="grafica-progreso" class="h-full w-full"></canvas>
                        <div id="grafica-progreso-empty" class="pointer-events-none absolute inset-0 hidden items-center justify-center px-4 text-center text-sm font-medium text-gray-500 dark:text-gray-400">
                            {{ __('progress-chart.no_data') }}
                        </div>
                    </div>

                    <div class="mt-4 grid grid-cols-4 rounded-lg bg-gray-100 p-1 dark:bg-gray-900 sm:max-w-md" aria-label="{{ __('progress-chart.period_selector') }}">
                        <button type="button" x-on:click="period = '7d'; window.actualizarGrafica(window.datosGraficaProgreso[metric][period])" x-bind:class="period === '7d' ? 'bg-white text-indigo-700 shadow-sm dark:bg-gray-700 dark:text-white' : 'text-gray-600 hover:text-gray-900 dark:text-gray-300 dark:hover:text-white'" class="rounded-md px-3 py-2 text-center text-sm font-semibold transition">
                            {{ __('progress-chart.periods.7d') }}
                        </button>
                        <button type="button" x-on:click="period = '30d'; window.actualizarGrafica(window.datosGraficaProgreso[metric][period])" x-bind:class="period === '30d' ? 'bg-white text-indigo-700 shadow-sm dark:bg-gray-700 dark:text-white' : 'text-gray-600 hover:text-gray-900 dark:text-gray-300 dark:hover:text-white'" class="rounded-md px-3 py-2 text-center text-sm font-semibold transition">
                            {{ __('progress-chart.periods.30d') }}
                        </button>
                        <button type="button" x-on:click="period = '6m'; window.actualizarGrafica(window.datosGraficaProgreso[metric][period])" x-bind:class="period === '6m' ? 'bg-white text-indigo-700 shadow-sm dark:bg-gray-700 dark:text-white' : 'text-gray-600 hover:text-gray-900 dark:text-gray-300 dark:hover:text-white'" class="rounded-md px-3 py-2 text-center text-sm font-semibold transition">
                            {{ __('progress-chart.periods.6m') }}
                        </button>
                        <button type="button" x-on:click="period = 'all'; window.actualizarGrafica(window.datosGraficaProgreso[metric][period])" x-bind:class="period === 'all' ? 'bg-white text-indigo-700 shadow-sm dark:bg-gray-700 dark:text-white' : 'text-gray-600 hover:text-gray-900 dark:text-gray-300 dark:hover:text-white'" class="rounded-md px-3 py-2 text-center text-sm font-semibold transition">
                            {{ __('progress-chart.periods.all') }}
                        </button>
                    </div>
                </div>
            </section>

			<!-- RUTINA -->
            <div class="grid gap-8 xl:grid-cols-[0.9fr_1.1fr]">
                <section class="rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-200 dark:bg-gray-800 dark:ring-gray-700">
                    <div class="flex flex-col gap-4 border-b border-gray-200 pb-5 dark:border-gray-700 sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <h2 class="text-xl font-bold text-gray-950 dark:text-gray-50">{{ __('views.current_routine') }}</h2>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                {{ $rutinaAsignada ? __('views.assigned_plan_currently') : __('views.no_active_routine') }}
                            </p>
                        </div>
                    </div>

                    @if($rutinaAsignada)
                        <div class="mt-6 space-y-5">
                            <div>
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('views.routine_name') }}</p>
                                <p class="mt-1 text-2xl font-bold text-gray-950 dark:text-gray-50">{{ $rutinaAsignada->nombre }}</p>
                            </div>

                            <p class="text-sm leading-6 text-gray-600 dark:text-gray-300">
                                {{ $rutinaAsignada->descripcion ?? __('views.no_description') }}
                            </p>

                            <div class="grid gap-3 sm:grid-cols-2 xl:grid-cols-3">
                                <div class="rounded-lg bg-gray-50 p-4 dark:bg-gray-900">
                                    <p class="text-xs font-medium uppercase tracking-wide text-gray-500 dark:text-gray-400">{{ __('views.author') }}</p>
                                    <p class="mt-2 text-lg font-bold text-gray-950 dark:text-gray-50">{{ $rutinaAsignada->autor?->name ?? __('views.no_author') }}</p>
                                </div>
                                <div class="rounded-lg bg-gray-50 p-4 dark:bg-gray-900">
                                    <p class="text-xs font-medium uppercase tracking-wide text-gray-500 dark:text-gray-400">{{ __('views.days') }}</p>
                                    <p class="mt-2 text-lg font-bold text-gray-950 dark:text-gray-50">{{ $rutinaAsignada->dias_entreno ?? "--" }} {{ __("views.per_week_short") }}</p>
                                </div>
                                <div class="rounded-lg bg-gray-50 p-4 dark:bg-gray-900">
                                    <p class="text-xs font-medium uppercase tracking-wide text-gray-500 dark:text-gray-400">{{ __('views.duration') }}</p>
                                    <p class="mt-2 text-lg font-bold text-gray-950 dark:text-gray-50">{{ $rutinaAsignada->duracion_aproximada_min ?? '--' }} min</p>
                                </div>
                                <div class="rounded-lg bg-gray-50 p-4 dark:bg-gray-900">
                                    <p class="text-xs font-medium uppercase tracking-wide text-gray-500 dark:text-gray-400">{{ __('views.start') }}</p>
                                    <p class="mt-2 text-lg font-bold text-gray-950 dark:text-gray-50">{{ $asignacionRutinaActiva?->fecha_asignacion?->format('d/m/Y') ?? '--' }}</p>
                                </div>
                                <div class="rounded-lg bg-gray-50 p-4 dark:bg-gray-900">
                                    <p class="text-xs font-medium uppercase tracking-wide text-gray-500 dark:text-gray-400">{{ __('views.target_kcal') }}</p>
                                    <p class="mt-2 text-lg font-bold text-gray-950 dark:text-gray-50">{{ $rutinaAsignada->kcal_objetivo ?? '--' }}</p>
                                </div>
                                <div class="rounded-lg bg-gray-50 p-4 dark:bg-gray-900">
                                    <p class="text-xs font-medium uppercase tracking-wide text-gray-500 dark:text-gray-400">{{ __('views.target_steps') }}</p>
                                    <p class="mt-2 text-lg font-bold text-gray-950 dark:text-gray-50">{{ $rutinaAsignada->pasos_objetivo ?? '--' }}</p>
                                </div>
                            </div>

                            @if(!$esSuEntrenador)
                                <div class="flex flex-wrap gap-3">
                                    <a href="{{ route('rutinas.get', $rutinaAsignada->id) }}" class="inline-flex items-center justify-center rounded-lg bg-amber-500 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-amber-600">
                                        {{ __('views.details') }}
                                    </a>
                                    <a href="{{ route('rutinas.registro-entrenamiento.create', $rutinaAsignada->id) }}" class="inline-flex items-center justify-center rounded-lg bg-emerald-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-emerald-700">
                                        {{ __('views.log_workout') }}
                                    </a>
                                </div>
                            @endif

                            @if($esSuEntrenador)
                                <div class="flex flex-col gap-3 sm:flex-row sm:flex-wrap">
                                    <a href="{{ route('rutinas.edit', $rutinaAsignada->id) }}" class="inline-flex items-center justify-center rounded-lg bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-indigo-700">
                                        {{ __('views.edit_routine') }}
                                    </a>
                                    <button type="button" class="inline-flex items-center justify-center rounded-lg bg-white px-4 py-2.5 text-sm font-semibold text-gray-800 ring-1 ring-gray-300 transition hover:bg-gray-50 dark:bg-gray-800 dark:text-gray-100 dark:ring-gray-600 dark:hover:bg-gray-700"
                                        x-data x-on:click="$dispatch('open-modal', 'asignarRutinaModal-{{ $user->id }}')">
                                        {{ __('views.change_routine') }}
                                    </button>
                                    <form method="POST" action="{{ route('clientes.rutina.desasignar', $user->id) }}"
                                        onsubmit="return confirm(@js(__('views.confirm_unassign_routine', ['name' => $user->name])));">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="inline-flex items-center justify-center rounded-lg bg-red-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-red-700">
                                            {{ __('views.unassign_routine') }}
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    @else
                        <div class="mt-6 space-y-5">
                            <div class="rounded-lg border border-dashed border-gray-300 bg-gray-50 p-5 dark:border-gray-600 dark:bg-gray-900/60">
                                <p class="text-sm font-semibold text-gray-900 dark:text-gray-100">{{ __('views.no_routine_assigned_now') }}</p>
                                <p class="mt-2 text-sm leading-6 text-gray-600 dark:text-gray-300">
                                    {{ $esSuEntrenador ? __('views.trainer_can_assign_plan') : __('views.client_can_request_or_create_plan') }}
                                </p>
                            </div>

                            <div class="flex flex-col gap-3 sm:flex-row sm:flex-wrap">
                                @if($esSuEntrenador)
                                    <button type="button" class="inline-flex items-center justify-center rounded-lg bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-indigo-700"
                                        x-data x-on:click="$dispatch('open-modal', 'asignarRutinaModal-{{ $user->id }}')">
                                        {{ __('views.assign_routine') }}
                                    </button>
                                @elseif($entrenadorAsignado)
                                    <a href="{{ route('conversations.start', $entrenadorAsignado->user->id) }}" class="inline-flex items-center justify-center rounded-lg bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-indigo-700">
                                        {{ __('views.request_routine_from_trainer') }}
                                    </a>
                                @else
                                    <a href="{{ route('entrenadores.index') }}" class="inline-flex items-center justify-center rounded-lg bg-emerald-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-emerald-700">
                                        {{ __('views.search_trainers') }}
                                    </a>
                                @endif

								@if(!$esSuEntrenador)
									<a href="{{ route('rutinas.create') }}" class="inline-flex items-center justify-center rounded-lg bg-white px-4 py-2.5 text-sm font-semibold text-gray-800 ring-1 ring-gray-300 transition hover:bg-gray-50 dark:bg-gray-800 dark:text-gray-100 dark:ring-gray-600 dark:hover:bg-gray-700">
                                        {{ __('views.create_routine_for_me') }}
                                    </a>
								@endif
                            </div>
                        </div>
                    @endif
                </section>
				
				<!-- ÚLTIMOS ENTRENAMIENTOS -->
                <section class="rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-200 dark:bg-gray-800 dark:ring-gray-700">
                    <div class="flex flex-col gap-4 border-b border-gray-200 pb-5 dark:border-gray-700 sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <h2 class="text-xl font-bold text-gray-950 dark:text-gray-50">{{ __('views.latest_workouts') }}</h2>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">{{ __('views.latest_workouts_intro') }}</p>
                        </div>
                        <a href="{{ route('usuario.historial', ['id' => $user->id, 'tab' => 'historial_entrenos']) }}" class="inline-flex items-center justify-center rounded-lg bg-white px-4 py-2.5 text-sm font-semibold text-gray-800 ring-1 ring-gray-300 transition hover:bg-gray-50 dark:bg-gray-800 dark:text-gray-100 dark:ring-gray-600 dark:hover:bg-gray-700">
                            {{ __('views.full_history') }}
                        </a>
                    </div>

                    <div class="mt-6 overflow-hidden rounded-lg border border-gray-200 dark:border-gray-700">
                        <div class="hidden grid-cols-2 bg-gray-50 px-4 py-3 text-xs font-semibold uppercase tracking-wide text-gray-500 dark:bg-gray-900 dark:text-gray-400 md:grid">
                            <span>{{ __('views.date') }}</span>
                            <span>{{ __('views.workout') }}</span>
                        </div>

                        <div class="divide-y divide-gray-200 dark:divide-gray-700">
                            @forelse ($ultimosEntrenos as $registro)
                                <article class="grid gap-3 px-4 py-4 text-sm md:grid-cols-2 md:items-center">
                                    <div>
                                        <p class="font-semibold text-gray-900 dark:text-gray-100">{{ $registro['fecha'] }}</p>
                                        <p class="text-gray-500 dark:text-gray-400 md:hidden">{{ __('views.date') }}</p>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-900 dark:text-gray-100">{{ $registro['nombre'] }}</p>
                                        <p class="text-gray-500 dark:text-gray-400 md:hidden">{{ __('views.workout') }}</p>
                                    </div>
                                </article>
                            @empty
                                <div class="px-4 py-6 text-sm text-gray-600 dark:text-gray-300">
                                    {{ __('views.no_workout_registers_available') }}
                                </div>
                            @endforelse
                        </div>
                    </div>
                </section>
            </div>

            @if($esSuEntrenador)
                @include('cliente._partials.dashboard.modal-asignar-rutina', [
                    'user' => $user,
                    'rutinaAsignada' => $rutinaAsignada,
                    'rutinasDisponibles' => $rutinasDisponibles,
                ])

            @endif
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        window.datosGraficaProgreso = @json($datosGrafica);
        window.textosGraficaProgreso = @json([
            'noData' => __('progress-chart.no_data'),
        ]);
    </script>
    @vite('resources/js/cliente/progreso-chart.js')
@endpush

@if($esSuEntrenador)
    @push('scripts')
        @vite('resources/js/list-search.js')
    @endpush
@endif

