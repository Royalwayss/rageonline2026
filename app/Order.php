<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;
use DB;
use Auth;
use App\OrderProduct;
use App\Order;
use App\User;
use App\LoyaltyPointLog;
use App\ProductAttribute;
use App\ReturnRequest;
use App\ProductAttributeLog;
class Order extends Model
{
    //
    protected $fillable = ['id','user_id','company_name','gstin','payment_method','txn_id','coupon_code','mobile','coupon_discount','prepaid_discount','prepaid_discount_percentage','total_order_discount','order_discount','order_discount_percentage','shipping_charges','subtotal','grand_total_without_round_of','amount_redeemed','points_redeemed','round_of','grand_total','payment_status','order_status','comments','webhook_payment_response','gift_id','gift_name','gift_mrp','delivery_method','awb_number','invoice_no','invoice_date','ip_address','created_at','updated_at','manifest_resp'];

    public function getuser(){
    	return $this->belongsTo('App\User','user_id');
    }

    public function order_products(){
    	return $this->hasMany('App\OrderProduct','order_id')->with('productdetail');
    }

    public function order_address(){
    	return $this->hasOne('App\OrderAddress','order_id');
    }

    public function histories(){
        return $this->hasMany('App\OrderHistory')->orderby('id','DESC');
    }

    public static function checkCouponUsed($couponcode){
        $checkCouponUsed = DB::table('orders')->where('user_id',Auth::user()->id)->where('coupon_code',$couponcode)->wherein('payment_status',['cod','captured'])->count();
        return $checkCouponUsed;
    }
	public function sendOrderEmail($orderid=''){
		       if($orderid == ''){
				   return '';
			   }
               if(env('MAIL_MODE') =="live" ){
				     
                    $orderDetails = Order::with(['getuser','order_products','order_address'])->where('id',$orderid)->first();
                    $orderDetails = json_decode(json_encode($orderDetails),true);
                    $messageData = [
                        'orderDetails' => $orderDetails
                    ];
					
					$admin_mail =   config('constants.admin_mail');
						   foreach($admin_mail as $email){
								Mail::send('emailtemplate.to_admin.order-success-email', $messageData, function($message) use ($email){
									$message->to($email)->subject('New Order has been placed at '.config('constants.project_name'));
								}); 
							}
				}
				$orderDetails = Order::with(['getuser','order_products','order_address'])->where('id',$orderid)->first();
                $orderDetails = json_decode(json_encode($orderDetails),true);
				
				
                if(env('MAIL_MODE') =="live" && $orderDetails['getuser']['user_type']=="normal"){ 
                    
                    
                    $messageData = [
                        'orderDetails' => $orderDetails
                    ];
					$email = $orderDetails['getuser']['email'];
                    $emails = array($email);
					
						
							foreach($emails as $email){
								Mail::send('emailtemplate.to_user.order-success-email', $messageData, function($message) use ($email){
									$message->to($email)->subject('Thanks for Placing the Order with '.config('constants.project_name'));
								}); 
							}
							
					
					 
					
                }
				
    }
   
    public function sendOrderEmail1111($orderid){
        $orderDetails = Order::with(['order_products','order_address','getuser'])->where('id',$orderid)->first();
        $orderDetails = json_decode(json_encode($orderDetails),true);
        if(env('MAIL_MODE') =='live'){
            //SmsApi::sendSms($smsdetails);
            $email = $orderDetails['getuser']['email'];
            $messageData = [
                'orderDetails' => $orderDetails
            ];
            
            Mail::send('emails.order-success-email', $messageData, function($message) use ($email){
                $message->to($email)->subject('Order Placed with '.config('constants.project_name'));
            });
        }
    }
	
	 
	  public static function update_stock($order_id){
		 
		$order = Order::with(['order_products'])->where('id', $order_id)->first();

		if(!empty($order)) {
			foreach ($order['order_products'] as $order_product) {
				
				$product = ProductAttribute::where('product_id', $order_product['product_id'])
					->where('status', 1) 
					->where('size', $order_product['product_size']) 
					->first();
                $get_attr  = $product;
				
				if ($product && $product->stock >= $order_product['product_qty']) {
					
					$product->decrement('stock', $order_product['product_qty']);
					ProductAttribute::where('product_id',$order_product['product_id'])->where('status',1)->where('size',$order_product['product_size'])->update(['stock_alert'=>0]);
				
				
				        $stock_logs = new ProductAttributeLog;
						$stock_logs->attribute_id = $product->id;
						$stock_logs->action = '2'; /* qty update by new order */
						$stock_logs->qty = '-'.$order_product['product_qty'];
						
						$stock_remaining = $get_attr->stock -  $order_product['product_qty'];
						if($stock_remaining < 0){
							$stock_remaining = 0;
						} 
						$stock_logs->stock_remaining = $stock_remaining; 
						$stock_logs->message = 'Stock Removed';
						$stock_logs->order_id = $order_id;
						$stock_logs->save();
				
				
				
				
				
				
				
				} else {
					
					ProductAttribute::where('product_id', $order_product['product_id'])
					->where('status', 1)
					->where('size', $order_product['product_size'])
					->update(['stock' => 0]); // Set stock to 0
				
				ProductAttribute::where('product_id',$order_product['product_id'])->where('status',1)->where('size',$order_product['product_size'])->update(['stock_alert'=>0]);	
					
					
					    $stock_logs = new ProductAttributeLog;
						$stock_logs->attribute_id = $product->id;
						$stock_logs->action = '2'; /* qty update by new order */
						$stock_logs->qty =  $order_product['product_qty'];
						$stock_logs->stock_remaining = 0;
						$stock_logs->message = 'Stock Removed';
						$stock_logs->order_id = $order_id;
						$stock_logs->save();
					
					
				
				}
			}
	   }
	 }
	 
	 
	 
	 
	  public static function creditRewardPoints($orderId){ 
		  
		  /*
		  return true;
		  die();
		 
		$order = Order::with(['order_products'])->where('id', $orderId)->first();
        
		$orderTotal = $order['grand_total'];
		
		$userId = $order['user_id'];
		
		$points = (int) floor($orderTotal * 0.10); 
		
		User::where('id', $userId)->increment('loyalty_points', $points);

		LoyaltyPointLog::insert([
			'user_id'     => $userId,
			'order_id'    => $orderId,
			'points'      => $points,
			'type'        => 'earned',
			'description' => 'Reward points for Order #' . $orderId,
		]);
		*/
		
	  }
	  
	  
	  public static function redeemRewardPoints($orderId)
		{ /*
			return true;
		     die();
			
			$order = Order::where('id', $orderId)->first();

			$pointsUsed = $order['points_redeemed'] ?? 0;
			$userId = $order['user_id'];

			if ($pointsUsed <= 0) {
				return;
			}

			User::where('id', $userId)->decrement('loyalty_points', $pointsUsed);

			LoyaltyPointLog::insert([
				'user_id'     => $userId,
				'order_id'    => $orderId,
				'points'      => $pointsUsed,
				'type'        => 'redeemed',
				'description' => 'Redeemed on Order #' . $orderId,
			]); */
		}
	 
	 
	 
	 
    public static function trackOrder($awb){
        //$awb = '50706530545';
        
        $ch = curl_init();
		
		curl_setopt($ch, CURLOPT_URL, "http://api.bluedart.com/servlet/RoutingServlet?handler=tnt&action=custawbquery&loginid=LD910195&awb=awb&numbers=50706530545&format=xml&lickey=df88bee111fe614f8cdd26d382ef6133&verno=1.3&scan=1");
		
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		
		$output = curl_exec($ch);
		
		curl_close($ch);
		
		$new = simplexml_load_string($output);
		
		$con = json_encode($new);         
                        $result = json_decode($con,TRUE);
                        $i = 0;
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

                        return  $tracking; 
                }
            
			
			
		public static function check_order_return_exchange($order_id){
			$cancel  = '';
			$return   = '';
			$exchange   = '';
			$order = Order::with('order_products')->where('order_status','Delivered')->where('user_id',Auth::user()->id)->where('id',$order_id)->first(); 
			
			if(!empty($order)){
				$order_status = $order->order_status;
				$date1 = $order->created_at;
				$date2 = date('Y-m-d H:i:s');
				$diff = strtotime($date2) - strtotime($date1); 
				//$diff =  abs(round($diff / 86400));
				
				
				if($diff < 86400){
					$cancel  = 1;
				}	

                if($diff < 172800){
					
					foreach($order->order_products as $order_product){
						$check = ReturnRequest::where('order_product_id',$order_product->id)->count();
						if($check  == 0){
							$return   = 1;
							$exchange   = 1;
						}
					}
					
				
				}

			}
			return [
				'cancel'=>$cancel,
				'return'=>'',
				'exchange'=>$exchange
			];
			
			
		}			
			
			
}
