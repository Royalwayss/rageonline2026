<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Order;
use App\User;
use Session;
use Illuminate\Support\Facades\Mail;
use Auth;
use Redirect;
use Softon\Indipay\Facades\Indipay; 
use App\OrderHistory;
class CcavenueController extends Controller
{
    //
    public function __construct(Order $order,OrderHistory $orderhistory){
        error_reporting(0);
        $this->order      = $order;
        $this->orderhistory = $orderhistory;
    }
    
    public function ccavenuePayment(Request $request){
        if($request->isMethod('get')){
            $data = $request->all();
             if(isset($data['id']) && !empty($data['id'])){
                $orderId =  decrypt($data['id']);
    			$orderdetails = Order::with(['order_address','getuser'])->where(['id'=>$orderId])->first();
                $parameters = [
                    'tid' => $orderId,
                    'order_id' => $orderId,
                    'merchantTxnId' => $orderId,
                    'amount' => $orderdetails->grand_total,
                    'currency' => 'INR',
                    'shipName'=> $orderdetails->order_address->shipping_name,
                    'shipAddress' => $orderdetails->order_address->shipping_address,
                    'shipState' => $orderdetails->order_address->shipping_state,
                    'shipCountry' => 'India',
                    'shipCity' => $orderdetails->order_address->shipping_city,
                    'shipZip' => $orderdetails->order_address->shipping_postcode,
                    'shipTel' => $orderdetails->order_address->shipping_mobile,
                    'shipping_email' => $orderdetails->getuser->email
                ];
                $order = Indipay::prepare($parameters);
                return Indipay::process($order);
            }else{
                return redirect()->action('App\Http\Controllers\Front\ListingController@cart');
            }
        }
    }

    public function ccavenueresponse(Request $request){
        $response = Indipay::response($request);
        $response = Indipay::gateway('CCAvenue')->response($request);
        //echo "<pre>"; print_r($response); die;
        if(isset($response) && $response['order_id']){
            $orderDetails = Order::with(['order_products','order_address','getuser'])->where('id',$response['order_id'])->first();
            $orderDetails = json_decode(json_encode($orderDetails),true);
            $encorderid = encrypt($response['order_id']);
            if($orderDetails && $orderDetails['grand_total'] == $response['amount']){
                if($response['order_status'] =="Success"){
                	$this->orderhistory->where('order_id',$response['order_id'])->delete();
			        $requestdata['order_status'] = 'Payment Captured';
			        $requestdata['comments'] = 'Payment has been received';
			        $requestdata['order_id'] =  $response['order_id'];
			        OrderHistory::create($requestdata);
                    Order::where('id',$response['order_id'])->update(['order_status'=>'Payment Captured','payment_status'=>'captured','txn_id'=>$response['tracking_id']]);
                    Order::update_stock($response['order_id']);
					//Send Order Email
                    $messageData = [
                        'orderDetails' => $orderDetails
                    ];
                    $email = $orderDetails['getuser']['email'];
                    $admin_mail =   config('constants.admin_mail');
                    Mail::send('emailtemplate.to_user.order-success-email', $messageData, function($message) use ($email,$admin_mail){
                        $message->to($email)->bcc($admin_mail)->subject('Thanks for Placing the Order with '.config('constants.project_name'));
                    });
                    return redirect::to('/thanks?id='.$encorderid);
                }else{
                    Order::where('id',$response['order_id'])->update(['order_status'=>'Aborted']);
                    return redirect::to('/cancel?id='.$encorderid);
                }
            }else{
                return redirect::to('/cancel?id='.$encorderid);
            }
        }else{
            return redirect()->action('App\Http\Controllers\Front\ListingController@cart');
        }
    } 

    public function ccavenueCancel(Request $request){
        $response = Indipay::response($request);
        $response = Indipay::gateway('CCAvenue')->response($request);
        if(isset($response) && $response['order_id']){
            Order::where('id',$response['order_id'])->update(['order_status'=>'Aborted']);
            $orderid = encrypt($response['order_id']);
            return redirect::to('/cancel?id='.$orderid);
        }else{
            return redirect()->action('App\Http\Controllers\Front\ListingController@cart');
        }
    }
}
