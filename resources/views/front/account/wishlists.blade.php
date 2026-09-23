<style>
.prod-info .name-wrap h4 {
    font-family: 'Playfair Display', serif; /* or whatever your site's serif heading font is */
    font-style: italic;
    font-weight: 400;
    font-size: 18px;
    color: #2b2b2b;
    margin-bottom: 8px;
}

.prod-info .price {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 6px;
}

.prod-info .sale-price {
    font-weight: 700;
    font-size: 16px;
    color: #1a1a1a;
}

.prod-info del {
    color: #999;
    font-size: 14px;
    font-weight: 400;
    text-decoration: line-through;
}

.prod-info .discount {
    background: #d4b896; /* tan/gold, adjust to match your brand color */
    color: #4a3728;
    font-size: 11px;
    font-weight: 600;
    padding: 3px 8px;
    border-radius: 3px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}
</style>

<div class="listing-heading wish-head mt-4">
    <div class="breadcrumb-wrap">
        <a href="{{ url('/') }}">Home</a>
        <span>/</span>
        <a href="{{ url('account/dashboard') }}">Account</a>
        <span>/</span>
        <span>Wishlist</span>
    </div>
    <h1>My Curated Wishlist ({{ count($wishlists) }} {{ count($wishlists) == 1 ? 'Item' : 'Items' }})</h1>
</div>

@if(Session::has('flash_message_success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <strong>Success! </strong> {!! session('flash_message_success') !!}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<div class="addcart" tabindex="-1"></div>

<div class="product-grid">

    @if(count($wishlists) > 0)
    <div class="row">
        @foreach($wishlists as $wishlist)
        <div class="col-lg-4 col-md-4 col-6">
            <div class="prod-card">
                <div class="prod-img">
                    <a href="{{ url('product/'.$wishlist->product->seo_url) }}">
                        @if(!empty($wishlist->product->product_image))
                            <img src="{{ asset('images/ProductImages/xlarge/'.$wishlist->product->product_image->image) }}" alt="{{ $wishlist->product->product_name }}">
                        @else
                            <img src="{{ asset('images/no-image-found.jpg') }}" alt="{{ $wishlist->product->product_name }}">
                        @endif
                    </a>

                    <a href="{{ url('remove-wishlist/'.$wishlist->id) }}" onclick="return confirm('Are you sure?')" title="Remove from Wishlist">
                        <i class="fa-solid fa-trash"></i>
                    </a>

                    @if($wishlist->product->status == 1)
                    <div class="cart-btn">
                        {{-- NOTE: field names (product_id/size/qty) are my best guess -
                             confirm these match your /add-to-cart controller's real
                             validation rules. --}}
                        <form id="{{ $wishlist->id }}"  action="{{ url('product/'.$wishlist->product->seo_url) }}" style="display: contents;">
                            
                            <button type="submit" class="link-btn black">Add to Cart</button>
                        </form>
                        <a href="{{ url('product/'.$wishlist->product->seo_url) }}" class="link-btn brown">Buy Now</a>
                    </div>
                    @endif
                </div>

                <div class="prod-info">
                    <div class="name-wrap d-block">
                        <a href="{{ url('product/'.$wishlist->product->seo_url) }}">
                            <h4>{{ $wishlist->product->product_name }}</h4>
                        </a>
                        <span class="price">
                            {!! productPriceHtml($wishlist->product) !!}
                        </span>
                        <p class="wishlist-meta">
                            Size: {{ $wishlist->size }} &nbsp;|&nbsp; Item No: {{ $wishlist->product->product_code }} &nbsp;|&nbsp; Color: {{ $wishlist->product->color }}
                        </p>

                        @if($wishlist->product->status != 1)
                        <p class="text-danger"><strong>Product is not available</strong></p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @else
   <!-- <div class="row">
        <div class="col-12 text-center pt-5 pb-5">
            <i class="fa-regular fa-heart fa-4x text-muted mb-3"></i>
            <h3>No Wishlist Items Found</h3>
            <p class="text-muted">Save pieces you love and find them here anytime.</p>
            <a href="{{ url('/') }}" class="primary-btn mt-3 d-inline-block">Continue Shopping</a>
        </div>
    </div> -->
    @endif

</div>

@section('javascript')
@parent
<script type="text/javascript" src="{{ asset('js/ajax_jquery.min.js')}}"></script>
<script type="text/javascript">
    $(".MovetoBag").submit(function(e) {
        var id = $(this).attr('id');
        e.preventDefault();
        $('.PleaseWaitDiv').show();
        var formdata = $("#" + id).serialize();
        $.ajax({
            url: '/add-to-cart',
            type: 'POST',
            data: formdata,
            success: function(data) {
                $('.PleaseWaitDiv').hide();
                if (!data.status) {
                    if (data.type == "validation") {
                        $.each(data.errors, function(key, value) {
                            alert(value);
                        });
                    }
                } else {
                    $('.totalItems').html(data.totalitems);
                    $(".shopping-cart").toggleClass("active");
                    var alertclasss = 'success';
                    var message = 'Product added successfully in cart';
                    $('.addcart').html('<div class="alert alert-' + alertclasss + ' alert-dismissible"><button type="button" class="btn-close" data-bs-dismiss="alert"></button><span>' + message + '</span></div>');
                    $('.addcart').focus();
					//location.reload();
                }
            }
        });
    });
</script>
@stop