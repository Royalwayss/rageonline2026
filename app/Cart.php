<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;
use App\Cart;
use Session;
use App\Product;
use App\ProductAttribute;
use DB;
use App\CouponCode;
use App\Category;
class Cart extends Model
{

    public function user(){
        return $this->belongstO('App\User','user_id')->select('id','name','email');
    }

    public function product(){
    	return $this->belongsTo('App\Product','product_id')->select('id','category_id','product_name','product_code','seo_url','short_description','product_description','product_price','current_discount','product_discount','status','color')->with('product_image')->with('category')->where('status',1);
    }

    public static function items($type){
        $cartitems = Cart::with('product')->join('products','products.id','=','carts.product_id')->select('carts.*','product_attributes.size','product_attributes.stock','product_attributes.color','product_attributes.sku','product_attributes.cut_price','product_attributes.price')->join('product_attributes','product_attributes.product_id','=','products.id')->whereColumn('product_attributes.size','carts.size')->whereColumn('carts.qty','<=','product_attributes.stock')->orderby('carts.id','desc')->where('product_attributes.stock','>',0)->where('products.status',1)->where('product_attributes.status',1);
        if(Auth::check()){
            $cartitems->where('carts.user_id',Auth::user()->id);  
        }else{
            $cartitems->where('carts.session_id',Session::get('cartsessionId'));
        }
        if($type=="listing"){
            $cartitems = $cartitems->get();  
            $cartitems = json_decode(json_encode($cartitems),true);
        }else{
            $cartitems = $cartitems->get(); 
              $total_cart_qty = 0;
              foreach($cartitems as $cartitem){
                $total_cart_qty +=  $cartitem['qty']; 
              }
              $cartitems = $total_cart_qty;
        }
        return $cartitems;
    }

    public static function totalitems(){
        $cartcount = Cart::items('count');
        return $cartcount;
    }

    public static function cartitems(){
        $getcartitems = Cart::items('listing');
        return $getcartitems;
    }

    public static function CalculateShipping($cartitems) {
        
         return 0; die();
        if($cartitems){
            if(Session::has('couponinfo')){
                if(Session::get('couponinfo')->type=="staff"){
                    $shipping =false;
                }else{
                    $shipping =true;
                }
            }else{
                $shipping =true;
            }
        }else{
            $shipping =false;
        } 
        if($shipping){
			/* $summer_category = array('6','7','8'); */
			$summer_category = Cart::get_summer_category_ids();
			$shipping_free = '';
            foreach($cartitems as $ckey=> $cart){
                $priceDetails = Cart::calProPricing($cart);
				$category_id = $priceDetails['category_id'];
				$priceArr[] =  $priceDetails['prosubtotal'];
				if (!in_array($category_id, $summer_category)){
					$shipping_free = 1;
				}	
				
               
            }
			if(!empty($shipping_free)){
				$subtotal = round(array_sum($priceArr));
				if($subtotal >= 2000){
					return 200;
				}else{
					return 100; //if need change the value 0 to actual amount
				}
			}else{
				return 0;
			}
        }else{
            return 0;
        }
    }

    public static function calProPricing($cartitem){ 
        if(!empty($cartitem['product']['product_discount'])){
				$price = $cartitem['price'] - ($cartitem['price'] * $cartitem['product']['product_discount'] /100);
				$strikePrice =  $cartitem['price'];
				/* $discount = $cartitem['product']['product_discount']; */
				$discount = round(($cartitem['price'] * ($cartitem['product']['product_discount']/100)));
				  $prosubtotal = $price * $cartitem['qty'];
        }else{ 
			  $catID = $cartitem['product']['category_id'];
			  $productPrice = $cartitem['price'];
			  $productDetails['product_price'] = $productPrice;
			  $productDetails['product_discount'] =$cartitem['product']['product_discount'];
			  $strikePrice =   Product::ProductPrice($catID,$productDetails);
			  $prosubtotal = $strikePrice * $cartitem['qty'];
			  $discount = $productPrice - $strikePrice;
		}
		
		if($strikePrice < 1000){
			$product_gst = '5';
		}else{
			$product_gst = '12';
		}
		
		
	  $category_id = $cartitem['product']['category_id'];
      return array('price'=> $strikePrice,'strikeprice'=>$strikePrice,'discount'=>$discount,'prosubtotal'=> $prosubtotal,'category_id'=>$category_id,'product_gst'=>$product_gst);
    }

    public static function cartdetails($cartitems,$mode=null){ 
        $priceArr = array();
        foreach($cartitems as $ckey=> $cart){
            $priceDetails = Cart::calProPricing($cart);
            $priceArr[] =  $priceDetails['prosubtotal'];
        }
        $subtotal = round(array_sum($priceArr));
        $coupon_discount =0;
		$total_order_discount =0;
        $shipping = Cart::CalculateShipping($cartitems);
        $grandtotal = round($subtotal);
        $couponcode = '';
        if(Session::has('couponinfo')){
            $couponcode = Session::get('couponinfo')->code;
            $coupon_discount = CouponCode::getCouponAmount(Session::get('couponinfo'),$subtotal);
			$total_order_discount += $coupon_discount;
			
			if(Session::get('couponinfo')['amount_type'] == 'Percentage'){
			
			       $coupon_discount_percentage = Session::get('couponinfo')['amount'];
			
			}else{
				   $coupon_discount_percentage = (Session::get('couponinfo')['amount']/$subtotal)*100;
			}
			
        }else{
			$coupon_discount_percentage = 0;
		}
		
		
		$prepaid_discount = 0;
		$order_discount = 0;
		
		/*
		
		if($subtotal >= 10000){
			$subtotal_after_coupon_discount = $subtotal-$total_order_discount;
			$order_discount_percentage  = 10;
			$order_discount = ($order_discount_percentage/100) * $subtotal_after_coupon_discount;
            $total_order_discount += $order_discount;
		}else{
			$subtotal_after_coupon_discount = $subtotal;
			$order_discount_percentage =0;
		}
		
		*/
		
		$subtotal_after_coupon_discount = $subtotal;
		$order_discount_percentage =0;
		
	     
		
		if($mode == 'phonepe' || $mode == 'ccavenue' || $mode == 'razorpay' ){
		    $prepaid_discount_percentage =5;
			
			$subtotal_after_order_discount = $subtotal - $total_order_discount; 
			$prepaid_discount = ($subtotal_after_order_discount/100) * $prepaid_discount_percentage; 
		    
			$total_order_discount += $prepaid_discount;
			$grandtotal = $subtotal - $total_order_discount;
		}else{
			$prepaid_discount_percentage = 0;
			$subtotal_after_order_discount = $subtotal- $total_order_discount;
			
			
			$grandtotal = $subtotal - $total_order_discount;
		}
		
		
		
		
		   
		
		
		
		if(Session::has('pointsinfo')){
			
			$amount_redeemed =  Session::get('pointsinfo')['amount']; 
            $points_redeemed =  Session::get('pointsinfo')['points'];   
		}else{
			$amount_redeemed  = $points_redeemed = 0;
		}
		
		
		
		
		
		
        $grandtotal = $grandtotal + $shipping;
		$final_grandtotal = round($grandtotal);
		$adjustment = $final_grandtotal - $grandtotal;
		$round_of = number_format($adjustment, 2);
		if($round_of == '0.00'){ $round_of = 0; }
        return array('subtotal'=>$subtotal,'discount'=>$coupon_discount,'coupon_discount_percentage'=>$coupon_discount_percentage,'subtotal_after_coupon_discount'=>$subtotal_after_coupon_discount,'order_discount'=>$order_discount,'subtotal_after_order_discount'=>$subtotal_after_order_discount,'prepaid_discount'=>$prepaid_discount,'prepaid_discount_percentage'=>$prepaid_discount_percentage,'total_order_discount'=>$total_order_discount,'order_discount_percentage'=>$order_discount_percentage,'prepaid_discount'=>$prepaid_discount,'grandtotal'=>$grandtotal,'final_grandtotal'=>$final_grandtotal,'round_of'=>$round_of,'couponcode'=>$couponcode,'shipping'=>$shipping,'amount_redeemed'=>$amount_redeemed,'points_redeemed'=>$points_redeemed);
    }
	
	
	
	
	
	 public static function applyPoints($points, $payment_mode)
	{
		// 1. User must be logged in
		if (!Auth::check()) {
			Session::forget('pointsinfo');
			return array('status' => false, 'message' => 'Please login to redeem points.');
		}

		// 2. Points must be a valid positive number
		$points = (int) $points;
		if ($points <= 0) {
			Session::forget('pointsinfo');
			return array('status' => false, 'message' => 'Please enter a valid number of points.');
		}

		$availablePoints = Auth::user()->loyalty_points;

		// 3. User must actually have points
		if ($availablePoints <= 0) {
			Session::forget('pointsinfo');
			return array('status' => false, 'message' => 'You have no reward points available.');
		}

		// 4. Can't redeem more than available balance
		if ($points > $availablePoints) {
			Session::forget('pointsinfo');
			return array('status' => false, 'message' => 'You only have ' . $availablePoints . ' points available.');
		}

		// 5. Cart must not be empty
		$cartitems = Cart::cartitems();
		if (empty($cartitems)) {
			Session::forget('pointsinfo');
			return array('status' => false, 'message' => 'Your cart is empty.');
		}

		$cartPricing = Cart::cartdetails($cartitems, $payment_mode);
		$grandtotal = $cartPricing['final_grandtotal'];

		// 6. Points value (1 point = ₹1) can't exceed the order's grand total
		if ($points > $grandtotal) {
			Session::forget('pointsinfo');
			return array('status' => false, 'message' => 'Points value cannot exceed the order total.');
		}
        Session::forget('pointsinfo');
		$pointsinfo['points'] = $points;
		$pointsinfo['amount'] = $points; /* 1 point = 1 rupee */

		Session::put('pointsinfo', $pointsinfo);
        $currently_availablePoints =  $availablePoints - $points;
        return array('status' => true, 'message' => 'Points Applied successfully!','currently_availablePoints'=>$currently_availablePoints);
	}
	
	
	
	
	
	
	public static function cartsSubtotal(){
		$subtotal = 0;
		$cartitems = Cart::cartitems();
		foreach($cartitems as $cartitem){
			$priceDetails = Cart::calProPricing($cartitem);
			$subtotal +=  $priceDetails['prosubtotal'];
		}
		return $subtotal;
	}
	public static function get_summer_category_ids(){
		$summer_category = Category::where('parent_id','16')->get();
		$summer_category_ids = [];
		foreach($summer_category as $value){
			$summer_category_ids[] = $value['id'];
		}
		return $summer_category_ids;
		
	}
}
