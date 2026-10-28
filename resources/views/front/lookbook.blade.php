@extends('layouts.frontLayout.front-layout')
@section('content')

<main class="inner-page ambassadors-page">
    <div class="container">

        <!-- HEADER & BREADCRUMBS -->
        <section class="ambassadors-header" data-aos="fade-up">
            <div class="detail-breadcrumb">
                <a href="{{ route('home') }}">Home</a>
                <span>/</span>
                <span>Brand Ambassadors</span>
            </div>
            <span class="ambassadors-pretitle">Elegance Celebrated</span>
            <h1 class="ambassadors-title">Brand Ambassadors</h1>
        </section>

        <!-- AMBASSADORS GRID (CLEAN & MINIMAL) -->
        <div class="ambassadors-grid" data-aos="fade-up" data-aos-delay="100">

            <!-- 1. Katrina Kaif -->
            <div class="ambassador-card">
                <div class="ambassador-img-wrap">
                    <img src="{{ asset('assets/images/katrina-kaif.png') }}" alt="Katrina Kaif in Rage">
                </div>
                <div class="ambassador-content">
                    <span class="ambassador-tag">Actor & Style Icon</span>
                    <h3>Katrina Kaif</h3>
                    <p class="ambassador-desc">Radiating timeless grace in signature handcrafted knitwear and luxury silhouettes by Rage.</p>
                </div>
            </div>

            <!-- 2. Jacqueline Fernandez -->
            <div class="ambassador-card">
                <div class="ambassador-img-wrap">
                    <img src="{{ asset('assets/images/Jacqueline.png') }}" alt="Jacqueline Fernandez in Rage">
                </div>
                <div class="ambassador-content">
                    <span class="ambassador-tag">Leading Screen Actor</span>
                    <h3>Jacqueline Fernandez</h3>
                    <p class="ambassador-desc">Embodying contemporary vivacity and architectural knitwear artistry in the Rage winter edit.</p>
                </div>
            </div>

            <!-- 3. Amyra Dastur -->
            <div class="ambassador-card">
                <div class="ambassador-img-wrap">
                    <img src="{{ asset('assets/images/Amyra.png') }}" alt="Amyra Dastur in Rage">
                </div>
                <div class="ambassador-content">
                    <span class="ambassador-tag">Actor & Fashion Maven</span>
                    <h3>Giselle Montiro</h3>
                    <p class="ambassador-desc">Channelling refined ease and high-fashion elegance in artisanal tunics and sculpted cardigans.</p>
                </div>
            </div>

            <!-- 4. Urvashi Sharma -->
            <div class="ambassador-card">
                <div class="ambassador-img-wrap">
                    <img src="{{ asset('assets/images/Urvashi.png') }}" alt="Urvashi Sharma in Rage">
                </div>
                <div class="ambassador-content">
                    <span class="ambassador-tag">Actor & Muse</span>
                    <h3>Urvashi Sharma</h3>
                    <p class="ambassador-desc">Celebrating classic charm and premium woolen drape crafted at our Ludhiana atelier.</p>
                </div>
            </div>

            <!-- 5. Jenniffer Piccinato -->
            <div class="ambassador-card">
                <div class="ambassador-img-wrap">
                    <img src="{{ asset('assets/images/Jenniffer.png') }}" alt="Jenniffer Piccinato in Rage">
                </div>
                <div class="ambassador-content">
                    <span class="ambassador-tag">International Model</span>
                    <h3>Jenniffer Piccinato</h3>
                    <p class="ambassador-desc">Bringing cosmopolitan chic and sophisticated modern knit aesthetics to the House of Rage.</p>
                </div>
            </div>

            <!-- 6. Alicia -->
            <div class="ambassador-card">
                <div class="ambassador-img-wrap">
                    <img src="{{ asset('assets/images/alicia.png') }}" alt="Alicia in Rage">
                </div>
                <div class="ambassador-content">
                    <span class="ambassador-tag">Runway Model & Muse</span>
                    <h3>Alicia Raut</h3>
                    <p class="ambassador-desc">Showcasing editorial grace in intricate winter co-ords and fine woven apparel.</p>
                </div>
            </div>


            <!-- 7. Farah Karimaee -->
            <div class="ambassador-card">
                <div class="ambassador-img-wrap">
                    <img src="{{ asset('assets/images/farah-karimee.jpg') }}" alt="Farah Karimaee in Rage">
                </div>
                <div class="ambassador-content">
                    <span class="ambassador-tag">Model & Actress</span>
                    <h3>Farah Karimee</h3>
                    <p class="ambassador-desc">Celebrating free-spirited elegance through expressive prints, rich textures, and effortlessly sophisticated winterwear.</p>
                </div>
            </div>

            <!-- 8. Angela Jonsson -->
            <div class="ambassador-card">
                <div class="ambassador-img-wrap">
                    <img src="{{ asset('assets/images/angela-jonsson.jpg') }}" alt="Angela Jonsson in Rage">
                </div>
                <div class="ambassador-content">
                    <span class="ambassador-tag">Model & Actress</span>
                    <h3>Angela Jonsson</h3>
                    <p class="ambassador-desc">Bringing bold patterns and vibrant knitwear together in a statement of modern elegance for the House of Rage.</p>
                </div>
            </div>

            <!-- 9. Sameera Reddy -->
            <div class="ambassador-card">
                <div class="ambassador-img-wrap">
                    <img src="{{ asset('assets/images/sameera-reddy.jpg') }}" alt="Sameera Reddy in Rage">
                </div>
                <div class="ambassador-content">
                    <span class="ambassador-tag">Actor & Style Icon</span>
                    <h3>Sameera Reddy</h3>
                    <p class="ambassador-desc">Embodying understated sophistication with refined knitwear and graceful silhouettes crafted for effortless everyday luxury.</p>
                </div>
            </div>

            <!-- 10. Amrit Maghera -->
            <div class="ambassador-card">
                <div class="ambassador-img-wrap">
                    <img src="{{ asset('assets/images/amrit-maghera.jpg') }}" alt="Amrit Maghera in Rage">
                </div>
                <div class="ambassador-content">
                    <span class="ambassador-tag">International Model & Actress</span>
                    <h3>Amrit Maghera</h3>
                    <p class="ambassador-desc">Blending urban edge with relaxed refinement through contemporary layers and versatile winter essentials.</p>
                </div>
            </div>

            <!-- 11. Izabelle Leite -->
            <div class="ambassador-card">
                <div class="ambassador-img-wrap">
                    <img src="{{ asset('assets/images/isabelle-leite.jpg') }}" alt="Izabelle Leite in Rage">
                </div>
                <div class="ambassador-content">
                    <span class="ambassador-tag">Model & Actress</span>
                    <h3>Izabelle Leite</h3>
                    <p class="ambassador-desc">Showcasing expressive knitwear and modern femininity through artistic detailing and effortlessly chic styling.</p>
                </div>
            </div>

        </div>

        <!-- MINIMAL CTA -->
        <div class="ambassador-cta-wrap" data-aos="fade-up">
            <h3>Step Into The Limelight</h3>
            <p>Explore the winter edit and signature knitwear pieces favored by our ambassadors.</p>
            <a href="{{ url('winter-collection') }}" class="ambassador-cta-btn">
                <span>Explore Collection</span>
                <i class="fa-solid fa-arrow-right-long"></i>
            </a>
        </div>

    </div>
</main>
@stop

@section('javascript')
@parent
@stop