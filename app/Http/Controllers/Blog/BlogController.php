<?php

namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class BlogController extends Controller
{
	public function dashboard() {
		$guard = session('guard');
      	$id = auth($guard)->user()->id;
		$roleNames = "";
		if($guard == 'tour_operator_staff') {
			$roleNames = DB::table('tour_operator_staff_roles as tosd')
			->select('r.id','r.name as name')
			->join('roles as r', 'r.id' ,'=', 'tosd.role_id')
			->where('tosd.deleted_by', '=', '0')
			->where('tosd.tour_operator_staff_id', '=', $id)
			->get();
			
		}
		session()->put('roleNames', $roleNames);
		$vars = [
			'page_title' => 'Dashboard',
			'roleNames' => $roleNames
		];

		return view('users.blog-operator.dashboard', $vars);
	}
}
