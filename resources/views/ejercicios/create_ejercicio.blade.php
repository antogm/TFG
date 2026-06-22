@extends('layouts.app')

@section('title', isset($ejercicio) ? __('views.titles_exercise_edit') : __('views.titles_exercise_new'))

@section('content')
    <div class="min-h-screen py-16">
        <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">
            <div class="rounded-xl bg-white p-8 shadow-sm dark:bg-gray-800">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100">
                    {{ isset($ejercicio) ? __('views.exercise_edit_heading') : __('views.exercise_new_heading') }}
                </h1>
                <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">
                    {{ isset($ejercicio) ? __('views.exercise_edit_intro') : __('views.exercise_new_intro') }}
                </p>

                @if ($errors->any())
                    <div class="mt-6 rounded-lg border border-red-300 bg-red-50 p-4 text-sm text-red-700 dark:border-red-800 dark:bg-red-950/30 dark:text-red-300">
                        <ul class="list-disc space-y-1 pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (session('created_exercise_for_routine'))
                    <div id="exercise_created_from_routine_notice"
                        class="mt-6 rounded-lg border border-emerald-300 bg-emerald-50 p-4 text-sm text-emerald-800 dark:border-emerald-800 dark:bg-emerald-950/30 dark:text-emerald-200">
                        <p class="font-medium">{{ __('views.exercise_sent_to_routine') }}</p>
                        <button type="button" onclick="window.close()"
                            class="mt-3 inline-flex items-center justify-center rounded-lg bg-emerald-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 focus:ring-offset-white dark:focus:ring-offset-gray-800">
                            {{ __('views.close_tab') }}
                        </button>
                    </div>
                @endif

                <form method="POST" action="{{ isset($ejercicio) ? route('ejercicios.update', $ejercicio->id) : route('ejercicios.store') }}" enctype="multipart/form-data" class="mt-8 space-y-8">
                    @csrf
                    @isset($ejercicio)
                        @method('PATCH')
                    @endisset
                    @if (request()->boolean('from_routine'))
                        <input type="hidden" name="from_routine" value="1">
                    @endif

                    <div class="grid gap-6 rounded-lg border border-gray-200 p-4 dark:border-gray-700 lg:grid-cols-2">
                        <div class="space-y-5">
                            <div>
                                <x-input-label for="nombre" :value="__('views.name_required')" />
                                <x-text-input id="nombre" name="nombre" type="text" class="mt-2 block w-full"
                                    :value="old('nombre', isset($ejercicio) ? $ejercicio->nombre : null)" maxlength="100" required />
                                <x-input-error :messages="$errors->get('nombre')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="descripcion" :value="__('views.description_no_accent')" />
                                <textarea id="descripcion" name="descripcion" rows="5"
                                    class="mt-2 block w-full rounded-md border-gray-300 bg-white text-sm text-gray-900 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 dark:focus:border-indigo-600 dark:focus:ring-indigo-600">{{ old('descripcion', isset($ejercicio) ? $ejercicio->descripcion : null) }}</textarea>
                                <x-input-error :messages="$errors->get('descripcion')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="link_youtube" :value="__('views.youtube_link')" />
                                <x-text-input id="link_youtube" name="link_youtube" type="url" class="mt-2 block w-full"
                                    :value="old('link_youtube', isset($ejercicio) ? $ejercicio->link_youtube : null)" maxlength="2048" />
                                <x-input-error :messages="$errors->get('link_youtube')" class="mt-2" />
                            </div>

                            <div>
                                @if (isset($ejercicio) && $ejercicio->imagen)
                                    <div class="mt-3 flex flex-col items-center gap-2 mt-2">
                                        <img src="{{ Storage::url($ejercicio->imagen) }}" alt="{{ $ejercicio->nombre }}"
                                            class="h-20 w-20 rounded-lg object-contain">
                                        <p class="text-xs text-gray-500 dark:text-gray-400">
                                            {{ __('views.current_image') }}
                                        </p>
                                    </div>
                                @endif

                                <x-input-label for="imagen" :value="__('views.image')" />
                                <input id="imagen" name="imagen" type="file" accept=".jpg,.jpeg,.png,.webp,image/*"
                                    class="mt-2 block w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm text-gray-700 shadow-sm dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200">
                                <x-input-error :messages="$errors->get('imagen')" class="mt-2" />
                            </div>
                        </div>

                        <fieldset class="lg:border-l lg:border-gray-300 lg:pl-6 dark:lg:border-gray-600">
                            <legend class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ __('views.muscle_groups_optional') }}</legend>
                            <div class="mt-4 space-y-4">
                                @foreach ($gruposPrincipales as $grupoPrincipal)
                                    @if (!empty($subgruposPorPadre[$grupoPrincipal->id]))
                                        <details class="rounded-lg border border-gray-200 dark:border-gray-700">
                                            <summary class="min-h-12 cursor-pointer px-4 py-3 text-sm font-semibold uppercase text-gray-500 transition hover:bg-gray-50 dark:text-gray-400 dark:hover:bg-gray-700">
                                                {{ $grupoPrincipal->nombre }}
                                            </summary>

                                            <div class="grid gap-3 border-t border-gray-200 p-4 sm:grid-cols-2 dark:border-gray-700">
                                                @foreach ($subgruposPorPadre[$grupoPrincipal->id] as $subgrupo)
                                                    <label class="flex items-center cursor-pointer gap-3 rounded-lg border border-gray-200 px-3 py-2 dark:border-gray-700">
                                                        <input type="checkbox" name="grupos_musculares[]"
                                                            value="{{ $subgrupo->id }}"
                                                            @checked(in_array($subgrupo->id, old('grupos_musculares', isset($ejercicio) ? $ejercicio->gruposMusculares->pluck('id')->toArray() : [])))
                                                            class="cursor-pointer rounded border-gray-300 text-emerald-600 shadow-sm focus:ring-emerald-500 dark:border-gray-600 dark:bg-gray-900">
                                                        <span class="text-sm text-gray-700 dark:text-gray-200">{{ $subgrupo->nombre }}</span>
                                                    </label>
                                                @endforeach
                                            </div>
                                        </details>
                                    @else
                                        <label class="flex items-center cursor-pointer gap-3 rounded-lg border border-gray-200 px-3 py-2 dark:border-gray-700">
                                            <input type="checkbox" name="grupos_musculares[]"
                                                value="{{ $grupoPrincipal->id }}"
                                                @checked(in_array($grupoPrincipal->id, old('grupos_musculares', isset($ejercicio) ? $ejercicio->gruposMusculares->pluck('id')->toArray() : [])))
                                                class="cursor-pointer rounded border-gray-300 text-emerald-600 shadow-sm focus:ring-emerald-500 dark:border-gray-600 dark:bg-gray-900">
                                            <span class="text-sm text-gray-700 dark:text-gray-200">{{ $grupoPrincipal->nombre }}</span>
                                        </label>
                                    @endif
                                @endforeach
                            </div>

                            <x-input-error :messages="$errors->get('grupos_musculares')" class="mt-2" />
                            <x-input-error :messages="$errors->get('grupos_musculares.*')" class="mt-2" />
                        </fieldset>
                    </div>

                    <div class="mt-8 flex flex-col-reverse gap-3 sm:flex-row sm:items-center sm:justify-between">
                        <a href="{{ route('ejercicios.index') }}"
                            class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-200 dark:hover:bg-gray-700">
                            {{ __('views.back_to_catalog') }}
                        </a>

                        <x-primary-button>
                            {{ isset($ejercicio) ? __('views.save_changes') : __('views.save_exercise') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@if (session('created_exercise_for_routine'))
    @push('scripts')
        <script>
            (() => {
                if (!window.opener || window.opener.closed) {
                    return;
                }

                window.opener.postMessage({
                    type: 'tfg:exercise-created',
                    exercise: @json(session('created_exercise_for_routine')),
                }, window.location.origin);

                window.setTimeout(() => window.close(), 150);
            })();
        </script>
    @endpush
@endif
