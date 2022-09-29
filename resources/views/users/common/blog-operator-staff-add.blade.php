@extends('layouts.default-2')

@php
	if(session('userType') == 'Admin') {
		$routePrefix = 'admin.';
		$msgOnSuccess = 'Blog operator staff user added';
		$uTypeAdmin = true;
	} else {
		$routePrefix = '';
		$msgOnSuccess = 'Staff user added';
		$uTypeAdmin = false;
	}
@endphp

@section('main-content')
<div class="page-content">
	<div class="content-title">
		<h2><i class="fas fa-user title-icon"></i> Add @if($uTypeAdmin) Blog Operator @endif Staff User</h2>
	</div>
	
	<div class="sub-nav">
		<a href="{{ route($routePrefix . 'blog-operator.staff.create') }}" class="active"><i class="fas fa-plus sub-nav-icon"></i> Add New</a>
		<span class="sub-nav-sep">|</span>
		<a href="{{ route($routePrefix . 'blog-operator.staff.index') }}"><i class="fas fa-bars sub-nav-icon"></i> View List</a>
	</div>

	<div class="main-content">
		<form method="post" action="{{ route($routePrefix . 'blog-operator.staff.store') }}" onsubmit="return validateAndSubmitForm(this)" data-redirect-on-success="{{ route($routePrefix . 'blog-operator.staff.index') }}" data-on-success-msg="{{ $msgOnSuccess }}">
			@csrf

			<div class="row">
	
				<div class="col-12 col-md-6 mb-3">
					<div class="row">
						<div class="col">
							<label for="first_name" class="form-label">First Name</label>
							<input class="form-control" name="first_name" id="first_name" maxlength="50" placeholder="Enter first name" onblur="validateCharacters('#first_name')" required>
						</div>
						<div class="col">
							<label for="last_name" class="form-label">Last Name</label>
							<input class="form-control" name="last_name" id="last_name" maxlength="50" placeholder="Enter last name" onblur="validateCharacters('#last_name')">
						</div>
					</div>
				</div>

				<div class="col-12 col-md-6 mb-3">
					<label for="email" class="form-label">Email Address <req>*</req></label>
					<input type="email" class="form-control" name="email" id="email" maxlength="50" placeholder="Enter email address" required>
				</div>

				<div class="col-12 col-md-6 mb-3">
					<label for="password" class="form-label">Password <req>*</req></label>
					<div class="input-group">
						<input type="password" class="form-control" name="password" id="password" placeholder="Enter password"> 
						<div class="input-group-text" style="padding:0.15rem">
							<button type="button" data-toggle="#password" class="btn btn-sm toggle-password"><i class="fa fa-fw fa-eye"></i></button>
						</div>
					</div>
				</div>

				<div class="col-12 col-md-6 mb-3">
					<label for="phone_number" class="form-label">Phone Number</label>
					<input type="tel" class="form-control" name="phone_number" id="phone_number" maxlength="30" placeholder="Enter phone number" data-allowed-characters="0-9 space - ( ) +" onblur="validateCharacters('#phone_number')">
				</div>

				<div class="col-12 col-md-6 mb-3">
					<label class="form-label">Roles <req>*</req></label>
					<div class="form-select multi-selection-container" tabindex="0">
						<div class="multi-sel-placeholder"><span class="default-placeholder">Select Role(s)</span></div>

						<div class="multi-sel-checkboxes">
					@foreach($roles as $role)
							<label>
								<input type="checkbox" name="role[]" id="role-{{ $role->id }}" value="{{ $role->id }}">
								{{ $role->name }}
							</label>
					@endforeach
						</div>
					</div>
				</div>
	
				<div class="col-12 col-md-6 mb-3">
					<label for="status" class="form-label">Status</label>
					<select class="form-select" name="status" id="status">
						<option>Active</option>
						<option>Inactive</option>
					</select>
				</div>
			</div>

			<div class="mt-4 text-end"><button class="btn btn-main">Add</button></div>
		</form>
	</div> {{-- /.main-content --}}
</div> {{-- /.page-content --}}
@endsection

@section('css-libraries')
<link href="{{ asset('plugins/multi-selection-checkbox-dropdown/multi-selection-checkbox-dropdown.css') }}?v=3" rel="stylesheet">
@endsection

@section('js-libraries')
<script src="{{ asset('plugins/multi-selection-checkbox-dropdown/multi-selection-checkbox-dropdown.js') }}?v=3"></script>
@endsection

@section('js-custom')
	@if(session('userType') == 'Admin')
<x-admin-js />
	@endif

<script src="{{ asset('js/user-common/blog-operator-staff-add-edit.js') }}"></script>
@endsection
