<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductReview extends Model
{
    public function product_details(){
    	return $this->belongsTo('App\Product','product_id')->select('id','product_name','category_id','short_description','seo_url','final_price','color','productcolor');
    }
}
