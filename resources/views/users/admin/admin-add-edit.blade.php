@extends('layouts.default-2')

@section('main-content')
	@php
		if(Route::currentRouteName() == 'admin.admin-user.create')
			$action = 'Add';
		else // if(Route::currentRouteName() == 'admin.admin-user.edit')
			$action = 'Update';
	@endphp

<div class="page-content">
	<div class="content-title">
		<h2><i class="fas fa-user-secret title-icon"></i> {{ $action }} Administrator</h2>
	</div>

	<div class="sub-nav">
		<a href="{{ route('admin.admin-user.create') }}" {!! $action == 'Add' ? 'class="active"' : '' !!}><i class="fas fa-plus sub-nav-icon"></i> Add New</a>
		<span class="sub-nav-sep">|</span>
		<a href="{{ route('admin.admin-user.index') }}"><i class="fas fa-bars sub-nav-icon"></i> View List</a>
	</div>

	<div class="main-content">
		<form class="form" method="post" action="{{ $formSubmitRoute }}" onsubmit="return validateAndSubmitForm(this)" data-redirect-on-success="{{ route('admin.admin-user.index') }}" data-on-success-msg=
	@if($action == 'Add')
"Admin user added"
	@else {{-- edit-update --}}
"Admin user details updated"
	@endif >

	@if($action == 'Update')
		@method('PUT')
	@endif
		
			<div class="row">
				<div class="col-12 col-md-6 mb-3">
					<label for="name" class="form-label">Admin Name <req>*</req></label>
					<input class="form-control" name="name" id="name" maxlength="50" value="{{ $admin->name }}" placeholder="Enter admin name" onblur="validateCharacters('#name')" required>
				</div>

				<div class="col-12 col-md-6 mb-3">
					<label for="email" class="form-label">Email Address <req>*</req></label>
					<input type="email" class="form-control" name="email" id="email" maxlength="50" value="{{ $admin->email }}" placeholder="Enter email address" required>
				</div>

				<div class="col-12 col-md-6 mb-3">
					<label for="password" class="form-label">Password @if($action == 'Add') <req>*</req> @endif</label>
					
					<div class="input-group">
						<input type="password" class="form-control" name="password" id="password" placeholder="Enter password" @if($action == 'Add') required @endif> 
						<div class="input-group-text" style="padding:0.15rem">
							<button type="button" class="btn btn-sm toggle-password" data-toggle="#password"><i class="fa fa-fw fa-eye"></i></button>
						</div>
					</div>
				</div>
				
				<div class="col-12 col-md-6 mb-3">
					<label for="status" class="form-label">Status</label>
					<select class="form-select" name="status" id="status" @if($action == 'Update' && $id == auth(session('guard'))->id())  @endif>
						<option {{ $admin->status == 'Active' ? 'selected' : '' }}>Active</option>
						<option {{ $admin->status == 'Inactive' ? 'selected' : '' }}>Inactive</option>
					</select>
				</div>
			</div>
	
			<div class="mt-4 text-end"><button class="btn btn-main">{{ $action }}</button></div>
		</form>
	</div> {{-- /.main-content --}}
</div> {{-- /.page-content --}}
@endsection

@section('js-custom')
<script src="{{ asset('js/admin/admin-add-edit.js') }}"></script>
@endsection
