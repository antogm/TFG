@php($esSuEntrenador = $esSuEntrenador ?? false)

<section class="rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-200 dark:bg-gray-800 dark:ring-gray-700">
    <div class="border-b border-gray-200 pb-5 dark:border-gray-700">
        <h2 class="text-xl font-bold text-gray-950 dark:text-gray-50">
            {{ __('views.trainer_assigned') }}
        </h2>
        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
            {{ __('views.trainer_relationship_intro') }}
        </p>
    </div>

    @if($entrenadorAsignado)
        <div class="mt-6 flex flex-col gap-5 sm:flex-row sm:items-start sm:justify-between">
            <div class="flex min-w-0 items-start gap-4">
                <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-lg bg-emerald-100 text-lg font-bold text-emerald-700 dark:bg-emerald-950/40 dark:text-emerald-300">
                    {{ strtoupper(substr($entrenadorAsignado->user->name, 0, 1)) }}
                </div>

                <div class="min-w-0">
                    <h3 class="truncate text-lg font-semibold text-gray-950 dark:text-gray-50">
                        {{ $entrenadorAsignado->user->name }}
                    </h3>
                    <p class="truncate text-sm text-gray-600 dark:text-gray-300">
                        {{ $entrenadorAsignado->user->email }}
                    </p>

                    @if(!empty($entrenadorAsignado->especialidad))
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                            {{ __('views.trainer_specialty', ['specialty' => $entrenadorAsignado->especialidad]) }}
                        </p>
                    @endif
                </div>
            </div>

            <div class="flex shrink-0 flex-wrap gap-3 sm:justify-end">
                @if(! $esSuEntrenador)
                    <a href="{{ route('entrenadores.show', $entrenadorAsignado->id) }}" class="inline-flex items-center justify-center rounded-lg bg-emerald-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-emerald-700">
                        {{ __('views.details') }}
                    </a>

                    <a href="{{ route('conversations.start', $entrenadorAsignado->user->id) }}" class="inline-flex items-center justify-center rounded-lg bg-white px-4 py-2.5 text-sm font-semibold text-gray-800 ring-1 ring-gray-300 transition hover:bg-gray-50 dark:bg-gray-800 dark:text-gray-100 dark:ring-gray-600 dark:hover:bg-gray-700">
                        {{ __('views.send_private_message') }}
                    </a>
                @endif

                <form action="{{ route('cliente-entrenador.cancelar', ['cliente' => $user->id, 'entrenador' => $entrenadorAsignado->id]) }}"
                    method="POST"
                    onsubmit="return confirm(@js(__('views.confirm_cancel_trainer_collaboration')));">
                    @csrf
                    @method('PATCH')

                    <button type="submit" class="inline-flex items-center justify-center rounded-lg bg-red-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-red-700">
                        {{ __('views.cancel_collaboration') }}
                    </button>
                </form>
            </div>
        </div>
    @else
        <div class="mt-6 rounded-lg border border-dashed border-gray-300 bg-gray-50 p-5 dark:border-gray-600 dark:bg-gray-900/60">
            <h3 class="text-base font-semibold text-gray-950 dark:text-gray-50">
                {{ __('views.no_assigned_trainer') }}
            </h3>
            <p class="mt-2 text-sm leading-6 text-gray-600 dark:text-gray-300">
                {{ __('views.explore_trainers_intro') }}
            </p>

            @if(! $esSuEntrenador)
                <a href="{{ route('entrenadores.index') }}" class="mt-4 inline-flex items-center justify-center rounded-lg bg-emerald-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-emerald-700">
                    {{ __('views.explore_trainers') }}
                </a>
            @endif
        </div>
    @endif
</section>
