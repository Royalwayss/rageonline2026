<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payu extends Model
{
    //
    public static function payudetails(){
    	/*if(env('PAYU_MODE') =='test'){
            $PAYU_BASE_URL ='https://test.payu.in';
            $INFO_PAYU_BASE_URL ='https://test.payu.in/merchant/postservice?form=2';
        	$MERCHANT_KEY ='7rnFly';
        	$SALT = 'pjVQAWpA';
        }else{
            $PAYU_BASE_URL ='https://secure.payu.in';
            $INFO_PAYU_BASE_URL ='https://info.payu.in/merchant/postservice?form=2';
        	$MERCHANT_KEY ='EYTnrC';
            $SALT = 'pXBqedKx';
        } */
		
		    $PAYU_BASE_URL ='https://test.payu.in';
            $INFO_PAYU_BASE_URL ='https://test.payu.in/merchant/postservice?form=2';
        	$MERCHANT_KEY ='7rnFly';
        	$SALT = 'pjVQAWpA';
        return array('INFO_PAYU_BASE_URL'=>$INFO_PAYU_BASE_URL,'PAYU_BASE_URL'=>$PAYU_BASE_URL,'MERCHANT_KEY'=>$MERCHANT_KEY,'SALT'=>$SALT);
    }
}
