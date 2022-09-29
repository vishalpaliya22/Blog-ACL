<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\TagRequest;
use App\Models\Tag;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use Session;

class TagController extends Controller
{
	/**
	* Show the form for creating a new resource.
	*
	* @return \Illuminate\Http\Response
	*/
	public function create()
	{
		$vars = [ 'page_title' => 'Add Tag',];

		return view('users.admin.tag-add', $vars);
	}

	/**
	* Store a newly created resource in storage.
	*
	* @param  \App\Http\Requests\Admin\TagRequest $r
	* @return array
	*/
	public function store(TagRequest $r)
	{
		$fieldsValues = $r->all();

		try {
			$Tag = Tag::create($fieldsValues);
			
			if(session('userType') == 'Admin'){
				$routePrefix = 'admin.';
			}else{
				$routePrefix = '';
			}

			return redirect()
				->route($routePrefix .'blog-operator.tag.index')
				->with('message', 'Tag added.');
		}
		catch(\Exception $ex) {
			DB::rollback();
			logMsg($ex);
		
			return back()
				->withErrors([ 'errors' => 'Unable to add tag.' ])
				->withInput();
		}
	}

	/**
	* Display a listing of the resource.
	*
	* @return \Illuminate\Http\Response
	*/
	public function index()
	{
		$vars = [ 'page_title' => 'Tag' ];

		return view('users.admin.tags', $vars);
	}

	/**
	* Array response for DataTable.
	*
	* @param \Yajra\DataTables\DataTables $dt
	* @return array
	*/
	public function indexAHR(DataTables $dt)
	{
		if(session('userType') == 'Admin') {
			$routePrefix = 'admin.';
		} else {
			$routePrefix = '';
		}

		$qry = DB::table('tags AS t_o')
			->where('t_o.deleted_by', 0)
			->select([ 't_o.id', 't_o.name' ]);
		
		return Datatables::of($qry)
			->addIndexColumn()
			->editColumn('action', function($Tag)  use($routePrefix) {
				return '<a href="' . route($routePrefix . 'blog-operator.tag.edit', [ 'tag' => $Tag->id ]) . '" class="btn btn-edit btn-sm me-3"><i class="far fa-edit"></i> Edit</a>' .
					'<button data-url="' . route($routePrefix . 'blog-operator.tag.destroy', [ 'tag' => $Tag->id ]) . '" data-method="delete" class="btn btn-sm btn-delete"><i class="far fa-trash-alt"></i> Delete</a>';
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
		$Tag = DB::table('tags AS t_o')
			->where('t_o.id', $id)
			->first([ 't_o.*' ]);

		if(!$Tag)
			abort(404);
		
		if(session('userType') == 'Admin') {
			$routePrefix = 'admin.';
		} else {
			$routePrefix = '';
		}

		$vars = [
			'page_title' => 'Edit Tag',
			'routePrefix' => $routePrefix,
			'Tag' => $Tag
		];

		return view('users.admin.tag-edit', $vars);
	}

	/**
	* Update general details of the tag.
	*
	* @param  \App\Http\Requests\Admin\TagRequest $r
	* @param int $id
	* @return array
	*/
	public function updateGeneral(TagRequest $r, int $id)
	{
		$Tag = Tag::find($id);

		if(!$Tag){
			return sendJsonErrMsg("Tag not found.", 404);
		}

		$fieldsValues = $r->all();
		 
		$Tag->fill($fieldsValues);

		try {
			$Tag->save();

			return response()->json([]);
		}
		catch(\Exception $ex) {
			logMsg($ex);
			return sendJsonErrMsg("Unable to update the tag.");
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
			DB::table('tags')
				->where('id', $id)
				->update([
					'deleted_at' => mysqlDT(),
					'deleted_by' => auth(session('guard'))->id(),
					'deleted_by_user_type' => session('userType'),
				]);
			
			return response()->json([]);
		}
		catch(\Exception $ex) {
			logMsg($ex);
			return sendJsonErrMsg('Unable to delete tag.');
		}
	}
}
