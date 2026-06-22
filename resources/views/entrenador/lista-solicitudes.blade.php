@extends('layouts.list')

@section('title', __('views.titles_incoming_requests'))

@section('header-title', __('views.manage_requests'))
@section('header-subtitle', __('views.incoming_requests_subtitle'))

@section('list-content')

    {{-- LISTA SOLICITUDES --}}
    @if ($solicitudes->isEmpty())
        <p class="text-gray-600 dark:text-gray-300">
            {{ __('views.no_requests') }}
        </p>
    @else
        <ul class="space-y-3">
            @foreach ($solicitudes as $solicitud)
                @include('entrenador._partials.solicitud', ['cliente' => $solicitud->cliente])
            @endforeach
        </ul>
        <div class="mt-6">
            {{ $solicitudes->links() }}
        </div>
    @endif
@endsection
