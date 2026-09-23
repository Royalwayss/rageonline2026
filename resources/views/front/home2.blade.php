@extends('layouts.frontLayout.front-layout')
@section('content')
<?php 
use App\CustomFunction;
use App\Wishlist;
use App\Product; 
use App\Category;
if (!isset($categories)) {
$categories = Category::getcategories();
}

?>
<main class="home">
    <section class="hero-banner">

    <div class="swiper heroSwiper">

        <div class="swiper-wrapper">

            @forelse($banners as $banner)
            <div class="swiper-slide">
                <a href="{{ !empty($banner->link) ? $banner->link : url('winter-collection') }}">
                    <img src="{{ asset('images/banners/'.$banner->image) }}" alt="{{ !empty($banner->description) ? $banner->description : 'Rage Collection' }}">
                </a>
            </div>
            @empty
            <div class="swiper-slide">
                <a href="{{ url('winter-collection') }}">
                    <img src="{{ asset('assets/images/hero-banner.png') }}" alt="Rage Winter Collection">
                </a>
            </div>
            @endforelse

        </div>

        <div class="swiper-pagination"></div>

    </div>

</section>
        <section>
            <div class="container text-center">
                <div class="about">
                    <h2>Wrapped in warmth. Rooted in tradition.</h2>
                    <p>A celebration of winter dressing through rich textures, thoughtful craftsmanship and modern
                        Indian
                        silhouettes. Crafted dynamically for the discerning modern woman who holds her heritage close.
                    </p>
                </div>
            </div>
        </section>
       <section class="collection winter">
            <div class="container">
                <div class="heading-wrap text-center">
                    <span>the collection</span>
                    <h2>Winter Chapters</h2>
                </div>
                <div class="swiper categorySwiper">

                    <div class="swiper-wrapper">

                        <?php
                            $winter_subcategories = [];
                            foreach ($categories as $category) {
                                if ($category['seo_unique'] == 'winter-collection' && !empty($category['subcategories'])) {
                                    $winter_subcategories = $category['subcategories'];
                                }
                            }
                            $chapter_no = 0;
                        ?>

                        @foreach($winter_subcategories as $subcategory)
                            <?php
                                $chapter_no++;
                                $chapter_product = Product::where('category_id', $subcategory['id'])
                                    ->where('status', 0)
                                    ->orderBy('id', 'desc')
                                    ->first();
                                if (!$chapter_product) {
                                    continue;
                                }
                                $chapter_image = !empty($chapter_product->product_image) ? asset('images/ProductImages/medium/'.$chapter_product->product_image->image) : asset('images/no-image-found.jpg');
                                $chapter_roman = ['I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X'];
                            ?>
                            <div class="swiper-slide">
                                <div class="collection-card" style="position: relative;">

                                    <a href="{{ url('/'.$subcategory['seo_unique']) }}" class="collection-card-overlay-link" aria-label="{{ $subcategory['name'] }}" style="position: absolute; inset: 0; z-index: 1;"></a>

									<div class="collection-content">
                                        <span>Chapter {{ $chapter_roman[$chapter_no - 1] ?? $chapter_no }}</span>
                                        <h3>{{ $subcategory['name'] }}</h3>
                                    </div>

                                    <img src="{{ $chapter_image }}" alt="{{ $subcategory['name'] }}">

                                    <a href="{{ url('/'.$subcategory['seo_unique']) }}" class="collection-link link-btn" style="position: relative; z-index: 2;">
                                        Explore
                                        <i class="fa-solid fa-arrow-right"></i>
                                    </a>

                                </div>
                            </div>
                        @endforeach

                    </div>
                       <div class="swiper-pagination"></div>

                </div>
            </div>
        </section>
		<section class="alicia">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6 col-md-12 col-12">
                        <div class="ambasador-img">
                            <img src="assets/images/alicia.png" alt="">
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12 col-12">
                        <div class="ambasador-content">
                            <div class="heading-wrap">
                                <span>The Face of Winter</span>
                                <h2>Alicia for Rage</h2>
                            </div>
                            <p>An ode to effortless warmth, quiet confidence and modern Indian femininity. Styled in
                                layering pieces crafted for the colder months, bridging contemporary ease with
                                deep-rooted
                                heritage.</p>
                            <h3 class="quote">
                                "There is something about winter dressing that feels deeply personal."
                            </h3>
                            <a href="{{ url('winter-collection') }}" class="link-btn">Discover Her Edit <i
                                    class="fa-solid fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="product-listing">
            <div class="container">
                <div class="heading-wrap text-center">
                    <h2>Worn by Her</h2>
                    <p>The season's signature looks, curated from the campaign.</p>
                </div>
                <div class="swiper bestSellerSwiper">

                    <div class="swiper-wrapper">
                        @foreach($best_seller_products as $product)
                        <?php
                            $product_image = !empty($product->product_image) ? asset('images/ProductImages/large/'.$product->product_image->image) : asset('images/no-image-found.jpg');
                        ?>
                        <div class="swiper-slide">
                            <div class="prod-card">
                                <div class="prod-img">
                                    <a href="{{ url('product/'.$product->seo_url) }}">
                                        <img src="{{ $product_image }}" alt="{{ $product->product_name }}">
                                    </a>
                                    <a href="javascript:void(0)" class="addWishList WishList-{{ $product->id }}" data-productid="{{ $product->id }}" page-type="listing" aria-label="Add to Wishlist">
									
									@if($product['is_wishlisted'] == '1')
									    <i class="fa-heart fa-solid" style="color: rgb(147, 47, 47);"></i>
									@else
										<i class="fa-regular fa-heart"></i>
									@endif	
								
									</a>
                                    <div class="cart-btn">
                                        <a href="{{ url('product/'.$product->seo_url) }}" class="link-btn black">Add to Cart</a>
                                        <a href="{{ url('product/'.$product->seo_url) }}" class="link-btn brown">Buy Now</a>
                                    </div>
                                </div>
                                <a href="{{ url('product/'.$product->seo_url) }}" class="prod-info">
                                    <div class="name-wrap">
                                        <h4>{{ $product->product_name }}</h4>
                                    </div>
                                    <div class="detail-price card-box">
                                        {!! productPriceHtml($product) !!}
                                    </div>

                                </a>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <div class="swiper-pagination"></div>

                </div>
                <div class="row">
                    <div class="col-12 text-center mt-5">
                        <a href="{{ url('winter-collection') }}" class="border-btn link-btn">
                            Explore Celebrity Closet <i class="fa-solid fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </section>
        <section class="film-section">

            <img src="assets/images/film-poster.jpg" alt="" class="film-poster">

            <video class="film-video" playsinline controls muted>
                <source src="assets/images/rage.mp4" type="video/mp4">
            </video>

            <div class="film-overlay">
                <span>WINTER '26 FILM</span>

                <h2>The Season Unfolds</h2>

                <button type="button" class="film-play">
                    <span class="play-icon">
                        <i class="fa-solid fa-play"></i>
                    </span>
                    WATCH FILM
                </button>
            </div>

        </section>
        <section class="collection winter">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                        <div class="heading-wrap">
                            <span>Our World</span>
                            <h2>Made for Indian Winters. Inspired by Indian Stories.</h2>
                        </div>
                        <p>For years, the brand has brought together seasonal comfort, expressive craft and contemporary
                            Indian design. Guided by ancestral craft knowledge, our ateliers tailor silhouettes that
                            balance
                            thermal coziness with historic grace.</p>
                        <a href="{{ url('about-us') }}" class="link-btn">Discover Our Story <i
                                class="fa-solid fa-arrow-right"></i></a>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                        <div class="craft-img">
                            <img src="assets/images/Craft.png" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
		<section class="celebs">
            <div class="container">
                <div class="heading-wrap">
                    <span>Brand Ambassadors</span>
                    <h2>Celebs In Rage</h2>
                </div>
            </div>
            <div class="swiper celebSwiper">
                <div class="swiper-wrapper">

                    <div class="swiper-slide">
                        <div class="celebrity-card" style="position: relative;">
                            <a href="{{ url('lookbook') }}" aria-label="Jenniffer Piccinato" style="position: absolute; inset: 0; z-index: 1;"></a>
                            <img src="{{ asset('assets/images/Jenniffer.png') }}" alt="Jenniffer Piccinato">
                            <h3>Jenniffer Piccinato</h3>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="celebrity-card" style="position: relative;">
                            <a href="{{ url('lookbook') }}" aria-label="Katrina Kaif" style="position: absolute; inset: 0; z-index: 1;"></a>
                            <img src="{{ asset('assets/images/katrina-kaif.png') }}" alt="Katrina Kaif">
                            <h3>Katrina Kaif</h3>
                        </div>
                    </div>

                    <div class="swiper-slide">
                        <div class="celebrity-card" style="position: relative;">
                            <a href="{{ url('lookbook') }}" aria-label="Jacqueline Fernandez" style="position: absolute; inset: 0; z-index: 1;"></a>
                            <img src="{{ asset('assets/images/Jacqueline.png') }}" alt="Jacqueline Fernandez">
                            <h3>Jacqueline Fernandez</h3>
                        </div>
                    </div>

                    <div class="swiper-slide">
                        <div class="celebrity-card" style="position: relative;">
                            <a href="{{ url('lookbook') }}" aria-label="Urvashi Sharma" style="position: absolute; inset: 0; z-index: 1;"></a>
                            <img src="{{ asset('assets/images/Urvashi.png') }}" alt="Urvashi Sharma">
                            <h3>Urvashi Sharma</h3>
                        </div>
                    </div>

                    <div class="swiper-slide">
                        <div class="celebrity-card" style="position: relative;">
                            <a href="{{ url('lookbook') }}" aria-label="Amyra Dastur" style="position: absolute; inset: 0; z-index: 1;"></a>
                            <img src="{{ asset('assets/images/Amyra.png') }}" alt="Amyra Dastur">
                            <h3>Amyra Dastur</h3>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="celebrity-card" style="position: relative;">
                            <a href="{{ url('lookbook') }}" aria-label="Jacqueline Fernandez" style="position: absolute; inset: 0; z-index: 1;"></a>
                            <img src="{{ asset('assets/images/Jacqueline.png') }}" alt="Jacqueline Fernandez">
                            <h3>Jacqueline Fernandez</h3>
                        </div>
                    </div>

                </div>
            </div>
        </section>
		
		
		<section class="about-cta-section">
            <div class="container-fluid">
                <div class="about-cta-box text-center">
                    <span class="cta-subtitle">Experience The House of Rage</span>
                    <h2>Step Into Our World of Warmth & Elegance</h2>
                    <p>Discover signature cardigans, sculpted capes, fine tunics, and our exclusive plus-size curations.
                    </p>
                    <div class="about-cta-btns">
                        <a href="{{ url('winter-collection') }}" class="link-btn black">
                            Explore Winter Edit <i class="fa-solid fa-arrow-right-long"></i>
                        </a>
                        <a href="{{ url('store-locator') }}" class="link-btn white">
                            Locate A Store <i class="fa-solid fa-location-dot"></i>
                        </a>
                    </div>
                </div>
            </div>
        </section>
    </main>
    
@stop
@section('javascript')
@parent

@stop