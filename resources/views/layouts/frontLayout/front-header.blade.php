<?php use App\Cart; use App\Category;
   $totalItems = Cart::totalItems();
   
   $categories = Category::getcategories(); 
   
   $cartitems = Cart::cartitems();
   
   $cart_count = count($cartitems);
   
   $subtotal = 0; 
   
   ?>
  <header class="main-header" id="mainHeader">
    <div class="container-fluid">
        <div class="header-wrap">

            <!-- Left -->
            <div class="header-left">
                <button class="menu-btn" type="button" data-bs-toggle="offcanvas" data-bs-target="#rageMenu">
                    <span class="menu-lines">
                        <span></span>
                        <span></span>
                    </span>
                    <span class="menu-text">MENU</span>
                </button>

                <a href="{{ route('home') }}" class="brand-logo">
                    <img src="{{ asset('assets/images/logo-w.png') }}" alt="">
                </a>
            </div>

            <!-- Right -->
            <div class="header-actions">

                <a href="javascript:void(0)" class="search-trigger" id="rageSearchTrigger" aria-label="Search" role="button">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </a>

                <a href="wishlist.php" aria-label="Wishlist">
                    <i class="fa-regular fa-heart"></i>
                </a>

                <a href="my-profile.php" aria-label="Account">
                    <i class="fa-regular fa-user"></i>
                </a>

                <a href="{{ url('cart') }}" class="bag-link">
                    BAG<span>(2)</span>
                </a>

            </div>

        </div>
    </div>
</header>

<!-- Luxury Search Modal / Overlay -->
<div class="rage-search-overlay" id="rageSearchOverlay" aria-hidden="true">
    <div class="rage-search-backdrop" id="rageSearchBackdrop"></div>
    <div class="rage-search-panel">
        <div class="container-fluid">
            <!-- Search Top Bar -->
            <div class="rage-search-topbar">
                <div class="rage-search-brand">
                    <img src="{{ asset('assets/images/logo.png') }}" alt="Rage">
                    <span class="rage-search-label">Curated Search</span>
                </div>
                <button type="button" class="rage-search-close-btn" id="rageSearchCloseBtn" aria-label="Close search">
                    <span>CLOSE</span>
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>

            <!-- Search Form / Input -->
            <div class="rage-search-form-wrap">
                <form id="rageSearchForm" action="listing.php" method="GET" onsubmit="return false;">
                    <div class="rage-search-input-group">
                        <i class="fa-solid fa-magnifying-glass search-icon"></i>
                        <input type="text" 
                               id="rageSearchInput" 
                               name="q" 
                               placeholder="Search kurtas, co-ords, coats, silk jackets..." 
                               autocomplete="off" 
                               spellcheck="false">
                        <button type="button" class="rage-search-clear-btn" id="rageSearchClearBtn" aria-label="Clear search">
                            <i class="fa-solid fa-circle-xmark"></i>
                        </button>
                    </div>
                </form>
            </div>

            <!-- Quick Suggestions / Trending Tags -->
            <div class="rage-search-tags">
                <span class="tags-title">Trending Searches:</span>
                <button type="button" class="search-tag-btn" data-tag="Velvet Kurta">Velvet Kurta</button>
                <button type="button" class="search-tag-btn" data-tag="Co-Ord">Co-Ord Sets</button>
                <button type="button" class="search-tag-btn" data-tag="Cardigans">Cardigans</button>
                <button type="button" class="search-tag-btn" data-tag="Wool Coat">Wool Coats</button>
                <button type="button" class="search-tag-btn" data-tag="Poncho">Poncho & Cape</button>
                <button type="button" class="search-tag-btn" data-tag="Luxe">Rage Luxe</button>
            </div>

            <!-- Live Results Container -->
            <div class="rage-search-results-section">
                <div class="rage-search-results-header">
                    <h5 id="rageSearchStatusTitle">Featured Products</h5>
                    <span class="results-badge" id="rageSearchResultsCount">Top 6 products</span>
                </div>

                <!-- Product Grid (Top 6) -->
                <div class="rage-search-grid" id="rageSearchGrid">
                    <!-- Dynamic Product Cards Injected Here by JS -->
                </div>

                <!-- Empty State -->
                <div class="rage-search-empty" id="rageSearchEmpty" style="display: none;">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <h4>No products found</h4>
                    <p>We couldn't find any piece matching your search. Try searching for "Kurta", "Co-ord", "Velvet", or "Coat".</p>
                </div>

                <!-- View All Button -->
                <div class="rage-search-footer" id="rageSearchFooter">
                    <a href="listing.php" class="rage-search-view-all-btn" id="rageSearchViewAllBtn">
                        <span>View All Products</span>
                        <i class="fa-solid fa-arrow-right-long"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Creative Offcanvas Menu -->
<div class="offcanvas offcanvas-start rage-offcanvas" tabindex="-1" id="rageMenu">

    <div class="offcanvas-header">

        <a href="{{ route('home') }}" class="menu-logo"><img src="{{ asset('assets/images/logo.png') }}" alt=""></a>

        <button type="button" class="menu-close" data-bs-dismiss="offcanvas">
            <span></span>
            <span></span>
        </button>

    </div>


    <div class="offcanvas-body">

        <div class="menu-small-title">Explore Rage</div>

        <!-- Winter Collection -->
        <div class="menu-group">
           @foreach($categories as $category)
		    @if($category['seo_unique'] == 'winter-collection')
            <button class="collection-toggle"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#winterMenu"
                    aria-expanded="true">

                <span> 
                    {{ $category['name'] }}
                </span>

                <i class="fa-solid fa-chevron-up"></i>
            </button>
			@endif
            @endforeach

            <div class="collapse show" id="winterMenu">

                <div class="collection-links">
                    @foreach($categories as $category)
						@if($category['seo_unique'] == 'winter-collection')
						 @if(!empty($category['subcategories']))
					     @foreach($category['subcategories'] as $subcategory)
					     <a href="{{url('/'.$subcategory['seo_unique'])}}">
							<span>{{ $subcategory['name'] }}</span>
							<i class="fa-solid fa-arrow-right-long"></i>
						</a>
                          @endforeach
					   @endif
					   @endif
                  @endforeach


                </div>

            </div>

        </div>


        <!-- Main Links -->
        <nav class="main-menu">

            <a href="{{ url('rage-luxe') }}">
                <span>Rage Luxe</span>
            </a>

            <a href="{{ url('about-us') }}">
                <span>About Us</span>
            </a>

            <a href="{{ url('lookbook') }}">
                <span>Brand Ambassadors</span>
            </a>

            <a href="{{ url('new-arrivals') }}">
                <span>New Arrivals</span>
            </a>

            <a href="{{ url('store-locator') }}">
                <span>Store Locator</span>
            </a>

            <a href="{{ url('contact-us') }}">
                <span>Contact Us</span>
            </a>
        </nav>
    </div>
</div>
