<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;
class ReturnRequest extends Model
{
    //
    public static function checkReturn($id){
    	$check = ReturnRequest::where('order_product_id',$id)->count();
    	if($check==0){
    		return 1;
    	}else{
    		return 0;
    	}
    }
	
	
	public static function send_mail($id){ 
	  
	    if(env('MAIL_MODE') =="live"){
			            $data = ReturnRequest::where('id',$id)->first();
			            $product = OrderProduct::with('productdetail')->where('id',$data->order_product_id )->first();// pd($product);
						$action = $data->action;
                        $emails = array('info@rageonline.com'); 
                        $messageData = [
						   'data' =>$data, 
						   'product' =>$product
					
						];
                        Mail::send('emails.exchange_return_request', $messageData, function($message) use ($emails,$action){
                            $message->to($emails)->subject($action.' request has been received from '.config('constants.project_name'));
                        });
        }
	}
	
	
	
	
	

}
