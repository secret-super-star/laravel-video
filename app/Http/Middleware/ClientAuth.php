<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class ClientAuth
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
    	if (Auth::user() && auth()->user()->hasRole('administrator')) {
    	  //TODO: what to do if admin tries to access the users views
	    } else {
		    return $next($request);
	    }
    }
}
