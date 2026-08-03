<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExchangeRequest extends Model
{
    //
    public static function checkExchange($id){
    	$check = ExchangeRequest::where('order_product_id',$id)->count();
    	if($check==0){
    		return 1;
    	}else{
    		return 0;
    	}
    }

}
