<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\StreamedResponse;
use App\Category;
use App\ProductAttribute;
use App\ProductAttributeLog;
use App\Order;
use Auth;
use Session;

class ProductAttributeController extends Controller
{
    public function index()
    {  
        $categories =$this->getcategories();
		return view('admin.product_attributes.index', compact('categories'))->render();
    }
    public function filterStock(Request $request)
    {
        $filter = $request->all(); 
		Session::put('stock_filter',$filter); 
		
    } 
    public function fetch(Request $request)
	{
		$sortColumn = $request->sortColumn ?? 'id';
		$sortOrder = $request->sortOrder ?? 'desc';

		$products = ProductAttribute::select('product_attributes.*','products.product_code','products.seo_url','categories.name as category_name','categories.seo_unique as category_url')
		->join('products','products.id','=','product_attributes.product_id')
		->join('categories','categories.id','=','products.category_id')
		->where('product_attributes.status','1')
		->where('products.status','1')
		->where('categories.status','1');
		
		
		if(Session::has('stock_filter')){
		   
		   if(isset(Session::get('stock_filter')['cats']) && !empty(Session::get('stock_filter')['cats'])){
			  $productCats = Session::get('stock_filter')['cats'];
			  $products = $products->wherein('categories.id',$productCats);
		  }
		   
		 if(isset(Session::get('stock_filter')['stock_from']) && Session::get('stock_filter')['stock_from'] != ''){
			  $stock_from = Session::get('stock_filter')['stock_from'];
			  $products = $products->where('product_attributes.stock', '>=',$stock_from);
		  } 
		  if(isset(Session::get('stock_filter')['stock_to']) && Session::get('stock_filter')['stock_to'] != ''){
			  $stock_to = Session::get('stock_filter')['stock_to'];
			  $products = $products->where('product_attributes.stock', '<=',$stock_to);
		  } 
		  if(isset(Session::get('stock_filter')['keyword']) && !empty(Session::get('stock_filter')['keyword'])){
			  $keyword = Session::get('stock_filter')['keyword'];
			  
			  
			  $products = $products->where(function($query) use($keyword) {
					       $query->orWhere('product_attributes.size', 'like', '%' . $keyword . '%')
					             ->orWhere('product_attributes.sku', 'like', '%' . $keyword . '%')
					             ->orWhere('products.product_name', 'like', '%' . $keyword . '%')
							     ->orWhere('categories.name', 'like', '%' . $keyword . '%');
				});
			  
			  
			  
			  
		  }  
		  
		  
		  
		  
		

	   }
		
		
		
		
		$products = $products->orderBy($sortColumn, $sortOrder)
			->paginate(5);
			
			
		        $product_count = 'Showing '; 
                if ($products->total() > 0){
                    $product_count .= $products->firstItem().' to '.$products->lastItem();
	            }else{
					$product_count .= ' 0';
				}
                    
               
                $product_count .= ' of '.$products->total().' products';	
			
			    $html = view('admin.product_attributes.table', compact('products'))->render();
			
			    return response()->json(['success'=>true,'html'=>$html,'product_count'=>$product_count]);

		
	}

    public function updateStock(Request $request)
    {
        
		$get_attr = ProductAttribute::find($request->id);
            
		ProductAttribute::where('id', $request->id)
            ->update(['stock' => $request->stock]);
        
		
		if($get_attr->stock != $request->stock){ 
						$stock_logs = new ProductAttributeLog;
						$stock_logs->attribute_id = $request->id;
						$stock_logs->action = '1'; /* qty update by admin */
						$stock_logs->qty =  $request->stock - $get_attr->stock;
						$stock_logs->stock_remaining = $request->stock; 
						if($get_attr->stock < $request->stock){
							$stock_message = 'Stock Added';
						}else{
							$stock_message = 'Stock Removed';
						}
						$stock_logs->message = $stock_message;
						$stock_logs->admin_id = Auth::guard('admin')->user()->id;
						$stock_logs->save();
		}
		
		
		
		
		
		
        return response()->json(['success' => true]);
    }
	
	
	
	
	 public function logs(Request $request){
		 
		 $logs = ProductAttributeLog::where('attribute_id',$request->input('id'))->orderby('id','desc')->get()->toArray();
		 
		 $html = view('admin.product_attributes.log_modal', compact('logs'))->render();
			
	     return response()->json(['success'=>true,'html'=>$html]);
	 }
	
	
	
	 public function export(Request $request){
        $headers = array(
            'Content-Type'        => 'text/csv',
            'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
            'Content-Disposition' => 'attachment; filename=product_stocks.csv',
            'Expires'             => '0',
            'Pragma'              => 'public',
        );
        $response = new StreamedResponse(function(){
            // Open output stream
            $handle = fopen('php://output', 'w');
            // Add CSV headers
            fputcsv($handle, ["Product Code","Product Name","Category Name","Sku","Size","Price","Stock"]);
            
			$products = ProductAttribute::select('product_attributes.*','products.product_code','products.product_name','products.seo_url','categories.name as category_name','categories.seo_unique as category_url')
		->join('products','products.id','=','product_attributes.product_id')
		->join('categories','categories.id','=','products.category_id')
		->where('product_attributes.status','1')
		->where('products.status','1')
		->where('categories.status','1');
		
		
		if(Session::has('stock_filter')){
		   
		   if(isset(Session::get('stock_filter')['cats']) && !empty(Session::get('stock_filter')['cats'])){
			  $productCats = Session::get('stock_filter')['cats'];
			  $products = $products->wherein('categories.id',$productCats);
		  }
		   
		 if(isset(Session::get('stock_filter')['stock_from']) && Session::get('stock_filter')['stock_from'] != ''){
			  $stock_from = Session::get('stock_filter')['stock_from'];
			  $products = $products->where('product_attributes.stock', '>=',$stock_from);
		  } 
		  if(isset(Session::get('stock_filter')['stock_to']) && Session::get('stock_filter')['stock_to'] != ''){
			  $stock_to = Session::get('stock_filter')['stock_to'];
			  $products = $products->where('product_attributes.stock', '<=',$stock_to);
		  } 
		  if(isset(Session::get('stock_filter')['keyword']) && !empty(Session::get('stock_filter')['keyword'])){
			  $keyword = Session::get('stock_filter')['keyword'];
			  
			  
			  $products = $products->where(function($query) use($keyword) {
					       $query->orWhere('product_attributes.size', 'like', '%' . $keyword . '%')
					             ->orWhere('product_attributes.sku', 'like', '%' . $keyword . '%')
					             ->orWhere('products.product_name', 'like', '%' . $keyword . '%')
							     ->orWhere('categories.name', 'like', '%' . $keyword . '%');
				});
			  
			  
		  }  
		
	   }
		
	
			$products = $products->chunk(500, function($rows) use($handle) {
                foreach ($rows as $row){
                    fputcsv($handle, [
                        $row->product_code,
                        $row->product_name,
                        $row->category_name,
                        $row->sku,
                        $row->size,
                        $row->price,
                        $row->stock,
                        
                    ]);
                }
            });
            // Close the output stream
            fclose($handle);
        }, 200, $headers);

        return $response->send();
    }
	
	
	
	
	
	
	
	
}

