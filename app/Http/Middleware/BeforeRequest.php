<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class BeforeRequest
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

        //return from cache if cache already exists
        $key = 'route_'.Str::slug($request->url());
        if (Cache::has($key)) {
            return Cache::get($key);
        }
        return $next($request);
    }
}
