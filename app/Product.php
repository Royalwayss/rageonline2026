<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Product;
use App\Category;
use App\CouponCode;
use DB;
use Auth;
class Product extends Model
{
    public function product_categories(){
        return $this->belongsToMany('App\ProductCategory','product_categories','product_id','category_id');
    }

    public function product_image(){
        return $this->hasOne('App\ProductImage','product_id')->orderby('image_sort','asc');
    }

    public function category(){
    	return $this->belongsTo('App\Category','category_id')->select('id','parent_id','name','status','seo_unique','category_discount','size_chart','filters');
    }

    public function productimages(){
    	return $this->hasMany('App\ProductImage','product_id')->orderby('image_sort','asc');
    }

    public function attributes(){
        return $this->hasMany('App\ProductAttribute','product_id');
    }

    public function pro_attrs(){
        return $this->hasMany('App\ProductAttribute','product_id')->where('status',1);
    }
//->has('colordetails','>',0)
    public function groups(){
        return $this->hasMany('App\Product','group_code','group_code')->select('id','color','status','group_code','seo_url')->where('group_code','!=','')->where('status',1)->with(['colordetails','product_image']);
    }
    public function colordetails(){
        return $this->belongsto('App\Color','color','color_name')->select('color_name');
    }

    public function relatedproducts(){
        return $this->hasMany('App\Product','category_id')->select('id','category_id','status','seo_url','product_name','product_discount','current_discount','final_price','product_price')->where('status',1)->with(['product_image','category']);
    }
	
	 public function product_reviews(){
        return $this->hasMany('App\ProductReview','product_id')->where('status','1');
    }

    public static function CheckProduct($proseo){ 
        $getproductdetails = Product::with(['productimages','pro_attrs','product_reviews','category'=>function($query){
            $query->with('subcat');
        },'relatedproducts'=>function($query) use($proseo){
            $query->where('seo_url','!=',$proseo);
        },'groups'=>function($query) use($proseo){
            $query->where('seo_url','!=',$proseo);
        }])->where('seo_url',$proseo)->where('status',1)->first();
        $getproductdetails = json_decode(json_encode($getproductdetails),true);
        $response = array('status'=>false);
        if(!empty($getproductdetails)){
            if($getproductdetails['category']['status']==1){
                $response = array('status'=>true,'productdetails'=>$getproductdetails);
            }
        } 
        return $response;
    }
	
 public static function relatedcategory($category_parent_id,$cat_id=null,$seo_unique){ 
	
		if($category_parent_id != ''){  
		$cat_ids = $cat_id;
	    $pattern = Category::select('id')->where(['status'=>'1','seo_unique'=>$seo_unique])->first();
        $category_id = $pattern['id']; 
    	$sub_cat_id = Category::select('id')->where(['status'=>'1','parent_id'=>$category_id])->get();
			if(!empty($sub_cat_id)){
			foreach($sub_cat_id as $value){
				$cat_ids .=','. $value['id'];
			}
			}
		}else
		{ 
				$category_id = $cat_id; 
				$cat_ids = $cat_id; 
				$sub_cat_id = Category::select('id')->where(['status'=>'1','parent_id'=>$category_id])->get();
					if(!empty($sub_cat_id)){
						foreach($sub_cat_id as $value){
							$cat_ids .=','. $value['id'];
							    $sub_cat_id2 = Category::select('id')->where(['status'=>'1','parent_id'=>$value['id']])->get();
                                foreach($sub_cat_id2 as $value2){
				                   $cat_ids .=','. $value2['id'];
			                    }								
						}
						}
		}
    	return $cat_ids;
    }
     public static function GruopbyProductattribute($relatedcategory,$attribute_name,$type=null){ 
	   if($type == 'New Arrivals'){
			$attribute =  Product::select($attribute_name)->where('new_arrival','Yes')->where($attribute_name, '!=' , NULL)->where('status',1)->groupby($attribute_name)->get();
	   }else if($type == 'Shop All'){
			$attribute =  Product::select($attribute_name)->where($attribute_name, '!=' , NULL)->where('status',1)->groupby($attribute_name)->get();
	   }else{
			$explode = explode(',', $relatedcategory);
			//$attribute =  Product::select($attribute_name)->whereIn('category_id',$explode)->where($attribute_name, '!=' , NULL)->where('status',1)->groupby($attribute_name)->get();
	        $attribute =  Product::select($attribute_name)
				->join('product_categories', 'product_categories.product_id', '=', 'products.id')
				->where($attribute_name, '!=', NULL)
				->where('products.status', 1)
				->where(function($query) use ($explode) { 
					$query->whereIn('product_categories.category_id', $explode)
						  ->orWhereIn('products.category_id', $explode);
				 })
				->groupBy($attribute_name)
				->get();
	   
	   }
	//echo "<pre>"; print_r($attribute); exit;
		if(!empty($attribute)){
		 return $attribute;
        }else{
		 return array();
		}
	 }
	
     public static function MorecolorProducts($id='',$group_code){ 
		 $morecolors = Product::select('id','seo_url','color')->where('group_code',$group_code)->where('id', '!=' ,$id)->where('status', 1)->offset(0)->limit(10)->get(); 
		 return $morecolors;
	 }
    public static function getseourl($id){
        $seo_url = DB::table('products')->select('id','seo_url')->where('id',$id)->get()->toArray();
        if(isset($seo_url[0])){
            return $seo_url[0];
        }
    }
    public static function getsingleRow($id){
        $product_attributes = DB::table('product_attributes')->select('id','sku','stock')->where('product_id',$id)->where('status',1)->get()->toArray();
        return $product_attributes;
    }
    public static function getstockcount($id){
        $product_attributes = DB::table('product_attributes')->select('stock')->where('product_id',$id)->where('status',1)->sum('stock');
        return $product_attributes;
    }    
    public static function subcatDynamic($id){
        $subcat_count = DB::table('products')->select('id','seo_url')->where('category_id',$id)->where('status',1)->count();
        return $subcat_count;
    }
    public static function getRemarks($id){
        $sku = array();
        $count = 0;
        $cupan = '';
        $product_attributes = DB::table('product_attributes')->select('id','sku')->where('product_id',$id)->where('status',1)->get()->toArray();
        foreach($product_attributes as $key=>$product_attributessku){
            $count = CouponCode::select('remarks')->whereRaw('FIND_IN_SET("'.$product_attributessku->sku.'",product_sku)')->where('visible',1)->count();
            if($count>0){
                $cupan_code_count = CouponCode::select('remarks')->whereRaw('FIND_IN_SET("'.$product_attributessku->sku.'",product_sku)')->where('user_emails',NULL)->where('visible',1)->count(); 
                if($cupan_code_count>0){
                  $cupan_code = CouponCode::select('remarks')->whereRaw('FIND_IN_SET("'.$product_attributessku->sku.'",product_sku)')->where('visible',1)->first();    
                }else{
                  if(Auth::check()){  
                    $cupan_code = CouponCode::select('remarks')->whereRaw('FIND_IN_SET("'.$product_attributessku->sku.'",product_sku)')->whereRaw('FIND_IN_SET("'.Auth::user()->email.'",user_emails)')->where('visible',1)->first();  
                  }else{
                    $cupan_code = CouponCode::select('remarks')->whereRaw('FIND_IN_SET("'.$product_attributessku->sku.'",product_sku)')->where('visible',1)->first();  
                  }                
                }
                if(!empty($cupan_code['remarks'])){
                    $cupan = $cupan_code['remarks'];
                }
            }
        }
        return $cupan;
    }
	
	
	 public static function ProductPrice($catID,$product){
		 
		 $productPrice = $product['product_price'];
		 $product_discount = $product['product_discount'];
		 $FinalproductPrice=0;
		 
		 if(empty($product_discount)){
			 $resRow = Category::where(['status'=>'1','id'=>$catID])->first();
			 if(!empty($resRow)){
				 $dicsountPercent =  (float)$resRow["category_discount"];
					if(!empty($dicsountPercent)){
						$dicountedAmount=$productPrice*($dicsountPercent/100);
						$FinalproductPrice=$productPrice-$dicountedAmount;
					}else{
						$FinalproductPrice=$productPrice;
					}						
			 }			 
		 } else{
			
			 $dicountedAmount = $productPrice * ( $product_discount / 100 );
			 $FinalproductPrice=$productPrice-$dicountedAmount;
		 }
		return number_format($FinalproductPrice,0,'.','');
		
 }
	
	public static function product_code($color_name){
		$details = Productcolor::where(['product_color'=>$color_name])->first();
		if(!empty($details) && $details['color_code'] != '') {
			return $details['color_code'];
		}else{
			return $color_name;
		}
	}
	

}
