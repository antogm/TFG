<div class="w-full md:flex-1 rounded-xl border-l-4 border-emerald-500 bg-white p-8 shadow-sm dark:bg-gray-800">
    <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-2">
        {{ __('views.pending_requests_count', ['count' => $numSolicitudesPendientes]) }}
    </h2>

    @php
        if ($numSolicitudesPendientes == 0) {
            $h2text = __('views.no_pending_requests_yet');
        } else if ($numSolicitudesPendientes > 0) {
            $h2text = __('views.pending_requests_advice');
        }
    @endphp

    <p class="text-sm text-gray-600 dark:text-gray-300 mb-6">
        {!! $h2text !!}
    </p>

    @if($numSolicitudesPendientes)
        <div class="flex flex-wrap gap-3">
            <a href="{{ route('entrenador.gestionarSolicitudes') }}"
                class="inline-flex items-center justify-center px-4 py-2 text-sm rounded-lg bg-emerald-600 text-white transition hover:bg-emerald-700">
                {{ __('views.manage_requests') }}
            </a>
        </div>
    @endif
</div>
