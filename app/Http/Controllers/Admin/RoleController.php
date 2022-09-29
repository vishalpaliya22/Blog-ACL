<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\RoleRequest;
use App\Models\Role;
use Yajra\DataTables\DataTables;

class RoleController extends Controller
{
	/**
	* Show the form for creating a new resource.
	*
	* @return \Illuminate\Http\Response
	*/
	public function create()
	{
		$vars = [
			'page_title' => 'Add Role',
			'formSubmitRoute' => route('admin.role.store'),
			'role' => new Role
		];

		return view('users.admin.role-add-edit', $vars);
	}

	/**
	* Store a newly created resource in storage.
	*
	* @param  \App\Http\Requests\Admin\RoleRequest $r
	* @return array
	*/
	public function store(RoleRequest $r)
	{
		try {
			Role::create($r->all());
			return response()->json([]);
		}
		catch(\Exception $ex) {
			logMsg($ex);
			return sendJsonErrMsg('Unable to add role.');
		}
	}

	/**
	* Display a listing of the resource.
	*
	* @return \Illuminate\Http\Response
	*/
	public function index()
	{
		$vars = [ 'page_title' => 'Roles' ];

		return view('users.admin.roles', $vars);
	}

	/**
	* Array response for DataTable.
	*
	* @param \Yajra\DataTables\DataTables $dt
	* @return array
	*/
	public function indexAHR(DataTables $dt)
	{
		$roles = Role::orderBy('display_order')
			->orderBy('name')
			->select([ 'id', 'name', 'display_order', 'status' ]);
			
		return Datatables::of($roles)
			->addIndexColumn()
			->editColumn('status', function ($role) {
				return '<span class="status-' . $role->status . '">' . $role->status . '</span>';
			})
			->editColumn('action', function($role) {
				return '<a href="' . route('admin.role.edit', [ 'role' => $role->id ]) . '" class="btn btn-edit btn-sm me-3"><i class="far fa-edit"></i> Edit</a>' .
					'<button data-url="' . route('admin.role.destroy', [ 'role' => $role->id ]) . '" data-method="delete" class="btn btn-sm btn-delete"><i class="far fa-trash-alt"></i> Delete</a>';
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
		$role = Role::findOrFail($id);

		$vars = [
			'page_title' => 'Edit Role',
			'formSubmitRoute' => route('admin.role.update', [ 'role' => $role ]),
			'role' => $role
		];

		return view('users.admin.role-add-edit', $vars);
	}

	/**
	* Update the specified resource in storage.
	*
	* @param \App\Http\Requests\Admin\RoleRequest $r
	* @param int $id
	* @return array
	*/
	public function update(RoleRequest $r, $id)
	{
		$role = Role::find($id);

		if(!$role)
			return sendJsonErrMsg('Role not found.', 404);
		
		$role->fill($r->all());

		try {
			$role->save();
			return response()->json([]);
		}
		catch(\Exception $ex) {
			logMsg($ex);
			return sendJsonErrMsg('Unable to update role.');
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
			\DB::table('roles')
				->where('id', $id)
				->update([
					'deleted_at' => mysqlDT(),
					'deleted_by' => auth(session('guard'))->id(),
				]);
			
			return response()->json([]);
		}
		catch(\Exception $ex) {
			logMsg($ex);
			return sendJsonErrMsg('Unable to delete role.');
		}
	}
}
