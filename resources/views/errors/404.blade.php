@extends('layouts.frontLayout.front-layout')
@section('content')
<?php use App\CustomFunction; use App\Wishlist; ?>
<div class="main-container shop-page left-sidebar error-page">
  <div class="container">
    <div class="row mt-3 pt-3">
      <ol class="breadcrumb">
        <li><a href="{{ url('/') }}">Home &nbsp;/&nbsp;</a></li>
        <li class="active">Page not found</li>
      </ol>
    </div>
	<div class="row mt-3 pt-3 justify-content-center">
    <div class="main-content col-xl-9 col-lg-8 col-md-8 col-sm-12 has-sidebar text-center" style="margin-top:-20px">
        <img src="{{ asset('images/404.png') }}" class="img-responsive" alt=""/><br>
        <p class="text-center" ><b>The page you are looking for couldn't be found If you need some help</b></p>
			  <div class="error-btn"><a href="{{ url('/contact-us') }}" class="error-cntct-btn">Contact Us</a></div>
	  </div>
  </div>
  </div>
</div>
@stop
@section('javascript')
@parent
@stop

