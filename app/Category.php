<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Category;
use Illuminate\Support\Facades\Redirect;
class Category extends Model
{
    //
    public function subcategories(){
    	return $this->hasMany('App\Category','parent_id')->select('id','name','parent_id','seo_unique','filters','description','image')->orderby('sort','ASC')->where('status',1);
    }

    public function subcat(){
    	return $this->belongsTo('App\Category','parent_id');
    }

    public static function getcategories(){
    	$getcategories = Category::with('subcategories')->where(['parent_id'=>NULL,'status'=>1])->orderby('sort','ASC')->get();
    	$getcategories = json_decode(json_encode($getcategories),true);
    	return $getcategories;
    }
    public static function getsubcategories(){
    	$getcategories = Category::with('subcategories')->where(['status'=>1])->where('parent_id', '!=' , NULL)->orderby('sort','ASC')->get();
    	$getcategories = json_decode(json_encode($getcategories),true);
    	return $getcategories;
    }
    public static function getcatdetails($catseo){
		if($catseo == 'new-arrivals'){
			    $getCatdetail['meta_title'] = 'New  Arrivals products';
			    $getCatdetail['meta_description'] = '';
			    $getCatdetail['meta_keyword'] = '';
			    $getCatdetail['parent_id'] = '';
			    $getCatdetail['name'] = 'New Arrivals';
			    $getCatdetail['subcategories'] = '';
			    $getCatdetail['id'] = '';
			    $getCatdetail['seo_unique'] = '';
				$resp = array('status'=>true,'catids'=>array(),'catdetail'=>$getCatdetail);
				return $resp;	
		}else if($catseo == 'shop-all'){
			    $getCatdetail['meta_title'] = 'Shop All products';
			    $getCatdetail['meta_description'] = '';
			    $getCatdetail['meta_keyword'] = '';
			    $getCatdetail['parent_id'] = '';
			    $getCatdetail['name'] = 'Shop All';
			    $getCatdetail['subcategories'] = '';
			    $getCatdetail['id'] = '';
			    $getCatdetail['seo_unique'] = '';
				$resp = array('status'=>true,'catids'=>array(),'catdetail'=>$getCatdetail);
				return $resp;	
		}else{
				$getCatdetail = Category::with(['subcategories'=>function($query){
						$query->with('subcategories');
					}])->where('seo_unique',$catseo)->where('status',1)->select('id','name','description','seo_unique','meta_title','meta_keyword','meta_description','filters','parent_id','image')->first();
				$getCatdetail = json_decode(json_encode($getCatdetail),true);
				if(empty($getCatdetail)){
					$resp = array('status'=>false);
					return $resp;
				}
				$catids =array();
				$catids[] = $getCatdetail['id'];
				foreach($getCatdetail['subcategories'] as $subcat){
					$catids[] = $subcat['id'];
					foreach($subcat['subcategories'] as $subsubcat){
						$catids[] = $subsubcat['id'];
					}
				}
				$resp = array('status'=>true,'catids'=>$catids,'catdetail'=>$getCatdetail);
				return $resp;
		}
    }

    public function products(){
        return $this->hasMany('App\Product','category_id')->where('status',1)->where('visible',1);
    }

    public static function catproducts(){
        $categories = Category::with('products')->where('status',1)->get();
        $categories = json_decode(json_encode($categories),true);
        return $categories;
    }
}
