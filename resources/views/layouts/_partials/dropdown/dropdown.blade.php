@if(auth()->user()->rol === 'entrenador')
    @include('layouts._partials.dropdown.dropdown_entrenador')
@else
    @include('layouts._partials.dropdown.dropdown_cliente')
@endif
