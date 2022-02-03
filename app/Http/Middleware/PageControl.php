<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PageControl
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
    	$hasAccess = Session::get('hasPageControl');
    	if( $hasAccess ){
		    return $next($request);
	    }

		return redirect(route('confirm.page.control'));
    }
}
