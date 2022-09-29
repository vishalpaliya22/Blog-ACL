@extends('layouts.default-2')

@section('main-content')
<div class="page-content">
	<div class="content-title">
		<h2><i class="fas fa-bus title-icon"></i> List Tag</h2>
	</div>

	<div class="sub-nav">
		<a href="{{ route(prefixedRouteName('blog-operator.tag.create')) }}"><i class="fas fa-plus sub-nav-icon"></i> Add New</a>
		<span class="sub-nav-sep">|</span>
		<a href="{{ route(prefixedRouteName('blog-operator.tag.index')) }}" class="active"><i class="fas fa-bars sub-nav-icon"></i> View List</a>
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
					<th>Name</th>
					<th>Action</th>
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
var dtbl = null;

$(function() {
	dtbl = $('#datatable').DataTable({
		processing: true,
		serverSide: true,
		responsive: true,
		ajax: {
			method: 'POST',
			url: "{{ route(prefixedRouteName('blog-operator.tag.index-ahr')) }}"
		},
		order: [ [0, 'desc']/*, [2, 'asc'], [3, 'asc'], [0, 'asc'] */],
		columns: [
			{
				data: 'name',
				name: 't_o.name',
				className: 'fw-bold'
			},
			{
				data: 'action',
				className: 'text-center',
				orderable: false,
				searchable: false
			}
		]
	});
});
</script>

<x-delete-record-js-file />
@endsection
