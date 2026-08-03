<?php use App\Cart; use App\Category;
   $totalItems = Cart::totalItems();
   
   $categories = Category::getcategories(); 
   
   $cartitems = Cart::cartitems();
   
   $cart_count = count($cartitems);
   
   $subtotal = 0; 
   
   ?>
   <style>

   </style>
<!-- header section start -->

<nav data-aos="fade-up">
  <div class="navbar container-fluid">
    <div class="row">
        <div class="col-md-4 col-2 nav1">
            <!-- <i class='bx bx-menu'></i> -->
            <svg class="bx-menu"  height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg" id="fi_15610747"><path clip-rule="evenodd" d="m1.3999 5.9999c0-.33137.26863-.6.6-.6h20c.3314 0 .6.26863.6.6s-.2686.6-.6.6h-20c-.33137 0-.6-.26863-.6-.6zm0 12c0-.3314.26863-.6.6-.6h20c.3314 0 .6.2686.6.6s-.2686.6-.6.6h-20c-.33137 0-.6-.2686-.6-.6zm.6-6.6c-.33137 0-.6.2686-.6.6s.26863.6.6.6h12c.3314 0 .6-.2686.6-.6s-.2686-.6-.6-.6z" ></path></svg>
            <div class="nav-links header-right">
                <div class="sidebar-logo">
                    <span class="logo-name"><img src="{{ asset('images/logo.png') }}?v=1.0" class="img-fluid" alt="Rage - Shop Kurtis, Tops, Dresses, Jumpers, Co-Ord, Coats, Tunics & Ponchos Online in India" title="Rage - Shop Kurtis, Tops, Dresses, Jumpers, Co-Ord, Coats, Tunics & Ponchos Online in India"></span>
                    <div class="cross-icon"><i class='bx bx-x' ></i></div>
                </div>
                <ul class="links header-left">
                    <!-- <li> 
                    <a href="{{ url('/') }}"><span class="logo-name"><img src="{{ asset('images/logo.png') }}"></span></a>
                </li> -->

                    @foreach($categories as $category)

                    <li>
                    <a href="{{url('/'.$category['seo_unique'])}}">{{ $category['name'] }}</a>
                    @if(!empty($category['subcategories']))
                    <i class='bx bxs-chevron-down htmlcss-arrow arrow'></i>
                    
                    <ul class="htmlCss-sub-menu sub-menu">
                        @foreach($category['subcategories'] as $subcategory)
                            <li > <a  href="{{url('/'.$subcategory['seo_unique'])}}">{{ $subcategory['name'] }}</a> </li>
                        @endforeach
                    </ul>
                    @endif
                    </li>
                    @endforeach
                    <li><a href="{{ url('about-us') }}">About Us</a></li>
                     <li><a href="{{ url('lookbook') }}">Brand Ambassadors</a></li> 
                    <li><a href="{{ url('new-arrivals') }}">New Arrivals</a></li>
                    <li><a href="{{ url('store-locator') }}">Store Locator</a></li>
                    <!--<li><a href="#">Rage Luxe</a></li>-->
                    <li><a href="{{ url('contact-us') }}">Contact Us</a></li>

                </ul>
            </div>
        </div>

        <div class="col-md-4 col-4 nav2">
            <div class="logo">
            <a href="{{ url('/') }}"><span class="logo-name"><img src="{{ asset('images/logo.png') }}" class="img-fluid" alt="Rage - Shop Kurtis, Tops, Dresses, Jumpers, Co-Ord, Coats, Tunics & Ponchos Online in India" title="Rage - Shop Kurtis, Tops, Dresses, Jumpers, Co-Ord, Coats, Tunics & Ponchos Online in India"></span></a>
            </div>
        </div>
  
        <div class="col-md-4 col-6 nav3">
            <div class="search-box">

            <ul class="links">
            <li><a href="javascript:;" onclick="openSearch()"><svg enable-background="new 0 0 40 40" height="25" viewBox="0 0 40 40" width="25" xmlns="http://www.w3.org/2000/svg" id="fi_2811806"><g id="_x32_-Magnifying_Glass"><path d="m40.8994141 39.4853516-7.8127441-7.8127441c2.3978882-2.734375 3.7209473-6.1942749 3.7209473-9.8649902 0-4.0068359-1.5605469-7.7734375-4.3935547-10.6064453s-6.5996094-4.3935547-10.6064453-4.3935547-7.7734375 1.5605469-10.6064453 4.3935547-4.3935547 6.5996094-4.3935547 10.6064453 1.5605469 7.7734375 4.3935547 10.6064453 6.5996094 4.3935547 10.6064453 4.3935547c3.6707153 0 7.1306152-1.3230591 9.8649902-3.7209473l7.8127441 7.8127441c.1953125.1953125.4511719.2929688.7070313.2929688s.5117188-.0976563.7070313-.2929688c.3906249-.390625.3906249-1.0234375-.0000001-1.4140625zm-28.2841797-8.4853516c-2.4550781-2.4555664-3.8076172-5.7202148-3.8076172-9.1923828s1.3525391-6.7368164 3.8076172-9.1923828c2.4555664-2.4550781 5.7202148-3.8076172 9.1923828-3.8076172s6.7368164 1.3525391 9.1923828 3.8076172c2.4550781 2.4555664 3.8076172 5.7202148 3.8076172 9.1923828s-1.3525391 6.7368164-3.8076172 9.1923828c-2.4555664 2.4550781-5.7202148 3.8076172-9.1923828 3.8076172s-6.7368164-1.3525391-9.1923828-3.8076172z"></path></g></svg></a></li>
            
            
                <li class="dashboard-li">
                <a href="javascript:;"><svg id="fi_15678795" enable-background="new 0 0 100 100" width="22" height="22" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg" xmlns:serif="http://www.serif.com/"><g><path d="m11.4 93.3c-.1 0-.1 0-.2 0-1.3-.1-2.2-1.2-2.1-2.4 1.3-19.1 19.3-34 40.9-34s39.6 14.9 40.9 33.9c.1 1.3-.9 2.3-2.1 2.4-1.3.1-2.3-.9-2.4-2.1-1.2-16.7-17.2-29.7-36.4-29.7-19.3 0-35.3 13.1-36.4 29.8-.1 1.2-1.1 2.1-2.2 2.1z"></path><path d="m50 52.3c-12.6 0-22.8-10.2-22.8-22.8s10.2-22.8 22.8-22.8 22.8 10.2 22.8 22.8-10.2 22.8-22.8 22.8zm0-41c-10 0-18.2 8.2-18.2 18.2s8.2 18.2 18.2 18.2 18.2-8.2 18.2-18.2-8.2-18.2-18.2-18.2z"></path></g></svg></a>
                <!-- <i class='bx bxs-chevron-down htmlcss-arrow arrow'></i> -->
                <ul class="htmlCss-sub-menu sub-menu">
                @if(Auth::check())
                <li><a href="{{ url('account/dashboard') }}">Dashboard</a></li> 
                <li><a href="{{ url('account/address') }}">Address</a></li> 
                <li><a href="{{ url('account/orders') }}">Orders</a></li> 
                <li><a href="{{ url('account/wishlists') }}">Wishlists</a></li> 
                <li><a href="{{ url('account/settings') }}">Settings</a></li> 
                <li><a href="{{ url('logout') }}">Logout</a></li> 
                @else
                <li><a href="{{ url('login') }}">Login</a></li>
                <li><a href="{{ url('login') }}">Sign Up</a></li>
                @endif
                
                        </ul>
                    </li>
                    <?php /* <li><a href="javascript:void(0)"><i class="fal fa-shopping-bag"><span id="cart_count" class="totalItems">{{ $cart_count }}</span></i></a>
                                @include('front/cart/cart-popup')
                    </li> */ ?>
                    <li class="cart-style-btns">
                        <a class="minicart-btn" href="javascript:;">
                        <svg height="22" viewBox="-96 -27 859 859.3115" width="22" xmlns="http://www.w3.org/2000/svg" id="fi_1174408"><path d="m621.503906 805.6875h-585.683594c-1.175781 0-2.355468-.054688-3.519531-.140625-22.253906-2.050781-38.617187-21.675781-36.601562-43.785156l48.835937-537.070313c1.894532-20.882812 19.128906-36.632812 40.101563-36.632812h488.050781c20.9375.023437 38.167969 15.773437 40.070312 36.632812l48.828126 537.070313c.105468 1.144531.15625 2.386719.15625 3.621093.011718 22.199219-18.027344 40.289063-40.238282 40.304688zm-536.867187-590.777344c-6.984375 0-12.726563 5.246094-13.355469 12.207032l-48.832031 537.085937c-.679688 7.367187 4.785156 13.910156 12.15625 14.578125l1.214843.054688h585.667969c7.398438-.015626 13.402344-6.03125 13.402344-13.441407l-48.878906-538.261719c-.628907-6.960937-6.371094-12.207031-13.351563-12.222656zm136.609375 67.171875c-.019532-7.40625-6.066406-13.449219-13.457032-13.464843l.0625-26.851563c22.125.050781 40.183594 18.109375 40.246094 40.238281zm0 0"></path><path d="m449.5 322.324219c-22.210938 0-40.28125-18.066407-40.28125-40.28125 0-22.210938 18.066406-40.277344 40.28125-40.277344 22.210938 0 40.277344 18.066406 40.277344 40.277344 0 22.214843-18.066406 40.28125-40.277344 40.28125zm0-53.707031c-7.40625 0-13.429688 6.019531-13.429688 13.425781 0 7.414062 6.023438 13.429687 13.429688 13.429687 7.410156 0 13.425781-6.015625 13.425781-13.429687 0-7.40625-6.015625-13.425781-13.425781-13.425781zm0 0"></path><path d="m207.816406 322.324219c-22.207031 0-40.277344-18.066407-40.277344-40.28125 0-22.210938 18.066407-40.277344 40.277344-40.277344v26.851563c-7.398437 0-13.425781 6.015624-13.425781 13.425781 0 7.40625 6.027344 13.429687 13.425781 13.429687 7.402344 0 13.429688-6.023437 13.429688-13.429687h26.851562c0 22.214843-18.066406 40.28125-40.28125 40.28125zm0 0"></path><path d="m221.246094 282.082031c-.019532-7.40625-6.066406-13.449219-13.457032-13.464843l.0625-26.851563c22.125.050781 40.183594 18.109375 40.246094 40.238281zm0 0"></path><path d="m462.925781 255.191406h-26.855469v-120.839844c0-59.226562-48.183593-107.414062-107.410156-107.414062-59.226562 0-107.414062 48.1875-107.414062 107.414062v120.839844h-26.855469v-120.839844c0-74.039062 60.230469-134.2695308 134.269531-134.2695308 74.03125 0 134.265625 60.2304688 134.265625 134.2695308zm0 0"></path></svg><span id="cart_count" class="totalItems">{{ $cart_count }}</span></a>
                
                @include('front/cart/cart-popup')
                </li>
            </ul>
            </div>
        </div>
    </div>
  </div>
</nav>

<!-- header section end -->
<!-- <div class="marquee">
  <div class="marquee--inner">
    <span>FLAT 50% OFF &nbsp;&nbsp;</span>
    <span>FLAT 50% OFF &nbsp;&nbsp;</span>
    <span>FLAT 50% OFF &nbsp;&nbsp;</span>
    <span>FLAT 50% OFF &nbsp;&nbsp;</span>
  </div>
</div> -->
