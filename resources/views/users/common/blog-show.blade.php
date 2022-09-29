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
<section>
	<div class="container">
		<div class="row">
			<div class="col-12">
				<h2 class="text-center">{{ $blogData->name }}</h2>
				<hr>
				<div>
					<p>{{ $blogData->short_description }}</p>
					<p>{!! $blogData->long_description !!}</p>
				</div>
				<br/>
				<br/>
				<h4 class="text-left">All Comment</h4>
				<br/>

				@foreach($commentData as $comment)
					<div style="border: 1px solid #cccc;border-radius: 7px;padding: 10px 25px 10px 25px;">
						<p>{{$comment->desc}}</p><br>
						<p style="font-size: 12px;">created Date :- {{$comment->createdDate}}</p>
					</div><br>
				@endforeach
				<br/>
 
				<form method="post" action="{{ route($routePrefix . 'blog-operator.comment.commentAdd') }}" enctype="multipart/form-data">
					@csrf
				 	@if($errors->any())
						@include('layouts._errors')
					@endif

					@if(session('message'))
						@include('layouts._message')
					@endif
					<input type="hidden" name="blog_id" value="{{$blogData->id}}">
					<div class="mb-3">
						<label for="comment" class="form-label">Add Comment</label>
						<textarea class="form-control" name="comment" id="comment" placeholder="Enter comment of the blog">{{ old('comment') }}</textarea>
					</div>

					<div class="mt-4 text-end">
						<a href="{{ route($routePrefix . 'blog-operator.blog.index') }}" class="btn btn-danger"></i> Back</a>
						<button class="btn btn-main">Add</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</section>
 
@endsection