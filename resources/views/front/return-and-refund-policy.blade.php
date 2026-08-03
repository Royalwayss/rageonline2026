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
<div class="container policy-divs">
	<div class="row">
		<!-- <div class="col-lg-12 mb-3">
			<ol class="breadcrumb p-0">
				<li><a href="{{ url('/') }}">Home&nbsp;/&nbsp;</a></li>
				<li class="active">Return & Refund Policy</li>
			</ol>
		</div> -->
		<div class="col-lg-12 policy-padding privacy-policy-content" >
			<h3 class="">RETURN & REFUND POLICY</h3>
			<hr>
			<p>You may request for a Return/Exchange of your order within 24 hours of delivery of the order from the order page in your account  at <a href="{{ url('/') }}" style="color: #e3b282;"> https://www.rageonline.co.in/</a>  In case, you placed a COD order, you may request the same from the  <a target="_block" style="color: #e3b282;" href="https://miarcus.com/pages/returns-exchange">Return</a> button in my account. Return/Exchange can be requested only on reasons based on size issues, defective articles, different/wrong colors, or quality issues. At the time of creating a return customers are requested to make sure that the product being returned is unused with original tags intact. Exchange can only be done with the same product in a different size or color & no other product replacement is possible in any case. All this at no extra cost to you! Rage reserves the right to decline the Return/Exchange request if the reason stated is different from the specified list or is not genuine</p>
			<p>We will arrange a free pickup of the return/Exchange order through our logistic partner. Please note, the free reverse pickup is only provided once per order. If you raise multiple return requests (subject to special cases), the reverse pickup amount will be deducted from the refund  amount, and   the amount paid by you will be credited to your bank account/original payment method.</p>
		</div>
	</div>
	</div>
@stop