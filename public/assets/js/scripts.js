// Rage Luxury Fashion E-Commerce - Main Scripts

// Header scroll state
const header = document.getElementById('mainHeader');
window.addEventListener('scroll', function () {
    if (header) {
        if (window.scrollY > 50) {
            header.classList.add('scrolled');
        } else {
            header.classList.remove('scrolled');
        }
    }
});

// Accordion arrow rotate for Offcanvas Menu
document.addEventListener('DOMContentLoaded', function () {
    const collectionToggle = document.querySelector('.collection-toggle');
    const winterMenu = document.getElementById('winterMenu');

    if (winterMenu && collectionToggle) {
        winterMenu.addEventListener('show.bs.collapse', function () {
            collectionToggle.classList.add('active');
        });

        winterMenu.addEventListener('hide.bs.collapse', function () {
            collectionToggle.classList.remove('active');
        });
    }
});

// Video banner controls
document.addEventListener('DOMContentLoaded', function () {
    const section = document.querySelector('.film-section');
    if (section) {
        const button = section.querySelector('.film-play');
        const video = section.querySelector('.film-video');

        if (button && video) {
            button.addEventListener('click', function () {
                section.classList.add('playing');
                video.currentTime = 0;
                video.play();
            });

            video.addEventListener('ended', function () {
                section.classList.remove('playing');
                video.currentTime = 0;
            });
        }
    }
});

// Swiper Sliders Initialization
document.addEventListener('DOMContentLoaded', function () {
    if (document.querySelector('.celebSwiper')) {
        new Swiper('.celebSwiper', {
            loop: true,
            speed: 900,
            spaceBetween: 16,
            autoplay: {
                delay: 3000,
                disableOnInteraction: false
            },
            breakpoints: {
                0: { slidesPerView: 1.2, spaceBetween: 10 },
                576: { slidesPerView: 2, spaceBetween: 12 },
                992: { slidesPerView: 4, spaceBetween: 16 }
            }
        });
    }

    if (document.querySelector('.relatedSwiper')) {
        new Swiper('.relatedSwiper', {
            slidesPerView: 4,
            spaceBetween: 16,
            loop: true,
            speed: 800,
            autoplay: {
                delay: 3500,
                disableOnInteraction: false,
                pauseOnMouseEnter: true
            },
            breakpoints: {
                0: { slidesPerView: 1.4, spaceBetween: 10 },
                576: { slidesPerView: 2, spaceBetween: 12 },
                768: { slidesPerView: 3, spaceBetween: 14 },
                1200: { slidesPerView: 4, spaceBetween: 16 }
            }
        });
    }

    if (document.querySelector('.recentSwiper')) {
        new Swiper('.recentSwiper', {
            slidesPerView: 4,
            spaceBetween: 16,
            loop: true,
            speed: 800,
            autoplay: {
                delay: 3500,
                disableOnInteraction: false,
                pauseOnMouseEnter: true
            },
            breakpoints: {
                0: { slidesPerView: 1.4, spaceBetween: 10 },
                576: { slidesPerView: 2, spaceBetween: 12 },
                768: { slidesPerView: 3, spaceBetween: 14 },
                1200: { slidesPerView: 4, spaceBetween: 16 }
            }
        });
    }
});

// Filter Drawer (Mobile)
document.addEventListener('DOMContentLoaded', function () {
    const openBtn = document.querySelector('.filter-open-btn');
    const closeBtn = document.querySelector('.filter-close-btn');
    const drawer = document.querySelector('.mobile-filter');
    const overlay = document.querySelector('.filter-overlay');

    if (openBtn && drawer && overlay) {
        openBtn.addEventListener('click', function () {
            drawer.classList.add('active');
            overlay.classList.add('active');
            document.body.style.overflow = 'hidden';
        });

        const closeFilter = function () {
            drawer.classList.remove('active');
            overlay.classList.remove('active');
            document.body.style.overflow = '';
        };

        if (closeBtn) closeBtn.addEventListener('click', closeFilter);
        overlay.addEventListener('click', closeFilter);
    }
});

// Fancybox Product Zoom
if (typeof Fancybox !== 'undefined') {
    Fancybox.bind('[data-fancybox="product-main"]', {
        Thumbs: false
    });
}

// Global Toast Notification Helper
window.RageToast = {
    show: function (message, icon = 'fa-check') {
        let toastContainer = document.getElementById('rageToastContainer');
        if (!toastContainer) {
            toastContainer = document.createElement('div');
            toastContainer.id = 'rageToastContainer';
            toastContainer.className = 'rage-toast-container';
            document.body.appendChild(toastContainer);
        }

        const toast = document.createElement('div');
        toast.className = 'rage-toast';
        toast.innerHTML = `<i class="fa-solid ${icon}"></i> <span>${message}</span>`;
        toastContainer.appendChild(toast);

        setTimeout(() => toast.classList.add('show'), 10);

        setTimeout(() => {
            toast.classList.remove('show');
            setTimeout(() => toast.remove(), 400);
        }, 3000);
    }
};

// Global Bag Count Manager
window.RageBag = {
    getCount: function () {
        const bagLink = document.querySelector('.bag-link span');
        if (bagLink) {
            const match = bagLink.innerText.match(/\d+/);
            return match ? parseInt(match[0]) : 2;
        }
        return 2;
    },
    increment: function (amount = 1) {
        const bagLink = document.querySelector('.bag-link span');
        if (bagLink) {
            const current = this.getCount();
            const updated = current + amount;
            bagLink.innerText = `(${updated})`;
            bagLink.classList.add('bump');
            setTimeout(() => bagLink.classList.remove('bump'), 500);
        }
    }
};

// Global Interactive Helpers (Quantity, Gallery, Accordions, Wishlist, Bag, OTP)
document.addEventListener('DOMContentLoaded', function () {

    // 1. Gallery Thumbnail Switcher
    const mainImage = document.getElementById('mainProductImage');
    const mainImageLink = document.querySelector('.main-image-link');
    document.querySelectorAll('.gallery-thumbs .thumb').forEach(function (thumb) {
        thumb.addEventListener('click', function () {
            document.querySelectorAll('.gallery-thumbs .thumb').forEach(t => t.classList.remove('active'));
            this.classList.add('active');
            const imgEl = this.querySelector('img');
            if (imgEl && mainImage) {
                mainImage.src = imgEl.src;
                if (mainImageLink) mainImageLink.href = imgEl.src;
            }
        });
    });

    // 2. Quantity Box (works across all quantity boxes on all pages)
    document.querySelectorAll('.quantity-box').forEach(function (box) {
        const minusBtn = box.querySelector('.qty-minus');
        const plusBtn = box.querySelector('.qty-plus');
        const input = box.querySelector('input');

        if (minusBtn && plusBtn && input) {
            minusBtn.addEventListener('click', function (e) {
                e.preventDefault();
                let qty = parseInt(input.value) || 1;
                if (qty > 1) {
                    input.value = qty - 1;
                    input.dispatchEvent(new Event('change'));
                }
            });

            plusBtn.addEventListener('click', function (e) {
                e.preventDefault();
                let qty = parseInt(input.value) || 1;
                input.value = qty + 1;
                input.dispatchEvent(new Event('change'));
            });
        }
    });

    // 3. Accordion toggle
    document.querySelectorAll('.accordion-head').forEach(function (button) {
        button.addEventListener('click', function () {
            const item = button.closest('.accordion-item');
            if (item) item.classList.toggle('active');
        });
    });

    // 4. Copy Promo Coupon
    document.querySelectorAll('.copy-coupon').forEach(function (button) {
        button.addEventListener('click', function () {
            const code = this.getAttribute('data-code') || 'RAGE10';
            navigator.clipboard.writeText(code);
            this.innerText = 'Copied!';
            this.style.background = '#287444';
            this.style.color = '#fff';

            // Auto-fill into coupon input if present
            const couponInput = document.querySelector('.coupon-input input');
            if (couponInput) {
                couponInput.value = code;
            }

            /*RageToast.show(`Coupon ${code} copied to clipboard!`); */

            setTimeout(() => {
                this.innerText = 'Copy';
                this.style.background = '';
                this.style.color = '';
            }, 2000);
        });
    });

    // 5. Wishlist Heart Toggle across all cards
    document.querySelectorAll('.prod-card .prod-img > a:not([class])').forEach(function (btn) { return false;
        btn.addEventListener('click', function (e) {
            e.preventDefault();
            const icon = this.querySelector('i');
            if (icon) {
                if (icon.classList.contains('fa-regular')) {
                    icon.classList.remove('fa-regular');
                    icon.classList.add('fa-solid');
                    icon.style.color = '#932f2f';
                    RageToast.show('Item added to your Wishlist!', 'fa-heart');
                } else {
                    icon.classList.remove('fa-solid');
                    icon.classList.add('fa-regular');
                    icon.style.color = '';
                    RageToast.show('Item removed from Wishlist', 'fa-heart-crack');
                }
            }
        });
    });

    // 6. Add to Bag Buttons across catalog cards
    document.querySelectorAll('.link-btn.black').forEach(function (btn) { return true;
        if (btn.innerText.trim().toLowerCase() === 'add to cart') {
            btn.addEventListener('click', function (e) {
                e.preventDefault();
                const orig = this.innerText;
                this.innerHTML = '<i class="fa-solid fa-check"></i> Added';
                this.style.background = '#287444';
                RageBag.increment(1);
                RageToast.show('Piece added to your shopping bag!', 'fa-bag-shopping');
                setTimeout(() => {
                    this.innerHTML = orig;
                    this.style.background = '';
                }, 2000);
            });
        }
    });

    // 7. Detail Page: Add To Bag Button
    const detailAddBag = document.querySelector('.add-cart-btn');
    if (detailAddBag) {
        detailAddBag.addEventListener('click', function (e) { return false;
            e.preventDefault();
            const orig = this.innerHTML;
            this.innerHTML = '<i class="fa-solid fa-check"></i> Added To Bag';
            this.style.background = '#287444';
            RageBag.increment(1);
            RageToast.show('Added to Bag! Review in your Shopping Bag.', 'fa-bag-shopping');
            setTimeout(() => {
                this.innerHTML = orig;
                this.style.background = '';
            }, 2500);
        });
    }

    // 8. Detail Page: Size Selection
    document.querySelectorAll('.size-options label').forEach(function (lbl) {
        lbl.addEventListener('click', function () {
            document.querySelectorAll('.size-options label').forEach(l => l.classList.remove('active'));
            this.classList.add('active');
        });
    });

    // 9. Delivery Pincode Checker on Product Detail
    const pinBox = document.querySelector('.pincode-box');
    if (pinBox) {
        const pinInput = pinBox.querySelector('input');
        const pinBtn = pinBox.querySelector('button');
        const pinMsg = pinBox.parentElement.querySelector('p');

        if (pinBtn && pinInput && pinMsg) {
            pinBtn.addEventListener('click', function () {
                const val = pinInput.value.trim();
                if (val.length >= 5) {
                    pinBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i>';
                    setTimeout(() => {
                        pinBtn.innerHTML = 'Check';
                        pinMsg.innerHTML = `<span style="color:#287444; font-weight:500;"><i class="fa-solid fa-truck"></i> Delivery to <strong>${val}</strong>: Expected in 3–5 business days. Express White-Glove delivery eligible.</span>`;
                    }, 500);
                } else {
                    pinMsg.innerHTML = '<span style="color:#932f2f;">Please enter a valid 6-digit postal code.</span>';
                }
            });
        }
    }

    // 10. OTP auto-advance in Login/Auth
    const otpInputs = document.querySelectorAll('.otp-inputs input');
    if (otpInputs.length > 0) {
        otpInputs.forEach((input, index) => {
            input.addEventListener('input', (e) => {
                if (input.value.length === 1 && index < otpInputs.length - 1) {
                    otpInputs[index + 1].focus();
                }
            });
            input.addEventListener('keydown', (e) => {
                if (e.key === 'Backspace' && input.value === '' && index > 0) {
                    otpInputs[index - 1].focus();
                }
            });
        });
    }

    // 11. Checkout: Billing form toggle
    const billingSame = document.getElementById('billingSame');
    const billingForm = document.getElementById('billingForm');
    if (billingSame && billingForm) {
        function toggleBilling() {
            billingForm.style.display = billingSame.checked ? 'none' : 'block';
        }
        toggleBilling();
        billingSame.addEventListener('change', toggleBilling);
    }

    // 12. Luxury Search Overlay & Live Search (Top 6 Products + View All + Close)
    const searchTrigger = document.getElementById('rageSearchTrigger');
    const searchOverlay = document.getElementById('rageSearchOverlay');
    const searchBackdrop = document.getElementById('rageSearchBackdrop');
    const searchCloseBtn = document.getElementById('rageSearchCloseBtn');
    const searchInput = document.getElementById('rageSearchInput');
    const searchClearBtn = document.getElementById('rageSearchClearBtn');
    const searchGrid = document.getElementById('rageSearchGrid');
    const searchEmpty = document.getElementById('rageSearchEmpty');
    const searchStatusTitle = document.getElementById('rageSearchStatusTitle');
    const searchResultsCount = document.getElementById('rageSearchResultsCount');
    const searchViewAllBtn = document.getElementById('rageSearchViewAllBtn');
    const searchTagBtns = document.querySelectorAll('.search-tag-btn');
    const searchForm = document.getElementById('rageSearchForm');

    // Fallback static catalog for offline / static preview reliability
    const fallbackProducts = [
        {
            id: 1,
            name: 'Abeer Velvet Kurta',
            category: 'Kurti Sets',
            price: 'INR 1,48,000',
            original_price: 'INR 1,65,000',
            discount: '10% OFF',
            badge: 'New',
            image: 'assets/images/Product-Image-1.png',
            url: 'detail.php?id=1',
            tags: ['velvet', 'kurta', 'kurti', 'winter', 'embroidery', 'abeer', 'sets']
        },
        {
            id: 2,
            name: 'Noor Silk Co-Ord Set',
            category: 'Co-Ord',
            price: 'INR 1,32,000',
            original_price: 'INR 1,50,000',
            discount: '12% OFF',
            badge: 'Exclusive',
            image: 'assets/images/co-ord.png',
            url: 'detail.php?id=2',
            tags: ['co-ord', 'silk', 'sets', 'festive', 'noor', 'winter']
        },
        {
            id: 3,
            name: 'Zoya Hand-Embroidered Cardigan',
            category: 'Cardigans',
            price: 'INR 89,500',
            original_price: 'INR 98,000',
            discount: '8% OFF',
            badge: 'Trending',
            image: 'assets/images/Product-Image-2.png',
            url: 'detail.php?id=3',
            tags: ['cardigans', 'knitwear', 'warmth', 'zoya', 'wool', 'embroidered']
        },
        {
            id: 4,
            name: 'Heer Kashmiri Wool Coat',
            category: 'Coats',
            price: 'INR 1,85,000',
            original_price: 'INR 2,10,000',
            discount: '12% OFF',
            badge: 'Luxury',
            image: 'assets/images/Product-Image-3.png',
            url: 'detail.php?id=4',
            tags: ['coat', 'kashmiri', 'wool', 'winter', 'heer', 'outerwear', 'coats']
        },
        {
            id: 5,
            name: 'Gulzar Velvet Poncho & Cape',
            category: 'Poncho / Cape / Kaftan',
            price: 'INR 1,15,000',
            original_price: 'INR 1,28,000',
            discount: '10% OFF',
            badge: 'Bestseller',
            image: 'assets/images/top.png',
            url: 'detail.php?id=5',
            tags: ['poncho', 'cape', 'kaftan', 'velvet', 'gulzar', 'winter']
        },
        {
            id: 6,
            name: 'Meera Chanderi Tunic',
            category: 'Tops & Tunics',
            price: 'INR 74,000',
            original_price: 'INR 82,000',
            discount: '10% OFF',
            badge: 'New',
            image: 'assets/images/kurti.png',
            url: 'detail.php?id=6',
            tags: ['top', 'tunic', 'tops', 'tunics', 'chanderi', 'meera']
        },
        {
            id: 7,
            name: 'Rage Luxe Royal Anarkali Suit',
            category: 'Kurti Sets',
            price: 'INR 2,20,000',
            original_price: 'INR 2,45,000',
            discount: '10% OFF',
            badge: 'Exclusive',
            image: 'assets/images/Product-Image-1.png',
            url: 'detail.php?id=7',
            tags: ['luxe', 'anarkali', 'royal', 'suit', 'kurta', 'festive']
        },
        {
            id: 8,
            name: 'Kashvi Cashmere Wrap Shawl',
            category: 'Cardigans',
            price: 'INR 95,000',
            original_price: 'INR 1,05,000',
            discount: '9% OFF',
            badge: 'Winter Luxe',
            image: 'assets/images/Product-Image-2.png',
            url: 'detail.php?id=8',
            tags: ['cashmere', 'wrap', 'shawl', 'kashvi', 'winter', 'wool']
        },
        {
            id: 9,
            name: 'Sitara Jacquard Winter Jacket',
            category: 'Coats',
            price: 'INR 1,60,000',
            original_price: 'INR 1,75,000',
            discount: '8% OFF',
            badge: 'New',
            image: 'assets/images/Product-Image-3.png',
            url: 'detail.php?id=9',
            tags: ['jacquard', 'jacket', 'coat', 'winter', 'sitara']
        }
    ];

    let searchDebounceTimer = null;

    function openSearch() {
        if (!searchOverlay) return;
        searchOverlay.classList.add('active');
        searchOverlay.setAttribute('aria-hidden', 'false');
        document.body.style.overflow = 'hidden';

        setTimeout(() => {
            if (searchInput) {
                searchInput.focus();
                // If input is empty, perform initial search for top 6 featured
                if (!searchInput.value.trim() && searchGrid && searchGrid.children.length === 0) {
                    performSearch('');
                }
            }
        }, 120);
    }

    function closeSearch() {
        if (!searchOverlay) return;
        searchOverlay.classList.remove('active');
        searchOverlay.setAttribute('aria-hidden', 'true');
        document.body.style.overflow = '';
    }

    function renderProducts(products, totalCount, query) { return true;
        if (!searchGrid) return;
        searchGrid.innerHTML = '';

        if (!products || products.length === 0) {
            if (searchGrid) searchGrid.style.display = 'none';
            if (searchEmpty) searchEmpty.style.display = 'block';
            if (searchStatusTitle) searchStatusTitle.textContent = query ? `No results for "${query}"` : 'No products found';
            if (searchResultsCount) searchResultsCount.textContent = '0 products';
            if (searchViewAllBtn) {
                searchViewAllBtn.href = 'listing.php';
                searchViewAllBtn.querySelector('span').textContent = 'Explore All Products';
            }
            return;
        }

        if (searchGrid) searchGrid.style.display = 'grid';
        if (searchEmpty) searchEmpty.style.display = 'none';

        if (query) {
            if (searchStatusTitle) searchStatusTitle.textContent = `Search results for "${query}"`;
            if (searchResultsCount) searchResultsCount.textContent = `Showing top ${products.length} of ${totalCount} items`;
            if (searchViewAllBtn) {
                searchViewAllBtn.href = `listing.php?q=${encodeURIComponent(query)}`;
                searchViewAllBtn.querySelector('span').textContent = totalCount > products.length
                    ? `View All ${totalCount} Results`
                    : `View All Results`;
            }
        } else {
            if (searchStatusTitle) searchStatusTitle.textContent = 'Curated Top Picks';
            if (searchResultsCount) searchResultsCount.textContent = 'Top 6 featured';
            if (searchViewAllBtn) {
                searchViewAllBtn.href = 'listing.php';
                searchViewAllBtn.querySelector('span').textContent = 'View All Products';
            }
        }

        // Limit strictly to top 6 products as requested
        const topSix = products.slice(0, 6);

        topSix.forEach(prod => {
            const card = document.createElement('a');
            card.href = prod.url || 'detail.php';
            card.className = 'search-prod-card';

            const badgeHtml = prod.badge ? `<span class="search-prod-badge">${prod.badge}</span>` : '';
            const origPriceHtml = prod.original_price ? `<span class="search-prod-orig-price">${prod.original_price}</span>` : '';
            const discountHtml = prod.discount ? `<span class="search-prod-discount">${prod.discount}</span>` : '';

            card.innerHTML = `
                <div class="search-prod-img-wrap">
                    ${badgeHtml}
                    <img src="${prod.image}" alt="${prod.name}" loading="lazy">
                </div>
                <div class="search-prod-info">
                    <span class="search-prod-cat">${prod.category || 'Collection'}</span>
                    <h6 class="search-prod-title">${prod.name}</h6>
                    <div class="search-prod-price-wrap">
                        <span class="search-prod-sale-price">${prod.price}</span>
                        ${origPriceHtml}
                        ${discountHtml}
                    </div>
                </div>
            `;
            searchGrid.appendChild(card);
        });
    }

    function searchFallbackLocal(query) {
        const q = (query || '').trim().toLowerCase();
        if (!q) {
            return {
                products: fallbackProducts.slice(0, 6),
                total: fallbackProducts.length
            };
        }

        const matched = fallbackProducts.filter(item => {
            if (item.name.toLowerCase().includes(q)) return true;
            if (item.category.toLowerCase().includes(q)) return true;
            if (item.tags && item.tags.some(t => t.toLowerCase().includes(q))) return true;
            return false;
        });

        return {
            products: matched.slice(0, 6),
            total: matched.length
        };
    }

    function performSearch(query) { return true;
        const trimmedQuery = (query || '').trim();

        // Update clear button visibility
        if (searchClearBtn) {
            searchClearBtn.style.display = trimmedQuery.length > 0 ? 'inline-block' : 'none';
        }

        // Show subtle loading state if needed
        if (searchGrid && searchGrid.children.length === 0) {
            searchGrid.innerHTML = `
                <div class="rage-search-loading">
                    <i class="fa-solid fa-spinner fa-spin"></i>
                    <span>Finding pieces...</span>
                </div>
            `;
        }

        // Fetch from backend endpoint search-products.php
        fetch(`search-products.php?q=${encodeURIComponent(trimmedQuery)}`)
            .then(res => {
                if (!res.ok) throw new Error('Network response not ok');
                return res.json();
            })
            .then(data => {
                if (data && data.success) {
                    renderProducts(data.products || [], data.total || 0, trimmedQuery);
                } else {
                    const fallback = searchFallbackLocal(trimmedQuery);
                    renderProducts(fallback.products, fallback.total, trimmedQuery);
                }
            })
            .catch(() => {
                // Client-side fallback if server endpoint is inaccessible
                const fallback = searchFallbackLocal(trimmedQuery);
                renderProducts(fallback.products, fallback.total, trimmedQuery);
            });
    }

    // Event Listeners for Search Overlay
    if (searchTrigger) {
        searchTrigger.addEventListener('click', function (e) {
            e.preventDefault();
            openSearch();
        });
    }

    if (searchCloseBtn) {
        searchCloseBtn.addEventListener('click', function (e) {
            e.preventDefault();
            closeSearch();
        });
    }

    if (searchBackdrop) {
        searchBackdrop.addEventListener('click', closeSearch);
    }

    // Close on Escape key
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && searchOverlay && searchOverlay.classList.contains('active')) {
            closeSearch();
        }
    });

    // Debounced Live Typing
    if (searchInput) {
        searchInput.addEventListener('input', function () {
            clearTimeout(searchDebounceTimer);
            const query = this.value;
            searchDebounceTimer = setTimeout(() => {
                performSearch(query);
            }, 200);
        });

        // Pressing Enter submits to the form's real action URL
			searchInput.addEventListener('keydown', function (e) {
				if (e.key === 'Enter') { return true;
					e.preventDefault();

					var form_url = $("#rageSearchForm").attr('action');
					var q = this.value.trim();

					window.location.href = q ? form_url + '?q=' + encodeURIComponent(q) : form_url;
				}
			});
    }

    // Clear Button
    if (searchClearBtn) {
        searchClearBtn.addEventListener('click', function () {
            if (searchInput) {
                searchInput.value = '';
                searchInput.focus();
                searchClearBtn.style.display = 'none';
                performSearch('');
            }
        });
    }

    // Quick Search Tags
    if (searchTagBtns.length > 0) {
        searchTagBtns.forEach(btn => {
            btn.addEventListener('click', function () {
                const tag = this.getAttribute('data-tag') || this.textContent.trim();
                if (searchInput) {
                    searchInput.value = tag;
                    searchInput.focus();
                    performSearch(tag);
                }
            });
        });
    }

    // 13. Detail Page Luxury Interactions
    // A. Color Swatches Switcher
    const colorSwatches = document.querySelectorAll('.color-options .color');
    const selectedColorName = document.getElementById('selectedColorName');
    if (colorSwatches.length > 0) {
        colorSwatches.forEach(swatch => {
            swatch.addEventListener('click', function () {
                colorSwatches.forEach(s => s.classList.remove('active'));
                this.classList.add('active');
                const name = this.getAttribute('data-color-name');
                if (name && selectedColorName) {
                    selectedColorName.textContent = name;
                }
            });
        });
    }

    // B. Size Selection with Stock Urgency & Sticky Bar Sync
    const sizeLabels = document.querySelectorAll('.size-options label');
    const stickySelectedSize = document.getElementById('stickySelectedSize');
    const sizeStockStatus = document.getElementById('sizeStockStatus');
    const sizeStockText = document.getElementById('sizeStockText');

    if (sizeLabels.length > 0) {
        sizeLabels.forEach(lbl => {
            lbl.addEventListener('click', function () { return true;
                sizeLabels.forEach(l => l.classList.remove('active'));
                this.classList.add('active');

                const input = this.querySelector('input');
                if (input) {
                    const sizeVal = input.value;
                    const stock = input.getAttribute('data-stock') || 'In Stock';
                    const count = parseInt(input.getAttribute('data-count')) || 5;

                    // Update sticky bar size
                    if (stickySelectedSize) {
                        stickySelectedSize.textContent = sizeVal;
                    }

                    // Update stock urgency badge
                    if (sizeStockStatus && sizeStockText) {
                        if (count <= 2 || stock.toLowerCase().includes('only')) {
                            sizeStockStatus.classList.add('low-stock');
                            sizeStockText.innerHTML = `<strong>${stock}</strong> &ndash; High demand, order soon to secure yours`;
                        } else {
                            sizeStockStatus.classList.remove('low-stock');
                            sizeStockText.innerHTML = `${stock} &ndash; Ready to dispatch in 24 hours`;
                        }
                    }

                    // Auto-fill notify modal size input if present
                    const notifySizeInput = document.querySelector('#notifyModal input[placeholder*="M/90"]');
                    if (notifySizeInput) {
                        notifySizeInput.value = sizeVal;
                    }
                }
            });
        });
    }

    // C. Sticky "Add To Bag" Quick Bar
    const stickyDetailBar = document.getElementById('stickyDetailBar');
    const mainDetailActions = document.getElementById('mainDetailActions');
    const stickyAddBtn = document.getElementById('stickyAddBtn');

    if (stickyDetailBar && mainDetailActions) {
        window.addEventListener('scroll', function () {
            const rect = mainDetailActions.getBoundingClientRect();
            // When main CTA is scrolled above viewport top
            if (rect.bottom < 0) {
                stickyDetailBar.classList.add('visible');
            } else {
                stickyDetailBar.classList.remove('visible');
            }
        });

        if (stickyAddBtn) {
            stickyAddBtn.addEventListener('click', function (e) { return true;
                e.preventDefault();
                const orig = this.innerHTML;
                this.innerHTML = '<i class="fa-solid fa-check"></i> Added';
                this.style.background = '#287444';
                if (window.RageBag) window.RageBag.increment(1);
                if (window.RageToast) window.RageToast.show('Piece added to your shopping bag!', 'fa-bag-shopping');
                setTimeout(() => {
                    this.innerHTML = orig;
                    this.style.background = '';
                }, 2000);
            });
        }
    }

    // D. Size Guide Unit Converter (Inches <-> Centimeters)
    const unitInchesBtn = document.getElementById('unitInchesBtn');
    const unitCmBtn = document.getElementById('unitCmBtn');
    const sizeTableRows = document.querySelectorAll('#sizeGuideTable tbody tr');

    function updateSizeGuideUnits(unit) {
        if (!sizeTableRows.length) return;
        sizeTableRows.forEach(row => {
            const bust = row.getAttribute(`data-bust-${unit}`);
            const waist = row.getAttribute(`data-waist-${unit}`);
            const hips = row.getAttribute(`data-hips-${unit}`);
            const len = row.getAttribute(`data-len-${unit}`);

            const colBust = row.querySelector('.col-bust');
            const colWaist = row.querySelector('.col-waist');
            const colHips = row.querySelector('.col-hips');
            const colLen = row.querySelector('.col-len');

            if (colBust && bust) colBust.textContent = bust;
            if (colWaist && waist) colWaist.textContent = waist;
            if (colHips && hips) colHips.textContent = hips;
            if (colLen && len) colLen.textContent = len;
        });
    }

    if (unitInchesBtn && unitCmBtn) {
        unitInchesBtn.addEventListener('click', function () {
            unitInchesBtn.classList.add('active');
            unitCmBtn.classList.remove('active');
            updateSizeGuideUnits('in');
        });

        unitCmBtn.addEventListener('click', function () {
            unitCmBtn.classList.add('active');
            unitInchesBtn.classList.remove('active');
            updateSizeGuideUnits('cm');
        });
    }

    // E. Copy Product Link Button
    const copyProductLinkBtn = document.getElementById('copyProductLinkBtn');
    if (copyProductLinkBtn) {
        copyProductLinkBtn.addEventListener('click', function () {
            navigator.clipboard.writeText(window.location.href);
            if (window.RageToast) {
                window.RageToast.show('Piece link copied to clipboard!', 'fa-link');
            }
            const modalEl = document.getElementById('shareModal');
            if (modalEl && typeof bootstrap !== 'undefined') {
                const modal = bootstrap.Modal.getInstance(modalEl);
                if (modal) setTimeout(() => modal.hide(), 800);
            }
        });
    }

    // F. Notify Me Modal Submission
    const notifyForm = document.querySelector('#notifyModal form');
    if (notifyForm) {
        notifyForm.addEventListener('submit', function (e) {
            e.preventDefault();
            const modalEl = document.getElementById('notifyModal');
            if (modalEl && typeof bootstrap !== 'undefined') {
                const modal = bootstrap.Modal.getInstance(modalEl);
                if (modal) modal.hide();
            }
            if (window.RageToast) {
                window.RageToast.show('We will notify you immediately once this piece returns to stock!', 'fa-bell');
            }
            notifyForm.reset();
        });
    }

    // G. Write Review Modal Submission
    const reviewForm = document.querySelector('#reviewModal form');
    if (reviewForm) {
        reviewForm.addEventListener('submit', function (e) { return true;
            e.preventDefault();
            const modalEl = document.getElementById('reviewModal');
            if (modalEl && typeof bootstrap !== 'undefined') {
                const modal = bootstrap.Modal.getInstance(modalEl);
                if (modal) modal.hide();
            }
            if (window.RageToast) {
                window.RageToast.show('Thank you! Your verified review has been submitted.', 'fa-star');
            }
            reviewForm.reset();
        });
    }
});


document.addEventListener('DOMContentLoaded', function () {
    if (document.querySelector('.categorySwiper')) {
        new Swiper('.categorySwiper', {
            slidesPerView: 3,
            spaceBetween: 16,
            loop: true,
            speed: 800,
            autoplay: {
                delay: 2800,
                disableOnInteraction: false,
                pauseOnMouseEnter: true
            },
            pagination: {
                el: '.categorySwiper .swiper-pagination',
                clickable: true
            },
            breakpoints: {
                0: {
                    slidesPerView: 1.2,
                    spaceBetween: 10
                },
                576: {
                    slidesPerView: 1.8,
                    spaceBetween: 12
                },
                768: {
                    slidesPerView: 2,
                    spaceBetween: 14
                },
                992: {
                    slidesPerView: 3,
                    spaceBetween: 16
                }
            }
        });
    }
});


document.addEventListener('DOMContentLoaded', function () {
    if (document.querySelector('.bestSellerSwiper')) {
        new Swiper('.bestSellerSwiper', {
            slidesPerView: 3,
            spaceBetween: 16,
            loop: true,
            speed: 800,
            autoplay: {
                delay: 2800,
                disableOnInteraction: false,
                pauseOnMouseEnter: true
            },
            pagination: {
                el: '.bestSellerSwiper .swiper-pagination',
                clickable: true
            },
            breakpoints: {
                0: {
                    slidesPerView: 1.2,
                    spaceBetween: 10
                },
                576: {
                    slidesPerView: 1.8,
                    spaceBetween: 12
                },
                768: {
                    slidesPerView: 2,
                    spaceBetween: 14
                },
                992: {
                    slidesPerView: 3,
                    spaceBetween: 16
                }
            }
        });
    }
});


document.addEventListener('DOMContentLoaded', function () {

    new Swiper('.heroSwiper', {
        slidesPerView: 1,
        loop: true,
        speed: 900,

        autoplay: {
            delay: 3500,
            disableOnInteraction: false
        },

        pagination: {
            el: '.heroSwiper .swiper-pagination',
            clickable: true
        }
    });

});