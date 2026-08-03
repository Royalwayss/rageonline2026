@extends('layouts.frontLayout.front-layout')
@section('content')
<?php use App\CustomFunction; use App\Wishlist; ?>
<style>
   .slick-dots{ display:none!important; }
   .home-top-banner{ padding-top: 89px!important; } 
   @media only screen and (max-width:767px) {
   .home-top-banner{ padding-top: 0px!important; } 
   }
   .carousel-control-next,.carousel-control-prev{position:absolute;top:0;bottom:0;z-index:1;display:-ms-flexbox;display:flex;-ms-flex-align:center;align-items:center;-ms-flex-pack:center;justify-content:center;width:15%;color:#fff;text-align:center;opacity:.5;transition:opacity .15s ease}
   
   .next_icon{  margin-top: 72px; }
   .prev_icon{  margin-top: 72px; }  

   @media only screen and (max-width: 600px) {
	   .next_icon{  margin-top: -11px; }
	   .prev_icon{  margin-top: -11px; }
   }
</style>
<div class="fullwidth-template">

<div id="homeSlider" class="carousel slide" data-ride="carousel">
   <!-- Indicators -->
   <ul class="carousel-indicators">
      <li data-target="#homeSlider" data-slide-to="0" class="active"></li>
      <li data-target="#homeSlider" data-slide-to="1"></li>
   </ul>
   <div class="carousel-inner">
      <div class="section-003 section-002 home-top-banner carousel-item active">
         <a href="{{ url('tops-and-tunics') }}">
         <img class="img-fluid w-100" src="{{ asset('assets/images/banner-march.png') }}" /> 
         </a>
      </div>
      <div class="section-003 section-002 home-top-banner carousel-item">
         <a href="{{ url('tops-and-tunics') }}">
         <img class="img-fluid w-100" src="{{ asset('assets/images/home-banner.png') }}" /> 
         </a>
      </div>
      <div class="">			
         <a class="next_icon carousel-control-prev" href="#homeSlider" data-slide="prev">
			<span class=" carousel-control-prev-icon"></span>
         </a>
         <a class="prev_icon carousel-control-next" href="#homeSlider" data-slide="next">
			<span class="carousel-control-next-icon"></span>
         </a>
      </div>
   </div>
   <!-- Left and right controls -->
</div>
<div class="section-003 section-002">
   <div class="container">
      <div class="row">
         <div class="col-md-12 col-lg-6 mb-5">
            <div class="rage-banner style-01 left-center">
               <a target="_self" href="{{ url('dresses') }}">
                  <div class="banner-inner">
                     <figure class="banner-thumb"> <img src="{{ asset('assets/images/dress.jpg') }}" class="attachment-full size-full" alt="Dresses" title="Dresses"> </figure>
                     <div class="banner-info ">
                        <div class="banner-content">
                           <div class="title-wrap">
                              <h6 class="title"> 
               <a target="_self" href="{{ url('dresses') }}">Dresses</a> </h6>
               </div>
               <div class="button-wrap"> </div>
               </div>
               </div>
               </div>
               </a> 
            </div>
         </div>
         <div class="col-md-12 col-lg-6 mb-5">
            <div class="rage-banner style-01 left-center">
               <a target="_self" href="{{ url('kaftan') }}">
                  <div class="banner-inner">
                     <figure class="banner-thumb"> <img src="{{ asset('assets/images/kaftan.jpg') }}" class="attachment-full size-full" alt="Kaftan" title="Kaftan"> </figure>
                     <div class="banner-info ">
                        <div class="banner-content">
                           <div class="title-wrap">
                              <h6 class="title"> 
               <a target="_self" href="{{ url('kaftan') }}">Kaftan</a> </h6>
               </div>
               <div class="button-wrap"> </div>
               </div>
               </div>
               </div>
               </a> 
            </div>
         </div>
         <div class="col-md-12 col-lg-12 mb-5">
            <div class="rage-banner style-01 left-center">
               <a target="_self" href="{{ url('tops-and-tunics') }}">
                  <div class="banner-inner">
                     <figure class="banner-thumb"> <img src="{{ asset('assets/images/tops-and-tunics.jpg') }}" class="attachment-full size-full" alt="Tops And Tunics" title="Tops And Tunics"> </figure>
                     <div class="banner-info ">
                        <div class="banner-content">
                           <div class="title-wrap">
                              <h6 class="title"> 
               <a target="_self" href="{{ url('tops-and-tunics') }}">Tops And Tunics</a> </h6>
               </div>
               <div class="button-wrap"> </div>
               </div>
               </div>
               </div>
               </a> 
            </div>
         </div>
         <div class="col-md-12 col-lg-6 mb-5">
            <div class="rage-banner style-01 left-center">
               <a target="_self" href="{{ url('ponchu') }}">
                  <div class="banner-inner">
                     <figure class="banner-thumb"> <img src="{{ asset('assets/images/_K8A0117.jpg') }}"
                        class="attachment-full size-full" alt="Women Ponchos" title="Women Ponchos"> </figure>
                     <div class="banner-info ">
                        <div class="banner-content">
                           <div class="title-wrap">
                              <h6 class="title"> 
               <a target="_self" href="{{ url('ponchu') }}">Ponchu</a> </h6>
               </div>
               <div class="button-wrap"> </div>
               </div>
               </div>
               </div>
               </a> 
            </div>
         </div>
         <div class="col-md-12 col-lg-6 mb-5">
            <div class="rage-banner style-01 left-center">
               <a target="_self" href="{{ url('tops') }}">
                  <div class="banner-inner">
                     <figure class="banner-thumb"> <img src="{{ asset('assets/images/_K8A0208.jpg') }}"
                        class="attachment-full size-full" alt="Women Knitted Tops" title="Women Knitted Tops"> </figure>
                     <div class="banner-info ">
                        <div class="banner-content">
                           <div class="title-wrap">
                              <h6 class="title"> 
               <a target="_self" href="{{ url('tops') }}">Tops</a> </h6>
               </div>
               <div class="button-wrap"> </div>
               </div>
               </div>
               </div>
               </a> 
            </div>
         </div>
      </div>
   </div>
</div>
@if(count($best_seller_products) > 0)
<div class="section-001">
<div class="container">
   <div class="rage-heading style-01">
      <div class="heading-inner">
         <h3 class="title">Best Seller</h3>
         <div class="subtitle">Made with care for your little ones, our products are perfect for every
            occasion. Check it out. 
         </div>
      </div>
   </div>
   @if(count($best_seller_products) > 0)
   <div class="rage-products style-02">
      <?php /*?>  
      <div class="response-product product-list-owl owl-slick equal-container better-height"
         data-slick="{&quot;arrows&quot;:false,&quot;slidesMargin&quot;:30,&quot;dots&quot;:true,&quot;infinite&quot;:false,&quot;speed&quot;:300,&quot;slidesToShow&quot;:4,&quot;rows&quot;:2}"
         data-responsive="[{&quot;breakpoint&quot;:480,&quot;settings&quot;:{&quot;slidesToShow&quot;:3,&quot;slidesMargin&quot;:&quot;10&quot;}},{&quot;breakpoint&quot;:768,&quot;settings&quot;:{&quot;slidesToShow&quot;:3,&quot;slidesMargin&quot;:&quot;10&quot;}},{&quot;breakpoint&quot;:992,&quot;settings&quot;:{&quot;slidesToShow&quot;:3,&quot;slidesMargin&quot;:&quot;20&quot;}},{&quot;breakpoint&quot;:1200,&quot;settings&quot;:{&quot;slidesToShow&quot;:3,&quot;slidesMargin&quot;:&quot;20&quot;}},{&quot;breakpoint&quot;:1500,&quot;settings&quot;:{&quot;slidesToShow&quot;:4,&quot;slidesMargin&quot;:&quot;30&quot;}}]">
         <div class="product-item featured_products style-02 rows-space-30 post-34 product type-product status-publish has-post-thumbnail product_cat-light product_cat-new-arrivals product_tag-light product_tag-hat product_tag-sock first instock sale featured shipping-taxable product-type-grouped">
            <?php */?>
            <div class="response-product product-list-owl owl-slick equal-container better-height"
               data-slick="{&quot;arrows&quot;:false,&quot;slidesMargin&quot;:30,&quot;dots&quot;:true,&quot;infinite&quot;:false,&quot;speed&quot;:300,&quot;slidesToShow&quot;:3,&quot;rows&quot;:1}"
               data-responsive="[{&quot;breakpoint&quot;:480,&quot;settings&quot;:{&quot;slidesToShow&quot;:2,&quot;slidesMargin&quot;:&quot;10&quot;}},{&quot;breakpoint&quot;:768,&quot;settings&quot;:{&quot;slidesToShow&quot;:2,&quot;slidesMargin&quot;:&quot;10&quot;}},{&quot;breakpoint&quot;:992,&quot;settings&quot;:{&quot;slidesToShow&quot;:3,&quot;slidesMargin&quot;:&quot;20&quot;}},{&quot;breakpoint&quot;:1200,&quot;settings&quot;:{&quot;slidesToShow&quot;:3,&quot;slidesMargin&quot;:&quot;30px&quot;}},{&quot;breakpoint&quot;:1500,&quot;settings&quot;:{&quot;slidesToShow&quot;:3,&quot;slidesMargin&quot;:&quot;30px&quot;}}]">
               @foreach($best_seller_products as $key=> $product)
               <div class="product-item featured_products style-02 rows-space-30 post-34 product type-product status-publish has-post-thumbnail product_cat-light product_cat-new-arrivals product_tag-light product_tag-hat product_tag-sock first instock sale featured shipping-taxable product-type-grouped px-4">
                  <div class="product-inner tooltip-top pl-4" >
                     <div class="product-thumb">
                        <a class="thumb-link" href="{{url('/product/'.$product['seo_url']) }}" tabindex="0"> @if(!empty($product['product_image'])) <img class="img-responsive"   src="{{ asset('images/ProductImages/medium/'.$product['product_image']['image'])}}" alt="Black Shirt" width="320" height="350"> @else <img src="{{asset('images/no-image-found.jpg')}}" class="img-responsive img-fluid" alt="no-image-found.jpg" title="no-image-found.jpg" width="auto" height="778"   /> @endif </a>
                        <div class="flash"> <span class="onnew"><span class="text">New</span></span> </div>
                        <a href="{{url('/product/'.$product['seo_url']) }}" class="button yith-wcqv-button">Quick View</a> 
                     </div>
                     <div class="product-info">
                        <h3 class="product-name product_title"> <a href="{{url('/product/'.$product['seo_url']) }}"
                           tabindex="0">{{$product['product_name']}}</a> </h3>
                     </div>
                     <div class=""> </div>
                  </div>
               </div>
               @endforeach 
            </div>
         </div>
         @endif 
      </div>
   </div>
   @endif 
   <!-- <div>
      <div class="rage-banner style-02 left-center">
        <div class="banner-inner">
          <figure class="banner-thumb"> <img src="{{ asset('assets/images/banner101.jpg') }}"
                          class="attachment-full size-full" alt="img"> </figure>
          <div class="banner-info container">
            <div class="banner-content">
              <div class="title-wrap">
                <div class="banner-label"> Modern Glasses </div>
                <h6 class="title"> Best Seller </h6>
              </div>
              <div class="button-wrap">
                <div class="subtitle"> Lorem ipsum dolor sit amet consectetur adipiscing elit justo </div>
                <a class="button" target="_self" href="#"><span>Shop now</span></a> </div>
            </div>
          </div>
        </div>
      </div>
      </div> -->
   <div class="section-001">
      <div class="container">
         <div class="rage-heading style-01">
            <div class="heading-inner">
               <h3 class="title">New Arrival</h3>
               <div class="subtitle">Our products are perfect for every occasion. Check it out. </div>
            </div>
         </div>
         <div class="rage-products style-01">
            <div class="response-product product-list-owl owl-slick equal-container better-height"
               data-slick="{&quot;arrows&quot;:true,&quot;slidesMargin&quot;:30,&quot;dots&quot;:true,&quot;infinite&quot;:false,&quot;speed&quot;:300,&quot;slidesToShow&quot;:4,&quot;rows&quot;:1}"
               data-responsive="[{&quot;breakpoint&quot;:480,&quot;settings&quot;:{&quot;slidesToShow&quot;:2,&quot;slidesMargin&quot;:&quot;10&quot;}},{&quot;breakpoint&quot;:768,&quot;settings&quot;:{&quot;slidesToShow&quot;:2,&quot;slidesMargin&quot;:&quot;10&quot;}},{&quot;breakpoint&quot;:992,&quot;settings&quot;:{&quot;slidesToShow&quot;:3,&quot;slidesMargin&quot;:&quot;20&quot;}},{&quot;breakpoint&quot;:1200,&quot;settings&quot;:{&quot;slidesToShow&quot;:3,&quot;slidesMargin&quot;:&quot;20&quot;}},{&quot;breakpoint&quot;:1500,&quot;settings&quot;:{&quot;slidesToShow&quot;:4,&quot;slidesMargin&quot;:&quot;30&quot;}}]">
               @foreach($new_arrival_products as $key=> $product)
               <div class="product-item recent-product style-01 rows-space-0 post-93 product type-product status-publish has-post-thumbnail product_cat-light product_cat-table product_cat-new-arrivals product_tag-table product_tag-sock first instock shipping-taxable purchasable product-type-simple  ">
                  <div class="product-inner tooltip-left">
                     <div class="product-thumb">
                        <a class="thumb-link"  href="{{url('/product/'.$product['seo_url']) }}" tabindex="0"> @if(!empty($product['product_image'])) <img class="img-responsive"   src="{{ asset('images/ProductImages/medium/'.$product['product_image']['image'])}}" alt="Black Shirt" width="270" height="350"> @else <img  class="img-responsive" src="{{asset('images/no-image-found.jpg')}}" class="img-fluid" alt="no-image-found.jpg" title="no-image-found.jpg" width="270" height="778" style="height: 350px" /> @endif </a>
                        <div class="flash"> <span class="onnew"><span class="text">New</span></span> </div>
                     </div>
                     <div class="product-info equal-elem">
                        <h3 class="product-name product_title"> <a href="{{url('/product/'.$product['seo_url']) }}" tabindex="0">{{$product['product_name']}}</a> </h3>
                     </div>
                  </div>
               </div>
               @endforeach 
            </div>
         </div>
      </div>
   </div>
   <div class="section-014">
      <div class="container">
         <div class="row">
            <div class="col-md-6 col-lg-3">
               <div class="rage-iconbox style-02">
                  <div class="iconbox-inner">
                     <div class="icon"> <span class="flaticon-rocket-ship"></span> </div>
                     <div class="content">
                        <h4 class="title">Fast Delivery</h4>
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-md-6 col-lg-3">
               <div class="rage-iconbox style-02">
                  <div class="iconbox-inner">
                     <div class="icon"> <span class="flaticon-padlock"></span> </div>
                     <div class="content">
                        <h4 class="title">Safe shopping</h4>
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-md-6 col-lg-3">
               <div class="rage-iconbox style-02">
                  <div class="iconbox-inner">
                     <div class="icon"> <span class="flaticon-recycle"></span> </div>
                     <div class="content">
                        <h4 class="title">Easy returns</h4>
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-md-6 col-lg-3">
               <div class="rage-iconbox style-02">
                  <div class="iconbox-inner">
                     <div class="icon"> <span class="flaticon-support"></span> </div>
                     <div class="content">
                        <h4 class="title">COD Available</h4>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <div class="section-008">
      <div class="rage-instagram style-01">
         <div class="instagram-owl owl-slick"
            data-slick="{&quot;arrows&quot;:false,&quot;slidesMargin&quot;:15,&quot;dots&quot;:false,&quot;infinite&quot;:false,&quot;speed&quot;:300,&quot;slidesToShow&quot;:5,&quot;rows&quot;:1}"
            data-responsive="[{&quot;breakpoint&quot;:480,&quot;settings&quot;:{&quot;slidesToShow&quot;:2,&quot;slidesMargin&quot;:&quot;10&quot;}},{&quot;breakpoint&quot;:768,&quot;settings&quot;:{&quot;slidesToShow&quot;:3,&quot;slidesMargin&quot;:&quot;10&quot;}},{&quot;breakpoint&quot;:992,&quot;settings&quot;:{&quot;slidesToShow&quot;:4,&quot;slidesMargin&quot;:&quot;15&quot;}},{&quot;breakpoint&quot;:1200,&quot;settings&quot;:{&quot;slidesToShow&quot;:4,&quot;slidesMargin&quot;:&quot;15&quot;}},{&quot;breakpoint&quot;:1500,&quot;settings&quot;:{&quot;slidesToShow&quot;:5,&quot;slidesMargin&quot;:&quot;15&quot;}}]">
            <div class="rows-space-0"> <a target="_blank" href="#" class="item"
               tabindex="0"> <img class="img-responsive lazy" src="{{ asset('assets/images/insta1.jpg') }}" alt="Home 01"> <span class="instagram-info"> <span class="social-wrap"> <span class="social-info">1 <i class="flaticon-chat"></i> </span> <span class="social-info">0 <i class="flaticon-heart-shape-outline"></i> </span> </span> </span> </a> </div>
            <div class="rows-space-0"> <a target="_blank" href="#" class="item" tabindex="0"> <img class="img-responsive lazy" src="{{ asset('assets/images/insta2.jpg') }}" alt="Home 01"> <span class="instagram-info"> <span class="social-wrap"> <span class="social-info">0 <i class="flaticon-chat"></i> </span> <span class="social-info">0 <i class="flaticon-heart-shape-outline"></i> </span> </span> </span> </a> </div>
            <div class="rows-space-0"> <a target="_blank" href="#" class="item"
               tabindex="0"> <img class="img-responsive lazy" src="{{ asset('assets/images/insta3.jpg') }}" alt="Home 01"> <span class="instagram-info"> <span class="social-wrap"> <span class="social-info">0 <i class="flaticon-chat"></i> </span> <span class="social-info">0 <i class="flaticon-heart-shape-outline"></i> </span> </span> </span> </a> </div>
            <div class="rows-space-0"> <a target="_blank" href="#" class="item" tabindex="0"> <img class="img-responsive lazy" src="{{ asset('assets/images/insta4.jpg') }}" alt="Home 01"> <span class="instagram-info"> <span class="social-wrap"> <span class="social-info">0 <i class="flaticon-chat"></i> </span> <span class="social-info">0 <i class="flaticon-heart-shape-outline"></i> </span> </span> </span> </a> </div>
            <div class="rows-space-0"> <a target="_blank" href="#" class="item" tabindex="0"> <img class="img-responsive lazy" src="{{ asset('assets/images/insta5.jpg') }}" alt="Home 01"> <span class="instagram-info"> <span class="social-wrap"> <span class="social-info">0 <i class="flaticon-chat"></i> </span> <span class="social-info">0 <i class="flaticon-heart-shape-outline"></i> </span> </span> </span> </a> </div>
            <div class="rows-space-0"> <a target="_blank" href="#" class="item"
               tabindex="-1"> <img class="img-responsive lazy" src="{{ asset('assets/images/insta6.jpg') }}" alt="Home 01"> <span class="instagram-info"> <span class="social-wrap"> <span class="social-info">0 <i class="flaticon-chat"></i> </span> <span class="social-info">0 <i class="flaticon-heart-shape-outline"></i> </span> </span> </span> </a> </div>
            <div class="rows-space-0"> <a target="_blank" href="#" class="item"
               tabindex="-1"> <img class="img-responsive lazy" src="{{ asset('assets/images/insta7.jpg') }}" alt="Home 01"> <span class="instagram-info"> <span class="social-wrap"> <span class="social-info">0 <i class="flaticon-chat"></i> </span> <span class="social-info">0 <i class="flaticon-heart-shape-outline"></i> </span> </span> </span> </a> </div>
            <div class="rows-space-0"> <a target="_blank" href="#" class="item"
               tabindex="-1"> <img class="img-responsive lazy" src="{{ asset('assets/images/insta8.jpg') }}" alt="Home 01"> <span class="instagram-info"> <span class="social-wrap"> <span class="social-info">0 <i class="flaticon-chat"></i> </span> <span class="social-info">0 <i class="flaticon-heart-shape-outline"></i> </span> </span> </span> </a> </div>
         </div>
      </div>
   </div>
   <style>
      .rage-content{
      text-align: justify;
      text-justify: inter-word;
      }
   </style>
   <div class="section-001">
      <div class="container">
         <div class="row">
            <p class="rage-content">She doesn’t follow the crowd. Her style makes heads turn. She dances to your own rhythm. She doesn’t go to the party, she is the party. She is an artist. She is a boss. She is whatever she wants to be. She is the woman who wears Rage.</p>
            <p class="rage-content">Welcome to Rage! Rage is a contemporary Indian clothing brand that came into being in the early 2000s. The brand’s unique knitwear and apparel range which fuses ethnic designs with modern silhouettes, has indeed become the rage among style-conscious modern women who will compromise neither with comfort nor with elegance. </p>
            <p class="rage-content">Rage offers <a href="{{ url('cardigans') }}"><b>cardigans</b></a>,<a href="{{ url('tops') }}"><b> knitted tops</b></a>,<a href="javascript:;"><b> woven blouses</b></a>, <a href="javascript:;"><b> dresses</b></a>, <a href="{{ url('tops') }}"><b> tunics</b></a>, <a href="javascript:;"><b>jumpers</b></a>, <a href="{{ url('ponchu') }}"><b>capes</b></a> and <a href="{{ url('ponchu') }}"><b>ponchos for women </b></a> that have been made with the finest quality natural yarn and fabrics. Rage’s pieces are designed to give a comfortably snug fit, and they can be paired with work wear, casual wear or even party wear. From solid colours to neutral hues with minimalistic patterns to melange of bright shades and patterns, Rage’s pieces appeal to different aesthetics. And that is why, different consumers with varying tastes will definitely find something that they love. </p>
            <p class="rage-content"></p>
            <p class="rage-content"></p>
            <p class="rage-content"></p>
         </div>
      </div>
   </div>
</div>
@stop
@section('javascript')
@parent 
<script type="text/javascript" src="{{ asset('js/ajax_jquery.min.js')}}"></script> 
<script>
   $(document).ready(function(){
       $(document).on('change','[name=action]',function(){
           var value = $(this).val();
           if(value=="shipping"){
               $('#showShipping').show();
           }else{
               $('#showShipping').hide();
               /*$('#showShipping').find('input:text').val('');  
               $('#showShipping').find('textarea').val('');  */
           }
       });
   
      
   
   })
   
</script> 
@stop