<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use JetBrains\PhpStorm\NoReturn;

class Cors
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
        die("here");
        if (app()->isLocal()) {
            return $next($request)
                ->header('Access-Control-Allow-Origin', '*')
                ->header('Access-Control-Allow-Methods', 'GET, POST, OPTIONS, PUT, PATCH, DELETE')
                ->header('Access-Control-Allow-Headers', ' Origin, Content-Type, Accept, Authorization, X-Request-With, Accept')
                ->header('Access-Control-Allow-Credentials', ' true')
                ->header('Access-Control-Allow-Methods', 'GET, POST, OPTIONS, PUT, PATCH, DELETE');
        } else {
            die("here");
            $origins = explode(
                ',',
                env('SANCTUM_STATEFUL_DOMAINS')
            );
            if ($origins != null && $request->server('HTTP_ORIGIN') != null) {
                if (in_array($request->server('HTTP_ORIGIN'), $origins)) {
                    return $next($request)
                        ->header('Access-Control-Allow-Origin', $request->server('HTTP_ORIGIN'))
                        ->header('Access-Control-Allow-Methods', 'POST, GET, OPTIONS, PUT, DELETE, PATCH')
                        ->header('Access-Control-Allow-Credentials', ' true')
                        ->header('Access-Control-Allow-Headers', '*');
                } else {
                    return $next($request)
                        ->header('Access-Control-Allow-Methods', 'GET, POST, OPTIONS, PUT, PATCH, DELETE')
                        ->header('Access-Control-Allow-Headers', ' Origin, Content-Type, Accept, Authorization, X-Request-With, Accept')
                        ->header('Access-Control-Allow-Credentials', ' true');
                }

            } else {

                return $next($request)
                    ->header('Access-Control-Allow-Origin', '*')
                    ->header('Access-Control-Allow-Methods', 'GET, POST, OPTIONS, PUT, PATCH, DELETE')
                    ->header('Access-Control-Allow-Headers', ' Origin, Content-Type, Accept, Authorization, X-Request-With, Accept')
                    ->header('Access-Control-Allow-Credentials', ' true')
                    ->header('Access-Control-Allow-Methods', 'GET, POST, OPTIONS, PUT, PATCH, DELETE');
            }

        }
    }
}
