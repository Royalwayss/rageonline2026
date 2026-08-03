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
					<li class="active">Cancellation Policy</li>
				</ol>
			</div> -->
			<div class="col-lg-12 policy-padding privacy-policy-content" >
				<h3 class="">CANCELLATION POLICY</h3>
				<hr>
				<p>You can cancel order only before we have processed your order. You can do so by contacting to our customer care at 7986158756. If the order is already processed for shipping then we won’t be able to cancel it. You cannot modify the size, color or shipping address of your order once the order has been placed. Discount vouchers or coupons that are intended for one-time use only and shall be treated as used even after you cancel the order.</p>
				<p>In the event of a cancellation, your payment (if prepaid order) will be returned to your account within 4-7 working days.</p>
			</div>
		</div>
	</div>
</main>
@stop