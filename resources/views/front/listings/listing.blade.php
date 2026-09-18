@extends('layouts.frontLayout.front-layout')
@section('content')
<?php
    use App\CustomFunction;
    use App\Wishlist;
    use App\Category;
    use App\Color;
    use App\ProductAttribute;
    use App\Product;
    use App\Productcolor;

    $getcategories = Category::getcategories();
    $page_link = url($catdetails['seo_unique']);
    $relatedcategory = Product::relatedcategory($catdetails['parent_id'], $catdetails['id'], $catdetails['seo_unique']);
    $getcategories = Category::getcategories();

    if (!isset($categories)) {
        $categories = Category::getcategories();
    }

    if ($catdetails['name'] == 'New Arrivals') {
        $colors = Product::GruopbyProductattribute($relatedcategory, 'productcolor', 'New Arrivals');
    } elseif ($catdetails['name'] == 'Shop All') {
        $colors = Product::GruopbyProductattribute($relatedcategory, 'productcolor', 'Shop All');
    } else {
        $colors = Product::GruopbyProductattribute($relatedcategory, 'productcolor');
    }

    if ($catdetails['name'] == 'New Arrivals') {
        $sizes = ProductAttribute::getproductsizes($relatedcategory, 'New Arrivals');
    } elseif ($catdetails['name'] == 'Shop All') {
        $sizes = ProductAttribute::getproductsizes($relatedcategory, 'Shop All');
    } else {
        $sizes = ProductAttribute::getproductsizes($relatedcategory);
    }

    $priceRanges = [
        '0-1000'     => 'INR 0 - INR 1,000',
        '1000-2000'  => 'INR 1,000 - INR 2,000',
        '2000-3000'  => 'INR 2,000 - INR 3,000',
        '3000-5000'  => 'INR 3,000 - INR 5,000',
        '5000-10000' => 'INR 5,000 - INR 10,000',
        '10000-plus' => 'INR 10,000 & Above',
    ];

    $search_query = isset($_GET['q'])
        ? htmlspecialchars(trim($_GET['q']), ENT_QUOTES, 'UTF-8')
        : (isset($_GET['search']) ? htmlspecialchars(trim($_GET['search']), ENT_QUOTES, 'UTF-8') : '');

    $page_title = $search_query ? 'Search: &ldquo;' . $search_query . '&rdquo;' : 'Winter Collection';
?>
<style>
    .color-active1 {
        border: 2px solid #8e313c !important;
    }
</style>

<main class="inner-page">
    <section class="product-listing-page">
        <div class="container-fluid">

            <div class="listing-top" tabindex="-1">
                <div class="row align-items-end">

                    <div class="col-lg-7 col-md-7 col-12">
                        <div class="listing-heading">
                            <div class="breadcrumb-wrap">
                                <a href="{{ route('home') }}">Home</a>
                                <span>/</span>
                                <span>{{ $catdetails['name'] }}</span>
                            </div>
                            <h1>{{ $catdetails['name'] }}</h1>
                        </div>
                    </div>

                    <div class="col-lg-5 col-md-5 col-12">
                        <div class="listing-controls">

                            <button class="filter-open-btn" type="button">
                                <i class="fa-solid fa-sliders"></i>
                                Filter
                            </button>

                            <div class="product-count">
                                {{ $no_of_products }}
                            </div>

                            <div class="sort-box">
                                <span>Sort By</span>

                                <?php
                                    $sortOptions = [
                                        ''    => 'Default',
                                        'lth' => 'Price: Low to High',
                                        'htl' => 'Price: High to Low',
                                    ];
                                ?>

                                <select name="sort" id="sortSelect" class="classic getsort filterby listing_dropdown">
                                    @foreach($sortOptions as $value => $label)
                                        <option value="{{ $value }}" {{ (request('sort') == $value) ? 'selected' : '' }}>{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>

                        </div>
                    </div>

                </div>
            </div>

            <div class="listing-layout">
                <div class="row">
                    @include('front.listings.filters')
                    <div class="col-lg-9 col-md-12 col-12" id="appnedProductListing">
                        @include('front.listings.product-listing')
                    </div>
                </div>
            </div>

        </div>
    </section>

    <div class="filter-overlay"></div>
    @include('front.listings.mobile-filters')
</main>
@stop

@section('javascript')
@parent
<script type="text/javascript" src="{{ asset('js/ajax_jquery.min.js') }}"></script>
<script type="text/javascript">

    var queryStringObject = {};

    // Rebuilds queryStringObject from every .filterAjax input currently
    // checked on the page (price, color, size, category — desktop AND
    // mobile/.mob-filter inputs alike), keyed by input name.
    function buildQueryStringObject() {

        $(".filterAjax").each(function () {

            var name = $(this).attr('name');

            queryStringObject[name] = [];

            $.each($("input[name='" + name + "']:checked"), function () {
                queryStringObject[name].push($(this).val());
            });

            if (queryStringObject[name].length == 0) {
                delete queryStringObject[name];
            }

        });

        var sortValue = $('.getsort option:selected').val();
        var sortName = $('.getsort').attr('name');

        queryStringObject[sortName] = [sortValue];

        if (sortValue == "") {
            delete queryStringObject[sortName];
        }

        delete queryStringObject['page'];

    }

    function filterproducts(queryStringObject, reload = 0) {

        $(".PleaseWaitDiv").show();

        var queryString = "";

        for (var key in queryStringObject) {

            if (queryString == '') {
                queryString += "?" + key + "=";
            } else {
                queryString += "&" + key + "=";
            }

            var queryValue = "";

            for (var i in queryStringObject[key]) {
                if (queryValue == '') {
                    queryValue += queryStringObject[key][i];
                } else {
                    queryValue += "~" + queryStringObject[key][i];
                }
            }

            queryString += queryValue;

        }

        if (history.pushState) {
            var newurl = window.location.protocol + "//" + window.location.host + window.location.pathname + queryString;
            window.history.pushState({ path: newurl }, '', newurl);
        }

        if (newurl.indexOf("?") >= 0) {
            newurl = newurl + "&json=";
        } else {
            newurl = newurl + "?json=";
        }

        if (reload == 1) {
            window.location.reload();
        }

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': '<?= csrf_token() ?>'
            }
        });

        $.ajax({
            url: newurl,
            type: 'get',
            dataType: 'json',
            success: function (resp) {
                $("#appnedProductListing").html(resp.view);
                $('.product-count').html(resp.no_of_products);
                $(".listing-top").focus();
                $("#UpdateProCount").text(resp.countproducts + " styles");
                $(".PleaseWaitDiv").hide();
            },
            error: function () {}
        });

    }

    function changes_categories(url) {
        window.location.href = url;
    }

    function select_size(id) {
        var size_id = '#size-' + id;
        $(size_id).trigger("click");

        if ($(size_id).is(':checked')) {
            $(".filter-size-" + id).addClass('size-active');
        } else {
            $(".filter-size-" + id).removeClass('size-active');
        }
    }

    function select_size2(id) {
        var size_id = '#pro-size-' + id;
        $(size_id).trigger("click");

        if ($(size_id).is(':checked')) {
            $(".filter-size-" + id).addClass('size-active');
        } else {
            $(".filter-size-" + id).removeClass('size-active');
        }
    }

    function select_color(id) {
        var color_id = '#color-' + id;
        $(color_id).trigger("click");

        if ($(color_id).is(':checked')) {
            $(".filter-color-" + id).addClass('color-active');
        } else {
            $(".filter-color-" + id).removeClass('color-active');
        }
    }

    function select_color2(id) {
        var color_id = '#pro-color-' + id;
        $(color_id).trigger("click");

        if ($(color_id).is(':checked')) {
            $(".filter-color-" + id).addClass('color-active');
        } else {
            $(".filter-color-" + id).removeClass('color-active');
        }
    }

    jQuery(document).ready(function ($) {

        // Initial state: if filters are already applied on page load
        // (server flagged via .filtertrue), sync queryStringObject to match.
        if ($('.filtertrue').length > 0) {
            buildQueryStringObject();
        }

        // Pagination
        $(document).on('click', '.pagination a', function (event) {
            event.preventDefault();

            if ($('.filtertrue').length > 0) {
                buildQueryStringObject();
            }

            var page = $(this).attr('href').split('page=')[1];
            queryStringObject['page'] = page;

            filterproducts(queryStringObject);
        });

        // Add to Wishlist
        $(document).on('click', '.addWishList1', function () {

            $('.PleaseWaitDiv').show();

            var proid = $(this).data('productid');

            $.ajax({
                data: {
                    "_token": "{{ csrf_token() }}",
                    "proid": proid
                },
                type: 'post',
                url: '/add-to-wishlist',
                success: function (resp) {
                    if (resp.status) {
                        if (resp.message === 'set') {
                            $('a[data-productid=' + proid + ']').children().removeClass('fa-heart-o');
                            $('a[data-productid=' + proid + ']').children().addClass('fa-heart');
                        } else if (resp.message === 'unset') {
                            $('a[data-productid=' + proid + ']').children().removeClass('fa-heart');
                            $('a[data-productid=' + proid + ']').children().addClass('fa-heart-o');
                        }
                    } else {
                        alert(resp.message);
                        if (resp.login == false) {
                            window.location.href = resp.url;
                        }
                    }
                    $('.PleaseWaitDiv').hide();
                },
                error: function () {
                    // Nothing to do
                }
            });

        });

        // Price slider "apply" button
        $(".price_slider_amount").click(function (event) {
            event.preventDefault();

            var filter_price = $("#price_sort").val();
            $("#price_sort").val($.trim(filter_price));
            $("#price_sort").prop("checked", true);

            var name = 'price';
            queryStringObject[name] = [];

            $.each($("input[name='price']:checked"), function () {
                queryStringObject[name].push($(this).val());
            });

            if (queryStringObject[name].length == 0) {
                delete queryStringObject[name];
            }

            delete queryStringObject['page'];

            filterproducts(queryStringObject);

            setTimeout(function () {
                $(".PleaseWaitDiv").hide();
            }, 3000);

            return false;
        });

        // Mobile filter drawer: "Apply Filter" button — gathers every
        // checked .filterAjax input (including .mob-filter ones, which
        // the instant desktop click handler below skips) then filters.
        $(".apply-filter").click(function () {

            $(".PleaseWaitDiv").show();
           
            buildQueryStringObject();

            filterproducts(queryStringObject);
            
			$(".filter-close-btn").trigger('click');
			
			
            setTimeout(function () {
                $(".PleaseWaitDiv").hide();
            }, 3000);

        });

        // Mobile filter drawer: "Clear Filter" — resets checkboxes and
        // re-fetches the unfiltered list via AJAX (no page reload).
        $(".clear-filter").click(function () {
            $('.filterAjax').prop('checked', false);
            filterproducts({});
			$(".filter-close-btn").trigger('click');
        });

        // Desktop "Clear All" — same behavior as .clear-filter above.
        $(document).on('click', '.filter-clear-btn', function () {
            $('.filterAjax').prop('checked', false);
            filterproducts({});
        });

        // Full navigation back to the category's base URL (drops all
        // filters/sort/page state entirely, unlike the AJAX clear above).
        $(".ClearFilter").click(function () {
            window.location.href = '<?php echo $page_link; ?>';
        });

        // Desktop instant-filter checkboxes (skips .mob-filter inputs,
        // which are handled via the "Apply Filter" button instead).
        $(".filterAjax").click(function () {

            if ($(this).hasClass('mob-filter')) {
                return;
            }

            $(".PleaseWaitDiv").show();

            var name = $(this).attr('name');
            queryStringObject[name] = [];

            $.each($("input[name='" + name + "']:checked"), function () {
                queryStringObject[name].push($(this).val());
            });

            if (queryStringObject[name].length == 0) {
                delete queryStringObject[name];
            }

            delete queryStringObject['page'];

            filterproducts(queryStringObject);

            setTimeout(function () {
                $(".PleaseWaitDiv").hide();
            }, 3000);

        });

        // Sort dropdown
        $(document).on('change', '.getsort', function () {
            var value = $(this).val();
            var name = $(this).attr('name');

            queryStringObject[name] = [value];

            if (value == "") {
                delete queryStringObject[name];
            }

            delete queryStringObject['page'];

            filterproducts(queryStringObject);
        });

        // Mobile filter drawer open/close
        $(".device-filter").click(function () {
            $(".sidebar").removeClass('d-none').addClass('d-sm-block').addClass('mobile-filter');
        });

        $(".m-filter-close").click(function () {
            $('.sidebar').addClass('d-none').removeClass('d-sm-block').removeClass('mobile-filter');
        });

    });

</script>
@stop