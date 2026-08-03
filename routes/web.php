<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use Illuminate\Support\Facades\Schema;
use App\Category;
use App\CmsPage;

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\CustomerController as BaseCustomerController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\FeedbackController;
use App\Http\Controllers\Admin\FranchiseenquiryController;
use App\Http\Controllers\Admin\GiftController;

use App\Http\Controllers\HomeController;



use App\Http\Controllers\Front\IndexController;
use App\Http\Controllers\Front\CcavenueController;
use App\Http\Controllers\Front\CronJobController;
use App\Http\Controllers\Front\CustomerController;
use App\Http\Controllers\Front\ListingController;
use App\Http\Controllers\Admin\OrdersController;
use App\Http\Controllers\Front\PaymentController;
use App\Http\Controllers\Front\PayuController;
use App\Http\Controllers\Front\PhonepeController;
use App\Http\Controllers\Admin\ProductAttributeController;
use App\Http\Controllers\Admin\ProductsController;
use App\Http\Controllers\Front\RazorpayController;
use App\Http\Controllers\Admin\ReportsController;
use App\Http\Controllers\Admin\ReturnController;
use App\Http\Controllers\Admin\ReviewsController;
use App\Http\Controllers\Front\SocialAuthController;
use App\Http\Controllers\Admin\TestController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\WholesaleenquiryController;


Route::get('/', function () {
	//echo "coming soon"; die;
    return view('coming-soon');
});

Route::prefix('/admin')->group(function(){
  //All the admin routes will be defined here...
	Route::match(['get','post'],'/',[AdminController::class, 'login'])->name('admin_login');
	Route::get('/stock-update/{id}',[AdminController::class, 'update_stock']);
	Route::any('webhook_razorpay',[AdminController::class, 'webhook_razorpay']);
	Route::get('logout',[AdminController::class, 'logout']);
	Route::group(['middleware' => ['admin']], function () {
		Route::match(['get', 'post'], '/update-product-price', [AdminController::class, 'update_product_price']);
		Route::match(['get', 'post'], '/testfun', [AdminController::class, 'testfun']);
		Route::match(['get', 'post'], '/dashboard', [AdminController::class, 'dashboard']);
		Route::match(['get', 'post'],'/dashboard-reports', [AdminController::class, 'dashboard_reports']);
		Route::match(['get', 'post'], '/profile', [AdminController::class, 'profile']);
		Route::match(['get', 'post'], '/settings', [AdminController::class, 'settings']);
		Route::match(['get', 'post'], '/change-picture', [AdminController::class, 'changeAdminLogo']);
		Route::match(['get', 'post'], '/update-password', [AdminController::class, 'changeAdminPassword']);
		Route::match(['get', 'post'], '/checkAdminPassword', [AdminController::class, 'checkAdminPassword']);
		Route::match(['get', 'post'], '/status', [AdminController::class, 'status']);
		//Subadmin Routes
		Route::match(['get', 'post'], '/subadmins', [AdminController::class, 'subadmins']);
		Route::match(['get', 'post'], '/add-edit-subadmin/{id?}', [AdminController::class, 'addeditSubadmin']);
		Route::match(['get', 'post'], '/update-role/{id}', [AdminController::class, 'updateRole']);
		Route::match(['get', 'post'], '/checkAdminUsername', [AdminController::class, 'checkAdminUsername']);

		//Users Routes
		Route::match(['get', 'post'], '/users', [UsersController::class, 'users']);
		Route::match(['get', 'post'], '/add-edit-user/{id?}', [UsersController::class, 'addEditUser']);
		Route::match(['get', 'post'], '/CheckUserEmail', [UsersController::class, 'CheckUserEmail']);

		// Category Routes
		Route::match(['get', 'post'], '/categories', [CategoryController::class, 'categories']);
		Route::match(['get', 'post'], '/add-edit-category/{id?}', [CategoryController::class, 'addEditCatgeory']);
		Route::match(['get', 'post'], '/CheckSeoUnique', [CategoryController::class, 'CheckSeoUnique']);
        Route::match(['get', 'post'], '/remove-category-sizechartimage', [CategoryController::class, 'removeCategorySizechartImage']);

		// Product Routes
		Route::match(['get', 'post'], '/products', [ProductsController::class, 'products']);
		Route::match(['get', 'post'], '/compress_product_images', [ProductsController::class, 'compress_product_images']); 
		Route::match(['get', 'post'], '/add-edit-product/{id?}', [ProductsController::class, 'addEditProduct'])->name('add_edit_product');
		Route::match(['get', 'post'], '/delete-product/{id}', [ProductsController::class, 'deleteProduct']);
		Route::match(['get', 'post'], '/remove-attribute/{attrid}/{productid}', [ProductsController::class, 'removeAttribute']);
		Route::match(['get', 'post'], '/add-edit-Product-tags/{id?}', [ProductsController::class, 'addEditProductTags']);
		Route::match(['get', 'post'], '/product-tag', [ProductsController::class, 'product_tag']); 
		Route::match(['get', 'post'], '/product-tag-delete/{id}', [ProductsController::class, 'product_tag_delete']); 
		Route::match(['get', 'post'], '/checkProductDetails', [ProductsController::class, 'checkProductDetails']);
		Route::match(['get', 'post'], '/delete-product-image', [ProductsController::class, 'deleteProductImage']);
		Route::match(['get', 'post'], '/change-attr-status', [ProductsController::class, 'ChangeAttrStatus']);
		Route::match(['get', 'post'], '/update-image-sort', [ProductsController::class, 'updateImageSort']);
		Route::match(['get', 'post'], '/remove-product-sizechartimage', [ProductsController::class, 'removeProductSizechartImage']);
		Route::match(['get', 'post'], '/stocks', [ProductsController::class, 'stocks']);
		
		// Product Stocks
		Route::get('/product-attributes',[ProductAttributeController::class, 'index'])->name('product_attributes');
		Route::get('/product-attributes/fetch', [ProductAttributeController::class, 'fetch'])->name('product.attributes.fetch');
		Route::post('/product-attributes/update-stock',[ProductAttributeController::class, 'updateStock'])->name('product.attributes.updateStock');
		Route::post('/product-attributes/filter-stock',[ProductAttributeController::class, 'filterStock'])->name('product.attributes.filterStock');
		Route::post('/product-attributes/logs',[ProductAttributeController::class, 'logs'])->name('product.attributes.logs');
		Route::get('/product-attributes/export',[ProductAttributeController::class, 'export'])->name('product.attributes.export');
		
		
		
		
		
		//Coupon Routes
		Route::match(['get', 'post'], '/header-text/{id?}', [AdminController::class, 'headertext']);
		Route::match(['get', 'post'], '/coupons', [CouponController::class, 'coupons']);
		Route::match(['get', 'post'], '/checkCouponCode', [CouponController::class, 'checkCouponCode']);
		Route::match(['get', 'post'], '/add-edit-coupon/{id?}', [CouponController::class, 'addEditCoupon']);
		Route::match(['get', 'post'], '/delete-coupon/{id}', [CouponController::class, 'deleteCouponCode']);

		//Home Page Banners
		Route::match(['get', 'post'], '/banner-images', [BannerController::class, 'bannerImages']);
		Route::match(['get', 'post'], '/edit-add-cms/{id?}', [AdminController::class, 'addEditCms']);
        Route::match(['get', 'post'], '/faq-page', [AdminController::class, 'faqPage']);	
        Route::match(['get', 'post'], '/faqpage-addEdit/{id?}', [AdminController::class, 'faqPageAddEdit']);			
        Route::match(['get', 'post'], '/faqpage-addEdit', [AdminController::class, 'faqPageAddEdit']);			
        Route::match(['get', 'post'], '/faqpage-delete/{id}', [AdminController::class, 'faqpage_delete']);			

		Route::match(['get', 'post'], '/add-edit-banner-image/{id?}', [BannerController::class, 'addEditBannerImage']);
		Route::match(['get', 'post'], '/delete-banner-image/{id}', [BannerController::class, 'deleteBannerImage']);

		//Orders Routes
		Route::match(['get', 'post'], '/orders', [OrdersController::class, 'orders']);
		Route::get('/order-view/{id}', [OrdersController::class, 'orderview']);
		Route::post('/order-delete', [OrdersController::class, 'orderdelete']);
		Route::post('/update-shipping-address/{id}', [OrdersController::class, 'updateShippingAddress']);
		Route::match(['get', 'post'], '/order-invoice/{id}', [OrdersController::class, 'vieworderInvoice']);
		Route::match(['get', 'post'], '/order-invoice-new/{id}', [OrdersController::class, 'vieworderInvoicenew']);
		Route::match(['get', 'post'], '/courier-invoice/{id}', [OrdersController::class, 'courierInvoice']);
		Route::match(['get', 'post'], '/update-order-status/{id}', [OrdersController::class, 'updateOrderStatus']);
		Route::match(['get', 'post'], '/exchange-return-requests', [ReturnController::class, 'returnRequests']);
		Route::match(['get', 'post'], '/exchange', [ReturnController::class, 'exchangeRequests']);
		Route::match(['get', 'post'], '/return-status', [ReturnController::class, 'return_status']);
		Route::match(['get', 'post'], '/exchange-status', [ReturnController::class, 'exchange_status']);
		Route::match(['get', 'post'], '/accept-exchange/{id}', [ReturnController::class, 'accept_exchange']);
		
		Route::get('/order-details/{id}', [OrdersController::class, 'orderDetails']);  
		Route::get('/track-order/{id}', [OrdersController::class, 'trackOrder']);  
		
		
		Route::match(['get', 'post'], '/get_update_data', [ReturnController::class, 'get_update_data']);
		
		//Careers Routes
		Route::match(['get', 'post'], '/careers', [AdminController::class, 'usercareers']);
		//Stores Route
		Route::match(['get', 'post'], '/stores', [AdminController::class, 'stores']);
		Route::match(['get', 'post'], '/add-edit-store/{id?}', [AdminController::class, 'addEditStore']);

		Route::match(['get', 'post'], '/web-settings', [AdminController::class, 'webSettings']);
		Route::match(['get', 'post'], '/cms', [AdminController::class, 'cms']);
		Route::match(['get', 'post'], '/edit-web-setting/{id}', [AdminController::class, 'editWebSetting']);
		Route::match(['get', 'post'], '/delete-subscribers/{id?}', [AdminController::class, 'deleteSubscribers']);
        Route::match(['get', 'post'], '/notify', [AdminController::class, 'notify']);	
		//Subscriber Routes
		Route::match(['get', 'post'], '/subscribers', [AdminController::class, 'subscribers']);
		Route::match(['get', 'post'], '/awb', [OrdersController::class, 'awb']);
		//Gift Routes
		Route::match(['get', 'post'], '/gifts', [GiftController::class, 'gifts']);
		Route::match(['get', 'post'], '/add-edit-gift/{id?}', [GiftController::class, 'addEditgift']);
		//Reports Controller
		Route::match(['get', 'post'], '/export-subscribers', [ReportsController::class, 'exportSubscribers']);
		Route::match(['get', 'post'], '/export-orders', [ReportsController::class, 'exportorders']);
		Route::match(['get', 'post'], '/export-stock', [ReportsController::class, 'exportProductStock']);
		Route::match(['get', 'post'], '/export-attribute', [ReportsController::class, 'exportattributeTable']);
		Route::match(['get', 'post'], '/export-images', [ReportsController::class, 'exportimageTable']);
		Route::match(['get', 'post'], '/export-product', [ReportsController::class, 'exportproductTable']);
	
		Route::match(['get', 'post'], '/export-users', [ReportsController::class, 'exportUsers']);
		Route::match(['get', 'post'], '/wholesale-enquiry', [WholesaleenquiryController::class, 'index']);
		Route::match(['get', 'post'], '/contact', [ContactController::class, 'index']);
		Route::get('view-contact/{id}', [ContactController::class, 'view_contact']);
		Route::match(['get', 'post'], '/feedback', [FeedbackController::class, 'index']);
		Route::match(['get', 'post'], '/franchise-enquiry', [FranchiseenquiryController::class, 'index']);
		Route::match(['get', 'post'], '/franchise-enquiry-details/{id}', [FranchiseenquiryController::class, 'franchiseEnquiryDetails']);
		
		Route::match(['get', 'post'], '/pattern', [AdminController::class, 'pattern']);
		Route::match(['get', 'post'], '/pattern', [AdminController::class, 'pattern']);
		
		Route::match(['get', 'post'], '/exchange-accept-status', [ReturnController::class, 'exchange_acceptstatus']);
		
		Route::match(['get', 'post'], '/fabric', [AdminController::class, 'fabric']);
		Route::match(['get', 'post'], '/add-edit-fabric/{id?}', [AdminController::class, 'addEditFabric']);
		Route::match(['get', 'post'], '/delete-fabric/{id?}', [AdminController::class, 'deleteFabric']);
		
		Route::match(['get', 'post'], '/neck', [AdminController::class, 'neck']);
		Route::match(['get', 'post'], '/add-edit-neck/{id?}', [AdminController::class, 'addEditNeck']);		

		Route::match(['get', 'post'], '/sleeve', [AdminController::class, 'sleeve']);
		Route::match(['get', 'post'], '/add-edit-sleeve/{id?}', [AdminController::class, 'addEditSleeve']);
		
		
		Route::match(['get', 'post'], '/delete-sleeve/{id?}', [AdminController::class, 'deleteSleeve']);
		Route::match(['get', 'post'], '/delete-neck/{id?}', [AdminController::class, 'deleteNeck']);
		Route::match(['get', 'post'], '/delete-pattern/{id?}', [AdminController::class, 'deletePattern']);
		Route::match(['get', 'post'], '/delete-colorfamily/{id?}', [AdminController::class, 'deleteColorfamily']);
		
		Route::match(['get', 'post'], '/colorfamilies', [AdminController::class, 'colorfamilies']);
		Route::match(['get', 'post'], '/add-edit-colorfamily/{id?}', [AdminController::class, 'addEditColorFamilies']);
		Route::match(['get', 'post'], '/UPDATE_PRODUCT_ATTR_SKU', [AdminController::class, 'UPDATE_PRODUCT_ATTR_SKU']);
		Route::match(['get', 'post'], '/test_img_name', [TestController::class, 'test_img_name']);
		
		
		//product-reviews
		Route::match(['get', 'post'], '/product-reviews', [ReviewsController::class, 'productreviews']);
		
		
		
	
	});

});
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::post('login', [ 'as' => 'login', 'uses' => [BaseCustomerController::class, 'checkAuth']]);
	/*Frontend Routes*/
Route::group([], function(){
	
	Route::get('/',[IndexController::class, 'index']);
	Route::get('/index-demo',[IndexController::class, 'indexDemo']);
	Route::get('/indexx',[IndexController::class, 'indexx']);
	Route::get('/index_demo',[IndexController::class, 'indexx']);
	Route::get('/about-us',[IndexController::class, 'aboutus']);
	Route::get('/faq',[IndexController::class, 'faq']);
	Route::get('/lookbook',[IndexController::class, 'lookbook']);
	Route::get('/sitemap',[IndexController::class, 'sitemap']);
	Route::any('/t-form',[IndexController::class, 'testform'])->name('testform');
	Route::post('/save-wholesale-enquiry',[CustomerController::class, 'wholesale_enquiry']); 
	Route::get('search-products',array('as'=>'search-products','uses'=>[IndexController::class, 'autoComplete']));
	Route::match(['get','post'],'/results',[ListingController::class, 'searchresults']);
	Route::match(['get','post'],'/search-autofill',[ListingController::class, 'search_autofill']);
	Route::post('/get-state',[CustomerController::class, 'getState']);
	Route::get('/logout',[CustomerController::class, 'logout']);
	Route::post('/genreate-otp',[CustomerController::class, 'genreate_otp']);  
	Route::post('/update-email',[CustomerController::class, 'update_email']);
	Route::match(['get','post'],'/login',[CustomerController::class, 'login']);
	Route::post('/check-register',[CustomerController::class, 'check_register']);
	Route::match(['get','post'],'/register',[CustomerController::class, 'register']);
	Route::match(['get','post'],'/forgot-password',[CustomerController::class, 'forgotPassword']);
	Route::match(['get','post'],'/guest-checkout',[CustomerController::class, 'guestCheckout']);
	Route::post('/update-address', [CustomerController::class, 'updateAddress']);
	//get_pincode_details
	Route::post('/get-pincode-details',[CustomerController::class, 'get_pincode_details']);
	Route::post('/save-review',[IndexController::class, 'saveReview']);
	Route::match(['get','post'],'/add-to-wishlist',[ListingController::class, 'addtoWishlist']);
	Route::get('/product/{seo}',[ListingController::class, 'productdetail']);
	Route::post('/check-pincode',[ListingController::class, 'checkPincode']);
	Route::get('/abort', [IndexController::class, 'abort'])->name('abort');
	Route::get('/get-state-city', [IndexController::class, 'get_state_city'])->name('get_state_city');
	Route::post('/get-product-attribute-price',[ListingController::class, 'getProductAttributePricing']);
	Route::post('/check-product-qty',[ListingController::class, 'checkProductQty']);
	Route::post('/add-to-cart',[ListingController::class, 'addtoCart']);
	Route::get('/cart',[ListingController::class, 'cart']);
	Route::get('/cart-items-ajax',[ListingController::class, 'cartItemsAjax']);
	Route::match(['get','post'],'/update-cart-product',[ListingController::class, 'updateCartProduct']);
	Route::match(['get','post'],'/popup-cart-qty-update',[ListingController::class, 'updatePopupCartProduct']);
	Route::match(['get','post'],'/update-cart-productsize',[ListingController::class, 'updateCartProductsize']);
	Route::post('/remove-cart-product',[ListingController::class, 'removeCartProduct']);
	Route::post('/apply-coupon',[ListingController::class, 'applyCoupon']);
	Route::post('/apply-points',[ListingController::class, 'applyPoints']);
	Route::post('/remove-points',[ListingController::class, 'removePoints']);
	Route::post('/apply-gift',[ListingController::class, 'applyGift']);
	Route::post('/get-order-summery',[ListingController::class, 'get_order_summery']);
	 Route::post('/product-quick-view',[ListingController::class, 'product_quick_view'])->name('product_quick_view');
	 Route::get('/feed/{type}',[CronJobController::class, 'feed']);
	
	Route::group(['middleware' => ['auth']], function () {
		Route::get('account/{slug}',[CustomerController::class, 'account']);
		Route::get('order/{id}',[CustomerController::class, 'orderview']);
		Route::get('track-order/{id}',[CustomerController::class, 'trackOrder']);
		Route::get('account/order-invoice-print/{any}',[CustomerController::class, 'order_invoice_print']);
		Route::post('submit-account-details',[CustomerController::class, 'submitAcountDetails']);
		Route::post('return-order-item',[CustomerController::class, 'returnOrderItem']);
		Route::post('exchange-order-item',[CustomerController::class, 'exchangeOrderItem']);
		Route::get('exchange-item/{id}',[CustomerController::class, 'returnExchangeItem']);
		Route::post('exchange_item/{id}',[CustomerController::class, 'return_exchange_item']);
		Route::get('order-cancel/{id}',[CustomerController::class, 'order_cancel']);
		
		

		Route::post('change-password',[CustomerController::class, 'changePassword']);
		Route::get('newsletter-subscription-change',[CustomerController::class, 'newsletter_subscription_change']);
		Route::get('/remove-wishlist/{id}',[ListingController::class, 'removeWishlist']);
       
		
		Route::get('/order-checkout',[ListingController::class, 'orderCheckout']);
		Route::post('/check-order',[ListingController::class, 'checkOrder']);
		Route::post('/place-orders',[ListingController::class, 'placeOrder']);
		
		//address Routes
		Route::match(['get','post'],'/save-address',[CustomerController::class, 'saveAddress']);
		Route::get('/get-delivery-address',[CustomerController::class, 'getDeliveryAddress']);
		Route::get('/set-default-address',[CustomerController::class, 'setDefaultAddress']);
		Route::get('/remove-delivery-address',[CustomerController::class, 'removeDeliveryAddress']);
	});
	Route::get('/thanks',[ListingController::class, 'thanks']);
	Route::get('/sale',[ListingController::class, 'sale']);
	//Route::match(['get','post'],'/cancel',[ListingController::class, 'cancel']);
	//Route::match(['get','post'],'/payu/payment',[PaymentController::class, 'payuPayment']);
	//Payu Routes
	//Route::match(['get','post'],'/payu/success',[PaymentController::class, 'payuSuccess']);
	Route::post('/payu-money-callback',[CronJobController::class, 'payumoneycallback']);
	Route::get('/payu-ipn-verification', [PaymentController::class, 'ipnPayuVerification']);
	Route::get('/single-order-status/{oid}', [PaymentController::class, 'singleOrderStatus']);
	/* PHONEPE PAYMENT */
	Route::match(['get','post'],'phonepe-payment',[PhonepeController::class, 'phonePePayment']);
	Route::match(['get','post'],'phonepe/redirect',[PhonepeController::class, 'phonePeRedirect']);
	Route::match(['get','post'],'phonepe/callback',[PhonepeController::class, 'phonePeCallback']);
	
	/* Razorpay PAYMENT */
	
	Route::match(['get','post'],'razorpay-payment',[RazorpayController::class, 'razorpayPayment'])->name('razorpay-payment');
	Route::match(['get','post'],'dopayment',[RazorpayController::class, 'dopayment'])->name('dopayment');
	Route::match(['get','post'],'webhook-razorpay',[RazorpayController::class, 'webhook_razorpay'])->name('webhook_razorpay');
	
	
	
	if (Schema::hasTable('categories')) {
		//Category Route
		$catSlugs = Category::Where('status',1)->get()->pluck('seo_unique')->toArray();
		foreach($catSlugs as $cat){
			Route::get('/'.$cat,[ListingController::class, 'productlisting']);
		}
	}
	Route::get('/new-arrivals',[ListingController::class, 'productlisting']); 
	Route::get('/shop-all',[ListingController::class, 'productlisting']); 
	//CMS ROUTES
	$cmsArray = CmsPage::Where('status',1)->get()->pluck('slug')->toArray();
	foreach($cmsArray as $cms){
		Route::get('/'.$cms,[IndexController::class, 'staticpages']);
	}
	Route::get('/join-our-community',[IndexController::class, 'ourCommunity']);
	Route::get('/sustainability',[IndexController::class, 'sustainability']);
	Route::get('/quality',[IndexController::class, 'quality']);
	Route::get('/privacy-policy',[IndexController::class, 'privacyPolicy']);
	
	Route::get('/cancellation-policy',[IndexController::class, 'cancellationPolicy']);
	Route::get('/return-and-refund-policy1',[IndexController::class, 'returnandRefundpolicy']);
	Route::get('/return-policy',[IndexController::class, 'returnPolicy']);
	Route::get('/cancellation-and-refund-policy',[IndexController::class, 'cancellationAndrefundPolicy']);
	Route::get('/shipping-policy',[IndexController::class, 'shippingPolicy']);
	
	
	Route::get('/terms-and-conditions',[IndexController::class, 'termsConditions']);
	Route::get('/contact-us',[IndexController::class, 'contactus']);
	Route::post('/save-contact',[IndexController::class, 'saveContact']);
	
	Route::get('/feedback',[IndexController::class, 'feedback']);
	Route::post('/save-feedback',[IndexController::class, 'saveFeedback']);
	
	Route::get('/franchise-enquiry',[IndexController::class, 'franchiseEnquiry']);
	Route::post('/save-franchiseenquiry',[IndexController::class, 'SavefranchiseEnquiry']);
	
	Route::get('/store-locator',[IndexController::class, 'storeLocator']);
	//Subscriber routes
	Route::get('add-subscriber',[IndexController::class, 'addSubscriber']);
	//Cron Jobs
	Route::get('cart-reminder',[CronJobController::class, 'cartReminder']);
	Route::get('cart-remindermail',[CronJobController::class, 'cartRemindermail']);
	Route::post('/save-notify',[IndexController::class, 'savenotify']);
	/*Facebook Routes Starts*/
	Route::get('/facebook/redirect', [SocialAuthController::class, 'facebokRedirect']);
	Route::any('/facebook/callback', [SocialAuthController::class, 'facebookCallback']);
	Route::get('/google/redirect', [SocialAuthController::class, 'googleredirect']);
	Route::get('/google/callback', [SocialAuthController::class, 'googlecallback']);
	Route::get('/view-order-email/{id}', [ListingController::class, 'viewOrderEmail']);
	Route::get('/checksms',[CustomerController::class, 'checksms']);
	
Route::match(['get','post'],'/payu/payment',[PayuController::class, 'payuPayment']);
Route::match(['get','post'],'/payu/success',[PayuController::class, 'payuSuccess']);
Route::match(['get','post'],'/payu/response',[PayuController::class, 'payuResponse']);
Route::match(['get','post'],'/cancel',[ListingController::class, 'cancel']);	
Route::match(['get','post'],'google-feed-text',[CronJobController::class, 'googleFeedText']);
Route::match(['get','post'],'/ccavenue/payment',[CcavenueController::class, 'ccavenuePayment']);
	Route::match(['get','post'],'/ccavenue/response',[CcavenueController::class, 'ccavenueresponse']);
	Route::match(['get','post'],'/ccavenue/cancel',[CcavenueController::class, 'ccavenueCancel']);
	/*Facebook Routes Ends*/
});