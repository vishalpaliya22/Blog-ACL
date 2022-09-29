@extends('layouts.default-2')

@section('main-content')
	@php
		if(Route::currentRouteName() == 'admin.role.create')
			$action = 'Add';
		else // if(Route::currentRouteName() == 'admin.role.edit')
			$action = 'Update';
	@endphp

<div class="page-content">
	<div class="content-title">
		<h2><i class="fas fa-fw fa-user-shield title-icon"></i> {{ $action }} Role</h2>
	</div>

	<div class="sub-nav">
		<a href="{{ route('admin.role.create') }}" {!! $action == 'Add' ? 'class="active"' : '' !!}><i class="fas fa-plus sub-nav-icon"></i> Add New</a>
		<span class="sub-nav-sep">|</span>
		<a href="{{ route('admin.role.index') }}"><i class="fas fa-bars sub-nav-icon"></i> View List</a>
	</div>

	<div class="main-content">
		<form method="post" action="{{ $formSubmitRoute }}" onsubmit="if(!validateCharacters('#name'))return false;return submitForm(this)" data-redirect-on-success="{{ route('admin.role.index') }}" data-on-success-msg=
	@if($action == 'Add')
"Tour operator staff role added"
	@else {{-- update --}}
"Tour operator staff role updated"
	@endif >

	@if($action == 'Update')
		@method('PUT')
	@endif
		
			<div class="row">
				<div class="col-12 col-md-6 mb-3">
					<label for="name" class="form-label">Name <req>*</req></label>
					<input class="form-control" name="name" id="name" maxlength="30" value="{{ $role->name }}" placeholder="Enter role name" data-allowed-characters="A-Z a-z space - + ( ) , . : /" onblur="validateCharacters('#name')" required>
				</div>
			
				<div class="col-12 col-md-6 mb-3">
					<label for="display_order" class="form-label">Display Order <req>*</req></label>
					<input type="number" class="form-control" name="display_order" id="display_order" min="0" max="255" value="{{ $role->display_order }}" placeholder="Enter display order for the role" required>
				</div>
			
				<div class="col-12 col-md-6 mb-3">
					<label for="status" class="form-label">Status</label>
					<select class="form-select" name="status" id="status">
						<option {{ $role->status == 'Active' ? 'selected' : '' }}>Active</option>
						<option {{ $role->status == 'Inactive' ? 'selected' : '' }}>Inactive</option>
					</select>
				</div>
			</div>
		
			<div class="mt-3 text-end"><button class="btn btn-main">{{ $action }}</button></div>
		</form>
	</div> {{-- /.main-content --}}
</div> {{-- /.page-content --}}
@endsection
