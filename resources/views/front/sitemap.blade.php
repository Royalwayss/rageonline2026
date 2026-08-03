@extends('layouts.frontLayout.front-layout')
@section('content')
<?php $SITE_URL = ''; ?>

<main>
    <div class="site-main main-container no-sidebar policy-divs">
      <div class="section-037">
        <div class="container">
          <div class="rage-popupvideo style-01">
            <!-- <div class="row">
              <ol class="breadcrumb">
                <li><a href="{{ url('/') }}">Home&nbsp;/&nbsp;</a></li>
                <li class="active">Sitemap</li>
              </ol>
            </div> -->
            <div class="row site-box">

                        <div class="col-sm-12">
                            <h3>Sitemap</h3>
                        <hr>
                        <h4 class="mb-3"><a href="{{ url('/new-arrivals') }}">New Arrival</a></h4>
                        </div>
                        <div class="col-sm-6 col-xs-12">
                            <ul class="sitemap-nav">
                                <li></li>
                                <li><a class="sitemap-min-title" href="javascript:void(0)">Collection</a>
                                    <ul class="st-min-list">
    								  @foreach($categories as $category)
                                        <li><i class="fas fa-chevron-right"></i>&nbsp;<a href="{{url('/'.$category['seo_unique'])}}">	{{$category['name']}}</a></li>
                                        @if(!empty($category['subcategories']))
    										@foreach($category['subcategories'] as $subcategory)
    											 <li>&nbsp;&nbsp;&nbsp;<i class="fas fa-chevron-right"></i><i class="fas fa-chevron-right"></i>&nbsp;<a href="{{url('/'.$subcategory['seo_unique'])}}">	{{$subcategory['name']}}</a></li>
    										@endforeach
    									@endif
    								  @endforeach
    								</ul>
                                </li>
                                
                            </ul>
                        </div>
                        <div class="col-sm-6 col-xs-12">
                            <ul class="sitemap-nav">
                                <li><a href="javascript:void(0)" class="sitemap-min-title">About Us</a></li>
                                <ul class="st-min-list">
                                <li><i class="fas fa-chevron-right"></i>&nbsp;&nbsp;<a href="{{ url('lookbook') }}">Ad Campaign</a></li>
                                <li><i class="fas fa-chevron-right"></i>&nbsp;&nbsp;<a href="{{ url('about-us') }}">About Us</a></li>
                                <li><i class="fas fa-chevron-right"></i>&nbsp;&nbsp;<a href="{{ url('store-locator') }}">Stores</a></li>
                                <!--<li><i class="fas fa-chevron-right"></i>&nbsp;&nbsp;<a href="e-catalogue.php">E-Catalogue</a></li>-->
                             
                                <li><i class="fas fa-chevron-right"></i>&nbsp;&nbsp;<a href="{{ url('feedback') }}">Feedback</a></li>
                                <li><i class="fas fa-chevron-right"></i>&nbsp;&nbsp;<a href="{{ url('franchise-enquiry') }}">Franchise Enquiry</a></li>
                                <li><i class="fas fa-chevron-right"></i>&nbsp;&nbsp;<a href="{{ url('contact-us') }}">Contact Us</a></li>
    							<li><i class="fas fa-chevron-right"></i>&nbsp;&nbsp;<a href="{{ url('privacy-policy') }}">Privacy Policy</a></li>
    							<li><i class="fas fa-chevron-right"></i>&nbsp;&nbsp;<a href="{{ url('cancellation-policy') }}">Cancellation Policy</a></li>
    							<li><i class="fas fa-chevron-right"></i>&nbsp;&nbsp;<a href="{{ url('return-and-refund-policy') }}">Return & Refund Policy</a></li>
    							<li><i class="fas fa-chevron-right"></i>&nbsp;&nbsp;<a href="{{ url('shipping-policy') }}">Shipping Policy</a></li>
                                <li><i class="fas fa-chevron-right"></i>&nbsp;&nbsp;<a href="{{ url('terms-and-conditions') }}">Terms of Use</a></li>
                                <li><i class="fas fa-chevron-right"></i>&nbsp;&nbsp;<a href="http://rageknit.blogspot.in/">Our Blog</a></li>
                                </ul>
                            </ul>
                        </div>
                    </div>
                
          </div>
        </div>
      </div>
    </div>
</main>

@stop
@section('javascript')
@parent

@stop