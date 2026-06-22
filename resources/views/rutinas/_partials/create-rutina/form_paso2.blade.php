<fieldset data-routine-step-panel="1" class="hidden space-y-4">
@php
    $routineBuilderTranslations = [
        'all_exercises_added' => __('views.all_exercises_added'),
        'characters_count' => __('views.characters_count'),
        'complete_required_fields' => __('views.complete_required_fields'),
        'day_label' => __('views.day_label'),
        'exercise_count_plural' => __('views.exercise_count_plural'),
        'exercise_count_singular' => __('views.exercise_count_singular'),
        'exercise_summary_plural' => __('views.exercise_summary_plural'),
        'exercise_summary_singular' => __('views.exercise_summary_singular'),
        'exercises_load_error' => __('views.exercises_load_error'),
        'loading_exercises' => __('views.loading_exercises'),
        'missing_exercises_by_day' => __('views.missing_exercises_by_day'),
        'no_exercises_available' => __('views.no_exercises_available'),
        'no_muscle_groups_short' => __('views.no_muscle_groups_short'),
        'move_exercise_left_aria' => __('views.move_exercise_left_aria'),
        'move_exercise_right_aria' => __('views.move_exercise_right_aria'),
        'remove_exercise_aria' => __('views.remove_exercise_aria'),
        'review_before_save_aria' => __('views.review_before_save_aria'),
        'save_routine_valid_aria' => __('views.save_routine_valid_aria'),
        'select_exercise' => __('views.select_exercise'),
    ];
@endphp
<script type="application/json" id="routine_builder_translations">
{!! json_encode($routineBuilderTranslations, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT) !!}
</script>
    <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
        <legend class="text-lg font-semibold text-gray-100">
        	{{ __('views.exercises') }}
    	</legend>
			
		<span id="exercise_summary_badge"
            class="inline-flex items-center rounded-full bg-emerald-900/40 px-3 py-1 text-sm font-semibold text-emerald-300">
            {{ __('views.exercise_summary_zero') }}
        </span>
    </div>

    <div
        class="rounded-2xl border border-emerald-900/40 bg-gradient-to-br from-emerald-950/20 via-gray-800 to-gray-800 p-5 shadow-sm">
        <div class="flex flex-col gap-3 lg:flex-row lg:items-start lg:justify-between">
            <div class="max-w-2xl">
	                <h3 class="text-base font-semibold text-gray-100">
	                    {{ __('views.routine_builder') }}
	                </h3>
	                <p class="mt-1 text-sm text-gray-300">
	                    {{ __('views.routine_builder_intro') }}
	                </p>
            </div>
        </div>

        <div
            class="mt-5 rounded-xl border border-dashed border-emerald-900/40 bg-gray-900/50 p-4">

	            <ul class="mt-3 grid gap-2 text-sm text-gray-300 lg:grid-cols-3">
                <li class="rounded-lg bg-emerald-950/20 px-3 py-2">
                    {{ __('views.routine_builder_step_1') }}
                </li>
                <li class="rounded-lg bg-emerald-950/20 px-3 py-2">
                    {{ __('views.routine_builder_step_2') }}
                </li>
                <li class="rounded-lg bg-emerald-950/20 px-3 py-2">
                    {{ __('views.routine_builder_step_3') }}
                </li>
            </ul>
        </div>

        <div id="exercise_days_container" class="mt-5 space-y-4"
            data-create-exercise-url="{{ route('ejercicios.create', ['from_routine' => 1]) }}"
            data-exercise-catalog-url="{{ route('api.ejercicios.catalogo') }}"
            data-initial-day-plans='@json($dayPlans ?? [])'>
            <div id="routine_exercise_validation_message"
                class="hidden rounded-lg border border-red-300 bg-red-50 p-4 text-sm font-medium text-red-700 dark:border-red-800 dark:bg-red-950/30 dark:text-red-300"
                role="alert" aria-live="polite">
            </div>

            <div data-exercise-no-days
                class="hidden rounded-2xl border border-dashed border-gray-700 bg-gray-900/40 px-6 py-10 text-center">
                <p class="text-base font-semibold text-gray-100">
                    {{ __('views.define_routine_days_first') }}
                </p>
                <p class="mt-2 text-sm text-gray-300">
                    {{ __('views.routine_days_first_help') }}
                </p>
            </div>

            @for ($dayIndex = 0; $dayIndex < 7; $dayIndex++)
                <section data-exercise-day-card="{{ $dayIndex }}"
                    class="hidden rounded-2xl border border-slate-700 bg-slate-900/70 p-5 shadow-sm">
                    <div class="flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
                        <div>
                            <div class="flex flex-wrap items-center gap-3">
                                <h3 class="text-lg font-semibold text-slate-100">
                                    {{ __('views.day_number', ['number' => $dayIndex + 1]) }}
                                </h3>
                                <span
                                    class="inline-flex items-center rounded-full bg-emerald-900/40 px-3 py-1 text-xs font-semibold text-emerald-300">
                                    <span data-exercise-day-count="{{ $dayIndex }}">{{ __('views.exercise_count_zero') }}</span>
                                </span>
                            </div>
                            <p class="mt-1 text-sm text-slate-300">
                                {{ __('views.day_exercise_intro') }}
                            </p>
                        </div>
                    </div>

                    <div class="mt-5">
                        <label for="day-name-{{ $dayIndex }}" class="block text-sm font-medium text-slate-100">
                            {{ __('views.day_name_optional') }}
                        </label>
                        <input id="day-name-{{ $dayIndex }}" type="text" maxlength="100"
                            data-day-name-input="{{ $dayIndex }}"
                            placeholder="{{ __('views.day_name_placeholder') }}"
                            class="mt-2 block w-full rounded-lg border-slate-600 bg-slate-800 text-sm text-slate-100 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 placeholder:text-slate-400"
                            disabled>
                        <p class="mt-2 text-xs text-slate-400">
                            {{ __('views.day_name_help') }}
                        </p>
                    </div>

                    <div class="mt-5 rounded-2xl border border-slate-700 bg-slate-950/40 p-4">
                        <div class="grid gap-4 xl:grid-cols-[minmax(0,1fr)_auto_auto]">
                            <div>
                                <label for="day-exercise-{{ $dayIndex }}"
                                    class="block text-sm font-medium text-slate-100">
                                    {{ __('views.exercise') }}
                                </label>
                                <select id="day-exercise-{{ $dayIndex }}" data-day-exercise-select="{{ $dayIndex }}"
                                    class="mt-2 block w-full rounded-lg border-slate-600 bg-slate-800 text-slate-100 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 placeholder:text-slate-400">
                                    <option value="">{{ __('views.select_exercise') }}</option>
                                </select>
                                <p class="mt-2 text-xs text-slate-400">
                                    {{ __('views.select_existing_exercise_help') }}
                                </p>
                            </div>

                            <button type="button" data-add-exercise="{{ $dayIndex }}"
                                class="inline-flex items-center justify-center rounded-lg bg-emerald-500 px-4 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-emerald-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 focus:ring-offset-gray-800">
                                {{ __('views.add_exercise') }}
                            </button>

                            <a href="{{ route('ejercicios.create', ['from_routine' => 1]) }}" target="_blank"
                                rel="opener"
                                class="inline-flex items-center justify-center rounded-lg border border-slate-600 bg-slate-800 px-4 py-3 text-sm font-medium text-slate-200 transition hover:bg-slate-700 focus:outline-none focus:ring-2 focus:ring-slate-500 focus:ring-offset-2 focus:ring-offset-gray-800">
                                {{ __('views.not_found') }}
                            </a>
                        </div>
                    </div>

                    <div class="mt-4">
                        <div data-exercise-empty-state="{{ $dayIndex }}"
                            class="rounded-2xl border border-dashed border-slate-600 bg-slate-900/50 px-4 py-10 text-center">
                            <p class="text-sm font-medium text-slate-200">
                                {{ __('views.no_exercises_day') }}
                            </p>
                            <p class="mt-1 text-sm text-slate-400">
                                {{ __('views.choose_or_create_exercise') }}
                            </p>
                        </div>
                        <div data-exercise-list="{{ $dayIndex }}" class="hidden flex flex-wrap gap-3"></div>
                    </div>
                </section>
            @endfor
        </div>

        <template id="exercise_row_template">
            @include('rutinas._partials.create-rutina.card-ejercicio')
        </template>
    </div>
</fieldset>
