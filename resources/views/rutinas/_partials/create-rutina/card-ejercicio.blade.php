<div data-exercise-row
    class="w-full max-w-full flex-none rounded-xl border border-slate-700 bg-slate-900/80 p-4 shadow-sm transition sm:w-[calc(50%-0.5rem)] xl:w-[15.5rem]">
    <div class="mb-4 grid grid-cols-[1fr_auto_1fr] items-start gap-3">
        <div aria-hidden="true"></div>

        <div class="flex items-center justify-center gap-1 justify-self-center rounded-xl border border-slate-700 bg-slate-800/80 p-1 shadow-sm">
            @component('components.flecha-horizontal', [
                'title' => __('views.move_exercise_left'),
                'ariaLabel' => __('views.move_exercise_left'),
                'direction' => 'left',
                'dataAttributes' => ['data-move-exercise-left' => ''],
            ])
            @endcomponent

            @component('components.flecha-horizontal', [
                'title' => __('views.move_exercise_right'),
                'ariaLabel' => __('views.move_exercise_right'),
                'direction' => 'right',
                'dataAttributes' => ['data-move-exercise-right' => ''],
            ])
            @endcomponent
        </div>

        <button type="button" data-remove-exercise-button
            class="inline-flex h-8 w-8 shrink-0 items-center justify-center justify-self-end rounded-lg border border-red-900/40 bg-red-950/20 text-sm font-semibold text-red-300 transition hover:bg-red-950/40 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 focus:ring-offset-slate-900">
            ×
        </button>
    </div>

    <div class="flex items-start gap-3">
        <div class="h-14 w-14 shrink-0 overflow-hidden rounded-xl border border-slate-700 bg-slate-800/90">
            <img data-exercise-image class="h-full w-full object-cover" alt="" hidden>
            <div data-exercise-image-fallback
                class="flex h-full w-full items-center justify-center text-[10px] font-semibold uppercase tracking-[0.2em] text-slate-300">
            </div>
        </div>

        <div class="min-w-0 flex-1">
            <h4 data-exercise-name class="truncate text-sm font-semibold text-slate-100"></h4>
            <p data-exercise-group class="mt-1 line-clamp-2 text-xs leading-5 text-slate-400"></p>
        </div>
    </div>

    <input type="hidden" data-exercise-id-input>
    <input type="hidden" data-exercise-name-input>

    <div class="mt-4 grid grid-cols-2 gap-x-3 gap-y-3">
        <div>
            <label data-exercise-series-label class="block text-[11px] font-semibold uppercase tracking-wide text-slate-400">
                {{ __('views.sets') }}
            </label>
            <input type="number" min="1" max="20" step="1" inputmode="numeric"
                data-exercise-field="series"
                required
                class="mt-1.5 block w-full rounded-lg border-slate-600 bg-slate-800 text-sm text-slate-100 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 placeholder:text-slate-400">
        </div>

        <div>
            <label data-exercise-repetitions-label class="block text-[11px] font-semibold uppercase tracking-wide text-slate-400">
                {{ __('views.reps') }}
            </label>
            <input type="number" min="1" max="100" step="1" inputmode="numeric"
                data-exercise-field="repeticiones"
                required
                class="mt-1.5 block w-full rounded-lg border-slate-600 bg-slate-800 text-sm text-slate-100 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 placeholder:text-slate-400">
        </div>

        <div>
            <label data-exercise-load-label class="block text-[11px] font-semibold uppercase tracking-wide text-slate-400">
                {{ __('views.load') }}
            </label>
            <input type="number" min="0" max="65535" step="1" inputmode="numeric"
                data-exercise-field="carga" placeholder="20"
                class="mt-1.5 block w-full rounded-lg border-slate-600 bg-slate-800 text-sm text-slate-100 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 placeholder:text-slate-400">
        </div>

        <div class="col-span-2">
            <label data-exercise-duration-label class="block text-[11px] font-semibold uppercase tracking-wide text-slate-400">
                {{ __('views.duration_optional') }}
            </label>
            <div class="mt-1.5 grid w-full grid-cols-[4.25rem_minmax(0,1fr)] gap-2">
                <input type="number" min="1" step="1" inputmode="numeric"
                    data-exercise-duration-value placeholder="45"
                    class="block min-w-0 w-full rounded-lg border-slate-600 bg-slate-800 text-sm text-slate-100 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 placeholder:text-slate-400">
                <select data-exercise-duration-unit
                    class="block min-w-0 w-full rounded-lg border-slate-600 bg-slate-800 px-2 py-2 text-sm text-slate-100 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                    <option value="seconds">{{ __('views.seconds') }}</option>
                    <option value="minutes">{{ __('views.minutes') }}</option>
                    <option value="hours">{{ __('views.hours') }}</option>
                </select>
            </div>
            <input type="hidden" data-exercise-duration-seconds-input>
        </div>
    </div>
</div>
