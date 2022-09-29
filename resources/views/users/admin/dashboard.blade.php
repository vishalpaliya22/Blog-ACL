@extends('layouts.default-2')
@php
$uTypeAdmin = session('userType') == 'Admin';
@endphp

@section('main-content')
<section>
  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-4">
        <h2 class="text-left" style="margin-bottom:10px">Dashboard</h2>
      </div>
       
    </div>
  </div>
</section>

@endsection

@section('css-libraries')
<link href="{{ asset('plugins/daterangepicker-3.1/daterangepicker.css') }}" rel="stylesheet">
@endsection

@section('css-custom')
<style>
  #bookingDetailsBody .af_warning{
    background-color: #ff03;
  }
</style>
<link href="{{ asset('css/user-common/dashboard.css') }}?v=2" rel="stylesheet">
@endsection

@section('js-libraries')
<script src="{{ asset('plugins/chart.js-2.9.4/Chart.min.js') }}"></script>
<script src="{{ asset('plugins/moment-2.29.1.min.js')}}"></script>
<script src="{{ asset('plugins/daterangepicker-3.1/daterangepicker.js')}}"></script>
@endsection

@section('js-custom')

<script> </script>
@endsection
