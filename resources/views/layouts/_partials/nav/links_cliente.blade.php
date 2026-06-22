<x-nav-link :href="route('cliente.dashboard')">
    {{ __('nav.my_progress') }}
</x-nav-link>

<x-nav-link :href="route('rutinas.actual')">
    {{ __('nav.my_routine') }}
</x-nav-link>

<x-nav-link :href="route('entrenadores.index')">
    {{ __('nav.coachs') }}
</x-nav-link>

<x-nav-link :href="route('conversations.index')">
    {{ __('nav.conversations') }}
</x-nav-link>

<x-nav-link :href="route('ejercicios.index')">
    {{ __('nav.exercises') }}
</x-nav-link>
