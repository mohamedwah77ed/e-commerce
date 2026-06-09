<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Supported locales
     */
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $supportedLocales = array_keys(config('locales.supported', []));
        $defaultLocale = config('locales.default', 'ar');

        $locale = Session::get('locale', $defaultLocale);

        if (! in_array($locale, $supportedLocales, true)) {
            $locale = $defaultLocale;
        }

        App::setLocale($locale);
        Session::put('locale', $locale);

        return $next($request);
    }
}