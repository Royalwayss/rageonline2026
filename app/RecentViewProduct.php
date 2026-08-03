<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RecentViewProduct extends Model
{
    //
    public function product(){
    	return $this->belongsTo('App\Product')->with('product_image');
    }
}
