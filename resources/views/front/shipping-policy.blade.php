@extends('layouts.frontLayout.front-layout')
@section('content')

<main class="inner-page">
    <section class="policy-page">
        <div class="container">

            <div class="detail-breadcrumb" data-aos="fade-up">
                <a href="{{ url('/') }}">Home</a>
                <span>/</span>
                <span>Shipping Policy</span>
            </div>

            <div class="policy-content-box" data-aos="fade-up" data-aos-delay="100">
                <h1>Shipping Policy</h1>

                <p>We dispatch your order through a reputed logistics partner (Depending upon your location).Normally, we ship your order within 24 to 48 hours of receiving the order and it takes 5 to 7 business days to reach your doorstep. (Delivery time may be exceeded depending upon your location). If your order exceeds the average delivery time mentioned and you would like an update on its exact status, please contact us via email at <a href="mailto:rageindiaonline@gmail.com">rageindiaonline@gmail.com</a></p>
                <p>We are delighted to inform you that there are no shipping charges for both the prepaid and cash on delivery (COD) orders. In case if we provide shipping and cod charges then please note that shipping and Cash on Delivery (COD) charges are Non-Refundable.</p>
                <p>We offer delivery services across India, except for a few pin codes where serviceability may not be possible</p>
                <p><b>If you haven&rsquo;t received your order?</b></p>
                <p>Don&rsquo;t worry. Just write to us at rageindiaonline@gmail.com with your order number and we'll update you about the exact status of your order.</p>
            </div>

        </div>
    </section>
</main>
@stop