<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use App\Http\Requests\Common\BlogRequest;
use Illuminate\Http\Request;
use App\Models\Tag;
use App\Models\Blog;
use App\Models\Comment;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Session;

class BlogController extends Controller
{
	/**
	* Show the form for creating a new resource.
	*
	* @return \Illuminate\Http\Response
	*/
	public function create()
	{
		$vars = [ 'page_title' => 'Add Blog' ];
		
		return view('users.common.blog-add', $vars);
	}

	public function commentAdd(Request $r)
	{
		$validated = $r->validate([
 			'comment' => 'required',
        ]);

        if(session('userType') == 'Admin'){
			$routePrefix = 'admin.';
		}else{
			$routePrefix = '';
		}

        $comment = new Comment;
        $comment->desc = $r->comment;
        $comment->blog_id = $r->blog_id;
        $comment->save();
        
        Session::flash('message', 'Comment successfully added!');
        return redirect()->back()->withOutInput($routePrefix);
	}

	/**
	* Store a newly created resource in storage.
	*
	* @param  \App\Http\Requests\Common\BlogRequest $r
	* @return \Illuminate\Http\Response
	*/
	public function store(BlogRequest $r)
	{

		try {
			$blogData = Blog::create($r->only(Blog::fillableFields()));

			if(session('userType') == 'Admin'){
				$routePrefix = 'admin.';
			}else{
				$routePrefix = '';
			}

			$return = redirect()
				->route($routePrefix . 'blog-operator.blog.index')
				->with('message', 'Blog added.');
			
			return $return;
		}
		catch(\Exception $ex) {
			DB::rollback();
			logMsg($ex);
		
			return back()
				->withErrors([ 'errors' => 'Unable to add blog.' ])
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
		$vars = [ 'page_title' => 'Blogs' ];

		return view('users.common.blogs', $vars);
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
		
		$selectFields = [ 'blog.id', 'blog.name', 'blog.status' ];
 				
		$qry = DB::table('blogs AS blog')->where('blog.deleted_by', 0);
		$qry = $qry->select($selectFields);
		
		return Datatables::of($qry)
			->addIndexColumn()
			->editColumn('status', function($blog) {
				return '<span class="status-' . $blog->status . '">' . $blog->status . '</span>';
			})
			->editColumn('action', function($blog) use($routePrefix) {
				
				if(session('userType') === 'Admin'){
					return '<a href="' . route($routePrefix . 'blog-operator.blog.show', [ 'blog' => $blog->id ]) . '" class="btn btn-edit btn-sm me-3"><i class="far fa-eye"></i> View</a>'.
					'<a href="' . route($routePrefix . 'blog-operator.blog.edit', [ 'blog' => $blog->id ]) . '" class="btn btn-edit btn-sm me-3"><i class="far fa-edit"></i> Edit</a>' .
					'<button data-url="' . route($routePrefix . 'blog-operator.blog.destroy', [ 'blog' => $blog->id ]) . '" data-method="delete" class="btn btn-sm btn-delete"><i class="far fa-trash-alt"></i> Delete</a>';
				}else{
					if(Session::get('roleNames')){
						if(Session::get('roleNames')->contains("name", "Admin")){
							return '<a href="' . route($routePrefix . 'blog-operator.blog.show', [ 'blog' => $blog->id ]) . '" class="btn btn-edit btn-sm me-3"><i class="far fa-eye"></i> View</a>'.
								'<a href="' . route($routePrefix . 'blog-operator.blog.edit', [ 'blog' => $blog->id ]) . '" class="btn btn-edit btn-sm me-3"><i class="far fa-edit"></i> Edit</a>' .
								'<button data-url="' . route($routePrefix . 'blog-operator.blog.destroy', [ 'blog' => $blog->id ]) . '" data-method="delete" class="btn btn-sm btn-delete"><i class="far fa-trash-alt"></i> Delete</a>';
					 	}elseif(Session::get('roleNames')->contains("name", "Writer")){
							return '<a href="' . route($routePrefix . 'blog-operator.blog.show', [ 'blog' => $blog->id ]) . '" class="btn btn-edit btn-sm me-3"><i class="far fa-eye"></i> View</a>'.
								'<a href="' . route($routePrefix . 'blog-operator.blog.edit', [ 'blog' => $blog->id ]) . '" class="btn btn-edit btn-sm me-3"><i class="far fa-edit"></i> Edit</a>' .
								'<button data-url="' . route($routePrefix . 'blog-operator.blog.destroy', [ 'blog' => $blog->id ]) . '" data-method="delete" class="btn btn-sm btn-delete"><i class="far fa-trash-alt"></i> Delete</a>';
					 	}elseif(Session::get('roleNames')->contains("name", "Reader")){

							return '<a href="' . route($routePrefix . 'blog-operator.blog.show', [ 'blog' => $blog->id ]) . '" class="btn btn-edit btn-sm me-3"><i class="far fa-eye"></i> View</a>';
					 	}
				 	}
				}
				
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
	public function show($id)
	{
		$blogData = Blog::findOrFail($id);
		$commentData = Comment::where('blog_id','=',$id)
			->orderBy('id','desc')
			->select(['desc',  DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d") as createdDate')])
			->get();

		if(session('userType') == 'Admin') {
			$routePrefix = 'admin.';
		} else {
			$routePrefix = '';
		}

		$vars = [ 
			'page_title' => 'Show Blog Details',
			'blogData' => $blogData,
			'commentData' => $commentData,
			'routePrefix' => $routePrefix,
		];
		
		return view('users.common.blog-show', $vars);
	}
	/**
	* Show the form for editing the specified resource.
	*
	* @param int $id
	* @return \Illuminate\Http\Response
	*/
	public function edit(int $id)
	{
		$blogData = Blog::findOrFail($id);
		 
		if(session('userType') == 'Admin'){
			$routePrefix = 'admin.';
		}else{
			$routePrefix = '';
		}
		 
		$vars = [
			'page_title' => 'Edit Blog',
			'routePrefix' => $routePrefix,
			'blogData' => $blogData,
		];

		return view('users.common.blog-edit', $vars);
	}

	/**
	* Update general details of the blog.
	*
	* @param  \App\Http\Requests\Common\BlogRequest $r
	* @param int $id
	* @return array
	*/
	public function updateGeneral(BlogRequest $r, int $id)
	{
		try {

				$blogData = Blog::findOrFail($id);
			// if(session('userType') == 'Admin')
			
			$oldValues2 = $newValues2 = [];
			$oldValues1 = $blogData->toArray();
			$newValues1 = $r->all();
			if($oldValues1['tag'] !== $newValues1['tag']) {
				$newValues1['tag'] = fromTagifyToDb($newValues1['tag']);	
			}

			diffRecord(
				[ 'name', 'short_description', 'long_description', 'tag', 'status' ],
				'u', $oldValues1, $newValues1, $oldValues2, $newValues2
			);

			if(count($newValues2)) {
				if(isset($newValues2['name'])) {
					$newValues2['blog_name'] = $newValues2['name'];
					unset($newValues2['name']);
				}
				
				if(isset($newValues2['short_description'])){
					$newValues2['short_description'] = '';
				}
				if(isset($newValues2['long_description'])){
					$newValues2['long_description'] = '';
				}

				$updateDT = mysqlDT();
				
				$newValues1 += [
					'updated_at' => $updateDT,
					'updated_by' => auth()->id(),
					'updated_by_user_type' => session('userType'),
				];

				$blogData->fill($newValues1)->save();
			}

			return response()->json([]);
		}
		catch(\Exception $ex) {
			logMsg($ex);
			return sendJsonErrMsg("Unable to update the blog information.");
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
			$qry = DB::table('blogs')->where('id', $id);
			
			DB::table('comments')->where('blog_id', $id)->delete();

			$qry = $qry->update([
				'deleted_at' => mysqlDT(),
				'deleted_by' => auth()->id(),
				'deleted_by_user_type' => session('userType'),
			]);
			
			return response()->json([]);
		}
		catch(\Exception $ex) {
			logMsg($ex);
			return sendJsonErrMsg("Unable to delete blog.");
		}
	}

}
