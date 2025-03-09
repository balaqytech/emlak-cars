<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LocalizationMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $supportedLocales = config('app.locales');
        $prefix = $request->segment(1) ?? config('app.locale');

        if (!in_array($prefix, $supportedLocales)) {
            $local = config('app.locale');
            app()->setLocale($local);
            return redirect($local . '/' . $request->path());
        } else {
            app()->setLocale($prefix);
        }

        return $next($request);
    }
}
