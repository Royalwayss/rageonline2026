<?php use App\CustomFunction;   use App\Product; ?>

 <div class="row p-0 m-0  product-listing grid-3" data-aos="fade-right">
           	    @if(count($getproducts) > 0) @foreach($getproducts as $key=> $product)
			   <div class="product-slide  col-12 col-md-4 mb-4">
		          <?php
				    $product_image = '';
				    if(!empty($product['product_image'])){
				        $product_image= $product['product_image']['image'];
				    }
					?>
				  <div class="product-img">
                    <a href="{{url('/product/'.$product['seo_url']) }}">
					@if(!empty($product_image))
					<img src="{{ asset('images/ProductImages/large/'.$product_image)}}?v=1.0" class="w-100" alt="{{ $product['product_name'] }}" title="{{ $product['product_name'] }}" />
					@else
					<img src="{{asset('images/no-image-found.jpg')}}" class="w-100" alt="{{ $product['product_name'] }}" title="{{ $product['product_name'] }}" width="600" height="778" style="height: 364px;" />
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
		          <!-- <div class="product-content">
		            <a href="{{url('/product/'.$product['seo_url']) }}" class="product-title">{{ $product['product_name'] }}</a>
		             @if($product['current_discount'] == 'product' || $product['current_discount'] == 'category')
                                
								<span class="product-prize">INR {{ Product::ProductPrice($product['category_id'],$product) }}  <span class="cut-price" style=" text-decoration: line-through;">INR {{round(CustomFunction::formatAmt($product['product_price']))}}  </span></span>
                    
                                @else
                                <span class="akasha-Price-amount amount">
                                    <span class="akasha-Price-currencySymbol">INR &nbsp;</span>{{ Product::ProductPrice($product['category_id'],$product) }} 
                                </span>
								
                                @endif
					
					<div class="listing-btns">
                        <a href="{{url('/product/'.$product['seo_url']) }}" class="read-more">Add To Cart</a>
                    </div>
		          </div> -->
	           </div>
	         @endforeach 


			@else
				<div class="col-12 text-center pt-5 pb-5">
					<i class="fa fa-exclamation-circle fa-4x orange"></i>
					<h4 class="mt-4 mb-4">No products Found</h4>
				</div>
			@endif 
       
		   
		   </div>

