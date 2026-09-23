@extends('layouts.frontLayout.front-layout')
@section('content')

<main class="inner-page store-locator-page">
    <div class="container">

        <!-- HEADER & BREADCRUMBS -->
        <section class="locator-header-section" data-aos="fade-up">
            <div class="detail-breadcrumb">
                <a href="{{ route('home') }}">Home</a>
                <span>/</span>
                <span>Store Locator</span>
            </div>
            <span class="locator-pretitle">Experience Rage In Person</span>
            <h1 class="locator-title">Store Locator</h1>
        </section>

        <!-- TABS SWITCHER -->
        <div class="locator-tabs-wrapper" data-aos="fade-up" data-aos-delay="100">
            <div class="locator-tabs-nav" role="tablist">
                <button type="button" class="locator-tab-btn @if(!isset($_GET['state'])) active @endif" id="tabBtnEbo" onclick="switchLocatorTab('ebo')">
                    <i class="fa-solid fa-store"></i>
                    <span>All Outlets</span>
                    <span class="tab-count-badge">13 Outlets</span>
                </button>
                <button type="button" class="locator-tab-btn @if(isset($_GET['state'])) active @endif" id="tabBtnMbo" onclick="switchLocatorTab('mbo')">
                    <i class="fa-solid fa-shop"></i>
                    <span>Find By State & City</span>
                </button>
            </div>
        </div>

        <!-- TAB 1: EBO (static content - not DB-driven) -->
        <div id="eboTabPanel" class="locator-tab-panel @if(!isset($_GET['state'])) active @endif">

            <!-- Quick City Filter Pills -->
            <div class="ebo-filter-row" data-aos="fade-up">
                <span class="ebo-filter-label"><i class="fa-solid fa-filter me-1"></i> Filter By City:</span>
                <button type="button" class="ebo-pill active" onclick="filterEboStores('all', this)">All Outlets</button>
                <button type="button" class="ebo-pill" onclick="filterEboStores('Amritsar', this)">Amritsar</button>
                <button type="button" class="ebo-pill" onclick="filterEboStores('Barnala', this)">Barnala</button>
                <button type="button" class="ebo-pill" onclick="filterEboStores('Moga', this)">Moga</button>
                <button type="button" class="ebo-pill" onclick="filterEboStores('Jalandhar', this)">Jalandhar</button>
                <button type="button" class="ebo-pill" onclick="filterEboStores('Kharar', this)">Kharar</button>
                <button type="button" class="ebo-pill" onclick="filterEboStores('Dharamshala', this)">Dharamshala</button>
                <button type="button" class="ebo-pill" onclick="filterEboStores('Jammu', this)">Jammu</button>
                <button type="button" class="ebo-pill" onclick="filterEboStores('Ludhiana', this)">Ludhiana</button>
            </div>

            <!-- Stores Grid -->
            <div class="ebo-grid" id="eboGrid" data-aos="fade-up" data-aos-delay="100">

                <div class="ebo-card" data-city="Amritsar">
                    <h4>Amritsar, Punjab</h4>
                    <div class="ebo-info-list">
                        <div class="ebo-info-item">
                            <i class="fa-solid fa-location-dot"></i>
                            <span>Lawrance Road, Novelty Chowk, Landmark Novelty Sweet</span>
                        </div>
                    </div>
                </div>

                <div class="ebo-card" data-city="Amritsar">
                    <h4>Amritsar, Punjab</h4>
                    <div class="ebo-info-list">
                        <div class="ebo-info-item">
                            <i class="fa-solid fa-location-dot"></i>
                            <span>Countryside Factory Outlet, Manawala, Near Delhi Public School, 143115</span>
                        </div>
                    </div>
                </div>

                <div class="ebo-card" data-city="Barnala">
                    <h4>Barnala, Punjab</h4>
                    <div class="ebo-info-list">
                        <div class="ebo-info-item">
                            <i class="fa-solid fa-location-dot"></i>
                            <span>HG Eaton Plaza, Opp 5 Star Diamond Dhaba, Handiaya Chowk, Handiaya, 148107</span>
                        </div>
                    </div>
                </div>

                <div class="ebo-card" data-city="Moga">
                    <h4>Moga, Punjab</h4>
                    <div class="ebo-info-list">
                        <div class="ebo-info-item">
                            <i class="fa-solid fa-location-dot"></i>
                            <span>Rage Showroom, Eaton Plaza, GT Road, Near KFC, Bughipura Chowk</span>
                        </div>
                    </div>
                </div>

                <div class="ebo-card" data-city="Jalandhar">
                    <h4>Jalandhar, Punjab</h4>
                    <div class="ebo-info-list">
                        <div class="ebo-info-item">
                            <i class="fa-solid fa-location-dot"></i>
                            <span>Rage Knit Eastwood Village, Shop No. A-70, G.T. Road, Khajrula, 144411</span>
                        </div>
                    </div>
                </div>

                <div class="ebo-card" data-city="Kharar">
                    <h4>Kharar, Punjab</h4>
                    <div class="ebo-info-list">
                        <div class="ebo-info-item">
                            <i class="fa-solid fa-location-dot"></i>
                            <span>Shop No. 13, Ground Floor, Amayra Emporio, NH-205, Kharar Kurali Road, 140301</span>
                        </div>
                    </div>
                </div>

                <div class="ebo-card" data-city="Dharamshala">
                    <h4>Dharamshala, Himachal Pradesh</h4>
                    <div class="ebo-info-list">
                        <div class="ebo-info-item">
                            <i class="fa-solid fa-location-dot"></i>
                            <span>Maximus Mall, Shop No. 7, 6878 + MRX, MDR44, Chilgari, 176215</span>
                        </div>
                    </div>
                </div>

                <div class="ebo-card" data-city="Jammu">
                    <h4>Jammu, Jammu &amp; Kashmir</h4>
                    <div class="ebo-info-list">
                        <div class="ebo-info-item">
                            <i class="fa-solid fa-location-dot"></i>
                            <span>Opp Sec-3 Shopping Complex, Near Railway Track, Ishwar Road, Shanker Market, Channi Himmat, 180015</span>
                        </div>
                    </div>
                </div>

                <div class="ebo-card" data-city="Ludhiana">
                    <h4>Ludhiana, Punjab</h4>
                    <div class="ebo-info-list">
                        <div class="ebo-info-item">
                            <i class="fa-solid fa-location-dot"></i>
                            <span>435-L, Gulati Chowk, Model Town, 141002</span>
                        </div>
                    </div>
                </div>

                <div class="ebo-card" data-city="Ludhiana">
                    <h4>Ludhiana, Punjab</h4>
                    <div class="ebo-info-list">
                        <div class="ebo-info-item">
                            <i class="fa-solid fa-location-dot"></i>
                            <span>Shop No. 3, Carnival Complex, Mall Road</span>
                        </div>
                    </div>
                </div>

                <div class="ebo-card" data-city="Ludhiana">
                    <h4>Ludhiana, Punjab</h4>
                    <div class="ebo-info-list">
                        <div class="ebo-info-item">
                            <i class="fa-solid fa-location-dot"></i>
                            <span>Shop No. LG-10, Ground Floor, Westend Mall, Ferozpur Road</span>
                        </div>
                    </div>
                </div>

                <div class="ebo-card" data-city="Ludhiana">
                    <h4>Ludhiana, Punjab</h4>
                    <div class="ebo-info-list">
                        <div class="ebo-info-item">
                            <i class="fa-solid fa-location-dot"></i>
                            <span>Shop No. 05 of Unit 02, V.P.O. Heeran, Chandigarh-Ludhiana Highway, 141112</span>
                        </div>
                    </div>
                </div>

                <div class="ebo-card" data-city="Ludhiana">
                    <h4>Ludhiana, Punjab</h4>
                    <div class="ebo-info-list">
                        <div class="ebo-info-item">
                            <i class="fa-solid fa-location-dot"></i>
                            <span>10-B, Block-B, Sarabha Nagar, Malhar Road</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- TAB 2: FIND BY STATE & CITY -->
        <div id="mboTabPanel" class="locator-tab-panel @if(isset($_GET['state'])) active @endif">

            <!-- State & City Selectors -->
            <div class="mbo-filter-card" data-aos="fade-up">
                <h3 class="mbo-filter-title">Find Partner Departmental Stores Near You</h3>
                <div class="row g-3">
                    <div class="col-md-6 col-12">
                        <label for="mboStateSelect" class="mbo-select-label">
                            <i class="fa-solid fa-map-location-dot me-1 text-muted"></i> Select State
                        </label>
                        <select id="mboStateSelect" name="state" class="form-select mbo-select" onChange="window.location.href='{{ url('store-locator') }}?state=' + escape(this[selectedIndex].value)">
                            <option value="">Select State</option>
                            @foreach($state_list as $state)
                            <option value="{{ $state['state'] }}" <?php if (isset($_GET['state'])) { if ($_GET['state'] == $state['state']) { echo 'selected'; } } ?>>{{ $state['state'] }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 col-12">
                        <label for="mboCitySelect" class="mbo-select-label">
                            <i class="fa-solid fa-city me-1 text-muted"></i> Select City
                        </label>
                        <select id="mboCitySelect" name="city" class="form-select mbo-select" onChange="window.location.href='{{ url('store-locator') }}?state=<?php if (isset($_GET['state'])) { echo $_GET['state']; } ?>&city=' + escape(this[selectedIndex].value)">
                            <option value="">Select City</option>
                            @foreach($city_list as $city)
                            <option value="{{ $city['city1'] }}" <?php if (isset($_GET['city'])) { if ($_GET['city'] == $city['city1']) { echo 'selected'; } } ?>>{{ $city['city1'] }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="mbo-results-bar">
                    <span id="mboCountLabel">
                        @if(isset($_GET['city']) && $_GET['city'] != '' && isset($_GET['state']) && $_GET['state'] != '')
                            {{ count($store_locations) == 0 ? 'No stores found in this city' : count($store_locations).' store(s) found' }}
                        @else
                            Select a state and city to find partner stores
                        @endif
                    </span>
                    <span><i class="fa-solid fa-circle-info me-1 text-muted"></i> Sells genuine Rage merchandise</span>
                </div>
            </div>

            @if(isset($_GET['city']) && $_GET['city'] != '' && isset($_GET['state']) && $_GET['state'] != '')
            <!-- Stores List & Embedded Map Split Row -->
            <div class="row g-4" data-aos="fade-up" data-aos-delay="100">

                <!-- Left: Stores List -->
                <div class="col-lg-7 col-12">
                    <div class="mbo-stores-container" id="mboStoresList">
                        @foreach($store_locations as $store_location)
                        <div class="ebo-card">
                            <h4>{{ $store_location['city1'] }}, {{ $store_location['state'] }}</h4>
                            <div class="ebo-info-list">
                                <div class="ebo-info-item">
                                    <i class="fa-solid fa-location-dot"></i>
                                    <span>{{ $store_location['address'] }}</span>
                                </div>
                                @if(!empty($store_location['phone']))
                                <a href="tel:{{ $store_location['phone'] }}" class="ebo-info-item">
                                    <i class="fa-solid fa-phone"></i>
                                    <span>{{ $store_location['phone'] }}</span>
                                </a>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Right: Embedded Google Map -->
                <div class="col-lg-5 col-12">
                    <div class="mbo-map-container">
                        <iframe id="mboMapFrame"
                                title="Store Location Map"
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d54762.98128701653!2d75.81550980309885!3d30.92339063718933!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x391a83b2d4b0d52b%3A0xf60599b5a3ef7109!2sRage!5e0!3m2!1sen!2sin!4v1660903963441!5m2!1sen!2sin"
                                width="100%" height="400" style="border:0;" allowfullscreen=""
                                loading="lazy">
                        </iframe>
                    </div>
                </div>

            </div>
            @endif

        </div>

    </div>
</main>
@stop

@section('javascript')
@parent
<script>
    function switchLocatorTab(tab) {
        document.getElementById('tabBtnEbo').classList.remove('active');
        document.getElementById('tabBtnMbo').classList.remove('active');
        document.getElementById('eboTabPanel').classList.remove('active');
        document.getElementById('mboTabPanel').classList.remove('active');

        if (tab === 'ebo') {
            document.getElementById('tabBtnEbo').classList.add('active');
            document.getElementById('eboTabPanel').classList.add('active');
        } else {
            document.getElementById('tabBtnMbo').classList.add('active');
            document.getElementById('mboTabPanel').classList.add('active');
        }
    }

    function filterEboStores(city, btn) {
        document.querySelectorAll('.ebo-pill').forEach(function(p) {
            p.classList.remove('active');
        });
        btn.classList.add('active');

        document.querySelectorAll('#eboGrid .ebo-card').forEach(function(card) {
            if (city === 'all' || card.getAttribute('data-city') === city) {
                card.style.display = '';
            } else {
                card.style.display = 'none';
            }
        });
    }
</script>
@stop