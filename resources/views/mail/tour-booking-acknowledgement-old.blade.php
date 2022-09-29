@extends('mail.main')

@section('main-content')
<p>Thank you for booking a tour.</p>
<p>Following is the summary of the booking:</p>

<h5 style="margin-bottom:4px">Booking Id</h5>
<h4 style="margin-bottom:16px">{{ $arEmailData['bookingId'] }}</h4>

<h5 style="margin-bottom:4px">Tour Package</h5>
<h4 style="margin-bottom:16px">{{ $arEmailData['tourPackage'] }}</h4>

<h5 style="margin-bottom:4px">Tour Date and Time</h5>
<h4 style="margin-bottom:16px">{{ $arEmailData['tourDateTime'] }}</h4>

<h5 style="margin-bottom:4px">Total Cost</h5>
<h4 style="margin-bottom:16px">${{ sprintf('%.2f', $arEmailData['total']) }}</h4>

<h5 style="margin-bottom:4px">Amount Paid</h5>
<h4 style="margin-bottom:16px">${{ sprintf('%.2f', $arEmailData['paid']) }}</h4>

<p>&nbsp;</p>
<p>- <b>{{ $arEmailData['tourOperator'] }}</b></p>
@endsection
