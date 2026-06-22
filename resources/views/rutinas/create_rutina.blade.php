@extends('layouts.app')

@section('title', isset($rutina) ? __('views.titles_routine_edit') : __('views.titles_routine_new'))

@section('content')
    <div class="min-h-screen py-16">
        <div class="flex flex-col gap-8 px-4 sm:px-6 lg:px-8">

            {{-- HEADER --}}
            <header class="border-b border-gray-300 rounded-xl p-4 bg-white dark:bg-gray-800">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100">
                    {{ isset($rutina) ? __('views.routine_edit_heading') : __('views.routine_new_heading') }}
                </h1>
                <p class="text-gray-600 dark:text-gray-300 mt-2">
                    {{ isset($rutina) ? __('views.routine_edit_intro') : __('views.routine_new_intro') }}
                </p>
            </header>

            {{-- FORMULARIO --}}
            <section>
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-8 border-l-4 border-indigo-500">
                    @if (session('status'))
                        <div class="mb-6 rounded-lg border border-emerald-300 bg-emerald-50 p-4 text-sm text-emerald-800 dark:border-emerald-800 dark:bg-emerald-950/30 dark:text-emerald-300"
                            role="status" aria-live="polite">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="mb-6 rounded-lg border border-red-300 bg-red-50 p-4 text-sm text-red-700 dark:border-red-800 dark:bg-red-950/30 dark:text-red-300"
                            role="alert" aria-labelledby="errores-formulario-titulo" tabindex="-1">
                            <p id="errores-formulario-titulo" class="font-medium">{{ __('views.form_errors_heading') }}</p>
                            <ul class="mt-3 list-disc space-y-1 pl-5">
                                @foreach ($errors->keys() as $field)
                                    <li>
                                        <a href="#{{ $field }}" class="underline underline-offset-2 hover:no-underline">
                                            {{ $errors->first($field) }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <nav class="mb-10" aria-label="{{ __('views.routine_creation_progress') }}">
                        <ol class="flex w-full items-start">
                            <li class="relative flex-1">
                                <span data-routine-step-line="0"
                                    class="absolute left-1/2 right-0 top-5 h-0.5 bg-gray-300 dark:bg-gray-700"></span>
                                <button type="button" data-routine-step-tab="0"
                                    class="relative flex w-full flex-col items-center gap-3 text-center transition focus:outline-none">
                                    <span data-routine-step-number
                                        class="z-10 flex h-10 w-10 items-center justify-center rounded-full border-2 text-sm font-semibold transition">1</span>
                                    <span class="max-w-32 text-sm font-semibold text-gray-600 dark:text-gray-300">
                                        {{ __('views.routine_form_info_objectives') }}
                                    </span>
                                </button>
                            </li>
                            <li class="relative flex-1">
                                <span data-routine-step-line="0"
                                    class="absolute left-0 right-1/2 top-5 h-0.5 bg-gray-300 dark:bg-gray-700"></span>
                                <button type="button" data-routine-step-tab="1"
                                    class="relative flex w-full flex-col items-center gap-3 text-center transition focus:outline-none">
                                    <span data-routine-step-number
                                        class="z-10 flex h-10 w-10 items-center justify-center rounded-full border-2 text-sm font-semibold transition">2</span>
                                    <span class="max-w-36 text-sm font-semibold text-gray-600 dark:text-gray-300">
                                        {{ __('views.routine_form_exercise_assignment') }}
                                    </span>
                                </button>
                            </li>
                        </ol>
                    </nav>

                    <form id="routine_form" method="POST" action="{{ isset($rutina) ? route('rutinas.update', $rutina->id) : route('rutinas.store') }}">
                        @csrf
                        @isset($rutina)
                            @method('PATCH')
                        @endisset

                        @include('rutinas._partials.create-rutina.form_paso1')

                        @include('rutinas._partials.create-rutina.form_paso2')

                        <div class="mt-8 flex flex-col-reverse gap-3 sm:flex-row sm:items-center sm:justify-between">
                            <a href="{{ route('rutinas.lista-rutinas') }}"
                                class="inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-300 focus:ring-offset-2 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-200 dark:hover:bg-gray-700 dark:focus:ring-offset-gray-800">
                                {{ __('views.back_to_routines') }}
                            </a>

                            <div class="flex flex-col-reverse gap-3 sm:flex-row sm:items-center">
                                <button id="routine_step_prev" type="button"
                                    class="hidden inline-flex items-center justify-center rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-300 focus:ring-offset-2 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-200 dark:hover:bg-gray-700 dark:focus:ring-offset-gray-800">
                                    {{ __('views.previous') }}
                                </button>
                                <button id="routine_step_next" type="button"
                                    class="inline-flex items-center justify-center rounded-lg bg-emerald-600 px-4 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 dark:bg-emerald-500 dark:hover:bg-emerald-400 dark:focus:ring-offset-gray-800">
                                    {{ __('views.continue') }}
                                </button>
                                <x-primary-button id="routine_submit_button" class="hidden">
                                    {{ isset($rutina) ? __('views.save_changes') : __('views.save_routine') }}
                                </x-primary-button>
                            </div>
                        </div>
                    </form>
                </div>
            </section>
        </div>
    </div>

@endsection

@push('scripts')
    @vite('resources/js/rutinas/create-rutina.js')
@endpush
