@extends('layouts.app')

@section('title', __('views.coach_dashboard_title'))

@section('content')
    <div class="min-h-screen py-16">
        <div class="flex flex-col gap-8 px-4 sm:px-6 lg:px-8">

            {{-- HEADER --}}
            <header class="rounded-xl border-b border-gray-300 bg-white p-4 dark:bg-gray-800">
                <h2 class="text-3xl font-bold text-gray-900 dark:text-gray-100">
                    {{ __('views.coach_dashboard_heading') }}
                </h2>
                <p class="mt-2 text-gray-600 dark:text-gray-300">
                    {{ __('views.dashboard_tagline') }}<br>
                    {{ __('views.coach_dashboard_subtitle') }}
                </p>
            </header>

            @include('entrenador._partials.dashboard.infomensajes')

            <div class="grid gap-8 xl:grid-cols-2">
                @include('entrenador._partials.dashboard.infosolicitudes')
                @include('entrenador._partials.dashboard.infonumclientes')
                @include('entrenador._partials.dashboard.infoclientessinrutina')
                @include('entrenador._partials.dashboard.infoclientesinactivos')
            </div>

            @include('entrenador._partials.dashboard.infoultimosentrenos')
        </div>
    </div>
@endsection
