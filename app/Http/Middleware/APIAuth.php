<?php

namespace App\Http\Middleware;

use Closure;

class APIAuth
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
	    $request->headers->set('accept', 'api');
//	    dd($request->header());
	    return $next($request);
    }
}
