@extends('layouts.default-2')

@if(Session::get('roleNames')->contains("name", "Admin"))
    @section('main-content')
    <h2 class="text-center">{{$roleNames[0]->name}} Dashboard</h2>
    @endsection
@elseif(Session::get('roleNames')->contains("name", "Writer"))
    @section('main-content')
    <h2 class="text-center">{{$roleNames[0]->name}} Dashboard</h2>
    @endsection
@elseif(Session::get('roleNames')->contains("name", "Reader"))
    @section('main-content')
    <h2 class="text-center">{{$roleNames[0]->name}} Dashboard</h2>
    @endsection
@else
	@section('main-content')
    <h2 class="text-center">Dashboard</h2>
    @endsection  
@endif    
