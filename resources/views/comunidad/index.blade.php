@extends('layouts.app')

@section('title', __('views.titles_community'))

@section('content')
<div class=" min-h-screen py-16">
    <div class="px-4 sm:px-6 lg:px-8">

        {{-- HEADER --}}
        <header class="mb-20 border-b border-gray-300 rounded-xl p-4 bg-white dark:bg-gray-800">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100">
                {{ __('views.community') }}
            </h1>
        </header>

        {{-- NOTICIAS + CHAT --}}
        <section class="flex flex-col sm:flex-row gap-12 items-stretch">

            {{-- NOTICIAS --}}
            <div class="md:w-1/2">
                <div class="mb-6">
                    <h2 class="text-2xl font-semibold text-gray-900 dark:text-gray-100">
                        {{ __('views.community_feed') }}
                    </h2>
                    <p class="text-gray-600 dark:text-gray-300 mt-1">
                        {{ __('views.community_latest_updates') }}
                    </p>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-8 border-l-4 border-indigo-500 h-full">
                    <ul class="space-y-6">
                        @for ($i = 1; $i <= 3; $i++)
                            <li class="pb-4 border-b border-gray-200 last:border-b-0">
                                <h3 class="text-lg font-medium text-gray-600 dark:text-gray-300">
                                    {{ __('views.news_title', ['number' => $i]) }}
                                </h3>
                                <p class="text-gray-600 dark:text-gray-300 mt-1">
                                    {{ __('views.news_summary') }}
                                </p>
                            </li>
                        @endfor
                    </ul>

                    <div class="mt-8 text-center">
                        <button class="text-indigo-700 text-sm hover:underline">
                            {{ __('views.load_more_news') }}
                        </button>
                    </div>
                </div>
            </div>

            {{-- CHAT --}}
            <div class="md:w-1/2">
                <div class="mb-6">
                    <h2 class="text-2xl font-semibold text-gray-900 dark:text-gray-100">
                        {{ __('views.community_chat') }}
                    </h2>
                    <p class="text-gray-600 dark:text-gray-300 mt-1">
                        {{ __('views.community_chat_intro') }}
                    </p>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-8 border-l-4 border-sky-500 flex flex-col h-full">
                    <div class="flex-1 overflow-y-auto bg-white dark:bg-gray-800  border border-gray-200 rounded-lg p-4 space-y-3">
                        @for ($i = 1; $i <= 4; $i++)
                            <div>
                                <span class="font-medium text-gray-700 dark:text-gray-200">
                                    {{ __('views.chat_user', ['number' => $i]) }}
                                </span>
                                <span class="text-gray-600 dark:text-gray-300">
                                    {{ __('views.chat_example_message') }}
                                </span>
                            </div>
                        @endfor
                    </div>

                    <form class="flex gap-3 mt-5">
                        <input
                            type="text"
                            placeholder="{{ __('views.chat_placeholder') }}"
                            class="flex-1 border border-gray-300 rounded-lg px-4 py-2 text-sm bg-gray-100"
                            disabled
                        >
                        <button
                            type="button"
                            class="bg-indigo-600 text-white px-5 py-2 rounded-lg text-sm opacity-50 cursor-not-allowed">
                            {{ __('views.send') }}
                        </button>
                    </form>

                    <p class="text-xs text-gray-600 mt-3">
                        {{ __('views.chat_future_notice') }}
                    </p>
                </div>
            </div>
        </section>

        {{-- SEPARADOR CLARO --}}
        <div class="mt-24 border-t border-gray-300"></div>

        {{-- RECETAS --}}
        <section class="mt-24">
            <div class="mb-6 flex items-end justify-between">
                <div>
                    <h2 class="text-2xl font-semibold text-gray-900 dark:text-gray-100">
                        {{ __('views.recipes') }}
                    </h2>
                    <p class="text-gray-600 dark:text-gray-300 mt-1">
                        {{ __('views.user_contributions') }}
                    </p>
                </div>

                <a href="#" class="text-indigo-700 text-sm hover:underline">
                    {{ __('views.view_all') }}
                </a>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-8 border-l-4 border-emerald-500">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @for ($i = 1; $i <= 3; $i++)
                        <div class="bg-white dark:bg-gray-700 border border-gray-200 rounded-lg p-5">
                            <h3 class="text-gray-900 dark:text-gray-100 font-medium">
                                {{ __('views.recipe_title', ['number' => $i]) }}
                            </h3>
                            <p class="text-gray-300 text-sm mt-1">
                                {{ __('views.recipe_summary') }}
                            </p>
                        </div>
                    @endfor
                </div>
            </div>
        </section>

    </div>
</div>
@endsection
