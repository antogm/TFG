@extends('layouts.list')

@section('title', __('views.titles_my_clients'))

@section('header-title', __('views.titles_my_clients'))
@section('header-subtitle', __('views.no_clients'))

@section('list-content')

    {{-- BUSCADOR --}}
    <div class="mb-8 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between  border-b border-gray-200 pb-4 last:border-b-0">
        <x-server-list-search id="buscar_clientes" />
    </div>

    {{-- LISTA CLIENTES --}}
    @if ($clientes->isEmpty())
        <p class="text-gray-600 dark:text-gray-300">
            {{ __('views.no_clients') }}
        </p>
    @else
        <ul id="lista_clientes" class="space-y-3">
            @foreach ($clientes as $cliente)
                @include('entrenador._partials.cliente-inlist', ['cliente' => $cliente])
            @endforeach
        </ul>
        <div class="mt-6">
            {{ $clientes->links() }}
        </div>
    @endif
@endsection
