<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Order;
use App\User;
use Session;
use Illuminate\Support\Facades\Mail;
use App\OrderHistory;
use App\Phonepe;
use Auth;
use Redirect;
class PhonepeController extends Controller
{
    //
    public function __construct(Order $order,OrderHistory $orderhistory){
        $this->order           = $order;
        $this->orderhistory    = $orderhistory;
    }

    public function phonePePayment(){  
        if(isset($_GET) && !empty($_GET['id'])){ 
            $order_id = decrypt($_GET['id']);
			$orderDetails = $this->order->with('getuser')->where('id',$order_id)->first();
            $orderDetails = json_decode(json_encode($orderDetails),true);
            
			if(!empty($orderDetails)){
            	$url = Phonepe::getPaymentUrl($orderDetails); 
               	if(!empty($url)){
               		return redirect::to($url);
               	}else{
               		return redirect::to('order-checkout')->with('flash_message_error','Something went wrong at Phonepe payment gateway side');
               	}
            }else{
                abort(404);
            }
        }else{ 
            abort(404);
        }
    }

    public function phonePeRedirect(Request $request){ 
    	$data = $request->getContent(); 
        parse_str($data, $arr);
        Session::put('orderid',$arr['transactionId']);
		$encorderid = encrypt($arr['transactionId']);
        if(isset($arr['code']) && $arr['code'] =="PAYMENT_SUCCESS"){
			$orderDetails = Order::with(['order_products','order_address','getuser'])->where('id',$arr['transactionId'])->first();
            $orderDetails = json_decode(json_encode($orderDetails),true);
			if(env('MAIL_MODE') =="live" ){
				
				$email = $orderDetails['getuser']['email'];
				$admin_mail =   config('constants.admin_mail');
				 $messageData = [
                        'orderDetails' => $orderDetails
                    ];
				Mail::send('emailtemplate.to_user.order-success-email', $messageData, function($message) use ($email,$admin_mail){
					$message->to($email)->bcc($admin_mail)->subject('Thanks for Placing the Order with '.config('constants.project_name'));
				});
			}	
			Order::update_stock($orderDetails['id']);
			return redirect::to('/thanks?id='.$encorderid);
        }else if(isset($arr['code']) && ($arr['code'] =="PAYMENT_PENDING" || $arr['code'] =="INTERNAL_SERVER_ERROR")) {
            return redirect::to('/cancel?id='.$encorderid);
        }else{
            return redirect::to('/cancel?id='.$encorderid);
        }
    }

    public function phonePeCallback(Request $request){ 
        $phonepe_details = Phonepe::phonepe_info();
        if($request->header('x-verify')){
            $header = $request->header('x-verify');
            $data = $request->getContent();
            $data = json_decode($data,true);
            if(isset($data['response'])){
                $base64_decode = base64_decode($data['response']);
                $response = json_decode($base64_decode,true);
                $orderDetails = Order::where('id',$response['data']['merchantTransactionId'])->first();
                $orderDetails =json_decode(json_encode($orderDetails),true);
                $sha = hash('sha256',$data['response'].$phonepe_details['salt_key']).'###'.$phonepe_details['salt_index'];
                if($header ==$sha){
                    if($response['code'] == "PAYMENT_SUCCESS"){
                        $this->order->where('id',$orderDetails['id'])->update(['txn_id'=>$response['data']['transactionId'],'payment_status'=>'captured','order_status'=>'Payment Captured','webhook_payment_response'=>json_encode($response)]);
                        $requestdata['order_status'] = 'Payment Captured';
                        $requestdata['comments'] =  'Payment has been received';
                        $requestdata['order_id'] =  $orderDetails['id'];
                        OrderHistory::create($requestdata);
						
                    }elseif($response['code'] == "PAYMENT_PENDING" || $response['code'] == "INTERNAL_SERVER_ERROR"){
                        
                        Order::where('id',$orderDetails['id'])->update(['payment_status'=>'pending','order_status'=>'Phonepe Payment Pending','webhook_payment_response'=>json_encode($response)]);
                    }else{
                        Order::where('id',$orderDetails['id'])->update(['order_status'=>'Cancelled','webhook_payment_response'=>json_encode($response)]);
                    }
                }else{
                    Order::where('id',$orderDetails['id'])->update(['order_status'=>'Cancelled']);
                }
            }
        }
        return response()->json(['status'=>true,'message'=>'Status has been updated successfully']);
    }

    public function verifyPhonepePayments(){ 
        $orders = PendingPayment::where('run_time',date('Y-m-d H:i:00'))->where('pg','phonepe')->get()->toArray();
        foreach($orders as $order){;
            $phonepe_resp = Phonepe::checkOrderStatus($order['order_id']);
            $orderDetails = Order::with('getuser')->where('id',$order['order_id'])->first();
            $orderDetails =json_decode(json_encode($orderDetails),true);
            if($phonepe_resp['data']['code'] == "PAYMENT_SUCCESS"){
                $response = $phonepe_resp['data'];
                PendingPayment::where('order_id',$order['order_id'])->Where('id','!=',$order['id'])->delete();
                $this->order->where('id',$orderDetails['id'])->update(['txn_id'=>$response['data']['transactionId'],'payment_status'=>'captured','order_status'=>'Payment Captured','webhook_payment_response'=>json_encode($phonepe_resp)]);
                OrderHistory::where('order_id',$orderDetails['id'])->delete();
                $requestdata['order_status'] = 'Payment Captured';
                $requestdata['comments'] =  'Payment has been received';
                $requestdata['order_id'] =  $orderDetails['id'];
                OrderHistory::create($requestdata);
                $this->order->sendOrderEmail($orderDetails['id']);
            }
        }
    }
}
