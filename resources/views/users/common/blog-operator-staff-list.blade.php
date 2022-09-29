@extends('layouts.default-2')

@php
	$uTypeAdmin = session('userType') == 'Admin';
@endphp

@section('main-content')
<div class="page-content">
	<div class="content-title">
		<h2><i class="fas fa-user title-icon"></i> Staff Users</h2>
	</div>

	<div class="sub-nav">
		<a href="{{ route(prefixedRouteName('blog-operator.staff.create')) }}"><i class="fas fa-plus sub-nav-icon"></i> Add New</a>
		<span class="sub-nav-sep">|</span>
		<a href="{{ route(prefixedRouteName('blog-operator.staff.index')) }}" class="active"><i class="fas fa-bars sub-nav-icon"></i> View List</a>
	</div>

	<div class="main-content">
	@if($errors->any())
		@include('layouts._errors')
	@endif

	@if(session('message'))
		@include('layouts._message')
	@endif

	
	
		<table class="table table-bordered table-hover" id="datatable">
			<thead>
				<tr>
					<th>{{ $uTypeAdmin ? 'Staff ' : '' }}First Name</th>
					<th>{{ $uTypeAdmin ? 'Staff ' : '' }}Last Name</th>
					<th>Email Address</th>
					<th>Phone Number</th>
					<th>Status</th>
					<th style="width: 180px !important;">Action</th>
				</tr>
			</thead>
			
			<tbody></tbody>
		</table>
	</div> {{-- /.main-content --}}
</div> {{-- /.page-content --}}
@endsection

@section('css-libraries')
	@if(App::environment('local'))
<link href="{{ asset('plugins/datatables-1.11.3/dataTables.bootstrap5.min.css') }}" rel="stylesheet">
	@else
<link href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap5.min.css" rel="stylesheet">
	@endif
@endsection

@section('js-libraries')
	@if(App::environment('local'))
<script src="{{ asset('plugins/datatables-1.11.3/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-1.11.3/dataTables.bootstrap5.min.js') }}"></script>
	@else
<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap5.min.js"></script>
	@endif
@endsection

@section('js-custom')
<script>


$(document).ready(function() {
	dtbl = $('#datatable').DataTable({
		processing: true,
		serverSide: true,
		responsive: true,
		ajax: {
			method: 'POST',
			url: "{{ route(prefixedRouteName('blog-operator.staff.index-ahr')) }}",
		},
		order: [ {!! $uTypeAdmin ? "[1, 'asc'], [2, 'asc']" : "[0, 'asc'], [1, 'asc']" !!} ],
		columns: [
			{
				data: 'first_name',
				name: 'tos.first_name',
				className: 'fw-bold'
			},
			{
				data: 'last_name',
				name: 'tos.last_name',
				className: 'fw-bold'
			},
			{
				data: 'email',
				name: 'tos.email'
			},
			{
				data: 'phone_number',
				name: 'tos.phone_number'
			},
			{
				data: 'status',
				name: 'tos.status',
				className: 'text-center'
			},
			{
				data: 'action',
				className: 'text-center',
				orderable: false,
				searchable: false
			},
		]
	});
});	
</script>

<x-delete-record-js-file />
@endsection
