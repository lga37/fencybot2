<?php

namespace App\Http\Middleware;

use Closure;

class NoJSCache
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $response= $next($request);
        $response->header('Cache-Control','no-store, no-cache, must-revalidate, max-age=0');
        $response->header('Cache-Control','post-check=0, pre-check=0, false');
        $response->header('Pragma','no-cache');

        return $response;
    }
}
