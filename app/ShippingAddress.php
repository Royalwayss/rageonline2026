<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\ShippingAddress;
use Auth;
class ShippingAddress extends Model
{
    //
	protected $fillable = [
        'user_id','name','first_name','last_name','mobile','country','state','city','postcode','address','address2','company_name','gstin','is_default'
    ];

    public static function addresses(){
    	$addresses = ShippingAddress::where('user_id',Auth::user()->id)->first();
    	return $addresses;
    }

    public static function addresscount($userid){
    	$count = ShippingAddress::where('user_id',$userid)->count();
    	return $count;
    }
}
