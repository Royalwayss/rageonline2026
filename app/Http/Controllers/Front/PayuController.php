<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Softon\Indipay\Facades\Indipay; 
use App\Order;
use App\User;
use Session;
use Illuminate\Support\Facades\Mail;
use App\OrderHistory;
use App\OrderGiftVoucher;
use App\Payu;
use App\SmsApi;
use DB;
use Redirect;
use Auth;
class PayuController extends Controller
{
    //
    public function __construct(Order $order){
        error_reporting(0);
        $this->order      = $order;
    }

    public function payuPayment(Request $request){ 
	   // echo "<pre>"; print_r($request->isMethod('get')); exit;
        if($request->isMethod('get')){
            $data = $request->all();
            if(isset($data['id']) && !empty($data['id'])){
                $orderId =  decrypt($data['id']);
                $orderdetails = Order::with(['order_address','getuser'])->where(['id'=>$orderId])->first();
                if($orderdetails){
                    $payudetails = Payu::payudetails();
                    $PAYU_BASE_URL = $payudetails['PAYU_BASE_URL'];
                    $SALT = $payudetails['SALT'];
                    $MERCHANT_KEY = $payudetails['MERCHANT_KEY'];
					if(env('PAYU_MODE') =='test'){
						$txnid =  time().'-'.$orderId;
					}else{
						$txnid = $orderId;
					}
					
                	$posted = [
                        'key'   => $MERCHANT_KEY,
                        'txnid' => $txnid,
                        'order_id' => $orderId,
                        'amount' => $orderdetails->grand_total,
                        'firstname'=>$orderdetails->order_address->shipping_name,
                        'lastname'=>$orderdetails->order_address->shipping_name,
                        'email' =>$orderdetails->getuser->email,
                        'phone' =>$orderdetails->order_address->shipping_mobile,
                        'productinfo' =>Session::get('orderid'),
                        'service_provider' =>'payu_paisa',
                        'zipcode' =>$orderdetails->order_address->shipping_postcode,
                        'city' => $orderdetails->order_address->shipping_city,
                        'state' => $orderdetails->order_address->shipping_state,
                        'country' => $orderdetails->order_address->shipping_country,
                        'address1' => $orderdetails->order_address->shipping_address,                        
                        'productinfo' =>$orderId,
                        'service_provider' =>'',
                        'zipcode' =>$orderdetails->postcode,
                        'city' => $orderdetails->city,
                        'state' => $orderdetails->state,
                        'country' => 'India',
                        'address2' => $orderdetails->address_line_2,
                        'surl' => url('/payu/success'),
                        'furl' => url('/payu/response'),
                        'curl' => url('/payu/response'),
                    ];
                    
                    $hash = '';
                    // Hash Sequence
                    $hashSequence = "key|txnid|amount|productinfo|firstname|email||||||||||";
                    if(empty($posted['hash']) && sizeof($posted) > 0) {
                        if(empty($posted['key']) || empty($posted['txnid']) || empty($posted['amount']) || empty($posted['firstname']) || empty($posted['email']) || empty($posted['phone']) || empty($posted['productinfo']) || empty($posted['surl'])|| empty($posted['furl'])) {
                                $formError = 1;
                        } else {
                            $hashVarsSeq = explode('|', $hashSequence);
                            $hash_string = '';
                            foreach($hashVarsSeq as $hash_var) {
                              $hash_string .= isset($posted[$hash_var]) ? $posted[$hash_var] : '';
                              $hash_string .= '|';
                            }
                            $hash_string .= $SALT;
                            $hash = strtolower(hash('sha512', $hash_string));
                            $action = $PAYU_BASE_URL . '/_payment';
                        }
                    }elseif(!empty($posted['hash'])) {
                        $hash = $posted['hash'];
                        $action = $PAYU_BASE_URL . '/_payment';
                    }else{
                    }
                    $title="Make Payment";
                    return view('front.checkout.payu_payment')->with(compact('action','MERCHANT_KEY','hash','txnid','posted','title'));
                }else{
                	return redirect()->action('App\Http\Controllers\Front\ListingController@cart');
                }
            }else{
                return redirect()->action('App\Http\Controllers\Front\ListingController@cart');
            }
        }
    }

    public function payuSuccess(Request $request){
		//echo "<pre>"; print_r($request->all()); exit; 
        if($request->isMethod('post')){
            $response = $request->all();
            $payudetails = Payu::payudetails();
            $PAYU_BASE_URL = $payudetails['PAYU_BASE_URL'];
            $salt          = $payudetails['SALT'];
            $status        = $_POST["status"];
            $firstname     = $_POST["firstname"];
            $amount        = $_POST["amount"];
            $txnid         = $_POST["txnid"];
            $posted_hash   = $_POST["hash"];
            $key           = $_POST["key"];
            $productinfo   = $_POST["productinfo"];
            $email         = $_POST["email"];
            if (isset($_POST["additionalCharges"])) {
                $additionalCharges =$_POST["additionalCharges"];
                $retHashSeq        = $additionalCharges.'|'.$salt.'|'.$status.'|||||||||||'.$email.'|'.$firstname.'|'.$productinfo.'|'.$amount.'|'.$txnid.'|'.$key;
            } else {
                $retHashSeq = $salt.'|'.$status.'|||||||||||'.$email.'|'.$firstname.'|'.$productinfo.'|'.$amount.'|'.$txnid.'|'.$key;
            }
            $hash = hash("sha512", $retHashSeq);
            if ($hash != $posted_hash) { 
                return redirect()->action('App\Http\Controllers\Front\ListingController@checkout')->with('flash_message_error','Sorry! Invalid Transaction. Please try again');
            }else {
				 
				 
				if(env('PAYU_MODE') =='test'){
					$get_order_id = explode('-',$txnid);
					$txnid = $get_order_id['1'];
				}
				
				
                $orderPaymentInfo = Order::where('id',$txnid)->first();
                if($orderPaymentInfo->grand_total == $_POST['amount']){
                 // $payuResp = $this->checkOrderStatusPayu($txnid);
					$payuResp = '';
                    if($payuResp){
                        $payment = true;
                    }else{
                        $payment = false;
                    }
					 $payment = true;
                }else{
                    $payment = false;   
                }
                if($payment){
                    DB::beginTransaction();
                    OrderHistory::where('order_id',$txnid)->delete();
                    $history = array('order_status'=>'Payment Captured','comments'=>'Payment has been received','order_id'=>$txnid);
                    OrderHistory::create($history);
                    Order::where('id',$txnid)->update(['order_status'=>'Payment Captured','payment_status'=>'captured','payu_api'=>'yes','mihpayid'=>$response['mihpayid']]);
                    
                    DB::commit();
                    //Send Order Email
                    $this->order->sendOrderEmail($txnid);
                    return redirect::to('/thanks?id='.encrypt($txnid));
                }else{
                    return redirect()->action('App\Http\Controllers\Front\ListingController@checkout')->with('flash_message_error','Something went Wrong!. Please try again after sometime');
                }
            }         
        }else{
            return redirect()->action('App\Http\Controllers\Front\IndexController@index');
        }
    }   

    public function payuResponse(Request $request){
		
        try{
            $data = $request->all();
			$get_order_id = explode('-',$data['txnid']);
		    $data['txnid'] = $get_order_id['1'];
            if(isset($data['txnid']) && !empty($data['txnid'])){
                return redirect::to('/cancel?id='.encrypt($data['txnid']));
            }else{
                return redirect::to('/');
            }
        }catch(\Exception $e){
            return response()->json(exceptionMessage($e),423);
        }
    }

    public function checkOrderStatusPayu($txnid){
        $payudetails = Payu::payudetails();
        $key = $payudetails['MERCHANT_KEY'];
        $salt = $payudetails['SALT'];
        $command = "verify_payment";
        $var1 = $txnid;
        $hash_str = $key  . '|' . $command . '|' . $var1 . '|' . $salt ;
        $hash = strtolower(hash('sha512', $hash_str));
        $r = array('key' => $key , 'hash' =>$hash , 'var1' => $var1, 'command' => $command);
        $qs= http_build_query($r);
        $wsUrl = $payudetails['INFO_PAYU_BASE_URL'];
        $c = curl_init();
        curl_setopt($c, CURLOPT_URL, $wsUrl);
        curl_setopt($c, CURLOPT_POST, 1);
        curl_setopt($c, CURLOPT_POSTFIELDS, $qs);
        curl_setopt($c, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($c, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($c, CURLOPT_SSL_VERIFYPEER, 0);
        $o = curl_exec($c);
        if (curl_errno($c)) {
          $sad = curl_error($c);
          throw new Exception($sad);
        }
        curl_close($c);
        $valueSerialized = @unserialize($o);
        if($o === 'b:0;' || $valueSerialized !== false) {
          print_r($valueSerialized);
        } 
        $o = json_decode($o);
        foreach($o->transaction_details as $key => $val){
            if(($val->status=="success")&&($val->unmappedstatus=="captured")){
                $status = true;               
            }else{
                $status = false;  
            }
        }
        return $status;
    }

    public function singleOrderStatus($txnid){
        $payudetails = Payu::payudetails();
        $key = $payudetails['MERCHANT_KEY'];
        $salt = $payudetails['SALT'];
        $command = "verify_payment";
        $var1 = $txnid;
        $hash_str = $key  . '|' . $command . '|' . $var1 . '|' . $salt ;
        $hash = strtolower(hash('sha512', $hash_str));
        $r = array('key' => $key , 'hash' =>$hash , 'var1' => $var1, 'command' => $command);
        $qs= http_build_query($r);
        $wsUrl = $payudetails['INFO_PAYU_BASE_URL'];
        $c = curl_init();
        curl_setopt($c, CURLOPT_URL, $wsUrl);
        curl_setopt($c, CURLOPT_POST, 1);
        curl_setopt($c, CURLOPT_POSTFIELDS, $qs);
        curl_setopt($c, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($c, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($c, CURLOPT_SSL_VERIFYPEER, 0);
        $o = curl_exec($c);
        if (curl_errno($c)) {
          $sad = curl_error($c);
          throw new Exception($sad);
        }
        curl_close($c);
        $valueSerialized = @unserialize($o);
        if($o === 'b:0;' || $valueSerialized !== false) {
          print_r($valueSerialized);
        } 
        $o = json_decode($o);
        echo "<pre>"; print_r($o->transaction_details);
    } 
}
