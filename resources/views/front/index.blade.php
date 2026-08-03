@extends('layouts.frontLayout.front-layout')
@section('content')
<?php use App\CustomFunction; use App\Wishlist; use App\Product; 

?>

<style>.rage-store-locator a:hover  { color:#ffffff!important; }</style>
<main class="homeMain">
	<div class="container-fluid p-0" data-aos="fade-right">
		<div class="row">
			<div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
				<div class="carousel-inner">

					<div class="carousel-item active">
					<a href="{{ url('cardigans') }}">
						<img src="{{ asset('images/banners/2025.1.jpg') }}" class="d-md-block d-none w-100" alt="winter collection" title="winter collection"> <!-- desktop -->
						<img src="{{ asset('images/banners/2025.1m.jpg') }}" class="d-block d-md-none w-100" alt="winter collection" title="winter collection"> <!-- mobile -->
					</a>
					</div>

					<div class="carousel-item">
					<a href="{{ url('cardigans') }}">
						<img src="images/banners/2025.2.jpg" class="d-md-block d-none w-100" alt="winter collection" title="winter collection"> <!-- desktop -->
						<img src="images/banners/2025.2m.jpg" class="d-block d-md-none w-100" alt="winter collection" title="winter collection"> <!-- mobile -->
					</a>
					</div>

				</div>

				<!-- Controls -->
				<button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
					<span class="carousel-control-prev-icon" aria-hidden="true"></span>
					<span class="visually-hidden">Previous</span>
				</button>

				<button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
					<span class="carousel-control-next-icon" aria-hidden="true"></span>
					<span class="visually-hidden">Next</span>
				</button>
			</div>
		</div>
	</div>
	@if(count($new_arrival_products) > 0)
	<div class="container products" data-aos="fade-up">
	  <div class="row">
	    <div class="col-md-12 col-6">
	      <h3 class="title-head">Discover What’s Next</h3>

	      <div id="news-slider" class="owl-carousel">
	        
			@foreach($new_arrival_products as $product)
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
						<span class="product-prize">INR {{ Product::ProductPrice($product['category_id'],$product) }} <span class="cut-price" style=" text-decoration: line-through;">INR {{round(CustomFunction::formatAmt($product['product_price']))}} </span> @endif </span>
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
	@endif
	
	
	
	
	
	
	
	
	
	<h3 class="title-head mb-3">Shop by Category</h3>
	<div class="sticky-section categories-section" data-aos="fade-up">
		<div class="row d-none d-md-flex">
			 <!-- Tabs Navigation -->
			<!-- <div class="categories-tabs d-none d-md-flex">
				<button class="tab-btn active" data-tab="0">Co-ord</button>
				<button class="tab-btn" data-tab="1">Kurtis</button>
				<button class="tab-btn" data-tab="2">Poncho</button>
				<button class="tab-btn" data-tab="3">Cardigans</button>
				<button class="tab-btn" data-tab="4">Tops</button>
			</div> -->

			<div class="categories-tabs d-none d-md-flex">
				@foreach($categories as $category)
					@if($category['id'] == 15)
						@foreach($category['subcategories'] as $cat_key=>$sub_category)
						<button class="tab-btn @if($cat_key == 0) active @endif" data-tab="{{ $cat_key }}">{{ $sub_category['name'] }}</button>
						@endforeach
			        @endif
				@endforeach
			</div>
			<!-- Left Sticky Image -->
			<div class="col-6  image-col">
			<div class="image-box">
				@foreach($categories as $category)
					@if($category['id'] == 15)
						@foreach($category['subcategories'] as $cat_key=>$sub_category)
							<img src="{{ asset('images/CategoryImages/'.$sub_category['image']) }}" alt="Image {{ $cat_key+1 }}" class="sticky-img @if($cat_key == 0) active @endif">
						@endforeach
					@endif
				@endforeach
			</div>
			</div>

			<!-- Right Scroll Content -->
			
			<div class="col-6  content-col">
			@foreach($categories as $category)
				@if($category['id'] == 15)
					@foreach($category['subcategories'] as $cat_key=>$sub_category)
					<div class="content-block" data-image="0">
						<h2>{{ $sub_category['name'] }}</h2>
						<p>@php echo $sub_category['description']; @endphp</p>
						<a href="{{ url($sub_category['seo_unique']) }}" class="btn-bg">Shop Now</a>
					</div>
					@endforeach
				@endif
			@endforeach
			</div>
		</div>

		<div id="categoriesCarousel" class="carousel slide d-block d-md-none" data-bs-ride="carousel">
			<!-- Dots -->
			<div class="carousel-indicators">
				@foreach($categories as $category)
					@if($category['id'] == 15)
						@foreach($category['subcategories'] as $cat_key=>$sub_category)
							<button type="button" data-bs-target="#categoriesCarousel" data-bs-slide-to="{{ $cat_key }}" @if($cat_key == 0) class="active" @endif></button>
						@endforeach
					@endif
			    @endforeach
			</div>

			<!-- Slides -->
			<div class="carousel-inner">
               
				@foreach($categories as $category)
					@if($category['id'] == 15)
						@foreach($category['subcategories'] as $cat_key=>$sub_category)
						 <div class="carousel-item @if($cat_key == 0) active @endif">
								<div class="row">
									<div class="col-md-6 image-col">
									<img src="{{ asset('images/CategoryImages/'.$sub_category['image']) }}"   class="d-block w-100" title="{{ $sub_category['name'] }}" alt="{{ $sub_category['name'] }}">
									</div>
									<div class="col-md-6 content-col d-flex flex-column justify-content-center">
									<h2>{{ $sub_category['name'] }}</h2>
									<p>@php echo $sub_category['description']; @endphp</p>
									<a href="{{ url($sub_category['seo_unique']) }}" class="btn-bg">Shop Now</a>
									</div>
								</div>
						</div>
					@endforeach
					@endif
			    @endforeach
				


				
				

				

			</div>
		</div>
    </div>


<!-- 
	<div class="container luxe-section" data-aos="fade-up">
		<div class="row">
			<div class="col-md-6 col-12 luxe-content" data-aos="fade-left">
				<span>Rage Luxe</span>
				<h3>Premium Collection</h3>
				<p>Rage Luxe brings you timeless elegance with premium fabrics and refined designs. A collection that defines sophistication for every occasion</p>
				<a href="#" class="btn-cart">Shop Now</a>
			</div>
			<div class="col-md-6 col-12 luxe-img" data-aos="fade-left">
				<a href="{{ url('rage-luxe') }}"><img src="images/rage-luxe.jpg" class="img-fluid" alt="Rage Luxe" title="Rage Luxe"></a>
			</div>
		</div>
	</div> -->
    @if(count($best_seller_products) > 0)
	<div class="container products" data-aos="fade-up">
	  <div class="row">
	    <div class="col-md-12">
	      <h3 class="title-head">Festive Wear</h3>

	      <div id="news-slider1" class="owl-carousel">
	        
			@foreach($best_seller_products as $product)
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
						<span class="product-prize">INR {{ Product::ProductPrice($product['category_id'],$product) }} <span class="cut-price" style=" text-decoration: line-through;">INR {{round(CustomFunction::formatAmt($product['product_price']))}} </span> @endif </span>
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
     @endif
	 
	<div class="container-fluid p-0" data-aos="fade-right">
		<a href="{{ url('rage-luxe') }}"><img src="images/luxe25.jpg" class="img-fluid" alt="Premium Collection" title="Premium Collection"></a>
	</div>

	<div class="container luxe-section store-locator" data-aos="fade-up">
	<div class="row">
		<h3 class="mb-3 title-head">Store Locator</h3>
		<div class="col-md-12 col-12 luxe-img" data-aos="fade-left">
			<a href="{{ url('rage-luxe') }}"><img src="images/location.jpg" class="img-fluid" alt="Store Locator" title="Store Locator"></a>
		</div>
		<div class="col-md-12 col-12 luxe-content" data-aos="fade-left">
			<div class="store-content">
				<a href="{{ url('store-locator') }}" class="btn-cart2 rage-store-locator">Find Your Nearest Store</a>
				</div>
		</div>
	</div>
</div>

	<!-- <div class="container-fluid p-0 brands" data-aos="fade-up">
		<div class="row">
			 <h3 class="title-head" data-aos="fade-left">The Faces Behind Our Story</h3>
			<img src="images/brand.jpg" alt="brand ambassador" class="img-fluid d-none d-md-block">
			<img src="images/brand.jpg" alt="brand ambassador" class="img-fluid d-block d-md-none">
		</div>
	</div> -->

	<!-- <div class="container-fluid mainBanner" data-aos="fade-left">
		<div class="row">
            <video class="responsive video-autoplay" autoplay loop muted playsinline>
				<source src="images/new-25.mp4" type="video/mp4">
			</video>
			<div class="video-text">
				<p>New Season, New You</p>
				<h4>Step Ahead in Fashion</h4>
				<a href="#">Shop Now</a>
			</div>
		</div>
	</div> -->

<div class="container-fluid celebs-video">
	<div class="row">
		<div class="col-md-7 col-12">
			<div class="mainBanner" data-aos="fade-left">
				<video class="responsive video-autoplay" autoplay loop muted playsinline>
					<source src="images/new-25.mp4" type="video/mp4">
				</video>
				<!-- <div class="video-text">
					<p>New Season, New You</p>
					<h4>Celebs in Rage</h4>
					<a href="#">Shop Now</a>
				</div> -->
			</div>
		</div>
		<div class="col-md-5 col-12 celebs-img">
			<h3>Celebs in Rage</h3>
			<div id="lookbook" class="owl-carousel">
				<div class="product-slide">
				<div class="product-img">
					<img src="img/lookbook/ba1.jpg" alt="img" title="img">
				</div>
				<div class="product-content">
					<a href="javascript:;" class="product-title">Katrina Kaif</a>
				</div>
				</div>

				<div class="product-slide">
				<div class="product-img">
					<img src="img/lookbook/ba2.jpg" alt="img" title="img">
				</div>
				<div class="product-content">
					<a href="Jacqueline:;" class="product-title">Jacqueline Fernandez</a>
				</div>
				</div>

				<div class="product-slide">
				<div class="product-img">
					<img src="img/lookbook/ba3.jpg" alt="img" title="img">
				</div>
				<div class="product-content">
					<a href="javascript:;" class="product-title">Urvashi Sharma</a>
				</div>
				</div>

				<div class="product-slide">
				<div class="product-img">
					<img src="img/lookbook/ba4.jpg" alt="img" title="img">
				</div>
				<div class="product-content">
					<a href="javascript:;" class="product-title">Giselle Monterio</a>
				</div>
				</div>

				<div class="product-slide">
				<div class="product-img">
					<img src="img/lookbook/ba5.jpg" alt="img" title="img">
				</div>
				<div class="product-content">
					<a href="javascript:;" class="product-title">Amyra Dastur</a>
				</div>
				</div>

	        </div>
		</div>
	</div>
</div>





</main>

@stop
@section('javascript')
@parent 

@stop