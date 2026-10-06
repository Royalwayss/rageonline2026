@extends('layouts.frontLayout.front-layout')
@section('content')

<main class="inner-page about-page">

    <!-- HERO & BREADCRUMB -->
    <section class="about-hero-section">
        <div class="container-fluid">
            <div class="about-hero-inner">
                <div class="detail-breadcrumb">
                    <a href="{{ route('home') }}">Home</a>
                    <span>/</span>
                    <span>About Us</span>
                </div>
                <span class="about-hero-subtitle" data-aos="fade-up">The House of Rage Knit</span>
                <h1 class="about-hero-title" data-aos="fade-up" data-aos-delay="100">Who We Are</h1>
                <p class="about-hero-desc" data-aos="fade-up" data-aos-delay="200">
                    15 Years of Crafting Architectural Knitwear, Modern Silhouettes & Inclusive Elegance.
                </p>
            </div>
        </div>
    </section>

    <!-- STATS / METRICS COUNTER BAR -->
    <section class="about-stats-section">
        <div class="container-fluid">
            <div class="about-stats-grid" data-aos="fade-up">
                <div class="about-stat-card">
                    <div class="stat-number">30</div>
                    <div class="stat-label">Exclusive Brand Outlets</div>
                    <span class="stat-sub">Across Prime Locations in India</span>
                </div>

                <div class="about-stat-card">
                    <div class="stat-number">500+</div>
                    <div class="stat-label">MBOs & Departmental Stores</div>
                    <span class="stat-sub">Nationwide Retail Presence</span>
                </div>

                <div class="about-stat-card">
                    <div class="stat-number">10+</div>
                    <div class="stat-label">Countries Export</div>
                    <span class="stat-sub">Global Footprint & Recognition</span>
                </div>

                <div class="about-stat-card">
                    <div class="stat-number">15+</div>
                    <div class="stat-label">Years of Legacy</div>
                    <span class="stat-sub">Pioneering Premium Knitwear Since 2011</span>
                </div>
            </div>
        </div>
    </section>

    <!-- MAIN NARRATIVE: WHO WE ARE -->
    <section class="about-story-section">
        <div class="container">
            <div class="row align-items-center">

                <div class="col-lg-6 col-12 mb-5 mb-lg-0" data-aos="fade-right">
                    <div class="about-story-content">
                        <span class="section-badge">Our Heritage & Manifesto</span>
                        <h2>A Passionate Strive for Knitwear Perfection</h2>

                        <blockquote class="about-quote">
                            &ldquo;Living to its name, RAGE for the past 15 years has dedicatedly and passionately strived to bring the best of knitwear and apparel to an ever growing fashion conscious client.&rdquo;
                        </blockquote>

                        <p class="story-lead">
                            With the huge manifesto of 30 Exclusive Brand Outlets (EBOs) and over 500 Multi-Brand Outlets (MBOs) and prestigious departmental stores throughout India accounting for its parent company <strong>RAGE KNIT</strong>, our brand represents an uncompromising commitment to sartorial quality and modern Indian craftsmanship.
                        </p>

                        <p>
                            Our comprehensive merchandise repertoire includes exquisitely styled <strong>cardigans, knitted tops, woven blouses, dresses, tunics, jumpers, capes, and ponchos</strong> for women. Believing that sophistication should know no boundaries, we also take immense pride in offering fine merchandise in thoughtfully proportioned <strong>plus size clothing</strong>.
                        </p>

                        <div class="story-highlights">
                            <div class="highlight-item">
                                <i class="fa-solid fa-industry"></i>
                                <div>
                                    <h6>Ludhiana</h6>
                                    <p>Comprehensive manufacturing unit with the world's most modern knitting and finishing machinery.</p>
                                </div>
                            </div>
                            <div class="highlight-item">
                                <i class="fa-solid fa-compass-drafting"></i>
                                <div>
                                    <h6>In-House Creative</h6>
                                    <p>A dedicated team of pattern masters, textile engineers, and visionary fashion designers.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-12" data-aos="fade-left">
                    <div class="about-visual-wrap">
                        <div class="about-img-main">
                            <img src="{{ asset('assets/images/Craft.png') }}" alt="Rage Craftsmanship">
                        </div>
                        <div class="about-floating-badge">
                            <span class="badge-accent">Parent Company</span>
                            <h4>RAGE KNIT</h4>
                            <p>Ludhiana &bull; Punjab &bull; India</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- CTA INVITATION -->
    <section class="about-cta-section" data-aos="fade-up">
        <div class="container-fluid">
            <div class="about-cta-box text-center">
                <span class="cta-subtitle">Experience The House of Rage</span>
                <h2>Step Into Our World of Warmth & Elegance</h2>
                <p>Discover signature cardigans, sculpted capes, fine tunics, and our exclusive plus-size curations.</p>
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