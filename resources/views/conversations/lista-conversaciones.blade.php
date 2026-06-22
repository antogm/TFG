@extends('layouts.list')

@section('title', __('views.titles_conversations'))

@section('header-title', __('views.titles_conversations'))
@section('header-subtitle', __('views.conversations_list_subtitle'))

@section('list-content')
	{{-- LISTA MENSAJES --}}
	@if($conversations->isEmpty())
		<p class="text-gray-600 dark:text-gray-300">
			{{ __('views.conversation_no_open') }}
		</p>
	@else
		<ul class="space-y-3">
			@foreach($conversations as $conversation)
				@include('conversations._partials.conversacion-inlist', [
					'conversation' => $conversation,
				])
			@endforeach
		</ul>
		<div class="mt-6">
			{{ $conversations->links() }}
		</div>
	@endif
@endsection
