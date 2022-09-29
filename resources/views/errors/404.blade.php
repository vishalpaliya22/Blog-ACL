@extends('layouts.default')

@section('content')
<section>
	<div class="container">
		<div class="row">
			<div class="col-12 text-center">
				<h1>404</h1>
				<h2>{{ isset($error) ? $error : 'Page Not Found' }}</h2>
				
				<p class="mt-5">
					<a class="btn btn-outline-primary mr-5" href="{{ url()->previous() }}">Back to Home</a>
					<button type="button" class="btn btn-outline-primary" onclick="history.back()">Back to Previous Page</a>
				</p>
			</div>
		</div>
	</div>
</section>
@endsection
