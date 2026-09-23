@extends('layouts.frontLayout.front-layout')
@section('content')
<?php use App\GiftOffer; ?>

<main class="inner-page">
    <section class="thankyou-page">
        <div class="container">

            <div class="thankyou-box">

                <div class="thankyou-icon cancelled">
                    <i class="fa-solid fa-xmark"></i>
                </div>

                <span class="thankyou-label cancelled">Order Cancelled</span>

                <h1>Your Order Has Been Cancelled</h1>

                <p class="thankyou-message">
                    Your Order <strong>#{{ Session::get('orderid') }}</strong> has been cancelled.
                    If any payment was made, it will be refunded as per our
                    <a href="{{ url('cancellation-and-refund-policy') }}">Cancellation &amp; Refund Policy</a>.
                </p>

                <div class="thankyou-actions">
                    <a href="{{ url('account/orders') }}" class="primary-btn">
                        View Order History
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