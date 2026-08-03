<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Cart;
use App\Product;
use App\User;
use App\Category;
use App\ProductAttribute;
use Illuminate\Support\Str; 
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\Support\Facades\Mail;
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
	
	
	
	
	
	
	
	
	
}
