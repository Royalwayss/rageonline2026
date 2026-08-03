<?php

namespace App\Http\Controllers\Front;

use Illuminate\Support\Str;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\User;
use App\Order;
use Illuminate\Support\Facades\Validator;
use App\Cart;
use Session;
use Redirect;
use Illuminate\Support\Facades\Mail;
use DB;
use Image;
use Hash;
use App\ProductAttribute;
use App\Wishlist;
use App\ShippingAddress;
use App\BillingAddress;
use App\Wholesaleenquiry;
use Illuminate\Support\Facades\View;
use App\ReturnRequest;
use App\OrderProduct;
use App\ExchangeRequest;
use App\State;
use App\Pincodelist;
use App\Pincode;
use App\CustomFunction;
use PDF;
use Cookie;

class CustomerController extends Controller
{
    //
    public function __construct(ShippingAddress $shippingAddr){
        $this->shippingAddr = $shippingAddr;
    }

    public function login(Request $request){  
	   
	   $data = $request->all(); 
	   //if(isset($data['whislist'])){
		   // Session::put('previousurl',"/account/wishlists");
	   //}
	
        if($request->ajax()){
            $validator = Validator::make($request->all(), [
	                'email' => 'bail|required|email|regex:/^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i',
	                'password' => 'bail|required',
            	],
            	['email.regex'=>'This email is not a valid email address']
        	);
            if($validator->passes()) {
                $data = $request->all(); 
                if(Auth::check()){
                    return response()->json(['status'=>false,'type'=>'normal','errors'=>"We are sorry! Multiple Login not allowed."]);
                }else{
                    if(Auth::attempt(['email' => $data['email'], 'password' => $data['password']])){
                        if(Auth::user()->status ==0){
                            Auth::logout();
                            return response()->json(['status'=>false,'type'=>'normal','errors'=>"Your account is deactivated by system administrator"]);
                        }
                        $this->updatingCartSessionToUser();
                        if(Session::has('previousurl')){
                            $redirectTo = Session::get('previousurl');
                            Session::forget('previousurl');
                        }else{
							
                            if(isset($data['redirect']) && !empty($data['redirect'])){
                                $redirectTo = url('/cart');
                            }else{
                                $redirectTo = url('/');
                            }
                        }
						User::where('id',Auth::user()->id)->update(['user_accound_status'=>'1']);
                        return response()->json(['status'=>true,'message'=>'Login successfully. It will automatically redirected','url'=>$redirectTo]);
                    }else{
                        return response()->json(['status'=>false,'type'=>'normal','errors'=>"You have entered wrong email or password!"]);
                    }
                }
            }else{
                return response()->json(['status'=>false,'type'=>'validation','errors'=>$validator->messages()]);
            }
        }else{
			 if(Auth::check()){
				 return redirect::to('/');
			 }else{
				$title = 'Login';
				$catseo = 'login';
				return view('front.login')->with(compact('title','catseo'));
			 }
        }
    }
	
	public function check_register(Request $request){
		if($request->ajax()){
			$validation_data = $request->all(); 
	 	    $validation_data['name'] = CustomFunction::charactersOnly( $validation_data['name']);
		
            $validator = Validator::make($validation_data, [
                    'name' => 'required|regex:/^[a-zA-Z]+$/u|max:255',
                    'mobile'=>'required|numeric|digits:10',
                    'email' => 'required|string|regex:/^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i|max:255|unique:users',
                    'password' => 'required|string|min:6',
                    /*'password_confirmation' => 'required|string|min:6',*/
                ],
                [
                    'email.regex'=>'This email is not a valid email address'
                ]);
				
			    if($validator->passes()) {
					    return response()->json(['status'=>true]);
				}else{
					    return response()->json(['status'=>false,'type'=>'validation','errors'=>$validator->messages()]);
				}
				
				
		}
	}
	
	
	
	

    public function register(Request $request){
        if($request->ajax()){
			
			
			
			
			   $recaptchaResponse = $request->input('g-recaptcha-response');
                
				/*
				
				// Google's reCAPTCHA secret key
				$secretKey = env('RECAPTCHA_SECRET_KEY');  // Replace with your actual secret key

				// Make the request to verify the reCAPTCHA token using file_get_contents
				$response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret={$secretKey}&response={$recaptchaResponse}");

				// Decode the JSON response
				$responseData = json_decode($response, true);
  
				

				// Check if reCAPTCHA validation was successful
				if (!$responseData['success']) {
					
					return response()->json(['status'=>false,'message'=>'Something went wrong, please try again later.']);
					
				}
			 */
			
			if(empty($recaptchaResponse)) {
					
					return response()->json(['status'=>false,'message'=>'Something went wrong, please try again later.']);
					
				}
			
			$validation_data = $request->all(); 
	 	    $validation_data['name'] = CustomFunction::charactersOnly( $validation_data['name']);
		
            $validator = Validator::make($validation_data, [
                    'name' => 'required|regex:/^[a-zA-Z]+$/u|max:255',
                    'mobile'=>'required|numeric|digits:10',
                    'email' => 'required|string|regex:/^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i|max:255|unique:users',
                    'password' => 'required|string|min:6',
                    /*'password_confirmation' => 'required|string|min:6',*/
                ],
                [
                    'email.regex'=>'This email is not a valid email address'
                ]);
            if($validator->passes()) {
                $data = $request->all();
				$password = $data['password'];
                $data['country'] ='India';
                $data['status'] =1;
                $data['password'] = bcrypt($data['password']);
                $data['name'] = $data['name'];
				
				 if($data['dob'] != ''){
					     $birth_date = str_replace("/","-",$data['dob']);
					     $dob = date("Y-m-d", strtotime($birth_date));  
				}else{
					   $dob = '';
				} 
		
                $data['dob'] = $dob;
                User::create($data);
                if(Auth::guard('web')->attempt($request->only('email','password'))) {
                    $this->updatingCartSessionToUser();
                    $smsdetails['mobile']  = $data['mobile'];
                    $smsdetails['message'] = "Dear ".$data['name']. ", you have been successfully registered with ".config('constants.project_name').". Login to your account to access order, address & available offers information";
                   // sendSms($smsdetails);
                    $redirectTo = url('/');
                    if(env('MAIL_MODE') =="live"){
                        $email = Auth::user()->email;
						
                        $userdetails['email'] =  $email;
                        $userdetails['password'] =  $password;
						
                        $messageData = [
                            'userdetails' => $userdetails
                        ];
						
                        Mail::send('emailtemplate.to_user.user-register', $messageData, function($message) use ($email){
                            $message->to($email)->subject('Registration with '.config('constants.project_name'))->getSwiftMessage()->getHeaders();
                        });
						$admin_mail =   config('constants.admin_mail');
						foreach($admin_mail as $email){
							Mail::send('emailtemplate.to_admin.user-register', $messageData, function($message) use ($email){
								$message->to($email)->subject('Registration with '.config('constants.project_name'))->getSwiftMessage()->getHeaders();
							});	
						}						
                    }
                    if(Session::has('previousurl')){
                        $redirectTo = Session::get('previousurl');
                        Session::forget('previousurl');
                    }else{
                     
                        $redirectTo = url('/');
                    }
                }
				Session::put('CompleteRegistration','1');
                return response()->json(['status'=>true,'message'=>'Registered successfully. It will automatically redirected','url'=>$redirectTo]);
            }else{
                return response()->json(['status'=>false,'type'=>'validation','errors'=>$validator->messages()]);
            }
        }else{
            return redirect::to('/');
        }
    }
    
    public function genreate_otp(Request $request){
		$validator = Validator::make($request->all(), [  
                   'new_email' => 'required|email|unique:users,email'
                    
                ],
                [
                    'new_email.regex' =>'This email is not a valid email address'
                ]);
				
				if($validator->passes()) {
					$otp = mt_rand(100000, 999999);
					User::where('id', Auth::user()->id)->update(['otp'=>$otp]);
					if(env('MAIL_MODE') =="live"){
					    $email = $request->new_email;
                        $userdetails = Auth::user();
                        $messageData = [
                            'email' => $email,
                            'otp' => $otp,
                            'name' => $userdetails->name,
                        ];
						
                       Mail::send('emails.email-update', $messageData, function($message) use ($email){
                            $message->to($email)->subject('Otp from '.config('constants.project_name'))->getSwiftMessage()->getHeaders();
                        }); 
					
					}
					
					return response()->json(['status'=>1,'message'=>'<h5>Otp sent to your emil address</h5>']);
				}else{
					return response()->json(['status'=>false,'type'=>'validation','errors'=>$validator->messages()]);
				}
		
	}
	
	public function update_email(Request $request){
		$validator = Validator::make($request->all(), [  
                   'new_email' => 'required|email|unique:users,email,'.Auth::user()->id,
                   'otp' => 'required',
                    
                ],
                [
                    'new_email.regex' =>'This email is not a valid email address'
                ]);
				
				if($validator->passes()) {
					
					$data = $request->all();
					
					$data = User::where('otp',$data['otp'])->where('id',Auth::user()->id)->first();
					if(!empty($data)){
					
					  User::where('id', Auth::user()->id)->update(['email'=>$request->new_email]); 
					  return response()->json(['status'=>true,'type'=>'','message'=>'<h5>Email updated successfully<h5>','new_email'=>$request->new_email]);	
					}else{
					   return response()->json(['status'=>true,'type'=>'otp','message'=>'<h5>Invalid Otp number<h5>']);	
					}
				}else{
					return response()->json(['status'=>false,'type'=>'validation','errors'=>$validator->messages()]);
				}
		
	}
   
    public function wholesale_enquiry(Request $request){
	   if($request->ajax()){
		   
                $validator = Validator::make($request->all(), [
                    'Name'=>'bail|required',
                    'Email'=>'email|required',
                    'Mobile'=>'required|numeric|digits:10',
                    'City'=>'bail|required',
                    'Message'=>'bail|required',
                ],
                [
                    'Email.regex' =>'This email is not a valid email address'
                ]);
                if($validator->passes()) {
					$data = $request->all(); 
					$enquiry = new Wholesaleenquiry;
					$enquiry->name = $data['Name'];
					$enquiry->email = $data['Email'];
					$enquiry->mobile = $data['Mobile'];
					$enquiry->city = $data['City'];
					$enquiry->message = $data['Message'];
					$enquiry->save();
					if(env('MAIL_MODE') =="live"){
                        $email = 'info@rageonline.co.in';
                         $data = [
                            'Name' => $data['Name'],
                            'Email' => $data['Email'],
                            'Mobile' => $data['Mobile'],
                            'City' => $data['City'],
                            'Message' => $data['Message']
                        ];
						
						
						
                        Mail::send('emails.wholesale-enquiry', $data, function($message) use ($email){
                                $message->to($email)->subject('Wholesale Enquiry');
                        });
                    }
                     return response()->json(['status'=>true,'message'=>'<h5>Thank you for contacting us – we will get back to you soon!<h5>']);
                   
                }else{
                    return response()->json(['status'=>false,'type'=>'validation','errors'=>$validator->messages()]);
                }
            }
       
   }



    public function updatingCartSessionToUser(){
        if(Session::has('cartsessionId')){
            Cart::where('session_id',Session::get('cartsessionId'))->update(['user_id'=>Auth::user()->id,'session_id'=>'']);
            DB::select("DELETE FROM carts WHERE id NOT IN (SELECT * FROM (SELECT MAX(n.id) FROM carts n GROUP BY n.product_id,n.size) x) and user_id = ".Auth::user()->id."");
        }
        $mesage = "success";
        return $mesage;
    }

    public function account($slug=null){
		Session::put('previousurl',"/account/wishlists"); 
        $blueDartTracking ='';
        $awb = 0; $catseo = ''; $page = '';
        $accountSlugs = array('orders','settings','dashboard','wishlists','address');
        $orders = array();$orderDetails= array(); $address = array();
        if(in_array($slug,$accountSlugs)){
            if($slug=="orders"){
                if(isset($_GET['order_id']) && !empty($_GET['order_id'])){
                    $title ="Order Details";
                    $orderDetails = Order::withCount(['order_products as total_items'=>function($query){
                        $query->select(DB::raw('sum(product_qty)'));
                    }])->with(['order_products','order_address'])->where(['user_id'=>Auth::user()->id,'id'=>$_GET['order_id']])->first();
                    
                    $getawb_Order = Order::where('id',$_GET['order_id'])->where('user_id',Auth::user()->id)->first();

                    if($getawb_Order->awb_number!=''){
                        $awb = 1;
                        $ship_details = $this->order_tracking_status($getawb_Order->awb_number);
                        $result = json_decode($ship_details,TRUE);
                        $i = 0;
                        $tracking = [];
                            if(isset($result['Shipment']['Scans'])) {
                            			
                    			foreach($result['Shipment']['Scans']['ScanDetail'] as $key => $value) {
                    				
                    				if($value['Scan'] == 'SHIPMENT DELIVERED') {
                    					$tracking['delivered'] = $result['Shipment']['Scans']['ScanDetail'][$key];
                    					$tracking['message'][] = $result['Shipment']['Scans']['ScanDetail'][$key];
                    				}
                    				
                    				if($value['Scan'] == 'SHIPMENT OUT FOR DELIVERY') {
                    					$tracking['out_of_delivered'] = $result['Shipment']['Scans']['ScanDetail'][$key];
                    					$tracking['message'][] = $result['Shipment']['Scans']['ScanDetail'][$key];
                    				}
                    				
                    				if($value['Scan'] == 'SHIPMENT ARRIVED') {
                    					$tracking['arrived'][$i] = $result['Shipment']['Scans']['ScanDetail'][$key];
                    					$tracking['message'][] = $result['Shipment']['Scans']['ScanDetail'][$key];
                    					$i++;
                    				}
                    				
                    			}
                    			
                    			$tracking['arrived'] = array_slice($tracking['arrived'], -3, 3, true);
                            			
                            }                        

                        $blueDartTracking = $tracking;
                    }
                    
                    if(!$orderDetails){
                        return redirect('account/orders');
                    }
                }else{
                    $title ="Orders";
                    $orders = Order::with('order_products','order_address')->where('user_id',Auth::user()->id)->where('order_status','!=','Cancelled by User')->orderby('id','DESC')->get();
                    $catseo = 'orders';
				}
            }elseif($slug=="settings"){
                $title="Change Password";
				$catseo = 'setting';
            }
            elseif($slug=="dashboard"){
                $title="Dashboard";
				$catseo = 'dashboard';
            }elseif($slug=="wishlists"){
                $wishlists =Wishlist::wishlists();
                $title="Wishlist";
				$catseo = 'wishlist';
				$page = 'wishlist';
			}elseif($slug=="address"){
				$address['shipping'] = ShippingAddress::where('user_id',Auth::user()->id)->first();
				$address['billing'] = BillingAddress::where('user_id',Auth::user()->id)->first();
				$catseo = 'address';
			}
            $title="Dashboard";
             $wishlists =Wishlist::wishlists();
            $states = State::orderby('name','ASC')->pluck('name')->toArray();
           // echo "<pre>"; print_r($orderDetails); exit;
            return view('front.account.account')->with(compact('title','catseo','orders','slug','orderDetails','wishlists','address','states','blueDartTracking','awb','page'));
        }else{
            abort(404);
        }
    }
	
	public function orderview($id){
		$title='Order View';
		$order = Order::withCount(['order_products as total_items'=>function($query){
                $query->select(DB::raw('sum(product_qty)'));
            }])->with(['order_address','getuser','order_products'])->where('user_id',Auth::user()->id)->where('id',$id)->firstorfail();
	    return view('front.account.order-view')->with(compact('title','order'));
	}
	
    public function order_invoice_print(Request $request,$id){
		
		$orderDetails = Order::withCount(['order_products as total_items'=>function($query){
                $query->select(DB::raw('sum(product_qty)'));
            }])->with(['order_address','getuser','order_products'])->where('user_id',Auth::user()->id)->where('id',$id)->first();
        //$orderDetails = Order::with(['order_products','order_address'])->where('id',$id)->first();
		//$orderDetails = json_decode(json_encode($orderDetails),true);
        $title="Invoice";
        $numberWords =  convert_number_to_words($orderDetails['grand_total']);
		$site_logo = '';
		//echo "<pre>"; print_r($orderDetails); exit; 
		/*
		$path = public_path('images/logo.png');
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        $site_logo = '';//'data:image/' . $type . ';base64,' . base64_encode($data);
		*/
		//return view('front.account.order-invoice')->with(compact('title','orderDetails','numberWords','site_logo'));
		$pdf    = PDF::setOptions([
            'images' => true
        ])->loadView('front.account.order-invoice', compact('title','orderDetails','numberWords','site_logo'))->setPaper('a4', 'portrait');
         return $pdf->download('Order-'.$id.'.pdf');
	}
    public function changePassword(Request $request){
        if($request->ajax()){
            $data = $request->all();
            $validator = Validator::make($request->all(), [
                    'current_password' => 'required',
                    'password' => 'required|min:6|confirmed',
                    'password_confirmation' => 'required|min:6',
                ]
            );
            if($validator->passes()) {
                $password = $data['current_password'];
                $check_password = DB::table('users')
                       ->where('id',Auth::user()->id)
                        ->select('id','password')
                       ->first();
                if(Hash::check($password, $check_password->password)) {
                    $user = User::find(Auth::user()->id);
                    $user->password = bcrypt($data['password']);
                    $user->save();
                    return response()->json(['status'=>true,'message'=>array('Password has been updated successfully')]);
                }else{
                    return response()->json(['status'=>false,'errors'=>array('current_password'=>'Your current password is incorrect')]);
                }
            }else{
                return response()->json(['status'=>false,'type'=>'validation','errors'=>$validator->messages()]);
            }
        } 
    }

    public function submitAcountDetails(Request $request){
        if($request->ajax()){
            $data = $request->all();
            $validation_data = $request->all();
	 	    $validation_data['name'] = CustomFunction::charactersOnly( $validation_data['name']);
            $validator = Validator::make($validation_data, [
                    'name' => 'required|regex:/^[a-zA-Z]+$/u|max:255',
                    'mobile' => 'bail|required|numeric|digits:10',
                    'state' => 'bail|required',
                    'city' =>  'required|regex:/^[a-zA-Z]+$/u|max:255',
                    'postcode' => 'required|numeric|digits:6',
                    'address' => 'bail|required',
                    
                ]
            );
            if($validator->passes()) {
                //Update user info
                $user = User::find(Auth::user()->id);
				$user->update($data);
				
				    $billingAddress =BillingAddress::where('user_id',Auth::user()->id)->where('is_default','yes')->first();
					if(empty($billingAddress)){
						$billingAddress = new BillingAddress; 
					}
			
						$billingAddress->user_id =Auth::user()->id;
						$billingAddress->is_default ='yes';
						$billingAddress->name = $data['name'];
						$billingAddress->first_name =$data['name'];
						$billingAddress->mobile =$data['mobile'];
						$billingAddress->alternative_number =$data['alternative_number'];
						$billingAddress->postcode =$data['postcode'];
						$billingAddress->address =$data['address'];
						$billingAddress->country ='India';
						$billingAddress->state =$data['state'];
						$billingAddress->city =$data['city'];
						$billingAddress->save();
					
				
				
                return response()->json(['status'=>true,'message'=>array('Profile has has been updated succesfully!')]);
            }else{
                return response()->json(['status'=>false,'type'=>'validation','errors'=>$validator->messages()]);
            } 
        }
    }

    public function forgotPassword(Request $request){
        if($request->ajax()){
            $data = $request->all();
            $validator = Validator::make($request->all(), [
                'email' => 'required|string|email|max:255',
            ]);
            if ($validator->passes()) {
                $userDetails = User::where('email',$data['email'])->first();
                if($userDetails){
                    $user = User::find($userDetails->id);
                    if(env('MAIL_MODE')=="live"){
                        $password = Str::random(6);
                    }else{
                        $password = "123456";
                    }
                    $user->password  = bcrypt($password);
                    $user->save();
                    if(env('MAIL_MODE') == "live"){
                        $email = $userDetails->email;
                        $messageData = [
                            'name' => $userDetails->name,
                            'user_email' => $email,
                            'password' => $password
                        ];
                        Mail::send('emails.forgot-user-password', $messageData, function($message) use ($email){
                                $message->to($email)->subject('Password Changed successfully!');
                        });
                    }
                    $messages = 'Password has been changed successfully and sent to your email.';
                    return response()->json(['status'=>true,'message'=>$messages]);
                }else{
                    $errors = array('email'=>'This email not exists in '.config('constants.project_name'));
                    return response()->json(['status'=>false,'type'=>'validation','errors'=>$errors]);
                }
            }else{
                return response()->json(['status'=>false,'type'=>'validation','errors'=>$validator->messages()]);
            }
        }else{
			
			 if(Auth::check()){
				 return redirect::to('/');
			 }else{
				$title = 'forgot-password';
				return view('front.forgot-password')->with(compact('title'));
			 }
			
			
			
            return redirect::to('/');
        }
    }

    public function saveAddress(Request $request){
        try{
            if($request->ajax()){
                if($request->company_name != '' || $request->gstin !=''){
					$validator = Validator::make($request->all(), [
						'first_name'=>'bail|required',
						'last_name'=>'bail|required',
						'mobile'=>'required|numeric|digits:10',
						'address'=>'bail|required',
						'city'=>'bail|required',
						'state'=>'bail|required',
						'postcode'=>'required|numeric|digits:6',
						'company_name'=>'bail|required'
					],
					[
						'email.regex' =>'This email is not a valid email address'
					]);
				}else{					
					$validator = Validator::make($request->all(), [
						'first_name'=>'bail|required',
						'last_name'=>'bail|required',
						'mobile'=>'required|numeric|digits:10',
						'address'=>'bail|required',
						'city'=>'bail|required',
						'state'=>'bail|required',
						'postcode'=>'required|numeric|digits:6',
					],
					[
						'email.regex' =>'This email is not a valid email address'
					]);
				}
                if($validator->passes()) {
                    $sql ="SELECT * FROM `pincodelists` WHERE `pincode` ='".$request->postcode."' and (`prepaid` = 'yes' or `cod` = 'yes') LIMIT 1";
                   $pincode_details =  DB::select($sql);
			
		        	if(empty($pincode_details)){
    					$validator->messages()->add('postcode', 'This pin code is not serviceable at all');
    					return response()->json(['status'=>false,'type'=>'validation','errors'=>$validator->messages()]);
		        	}
                    $data = $request->all();
                    unset($data['_token']);
                    $data['country'] = 'India';
                    $data['user_id'] = Auth::user()->id;
                    $data['name'] = $data['first_name']. " ".$data['last_name'];
                    $data['company_name'] = $data['company_name'];
                    $data['gstin'] = $data['gstin'];
                    if($this->shippingAddr->addresscount(Auth::user()->id) ==0){
                        $data['is_default'] = 'yes';
                        //Update Address in Users Table
                        $updateAddr['city'] = $data['city'];
                        $updateAddr['state'] = $data['state'];
                        $updateAddr['postcode'] = $data['postcode'];
                        $updateAddr['address'] = $data['address'];
                        $updateAddr['address2'] = $data['address2'];
                        $updateAddr['company_name'] = $data['company_name'];
                        $updateAddr['gstin'] = $data['gstin'];
                        if(Auth::user()->mobile ==""){
                            $updateAddr['mobile'] = $data['mobile'];
                        }
                        if(Auth::user()->first_name ==""){
                            $updateAddr['first_name'] = $data['first_name'];
                            $updateAddr['name'] = $data['name'];
                        }
                        if(Auth::user()->last_name ==""){
                            $updateAddr['last_name'] = $data['last_name'];
                        }
                        User::where('id',Auth::user()->id)->update($updateAddr);
                    }
                    if(!empty($data['shipping_id'])){
                        $shippingid = $data['shipping_id'];
                        unset($data['shipping_id']);
                        ShippingAddress::where('id',$shippingid)->update($data);
                    }else{
                        ShippingAddress::create($data);
                    }
                    return response()->json([
                        'status' => true,
                        'view' => (String)View::make('front.address.delivery-address')
                    ]);
                }else{
                    return response()->json(['status'=>false,'type'=>'validation','errors'=>$validator->messages()]);
                }
            }
        }catch(\Exception $e){
            return response()->json(exceptionMessage($e),423);
        }
    }

    public function getDeliveryAddress(Request $request){
        try{
            if($request->ajax()){
                $validator = Validator::make($request->all(), [
                    'id'=>'bail|required|exists:shipping_addresses,id',
                ]);
                if($validator->passes()) {
                    $data = $request->all();
                    $address = $this->shippingAddr->where('id',$data['id'])->first()->toArray();
                    return response()->json([
                        'status' => true,
                        'address' => $address
                    ]);
                }else{
                    return response()->json([
                        'status' => false,
                        'view' => (String)View::make('front.address.delivery-address')
                    ]);
                }
            }
        }catch(\Exception $e){
            return response()->json(exceptionMessage($e),423);
        }
    }

    public function setDefaultAddress(Request $request){
        try{
            if($request->ajax()){
                $validator = Validator::make($request->all(), [
                    'addressid'=>'bail|required|exists:shipping_addresses,id',
                ]);
                if($validator->passes()) {
                    $data = $request->all();
                    DB::beginTransaction();
                    $this->shippingAddr->where('id',$data['addressid'])->update(['is_default'=>'yes']);
                    $this->shippingAddr->where('id','!=',$data['addressid'])->where('user_id',Auth::user()->id)->update(['is_default'=>'no']);
                    DB::commit();
                }
                return response()->json([
                    'status' => true,
                    'view' => (String)View::make('front.address.delivery-address')
                ]);
            }
        }catch(\Exception $e){
            return response()->json(exceptionMessage($e),423);
        }
    }

    public function removeDeliveryAddress(Request $request){
        try{
            if($request->ajax()){
                $validator = Validator::make($request->all(), [
                    'id'=>'bail|required|exists:shipping_addresses,id',
                ]);
                if($validator->passes()) {
                    $data = $request->all();
                    $this->shippingAddr->where('id',$data['id'])->delete();
                }
                return response()->json([
                    'status' => true,
                    'view' => (String)View::make('front.address.delivery-address')
                ]);
            }
        }catch(\Exception $e){
            return response()->json(exceptionMessage($e),423);
        }
    }
	
	public function returnExchangeItem($order_id){ 
	   
	   $check = Order::check_order_return_exchange($order_id); 
	   if($check['return'] == 1 || $check['exchange'] == 1){
	            $title = 'Return Exchange Item';
				$returnOrderitems = ReturnRequest::where('order_id',$order_id)->pluck('order_product_id')->toArray(); 
				$orderDetails = Order::withCount(['order_products as total_items'=>function($query){
                            $query->select(DB::raw('sum(product_qty)'));
                        }])->with(['order_products'=>function($query) use($returnOrderitems){
                            $query->whereNotin('id',$returnOrderitems);
                        }])->where(['user_id'=>Auth::user()->id,'id'=>$order_id])->first();
                       // $orderDetails = json_decode(json_encode($orderDetails),true); 
					   $order = $orderDetails;
				return view('front.account.return_exchange_item')->with(compact('title','order'));
	   }else{
		    abort(404);
	   }
	}

    public function return_exchange_item(Request $request,$order_id){
		
		if($request->isMethod('post')){
			 $check = Order::check_order_return_exchange($order_id); 
			 if($check['return'] == 1 || $check['exchange'] == 1){
				 $data =$request->all();
					$check_return = OrderProduct::check_return($data['order_product_id']); 
					if(!empty($check_return) && !empty($data['action'])){
							$details = OrderProduct::where('id',$data['order_product_id'])->where('user_id',Auth::user()->id)->select('order_id')->first();
							$return = new ReturnRequest;
							$return->user_id = Auth::user()->id;
							$return->action = $data['action'];
							$return->order_id = $details->order_id;
							$return->order_product_id = $data['order_product_id'];
							if($data['action'] == 'Exchange'){
							$return->required_size = $data['required_size'];
							}
							$return->reason = $data['reason'];
							$return->return_reason = $data['return_reason'];
							$fileNames = '';
							if ($request->hasFile('file')) {
								
								$files = $request->file('file');
								foreach($files  as $file){
									$filename = $file->getClientOriginalName();
									$extension = $file->getClientOriginalExtension();
									$extension_array = array("jpg","jpeg","png","JPG","JPEG","PNG");
									if (in_array($extension, $extension_array)){
										$fileName = "return-".Auth::user()->id."-".Str::random(10).".".$extension;
										$destinationPath = 'images/return'.'/';
										$file->move($destinationPath, $fileName);
										
										if($fileNames == ''){
											$fileNames = $fileName;
										}else{
											$fileNames .= ','.$fileName;
										}
									}
								}
							}
							$return->filename = $fileNames;
							$return->save();
							ReturnRequest::send_mail($return->id);
							OrderProduct::where('id',$details['id'])->update(['return_request'=>'1']);
							return redirect::to('account/orders')->with('flash_message_success',$data['action'].' request submitted successfully. We will get back to you soon');
					}else{
						return redirect()->back()->with('flash_message_error','Something went wrong');
					}
			 }
		}
	}
    public function returnOrderItem(Request $request){
        if($request->isMethod('post')){
            $data =$request->all();
            
			$check_return = OrderProduct::check_return($data['order_product_id']); 
           
			
			if(!empty($check_return)){
                $details = OrderProduct::where('id',$data['order_product_id'])->where('user_id',Auth::user()->id)->select('order_id')->first();
            
				$return = new ReturnRequest;
                $return->user_id = Auth::user()->id;
                $return->order_id = $details->order_id;
                $return->order_product_id = $data['order_product_id'];
                $return->required_size = $data['required_size'];
                $return->reason = $data['reason'];
                $return->return_reason = $data['return_reason'];
                if ($request->hasFile('file')) {
                    $files = $request->file('file');
                    $filename = $files->getClientOriginalName();
                    $extension = $files->getClientOriginalExtension();
                    $extension_array = array("jpg","jpeg","png","JPG","JPEG","PNG");
					if (in_array($extension, $extension_array)){
						$fileName = "return-".Auth::user()->id."-".Str::random(10).".".$extension;
						$destinationPath = 'images/return'.'/';
						$files->move($destinationPath, $fileName);
						$return->filename = $fileName;
					}
					
                }
                $return->save();
                OrderProduct::where('id',$details['id'])->update(['return_request'=>'1']);
                return redirect()->back()->with('flash_message_success','Exchange request submitted successfully. We will get back to you soon');
            }else{
				
                return redirect()->back()->with('flash_message_error','Something went wrong');
            }
        }
    }

    public function exchangeOrderItem(Request $request){
        if($request->isMethod('post')){
            $data =$request->all();
            $details = OrderProduct::where('id',$data['order_product_id'])->where('user_id',Auth::user()->id)->select('order_id')->first();
            if($details){
                $exchange = new ExchangeRequest;
                $exchange->user_id = Auth::user()->id;
                $exchange->order_id = $details->order_id;
                $exchange->order_product_id = $data['order_product_id'];
                $exchange->reason = $data['reason'];
                $exchange->sku = $data['sku'];
                $exchange->return_reason = $data['return_reason'];
                if ($request->hasFile('file')) {
                    $files = $request->file('file');
                    $filename = $files->getClientOriginalName();
                    $extension = $files->getClientOriginalExtension();
                    $fileName = "exchange-".Auth::user()->id."-".Str::random(5).".".$extension;
                    $destinationPath = 'images/exchange'.'/';
                    $files->move($destinationPath, $fileName);
                    $exchange->filename = $fileName;
                }
                $exchange->save();
                return redirect()->back()->with('flash_message_success','Exchange request submiited successfully. We will get back to you soon');
            }else{
                return redirect()->back()->with('flash_message_error','Something went wrong');
            }
        }
    }


    public function guestCheckout(Request $request){
        if($request->ajax()){ 
            $data = $request->all();
            $validator = Validator::make($request->all(), [
                'mobile'=>'bail|required|numeric|digits:10',
                'email_address'=>'bail|required|email',
            ]);
            if($validator->passes()){
               $checkGuestUser = User::select('id','user_type')->where(['email'=>$data['email_address']])->first();
    			   if($checkGuestUser){
    				   if($checkGuestUser->user_type=='normal'){
    						 $validator->getMessageBag()->add('exist', 'You are in already register user Please login');
                             return response()->json(['status'=>false,'type'=>'validation','errors'=>$validator->messages()]);						 
    				   }
    				   
    			   }
                if($checkGuestUser){
                    $guestUserId = $checkGuestUser->id;
                }else{
                    //create Guest User
                    $lastUser = User::select('id')->orderby('id','DESC')->first();
                    $lastid = $lastUser->id +1;
                    $guestEmail = "guest".$lastid.Str::random(2)."@yopmail.com";
                    $guestUser = new User;
                    $guestUser->user_type = "guest";
                    $guestUser->name = "Guest";
                    $guestUser->mobile = $data['mobile'];
                    $guestUser->password = bcrypt(Str::random(6));
                    $guestUser->email =  $data['email_address'];
                    $guestUser->status =1;
                    $guestUser->save();
                    $guestUserId = $guestUser->id; 
                }
				
                Auth::loginUsingId($guestUserId);
                $this->updatingCartSessionToUser();
                $redirectTo = url('/order-checkout');
                return response()->json(['status'=>true,'message'=>'ok','url'=>$redirectTo]);
            }else{
                return response()->json(['status'=>false,'type'=>'validation','errors'=>$validator->messages()]);
            }
        }
    }
    public function newsletter_subscription_change(Request $request){
		 $data['newsletter_subscription'] = $request->status;
		 User::where('id',Auth::user()->id)->update($data);
		 if($data['newsletter_subscription'] == '1'){
			 $current_status = 'activeted';
		 }else{
			  $current_status = 'deactiveted';
		 }
         return response()->json(['status'=>true,'message'=>array('Newsletter subscription has been '. $current_status.' successfully')]);
	}
    public function logout(){
        Session::forget('previousurl');
        Session::forget('couponinfo');
        Auth::logout();
        return redirect('/');
    }
	
	public function trackOrder($order_id){  
	        $order = Order::where('user_id',Auth::user()->id)->where('id',$order_id)->where('waybill','!=','')->firstOrFail();
			if(!empty($order)){ 
				$delhivery = new \App\Services\DelhiveryService();
				$ShipmentData = $delhivery->trackOrder($order['waybill']); 
				return View::make('admin.orders.shipment')->with(compact('order','ShipmentData')); 
			}
	}
    public function order_tracking_status($awb){
        
        //$awb = '50706530545';
        $ch = curl_init();
		
		curl_setopt($ch, CURLOPT_URL, "http://api.bluedart.com/servlet/RoutingServlet?handler=tnt&action=custawbquery&loginid=LD910195&awb=awb&numbers=".$awb."&format=xml&lickey=df88bee111fe614f8cdd26d382ef6133&verno=1.3&scan=1");
		
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		
		$output = curl_exec($ch);
		
		curl_close($ch);
		
		$new = simplexml_load_string($output);
		
		$con = json_encode($new); 

        return $con;
        
    }
    
    public function get_pincode_details(Request $request){
		if($request->pincode == ''){
			$message = 'Enter the Pincode';
			$status = false;
		}else{
			$sql ="SELECT * FROM `pincodelists` WHERE `pincode` ='".$request->pincode."' and (`prepaid` = 'yes' or `cod` = 'yes') LIMIT 1
";
             $pincode_details =  DB::select($sql);
			
			if(!empty($pincode_details)){
				 $message = 'This pin code is serviceable.';
			     $status = true;
			}else{
				 $message = 'This pin code is not serviceable at all';
			     $status = false;
			}
			
		}
		return response()->json(['status'=>$status,'message'=>$message]);
	}
	public function checksms(){
	    Order::sendSms();
	}
	public function order_cancel($id){
	  $orderDetails = Order::where('user_id',Auth::user()->id)->where('id',$id)->firstorFail();
	  if($orderDetails->order_status=='Cancelled by User'){
	      return redirect()->back()->with('flash_message_error','Order already cancelled');
	  }
	  
	  
	  $check_order_return_exchange = Order::check_order_return_exchange($id);
	  
	  if($check_order_return_exchange['cancel'] == 1){
		  $orderDetails->order_status = 'Cancelled by User';
		  if($orderDetails->save()){
			  $updateqty = OrderProduct::where('order_id',$orderDetails->id)->first();
			  ProductAttribute::where('product_id',$updateqty->product_id)->where('size',$updateqty->product_size)->increment('stock',1);
			  return redirect('account/orders')->with('flash_message_success','Order successfully cancelled');
		  }else{
			  return redirect('account/orders')->with('flash_message_error','Something went to wrong');
		  }
	  }else{
		  return redirect('account/orders')->with('flash_message_error','Something went to wrong');
	  }
	}
	
	
	public function updateAddress(Request $request){ 
	
	if($request->isMethod('post')){
           
			 $validation_data = $request->all();
	    	 //$validation_data['billing_first_name'] = CustomFunction::charactersOnly( $validation_data['billing_first_name']);
	    	 //$validation_data['billing_city'] = CustomFunction::charactersOnly( $validation_data['billing_city']);
	    	 $validation_data['shipping_first_name'] = CustomFunction::charactersOnly( $validation_data['shipping_first_name']);
	    	 $validation_data['shipping_city'] = CustomFunction::charactersOnly( $validation_data['shipping_city']);
			$validator = Validator::make($validation_data, [
					'shipping_first_name' => 'required|regex:/^[a-zA-Z]+$/u|max:255',
                    'shipping_mobile' => 'required|numeric|digits:10',
                    'shipping_alternative_number' => 'required|numeric|digits:10',
                    'shipping_address' => 'bail|required',
                    'shipping_postcode' => 'required|numeric|digits:6',
                    'shipping_city' => 'required|regex:/^[a-zA-Z]+$/u|max:255',
                    'shipping_state' => 'bail|required',
                    'shipping_country' => 'bail|required',
                    
                ],
				[
					'shipping_first_name.required' => 'Enter the name.',
					'shipping_first_name.regex' => 'Enter the valid name.',
                    'shipping_mobile.required' => 'Enter the 10 digit valid mobile number.',
                    'shipping_alternative_number.required' => 'Enter the 10 digit valid alternative mobile number.',
                    'shipping_address.required' => 'Enter the address.',
                    'shipping_postcode.required' => 'Enter the postcode.',
                    'shipping_city.required' => 'Enter the city.',
                    'shipping_state.required' => 'Please select state.',
                    'shipping_country.required' => 'Please select country.',
                ]);
                
			
            if($validator->passes()){
				$data = $request->all();
				
				$CheckShippingAddress = ShippingAddress::addresses();
				if(!empty($CheckShippingAddress)){
					$shipping_address_id =  $CheckShippingAddress['id'];
					$save_shipping_address = ShippingAddress::find($shipping_address_id);
				}else{
					$save_shipping_address = new ShippingAddress;
				}
				
				$user_id = Auth::user()->id;
				$save_shipping_address->first_name = $data['shipping_first_name'];
				$save_shipping_address->name = $data['shipping_first_name'];
				$save_shipping_address->mobile = $data['shipping_mobile'];
				$save_shipping_address->alternative_number = $data['shipping_alternative_number'];
				$save_shipping_address->address = $data['shipping_address'];
				$save_shipping_address->postcode = $data['shipping_postcode'];
				$save_shipping_address->city = $data['shipping_city'];
				$save_shipping_address->state = $data['shipping_state'];
				$save_shipping_address->country = $data['shipping_country'];
				$save_shipping_address->user_id = $user_id;
				$save_shipping_address->is_default = 'yes';
				$save_shipping_address->save();
				
				
				 $action = url('/account/address?r=success');
				 return response()->json(['status'=>true,'type'=>'validation','action'=>$action,'message'=>'ok']); 
			}else{
				
				return response()->json(['status'=>false,'type'=>'validation','errors'=>$validator->messages()]); 
				
			}
		}
	}
	
	
	
	
	
	public function getState(Request $request){  
	  if($request->ajax()){
		  $pincode = $request->input('pincode');
		  $get_state = Pincodelist::where('pincode',$pincode)->first();
		  $state = $city = '';
		  if(!empty($get_state)){
			  $state = $get_state->state;
			  $city = $get_state->city;
			  
			  $state = str_replace('"','', $state);
			  $city = str_replace('"','', $city);

			  $state = ucwords(strtolower($state));
			  $city = ucwords(strtolower($city));
			 
		  }
		  return response()->json(['status'=>true,'state'=>$state,'city'=>$city]);
	  }
	}
	
	
}
