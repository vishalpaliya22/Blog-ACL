<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminController extends Controller
{
	public function dashboard()
	{
		$tourOperators = \DB::table('tags')
			// ->where('status', 'Active')
			->where('deleted_by', 0)
			->orderBy('name')
			->get([ 'id', 'name' ]);

		$vars = [
			'page_title' => 'Dashboard',
			'pageId' => 'dashboard',
			'tourOperators' => $tourOperators,
			'roleNames' => []
		];

		return view('users.admin.dashboard', $vars);
	}
}
