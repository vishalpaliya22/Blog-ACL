@extends('layouts.default-2')
@php
	if(session('userType') == 'Admin') {
		$routePrefix = 'admin.';
	} else {
		$routePrefix = '';
	}
@endphp
@section('main-content')
<div class="page-content">
	<div class="content-title">
		<h2><i class="fas fa-bus title-icon"></i> Add Tag</h2>
	</div>

	<div class="sub-nav">
		<a href="{{ route($routePrefix . 'blog-operator.tag.create') }}" class="active"><i class="fas fa-plus sub-nav-icon"></i> Add New</a>
		<span class="sub-nav-sep">|</span>
		<a href="{{ route($routePrefix . 'blog-operator.tag.index') }}"><i class="fas fa-bars sub-nav-icon"></i> View List</a>
	</div>

	<div class="main-content">
	@if($errors->any())
		@include('layouts._errors')
	@endif

	@if(session('message'))
		@include('layouts._message')
	@endif

		<form method="post" action="{{ route($routePrefix . 'blog-operator.tag.store') }}" enctype="multipart/form-data" onsubmit="return validateForm()">
			@csrf

			<div class="mb-3">
				<label for="name" class="form-label">Name <req>*</req></label>
				<input class="form-control" name="name" id="name" maxlength="100" value="{{ old('name') }}" placeholder="Enter name" data-allowed-characters="space 'A-Z a-z - ( ) , ." onblur="validateCharacters('#name')" required>
			</div>

			<div class="mb-3">
				<label for="description" class="form-label">Description</label>
				<textarea class="form-control" name="description" id="description" placeholder="Enter description">{{ old('description') }}</textarea>
			</div>

			<div class="mt-4 text-end"><button class="btn btn-main">Add</button></div>
		</form>
	</div> {{-- /.main-content --}}
</div> {{-- /.page-content --}}
@endsection

@section('js-custom')
<script src="{{ asset('js/admin/tag-add-edit.js') }}?v=4"></script>
@endsection
