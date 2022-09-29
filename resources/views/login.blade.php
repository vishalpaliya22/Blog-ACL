@extends('layouts.default')

@section('content')
<section>
	<div class="container">
		<div class="row">
			<div class="col-12 mb-3 text-center">
				<img src="{{ asset('images/logo.png') }}" alt="{{ env('APP_NAME') }}">
			</div>
		</div>
		
		<div class="row">
			<div class="col-12 text-center">
				<h3>{{ $page_title }}</h3>
			</div>
		</div>
	</div>
</section>

<section class="login-form">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<form method="POST" action="{{ route($formSubmitRoute) }}" onsubmit="return validateEmailAddressFormat()">
					@csrf

	@if($errors->any())
		@include('layouts._errors')
	@endif

	@if(isset($tourOperators))
					<div class="mb-3">
						<label for="tour_operator" class="form-label"><b>Tour Operator</b></label>
						<select id="tour_operator" name="tour_operator" class="form-select">
		@foreach($tourOperators as $to)
							<option value="{{ $to->id }}"{{ old('tour_operator') == $to->id ? ' selected' : '' }}>{{ $to->name }}</option>
		@endforeach
						</select>
					</div>
	@endif

					<div class="mb-3">
						<label for="email" class="form-label"><b>Email Address <req>*</req></b></label>
						<input type="text" id="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="Enter email address" required>
					</div>

					<div class="mb-3">
						<label for="password" class="form-label"><b>Password <req>*</req></b></label>
						<input type="password" id="password" name="password" class="form-control" placeholder="Enter password" required>
					</div>

					<div class="mb-3">
						<label class="form-label">
							<input type="checkbox" name="remember" value="1" @if(old('remember')) checked @endif >
							<span><b>Remember Log-in</b></span>
						</label>
					</div>

					<div class="text-center">
						<button type="submit" class="btn btn-main btn-main-sm">Log-In</button>
					</div>
				</form>

				<div class="mt-4 text-center">
					Forgot Password? <a href="{{ route($forgotPasswordRoute) }}">Click here</a> to reset.
				</div>
			</div> {{-- /.col --}}
		</div> {{-- /.row --}}
	</div> {{-- /.container --}}
</section>
@endsection
