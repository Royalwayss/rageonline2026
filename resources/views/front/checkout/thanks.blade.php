@extends('layouts.frontLayout.front-layout')
@section('content')
<?php
    use App\GiftOffer;

    $total_amount = 0;
    foreach ($orderdetails['order_products'] as $orderpro) {
        $total_amount = $orderpro['grand_total'];
    }
?>

<main class="inner-page">
    <section class="thankyou-page">
        <div class="container">

            <div class="thankyou-box">

                <div class="thankyou-icon">
                    <i class="fa-solid fa-check"></i>
                </div>

                <span class="thankyou-label">Order Confirmed</span>

                <h1>Thank You For Your Order</h1>

                <p class="thankyou-message">
                    Your order has been placed successfully.
                    We'll send your order confirmation and delivery updates to your registered email and mobile
                    number.
                </p>

                <div class="order-number">
                    <span>Order Number</span>
                    <strong>#{{ Session::get('orderid') }}</strong>
                </div>

                <div class="thankyou-summary">

                    <div class="thankyou-total">
                        <span>Total Paid</span>
                        <strong>INR {{ formatAmt($total_amount) }}</strong>
                    </div>

                </div>

                <div class="thankyou-info">

                    <div>
                        <i class="fa-regular fa-envelope"></i>
                        <span>Confirmation details have been sent to your email.</span>
                    </div>

                    <div>
                        <i class="fa-solid fa-mobile-screen-button"></i>
                        <span>You'll receive shipping updates on your mobile.</span>
                    </div>

                </div>
                <?php /*
                <div class="thankyou-products">
                    <h4>Products</h4>

                    @foreach($orderdetails['order_products'] as $orderpro)
                    <div class="thankyou-product-row">
                        <a target="_blank" href="{{ url('/product/'.$orderpro['productdetail']['seo_url']) }}" class="thankyou-product-img">
                            @if(isset($orderpro['productdetail']['product_image']))
                                <img src="{{ asset('images/ProductImages/small/'.$orderpro['productdetail']['product_image']['image']) }}" alt="{{ $orderpro['product_name'] }}">
                            @else
                                <img src="{{ asset('images/no-image-found.jpg') }}" alt="{{ $orderpro['product_name'] }}">
                            @endif
                        </a>

                        <div class="thankyou-product-info">
                            <h5>
                                <a target="_blank" href="{{ url('/product/'.$orderpro['productdetail']['seo_url']) }}">
                                    {{ $orderpro['product_name'] }}
                                </a>
                            </h5>
                            <p>{{ $orderpro['product_size'] }}</p>
                            <p>INR {{ formatAmt($orderpro['subtotal']) }}</p>
                        </div>
                    </div>
                    @endforeach

                </div> */ ?>

                @if(Session::has('giftSession'))
                <?php $giftInfo = GiftOffer::giftinfo(Session::get('giftSession')); ?>
                <div class="thankyou-gift">
                    <h5>Free Gift Included</h5>
                    <img src="{{ asset('images/GiftImages/'.$giftInfo->gift_image) }}" alt="Free Gift" class="img-fluid">
                </div>
                @endif

                <div class="thankyou-actions">
                    <a href="{{ url('account/orders') }}" class="primary-btn">
                        View Order
                    </a>

                    <a href="{{ url('/') }}" class="continue-link">
                        Continue Shopping
                        <i class="fa-solid fa-arrow-right-long"></i>
                    </a>
                </div>

            </div>

        </div>
    </section>
</main>

<?php
Session::forget('orderid');
Session::forget('giftSession');
?>
@stop