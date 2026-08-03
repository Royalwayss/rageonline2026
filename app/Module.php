<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Auth;
class Module extends Model
{
    //
    protected $fillable = [
        'id','name', 'parent_id', 'view_route','edit_route','delete_route','icon','session_value','status','sortorder','shown_in_roles','table_name','created_at','updated_at'
    ];
	public static function getModules(){
    	if(Auth::guard('admin')->user()->type=="admin"){
    		$allModules = Module::where('status',1)->orderby('sortorder','ASC')->get();
	    	$allModules = json_decode(json_encode($allModules),true);
	    	return $allModules;
    	}else{
    		$getEmpModules = DB::table('admin_roles')->where(['admin_id'=>Auth::guard('admin')->user()->id,'view_access'=>'1'])->select('module_id')->get();
    		$getEmpModules = array_flatten(json_decode(json_encode($getEmpModules),true));
    		$allModules = Module::whereIn('id',$getEmpModules)->where('status',1)->orderby('sortorder','ASC')->get();
	    	$allModules = json_decode(json_encode($allModules),true);
	    	return $allModules;
    	}
    }

    public function undermodules(){
    	return $this->hasMany('App\Module','parent_id')->orderby('sortorder','asc');
    }
}
