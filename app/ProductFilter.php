<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class ProductFilter extends Model
{
    //
    protected $fillable = [
        'id','type','value','description','sort','status'
    ];

    

    public static function filterids($values){
        $ids = array();
        $filterids = ProductFilter::whereIn('value',$values)->get()->pluck('id');
        if(count($filterids)>0){
           $ids =  $filterids->toArray();
        }
        return $ids;
    }
}
