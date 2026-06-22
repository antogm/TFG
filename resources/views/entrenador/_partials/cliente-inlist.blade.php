<li
    data-search-item data-search-text="{{ strtolower($cliente->name) }}"
    class="flex flex-col gap-3 border-b border-gray-200 pb-4 last:border-b-0 md:flex-row md:items-start md:justify-between md:gap-6">

    <div class="flex min-w-0 flex-1 flex-row flex-wrap gap-4 md:gap-x-10 md:gap-y-3">
        {{-- FOTO DE PERFIL, NOMBRE Y CORREO --}}
		<div class="flex min-w-0 items-center gap-4">
            <img src="{{ Storage::url($cliente->imagen ?? 'default-pp.png') }}" alt="{{ $cliente->name }}"
                class="h-16 w-16 shrink-0 rounded-full object-cover">

            <div class="min-w-0">
                <h3 class="truncate text-lg font-medium text-gray-900 dark:text-gray-100">
                    {{ $cliente->name }}
                </h3>

                <p class="truncate text-sm text-gray-600 dark:text-gray-300">
                    {{ $cliente->email }}
                </p>
            </div>
        </div>

		{{-- FECHAS --}}
        <div class="min-w-0 text-xs text-gray-600 dark:text-gray-300 md:self-center">
            <p class="break-words leading-5">
                {{ __('views.latest_body_measurement') }}: {{ $cliente->ultimoRegistroCorporal?->fecha_registro?->format('d/m/Y') ?? '-' }}
            </p>
            <p class="mt-0.5 break-words leading-5">
                {{ __('views.latest_workout') }}: {{ $cliente->ultimoRegistroEntrenamiento?->fecha_entrenamiento?->format('d/m/Y') ?? '-' }}
            </p>
        </div>
    </div>

    {{-- ACCIONES --}}
    <div class="flex flex-row flex-wrap gap-3 md:w-[35%] md:max-w-[35%] md:shrink-0 md:justify-end">
        @if ($cliente->id !== auth()->id())
            <a href="{{ route('conversations.start', $cliente->id) }}"
                class="rounded-lg bg-gray-200 px-4 py-2 text-sm text-gray-800 transition dark:bg-gray-700 dark:text-white">
                {{ __('views.private_message') }}
            </a>
        @endif

        <a href="{{ route('usuario.progreso', $cliente->id) }}"
            class="rounded-lg bg-emerald-600 px-4 py-2 text-sm text-white transition hover:bg-emerald-700">
            {{ __('views.review_progress') }}
        </a>

        <form method="POST"
            action="{{ route('cliente-entrenador.cancelar', ['entrenador' => auth()->id(), 'cliente' => $cliente->id]) }}"
            onsubmit="return confirm('{{ __('views.confirm_cancel_trainer_collaboration') }}');">
            @csrf
            @method('PATCH')

            <button type="submit"
                class="rounded-lg bg-red-600 px-4 py-2 text-sm text-white transition hover:bg-red-700">
                {{ __('views.cancel_collaboration') }}
            </button>
        </form>
    </div>
</li>
