<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class Fabric extends Model
{
    //
    public static function fabric(){
        $fabric = DB::table('fabrics')->select('id','fabric_name')->get();
        return $fabric;
    }
}
