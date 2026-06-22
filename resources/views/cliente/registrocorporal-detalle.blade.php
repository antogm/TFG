@extends('layouts.app')

@section('title', $esCreacion ? __('views.titles_body_record_new') : ($esEdicion ? __('views.titles_body_record_edit') : __('views.titles_body_record_show')))

@section('content')
    <div class="min-h-screen py-16">
        <div class="flex flex-col gap-8 px-4 sm:px-6 lg:px-8">
            <div>
                <a href="{{ $volverUrl }}"
                    class="inline-flex items-center rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-200 dark:hover:bg-gray-600">
                    {{ __('views.back') }}
                </a>
            </div>

            <header class="rounded-xl border-b border-gray-300 bg-white p-4 dark:bg-gray-800">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100">
                    @if($esCreacion)
                        {{ __('views.body_record_new') }}
                    @elseif($esEdicion)
                        {{ __('views.body_record_edit_heading') }}
                    @else
                        {{ __('views.body_record_show_heading') }}
                    @endif
                </h1>
                <p class="mt-2 text-gray-600 dark:text-gray-300">
                    @if($esCreacion)
                        {{ __('views.body_record_intro') }}
                    @elseif($esEdicion)
                        {{ __('views.body_record_edit_intro') }}
                    @else
                        {{ __('views.body_record_show_intro') }}
                    @endif
                </p>
            </header>

            <section>
                <div class="rounded-xl border-l-4 border-indigo-500 bg-white p-8 shadow-sm dark:bg-gray-800">
                    @if ($errors->any())
                        <div class="mb-6 rounded-lg border border-red-300 bg-red-50 p-4 text-sm text-red-700 dark:border-red-800 dark:bg-red-950/30 dark:text-red-300">
                            <p class="font-medium">{{ __('views.form_errors_heading') }}</p>
                        </div>
                    @endif

                    <form method="POST" enctype="multipart/form-data" action="{{ $esCreacion ? route('registrocorporal.store') : ($esEdicion ? route('registrocorporal.update', $registroCorporal->id) : '#') }}">
                        @csrf
                        @if($esEdicion)
                            @method('PATCH')
                        @endif

                        <div>
                            <x-input-label for="peso" :value="__('registrocorporal.peso')" />
                            <x-text-input id="peso" class="mt-1 block w-full" type="number" name="peso" :value="old('peso', $registroCorporal->peso)" step="0.01" min="1" max="500" :disabled="!$esCreacion && !$esEdicion" required />
                            <x-input-error :messages="$errors->get('peso')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="masa_muscular" :value="__('registrocorporal.masa_muscular') . ' (' . __('views.optional') . ')'" />
                            <x-text-input id="masa_muscular" class="mt-1 block w-full" type="number" name="masa_muscular" :value="old('masa_muscular', $registroCorporal->masa_muscular)" step="0.01" min="1" max="300" :disabled="!$esCreacion && !$esEdicion" />
                            <x-input-error :messages="$errors->get('masa_muscular')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="porcentaje_grasa" :value="__('registrocorporal.porcentaje_grasa') . ' (' . __('views.optional') . ')'" />
                            <x-text-input id="porcentaje_grasa" class="mt-1 block w-full" type="number" name="porcentaje_grasa" :value="old('porcentaje_grasa', $registroCorporal->porcentaje_grasa)" step="0.01" min="1" max="100" :disabled="!$esCreacion && !$esEdicion" />
                            <x-input-error :messages="$errors->get('porcentaje_grasa')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="fecha" :value="__('registrocorporal.fecha')" />
                            <x-text-input id="fecha" class="mt-1 block w-full" type="date" name="fecha" :value="old('fecha', $registroCorporal->fecha_registro?->format('Y-m-d'))" :disabled="!$esCreacion && !$esEdicion" required />
                            <x-input-error :messages="$errors->get('fecha')" class="mt-2" />
                        </div>

                        @if($esCreacion || $esEdicion)
                            <section class="mt-8 rounded-xl border border-dashed border-indigo-300 bg-indigo-50/60 p-5 dark:border-indigo-700 dark:bg-indigo-950/20">
                                <div class="flex flex-col gap-5 lg:flex-row lg:items-start lg:justify-between">
                                    <div class="max-w-2xl">
                                        <x-input-label for="imagenes" :value="__('registrocorporal.imagenes_label')" />
                                        <p class="mt-2 text-sm leading-6 text-gray-600 dark:text-gray-300">
                                            {{ __('registrocorporal.imagenes_help') }}
                                        </p>
                                    </div>

                                    <div class="w-full lg:max-w-md">
                                        <input
                                            id="imagenes"
                                            class="block w-full rounded-lg border border-indigo-200 bg-white p-2 text-sm text-gray-700 shadow-sm file:mr-4 file:rounded-md file:border-0 file:bg-indigo-600 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-white hover:file:bg-indigo-700 dark:border-indigo-800 dark:bg-gray-900 dark:text-gray-200"
                                            type="file"
                                            name="imagenes[]"
                                            accept="image/jpeg,image/png,image/webp"
                                            multiple>
                                        <x-input-error :messages="$errors->get('imagenes')" class="mt-2" />
                                        <x-input-error :messages="$errors->get('imagenes.*')" class="mt-2" />
                                    </div>
                                </div>
                            </section>
                        @endif

                        @if(!$esCreacion)
                            <div class="mt-4">
                                <x-input-label for="fecha_edicion_texto" :value="__('views.edited')" />
                                <x-text-input id="fecha_edicion_texto" class="mt-1 block w-full" type="text" :value="$registroCorporal->fecha_edicion ? $registroCorporal->fecha_edicion->format('d/m/Y H:i') : '-'" disabled />
                            </div>
                        @endif

                        <div class="mt-6 flex flex-wrap gap-3">
                            @if($esCreacion)
                                <x-primary-button>
                                    {{ __('registrocorporal.save') }}
                                </x-primary-button>
                            @elseif($esEdicion)
                                <x-primary-button>
                                    {{ __('views.save_changes') }}
                                </x-primary-button>
                            @elseif($puedeEditar)
                                <a href="{{ route('registrocorporal.edit', $registroCorporal->id) }}"
                                    class="inline-flex items-center rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-200 dark:hover:bg-gray-700">
                                    {{ __('views.edit') }}
                                </a>
                            @endif

                            @if(!$esCreacion && $puedeEditar)
                                <button type="submit"
                                    form="delete-registro-corporal-{{ $registroCorporal->id }}"
                                    class="inline-flex items-center rounded-lg border border-red-300 bg-white px-4 py-2 text-sm font-medium text-red-700 transition hover:bg-red-50 dark:border-red-800 dark:bg-gray-800 dark:text-red-300 dark:hover:bg-red-950/30">
                                    {{ __('views.delete') }}
                                </button>
                            @endif
                        </div>
                    </form>

                    @if(!$esCreacion && $puedeEditar)
                        <form id="delete-registro-corporal-{{ $registroCorporal->id }}" method="POST" action="{{ route('registrocorporal.delete', $registroCorporal->id) }}"
                            onsubmit="return confirm(@js(__('views.confirm_delete_body_record', ['date' => $registroCorporal->fecha_registro?->format('d/m/Y') ?? '-'])));">
                            @csrf
                            @method('DELETE')
                        </form>
                    @endif

                    @if(!$esCreacion && $registroCorporal->imagenes->isNotEmpty())
                        <div class="mt-8 border-t border-gray-200 pt-6 dark:border-gray-700">
                            <h2 class="text-sm font-semibold uppercase text-gray-500 dark:text-gray-400">
                                {{ __('registrocorporal.imagenes_guardadas') }}
                            </h2>
                            <div class="mt-4 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                                @foreach($registroCorporal->imagenes as $imagen)
                                    <a href="{{ $imagen->url }}" target="_blank" rel="noopener noreferrer" class="block overflow-hidden rounded-lg border border-gray-200 bg-gray-50 dark:border-gray-700 dark:bg-gray-900">
                                        <img src="{{ $imagen->url }}" alt="{{ __('registrocorporal.imagen_corporal_alt') }}" class="h-56 w-full object-cover">
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </section>
        </div>
    </div>
@endsection
