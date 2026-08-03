<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;
use App\OrderHistory;
use App\ReturnRequest;
class OrderProduct extends Model
{
    //
    protected $fillable = ['id','order_id','user_id','product_id','product_name','category_name','product_code','mrp','discount','discount_type','product_gst','product_price','product_qty','subtotal','product_size','product_sku','grand_total','created_at','updated_at'];

    public function productdetail(){
    	return $this->belongsTo('App\Product','product_id')->select('id','product_name','category_id','short_description','seo_url','final_price','color','productcolor')->with('product_image');
    }
	
	public static function check_return($id){
		$details = ReturnRequest::where('order_product_id',$id)->count();
        $details = json_decode(json_encode($details),true); 
		if(empty($details)){ 
			 return true;
		}else{

			return false;
		}
		
		
	}
}
