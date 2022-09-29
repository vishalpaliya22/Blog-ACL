<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
	/**
	* Handle an incoming request.
	*
	* @param \Illuminate\Http\Request $request
	* @param \Closure $next
	* @param string|null ...$guards
	* @return mixed
	*/
	public function handle(Request $request, Closure $next, ...$guards)
	{
		if(
			Auth::guard('admin')->check() &&
			session('userType') == 'Admin' &&
			substr(\Route::currentRouteName(), 0, 11) == 'auth.admin.'
		) {
			return redirect()->route('admin.dashboard');
		}

		if(
			Auth::guard('tour_operator_staff')->check() &&
			session('userType') == 'Tour Operator' &&
			substr(\Route::currentRouteName(), 0, 19) == 'auth.blog-operator.'
		) {
			return redirect()->route('blog-operator.dashboard');
		}

		return $next($request);
	}
}
