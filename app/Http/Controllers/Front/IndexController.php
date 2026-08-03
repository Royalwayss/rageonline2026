<?php

namespace App\Http\Controllers\Front;

use Illuminate\Support\Str;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Product;
use App\BannerImage;
use Illuminate\Support\Facades\Route;
use App\CmsPage;
use Illuminate\Support\Facades\Validator;
use App\State;
use App\Store;
use App\StoreLocation;
use App\City;
use App\Subscriber;
use App\Contact;
use App\Feedback;
use App\Visitor;
use App\Order;
use App\Notifies;
use App\FranchiseEnquiry;
use App\ProductReview;
use App\CustomFunction;
use Redirect;
use DB;
use Auth;
use Illuminate\Support\Facades\Mail;
class IndexController extends Controller
{
    public function comingsoon(){ 
        $title = 'Comming Soon';
        return view('coming-soon')->with(compact('title'));
        
    }
    //
    public function index(){ 
		$catseo = 'home';
    	$title="Winter Dresses  Online - Buy Women Kurtis, Cardigans, Knitted Tops, Kaftans, Sweaters, Jackets, Coats, Stoles, Capes & Ponchos | Rage";
    	$metakeywords ="women jackets, women cardigans, women sweaters, women capes, women ponchos, ladies kurtis, woolen kurtis, women winter clothing, women clothing online, knitted tops";
    	$metadescription="Discover wide range of women cardigans, coats, jackets, knitted tops, kurtis, sweaters & ponchos. Rage is one of the leading brand for women's in India offer online shopping for ladies cardigans, long coats, woolen kurtis, western dresses, designer tops, capes, tunics, stoles & stylish ponchos. Show online now!";
        $showPoup = $this->checkVistor();
		$new_arrival_products = Product::with(['attributes','productimages','category'])->where(['status'=>1,'new_arrival'=>'yes'])->orderby('id','DESC')->skip(0)->take(10)->get();
		$best_seller_products = Product::with(['attributes','productimages','category'])->where(['status'=>1,'best_seller'=>'yes'])->orderby('id','DESC')->skip(0)->take(10)->get();
		return view('front.home2')->with(compact('catseo','title','metakeywords','metadescription','new_arrival_products','best_seller_products'));
    }
	 public function home2(){ 
	    $catseo = 'home';
    	$title="Winter Dresses  Online - Buy Women Kurtis, Cardigans, Knitted Tops, Kaftans, Sweaters, Jackets, Coats, Stoles, Capes & Ponchos | Rage";
    	$metakeywords ="women jackets, women cardigans, women sweaters, women capes, women ponchos, ladies kurtis, woolen kurtis, women winter clothing, women clothing online, knitted tops";
    	$metadescription="Discover wide range of women cardigans, coats, jackets, knitted tops, kurtis, sweaters & ponchos. Rage is one of the leading brand for women's in India offer online shopping for ladies cardigans, long coats, woolen kurtis, western dresses, designer tops, capes, tunics, stoles & stylish ponchos. Show online now!";
        $showPoup = $this->checkVistor();
		$new_arrival_products = Product::with(['attributes','productimages','category'])->where(['status'=>1,'new_arrival'=>'yes'])->orderby('id','DESC')->skip(0)->take(10)->get();
		$best_seller_products = Product::with(['attributes','productimages','category'])->where(['status'=>1,'best_seller'=>'yes'])->orderby('id','DESC')->skip(0)->take(10)->get();
		return view('front.home2')->with(compact('catseo','title','metakeywords','metadescription','new_arrival_products','best_seller_products'));
    }
	public function home3(){ 
	    $catseo = 'home';
    	$title="Winter Dresses  Online - Buy Women Kurtis, Cardigans, Knitted Tops, Kaftans, Sweaters, Jackets, Coats, Stoles, Capes & Ponchos | Rage";
    	$metakeywords ="women jackets, women cardigans, women sweaters, women capes, women ponchos, ladies kurtis, woolen kurtis, women winter clothing, women clothing online, knitted tops";
    	$metadescription="Discover wide range of women cardigans, coats, jackets, knitted tops, kurtis, sweaters & ponchos. Rage is one of the leading brand for women's in India offer online shopping for ladies cardigans, long coats, woolen kurtis, western dresses, designer tops, capes, tunics, stoles & stylish ponchos. Show online now!";
        $showPoup = $this->checkVistor();
		$new_arrival_products = Product::with(['attributes','productimages','category'])->where(['status'=>1,'new_arrival'=>'yes'])->orderby('id','DESC')->skip(0)->take(10)->get();
		$new_arrival_summer_collection_products = []; /* Product::with(['attributes','productimages','category'])->where(['status'=>1,'new_arrival'=>'yes'])->wherein('category_id',[6,7,8])->orderby('id','DESC')->skip(0)->take(10)->get(); */
		
    	//echo "<pre>"; print_r($new_arrival_products); exit;
		return view('front.home3')->with(compact('catseo','title','metakeywords','metadescription','new_arrival_products','new_arrival_summer_collection_products'));
    }
	public function indexDemo(){ 
	    $catseo = 'home';
    	$title="Winter Dresses  Online - Buy Women Kurtis, Cardigans, Knitted Tops, Kaftans, Sweaters, Jackets, Coats, Stoles, Capes & Ponchos | Rage";
    	$metakeywords ="women jackets, women cardigans, women sweaters, women capes, women ponchos, ladies kurtis, woolen kurtis, women winter clothing, women clothing online, knitted tops";
    	$metadescription="Discover wide range of women cardigans, coats, jackets, knitted tops, kurtis, sweaters & ponchos. Rage is one of the leading brand for women's in India offer online shopping for ladies cardigans, long coats, woolen kurtis, western dresses, designer tops, capes, tunics, stoles & stylish ponchos. Show online now!";
        $showPoup = $this->checkVistor();
		$new_arrival_winter_collection_products = Product::with(['attributes','productimages','category'])->where(['status'=>1,'new_arrival'=>'yes'])->orderby('id','DESC')->skip(0)->take(10)->get();
		$new_arrival_summer_collection_products = []; /* Product::with(['attributes','productimages','category'])->where(['status'=>1,'new_arrival'=>'yes'])->wherein('category_id',[6,7,8])->orderby('id','DESC')->skip(0)->take(10)->get(); */
		
    	//echo "<pre>"; print_r($best_seller_products); exit;
		return view('front.index-demo')->with(compact('catseo','title','metakeywords','metadescription','new_arrival_winter_collection_products','new_arrival_summer_collection_products'));
    }
	
   
   public function indexx(){ 
	    $catseo = 'indexx';
    	$title="Winter Dresses  Online - Buy Women Kurtis, Cardigans, Knitted Tops, Kaftans, Sweaters, Jackets, Coats, Stoles, Capes & Ponchos | Rage";
    	$metakeywords ="women jackets, women cardigans, women sweaters, women capes, women ponchos, ladies kurtis, woolen kurtis, women winter clothing, women clothing online, knitted tops";
    	$metadescription="Discover wide range of women cardigans, coats, jackets, knitted tops, kurtis, sweaters & ponchos. Rage is one of the leading brand for women's in India offer online shopping for ladies cardigans, long coats, woolen kurtis, western dresses, designer tops, capes, tunics, stoles & stylish ponchos. Show online now!";
        $showPoup = '';
		$new_arrival_products = Product::with('attributes')->where(['status'=>1,'new_arrival'=>'yes'])->orderby('id','DESC')->skip(0)->take(10)->get();
		$best_seller_products = Product::with('attributes')->where(['status'=>1,'best_seller'=>'yes'])->orderby('id','DESC')->get();
    	return view('front.indexx')->with(compact('catseo','title','metakeywords','metadescription','new_arrival_products','best_seller_products'));
    }
   
    public function checkVistor() {
        //Check User IP
        $ip = \Request::ip();
        $checkVisitor = Visitor::where('user_ip',$ip)->first();
        if(!$checkVisitor){
            $visitor = new Visitor;
            $visitor->user_ip  = $ip;
            $visitor->visit_date = date('Y-m-d');
            $visitor->save();
            $showPoup = true;
        }else{
            $date1 = $checkVisitor->visit_date;
            $date2 = date('Y-m-d');
            $diff = strtotime($date2) - strtotime($date1); 
            $diff =  abs(round($diff / 86400));
            if($diff >7){
                $showPoup = true;
                $visitor = Visitor::find($checkVisitor->id);
                $visitor->visit_date = date('Y-m-d');
                $visitor->save();
            }else{
                $showPoup = false;
            }
        }
        return $showPoup;
    }
    public function aboutus(){
		$title="Home";
    	$metakeywords ="";
    	$catseo = 'about-us';
    	$metadescription="";
    	$static_page="About Us";
		return view('front.cms.about-us')->with(compact('catseo','title','metakeywords','metadescription','static_page'));
	}
	public function faq(){
		$title="Faq";
    	$metakeywords ="";
    	$catseo = 'faq';
    	$metadescription="";
		return view('front.cms.faq')->with(compact('catseo','title','metakeywords','metadescription'));
	}
	
	public function lookbook(){
		$title="Lookbook";
    	$metakeywords ="";
    	$catseo ='lookbook';
    	$metadescription="";
    	$static_page="Lookbook";
		return view('front.lookbook')->with(compact('catseo','title','metakeywords','metadescription','static_page'));
	}
	
	public function sitemap(){
		$title="Sitemap";
    	$metakeywords ="";
    	$catseo ='sitemap';
    	$static_page ='Sitemap';
    	$metadescription="";
		return view('front.sitemap')->with(compact('catseo','title','metakeywords','metadescription','static_page'));
	}
	
	
    public function autoComplete(Request $request){
        if($request->ajax()){
            $query = $request->get('term','');
            $products=Product::where('product_name','LIKE','%'.$query.'%')->where('status',1)->get();
            $data = array();
            $productids = array();
            foreach ($products as $product) {
                $productslug = $product->seo_url;
                $data[]=array('slug'=>$productslug,'value'=>$product->product_name);
            }
            return $data;
        }else{
            return redirect()->action('IndexController@index');
        }
    }

    public function addSubscriber(Request $request){
        if($request->ajax()){
            $data = $request->all();
            $validator = Validator::make($request->all(), [
                    'email' => 'bail|required|email|regex:/^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i'
                ],
                ['email.regex'=>'This email is not a valid email address']
            );
            if($validator->passes()) {
                $check = Subscriber::where('email',$data['email'])->count();
                if($check == 0){
                    $subscriber = new Subscriber;
                    $subscriber->email = $data['email'];
                    if(isset($data['type'])){
                        $subscriber->type = $data['type'];
                    }
                    $subscriber->save();
                    if(env('MAIL_MODE') =="live"){
                        $email = $data['email'];  
                        $messageData = [];
                        Mail::send('emails.newsletter-subscribe', $messageData, function($message) use ($email){
                            $message->to($email)->subject('Welcome to '.config('constants.project_name'));
                        });
                    }
                    return response()->json(['status'=>true,'message'=>'Thank you! We are delighted that you have signed up to receive our emails.']);
                }else{
                    return response()->json(['status'=>false,'type'=>'validation','errors'=>'This email is already in our subscription list']);
                }
            }else{
                return response()->json(['status'=>false,'type'=>'validation','errors'=>'Enter the valid email address']);
            }
            echo "<pre>"; print_r($data); die;
        }
    }

    public function staticpages(){
        $currentPath= Route::getFacadeRoot()->current()->uri();
        $availableRoutes = CmsPage::Where('status',1)->get()->pluck('slug')->toArray();
        if(in_array($currentPath,$availableRoutes)){
            $details = CmsPage::where('slug',$currentPath)->first();
            $title = $details->meta_title;
            $metakeywords = $details->meta_keywords;
            $metadescription = $details->meta_description;
			if($details['id'] != '8'){
				 return view('front.cms.cms')->with(compact('title','details','metakeywords','metadescription'));
			}else{
				 $faqdata = 	 DB::select('select * from faq_page_contents order by `position` asc');
			//echo "<pre>";print_r($faqdata); exit; 
				 return view('front.cms.faq')->with(compact('title','details','metakeywords','metadescription','faqdata'));
			}
           
        }else{
            abort(404);
        }
    }

    public function contactus(){
        $title ="Contact Us";
        $catseo ='contact-us';
        $static_page ='Contact Us';
        return view('front.cms.contact-us')->with(compact('title','catseo','static_page'));
    }
	  public function feedback(){
        $title ="Feedback";
        $catseo ='feedback';
        $static_page='feedback';
        return view('front.cms.feedback')->with(compact('title','catseo','static_page'));
    }
    public function abort(){
		$title ="Page Not found";
        $catseo ='404';
        return view('errors.404')->with(compact('title','catseo')); 
    }
    public function saveContact(Request $request){
		
		 
		
        if($request->ajax()){
			$validation_data = $request->all();
	 	   $validation_data['name'] = CustomFunction::charactersOnly( $validation_data['name']);
		
            $validator = Validator::make($validation_data, [
                    'name' =>  'required|regex:/^[a-zA-Z]+$/u|max:255',
                    'email' => 'required|string|regex:/^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i|max:255',
					'mobile'=>'required|numeric',
                    'message' => 'bail|required'
                ],
                [
                    'email.regex'=>'This email is not a valid email address'
                ]);
            if($validator->passes()) {
                
				
				
				$recaptchaResponse = $request->input('g-recaptcha-response');

				// Google's reCAPTCHA secret key
				$secretKey = env('RECAPTCHA_SECRET_KEY');  // Replace with your actual secret key

				// Make the request to verify the reCAPTCHA token using file_get_contents
				$response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret={$secretKey}&response={$recaptchaResponse}");

				// Decode the JSON response
				$responseData = json_decode($response, true);

				$responseData['success'] = true;

				// Check if reCAPTCHA validation was successful
				if ($responseData['success']) {
						$data = $request->all(); 
						//save Contact
						$contact = new Contact;
						$contact->name = $data['name']; 
						$contact->email = $data['email']; 
						$contact->country_code = $data['country_code'];
						$contact->country = $data['country'];
						$contact->state = @$data['state'];
						$contact->city = @$data['city'];
						$contact->mobile = $data['mobile'];
						$contact->message = $data['message']; 
						$contact->save();
						if(env('MAIL_MODE') =="live"){
							$emails = array('info@rageonline.com'); 
							$messageData = [
								'data' => $contact
							];
							   $admin_mail =   config('constants.admin_mail');
								foreach($admin_mail as $email){
										Mail::send('emails.contact-email', $messageData, function($message) use ($email){
											$message->to($email)->subject('Contact Us Information Received');
										});
								}
						}
						$redirectTo = url('contact-us?s');
						return response()->json(['status'=>true,'message'=>'ok','url'=>$redirectTo]);
				
				
				
				} else {
					return response()->json(['status'=>false,'type'=>'validation','errors'=>[]]);
				}
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
				
            }else{
                return response()->json(['status'=>false,'type'=>'validation','errors'=>$validator->messages()]);
            }
        }
    }
    
	public function saveFeedback(Request $request){
		 $validation_data = $request->all();
	 	 $validation_data['name'] = CustomFunction::charactersOnly( $validation_data['name']);
        if($request->ajax()){
            $validator = Validator::make($validation_data, [
                    'name' => 'required|regex:/^[a-zA-Z]+$/u|max:255',
                    'email' => 'required|string|regex:/^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i|max:255',
					'mobile'=>'required|numeric|digits:10',
                    'message' => 'bail|required'
                ],
                [
                    'email.regex'=>'This email is not a valid email address'
                ]);
            if($validator->passes()) {
                $data = $request->all();
                //save Contact
                $feedback = new Feedback;
                $feedback->name = $data['name']; 
                $feedback->email = $data['email']; 
                $feedback->mobile = $data['mobile'];
                $feedback->message = $data['message']; 
                $feedback->save();
                if(env('MAIL_MODE') =="live"){
                    $emails = 'info@rageonline.co.in'; 
                    $messageData = [
                        'data' => $feedback
                    ];
					
					
					$admin_mail =   config('constants.admin_mail');
						    foreach($admin_mail as $email){
							Mail::send('emails.feedback', $messageData, function($message) use ($email){
								$message->to($email)->subject('Feedback Information has been Received');
							});
				   }
					
                }
                $redirectTo = url('feedback?s');
                return response()->json(['status'=>true,'message'=>'ok','url'=>$redirectTo]);
            }else{
                return response()->json(['status'=>false,'type'=>'validation','errors'=>$validator->messages()]);
            }
        }
    }
    
   public function franchiseEnquiry(){ 
        $title ="Franchise Enquiry";
        $catseo ='franchise-enquiry';
        $static_page ='Franchise Enquiry';
        return view('front.cms.franchise-enquiry')->with(compact('title','catseo','static_page'));
    }
	 public function SavefranchiseEnquiry(Request $request){
         $validation_data = $request->all();
	 	 $validation_data['name_of_party'] = CustomFunction::charactersOnly( $validation_data['name_of_party']);
	 	 $validation_data['city_of_party'] = CustomFunction::charactersOnly( $validation_data['city_of_party']);
	 	 $validation_data['father_name'] = CustomFunction::charactersOnly( $validation_data['father_name']);
	 	 $validation_data['prop'] = CustomFunction::charactersOnly( $validation_data['prop']);
        if($request->ajax()){
            $validator = Validator::make($validation_data, [
                    'name_of_party' => 'required|regex:/^[a-zA-Z]+$/u|max:255',
                    'address_of_party' => 'required|string|max:255',
                    'city_of_party' => 'required|regex:/^[a-zA-Z]+$/u|max:255',
                    'phone_of_party' => 'required|numeric|digits:10',
					'prop' => 'required|regex:/^[a-zA-Z]+$/u|max:255',
					'father_name' => 'required|regex:/^[a-zA-Z]+$/u|max:255',
					'res_address' => 'required|string|max:255',
					'phone' => 'required|numeric|digits:10',
					'mobile' => 'required|numeric|digits:10',
					'email' => 'required|string|regex:/^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i|max:255',
					'showroom_name' => 'required|string|max:255',
					'showroom_address' => 'required|string|max:255',
					'showroom_phone' => 'required|numeric|digits:10',
					'floor1' => 'required|numeric',
					'frontage' => 'required|numeric',
					'depth' => 'required|numeric',
					'area' => 'required|numeric',
					'competitor' => 'required|string|max:255',
					'mode_of_operation' => 'required|string|max:255',
                ],
                [
                    'email.regex'=>'This email is not a valid email address',
                    'floor1.required'=>'The floor field is required',
                    'floor1.numeric'=>'The floor must be a number.',
                    'phone.required'=>'Phone number must be 10 digits',
                    'phone.numeric'=>'Phone number must be 10 digits',
                    'phone.digits'=>'Phone number must be 10 digits',
					'showroom_phone.required'=>'Phone number must be 10 digits',
                    'showroom_phone.numeric'=>'Phone number must be 10 digits',
                    'showroom_phone.digits'=>'Phone number must be 10 digits',
					'phone_of_party.required'=>'Phone number must be 10 digits',
                    'phone_of_party.numeric'=>'Phone number must be 10 digits',
                    'phone_of_party.digits'=>'Phone number must be 10 digits',
                ]);
            if($validator->passes()) {
                $data = $request->all();
                //save Contact
                $franchiseenquiry = new FranchiseEnquiry;
                $franchiseenquiry->name_of_party = $data['name_of_party']; 
                $franchiseenquiry->address_of_party = $data['address_of_party']; 
                $franchiseenquiry->city_of_party = $data['city_of_party']; 
                $franchiseenquiry->phone_of_party = $data['phone_of_party'];
                $franchiseenquiry->prop = $data['prop']; 
                $franchiseenquiry->father_name = $data['father_name']; 
                $franchiseenquiry->res_address = $data['res_address']; 
                $franchiseenquiry->mobile = $data['mobile']; 
                $franchiseenquiry->phone = $data['phone']; 
                $franchiseenquiry->email = $data['email']; 
                $franchiseenquiry->showroom_name = $data['showroom_name']; 
                $franchiseenquiry->showroom_address = $data['showroom_address']; 
                $franchiseenquiry->showroom_phone = $data['showroom_phone']; 
                $franchiseenquiry->floor1 = $data['floor1']; 
                $franchiseenquiry->frontage = $data['frontage']; 
                $franchiseenquiry->depth = $data['depth']; 
                $franchiseenquiry->area = $data['area']; 
                $franchiseenquiry->profile1 = $data['profile1']; 
                $franchiseenquiry->profile2 = $data['profile2']; 
                $franchiseenquiry->competitor = $data['competitor']; 
                $franchiseenquiry->mode_of_operation = $data['mode_of_operation']; 
                $franchiseenquiry->save();
                if(env('MAIL_MODE') =="live"){
                    $emails = 'info@rageonline.co.in'; 
                    $messageData = [
                        'data' => $data
                    ];
					
					$admin_mail =   config('constants.admin_mail');
						foreach($admin_mail as $email){
								Mail::send('emailtemplate.to_admin.franchise-enquiry', $messageData, function($message) use ($email){
									$message->to($email)->subject('Franchise Enquiry Information has been Received');
								});
						}
					
					
					
                }
                $redirectTo = url('franchise-enquiry?s');
                return response()->json(['status'=>true,'message'=>'ok','url'=>$redirectTo]);
            }else{
                return response()->json(['status'=>false,'type'=>'validation','errors'=>$validator->messages()]);
            }
        }
    }
	
	public function storeLocator(Request $request){ 
	     $data = $request->all();
	     $catseo ='store-locator';
	     $static_page ='Store Locator';
	     $store_locations = $city_list = array();
		 $state_list = StoreLocation::groupBy('state')->orderBy('state', 'asc')->get();
		 if(isset($data['state']) && $data['state'] != ''){  
			 $city_list = StoreLocation::select('city1')->distinct()->where('state',$data['state'])->orderBy('city1', 'asc')->get();
		 }
		  if(isset($data['city']) && $data['city'] != ''){  

		          if($data['city'] == 'Ludhiana') {
		                 $store_locations = StoreLocation::where('city1',$data['city'])->where('state',$data['state'])->orderBy('position','asc')->get();
		          }else{
		                 $store_locations = StoreLocation::where('city1',$data['city'])->where('state',$data['state'])->orderBy('id','desc')->get();
		          }
			 
		 }
        $title ="Store Locator";
        return view('front.store-locator')->with(compact('catseo','title','state_list','city_list','store_locations','static_page'));
    }
	
	
    public function ourCommunity(){
        $title ="Our Community";
        $catseo ='our-community';
        return view('front.cms.our-community')->with(compact('title','catseo'));
    }

    public function sustainability(){
        $title ="Sustainability";
        $catseo ='sustainability';
        return view('front.cms.sustainability')->with(compact('title','catseo'));
    }

    public function quality(){
        $title ="Quality";
        return view('front.cms.quality')->with(compact('title'));
    }
	
	public function privacyPolicy(){
        $title ="Privacy Policy";
        $catseo ='privacy-policy';
        $static_page ='Privacy Policy';
        return view('front.privacy-policy')->with(compact('title','catseo','static_page'));
    }
	
	public function cancellationPolicy(){
        $title ="Cancellation Policy";
        $catseo ='cancellation-policy';
        $static_page ='Cancellation Policy';
        return view('front.cancellation-policy')->with(compact('title','catseo','static_page'));
    }
	public function returnandRefundpolicy(){
        $title ="Return and Refund Policy";
        $catseo ='return-and-refund-policy';
        $static_page ='Return and Refund Policy';
        return view('front.return-and-refund-policy')->with(compact('title','catseo','static_page'));
    }
	
	public function cancellationAndrefundPolicy(){
        $title ="Cancellation & Refund Policy";
        $catseo ='cancellation-and-refund-policy';
        $static_page ='cancellation-and-refund-policy';
        return view('front.cancellation-and-refund-policy')->with(compact('title','catseo','static_page'));
    }
	
	
	public function returnPolicy(){
        $title ="Return Policy";
        $catseo ='return-policy';
        $static_page ='return-policy';
        return view('front.return-policy')->with(compact('title','catseo','static_page'));
    }
	
	public function shippingPolicy(){
        $title ="Shipping Policy";
        $catseo ='shipping-policy';
        $static_page ='Shipping Policy';
        return view('front.shipping-policy')->with(compact('title','catseo','static_page'));
    }
	
	public function termsConditions(){ 
        $title ="Terms Conditions";
        $catseo ='terms-and-conditions';
        $static_page ='Terms And Conditions';
        return view('front.terms-and-conditions')->with(compact('title','catseo','static_page'));
    }
    public function trackOrder(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();
            $details = Order::where('id',$data['order_no'])->select('awb_number')->first();
            if($details && $details->awb_number !=""){
               $awbNumber =  $details->awb_number;
            }else{
                $awbNumber =  $data['order_no'];
            }
            $trackings = Order::trackOrder($awbNumber);
            $title = "Track Order";
            return view('front.track-order')->with(compact('title','trackings')); 
        }else{
            return redirect::to('/');
        }
    }
    public function savenotify(Request $request){
        if($request->ajax()){
                
				$recaptchaResponse = $request->input('g-recaptcha-response');
				if(empty($recaptchaResponse)){
				   return response()->json(['status'=>false,'message'=>'Something went to wrong please try later.']);
				} 
				
				
				/*
				$recaptchaResponse = $request->input('g-recaptcha-response');
				// Google's reCAPTCHA secret key
				$secretKey = env('RECAPTCHA_SECRET_KEY');  // Replace with your actual secret key

				// Make the request to verify the reCAPTCHA token using file_get_contents
				$response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret={$secretKey}&response={$recaptchaResponse}");

				// Decode the JSON response
				$responseData = json_decode($response, true);
  
			

				// Check if reCAPTCHA validation was successful
				if (!$responseData['success']) {
					
					return response()->json(['status'=>false,'message'=>'Something went to wrong please try later.']);
					
				}
				
					*/
				
				
				
				$data = $request->all();
                $notify = new Notifies;
                $notify->notifysize = $data['notifysize']; 
                $notify->notifycode = $data['notifycode'];
                $notify->name = $data['name']; 
                $notify->email = $data['email']; 
                $notify->mobile = $data['mobile']; 
                $notify->save();
                if(env('MAIL_MODE') =="live"){
                    $emails = array('info@rageonline.co.in'); //
                    $messageData = [
                        'data' => $data
                    ];                    
                    Mail::send('emails.notifyme', $messageData, function($message) use ($emails){
                        $message->to($emails)->subject('Product notification');
                    });
                }
                return response()->json(['status'=>true,'message'=>'ok']);
        }
    }  



    public function saveReview(Request $request){
		
		 
		
        if($request->ajax()){
			$validation_data = $request->all();
            $validator = Validator::make($validation_data, [
                    'rating' =>  'required',
                    'review_title' =>  'required',
                    'review_content' =>  'required',
                    'display_name' =>  'required',
                    'email' => 'required|string|regex:/^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i|max:255',
                ],
                [
                    'rating.required'=>'Select the rating',
                    'review_title.required'=>'Enter the review title',
                    'review_content.required'=>'Enter the review content',
                    'display_name.required'=>'Enter the display name',
                    'email.required'=>'Enter the email address',
                    'email.regex'=>'Enter the a valid email address'
                ]);
            if($validator->passes()) {
                $data = $request->all();
                //save ProductReview
                $product_review = new ProductReview;
                $product_review->product_id = $data['product_id']; 
				if(Auth::check()){
                    $product_review->user_id = Auth::user()->id;
				}
                $product_review->rating = $data['rating']; 
                $product_review->review_title = $data['review_title']; 
                $product_review->review_content = $data['review_content']; 
                $product_review->display_name = $data['display_name']; 
                $product_review->email = $data['email']; 
				
				
				$fileNames = '';
							if ($request->hasFile('file')) {
								
								$files = $request->file('file');
								foreach($files  as $file){
									$filename = $file->getClientOriginalName();
									$extension = $file->getClientOriginalExtension();
									$extension_array = array("jpg","jpeg","png","JPG","JPEG","PNG");
									if (in_array($extension, $extension_array)){
										$fileName = "review-".Str::random(10).".".$extension;
										$destinationPath = 'images/ProductImages/review'.'/';
										$file->move($destinationPath, $fileName);
										
										if($fileNames == ''){
											$fileNames = $fileName;
										}else{
											$fileNames .= ','.$fileName;
										}
									}
								}
							}
				
				
				
				
				
				
				$product_review->images = $fileNames; 
                $product_review->save();
               /* if(env('MAIL_MODE') =="live"){
                    $emails = array('info@rageonline.com'); 
                    $messageData = [
                        'data' => $contact
                    ];
					   $admin_mail =   config('constants.admin_mail');
						foreach($admin_mail as $email){
								Mail::send('emails.contact-email', $messageData, function($message) use ($email){
									$message->to($email)->subject('Contact Us Information Received');
								});
						}
                } */
                return response()->json(['status'=>true,'message'=>'Thank you for your feedback! We’ll take it into account as we continue to improve.']);
            }else{
                return response()->json(['status'=>false,'type'=>'validation','errors'=>$validator->messages()]);
            }
        }
    }
    
  

  public function get_state_city(Request $request){
		 if($request->ajax()){
			 $data = $request->all();
			 $country = $data['country'];
			 
			 if($data['action'] == '1'){
				 $html = get_state_options($country);
			 }else if($data['action'] == '2'){
				 $state = $data['state'];
				 $html = get_city_options($state);
			 }
		 
		     echo $html;
		 }
  }
		 
		
     		
    public function testform(Request $request){ 



          if($request->isMethod('post')){
           
            $msg =  'reCAPTCHA was successful, proceed with form processing'; 
				return response()->json(['status'=>true,'message'=>$msg]);
			
			$recaptchaResponse = $request->input('g-recaptcha-response');

			// Google's reCAPTCHA secret key
			$secretKey = env('RECAPTCHA_SECRET_KEY');  // Replace with your actual secret key

			// Make the request to verify the reCAPTCHA token using file_get_contents
			$response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret={$secretKey}&response={$recaptchaResponse}");

			// Decode the JSON response
			$responseData = json_decode($response, true);

			

			// Check if reCAPTCHA validation was successful
			if ($responseData['success']) {
				$msg =  'reCAPTCHA was successful, proceed with form processing'; 
				return response()->json(['status'=>true,'message'=>$msg]);
				// Handle the form submission logic
			} else {
				// reCAPTCHA failed, handle the error
				echo('error - Please complete the reCAPTCHA.');
			}
					
			
			
			
			
			
			
        }else{
			$title = "Track Order";
            return view('front.test_form')->with(compact('title')); 
        }



	}	
	  
	
}		
