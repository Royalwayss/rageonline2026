<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\ProductAttribute;
use App\Product;
class ProductAttribute extends Model
{
    //
    public static function sizes(){
    	$sizes = ProductAttribute::select('size')->where('status',1)->groupby('size')->get();
    	return $sizes;
    }
    public static function getproductsizes($relatedcategory,$type=null){
		if($type == 'New Arrivals'){
			$products = Product::select('id')->where('new_arrival','Yes')->where('status',1)->get()->toArray();
	   }else if($type == 'Shop All'){
			$products = Product::select('id')->where('status',1)->get()->toArray();
	   }else{
			$explode = explode(',',$relatedcategory); 
			
			$products =  Product::select('products.id')
				->join('product_categories', 'product_categories.product_id', '=', 'products.id')
				->where('products.status', 1)
				->where(function($query) use ($explode) { 
					$query->whereIn('product_categories.category_id', $explode)
						  ->orWhereIn('products.category_id', $explode);
				 })
				->get()->toArray();
	   
	   }
		if(!empty($products)){
			$product_ids = array_column($products, 'id');
			$sizes = ProductAttribute::select('size')->where('status',1)->wherein('product_id',$product_ids)->groupby('size')->orderBy('sort','ASC')->get();
			return $sizes;
		}
		else
		{
			return array();
		}
		
		
	}
    public static function prosizes($productid){
    	$sizes = ProductAttribute::select('size')->where('product_id',$productid)->where('status',1)->where('stock','>',0)->groupby('size')->pluck('size')->toArray();
    	return $sizes;
    }
    public static function prosizes1($productid){
    	$sizes = ProductAttribute::select('size','sku')->where('product_id',$productid)->where('status',1)->where('stock','>',0)->groupby('size')->get();
    	return $sizes;
    }
    public static function attributeDetail($proid,$size){
    	$details = ProductAttribute::where(['product_id'=>$proid,'size'=>$size])->first();
    	return $details;
    }
    
     public static function stock($proid,$size){
    	$details = ProductAttribute::select('stock')->where(['product_id'=>$proid,'size'=>$size])->first();
    	return $details['stock'];
    }
     public static function getSku($proid,$sku){
    	$details = ProductAttribute::where('product_id',$proid)->where('sku', '!=' , $sku)->get();
    	return $details;
    }
}
