@extends('layouts.default-2')

@php
	$uTypeAdmin = session('userType') == 'Admin';
@endphp

@section('main-content')
<div class="page-content">
	<div class="content-title">
		<h2><i class="fab fa-dropbox title-icon"></i> Blogs</h2>
	</div>

	<div class="sub-nav">
		@if($uTypeAdmin)
			<a href="{{ route(prefixedRouteName('blog-operator.blog.create')) }}"><i class="fas fa-plus sub-nav-icon"></i> Add New</a>
			<span class="sub-nav-sep">|</span>
			<a href="{{ route(prefixedRouteName('blog-operator.blog.index')) }}" class="active"><i class="fas fa-bars sub-nav-icon"></i> View List</a>
		@else
			@if(Session::get('roleNames'))
			
				@if(Session::get('roleNames')->contains("name", "Writer"))
					 
					<a href="{{ route(prefixedRouteName('blog-operator.blog.create')) }}"><i class="fas fa-plus sub-nav-icon"></i> Add New</a>
					<span class="sub-nav-sep">|</span>
					<a href="{{ route(prefixedRouteName('blog-operator.blog.index')) }}" class="active"><i class="fas fa-bars sub-nav-icon"></i> View List</a>
					
				@elseif(Session::get('roleNames')->contains("name", "Reader"))
					<a href="{{ route(prefixedRouteName('blog-operator.blog.index')) }}" class="active"><i class="fas fa-bars sub-nav-icon"></i> View List</a>
				@endif
			@endif
		@endif
	</div>

	<div class="main-content">
	@if($errors->any())
		@include('layouts._errors')
	@endif

	@if(session('message'))
		@include('layouts._message')
	@endif

	<div class="row" style="margin-bottom:20px;">
	
	</div>
		<table class="table table-bordered table-hover" id="datatable">
			<thead>
				<tr>
					<th>Title</th>
					<th>Status</th>
					<th style="width: 320px !important;">Action</th>
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
			url: "{{ route(prefixedRouteName('blog-operator.blog.index-ahr')) }}",
		},
		order: [ [ 0, 'asc' ], [ 1, 'asc' ] ],
		columns: [
			{
				data: 'name',
				name: 'name',
				className: 'fw-bold'
			},
			{
				data: 'status',
				name: 'status',
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
