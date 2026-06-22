@extends('layouts.list')

@section('title', __('views.titles_trainers_list'))

@section('header-title', __('views.titles_trainers_list'))
@section('header-subtitle', __('views.trainers_list_subtitle'))

@section('list-content')
	{{-- LISTA ENTRENADORES --}}
	@if ($entrenadores->isEmpty())
		<p class="text-gray-600 dark:text-gray-300">
			{{ __('views.no_trainers_available') }}
		</p>
	@else
		<ul class="space-y-3">
			@foreach ($entrenadores as $entrenador)
				@include('cliente._partials.lista-entrenadores.entrenador-inlist', [
					'entrenador' => $entrenador,
					'solicitudPendienteId' => $solicitudPendienteId,
					'conocidos' => $conocidos,
				])
			@endforeach
		</ul>
		<div class="mt-6">
			{{ $entrenadores->links() }}
		</div>
	@endif
@endsection
