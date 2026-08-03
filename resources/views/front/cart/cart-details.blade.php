<?php 
 use App\CustomFunction;
 use App\Cart;
 use App\CouponCode;
 use App\ProductAttribute;
 $total_gst = '0'; 
 $subtotal = '0';  
 $total_cart_qty = '0';  
 $total_cart_items = Cart::items('count');  
 
 $summery = Cart::cartdetails($cartitems); 
 $order_discount = $summery['order_discount'];
 $order_discount_percentage = $summery['order_discount_percentage'];
?>
	<div class="card-body p-0">
                     <div class="row g-0">
                       <?php /* <h5 class="cartoffer">
                          Spend <strong>₹10,000</strong> or more and unlock <strong>10% extra</strong> discount on your purchase.
                        </h5>  */ ?>
						<div class="col-lg-8">
                           @if(!empty($total_cart_items))
						   <div class="cart-padding">
                              <div class="d-flex justify-content-between align-items-center mb-3">
                                 <h5 class="mb-0 ">IN MY BAG <span>( {{ $total_cart_items }} @if($total_cart_items > 1)ITEMS @else ITEM @endif )</span></h5>
                              </div>
                             <!--  <hr class="my-2">
                              <div class="row mb-1 d-flex justify-content-between align-items-center">
                                 <div class="col-md-2 col-lg-2 col-xl-2">Item </div>
                                 <div class="col-md-3 col-lg-3 col-xl-3">Description </div>
                                 <div class="col-md-3 col-lg-3 col-xl-2 d-flex">Qty</div>
                                 <div class="col-md-3 col-lg-2 col-xl-2 ">Subtotal</div>
                                 <div class="col-md-2 col-lg-2 col-xl-2">Action </div>
                              </div> -->
                              <hr class="my-2">
                              
							  @foreach($cartitems as $cartitem)
							  <?php $priceDetails = Cart::calProPricing($cartitem);
									$subtotal +=  $priceDetails['prosubtotal']; 
									$total_cart_qty +=  $cartitem['qty']; 
									?>
							  <div class="row mb-4 d-flex justify-content-between align-items-center">
                                 <div class="col-md-2 col-3 col-lg-2 col-xl-2">
                                    <a target="_blank" href="{{url('/product/'.$cartitem['product']['seo_url'])}}">
									@if(!empty($cartitem['product']['product_image']))
									<img
                                       src="{{asset('images/ProductImages/small/'.$cartitem['product']['product_image']['image'])}}"
                                       class="img-fluid rounded-3" title="{{ $cartitem['product']['product_image']['image'] }}" alt="{{ $cartitem['product']['product_image']['image'] }}">
									@else
											<img src="{{asset('images/no-image-found.jpg')}}"  alt="no-image-found.jpg" title="no-image-found" class="attachment-rage_thumbnail size-rage_thumbnail"
											alt="">
									@endif   
									   </a>
                                 </div>
                                 <div class="col-md-3 col-9 col-lg-3 col-xl-3 ">
                                    <a href="{{ url('product/'.$cartitem['product']['seo_url']) }}" class="p-0">
                                    <h6 class="text-muted text-black">{{$cartitem['product']['product_name']}}</h6>
                                    </a>
                                    <h6 class="text-muted f-size ">Color : {{$cartitem['product']['color']}}</h6>
                                    <h6 class="text-muted f-size ">Category : {{ $cartitem['product']['category']['name'] }}</h6>
                                    <h6 class="text-muted f-size ">Size : {{ $cartitem['size'] }}</h6>
                                    <h6 class="text-muted f-size ">Price : INR {{ formatAmt($priceDetails['prosubtotal'] / $cartitem['qty']) }}</h6>
                                 </div>
                                 <div class="col-md-3 col-6 qty-btns col-lg-3 col-xl-2 d-flex p-0">
                                    <button class="btn btn-link px-2"
                                       onclick="qty_onchange('minus',{{$cartitem['id']}})" id="">
                                    <i class="fas fa-minus"></i>
                                    </button>
                                    <input  min="0" id="qty-{{$cartitem['id']}}" data-cartid="{{$cartitem['id']}}"  name="qty" value="{{ $cartitem['qty'] }}" type="number" 
                                       class="cart_qty form-control form-control-sm cart_qty-price" />
                                    <button class="cart_qty btn btn-link px-2"
                                       onclick="qty_onchange('plus',{{$cartitem['id']}})">
                                    <i class="fas fa-plus"></i>
                                    </button>
                                 </div>
                                 <div class="col-md-3 col-4 col-lg-2 col-xl-2 ">
                                    <h6 class="mb-0"> {{ formatAmt($priceDetails['prosubtotal']) }}</h6>
                                 </div>
                                 <div class="col-md-1 col-2 col-lg-1 col-xl-2">
                                    <a href="javascript:;"  data-cart="{{$cartitem['id']}}" class="removeCartProduct text-muted"><i class="fas fa-times"></i></a>
                                 </div>
                              </div>
                              <hr class="my-4">
                             @endforeach
                           </div>
                           @else
							   <div class="cart-padding">
						              <div class="col-12 text-center pt-5 pb-5">

											<svg class="svg-inline--fa fa-exclamation-circle fa-w-16 fa-4x orange" aria-hidden="true" focusable="false" data-prefix="fa" data-icon="exclamation-circle" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg=""><path fill="currentColor" d="M504 256c0 136.997-111.043 248-248 248S8 392.997 8 256C8 119.083 119.043 8 256 8s248 111.083 248 248zm-248 50c-25.405 0-46 20.595-46 46s20.595 46 46 46 46-20.595 46-46-20.595-46-46-46zm-43.673-165.346l7.418 136c.347 6.364 5.609 11.346 11.982 11.346h48.546c6.373 0 11.635-4.982 11.982-11.346l7.418-136c.375-6.874-5.098-12.654-11.982-12.654h-63.383c-6.884 0-12.356 5.78-11.981 12.654z"></path></svg><!-- <i class="fa fa-exclamation-circle fa-4x orange"></i> Font Awesome fontawesome.com -->

											<h5 class="mt-4 mb-4">No items Found in cart</h5>

									  </div>
						       </div>
						   @endif 
						</div>
                        <div class="col-md-4 summary p-3">
                           <div>
                              <h5>Order Summary</h5>
                              <hr>
                           </div>
						   <div id="PrintMessages"> </div>
                           
						  
                           <div class="input-wrapper">
                              
							  <div class="promo">
                                 <h6>Coupon Code</h6>
                              </div>
							   
                              <form id="ApplyCoupon" method="post" action="javascript:void(0);">@csrf
							  <input type="text" placeholder="" id="couponInput" name="code" @if(Session::has('couponinfo')) value="{{ Session::get('couponinfo')['code'] }}"  @endif class="size-width"> 
                              <button class="button_style">Apply Coupon</button>
                              </form>
							  @if(Auth::check())
					<?php $coupons = CouponCode::availableCoupons($cartitems); ?>
					@if($coupons)
						<p class="mt-2 mb-2 orange">Available Coupons</p>
						<div class="radiobuttons">
							@foreach($coupons as $coupon)
								<div class="coupon-welcome">
										  <h6><input type="" class="available_coupon_code" value="{{$coupon['code']}}"></h6>
										  <p>{{$coupon['terms_and_conditions']}}
										  <span>
											 @if(Session::has('couponinfo') && Session::get('couponinfo')['code'] ==  $coupon['code'])
											     <img src="{{ asset('assets/images/icons/tick-icon.png') }}">
											 @else
												 <a href="javascript:;" onclick="copyCode('{{$coupon['code']}}')" class="text-muted"><i class="fa fa-copy"></i></a>
											 @endif
											 </span>
										  </p>
							  
                                  </div>
							@endforeach
						</div>
					@endif
				@endif
						   </div>
						   
						   <?php $shipping = Cart::CalculateShipping($cartitems);
                            $couponamount =0; ?>
							@if(Session::has('couponinfo'))
							<?php $couponamount = CouponCode::getCouponAmount(Session::get('couponinfo'),$subtotal); ?>
							@endif
						   
						 
						 <div class="row">
                              <div class="col p-3 pb-0" >Qty:</div>
                              <div class="col p-3 pb-0 text-end"> {{ $total_cart_qty }} </div>
                           </div>
						    <hr>
						   <div class="row">
                              <div class="col p-3 pb-0" >Subtotal:</div>
                              <div class="col p-3 pb-0 text-end"> {{CustomFunction::formatAmt($subtotal)}}</div>
                           </div>
                           <hr>
						   
						    <div class="row">
                              <div class="col p-3 pb-0" >Coupon Discount:</div>
                              <div class="col p-3 pb-0 text-end"> {{CustomFunction::formatAmt($couponamount )}}</div>
                           </div>
						   <hr>
						   
						   @if(!empty($order_discount))
						    <div class="row">
                              <div class="col p-3 pb-0" ><strong>Order Discount ({{ $order_discount_percentage }}%)</strong>:</div>
                              <div class="col p-3 pb-0 text-end"><strong> {{CustomFunction::formatAmt($order_discount )}} </strong></div>
                           </div>
						   <hr>
						   @endif
						   
						   
						   
						   
						    <div class="row">
                              <div class="col p-3 pb-0" ><strong>Shipping</strong>:</div>
                              <div class="col p-3 pb-0 text-end"><strong>  @if(!empty($shipping)) {{CustomFunction::formatAmt($shipping )}} @else Free @endif</strong></div>
                           </div>
						   <hr>
						   
						   
						   
						   
                           <div class="row">
                              <div class="col p-3 pb-0  pt-0" style="padding-left:0;"><strong>Grand Total:</strong></div>
                              <div class="col p-3 pb-0  pt-0 text-end"><strong> <?php
					if(Session::has('couponinfo')){
						$tot = CustomFunction::formatAmt($subtotal + $shipping -($couponamount +$order_discount));
					}else{
						$tot = CustomFunction::formatAmt(($subtotal + $shipping) - $order_discount);
					}
					echo number_format(round($tot)) ; ?></strong></div>
                           </div>
                           <hr>
                           <div class="row">
                              <p style="font-weight: 500; font-size: 14px;">Note: Return request will be accepted within 24 hours only once the order gets delivered.</p>
                           </div>
						   
						   
                           <div class="div">
                              <a @if(Auth::check()) href="{{ url('order-checkout') }}"  @else href="{{ url('login') }}" @endif ><button class="checkout">Proceed to Checkout</button></a>
                           </div>
						   @if(!Auth::check())
							   <div class="div text-center" style="margin-top:5px"><p>OR</p></div>
							   <div class="div">
                                  <a href="javascript:void(0);" data-toggle="modal" data-target="#GuestCheckoutModal"><button class="checkout">Guest Checkout</button></a>
                               </div>
						   @endif
                           <!-- <div class="desc">
                              <p>Online purchases are currently not eligible for earning loyalty points under RITU KUMAR Loyalty Program.
                              Store Credits & E-Gift cards are temporarily discontinued, for more assistance please reach out to our customer care team.
                              </p>
                              </div> -->
                        </div>
                     </div>
                  </div>
               <?php /*
			@if(!empty($cartitems))
            <div class="offset-lg-1 col-lg-4 col-12">
              <div class="row">
                <div class="col-12">
				  <div class="coupon-info-msg">
				       <p >Register now for a 10% discount on your first order!</p>
					   <p class="p2">Use coupon: <span>Welcome10</span></p>
				  </div>
                  <button class="coupon-code coupon-code-btn" data-toggle="collapse" data-target="#coupon">Got a Coupon Code? <i class="fa fa-angle-down"></i> </button>
                  <div id="coupon" class="collapse show coupon mt-2">
				   <div id="PrintMessages"> </div>
                    <form id="ApplyCoupon" method="post" action="javascript:void(0);">@csrf
                      
                      <input type="text" class="coupon-input-style" id="couponInput" name="code"  placeholder="Enter Coupon Code..." >
                      <button type="submit" class="coupon-btn-style">Apply</button>
                    </form>
					@if(Auth::check())
					<?php $coupons = CouponCode::availableCoupons($cartitems); ?>
					@if($coupons)
						<p class="mt-2 mb-2 orange">Available Coupons</p>
						<div class="radiobuttons">
							@foreach($coupons as $coupon)
								<div class="rdio rdio-primary radio-inline"> 
									<input type="radio" value="{{$coupon['code']}}" name="coupon" id="{{$coupon['id']}}" @if(Session::has('couponinfo') && Session::get('couponinfo')['code'] == $coupon['code']) checked  @endif>
									<label for="{{$coupon['id']}}">{{$coupon['code']}} <span>
									@if($coupon['amount_type'] =="Rupees")
										(Rs. {{CustomFunction::formatAmt($coupon['amount'])}} off)
									@else
										({{$coupon['amount']}}% off)
									@endif
									</span></label>
								</div>
							@endforeach
						</div>
					@endif
				@endif
                  </div>
                </div>
              </div>
              <hr>
              <div class="row">
                <div class="col-sm-12 col-12 cart-total">
                  <h5 class="orange">Cart Summary</h5>
                  <p class="main-total">Subtotal <span>INR  {{CustomFunction::formatAmt($subtotal - (formatAmt($total_gst)) )}}</span></p>
                 <?php $couponamount =0; ?>
				 	@if(Session::has('couponinfo'))
					<?php $couponamount = CouponCode::getCouponAmount(Session::get('couponinfo'),$subtotal); ?>
			        @endif
				  <?php $shipping = Cart::CalculateShipping($cartitems); ?>
					
						
						<p class="main-total">Shipping <span>INR. {{CustomFunction::formatAmt($shipping)}}</span></p> 
						
									  
                 <p class="main-total">Discount (If Any)  <span>INR.{{CustomFunction::formatAmt($couponamount)}}</span></p>
                 
                 <hr>
                  <h5 class="main-total">Total <span>INR <?php
					if(Session::has('couponinfo')){
						$tot = CustomFunction::formatAmt($subtotal - $couponamount + $shipping);
					}else{
						$tot = CustomFunction::formatAmt($subtotal + $shipping);
					}
					echo round($tot) ; ?></span></h5>
                   <p style="color:red;font-weight: bolder; font-size: 15px;">Note: Return request will be accepted within 24 hours only once the order gets delivered.</p>
                </div>
              </div>
              <div class="row mt-2">
                <div class="col-12 cart-btn buy-bttns">
                  <div class="buy-bttns"> <a href="{{ url('/') }}" class="continue-btn">Continue Shopping</a> 
                  </div>
                </div>
              </div>
              <div class="row mt-2">
                <div class="col-12 cart-btn"> 
				
				<a  @if(Auth::check()) href="{{ url('/order-checkout') }}" @else  href="{{ url('/login') }}" @endif class="checkout-btn">Continue to Checkout</a>
				@if(!Auth::check())
                  <p class="text-center" style="margin-top: 10px;">OR</p>
                   <a href="javascript:void(0);" data-toggle="modal" data-target="#GuestCheckoutModal" class="checkout-btn">Guest Checkout</a> </div> 
                @endif 
              </div>
            </div>
           @endif
           */ ?>