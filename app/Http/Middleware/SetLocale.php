<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;

class SetLocale
{
    public function handle($request, Closure $next)
    {
        $locale = $request->query('lang', 'en'); // default to English
        App::setLocale($locale);

        return $next($request);
    }
}
