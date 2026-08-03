<?php 
 use App\Category;
 $categories = Category::getcategories();
 $PageLink = Request::url(); 
?>


<div class="marquee">
  <div class="marquee-content">
    <p>⚡ Fast & Reliable Delivery</p>
    <p>🔐 100% Safe Checkout</p>
    <p>💕 Loved by Thousands of Customers</p>
    <p>⚡ Fast & Reliable Delivery</p>
    <p>🔐 100% Safe Checkout</p>
    <p>💕 Loved by Thousands of Customers</p>
  </div>
</div>
<!-- footer section start -->
<footer>
    <!-- <div class="container shippment"><img src="{{ asset('images/shippment-banner.png') }}" class="img-fluid"></div> -->
    <div class="container-fluid footer-bg">
        <div class="container">
            <div class="row">
                <div class="col-md-3 col-6">
                    <h4>Company</h4>
                    <ul>
                        <li><a href="{{ url('/about-us') }}">About Us</a></li>
                        <li><a href="{{ url('/lookbook') }}">Brand Ambassadors</a></li>
                        <li><a href="{{ url('/new-arrivals') }}">New Arrivals</a></li>
                        <li><a href="{{ url('/feedback') }}">Feedback</a></li>
                        <li><a href="{{ url('/store-locator') }}">Store Locator</a></li>
                        <li><a href="{{ url('/contact-us') }}">Contact</a></li>
                    </ul>
                </div>
                <div class="col-md-3 col-6">
                    <h4>Products</h4>
                    <ul>
					    <li><a href="{{ url('shop-all') }}">Shop All</a></li>
					    @foreach($categories as $category)
                        @if(!empty($category['subcategories']))
						@foreach($category['subcategories'] as $subcategory)
					     <li><a href="{{url('/'.$subcategory['seo_unique'])}}">{{ $subcategory['name'] }}</a></li>
						@endforeach
						@endif
						@endforeach
                    </ul>
                </div>
                <div class="col-md-3 col-6">
                    <h4>Policies</h4>
                    <ul>
                        <li><a href="{{ url('/franchise-enquiry') }}">Franchise Enquiry</a></li>
                        <li><a href="{{ url('/privacy-policy') }}">Privacy Policy</a></li>
                       <!-- <li><a href="{{ url('/cancellation-policy') }}">Cancellation Policy</a></li> -->
                      <?php /*  <li><a href="{{ url('/return-and-refund-policy') }}">Return & Refund policy</a></li> */ ?>
                       <li><a href="{{ url('/return-policy') }}">Return & Exchange Policy</a></li>
                       <li><a href="{{ url('/cancellation-and-refund-policy') }}">Cancellation & Refund Policy</a></li>
						<li><a href="{{ url('/shipping-policy') }}">Shipping Policy</a></li>
                        <li><a href="{{ url('/terms-and-conditions') }}">Terms of Use</a></li>
                        <!-- <li><a href="{{ url('/sitemap') }}">Sitemap</a></li> -->
                    </ul>
                </div>
                <div class="col-md-3 col-6">
                  <h4>Contact Us</h4>
                  <ul>
                      <li>Have a question or doubt? Need some personalized advice? Our team is at your service.</li>
                      <li>Rage Knit</li>
                      <li><i class="fas fa-at"></i> <a href="mailto:info@rageonline.co.in">info@rageonline.co.in</a></li>
                      <li><i class="fas fa-at"></i> <a href="mailto:rageindiaonline@gmail.com">rageindiaonline@gmail.com</a></li>
                      <li><i class="fas fa-phone-alt"></i> <a href="tel:+91 79861 58756">+91 79861 58756</a></li>
                      <li><i class="far fa-clock"></i> 10:00 AM - 8:00 PM</li>
                  </ul>
                  
                    <ul class="social-icons-footer">
                        <li><a rel="nofollow" href="https://www.facebook.com/rageindiaonline"><i class="fab fa-facebook-f"></i></a></li>
                        <li><a rel="nofollow" href="https://www.instagram.com/rageindiaonline/"><i class="fab fa-instagram"></i></a></li>
                    </ul>
              </div>

            </div>
        </div>
    </div>
    <div class="container-fluid copyright">© Copyright {{ date('Y') }} RAGE. All Rights Reserved | Site Credit: <a rel="nofollow" href="https://www.royalways.com/">Royalways</a></div>
</footer>    

<div class="whatsapp-icon">
  <a href="https://wa.me/+917986158756" rel="nofollow" target="_blank">
    <img src="{{ asset('images/whatsapp.png') }}" alt="img" title="img" class="img-fluid">
  </a>
</div>




<!-- Product Offcanvas (Right Side) -->
<div class="offcanvas offcanvas-end product-canvas" tabindex="-1" id="productOffcanvas">
     <?php /* @include('front.listings.product-quick-view') */ ?>
	 
</div>



<!-- footer section end -->
   
  
	
<!-- Notify model start -->
<div class="modal fade" id="notifyme" role="dialog">
   <div class="modal-dialog" id="notifyme_content">
   </div>
</div>
<!-- Notify model end --> 


