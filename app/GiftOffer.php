<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GiftOffer extends Model
{
    //
    public static function gifts(){
    	$gifts = GiftOffer::where('status',1)->where('stock','>',0)->get()->toArray();
    	return $gifts;
    }

    public static function giftinfo($giftid){
    	$giftDetail = GiftOffer::where('id',$giftid)->first();
    	return $giftDetail;
    }
}
