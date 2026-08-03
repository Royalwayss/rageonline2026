<?php
use App\Cart;
$subtotal = 0 ;
?>
				   @foreach($cartitems as $cart_key => $cartitem)
                    <?php 
                     $priceDetails = Cart::calProPricing($cartitem);
                     $subtotal +=  $priceDetails['prosubtotal'];
                     ?> 
					@endforeach
				   <div class="d-flex justify-content-between mb-2">
					  <h5 class="text-uppercase" style="color:black;">Sub Total</h5>
					  <h5 style="color:black;"> {{ AmountFormat($subtotal) }}</h5>
				   </div>
				   <div class="d-flex justify-content-between mb-2">
					  <h5 class="text-uppercase" style="color:black;">Shipping</h5>
					  <h5 style="color:black;"> {{ AmountFormat($cartPricing['shipping']) }}</h5>
				   </div>
				   <input type="hidden" id="discountamount" value="{{ $cartPricing['discount'] }}">
				   <div class="d-flex justify-content-between mb-2">
					  <h5 class="text-uppercase" style="color:black;">Coupon Discount</h5>
					  <h5 class="discount_amount" style="color:black;"> {{ AmountFormat($cartPricing['discount']) }}</h5>
				   </div>
				   
				   @if(!empty($cartPricing['order_discount']))
				   <div class="d-flex justify-content-between mb-2">
					  <h5 class="text-uppercase" style="color:black;">Order Discount ({{ $cartPricing['order_discount_percentage'] }}%)</h5>
					  <h5 class="" style="color:black;"> {{ AmountFormat($cartPricing['order_discount']) }}</h5>
				   </div> 
				   @endif
				   
				   
				   @if(!empty($cartPricing['prepaid_discount']))
				   <div class="d-flex justify-content-between mb-2" id="prepaid_discount" >
					  <h5 class="text-uppercase" style="color:black;">Prepaid Discount</h5>
					  <h5 class="prepaid_discount" style="color:black;">{{ AmountFormat($cartPricing['prepaid_discount']) }}</h5>
				   </div>
				   @endif
				   
				   
				   
				   
				   
				     @if(Session::has('pointsinfo'))
					   <div class="d-flex justify-content-between mb-2" id="prepaid_discount" >
						  <h5 class="text-uppercase" style="color:black;">Reward Points</h5>
						  <h5 class="prepaid_discount" style="color:black;">{{ AmountFormat(Session::get('pointsinfo')['amount']) }}</h5>
					   </div>
				    @endif
				   
				  
				   
				   
				   
				   
				   
				   
				   @if(!empty($cartPricing['round_of']))
				   
				  
				   <div class="d-flex justify-content-between mb-2">
					  <h5 class="text-uppercase">Total</h5>
					  <h5 class=""> 
					  
					  @if(Session::has('pointsinfo'))
					     <?php //echo AmountFormat($cartPricing['grandtotal'] - Session::get('pointsinfo')['amount']);  ?>
				      @else
						  {{ AmountFormat($cartPricing['grandtotal']) }}
					  @endif
					  
					  
					  
					  </h5>
				   </div>
				    @endif 
				   
				   
				   
				   
				   
				   
				   
				   @if(!empty($cartPricing['round_of']))
				   
				  
				   <div class="d-flex justify-content-between mb-2">
					  <h5 class="text-uppercase">Total</h5>
					  <h5 class=""> {{AmountFormat($cartPricing['grandtotal'])}}</h5>
				   </div>
				   
				   <div class="d-flex justify-content-between mb-2" id="round_of" >
					  <h5 class="text-uppercase" style="color:black;">Round Of</h5>
					  <h5 class="round_of" style="color:black;"><?php echo round_of($cartPricing['round_of']); ?></h5>
				   </div>
				   
				    @endif 
				   <div class="d-flex justify-content-between mb-2">
					  <h5 class="text-uppercase"><strong>Grand Total</strong></h5>
					  
					  <h5 class="grandtotal_amount">
					  @if(Session::has('pointsinfo'))
						  <?php echo AmountFormat($cartPricing['final_grandtotal'] - Session::get('pointsinfo')['amount']);  ?>
					  @else
						  {{ AmountFormat($cartPricing['final_grandtotal']) }}
					  @endif
					  </h5>
					  
					   
				   </div> 