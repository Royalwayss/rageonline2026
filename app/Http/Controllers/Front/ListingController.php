<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\Category;
use App\Product;
use App\ProductAttribute;
use App\Wishlist;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Validator;
use Session;
use App\Cart;
use App\CouponCode;
use App\User;
use App\ShippingAddress;
use App\BillingAddress;
use App\Order;
use App\OrderProduct;
use App\OrderAddress;
use App\OrderHistory;
use App\CustomFunction;
use App\State;
use DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use App\RecentViewProduct;
use App\ReturnRequest;
use Redirect;
class ListingController extends Controller
{
    //
    public function cart(){    
		$orderid =8597;
		//Order::creditRewardPoints($orderid); 
		CouponCode::checkCouponStatus();
    	$title ="Cart";
    	$metakeywords ="";
    	$metadescription="";
        $cartitems = Cart::cartitems(); 
        Session::forget('previousurl');
        Session::put('previousurl',"/cart");
		$catseo = 'addtocart';
		$page = 'cart'; 
    	return view('front.cart.cart')->with(compact('title','metakeywords','metadescription','cartitems','catseo','page'));
    }

    public function productlisting(Request $request){
		//echo "f"; exit;
        $catseo = Route::getFacadeRoot()->current()->uri();
    	$response = Category::getcatdetails($catseo);
    	$getcategories = Category::getsubcategories();
        $sortname ="";$selPrice="";$proage="";
        //echo "<pre>"; print_r($response); exit;
    	if($response['status']){
    		$catids = $response['catids'];
    		$getproducts = Product::with(['productimages','product_image','category','attributes'])->where('products.status',1)->join('categories','categories.id','=','products.category_id')->select('products.*','categories.category_discount',DB::raw("(case when products.product_discount = 0 then categories.category_discount else  products.product_discount end ) as 'item_discount'"));
			$search = array();
    		if($request->isMethod('get')){
    			$data = $request->all();
    			if(isset($data['color']) && !empty($data['color'])){
					$color = $data['color'];
    				$colors = explode('~',$color);
					$search['color'] = $colors;
    				$getproducts = $getproducts->wherein('products.productcolor',$colors);
    			}
				
				
				
                if(isset($data['category']) && !empty($data['category'])){
                    $catids = explode('~',$data['category']);
                }
				if($catseo == 'new-arrivals'){
					$getproducts = $getproducts->leftjoin('product_categories','product_categories.product_id','=','products.id')->join('categories as cats','cats.id','=','product_categories.category_id')->groupby('product_categories.product_id');
				    $getproducts = $getproducts->where('products.new_arrival','yes');
				}else if($catseo == 'shop-all'){
					$getproducts = $getproducts->leftjoin('product_categories','product_categories.product_id','=','products.id')->join('categories as cats','cats.id','=','product_categories.category_id')->groupby('product_categories.product_id');
				   
				}else{
					$getproducts = $getproducts->leftjoin('product_categories','product_categories.product_id','=','products.id')->join('categories as cats','cats.id','=','product_categories.category_id')->wherein('product_categories.category_id',$catids)->groupby('product_categories.product_id');
				}
                
               
			   if(isset($data['size']) && !empty($data['size'])){
                    $proage = $data['size'];
                    $ageGroups = explode('~',$proage);
                    $search['size'] = $ageGroups;
                    $getproducts->join('product_attributes','product_attributes.product_id','=','products.id')->wherein('product_attributes.size',$ageGroups)->where('product_attributes.status',1)->groupby('product_attributes.product_id'); 
                }
    			if (isset($data['price']) && !empty($data['price'])) {

					$selPrice = $data['price'];
					$search['price'] = explode('~', $selPrice);
					$priceArr = $search['price'];
                     $search['price'] = $priceArr;
					$getproducts = $getproducts->where(function ($q) use ($priceArr) {

						foreach ($priceArr as $index => $range) {

							$rangeExplode = explode('-', $range);

							$min = $rangeExplode[0];
							$max = isset($rangeExplode[1]) && $rangeExplode[1] !== 'plus'
								? $rangeExplode[1]
								: PHP_INT_MAX;

							if ($index === 0) {
								$q->whereBetween('products.final_price', [$min, $max]);
							} else {
								$q->orWhereBetween('products.final_price', [$min, $max]);
							}

						}

					});

				}
				
				
				
				
				
				
				
    			if(isset($data['sort']) && !empty($data['sort'])){ 
    				$sortname =$data['sort'];
					$search['sort'] =  $sortname;
	                if($sortname=="new-arrivals"){
	                    //$getproducts = $getproducts->where('products.new_arrival','yes');
	                }else if($sortname=="asc"){
	                    $getproducts = $getproducts->orderby('products.product_name','asc');
	                }else if($sortname=="desc"){
	                    $getproducts = $getproducts->orderby('products.product_name','Desc');
	                }else if($sortname=="lth"){
	                    $getproducts = $getproducts->orderby('products.final_price','ASC');
	                }else if($sortname=="htl"){
	                    $getproducts = $getproducts->orderby('products.final_price','DESC');
	                }else if($sortname=="best"){
                        $getproducts = $getproducts->where('products.best_seller','yes');
                    }else if($sortname=="stockasc"){
                        $getproducts = $getproducts->orderBy('stock_count','ASC');
                    }else if($sortname=="stockdesc"){
                        $getproducts = $getproducts->orderBy('stock_count','DESC');
                    }else if($sortname=="discounted"){
                        $getproducts = $getproducts->wherein('current_discount',['category','product'])->orderBy('item_discount','DESC');
                    }
	            }else{
	                $getproducts = $getproducts->orderby('products.product_sort','ASC');
	            }
    		}
			
    		$getproducts = $getproducts->whereExists( function ($query)  {
                $query->from('categories')
                ->whereRaw('products.category_id = categories.id')
                ->where('status',1);
            })->paginate(1000);
			
			//echo "<pre>"; print_r($getproducts['product_name']); exit;
			
			$paginate_link =  $getproducts->links();
			
            //echo "<pre>"; print_r(array_column($getproducts1, 'product_name')); die;
    		$getproducts = $getproducts->appends(request()->except('page'));
    		$title = $response['catdetail']['meta_title'];
            $metadescription = $response['catdetail']['meta_description'];
            $metakeywords = $response['catdetail']['meta_keyword'];
            $catdetails  = $response['catdetail'];
			if($catdetails['parent_id'] !=''){
				$category = Category::where(['status'=>1,'parent_id'=>$catdetails['parent_id']])->first();
				//echo "<pre>"; print_r($category); exit;
				$maincategory = Category::where(['status'=>1,'id'=>$category['parent_id']])->first();
				
			}else{
				$maincategory = array();
			}	
            
            $subcategories = $response['catdetail']['subcategories'];
            $catdetails  = $response['catdetail'];
    	}else{
    		abort(404);
    	}
		
		
			$no_of_products = 'Showing'; 
			if(!empty($getproducts->firstItem() )){
					$no_of_products .= '  '.$getproducts->firstItem();
			}else{
					$no_of_products .= '  0'; 
			}
		    $no_of_products .= ' to '.$getproducts->lastItem().' of '.$getproducts->total();
		    if(count($getproducts) == 1 || count($getproducts) == 0){
				$no_of_products .= ' product';
			}else{
				$no_of_products .= ' products';
			}
		
    	if($request->ajax()){
            return response()->json([
                'view' => (String)View::make('front.listings.product-listing')->with(compact('catseo','getcategories','getproducts','catdetails','sortname','paginate_link','search')),
                'countproducts' => count($getproducts),
                'no_of_products' => $no_of_products
            ]);
        }else{
			$page = 'listing-page';
            return view('front.listings.listing')->with(compact('catseo','getcategories','catdetails','maincategory','subcategories','getproducts','title','metakeywords','metadescription','catseo','sortname','selPrice','proage','paginate_link','search','no_of_products','page'));
        }
    }

    public function searchresults(Request $request){  
        if(isset($_GET['q']) && !empty($_GET['q']) || isset($_GET['sort']) && !empty($_GET['sort'])){
            $sortname ="";$selPrice="";$proage="";$search = array(); $string = '';
            $title="Product Results";
            $data = $request->all();
            if(isset($_GET['q']) && !empty($_GET['q'])){
            $string = trim($_GET['q']);
            Session::put('string', $string);
			}
			$catdetails['parent_id'] = '';
			$catdetails['id'] = '';
			$catdetails['seo_unique'] = '';
			if(isset($_GET['q']) && !empty($_GET['q'])){
                if($string == "new-arrivals"){
                    $title="New Arrivals";
                    $getproducts = Product::with('attributes')->where(['status'=>1,'new_arrival'=>'yes'])->orderby('id','DESC')->paginate(1000);
                }else{
                    $getproducts = Product::with('attributes')->join('categories','categories.id','=','products.category_id')->select('products.*','categories.name')->where(function ($q) use ($string) {
                        $q->where('products.product_name', 'like', '%'.trim($string).'%')->orWhere('products.short_description', 'like', '%'.trim($string).'%')->orWhere('categories.name', 'like', '%'.trim($string).'%')->orWhere('products.product_code', 'like', '%'.trim($string).'%');
                    })->whereExists( function ($query)  {
                        $query->from('categories')
                        ->whereRaw('products.category_id = categories.id')
                        ->where('categories.status',1);
                    })->where('products.status',1)->orderby('id','DESC')->paginate(1000);
                    $title = $string;
                }
			}else{
				$sortname =$_GET['sort'];
				$search['sort'] = $_GET['sort'];
                if($sortname=="lth"){
                    $field = 'products.final_price';
					$val = 'ASC';
                }else if($sortname=="htl"){
                    $field = 'products.final_price';
					$val = 'DESC';
                }else{
                    $field = 'products.product_sort';
    				$val = 'ASC';                    
                }
                $title = $sortname;
                
                    $getproducts = Product::with('attributes')->join('categories','categories.id','=','products.category_id')->select('products.*','categories.name')->where(function ($q) use ($string) {
                        $q->where('products.product_name', 'like', '%'.trim(Session::get('string')).'%');
                    })->whereExists( function ($query)  {
                        $query->from('categories')
                        ->whereRaw('products.category_id = categories.id')
                        ->where('categories.status',1);
                    })->where('products.status',1)->orderby($field,$val)->paginate(1000);                
                   // $getproducts = Product::with('attributes')->join('categories','categories.id','=','products.category_id')->where('categories.status',1)->select('products.*','categories.name')->where('products.status',1)->orderby($field,$val)->paginate(1000);
			}
			
			$no_of_products = 'Showing'; 
			if(!empty($getproducts->firstItem() )){
					$no_of_products .= '  '.$getproducts->firstItem();
			}else{
					$no_of_products .= '  0'; 
			}
		    $no_of_products .= ' to '.$getproducts->lastItem().' of '.$getproducts->total();
		    if(count($getproducts) == 1 || count($getproducts) == 0){
				$no_of_products .= ' product';
			}else{
				$no_of_products .= ' products';
			}
			
			$paginate_link =  $getproducts->links();
            $getproducts = $getproducts->appends(request()->except('page'));
            $metadescription = '';
            $metakeywords = '';
            $catdetails['name']  = $title;
			if($request->ajax()){	
			    $ajax = 'ajax';
				return response()->json([
					 'view' => (String)View::make('front.listings.product-listing')->with(compact('catdetails','getproducts','no_of_products','title','metakeywords','metadescription','proage','selPrice','sortname','ajax','search')),
					'countproducts' => count($getproducts)
				]);			
			}else{	
			   $catseo = 'search';
				return view('front.listings.listing')->with(compact('catdetails','catseo','getproducts','no_of_products','title','metakeywords','metadescription','proage','selPrice','sortname','search'));
			}
        }else{
            return redirect()->action('App\Http\Controllers\Front\IndexController@index');
        }
    }
     public function sale(Request $request){ 
            $sortname ="";$selPrice="";$proage="";$search = array(); $string = '';
            $title="Sales";
			$catdetails['parent_id'] = '';
			$catdetails['id'] = '';
			$catdetails['seo_unique'] = '';
			if(isset($_GET['sort'])){
			$sortname =$_GET['sort'];
			$search['sort'] = $_GET['sort'];
            if($sortname=="lth"){
                $field = 'products.final_price';
				$val = 'ASC';
            }else if($sortname=="htl"){
                $field = 'products.final_price';
				$val = 'DESC';
            }else{
                $field = 'products.product_sort';
				$val = 'ASC';                    
            }
			if(isset($_GET['sort']) && !empty($_GET['sort'])){
			    if($sortname=="lth"){
                    $getproducts = Product::with('attributes')->where(['status'=>1,'sale'=>'yes'])->orderby('products.final_price','ASC')->paginate(1000);
			    }else if($sortname=="htl"){
			        $getproducts = Product::with('attributes')->where(['status'=>1,'sale'=>'yes'])->orderby('products.final_price','DESC')->paginate(1000);
			    }else{
			        $getproducts = Product::with('attributes')->where(['status'=>1,'sale'=>'yes'])->orderby('products.product_sort','DESC')->paginate(1000);
			    }
			}
             }else{
                 $getproducts = Product::with('attributes')->where(['status'=>1,'sale'=>'yes'])->orderby('id','DESC')->paginate(1000);
             }
			$paginate_link =  $getproducts->links();
            $getproducts = $getproducts->appends(request()->except('page'));
            $metadescription = '';
            $metakeywords = '';
            $catdetails['name']  = $title;
			if($request->ajax()){	
			    $ajax = 'ajax';
				return response()->json([
					 'view' => (String)View::make('front.listings.product-listing')->with(compact('catdetails','getproducts','title','metakeywords','metadescription','proage','selPrice','sortname','ajax','search')),
					'countproducts' => count($getproducts)
				]);			
			}else{	
                return view('front.listings.listing')->with(compact('catdetails','getproducts','title','metakeywords','metadescription','proage','selPrice','sortname','search'));
        
			}
		}   
    public function wishlist(){
        $title = "Wishlist";
        if(Auth::check()){
            $wishlists =Wishlist::wishlists();
        }else{
            $wishlists = array();
        }
        return view('front.cart.wishlist')->with(compact('title','wishlists'));
    }

    public function removeWishlist($wishid){
        $check = Wishlist::where(['user_id'=>Auth::user()->id,'id'=>$wishid])->first();
        if($check){
            Wishlist::where('id',$wishid)->delete();
            return redirect()->back()->with('flash_message_success','Wishlist item has been deleted successfully');
        }else{
            return redirect()->back()->with('flash_message_error','Something Went Wrong');
        }
    }

        public function addtoWishlist(Request $request){
            $cartmessage ='';
        if($request->ajax()){
			 $data = $request->all();  
			 
			 if(isset($data['proid']) && !empty($data['proid'])){ 
				 $get_product =Product::where('id',$data['proid'])->first();
				 Session::put('previousurl',"/product/".@$get_product->seo_url);
			 }
			
			 
            if(Auth::check()){
				$data = $request->all();  
				if((isset($data['size']) && isset($data['qty'] )) && $data['qty'] != '' && $data['size'] != ''){
						
						$checkifExits = Wishlist::where([
							'user_id'=>Auth::user()->id,
							'size' => $data['size'],
							'product_id' => $data['proid'],
						])->count();
						
						if($checkifExits ==0){
						    $cartmessage = 'Product added successfully in wishlist';
							$wishlist = new Wishlist;
							$wishlist->user_id = Auth::user()->id;
							$wishlist->product_id = $data['proid'];
							$wishlist->size = $data['size'];
							$wishlist->qty = $data['qty'];
							$wishlist->save();
							return response()->json(['status'=>true,'login'=>true,'message'=>'set','alert_message'=>$cartmessage]);
						}else{
						    $cartmessage = 'Product remove successfully in wishlist';
							Wishlist::where([
								'user_id'=>Auth::user()->id,
								'qty' => $data['qty'],
								'size' => $data['size'],
								'product_id' => $data['proid'],
							])->delete();
							return response()->json(['status'=>true,'login'=>true,'message'=>'unset','alert_message'=>$cartmessage]);
						}
				
				    }else{
						$err_message = '';
						
						if(!isset($data['size']) || $data['size'] == '' )  { $err_message = 'Select the product size'; }
						if($data['qty'] == '') { $err_message .= 'Slect the product qty'; }
						return response()->json(['status'=>false,'login'=>true,'message'=>$err_message]);
					}
				
            }else{
                return response()->json(['status'=>false,'login'=>false,'message'=>'Please login','url'=>url('login')]);
            }
        }
    }
    public function productdetail(Request $request,$proseo){
        $response = Product::CheckProduct($proseo);
	
        if($response['status']){
            Session::put('previousurl',"/product/".$proseo);
            $productdetails = $response['productdetails'];
			$catdetails['parent_id'] =  ''; ///'';$request->parent_id;
			$catdetails['id'] =  ''; //$request->cat_id;
			$catdetails['seo_unique'] = ''; // $request->seo_unique;
            $title = $productdetails['product_name'];
            $productname = $productdetails['product_name'];
            $metadescription = "";
            $metakeywords ="";
            //RECENT VIEW ITEMS
            if(Session::has('recentSession')){
                Session::get('recentSession');
            }else{
                $recentSession = Session::getId();
                Session::put('recentSession',$recentSession);
            }
            //Save Recent Item
            $check = RecentViewProduct::where('session_id',Session::get('recentSession'))->where('product_id',$productdetails['id'])->count();
            if($check ==0){
                $recent = new RecentViewProduct;
                $recent->session_id = Session::get('recentSession');
                $recent->product_id = $productdetails['id'];
                $recent->save();
            }
             $sizechart = Category::where('parent_id',$response['productdetails']['category']['parent_id'])->get()->toArray();
            if(count($sizechart)>0){
                $sizechart = $sizechart[0]; 
            }else{
                $sizechart = ''; 
            }
            $recentitems = RecentViewProduct::with('product')->where('session_id',Session::get('recentSession'))->where('product_id','!=',$productdetails['id'])->orderby('id','DESC')->get()->toArray();
            
			
			$catids = explode(',', $response['productdetails']['category_id']);
			$get_related_products = Product::with(['productimages','product_image','category'])->where('products.status',1)->join('categories','categories.id','=','products.category_id')->select('products.*','categories.category_discount',DB::raw("(case when products.product_discount = 0 then categories.category_discount else  products.product_discount end ) as 'item_discount'"));
			$get_related_products = $get_related_products->leftjoin('product_categories','product_categories.product_id','=','products.id')->join('categories as cats','cats.id','=','product_categories.category_id')->wherein('product_categories.category_id',$catids)->groupby('product_categories.product_id');
			$get_related_products = $get_related_products->where('products.id','!=',$productdetails['id'])->whereExists( function ($query)  {
                $query->from('categories')
                ->whereRaw('products.category_id = categories.id')
                ->where('status',1);
            })->paginate(100);
			$page = 'product-detail';
            return view('front.listings.product-detail')->with(compact('productname','title','metadescription','metakeywords','productdetails','get_related_products','recentitems','catdetails','sizechart','page'));
        }else{
            return redirect('/');
        }
    }


    public function product_quick_view(Request $request){
        $data = $request->all();
        $proseo = $data['seo_url'];
        $response = Product::CheckProduct($proseo);  
        $product = $response['productdetails'];
        $html = (String)View::make('front.listings.product-quick-view')->with(compact('product'));	
        return response()->json(['status'=>true,'html'=>$html]);

    }

     public function getProductAttributePricing(Request $request){
        if($request->ajax()){
			$button = '<button type="submit" style="cursor: pointer;" data-cart-type=""  class="addCart btn-cart add-to-cart single_add_to_cart_button button alt mt-4"> Add to cart </button>
					<button type="submit" style="cursor: pointer;" name="wishlist" class="addWishList"><i class="whishlist-icon fa fa-heart"></i></button>';
            $data = $request->all(); 
            $details = Product::has('pro_attrs','>',0)->with(['pro_attrs'=>function($query) use($data){
                $query->where('size',$data['size']);
            },'category'])->where('id',@$data['proid'])->select('id','category_id','product_discount','current_discount','product_name','product_code')->where('status',1)->first();
            $details = json_decode(json_encode($details),true);
			$check_wishlist_count = 0;
			if(Auth::check()){
			$check_wishlist_count = Wishlist::where([
								'user_id'=>Auth::user()->id,
								'size' => $data['size'],
								'product_id' => $data['proid'],
							])->count();
			}
            if($details && $details['pro_attrs'][0]){
				 $attributeDetail = $details['pro_attrs'][0];
				$produt_details['product_price'] = $attributeDetail['price'];
				 $produt_details['product_discount'] = $details['product_discount'];
				
				if(!empty($details['product_discount'])){ 
					
					 $finalprice = $attributeDetail['price'] - ($attributeDetail['price'] * $details['product_discount'] /100);
					 $finalprice =  number_format($finalprice,0,'.','');
					 $pricings = array('price'=>$finalprice,'product_price'=>$produt_details['product_price']);
				}else{ 
					
					
					$finalprice = Product::ProductPrice( $data['catid'],$produt_details);
					$pricings = array('price'=>$finalprice,'product_price'=>$produt_details['product_price']);
				 }
				$single_product_price ='<h6>MRP: <span class="pricing-text">INR<span> '.$finalprice.'</span>';
				if($produt_details['product_price'] > $finalprice){
				$single_product_price .='- <span><strike> INR '.$produt_details['product_price'].'</strike></span>';
				}
				
				
				
				if($details['current_discount'] == 'product' || $details['current_discount'] == 'category'){
               
                    if($details['current_discount'] == 'product'){
                        $discount_percentage = $details['product_discount'];
                    }else{
                        $discount_percentage = $details['category']['category_discount'];
                    }
                     $single_product_price .='<span class="badge bg-dark ms-2" style="line-height: unset;">'.$discount_percentage.'% OFF</span>';
                } 
				
				
				
				
				
				
				$single_product_price .='</span></h6>';



               $quick_view_single_product_price = '<span class="product-prize">INR '.$finalprice;
               if($produt_details['product_price'] > $finalprice){
                   $quick_view_single_product_price .=  '<span class="cut-price" style=" text-decoration: line-through;">&nbsp;&nbsp;INR '.$produt_details['product_price'].' </span>'; 
                } 
                 
                 $quick_view_single_product_price .=  '</span>';

                if($details['current_discount'] == 'product' || $details['current_discount'] == 'category'){
               
                    if($details['current_discount'] == 'product'){
                        $discount_percentage = $details['product_discount'];
                    }else{
                        $discount_percentage = $details['category']['category_discount'];
                    }
                     $quick_view_single_product_price .='<span class="badge bg-dark ms-2">'.$discount_percentage.'% OFF</span>';
                } 
               
		  								 
								 
			  
			  $pricings['single_product_price'] = $single_product_price;
			  $pricings['quick_view_single_product_price'] = $quick_view_single_product_price;
				 
				 $current_stock = $details['pro_attrs'][0]['stock'];

					if ($current_stock >= 3) {
						$stock_class = '';
						$sizeStockText  = 'In Stock – Dispatches within 24 hours';
					} elseif ($current_stock == 2) {
						$stock_class = 'low-stock';
						$sizeStockText  = 'Only 2 Left – High demand, order soon to secure yours';
					} elseif ($current_stock == 1) {
						$stock_class = 'low-stock';
						$sizeStockText  = 'Only 1 Left – High demand, order soon to secure yours';
					} else {
						$stock_class = 'out-of-stock';
						$sizeStockText  = 'Out of Stock';
					}
				 /*<button type="submit" onclick=notifyme("'.$data['size'].'","'.$details['product_code'].'"); style="background-color:red;cursor: pointer;"  class="btn-cart single_add_to_cart_button button alt mt-4"> Sold out </button> */
				 if($details['pro_attrs'][0]['stock'] == 0){
					 $button = '<button type="submit" style="cursor: pointer;" name="wishlist" class="addWishList"><i class="whishlist-icon fa fa-heart"></i></button> ';
					 return response()->json(['status'=>false,'data'=>$pricings,'sizeStockText'=>$sizeStockText,'message'=>'Selected size is not available at the moment','button'=>$button,'wishlist_count'=>$check_wishlist_count,]);
				 }else{
                      return response()->json(['status'=>true,'data'=>$pricings,'sizeStockText'=>$sizeStockText, 'message'=>'ok','wishlist_count'=>$check_wishlist_count,'button'=>$button]);
				 }
		   }else{
				
				$finalprice = 0;
                $pricings = array('price'=>$finalprice,'product_price'=>$produt_details['product_price']);
                return response()->json(['status'=>false,'data'=>$pricings,'message'=>'Selected size is not available at the moment','wishlist_count'=>$check_wishlist_count,'button'=>$button]);
            }
        }
    }
    
	 public function checkProductQty(Request $request){
		 $data = $request->all();
         $checkStockDetails = ProductAttribute::attributeDetail($data['proid'],$data['size']);
		 if($data['qty'] > $checkStockDetails->stock){
			 $product = Product::where('id',$data['proid'])->first();
			 $pro_attrs = ProductAttribute::where('product_id',$data['proid'])->where('status',1)->get(); 
			 $notify = (String)View::make('front.listings.notify')->with(compact('pro_attrs','product'));	
			 return response()->json(['status'=>false,'type'=>'validation','notify'=>$notify,'errors'=>array('qty'=>"We're sorry! The requested quantity not available at this moment")]);
		 }else{
			 return response()->json(['status'=>true]);
		 }
	 }
	 public function get_order_summery(Request $request){
		 $data =  $request->all(); 
		$cartitems = Cart::cartitems();
        $cartPricing = Cart::cartdetails($cartitems,@$data['paymode']);
		$order_summary =  (String)View::make('front.checkout.order_summary')->with(compact('cartPricing','cartitems'));
		return response()->json(['status'=>true,'order_summary'=>$order_summary]);
 
	 }
	 
	 
	 
      public function addtoCart(Request $request){
        if($request->isMethod('post')){
            $data =  $request->all();
            $sizes = ProductAttribute::prosizes($data['proid']);
            $validator = Validator::make($request->all(), [
                    'size' => 'bail|required|in:'.implode(',',$sizes),
                    'qty'  => 'bail|required|numeric'
                ],
                [
                    'size.required' => 'Please select product size.',
                    'size.in' => 'Selected size is out of stock',
                ]
            );
            if($validator->passes()) {
                $checkStockDetails = ProductAttribute::attributeDetail($data['proid'],$data['size']);
                if($data['qty'] > $checkStockDetails->stock){
                    return response()->json(['status'=>false,'type'=>'validation','errors'=>array('qty'=>"We're sorry! The requested quantity not available at this moment")]);
                }
                //Check product Status
                $product = Product::where('status',1)->where('id',$data['proid'])->count();
                if($product ==0){
                    return response()->json(['status'=>false,'type'=>'validation','errors'=>array('Product is not available at the moment')]);
                }
                if(Auth::check()){
                  //  Cart::where(['product_id'=>$data['proid'],'size'=>$data['size'],'user_id'=>Auth::user()->id])->delete();
                }else{
                   // Cart::where('session_id',Session::get('cartsessionId'))->where(['product_id'=>$data['proid'],'size'=>$data['size']])->delete();
                }
                $checkcart = Cart::where(['product_id'=>$data['proid'],'size'=>$data['size']]);
                if(Auth::check()){
                    $checkcart = $checkcart->where('user_id',Auth::user()->id);
                }else{
                    $checkcart = $checkcart->where('session_id',Session::get('cartsessionId'));
                }
                $checkcart = $checkcart->first();
                $checkcart = json_decode(json_encode($checkcart),true);
                Session::forget('couponinfo');
                Session::forget('giftSession');
                //Pushing item in cart
                $todayDate = date('Y-m-d');
                $expiry_date = date('Y-m-d', strtotime("+7 days", strtotime($todayDate)));
                if(!Session::has('cartsessionId')){
                    $session_id = Session::getId();
                    Session::put('cartsessionId',$session_id);
                }
                $message = array('Product added successfully in cart');
                if(empty($checkcart)){
                    $cart = new Cart;
                }else{ 
                    $cart = Cart::find($checkcart['id']); 
                    return response()->json(['status'=>false,'type'=>'validation','errors'=>array('This product size has already added in cart')]); die();
                }
                $cart->session_id = (Auth::check()) ? '' : Session::get('cartsessionId');
                $cart->product_id = $data['proid'];
                $cart->size = $data['size'];
                $cart->qty = $data['qty'];
                $cart->expiry_date = $expiry_date;
				$cart->sku = $checkStockDetails->sku;
                $cart->next_expiry_date = date('Y-m-d', strtotime("+1 days", strtotime($todayDate)));
                if(Auth::check()){
                    $cart->user_id = Auth::user()->id;
                }
                $cart->save();
                $totalItems = Cart::totalitems();
				$cartdata = (String)View::make('front.cart.cart-popup');
				
                return response()->json(['status'=>true,'message'=>$message,'totalitems'=>$totalItems,'cartdata'=>$cartdata]);
            }else{
                return response()->json(['status'=>false,'type'=>'validation','errors'=>$validator->messages()]);
            }
        }
    }

    public function updatePopupCartProduct(Request $request){
        if($request->ajax()){
            $data = $request->all();
            $cartDetails = Cart::find($data['cartid']);
            if(!$cartDetails){
                $cartitems = Cart::cartitems();
                return response()->json([
                    'status'=>false,
                    'already_deleted'=>true,
					'cartssubtotal'=>Cart::cartsSubtotal(),
                    'message' =>"Cart item already deleted",
                ]);
            }
            if($data['qty'] ==0){
                $cartitems = Cart::cartitems();
                return response()->json([
                    'status'=>false,
					'already_deleted'=>false,
					'cartssubtotal'=>Cart::cartsSubtotal(),
                    'message' =>"Product Qty must be greater than or equal to 1",
                ]);
            }
            //check stock
            $checkStockDetails = ProductAttribute::attributeDetail($cartDetails->product_id,$cartDetails->size);
            if($data['qty'] > $checkStockDetails->stock){
                $cartitems = Cart::cartitems();
                return response()->json([
                    'status'=>false,
					'already_deleted'=>false,
					'cartssubtotal'=>Cart::cartsSubtotal(),
                    'current_qty'=>$cartDetails['qty'],
                    'message' =>"We're sorry! The requested quantity not avialable at this moment.",
                ]);
            }
            Session::forget('couponinfo');
            Session::forget('giftSession');
            Cart::where('id',$data['cartid'])->update(['qty'=>$data['qty']]);
            $cartitems = Cart::cartitems();
            return response()->json([
                'status'=>true,
                'cartssubtotal'=>Cart::cartsSubtotal(),
				'already_deleted'=>false,
                'message' =>"Quantity has been updated successfully",
            ]);
        }
    }

      public function updateCartProduct(Request $request){
        if($request->ajax()){
            $data = $request->all();
            $cartDetails = Cart::find($data['cartid']);
            if(!$cartDetails){
                $cartitems = Cart::cartitems();
                return response()->json([
                    'status'=>false,
                    'message' =>"Cart item already deleted",
                    'view' => (String)View::make('front.cart.cart-details')->with(compact('cartitems'))
                ]);
            }
            if($data['qty'] ==0){
                $cartitems = Cart::cartitems();
                return response()->json([
                    'status'=>false,
                    'message' =>"Product Qty must be greater than or equal to 1",
                    'view' => (String)View::make('front.cart.cart-details')->with(compact('cartitems'))
                ]);
            }
            //check stock
            $checkStockDetails = ProductAttribute::attributeDetail($cartDetails->product_id,$cartDetails->size);
            if($data['qty'] > $checkStockDetails->stock){
                $cartitems = Cart::cartitems();
                return response()->json([
                    'status'=>false,
                    'message' =>"We're sorry! The requested quantity not avialable at this moment.",
                    'view' => (String)View::make('front.cart.cart-details')->with(compact('cartitems'))
                ]);
            }
            Session::forget('couponinfo');
            Session::forget('giftSession');
            Cart::where('id',$data['cartid'])->update(['qty'=>$data['qty']]);
            $cartitems = Cart::cartitems();
            return response()->json([
                'status'=>true,
                'message' =>"Quantity has been updated successfully",
                'view' => (String)View::make('front.cart.cart-details')->with(compact('cartitems'))
            ]);
        }
    }

     public function updateCartProductsize(Request $request){
        if($request->ajax()){
            $data = $request->all();
            $cartDetails = Cart::find($data['cartid']);
            if(!$cartDetails){
                $cartitems = Cart::cartitems();
                return response()->json([
                    'status'=>false,
                    'message' =>"Cart item already deleted",
                    'view' => (String)View::make('front.cart.cart-details')->with(compact('cartitems'))
                ]);
            }
            if($data['size'] ==''){
                $cartitems = Cart::cartitems();
                return response()->json([
                    'status'=>false,
                    'message' =>"Select product size",
                    'view' => (String)View::make('front.cart.cart-details')->with(compact('cartitems'))
                ]);
            }
            //check stock
            /* $checkStockDetails = ProductAttribute::attributeDetail($cartDetails->product_id,$cartDetails->size);
            if($data['qty'] > $checkStockDetails->stock){
                $cartitems = Cart::cartitems();
                return response()->json([
                    'status'=>false,
                    'message' =>"We're sorry! The requested quantity not avialable at this moment.",
                    'view' => (String)View::make('front.cart.cart-details')->with(compact('cartitems'))
                ]);
            } */
            Session::forget('couponinfo');
            Session::forget('giftSession');
            Cart::where('id',$data['cartid'])->update(['size'=>$data['size'],'sku'=>$data['cartsku']]);
           // Cart::where('id',$data['cartid'])->update(['size'=>$data['size']]);
            $cartitems = Cart::cartitems();
            return response()->json([
                'status'=>true,
                'message' =>"Size has been updated successfully",
                'view' => (String)View::make('front.cart.cart-details')->with(compact('cartitems'))
            ]);
        }
    }




    public function cartItemsAjax(Request $request){
        if($request->ajax()){
			$cartitems = Cart::cartitems();
            return response()->json([
                'view' => (String)View::make('front.cart.cart-popup'),
                'totalItems' => count($cartitems)
            ]);
        }
    }

   
    public function applyCoupon(Request $request){
        if($request->ajax()){
            if(Auth::check()){
                $data = $request->all();
                $validator = Validator::make($request->all(), [
                        'code' => 'bail|required',
                    ]
                );
                if($validator->passes()){ 
                    $response = CouponCode::applycouponcode($data['code']);
                    $cartitems = Cart::cartitems();
                    return response()->json([
                        'status'=>$response['status'],
                        'message' =>$response['message'],
                        'view' => (String)View::make('front.cart.cart-details')->with(compact('cartitems'))
                    ]);
                }else{
                    Session::forget('couponinfo');
                    $cartitems = Cart::cartitems();
                    $totalItems = count($cartitems);
                    return response()->json([
                        'status'=>false,
                        'view' => (String)View::make('front.cart.cart-details')->with(compact('cartitems')),
                        'message' =>'Coupon Code is required'
                    ]);
                }
            }else{
                $cartitems = Cart::cartitems();
                $totalItems = count($cartitems);
                return response()->json([
                    'status'=>false,
                    'type' =>'login',
                    'view' => (String)View::make('front.cart.cart-details')->with(compact('cartitems')),
                    'message' =>'You need to login to apply this coupon'
                ]);
            }
        }
    }
	 public function applyPoints(Request $request){
        if($request->ajax()){
            if(Auth::check()){
                $data = $request->all();
                $validator = Validator::make($request->all(), [
                        'points' => 'bail|required',
                    ]
                ); 
                if($validator->passes()){ 
                    $response = Cart::applyPoints($data['points'],$data['payment_mode']);
                    $cartitems = Cart::cartitems();
					$cartPricing = Cart::cartdetails($cartitems,@$data['payment_mode']);
					$order_summary =  (String)View::make('front.checkout.order_summary')->with(compact('cartPricing','cartitems'));
					return response()->json(['status'=>$response['status'],'message' =>$response['message'],'order_summary'=>$order_summary]);
                    
                }else{
                    
					
					
                    $cartitems = Cart::cartitems();
					$cartPricing = Cart::cartdetails($cartitems,@$data['payment_mode']);
					$order_summary =  (String)View::make('front.checkout.order_summary')->with(compact('cartPricing','cartitems'));
					return response()->json(['status'=>false,'message' =>'Enter the points','order_summary'=>$order_summary]);
					
                }
            }else{
                
				
				    $cartitems = Cart::cartitems();
					$cartPricing = Cart::cartdetails($cartitems,@$data['payment_mode']);
					$order_summary =  (String)View::make('front.checkout.order_summary')->with(compact('cartPricing','cartitems'));
					return response()->json(['status'=>false,'message' =>'You need to login to apply this coupon','order_summary'=>$order_summary]);
				
				
				
            }
        }
    }
	public function removePoints(Request $request){
		if($request->ajax()){ 
		     Session::forget('pointsinfo');
			 $cartitems = Cart::cartitems();
			 $cartPricing = Cart::cartdetails($cartitems,@$data['payment_mode']);
			 $order_summary =  (String)View::make('front.checkout.order_summary')->with(compact('cartPricing','cartitems'));
			 return array('status' => false, 'message' => 'Points removed successfully.','order_summary'=>$order_summary);
		}
	}

    public function removeCartProduct(Request $request){
        if($request->ajax()){
            $data = $request->all();
            $cart = Cart::find($data['cartid']);
            if($cart){
                Session::forget('couponinfo');
                Session::forget('giftSession');
                $cart->delete();
                $cartitems = Cart::cartitems();
                $totalItems = count($cartitems);
                return response()->json([
                    'status'=>true,
                    'message' =>'Cart item has been deleted successfully',
                    'view' => (String)View::make('front.cart.cart-details')->with(compact('cartitems')),
                    'totalItems' => $totalItems
                ]);
            }else{
                $cartitems = Cart::cartitems();
                $totalItems = count($cartitems);
                return response()->json([
                    'status'=>false,
                    'message' =>'Cart item already deleted',
                    'view' => (String)View::make('front.cart.cart-details')->with(compact('cartitems')),
                    'totalItems' => $totalItems
                ]);
            }
        }
    }

    public function orderCheckout(){ 
	
        $cartitems = Cart::cartitems();
		$summery = Cart::cartdetails($cartitems); 
		
		
		
        if(!$cartitems){
            return redirect()->action('App\Http\Controllers\Front\ListingController@cart')->with('flash_message_error','Please add products in cart before checkout.');
        }
        $title ="Order Checkout";
        $metakeywords ="";
        $metadescription="";
        $cartPricing = Cart::cartdetails($cartitems);
        $states = State::orderby('name','ASC')->pluck('name')->toArray();
		$address['billing']  = BillingAddress::addresses();
		$address['shipping']  = ShippingAddress::addresses(); 
		$catseo = 'checkout';
		$page = 'checkout';
		
		
		$user  = User::where('id',Auth()->user()->id)->first();
		$availablePoints = $user->loyalty_points;
		
		
		
		
        return view('front.checkout.order-checkout')->with(compact('title','catseo','metakeywords','metadescription','cartPricing','cartitems','states','address','availablePoints','page'));
    }
	public function check_order_address($data){
		$validation_data = $data;
		
		$validation_data['shipping_first_name'] = CustomFunction::charactersOnly( $validation_data['shipping_first_name']);
		
		$validation_data['shipping_city'] = CustomFunction::charactersOnly( $validation_data['shipping_city']);
	

		
		$validator = Validator::make($validation_data, [
					'shipping_first_name' => 'required|regex:/^[a-zA-Z]+$/u|max:255',
                    'shipping_mobile' => 'required|numeric|digits:10',
                    'shipping_alternative_number' => 'required|numeric|digits:10',
                    'shipping_address' => 'bail|required',
                    'shipping_postcode' => 'required|numeric|digits:6',
                    'shipping_city' => 'required|regex:/^[a-zA-Z]+$/u|max:255',
                    'shipping_state' => 'bail|required',
                    'shipping_country' => 'bail|required',
                    'paymentMode' => 'bail|required',
                    
                ],
				[
					'shipping_first_name.required' => 'Enter the name.',
					'shipping_first_name.regex' => 'Enter the valid name.',
                    'shipping_mobile.required' => 'Enter the 10 digit valid mobile number.',
                    'shipping_alternative_number.required' => 'Enter the 10 digit valid alternative mobile number.',
                    'shipping_address.required' => 'Enter the address.',
                    'shipping_postcode.required' => 'Enter the postcode.',
                    'shipping_city.required' => 'Enter the city.',
                    'shipping_state.required' => 'Please select state.',
                    'shipping_country.required' => 'Please select country.',
                    'paymentMode.required' => '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert">×</button><span>Choose the payment method</span>',
                ]);
                
				return $validator;
	}
    public function checkOrder(Request $request){
		if($request->isMethod('post')){
            $data = $request->all();
			
			$validator = $this->check_order_address($request->all());
			
            if($validator->passes()){
				
				
				
				
					
				$CheckShippingAddress = ShippingAddress::addresses();
				if(!empty($CheckShippingAddress)){
					$shipping_address_id =  $CheckShippingAddress['id'];
					$save_shipping_address = ShippingAddress::find($shipping_address_id);
				}else{
					$save_shipping_address = new ShippingAddress;
				}
				
				$user_id = Auth::user()->id;
				$save_shipping_address->first_name = $data['shipping_first_name'];
				$save_shipping_address->name = $data['shipping_first_name'];
				$save_shipping_address->mobile = $data['shipping_mobile'];
				$save_shipping_address->alternative_number = $data['shipping_alternative_number'];
				$save_shipping_address->address = $data['shipping_address'];
				$save_shipping_address->postcode = $data['shipping_postcode'];
				$save_shipping_address->city = $data['shipping_city'];
				$save_shipping_address->state = $data['shipping_state'];
				$save_shipping_address->country = $data['shipping_country'];
				$save_shipping_address->user_id = $user_id;
				$save_shipping_address->is_default = 'yes';
				$save_shipping_address->save();
				
				
				 $action = url('/place-orders');
				 return response()->json(['status'=>true,'type'=>'validation','action'=>$action,'message'=>'ok']); 
			}else{
				return response()->json(['status'=>false,'type'=>'validation','errors'=>$validator->messages()]); 
				
			}
		}
	}
    public function placeOrder(Request $request){  
	
        if($request->isMethod('post')){ 

			$update_stock = 1;
			$validator = $this->check_order_address($request->all());
			
			if(!$validator->passes()){
				 return redirect()->action('App\Http\Controllers\Front\ListingController@orderCheckout')->with('flash_message_error','Enter the Billing Address and Billing Address');
				 die();
			}
			
            $data = $request->all();
            $cartitems = Cart::cartitems();
			
		/*	if($data['paymentMode'] == 'ccavenue'){
				$data['paymentMode'] = 'phonepe';
			} */
			
			
            if(!$cartitems){
                return redirect()->action('App\Http\Controllers\Front\ListingController@cart')->with('flash_message_error','Please add products in cart before placing an order.');
            }
            $shippingAddress = DB::table('shipping_addresses')->where('user_id',Auth::user()->id)->where('is_default','yes')->first();
           
		    if(empty($shippingAddress)){
                return redirect()->action('App\Http\Controllers\Front\ListingController@orderCheckout')->with('flash_message_error','Enter the Billing Address and Billing Address');
            }
			
			
			
			
			
			$billingAddress =BillingAddress::where('user_id',Auth::user()->id)->where('is_default','yes')->first();
			
			
			
			if(empty($billingAddress)){
				
				    $insert_billing_address = new BillingAddress; 
				    $insert_billing_address->user_id =Auth::user()->id;
				    $insert_billing_address->is_default ='yes';
				    $insert_billing_address->name =$shippingAddress->name;
				    $insert_billing_address->first_name =$shippingAddress->first_name;
				    $insert_billing_address->last_name =$shippingAddress->last_name;
				    $insert_billing_address->mobile =$shippingAddress->mobile;
				    $insert_billing_address->alternative_number =$shippingAddress->alternative_number;
				    $insert_billing_address->postcode =$shippingAddress->postcode;
				    $insert_billing_address->address =$shippingAddress->address;
				    $insert_billing_address->address2 =$shippingAddress->address2;
				    $insert_billing_address->country =$shippingAddress->country;
				    $insert_billing_address->state =$shippingAddress->state;
				    $insert_billing_address->city =$shippingAddress->city;
					$insert_billing_address->save();
			        $billingAddress = $insert_billing_address;
			}
			
			$user_info = User::where('id',Auth::user()->id)->first();
			
			if(empty($user_info->state)){
				
				
				$update_user_profile = [
				
				             'name'=>$billingAddress->name,
				             'first_name'=>$billingAddress->first_name,
				             'mobile'=>$billingAddress->mobile,
				             'postcode'=>$billingAddress->postcode,
				             'mobile'=>$billingAddress->mobile,
				             'address'=>$billingAddress->address,
				             'address2'=>$billingAddress->address2,
				             'country'=>$billingAddress->country,
				             'state'=>$billingAddress->state,
				             'city'=>$billingAddress->city
				
				
				
				];
				
				User::where('id',Auth::user()->id)->update($update_user_profile);
			}
			
			
			
			
	        
            $paymentModeArr = array('cod','phonepe','ccavenue','razorpay'); 
            if(isset($data['paymentMode']) && in_array($data['paymentMode'],$paymentModeArr)){
                $paymentmethod = $data['paymentMode'];
                
				if($data['paymentMode'] =='phonepe'){ 
                    $paymentStatus = "cancelled";
                    $orderstatus = "Abandoned";
                    $comments = "Payment has been abandoned";
					$update_stock = 0;
                }if($data['paymentMode'] =='razorpay'){
                    $paymentStatus = "cancelled";
                    $orderstatus = "Abandoned";
                    $comments = "Payment has been abandoned";
					$update_stock = 0;
                }if($data['paymentMode'] =='ccavenue'){
                    $paymentStatus = "cancelled";
                    $orderstatus = "Abandoned";
                    $comments = "Payment has been abandoned";
					$update_stock = 0;
                }else if($data['paymentMode'] =='cod'){
                    $paymentStatus ="cod";
                    $orderstatus = "COD Confirmed";
                    $comments = "COD order created";
                }
            }else{
                return redirect()->action('App\Http\Controllers\Front\ListingController@orderCheckout')->with('flash_message_error','Something went wrong!. Please try again');
            }
            //Get Cart details grand total, discount, subtotal
			/*$couponinfo = CouponCode::where('code',Session::get('couponinfo')['code'])->first();
			if(!empty($couponinfo)){
				if($couponinfo['coupon_usage'] > 0){
					//$update_coupon_usage['coupon_usage'] = $couponinfo['coupon_usage']-1;
					//CouponCode::where('id', $couponinfo['id'])->limit(1)->update($update_coupon_usage);
		   
				}
			}*/
			
			 $cartDetails = Cart::cartdetails($cartitems,$data['paymentMode']);
			
			if($cartDetails['final_grandtotal'] < 1){
				return redirect()->action('App\Http\Controllers\Front\ListingController@orderCheckout')->with('flash_message_error','Grand total must be greater than 0');
			}
			
		   
			
			
		    if(Session::get('couponinfo')){
                CouponCode::checkCouponStatus();
		    }
           $cartDetails = Cart::cartdetails($cartitems,$data['paymentMode']);  
            DB::beginTransaction();
            $giftid  = 0;$giftname =''; $giftmrp =0;
           
		   
		  
		 
		   
		   
		   
		   
            $orderArray = array(
				'user_id'=>Auth::user()->id,
				'payment_method'=>$data['paymentMode'],
				'coupon_code'=> $cartDetails['couponcode'],
				'prepaid_discount'=>$cartDetails['prepaid_discount'],
				'prepaid_discount_percentage'=>$cartDetails['prepaid_discount_percentage'],
				'total_order_discount'=>$cartDetails['total_order_discount'],
				'order_discount'=>$cartDetails['order_discount'],
				'order_discount_percentage'=>$cartDetails['order_discount_percentage'],
				'coupon_discount'=>$cartDetails['discount'],
				'shipping_charges'=>$cartDetails['shipping'],
				'subtotal'=>$cartDetails['subtotal'],
				'grand_total_without_round_of'=>$cartDetails['grandtotal']-$cartDetails['amount_redeemed'],
				'round_of'=>$cartDetails['round_of'],
				'amount_redeemed'=>$cartDetails['amount_redeemed'],
				'points_redeemed'=>$cartDetails['points_redeemed'],
				'grand_total'=>$cartDetails['final_grandtotal']-$cartDetails['amount_redeemed'],
				'payment_status'=>$paymentStatus,
				'order_status'=>$orderstatus,
				'comments'=>$data['comments'],
				'gift_id'=>$giftid,
				'gift_name'=>$giftname,
				'gift_mrp'=>$giftmrp,
				'ip_address'=>$_SERVER['REMOTE_ADDR']
			);
            //Create Order  
			  
            Order::create($orderArray);
            $orderid = DB::getPdo()->lastInsertId();
            //Create Addresses in Order Address Model
              $orderAddrArr = array(
					'order_id'=>$orderid,
					'billing_name'=>$billingAddress->name,
					'billing_first_name'=>$billingAddress->name,
					'billing_last_name'=>'',
					'billing_mobile'=>$billingAddress->mobile,
					'billing_alternative_number'=>$billingAddress->alternative_number,
					'billing_postcode'=>$billingAddress->postcode,
					'billing_address'=>$billingAddress->address,
					'billing_address2'=>$billingAddress->address2,
					'billing_country'=>$billingAddress->country,
					'billing_state'=>$billingAddress->state,
					'billing_city'=>$billingAddress->city,
					
					'shipping_name'=>$shippingAddress->name,
					'shipping_first_name'=>$shippingAddress->name,
					'shipping_last_name'=>'',
					'shipping_mobile'=>$shippingAddress->mobile,
					'shipping_alternative_number'=>$shippingAddress->alternative_number,
					'shipping_postcode'=>$shippingAddress->postcode,
					'shipping_address'=>$shippingAddress->address,
					'shipping_address2'=>'',
					'shipping_country'=>$shippingAddress->country,
					'shipping_state'=>$shippingAddress->state,
					'shipping_city'=>$shippingAddress->city,
					'company_name'=>$shippingAddress->company_name,
					'gstin'=>'',
			);
			OrderAddress::create($orderAddrArr);
            //Create Order Products
            foreach($cartitems as $cartitem){
                //reducing stock
				if($update_stock != 0){
					//ProductAttribute::where('product_id',$cartitem['product_id'])->where('size',$cartitem['size'])->where('status','1')->decrement('stock',$cartitem['qty']);
                   // ProductAttribute::where('product_id',$cartitem['product_id'])->where('size',$cartitem['size'])->where('status','1')->where('size',$cartitem['size'])->update(['stock_alert'=>0]);
				}
				$priceDetails = Cart::calProPricing($cartitem);
                //Get Barcode
                $proAttrBarcode = ProductAttribute::where('product_id',$cartitem['product_id'])->where('size',$cartitem['size'])->where('status',1)->select('bar_code')->first();
                
                //Create Order Products array
              
				$OrderProArr = array('order_id'=>$orderid,'user_id'=>Auth::user()->id,'product_id'=>$cartitem['product_id'],'category_name'=>$cartitem['product']['category']['name'],'product_name'=>$cartitem['product']['product_name'],'product_code'=>$cartitem['product']['product_code'],'product_sku'=>$cartitem['sku'],'product_size'=>$cartitem['size'],'mrp'=>$cartitem['price'],'discount_type'=>$cartitem['product']['current_discount'],'discount' =>$priceDetails['discount'],'product_price'=>$priceDetails['price'],'product_qty'=>$cartitem['qty'],'subtotal'=> $priceDetails['prosubtotal'],'grand_total'=>$cartDetails['grandtotal']);
                OrderProduct::create($OrderProArr);
            }
			
            Session::forget('couponinfo');
            if(Session::has('pointsinfo')){
				     
					 Order::redeemRewardPoints($orderid,Session::get('pointsinfo')['points']);
			}
			Session::forget('pointsinfo');
            Session::put('orderid',$orderid);
            $history = array('order_status'=>$orderstatus,'comments'=>$comments,'order_id'=>$orderid);
            OrderHistory::create($history);
			update_order_product_gst($orderid);
            DB::commit();
			
			
			 
			
			
			
			
			
            if(isset($data['paymentMode']) && !empty($data['paymentMode']) && $data['paymentMode'] =="phonepe" ){
                    //For prepaid Orders 
                   return redirect::to('phonepe-payment?id='.encrypt($orderid));

            }else if(isset($data['paymentMode']) && !empty($data['paymentMode']) && $data['paymentMode'] =="razorpay" ){
                    //For prepaid Orders 
                   return redirect::to('razorpay-payment?id='.encrypt($orderid));

            }else if(isset($data['paymentMode']) && !empty($data['paymentMode']) && $data['paymentMode'] =="ccavenue" ){
                    //For prepaid Orders 
                   return redirect::to('ccavenue/payment?id='.encrypt($orderid));

            }else{
                if(!empty(Auth::user()->mobile)){
                    $smsdetails['mobile']  = Auth::user()->mobile;
                    $smsdetails['message'] = "Dear ".Auth::user()->name. ", your order no. ".$orderid." been successfully placed with deerclubonline.com . We shall intimate you once your order is shipped. Write to info@deerclubonline.com for any queries.";
                   // sendSms($smsdetails);
                }
				foreach($cartitems as $cartitem){
				    Wishlist::where([
							'user_id'=>Auth::user()->id,
							'size' => $cartitem['size'],
							'product_id' => $cartitem['product_id'],
						])->delete();
				}
				if(env('MAIL_MODE') =="live" ){
				     $email = Auth::user()->email;
                    $orderDetails = Order::with(['order_products','order_address'])->where('id',$orderid)->first();
                    $orderDetails = json_decode(json_encode($orderDetails),true);
                    $messageData = [
                        'orderDetails' => $orderDetails
                    ];
					$admin_mail =   config('constants.admin_mail');
						   foreach($admin_mail as $email){
								Mail::send('emailtemplate.to_admin.order-success-email', $messageData, function($message) use ($email){
									$message->to($email)->subject('New Order has been placed at '.config('constants.project_name'));
								}); 
							}
				}
                if(env('MAIL_MODE') =="live" && Auth::user()->user_type=="normal"){ 
                    $email = Auth::user()->email;
                    $orderDetails = Order::with(['order_products','order_address'])->where('id',$orderid)->first();
                    $orderDetails = json_decode(json_encode($orderDetails),true);
                    $messageData = [
                        'orderDetails' => $orderDetails
                    ];
                    $emails = array($email);
					
						
							foreach($emails as $email){
								Mail::send('emailtemplate.to_user.order-success-email', $messageData, function($message) use ($email){
									$message->to($email)->subject('Thanks for Placing the Order with '.config('constants.project_name'));
								}); 
							}
							
					
					 
					
                }
				Order::update_stock($orderid);
				
				
				
				
				Order::creditRewardPoints($orderid);
				
				
				
				
                return redirect()->action([\App\Http\Controllers\Front\ListingController::class, 'thanks']);
            }
        }
    }

    public function thanks(Request $request){
         error_reporting(0);
	   $data =$request->all();
		if(isset($data['id'])){
			$id = decrypt($data['id']); 
			Session::put('orderid',$id);
		} 
        if(Session::has('orderid')){
            //Clean Cart table
            Cart::where('user_id',Auth::user()->id)->delete();
            $orderdetails = Order::with(['order_products','order_address'])->where('id',Session::get('orderid'))->first();
            $orderdetails = json_decode(json_encode($orderdetails),true);
           
            $title = "Thanks";
             $user_order_id = Session::get('orderid');
            return view('front.checkout.thanks')->with(compact('title','orderdetails','user_order_id'));
        }else{
            return redirect()->action('App\Http\Controllers\Front\IndexController@index');
        }
    }  

    public function cancel(Request $request){
         $data =$request->all();
		if(isset($data['id'])){
			$id = decrypt($data['id']); 
			Session::put('orderid',$id);
		}
		$orderdetails = array();
        if(Session::has('orderid')){
            $data =$request->all();
            Order::where('id',Session::get('orderid'))->update(['order_status'=>'Cancelled']);
            $title = "Order Cancelled";
            return view('front.checkout.cancel')->with(compact('title','orderdetails'));
        }else{ 
           return redirect()->action('App\Http\Controllers\Front\IndexController@index');
        }
    }

    public function viewOrderEmail($orderid){
        $orderDetails = Order::with(['order_products','order_address'])->where('id',$orderid)->first();
        $orderDetails = json_decode(json_encode($orderDetails),true);
        return view('emails.order-success-email')->with(compact('orderDetails'));
    } 
   public function search_autofill(Request $request){
		$string = $request->value;
		if($string == ''){
			echo  ''; die();
		}
		$Auto_fill_Data = '';
		$auto_fill_result = '';
		$getproducts = Product::join('categories','categories.id','=','products.category_id')->select('products.id','products.product_name','products.product_tag')->where(function ($q) use ($string) {
                    $q->where('products.product_name', 'like', '%'.trim($string).'%')->orWhere('products.product_tag', 'like', '%'.trim($string).'%')->orWhere('products.short_description', 'like', '%'.trim($string).'%')->orWhere('categories.name', 'like', '%'.trim($string).'%')->orWhere('products.product_code', 'like', '%'.trim($string).'%');
                })->whereExists( function ($query)  {
                    $query->from('categories')
                    ->whereRaw('products.category_id = categories.id')
                    ->where('categories.status',1);
                })->where('products.status',1)->orderby('id','DESC')->get()->toArray();
				if(!empty($getproducts)){
					$product_name = array_column($getproducts, 'product_name');
					$auto_fill_product_names=  implode(',',$product_name);
					$product_tag = array_column($getproducts, 'product_tag');
					$all_product_tag = array_filter($product_tag); 
					$tag_string = implode(",",$all_product_tag);
					$array_unique_tag =  array_unique(explode(",",$tag_string));
					//$array_unique_tag = preg_grep('~' . $string . '~', $array_unique_tag);
					$auto_fill_tags=  implode(',',$array_unique_tag);
					if($auto_fill_tags != ''){
						$Auto_fill_Data .= $auto_fill_tags;
					}	
                    if($auto_fill_product_names != ''){
						if($Auto_fill_Data != ''){
						  $Auto_fill_Data .= ','.$auto_fill_product_names;
					    }else{
						  $Auto_fill_Data .= $auto_fill_product_names;
						}
				     }
					 
					  foreach(explode(',',$Auto_fill_Data) as $keyword){
                               $auto_fill_result = '';
							   $keyword_lc = strtolower($keyword);
							 
							   $string_lc = strtolower($string);
                             if(strpos($keyword_lc, $string_lc) !== false){
								    
										echo ','.$keyword;  
									
								} 
						 
					 }
					 
					     
                				
					 
					 
                }
               		
	}		

}