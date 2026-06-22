@extends('layouts.app')

@section('title')
	@yield('title')
@endsection

@section('content')
	<div class="min-h-screen py-16">
		<div class="flex flex-col gap-8 px-4 sm:px-6 lg:px-8">

			{{-- HEADER --}}
			<header class="border-b border-gray-300 rounded-xl p-4 bg-white dark:bg-gray-800">
                @hasSection('header-actions')
                    <div class="mb-4">
                        @yield('header-actions')
                    </div>
                @endif
				<h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100">
					@yield('header-title')
				</h1>
				<p class="text-gray-600 dark:text-gray-300 mt-2">
					@yield('header-subtitle')
				</p>
			</header>

			{{-- CONTENIDO DE LA LISTA --}}
			<section>
				<div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-8 border-l-4 border-indigo-500">
					@yield('list-content')
				</div>
			</section>

		</div>
	</div>
@endsection

@push('scripts')
    @vite('resources/js/list-search.js')
@endpush
