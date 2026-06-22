<nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b">

    <div class="max-w-7xl mx-auto px-4">
        <div class="flex justify-between h-16">

            <!-- LEFT -->
            <div class="flex">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="{{ auth()->user()->rol === 'entrenador'
                        ? route('entrenador.dashboard')
                        : route('cliente.dashboard') }}">
                        <x-application-logo class="h-9 w-auto" />
                    </a>
                </div>

                <!-- Desktop links -->
                <div class="hidden sm:flex space-x-8 sm:ms-10">
                    @if(auth()->user()->rol === 'entrenador')
                        @include('layouts._partials.nav.links_entrenador')
                    @else
                        @include('layouts._partials.nav.links_cliente')
                    @endif
                </div>
            </div>

            <!-- RIGHT -->
            <div class="hidden sm:flex sm:items-center sm:gap-3">
                @include('layouts._partials.nav.language-switcher')
                @include('layouts._partials.dropdown.dropdown')
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="p-2">
                    ☰
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">

        @if(auth()->user()->rol === 'entrenador')
            @include('layouts._partials.nav.responsive_entrenador')
        @else
            @include('layouts._partials.nav.responsive_cliente')
        @endif

        @include('layouts._partials.nav.language-switcher-responsive')
    </div>
</nav>
