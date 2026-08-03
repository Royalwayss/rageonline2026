@extends('layouts.frontLayout.front-layout')
@section('content')
<?php use App\CustomFunction; use App\Wishlist; use App\Product; 

?>


<main class="homeMain">
	<div class="container-fluid p-0" data-aos="fade-right">
		<div class="row">
			<div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
				<div class="carousel-inner">

					<div class="carousel-item active">
					<a href="{{ url('cardigans') }}">
						<img src="images/banners/2025.1.jpg" class="d-md-block d-none w-100" alt="winter collection" title="winter collection"> <!-- desktop -->
						<img src="images/banners/2025.1m.jpg" class="d-block d-md-none w-100" alt="winter collection" title="winter collection"> <!-- mobile -->
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
	
	<div class="container products" data-aos="fade-up">
	  <div class="row">
	    <div class="col-md-12">
	      <h3 class="title-head">Discover What’s Next</h3>

	      <div id="news-slider" class="owl-carousel">
	        <div class="product-slide">
	          <div class="product-img">
				<span class="offprice">20% Off</span>
	            <img src="images/p1.jpg" alt="">
	          </div>
	          <div class="product-content">
	            <a href="#" class="product-title">Floral Jacquard Embroidered Co-ord </a>
	            <span class="product-prize">INR 2999 <span class="cut-price" style=" text-decoration: line-through;">INR 4999 </span></span>
				<button  data-bs-toggle="offcanvas" data-bs-target="#productOffcanvas" class="btn-quickview" aria-controls="productOffcanvas" title="Quick View">
					<svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="22" height="22" x="0" y="0" viewBox="0 0 32 32" style="enable-background:new 0 0 512 512" xml:space="preserve"><g><path d="M24 8h-2a6 6 0 0 0-12 0H8a3 3 0 0 0-3 3v14a5.006 5.006 0 0 0 5 5h12a5.006 5.006 0 0 0 5-5V11a3 3 0 0 0-3-3zm-8-4a4 4 0 0 1 4 4h-8a4 4 0 0 1 4-4zm9 21a3 3 0 0 1-3 3H10a3 3 0 0 1-3-3V11a1 1 0 0 1 1-1h2v2a1 1 0 0 0 2 0v-2h8v2a1 1 0 0 0 2 0v-2h2a1 1 0 0 1 1 1z" data-name="Layer 2" fill="#000000" opacity="1" data-original="#212121"></path></g></svg>
				</button> 
	          </div>
				
	        </div>

	        <div class="product-slide">
	          <div class="product-img">
	            <img src="images/p2.jpg" alt="">
	          </div>
	          <div class="product-content">
	            <a href="#" class="product-title">Floral Jacquard Embroidered Co-ord </a>
	           <span class="product-prize">INR 2999 <span class="cut-price" style=" text-decoration: line-through;">INR 4999 </span></span>
			   <button  data-bs-toggle="offcanvas" data-bs-target="#productOffcanvas" class="btn-quickview" aria-controls="productOffcanvas" title="Quick View">
					<svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="22" height="22" x="0" y="0" viewBox="0 0 32 32" style="enable-background:new 0 0 512 512" xml:space="preserve"><g><path d="M24 8h-2a6 6 0 0 0-12 0H8a3 3 0 0 0-3 3v14a5.006 5.006 0 0 0 5 5h12a5.006 5.006 0 0 0 5-5V11a3 3 0 0 0-3-3zm-8-4a4 4 0 0 1 4 4h-8a4 4 0 0 1 4-4zm9 21a3 3 0 0 1-3 3H10a3 3 0 0 1-3-3V11a1 1 0 0 1 1-1h2v2a1 1 0 0 0 2 0v-2h8v2a1 1 0 0 0 2 0v-2h2a1 1 0 0 1 1 1z" data-name="Layer 2" fill="#000000" opacity="1" data-original="#212121"></path></g></svg>
				</button> 
	          </div>
	        </div>

	        <div class="product-slide">
	          <div class="product-img">
	            <img src="images/p3.jpg" alt="">
	          </div>
	          <div class="product-content">
	            <a href="#" class="product-title">Floral Jacquard Embroidered Co-ord </a>
	           <span class="product-prize">INR 2999 <span class="cut-price" style=" text-decoration: line-through;">INR 4999 </span></span>
			   <button  data-bs-toggle="offcanvas" data-bs-target="#productOffcanvas" class="btn-quickview" aria-controls="productOffcanvas" title="Quick View">
					<svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="22" height="22" x="0" y="0" viewBox="0 0 32 32" style="enable-background:new 0 0 512 512" xml:space="preserve"><g><path d="M24 8h-2a6 6 0 0 0-12 0H8a3 3 0 0 0-3 3v14a5.006 5.006 0 0 0 5 5h12a5.006 5.006 0 0 0 5-5V11a3 3 0 0 0-3-3zm-8-4a4 4 0 0 1 4 4h-8a4 4 0 0 1 4-4zm9 21a3 3 0 0 1-3 3H10a3 3 0 0 1-3-3V11a1 1 0 0 1 1-1h2v2a1 1 0 0 0 2 0v-2h8v2a1 1 0 0 0 2 0v-2h2a1 1 0 0 1 1 1z" data-name="Layer 2" fill="#000000" opacity="1" data-original="#212121"></path></g></svg>
				</button> 
	          </div>
	        </div>

	        <div class="product-slide">
	          <div class="product-img">
	            <img src="images/p4.jpg" alt="">
	          </div>
	          <div class="product-content">
	            <a href="#" class="product-title">Floral Jacquard Embroidered Co-ord </a>
	           <span class="product-prize">INR 2999 <span class="cut-price" style=" text-decoration: line-through;">INR 4999 </span></span>
			   <button  data-bs-toggle="offcanvas" data-bs-target="#productOffcanvas" class="btn-quickview" aria-controls="productOffcanvas" title="Quick View">
					<svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="22" height="22" x="0" y="0" viewBox="0 0 32 32" style="enable-background:new 0 0 512 512" xml:space="preserve"><g><path d="M24 8h-2a6 6 0 0 0-12 0H8a3 3 0 0 0-3 3v14a5.006 5.006 0 0 0 5 5h12a5.006 5.006 0 0 0 5-5V11a3 3 0 0 0-3-3zm-8-4a4 4 0 0 1 4 4h-8a4 4 0 0 1 4-4zm9 21a3 3 0 0 1-3 3H10a3 3 0 0 1-3-3V11a1 1 0 0 1 1-1h2v2a1 1 0 0 0 2 0v-2h8v2a1 1 0 0 0 2 0v-2h2a1 1 0 0 1 1 1z" data-name="Layer 2" fill="#000000" opacity="1" data-original="#212121"></path></g></svg>
				</button> 
	          </div>
	        </div>
	      </div>
	    </div>
	  </div>
	</div>
	<h3 class="title-head mb-3">Shop by Category</h3>
	<div class="sticky-section categories-section" data-aos="fade-up">
		<div class="row d-none d-md-flex">
			 <!-- Tabs Navigation -->
			<div class="categories-tabs d-none d-md-flex">
				<button class="tab-btn active" data-tab="0">Co-ord</button>
				<button class="tab-btn" data-tab="1">Kurtis</button>
				<button class="tab-btn" data-tab="2">Poncho</button>
				<button class="tab-btn" data-tab="3">Cardigans</button>
				<button class="tab-btn" data-tab="4">Tops</button>
			</div>
			<!-- Left Sticky Image -->
			<div class="col-6  image-col">
			<div class="image-box">
				<img src="images/cr1.jpg" alt="Image 1" class="sticky-img active">
				<img src="images/cr2.jpg" alt="Image 2" class="sticky-img">
				<img src="images/cr3.jpg" alt="Image 3" class="sticky-img">
				<img src="images/cr4.jpg" alt="Image 4" class="sticky-img">
				<img src="images/cr5.jpg" alt="Image 5" class="sticky-img">
			</div>
			</div>

			<!-- Right Scroll Content -->
			
			<div class="col-6  content-col">
			<div class="content-block" data-image="0">
				<h2>Co-ord</h2>
				<p>Co-ord sets bring together comfort and style in perfect harmony. Designed to make dressing effortless yet chic, these matching outfits are versatile enough for casual outings, festive occasions, or elegant evenings. With coordinated pieces that blend seamlessly, our co-ords let you look polished without the hassle of mix-and-match.</p>
				<a href="#" class="btn-bg">Shop Now</a>
			</div>

			<div class="content-block" data-image="1">
				<h2>Kurtis</h2>
				<p>Discover our collection of stylish Kurtis designed for every occasion. From casual everyday wear to elegant festive styles, each piece blends comfort with timeless charm.</p>
				<a href="#" class="btn-bg">Shop Now</a>
			</div>

			<div class="content-block" data-image="2">
				<h2>Poncho</h2>
				<p>Discover our exclusive poncho collection that brings together warmth, style, and versatility. From cozy evenings to fashionable outings, each poncho is crafted to keep you comfortable while elevating your look.</p>
				<a href="#" class="btn-bg">Shop Now</a>
			</div>

			<div class="content-block" data-image="3">
				<h2>Cardigans</h2>
				<p>Explore our curated cardigan collection that blends comfort and sophistication. Whether you prefer longline, cropped, or button-down styles, our cardigans are perfect for layering across all seasons.</p>
				<a href="#" class="btn-bg">Shop Now</a>
			</div>
			<div class="content-block" data-image="4">
				<h2>Tops</h2>
				<p>From casual classics to statement styles, our tops are designed to keep you effortlessly stylish. Pair them with jeans, skirts, or trousers for a look that’s always on-trend.</p>
				<a href="#" class="btn-bg">Shop Now</a>
			</div>
			</div>
		</div>

		<div id="categoriesCarousel" class="carousel slide d-block d-md-none" data-bs-ride="carousel">
			<!-- Dots -->
			<div class="carousel-indicators">
				<button type="button" data-bs-target="#categoriesCarousel" data-bs-slide-to="0" class="active"></button>
				<button type="button" data-bs-target="#categoriesCarousel" data-bs-slide-to="1"></button>
				<button type="button" data-bs-target="#categoriesCarousel" data-bs-slide-to="2"></button>
				<button type="button" data-bs-target="#categoriesCarousel" data-bs-slide-to="3"></button>
				<button type="button" data-bs-target="#categoriesCarousel" data-bs-slide-to="4"></button>
			</div>

			<!-- Slides -->
			<div class="carousel-inner">

				<!-- Slide 1 -->
				<div class="carousel-item active">
				<div class="row">
					<div class="col-md-6 image-col">
					<img src="images/cr1.jpg" class="d-block w-100" alt="Co-ord">
					</div>
					<div class="col-md-6 content-col d-flex flex-column justify-content-center">
					<h2>Co-ord</h2>
					<p>Co-ord sets bring together comfort and style in perfect harmony. Designed to make dressing effortless yet chic, these matching outfits are versatile enough for casual outings, festive occasions, or elegant evenings.</p>
					<a href="#" class="btn-bg">Shop Now</a>
					</div>
				</div>
				</div>

				<!-- Slide 2 -->
				<div class="carousel-item">
				<div class="row">
					<div class="col-md-6 image-col">
					<img src="images/cr2.jpg" class="d-block w-100" alt="Kurtis">
					</div>
					<div class="col-md-6 content-col d-flex flex-column justify-content-center">
					<h2>Kurtis</h2>
					<p>Discover our collection of stylish Kurtis designed for every occasion. From casual everyday wear to elegant festive styles, each piece blends comfort with timeless charm.</p>
					<a href="#" class="btn-bg">Shop Now</a>
					</div>
				</div>
				</div>

				<!-- Slide 3 -->
				<div class="carousel-item">
				<div class="row">
					<div class="col-md-6 image-col">
					<img src="images/cr3.jpg" class="d-block w-100" alt="Poncho">
					</div>
					<div class="col-md-6 content-col d-flex flex-column justify-content-center">
					<h2>Poncho</h2>
					<p>Discover our exclusive poncho collection that brings together warmth, style, and versatility. From cozy evenings to fashionable outings, each poncho is crafted to keep you comfortable while elevating your look.</p>
					<a href="#" class="btn-bg">Shop Now</a>
					</div>
				</div>
				</div>

				<!-- Slide 4 -->
				<div class="carousel-item">
				<div class="row">
					<div class="col-md-6 image-col">
					<img src="images/cr4.jpg" class="d-block w-100" alt="Cardigans">
					</div>
					<div class="col-md-6 content-col d-flex flex-column justify-content-center">
					<h2>Cardigans</h2>
					<p>Explore our curated cardigan collection that blends comfort and sophistication. Whether you prefer longline, cropped, or button-down styles, our cardigans are perfect for layering across all seasons.</p>
					<a href="#" class="btn-bg">Shop Now</a>
					</div>
				</div>
				</div>

				<!-- Slide 5 -->
				<div class="carousel-item">
				<div class="row">
					<div class="col-md-6 image-col">
					<img src="images/cr5.jpg" class="d-block w-100" alt="Tops">
					</div>
					<div class="col-md-6 content-col d-flex flex-column justify-content-center">
					<h2>Tops</h2>
					<p>From casual classics to statement styles, our tops are designed to keep you effortlessly stylish. Pair them with jeans, skirts, or trousers for a look that’s always on-trend.</p>
					<a href="#" class="btn-bg">Shop Now</a>
					</div>
				</div>
				</div>

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

	<div class="container products" data-aos="fade-up">
	  <div class="row">
	    <div class="col-md-12">
	      <h3 class="title-head">Festive Wear</h3>

	      <div id="news-slider1" class="owl-carousel">
	        <div class="product-slide">
	          <div class="product-img">
				<span class="offprice">20% Off</span>
	            <img src="images/p1.jpg" alt="">
	          </div>
	          <div class="product-content">
	            <a href="#" class="product-title">Floral Jacquard Embroidered Co-ord </a>
	            <span class="product-prize">INR 2999 <span class="cut-price" style=" text-decoration: line-through;">INR 4999 </span></span>
				<button  data-bs-toggle="offcanvas" data-bs-target="#productOffcanvas" class="btn-quickview" aria-controls="productOffcanvas" title="Quick View">
					<svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="22" height="22" x="0" y="0" viewBox="0 0 32 32" style="enable-background:new 0 0 512 512" xml:space="preserve"><g><path d="M24 8h-2a6 6 0 0 0-12 0H8a3 3 0 0 0-3 3v14a5.006 5.006 0 0 0 5 5h12a5.006 5.006 0 0 0 5-5V11a3 3 0 0 0-3-3zm-8-4a4 4 0 0 1 4 4h-8a4 4 0 0 1 4-4zm9 21a3 3 0 0 1-3 3H10a3 3 0 0 1-3-3V11a1 1 0 0 1 1-1h2v2a1 1 0 0 0 2 0v-2h8v2a1 1 0 0 0 2 0v-2h2a1 1 0 0 1 1 1z" data-name="Layer 2" fill="#000000" opacity="1" data-original="#212121"></path></g></svg>
				</button> 
	          </div>
				
	        </div>

	        <div class="product-slide">
	          <div class="product-img">
	            <img src="images/p2.jpg" alt="">
	          </div>
	          <div class="product-content">
	            <a href="#" class="product-title">Floral Jacquard Embroidered Co-ord </a>
	           <span class="product-prize">INR 2999 <span class="cut-price" style=" text-decoration: line-through;">INR 4999 </span></span>
			   <button  data-bs-toggle="offcanvas" data-bs-target="#productOffcanvas" class="btn-quickview" aria-controls="productOffcanvas" title="Quick View">
					<svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="22" height="22" x="0" y="0" viewBox="0 0 32 32" style="enable-background:new 0 0 512 512" xml:space="preserve"><g><path d="M24 8h-2a6 6 0 0 0-12 0H8a3 3 0 0 0-3 3v14a5.006 5.006 0 0 0 5 5h12a5.006 5.006 0 0 0 5-5V11a3 3 0 0 0-3-3zm-8-4a4 4 0 0 1 4 4h-8a4 4 0 0 1 4-4zm9 21a3 3 0 0 1-3 3H10a3 3 0 0 1-3-3V11a1 1 0 0 1 1-1h2v2a1 1 0 0 0 2 0v-2h8v2a1 1 0 0 0 2 0v-2h2a1 1 0 0 1 1 1z" data-name="Layer 2" fill="#000000" opacity="1" data-original="#212121"></path></g></svg>
				</button> 
	          </div>
	        </div>

	        <div class="product-slide">
	          <div class="product-img">
	            <img src="images/p3.jpg" alt="">
	          </div>
	          <div class="product-content">
	            <a href="#" class="product-title">Floral Jacquard Embroidered Co-ord </a>
	           <span class="product-prize">INR 2999 <span class="cut-price" style=" text-decoration: line-through;">INR 4999 </span></span>
			   <button  data-bs-toggle="offcanvas" data-bs-target="#productOffcanvas" class="btn-quickview" aria-controls="productOffcanvas" title="Quick View">
					<svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="22" height="22" x="0" y="0" viewBox="0 0 32 32" style="enable-background:new 0 0 512 512" xml:space="preserve"><g><path d="M24 8h-2a6 6 0 0 0-12 0H8a3 3 0 0 0-3 3v14a5.006 5.006 0 0 0 5 5h12a5.006 5.006 0 0 0 5-5V11a3 3 0 0 0-3-3zm-8-4a4 4 0 0 1 4 4h-8a4 4 0 0 1 4-4zm9 21a3 3 0 0 1-3 3H10a3 3 0 0 1-3-3V11a1 1 0 0 1 1-1h2v2a1 1 0 0 0 2 0v-2h8v2a1 1 0 0 0 2 0v-2h2a1 1 0 0 1 1 1z" data-name="Layer 2" fill="#000000" opacity="1" data-original="#212121"></path></g></svg>
				</button> 
	          </div>
	        </div>

	        <div class="product-slide">
	          <div class="product-img">
	            <img src="images/p4.jpg" alt="">
	          </div>
	          <div class="product-content">
	            <a href="#" class="product-title">Floral Jacquard Embroidered Co-ord </a>
	           <span class="product-prize">INR 2999 <span class="cut-price" style=" text-decoration: line-through;">INR 4999 </span></span>
			   <button  data-bs-toggle="offcanvas" data-bs-target="#productOffcanvas" class="btn-quickview" aria-controls="productOffcanvas" title="Quick View">
					<svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="22" height="22" x="0" y="0" viewBox="0 0 32 32" style="enable-background:new 0 0 512 512" xml:space="preserve"><g><path d="M24 8h-2a6 6 0 0 0-12 0H8a3 3 0 0 0-3 3v14a5.006 5.006 0 0 0 5 5h12a5.006 5.006 0 0 0 5-5V11a3 3 0 0 0-3-3zm-8-4a4 4 0 0 1 4 4h-8a4 4 0 0 1 4-4zm9 21a3 3 0 0 1-3 3H10a3 3 0 0 1-3-3V11a1 1 0 0 1 1-1h2v2a1 1 0 0 0 2 0v-2h8v2a1 1 0 0 0 2 0v-2h2a1 1 0 0 1 1 1z" data-name="Layer 2" fill="#000000" opacity="1" data-original="#212121"></path></g></svg>
				</button> 
	          </div>
	        </div>
	      </div>
	    </div>
	  </div>
	</div>

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
				<a href="#" class="btn-cart2">Find Your Nearest Store</a>
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
					<img src="img/lookbook/ba1.jpg" alt="">
				</div>
				<div class="product-content">
					<a href="#" class="product-title">Katrina Kaif</a>
				</div>
				</div>

				<div class="product-slide">
				<div class="product-img">
					<img src="img/lookbook/ba2.jpg" alt="">
				</div>
				<div class="product-content">
					<a href="#" class="product-title">Jacqueline Fernandez</a>
				</div>
				</div>

				<div class="product-slide">
				<div class="product-img">
					<img src="img/lookbook/ba3.jpg" alt="">
				</div>
				<div class="product-content">
					<a href="#" class="product-title">Urvashi Sharma</a>
				</div>
				</div>

				<div class="product-slide">
				<div class="product-img">
					<img src="img/lookbook/ba4.jpg" alt="">
				</div>
				<div class="product-content">
					<a href="#" class="product-title">Giselle Monterio</a>
				</div>
				</div>

				<div class="product-slide">
				<div class="product-img">
					<img src="img/lookbook/ba5.jpg" alt="">
				</div>
				<div class="product-content">
					<a href="#" class="product-title">Amyra Dastur</a>
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