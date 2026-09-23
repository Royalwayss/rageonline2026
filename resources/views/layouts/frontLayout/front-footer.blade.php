<?php 
 use App\Category;
 $categories = Category::getcategories();
 $PageLink = Request::url(); 
?>

<footer class="site-footer">
    <div class="container-fluid">

        <div class="footer-main">
            <div class="row">


                <div class="col-lg-4 col-md-6 col-6">
                    <div class="footer-links">
                        <h4>Company</h4>
                        <ul>
                            <li><a href="{{ url('about-us') }}">About Us</a></li>
                            <li><a href="{{ url('lookbook') }}">Brand Ambassadors</a></li>
                            <li><a href="{{ url('new-arrivals') }}">New Arrivals</a></li>
                            <li><a href="{{ url('store-locator') }}">Store Locator</a></li>
                            <li><a href="{{ url('contact-us') }}">Contact</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-6">
                    <div class="footer-links">
                        <h4>Policies</h4>

                        <ul>
                            <li><a href="{{ url('franchise-enquiry') }}">Franchise Enquiry</a></li>
                            <li><a href="{{ url('privacy-policy') }}">Privacy Policy</a></li>
                            <li><a href="{{ url('return-policy') }}">Return & Exchange Policy</a></li>
                            <li><a href="{{ url('cancellation-and-refund-policy') }}">Cancellation & Refund Policy</a></li>
                            <li><a href="{{ url('shipping-policy') }}">Shipping Policy</a></li>
                            <li><a href="{{ url('terms-and-conditions') }}">Terms of Use</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4 col-md-12 col-12">
                    <div class="footer-links">
                        <h4>Contact Us</h4>
                        <div class="footer-newsletter">
                            <p class="footer-about">
                                Have a question or doubt? Need some personalized advice?
                                Our team is at your service.
                            </p>

                            <p class="footer-contact-name">
                                Rage Knit
                            </p>

                            <div class="footer-contact-links">

                                <a href="mailto:info@rageonline.co.in">
                                    <i class="fa-solid fa-at"></i>
                                    info@rageonline.co.in
                                </a>

                                <a href="mailto:rageindiaonline@gmail.com">
                                    <i class="fa-solid fa-at"></i>
                                    rageindiaonline@gmail.com
                                </a>

                                <a href="tel:+917986158756">
                                    <i class="fa-solid fa-phone"></i>
                                    +91 79861 58756
                                </a>

                                <div class="footer-time">
                                    <i class="fa-regular fa-clock"></i>
                                    10:00 AM - 8:00 PM
                                </div>

                            </div>

                            <div class="footer-social">

                                <a rel="nofollow" href="https://www.facebook.com/rageindiaonline" target="_blank" rel="noopener noreferrer"
                                    aria-label="Facebook">
                                    <i class="fa-brands fa-facebook-f"></i>
                                </a>

                                <a rel="nofollow" href="https://www.instagram.com/rageindiaonline/" target="_blank" rel="noopener noreferrer"
                                    aria-label="Instagram">
                                    <i class="fa-brands fa-instagram"></i>
                                </a>

                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>


        <div class="footer-bottom">
            <div class="footer-copy">
                © Copyright {{ date('Y') }} RAGE. All Rights Reserved | Site Credit: <a href="https://www.royalways.com/" target="_blank">Royalways</a>
            </div>
        </div>

    </div>
</footer>
<a href="https://wa.me/917986158756" 
   class="whatsapp-fixed" 
   target="_blank" 
   aria-label="Chat with us on WhatsApp">
    <i class="fa-brands fa-whatsapp"></i>
</a>
