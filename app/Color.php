<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class Color extends Model
{
    //
    public static function colors(){
        $colors = DB::table('colors')->select('id','color_name','image')->get();
        return $colors;
    }
}
