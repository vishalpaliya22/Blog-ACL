@php
	$routePrefix = session('userType') == 'Admin' ? 'admin.' : '';
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}" />
<title>{{ $page_title }} | {{ config('app.name') }}</title>
<link href="{{ asset('images/favicon.png') }}" rel="icon">

@if(App::environment('local'))
<link href="{{ asset('plugins/bootstrap-5.1.1/css/bootstrap.min.css') }}" rel="stylesheet">
@else
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet">
@endif
<link href="{{ asset('plugins/font-awesome-5.15.4/css/all.min.css') }}" rel="stylesheet">

@yield('css-libraries')

<x-style-2-css />

<link href="{{ asset('css/style.css') }}?v=9" rel="stylesheet">

@yield('css-custom')

	<script>
var rootPath = "{{ asset('') }}";

function noPhoto(elImg) {
	elImg.onerror = null;
	elImg.src = (typeof rootPath == 'undefined' ? '/' : rootPath) + 'images/no-photo.png';
}
	</script>
</head>
<body>
<header class="header-section {{ request('modal') ? 'd-none' : '' }}">
	<div class="container">
		<div class="row align-items-center">
			<div class="text-start logo-wrp order-1">
				<a href="{{ route(prefixedRouteName('dashboard')) }}">
					<img id="mainLogo" src="{{ asset('images/logo.png') }}">
				</a>
			</div>

			<div class="text-end d-flex justify-content-start login-wrp order-2 order-lg-3">
				<div class="branch-menu-wrp">
					<div class="dropdown">
						<a class="dropdown-toggle" href="#" role="button" id="dropdownMenuBranch" data-bs-toggle="dropdown" aria-expanded="false">
							<span class="branch-img">
								<img src="{{ asset('images/dixies_logo.png') }}" alt="Menu">
							</span>
						</a>

						<ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuBranch">
							@if(session('userType') !== 'Admin')
								@if(Session::get('roleNames'))
									@if(Session::get('roleNames')->contains("name", "Admin"))
									<li><a class="dropdown-item" href="{{ route($routePrefix . 'blog-operator.blog.index') }}"><i class="fab fa-fw fa-dropbox"></i> Blog Post</a></li>
									<li><a class="dropdown-item" href="{{ route($routePrefix . 'blog-operator.staff.index') }}"><i class="fas fa-fw fa-user"></i> Blog Operator Users (Staff)</a></li>
									<li><a class="dropdown-item" href="{{ route($routePrefix . 'blog-operator.tag.index') }}"><i class="fas fa-fw fa-bus"></i> Tags</a></li>
										
									@elseif(Session::get('roleNames')->contains("name", "Writer"))
										<li><a class="dropdown-item" href="{{ route($routePrefix . 'blog-operator.blog.index') }}"><i class="fab fa-fw fa-dropbox"></i> Blog Post</a></li>

									@elseif(Session::get('roleNames')->contains("name", "Reader"))
										
										 
										<li><a class="dropdown-item" href="{{ route($routePrefix . 'blog-operator.blog.index') }}"><i class="fab fa-fw fa-dropbox"></i> Blog Post</a></li>
										
									@endif
								@endif
							@else
								
								 
								<li><a class="dropdown-item" href="{{ route($routePrefix . 'blog-operator.blog.index') }}"><i class="fab fa-fw fa-dropbox"></i> Blog Post</a></li> 
								
								<li><a class="dropdown-item" href="{{ route($routePrefix . 'blog-operator.staff.index') }}"><i class="fas fa-fw fa-user"></i> BLog Operator Users (Staff) </a></li>

							@endif

							@if(session('userType') == 'Admin')
								<li><a class="dropdown-item" href="{{ route('admin.admin-user.index') }}"><i class="fas fa-fw fa-user-secret"></i> Admin Users</a></li>
								<li><a class="dropdown-item" href="{{ route('admin.role.index') }}"><i class="fas fa-fw fa-user-shield"></i> Roles</a></li>
								<li><a class="dropdown-item" href="{{ route($routePrefix . 'blog-operator.tag.index') }}"><i class="fas fa-fw fa-bus"></i> Tags</a></li>
							@endif

						</ul>
					</div>
				</div>

				<div class="myprofile-menu-wrp">
					<div class="dropdown">
						<a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
							<span class="profile-img">
								<span class="profile-img-text">@if(Auth::user()){{ strtoupper(substr(auth()->user()->name, 0, 1)) }} @endif</span>
							</span>

							<span class="name-text">@if(Auth::user()){{ auth()->user()->name }}@endif</span>
						</a>

						<ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuLink">
							{{--<li><a class="dropdown-item" href="#">My Profile</a></li>--}}
							<li><a class="dropdown-item" href="{{ route(prefixedRouteName('logout')) }}" onclick="event.preventDefault();$('#logout-form').submit()">Sign Out</a></li>
						</ul>

						<form method="post" action="{{ route(prefixedRouteName('logout')) }}"id="logout-form" class="d-none">
							@csrf
						</form>
					</div>
				</div>
			</div>

			<div class="navbar-wrp order-3 order-lg-2">
				<nav class="navbar navbar-expand-lg navbar-light justify-content-end justify-content-lg-start">
					<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
						<span class="navbar-toggler-icon"></span>
					</button>

					<div class="collapse navbar-collapse" id="navbarNavAltMarkup">
						<div class="navbar-nav">
							@if(session('userType') !== 'Admin')
								@if(Session::get('roleNames'))
									@if(Session::get('roleNames')->contains("id", "1"))
										<a aria-current="page" href="{{ route(prefixedRouteName('dashboard')) }}"  class="nav-link {{ Request::routeIs(prefixedRouteName('dashboard')) ? 'active' : '' }}"><img class="icon-img" src="{{ asset('images/1.png') }}">Dashboard</a>
									@elseif(Session::get('roleNames')->contains("id", "2"))
										<a  aria-current="page" href="{{ route(prefixedRouteName('dashboard')) }}" class="nav-link {{ Request::routeIs(prefixedRouteName('dashboard')) ? 'active' : '' }}"><img class="icon-img" src="{{ asset('images/1.png') }}">Dashboard</a>
									@elseif(Session::get('roleNames')->contains("id", "3"))
										<a  aria-current="page" href="{{ route(prefixedRouteName('dashboard')) }}" class="nav-link {{ Request::routeIs(prefixedRouteName('dashboard')) ? 'active' : '' }}"><img class="icon-img" src="{{ asset('images/1.png') }}">Dashboard</a>
									@endif
								@endif
							@else
								<a  aria-current="page" href="{{ route(prefixedRouteName('dashboard')) }}" class="nav-link {{ Request::routeIs(prefixedRouteName('dashboard')) ? 'active' : '' }}"><img class="icon-img" src="{{ asset('images/1.png') }}">Dashboard</a>
							@endif
 							{{--
							<a class="nav-link" href="#"><img class="icon-img" src="{{ asset('images/5.png') }}">Settings</a>
 							--}}
						</div>
					</div>
				</nav>
			</div>
		</div>
	</div>
</header>

<div class="container py-3">
@yield('main-content')
</div>

<div class="loading-container" id="loading-container">
	<img class='loading-img' src="{{ asset('images/loading.gif') }}">
</div>

@if(App::environment('local'))
<script src="{{ asset('plugins/jquery-3.5.1.min.js') }}"></script>
<script src="{{ asset('plugins/bootstrap-5.1.1/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('plugins/sweetalert-2.1.2.min.js') }}"></script>
@else
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/sweetalert@2.1.2/dist/sweetalert.min.js"></script>
@endif

@yield('js-libraries')

<x-custom-js />

@yield('js-custom')
</body>
</html>
