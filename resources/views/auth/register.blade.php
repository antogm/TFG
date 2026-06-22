@extends('layouts.guest')

@section('title', __('views.titles_register'))
@section('guest_width', 'max-w-2xl')

@section('content')
    <div class="mb-6 text-center">
        <h1 class="text-2xl font-bold text-white">{{ __('auth.registerHeading') }}</h1>
        <p class="mt-2 text-sm text-gray-400">{{ __('auth.registerIntro') }}</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <div class="grid gap-4 md:grid-cols-2">
            <div>
                <x-input-label for="name" :value="__('auth.Name')" class="text-gray-200" />
                <x-text-input id="name" class="mt-1 block w-full border-gray-600 bg-gray-700 text-white focus:border-emerald-500 focus:ring-emerald-500" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2 text-red-300" />
            </div>

            <div>
                <x-input-label for="email" :value="__('auth.email')" class="text-gray-200" />
                <x-text-input id="email" class="mt-1 block w-full border-gray-600 bg-gray-700 text-white focus:border-emerald-500 focus:ring-emerald-500" type="email" name="email" :value="old('email')" required autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-300" />
            </div>

            <div>
                <x-input-label for="rol" :value="__('auth.role')" class="text-gray-200" />
                <select id="rol" name="rol" class="mt-1 block w-full rounded-md border-gray-600 bg-gray-700 text-white focus:border-emerald-500 focus:ring-emerald-500" required>
                    <option value="">{{ __('auth.selectRole') }}</option>
                    <option value="usuario" {{ old('rol') == 'usuario' ? 'selected' : '' }}>{{ __('auth.rolUsuario') }}</option>
                    <option value="entrenador" {{ old('rol') == 'entrenador' ? 'selected' : '' }}>{{ __('auth.rolEntrenador') }}</option>
                </select>
                <x-input-error :messages="$errors->get('rol')" class="mt-2 text-red-300" />
            </div>

            <div>
                <x-input-label for="genero" :value="__('views.gender')" class="text-gray-200" />
                <select id="genero" name="genero" class="mt-1 block w-full rounded-md border-gray-600 bg-gray-700 text-white focus:border-emerald-500 focus:ring-emerald-500" required>
                    <option value="Masculino" {{ old('genero', 'Prefiero no especificarlo') == 'Masculino' ? 'selected' : '' }}>{{ __('views.gender_male') }}</option>
                    <option value="Femenino" {{ old('genero', 'Prefiero no especificarlo') == 'Femenino' ? 'selected' : '' }}>{{ __('views.gender_female') }}</option>
                    <option value="Prefiero no especificarlo" {{ old('genero', 'Prefiero no especificarlo') == 'Prefiero no especificarlo' ? 'selected' : '' }}>{{ __('views.gender_unspecified') }}</option>
                </select>
                <x-input-error :messages="$errors->get('genero')" class="mt-2 text-red-300" />
            </div>

            <div>
                <x-input-label for="altura" :value="__('registrocorporal.altura')" class="text-gray-200" />
                <x-text-input id="altura" class="mt-1 block w-full border-gray-600 bg-gray-700 text-white focus:border-emerald-500 focus:ring-emerald-500" type="number" name="altura" :value="old('altura')" step="1" min="0" max="500" required />
                <x-input-error :messages="$errors->get('altura')" class="mt-2 text-red-300" />
            </div>

            <div>
                <x-input-label for="objetivo" :value="__('views.goal')" class="text-gray-200" />
                <select id="objetivo" name="objetivo" class="mt-1 block w-full rounded-md border-gray-600 bg-gray-700 text-white focus:border-emerald-500 focus:ring-emerald-500" required>
                    <option value="Pérdida de grasa" {{ old('objetivo', 'Sin objetivo marcado') == 'Pérdida de grasa' ? 'selected' : '' }}>{{ __('views.goal_fat_loss') }}</option>
                    <option value="Aumento de masa muscular" {{ old('objetivo', 'Sin objetivo marcado') == 'Aumento de masa muscular' ? 'selected' : '' }}>{{ __('views.goal_muscle_gain') }}</option>
                    <option value="Recomposición corporal" {{ old('objetivo', 'Sin objetivo marcado') == 'Recomposición corporal' ? 'selected' : '' }}>{{ __('views.goal_recomposition') }}</option>
                    <option value="Sin objetivo marcado" {{ old('objetivo', 'Sin objetivo marcado') == 'Sin objetivo marcado' ? 'selected' : '' }}>{{ __('views.goal_none') }}</option>
                </select>
                <x-input-error :messages="$errors->get('objetivo')" class="mt-2 text-red-300" />
            </div>

            <div>
                <x-input-label for="password" :value="__('auth.password')" class="text-gray-200" />
                <x-text-input id="password" class="mt-1 block w-full border-gray-600 bg-gray-700 text-white focus:border-emerald-500 focus:ring-emerald-500" type="password" name="password" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-300" />
            </div>

            <div>
                <x-input-label for="password_confirmation" :value="__('auth.confirmPassword')" class="text-gray-200" />
                <x-text-input id="password_confirmation" class="mt-1 block w-full border-gray-600 bg-gray-700 text-white focus:border-emerald-500 focus:ring-emerald-500" type="password" name="password_confirmation" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-red-300" />
            </div>
        </div>

        <button type="submit" class="w-full rounded-lg bg-emerald-500 px-4 py-2 font-semibold text-gray-950 hover:bg-emerald-400">
            {{ __('auth.register') }}
        </button>

        <p class="text-center text-sm text-gray-400">
            {{ __('auth.haveAccount') }}
            <a class="text-emerald-400 hover:text-emerald-300" href="{{ route('login') }}">{{ __('auth.login') }}</a>
        </p>
    </form>
@endsection
