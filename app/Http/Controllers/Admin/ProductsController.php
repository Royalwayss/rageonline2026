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
        
		if(isset($_GET['testtt'])){
			$this->downloadAllActiveProductImages(); exit;
		}
       
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
                    <a data-target="_blank" title="Edit" class="btn btn-sm green margin-top-10" href="'.url('/admin/add-edit-product/'.$product['id']).'"> <i class="fa fa-edit"></i>
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
            $product->short_description = $data['short_description'];
         
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
			
			 if(isset($data['is_featured']) && $data['is_featured'] == 'Yes'){
				$product->is_featured = $data['is_featured'];
			}else{
				$product->is_featured = 'No';
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
                    $proAttrUpdate->sku = $data['attr_sku'][$attrKeyId];  
                    $proAttrUpdate->size = $data['attr_size'][$attrKeyId];  
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

    /**
     * POST admin/duplicate-product
     * Copies a product using the new name / code / attribute SKU from the popup.
     * New seo_url is built from the new name + new code (same rule as add/edit).
     * Attribute SKU "T855-M" becomes "<new attribute sku>-M".
     */
    public function duplicateProduct(Request $request){
        $data = $request->all();
        $name = trim($data['duplicate_product_name'] ?? '');
        $code = trim($data['duplicate_product_code'] ?? '');

        if($name == '' || $code == ''){
            return redirect()->back()->with('flash_message_error','Product name and product code are required.');
        }

        $source = Product::find($data['source_product_id'] ?? 0);
        if(!$source){
            return redirect()->back()->with('flash_message_error','Source product not found.');
        }

        if(Product::where('product_code',$code)->exists()){
            return redirect()->back()->with('flash_message_error','This product code already exists. Please use a different product code.');
        }

        // seo_url: same rule as addEditProduct (name + '-' + code), made unique
        $slug = strtolower(str_replace(' ', '-', $name));
        $slug = strtolower(str_replace('.', '', $slug));
        $slug = strtolower(str_replace(',', '', $slug));
        $slug .= '-'.strtolower(str_replace(' ', '', $code));
        $baseSlug = $slug;
        $n = 1;
        while(Product::where('seo_url',$slug)->exists()){
            $slug = $baseSlug.'-'.$n++;
        }

        // new attribute sku prefix (popup value, fallback = part of code before first "-")
        $newSkuPrefix = trim($data['duplicate_attribute_sku'] ?? '');
        if($newSkuPrefix == ''){
            $newSkuPrefix = trim(explode('-', $code)[0]);
        }

        $newProduct = null;
        DB::transaction(function() use ($source,$name,$code,$slug,$newSkuPrefix,$data,&$newProduct){
            // 1. product
            $newProduct = $source->replicate();
            $newProduct->product_name = $name;
            $newProduct->product_code = $code;
            $newProduct->seo_url = $slug;
            $newProduct->source_product_id = $source->id; // original product this was duplicated from
            $newProduct->status = 0; // inactive until reviewed
            $newProduct->save();

            // 2. categories
            $catIds = ProductCategory::where('product_id',$source->id)->pluck('category_id')->toArray();
            if(!empty($catIds)){
                $newProduct->product_categories()->attach($catIds);
            }
            /*
            // 3. image rows (same image files are reused, nothing is copied on disk)
            foreach(ProductImage::where('product_id',$source->id)->get() as $img){
                $newImg = $img->replicate();
                $newImg->product_id = $newProduct->id;
                $newImg->save();
            } */

            // 4. attributes (only if the Attributes checkbox was ticked)
            if(!empty($data['duplicate_attributes'])){
                foreach(ProductAttribute::where('product_id',$source->id)->get() as $attr){
                    $oldSku = (string) $attr->sku;
                    if(strpos($oldSku,'-') !== false){
                        $newSku = $newSkuPrefix.substr($oldSku, strpos($oldSku,'-')); // T855-M => newprefix-M
                    }else{
                        $newSku = $newSkuPrefix.'-'.$attr->size;
                    }
                    $newAttr = $attr->replicate();
                    $newAttr->product_id = $newProduct->id;
                    $newAttr->sku = $newSku;
                    $newAttr->stock = 0; // do not double-count stock
                    $newAttr->status = 1;
                    $newAttr->save();

                    $stock_logs = new ProductAttributeLog;
                    $stock_logs->attribute_id = $newAttr->id;
                    $stock_logs->action = '1';
                    $stock_logs->qty = 0;
                    $stock_logs->stock_remaining = 0;
                    $stock_logs->message = 'New Attribute Added (duplicated from product '.$source->product_code.')';
                    $stock_logs->admin_id = Auth::guard('admin')->user()->id;
                    $stock_logs->save();
                }
            }
        });

        return redirect('admin/add-edit-product/'.$newProduct->id)->with('flash_message_success','Product duplicated successfully. It is Inactive - review it and enable when ready.');
    }

    /* =====================  PRODUCTS SORT  ===================== */

    // GET admin/products-sort
    public function productsSort(Request $request){
        Session::put('active','products');
        $title = "Products Sort";
        $getCategories = $this->getcategories();
        return view('admin.products.products-sort')->with(compact('title','getCategories'));
    }

    // POST admin/products-sort/fetch  (ajax) - products of a category in the chosen default order
    public function productsSortFetch(Request $request){
        $categoryId = (int) $request->input('category_id');
        $sortType   = $request->input('sort_type');
        $status     = $request->input('status');

        if(!$categoryId || !in_array($sortType, ['current','highest_sale','new_to_old','old_to_new']) || !in_array($status, ['active','deactive','all'])){
            return response()->json(['status'=>false,'message'=>'Please select category, sort type and status.']);
        }

        // selected category + its sub categories + sub-sub categories (same as the storefront listing)
        $catIds = array($categoryId);
        $level1 = DB::table('categories')->where('parent_id',$categoryId)->pluck('id')->toArray();
        $catIds = array_merge($catIds,$level1);
        if(!empty($level1)){
            $level2 = DB::table('categories')->whereIn('parent_id',$level1)->pluck('id')->toArray();
            $catIds = array_merge($catIds,$level2);
        }

        $query = DB::table('products')
                    ->where('products.is_delete','no')
                    ->where(function($q) use ($catIds){
                        $q->whereIn('products.category_id',$catIds)
                          ->orWhereIn('products.id',function($sub) use ($catIds){
                              $sub->select('product_id')->from('product_categories')->whereIn('category_id',$catIds);
                          });
                    });

        if($status == 'active'){
            $query->where('products.status',1);
        }elseif($status == 'deactive'){
            $query->where('products.status',0);
        }

        $select = ['products.id','products.product_name','products.product_code','products.status'];

        switch($sortType){
            case 'highest_sale':
                // units sold per product, cancelled / failed orders are not counted
                $sold = DB::table('order_products')
                            ->join('orders','orders.id','=','order_products.order_id')
                            ->where('orders.is_delete','no')
                            ->whereNotIn('orders.order_status',['Cancelled','Payment Failure','Payment Refunded','Abandoned'])
                            ->select('order_products.product_id', DB::raw('SUM(order_products.product_qty) as total_sold'))
                            ->groupBy('order_products.product_id');
                $query->leftJoinSub($sold,'sold','sold.product_id','=','products.id');
                $select[] = DB::raw('COALESCE(sold.total_sold,0) as total_sold');
                $query->orderByRaw('COALESCE(sold.total_sold,0) DESC')->orderBy('products.id','desc');
                break;
            case 'new_to_old':
                $query->orderBy('products.created_at','desc')->orderBy('products.id','desc');
                break;
            case 'old_to_new':
                $query->orderBy('products.created_at','asc')->orderBy('products.id','asc');
                break;
            default: // current - saved product_sort, products without a sort number go last (newest first)
                $query->orderByRaw('products.product_sort IS NULL')
                      ->orderBy('products.product_sort','asc')
                      ->orderBy('products.id','desc');
                break;
        }

        $products = $query->select($select)->get();

        $list = array();
        foreach($products as $product){
            $list[] = array(
                'id'     => $product->id,
                'name'   => $product->product_name,
                'code'   => $product->product_code,
                'status' => (int) $product->status,
                'sold'   => isset($product->total_sold) ? (int) $product->total_sold : null,
            );
        }
        return response()->json(['status'=>true,'products'=>$list]);
    }

    // POST admin/products-sort/save  (ajax) - saves the dragged order as product_sort 1..n
    public function productsSortSave(Request $request){
        $ids = $request->input('product_ids');
        if(!is_array($ids) || empty($ids)){
            return response()->json(['status'=>false,'message'=>'No products to save.']);
        }
        $ids = array_values(array_unique(array_filter(array_map('intval',$ids))));

        DB::transaction(function() use ($ids){
            foreach($ids as $position => $id){
                DB::table('products')->where('id',$id)->update(['product_sort' => $position + 1]);
            }
        });

        return response()->json(['status'=>true,'message'=>'Product order saved successfully.']);
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
			
			
	public function downloadAllActiveProductImages()
    {
        set_time_limit(0); // this can take a while for a large catalog

        $level = 4; // level 1 = products 1-10, level 2 = products 11-20, etc.
        $perLevel = 10;

        // Stream output as each file finishes, instead of waiting until the
        // very end to send one JSON response - lets you see progress live,
        // and shows exactly where it stops if something kills the request.
        ob_implicit_flush(true);
        if (ob_get_level() > 0) {
            ob_end_flush();
        }

        $products = Product::with('productimages')
            ->join('categories', 'categories.id', '=', 'products.category_id')
            ->where('categories.id', '11')
            ->where('categories.status', '1')
            ->where('products.status', '1')
            ->select('products.*') // avoid column clashes from the join (e.g. both tables having "status")
            ->orderBy('products.id')
            ->skip(($level - 1) * $perLevel)
            ->take($perLevel)
            ->get();

        echo "Level {$level}: processing " . count($products) . " product(s) (rows " . (($level - 1) * $perLevel + 1) . " to " . (($level - 1) * $perLevel + $perLevel) . ").<br><br>\n";
        flush();

        $baseUrl = 'https://www.rageonline.co.in/images/ProductImages/';
        $folders = ['xlarge', 'large', 'medium', 'small'];

        $destinationRoot = public_path('images/ProductImages');

        foreach ($products as $product) {
            if (empty($product->productimages) || $product->productimages->isEmpty()) {
                echo "Product {$product->id}: SKIPPED - no images.<br>\n";
                flush();
                continue;
            }

            foreach ($product->productimages as $productImage) {
                if (empty($productImage->image)) {
                    continue;
                }

                $filename = $productImage->image;

                foreach ($folders as $folder) {
                    $url = $baseUrl . $folder . '/' . $filename;
                    $destinationPath = $destinationRoot . '/' . $folder;

                    if (!\File::exists($destinationPath)) {
                        \File::makeDirectory($destinationPath, 0755, true);
                    }

                    $savePath = $destinationPath . '/' . $filename;

                    $context = stream_context_create([
                        'http' => [
                            'timeout' => 60,
                            'ignore_errors' => true,
                        ],
                    ]);

                    $contents = @file_get_contents($url, false, $context);
                    $statusLine = $http_response_header[0] ?? null;
                    $statusCode = null;

                    if ($statusLine && preg_match('/\s(\d{3})\s/', $statusLine, $m)) {
                        $statusCode = (int) $m[1];
                    }

                    if ($contents === false) {
                        echo "Product {$product->id} [{$folder}] {$filename}: FAILED - connection failed or timed out.<br>\n";
                        flush();
                        continue;
                    }

                    if ($statusCode !== null && $statusCode >= 400) {
                        echo "Product {$product->id} [{$folder}] {$filename}: FAILED - server returned HTTP {$statusCode}.<br>\n";
                        flush();
                        continue;
                    }

                    $written = @file_put_contents($savePath, $contents);

                    if ($written === false) {
                        echo "Product {$product->id} [{$folder}] {$filename}: FAILED - could not write to {$savePath} (check folder permissions).<br>\n";
                        flush();
                        continue;
                    }

                    echo "Product {$product->id} [{$folder}] {$filename}: SUCCESS - saved ({$written} bytes).<br>\n";
                    flush();
                }
            }
        }

        echo "<br>Done with level {$level}.<br>\n";
        flush();
    }
		
		
		
		
		
		
		}