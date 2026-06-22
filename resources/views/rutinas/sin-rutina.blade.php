@extends('layouts.app')

@section('title', __('views.no_routine_assigned_now'))

@section('content')
    <div class="min-h-screen py-16">
        <div class="px-4 sm:px-6 lg:px-8">
            <section class="rounded-xl bg-white p-8 shadow-sm ring-1 ring-gray-200 dark:bg-gray-800 dark:ring-gray-700">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100">
                    {{ __('views.no_routine_assigned_now') }}
                </h1>

                <p class="mt-3 max-w-3xl text-sm leading-6 text-gray-600 dark:text-gray-300">
                    {{ __('views.no_active_routine') }}
                </p>

                <div class="mt-6 flex flex-wrap gap-3">
                    @if($entrenadorAsignado)
                        <a href="{{ route('conversations.start', $entrenadorAsignado->user->id) }}" class="inline-flex items-center justify-center rounded-lg bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-indigo-700">
                            {{ __('views.request_routine_from_trainer') }}
                        </a>
                    @else
                        <a href="{{ route('entrenadores.index') }}" class="inline-flex items-center justify-center rounded-lg bg-emerald-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-emerald-700">
                            {{ __('views.search_trainers') }}
                        </a>
                    @endif

                    <a href="{{ route('cliente.dashboard') }}" class="inline-flex items-center justify-center rounded-lg bg-white px-4 py-2.5 text-sm font-semibold text-gray-800 ring-1 ring-gray-300 transition hover:bg-gray-50 dark:bg-gray-800 dark:text-gray-100 dark:ring-gray-600 dark:hover:bg-gray-700">
                        {{ __('nav.my_progress') }}
                    </a>
                </div>
            </section>
        </div>
    </div>
@endsection
