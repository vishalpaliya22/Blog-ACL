@extends('layouts.auth')

@section('main-content')
<div class="login-main-wrp">
	<div class="row align-items-center">
		<div class="col-12 col-md-6 col-lg-7 order-1 order-md-2">
			<div class="login-img-wrp">
				{{--<img src="{{ asset('images/login-page/cover.jpg') }}" alt="">--}}
				<img src="{{ asset('images/login-page/login-image.png') }}" alt="">
			</div>
		</div>

		<div class="col-12 col-md-6 col-lg-5 order-2 order-md-1">
			<div class="login-form-wrp">
				<div class="login-form-logo text-center">
					<!-- <img src="{{ asset('images/logo.png') }}" alt=""> -->
				</div>
				<div class="login-form-title text-center">Welcome to {{ env('APP_NAME') }}</div>
				<div class="login-form-notes text-center">Please log in to continue.</div>
				<div class="login-form-name text-center">
					<div class="login-form-name-inner"><img src="{{ asset('images/login-page/login-icon.png') }}" alt=""> Login</div>
				</div>

				<div class="login-form form-wrp">
	@if($errors->any())
		@include('layouts._errors')
	@endif

					<form id="loginform" method="POST" action="{{ route($formSubmitRoute) }}" onsubmit="return validateEmailAddressFormat()">
						@csrf

						<div class="row">
							<div class="mb-3 col-12">
								<div class="field-wrap">
									<div class="form-label">
										<label for="email"><b>Email Address <span class="required-star">*</span></b></label>
									</div>
									<div class="form-element">
										<input type="email" name="email" id="email" placeholder="Enter your email address" value="{{ old('email') }}" required>
									</div>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="mb-3 col-12">
								<div class="field-wrap">
									<div class="form-label">
										<label for="password"><b>Password <span class="required-star">*</span></b></label>
									</div>
									<div class="form-element">
										<input type="password" name="password" id="password" placeholder="Enter your password" required>
									</div>
								</div>
							</div>
						</div>

						<div class="row align-items-center">
							<div class="col-6">
								<div class="mb-4 checkbox-wrap">
									<label for="remember" class="checked-item mb-0"><b>Remember me</b>
										<input name="remember" id="remember" type="checkbox" value="1" @if(old('remember')) checked @endif >
										<span class="checkmark ms-0"></span>
									</label>
								</div>
							</div>

							{{--<div class="col-6">
								<div class="mb-4 forgotten-password text-end">
									<a href="{{ route($forgotPasswordRoute) }}">Forgot Password?</a>
								</div>
							</div>--}}
						</div>

						<div class="row">
							<div class="mb-3 button-wrap col-md-12">
								<div class="field-wrap">
									<button type="submit" class="btn btn-main btn-main-sm conpagesubmit btn-search">Log In</button>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
