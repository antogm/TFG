{{-- ACCIONES --}}
<div class="flex flex-wrap gap-3 mt-4 sm:mt-0">
	<a href="{{ route('entrenadores.show', $entrenador) }}"
		class="px-4 py-2 text-sm rounded-lg border border-indigo-200 bg-indigo-50 text-indigo-700 transition hover:bg-indigo-100 dark:border-indigo-800 dark:bg-indigo-950/40 dark:text-indigo-200 dark:hover:bg-indigo-900/60">
		{{ __("views.details") }}
	</a>

	@if($entrenador->user->id !== auth()->id())
		<a href="{{ route('conversations.start', $entrenador->user->id) }}"
			class="px-4 py-2 text-sm rounded-lg text-white transition {{ $entrenador->user->bloquear_mensajes_desconocidos && !in_array($entrenador->user->id, $conocidos, true) ? 'bg-red-600 hover:bg-red-700' : 'bg-gray-600 hover:bg-gray-700' }}">
			{{ __('views.private_message') }}
		</a>

		@if($solicitudPendienteId === $entrenador->user->id)
			<form method="POST" action="{{ route('cliente-entrenador.cancelar', $entrenador->user->id) }}"
				onsubmit="return confirm(@js(__('views.confirm_cancel_collaboration_request_to', ['name' => $entrenador->user->name])));">
				@csrf
				@method('PATCH')
				<button type="submit"
					class="px-4 py-2 text-sm rounded-lg bg-red-600 text-white hover:bg-red-700 transition">
					{{ __('views.cancel_request') }}
				</button>
			</form>
		@else
			<a href="#" x-data x-on:click.prevent="$dispatch('open-modal', 'solicitarModal-{{ $entrenador->id }}')"
				class="px-4 py-2 text-sm rounded-lg text-white transition {{ $entrenador->bloquear_solicitudes_entrantes ? 'bg-red-600 hover:bg-red-700' : 'bg-emerald-600 hover:bg-emerald-700' }}">
				{{ __('views.request_services') }}
			</a>

			@include('cliente._partials.lista-entrenadores.modal-solicitar', [
				'entrenador' => $entrenador,
			])
		@endif
	@endif
</div>
