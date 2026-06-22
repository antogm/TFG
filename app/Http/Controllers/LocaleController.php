<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class LocaleController extends Controller
{
    public function update(Request $request): RedirectResponse
    {
        $defaultLocale = config('app.locale', 'es');
        $supportedLocales = config('app.supported_locales');

        if (! is_array($supportedLocales) || $supportedLocales === []) {
            $supportedLocales = [$defaultLocale];
        }

        $data = $request->validate([
            'locale' => ['required', 'string', 'in:' . implode(',', $supportedLocales)],
        ]);

        $request->session()->put('locale', $data['locale']);

        return back();
    }
}
