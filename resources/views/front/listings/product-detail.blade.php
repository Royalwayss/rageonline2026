<?php  //echo "<pre>"; print_r($productdetails); exit;
   error_reporting(0);
   $page_link = url('product/'.$productdetails['seo_url']);
   $stock_count = array_sum(array_column($productdetails['pro_attrs'],'stock')); 
   use App\CustomFunction; use App\Wishlist;  use APP\ProductAttribute; use APP\Product;  
   $size_array = array();
   if(is_array($productdetails['pro_attrs'])){
      if(count($productdetails['pro_attrs'])>0){
         foreach($productdetails['pro_attrs'] as $key=> $pro_attrs){  
            $size_array[] = $pro_attrs['size'];
         }
      }
   }
   
   $size_chart = '';
   if($productdetails['size_chart'] != ''){
      $size_chart = $productdetails['size_chart'];
   }else{
       if(!empty($productdetails['category']['size_chart'])){
          $size_chart = $productdetails['category']['size_chart'];
       }
   }
    
   ?>
@extends('layouts.frontLayout.front-layout')
@section('content')
<style>
.whatsapp-icon {
    bottom: 83px !important;
}
</style>
<main>
   <div class="container-fluid mb-5 single-product product-detail-pg">
      <div class="shop-wrapper">
         <div class="single-product-top">
            <div class="row justify-content-center">
               <div class="col-lg-12">
                  <div class="row">
                     <div class="col-lg-5 col-xl-5 col-md-5 col-sm-5 product-web-view">

                     <div class="slider">
                        <div class="slider__flex">
                           <div class="slider__col">

                              <div class="slider__prev">Prev</div> <!-- Кнопка для переключения на предыдущий слайд -->

                              <div class="slider__thumbs">
                              <div class="swiper-container">
                                 <!-- Слайдер с превью -->
                                 <div class="swiper-wrapper">
                                    @foreach($productdetails['productimages'] as $imgkey => $proimage)
									<div class="swiper-slide">
                                          <div class="slider__image"><img src="{{asset('images/ProductImages/xlarge/'.$proimage['image'])}}" alt=""></div>
                                    </div>
                                    @endforeach
                                   
                                 </div>
                              </div>
                              </div>

                              <div class="slider__next">Next</div> 

                           </div>

                           <div class="slider__images">
                              <div class="swiper-container">

                              <div class="swiper-wrapper">
                                 @foreach($productdetails['productimages'] as $imgkey => $proimage)
								 <div class="swiper-slide">
									 <a href="{{asset('images/ProductImages/xlarge/'.$proimage['image'])}}" class="slider__image largeImg" data-fancybox="gallery">
										<img src="{{asset('images/ProductImages/xlarge/'.$proimage['image'])}}" alt="" />
									 </a>
                                 </div>
                                  @endforeach   
                                  
                              </div>
                              </div>
                           </div>

                        </div>
                     </div>


                           <div class="row">
                                 <div class="product-gallery d-flex">
                                    <!-- Thumbnails LEFT -->
                                    <div id="sync2" class="owl-carousel thumbs-carousel me-3">
                                       @foreach($productdetails['productimages'] as $imgkey => $proimage)
                                       <div class="item">
                                             <img src="{{asset('images/ProductImages/xlarge/'.$proimage['image'])}}" class="img-fluid" alt="">
                                       </div>
                                       @endforeach
                                    </div>

                                    <!-- Main Slider -->
                                    <div id="sync1" class="owl-carousel main-carousel">
                                       @foreach($productdetails['productimages'] as $imgkey => $proimage)
                                       <div class="item">
                                             <img src="{{asset('images/ProductImages/xlarge/'.$proimage['image'])}}" class="w-100" alt="">
                                       </div>
                                       @endforeach
                                    </div>
                                 </div>
                           </div>
                     </div>
                     <div class="col-xl-6 col-lg-6 col-md-7 col-12 col-sm-7 pr-detail-right">
                        <div class="single-product-sidebar">
                           <div class="product-content">
                              <div class="single-product-title">
                                 <h4>{{ $productdetails['product_name'] }}</h4>
                              </div>
                              <div class="single-product-category">
                                 <ul>
                                    <li class="single-product-component">
                                       <h6>Category:</h6>
                                    </li>
                                    <li class="mb-0"><a class="pr-cat-ds" href="{{ url($productdetails['category']['seo_unique']) }}">{{ $productdetails['category']['name'] }}</a></li>
                                 </ul>
                              </div>
                              <div class="single-product-component mb-4">
                                 <h6>Product Code: <span class="color-value">{{ $productdetails['product_code'] }}</span></h6>
                              </div>
                              <div class="single-product-price mt-15">
                                 <h6>MRP: <span class="pricing-text">INR<span> {{ Product::ProductPrice($productdetails['category_id'],$productdetails) }}</span>
                                    @if($productdetails['current_discount'] == 'product' || $productdetails['current_discount'] == 'category')
                                    - <span><strike> INR {{round(CustomFunction::formatAmt($productdetails['product_price']))}}</strike></span>
                                    @endif
                                    @if($productdetails['current_discount'] == 'product' || $productdetails['current_discount'] == 'category')    
											  <?php
												  if($productdetails['current_discount'] == 'product'){
													 $discount_percentage = $productdetails['product_discount'];
												  }else{
													 $discount_percentage = $productdetails['category']['category_discount'];
												  }
											  ?>
											  <span class="badge bg-dark " style="line-height: unset;">{{$discount_percentage}}% OFF</span>
									@endif
                                    </span>
                                    <div class="text-include">(inclusive of all taxes)</div>
                                 </h6>
                              </div>
                              <div class="single-product-component mt-15 mb-3">
                                 <h6>Color: <span class="color-value">{{ $productdetails['color'] }}</span></h6>
                                  @if(count($productdetails['groups'])>0) 
								   <h6 class="mt-20">More Colors:</span></h6>
								   <div class="color-input">
									  @foreach($productdetails['groups'] as $color_key=>$grouproduct) 
									  <a href="{{ url('/product/'.$grouproduct['seo_url'])}}">
									  <span>{{ $grouproduct['color'] }}</span>
									  </a>
									  @endforeach
								   </div>
								   @endif 
							  </div>
                              <hr>
							  
                              <div class="single-product-component mt-15 pb-2">
                                 <div class="size row align-items-top">
                                    <div class="col-lg-8 col-8">
                                       <?php $all_sizes =$size_array; $emptystock = 0; ?>
                                       <h6 class="col-lg-6 size-chart">Size: <span id="ProductSize"></span></h6>
                                       <form class="col-lg-6" action="#">
                                          @foreach($all_sizes as $attrkey=> $attribute)
                                          <?php  $stock = ProductAttribute::stock($productdetails['id'],$attribute); ?>
                                          <div class="radio-wrap">
                                             <input type="radio" id="{{$attribute}}" name="size" value="{{$attribute}}" data-proid="{{ $productdetails['id'] }}"  data-catid="{{ $productdetails['category']['id'] }}" page-type="listing">
                                             <label for="{{$attribute}}" class="active">{{$attribute}}</label>
                                          </div>
                                          @endforeach   
                                       </form>
                                       <input type="hidden" id="listing-product_size">
                                    </div>
                                     @if(!empty($size_chart))
                                    <div class="col-lg-4 col-4 text-end">
							                 <a  class="btn size-chart-btn" data-toggle="modal" data-target="#sizechart"> Size Chart</a>
                                     </div>
                                   @endif
                                 </div>
                              </div>
                              <hr>
							   
                              <div class="row align-items-center justify-content-between single-product-component">
                                 
                                 <div class="col-lg-6 col-6 pl-4">
                                    <h6 class="col-lg-2">Quantity:</h6>
                                    <div class="quantity">
                                       <button class="minus" aria-label="Decrease">&minus;</button>
                                       <input type="number" class="input-box product-qty" id="listing-qty" name="qty" value="1">
                                       <button class="plus" aria-label="Increase">&plus;</button>
                                    </div>
                                 </div>
                                 <div class="col-lg-6 col-6 wishlist-ul">
                                    <ul>
                                       <li>
                                         <a href="javascript:void(0)" class="addWishList" data-productid="{{ $productdetails['id'] }}" page-type="listing">
                                                   <span class="wishlist-wrap">
                                                      <i class="far fa-heart"></i>
                                                   </span>
					                           </a>
                                       </li>
                                    </ul>
                                 </div>
                                 
                              </div>
							  
                              <hr>
                              <div class="accordion pt-3" id="accordionExample">
                                 <div class="accordion-item">
                                    <h2 class="accordion-header">
                                       <button class="accordion-button show" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                       Description
                                       </button>
                                    </h2>
                                    <div id="collapseOne" class="accordion-collapse show collapse" data-bs-parent="#accordionExample">
                                       <div class="accordion-body">
                                          <div class="single-product-category">
                                             <ul>
                                                <li class="single-product-component">
                                                   <h6>Categories:</h6>
                                                </li>
                                                <li class="mb-0"><a class="pr-cat-ds" href="{{ url($productdetails['category']['seo_unique']) }}">{{ $productdetails['category']['name'] }}</a></li>
                                             </ul>
                                          </div>
                                          <div class="single-product-component">
                                             <h6>Product Code: <span class="color-value">{{ $productdetails['product_code'] }}</span></h6>
                                          </div>
                                          @if($productdetails['fabric_description'] != '')
                                          <div class="single-product-component">
                                             <h6>Fabric Description: <span class="color-value"><?php echo  $productdetails['fabric_description']; ?></span></h6>
                                          </div>
                                          @endif
                                       </div>
                                    </div>
                                 </div>
                               <?php /*  <div class="accordion-item">
                                    <h2 class="accordion-header">
                                       <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                       Policy &amp; Return
                                       </button>
                                    </h2>
                                    <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                                       <div class="accordion-body">
                                          All prices, unless indicated otherwise are in Indian Rupees. In a credit card transaction, you must use your own credit card. Rage will not be liable for any credit card fraud. In case of non-delivery, unsatisfactory or delayed performance of services or damages or delays will be dealt by the management and all efforts towards peaceful settlement will be entertained. Orders will be delivered within 10 days of receipt of payment. Complaints, dis-satisfaction will be sensitively tended to. If you happen to find defect/s in products, we will be happy to exchange it after due verification of the nature/cause/circumstances of the damage/injury and if the evidences support the defective nature of the garment.
                                       </div>
                                    </div>
                                 </div> */ ?>
                              </div>
                              <input type="hidden" name="action">
                              <div class="quick-quantity">
                                 <button type="submit" data-toggle="modal" data-target="#notifyme"  class="list-add-cart-btn listing-notify outofstock outofstock-btn" page-type="listing">Let me know when it's back in stock  </button> 
                                 <div class="row justify-content-between">
                                    <div class="col-lg-6 col-md-6 col-6">
                                       <button type="submit" data-cart-type="cart" class="btn-cart addCart" data-product-id="{{ $productdetails['id'] }}" page-type="listing">
                                       Add To Cart
                                       </button>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-6">
                                       <button type="submit" data-cart-type="buy" class="btn-cart2 buynow-btn addCart" data-product-id="{{ $productdetails['id'] }}" page-type="listing">
                                       Buy Now
                                       </button>
                                    </div>
                                 </div>
                              </div>
                              <div class="alert-message alert alert-danger listing-error-msg print-error-msg" style="margin-top:10px">
                                 <ul class="mb-0"></ul>
                              </div>
                              <div class="alert-message alert alert-success listing-success-msg print-success-msg" style="margin-top:10px">
                                 <ul class="mb-0"></ul>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   @if(!empty($get_related_products))
   <!-- <div class="container-fluid products detail-products" data-aos="">
      <div class="row">
         <div class="col-md-12">
            <h3>Related Products</h3>
            <div id="related-product" class="owl-carousel owl-carousel1">
               @foreach($get_related_products as $key=> $product)
               <?php 
                  $productimages = $product['productimages'];
                  $product_image = '';
                  if(!empty($productimages)){
                          $product_image= $productimages[0]['image'];
                  }
                  ?>
               <div class="product-slide">
                  <div class="product-img">
                     @if(!empty($product_image))
                      <a href="{{url('/product/'.$product['seo_url']) }}">
                     <img src="{{ asset('images/ProductImages/large/'.$product_image) }}" alt="{{ $product['product_name'] }} " title="{{ $product['product_name'] }} ">
                     </a>
                     @endif
                  </div>
                  <div class="product-content">
                     <a href="{{ url('/product/'.$product['seo_url']) }}" class="product-title">{{ $product['product_name'] }} </a>
                     <span class="product-prize">INR {{ Product::ProductPrice($product['category_id'],$product) }} 
                     @if($product['current_discount'] == 'product' || $product['current_discount'] == 'category')
                     <span class="cut-price" style=" text-decoration: line-through;">INR {{round(CustomFunction::formatAmt($product['product_price']))}} </span>
                     @endif
                     </span>
                     <div class="listing-btns">
                        <a href="{{ url('/product/'.$product['seo_url']) }}" class="read-more">Add To Cart</a>
                     </div>
                  </div>
               </div>
               @endforeach
            </div>
         </div>
      </div>
   </div> -->
   @endif

   <hr>
    @if(!empty(count($get_related_products)))
   <!-- related products -->
   <div class="container-fluid products relatedItems" data-aos="fade-up">
	  <div class="row">
	    <div class="col-md-12">
	      <h3 class="title-head">Related Products</h3>

	      <div id="news-slider" class="owl-carousel">
	        
          @foreach($get_related_products as $key=> $product)
           <?php
				    $product_image = '';
				    if(!empty($product['product_image'])){
				        $product_image= $product['product_image']['image'];
				    }

               if($product['current_discount'] == 'product' || $product['current_discount'] == 'category'){  
                  if($product['current_discount'] == 'product'){
                     $discount_percentage = $product['product_discount'];
                  }else{
                     $discount_percentage = $product['category']['category_discount'];
                  }
               }
               
					?>
          <div class="product-slide">
	          <div class="product-img">
				  
               @if(!empty($discount_percentage))  <span class="offprice">{{ $discount_percentage }}% Off</span> @endif
	            <a href="{{url('/product/'.$product['seo_url']) }}">
                  @if(!empty($product_image))
                  <img src="{{ asset('images/ProductImages/large/'.$product_image)}}?v=1.0"  alt="{{ $product['product_name'] }}" title="{{ $product['product_name'] }}" />
                  @else
                  <img src="{{asset('images/no-image-found.jpg')}}"  alt="{{ $product['product_name'] }}" title="{{ $product['product_name'] }}" width="600" height="778" style="height: 364px;" />
                  @endif
               </a>
	          </div>
	          <div class="product-content">
		            <a href="{{url('/product/'.$product['seo_url']) }}" class="product-title">{{ $product['product_name'] }}</a> 
					  @if($product['current_discount'] == 'product' || $product['current_discount'] == 'category') 
						<span class="product-prize">INR {{ Product::ProductPrice($product['category_id'],$product) }} <span class="cut-price" style=" text-decoration: line-through;">INR {{round(CustomFunction::formatAmt($product['product_price']))}} </span>
					    </span>
					  @else
						 <span class="akasha-Price-currencySymbol">INR &nbsp;</span>{{ Product::ProductPrice($product['category_id'],$product) }}  
					  @endif 
					  
					  
					  @if($product['current_discount'] == 'product' || $product['current_discount'] == 'category')    
							  <?php
								  if($product['current_discount'] == 'product'){
									 $discount_percentage = $product['product_discount'];
								  }else{
									 $discount_percentage = $product['category']['category_discount'];
								  }
							  ?>
							  <span class="badge bg-dark ms-2">{{$discount_percentage}}% OFF</span>
						  @endif
					  
					  
						<button <?php /* data-bs-toggle="offcanvas" data-bs-target="#productOffcanvas" aria-controls="productOffcanvas" */ ?> data-product-seo_url="{{ $product['seo_url'] }}" class="btn-quickview"  title="Quick View">
							<svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="22" height="22" x="0" y="0" viewBox="0 0 32 32" style="enable-background:new 0 0 512 512" xml:space="preserve"><g><path d="M24 8h-2a6 6 0 0 0-12 0H8a3 3 0 0 0-3 3v14a5.006 5.006 0 0 0 5 5h12a5.006 5.006 0 0 0 5-5V11a3 3 0 0 0-3-3zm-8-4a4 4 0 0 1 4 4h-8a4 4 0 0 1 4-4zm9 21a3 3 0 0 1-3 3H10a3 3 0 0 1-3-3V11a1 1 0 0 1 1-1h2v2a1 1 0 0 0 2 0v-2h8v2a1 1 0 0 0 2 0v-2h2a1 1 0 0 1 1 1z" data-name="Layer 2" fill="#000000" opacity="1" data-original="#212121"></path></g></svg>
						</button> 
					</div>
				
	        </div>
          @endforeach
	       
         
         </div>
	    </div>
	  </div>
	</div>
   <!-- related products end-->
    @endif
   <hr>

  @include('front.listings.product-reviews')

</main>




<!-- Notify model start -->
<div class="modal fade" id="notifyme" role="dialog">
   <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title">Notify Me</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
         </div>
         <div class="modal-body">
            <div id="notify_msg"></div>
            <form action="javascript:;" method="post" id="notify">
               @csrf
               <div class="form-group">
                  <label for="name">Size:</label>
                  <select name="notifysize" id="notifysize" class="form-control">
                     @foreach($all_sizes as $attrkey=> $attribute)
                     <?php  $stock = ProductAttribute::stock($productdetails['id'],$attribute); ?>
                     @if(!$stock) 
                     <option value="{{ $attribute }}" >
                        {{ $attribute }}
                     </option>
                     @endif
                     @endforeach
                  </select>
               </div>
               <div class="form-group">
                  <label for="name">Name:</label>
                  <input type="hidden" name="notifycode"  id="notifycode" value="{{ $productdetails['product_code'] }}">
                  <input type="text" class="form-control" id="name" name="name" required>
               </div>
               <div class="form-group">
                  <label for="email">Email:</label>
                  <input type="email" class="form-control" id="email" name="email" required>
               </div>
               <div class="form-group">
                  <label for="email">Mobile:</label>
                  <input type="text" class="form-control" id="mobile" name="mobile">
               </div>
			   <input type="hidden" name="g-recaptcha-response" id="g-recaptcha-response">
               <button type="submit" class="btn btn-default size-chart-close-btn mt-3">Submit</button>
            </form>
         </div>
      </div>
   </div>
</div>
<!-- Notify model end --> 
@if(!empty($size_chart))
<!-- Sizechart model start -->
<div class="modal fade" id="sizechart" role="dialog">
   <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title">Size Chart</h4>
            <button type="button" class="close" data-dismiss="modal" style="padding: 1rem;
    margin: -1rem -1rem -1rem auto;font-size: 1.5rem;border: none;">&times;</button>
         </div>
         <div class="modal-body m-0">
            <div class="modal-body size1" style="display:block">
               <img src="{{ asset('images/SizeCharts/'.$size_chart) }}" class="img-fluid" alt="" title="" />
            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
               <button type="button" class="btn btn-danger size-chart-close-btn" data-dismiss="modal">Close</button>
            </div>
         </div>
      </div>
   </div>
</div>
<!-- Sizechart model end --> 
@endif
@stop
@section('javascript')
@parent
<script type="text/javascript" src="{{ asset('js/ajax_jquery.min.js')}}"></script>
<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha384-tsQFqpEReu7ZLhBV2VZlAu7zcOV+rXbYlF2cqB8txI/8aZajjp4Bqd+V6D5IgvKT" crossorigin="anonymous"></script>
<script src="https://www.google.com/recaptcha/api.js?render={{ env('RECAPTCHA_SITE_KEY') }}" async defer></script>

<script>
   $(document).ready(function() {
       $('.social-media-share').click(function(e) { 
           e.preventDefault();
           window.open($(this).attr('href'), 'fbShareWindow', 'height=450, width=550, top=' + ($(window).height() / 2 - 275) + ', left=' + ($(window).width() / 2 - 225) + ', toolbar=0, location=0, menubar=0, directories=0, scrollbars=0');
           return false;
       });
	   
	   
	     $(document).on("submit", "#save-review", function(e){ 
                e.preventDefault();
				$('.PleaseWaitDiv').show();
				var formdata = $("#save-review").serialize();
				$.ajax({
					url: "/save-review",
					type:'POST',
					dataType: "JSON",
			        data: new FormData(this),
					processData: false,
			        contentType: false,
					success: function(data) {
						$('.PleaseWaitDiv').hide();
						$('.error-message').html('');
						if(!data.status){
							if(data.type=="validation"){
								var err_no = 0;
								$.each(data.errors, function (i, error) {
									err_no = err_no + 1;
									$('#review-'+i).attr('style', 'color:red!important');
									$('#review-'+i).html(error);
									if(err_no  == 1) { $('#con-'+i).focus(); }
									setTimeout(function () {
										$('#review-'+i).css({
											'review': 'none'
										});
									}, 5000);
								});
							}
						}else{
							   $("#previewContainer").html('');
							   $('#save-review').trigger('reset'); 
							   alert(data.message);
						}
					}
				});
         });
	   
	   
	   
	   
	    
   $(document).on('submit','#notify',function(e){ 

	
	grecaptcha.execute("{{ env('RECAPTCHA_SITE_KEY') }}")
		.then(function(token) {
			// Set the token to the hidden input field
			$('#g-recaptcha-response').val(token);
			// Submit the form via AJAX
			$.ajax({
				url: "/save-notify", // form action URL
				type: "POST",                 // method
				data:  $("#notify").serialize(), // serialize form data including g-recaptcha-response
				 success: function(data) {
                  $('.PleaseWaitDiv').hide();
                  if(data.status){
                      $('#notify_msg').attr('style', '');
                      $('#notify_msg').html('<div role="alert" class="alert alert-success alert-dismissible"> <button aria-label="Close" data-dismiss="alert" style="text-indent: 0;" class="close" type="button"><span aria-hidden="true"></span></button>Your infomation has been submitted successfully. We will get back to you soon.</div>');
                      setTimeout(function () {
                          $('#notify')[0].reset();
                          $('#notify_msg').empty();
                          $('#notifyme').modal('hide');
                      }, 3000);
                      
                  }else{
					  alert(data.message);
				  }
                 },
				error: function(xhr, status, error) {
					$('.PleaseWaitDiv').hide();
				}
			});
		});

});

   
   
   
   
   
   
   
   
   
   
   
   
	   
	   
	   
	   
	   
	   
	   
	   
	   
   });
 
   function cartitems_Ajax(){ 
     $.ajax({
       url : "/cart-items-ajax",
       type : "get",
       success:function(resp){
         $('#cartdata').html(resp.view);
       },
       error:function(){
   
       }
     })
   }
   
   function get_pincode_details(){
     
     var pincode = $('#pincode').val();
     $.ajax({
               url: "/get-pincode-details",
               type:'POST',
               data:{pincode:pincode,_token:"{{csrf_token()}}"},
               success: function(data) {
                   $('.PleaseWaitDiv').hide();
                   if(!data.status){
               
               alertclasss ="danger";
             }else{
             
               alertclasss ="success";
             }
             
             if(data.message !=""){
               $('#pincode_msg').html('<div class="alert alert-'+alertclasss+' alert-dismissible"><button type="button" class="close" data-dismiss="alert">&times;</button><span>'+data.message+'</span></div>');
             }
               }
           }); 
     
   }
</script>
<script type="text/javascript">
  
   $(document).on('click','#BuyNow',function(){
     $('[name=action]').val('buy');
   })
   $("#pincode").keyup(function(event) {
   if (event.keyCode === 13) {
       $("#pincode-check").click();
   }
   });
   
   function isNumberKey(evt){ 
    var charCode = (evt.which) ? evt.which : evt.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57)){
        return false;
   }else{
   return true;
   }
    
   }
   
</script>
<script>
   $(document).ready(function() {
      var gridShowing = false;
   
   
      $('.prod-pics-sect').remooz({
         debug: true,
         zoomPool: '.main-prod-cont',
         srcRegexp: '/450x600/',
         srcStrReplace: '1500x2000'
      });
   
      //Hide/display grid
      $(window).on('keypress', function(e){
         if(e.shiftKey && e.ctrlKey && (e.charCode === 1 || e.charCode === 65)) {
            $('#grid-container').toggleClass('hidden');
            gridShowing = true;
         }
         if(gridShowing && e.charCode === 0) {
            $('#grid-container').addClass('hidden');
            gridShowing = false;
         }
      });
   });
</script>
@stop