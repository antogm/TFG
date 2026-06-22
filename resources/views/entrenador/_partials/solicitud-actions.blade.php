<div class="flex gap-3 mt-4 sm:mt-0">
	<a href="{{ route('conversations.start', $cliente->id) }}"
		class="px-4 py-2 text-sm rounded-lg bg-gray-200 text-gray-800 dark:bg-gray-700 dark:text-white transition">
		{{ __('views.private_message') }}
	</a>

	<a href="#" x-data x-on:click.prevent="$dispatch('open-modal', 'aceptarModal-{{ $cliente->id }}')"
		class="px-4 py-2 text-sm rounded-lg bg-emerald-600 text-white hover:bg-emerald-700 transition">
		{{ __('views.accept_request') }}
	</a>

	<a href="#" x-data x-on:click.prevent="$dispatch('open-modal', 'rechazarModal-{{ $cliente->id }}')"
		class="px-4 py-2 text-sm rounded-lg bg-red-600 text-white hover:bg-emerald-700 transition">
		{{ __('views.reject_request') }}
	</a>
</div>

@include('entrenador._partials.modal-rechazar', ['cliente' => $cliente])
@include('entrenador._partials.modal-aceptar', ['cliente' => $cliente])