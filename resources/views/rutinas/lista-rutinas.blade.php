@extends('layouts.list')

@section('title', __('views.titles_routines'))

@section('header-title', __('views.titles_routines'))
@section('header-subtitle', __('views.routine_list_subtitle'))

@section('list-content')
    {{-- BOTON Y BUSCADOR --}}
    <div class="mb-4 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <x-server-list-search id="buscar_rutinas" />

        @if($rol === 'entrenador')
            <a href="{{ route('rutinas.create') }}"
                class="inline-flex items-center px-4 py-2 text-sm font-semibold rounded-lg bg-emerald-600 text-white shadow-sm transition hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 dark:bg-emerald-500 dark:hover:bg-emerald-400 dark:focus:ring-offset-gray-800">
                {{ __('views.create_new_routine') }}
            </a>
        @endif
    </div>

    {{-- CONTENIDO LISTA --}}
    @if ($rutinas->isEmpty())
        <p class="mt-8 text-gray-600 dark:text-gray-300">
            {{ __('views.no_routines_yet') }}
        </p>
    @else
        <ul id="lista_rutinas" class="space-y-3 mt-8 border-t border-gray-200">
            @foreach ($rutinas as $rutina)
                @include('rutinas._partials.rutina-inlist', [
                    'rutina' => $rutina,
                    'clientesSinRutina' => $clientesSinRutina,
                    'rol' => $rol,
                ])
            @endforeach
        </ul>
        <div class="mt-6">
            {{ $rutinas->links() }}
        </div>
    @endif
@endsection
