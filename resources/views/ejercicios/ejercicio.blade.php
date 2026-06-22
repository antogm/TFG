@extends('layouts.app')

@section('content')
    <div class="flex min-h-screen flex-col gap-8 px-4 py-16 sm:px-6 lg:px-8">
        {{-- HEADER --}}
        <header class="border-b border-gray-300 rounded-xl p-4 bg-white dark:bg-gray-800">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100">
                {{ $ejercicio->nombre }}
            </h1>
        </header>

        <section class="flex flex-row gap-8 bg-white dark:bg-gray-800 rounded-xl shadow-sm p-8 border-l-4 border-indigo-500">
            <div class="flex w-1/2 flex-col gap-6">
                @if ($ejercicio->imagen)
                    <img
                        src="{{ Storage::url($ejercicio->imagen) }}"
                        alt="{{ $ejercicio->nombre }}"
                        class="w-full max-w-sm rounded-lg object-contain">
                @endif

                <div>
                    <h2 class="text-sm font-semibold uppercase text-gray-500 dark:text-gray-400">{{ __('views.description_heading') }}</h2>
                    <p class="mt-2 max-w-prose text-base leading-7 text-gray-900 dark:text-gray-100">
                        {{ $ejercicio->descripcion }}
                    </p>
                </div>

                <div>
                    <h2 class="text-sm font-semibold uppercase text-gray-500 dark:text-gray-400">{{ __('views.muscles_involved') }}</h2>
                    <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">
                        {{ $ejercicio->gruposMusculares->pluck('nombre')->join(', ') ?: __('views.no_muscle_groups') }}
                    </p>
                </div>
            </div>
            
            <div class="flex flex-col w-1/2">
                @if ($ejercicio->getYoutubeEmbedUrl())
                <div>
                    <p class="text-sm font-semibold uppercase text-gray-500 dark:text-gray-400">
						{{ __('views.sample_video') }}
					</p>
                    <div class="mt-2 aspect-video w-full overflow-hidden rounded-lg">
                        <iframe
                            class="h-full w-full"
                            src="{{ $ejercicio->getYoutubeEmbedUrl() }}"
                            title="{{ __('views.sample_video_of', ['name' => $ejercicio->nombre]) }}"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                            allowfullscreen>
                        </iframe>
                    </div>
                </div>
                @endif
            </div>
        </section>
    </div>
@endsection
