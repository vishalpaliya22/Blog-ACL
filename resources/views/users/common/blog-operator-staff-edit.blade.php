@extends('layouts.default-2')
@section('css-custom')
<style>
.btn.btn-danger { line-height: 36px;
    padding: 10px 30px;
    font-size: 18px;
    font-weight: 700;
    color: #fff;
    box-shadow: -1px -6px 5px 0 rgb(0 0 0 / 12%) inset, 0px -3px 5px 0 rgb(0 0 0 / 21%);
    border: none;
    border-radius: 4px;
    outline: none;
 }
</style>
@endsection
@php
	if(session('userType') == 'Admin') {
		$routePrefix = 'admin.';
		$generalMsgOnSuccess = "Blog operator staff user details updated";
		$uTypeAdmin = true;
	} else {
		$routePrefix = '';
		$generalMsgOnSuccess = "Staff user's general details updated";
		$uTypeAdmin = false;
	}
@endphp

@section('main-content')
<div class="page-content">
	<div class="content-title">
		<h2><i class="fas fa-user title-icon"></i> Update @if($uTypeAdmin) Blog Operator @endif Staff User</h2>
	</div>

	<div class="sub-nav">
		<a href="{{ route($routePrefix . 'blog-operator.staff.create') }}"><i class="fas fa-plus sub-nav-icon"></i> Add New</a>
		<span class="sub-nav-sep">|</span>
		<a href="{{ route($routePrefix . 'blog-operator.staff.index') }}"><i class="fas fa-bars sub-nav-icon"></i> View List</a>
	</div>

	<div class="main-content">
		<div class="card">
			<nav class="nav nav-tabs" id="nav-tab" role="tablist">
				<button type="button" class="nav-item nav-link active" id="nav-general" data-bs-toggle="tab" data-bs-target="#tab-general" role="tab" aria-controls="tab-general" aria-selected="true">General</button>
				<button type="button" class="nav-item nav-link" id="nav-roles" data-bs-toggle="tab" data-bs-target="#tab-roles" role="tab" aria-controls="tab-roles" aria-selected="true">Roles</button>
			</nav>

			<div class="tab-content">
				<div class="tab-pane active" id="tab-general" role="tabpanel" aria-labelledby="tab-general">
					<div class="card-body">
						<form class="form" method="post" action="{{ route($routePrefix . 'blog-operator.staff.update-general', [ 'id' => $staff->id ]) }}" onsubmit="return validateAndSubmitForm(this)" data-on-success-msg="{{ $generalMsgOnSuccess }}">
							@csrf
				
							<div class="row">
								<div class="col-12 col-md-6 mb-3">
									<div class="row">
										<div class="col">
											<label for="first_name" class="form-label">First Name</label>
											<input class="form-control" name="first_name" id="first_name" maxlength="50" placeholder="Enter first name" value="{{ $staff->first_name }}" onblur="validateCharacters('#first_name')" required>
										</div>
										<div class="col">
											<label for="last_name" class="form-label">Last Name</label>
											<input class="form-control" name="last_name" id="last_name" maxlength="50" placeholder="Enter last name" value="{{ $staff->last_name }}" onblur="validateCharacters('#last_name')">
										</div>
									</div>
								</div>

								<div class="col-12 col-md-6 mb-3">
									<label for="email" class="form-label">Email Address <req>*</req></label>
									<input type="email" class="form-control" name="email" id="email" maxlength="50" placeholder="Enter email address" value="{{ $staff->email }}" required>
								</div>

								<div class="col-12 col-md-6 mb-3">
									<label for="password" class="form-label">Password</label>
									<div class="input-group">
										<input type="password" class="form-control" name="password" id="password" placeholder="Enter password"> 
										<div class="input-group-text" style="padding:0.15rem">
											<button type="button" data-toggle="#password" class="btn btn-sm toggle-password"><i class="fa fa-fw fa-eye"></i></button>
										</div>
									</div>
								</div>

								<div class="col-12 col-md-6 mb-3">
									<label for="phone_number" class="form-label">Phone Number</label>
									<input type="tel" class="form-control" name="phone_number" id="phone_number" maxlength="30" placeholder="Enter phone number" value="{{ $staff->phone_number }}" data-allowed-characters="0-9 space - ( ) +" onblur="validateCharacters('#phone_number')">
								</div>

								<div class="col-12 col-md-6 mb-3">
									<label for="status" class="form-label">Status</label>
									<select class="form-select" name="status" id="status">
										<option>Active</option>
										<option>Inactive</option>
									</select>
								</div>
							</div>
				
							<div class="mt-4 text-end">
								<a href="{{ route('admin.tag.index') }}" class="btn btn-danger"></i> Back</a>
								<button class="btn btn-main">Update</button>
							</div>
						</form>
					</div>{{-- /.card-body --}}
				</div>{{-- /#tab-general.tab-pane --}}

				<div class="tab-pane" id="tab-roles" role="tabpanel" aria-labelledby="tab-roles">
					<div class="card-body">
						<div class="row div-chk-roles">
							@foreach($roles as $role)
							<label class="col-sm-12 col-md-4 col-lg-2">
								<input type="checkbox" value="{{ $role->id }}" onclick="updateRole(this, {{ $staff->id }})" {{ $role->tosr_id && !$role->deleted_by ? 'checked' : '' }}>
								<span>{{ $role->name }}</span>
							</label>
							@endforeach
						</div> {{-- /.row --}}
					</div> {{-- /.card-body --}}
				</div> {{-- /#tab-roles.tab-pane --}}
			</div> {{-- /.tag-content --}}
		</div>{{-- /.card --}}
	</div> {{-- /.main-content --}}
</div> {{-- /.page-content --}}
@endsection

@section('css-custom')
<style>
.div-chk-roles input[type=checkbox] { position: relative; top: 2px; margin-right: 6px; }
</style>
@endsection

@section('js-custom')
<script>
var updateRoleUrl = "{{ route($routePrefix . 'blog-operator.staff.update-role', [ 'id' => $staff->id ]) }}";
</script>

<script src="{{ asset('js/user-common/blog-operator-staff-add-edit.js') }}?v=1"></script>
@endsection
