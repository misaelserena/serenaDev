<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class PermissionModule
{
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next, $module_id)
	{
		if (Auth::user()->module->where('id',$module_id)->count()>0) 
		{
			return $next($request);
		}
		else
		{
			return redirect('/error');
		}
	}
}
