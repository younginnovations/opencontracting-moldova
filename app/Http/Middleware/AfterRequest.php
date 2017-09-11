<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class AfterRequest
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        //cache the request if not already exists
        $key = 'route_'.Str::slug($request->url());
        if (!Cache::has($key)) {
            $response->original = '';
            Cache::put($key, $response, config('cache.time'));

            //to create the list of routes that has been cached
            $previousRoutes = Cache::get('routes');
            $cachedRoutes = empty($previousRoutes) ? $key : $previousRoutes.','.$key;
            Cache::put('routes', $cachedRoutes, config('cache.time'));
        }

        return $response;
    }
}
