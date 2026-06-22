<div class="pt-2 pb-3 space-y-1">
    <x-responsive-nav-link :href="route('cliente.dashboard')">
        {{ __('nav.my_progress') }}
    </x-responsive-nav-link>

    <x-responsive-nav-link :href="route('rutinas.actual')">
        {{ __('nav.my_routine') }}
    </x-responsive-nav-link>

    <x-responsive-nav-link :href="route('entrenadores.index')">
        {{ __('nav.coachs') }}
    </x-responsive-nav-link>

    <x-responsive-nav-link :href="route('conversations.index')">
        {{ __('nav.conversations') }}
    </x-responsive-nav-link>

    <x-responsive-nav-link :href="route('ejercicios.index')">
        {{ __('nav.exercises') }}
    </x-responsive-nav-link>
</div>

<div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">

    <div class="px-4">
        <div class="font-medium text-base text-gray-800 dark:text-gray-200">
            {{ Auth::user()->name }}
        </div>
        <div class="font-medium text-sm text-gray-500">
            {{ Auth::user()->email }}
        </div>
    </div>

    <div class="mt-3 space-y-1">
        <x-responsive-nav-link :href="route('profile.edit')">
            {{ __('nav.profile') }}
        </x-responsive-nav-link>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <x-responsive-nav-link :href="route('logout')"
                onclick="event.preventDefault(); this.closest('form').submit();">
                {{ __('nav.logout') }}
            </x-responsive-nav-link>
        </form>
    </div>
</div>
