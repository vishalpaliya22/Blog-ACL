<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
	private $errMsg = 'Session has expired. Please re-login.';

	/**
	* Get the path the user should be redirected to when they are not authenticated.
	*
	* @param \Illuminate\Http\Request $r
	* @return string|null
	*/
	protected function redirectTo($r)
	{
		if($r->expectsJson())
			return sendJsonErrMsg($this->errMsg, 401);
		else {
			if(substr(\Route::currentRouteName(), 0, 6) == 'admin.')
				$user = 'admin';
			else
				$user = 'blog-operator';

			return route("auth.{$user}.login-form");
		}
	}
}
