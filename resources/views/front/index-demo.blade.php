@extends('layouts.frontLayout.front-layout')
@section('content')
<?php use App\CustomFunction; use App\Wishlist; use App\Product; 

error_reporting(0);
?>

<style>
    a.amb-name {
        text-align: center;
    }
</style>


<!-- -------------Social Icons Start------------ -->

<div class="hm-social-icons">
    <ul>
        <li class="fb-iconn"><a class="inner-icons" href="https://www.facebook.com/rageindiaonline" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
        <li class="insta-iconn"><a class="inner-icons" href="https://www.instagram.com/rageindiaonline/" target="_blank"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
    </ul>
</div>

<!-- -------------Social Icons End------------ -->


<section class="mainn-banner">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 p-0">
                <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                  <div class="carousel-inner">
                      
                   
                    
					
					
					<div class="carousel-item active">
                        <a href="{{ url('summercollection') }}">
                          <picture>
                            <source media="(max-width:767px)" srcset="img/banner/rage-banner-mob-img1.jpg" width="100%">
                            <source media="(max-width:1024px)" srcset="img/banner/rage-banner-img1.jpg" width="100%">
                            <source media="(min-width:1024px)" srcset="img/banner/rage-banner-img1.jpg" width="100%">
                            <img src="<?php echo asset('/'); ?>img/banner/rage-banner-img1.jpg" alt="Banner">
                          </picture>
                        </a>
                    </div> 
					
					
					<div class="carousel-item">
                        <a href="{{ url('summercollection') }}">
                          <picture>
                            <source media="(max-width:767px)" srcset="img/banner/rage-banner-mob-img2.jpg" width="100%">
                            <source media="(max-width:1024px)" srcset="img/banner/rage-banner-img2.jpg" width="100%">
                            <source media="(min-width:1024px)" srcset="img/banner/rage-banner-img2.jpg" width="100%">
                            <img src="<?php echo asset('/'); ?>img/banner/rage-banner-img2.jpg" alt="Banner">
                          </picture>
                        </a>
                    </div> 
					
					<div class="carousel-item">
                        <a href="{{ url('summercollection') }}">
                          <picture>
                            <source media="(max-width:767px)" srcset="img/banner/rage-banner-mob-img3.jpg" width="100%">
                            <source media="(max-width:1024px)" srcset="img/banner/rage-banner-img3.jpg" width="100%">
                            <source media="(min-width:1024px)" srcset="img/banner/rage-banner-img3.jpg" width="100%">
                            <img src="<?php echo asset('/'); ?>img/banner/rage-banner-img3.jpg" alt="Banner">
                          </picture>
                        </a>
                    </div> 
					
                    
                    <div class="carousel-item">
                        <a href="{{ url('summercollection') }}">
                          <picture>
                            <source media="(max-width:767px)" srcset="img/banner/rage_mobile_banner.png" width="100%">
                            <source media="(max-width:1024px)" srcset="img/banner/rage_banner.png" width="100%">
                            <source media="(min-width:1024px)" srcset="img/banner/rage_banner.png" width="100%">
                            <img src="<?php echo asset('/'); ?>img/banner/rage_banner.png" alt="Banner">
                          </picture>
                        </a>
                    </div> 
                    
                    <div class="carousel-item">
                        <a href="{{ url('cardigans') }}">
                          <picture>
                            <source media="(max-width:767px)" srcset="img/banner/home-banner-mb.jpg" width="100%">
                            <source media="(max-width:1024px)" srcset="img/banner/banner1.png" width="100%">
                            <source media="(min-width:1024px)" srcset="img/banner/banner1.png" width="100%">
                            <img src="<?php echo asset('/'); ?>img/banner/banner1.png" alt="">
                          </picture>
                        </a>
                    </div>
					
                   
                   
                  </div>
                  <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                  </a>
                  <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                  </a>
                </div>

               <!--  <video src="video/rage.mp4" muted autoplay="true" preload="auto" loop height="100%" width="100%" id="VideoHomePage1" class="videoHome" data-videoHeighter="true">
                    <source type="video/mp4" src="video/rage.mp4">
                </video> -->
            </div>
        </div>
    </div>
</section>


<!-- - --------Product Categories Start-------- -->   

    <section class="category">
        <div class="container">
            <div class="row">
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12 left-category">
                    <div class="category-box">
                        <div class="category-wrapper">
                            <div class="category-img">
                                <a href="{{ url('kaftaan') }}"><img src="<?php echo asset('/'); ?>img/banner/banner-kaftan.jpg" class="w-100" title="Kaftaan" alt="Kaftaan"  ></a>
                            </div>
                            <div class="category-content">
                                <a href="{{ url('kaftaan') }}" class="title">Kaftaan</a><br />
                                <a href="{{ url('kaftaan') }}" class="hm-shop-btn">Shop Now</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                    <div class="row">
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12 ">
                            <div class="row">
                                <div class="col-12 mb-4">
                                    <div class="category-box">
                                        <div class="category-wrapper">
                                            <div class="category-img">
                                               <a href="{{ url('coord') }}">  <img src="<?php echo asset('/'); ?>img/banner/co-ord1.jpg" class="w-100" title="Co-Ord Sets" alt="Co-Ord Sets"></a>
                                            </div>
                                            <div class="category-content">
                                                <a href="{{ url('co-ord') }}" class="title">CO-ORD</a><br />
                                                <a href="{{ url('co-ord') }}" class="hm-shop-btn">Shop Now</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="category-box">
                                        <div class="category-wrapper">
                                            <div class="category-img">
                                               <a href="{{ url('cardigans') }}">  <img src="<?php echo asset('/'); ?>img/banner/cardigan1.jpg" class="w-100" title="Cardigan" alt="Cardigan"></a>
                                            </div>
                                            <div class="category-content">
                                                <a href="{{ url('cardigans') }}" class="title">Cardigans</a><br />
                                                <a href="{{ url('cardigans') }}" class="hm-shop-btn">Shop Now</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12 category-right">
                            <div class="category-box">
                                <div class="category-wrapper">
                                    <div class="category-img">
                                        <a href="{{ url('coord') }}"><img src="<?php echo asset('/'); ?>img/banner/banner-co-ord.jpg" class="w-100" title="CO-ORD" alt="CO-ORD"></a>
                                    </div>
                                    <div class="category-content">
                                        <a href="{{ url('coord') }}" class="title">CO-ORD</a><br />
                                        <a href="{{ url('coord') }}" class="hm-shop-btn">Shop Now</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

<!-- --------Product Categories End-------- -->     

<!-- --------Product Collection Start-------- -->   

    <section class="main-product mt-100">
        <div class="container">
            <ul class="nav nav-pills mb-3">
                <li class="nav-item">
                    <a class="active" data-toggle="pill" href="#main-tab-1">NEW ARRIVAL</a>
                </li>
              <?php /*  <li class="nav-item">
                    <a class="" data-toggle="pill" href="#main-tab-2">Summer Collection</a>
                </li> */ ?>
            </ul>
            <div class="tab-content mt-25">
                <div class="tab-pane fade show active" id="main-tab-1">
                    <div class="main-product-carousel owl-carousel red-nav">
                        
						@foreach($new_arrival_winter_collection_products as $key=> $product)
						<div class="main-product-carousel-item">
                            <div class="col-12">
                                <div class="product-box mb-40">
                                    <div class="product-box-wrapper">
                                        <div class="product-img">
										
										           <?php
												   $productimages = $product['productimages'];
												   $product_image1= '';
												   $product_image2= '';
												   if(!empty($productimages)){
													       $product_image1= $productimages[0]['image'];
													   if(!empty($productimages[1]['image'])){
														   $product_image2= $productimages[1]['image'];
													   }else{
														   $product_image2 = $product_image1;
													   }
												   } //echo "<pre>"; print_r($product); exit;
												   ?>
										
													@if(!empty($product_image1))
														<img src="{{ asset('images/ProductImages/medium/'.$product_image1) }}" class="w-100" alt="">
													@else 
														<img src="{{asset('images/no-image-found.jpg')}}" class="w-100" alt=""> 
													@endif
                                            <a href="{{url('/product/'.$product['seo_url']) }}" class="d-block">
                                                <div class="second-img">
                                                   @if(!empty($product_image2))
                                                        <img src="{{ asset('images/ProductImages/medium/'.$product_image2) }}" class="w-100" alt="">
										           @else 
												        <img src="{{asset('images/no-image-found.jpg')}}" class="w-100" alt=""> 
											       @endif
                                                </div>
                                            </a>
                                           <!-- <a href="javascript:void(0)"
                                                class="product-img-link quick-view-1 text-capitalize">Quick view</a> -->
                                        </div>

                                        <div class="product-desc pb-20">
                                            <div class="product-desc-top">
                                                <div class="categories">
                                                    <a href="{{ url($product['category']['seo_unique']) }}" class="product-category"><span>{{ $product['category']['name'] }}</span></a>
                                                </div>
                                                <a href="{{url('/product/'.$product['seo_url']) }}" class="wishlist float-right"><span><i
                                                            class="fal fa-heart"></i></span></a>
                                            </div>
                                            <a href="{{url('/product/'.$product['seo_url']) }}" class="product-title">{{ $product['product_name'] }}</a>
                                            <div class="price-switcher">
                                                <span class="price switcher-item">@if($product['current_discount'] == 'product' || $product['current_discount'] == 'category')
													<span class="akasha-Price-amount amount">
													<b> 
													<span class="akasha-Price-currencySymbol">INR  &nbsp;</span>{{ Product::ProductPrice($product['category_id'],$product) }}
													</b> 
													<span style=" text-decoration: line-through;">&nbsp;&nbsp;INR {{round(CustomFunction::formatAmt($product['product_price']))}} </span>&nbsp;	&nbsp;
													
													</span>
													@else
													<span class="akasha-Price-amount amount">
													<b> 
													<span class="akasha-Price-currencySymbol">INR &nbsp;</span>{{ Product::ProductPrice($product['category_id'],$product) }}
													</b> 
													</span>
												@endif
												</span>
                                                <a href="{{url('/product/'.$product['seo_url']) }}" class="add-cart text-capitalize switcher-item">+add
                                                    to cart</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
						@endforeach 
						
                        
					</div>
                </div>
                <!-- /. tab content 1 -->
                
				
				
				<div class="tab-pane fade" id="main-tab-2">
                    <div class="main-product-carousel owl-carousel red-nav">
                       
					    @foreach($new_arrival_summer_collection_products as $key=> $product)
						<div class="main-product-carousel-item">
                            <div class="col-12">
                                <div class="product-box mb-40">
                                    <div class="product-box-wrapper">
                                        <div class="product-img">
										
										           <?php
												   $productimages = $product['productimages'];
												   $product_image1= '';
												   $product_image2= '';
												   if(!empty($productimages)){
													       $product_image1= $productimages[0]['image'];
													   if(!empty($productimages[1]['image'])){
														   $product_image2= $productimages[1]['image'];
													   }else{
														   $product_image2 = $product_image1;
													   }
												   } //echo "<pre>"; print_r($product); exit;
												   ?>
										
													@if(!empty($product_image1))
														<img src="{{ asset('images/ProductImages/medium/'.$product_image1) }}" class="w-100" alt="">
													@else 
														<img src="{{asset('images/no-image-found.jpg')}}" class="w-100" alt=""> 
													@endif
                                            <a href="{{url('/product/'.$product['seo_url']) }}" class="d-block">
                                                <div class="second-img">
                                                   @if(!empty($product_image2))
                                                        <img src="{{ asset('images/ProductImages/medium/'.$product_image2) }}" class="w-100" alt="">
										           @else 
												        <img src="{{asset('images/no-image-found.jpg')}}" class="w-100" alt=""> 
											       @endif
                                                </div>
                                            </a>
                                            <a href="javascript:void(0)"
                                                class="product-img-link quick-view-1 text-capitalize">Quick view</a>
                                        </div>

                                        <div class="product-desc pb-20">
                                            <div class="product-desc-top">
                                                <div class="categories">
                                                    <a href="{{ url($product['category']['seo_unique']) }}" class="product-category"><span>{{ $product['category']['name'] }}</span></a>
                                                </div>
                                                <a href="#" class="wishlist float-right"><span><i
                                                            class="fal fa-heart"></i></span></a>
                                            </div>
                                            <a href="{{url('/product/'.$product['seo_url']) }}" class="product-title">{{ $product['product_name'] }} </a>
                                            <div class="price-switcher">
                                                <span class="price switcher-item">@if($product['current_discount'] == 'product' || $product['current_discount'] == 'category')
													<span class="akasha-Price-amount amount">
													<b> 
													<span class="akasha-Price-currencySymbol">INR  &nbsp;</span>{{ Product::ProductPrice($product['category_id'],$product) }}
													</b> 
													<span style=" text-decoration: line-through;">&nbsp;&nbsp;INR {{round(CustomFunction::formatAmt($product['product_price']))}} </span>&nbsp;	&nbsp;
													
													</span>
													@else
													<span class="akasha-Price-amount amount">
													<b> 
													<span class="akasha-Price-currencySymbol">INR &nbsp;</span>{{ Product::ProductPrice($product['category_id'],$product) }}
													</b> 
													</span>
												@endif
												</span>
                                                <a href="{{url('/product/'.$product['seo_url']) }}" class="add-cart text-capitalize switcher-item">+add
                                                    to cart</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
						@endforeach 
						
                    </div>
                </div>
                <!-- /. tab content 1 -->
				
            </div>
        </div>
    </section>
<!-- --------Product Collection End-------- -->  

<!-- --------Brand Ambassadors Start-------- -->    

    <section class="brand-ambassador">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10 col-12">
                    <h2 class="title mb-5 text-center">Our Brand Ambassadors</h2>
                    <div class="main-product-carousel-A owl-carousel red-nav">
                        <div class="main-product-carousel-item">
                            <div class="col-12">
                                <div class="product-box">
                                    <div class="product-box-wrapper">
                                        <div class="ambassador-img">
                                            <a href="{{ url('/lookbook') }}"><img src="<?php echo asset('/'); ?>img/brand-ambassador/katrina.jpg" class="" alt=""></a>
                                        </div>

                                        <div class="product-desc">
                                            <div class="amb-desc-top product-desc-top">
                                                <div class="categories">
                                                    <a href="{{ url('/lookbook') }}" class="amb-name product-category"><span>Katrina Kaif</span></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="main-product-carousel-item">
                            <div class="col-12">
                                <div class="product-box">
                                    <div class="product-box-wrapper">
                                        <div class="ambassador-img">
                                            <a href="{{ url('/lookbook') }}"><img src="<?php echo asset('/'); ?>img/brand-ambassador/jacqueline.jpg" class="" alt=""></a>
                                        </div>

                                        <div class="product-desc">
                                            <div class="amb-desc-top product-desc-top">
                                                <div class="categories">
                                                    <a href="{{ url('/lookbook') }}" class="amb-name product-category"><span>Jacqueline Fernandez</span></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="main-product-carousel-item">
                            <div class="col-12">
                                <div class="product-box">
                                    <div class="product-box-wrapper">
                                        <div class="ambassador-img">
                                            <a href="{{ url('/lookbook') }}"><img src="<?php echo asset('/'); ?>img/brand-ambassador/sameera.jpg" class="" alt=""></a>
                                        </div>

                                        <div class="product-desc">
                                            <div class="amb-desc-top product-desc-top">
                                                <div class="categories">
                                                    <a href="{{ url('/lookbook') }}" class="amb-name product-category"><span>Sameera Reddy</span></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="main-product-carousel-item">
                            <div class="col-12">
                                <div class="product-box">
                                    <div class="product-box-wrapper">
                                        <div class="ambassador-img">
                                            <a href="{{ url('/lookbook') }}"><img src="<?php echo asset('/'); ?>img/brand-ambassador/amyra.jpg" class="" alt=""></a>
                                        </div>

                                        <div class="product-desc">
                                            <div class="amb-desc-top product-desc-top">
                                                <div class="categories">
                                                    <a href="{{ url('/lookbook') }}" class="amb-name product-category"><span>Amyra Dastur</span></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="main-product-carousel-item">
                            <div class="col-12">
                                <div class="product-box">
                                    <div class="product-box-wrapper">
                                        <div class="ambassador-img">
                                            <a href="{{ url('/lookbook') }}"><img src="<?php echo asset('/'); ?>img/brand-ambassador/urvashi.jpg" class="" alt=""></a>
                                        </div>

                                        <div class="product-desc">
                                            <div class="amb-desc-top product-desc-top">
                                                <div class="categories">
                                                    <a href="{{ url('/lookbook') }}" class="amb-name product-category"><span>Urvashi Sharma</span></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="main-product-carousel-item">
                            <div class="col-12">
                                <div class="product-box">
                                    <div class="product-box-wrapper">
                                        <div class="ambassador-img">
                                            <a href="{{ url('/lookbook') }}"><img src="<?php echo asset('/'); ?>img/brand-ambassador/amy.jpg" class="" alt=""></a>
                                        </div>

                                        <div class="product-desc">
                                            <div class="amb-desc-top product-desc-top">
                                                <div class="categories">
                                                    <a href="{{ url('/lookbook') }}" class="amb-name product-category"><span>Amy Maghera</span></a>
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
            </div>
        </div>
    </section>

<!-- --------Brand Ambassadors End-------- -->  

<!-- --------Video Banner Start-------- -->

    <section class="hm-banner">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 p-0">
                    <video src="video/rage.mp4" muted autoplay="true" preload="auto" loop height="100%" width="100%" id="VideoHomePage1" class="videoHome" data-videoHeighter="true">
                        <source type="video/mp4" src="video/rage.mp4">
                    </video>
                </div>
            </div>
        </div>
    </section>

<!-- --------Video Banner End-------- --> 

<!-- --------Store Locator Start-------- -->    

    <section class="category-area category-style7-area">
      <div class="container">
        <div class="col-left">
          <div class="category-items-style12">
            <div class="thumb-style">
              <img src="<?php echo asset('/'); ?>img/banner/store-locator-back.jpg" alt="shop-Image">
            </div>
            <div class="category-item hover-effect effect-style1">
              <div class="thumb">
                <img src="<?php echo asset('/'); ?>img/banner/store-locator.jpg" title="Rage Clothing Store" alt="Rage Clothing Store">
                <div class="effect-content"></div>
              </div>
              <!-- <div class="content">
                <a class="btn-theme btn-black" href="{{url('/store-locator')}}">View</a>
              </div> -->
            </div>
          </div>
        </div>
        <div class="col-right">
          <div class="content">
            <div class="inner-content">
              <h2 class="title">Store Locator</h2>
              <p>Based in Ludhiana, Rage as a unit comprises of the most modern knitting and finishing machinery with a dedicated design and production team.</p>
              <a class="btn-theme btn-black btn-size-lg" href="{{url('/store-locator')}}">View</a>
            </div>
          </div>
        </div>
      </div>
    </section>

<!-- --------Store Locator End-------- -->         

<!-- --------instagram section start-------- -->

    <section class="blog mt-60">
        <div class="container container-1430">
            
			<div class="generic-title text-center">
                <h2 class="mb-20">#Instagram</h2>
               <?php /* <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                <p>Lorem Ipsum has been the industry's to make a type specimen book.</p> */ ?>
            </div> 

            <div class="blog-carousel owl-carousel pt-50">
                <div class="blog-carousel-item">
                    <div class="col-12">
                        <div class="blog-wrapper">
                            <div class="blog-box-img">
                                <a href="https://www.instagram.com/rageindiaonline/" target="_blank"><img src="<?php echo asset('/'); ?>img/social/insta-1.jpg" class="w-100" alt=""></a>
                                <div class="blog-box-tags">
                                    <a href="https://www.instagram.com/rageindiaonline/" target="_blank">#BeBoldBeYou</a>
                                </div>
                            </div>
                            <div class="blog-box-desc text-center">
                               <?php /* <div class="blog-box-link">
                                    <a href="https://www.instagram.com/rageindiaonline/" target="_blank">Diam arcu, fringilla a sem condi cras</a>
                                </div> */ ?>
                                <div class="blog-short-content">
                                    <p>Look classy and stylish with Rage....</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="blog-carousel-item">
                    <div class="col-12">
                        <div class="blog-wrapper">
                            <div class="blog-box-img">
                                <a href="https://www.instagram.com/rageindiaonline/" target="_blank"><img src="<?php echo asset('/'); ?>img/social/insta-2.jpg" class="w-100" alt=""></a>
                                <div class="blog-box-tags">
                                    <a href="https://www.instagram.com/rageindiaonline/" target="_blank">#BeBoldBeYou</a>
                                </div>
                            </div>
                            <div class="blog-box-desc text-center">
                                
                                <div class="blog-short-content">
                                    <p>She is a boss. She is whatever she…</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="blog-carousel-item">
                    <div class="col-12">
                        <div class="blog-wrapper">
                            <div class="blog-box-img">
                                <a href="https://www.instagram.com/rageindiaonline/" target="_blank"><img src="<?php echo asset('/'); ?>img/social/insta-3.jpg" class="w-100" alt=""></a>
                                <div class="blog-box-tags">
                                    <a href="https://www.instagram.com/rageindiaonline/" target="_blank">#BeBoldBeYou</a>
                                </div>
                            </div>
                            <div class="blog-box-desc text-center pt-20">
                                
                                <div class="blog-short-content">
                                    <p>She is an artist. She is a boss. She is whatever…</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="hm-bottom-text">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-12 text-justify">
                    
					<p>Welcome to Rage! Rage is a contemporary Indian clothing brand that came into being in the early 2000s. The brand’s unique knitwear and apparel range which fuses ethnic designs with modern silhouettes, has indeed become the rage among style-conscious modern women who will compromise neither with comfort nor with elegance.</p>
                    
                    <p class="rage-content">
					
					Rage’s pieces are designed to give a comfortably snug fit, and they can be paired with work wear, casual wear or even party wear. From solid colours to neutral hues with minimalistic patterns to melange of bright shades and patterns, Rage’s pieces appeal to different aesthetics. And that is why, different consumers with varying tastes will definitely find something that they love. </p>
                
				</div>
            </div>
        </div>
    </section>

<!-- --------instagram section End-------- -->
@stop
@section('javascript')
@parent 

@stop