<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="google-site-verification" content="Mh5XbOYqjxpvzLMc-VEuY2gstDIjS4_7yReDuyT0ob4" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}" />

<title>{{ $page_title }} | {{ config('app.name') }}</title>
<link href="{{ asset('images/favicon.png') }}" rel="icon">

<link href="{{ asset('plugins/font-awesome-5.15.4/css/all.min.css') }}" rel="stylesheet">

@if(App::environment('local'))
<link href="{{ asset('plugins/bootstrap-5.1.1/css/bootstrap.min.css') }}" rel="stylesheet">
@else
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet">
@endif

@yield('css-libraries')

<x-style-2-css />

<link href="{{ asset('css/style.css') }}?v=9" rel="stylesheet">

@yield('css-custom')

</head>
<body>
<section class="login-sec">
	<div class="container">
		<div class="row">
			<div class="col-12">
				@yield('main-content')
			</div>
		</div>
	</div>
</section>

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
