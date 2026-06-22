@extends('layouts.app')

@section("title", __("views.titles_trainer_detail"))

@section('content')
    <div class="py-12" x-data="{ modalValoracion: false, valoracion: 0 }">
        <div class="mx-auto max-w-6xl space-y-6 px-4 sm:px-6 lg:px-8">
            <div>
                <a href="{{ route('entrenadores.index') }}"
                    class="inline-flex items-center text-sm font-medium text-indigo-600 transition hover:text-indigo-800 dark:text-indigo-300 dark:hover:text-indigo-200">
                    {{ __("views.back_to_trainers") }}
                </a>
            </div>

            <section class="grid gap-6 lg:grid-cols-[1.4fr_0.8fr]">
                <article class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800 lg:p-8">
                    <div class="flex flex-col gap-6 sm:flex-row">
                        <img src="{{ Storage::url($entrenador->user->imagen ?? 'default-pp.png') }}"
                            alt="{{ $entrenador->user->name }}"
                            class="h-28 w-28 shrink-0 rounded-xl object-cover shadow-sm">

                        <div class="min-w-0">
                            <p class="text-sm font-semibold text-indigo-600 dark:text-indigo-300">{{ __("views.personal_trainer") }}</p>
                            <h1 class="mt-2 text-3xl font-bold text-gray-900 dark:text-gray-100">
                                {{ $entrenador->user->name }}
                            </h1>
                            <p class="mt-4 max-w-2xl text-base leading-7 text-gray-600 dark:text-gray-300">
                                {{ $entrenador->descripcion ?: __("views.trainer_bio_empty") }}
                            </p>
                        </div>
                    </div>
                </article>

                <aside class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800">
                    <div class="flex items-center justify-between gap-4">
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ __("views.rating") }}</p>
                            @if ($rating === null)
                                <p class="mt-1 text-xl font-bold text-gray-900 dark:text-gray-100">{{ __("views.no_reviews") }}</p>
                            @else
                                <div class="mt-1 flex flex-wrap items-center gap-2">
                                    <p class="text-3xl font-bold text-gray-900 dark:text-gray-100">{{ $rating }}</p>
                                    <div class="flex gap-0.5" aria-label="{{ __("views.rating_out_of_five", ["rating" => $rating]) }}">
                                        @for ($estrella = 1; $estrella <= 5; $estrella++)
                                            <span class="relative block h-5 w-5 text-gray-300 dark:text-gray-600">
                                                @component('components.rating-star')
                                                @endcomponent
                                                @if ((float) $rating >= $estrella - 0.5)
                                                    <span class="absolute left-0 top-0 block h-5 overflow-hidden text-yellow-400 {{ (float) $rating >= $estrella ? 'w-full' : 'w-1/2' }}">
                                                        @component('components.rating-star')
                                                        @endcomponent
                                                    </span>
                                                @endif
                                            </span>
                                        @endfor
                                    </div>
                                </div>
                            @endif
                        </div>
                        @if ($rating !== null)
                            <div class="rounded-full bg-amber-100 px-4 py-2 text-sm font-semibold text-amber-800 dark:bg-amber-900/40 dark:text-amber-200">
                                {{ __("views.reviews_count", ["count" => $numeroValoraciones]) }}
                            </div>
                        @endif
                    </div>

                    <div class="mt-6 grid gap-3 sm:grid-cols-3">
                        <div class="border-l-4 border-emerald-500 pl-4">
                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ __("views.current_clients") }}</p>
                            <p class="mt-2 text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $clientesActuales }}</p>
                        </div>
                        <div class="border-l-4 border-indigo-500 pl-4">
                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ __("views.previous_clients") }}</p>
                            <p class="mt-2 text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $clientesAnteriores }}</p>
                        </div>
                        <div class="border-l-4 border-amber-500 pl-4">
                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ __("views.routines_created") }}</p>
                            <p class="mt-2 text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $rutinasCreadas }}</p>
                        </div>
                    </div>
                </aside>
            </section>

            <section class="grid gap-6 lg:grid-cols-3">
                <article class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800 lg:col-span-2">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ __("views.bio") }}</h2>
                    <p class="mt-4 whitespace-pre-line text-sm leading-6 text-gray-600 dark:text-gray-300">
                        {{ $entrenador->descripcion ?: __("views.no_additional_information") }}
                    </p>
                </article>

                <aside class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ __("views.quick_actions") }}</h2>

                    <div class="mt-5 space-y-3">
                        @if ($puedeValorar)
                            <button type="button"
                                x-on:click="modalValoracion = true"
                                class="w-full rounded-lg bg-amber-500 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-amber-600">
                                {{ __("views.add_review") }}
                            </button>
                        @endif

                        @if ($valoracionCliente !== null)
                            <form method="POST" action="{{ route('entrenadores.valoracion.eliminar', $entrenador->id) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="w-full rounded-lg bg-red-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-red-700">
                                    {{ __("views.delete_review") }}
                                </button>
                            </form>
                        @endif

                        @if ($puedeEnviarMensaje)
                            <a href="{{ route('conversations.start', $entrenador->id) }}"
                                class="block w-full rounded-lg bg-gray-700 px-4 py-2.5 text-center text-sm font-semibold text-white transition hover:bg-gray-800 dark:bg-gray-200 dark:text-gray-900 dark:hover:bg-white">
                                {{ __("views.private_message") }}
                            </a>
                        @endif

                        @if ($entrenador->id === $usuarioActual->id)
                            <a href="{{ route('profile.edit') }}"
                                class="block w-full rounded-lg bg-indigo-600 px-4 py-2.5 text-center text-sm font-semibold text-white transition hover:bg-indigo-700">
                                {{ __("views.titles_edit_profile") }}
                            </a>
                        @endif

                        @if ($puedeSolicitarColaboracion)
                            <form method="POST" action="{{ route('cliente-entrenador.solicitar', $entrenador->id) }}"
                                onsubmit="return confirm(@js(__('views.confirm_request_trainer_services', ['name' => $entrenador->user->name])));">
                                @csrf
                                <button type="submit"
                                    class="w-full rounded-lg bg-emerald-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-emerald-700">
                                    {{ __("views.request_collaboration") }}
                                </button>
                            </form>
                        @endif
                    </div>

                    <dl class="mt-6 border-t border-gray-200 pt-5 text-sm dark:border-gray-700">
                        <dt class="text-gray-500 dark:text-gray-400">{{ __("views.monthly_fee") }}</dt>
                        <dd class="mt-1 font-medium text-gray-900 dark:text-gray-100">
                            {{ $entrenador->precio_mensual !== null ? number_format((float) $entrenador->precio_mensual, 0) . ' €' : __("views.not_provided_f") }}
                        </dd>
                    </dl>
                </aside>
            </section>
        </div>

            @if ($puedeValorar)
                <div x-show="modalValoracion" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 px-4">
                    <div x-on:click.outside="modalValoracion = false" class="w-full max-w-md rounded-xl bg-white p-6 shadow-xl dark:bg-gray-800">
                        <h2 class="text-xl font-bold text-gray-900 dark:text-gray-100">{{ __("views.review_trainer") }}</h2>
                        <form method="POST" action="{{ route('entrenadores.valorar', $entrenador->id) }}" class="mt-6">
                            @csrf
                            <input type="hidden" name="valoracion" x-bind:value="valoracion">

                            <div class="flex justify-center gap-1" aria-label="{{ __("views.star_rating") }}">
                                <template x-for="estrella in [1, 2, 3, 4, 5]" :key="estrella">
                                    <span class="relative block h-10 w-10 text-gray-300">
                                        @component('components.rating-star')
                                        @endcomponent
                                        <span class="absolute left-0 top-0 block h-10 overflow-hidden text-yellow-400" x-bind:class="valoracion >= estrella ? 'w-full' : (valoracion >= estrella - 0.5 ? 'w-1/2' : 'w-0')">
                                            @component('components.rating-star')
                                            @endcomponent
                                        </span>
                                        <button type="button" class="absolute left-0 top-0 h-full w-1/2" x-on:click="valoracion = estrella - 0.5" aria-label="{{ __("views.half_star") }}"></button>
                                        <button type="button" class="absolute right-0 top-0 h-full w-1/2" x-on:click="valoracion = estrella" aria-label="{{ __("views.full_star") }}"></button>
                                    </span>
                                </template>
                            </div>

                            <p class="mt-3 text-center text-sm font-semibold text-gray-700 dark:text-gray-200">
                                <span x-text="valoracion.toFixed(1)">0.0</span> / 5.0
                            </p>

                            <x-input-error :messages="$errors->get('valoracion')" class="mt-3" />

                            <div class="mt-6 flex justify-center gap-3">
                                <button type="button" x-on:click="modalValoracion = false" class="rounded-lg bg-gray-200 px-4 py-2 text-sm font-semibold text-gray-800 hover:bg-gray-300 dark:bg-gray-700 dark:text-gray-100 dark:hover:bg-gray-600">
                                    {{ __("views.cancel") }}
                                </button>
                                <button type="submit" x-bind:disabled="valoracion === 0" class="rounded-lg bg-amber-500 px-4 py-2 text-sm font-semibold text-white hover:bg-amber-600 disabled:cursor-not-allowed disabled:opacity-50">
                                    {{ __("views.send_review") }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            @endif

    </div>
@endsection
