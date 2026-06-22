@extends('layouts.guest')

@section('title', __('views.titles_welcome'))

@section('content')
	<section style="text-align:center; padding:4rem 2rem; background:#2563eb; color:white;">
		<h1>{{ __('views.homepage_title') }}</h1>
		<p style="max-width:600px; margin:1rem auto;">
			{{ __('views.homepage_subtitle') }}
		</p>
		<div style="display:flex; justify-content:center; gap:1rem; flex-wrap:wrap;">
			<a href="{{ route('login') }}"
			style="background:white; color:#2563eb; padding:0.75rem 1.5rem; border-radius:5px; text-decoration:none; font-weight:bold;">
				{{ __('views.login') }}
			</a>

			<a href="{{ route('register') }}"
			style="background:transparent; color:white; padding:0.75rem 1.5rem; border:2px solid white; border-radius:5px; text-decoration:none; font-weight:bold;">
				{{ __('views.register') }}
			</a>
		</div>
	</section>

	<section class="mt-12">
		<h2 class="mb-6 text-center text-2xl font-bold text-white">{{ __('views.main_features') }}</h2>

		<div class="grid gap-4 sm:grid-cols-2">
			<div class="rounded-lg border border-gray-700 bg-gray-700 p-4">
				<div class="mb-2 text-2xl">📈</div>
				<p class="font-semibold text-white">{{ __("views.feature_progress_label") }}</p>
			</div>

			<div class="rounded-lg border border-gray-700 bg-gray-700 p-4">
				<div class="mb-2 text-2xl">🌍</div>
				<p class="font-semibold text-white">{{ __("views.feature_community_label") }}</p>
			</div>

			<div class="rounded-lg border border-gray-700 bg-gray-700 p-4">
				<div class="mb-2 text-2xl">🧑‍🏫</div>
				<p class="font-semibold text-white">{{ __("views.feature_trainers_label") }}</p>
			</div>

			<div class="rounded-lg border border-gray-700 bg-gray-700 p-4">
				<div class="mb-2 text-2xl">💬</div>
				<p class="font-semibold text-white">{{ __("views.feature_messages_label") }}</p>
			</div>
		</div>
	</section>
@endsection
