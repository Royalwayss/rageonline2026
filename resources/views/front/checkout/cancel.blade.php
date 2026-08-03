@extends('layouts.frontLayout.front-layout')
@section('content')
<?php use App\GiftOffer; ?>

<main>
	<div class="container order-placed">
	  <div class="row">
	    <div class="main-content col-md-12 mt-3 mb-3">
	      <div class="page-main-content">
	       
			<div class="container mt-4">
			<div class="row">
				<div class="col-12 text-center pt-5 pb-5">
					<i class="fa fa-check-square-o fa-4x orange"></i>
					<h3 class="mt-4 mb-4">Order Cancelled</h3>
					<span class="order-number">Your Order #{{Session::get('orderid')}} has been cancelled.</span>
				</div>
			</div>
		</div>
			 </div>
		 
	    </div>
	 </div>
	</div>
</main>

<?php 
Session::forget('orderid');
Session::forget('giftSession'); 
?>
@stop