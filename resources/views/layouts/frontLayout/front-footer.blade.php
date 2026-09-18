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
                            <li><a href="about.php">About Us</a></li>
                            <li><a href="brand-ambassadors.php">Brand Ambassadors</a></li>
                            <li><a href="listing.php">New Arrivals</a></li>
                            <li><a href="store-locator.php">Store Locator</a></li>
                            <li><a href="contact-us.php">Contact</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-6">
                    <div class="footer-links">
                        <h4>Policies</h4>

                        <ul>
                            <li><a href="javascript::void()">Franchise Enquiry</a></li>
                            <li><a href="javascript::void()">Privacy Policy</a></li>
                            <li><a href="javascript::void()">Return & Exchange Policy</a></li>
                            <li><a href="javascript::void()">Cancellation & Refund Policy</a></li>
                            <li><a href="javascript::void()">Shipping Policy</a></li>
                            <li><a href="javascript::void()">Terms of Use</a></li>
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

                                <a href="https://www.facebook.com/" target="_blank" rel="noopener noreferrer"
                                    aria-label="Facebook">
                                    <i class="fa-brands fa-facebook-f"></i>
                                </a>

                                <a href="https://www.instagram.com/" target="_blank" rel="noopener noreferrer"
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
