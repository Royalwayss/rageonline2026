<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests;
use App\Admin;
use DB;
use Cookie;
use Session;
use Crypt;
use Illuminate\Support\Facades\Mail;
use PDF;
use App\Product;
use App\Category;
use App\Notifies;
use Image;
use App\ProductImage;
use App\ProductAttribute;
use App\ProductCategory;
use App\Producttag;
use App\ProductAttributeLog;
use Auth;
class ProductsController extends Controller
{
    //
    public function compress_product_images(Request $Request){ exit; die();
		$folders = array('xlarge','large','medium','small');
		$products = Product::with('product_image')->join('categories','categories.id','=','products.category_id')->select('products.id','products.product_name','categories.name as category_name')->where('categories.id','2')->where('products.status','1')->get();
		$products=json_decode( json_encode($products), true);
		//echo "<pre>"; print_r($products); exit; 
		foreach($products as $product){
			if(!empty($product['product_image'])){
				$img_name = $product['product_image']['image']; 
				foreach($folders as $folder){
					$source_img = public_path('images/ProductImages/'.$folder.'/'.$img_name);
                    $destination_img = $source_img; 
                    //echo $source_img; exit;
					//$d = $this->compress($source_img, $destination_img, 50); 
				}
			}
		}		
		echo "<pre>"; print_r($products); exit; 
	} 
		public function compress($source, $destination, $quality) { exit; die();
			$info = getimagesize($source);
			if ($info['mime'] == 'image/jpeg') 
				$image = imagecreatefromjpeg($source);
			elseif ($info['mime'] == 'image/gif') 
				$image = imagecreatefromgif($source);
			elseif ($info['mime'] == 'image/png') 
				$image = imagecreatefrompng($source);
			imagejpeg($image, $destination, $quality);
			return $destination;
   }
    public function products(Request $Request){
        
       
        $sku_with_size_text = '';
        Session::put('active','products'); 
        if($Request->ajax()){
            $conditions = array();
            $data = $Request->input();
            $querys = Product::with('pro_attrs','productimages')->join('categories','categories.id','=','products.category_id')->select('categories.name as cat_name','products.*')->where('is_delete','no');
             if(!empty($data['id'])){
                $querys = $querys->where('products.id','like','%'.$data['id'].'%');
            }
			if(!empty($data['cat_name'])){
                $querys = $querys->where('categories.name','like','%'.$data['cat_name'].'%');
            }
            if(!empty($data['p_name'])){
                $querys = $querys->where('products.product_name','like','%'.$data['p_name'].'%');
            }
            
             if(isset($data['status']) && $data['status'] != ''){
                $querys = $querys->where('products.status',$data['status']);
            }
            if(!empty($data['product_code'])){
                $querys = $querys->where('products.product_code','like','%'.$data['product_code'].'%');
            }
            $iDisplayLength = intval($_REQUEST['length']);
            $iDisplayStart = intval($_REQUEST['start']);
            $iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength; 
            $iTotalRecords = $querys->where($conditions)->count();
            $querys =  $querys->where($conditions)
                		->skip($iDisplayStart)->take($iDisplayLength)
                		->OrderBy('products.id','DESC')
                		->get();
            $sEcho = intval($_REQUEST['draw']);
            $records = array();
            $records["data"] = array(); 
            $end = $iDisplayStart + $iDisplayLength;
            $end = $end > $iTotalRecords ? $iTotalRecords : $end;
            $i=$iDisplayStart;
           // echo "<pre>"; print_r($querys); exit;
            $querys=json_decode( json_encode($querys), true);
            foreach($querys as $product){
                $size_sku = Product::getsingleRow($product['id']);
                $sku_with_size_text = '';
                foreach($size_sku as $size_sku_val){
                    
                    $sku_with_size_text.=$size_sku_val->sku.'-'.$size_sku_val->stock.'<br>';
                    
                }
                $checked='';
                if($product['status']==1){
                    $checked='on';
                }
                else{
                    $checked='off';
                }
                $deletePro = '</a><a  title="Delete Product"  class="btn btn-sm red margin-top-10 delete"  onclick="return ConfirmDelete()" href="'.url('admin/delete-product/'.$product['id']).'"> <i class="fa fa-times"></i>
                    </a>';
                $actionValues='
                    <a target="_blank" title="Edit" class="btn btn-sm green margin-top-10" href="'.url('/admin/add-edit-product/'.$product['id']).'"> <i class="fa fa-edit"></i>
                    '.$deletePro;
                $num = ++$i;
                if(!empty($product['productimages'][0])){
                    
                    /*
                    if (strstr($product['productimages'][0]['image'], '_') !== false) {

                         $img_width = '50';
                    } else {
                         $img_width = '100';
                    } */
                     $img_width = '50';
                    
                    $productImage = '<img width="'.$img_width.'" src="'.asset('images/ProductImages/medium/'.$product['productimages'][0]['image']).'"/>';
                }else{
                    $productImage ="";
                }
                $records["data"][] = array(      
                    $product['id'],
                    $product['product_code'],
                    $productImage,
                    '<a target="_blank" href="'.url('/product/'.$product['seo_url']).'">'.$product['product_name'].'</a>',
                    $sku_with_size_text,
                    $product['cat_name'],
                    '<div  id="'.$product['id'].'" rel="products" class="bootstrap-switch  bootstrap-switch-'.$checked.'  bootstrap-switch-wrapper bootstrap-switch-animate toogle_switch">
                    <div class="bootstrap-switch-container" ><span class="bootstrap-switch-handle-on bootstrap-switch-primary">&nbsp;Active&nbsp;&nbsp;</span><label class="bootstrap-switch-label">&nbsp;</label><span class="bootstrap-switch-handle-off bootstrap-switch-default">&nbsp;Inactive&nbsp;</span></div></div>',   
                    $actionValues
                );
            }
            $records["draw"] = $sEcho;
            $records["recordsTotal"] = $iTotalRecords;
            $records["recordsFiltered"] = $iTotalRecords;
            return response()->json($records);
        }
        $getCategories = Category::with('subcategories')->select('id','name','parent_id')->where('parent_id','ROOT')->get();
   		$getCategories = json_decode(json_encode($getCategories),true);
        $title = "Products";
        return View::make('admin.products.products')->with(compact('title','getCategories'));
    }

    public function addEditProduct(Request $request,$id=null){
    	if($id==""){
    		$title="Add Product";
    		$message="Product has been added successfully";
    		$product = new Product;
    		$productdata = array();
    		$productImages = array();
            $productCats = array();
    	}else{
    		$title="Edit Product";
    		$message="Product has been updated successfully";
    		$product = Product::with(['attributes'])->find($id);
    		$productdata = json_decode(json_encode($product),true);
            $productCats = ProductCategory::where('product_id',$id)->select('category_id')->pluck('category_id')->toArray();
    		$productid = $productdata['id'];
    		$productImages = ProductImage::where('product_id',$id)->orderby('image_sort','asc')->get();
            $productImages = json_decode(json_encode($productImages),true);
    	}
    	if($request->isMethod('post')){
    		$data = $request->all();
			if(count($_POST) != 0){
				//echo "<pre>"; print_r($data); die;
			}
            //echo "<pre>"; print_r($data); die;
    		unset($data['_token']);
            $product->category_id = $data['category_id'];
    		$product->product_name = $data['product_name'];
            
            
            $product->product_code = $data['product_code'];
            
            
			if(isset($data['group_code'])){
                $product->group_code = $data['group_code'];
            }
			
            //check Seo url exists
            $checkSeoUrl = Product::where('seo_url',$data['seo_url']);
            if(isset($data['old_seo'])){
                $checkSeoUrl = $checkSeoUrl->where('seo_url','!=',$data['old_seo']);
            }
            $checkSeoUrl = $checkSeoUrl->count();
            if($checkSeoUrl >0){
                return redirect()->back()->with('flash_message_error', 'This Seo Unique already exists. Please try with unique seo url');
            }
			
			
			 $slug ='';
             $slug = strtolower(str_replace(' ', '-', $data['product_name']));
			 $slug = strtolower(str_replace('.', '', $slug));
             $slug = strtolower(str_replace(',', '', $slug));
			 if($data['product_code'] != ''){
				 
				 $slug .= '-'.strtolower(str_replace(' ', '', $data['product_code']));
			 }
			 
			 
			 
			 
			 
			$checkSeoUrl = Product::where('seo_url',$slug);
            if($id!=""){
                $checkSeoUrl = $checkSeoUrl->where('id','!=',$id);
            }
            $checkSeoUrl = $checkSeoUrl->count();
			
			 if(!empty($checkSeoUrl)){
				 
				 $slug .='-'.$id;
			 }
			
			
			
			$product->seo_url = $slug;
			
			
			
			
			
            $product->color = $data['color'];
            $product->productcolor = $data['productcolor'];
            
    		$product->weight = $data['weight'];
    		$product->product_stock = $data['product_stock'];
            $product->product_description = $data['editor1'];
            $product->product_price = $data['product_price'];
            $product->special_price = $data['special_price'];
            $product->fabric_description = $data['fabric_description'];
         
			$getcatdetails = Category::where('id',$data['category_id'])->first();
			
			
			if(!empty($data['product_discount'])){
                $product->current_discount = "product";
                $product->product_discount = $data['product_discount'];
                $product->final_price = $data['product_price'] - ($data['product_price'] * $data['product_discount'])/100;
            }else{
                $getcatdetails = Category::where('id',$data['category_id'])->first();
                if($getcatdetails->category_discount == 0){
                    $product->current_discount = "";
                    $product->final_price = $data['product_price'];
                }else{
                    $product->current_discount = "category";
                    $product->final_price = $data['product_price'] - ($data['product_price'] * $getcatdetails->category_discount )/100;
                } 
            }
			
			
			
            if(isset($data['new_arrival']) && $data['new_arrival'] == 'Yes'){
				$product->new_arrival = $data['new_arrival'];
			}else{
				$product->new_arrival = 'No';
			}
			
			 if(isset($data['best_seller']) && $data['best_seller'] == 'Yes'){
				$product->best_seller = $data['best_seller'];
			}else{
				$product->best_seller = 'No';
			}
			
			if(isset($data['status']) && $data['status'] == 1){
				$product->status = $data['status'];
			}else{
				$product->status = 0;
			}
			
			if($request->hasFile('size_chart')){
                if ($request->file('size_chart')->isValid()) {
                    $file = $request->file('size_chart');
                    $img = Image::make($file);
                    $destination = public_path('/images/SizeCharts/');
                    if(!empty($categorydata) &&  $categorydata['size_chart'] !="" && file_exists($destination.$categorydata['size_chart'])){
                        unlink($destination.$categorydata['size_chart']);
                    }
                    $originalname = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
				    $extension = $file->getClientOriginalExtension();
				    $mainFilename = $originalname."-".time().".".$extension;
                    $img->save($destination.$mainFilename);
                    $product->size_chart= $mainFilename;
                }
            }
			
			
			
			
			
			
			
    		$product->save();
            if(empty($productdata)){
                $productid = DB::getPdo()->lastInsertId();
                $product->product_categories()->attach($data['cats']);
            }else{
                $product->product_categories()->sync($data['cats']);
            }
            if($request->hasFile('images')){
                $files = $request->file('images');
                foreach($files as $fkey => $file){
                    $productImage = new ProductImage;
                    $img = Image::make($file);
                    $originalname = pathinfo($file->getClientOriginalName(),PATHINFO_FILENAME);
                    $extension = $file->getClientOriginalExtension();
                    $fileName = time()."_".$fkey."".rand().".".$extension;
                    $sizeArray = array(
									'xlarge'=>array('0'=>'1200','1'=>'1800'),
									'large'=>array('0'=>'800','1'=>'1200'),
									'medium'=>array('0'=>'270','1'=>'405'),
									'small'=>array('0'=>'100','1'=>'150')
								);
					foreach($sizeArray as $key=> $size){
                        if($key !="xlarge"){
                            $img->resize($size[0],$size[1]);
                        }
                        $destinationPath = 'images/ProductImages/'.$key."/";
                        $img->save($destinationPath.$fileName);
                    }
					if($fkey==0){
						$productImage->is_default = 1;
					}
                    $productImage->image_sort = $data['image_sort'][$fkey];
                    $productImage->product_id = $productid;
                    $productImage->image = $fileName;
                    $productImage->save();
                }
            }
            //Update Stock and Price on Edit Product
            if(isset($data['attr_id'])){
                foreach($data['attr_id'] as $attrKeyId => $attrIdDetails){
                    $get_attr = ProductAttribute::find($attrIdDetails);  
                    $proAttrUpdate = ProductAttribute::find($attrIdDetails);  
                    $proAttrUpdate->price = $data['attr_price'][$attrKeyId];  
                    $proAttrUpdate->color = $data['attr_color'][$attrKeyId];  
                    $proAttrUpdate->stock = $data['attr_stock'][$attrKeyId];  
                    $proAttrUpdate->save();
                    
					
					if($get_attr->stock != $data['attr_stock'][$attrKeyId]){
						$stock_logs = new ProductAttributeLog;
						$stock_logs->attribute_id = $attrIdDetails;
						$stock_logs->action = '1'; /* qty update by admin */
						$stock_logs->qty =  $data['attr_stock'][$attrKeyId] - $get_attr->stock;
						$stock_logs->stock_remaining = $data['attr_stock'][$attrKeyId]; 
						if($get_attr->stock < $data['attr_stock'][$attrKeyId]){
							$stock_message = 'Stock Added';
						}else{
							$stock_message = 'Stock Removed';
						}
						$stock_logs->message = $stock_message;
						$stock_logs->admin_id = Auth::guard('admin')->user()->id;
						$stock_logs->save();
					}
					
					
                }
            }
            //Add Product Attributes
            foreach($data['size'] as $attrKey => $attrDetails){
                if(!empty($attrDetails)){
                    if($data['sku'][$attrKey] != '' && $data['size'][$attrKey] != '' && $data['price'][$attrKey] != ''){
						$proAttr = new ProductAttribute;
						$proAttr->product_id = $productid;  
						$proAttr->color = '';
						$proAttr->sku = $data['sku'][$attrKey];  
						$proAttr->size = $data['size'][$attrKey];  
						$proAttr->price = $data['price'][$attrKey];  
						$proAttr->stock = $data['stock'][$attrKey];  
						$proAttr->status = 1; 
						$proAttr->save();
						
						$attribute_id = $proAttr->id;
						
						
						$stock_logs = new ProductAttributeLog;
						$stock_logs->attribute_id = $attribute_id;
						$stock_logs->action = '1'; /* qty update by admin */
						$stock_logs->qty =  $data['stock'][$attrKey];  
						$stock_logs->stock_remaining = $data['stock'][$attrKey];   
						$stock_message = 'New Attribute Added';
						$stock_logs->message = $stock_message;
						$stock_logs->admin_id = Auth::guard('admin')->user()->id;
						$stock_logs->save();
					
						
						
						
						
					}
                }
            }
             $this->stockupdatemail($product->product_code);   
            return redirect()->action('App\Http\Controllers\Admin\ProductsController@products')->with('flash_message_success',$message);
    	}
        $getCategories = $this->getcategories();
    	return view('admin.products.add-edit-product')->with(compact('title','productdata','productImages','getCategories','productCats'));
    }

    public function updateImageSort(Request $request){
        if($request->ajax()){
            $data  = $request->all();
            ProductImage::where(['id'=>$data['imageid']])->update(['image_sort'=>$data['imagesort']]);
            return 'ok';
        }
    }

    public function deleteProduct($productid){
        Product::where('id',$productid)->where('id',$productid)->update(['is_delete'=>'yes','status'=>0]);
        return redirect()->back()->with('flash_message_success','Product has been deleted successfully');
    }

    public function deleteProductImage(Request $request){
        if($request->ajax()){
            $data = $request->all();
            $getdetails = ProductImage::find($data['id']);
            /*if($getdetails->image!=""){
                unlink('images/ProductImages/large/'.$getdetails->image);
                unlink('images/ProductImages/medium/'.$getdetails->image);
                unlink('images/ProductImages/small/'.$getdetails->image);
            }*/
            $getdetails->delete();
            echo "success";
        }
    }

    public function checkProductDetails(Request $request){
        if($request->ajax()){
            $data = $request->all();
            if(isset($data['seo_url']) && !empty($data['seo_url'])){
                $count = DB::table('products')->where('seo_url',$data['seo_url'])->where('seo_url','!=',$data['seo_url'])->count();
            }else{
                $count = DB::table('products')->where('product_code',$data['product_code'])->count();
            }
            if($count == 0) {
                echo '{"valid":true}';die;
            } else {
                echo '{"valid":false}';die;
            }
        }
    }
     public function product_tag(Request $Request){
		Session::put('active','product_tag'); 
        if($Request->ajax()){
            $conditions = array();
            $data = $Request->input();
            $querys = DB::table('producttags')->where('is_delete','no');
            if(!empty($data['tag_name'])){
                $querys = $querys->where('tag_name','like','%'.$data['tag_name'].'%');
            }
            $iTotalRecords = $querys->where($conditions)->count();
            $iDisplayLength = intval($_REQUEST['length']);
            $iDisplayStart = intval($_REQUEST['start']);
            $iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength; 
            $querys =  $querys->where($conditions)
                ->skip($iDisplayStart)->take($iDisplayLength)
                ->OrderBy('tag_name','asc')
                ->get();  
            $sEcho = intval($_REQUEST['draw']);
            $records = array();
            $records["data"] = array(); 
            $end = $iDisplayStart + $iDisplayLength;
            $end = $end > $iTotalRecords ? $iTotalRecords : $end;
            $i=$iDisplayStart;
            $querys=json_decode( json_encode($querys), true);
            foreach($querys as $key=>$producttag){ 
			   
                 $actionValues='
				
				 
				 
                	<a target="_blank" title="View Product Tag" class="btn btn-sm green" href="'.url('/admin/add-edit-Product-tags/'.$producttag['id']).'">  <i class="fa fa-edit"></i></i>
                    </a>
                    <a  title="Delete Product Tag"  class="btn btn-sm red margin-top-10 delete"  onclick="return ConfirmDelete()" href="'.url('admin/product-tag-delete/'.$producttag['id']).'"> <i class="fa fa-times"></i>
                    </a>';
					
                $records["data"][] = array(  
                    $key +1,  
                    $producttag['tag_name'],  
                    
                    date('d M Y H:ia',strtotime($producttag['created_at'])),										
                    
                    $actionValues
                );
            }
            $records["draw"] = $sEcho;
            $records["recordsTotal"] = $iTotalRecords;
            $records["recordsFiltered"] = $iTotalRecords;
            return response()->json($records);
        }
        $title = "Products Tags";
        return View::make('admin.products.tags.list')->with(compact('title'));
        
    }
  
   public function addEditProductTags(Request $request,$id=null){
		 if($id==""){
    		$title="Add Product Tag";
    		$message="Product Tag has been added successfully";
    		$Producttag = new Producttag;
			$producttagdata = array();
    	}else{
    		$title="Edit Product Tag";
    		$message="Product Tag has been updated successfully";
    		$producttagdata = Producttag::where('id',$id)->first();
           
    	}
		
		if($request->isMethod('post')){
    		$data =  $request->all();
            if($id ==''){
            $Producttag->tag_name = $data['tag_name'];
            
    		$Producttag->save();  
            }else{
				$update_data['tag_name'] = $data['tag_name'];
				Producttag::where('id', $id)->update($update_data); 
			}
            return redirect()->action('App\Http\Controllers\Admin\ProductsController@product_tag')->with('flash_message_success',$message);
    	}
		
    	return view('admin.products.tags.add-edit')->with(compact('title','producttagdata'));
       
		
		
	 }


   public function product_tag_delete($id){
        Session::put('active','product_tag'); 
        Producttag::where('id',$id)->update(['is_delete'=>'yes']);
        return redirect()->back()->with('flash_message_success','Product tag has been deleted successfully');
    }
	
	public function removeProductSizechartImage(Request $request){
		if($request->ajax()){
			$data = $request->all();
			Product::where('id',$data['id'])->update(['size_chart'=>'']);
			echo 1;
		}
	}
    
    public function removeAttribute($attrid,$proid){
        DB::table('carts')->where('product_id',$proid)->delete();
        DB::table('product_attributes')->where('id',$attrid)->delete();
        return redirect()->back()->with('flash_message_success','Product Attribute has been deleted successfully');
    }

    public function ChangeAttrStatus(Request $request){
        if($request->ajax()){
            $data = $request->all();
            if($data['status'] =="yes"){
                ProductAttribute::where('id',$data['attrid'])->update(['status'=>1]);
            }else{
                ProductAttribute::where('id',$data['attrid'])->update(['status'=>0]);
            }
            return 'ok';
        }
    }
   public function stockupdatemail($pcode){
     
    if($pcode){
        $product = Product::with(['attributes'])->where('product_code',$pcode)->get()->toArray();
        foreach($product as $attrKeyId => $product_val){
            $getCategories = Category::where('id',$product_val['category_id'])->select('seo_unique')->get()->toArray();
            for($i=0;$i<count($product_val['attributes']);$i++){
                $notifies = Notifies::where('notifycode',$pcode)->where('notifysize',$product_val['attributes'][$i]['size'])->where('status',0)->get()->toArray();
                if(count($notifies)>0){
                    if($product_val['attributes'][$i]['size']==$notifies[0]['notifysize']){
                        $prodattr = $product_val['attributes'][$i];
                    }
                    $productImages = ProductImage::where('product_id',$product_val['id'])->get()->toArray();
                    if(count($productImages)>0){
                       $productImg =  $productImages[0]['image'];
                    }else{
                        $productImg = '';
                    }

                    if(env('MAIL_MODE') =="live"){
                        $email = $notifies[0]['email'];  
                        $messageData = [
                            'data' => $product[0],
                            'image' => $productImg,
                            'attr' => $prodattr,
                            'user' =>$notifies[0],
                            'url'=>$getCategories[0]
                        ];

                        try {
                            Mail::send('emails.notifyrequest', $messageData, function($message) use ($email){
                                $message->to($email)->subject('Back in Stock!');
                            });
                        } catch (\Exception $e) {
                            //\Log::error('Stock notify mail failed for '.$email.': '.$e->getMessage());
                        }
                    }                           
                    Notifies::where('notifycode',$pcode)->where('notifysize',$product_val['attributes'][$i]['size'])->where('status',0)->update(['status'=>'1']);
                }
            }
        }       
    }
}		
			
			
				
			
			
			
			
			
			
			
			
			
			
			
			
        }
