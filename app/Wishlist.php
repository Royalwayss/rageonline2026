<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Wishlist;
use Auth;
class Wishlist extends Model
{
    //
    public function product(){
    	return $this->belongsTo('App\Product','product_id')->select('id','category_id','product_name','product_code','seo_url','current_discount','product_discount','product_price','final_price','color','status')->with('product_image');
    }

	public static function wishlists(){
		$wishlists= Wishlist::with('product')->where('user_id',Auth::user()->id)->get();
		return $wishlists;
	}

    public static function checkwishlist($proid){
    	$check = Wishlist::where([
                'user_id'=>Auth::user()->id,
                'product_id' => $proid
            ])->count();
    	return $check;
    }
}
