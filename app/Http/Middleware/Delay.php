<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Delay
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->query->has('_delay')) {
            $delay = (int) $request->query('_delay');
            usleep($delay * 1000);
        }

        return $next($request);
    }
}
