<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    /**
     * Switch application language
     *
     * @param \Illuminate\Http\Request $request
     * @param string $locale
     * @return \Illuminate\Http\RedirectResponse
     */
    public function switchLocale(Request $request, $locale)
    {
        $supportedLocales = array_keys(config('locales.supported', []));
        $defaultLocale = config('locales.default', 'ar');

        if (! in_array($locale, $supportedLocales, true)) {
            $locale = $defaultLocale;
        }

        Session::put('locale', $locale);

        $referer = $request->headers->get('referer');
        $redirect = $referer ?: route('products.home');

        return redirect($redirect);
    }
}

