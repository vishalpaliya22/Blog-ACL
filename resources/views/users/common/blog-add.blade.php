@extends('layouts.default-2')

@php
	if(session('userType') == 'Admin') {
		$routePrefix = 'admin.';
		$uTypeAdmin = true;
	} else {
		$routePrefix = '';
		$uTypeAdmin = false;
	}
@endphp
 
@section('main-content')
<div class="page-content">
	<div class="content-title">
		<h2><i class="fab fa-dropbox title-icon"></i> Add Blog</h2>
	</div>

	<div class="sub-nav">
		<a href="{{ route($routePrefix . 'blog-operator.blog.create') }}" class="active"><i class="fas fa-plus sub-nav-icon"></i> Add New</a>
		<span class="sub-nav-sep">|</span>
		<a href="{{ route($routePrefix . 'blog-operator.blog.index') }}"><i class="fas fa-bars sub-nav-icon"></i> View List</a>
	</div>

	<div class="main-content">
		@if($errors->any())
			@include('layouts._errors')
		@endif

		@if(session('message'))
			@include('layouts._message')
		@endif

		<form method="post" action="{{ route($routePrefix . 'blog-operator.blog.store') }}" enctype="multipart/form-data" onsubmit="return validateAddPckgForm()">
			@csrf
		
			<div class=" mb-3">
				<label for="name" class="form-label">Title <req>*</req></label>
				<input class="form-control" name="name" id="name" maxlength="100" value="{{ old('name') }}" placeholder="Enter blog title"  onblur="validateCharacters('#name')" required>
			</div>
		
			<div class="mb-3">
				<label for="short_description" class="form-label">Short Description</label>
				<textarea class="form-control" name="short_description" id="short_description" placeholder="Enter short description of the blog">{{ old('short_description') }}</textarea>
			</div>

			<div class="mb-3">
				<label for="long_description" class="form-label">Long Description</label>
				<textarea class="form-control" name="long_description" id="long_description" placeholder="Enter full description">{{ old('long_description') }}</textarea>
			</div>

			 

			<div class="mb-3">
				<label for="tag" class="form-label">Tag</label> <small>(Press Enter key after writing each tag)</small>
				<textarea class="form-control" name="tag" id="tag">{{ old('tag') }}</textarea>
			</div>

			<div class="mb-3">
				<label for="status" class="form-label">Status</label>
				<select class="form-select" name="status" id="status">
					<option {{ old('status') == 'Active' ? 'selected' : '' }}>Active</option>
					<option {{ old('status') == 'Inactive' ? 'selected' : '' }}>Inactive</option>
				</select>
			</div>

			<div class="mt-4 text-end"><button class="btn btn-main">Add</button></div>
		</form>
	</div> {{-- /.main-content --}}
</div> {{-- /.page-content --}}
@endsection

@section('css-libraries')
	@if(App::environment('local'))
<link href="{{ asset('plugins/tagify-4.8.1/tagify.css') }}" rel="stylesheet">
<!-- Summernote -->
<link rel="stylesheet" href="{{ asset('vendor/plugins/summernote/summernote-bs4.min.css') }}">
	@else
<link href="https://unpkg.com/@yaireo/tagify@4.8.1/dist/tagify.css" rel="stylesheet">
	@endif
@endsection

@section('js-libraries')
	@if(App::environment('local'))
<script src="{{ asset('plugins/tagify-4.8.1/tagify.min.js') }}"></script>
<!-- Summernote -->
<script src="{{ asset('vendor/plugins/summernote/summernote-bs4.min.js') }}"></script>
	@else
<script src="https://unpkg.com/@yaireo/tagify@4.8.1/dist/tagify.min.js"></script>
	@endif
@endsection

@section('css-custom')
<style>
.pckg-rate-grp tr:last-child td { padding-bottom: 10px; }
</style>
@endsection

@section('js-custom')
<script>
var action = 'Add';
</script>

@if(session('userType') == 'Admin')
<x-admin-js />
@endif

<script src="{{ asset('js/user-common/blog-add-edit.js') }}?v=7"></script>
@endsection
