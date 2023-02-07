<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\App;


class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure(Request): (Response|RedirectResponse) $next
     * @return Response|RedirectResponse
     */
    public function handle(Request $request, Closure $next): Response|RedirectResponse
    {
//        if ($request->has('lang') && (strtolower($request->lang) == 'de' || strtolower($request->lang) == 'en')) {
        if ($request->has('lang')) {
            $locale = strtolower($request->lang);
            if (!in_array($locale, ['en', 'de'])) {
                abort(400);
            }

            App::setLocale($locale);
        } else {
            App::setLocale('de');
        }

        return $next($request);
    }
}
