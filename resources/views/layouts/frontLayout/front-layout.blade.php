<!DOCTYPE html> 
<html>
<?php 
Use App\Cart;
Use App\Category;
if(!isset($catseo)) { $catseo = ''; }
if(!isset($page)) { $page = ''; } 
?>
<head>
@if(env('WEBSITE_MODE') != 'live')
<!-- Google tag (gtag.js) -->

<script async src="https://www.googletagmanager.com/gtag/js?id=G-27XWVMZ09B"></script>

<script>

  window.dataLayer = window.dataLayer || [];

  function gtag(){dataLayer.push(arguments);}

  gtag('js', new Date());

 

  gtag('config', 'G-27XWVMZ09B');

</script>
    
   
<!-- Global site tag (gtag.js) - Google Ads: 992852956 -->

<script async src="https://www.googletagmanager.com/gtag/js?id=AW-992852956"></script>

<script>

  window.dataLayer = window.dataLayer || [];

  function gtag(){dataLayer.push(arguments);}

  gtag('js', new Date());

 

  gtag('config', 'AW-992852956');

</script>



<!-- Google tag (gtag.js) -->

<script async src="https://www.googletagmanager.com/gtag/js?id=UA-211842950-1"></script>

<script>

  window.dataLayer = window.dataLayer || [];

  function gtag(){dataLayer.push(arguments);}

  gtag('js', new Date());

 

  gtag('config', 'UA-211842950-1');

</script>

<!-- Facebook Events - Rage Start -->
<!-- Facebook Pixel Code -->
<script>
!function(f,b,e,v,n,t,s)

{if(f.fbq)return;n=f.fbq=function(){n.callMethod?

n.callMethod.apply(n,arguments):n.queue.push(arguments)};

if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';

n.queue=[];t=b.createElement(e);t.async=!0;

t.src=v;s=b.getElementsByTagName(e)[0];

s.parentNode.insertBefore(t,s)}(window, document,'script',

'https://connect.facebook.net/en_US/fbevents.js');
fbq('init', '466265581833188');
fbq('track', 'PageView');
<?php if($catseo == 'addtocart'){ ?>
fbq('track', 'AddToCart');
<?php }else if($catseo == 'checkout'){ ?>
fbq('track', 'InitiateCheckout');
fbq('track', 'AddPaymentInfo');
<?php }else if($catseo == 'search'){ ?>
fbq('track', 'Search');
<?php }else if($catseo == 'wishlist'){ ?>
fbq('track', 'AddToWishlist');
<?php }else if(isset($user_order_id) && $user_order_id !='' ){ ?>
fbq('track', 'Purchase', {value: <?php echo $total_amount; ?>, currency: 'INR'});
<?php }else if(Session::has('CompleteRegistration')){  Session::forget('CompleteRegistration');  ?>
fbq('track', 'CompleteRegistration');
<?php }else{ ?>
fbq('track', 'ViewContent');
<?php } ?>

</script>

<noscript><img height="1" width="1" style="display:none"

src="https://www.facebook.com/tr?id=466265581833188&ev=PageView&noscript=1"

/></noscript>
<!-- End Facebook Pixel Code -->
<!-- Facebook Events - Rage End -->

<!-- Meta Pixel Code -->

<script>

!function(f,b,e,v,n,t,s)

{if(f.fbq)return;n=f.fbq=function(){n.callMethod?

n.callMethod.apply(n,arguments):n.queue.push(arguments)};

if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';

n.queue=[];t=b.createElement(e);t.async=!0;

t.src=v;s=b.getElementsByTagName(e)[0];

s.parentNode.insertBefore(t,s)}(window, document,'script',

'https://connect.facebook.net/en_US/fbevents.js');

fbq('init', '466265581833188');

fbq('track', 'PageView');

</script>

<noscript><img height="1" width="1" style="display:none"

src="https://www.facebook.com/tr?id=466265581833188&ev=PageView&noscript=1"

/></noscript>

<!-- End Meta Pixel Code -->

@if($catseo  == 'home')
	<!-- Open Graph Meta Tags -->

<meta property="og:type" content="website" />

<meta property="og:title" content="Winter Dresses  Online - Buy Women Kurtis, Cardigans, Knitted Tops, Kaftans, Sweaters, Jackets, Coats, Stoles, Capes &amp; Ponchos | Rage" />

<meta property="og:description" content="Discover wide range of women cardigans, coats, jackets, knitted tops, kurtis, sweaters &amp; ponchos. Rage is one of the leading brand for women's in India offer online shopping for ladies cardigans, long coats, woolen kurtis, western dresses, designer tops, capes, tunics, stoles & stylish ponchos. Show online now!" />

<meta property="og:url" content="https://www.rageonline.co.in/" />

<meta property="og:site_name" content="Rage" />

<meta property="og:image" content="https://www.rageonline.co.in/images/banners/banner-h9zqr11-10-52.jpeg" />

<meta property="og:image:width" content="1200" />

<meta property="og:image:height" content="630" />

<meta property="og:locale" content="en_IN" />

 
<!-- Twitter Card Meta Tags -->

<meta name="twitter:card" content="summary_large_image" />

<meta name="twitter:title" content="Winter Dresses  Online - Buy Women Kurtis, Cardigans, Knitted Tops, Kaftans, Sweaters, Jackets, Coats, Stoles, Capes &amp; Ponchos | Rage" />

<meta name="twitter:description" content="Discover wide range of women cardigans, coats, jackets, knitted tops, kurtis, sweaters &amp; ponchos. Rage is one of the leading brand for women's in India offer online shopping for ladies cardigans, long coats, woolen kurtis, western dresses, designer tops, capes, tunics, stoles &amp; stylish ponchos. Show online now!" />

<meta name="twitter:image" content="https://www.rageonline.co.in/images/banners/banner-h9zqr11-10-52.jpeg" />

 <script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@graph": [
    {
      "@@type": "Organization",
      "@@id": "https://www.rageonline.co.in/#organization",
      "name": "Rage",
      "legalName": "Rage Knit",
      "url": "https://www.rageonline.co.in/",
      "logo": {
        "@@type": "ImageObject",
        "url": "https://www.rageonline.co.in/assets/images/logo.png"
      },
      "address": {
        "@@type": "PostalAddress",
        "addressLocality": "Ludhiana",
        "addressRegion": "Punjab",
        "addressCountry": "IN"
      },
      "contactPoint": {
        "@@type": "ContactPoint",
        "telephone": "+91-79861-58756",
        "email": "info@rageonline.co.in",
        "contactType": "customer service",
        "areaServed": "IN",
        "availableLanguage": ["en", "hi"]
      },
      "sameAs": [
        "https://www.facebook.com/rageindiaonline",
        "https://www.instagram.com/rageindiaonline"
      ]
    },
    {
      "@@type": "WebSite",
      "@@id": "https://www.rageonline.co.in/#website",
      "url": "https://www.rageonline.co.in/",
      "name": "Rage",
      "publisher": { "@@id": "https://www.rageonline.co.in/#organization" },
      "potentialAction": {
        "@@type": "SearchAction",
        "target": "https://www.rageonline.co.in/results?q={search_term_string}",
        "query-input": "required name=search_term_string"
      }
    }
  ]
}
</script>


@endif


@if(isset($user_order_id) && $user_order_id !='' ) 
<script>

  gtag('event', 'conversion', {

      'send_to': 'AW-992852956/cI4oCN_Mk4UDENz3ttkD',

       'transaction_id': '<?php echo $user_order_id; ?>'

  });

</script>            
@endif

 
@if(isset($user_order_id) && $user_order_id !='' ) 
<!-- Ecommerce Tracking Code - Rage Online Start --->
<script type="text/javascript">
   var _gaq = _gaq || [];
   
   _gaq.push(['_setAccount', 'UA-211842950-1']); 
   
   _gaq.push(['_trackPageview']);
   
   _gaq.push(['_addTrans',
   
     '{{ $orderdetails["id"] }}',           // order ID - required
   
     'Rage Knit',  // affiliation or store name
   
     '{{ $total_amount }}',          // total – required
   
     '0',           // tax
   
     '{{ $orderdetails["shipping_charges"] }}',              // shipping
   
     '{{ $orderdetails["order_address"]["shipping_city"] }}',       // city
   
     '{{ $orderdetails["order_address"]["shipping_state"] }}',     // state or province
   
     '{{ $orderdetails["order_address"]["shipping_country"] }}'             // country
   
   ]);
   
   
   
    // add item might be called for every item in the shopping cart
   
    // where your ecommerce engine loops through each item in the cart and
   
    // prints out _addItem for each
   
   <?php foreach($orderdetails['order_products'] as $order_product) { ?>
   
   _gaq.push(['_addItem',
   
    '{{ $orderdetails["id"] }}',      // order ID - required
   
     '{{ $order_product["product_sku"] }}',           // SKU/code - required
   
     '{{ $order_product["product_name"] }}',        // product name
   
     '{{ $order_product["category_name"] }}',   // category or variation
   
     '{{ $order_product["product_price"] }}',          // unit price - required
   
     '{{ $order_product["product_qty"] }}'               // quantity - required
   
   ]);
   <?php } ?>
   
   _gaq.push(['_trackTrans']); //submits transaction to the Analytics servers
   
   (function() {
   
     var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
   
     ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
   
     var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
   
   })();
   
</script>
<!-- Ecommerce Tracking Code - Rage Online End --->
@endif




@if($page == 'product-detail')
	<script>

  gtag('event', 'page_view', {

    'send_to': 'AW-992852956',

    'value': '<?php echo $productdetails['final_price'] ?>',

    'items': [{

      'id': '<?php echo $productdetails['product_code'] ?>',

      'google_business_vertical': 'retail'

    }]

  });

</script>



<!-- Global site tag (gtag.js) - Google Ads: AW-992852956-->

<script async src="https://www.googletagmanager.com/gtag/js?id=AW-992852956"></script>

<script>

  window.dataLayer = window.dataLayer || [];

  function gtag(){dataLayer.push(arguments);}

  gtag('js', new Date());

  gtag('config', 'AW-992852956');

</script>

<script>

  gtag('event', 'page_view', {

    'send_to': 'AW-992852956',

    'ecomm_pagetype': 'product',

    'ecomm_prodid': <?php echo $productdetails['id'] ?>,

    'ecomm_totalvalue': <?php echo $productdetails['final_price'] ?>                                              

});

</script>





@endif

@if($page == 'cart' && !empty($cartitems))
	<!-- Global site tag (gtag.js) - Google Ads: AW-992852956 -->
<?php
 $Cart_Details = Cart::cartdetails($cartitems);
 
  
 ?>
<script async src="https://www.googletagmanager.com/gtag/js?id=AW-992852956"></script>

<script>

  window.dataLayer = window.dataLayer || [];

  function gtag(){dataLayer.push(arguments);}

  gtag('js', new Date());

  gtag('config', 'AW-992852956');

</script>

<script>

   <?php 
   $product_ids = '';
   foreach($cartitems as $cart_val){
	   if($product_ids == ''){
		  $product_ids = '"'.$cart_val['product_id'].'"';
       }else{
		   $product_ids .= ',"'.$cart_val['product_id'].'"';
	   }
   }  
	
	 ?>


  gtag('event', 'page_view', {

    'send_to': 'AW-992852956',

    'ecomm_pagetype': 'shopping-cart',

    ecomm_prodid:[<?php echo $product_ids; ?>],

    ecomm_totalvalue: <?php echo $Cart_Details['grandtotal']; ?>

  });

</script>
@endif


@if(isset($static_page) && !empty($static_page))
<?php
// ---- SEO: Open Graph + Twitter + JSON-LD for static pages (dynamic) ----
// Optional overrides from the controller: $seo_title, $seo_description, $seo_image
$sp_name  = $static_page;
$sp_url   = url()->current();
$sp_title = !empty($seo_title) ? $seo_title : $sp_name.' - Rage';
$sp_desc  = !empty($seo_description) ? $seo_description : (!empty($metadescription) ? $metadescription : '');
$sp_images = [                                                    // page url => share image (other pages: no image)
	'about-us'          => 'assets/images/Craft.png',
	'brand-ambassadors' => 'assets/images/katrina-kaif.png',
];
$sp_path  = trim(request()->path(), '/');
$sp_image = !empty($seo_image) ? $seo_image : (isset($sp_images[$sp_path]) ? asset($sp_images[$sp_path]) : '');
$sp_types = ['about-us'=>'AboutPage','contact-us'=>'ContactPage'];
$sp_type  = $sp_types[$catseo] ?? 'WebPage';

$sp_page = [
	'@type' => $sp_type,
	'@id'   => $sp_url.'#webpage',
	'url'   => $sp_url,
	'name'  => $sp_title,
];
if($sp_desc !== ''){ $sp_page['description'] = $sp_desc; }
if($sp_type == 'AboutPage'){
	$sp_page['mainEntity'] = [
		'@type'     => 'Organization',
		'name'      => 'Rage',
		'legalName' => 'Rage Knit',
		'url'       => url('/').'/',
		'address'   => ['@type'=>'PostalAddress','addressLocality'=>'Ludhiana','addressRegion'=>'Punjab','addressCountry'=>'IN'],
	];
}
$sp_schema = [
	'@context' => 'https://schema.org',
	'@graph'   => [
		[
			'@type' => 'BreadcrumbList',
			'itemListElement' => [
				['@type'=>'ListItem','position'=>1,'name'=>'Home','item'=>url('/').'/'],
				['@type'=>'ListItem','position'=>2,'name'=>$sp_name,'item'=>$sp_url],
			],
		],
		$sp_page,
	],
];
?>
<!-- Open Graph Meta Tags -->
<meta property="og:type" content="article" />
<meta property="og:title" content="{{ $sp_title }}" />
@if($sp_desc !== '')
<meta property="og:description" content="{{ $sp_desc }}" />
@endif
<meta property="og:url" content="{{ $sp_url }}" />
<meta property="og:site_name" content="Rage" />
@if($sp_image !== '')
<meta property="og:image" content="{{ $sp_image }}" />
@endif

<!-- Twitter Card Meta Tags -->
<meta name="twitter:card" content="{{ $sp_image !== '' ? 'summary_large_image' : 'summary' }}" />
<meta name="twitter:title" content="{{ $sp_title }}" />
@if($sp_desc !== '')
<meta name="twitter:description" content="{{ $sp_desc }}" />
@endif
@if($sp_image !== '')
<meta name="twitter:image" content="{{ $sp_image }}" />
@endif

<script type="application/ld+json">
{!! json_encode($sp_schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_PRETTY_PRINT) !!}
</script>
@endif

@if((isset($static_page) && !empty($static_page)) ||  $catseo == 'home')
<!-- Global site tag (gtag.js) - Google Ads: AW-992852956-->

<script async src="https://www.googletagmanager.com/gtag/js?id=AW-992852956"></script>

<script>

  window.dataLayer = window.dataLayer || [];

  function gtag(){dataLayer.push(arguments);}

  gtag('js', new Date());

  gtag('config', 'AW-992852956');

</script>

<script>

  gtag('event', 'page_view', {

    'send_to': 'AW-992852956',

     'ecomm_pagetype': ' static_page',

   

});

</script>

@endif

@if($page == 'listing-page')
<?php
// ---- SEO: Open Graph + Twitter + JSON-LD for category / listing pages (dynamic) ----
$ls_url         = url()->current();                       // without ?page= / filters
$ls_name        = $catdetails['name'] ?? '';
$ls_title       = !empty($title) ? $title : $ls_name;
$ls_description = !empty($catdetails['description']) ? strip_tags($catdetails['description']) : '';
$ls_image       = !empty($catdetails['image']) ? asset('images/CategoryImages/'.$catdetails['image']) : '';
$ls_schema = [
	'@context' => 'https://schema.org',
	'@graph'   => [
		[
			'@type' => 'BreadcrumbList',
			'itemListElement' => [
				['@type'=>'ListItem','position'=>1,'name'=>'Home','item'=>url('/').'/'],
				['@type'=>'ListItem','position'=>2,'name'=>$ls_name,'item'=>$ls_url],
			],
		],
		[
			'@type'       => 'CollectionPage',
			'@id'         => $ls_url.'#webpage',
			'url'         => $ls_url,
			'name'        => $ls_title,
		],
	],
];
if($ls_description !== ''){ $ls_schema['@graph'][1]['description'] = $ls_description; }
?>
<!-- Open Graph Meta Tags -->
<meta property="og:type" content="website" />
<meta property="og:title" content="{{ $ls_title }}" />
@if($ls_description !== '')
<meta property="og:description" content="{{ $ls_description }}" />
@endif
<meta property="og:url" content="{{ $ls_url }}" />
<meta property="og:site_name" content="Rage" />
@if($ls_image !== '')
<meta property="og:image" content="{{ $ls_image }}" />
@endif

<!-- Twitter Card Meta Tags -->
<meta name="twitter:card" content="summary_large_image" />
<meta name="twitter:title" content="{{ $ls_title }}" />
@if($ls_description !== '')
<meta name="twitter:description" content="{{ $ls_description }}" />
@endif
@if($ls_image !== '')
<meta name="twitter:image" content="{{ $ls_image }}" />
@endif

<script type="application/ld+json">
{!! json_encode($ls_schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_PRETTY_PRINT) !!}
</script>
@if(!empty($getproducts))
<?php 
$view_item_list_items =  json_decode(json_encode($getproducts),true);
?>
<script>
	  gtag("event", "view_item_list", {
	  item_list_id: "{{ $catdetails['id'] }}",
	  item_list_name: "{{ $catdetails['name'] }}",
	  items: [
		<?php foreach($view_item_list_items['data'] as $item_key=>$view_item_list_item) { ?>
{
		  item_id: "{{ $view_item_list_item['id'] }}",
		  item_name: "<?php echo $view_item_list_item['product_name']; ?>",
		  affiliation: "Rage Knit",
		  coupon: "",
		  discount: 0,
		  index: {{ $item_key }},
		  item_brand: "Rageonline",
		  item_category: "{{ $view_item_list_item['category']['name'] }}",
		  item_category2: "",
		  item_category3: "",
		  item_category4: "",
		  item_category5: "",
		  item_list_id: "{{ $view_item_list_item['category']['id'] }}",
		  item_list_name: "{{ $view_item_list_item['category']['name'] }}",
		  item_variant: "<?php echo $view_item_list_item['color']; ?>",
		  location_id: "ChIJIQBpAG2ahYAR_6128GcTUEo",
		  price: <?php echo $view_item_list_item['final_price']; ?>,
		  quantity: 1
		},
		<?php } ?>
	]
  });
</script>
@endif
@endif

@if($page == 'product-detail')
<?php
// ---- SEO: Open Graph + Twitter + JSON-LD for product pages (dynamic) ----
$pd_name   = $productdetails['product_name'] ?? '';
$pd_url    = url()->current();
$pd_sku    = $productdetails['product_code'] ?? '';
$pd_price  = (float) ($productdetails['final_price'] ?? 0);
$pd_price_txt = (string) $pd_price;                                   // 3749.0 => "3749"
$pd_title  = 'Buy '.$pd_name.' Online in India';
$pd_desc   = 'Shop '.$pd_name.' online in India at best prices. Free Shipping, Safe Shopping, Easy Returns & COD Available. Rage is one of the leading online store for women clothing in India.';
$pd_images = [];
foreach(($productdetails['productimages'] ?? []) as $pd_img){
	if(!empty($pd_img['image'])){ $pd_images[] = asset('images/ProductImages/xlarge/'.$pd_img['image']); }
}
$pd_image  = $pd_images[0] ?? '';
$pd_in_stock = ($productdetails['status'] ?? 1) == 1 && array_sum(array_column($productdetails['pro_attrs'] ?? [], 'stock')) > 0;
$pd_cat_name = $productdetails['category']['name'] ?? '';
$pd_cat_url  = !empty($productdetails['category']['seo_unique']) ? url('/'.$productdetails['category']['seo_unique']) : '';

$pd_crumbs = [['@type'=>'ListItem','position'=>1,'name'=>'Home','item'=>url('/').'/']];
if($pd_cat_name !== '' && $pd_cat_url !== ''){
	$pd_crumbs[] = ['@type'=>'ListItem','position'=>count($pd_crumbs)+1,'name'=>$pd_cat_name,'item'=>$pd_cat_url];
}
$pd_crumbs[] = ['@type'=>'ListItem','position'=>count($pd_crumbs)+1,'name'=>$pd_name,'item'=>$pd_url];

$pd_product = [
	'@type'       => 'Product',
	'name'        => $pd_name,
	'description' => $pd_desc,
	'sku'         => $pd_sku,
	'mpn'         => $pd_sku,
	'brand'       => ['@type'=>'Brand','name'=>'Rage'],
	'offers'      => [
		'@type'         => 'Offer',
		'url'           => $pd_url,
		'priceCurrency' => 'INR',
		'price'         => $pd_price_txt,
		'itemCondition' => 'https://schema.org/NewCondition',
		'availability'  => $pd_in_stock ? 'https://schema.org/InStock' : 'https://schema.org/OutOfStock',
		'seller'        => ['@type'=>'Organization','name'=>'Rage'],
	],
];
if(!empty($pd_images)){ $pd_product['image'] = $pd_images; }
if($pd_cat_name !== ''){ $pd_product['category'] = $pd_cat_name; }

$pd_schema = [
	'@context' => 'https://schema.org',
	'@graph'   => [
		['@type'=>'BreadcrumbList','itemListElement'=>$pd_crumbs],
		$pd_product,
	],
];
?>
<!-- Open Graph Meta Tags -->
<meta property="og:type" content="og:product" />
<meta property="og:title" content="{{ $pd_title }}" />
<meta property="og:description" content="{{ $pd_desc }}" />
<meta property="og:url" content="{{ $pd_url }}" />
<meta property="og:site_name" content="Rage" />
@if($pd_image !== '')
<meta property="og:image" content="{{ $pd_image }}" />
@endif
<meta property="product:price:amount" content="{{ $pd_price_txt }}" />
<meta property="product:price:currency" content="INR" />
<meta property="product:availability" content="{{ $pd_in_stock ? 'instock' : 'out of stock' }}" />

<!-- Twitter Card Meta Tags -->
<meta name="twitter:card" content="summary_large_image" />
<meta name="twitter:title" content="{{ $pd_title }}" />
<meta name="twitter:description" content="{{ $pd_desc }}" />
@if($pd_image !== '')
<meta name="twitter:image" content="{{ $pd_image }}" />
@endif
<meta name="twitter:label1" content="Price" />
<meta name="twitter:data1" content="₹{{ number_format($pd_price, fmod($pd_price,1) ? 2 : 0) }}" />
<meta name="twitter:label2" content="Availability" />
<meta name="twitter:data2" content="{{ $pd_in_stock ? 'In Stock' : 'Out of Stock' }}" />

<script type="application/ld+json">
{!! json_encode($pd_schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_PRETTY_PRINT) !!}
</script>
@endif

@if($page == 'product-detail')
<script>
	gtag("event", "view_item", {
	  currency: "INR",
	  value: {{ $productdetails['final_price'] }},
	  items: [
		{
		  item_id: "{{ $productdetails['id'] }}",
		  item_name: "{{ $productdetails['product_name'] }}",
		  affiliation: "Rage Knit",
		  coupon: "",
		  discount: 0,
		  index: 0,
		  item_brand: "Rageonline",
		  item_category: "{{ $productdetails['category']['name'] }}",
		  item_category2: "",
		  item_category3: "",
		  item_category4: "",
		  item_category5: "",
		  item_list_id: "{{ $productdetails['category']['id'] }}",
		  item_list_name: "{{ $productdetails['category']['name'] }}",
		  item_variant: "{{ $productdetails['color'] }}",
		  location_id: "",
		  price: {{ $productdetails['final_price'] }},
		  quantity: 1
		}
	  ]
	});	
</script>	
@endif

@if($page == 'cart')
@if(!empty($cartitems))
<?php
$coupun_code = '';
if(Session::has('couponinfo')){
	$coupun_code = Session::get('couponinfo')['code'];
}
$cartPricing = Cart::cartdetails($cartitems);
?>	
<script>
gtag("event", "add_to_cart", {
  currency: "INR",
  value: {{ $cartPricing['subtotal'] }},
  items: [
    <?php foreach($cartitems as $item_key=>$view_item_list_item) {   ?>
{
      item_id: "{{ $view_item_list_item['product_id'] }}",
      item_name: "{{ $view_item_list_item['product']['product_name'] }}",
      affiliation: "Rage Knit",
      coupon: "{{ $coupun_code }}",
      discount: 0,
      index: {{ $item_key }},
      item_brand: "Rageonline",
      item_category: "{{ $view_item_list_item['product']['category']['name'] }}",
      item_category2: "",
      item_category3: "",
      item_category4: "",
      item_category5: "",
      item_list_id: "{{ $view_item_list_item['product']['category']['id'] }}",
      item_list_name: "{{ $view_item_list_item['product']['category']['name'] }}",
      item_variant: "{{ $view_item_list_item['product']['color'] }}",
      location_id: "",
      price: {{ $view_item_list_item['product']['product_price'] }},
      quantity: {{ $view_item_list_item['qty'] }}
    },
	<?php } ?>
]
});	
</script>	
@endif
@endif

@if($page == 'wishlist')
@if(!empty($wishlists))
<?php
$wishlist_item =  json_decode(json_encode($wishlists),true);
$item_value = 0;
foreach($wishlist_item as $val2){
	$item_value += $val2['product']['final_price'];
}      
?>	
<script>
gtag("event", "add_to_wishlist", {
  currency: "INR",
  value: {{ $item_value }},
  items: [
    <?php foreach($wishlists as $item_key=>$item) {
		$item =  json_decode(json_encode($item),true);
		$cat = Category::where('id',$item['product']['category_id'])->first();
		$view_item_list_item = $item;
		?>
{
      item_id: "{{ $item['product_id'] }}",
      item_name: "{{ $item['product']['product_name'] }}",
      affiliation: "Rage Knit",
      coupon: "",
      discount: 0,
      index: {{ $item_key }},
      item_brand: "Rageonline",
      item_category: "{{ $item['product']['product_name'] }}",
      item_category2: "",
      item_category3: "",
      item_category4: "",
      item_category5: "",
      item_list_id: "{{ $cat['id'] }}",
      item_list_name: "{{ $cat['name'] }}",
      item_variant: "{{ $item['product']['color'] }}",
      location_id: "",
      price: {{ $view_item_list_item['product']['product_price'] }},
      quantity: {{ $view_item_list_item['qty'] }}
    },
	<?php } ?>
],
});	
</script>	
@endif
@endif

@if($page == 'checkout')
@if(!empty($cartitems))	
<?php
$coupun_code = '';
$discount = 0;
$cartPricing = Cart::cartdetails($cartitems);
if(Session::has('couponinfo')){
	$coupun_code = Session::get('couponinfo')['code'];
	$discount = $cartPricing['discount'];
}

?>
<script>
gtag("event", "begin_checkout", {
  currency: "INR",
  value: {{ $cartPricing['grandtotal'] }},
  coupon: "{{ $coupun_code }}",
  items: [
    <?php foreach($cartitems as $item_key=>$view_item_list_item) {   ?>
	{
      item_id: "{{ $view_item_list_item['product_id'] }}",
      item_name: "{{ $view_item_list_item['product']['product_name'] }}",
      affiliation: "Rage Knit",
      coupon: "",
      discount: 0,
      index: {{ $item_key }},
      item_brand: "Rageonline",
      item_category: "{{ $view_item_list_item['product']['category']['name'] }}",
      item_category2: "",
      item_category3: "",
      item_category4: "",
      item_category5: "",
      item_list_id: "{{ $view_item_list_item['product']['category']['id'] }}",
      item_list_name: "{{ $view_item_list_item['product']['category']['name'] }}",
      item_variant: "{{ $view_item_list_item['product']['color'] }}",
      location_id: "",
      price: 9.99,
      quantity: 1
    },
	<?php } ?>
  ]
});	
</script>	
@endif
@endif

@if(isset($user_order_id) && $user_order_id !='' )
	
	<script>
     gtag("event", "add_payment_info", {
	  currency: "INR",
	  value: {{ $orderdetails['grand_total'] }},
	  coupon: "{{ $orderdetails['coupon_code'] }}",
	  payment_type: "{{ $orderdetails['payment_method'] }}",
	  items: [
		<?php foreach($orderdetails['order_products'] as $item_key=>$order_product) {  ?>
{
		  item_id: "{{ $order_product['id'] }}",
		  item_name: "{{ $order_product['product_name'] }}",
		  affiliation: "Rage Knit",
		  coupon: "{{ $orderdetails['coupon_code'] }}",
		  discount: {{ $orderdetails['coupon_discount'] }},
		  index: {{ $item_key }},
		  item_brand: "Rageonline",
		  item_category: "{{ $order_product['category_name'] }}",
		  item_category2: "",
		  item_category3: "",
		  item_category4: "",
		  item_category5: "",
		  item_list_id: "{{ $order_product['category_id'] }}",
		  item_list_name: "{{ $order_product['category_name'] }}",
		  item_variant: "{{ $order_product['color'] }}",
		  location_id: "",
		  price: {{ $order_product['product_price'] }},
		  quantity: {{ $order_product['product_qty'] }}
		},
		<?php } ?>
		
		]
	});
	</script>
@endif
@endif


	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"/>
	<meta name="csrf-token" content="{{ csrf_token() }}" />
	<link rel="shortcut icon" type="image/x-icon" href="{{ asset('images/favicon.png') }}"/>  
	@include('layouts.frontLayout.meta')
	@include('layouts.frontLayout.css-files')
	

	
	<style>
	.openBtn {
  background: #f1f1f1;
  border: none;
  padding: 10px 15px;
  font-size: 20px;
  cursor: pointer;
}

.openBtn:hover {
  background: #bbb;
}

.overlay {
  height: 100%;
  width: 100%;
  display: none;
  position: fixed;
  z-index: 999;
  top: 0;
  left: 0;
  background-color: rgb(0,0,0);
  background-color: rgba(0,0,0, 0.9);
}

.overlay-content {
  position: relative;
  top: 46%;
  width: 80%;
  text-align: center;
  margin-top: 30px;
  margin: auto;
}

.overlay .closebtn {
  position: absolute;
  top: 20px;
  right: 45px;
  font-size: 60px;
  cursor: pointer;
  color: white;
}

.overlay .closebtn:hover {
  color: #ccc;
}

.overlay input[type=text] {
  padding: 15px;
  font-size: 17px;
  border: none;
  float: left;
  width: 80%;
  background: white;
}

.overlay input[type=text]:hover {
  background: #f1f1f1;
}

.overlay button {
  float: left;
  width: 20%;
  padding: 15px;
  background: #ddd;
  font-size: 17px;
  border: none;
  cursor: pointer;
}

.overlay button:hover {
  background: #bbb;
}
	</style>
</head>
	<body>
        <div class="container-fluid PleaseWaitDiv"  id="t" style="display:none;">
        </div>	
		@include('layouts.frontLayout.front-header')
			@yield('content')
		@include('layouts.frontLayout.front-footer')
		<div id="myOverlay" class="overlay">
			  <span class="closebtn" onclick="closeSearch()" title="Close Overlay">×</span>
			  <div class="overlay-content">
				<form action="{{ url('results') }}">
				  <input type="text" placeholder="Search product name / product code" name="q" required minlength="3">
				  <button type="submit"><i class="fa fa-search"></i></button>
				</form>
			  </div>
        </div>
	</body>
@include('layouts.frontLayout.js-files')
@include('layouts.frontLayout.common-js')	
<script>
function openSearch() {
  document.getElementById("myOverlay").style.display = "block";
}

function closeSearch() {
  document.getElementById("myOverlay").style.display = "none";
}
</script>
</html>