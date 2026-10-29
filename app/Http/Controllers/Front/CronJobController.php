<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Cart;
use App\Product;
use App\User;
use App\Category;
use App\Razorpay;
use App\ProductAttribute;
use Illuminate\Support\Str; 
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Http;
use App\Order;
use App\OrderHistory;
use  Session;
class CronJobController extends Controller
{
    //
    public function cartReminder(){
    	$date = date('Y-m-d', strtotime('-2 days'));
    	$users = Cart::with('user')->select('user_id')->whereDate('created_at',$date)->where('reminder_sent','no')->take(20)->get()->toArray();
    	foreach($users as $user){
    		$cartItems = Cart::with('product')->join('products','products.id','=','carts.product_id')->select('carts.*','product_attributes.size','product_attributes.stock','product_attributes.sku','product_attributes.price')->join('product_attributes','product_attributes.product_id','=','products.id')->whereColumn('product_attributes.size','carts.size')->whereColumn('carts.qty','<=','product_attributes.stock')->orderby('carts.id','desc')->where('product_attributes.stock','>',0)->where('products.status',1)->where('product_attributes.status',1)->where('user_id',$user['user_id'])->get()->toArray();
    		//echo "<pre>"; print_r($cartItems); die;
    		if(!empty($cartItems)){
    			Cart::where('user_id',$user['user_id'])->update(['reminder_sent'=>'no']);
    			$email = $user['user']['email'];
    			$messageData = [
	                'cartitems' => $cartItems,
	                'user'      => $user
	            ];
	            Mail::send('emails.cart-reminder', $messageData, function($message) use ($email){
	                $message->to($email)->subject('You have a few item(s) left in your cart, Shop Now !');
	            });
    		}
    	}
    	return 'ok';
    }



    public function cartRemindermail(){
    	$date = date('Y-m-d');
    	$users = Cart::with('user')->select('user_id')->whereDate('created_at',$date)->take(20)->get()->toArray();
    	foreach($users as $user){
    	    
    	    $del= 0;
    		$cartItem = Cart::with('product')->join('products','products.id','=','carts.product_id')->select('carts.*','product_attributes.size','product_attributes.stock','product_attributes.sku','product_attributes.price')->join('product_attributes','product_attributes.product_id','=','products.id')->whereColumn('product_attributes.size','carts.size')->whereColumn('carts.qty','<=','product_attributes.stock')->orderby('carts.id','desc')->where('product_attributes.stock','>',0)->where('products.status',1)->where('product_attributes.status',1)->where('carts.next_expiry_date',$date)->where('carts.step', '!=' ,'4')->where('user_id',$user['user_id'])->get()->toArray();
    	    if(count($cartItem)>0){
        		foreach($cartItem as $cartItems){
            		if(!empty($cartItems)){
            		    
            		    if($cartItems['step']==0){
            		        
            		        $step = 1;
            		        $next_expiry_date = date('Y-m-d', strtotime("+3 days", strtotime($date)));
            		        
            		    }elseif($cartItems['step']==1){
            		        
            		        $step = 2;
            		        $next_expiry_date = date('Y-m-d', strtotime("+7 days", strtotime($date)));
            		        
            		    }elseif($cartItems['step']==2){
            		        
            		        $step = 3;
            		        $next_expiry_date = date('Y-m-d', strtotime("+7 days", strtotime($date)));
            		        
            		    }elseif($cartItems['step']==3){
            		        
            		        $step = 4;
            		        $next_expiry_date = date('Y-m-d');
            		        ProductAttribute::where('product_id',$cartItems['product_id'])->where('size',$cartItems['size'])->update(['stock'=>$cartItems['qty']]);
            		        Cart::where('product_id',$cartItems['product_id'])->where('size',$cartItems['size'])->delete();
            		        $del = 1;
            		    }
                		 if($del==0){   
                		    Cart::where('user_id',$user['user_id'])->where('product_id',$cartItems['product_id'])->where('size',$cartItems['size'])->update(['step'=>$step,'next_expiry_date'=>$next_expiry_date]);
                		 }
            		}
        		}
        		if($del==0){ 
        			$email = $user['user']['email'];
        			$messageData = [
                        'cartitems' => $cartItem,
                        'user'      => $users[0]
                    ];
                    Mail::send('emails.cart-reminder-mail', $messageData, function($message) use ($email){
                        $message->to($email)->subject('You have a few item(s) left in your cart, Shop Now !');
                    });
        		}
    	    }
    	}
    	return 'ok';
    }
    public function payumoneycallback(Request $request){
        $data = $request->all();
        $respStatus = "Results: " . print_r($data,true);
        mail('mkanum786@gmail.com','Test',$respStatus,'From: care@miarcus.com');
    }
    
    public function googleFeedText(){
        $myFile = "google-feed.txt";
        $fo = fopen($myFile, 'w') or die("can't open file");
        $exportProducts = Product::with(['product_image'])->where('products.product_stock','>',0)->orderby('id','DESC')->select('products.id','products.product_name','products.final_price','products.short_description','products.seo_url')->where('products.status',1)->get();
        $exportProducts = json_decode(json_encode($exportProducts),true);
        $stringData = "id"."\t"."title"."\t"."description"."\t"."link"."\t"."image_link"."\t"."condition"."\t"."availability"."\t"."price"."\t"."brand"."\t"."google_product_category"."\r\n";
        $prods =array();
        foreach($exportProducts as $key => $product){
            $seo_url = url('/product/'.$product['seo_url']);
            $proimage ="";
            if(isset($product['product_image']['image'])){
                $proimage =  url('images/ProductImages/medium/'.rawurlencode($product['product_image']['image']));
            }
            $stringData .= $product['id']."\t".ucwords(strtolower($product['product_name']))."\t".ucwords(strtolower($product['product_name']))."\t".$seo_url."\t".$proimage."\t"."new"."\t"."in stock"."\t".$product['final_price']."\t".'Rage'."\t"."Apparel & Accessories > Clothing"."\r\n";
        }
        fwrite($fo, $stringData);
        fclose($fo);
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename='.basename('google-feed.txt'));
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize('google-feed.txt'));
        readfile('google-feed.txt');
        exit;
    }
	
	public function feed($type){ 
	    
		$types = array('google','facebook');
		
		if (in_array($type,$types)){
			$catids = array('6','7','8');
			Session::put('category_ids',$catids);
			if($type == 'google'){
					$myFile = "google-feed.txt";
					$fo = fopen($myFile, 'w') or die("can't open file");
					$stringData  = "id"."\t";
					$stringData .= "title"."\t";
					$stringData .=	"description"."\t";
					$stringData .=	"availability"."\t";
					$stringData .=	"condition"."\t";
					$stringData .=	"price"."\t";
					$stringData .=	"link"."\t";
					$stringData .=	"image_link"."\t";
					
					
					$stringData .=	"brand \t";
					$stringData .=	"google_product_category \r\n";
					
					
					$prods =array();
					$exportProducts = Product::with(['product_image'])->whereIn('category_id',$catids)->where('products.product_stock','>',0)->orderby('id','DESC')->select('products.id','products.product_name','products.final_price','products.product_stock','products.short_description','products.product_description','products.seo_url')->where('products.status',1)->get();
			        $exportProducts = json_decode(json_encode($exportProducts),true);
					foreach($exportProducts as $key => $product){
						
						$seo_url = url('/product/'.$product['seo_url']);
						$proimage ="";
						if(isset($product['product_image']['image'])){
							$proimage =  url('images/ProductImages/medium/'.rawurlencode($product['product_image']['image']));
						}
						$price = round($product['final_price']);
						if($product['product_stock'] > 0){
							$availability = 'In stock';
						}else{
							$availability = 'Out of stock';
						}
						$stringData .= $product['id']."\t";
						$stringData .= ucwords(strtolower($product['product_name']))."\t";
						$stringData .= ucwords(strtolower($product['product_name']))."\t";
						$stringData .= $availability."\t";
						$stringData .= 'New'."\t";
						$stringData .= $price."\t";
						$stringData .= $seo_url."\t";
						$stringData .= $proimage."\t";
						$stringData .= 'Rage'."\t";
						$stringData .= "Apparel & Accessories > Clothing"."\r\n";
						
					}
					fwrite($fo, $stringData);
					fclose($fo);
					header('Content-Type: application/octet-stream');
					header('Content-Disposition: attachment; filename='.basename('google-feed.txt'));
					header('Expires: 0');
					header('Cache-Control: must-revalidate');
					header('Pragma: public');
					header('Content-Length: ' . filesize('google-feed.txt'));
					readfile('google-feed.txt');
			}else if($type == 'facebook'){
				
				$headers = array(
					'Content-Type'        => 'text/csv',
					'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
					'Content-Disposition' => "attachment; filename=facebook-feed.csv",
					'Expires'             => '0',
					'Pragma'              => 'public',
                );
            
			  $data = array();
			  $response = new StreamedResponse(function() use($data,$catids) {
                // Open output stream
                $handle = fopen('php://output', 'w');
                // Add CSV headers
                fputcsv($handle, ['id','title','description','availability','condition','price','link','image_link','brand','google_product_category','facebook_product_category']);
                $exportProducts = Product::with(['product_image'])->where('products.product_stock','>',0)->orderby('id','DESC')->select('products.id','products.product_name','products.final_price','products.product_stock','products.short_description','products.product_description','products.seo_url')->where('products.status',1);
                // $exportProducts  = User::orderby('id','DESC');
                 
				$exportProducts = $exportProducts->chunk(500, function($products) use($handle) {
                    foreach ($products as $product){
						
						$seo_url = url('/product/'.$product['seo_url']);
						$proimage ="";
						if(isset($product['product_image']['image'])){
							$proimage =  url('images/ProductImages/medium/'.$product['product_image']['image']);
						}
						$price = round($product['final_price']);
						if($product['product_stock'] > 0){
							$availability = 'in stock';
						}else{
							$availability = 'Out of stock';
						}
                        fputcsv($handle, [
                            $product['id'],
                            ucwords(strtolower($product['product_name'])),
                            ucwords(strtolower(strip_tags($product['product_description']))),
							$availability,
                            'New',
                            $price,							
                            $seo_url,
                            $proimage,
							'Rage',
                            'Apparel & Accessories > Clothing',
                            'clothing & accessories > clothing accessories'
                        ]);
                    }
                });
                // Close the output stream
                fclose($handle);
            }, 200, $headers);

            return $response->send();
			}
		}else{
			exit;
		}
	
	
	   
	}

    /*
     * Check Razorpay payment status for unpaid orders and update the database.
     * /check-payment-status        -> checks razorpay orders of the last 2 days that are not captured yet
     * /check-payment-status/{id}   -> checks one order (orders.id)
     * Uses orders.razorpay_order_id (order_xxx) and Razorpay::credentials() for the keys.
     */
    public function checkPaymentStatus($id = null){
        
		
		$credentials = Razorpay::credentials();
		
		$keyId     = $credentials['RAZORPAY_KEY'];
        $keySecret = $credentials['RAZORPAY_SECRET_KEY'];

        $query = Order::where('payment_method','razorpay')->whereNotNull('razorpay_order_id')->where('razorpay_order_id','!=','');
        
		if(!empty($id)){
            $query->where('id',$id);
        }else{
            $query->where(function($q){
                $q->whereNull('payment_status')->orWhere('payment_status','!=','captured')->orWhereNull('razorpay_payment_id')->orWhere('razorpay_payment_id','');
            })->where('created_at','>=',date('Y-m-d H:i:s', strtotime('-2 days')));
        }
		
        $orders = $query->orderby('id','desc')->take(50)->get();
        
        $result = [];
        foreach($orders as $order){
            $rzpOrderId = trim($order->razorpay_order_id);
            $auth       = Http::withBasicAuth($keyId, $keySecret);

            $captured = null;
            $failed   = 0;
            $payments = [];
            $paid     = false;
            $orderInfo = null;
            $error    = null;
            $payError = null;

            // 1) Razorpay order itself: status = created / attempted / paid
            $r1 = $auth->get('https://api.razorpay.com/v1/orders/'.$rzpOrderId);
            if($r1->successful()){
                $orderInfo = $r1->json();
                if((isset($orderInfo['status']) && $orderInfo['status'] == 'paid') || (!empty($orderInfo['amount_paid']) && $orderInfo['amount_paid'] > 0)){
                    $paid = true;
                }
            }else{
                $error = $r1->body();
            }

            // 2) Payments made against that order
            $r2 = $auth->get('https://api.razorpay.com/v1/orders/'.$rzpOrderId.'/payments');
            if($r2->successful()){
                $json     = $r2->json();
                $payments = isset($json['items']) ? $json['items'] : [];
            }

            // 3) If a payment id is saved on the order (txn_id = pay_xxx), check that payment directly
            $payId = '';
            foreach(['txn_id','razorpay_payment_id'] as $col){
                if(!empty($order->$col) && strpos(trim($order->$col),'pay_') === 0){
                    $payId = trim($order->$col);
                    break;
                }
            }
            if(empty($payments) && $payId != ''){
                $r3 = $auth->get('https://api.razorpay.com/v1/payments/'.$payId);
                if($r3->successful()){
                    $payments = [$r3->json()];
                }else{
                    $payError = $r3->body();
                }
            }

            foreach($payments as $payment){
                if(isset($payment['status']) && $payment['status'] == 'captured'){
                    $captured = $payment;
                    break;
                }
                if(isset($payment['status']) && $payment['status'] == 'failed'){
                    $failed++;
                }
            }

            if($captured || $paid){
                $new = 'captured';
            }elseif(count($payments) > 0 && $failed == count($payments)){
                $new = 'failed';
            }elseif(!empty($payments) && isset($payments[0]['status']) && $payments[0]['status'] == 'authorized'){
                $new = 'authorized';
            }else{
                $new = $order->payment_status; // no payment found - leave as is
            }

            if($new != $order->payment_status){
                $response = $captured ? $captured : ($payments ? $payments : $orderInfo);
                $webhook_payment_response = json_encode($response);
                
                if($new == 'captured'){
                    $paymentId = $captured ? $captured['id'] : ($payId != '' ? $payId : null);

                    // update only once (so stock / reward points are never processed twice)
                    $affected = Order::where('id',$order->id)
                        ->where(function($q){ $q->whereNull('payment_status')->orWhere('payment_status','!=','captured'); })
                        ->update([
                            'razorpay_payment_id'      => $paymentId,
                            'payment_status'           => 'captured',
                            'order_status'             => 'Payment Captured',
                            'webhook_payment_response' => $webhook_payment_response,
                        ]);

                    if($affected){
                        // same process as RazorpayController::dopayment()
                       // OrderHistory::where('order_id',$order->id)->delete();
                        $requestdata['order_status'] = 'Payment Captured';
                        $requestdata['comments']     = 'Payment has been received';
                        $requestdata['order_id']     = $order->id;
                        OrderHistory::create($requestdata);

                        if(env('MAIL_MODE') == "live"){
                            (new Order)->sendOrderEmail($order->id);
                        }
                        Order::update_stock($order->id);
                       /* Order::creditRewardPoints($order->id);*/
						
                    }
                }else{
                    Order::where('id',$order->id)->update(['payment_status'=>$new, 'webhook_payment_response'=>$webhook_payment_response]);
                }
            }

            // save razorpay_payment_id if it is not saved in orders table yet
            $latest = $captured ? $captured : (!empty($payments) ? $payments[0] : null);
            $savedPaymentId = null;
            if($latest && !empty($latest['id']) && empty($order->razorpay_payment_id)){
                $upd = ['razorpay_payment_id'=>$latest['id']];
                if(empty($order->webhook_payment_response)){
                    $upd['webhook_payment_response'] = json_encode($latest);
                }
                Order::where('id',$order->id)->update($upd);
                $savedPaymentId = $latest['id'];
            }

            $result[] = [
                'order_id'          => $order->id,
                'razorpay_order_id' => $rzpOrderId,
                'razorpay_order_status' => $orderInfo['status'] ?? null,
                'amount_paid'       => $orderInfo['amount_paid'] ?? null,
                'payments_found'    => count($payments),
                'payment_id_saved'  => $savedPaymentId,
                'old_status'        => $order->payment_status,
                'new_status'        => $new,
                'key_mode'          => substr($keyId,0,8),
                'payment_id_checked'=> $payId,
                'error'             => $error,
                'payment_error'     => $payError,
            ];
        }

        return response()->json($result);
    }

}