<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'Laravel')) - {{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-900 font-sans text-gray-100 antialiased">
    <main class="flex min-h-screen items-center justify-center px-4 py-8">
        <div class="w-full @yield('guest_width', 'max-w-md')">
            <div class="mb-6 flex justify-center">
                <a href="/" class="flex items-center gap-3">
                    <x-application-logo class="h-14 w-auto text-emerald-400" />
                    <span class="text-2xl font-bold text-white">GonzFit</span>
                </a>
            </div>

            <div class="rounded-xl bg-gray-800 p-6 shadow-lg sm:p-8">
                @yield('content')
            </div>
        </div>
    </main>
</body>

</html>
