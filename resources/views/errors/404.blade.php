@extends('layouts.frontLayout.front-layout')
@section('content')
<?php use App\CustomFunction; use App\Wishlist; ?>

<main class="inner-page">
    <section class="error-page">
        <div class="container">

            <div class="detail-breadcrumb" data-aos="fade-up">
                <a href="{{ url('/') }}">Home</a>
                <span>/</span>
                <span>Page Not Found</span>
            </div>

            <div class="thankyou-box" data-aos="fade-up" data-aos-delay="100">

                <img src="{{ asset('images/404.png') }}" class="img-fluid error-illustration" alt="Page not found" style="margin-top: -24px;">

                <h1>Page Not Found</h1>

                <p class="thankyou-message">
                    The page you are looking for couldn't be found. If you need some help, our team is happy to assist.
                </p>

                <div class="thankyou-actions">
                    <a href="{{ url('/') }}" class="primary-btn">
                        Back To Home
                    </a>

                    <a href="{{ url('/contact-us') }}" class="continue-link">
                        Contact Us
                        <i class="fa-solid fa-arrow-right-long"></i>
                    </a>
                </div>

            </div>

        </div>
    </section>
</main>
@stop
@section('javascript')
@parent
@stop