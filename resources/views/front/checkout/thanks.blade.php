@extends('layouts.frontLayout.front-layout')
@section('content')
<?php use App\GiftOffer; ?>

<main>
	<div class="container order-placed">
	  <div class="row">
	    <div class="main-content col-md-12 mt-3 mb-3">
	      <div class="page-main-content">
	       
			<!--   <div class="row">
				  <ol class="breadcrumb">
					<li><a href="{{ url('account/orders') }}">Order&nbsp;/&nbsp;</a></li>
					<li class="active">Thanks</li>
				  </ol>
	      </div> -->
				<div class="container order-placed-detail">
				<div class="row">
				<div class="col-12 col-md-7 text-center pt-3 pb-3 order-cnfrmd">
				<!--- <img src="{{asset('images/happy-thanks.jpg')}}" style="width: 110px;"> -->
				<!-- <i class="fa fa-check-square-o fa-4x orange"></i> -->
				<?php $total_amount = 0;
				//echo "<pre>"; print_r($orderdetails['order_products']);
				?>
				@foreach($orderdetails['order_products'] as $orderpro)
				    <?php 
				    
				        $total_amount= $orderpro['grand_total'];
				    
				    ?>
				
				@endforeach
	            <h3 class="mt-4 mb-4">Order Confirmed</h3>
	            <span class="order-number">Thank you for shopping with us. This made our day!</span>
	            <p class="mt-4">Order total amount is <strong><span style="font-size:18px">Rs. {{ formatAmt($total_amount) }}</span></p></strong>
	            <p class="mt-4">Your Order Id is #{{Session::get('orderid')}}</p>
	            <p class="mt-4"><a href="{{ url('/') }}" class="buynow btn font16 btn-lg btn-outline-dark font12 mb-3 text-uppercase" style="color: #fff">Continue Shopping</a></p>
			</div>
<!-- 			<div class="col-12 thanks-div">
					<div class="row">
						<div class="col-12">
						  
						</div>
					</div>
			</div> -->
			
				<div class="col-12 thanks-div">
					<div class="row thanks-div-row">
						<h4>Products </h4>
						@foreach($orderdetails['order_products'] as $orderpro) 
						<div class="row thanks-product">
							<div class="col-md-2 col-sm-4 col-4 cnfrmd-img-wrap">
								<a target="_blank" href="{{url('/product/'.$orderpro['productdetail']['seo_url'])}}">
								@if(isset($orderpro['productdetail']['product_image']))
									<img src="{{asset('images/ProductImages/small/'.$orderpro['productdetail']['product_image']['image'])}}" class="img-fluid cf-pr-img" alt="" />
								@else
									<img src="{{asset('images/no-image-found.jpg')}}" class="img-fluid" style="height:160px;width:160px" alt="" />
								@endif
								</a>
							</div>
							<div class="col-md-10 col-sm-8 col-8 thanks-prd-dtl">
								<h5>
								<a target="_blank" href="{{url('/product/'.$orderpro['productdetail']['seo_url'])}}"> {{$orderpro['product_name']}}
								</a>
								</h5>
								<p>{{$orderpro['product_size']}}</p>
								<p>Rs.{{formatAmt($orderpro['subtotal'])}}</p>
							</div>
						</div>
						@endforeach
					</div>	
				</div>
				
			
		</div>
		@if(Session::has('giftSession'))
			<?php $giftInfo = GiftOffer::giftinfo(Session::get('giftSession')); ?>
			<div class="row mb-2">
				<div class="col-12 free-gift">
					<br />
					<h5 class="purple">Free Gift Included</h5>
					<img src="{{asset('images/GiftImages/'.$giftInfo->gift_image)}}" class="img-fluid" />

				</div>	
			</div>
		@endif
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