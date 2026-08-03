<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Category;
use DB;
class Controller extends BaseController
{
	public $mode;
	
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    public function __construct(){
        $whitelist = array(
            '127.0.0.1',
            '::1',
            '192.168.0.12'
        );
        if(!in_array($_SERVER['REMOTE_ADDR'], $whitelist)){
            $this->mode = "live";
        }else{
            $this->mode = "local";
        }
    }

    public function getcategories(){
    	$getCategories = Category::with(['subcategories'=>function ($query) {
            $query->with('subcategories');
        }])->select('id','name','parent_id')->where('parent_id',NULL)->get();
        $getCategories = json_decode(json_encode($getCategories),true);
        return $getCategories;
    }
}