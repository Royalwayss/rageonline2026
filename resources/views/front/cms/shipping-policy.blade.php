@extends('layouts.frontLayout.front-layout')
@section('content')
<style>
.privacy-policy-content p{
	color: #333!important;
    font-size: 15px!important;
    font-family: inherit!important;
    font-weight: 400!important;
}
</style>
<main>
	<div class="container policy-divs">
		<div class="row">
			<!-- <div class="col-lg-12 mb-3">
				<ol class="breadcrumb p-0">
					<li><a href="{{ url('/') }}">Home&nbsp;/&nbsp;</a></li>
					<li class="active">Shipping Policy</li>
				</ol>
			</div> -->
			<div class="col-lg-12 policy-padding privacy-policy-content" >
				<h3 class="">SHIPPING POLICY</h3>
				<hr>
				<p>We dispatch your order through a reputed logistics partner (Depending upon your location).Normally, we ship your order within 24 to 48 hours of receiving the order and it takes 5 to 7 business days to reach your doorstep. (Delivery time may be exceeded depending upon your location).  If your order exceeds the average delivery time mentioned and you would like an update on its exact status, please contact us via email at <a href="mailto:rageindiaonline@gmail.com" style="color: #8e313c;">rageindiaonline@gmail.com</a></p>
				<p>We are delighted to inform you that there are no shipping charges for both the prepaid and cash on delivery (COD) orders. In case if we provide shipping and cod charges then please note that shipping and Cash on Delivery (COD) charges are Non-Refundable.</p>
				<p>We offer delivery services across India, except for a few pin codes where serviceability may not be possible</p>
				<p><b>If you haven’t received your order?</b></p>
				<p>Don’t worry. Just write to us at rageindiaonline@gmail.com with your order number and we'll update you about the exact status of your order.</p>
			</div>
		</div>
	</div>
</main>
@stop