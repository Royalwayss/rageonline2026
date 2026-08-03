<?php
use APP\Product; 
use App\CustomFunction; 
use App\ProductAttribute; 


$all_sizes = [];
if(is_array($product['pro_attrs'])){
      if(count($product['pro_attrs'])>0){
         foreach($product['pro_attrs'] as $key=> $pro_attrs){  
            $all_sizes[] = $pro_attrs['size'];
         }
      }
   }
?>

<div class="offcanvas-header justify-content-end">
      <button type="button" class="btn closeBtn" id="productOffcanvascloseBtn" data-bs-dismiss="offcanvas" aria-label="Close">
		<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
		<path d="M18 6L6 18M6 6l12 12" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
		</svg>
	</button>
  </div>

<div class="offcanvas-body">
    <!-- Product Image -->
   <div id="carouselExampleIndicators1" class="carousel slide mb-3" data-bs-ride="carousel">
		@if(count($product['productimages']))
       <div class="carousel-indicators">
            @foreach($product['productimages']  as $img_key => $image)
			<button type="button" data-bs-target="#carouselExampleIndicators1" data-bs-slide-to="{{ $img_key }}" @if($img_key == 0) class="active" @endif aria-current="true" aria-label="Slide 1"></button>
			@endforeach
		</div>
		<div class="carousel-inner">
		    
           @foreach($product['productimages']  as $img_key => $image)
            <div class="carousel-item @if($img_key == 0) active @endif">
			    <img src="{{ asset('images/ProductImages/large/'.$image['image'])}}" class="d-block w-100" alt="rage product">
			</div>
			@endforeach
		</div>
        @endif
	</div>

    <!-- Price -->
	<a href="{{url('/product/'.$product['seo_url']) }}" class="productHeading">{{ $product['product_name'] }}</a>
    <p class="single-product-price">
      <span class="product-prize">INR {{ Product::ProductPrice($product['category_id'],$product) }}  @if($product['current_discount'] == 'product' || $product['current_discount'] == 'category') <span class="cut-price" style=" text-decoration: line-through;">INR {{round(CustomFunction::formatAmt($product['product_price']))}} </span> @endif </span>
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
    </p>

    <!-- Sizes -->
    <div class="mb-3 sizes-btn">
      <div class="popup-headings">Sizes</div>
      <div class="btn-group flex-wrap" role="group">
        
      @foreach($all_sizes as $attrkey=> $attribute)
        <input type="radio" class="btn-check" name="size" id="size{{$attribute}}" value="{{$attribute}}" data-proid="{{ $product['id'] }}"  data-catid="{{ $product['category']['id'] }}" page-type="popup" >
        <label class="btn btn-outline-dark" for="size{{$attribute}}">{{$attribute}}</label>
      @endforeach   
        
      </div>
    </div>
    <input type="hidden" id="popup-product_size">
    <hr>
	<div class="row">
	 <div class="single-product-component col-9">
		<div class="popup-headings">Quantity</div>
		<div class="quantity">
		<button class="minus" aria-label="Decrease" onclick="decreaseValue('popup');" >&minus;</button>
		<input type="number" class="input-box product-qty" value="1" min="1" id="popup-qty">
		<button class="plus" aria-label="Increase" onclick="increaseValue('popup');" >&plus;</button>
	  </div>
                                       <button type="submit" data-toggle="modal" data-target="#notifyme"  class="list-add-cart-btn outofstock popup-notify outofstock-btn">Let me know when it's back in stock  </button> 

	 </div>
	 	<div class="wishlist-ul col-3">
			<ul>
				<li>
					<a href="javascript:void(0)" class="addWishList" data-productid="{{ $product['id'] }}" page-type="popup">
					    <span class="wishlist-wrap">
					      <i class="far fa-heart"></i>
              </span>
					</a>
				</li>
			</ul>
		</div>
	</div>
    <hr>
    <!-- Description -->
    <!-- <p class="small">
      Celebrate in style with our green beige kurta set, designed to bring elegance to your festive wardrobe.
      Dupatta shown in the image is for styling purposes only.
    </p> -->


  </div>

	<!-- Add to Cart -->
	<div class="newBtns">
		<button class="btn-cart addCart" data-product-id="{{ $product['id'] }}" page-type="popup">ADD TO CART</button>
		<hr>
		<a href="{{url('/product/'.$product['seo_url']) }}" class="detail-btn">View Detail</a>
	</div>
  <div class="alert-message alert alert-danger popup-error-msg print-error-msg" style="margin-top:10px">
                                 <ul class="mb-0"></ul>
                              </div>
                              <div class="alert-message alert alert-success popup-success-msg print-success-msg" style="margin-top:10px">
                                 <ul class="mb-0"></ul>
                              </div>
	
