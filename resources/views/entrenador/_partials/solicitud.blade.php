<li class="flex flex-col sm:flex-row sm:items-center sm:justify-between border-b border-gray-200 pb-4 last:border-b-0">
    {{-- INFO --}}
    <div class="flex min-w-0 items-center gap-4">
        <img src="{{ Storage::url($cliente->imagen ?? 'default-pp.png') }}" alt="{{ $cliente->name }}"
            class="h-16 w-16 shrink-0 rounded-full object-cover">

        <div class="min-w-0">
            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ $cliente->name }}
            </h3>

            <p class="text-gray-600 dark:text-gray-300 text-sm">
                {{ $cliente->email }}
            </p>
        </div>
    </div>

    {{-- ACCIONES --}}
	@include('entrenador._partials.solicitud-actions', [
		'cliente' => $cliente,
	])
</li>
