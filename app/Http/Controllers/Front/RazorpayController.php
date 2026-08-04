<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Order;
use App\User;
use Session;
use Illuminate\Support\Facades\Mail;
use App\OrderHistory;
use App\Razorpay;
use Auth;
use Redirect;
use Razorpay\Api\Api;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class RazorpayController extends Controller
{
    //
	public function __construct(Order $order,OrderHistory $orderhistory){
        $this->order           = $order;
        $this->orderhistory    = $orderhistory;
    }

    public function razorpayPayment(){
        if(isset($_GET) && !empty($_GET['id'])){
			$order_id = decrypt($_GET['id']);
            $checkValidPayment = $this->order->where('id',$order_id)->first(); 
            if($checkValidPayment){
                $credentials = Razorpay::credentials(); 
				$RAZORPAY_KEY = $credentials['RAZORPAY_KEY'];
				$RAZORPAY_SECRET_KEY = $credentials['RAZORPAY_SECRET_KEY'];
				if($checkValidPayment->razorpay_order_id==""){ 
                   
                    $api = new \Razorpay\Api\Api($RAZORPAY_KEY, $RAZORPAY_SECRET_KEY);

					$api = new Api($RAZORPAY_KEY, $RAZORPAY_SECRET_KEY);
                    $order  = $api->order->create(array('receipt' => (String)$checkValidPayment->id, 'amount' => ($checkValidPayment->grand_total*100), 'currency' => 'INR','payment_capture'=>1)); // Creates order
                    $orderid = $order['id']; 
                    //Update Orderid In orders Table
                    $this->order->where('id',$checkValidPayment->id)->update(['razorpay_order_id'=>$orderid]);
                }else{
                    if($checkValidPayment->payment_status=="captured"){
                        return redirect::to('/');
                    }else{
                        $orderid = $checkValidPayment->razorpay_order_id;
                    }
                }
                return view('front.checkout.razorpay.razor-payment')->with(compact('orderid','checkValidPayment','RAZORPAY_KEY'));
            }else{
                abort(404);
            }
        }else{
            abort(404);
        }
    }
	
	public function webhook_razorpay(Request $request){	   
		return response()->json([
				'status'=>true,
				]);
		$data = $request->getContent();
		$signature = $request->header('X-Razorpay-Signature');
		
		$credentials = Razorpay::credentials(); 
				
		$webhookSecret = $credentials['RAZORPAY_WEBHOOK_SECRET'];
		
		 
		
		// Verify signature
		$expectedSignature = hash_hmac('sha256', $data, $webhookSecret);
		if ($signature !== $expectedSignature) {
			Log::warning('Razorpay webhook signature mismatch');
			return response()->json(['status' => 'invalid signature'], 400);
		}
		
		// Log or handle the webhook
		$payload = json_decode($data, true);
		
		$payload_array = ensureJson($payload);
		
		$event = $payload['event'];
		Log::info('Razorpay webhook received', ['event' => $event, 'payload' => $payload]);
		if ($event === 'payment.captured') {
			$razorpay_order_id = $payload['payload']['payment']['entity']['order_id']; 
			$details = Order::where('razorpay_order_id',$razorpay_order_id)->orderby('id','DESC')->first();
			if($details){
				
				$raorpayPaymentId = $payload['payload']['payment']['entity']['order_id']; 
				//$amount = $payload['payload']['payment']['entity']['amount'];  
				
				//check Payment details
				Order::where('razorpay_order_id',$razorpay_order_id)->update(['razorpay_payment_id'=>$raorpayPaymentId,'payment_status'=>'captured','signature'=>$signature,'webhook_payment_response'=>$payload_array,'order_status'=>'Payment Captured']);
				OrderHistory::where('order_id',$details->id)->delete();
				$requestdata['order_status'] = 'Payment Captured';
				$requestdata['comments'] =  'Payment has been received';
				$requestdata['order_id'] =  $details->id;
				OrderHistory::create($requestdata);
				
				
				
				if(env('MAIL_MODE') =="live"){
					/* Order::sendOrderEmail($details->id); */
					$this->order->sendOrderEmail($details->id);
				}
				
				Order::update_stock($details->id);
				//Order::creditRewardPoints($details->id);
				return response()->json([
				'status'=>true,
				]);
			}
		}
	}
	
	

    public function dopayment(Request $request) {
        if($request->ajax()){
           // return response()->json([  'status'=>true, ]); exit; die();
                   
                
			
			$data = $request->all();
            $details = $this->order->where('razorpay_order_id',$data['data']['razorpay_order_id'])->orderby('id','DESC')->first();
            if($details){
                $raorpayPaymentId = $data['data']['razorpay_payment_id'];
                $razorpaySignature = $data['data']['razorpay_signature'];
                //check Payment details
                $this->order->where('razorpay_order_id',$data['data']['razorpay_order_id'])->update(['razorpay_payment_id'=>$raorpayPaymentId,'payment_status'=>'captured','signature'=>$razorpaySignature,'order_status'=>'Payment Captured']);
                OrderHistory::where('order_id',$details->id)->delete();
                $requestdata['order_status'] = 'Payment Captured';
                $requestdata['comments'] =  'Payment has been received';
                $requestdata['order_id'] =  $details->id;
                OrderHistory::create($requestdata);
                if(!empty(Auth::user()->mobile)){
                    /*$smsdetails['mobile']  = Auth::user()->mobile;
                    $smsdetails['message'] = "Dear ".Auth::user()->name. ", your order no.".$details->id." has been successfully placed. We shall inform once your order has been dispatched. For any queries, write to us at ";
                    $smsdetails['dlttempid'] = '';
                    sendSms($smsdetails);*/
                }
                if(env('MAIL_MODE') =="live"){
                    $this->order->sendOrderEmail($details->id);
                }
				Order::update_stock($details->id);
				Order::creditRewardPoints($details->id);
                return response()->json([
                    'status'=>true,
                ]);
            }else{
                return response()->json([
                    'status'=>false,
                ]);
            }
        }
    }

    public function verifyRazorpayPayment($id=null){
        if($id>0){
            $prepaidOrders = Order::where('id',$id)->limit(1)->get();
        }else{
            // Check for last 10 prepaid orders
             $prepaidOrders = Order::where(['payment_gateway'=>'Razorpay'])->orderBy('id','DESC')->limit(100)->get();    
        }
        
        $prepaidOrders = json_decode(json_encode($prepaidOrders));
        /*echo "<pre>"; print_r($prepaidOrders); die;*/

        /*if($id>0){
            echo "<pre>"; print_r($prepaidOrders);
        }*/

        if(!empty($prepaidOrders)){
            foreach($prepaidOrders as $order){

                $api_key = env('RAZORPAY_KEY');
                $api_secret = env('RAZORPAY_SECRET');
                
                $curl = curl_init();
                curl_setopt_array($curl, array(
                    /*CURLOPT_URL => "https://".$api_key.":".$api_secret."@api.razorpay.com/v1/payments?count=100&notes=".$order->id,*/
                    CURLOPT_URL => "https://".$api_key.":".$api_secret."@api.razorpay.com/v1/payments?count=100&order_id=".$order->razorpay_order_id,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_TIMEOUT => 30,
                    /*CURLOPT_HTTP_VERSION => CURLOPT_HTTP_VERSION_1_1,*/
                    CURLOPT_CUSTOMREQUEST => "GET",
                    CURLOPT_HTTPHEADER => array(
                        "cache-control: no-cache",
                        "content-type: application/x-www-form-urlencoded"
                    ),
                ));

                $payments = curl_exec($curl);
                curl_close($curl);
                $payments = json_decode($payments,true);

                /*echo "<pre>"; print_r($payments); die;*/

                if($id>0){
                    echo "<pre>"; print_r($payments); die;
                }
                
                if(isset($payments['items'][0])){
                    $itemsArr = $payments['items'];
                    $key = array_search('captured', array_column($itemsArr, 'status'));
                    /*echo $payments['items'][$key]['status'];
                    echo $order->order_status;
                    echo "<pre>"; print_r($key); die;*/

                    if($payments['items'][$key]['status'] =="captured"){
                        if($order->order_status == "Cancelled"){

                            // Update Orders table with Payment Captured Status
                            Order::where(['id' => $order->id])->update(['order_status' => 'Payment Captured','payment_status' => $payments['items'][$key]['status'],'razorpay_payment_id'=>$payments['items'][$key]['id']]);

                            // Update Logs
                            $requestdata['order_status'] = 'Payment Captured';
                            $requestdata['comments'] =  'Payment has been received';
                            $requestdata['order_id'] =  $order->id;
                            OrdersHistory::create($requestdata);

                            echo $order->id." payment made, status updated to Success<br>";
                        }                       
                    
                    }else{
                        
                    }
                }else{
                    
                }
            }
            echo "cron job run successfully";
        }else{
            echo "nothing to run";
        }
        
    }

    public function cancel(){
        return view('front.razorpay.cancel');
    } 

}
?>
