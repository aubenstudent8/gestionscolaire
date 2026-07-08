<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;

class SetLocale
{
    public function handle(Request $request, Closure $next)
    {
        // Priority: authenticated user's saved locale -> session locale -> app default
        $locale = Config::get('app.locale');
        if ($request->user() && ! empty($request->user()->locale)) {
            $locale = $request->user()->locale;
        } elseif ($request->session()->has('locale')) {
            $locale = $request->session()->get('locale');
        }
        App::setLocale($locale);
        Config::set('app.locale', $locale);

        return $next($request);
    }
}
