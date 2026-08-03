@extends('layouts.frontLayout.front-layout')
@section('content')

<main>
 <!--  <div class="site-main  main-container no-sidebar">
    <div class="section-037">
      <div class="container">
        <div class="rage-popupvideo style-01 mt-3 pt-2">
          <div class="row">
            <ol class="breadcrumb">
              <li><a href="{{ url('/') }}">Home&nbsp;/&nbsp;</a></li>
              <li class="active">About</li>
            </ol>
          </div>
        </div>
      </div>
    </div>
  </div> -->
  <div class="section-037 about-wrapper" data-aos="fade-down">
    <div class="container">
      <div class="row align-items-center">
       
         <div class=" col-12">
          <div class="img-wrapper">
            <img src="{{ asset('img/banner/store-locator1.jpg') }}" class="attachment-full size-full w-100" alt="img">
          </div>
        </div>
        <div class=" col-12 popupvideo-wrap">
           <h3 class="title">Who we are</h3>
            <p class="desc">Living to its name RAGE for the past 15 years has dedicatedly and passionately strived to bring the best of knitwear and apparel to an ever growing fashion conscious client. With the huge manifesto of 25 EBO and over 500 MBOs and departmental stores throughout India accounting for its parent company RAGE KNIT, our merchandise includes cardigans, knitted tops, woven blouses, dresses, tunics, jumpers, capes, ponchos etc for women. We also offer fine merchandise in plus size clothing. Based in Ludhiana, Rage as a unit comprises of the most modern knitting and finishing machinery with a dedicated design and production team.</p>
          </div>
      </div>
        <div class="row about-facts">
          <!-- Fact 1 -->
          <div class="col-md-4 col-sm-6 col-12">
            <div class="fact-box">
              <p><strong>30</strong> EBO</p>
            </div>
          </div>

          <!-- Fact 2 -->
          <div class="col-md-4 col-sm-6 col-12">
            <div class="fact-box">
              <p><strong>500</strong> MBO's</p>
            </div>
          </div>

          <!-- Fact 3 -->
          <!-- <div class="col-md-4 col-sm-6 col-12">
            <div class="fact-box">
              <p><strong>5</strong> Departmental Stores</p>
            </div>
          </div> -->

          <!-- Fact 4 -->
          <div class="col-md-4 col-sm-6 col-12">
            <div class="fact-box border-0">
              <p><strong>10+</strong> Countries Export</p>
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