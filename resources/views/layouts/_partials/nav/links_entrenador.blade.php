<x-nav-link :href="route('entrenador.dashboard')">
    {{ __('nav.dashboard') }}
</x-nav-link>

<x-nav-link :href="route('entrenador.clientes')">
    {{ __('nav.my_clients') }}
</x-nav-link>

<x-nav-link :href="route('rutinas.lista-rutinas')">
    {{ __('nav.my_routines') }}
</x-nav-link>

<x-nav-link :href="route('ejercicios.index')">
    {{ __('nav.exercises') }}
</x-nav-link>

<x-nav-link :href="route('conversations.index')">
    {{ __('nav.conversations') }}
</x-nav-link>