	<?php //echo $catseo; exit; ?>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="Content-Type" content="html/text, charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="csrf-token" content="{{ csrf_token() }}" />
	<link rel="shortcut icon" type="image/x-icon" href="{{ asset('images/favicon.png') }}"/>
	@if(isset($productname))
	<title>Buy {{ $productname }} Online in India</title>
	<meta name="description" content="Shop {{ $productname }} online in India at best prices.Free Shipping, Safe Shopping, Easy Returns & COD Available. Rage is one of the leading online store for women clothing in India.">
	@if(isset($metakeywords) && !empty($metakeywords))
	<meta name="keywords" content="{{$metakeywords}}">
	@endif
	@endif
	@if(isset($catseo))
	@if($catseo=='home')
	<title>{{ $title }}</title>
	<meta name="description" content="{{ $metadescription }}">
	<meta name="keywords" content="{{ $metakeywords }}">
	@elseif($catseo=='tops' || $catseo=='women-tops')
	<title>Buy Knitted Tops - Designer Knitted Tops & Tunics Online in India</title>
	<meta name="description" content="Discover wide range of women tops online in India. Rage offer online shopping for knitted tops & designer tunics. Shop now at best prices.">
	<meta name="keywords" content="Knitted Tops, Designer Knitted Tops, Tunics Online">
	@elseif($catseo=='cardigans' || $catseo=='women-cardigans')
	<title>Women Cardigans Online - Woolen Sweaters, Winter Cardigans & Best Sweaters for Ladies</title>
	<meta name="description" content="Rage, one of the leading brand for women clothing in India offer online shopping for ladies cardigans, woolen sweaters & winter cardigans. Shop now at best prices.">
	<meta name="keywords" content="women cardigans online, woolen sweaters, winter cardigans, sweaters for ladies">    
	@elseif($catseo=='coats' || $catseo=='women-coats')
	<title>Winter Coats for Ladies - Overcoat, Long Overcoats & Women Winter Coats Online India</title>
	<meta name="description" content="Discover wide range of women winter coats online in India. Rage offer online shopping for ladies coats, long overcoats & winter coats at best prices.">
	<meta name="keywords" content="women coats, winter coats online, long overcoats">   
	@elseif($catseo=='kurtis' || $catseo=='women-kurtis')
	<title>Women Winter Kurtis Online - Buy Woollen Kurtis, Designer Kurtis & Long Kurtis in India</title>
	<meta name="description" content="Discover wide range of women winter kurtis online in India. Rage offer online shopping for woolen kurtis, designer kurtis & party wear winter kurtis at best prices.">
	<meta name="keywords" content="women winter kurtis online, woollen kurtis, designer kurtis, long kurtis in india">    
	@elseif($catseo=='ponchu' || $catseo=='women-ponchos')
	<title>Women Ponchos Online - Buy Branded and Designer Poncho & Capes in India</title>
	<meta name="description" content="Discover wide range of women poncho & capes online in India. Rage offer online shopping for designer ponchos & capes at best prices">
	<meta name="keywords" content="women capes, women poncho online, buy branded poncho, designer poncho in india">    
	@elseif($catseo=='new-arrivals')
	<title>Women Branded Clothing - Buy Kurtis, Tunics, Dresses, Tops, Kaftan, Poncho, Jackets, Coats, Cardigans & Sweaters Online in India</title>
	<meta name="description" content="Discover wide range of women branded clothing in India. Rage offer online shopping for kurtis, tunics, dresses, tops, kaftan, poncho, jackets, coats, cardigans & sweaters at best prices.">
	<meta name="keywords" content="kurtis, tunics, dresses, tops, kaftan, poncho, jackets, coats, cardigans, sweaters">  
	@elseif($catseo=='lookbook')
	<title>Rage - Lookbook, Branded Women Clothing in India</title>
	<meta name="description" content="View Lookbook of Rage. Our brand ambassadors over the years have had celebrities like Katrina Kaif, Priyanka Chopra, Diya Mirza, Sameera Reddy, Riya Sen, Malika Sherawat, Jacqueline Fernandez and many others.">
	<meta name="keywords" content="lookbook, rage brand ambassadors, rage clothing">    
	@elseif($catseo=='store-locator')
	<title>Stores - Rage, Women Clothing</title>
	<meta name="description" content="Looking for stores Rage in your city or state? Then you can view at here.">
	<meta name="keywords" content="stores, rage, women clothing">  
	@elseif($catseo=='contact-us')
	<title>Contact - Rage</title>
	<meta name="description" content="Rage is one of the leading women clothing brand in India. If you have any query related to our products then you can contact us at any time.">
	<meta name="keywords" content="contact, rage, women clothing"> 
	@elseif($catseo=='feedback')
	<title>Feedback - Rage</title>
	<meta name="description" content="Your feedback is most important for us. You can give you feedback at here.">
	<meta name="keywords" content="feedback, rage, women clothing">    
	@elseif($catseo=='franchise-enquiry')
	<title>Franchise for Women Clothing - Franchise Enquiry - Rage</title>
	<meta name="description" content="Want to open clothing store in your city and looking for branded franchise enquiry? Then you are at right place.">
	<meta name="keywords" content="franchise enquiry, rage, women clothing">       
	@elseif($catseo=='about-us')
	<title>About - Rage</title>
	<meta name="description" content="With the huge manifesto of 25 EBO and over 500 MBOs and departmental stores throughout India accounting for its parent company Rage Knit, our merchandise includes cardigans, knitted tops, woven blouses, dresses, tunics, jumpers, capes, ponchos etc for women.">
	<meta name="keywords" content="about us, rage, women clothing">    
	@elseif($catseo=='privacy-policy')
	<title>Privacy Policy - Rage</title>
	<meta name="description" content="We are committed to protecting your personal privacy. Rage will not give out your telephone number or E-mail address, except where needed to deliver a product or service you ordered.">
	@elseif($catseo=='terms-and-conditions')
	<title>Terms & Conditions - Rage</title>
	<meta name="description" content="Please read terms and conditions of Rage in details.">
	@elseif($catseo=='sitemap')
	<title>Sitemap - Rage</title>
	<meta name="description" content="Rage is one of the leading clothing brand for women clothing in India offer online shopping for kurtis, tops, cardigans, jackets, sweaters, coats & ponchos."> 
	@elseif($catseo=='login')
	 <title>Login/Register - Rage</title> 
	@elseif($catseo=='addtocart')
	<title>Shopping Cart - Rage</title>
	<meta name="description" content="Shopping Cart - Rage Online. Enjoy online shopping with us."/>                 
	@elseif($catseo=='order-checkout') 
	<title>Order Checkout - Rage</title>
	@elseif($catseo=='dashboard')
	<title>Login/Register - Rage</title>
	@elseif($catseo=='address')
	<title>Your Address - Rage</title>
	@elseif($catseo=='orders')
	<title>Your Orders - Rage</title>
	@elseif($catseo=='wishlist')
	<title>Your Wishlist- Rage</title>
	@elseif($catseo=='setting')
	<title>Your Account Settings - Rage</title>
	@elseif($catseo=='return-policy')
	<title>Rage Return & Exchange Policy</title>
    <meta name="description" content="View Rage's easy Return and Exchange Policy. Initiate a return within 24-48 hours of delivery. Get bank refunds for prepaid orders or a coupon for COD orders.">
	@elseif($catseo=='cancellation-and-refund-policy')
	<title>Rage Order Cancellation & Refund Policy</title>
    <meta name="description" content="Review Rage's Cancellation Policy. Cancel your order within 24 hours for a full refund. Refunds are issued to your account or as a discount voucher (for orders ≤ ₹2000).">
	@elseif($catseo=='404')
	<title>{{ @$title }}</title>
	<meta name="description" content="Page Not Found">                 
	@elseif($catseo=='tops-and-tunics')
	<title>Buy Women Tops - Designer Summer Tops & Tunics Online in India</title>
	<meta name="description" content="Discover wide range of women summer tops online in India. Rage offer online shopping for summer tops & designer tunics for ladies. Shop now at best prices.">
	<meta name="keywords" content="women tops, designer summer tops, tunics online">             
	@elseif($catseo=='dresses')
	<title>Buy Women Summer Dresses - Designer Dresses & Western Dresses Online in India</title>
	<meta name="description" content="Discover wide range of women summer dresses online in India. Rage offer online shopping for summer dresses, designer dresses & western dresses. Shop now at best prices.">
	<meta name="keywords" content="women dresses, designer dresses online, summer dresses">          
	@elseif($catseo=='kaftan')
	<title>Buy Women Kaftans Online - Designer & Branded Kaftans Online in India</title>
	<meta name="description" content="Discover wide range of womens kaftan dresses online in India. Rage offer online shopping for ladies kaftans at best prices. Shop now.">
	<meta name="keywords" content="women kaftan, designer kaftans online">   
	@elseif($catseo=='co-ord')
	<title>Women Co Ord Dresses, Woollen Co Ord Sets for Ladies Online</title>
	<meta name="description" content="Rage offer online shopping for co-ord sets. Discover wide range of co ord dresses and woollen co ord sets at best prices."/>
	<meta name="keywords" content="co ord sets, woolen co ord sets"/>
	@elseif($catseo=='women-dresses-tunics')
	<title>Women Winter Dresses - Buy Woollen Dresses & Tunics Online in India</title>
	<meta name="description" content="Discover wide range of women winter dresses online in India. Rage offer online shopping for woollen dresses & tunics."/>
	<meta name="keywords" content="winter dresses, woolen tunics"/>
	@elseif($catseo=='women-jumpers')
	<title>Women Jumpers Online - Buy Jumper for Ladies in India</title>
	<meta name="description" content="Discover wide range of women jumpers online in India. Rage offer online shopping for jumpers for ladies at best prices. Shop now."/>
	<meta name="keywords" content="winter dresses, woolen tunics"/>
	@elseif($catseo=='poncho-capes-kaftans')
	<title>Women Ponchos, Capes & Kaftans Online - Buy Branded and Designer Poncho & Capes in India</title>
	<meta name="description" content="Discover wide range of women ponchos, capes & kaftans online in India. Rage offer online shopping for designer and stylist ponchos, capes & kaftans. Shop now."/>
	<meta name="keywords" content="ladies kaftans, women capes, women poncho online, buy branded poncho, designer poncho in india"/>
	@elseif($catseo=='cancellation-policy')
	<title>Cancellation Policy - Rage</title>
    <meta name="description" content="You can cancel order only before we have processed your order. You can do so by contacting to our customer care at +91 7986158756. If the order is already processed for shipping then we won’t be able to cancel it."/>
	@elseif($catseo=='return-and-refund-policy')
	<title>Return & Refund Policy - Rage</title>
    <meta name="description" content="You may request for a Return/Exchange of your order within 24 hours of delivery of the order from the order page in your account."/>
	@elseif($catseo=='shipping-policy')
	<title>Shipping Policy - Rage</title>
    <meta name="description" content="We dispatch your order through a reputed logistics partner (Depending upon your location).Normally, we ship your order within 24 to 48 hours of receiving the order and it takes 5 to 7 business days to reach your doorstep."/>
    @elseif($catseo=='winter-collection')
    <title>Winter Fashion - Shop Winter Kurtis, Cardigans, Tops, Sweaters, Jackets, Coats & Dresses Online in India - Winter Wardrobe Essentials</title>
    <meta name="description" content="Discover wide range of winter collection for women. Buy winter kurtis, cardigans, tops, sweaters, jackets, coats and dresses at best prices. Stay cozy and stylish this winter with our curated collection of women's winter wear. From cozy knits to trendy outerwear, find the perfect piece to elevate your wardrobe."/>
    <meta name="keywords" content="winter collection, winter tops, winter kurtis, winter jackets, winter coats "/>	
	@elseif($catseo=='kurti-sets') 
	<title>Winter Kurtis - Printed Kurti, Trendy Kurtis for Winter, Kurtis for Every Occasion</title>
	<meta name="description" content="Discover wide range of winter kurtis for women. Stay warm and stylish this winter with our collection of cozy woolen kurtis and trendy printed kurtis. Perfect for any occasion."/>
	<meta name="keywords" content="woolen kurtis, winter kurtis, kurti for women, printed kurtis"/>
	@elseif($catseo=='rage-luxe') 
	<title>Stylish Winter Co-Ord Sets - Cozy, Chic and Luxury Co-Ord for Womens</title>
	<meta name="description" content="Discover wide range of winter co-ord sets for women. Elevate your winter wardrobe with our trendy co-ord sets. From cozy knits to stylish separates, find the perfect combination for any occasion."/>
	<meta name="keywords" content="co ord sets, women co ord, winter co ords"/>
	@endif
	@endif   


	@if(isset($page) && $page == 'product-detail')
	<?php  $img = '';
	if(isset($productdetails['productimages'][0]['image'])){
	  $img = $productdetails['productimages'][0]['image'];
	}
	?>
	
	<?php /*
	<meta property="og:title" content="{{ @$productdetails['product_name'] }}" />
	
	<meta property="og:url" content="{{ Request::url() }}" />
	<meta property="og:image" content="{{asset('images/ProductImages/medium/'.$img)}}" />
	<meta property="og:description" content="{{ @$productdetails['product_name'] }}" /> 
	<meta property="og:site_name" content="{{ @$productdetails['product_name'] }}" />
	*/ ?>
	@else
	<meta property="og:site_name" content="Rage"/>
	@endif