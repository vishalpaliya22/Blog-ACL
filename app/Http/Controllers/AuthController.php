<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use App\Http\Requests\Common\ResetPasswordRequest;
use Session;
use Illuminate\Support\Facades\Route;
use App\Models\Admin;

class AuthController extends Controller
{
	use AuthenticatesUsers;

	public function adminLoginForm()
	{
		$vars = [
			'page_title' => 'Admin Log-in',
			'formSubmitRoute' => 'auth.admin.login',
			'forgotPasswordRoute' => 'auth.admin.forgot-password-form',
		];

		return view('login-2', $vars);
	}

	public function adminLogin(Request $r)
	{
		return $this->commonLogin(
			$r,
			[
				'guard' => 'admin',
				'userType' => 'Admin',
				'routeUserHome' => 'admin.dashboard'
			]
		);
	}

	public function blogOpStaffLoginForm()
	{
		$vars = [
			'page_title' => 'Tour Operator Staff Log-in',
			'formSubmitRoute' => 'auth.blog-operator.login',
			'forgotPasswordRoute' => 'auth.blog-operator.forgot-password-form',
		];

		return view('login-2', $vars);
	}

	public function blogOpStaffLogin(Request $r)
	{
		return $this->commonLogin(
			$r,
			[
				'guard' => 'tour_operator_staff',
				'userType' => 'Tour Operator',
				'routeUserHome' => 'blog-operator.dashboard'
			]
		);
	}

	private function commonLogin(Request $r, $params)
	{ 
		if(Auth::guard($params['guard'])->attempt([
			'email' => $r->email, 'password' => $r->password
		], $r->has('remember'))) {
			session([
				'guard' => $params['guard'],
				'userType' => $params['userType'],
			]);
			
			return redirect()->intended(route($params['routeUserHome']));
		}

		return back()
			->withErrors([ 'errors' => 'Incorrect email address and/or password.' ])
			->withInput($r->except('password'));
	}

	public function logout(Request $r)
	{
		$guard = session('guard');
		
		if($guard = session('guard'))
			Auth::guard($guard)->logout();
		else
			Auth::logout();

		$r->session()->invalidate();
		$r->session()->regenerateToken();
		session()->forget('roleNames');

		if($guard == 'admin')
			return redirect(route('auth.admin.login-form'));

		if($guard == 'tour_operator_staff')
			return redirect(route('auth.blog-operator.login-form'));

		return redirect('/');
	}
}
