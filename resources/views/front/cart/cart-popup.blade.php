<?php use App\Cart; 

$cartitems = Cart::cartitems();

$cart_count = count($cartitems);

$subtotal = 0;

//echo "<pre>"; print_r($cartitems); ?>



<div class="minicart" id="cart-popup">

    <div class="minicart-body">

        <div class="minicart-content cart-popup-items">

            @if(!empty($cartitems))

            <ul class="text-left">

                @foreach($cartitems as $cartitem)

                <?php $priceDetails = Cart::calProPricing($cartitem);

                            

                                $subtotal +=  $priceDetails['prosubtotal']; ?>

                <li>

                    <div class="minicart-img">

                        <a href="{{ url('product/'.$cartitem['product']['seo_url']) }}" class="p-0">

                            @if(!empty($cartitem['product']['product_image']))

                            <img src="{{asset('images/ProductImages/small/'.$cartitem['product']['product_image']['image'])}}" class="w-100" alt="" />

                            @else

                            <img src="{{asset('images/no-image-found.jpg')}}" alt="" class="img-fluid" alt="{{$cartitem['product']['product_name']}}" title="{{$cartitem['product']['product_name']}}" />

                            @endif

                        </a>

                    </div>

                    <div class="minicart-desc">

                        <a href="{{ url('product/'.$cartitem['product']['seo_url']) }}" class="p-0 cart-product-name" style="color:black!important"> 

                            @php echo wordwrap($cartitem['product']['product_name'],30,"<br />

                            \n"); @endphp

                        
                            <br />
                        <strong>{{ $cartitem['qty'] }} × {{ formatAmt($priceDetails['prosubtotal'] / $cartitem['qty']) }}</strong>
                        </a>

                    </div>

                    <div class="remove">

                        <a href="javascript:;" data-type="popup" data-cart="{{ $cartitem['id'] }}" class="remove remove_from_cart_button removeCartProduct">X</a>

                    </div>

                </li>



                @endforeach

            </ul>

            @else

            <div class="col-12 text-center pt-5 pb-5">

                <i class="fa fa-exclamation-circle fa-4x orange"></i>

                <h5 class="mt-4 mb-4">No items Found in cart</h5>

            </div>

            @endif

        </div>

    </div>
 @if(!empty($cartitems))
    <div class="minicart-checkout">

        <div class="minicart-checkout-heading mt-8 mb-25 overflow-hidden">

            <strong class="float-left">Subtotal:</strong>

            <span class="price float-right" style="margin-right: 19px;">INR {{ $subtotal }}</span>

        </div>

        <div class="minicart-checkout-links">

            <a href="{{url('/cart') }}" class="generic-btn minicart-button">View cart</a>

            <a href="{{url('/order-checkout ') }}" class="generic-btn minicart-button">Checkout</a>

        </div>

    </div>
@endif
</div>

