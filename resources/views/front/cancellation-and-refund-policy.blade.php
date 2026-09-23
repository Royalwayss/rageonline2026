@extends('layouts.frontLayout.front-layout')
@section('content')

<main class="inner-page">
    <section class="policy-page">
        <div class="container">

            <div class="detail-breadcrumb" data-aos="fade-up">
                <a href="{{ url('/') }}">Home</a>
                <span>/</span>
                <span>Cancellation &amp; Refund Policy</span>
            </div>

            <div class="policy-content-box" id="cms_content" data-aos="fade-up" data-aos-delay="100">
                <h1>Cancellation &amp; Refund Policy</h1>

                <p>At <strong>Rage</strong>, we strive to offer a smooth and transparent shopping experience. Please review our Cancellation &amp; Refund Policy below:</p>

                <p><b>Order Cancellation</b></p>
                <ul>
                    <li>Orders can be <strong>cancelled within 24 hours</strong> of purchase.</li>
                    <li>After 24 hours, cancellation requests cannot be accepted as the order may already be processed or dispatched.</li>
                </ul>

                <p><b>Refund &amp; Voucher Terms</b></p>
                <ul>
                    <li>
                        <strong>All orders cancelled with a value below or equal to &#8377;2000</strong> will be either:
                        <ul>
                            <li>Refunded to the <strong>user&rsquo;s original account of transaction, or</strong></li>
                            <li>Issued as a Rage Discount Voucher of equivalent value within <strong>7 working days</strong> via email.
                                All voucher terms &amp; conditions will remain valid and applicable at all times.
                            </li>
                        </ul>
                    </li>
                    <li><strong>All orders cancelled with a value above &#8377;2000 will be refunded directly to the user&rsquo;s original account of transaction.</strong></li>
                </ul>

                <p><b>Platform Safety &amp; Verification</b></p>
                <ul>
                    <li>Rage reserves the right to <strong>cancel any order</strong> placed using a <strong>Credit Card with an International Billing Address</strong>, or any order that appears <strong>dubious, suspicious, or invalid</strong> in probity.</li>
                </ul>

                <p><b>Need Assistance?</b></p>
                <p>For any enquiries please mail us at <a href="mailto:rageindiaonline@gmail.com">rageindiaonline@gmail.com</a></p>
            </div>

        </div>
    </section>
</main>
@stop