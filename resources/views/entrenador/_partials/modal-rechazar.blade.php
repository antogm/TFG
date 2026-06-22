{{-- MODAL CANCELAR SOLICITUD --}}
@component('components.modal', ['name' => 'rechazarModal-' . $cliente->id])
<div class="p-6">
    <h2 class="text-lg font-medium mb-4 text-gray-900 dark:text-white">
        {{ __('views.reject_request') }}
    </h2>
    <p class="text-gray-600 dark:text-gray-300 mt-2">
        {{ __('views.reject_request_confirmation', ['name' => $cliente->name]) }}
    </p>

    <form method="POST" action="{{ route('cliente-entrenador.rechazar', $cliente->id) }}"
        @submit="$dispatch('close-modal', 'rechazarModal-{{ $cliente->id }}')">
        @csrf
        @method('PATCH')
        <div class="flex justify-center gap-8 mt-6">
            <button type="submit" class="bg-emerald-600 text-white px-4 py-2 rounded">
                {{ __('views.confirm') }}
            </button>
            <button type="button" class="bg-gray-200 px-4 py-2 rounded"
                @click="$dispatch('close-modal', 'rechazarModal-{{ $cliente->id }}')">
                {{ __('views.cancel') }}
            </button>
        </div>
    </form>
</div>
@endcomponent