<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Cart;
use App\Product;
use App\Category;
use Session;
use DB;
use Auth;
class CouponCode extends Model
{
    public static function applycouponcode($code){
        $cartitems = Cart::cartitems();
        //echo "<pre>"; print_r($cartitems); die;
        $priceArr = array();$totalitems =0;$catids =array();$skuids =array();
        foreach($cartitems as $ckey=> $cart){
            $catids[] = $cart['product']['category_id'];
			$skuids[] = $cart['sku'];
            $totalitems += $cart['qty'];
        	$priceDetails = Cart::calProPricing($cart);
            $priceArr[] =  $priceDetails['prosubtotal'];
        }
        $catids = array_unique($catids);
		
		$skuids = array_unique($skuids);
        
        $producttotal = array_sum($priceArr);
        $response = array('status'=> false,'message'=>'Invalid coupon code. Please try with some vaild coupon code.'); 
         $checkcoupon =CouponCode::where(['code'=>$code,'status'=>1])
                    ->where('expiry_date','>=',date('Y-m-d'))
					 ->where('start_date','<=',date('Y-m-d'))
                    ->where('max_amount','>=',$producttotal)
                    ->first();
        if($checkcoupon){
			$user_emails = $checkcoupon['user_emails'];

			$user_emails_array = explode(',',$user_emails);

			$user_email = Auth::user()->email;
            if($user_email != ''){
				 if(in_array($user_email, $user_emails_array))
				  {
						$valid_email = true;
				  }
				  else
				  {
						$valid_email = '';
				  }
			}else{
				$valid_email = true;
			}
			$is_product_sku_empty = '';
			if($checkcoupon->product_sku == ''){
				$is_product_sku_empty = true;
			}
			
            if($checkcoupon->categories !="" || $checkcoupon->product_sku !=""){
                $explodeCats = explode(',',$checkcoupon->categories);
				$explodeSkus = explode(',',$checkcoupon->product_sku);
                //Category::pluck('id')->toArray();
            }
            if(!isset($explodeCats)){
				$explodeCats = array();
			} 
			if(!isset($explodeSkus)){
				$explodeSkus = array();
			} 
			
			if(empty($explodeCats) ||  empty($explodeSkus) || empty($checkcoupon['user_emails'])){
			     $coupon_for_all = true;
			}else{
				 $coupon_for_all = '';
			}
			
			
			if($checkcoupon['coupon_for_new_user'] == '1'){
				
				$check_order_count = Order::where('user_id',Auth::user()->id);
				$check_order_count = $check_order_count->where('coupon_code',$code);
				$check_order_count = $check_order_count->where('order_status','!=','Abandoned');
				$check_order_count = $check_order_count->where('order_status','!=','Payment Failure');
				$check_order_count = $check_order_count->where('order_status','!=','Cancelled');
				$check_order_count = $check_order_count->where('order_status','!=','Pending');
				$check_order_count = $check_order_count->count();
				
				
				if(!empty($check_order_count)){
					     Session::forget('couponinfo');
                         $response = array('status'=> false,'message'=>'This coupon only for new user.');
				         return $response; die();
				}
			}
			
			
			
            if((count(array_intersect($explodeCats, $catids)) == count($catids) || count(array_intersect($explodeSkus, $skuids)) == count($skuids) || $is_product_sku_empty == true) && ($valid_email == true) || $coupon_for_all == true ){
                if($checkcoupon->min_qty <= $totalitems){
                    if($checkcoupon->min_amount <= $producttotal){
                        $minusCouponAmount = CouponCode::getCouponAmount($checkcoupon,$producttotal);
                        if($producttotal > $minusCouponAmount ){ 
                        	$grandtotal = $producttotal - $minusCouponAmount;
                            if($checkcoupon->coupon_type =="Single Time"){
                            	$checkCouponUsed=0;
                            	//Later will used for orders
                                $checkCouponUsed = DB::table('orders')->where('user_id',Auth::user()->id)->where('coupon_code',$checkcoupon->code)->wherein('payment_status',['cod','captured'])->count();
                                if($checkCouponUsed==0){
                                    Session::forget('giftSession');
                                    Session::put('couponinfo',$checkcoupon);
                                    $response = array('status'=> true,'message' =>'Coupon Applied successfully!');
                                }else{
                                    Session::forget('couponinfo');
                                }
                            }else{
                                Session::forget('giftSession');
                                Session::put('couponinfo',$checkcoupon);
                                $response = array('status'=> true,'message'=>' Coupon Applied successfully!');
                            }
                        }else{
                            Session::forget('couponinfo');
                            $response = array('status'=> false,'message'=>' Please add more products in cart to avail this coupon');
                        }
                    }else{
                        Session::forget('couponinfo');
                        $response = array('status'=> false,'message'=>' Shop for Rs. '.$checkcoupon->min_amount.' or above to avail this coupon.');
                    }
                }else{
                    Session::forget('couponinfo');
                    $response = array('status'=> false,'message'=>'Shop for '.$checkcoupon->min_qty ." or more products to avail this coupon");
                }
            }else{
                Session::forget('couponinfo');
                $response = array('status'=> false,'message'=>'This coupon is not valid for products in cart');
            }
        }else{
            Session::forget('couponinfo');
        }
        return $response;
    }
	
    public static function getCouponAmount($checkcoupon,$producttotal){
        if($checkcoupon->amount_type == "Rupees") {
            $minusCouponAmount = $checkcoupon->amount;
        }else{
            $minusCouponAmount = ($producttotal * $checkcoupon->amount)/100;
        }
        return $minusCouponAmount;
    }

    public static function checkCouponStatus(){
		if(Session::has('couponinfo')){
			$checkstatus = CouponCode::where('code',Session::get('couponinfo')['code'])->first();
			if(!empty($checkstatus) &&  $checkstatus->status == 0){
				Session::forget('couponinfo');
			}
			if(!empty($checkstatus) &&  $checkstatus->expiry_date < date('Y-m-d')){
				Session::forget('couponinfo');
			}
		}
        return true;
    }

    public static function availableCoupons($cartitems){
        $priceArr = array();$totalitems =0;$catids =array();
        foreach($cartitems as $ckey=> $cart){
            $catids[] = $cart['product']['category_id'];
            $totalitems += $cart['qty'];
            $priceDetails = Cart::calProPricing($cart);
            $priceArr[] =  $priceDetails['prosubtotal'];
        }
        $catids = array_unique($catids);
        $producttotal = array_sum($priceArr);
        $coupons = CouponCode::where('expiry_date','>=',date('Y-m-d'))
                            ->where('min_qty','<=',$totalitems)
                            ->where('max_qty','>=',$totalitems)
                            ->where('min_amount','<=',$producttotal)
                            ->where('max_amount','>=',$producttotal)
                            ->where('status',1)
                            ->where('visible',1)
                            ->where(function ($q) {
                                $q->whereRaw('FIND_IN_SET("'.Auth::user()->email.'",user_emails)')->orwhere('user_emails','=','');
                            })
                            ->get()
                            ->toArray();
        $availableCoupons = array();
        //this below code is not as much good we can do it in more better way later
        foreach($coupons as $ckey=> $coupon){
            //Check coupon used in orders
            if($coupon['coupon_type'] =='Single Time'){
                $checkCouponUsed = Order::checkCouponUsed($coupon['code']);
                if($checkCouponUsed == 0){
                    $availableCoupons[$ckey] = $coupon;
                }
            }else{
                $availableCoupons[$ckey] = $coupon;
            }
        }
        return $availableCoupons;
    }
}
