<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\BilllingAddress;
use Auth;
class BillingAddress extends Model
{
    //
	protected $fillable = [
        'user_id','name','first_name','last_name','mobile','alternative_number','country','country_code1','country_code2','state','city','postcode','address','address2','company_name','gstin','is_default'
    ];
	
	public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public static function addresses(){
    	$addresses = BillingAddress::where('user_id',Auth::user()->id)->first();
    	return $addresses;
    }

    public static function addresscount($userid){
    	$count = BillingAddress::where('user_id',$userid)->count();
    	return $count;
    }
}
