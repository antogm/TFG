{{-- MODAL SOLICITAR SERVICIOS --}}
@component('components.modal', ['name' => 'solicitarModal-' . $entrenador->id])
<div class="p-6">
    <h2 class="text-lg font-medium mb-4 text-gray-900 dark:text-white">
        {{ __('views.request_services') }}
    </h2>

	@if($entrenador->bloquear_solicitudes_entrantes)
        <p class="text-gray-600 dark:text-gray-300 mt-2">
            {{ __('views.trainer_not_accepting_requests') }}
        </p>

		<div class="flex justify-center gap-8 mt-6">
			<button type="button" class="bg-gray-200 px-4 py-2 rounded"
                @click="$dispatch('close-modal', 'solicitarModal-{{ $entrenador->id }}')">
				{{ __('views.close') }}
			</button>
		</div>

	@else
		<p class="text-gray-600 dark:text-gray-300 mt-2">
            {{ __('views.confirm_request_trainer_services', ['name' => $entrenador->user->name]) }}
        </p>

        <form method="POST" action="{{ route('cliente-entrenador.solicitar', $entrenador->user->id) }}"
            @submit="$dispatch('close-modal', 'solicitarModal-{{ $entrenador->id }}')">
            @csrf
            <div class="flex justify-center gap-8 mt-6">
                <button type="submit" class="bg-emerald-600 text-white px-4 py-2 rounded">
                    {{ __('views.request') }}
                </button>
                <button type="button" class="bg-gray-200 px-4 py-2 rounded"
                    @click="$dispatch('close-modal', 'solicitarModal-{{ $entrenador->id }}')">
                    {{ __('views.cancel') }}
                </button>
            </div>
        </form>
    @endif
</div>
@endcomponent