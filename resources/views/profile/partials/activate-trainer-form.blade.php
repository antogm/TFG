<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('profile.becomeTrainer') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('profile.becomeTrainerDescription') }}
        </p>
    </header>

    <form method="post" action="{{ route('entrenador.alta') }}" class="mt-6"
        onsubmit="return confirm(@js(__('profile.becomeTrainerConfirmation')));">
        @csrf
        @method('patch')

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('profile.becomeTrainerButton') }}</x-primary-button>

            @if (session('status') === 'trainer-profile-deactivated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400">{{ __('profile.trainerProfileDeactivated') }}</p>
            @endif
        </div>
    </form>
</section>
