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

            <div class="swiper-slide">
                <a href="listing.php">
                    <img src="assets/images/hero-banner.png" alt="Rage Winter Collection">
                </a>
            </div>

            <div class="swiper-slide">
                <a href="listing.php">
                    <img src="assets/images/hero-banner.png" alt="Rage Collection">
                </a>
            </div>

            <div class="swiper-slide">
                <a href="listing.php">
                    <img src="assets/images/hero-banner.png" alt="Rage Collection">
                </a>
            </div>

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

                        <div class="swiper-slide">
                            <div class="collection-card">
                                <div class="collection-content">
                                    <span>Chapter I</span>
                                    <h3>Kurti Sets</h3>
                                    <p>Velvets for winter evenings.</p>
                                </div>

                                <img src="assets/images/kurti.png" alt="Kurti Sets">

                                <a href="listing.php" class="collection-link link-btn">
                                    Explore
                                    <i class="fa-solid fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>


                        <div class="swiper-slide">
                            <div class="collection-card">
                                <div class="collection-content">
                                    <span>Chapter II</span>
                                    <h3>Co-ord</h3>
                                    <p>Festive warmth in rich textures.</p>
                                </div>

                                <img src="assets/images/co-ord.png" alt="Co-ord">

                                <a href="listing.php" class="collection-link link-btn">
                                    Explore
                                    <i class="fa-solid fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="collection-card">
                                <div class="collection-content">
                                    <span>Chapter II</span>
                                    <h3>Co-ord</h3>
                                    <p>Festive warmth in rich textures.</p>
                                </div>

                                <img src="assets/images/co-ord.png" alt="Co-ord">

                                <a href="listing.php" class="collection-link link-btn">
                                    Explore
                                    <i class="fa-solid fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>


                        <div class="swiper-slide">
                            <div class="collection-card">
                                <div class="collection-content">
                                    <span>Chapter III</span>
                                    <h3>Tops</h3>
                                    <p>Everyday winter elegance.</p>
                                </div>

                                <img src="assets/images/top.png" alt="Tops">

                                <a href="listing.php" class="collection-link link-btn">
                                    Explore
                                    <i class="fa-solid fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>

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
                            <a href="listing.php" class="link-btn">Discover Her Edit <i
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
                <div class="row">
                    <div class="col-lg-4 col-md-6 col-12">
                        <div class="prod-card">
                            <div class="prod-img">
                                <a href="detail.php">
                                    <img src="assets/images/Product-Image-1.png" alt="Abeer Velvet Kurta">
                                </a>
                                <a href="javascript:void(0)" aria-label="Add to Wishlist"><i
                                        class="fa-regular fa-heart"></i></a>
                                <div class="cart-btn">
                                    <a href="javascript:void(0)" class="link-btn black">Add to Cart</a>
                                    <a href="detail.php" class="link-btn brown">Buy Now</a>
                                </div>
                            </div>
                            <a href="detail.php" class="prod-info">
                                <div class="name-wrap">
                                    <h4>Abeer Velvet Kurta</h4>
                                </div>
                                <div class="detail-price card-box">
                                    <span class="sale-price">INR 1,48,000</span>
                                    <del>INR 1,65,000</del>
                                    <span class="discount">10% OFF</span>
                                </div>

                            </a>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-12">
                        <div class="prod-card">
                            <div class="prod-img">
                                <a href="detail.php">
                                    <img src="assets/images/Product-Image-2.png" alt="Meher Wool Coat">
                                </a>
                                <a href="javascript:void(0)" aria-label="Add to Wishlist"><i
                                        class="fa-regular fa-heart"></i></a>
                                <div class="cart-btn">
                                    <a href="javascript:void(0)" class="link-btn black">Add to Cart</a>
                                    <a href="detail.php" class="link-btn brown">Buy Now</a>
                                </div>
                            </div>
                            <a href="detail.php" class="prod-info">
                                <div class="name-wrap">
                                    <h4>Meher Luxe Wool Coat</h4>
                                </div>
                                <div class="detail-price card-box">
                                    <span class="sale-price">INR 1,48,000</span>
                                    <del>INR 1,65,000</del>
                                    <span class="discount">10% OFF</span>
                                </div>

                            </a>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-12">
                        <div class="prod-card">
                            <div class="prod-img">
                                <a href="detail.php">
                                    <img src="assets/images/Product-Image-3.png" alt="Jacquard Cardigan">
                                </a>
                                <a href="javascript:void(0)" aria-label="Add to Wishlist"><i
                                        class="fa-regular fa-heart"></i></a>
                                <div class="cart-btn">
                                    <a href="javascript:void(0)" class="link-btn black">Add to Cart</a>
                                    <a href="detail.php" class="link-btn brown">Buy Now</a>
                                </div>
                            </div>
                            <a href="detail.php" class="prod-info">
                                <div class="name-wrap">
                                    <h4>Plush Jacquard Cardigan</h4>
                                </div>
                                <div class="detail-price card-box">
                                    <span class="sale-price">INR 1,48,000</span>
                                    <del>INR 1,65,000</del>
                                    <span class="discount">10% OFF</span>
                                </div>

                            </a>
                        </div>
                    </div>
                    <div class="col-12 text-center mt-5">
                        <a href="listing.php" class="border-btn link-btn">
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
                        <a href="contact-us.php" class="link-btn">Discover Our Story <i
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
                        <div class="celebrity-card">
                            <img src="assets/images/Jenniffer.png" alt="Katrina Kaif">
                            <h3>Jenniffer Piccinato</h3>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="celebrity-card">
                            <img src="assets/images/katrina-kaif.png" alt="Katrina Kaif">
                            <h3>Katrina Kaif</h3>
                        </div>
                    </div>

                    <div class="swiper-slide">
                        <div class="celebrity-card">
                            <img src="assets/images/Jacqueline.png" alt="Jacqueline Fernandez">
                            <h3>Jacqueline Fernandez</h3>
                        </div>
                    </div>

                    <div class="swiper-slide">
                        <div class="celebrity-card">
                            <img src="assets/images/Urvashi.png" alt="Urvashi Sharma">
                            <h3>Urvashi Sharma</h3>
                        </div>
                    </div>

                    <div class="swiper-slide">
                        <div class="celebrity-card">
                            <img src="assets/images/Amyra.png" alt="Amyra Dastur">
                            <h3>Amyra Dastur</h3>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="celebrity-card">
                            <img src="assets/images/Jacqueline.png" alt="Jacqueline Fernandez">
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
                        <a href="listing.php" class="link-btn black">
                            Explore Winter Edit <i class="fa-solid fa-arrow-right-long"></i>
                        </a>
                        <a href="store-locator.php" class="link-btn white">
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