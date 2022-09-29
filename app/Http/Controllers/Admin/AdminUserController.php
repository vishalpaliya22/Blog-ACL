<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\AdminUserRequest;
use App\Http\Requests\Admin\AdminPasswordChange;
use App\Models\Admin;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Hash;

class AdminUserController extends Controller
{
	/**
	* Show the form for creating a new resource.
	*
	* @return \Illuminate\Http\Response
	*/
	public function create()
	{
		$vars = [
			'page_title' => 'Add Admin User',
			'formSubmitRoute' => route('admin.admin-user.store'),
			'admin' => new Admin
		];

		return view('users.admin.admin-add-edit', $vars);
	}

	/**
	* Store a newly created resource in storage.
	*
	* @param  \App\Http\Requests\Admin\AdminUserRequest $r
	* @return array
	*/
	public function store(AdminUserRequest $r)
	{
		try {
			Admin::create($r->all());
			return response()->json([]);
		}
		catch(\Exception $ex) {
			logMsg($ex);
			return sendJsonErrMsg('Unable to add admin user.');
		}
	}

	/**
	* Display a listing of the resource.
	*
	* @return \Illuminate\Http\Response
	*/
	public function index()
	{
		$vars = [ 'page_title' => 'Admin Users' ];

		return view('users.admin.admins', $vars);
	}

	/**
	* Array response for DataTable.
	*
	* @param  \Illuminate\Http\Request $r
	* @return array
	*/
	public function indexAHR(Request $r)
	{
		$admins = Admin::select([ 'id', 'name', 'email', 'status' ]);
			
		return Datatables::of($admins)
			->addIndexColumn()
			->editColumn('status', function($admin) {
				return '<span class="status-' . $admin->status . '">' . $admin->status . '</span>';
			})
			->editColumn('action', function($admin) {
				return '<a href="' . route('admin.admin-user.edit', [ 'admin_user' => $admin ]) . '" class="btn btn-edit btn-sm me-3"><i class="far fa-edit"></i> Edit</a>' .
					'<button data-url="' . route('admin.admin-user.destroy', [ 'admin_user' => $admin ]) . '" data-method="delete" class="btn btn-sm btn-delete"><i class="far fa-trash-alt"></i> Delete</a>';
			})
			->rawColumns([ 'action', 'status' ])
			->make(true);
	}

	public function edit($id)
	{
		$admin = Admin::findOrFail($id);
		
		$vars = [
			'page_title' => 'Edit Admin User',
			'formSubmitRoute' => route('admin.admin-user.update', [ 'admin_user' => $admin ]),
			'admin' => $admin,
			'id' => $id,
		];

		return view('users.admin.admin-add-edit', $vars);
	}

	/**
	* Update the specified resource in storage.
	*
	* @param \App\Http\Requests\Admin\AdminUserRequest $r
	* @param int $id
	* @return array
	*/
	public function update(AdminUserRequest $r, int $id)
	{
		try {
			if($id == auth(session('guard'))->id()){
				$values = $r->except('status');
			}else{
				$values = $r->all();
			}

			$admin = Admin::find($id);
			$admin->name = $values['name'];
			$admin->email = $values['email'];
			if ($admin->password != $values['password']) {
		 		$admin->password = bcrypt($values['password']);
			}
			$admin->status = $values['status'];
			$admin->save();

			return response()->json([]);
		}

		catch(\Exception $ex) {
			logMsg($ex);
			return sendJsonErrMsg('Unable to update admin user details.');
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
		if($id == auth(session('guard'))->id()){
			return sendJsonErrMsg('Your own record can not be deleted by you.');
		}
		try {
			\DB::table('admins')
				->where('id', $id)
				->update([
					'deleted_at' => mysqlDT(),
					'deleted_by' => auth(session('guard'))->id(),
				]);
			
			return response()->json([]);
		}
		catch(\Exception $ex) {
			logMsg($ex);
			return sendJsonErrMsg('Unable to delete admin user.');
		}
	}

	/*public function changeProfilePassword(AdminPasswordChange $r, int $id)
	{
		try {
	     Admin::where('id', $id)->update(['password' => Hash::make($r->new_password)]);
	     return response()->json([]);
		}
		catch(\Exception $ex) {
			logMsg($ex);
			return sendJsonErrMsg('Unable to update password.');
		}
	}*/
}
