<?php
 $js_file_version = "?v=3.3";
if(isset($page)){ $page = $page; } else { $page = '';} 

 ?>
@yield('javascript')
<!-- JS here -->
 <script src="{{ asset('js/bootstrap.bundle.min.js') }}" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script type="text/javascript" src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script> 
    <script type="text/javascript" src="https://unpkg.com/aos@2.3.0/dist/aos.js"></script>
    <script type="text/javascript" src="{{ asset('js/jquery.scrollbar.min.js')}}"></script>
    <script type="text/javascript" src="{{ asset('js/jquery.scrollUp.min.js')}}"></script>
    <script type="text/javascript" src="{{ asset('js/jquery-ui.js')}}"></script>
    <script type="text/javascript" src="{{ asset('js/jquery-ui.min.js')}}"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Glide.js/3.2.0/glide.min.js"></script>
    <script type="text/javascript" src="https://unpkg.com/swiper@6.8.4/swiper-bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui/dist/fancybox.umd.js"></script>
    <script src="{{ asset('js/script.js?v=2.5') }}"></script>
	
	
	
	<script type="text/javascript">
        AOS.init({
          duration: 1200,
        })

        let glide = new Glide(".glide", {
          type: "carousel",
          perView: 1,
          startAt: 0,
          focusAt: "center",
          autoplay: 5000 //Optional (5 seg)
        }).mount();
    </script>	
	
	