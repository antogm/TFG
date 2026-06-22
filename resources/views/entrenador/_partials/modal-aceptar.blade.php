{{-- MODAL ACEPTAR SOLICITUD --}}
@component('components.modal', ['name' => 'aceptarModal-' . $cliente->id])
<div class="p-6">
    <h2 class="text-lg font-medium mb-4 text-gray-900 dark:text-white">
        {{ __('views.accept_request') }}
    </h2>
    <p class="text-gray-600 dark:text-gray-300 mt-2">
        {{ __('views.accept_request_services_confirmation', ['name' => $cliente->name]) }}
    </p>

    <form method="POST" action="{{ route('cliente-entrenador.aceptar', $cliente->id) }}"
        @submit="$dispatch('close-modal', 'aceptarModal-{{ $cliente->id }}')">
        @csrf
        @method('PATCH')
        <div class="flex justify-center gap-8 mt-6">
            <button type="submit" class="bg-emerald-600 text-white px-4 py-2 rounded">
                {{ __('views.accept_request') }}
            </button>
            <button type="button" class="bg-gray-200 px-4 py-2 rounded"
                @click="$dispatch('close-modal', 'aceptarModal-{{ $cliente->id }}')">
                {{ __('views.cancel') }}
            </button>
        </div>
    </form>

</div>
@endcomponent