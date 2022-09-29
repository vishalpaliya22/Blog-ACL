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

@section('main-content')
<div class="page-content">
	<div class="content-title">
		<h2><i class="fas fa-bus title-icon"></i> Edit Tag</h2>
	</div>

	<div class="sub-nav">
		<a href="{{ route($routePrefix . 'blog-operator.tag.create') }}"><i class="fas fa-plus sub-nav-icon"></i> Add New</a>
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
 
		<div class="card">
			<nav class="nav nav-tabs" id="nav-tab" role="tablist">
				<button type="button" class="nav-item nav-link active" id="nav-general" data-bs-toggle="tab" data-bs-target="#tab-general" role="tab" aria-controls="tab-general" aria-selected="true">General</button>
			</nav>

			<div class="tab-content">
				<div class="tab-pane active" id="tab-general" role="tabpanel" aria-labelledby="tab-general">
					<div class="card-body">
						<form method="post" action="{{ route($routePrefix . 'blog-operator.tag.update-general', [ 'id' => $Tag->id ]) }}" onsubmit="if(!validateForm())return false;return submitForm(this)" data-on-success-msg="Tag updated.">
							@csrf
						
							<div class="mb-3">
								<label for="name" class="form-label">Name <req>*</req></label>
								<input class="form-control" name="name" id="name" maxlength="100" value="{{ old('name') ?? $Tag->name }}" placeholder="Enter admin name" data-allowed-characters="A-Z a-z space ' - ( ) , ." onblur="validateCharacters('#name')" required>
							</div>

							<div class="mb-3">
								<label for="description" class="form-label">Description</label>
								<textarea class="form-control" name="description" id="description" placeholder="Enter description">{{ old('description') ?? $Tag->description }}</textarea>
							</div>

							<div class="mt-3 text-end">
								<a href="{{ route($routePrefix . 'blog-operator.tag.index') }}" class="btn btn-danger"></i> Back</a>
								<button class="btn btn-main">Update</button>
							</div>
						</form>
					</div> {{-- /.card-body - general --}}
				</div> {{-- /#tab-general.tab-pane --}}

			</div> {{-- /.tab-content --}}
		</div> {{-- /.card - general --}}
	</div> {{-- /.main-content --}}
</div> {{-- /.page-content --}}
@endsection

@section('js-custom')
<script src="{{ asset('js/admin/tag-add-edit.js') }}"?v=4></script>
@endsection
