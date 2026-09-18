<?php
    error_reporting(0);

    use App\CustomFunction;
    use App\Wishlist;
    use App\ProductAttribute;
    use App\Product;

    $page_link = url('product/' . $productdetails['seo_url']);
    $stock_count = array_sum(array_column($productdetails['pro_attrs'], 'stock'));

    $size_array = [];
    if (is_array($productdetails['pro_attrs']) && count($productdetails['pro_attrs']) > 0) {
        foreach ($productdetails['pro_attrs'] as $key => $pro_attrs) {
            $size_array[] = $pro_attrs['size'];
        }
    }

    $size_chart = '';
    if ($productdetails['size_chart'] != '') {
        $size_chart = $productdetails['size_chart'];
    } elseif (!empty($productdetails['category']['size_chart'])) {
        $size_chart = $productdetails['category']['size_chart'];
    }

    // Discount % (same pattern used by productPriceHtml() helper)
    $discount_percentage = null;
    if ($productdetails['current_discount'] == 'product' || $productdetails['current_discount'] == 'category') {
        $discount_percentage = $productdetails['current_discount'] == 'product'
            ? $productdetails['product_discount']
            : $productdetails['category']['category_discount'];
    }
?>
@extends('layouts.frontLayout.front-layout')
@section('content')

<main class="inner-page">

    <section class="product-detail-page">
        <div class="container-fluid">

            <div class="product-detail-wrap">
                <div class="row">

                    <!-- PRODUCT GALLERY -->
                    <div class="col-lg-7 col-md-7 col-12">
                        <div class="product-gallery">

                            <div class="gallery-thumbs">
                                @foreach($productdetails['productimages'] as $imgkey => $proimage)
                                    <button type="button" class="thumb {{ $imgkey === 0 ? 'active' : '' }}" data-full="{{ asset('images/ProductImages/xlarge/'.$proimage['image']) }}">
                                        <img src="{{ asset('images/ProductImages/xlarge/'.$proimage['image']) }}" alt="{{ $productdetails['product_name'] }}">
                                    </button>
                                @endforeach
                            </div>

                            <div class="gallery-main">
                                @php $firstImage = $productdetails['productimages'][0]['image'] ?? ''; @endphp
                                <a href="{{ asset('images/ProductImages/xlarge/'.$firstImage) }}" data-fancybox="product-main" class="main-image-link">
                                    <img src="{{ asset('images/ProductImages/xlarge/'.$firstImage) }}" alt="{{ $productdetails['product_name'] }}" id="mainProductImage">
                                    <span class="gallery-zoom-hint"><i class="fa-solid fa-magnifying-glass-plus"></i> Zoom</span>
                                </a>

                                <button type="button" class="detail-wishlist addWishList" aria-label="Add to Wishlist" data-productid="{{ $productdetails['id'] }}" page-type="listing">
                                    <i class="far fa-heart"></i>
                                </button>

                                <button type="button" class="detail-share-btn" id="detailShareBtn" aria-label="Share Piece" title="Share Piece" data-bs-toggle="modal" data-bs-target="#shareModal">
                                    <i class="fa-solid fa-share-nodes"></i>
                                </button>
                            </div>

                        </div>
                    </div>

                    <!-- PRODUCT INFO -->
                    <div class="col-lg-5 col-md-5 col-12">
                        <div class="product-detail-info">

                            <div class="detail-breadcrumb">
                                <a href="{{ route('home') }}">Home</a>
                                <span>/</span>
                                <a href="{{ url($productdetails['category']['seo_unique']) }}">{{ $productdetails['category']['name'] }}</a>
                                <span>/</span>
                                <span>{{ $productdetails['product_name'] }}</span>
                            </div>

                            <h1>{{ $productdetails['product_name'] }}</h1>

                            <div class="detail-rating-quick">
                                <span class="code-sku">SKU: {{ $productdetails['product_code'] }}</span>
                            </div>

                            <div class="detail-price">
                                {!! productPriceHtml($productdetails) !!}
                            </div>

                            <p class="detail-tax">
                                <i class="fa-solid fa-shield-halved"></i> Inclusive of all taxes
                            </p>

                            @if(!empty($productdetails['product_description']))
                            <div class="detail-description">
                                <p>{{ $productdetails['product_description'] }}</p>
                            </div>
                            @endif

                            <!-- COLOR -->
                            @if(count($productdetails['groups']) > 0)
                            <div class="product-option">
                                <div class="option-head">
                                    <span>Color</span>
                                    <strong id="selectedColorName">{{ $productdetails['color'] }}</strong>
                                </div>

                                <div class="color-options">
                                    <?php $current_color_code = Product::product_code($productdetails['color']); ?>
                                    <button class="color active" type="button" aria-label="{{ $productdetails['color'] }}">
                                        <span style="background:{{ $current_color_code }};"></span>
                                    </button>
                                    @foreach($productdetails['groups'] as $color_key => $grouproduct)
                                        <?php $group_color_code = Product::product_code($grouproduct['color']); ?>
                                        <a href="{{ url('/product/'.$grouproduct['seo_url']) }}" class="color" aria-label="{{ $grouproduct['color'] }}">
                                            <span style="background:{{ $group_color_code }};"></span>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                            @endif

                            <!-- SIZE -->
                            <div class="product-option">
                                <div class="option-head">
                                    <span>Select Size</span>
                                    @if(!empty($size_chart))
                                    <button class="size-guide-btn" type="button" data-bs-toggle="modal" data-bs-target="#sizeGuideModal">
                                        <i class="fa-solid fa-ruler-horizontal"></i> Size Guide
                                    </button>
                                    @endif
                                </div>

                                <div class="size-options">
                                    <?php $first_available_stock = null; ?>
                                    @foreach($size_array as $attrkey => $attribute)
                                        <?php
                                            $stock = ProductAttribute::stock($productdetails['id'], $attribute);
                                            if ($first_available_stock === null) {
                                                $first_available_stock = $stock;
                                            }
                                        ?>
                                        <label class="{{ $attrkey === 0 ? 'active' : '' }} {{ !$stock ? 'disabled' : '' }}">
                                            <input style="width:200px;" type="radio" id="{{ $attribute }}" name="size" value="{{ $attribute }}"
                                                data-proid="{{ $productdetails['id'] }}"
                                                data-catid="{{ $productdetails['category']['id'] }}"
                                                data-stock="{{ $stock }}"
                                                page-type="listing"
                                                {{ $attrkey === 0 ? 'checked' : '' }}
                                                {{ !$stock ? 'disabled' : '' }}>
                                            <span>{{ $attribute }}</span>
                                        </label>
                                    @endforeach
                                    <input type="hidden" id="listing-product_size">
                                </div>

                                <div class="size-stock-status {{ ($first_available_stock !== null && $first_available_stock <= 2) ? 'low-stock' : '' }}" id="sizeStockStatus">
                                    <i class="fa-solid fa-bolt"></i>
                                    <span id="sizeStockText">Dispatches within 24 hours</span>
                                </div>

                                <button type="button" class="notify" data-bs-toggle="modal" data-bs-target="#notifyme">
                                    <i class="fa-regular fa-bell"></i> Size unavailable? Notify Me
                                </button>
                            </div>

                            <!-- QUANTITY -->
                            <div class="product-option">
                                <div class="option-head">
                                    <span>Quantity</span>
                                </div>

                                <div class="quantity-box">
                                    <button type="button" class="qty-minus minus" aria-label="Decrease quantity">&minus;</button>
                                    <input type="number" class="input-box product-qty" id="listing-qty" name="qty" value="1" aria-label="Product quantity">
                                    <button type="button" class="qty-plus plus" aria-label="Increase quantity">&plus;</button>
                                </div>
                            </div>

                            <!-- CTA -->
                            <input type="hidden" name="action">
                            <div class="detail-actions" id="mainDetailActions">
                                <button type="submit" data-cart-type="cart" class="add-cart-btn addCart" id="mainAddCartBtn" data-product-id="{{ $productdetails['id'] }}" page-type="listing">
                                    <i class="fa-solid fa-bag-shopping"></i> Add To Bag
                                </button>

                                <button type="submit" data-cart-type="buy" class="buy-now-btn addCart" id="BuyNow" data-product-id="{{ $productdetails['id'] }}" page-type="listing">
                                    Buy Now
                                </button>
                            </div>

                            <div class="alert-message alert alert-danger listing-error-msg print-error-msg" style="margin-top:10px">
                                <ul class="mb-0"></ul>
                            </div>
                            <div class="alert-message alert alert-success listing-success-msg print-success-msg" style="margin-top:10px">
                                <ul class="mb-0"></ul>
                            </div>

                            <!-- LUXURY TRUST STRIP -->
                            <div class="luxury-trust-badges">
                                <div class="trust-item">
                                    <i class="fa-solid fa-gem"></i>
                                    <div>
                                        <h6>Authentic Craft</h6>
                                        <span>Pure handwoven fabrics</span>
                                    </div>
                                </div>
                                <div class="trust-item">
                                    <i class="fa-solid fa-truck-fast"></i>
                                    <div>
                                        <h6>Express Delivery</h6>
                                        <span>Complimentary pan-India</span>
                                    </div>
                                </div>
                                <div class="trust-item">
                                    <i class="fa-solid fa-arrows-rotate"></i>
                                    <div>
                                        <h6>7-Day Exchanges</h6>
                                        <span>Doorstep size exchange</span>
                                    </div>
                                </div>
                                <div class="trust-item">
                                    <i class="fa-solid fa-box-open"></i>
                                    <div>
                                        <h6>Keepsake Box</h6>
                                        <span>Signature luxury packaging</span>
                                    </div>
                                </div>
                            </div>

                            <!-- DELIVERY -->
                            <div class="delivery-check">
                                <h5>Check Delivery & Services</h5>
                                <div class="pincode-box">
                                    <input type="text" id="pincode" placeholder="Enter 6-digit postal code" maxlength="6" onkeypress="return isNumberKey(event)">
                                    <button type="button" id="pincode-check" onclick="get_pincode_details()">Check</button>
                                </div>
                                <div id="pincode_msg"></div>
                                <p>Enter your pincode to verify express white-glove dispatch and estimated delivery.</p>
                            </div>

                            <!-- INFO ACCORDION -->
                            <div class="product-accordion" id="accordionExample">
                                <div class="accordion-item active">
                                    <button type="button" class="accordion-head">
                                        Product Details & Specifications
                                        <i class="fa-solid fa-plus"></i>
                                    </button>
                                    <div class="accordion-content">
                                        <p><strong>Category:</strong> {{ $productdetails['category']['name'] }}</p>
                                        <p><strong>Product Code:</strong> {{ $productdetails['product_code'] }}</p>
                                        @if(!empty($productdetails['fabric_description']))
                                        <p><strong>Fabric Description:</strong> {!! $productdetails['fabric_description'] !!}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>

        </div>
    </section>

    <!-- YOU MAY ALSO LIKE -->
    @if(!empty($get_related_products))
    <section class="related-products">
        <div class="container-fluid">

            <div class="related-head">
                <span>Curated For You</span>
                <h2>You May Also Like</h2>
            </div>

            <div class="swiper relatedSwiper">
                <div class="swiper-wrapper">
                    @foreach($get_related_products as $key => $relProduct)
                        <?php
                            $rel_product_image = '';
                            if (!empty($relProduct['productimages'])) {
                                $rel_product_image = $relProduct['productimages'][0]['image'];
                            }
                        ?>
                        <div class="swiper-slide">
                            <div class="prod-card">
                                <div class="prod-img">
                                    <a href="{{ url('/product/'.$relProduct['seo_url']) }}">
                                        @if(!empty($rel_product_image))
                                            <img src="{{ asset('images/ProductImages/large/'.$rel_product_image) }}" alt="{{ $relProduct['product_name'] }}">
                                        @else
                                            <img src="{{ asset('images/no-image-found.jpg') }}" alt="{{ $relProduct['product_name'] }}">
                                        @endif
                                    </a>

                                    <a href="javascript:void(0)" class="addWishList" data-productid="{{ $relProduct['id'] }}" page-type="listing">
                                        <i class="fa-regular fa-heart"></i>
                                    </a>

                                    <div class="cart-btn">
                                        <a href="{{ url('/product/'.$relProduct['seo_url']) }}" class="link-btn black">Add to Cart</a>
                                        <a href="{{ url('/product/'.$relProduct['seo_url']) }}" class="link-btn brown">Buy Now</a>
                                    </div>
                                </div>

                                <a href="{{ url('/product/'.$relProduct['seo_url']) }}" class="prod-info">
                                    <div class="name-wrap">
                                        <h4>{{ $relProduct['product_name'] }}</h4>
                                    </div>

                                    <div class="detail-price card-box">
                                        {!! productPriceHtml($relProduct) !!}
                                    </div>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>
    </section>
    @endif

    <!-- PRODUCT REVIEWS (existing dynamic partial - ratings summary, review list, write-a-review form) -->
    @include('front.listings.product-reviews')

    <!-- NOTIFY ME MODAL -->
    <div class="modal fade" id="notifyme" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content review-modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Notify Me</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="notify_msg"></div>
                    <form action="javascript:;" method="post" id="notify">
                        @csrf
                        <div class="review-field">
                            <label for="notifysize">Size:</label>
                            <select name="notifysize" id="notifysize" class="form-control">
                                @foreach($size_array as $attrkey => $attribute)
                                    <?php $stock = ProductAttribute::stock($productdetails['id'], $attribute); ?>
                                    @if(!$stock)
                                        <option value="{{ $attribute }}">{{ $attribute }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="review-field">
                            <label for="name">Name:</label>
                            <input type="hidden" name="notifycode" id="notifycode" value="{{ $productdetails['product_code'] }}">
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="review-field">
                            <label for="email">Email:</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="review-field">
                            <label for="mobile">Mobile:</label>
                            <input type="text" class="form-control" id="mobile" name="mobile">
                        </div>
                        <input type="hidden" name="g-recaptcha-response" id="g-recaptcha-response">
                        <button type="submit" class="review-submit-btn mt-3">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- SIZE CHART MODAL -->
    @if(!empty($size_chart))
    <div class="modal fade" id="sizeGuideModal" tabindex="-1" aria-labelledby="sizeGuideModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content size-guide-modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="sizeGuideModalLabel">Size Chart</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body m-0 text-center">
                    <img src="{{ asset('images/SizeCharts/'.$size_chart) }}" class="img-fluid" alt="Size Chart">
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- SHARE MODAL -->
    <div class="modal fade" id="shareModal" tabindex="-1" aria-labelledby="shareModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content review-modal-content">
                <div class="modal-header">
                    <div>
                        <span style="font-size:12px; color:#8c7353; letter-spacing:1px; text-transform:uppercase;">Curated Luxury Fashion</span>
                        <h4 class="modal-title" id="shareModalLabel">Share This Piece</h4>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p style="font-size:14px; color:#7d756e; margin-bottom:16px;">
                        Share <strong>{{ $productdetails['product_name'] }}</strong> with your circle or save for your personal festive wishlist.
                    </p>
                    <div class="share-links-grid">
                        <a href="https://api.whatsapp.com/send?text={{ urlencode('Discover the '.$productdetails['product_name'].' on Rage - '.$page_link) }}" target="_blank" rel="noopener" class="share-link-item">
                            <i class="fa-brands fa-whatsapp"></i>
                            <span>WhatsApp</span>
                        </a>
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode($page_link) }}" target="_blank" rel="noopener" class="share-link-item">
                            <i class="fa-brands fa-facebook"></i>
                            <span>Facebook</span>
                        </a>
                        <button type="button" class="share-link-item" id="copyProductLinkBtn" data-link="{{ $page_link }}">
                            <i class="fa-solid fa-link"></i>
                            <span>Copy Link</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- STICKY BOTTOM QUICK ADD BAR -->
    <div class="sticky-detail-bar" id="stickyDetailBar">
        <div class="container-fluid">
            <div class="sticky-detail-wrap">
                <div class="sticky-prod-info">
                    <img src="{{ asset('images/ProductImages/xlarge/'.($productdetails['productimages'][0]['image'] ?? '')) }}" alt="" id="stickyProdImg">
                    <div>
                        <h5>{{ $productdetails['product_name'] }}</h5>
                        <div class="sticky-meta">
                            <span class="price">{!! productPriceHtml($productdetails) !!}</span>
                            <span class="selected-size-pill">Size: <strong id="stickySelectedSize">{{ $size_array[0] ?? '' }}</strong></span>
                        </div>
                    </div>
                </div>
                <div class="sticky-actions">
                    <button type="submit" data-cart-type="cart" class="add-cart-btn addCart sticky-add-btn stickyAddBtn" id="stickyAddBtn" data-product-id="{{ $productdetails['id'] }}" page-type="listing">
                        <i class="fa-solid fa-bag-shopping"></i> Add To Bag
                    </button>
                    <button type="submit" data-cart-type="buy" class="buy-now-btn addCart sticky-buy-btn stickyAddBtn" data-product-id="{{ $productdetails['id'] }}" page-type="listing">
                        Buy Now
                    </button>
                </div>
            </div>
        </div>
    </div>

</main>
@stop

@section('javascript')
@parent
<script type="text/javascript" src="{{ asset('js/ajax_jquery.min.js')}}"></script>
<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha384-tsQFqpEReu7ZLhBV2VZlAu7zcOV+rXbYlF2cqB8txI/8aZajjp4Bqd+V6D5IgvKT" crossorigin="anonymous"></script>
<script src="https://www.google.com/recaptcha/api.js?render={{ env('RECAPTCHA_SITE_KEY') }}" async defer></script>

<script>
    $(document).ready(function() {

        // Gallery thumb click -> swap main image (new design's thumb list)
        $(document).on('click', '.gallery-thumbs .thumb', function() {
            $('.gallery-thumbs .thumb').removeClass('active');
            $(this).addClass('active');
            var fullSrc = $(this).data('full');
            $('#mainProductImage').attr('src', fullSrc);
            $('.main-image-link').attr('href', fullSrc);
        });

        // Quantity stepper
        $(document).on('click', '.quantity-box .plus', function() {
            var qty = parseInt($('#listing-qty').val()) || 1;
            $('#listing-qty').val(qty + 1);
        });
        $(document).on('click', '.quantity-box .minus', function() {
            var qty = parseInt($('#listing-qty').val()) || 1;
            if (qty > 1) {
                $('#listing-qty').val(qty - 1);
            }
        });

        // Size selection stock status text
        $(document).on('click', 'input[name="size"]', function() {
            $('.size-options label').removeClass('active');
            $(this).closest('label').addClass('active');
            $('#stickySelectedSize').text($(this).val());

            var stock = $(this).data('stock');
            if (stock && stock <= 2) {
                $('#sizeStockStatus').addClass('low-stock');
            } else {
                $('#sizeStockStatus').removeClass('low-stock');
            }
			
			
        });

        // Accordion toggle
        $(document).on('click', '.accordion-head', function() {
            $(this).closest('.accordion-item').toggleClass('active');
        });

        // Copy product link
        $(document).on('click', '#copyProductLinkBtn', function() {
            var link = $(this).data('link');
            navigator.clipboard.writeText(link);
            $(this).find('span').text('Copied!');
            var $btn = $(this);
            setTimeout(function() {
                $btn.find('span').text('Copy Link');
            }, 2000);
        });

        $('.social-media-share').click(function(e) {
            e.preventDefault();
            window.open($(this).attr('href'), 'fbShareWindow', 'height=450, width=550, top=' + ($(window).height() / 2 - 275) + ', left=' + ($(window).width() / 2 - 225) + ', toolbar=0, location=0, menubar=0, directories=0, scrollbars=0');
            return false;
        });

        $(document).on("submit", "#save-review", function(e) {
            e.preventDefault();
            $('.PleaseWaitDiv').show();
            var formdata = $("#save-review").serialize();
            $.ajax({
                url: "/save-review",
                type: 'POST',
                dataType: "JSON",
                data: new FormData(this),
                processData: false,
                contentType: false,
                success: function(data) {
                    $('.PleaseWaitDiv').hide();
                    $('.error-message').html('');
                    if (!data.status) {
                        if (data.type == "validation") {
                            var err_no = 0;
                            $.each(data.errors, function(i, error) {
                                err_no = err_no + 1;
                                $('#review-' + i).attr('style', 'color:red!important');
                                $('#review-' + i).html(error);
                                if (err_no == 1) {
                                    $('#con-' + i).focus();
                                }
                                setTimeout(function() {
                                    $('#review-' + i).css({
                                        'review': 'none'
                                    });
                                }, 5000);
                            });
                        }
                    } else {
                        $("#previewContainer").html('');
                        $('#save-review').trigger('reset');
                        alert(data.message);
                    }
                }
            });
        });

        $(document).on('submit', '#notify', function(e) {
            e.preventDefault();

            grecaptcha.execute("{{ env('RECAPTCHA_SITE_KEY') }}")
                .then(function(token) {
                    $('#g-recaptcha-response').val(token);
                    $.ajax({
                        url: "/save-notify",
                        type: "POST",
                        data: $("#notify").serialize(),
                        success: function(data) {
                            $('.PleaseWaitDiv').hide();
                            if (data.status) {
                                $('#notify_msg').attr('style', '');
                                $('#notify_msg').html('<div role="alert" class="alert alert-success alert-dismissible"> <button aria-label="Close" data-bs-dismiss="alert" style="text-indent: 0;" class="close" type="button"><span aria-hidden="true"></span></button>Your infomation has been submitted successfully. We will get back to you soon.</div>');
                                setTimeout(function() {
                                    $('#notify')[0].reset();
                                    $('#notify_msg').empty();
                                    $('#notifyme').modal('hide');
                                }, 3000);
                            } else {
                                alert(data.message);
                            }
                        },
                        error: function(xhr, status, error) {
                            $('.PleaseWaitDiv').hide();
                        }
                    });
                });

        });
		
		
		   // Star rating picker
        $(document).on('click', '#starRating .star', function() {
            var value = $(this).data('value');
            $('#ratingValue').val(value);

            $('#starRating .star').each(function() {
                var starVal = $(this).data('value');
                var icon = $(this).find('i');
                if (starVal <= value) {
                    icon.removeClass('fa-regular').addClass('fa-solid');
                } else {
                    icon.removeClass('fa-solid').addClass('fa-regular');
                }
            });
        });

        // Image upload preview
        $(document).on('change', '#fileUpload', function(event) {
            $('#previewContainer').html('');
            var files = event.target.files;
            for (var i = 0; i < files.length; i++) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#previewContainer').append('<img src="' + e.target.result + '"  class="preview-img">');
                }
                reader.readAsDataURL(files[i]);
            }
        });

		
		
		
		
		
		

    });

    function cartitems_Ajax() {
        $.ajax({
            url: "/cart-items-ajax",
            type: "get",
            success: function(resp) {
                $('#cartdata').html(resp.view);
            },
            error: function() {}
        })
    }

    function get_pincode_details() {
        var pincode = $('#pincode').val();
        $.ajax({
            url: "/get-pincode-details",
            type: 'POST',
            data: {
                pincode: pincode,
                _token: "{{csrf_token()}}"
            },
            success: function(data) {
                $('.PleaseWaitDiv').hide();
                var alertclasss = "";
                if (!data.status) {
                    alertclasss = "danger";
                } else {
                    alertclasss = "success";
                }
                if (data.message != "") {
                    $('#pincode_msg').html('<div class="alert alert-' + alertclasss + ' alert-dismissible"><button type="button" class="close" data-bs-dismiss="alert">&times;</button><span>' + data.message + '</span></div>');
                }
            }
        });
    }
</script>
<script type="text/javascript">
    $(document).on('click', '#BuyNow', function() {
        $('[name=action]').val('buy');
    })
    $("#pincode").keyup(function(event) {
        if (event.keyCode === 13) {
            $("#pincode-check").click();
        }
    });

    function isNumberKey(evt) {
        var charCode = (evt.which) ? evt.which : evt.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        } else {
            return true;
        }
    }
</script>
@stop