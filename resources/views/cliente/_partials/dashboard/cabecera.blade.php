<!-- CABECERA DE USUARIO -->
<header class="overflow-hidden rounded-xl bg-white shadow-sm ring-1 ring-gray-200 dark:bg-gray-800 dark:ring-gray-700">
   <div class="grid gap-6 p-6 lg:grid-cols-[1.4fr_0.9fr] lg:p-8">
       <div class="flex flex-col gap-6 sm:flex-row sm:items-center">
           <div class="relative h-24 w-24 shrink-0 overflow-hidden rounded-lg bg-white p-1 shadow-sm ring-1 ring-gray-200 dark:bg-gray-700 dark:ring-gray-600 sm:h-28 sm:w-28">
               <img src="{{ Storage::url($user->imagen) }}" alt="{{ $user->name }}"
                   class="h-full w-full rounded-md bg-gray-50 object-cover object-center dark:bg-gray-800">
           </div>

            <div class="min-w-0">
                <p class="text-sm font-medium uppercase tracking-wide text-indigo-600 dark:text-indigo-300">
                    {{ __('views.progress_tracking_profile') }}
                </p>
                <h1 class="mt-2 text-3xl font-bold text-gray-950 dark:text-gray-50">
                    {{ $user->name }}
                </h1>

                <div class="mt-4 flex flex-wrap gap-2 text-sm">
                    <span class="rounded-md bg-emerald-50 px-3 py-1 font-medium text-emerald-700 ring-1 ring-emerald-200 dark:bg-emerald-950/40 dark:text-emerald-300 dark:ring-emerald-800">
                        {{ __('views.active') }}
                    </span>
                    <span class="rounded-md bg-gray-100 px-3 py-1 text-gray-700 ring-1 ring-gray-200 dark:bg-gray-900 dark:text-gray-300 dark:ring-gray-700">
                        {{ __('views.objective_prefix', ['objective' => __("views.goal_values")[$user->objetivo] ?? $user->objetivo]) }}
                    </span>
                </div>
            </div>
        </div>

        <div class="rounded-lg border border-gray-200 bg-gray-50 p-5 dark:border-gray-700 dark:bg-gray-900/60">
            <div>
                <h2 class="text-sm font-semibold text-gray-900 dark:text-gray-100">{{ __('views.profile_summary') }}</h2>
                <dl class="mt-4 grid gap-3 text-sm sm:grid-cols-3 lg:grid-cols-1 xl:grid-cols-3">
                    <div>
                        <dt class="text-gray-500 dark:text-gray-400">{{ __('views.height') }}</dt>
                        <dd class="mt-1 font-semibold text-gray-900 dark:text-gray-100">{{ $user->altura }} cm</dd>
                    </div>
                    <div>
                        <dt class="text-gray-500 dark:text-gray-400">{{ __('views.gender') }}</dt>
                        <dd class="mt-1 font-semibold text-gray-900 dark:text-gray-100">{{ __("views.gender_values")[$user->genero] ?? $user->genero }}</dd>
                    </div>
                    <div>
                        <dt class="text-gray-500 dark:text-gray-400">{{ __('views.trainer_assigned') }}</dt>
                        <dd class="mt-1 font-semibold text-gray-900 dark:text-gray-100">{{ $entrenadorAsignado->user->name ?? __('views.no_items') }}</dd>
                    </div>
                </dl>
            </div>

            <div class="mt-5 border-t border-gray-200 pt-5 dark:border-gray-700">
                <p class="text-sm font-semibold text-gray-900 dark:text-gray-100">{{ __('views.quick_actions') }}</p>

                <div class="mt-3 grid w-full gap-3 sm:grid-cols-2 lg:grid-cols-1 xl:grid-cols-2">
                    @if($esSuEntrenador)
                        <a href="{{ route('conversations.start', $user->id) }}" class="inline-flex items-center justify-center rounded-lg bg-indigo-600 px-4 py-3 text-sm font-semibold text-white transition hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-900">
                            {{ __('views.private_message') }}
                        </a>
                    @else
                        <a href="{{ route('registrocorporal.create') }}" class="inline-flex items-center justify-center rounded-lg bg-indigo-600 px-4 py-3 text-sm font-semibold text-white transition hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-900">
                            {{ __('views.record_body_measurements') }}
                        </a>
                    @endif
                    <a href="{{ route('usuario.historial', $user->id) }}" class="inline-flex items-center justify-center rounded-lg bg-white px-4 py-3 text-sm font-semibold text-gray-800 ring-1 ring-gray-300 transition hover:bg-gray-50 dark:bg-gray-800 dark:text-gray-100 dark:ring-gray-600 dark:hover:bg-gray-700">
                        {{ __('views.view_full_history') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</header>
