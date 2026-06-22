<li class="flex flex-col border-b border-gray-200 pb-4 last:border-b-0 sm:flex-row sm:items-center sm:justify-between">

	{{-- INFO --}}
	<div class="flex min-w-0 items-center gap-4">
		<img src="{{ Storage::url($entrenador->user->imagen ?? 'default-pp.png') }}" alt="{{ $entrenador->user->name }}"
			class="h-16 w-16 shrink-0 rounded-full object-cover">

		<div class="min-w-0">
			<h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">
				{{ $entrenador->user->name }}
			</h3>
			<p class="text-gray-600 dark:text-gray-300 text-sm">
				{{ $entrenador->user->email }}
			</p>
			<div class="mt-2 flex flex-wrap items-center gap-2">
				@if ($entrenador->rating === null)
					<span class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __("views.no_reviews") }}</span>
				@else
					<span class="text-sm font-semibold text-gray-900 dark:text-gray-100">{{ number_format(round((float) $entrenador->rating * 2) / 2, 1) }}</span>
					<div class="flex gap-0.5" aria-label="{{ __("views.rating_out_of_five", ["rating" => number_format(round((float) $entrenador->rating * 2) / 2, 1)]) }}">
						@for ($estrella = 1; $estrella <= 5; $estrella++)
							<span class="relative block h-4 w-4 text-gray-300 dark:text-gray-600">
								@component('components.rating-star')
								@endcomponent
								@if (round((float) $entrenador->rating * 2) / 2 >= $estrella - 0.5)
									<span class="absolute left-0 top-0 block h-4 overflow-hidden text-yellow-400 {{ round((float) $entrenador->rating * 2) / 2 >= $estrella ? 'w-full' : 'w-1/2' }}">
										@component('components.rating-star')
										@endcomponent
									</span>
								@endif
							</span>
						@endfor
					</div>
				@endif
			</div>
		</div>
	</div>

	{{-- ACCIONES --}}
	@include('cliente._partials.lista-entrenadores.entrenador-actions', [
		'entrenador' => $entrenador,
		'solicitudPendienteId' => $solicitudPendienteId,
		'conocidos' => $conocidos,
	])
	
</li>
