@extends('layouts.frontLayout.front-layout') @section('content') 
<?php 
   use App\CustomFunction;
   use App\Cart;
   use App\CouponCode;
   use App\GiftOffer; 
   //$summery = Cart::cartdetails($cartitems); 
     // $order_discount = $summery['order_discount'];
   
   $total_gst = '0';
   $subtotal = 0;
   
   ?> 
<style>
.grandtotal_amount{ font-weight:bold; }

#points-redemption-box {
    background: linear-gradient(135deg, #f0fdf4, #dcfce7);
    border: 1px solid #86efac;
    border-left: 4px solid #16a34a;
    border-radius: 6px;
    padding: 14px 16px;
    margin: 15px 0;
}
#available-points-text {
    margin: 0 0 10px 0;
    font-size: 14px;
    font-weight: 500;
    color: #166534;
}
.points-redeem-row {
    display: flex;
    gap: 8px;
    align-items: center;
}
.points-redeem-row input#points_to_redeem {
    max-width: 180px;
    padding: 6px 10px;
    border: 1px solid #86efac;
    border-radius: 4px;
    font-size: 14px;
}
.points-err {
    color: #dc2626;
    font-size: 13px;
    margin-top: 6px;
}
</style>
<main>
   <div class="container order-details">
      <form name="checkout" id="OrderPlace" method="post" class="" action="javascript:;">
         @csrf
         <div class="row checkout-warp">
            <div class="col-xl-7 shipping-div">
               <h4 class="mb-4">Shipping Address</h4>
               <div class="card">
                  <div class="card-body p-4">
                     <ol class="activity-checkout mb-0 px-0 mt-0">
                        <li class="checkout-item">
                           <div class="feed-item-list">
                              <div>
                                 <!-- <p class="text-muted text-truncate mb-4">Sed ut perspiciatis unde omnis iste</p> -->
                                 <div class="mb-3">
                                    <?php $address_type = 'shipping'; ?>
                                    @include('front.checkout.billing_shipping_form') 
                                 </div>
                                 <div class="row mt-5">
                                    <h4 class="mb-2">Additional information</h4>
                                    <label class="form-label">Order notes  (optional)  </label>
                                    <textarea name="comments" class="form-control input-text " id="order_comments" placeholder="Notes about your order, e.g. special notes for delivery." rows="2" cols="5"></textarea>
                                 </div>
                              </div>
                           </div>
                        </li>
                     </ol>
                  </div>
               </div>
            </div>
            <div class="col-lg-5 shipping-details">
               <div class="">
                  @foreach($cartitems as $cart_key => $cartitem)
                  <?php 
                     $priceDetails = Cart::calProPricing($cartitem);
                     $subtotal +=  $priceDetails['prosubtotal'];
                     ?> 
                  <div class="product-text" @if($cart_key != '0')style="margin-top:20px;" @endif>
                  <a target="_blank"  href="{{url('/product/'.$cartitem['product']['seo_url'])}}">
                  @if(!empty($cartitem['product']['product_image']))
                  <img src="{{asset('images/ProductImages/small/'.$cartitem['product']['product_image']['image'])}}" alt="">
                  @else 
                  <img src="{{asset('images/no-image-found.jpg')}}" alt="no-image-found.jpg" title="no-image-found" class="attachment-rage_thumbnail size-rage_thumbnail" alt="" width="600" height="778">
                  @endif 
                  </a>
                  <div class="product-details">
                     <a target="_blank" style="color: #000000;" href="{{url('/product/'.$cartitem['product']['seo_url'])}}"> 
                     <span><b> {{$cartitem['product']['product_name']}}</b></span>
                     </a>
                     <span>Item Code: {{$cartitem['product']['product_code']}}</span>
                     <span>Color : {{$cartitem['product']['color']}}</span>
                     <span>Size: {{$cartitem['size']}}</span>
                     <span>Price : INR {{formatAmt($priceDetails['prosubtotal']/$cartitem['qty'])}}</span>
                  </div>
               </div>
               @endforeach
               <hr class="my-4">
			   <div id="order_summary">
				   @include('front.checkout.order_summary')
               </div>
                <div class="row">
               <?php /* <div id="order-notes">
				           <p id="reward-points">🎉 Get 10% of your order value as Reward Points on every order — redeemable on your next purchase!</p>
				   </div> */ ?>
               <div id="points-redemption-box" @if(empty($availablePoints)) style="display:none;" @endif>
                  <p id="available-points-text" >
				  
				      <?php
					  
					      if(Session::has('pointsinfo')){
							  $currently_availablePoints = $availablePoints - Session::get('pointsinfo')['points'];
						  }else{
							  $currently_availablePoints = $availablePoints;
						  }

						  ?>
				  
                     💰 You have <span id="currently_availablePoints"><strong>{{ $currently_availablePoints ?? 0 }}</strong></span> Reward Points available
                  </p>
				  
                  @if(($availablePoints ?? 0) > 0)
                  <div class="points-redeem-row">
                     <input type="number" id="points_to_redeem" name="points_to_redeem" min="0" max="{{ $availablePoints }}" placeholder="Enter points to redeem" class="form-control" @if(Session::has('pointsinfo')) value="{{ Session::get('pointsinfo')['points'] }}"  @endif>
                     <button type="button" id="ApplyPoints" @if(Session::has('pointsinfo')) style="display:none;" @endif class="btn btn-outline-dark btn-sm">Apply</button>
					 
                     <button type="button" id="RemovePoints" class="btn btn-link btn-sm" @if(!Session::has('pointsinfo')) style="display:none;" @endif>Remove</button>
					 
					 
                  </div>
                  <div  id="Address-points_to_redeem"></div>
                  @endif
               </div>
               </div>
               
			   <div class="d-flex justify-content-between mb-2">
                  
				  <ul class="wc_payment_methods payment_methods methods">
                     <?php /*<li class="row wc_payment_method payment_method_phonepe">
                        <div class="col-lg-12 mt-3">
                           <input id="payment_method_phonepe" type="radio" class="input-radio" name="paymentMode" value="phonepe" data-order_button_text="Proceed to Phonepe">
                           <label for="payment_method_phonepe">Phonepe - Net Banking/ Debit/ Credit Card/ Wallets &nbsp; <span style="color: #fa8f47;">
                           <b> (5% Discount)</b>
                           </span>
                           </label>
                        </div>
                        <div class="col-lg-12 card-details">
                           <img src="assets/images/AM_mc_vs_ms_aeUK.png" alt="Phonepe acceptance mark" style="margin-top: 10px;">
                        </div>
                     </li> */ ?>
					 <li class="row wc_payment_method payment_method_phonepe">
                        <div class="col-lg-12 mt-3">
                           <input id="payment_method_phonepe" type="radio" class="input-radio" name="paymentMode" value="razorpay" data-order_button_text="Proceed to Razorpay">
                           <label for="payment_method_phonepe">Razorpay - Net Banking/ Debit/ Credit Card/ Wallets &nbsp; <span style="color: #fa8f47;">
                           <b> (5% Discount)</b>
                           </span>
                           </label>
                        </div>
                        <div class="col-lg-12 card-details">
                           <img src="assets/images/AM_mc_vs_ms_aeUK.png"  style="margin-top: 10px;">
                        </div>
                     </li>
                     <div class="row" style="margin-top:10px">
                        <div class="address-err" id="Address-paymentMode"></div>
                     </div>
                     <?php /*      <li class="row wc_payment_method payment_method_ccavenue">
                        <div class="col-lg-12 mt-3">
                            <input id="payment_method_ccavenue" type="radio" class="input-radio" name="paymentMode" value="ccavenue" data-order_button_text="Proceed to Ccavenue">
                        
                            <label for="payment_method_ccavenue">Ccavenue - Net Banking/ Debit/ Credit Card/ Wallets &nbsp; <span style="color: #fa8f47;">
                                <b> (5% Discount)</b>
                              </span>
                            </label>
                        </div>
                        <div class="col-lg-12">
                            <img src="assets/images/AM_mc_vs_ms_aeUK.png" alt="Ccavenue acceptance mark" style="margin-top: 10px;">
                        </div>
                        </li>  */ ?>
                     <li class="wc_payment_method payment_method_cod  mt-3">
                        <input id="payment_method_cod" type="radio" class="input-radio" name="paymentMode" value="cod" data-order_button_text="">
                        <label for="payment_method_cod"> Cash on delivery </label>
                        <div class="payment_box payment_method_cod" style="display:none;">
                           <p>Pay with cash upon delivery.</p>
                        </div>
                     </li>
                     <?php /* 
                        <li class="wc_payment_method payment_method_bacs">
                            <input id="payment_method_bacs"  type="radio" class="input-radio" name="paymentMode" value="bank_deposit"  data-order_button_text="">
                                <label for="payment_method_bacs"> Direct bank transfer </label>
                                                                                                                <div class="payment_box payment_method_bacs">
                                                                                                                    <p>Make your payment directly into our bank account. Please use your
                            Order ID as the payment reference. Your order will not be shipped
                            until the funds have cleared in our account.</p>
                                                                                                                </div>
                                                                                                            </li> */ ?> <?php /* 
                        <li class="wc_payment_method payment_method_paypal">
                            <input id="payment_method_paypal"  type="radio" class="input-radio" name="paymentMode" value="payu" data-order_button_text="Proceed to PayPal">
                                <label for="payment_method_paypal"> PayU (Net Banking/Debit/Credit Card) 
                                    <img src="assets/images/AM_mc_vs_ms_aeUK.png" alt="PayPal acceptance mark" style="margin-top: 10px;">
                                        <!-- <a href="#" class="about_paypal">What is
                        PayPal?</a></label><div class="payment_box payment_method_paypal" style="display:none;"><p>Pay via PayPal; you can pay with your credit card if you don’t have a
                        PayPal account.</p>  -->
                                    </div>
                                </li>  
                        */ ?>
                  </ul>
               </div>
			   
			   <a href="javascript:;" id="PlaceOrder"><button type="button" class="btn btn-dark btn-block btn-lg PlaceOrderBtn" data-mdb-ripple-color="dark">Place Order</button></a>
            </div>
         </div>
   </div>
   </form>
   <!-- end row -->
   </div>
</main>
@stop
@section('javascript')
@parent
<script type="text/javascript" src="{{ asset('js/ajax_jquery.min.js')}}"></script>
<script>
   function percentage(num, per) {
     return (num / 100) * per;
   }
   
   
   $('input[name=paymentMode]').on('click', function() { 
     var paymode = $(this).val();
            $('.PleaseWaitDiv').show();
	        $.ajax({
				   url: '/get-order-summery',
				   type: 'POST',
			       data: {_token: "{{ csrf_token() }}",paymode:paymode},
				   success: function(res) {
					 $('.PleaseWaitDiv').hide();
					 $("#order_summary").html(res.order_summary);
					   
					}
		   });
				   
	});

   // Points redemption - Apply
   $('#ApplyPoints').click(function() {
     var pointsToRedeem = parseInt($('#points_to_redeem').val()) || 0;
     var payment_mode = $('input[name=paymentMode]:checked').val(); 
     
	 if (!payment_mode) { payment_mode = ''; }
	   
	
	 
	 var availablePoints = {{ $availablePoints ?? 0 }};

     $('.points-err').html('');

     if (pointsToRedeem <= 0) {
       //$('#Address-points_to_redeem').html('<span style="color:red">Please enter a valid number of points.</span>');
      // return;
     }
     if (pointsToRedeem > availablePoints) {
       //$('#Address-points_to_redeem').html('<span style="color:red">You only have ' + availablePoints + ' points available.</span>');
      // return;
     }

     $('.PleaseWaitDiv').show();
     $.ajax({
       url: '/apply-points',
       type: 'POST',
       data: {_token: "{{ csrf_token() }}", points: pointsToRedeem,payment_mode:payment_mode},
       success: function(res) {
         $('.PleaseWaitDiv').hide();
         if (res.status) { 
          $("#order_summary").html(res.order_summary);
           $('#Address-points_to_redeem').html('<span style="color:green">' + res.message+ '</span>');
           $('#ApplyPoints').hide();
           $('#RemovePoints').show();
         } else {
           $('#Address-points_to_redeem').html('<span style="color:red">' + res.message + '</span>');
         }
       }
     });
   });

   // Points redemption - Remove
   $('#RemovePoints').click(function() {
     $('.PleaseWaitDiv').show();
     
	 
	  var payment_mode = $('input[name=paymentMode]:checked').val(); 
     
	 if (!payment_mode) { payment_mode = ''; }
	   
	 
	 
	 
	 
	 $.ajax({
       url: '/remove-points',
       type: 'POST',
       data: {_token: "{{ csrf_token() }}",payment_mode:payment_mode},
       success: function(res) {
         $('.PleaseWaitDiv').hide();
         $("#order_summary").html(res.order_summary);
		 $('#Address-points_to_redeem').html('<span style="color:green">' + res.message+ '</span>');
         $('#points_to_redeem').val('').prop('disabled', false);
         $('#ApplyPoints').show();
         $('#RemovePoints').hide();
       }
     });
   });
   	
   
   
   
   $('#PlaceOrder').click(function() {
     $('.PleaseWaitDiv').show(); 
     var formdata = $("#OrderPlace").serialize();
     var actionType = $('[name=action]').val();
     $.ajax({
       url: '/check-order',
       type: 'POST',
       data: formdata,
       success: function(data) {
         $('.PleaseWaitDiv').hide();
         $('.address-err').html('');
         if (!data.status) {
           if (data.type == "validation") {
             var err_no = 0;
             $.each(data.errors, function(i, error) {
               err_no = err_no + 1;
               $('#Address-' + i).html(error);
               if (err_no == 1) {
                 $("#" + i).focus();
               }
             });
           }
         } else {
           $('#OrderPlace').attr('action', data.action);
           $('#OrderPlace').submit();
         }
       }
       
     });
     $('.PleaseWaitDiv').hide(); 
   });
   $('#same_address').change(function() {
     if ($(this).prop('checked') == true) {
       $("#shipping_first_name").val($("#billing_first_name").val());
       $("#shipping_mobile").val($("#billing_mobile").val());
       $("#shipping_address").val($("#billing_address").val());
       $("#shipping_postcode").val($("#billing_postcode").val());
       $("#shipping_city").val($("#billing_city").val());
       $("#shipping_state").val($("#billing_state").val());
       $("#shipping_country").val($("#billing_country").val());
     } else {
       $("#shipping_first_name").val('');
       $("#shipping_mobile").val('');
       $("#shipping_address").val('');
       $("#shipping_postcode").val('');
       $("#shipping_city").val('');
       $("#shipping_state").val('');
       $("#shipping_country").val('');
     }
   });
</script> @stop