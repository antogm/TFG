<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('profile.trainerProfile') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("profile.updateTrainerProfile") }}
        </p>
    </header>

    <form method="post" action="{{ route('entrenador.actualizarPerfil') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="precio_mensual" :value="__('profile.price')" />
            <x-text-input id="precio_mensual" name="precio_mensual" type="number" min="0" max="1000" step="1"
                class="mt-1 block w-full" :value="old('precio_mensual', (int) $user->entrenador->precio_mensual)"
                required autofocus />
            <x-input-error class="mt-2" :messages="$errors->get('precio_mensual')" />
        </div>

        <div>
            <x-input-label for="descripcion" :value="__('profile.description')" />

            <textarea id="descripcion" name="descripcion" rows="4" maxlength="500"
                class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                required>{{ old('descripcion', $user->entrenador->descripcion) }}</textarea>

            <x-input-error class="mt-2" :messages="$errors->get('descripcion')" />
        </div>

        <section class="space-y-4 border-t border-gray-200 pt-6 dark:border-gray-700">
            <h3 class="text-base font-medium text-gray-900 dark:text-gray-100">
                {{ __('views.privacy') }}
            </h3>

            @component('components.toggle-button', [
                'name' => 'ocultar_lista_publica',
                'checked' => old('ocultar_lista_publica', $user->entrenador->ocultar_lista_publica ?? false),
                'color' => 'rojo',
            ])
                {{ __('views.hide_public_trainer_listing') }}
            @endcomponent

            @component('components.toggle-button', [
                'name' => 'bloquear_solicitudes_entrantes',
                'checked' => old('bloquear_solicitudes_entrantes', $user->entrenador->bloquear_solicitudes_entrantes ?? false),
                'color' => 'rojo',
            ])
                {{ __('views.block_incoming_collaboration_requests') }}
            @endcomponent
        </section>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('profile.save') }}</x-primary-button>

            @if (session('status') === 'trainer-profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400">{{ __('profile.saved') }}</p>
            @endif

            @if (session('status') === 'trainer-profile-activated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400">{{ __('profile.trainerProfileActivated') }}</p>
            @endif
        </div>
    </form>

    <section class="mt-8 border-t border-gray-200 pt-6 dark:border-gray-700">
        <header>
            <h3 class="text-base font-medium text-gray-900 dark:text-gray-100">
                {{ __('profile.leaveTrainerRole') }}
            </h3>

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                {{ __('profile.leaveTrainerRoleDescription') }}
            </p>
        </header>

        <form method="post" action="{{ route('entrenador.baja') }}" class="mt-6"
            onsubmit="return confirm(@js(__('profile.leaveTrainerRoleConfirmation')));">
            @csrf
            @method('patch')

            <div class="flex items-center gap-4">
                <x-danger-button>{{ __('profile.leaveTrainerRoleButton') }}</x-danger-button>

                @if (session('status') === 'trainer-profile-deactivated')
                    <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                        class="text-sm text-gray-600 dark:text-gray-400">{{ __('profile.trainerProfileDeactivated') }}</p>
                @endif
            </div>
        </form>
    </section>
</section>
