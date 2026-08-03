<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\ProductAttribute;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class Cron extends Model
{
    public static function stock_alert_mail(){
		
		$product_attributes = ProductAttribute::select('product_attributes.*','products.product_name','products.seo_url','products.product_code','categories.name as category_name','categories.seo_unique as category_url')
			->join('products','products.id','product_attributes.product_id')
			->join('categories','categories.id','products.category_id')
			->where('product_attributes.stock_alert','0')
			->where('product_attributes.stock','<=','2')
			->where('product_attributes.status','1')
			->where('products.status','1')
			->where('categories.status','1')
			->get()->toArray();
			
		  /* Send Mail */
          if(!empty($product_attributes)){
			  if(env('MAIL_MODE') =="live" ){
				     
                   
                    $messageData = [
                        'product_attributes' => $product_attributes
                    ];
					   $admin_mail =   config('constants.admin_mail'); 
						Mail::send('emailtemplate.to_admin.stock-alert-mail', $messageData, function($message) use ($admin_mail){
							$message->to($admin_mail)
							->subject('New Stock Alert from '.config('constants.project_name').'. Date - '.date('d-m-Y H:i:s a'));
						}); 
							
				}
				
				
				
				
			
				
		  }
		  foreach($product_attributes as $product_attribute){
					ProductAttribute::where('id',$product_attribute['id'])->update(['stock_alert'=>1]);
				}
		  
		  
          /* Send Mail */
          //Log::info('Cronjob run successfuly');
	}
}
