<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Common\StaffRequest;
use App\Models\Staff;
use App\Models\Tag;
use App\Models\Role;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;

class StaffController extends Controller
{
	/**
	* Show the form for creating a new resource.
	*
	* @return \Illuminate\Http\Response
	*/
	public function create()
	{
		if(session('userType') == 'Admin') {
			$tag = Tag::orderBy('name')
				->get([ 'id', 'name' ]);

			if(!$tag){
				abort(500);
			}
		}
		
		$roles = Role::where('status', 'Active')
			->orderBy('display_order')
			->get([ 'id', 'name' ]);
		
		if(!$roles){
			abort(500);
		}
		$vars = [
			'roles' => $roles
		];

		if(session('userType') == 'Admin') {
			$vars += [
				'page_title' => 'Add Blog Operator Staff User',
				'tag' => $tag
			];
		} else{
			$vars['page_title'] = 'Add Staff User';
		}
		return view('users.common.blog-operator-staff-add', $vars);
	}

	/**
	* Store a newly created resource in storage.
	*
	* @param \App\Http\Requests\Common\StaffRequest $r
	* @return array
	*/
	public function store(StaffRequest $r)
	{
		DB::beginTransaction();

		try {		 
			$staff = Staff::create($r->all());
			
			$staffRoles = [];
			for($i = 0; $i < count($r->role); $i++) {
				$staffRoles[] = [
					'role_id' => $r->role[$i],
					'tour_operator_staff_id' => $staff->id,
					'created_by' => auth()->id(),
					'created_by_user_type' => session('userType')
				];
			}
			DB::table('tour_operator_staff_roles')->insert($staffRoles);
			DB::commit();
			return response()->json([]);
		}
		catch(\Exception $ex) {
			DB::rollback();
			logMsg($ex);

			if(session('userType') == 'Admin')
				$msg = 'Unable to add blog operator staff user.';
			else
				$msg = 'Unable to add staff user.';
			
			return sendJsonErrMsg($msg);
		} 
	}

	/**
	* Display a listing of the resource.
	*
	* @return \Illuminate\Http\Response
	*/
	public function index()
	{
		if(session('userType') == 'Admin'){
			$vars = [ 'page_title' => 'Blog Operator Staff Users' ];
		
				$blogOperators = Tag::orderBy('name')
					->get([ 'id', 'name' ]);
					$vars['blogOperators'] = $blogOperators;
			}
		else{
			$vars = [ 'page_title' => 'Staff Users' ];
		}
		return view('users.common.blog-operator-staff-list', $vars);
	}

	/**
	* Array response for DataTable.
	*
	* @param  \Yajra\DataTables\DataTables $dt
	* @return array
	*/
	public function indexAHR(DataTables $dt)
	{
		$selectFields = [ 'tos.id', 'tos.first_name', 'tos.last_name', 'tos.email', 'tos.phone_number', 'tos.status' ];
		
		$qry = DB::table('tour_operator_staff AS tos');
		$qry = $qry->where('tos.deleted_by', 0)
			->select($selectFields);
		
		if(session('userType') == 'Admin') {
			
			$routePrefix = 'admin.';
		} else {
			$routePrefix = '';
		}

		return Datatables::of($qry)
			->addIndexColumn()
			->editColumn('status', function($staff) {
				return '<span class="status-' . $staff->status . '">' . $staff->status . '</span>';
			})
			->editColumn('action', function($staff) use($routePrefix) {
				return '<a href="' . route($routePrefix . 'blog-operator.staff.edit', [ 'staff' => $staff->id ]) . '" class="btn btn-edit btn-sm me-3"><i class="far fa-edit"></i> Edit</a>' .
					'<button data-url="' . route($routePrefix . 'blog-operator.staff.destroy', [ 'staff' => $staff->id ]) . '" data-method="delete" class="btn btn-sm btn-delete"><i class="far fa-trash-alt"></i> Delete</a>';
			})
			->rawColumns([ 'action', 'status' ])
			->make(true);
	}

	/**
	* Show the form for editing the specified resource.
	*
	* @param int $id
	* @return \Illuminate\Http\Response
	*/
	public function edit(int $id) 
	{
		$staff = Staff::findOrFail($id);

		if(session('userType') == 'Admin') {
			$tourOperators = DB::table('tags')
				->where(function($qry) {
					$qry->where('deleted_by', 0);
				})
				->orderBy('name')
				->get([ 'id', 'name' ]);
		
			if(!$tourOperators){
				abort(500);
			}
		}

		$roles = DB::table('roles AS r')
			->leftJoin('tour_operator_staff_roles AS tosr', 'tosr.role_id', '=', DB::raw("r.id AND (ISNULL(tosr.tour_operator_staff_id) OR tosr.tour_operator_staff_id = $id)"))
			->where('r.deleted_by', 0)
			->where('r.status', 'Active')
			->orderBy('r.display_order')
			->get([ 'r.id', 'r.name', 'tosr.deleted_by', 'tosr.id AS tosr_id' ]);
		
		if(!$roles){
			abort(500);
		}
		$vars = [
			'roles' => $roles,
			'staff' => $staff,
		];

		if(session('userType') == 'Admin') {
			$vars += [
				'page_title' => 'Edit Blog Operator Staff User',
				'tourOperators' => $tourOperators,
			];
		} else{
			$vars['page_title'] = 'Edit Staff User';
		}
		return view('users.common.blog-operator-staff-edit', $vars);
	}
	
	/**
	* Update the specified resource in storage.
	*
	* @param \App\Http\Requests\Common\StaffRequest $r
	* @param int $id
	* @return array
	*/
	public function updateGeneral(StaffRequest $r, int $id)
	{
		
		try {
			if(session('userType') == 'Admin'){
				$values = $r->except('status');
			}else{
				$values = $r->all();
			}
			if($values['password'] == "" || $values['password'] == null){
				$values = $r->except('password', 'status');}
				$values = Staff::findOrFail($id)
					->fill($values)
					->saveOrFail();	
			
			return response()->json([]);
			}
		catch(\Exception $ex) {
			logMsg($ex);

			if(session('userType') == 'Admin'){
				$msg = 'Unable to update blog operator staff user details.';
			}else{
				$msg = 'Unable to update staff user details.';
			}	
			return sendJsonErrMsg($msg);
		}
	}

	public function updateRole(Request $r, $id)
	{
		try {
			$staffRole = DB::table('tour_operator_staff_roles AS tosr')
				->where('tosr.role_id', $r->role)
				->where('tosr.tour_operator_staff_id', $id);
			
			if(session('userType') == 'Tour Operator') {
				$staffRole = $staffRole->join('tour_operator_staff AS tos', 'tos.id', '=', 'tosr.tour_operator_staff_id')
					->where('tos.tour_operator_id', auth()->user()->tour_operator_id);
			}

			$staffRole = $staffRole->first([ 'tosr.id', 'tosr.deleted_by' ]);
			
			if($staffRole) { // record exist (role was assigned)
				if($staffRole->deleted_by) { // then, record was deleted (role was unassigned)
					// so, undelete/restore the record to assign the role again
					DB::table('tour_operator_staff_roles')
						->where('role_id', $r->role)
						->where('tour_operator_staff_id', $id)
						->update([
							'deleted_at' => '0000-00-00 00:00:00',
							'deleted_by' => 0,
							'updated_at' => mysqlDT(),
							'updated_by' => auth()->id(),
							'updated_by_user_type' => session('userType')
						]);
				   } else { // role isn't deleted (role is presently assigned)
					// so, delete record to unassign the role
					  DB::table('tour_operator_staff_roles')
						->where('role_id', $r->role)
						->where('tour_operator_staff_id', $id)
						->update([
							'deleted_at' => mysqlDT(),
							'deleted_by' => auth()->id(),
							'deleted_by_user_type' => session('userType')
						]);
					}
			} else { // record not found (role is never assigned to the user)
				// so, assign the role now
				DB::table('tour_operator_staff_roles')
					->insert([
						'role_id' => $r->role,
						'tour_operator_staff_id' => $id,
						'created_by' => auth()->id(),
						'created_by_user_type' => session('userType')
					]);
			}

			return response()->json([]);
		}
		catch(\Exception $ex) {
			logMsg($ex);

			if(session('userType') == 'Admin'){
				$msg = "Unable to update blog operator staff user's role.";
			}else{
				$msg = "Unable to update staff user's role.";
			}	
			return sendJsonErrMsg($msg);
		}
	}

	/**
	* Remove the specified resource from storage.
	*
	* @param int $id
	* @return array
	*/
	public function destroy(int $id)
	{
		try {
			DB::table('tour_operator_staff')
				->where('id', $id)
				->update([
					'deleted_at' => mysqlDT(),
					'deleted_by' => auth()->id(),
					'deleted_by_user_type' => session('userType'),
				]);
			
			return response()->json([]);
		}
		catch(\Exception $ex) {
			logMsg($ex);

			if(session('userType') == 'Admin'){
				$msg = 'Unable to delete blog operator staff user.';
			}else{
				$msg = 'Unable to delete staff user.';
			}	
			return sendJsonErrMsg($msg);
		}
	}
}
