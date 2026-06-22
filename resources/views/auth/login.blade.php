@extends('layouts.guest')

@section('title', __('auth.login'))
@section('guest_width', 'max-w-md')

@section('content')
    <div class="mb-6 text-center">
        <h1 class="text-2xl font-bold text-white">{{ __('auth.loginHeading') }}</h1>
        <p class="mt-2 text-sm text-gray-400">{{ __('auth.loginIntro') }}</p>
    </div>

    <x-auth-session-status class="mb-4 rounded-lg bg-emerald-900 px-4 py-3 text-sm text-emerald-100" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <div>
            <x-input-label for="email" :value="__('auth.email')" class="text-gray-200" />
            <x-text-input id="email" class="mt-1 block w-full border-gray-600 bg-gray-700 text-white focus:border-emerald-500 focus:ring-emerald-500" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-300" />
        </div>

        <div>
            <x-input-label for="password" :value="__('auth.password')" class="text-gray-200" />
            <x-text-input id="password" class="mt-1 block w-full border-gray-600 bg-gray-700 text-white focus:border-emerald-500 focus:ring-emerald-500" type="password" name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-300" />
        </div>

        <div class="flex items-center justify-between">
            <label for="remember_me" class="flex items-center text-sm text-gray-300">
                <input id="remember_me" type="checkbox" class="rounded border-gray-600 bg-gray-700 text-emerald-500" name="remember">
                <span class="ms-2">{{ __('auth.remember') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-sm text-emerald-400 hover:text-emerald-300" href="{{ route('password.request') }}">
                    {{ __('auth.forgotPassword') }}
                </a>
            @endif
        </div>

        <button type="submit" class="w-full rounded-lg bg-emerald-500 px-4 py-2 font-semibold text-gray-950 hover:bg-emerald-400">
            {{ __('auth.login') }}
        </button>

        <p class="text-center text-sm text-gray-400">
            {{ __('auth.noAccount') }}
            <a href="{{ route('register') }}" class="text-emerald-400 hover:text-emerald-300">{{ __('auth.register') }}</a>
        </p>
    </form>
@endsection
