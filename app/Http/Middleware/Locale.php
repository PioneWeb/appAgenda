<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Locale
{
    const SESSION_KEY = 'locale';
    const LOCALES = ['it', 'en', 'es', 'fr', 'de'];

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        session()->put(self::SESSION_KEY, $request->getPreferredLanguage(self::LOCALES));

        if ($request->has('lang')) {
            $lang = $request->get('lang');
            if (in_array($lang, self::LOCALES)) {
                session()->put(self::SESSION_KEY, $lang);
            }
        }

        app()->setLocale(session()->get(self::SESSION_KEY));
        return $next($request);
    }
}
