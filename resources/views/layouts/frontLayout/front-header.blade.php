<?php
    use App\Cart;
    use App\Category;
    use App\Product;

    $totalItems = Cart::totalItems();
    $categories = Category::getcategories();
    $cartitems = Cart::cartitems();
    $cart_count = count($cartitems);
    $subtotal = 0;
	

$categories = Category::getcategories();

$featured_by_category = [];

foreach ($categories as $category) {

    $featured_by_category[$category['id']] = Product::with(['category','product_image'])->select('id','category_id','product_name','seo_url','current_discount','product_discount','product_price','special_price','new_arrival','best_seller')->where('category_id', $category['id'])
        ->where('is_featured', 'Yes')
        ->where('status', 1)
        ->limit(6)
        ->get();

    if (!empty($category['subcategories'])) {
        foreach ($category['subcategories'] as $subcategory) {
            $featured_by_category[$subcategory['id']] = Product::with(['category','product_image'])->select('id','category_id','product_name','seo_url','current_discount','product_discount','product_price','special_price','new_arrival','best_seller')->where('category_id', $subcategory['id'])
                ->where('is_featured', 'Yes')
                ->where('status', 1)
                ->limit(6)
                ->get();
        }
    }
}
	
	$featured_by_category = array_filter($featured_by_category, function ($products) {
        return $products->isNotEmpty();
    });
	$featured_by_category = json_decode(json_encode($featured_by_category),true);
	//pd($featured_by_category);

	$search_overlay_products = Product::with(['attributes','productimages','category'])->where(['status'=>1])->orderby('id','DESC')->skip(0)->take(6)->get();
	
	
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

                <a @if(Auth::check()) href="{{ url('account/wishlists') }}" @else href="{{ url('login') }}" @endif aria-label="Wishlist">
                    <i class="fa-regular fa-heart"></i>
                </a>

                <a @if(Auth::check()) href="{{ url('account/dashboard') }}" @else href="{{ url('login') }}" @endif aria-label="Account">
                    <i class="fa-regular fa-user"></i>
                </a>

                <a href="{{ url('cart') }}" class="bag-link">
                    BAG<span class="totalItems">({{ $totalItems }})</span>
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
                <form id="rageSearchForm" action="{{ url('results') }}" method="GET" onsubmit="return false;">
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

                @foreach($categories as $category)

                    <button type="button" class="search-tag-btn" data-tag="{{ $category['name'] }}">{{ $category['name'] }}</button>

                    @if(!empty($category['subcategories']))
                        @foreach($category['subcategories'] as $subcategory)
                            <button type="button" class="search-tag-btn" data-tag="{{ $subcategory['name'] }}">{{ $subcategory['name'] }}</button>
                        @endforeach
                    @endif

                @endforeach

            </div>

            <!-- Live Results Container -->
            <div class="rage-search-results-section">
                <div class="rage-search-results-header">
                    <h5 id="rageSearchStatusTitle">Featured Products</h5>
                    <span class="results-badge" id="rageSearchResultsCount">{{ count($search_overlay_products) }} {{ count($search_overlay_products) == 1 ? 'product' : 'products' }}</span>
                </div>

                <!-- Product Grid (latest 10 active products) -->
                <!-- Dynamic Product Cards Start -->
                <div class="rage-search-grid" id="rageSearchGrid" style="display: grid;">

                    @foreach($search_overlay_products as $product)
                        <a href="{{ url('product/'.$product->seo_url) }}" class="search-prod-card" data-category="{{ $product->category->name ?? '' }}">
                            <div class="search-prod-img-wrap">
                                <img src="{{ asset('images/ProductImages/xlarge/'.($product->productimages->first()->image ?? '')) }}" alt="{{ $product->product_name }}" loading="lazy">
                            </div>
                            <div class="search-prod-info">
                                <span class="search-prod-cat">{{ $product->category->name ?? '' }}</span>
                                <h6 class="search-prod-title">{{ $product->product_name }}</h6>
                                <div class="search-prod-price-wrap">
                                    {!! productPriceHtml($product) !!}
                                </div>
                            </div>
                        </a>
                    @endforeach

                </div>
                <!-- Dynamic Product Cards End -->

                <!-- Empty State -->
                <div class="rage-search-empty" id="rageSearchEmpty" style="display: none;">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <h4>No products found</h4>
                    <p>We couldn't find any piece matching your search. Try searching for "Kurta", "Co-ord", "Velvet", or "Coat".</p>
                </div>
                <!-- View All Button -->
                <div class="rage-search-footer" id="rageSearchFooter" style="display: none;">
                    <a href="javascript:;" class="rage-search-view-all-btn" id="rageSearchViewAllBtn">
                        <span>View All Results</span>
                        <i class="fa-solid fa-arrow-right-long"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    (function() {
        var searchInput = document.getElementById('rageSearchInput');
        var searchClearBtn = document.getElementById('rageSearchClearBtn');
        var grid = document.getElementById('rageSearchGrid');
        var emptyState = document.getElementById('rageSearchEmpty');
        var footer = document.getElementById('rageSearchFooter');
        var viewAllBtn = document.getElementById('rageSearchViewAllBtn');
        var countBadge = document.getElementById('rageSearchResultsCount');
        var statusTitle = document.getElementById('rageSearchStatusTitle');
        var defaultGridHtml = grid ? grid.innerHTML : '';
        var defaultCount = countBadge ? countBadge.textContent : '';
        var defaultTitle = statusTitle ? statusTitle.textContent : '';
        var defaultViewAllHref = viewAllBtn ? viewAllBtn.getAttribute('href') : '';
        var debounceTimer = null;

        if (!searchInput) return;

        function resetToDefault() {
            grid.innerHTML = defaultGridHtml;
            grid.style.display = 'grid';
            if (emptyState) emptyState.style.display = 'none';
            if (footer) footer.style.display = 'none';
            if (countBadge) countBadge.textContent = defaultCount;
            if (statusTitle) statusTitle.textContent = defaultTitle;
            if (viewAllBtn) viewAllBtn.setAttribute('href', defaultViewAllHref);
        }

        function runSearch(query) {
            // Loading state while the real request is in flight
            grid.innerHTML = '<div class="rage-search-loading"><i class="fa-solid fa-spinner fa-spin"></i><span>Finding pieces...</span></div>';
            grid.style.display = 'grid';
            if (emptyState) emptyState.style.display = 'none';
            if (footer) footer.style.display = 'none';
            if (statusTitle) statusTitle.textContent = 'Searching for "' + query + '"';

            fetch('{{ url("search-suggestions") }}?q=' + encodeURIComponent(query))
                .then(function(res) { return res.json(); })
                .then(function(data) {
                    if (statusTitle) statusTitle.textContent = 'Search results for "' + query + '"';
                    if (viewAllBtn) viewAllBtn.setAttribute('href', '{{ url("results") }}?q=' + encodeURIComponent(query));

                    if (data.status && data.count > 0) {
                        grid.innerHTML = data.html;
                        grid.style.display = 'grid';
                        if (emptyState) emptyState.style.display = 'none';
                        if (countBadge) {
                            countBadge.textContent = 'Showing top ' + data.count + ' of ' + data.total + (data.total == 1 ? ' item' : ' items');
                        }
                        if (footer) {
                            footer.style.display = (data.total > data.count) ? 'block' : 'none';
                        }
                    } else {
                        grid.innerHTML = '';
                        grid.style.display = 'none';
                        if (emptyState) emptyState.style.display = 'block';
                        if (countBadge) countBadge.textContent = 'Showing top 0 of 0 items';
                        if (footer) footer.style.display = 'none';
                    }
                })
                .catch(function() {
                    // real network/server error - show the empty state honestly,
                    // no fake fallback results
                    grid.innerHTML = '';
                    grid.style.display = 'none';
                    if (emptyState) emptyState.style.display = 'block';
                    if (countBadge) countBadge.textContent = 'Showing top 0 of 0 items';
                    if (footer) footer.style.display = 'none';
                });
        }

        searchInput.addEventListener('input', function() {
            var query = this.value.trim();

            if (searchClearBtn) {
                searchClearBtn.style.display = query.length > 0 ? 'inline-block' : 'none';
            }

            clearTimeout(debounceTimer);

            if (query.length < 3) {
                resetToDefault();
                return;
            }

            debounceTimer = setTimeout(function() {
                runSearch(query);
            }, 350);
        });

        if (searchClearBtn) {
            searchClearBtn.addEventListener('click', function() {
                searchInput.value = '';
                searchClearBtn.style.display = 'none';
                clearTimeout(debounceTimer);
                resetToDefault();
                searchInput.focus();
            });
        }

        // Trending Searches tags: clicking one runs the search immediately,
        // same as typing it, no debounce needed since it's a deliberate click.
        document.querySelectorAll('.search-tag-btn').forEach(function(btn) {
            btn.addEventListener('click', function() {
                var tag = this.getAttribute('data-tag');

                document.querySelectorAll('.search-tag-btn').forEach(function(b) {
                    b.classList.remove('active');
                });
                this.classList.add('active');

                searchInput.value = tag;
                searchInput.focus();
                if (searchClearBtn) searchClearBtn.style.display = 'inline-block';

                clearTimeout(debounceTimer);
                runSearch(tag);
            });
        });
    })();
</script>




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
                                <a href="{{ url('/'.$subcategory['seo_unique']) }}">
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