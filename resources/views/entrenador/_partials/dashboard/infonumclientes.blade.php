<div class="w-full md:flex-1 rounded-xl border-l-4 border-emerald-500 bg-white p-8 shadow-sm dark:bg-gray-800">
    <h2 class="mb-2 text-2xl font-bold text-gray-900 dark:text-gray-100">
        {{ __('views.clients_count', ['count' => $numClientes]) }}
    </h2>

    @php
        if ($numClientes == 0) {
            $h2text = __('views.attract_candidates_tip');
        } else if ($numClientes > 0) {
            $h2text = __('views.clients_review_advice');
        }
    @endphp

    <p class="mb-6 text-sm text-gray-600 dark:text-gray-300">
        {{ $h2text }}
    </p>

    <a href="{{ route('entrenador.clientes') }}"
        class="inline-flex items-center rounded-lg bg-emerald-600 px-4 py-2 text-sm font-medium text-white transition hover:bg-emerald-700">
        {{ __('nav.my_clients') }}
    </a>
</div>
