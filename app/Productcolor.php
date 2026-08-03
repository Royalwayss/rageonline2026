<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class Productcolor extends Model
{
    //
    public static function productcolors(){
        $colors = DB::table('productcolors')->select('id','product_color','image','color_code')->orderby('product_color','asc')->get();
        return $colors;
    }
}
