<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('profile.profileinfo') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("profile.updateprofile") }}
        </p>
    </header>

    <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div class="flex flex-col gap-4 sm:flex-row sm:items-center">
            <img src="{{ Storage::url($user->imagen ?? 'default-pp.png') }}" alt="{{ $user->name }}"
                class="h-24 w-24 rounded-full object-cover">

            <div class="flex-1">
                <x-input-label for="imagen" :value="__('profile.profileImage')" />
                <input id="imagen" name="imagen" type="file" accept=".jpg,.jpeg,.png,.webp,image/*"
                    class="mt-2 block w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm text-gray-700 shadow-sm dark:border-gray-700 dark:bg-gray-900 dark:text-gray-200">
                <x-input-error class="mt-2" :messages="$errors->get('imagen')" />
            </div>
        </div>

        <div>
            <x-input-label for="name" :value="__('profile.name')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('profile.email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

        </div>

        <div class="grid gap-6 md:grid-cols-2">
            <div>
                <x-input-label for="genero" :value="__('views.gender')" />

                <select id="genero" name="genero" class="mt-1 block w-full" required>
                    <option value="Masculino" {{ old('genero', $user->genero) == 'Masculino' ? 'selected' : '' }}>
                        {{ __('views.gender_male') }}
                    </option>
                    <option value="Femenino" {{ old('genero', $user->genero) == 'Femenino' ? 'selected' : '' }}>
                        {{ __('views.gender_female') }}
                    </option>
                    <option value="Prefiero no especificarlo" {{ old('genero', $user->genero) == 'Prefiero no especificarlo' ? 'selected' : '' }}>
                        {{ __('views.gender_unspecified') }}
                    </option>
                </select>

                <x-input-error class="mt-2" :messages="$errors->get('genero')" />
            </div>

            <div>
                <x-input-label for="altura" :value="__('registrocorporal.altura')" />
                <x-text-input id="altura" name="altura" type="number" min="0" max="500" step="1"
                    class="mt-1 block w-full" :value="old('altura', $user->altura)" required />
                <x-input-error class="mt-2" :messages="$errors->get('altura')" />
            </div>
        </div>

        <div>
            <x-input-label for="objetivo" :value="__('views.goal')" />

            <select id="objetivo" name="objetivo" class="mt-1 block w-full" required>
                <option value="Pérdida de grasa" {{ old('objetivo', $user->objetivo) == 'Pérdida de grasa' ? 'selected' : '' }}>
                    {{ __('views.goal_fat_loss') }}
                </option>
                <option value="Aumento de masa muscular" {{ old('objetivo', $user->objetivo) == 'Aumento de masa muscular' ? 'selected' : '' }}>
                    {{ __('views.goal_muscle_gain') }}
                </option>
                <option value="Recomposición corporal" {{ old('objetivo', $user->objetivo) == 'Recomposición corporal' ? 'selected' : '' }}>
                    {{ __('views.goal_recomposition') }}
                </option>
                <option value="Sin objetivo marcado" {{ old('objetivo', $user->objetivo) == 'Sin objetivo marcado' ? 'selected' : '' }}>
                    {{ __('views.goal_none') }}
                </option>
            </select>

            <x-input-error class="mt-2" :messages="$errors->get('objetivo')" />
        </div>

        <section class="space-y-4 border-t border-gray-200 pt-6 dark:border-gray-700">
            <h3 class="text-base font-medium text-gray-900 dark:text-gray-100">
                {{ __('views.privacy') }}
            </h3>

            @component('components.toggle-button', [
                'name' => 'bloquear_mensajes_desconocidos',
                'checked' => old('bloquear_mensajes_desconocidos', $user->bloquear_mensajes_desconocidos ?? false),
                'color' => 'rojo',
            ])
                {{ __('views.block_unknown_messages') }}
            @endcomponent
        </section>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('profile.save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400"
                >{{ __('profile.saved') }}</p>
            @endif
        </div>
    </form>
</section>
