<p class="mb-6 text-sm text-gray-600 dark:text-gray-300">
	{{ __('views.required_fields_prefix') }} <span class="font-semibold text-red-600 dark:text-red-400">*</span>
	{{ __('views.required_fields_suffix') }}
</p>

<div id="routine_step_one_validation_message"
	class="mb-6 hidden rounded-lg border border-red-300 bg-red-50 p-4 text-sm font-medium text-red-700 dark:border-red-800 dark:bg-red-950/30 dark:text-red-300"
	role="alert" aria-live="polite">
</div>

<div data-routine-step-panel="0" class="flex flex-wrap gap-6">
	<fieldset
		class="flex min-w-0 flex-[1_1_22rem] flex-col space-y-4 rounded-xl border border-orange-200 border-l-4 border-l-orange-500 p-5 dark:border-orange-900/50 dark:border-l-orange-400">
		<legend class="text-lg font-semibold text-gray-900 dark:text-gray-100">
			{{ __('views.general_information') }}
		</legend>

		<div>
			<x-input-label for="nombre" :value="__('views.name_required')" class="!text-base !font-semibold" />
			<x-text-input id="nombre" class="mt-1 w-full focus:border-emerald-500 focus:ring-emerald-500" type="text"
				name="nombre" :value="old('nombre', isset($rutina) ? $rutina->nombre : null)" maxlength="100" aria-describedby="nombre_help nombre_count"
				required autofocus autocomplete="off" />
			<div class="mt-2 flex items-center justify-between text-xs text-gray-500 dark:text-gray-400">
				<p id="nombre_help">{{ __('views.routine_name_help') }}</p>
				<p id="nombre_count" aria-live="polite">0/100</p>
			</div>
			<x-input-error :messages="$errors->get('nombre')" class="mt-2" />
		</div>

		<div class="flex flex-1 flex-col">
			<x-input-label for="descripcion" :value="__('views.description')" class="!text-base !font-semibold" />
			<textarea id="descripcion" name="descripcion" maxlength="255"
				aria-describedby="descripcion_help descripcion_count"
				class="mt-1 min-h-48 w-full flex-1 resize-none rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100">{{ old('descripcion', isset($rutina) ? $rutina->descripcion : null) }}</textarea>
			<div class="mt-2 flex items-center justify-between text-xs text-gray-500 dark:text-gray-400">
				<p id="descripcion_help">{{ __('views.routine_description_help') }}</p>
				<p id="descripcion_count" aria-live="polite">0/255</p>
			</div>
			<x-input-error :messages="$errors->get('descripcion')" class="mt-2" />
		</div>
	</fieldset>

	<fieldset
		class="min-w-0 flex-[1.6_1_32rem] space-y-5 rounded-xl border border-orange-200 border-l-4 border-l-orange-500 p-5 dark:border-orange-900/50 dark:border-l-orange-400">
		<legend class="text-lg font-semibold text-gray-900 dark:text-gray-100">
			{{ __('views.goals_and_frequency') }}
		</legend>
		<p class="text-sm text-gray-600 dark:text-gray-300">
			{{ __('views.optional_goals_help') }}
		</p>

		<div class="flex flex-col gap-5">
			<div
				class="flex flex-col gap-3 border-t border-gray-100 pt-4 dark:border-white/5 lg:flex-row lg:items-start lg:justify-between">
				<div class="lg:max-w-56">
					<x-input-label for="dias_entreno_1" :value="__('views.training_days_per_week_required')"
						class="!text-base !font-semibold" />
					<p id="dias_entreno_help" class="mt-2 text-xs text-gray-500 dark:text-gray-400">
						{{ __('views.training_days_help') }}
					</p>
					<x-input-error :messages="$errors->get('dias_entreno')" class="mt-2" />
				</div>

				<div class="grid w-full max-w-md grid-cols-7 gap-1.5" role="radiogroup"
					aria-describedby="dias_entreno_help">
					@for ($dia = 1; $dia <= 7; $dia++)
						<label class="cursor-pointer">
							<input id="dias_entreno_{{ $dia }}" type="radio" name="dias_entreno" value="{{ $dia }}"
								class="peer sr-only" @checked((string) old('dias_entreno', isset($rutina) ? $rutina->dias_entreno : '3') === (string) $dia) required>
							<span
								class="flex h-11 items-center justify-center rounded-md border border-gray-300 bg-gray-100 text-sm font-semibold text-gray-700 transition hover:bg-gray-200 peer-checked:border-emerald-600 peer-checked:bg-emerald-600 peer-checked:text-white peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-emerald-500 peer-focus:ring-offset-2 dark:border-gray-600 dark:bg-gray-900/70 dark:text-gray-300 dark:hover:bg-gray-800 dark:peer-checked:border-emerald-500 dark:peer-checked:bg-emerald-500 dark:peer-checked:text-white dark:peer-focus:ring-offset-gray-800">
								{{ $dia }}
							</span>
						</label>
					@endfor
				</div>
			</div>

			<div
				class="flex flex-col gap-3 border-t border-gray-100 pt-4 dark:border-white/5 lg:flex-row lg:items-start lg:justify-between">
				<div class="lg:max-w-56">
					<x-input-label for="kcal_objetivo" :value="__('views.daily_calories')"
						class="!text-base !font-semibold" />
					<p id="kcal_objetivo_help" class="mt-2 text-xs text-gray-500 dark:text-gray-400">
						{{ __('views.daily_calories_help') }}
					</p>
					<x-input-error :messages="$errors->get('kcal_objetivo')" class="mt-2" />
				</div>
				<x-text-input id="kcal_objetivo" class="w-full max-w-md focus:border-emerald-500 focus:ring-emerald-500"
					type="number" name="kcal_objetivo" :value="old('kcal_objetivo', isset($rutina) ? $rutina->kcal_objetivo : null)" min="0" max="10000" step="1"
					inputmode="numeric" aria-describedby="kcal_objetivo_help" />
			</div>

			<div
				class="flex flex-col gap-3 border-t border-gray-100 pt-4 dark:border-white/5 lg:flex-row lg:items-start lg:justify-between">
				<div class="lg:max-w-56">
					<x-input-label for="duracion_aproximada_min" :value="__('views.approx_duration_min')"
						class="!text-base !font-semibold" />
					<p id="duracion_aproximada_min_help" class="mt-2 text-xs text-gray-500 dark:text-gray-400">
						{{ __('views.approx_duration_help') }}
					</p>
					<x-input-error :messages="$errors->get('duracion_aproximada_min')" class="mt-2" />
				</div>
				<x-text-input id="duracion_aproximada_min"
					class="w-full max-w-md focus:border-emerald-500 focus:ring-emerald-500" type="number"
					name="duracion_aproximada_min" :value="old('duracion_aproximada_min', isset($rutina) ? $rutina->duracion_aproximada_min : null)" min="1" max="600" step="1"
					inputmode="numeric" aria-describedby="duracion_aproximada_min_help" />
			</div>

			<div
				class="flex flex-col gap-3 border-t border-gray-100 pt-4 dark:border-white/5 lg:flex-row lg:items-start lg:justify-between">
				<div class="lg:max-w-56">
					<x-input-label for="pasos_objetivo" :value="__('views.daily_steps')" class="!text-base !font-semibold" />
					<p id="pasos_objetivo_help" class="mt-2 text-xs text-gray-500 dark:text-gray-400">
						{{ __('views.daily_steps_help') }}
					</p>
					<x-input-error :messages="$errors->get('pasos_objetivo')" class="mt-2" />
				</div>
				<x-text-input id="pasos_objetivo"
					class="w-full max-w-md focus:border-emerald-500 focus:ring-emerald-500" type="number"
					name="pasos_objetivo" :value="old('pasos_objetivo', isset($rutina) ? $rutina->pasos_objetivo : null)" min="0" max="100000" step="1"
					inputmode="numeric" aria-describedby="pasos_objetivo_help" />
			</div>
		</div>
	</fieldset>
</div>
