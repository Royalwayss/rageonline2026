<?php
    use App\CustomFunction;
    use App\Cart;
    use App\CouponCode;
    use App\ProductAttribute;

    $total_gst = '0';
    $subtotal = '0';
    $total_cart_qty = '0';
    $total_cart_items = Cart::items('count');

    $summery = Cart::cartdetails($cartitems);
    $order_discount = $summery['order_discount'];
    $order_discount_percentage = $summery['order_discount_percentage'];

    $shipping = Cart::CalculateShipping($cartitems);
    $couponamount = 0;
    if (Session::has('couponinfo')) {
        $couponamount = CouponCode::getCouponAmount(Session::get('couponinfo'), $subtotal);
    }
?>

<div class="row">

    <!-- CART ITEMS -->
    <div class="col-lg-8 col-12">

        @if(!empty($total_cart_items))
        <div class="cart-items">

            <div class="cart-items-head">
                <h5>IN MY BAG <span>( {{ $total_cart_items }} {{ $total_cart_items > 1 ? 'ITEMS' : 'ITEM' }} )</span></h5>
            </div>

            @foreach($cartitems as $cartitem)
                <?php
                    $priceDetails = Cart::calProPricing($cartitem);
                    $subtotal += $priceDetails['prosubtotal'];
                    $total_cart_qty += $cartitem['qty'];
                ?>
                <div class="cart-item">
                    <div class="cart-product-img">
                        <a target="_blank" href="{{ url('/product/'.$cartitem['product']['seo_url']) }}">
                            @if(!empty($cartitem['product']['product_image']))
                                <img src="{{ asset('images/ProductImages/small/'.$cartitem['product']['product_image']['image']) }}" alt="{{ $cartitem['product']['product_name'] }}">
                            @else
                                <img src="{{ asset('images/no-image-found.jpg') }}" alt="{{ $cartitem['product']['product_name'] }}">
                            @endif
                        </a>
                    </div>

                    <div class="cart-product-info">

                        <div class="cart-product-top">
                            <div>
                                <span class="cart-collection">{{ $cartitem['product']['category']['name'] }}</span>

                                <h3>
                                    <a href="{{ url('product/'.$cartitem['product']['seo_url']) }}">
                                        {{ $cartitem['product']['product_name'] }}
                                    </a>
                                </h3>
                            </div>

                            <a href="javascript:;" class="cart-remove removeCartProduct" data-cart="{{ $cartitem['id'] }}">
                                <i class="fa-solid fa-xmark"></i>
                            </a>
                        </div>

                        <div class="cart-variant">
                            <span>Color: {{ $cartitem['product']['color'] }}</span>
                            <span>Size: {{ $cartitem['size'] }}</span>
                        </div>

                        <div class="cart-product-bottom">

                            <div class="quantity-box">
                                <button type="button" class="qty-minus" onclick="qty_onchange('minus',{{ $cartitem['id'] }})">&minus;</button>
                                <input type="number" min="0" id="qty-{{ $cartitem['id'] }}" data-cartid="{{ $cartitem['id'] }}" name="qty" value="{{ $cartitem['qty'] }}" class="cart_qty">
                                <button type="button" class="qty-plus cart_qty" onclick="qty_onchange('plus',{{ $cartitem['id'] }})">&plus;</button>
                            </div>

                            <div class="cart-price">
                                INR {{ CustomFunction::formatAmt($priceDetails['prosubtotal']) }}
                            </div>

                        </div>

                    </div>
                </div>
            @endforeach

        </div>
        @else
        <div class="empty-cart text-center py-5">
            <i class="fa-solid fa-bag-shopping fa-3x text-muted mb-3"></i>
            <h3>Your Shopping Bag is Empty</h3>
            <p class="text-muted">Discover our winter collection and handcrafted ensembles.</p>
            <a href="{{ url('/') }}" class="primary-btn mt-3 d-inline-block">Continue Shopping</a>
        </div>
        @endif

    </div>


    <!-- ORDER SUMMARY -->
    <div class="col-lg-4 col-12">
        <div class="order-summary">
            <h3>Order Summary</h3>

            <div id="PrintMessages"></div>

            <div class="coupon-box">
                <label>Promo Code</label>

                <form id="ApplyCoupon" method="post" action="javascript:void(0);">
                    @csrf
                    <div class="coupon-input">
                        <input type="text" id="couponInput" name="code" @if(Session::has('couponinfo')) value="{{ Session::get('couponinfo')['code'] }}" @endif placeholder="Enter promo code">
                        <button type="submit">Apply</button>
                    </div>
                </form>

                @if(Auth::check())
                    <?php $coupons = CouponCode::availableCoupons($cartitems); ?>
                    @if($coupons)
                    <div class="available-coupons">
                        @foreach($coupons as $coupon)
                        <div class="available-coupon">
                            <div>
                                <strong>{{ $coupon['code'] }}</strong>
                                <span>{{ $coupon['terms_and_conditions'] }}</span>
                            </div>

                            @if(Session::has('couponinfo') && Session::get('couponinfo')['code'] == $coupon['code'])
                                <img src="{{ asset('assets/images/icons/tick-icon.png') }}" alt="Applied" style="width:20px;">
                            @else
                                <button type="button" class="copy-coupon" onclick="copyCode('{{ $coupon['code'] }}')">
                                    Copy
                                </button>
                            @endif
                        </div>
                        @endforeach
                    </div>
                    @endif
                @endif
            </div>

            <div class="summary-row">
                <span>Qty</span>
                <strong>{{ $total_cart_qty }}</strong>
            </div>

            <div class="summary-row">
                <span>Subtotal</span>
                <strong>INR {{ CustomFunction::formatAmt($subtotal) }}</strong>
            </div>

            <div class="summary-row">
                <span>Coupon Discount</span>
                <strong>INR {{ CustomFunction::formatAmt($couponamount) }}</strong>
            </div>

            @if(!empty($order_discount))
            <div class="summary-row">
                <span>Order Discount ({{ $order_discount_percentage }}%)</span>
                <strong>INR {{ CustomFunction::formatAmt($order_discount) }}</strong>
            </div>
            @endif

            <div class="summary-row">
                <span>Shipping</span>
                <strong>{{ !empty($shipping) ? 'INR '.CustomFunction::formatAmt($shipping) : 'Free' }}</strong>
            </div>

            <?php
                if (Session::has('couponinfo')) {
                    $tot = CustomFunction::formatAmt($subtotal + $shipping - ($couponamount + $order_discount));
                } else {
                    $tot = CustomFunction::formatAmt(($subtotal + $shipping) - $order_discount);
                }
            ?>
            <div class="summary-total">
                <span>Total</span>
                <strong>INR {{ number_format(round($tot)) }}</strong>
            </div>

            @if(Auth::check())
                <a href="{{ url('order-checkout') }}" class="primary-btn cart-checkout-btn">
                    Proceed To Checkout
                </a>
            @else
                <a href="{{ url('login') }}" class="primary-btn cart-checkout-btn">
                    Proceed To Checkout
                </a>

                <div class="text-center" style="margin-top:10px">OR</div>

                <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#GuestCheckoutModal" class="primary-btn cart-checkout-btn" style="margin-top:10px;">
                    Guest Checkout
                </a>
            @endif

            <a href="{{ url('/') }}" class="continue-shopping">
                <i class="fa-solid fa-arrow-left-long"></i>
                Continue Shopping
            </a>

            <p style="font-weight: 500; font-size: 13px; margin-top:16px;">
                Note: Return request will be accepted within 24 hours only once the order gets delivered.
            </p>

            <div class="cart-services">
                <div>
                    <i class="fa-solid fa-truck"></i>
                    <span>Secure Delivery</span>
                </div>
                <div>
                    <i class="fa-solid fa-shield-halved"></i>
                    <span>Secure Payment</span>
                </div>
                <div>
                    <i class="fa-solid fa-rotate-left"></i>
                    <span>Shop with Confidence</span>
                </div>
            </div>

        </div>
    </div>

</div>