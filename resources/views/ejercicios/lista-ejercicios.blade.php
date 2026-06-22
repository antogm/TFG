@extends('layouts.list')

@section('title', __('views.titles_exercises'))

@section('header-title', __('views.titles_exercises'))
@section('header-subtitle', __('views.exercise_catalog_subtitle'))

@section('list-content')
    

    {{-- BOTON Y BUSCADOR --}}
    <div class="mb-4 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <x-server-list-search id="buscar_ejercicios" />

        @if($rol === 'entrenador')
            <a href="{{ route('ejercicios.create') }}"
                class="inline-flex shrink-0 items-center justify-center px-4 py-2 text-sm font-semibold rounded-lg bg-emerald-600 text-white shadow-sm transition hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 dark:bg-emerald-500 dark:hover:bg-emerald-400 dark:focus:ring-offset-gray-800">
                {{ __('views.create_new_exercise') }}
            </a>
        @endif
    </div>

    {{-- LISTA EJERCICIOS --}}
    @if ($ejercicios->isEmpty())
        <p class="mt-8 text-gray-600 dark:text-gray-300">
            {{ __('views.no_exercises_yet') }}
        </p>
    @else
        <ul id="lista_ejercicios" class="space-y-3 border-t border-gray-200 last:border-b-0">
            @foreach ($ejercicios as $ejercicio)
                @include('ejercicios._partials.ejercicio-inlist', [
                    'ejercicio' => $ejercicio,
                    'rol' => $rol,
                ])
            @endforeach
        </ul>
        <div class="mt-6">
            {{ $ejercicios->links() }}
        </div>
    @endif
@endsection
