
<!-- RESUMEN CORPORAL -->
<section class="grid gap-5 md:grid-cols-2 xl:grid-cols-4">
	<article class="rounded-xl bg-white p-5 shadow-sm ring-1 ring-gray-200 dark:bg-gray-800 dark:ring-gray-700">
		<p class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('views.current_weight') }}</p>
		<div class="mt-3 flex items-end justify-between gap-3">
			<p class="text-3xl font-bold text-gray-950 dark:text-gray-50">
				{{ $resumenCorporal['peso'] ?? "--" }} kg
			</p>
			<span class="rounded-md px-2.5 py-1 text-xs font-semibold
				@if($variacionesCorporales['peso']['estado'] === 'positivo') bg-emerald-50 text-emerald-700 dark:bg-emerald-950/40 dark:text-emerald-300
				@elseif($variacionesCorporales['peso']['estado'] === 'negativo') bg-red-50 text-red-700 dark:bg-red-950/40 dark:text-red-300
				@else bg-gray-100 text-gray-600 dark:bg-gray-900 dark:text-gray-300
				@endif
			">
				{{ $variacionesCorporales['peso']['valor'] }} *
			</span>
		</div>
	</article>

	<article class="rounded-xl bg-white p-5 shadow-sm ring-1 ring-gray-200 dark:bg-gray-800 dark:ring-gray-700">
		<p class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('views.muscle_mass') }}</p>
		<div class="mt-3 flex items-end justify-between gap-3">
			<p class="text-3xl font-bold text-gray-950 dark:text-gray-50">
				{{ $resumenCorporal['masa_muscular'] ?? "--" }} kg
			</p>
			<span class="rounded-md px-2.5 py-1 text-xs font-semibold
				@if($variacionesCorporales['masa_muscular']['estado'] === 'positivo') bg-emerald-50 text-emerald-700 dark:bg-emerald-950/40 dark:text-emerald-300
				@elseif($variacionesCorporales['masa_muscular']['estado'] === 'negativo') bg-red-50 text-red-700 dark:bg-red-950/40 dark:text-red-300
				@else bg-gray-100 text-gray-600 dark:bg-gray-900 dark:text-gray-300
				@endif
			">
				{{ $variacionesCorporales['masa_muscular']['valor'] }} *
			</span>
		</div>
	</article>

	<article class="rounded-xl bg-white p-5 shadow-sm ring-1 ring-gray-200 dark:bg-gray-800 dark:ring-gray-700">
		<p class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('views.body_fat') }}</p>
		<div class="mt-3 flex items-end justify-between gap-3">
			<p class="text-3xl font-bold text-gray-950 dark:text-gray-50">
				{{ $resumenCorporal['porcentaje_grasa'] ?? "--" }} %
			</p>
			<span class="rounded-md px-2.5 py-1 text-xs font-semibold
				@if($variacionesCorporales['porcentaje_grasa']['estado'] === 'positivo') bg-emerald-50 text-emerald-700 dark:bg-emerald-950/40 dark:text-emerald-300
				@elseif($variacionesCorporales['porcentaje_grasa']['estado'] === 'negativo') bg-red-50 text-red-700 dark:bg-red-950/40 dark:text-red-300
				@else bg-gray-100 text-gray-600 dark:bg-gray-900 dark:text-gray-300
				@endif
			">
				{{ $variacionesCorporales['porcentaje_grasa']['valor'] }} *
			</span>
		</div>
	</article>

	<article class="rounded-xl bg-white p-5 shadow-sm ring-1 ring-gray-200 dark:bg-gray-800 dark:ring-gray-700">
		<p class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('views.main_goal') }}</p>
		<p class="mt-3 text-2xl font-bold text-gray-950 dark:text-gray-50">{{ __("views.goal_values")[$user->objetivo] ?? $user->objetivo }}</p>
	</article>

	<p class="col-span-full text-xs text-gray-500 dark:text-gray-400">
		@if($user->ultimoRegistroCorporal?->fecha_registro)
			{{ __('views.latest_body_measurement') }}: {{ $user->ultimoRegistroCorporal->fecha_registro->format('d/m/Y') }}.
		@else
			{{ __('views.body_measurements_empty_intro') }}
		@endif
		<br>
		{{ __('views.intervals_first_last_measurement') }}
	</p>
</section>
