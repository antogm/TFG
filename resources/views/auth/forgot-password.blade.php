@extends('layouts.app')

@section("title", __("auth.forgotPassword"))

@section('content')
    <div class="min-h-[70vh] flex items-center justify-center px-4 py-12">
        <div class="w-full max-w-md rounded-xl bg-white dark:bg-gray-800 p-6 sm:p-8 shadow-lg ring-1 ring-gray-200 dark:ring-gray-700 space-y-6">

            <div class="px-4 text-sm text-gray-600 dark:text-gray-400 mb-6">
                <h1 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                    {{ __("auth.forgotPassword") }}
                </h1>
                <p class="text-sm leading-relaxed text-gray-600 dark:text-gray-400">
                    {{ __("auth.forgotPasswordIntro") }}
                </p>
            </div>


            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')"/>

            <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
                @csrf

                <!-- Email Address -->
                <div>
                    <x-input-label for="email" :value="__("auth.email")" class="text-gray-700 dark:text-gray-300" />
                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <x-primary-button class="w-full justify-center mt-4">
                    {{ __("auth.emailPasswordResetLink") }}
                </x-primary-button>
            </form>
        </div>
    </div>
@endsection
