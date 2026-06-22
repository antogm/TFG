<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocaleFromSession
{
    public function handle(Request $request, Closure $next): Response
    {
        $defaultLocale = config('app.locale', 'es');
        $supportedLocales = config('app.supported_locales');

        if (! is_array($supportedLocales) || $supportedLocales === []) {
            $supportedLocales = [$defaultLocale];
        }

        $locale = $request->session()->get('locale', $defaultLocale);

        if (! in_array($locale, $supportedLocales, true)) {
            $locale = $defaultLocale;
        }

        app()->setLocale($locale);

        return $next($request);
    }
}
