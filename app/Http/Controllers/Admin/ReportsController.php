<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\StreamedResponse;
use App\Subscriber;
use App\Product;
use App\OrderProduct;
use App\ProductAttribute;
use App\ProductImage;
use App\User;
use DB;
class ReportsController extends Controller
{
    //
	public function exportUsers(Request $request){
        if($request->isMethod('post')){
            $data = $request->all();
            $headers = array(
                'Content-Type'        => 'text/csv',
                'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
                'Content-Disposition' => 'attachment; filename=users.csv',
                'Expires'             => '0',
                'Pragma'              => 'public',
            );
            $response = new StreamedResponse(function() use($data) {
                // Open output stream
                $handle = fopen('php://output', 'w');
                // Add CSV headers
                fputcsv($handle, ["UserId","Full Name","User Type","First Name","Last Name","Email","Mobile","State","City","Postcode","Address","Status","Created At"]);
                $exportUsers  = User::orderby('id','DESC');
                if(!empty($data['from_date'])){
                    $exportUsers = $exportUsers->whereDate('users.created_at','>=',$data['from_date']);
                }
                if(!empty($data['to_date'])){
                    $exportUsers = $exportUsers->whereDate('users.created_at','<=',$data['to_date']);
                }
                $exportUsers = $exportUsers->chunk(500, function($users) use($handle) {
                    foreach ($users as $user){
                        fputcsv($handle, [
                            $user->id,
                            $user->name,
                            $user->user_type,
                            $user->first_name,
                            $user->last_name,
                            $user->email,
                            $user->mobile,
                            $user->state,
                            $user->city,
                            $user->postcode,
                            $user->address,
                            $user->status,
                            date('d M Y',strtotime($user->created_at))
                        ]);
                    }
                });
                // Close the output stream
                fclose($handle);
            }, 200, $headers);

            return $response->send();
        }
        $title = "Export Users";
        return view('admin.users.export-users')->with(compact('title'));
    }

    public function exportSubscribers(Request $request){
        $headers = array(
            'Content-Type'        => 'text/csv',
            'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
            'Content-Disposition' => 'attachment; filename=subscribers.csv',
            'Expires'             => '0',
            'Pragma'              => 'public',
        );
        $response = new StreamedResponse(function(){
            // Open output stream
            $handle = fopen('php://output', 'w');
            // Add CSV headers
            fputcsv($handle, ["Email","Type"]);
            $exportSubscribers  = Subscriber::select('email','type');
            $exportSubscribers = $exportSubscribers->chunk(500, function($subscribers) use($handle) {
                foreach ($subscribers as $subscriber){
                    fputcsv($handle, [
                        $subscriber->email,
                        $subscriber->type
                    ]);
                }
            });
            // Close the output stream
            fclose($handle);
        }, 200, $headers);

        return $response->send();
    }


    public function exportorders(Request $request){
    	if($request->isMethod('post')){
    		$data = $request->all();
	        $headers = array(
	            'Content-Type'        => 'text/csv',
	            'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
	            'Content-Disposition' => 'attachment; filename=orders.csv',
	            'Expires'             => '0',
	            'Pragma'              => 'public',
	        );
	        $response = new StreamedResponse(function() use($data){
	            // Open output stream
	            $handle = fopen('php://output', 'w');
	            // Add CSV headers
	            fputcsv($handle, ["OrderId","UserId","Email","Name","Address","City","State","Postcode","Mobile",'Coupon','Order Status','Payment Method','Order Date','Product Name','Code','Size','Barcode','Product Qty','MRP','Product Discount RS','Product Discount %','Product Price','Shipping Charges','Coupon Discount','Grand Total']);

	            $exportOrders  = OrderProduct::join('orders','orders.id','=','order_products.order_id')->join('order_addresses','order_addresses.order_id','=','orders.id')->join('users','users.id','=','orders.user_id')->join('products','products.id','=','order_products.product_id')->select('order_products.order_id','order_products.product_id','order_addresses.shipping_name','order_addresses.shipping_address','order_addresses.shipping_city','order_addresses.shipping_state','order_addresses.shipping_postcode','order_addresses.shipping_mobile','orders.user_id','orders.comments','orders.shipping_charges','orders.coupon_code','orders.coupon_discount','orders.order_status','orders.payment_method','orders.created_at','orders.grand_total','order_products.product_name','order_products.product_code','order_products.product_barcode','order_products.product_qty','order_products.product_price','order_products.product_size','order_products.discount as prodiscount','order_products.mrp','order_products.discount_type','users.email')->orderBy('order_products.id','DESC');
	            if(isset($data['status']) && !empty($data['status'])){
	                $exportOrders = $exportOrders->wherein('orders.order_status',$data['status']);
	            }
	            if(!empty($data['from_date'])){
	                $exportOrders = $exportOrders->whereDate('orders.created_at','>=',$data['from_date']);
	            }
	            if(!empty($data['to_date'])){
	                $exportOrders = $exportOrders->whereDate('orders.created_at','<=',$data['to_date']);
	            }
	            $exportOrders = $exportOrders->chunk(500, function($orderPro) use($handle) {
	                foreach ($orderPro as $order) {   
	                    // Add a new row with data
	                    
						$discount_percentage = round((($order->prodiscount)/$order->mrp)*100);
						if(!empty($discount_percentage)){
							$discount_percentage = $discount_percentage.'%';
						}else{
							$discount_percentage = '';
						}
						
						fputcsv($handle, [
	                        $order->order_id,
                            $order->user_id,
	                        $order->email,
	                        $order->shipping_name,
	                        $order->shipping_address,
	                        $order->shipping_city,
	                        $order->shipping_state,
	                        $order->shipping_postcode,
	                        $order->shipping_mobile,
	                        $order->coupon_code,
	                        $order->order_status,
	                        $order->payment_method,
	                        date('Y-m-d h:i:s',strtotime($order->created_at)),
	                        $order->product_name,
                            $order->product_code,
                            $order->product_size,
                            $order->product_barcode,
	                        $order->product_qty,
	                        formatAmt($order->mrp),
	                        $order->prodiscount,
	                        $discount_percentage,
	                        formatAmt($order->product_price),
	                        formatAmt($order->shipping_charges),
	                        formatAmt($order->coupon_discount),
	                        formatAmt($order->grand_total)
	                        
	                    ]);
	                }
	            });
	            // Close the output stream
	            fclose($handle);
	        }, 200, $headers);
	        return $response->send();
    	}else{
    		$orderstatuses =  DB::table('order_statuses')->get();
    		$orderstatuses = json_decode(json_encode($orderstatuses),true); 
    		$title = "Export Orders";
    		return view('admin.orders.export-orders')->with(compact('title','orderstatuses'));
    	}
    }
    public function exportProductStock(Request $request){

        $headers = array(
            'Content-Type'        => 'text/csv',
            'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
            'Content-Disposition' => 'attachment; filename=Product_Stock.csv',
            'Expires'             => '0',
            'Pragma'              => 'public',
        );
        $response = new StreamedResponse(function(){
            // Open output stream
            $handle = fopen('php://output', 'w');
            // Add CSV headers
            fputcsv($handle, ["ProductName","Product Code","Sku","Size","Stock"]); 
			
	            $exportSubscribers  = Product::join('product_attributes','product_attributes.product_id','=','products.id')->select('products.id','products.product_name','products.product_code','product_attributes.sku','product_attributes.stock','product_attributes.product_id','product_attributes.size');			

            $exportSubscribers = $exportSubscribers->chunk(10, function($product) use($handle) {
                foreach ($product as $productvalue){
                    fputcsv($handle, [
                        $productvalue->product_name,
                        $productvalue->product_code,
                        $productvalue->sku,
						$productvalue->size,
						$productvalue->stock
                    ]);
                }
            });
            // Close the output stream
            fclose($handle);
        }, 200, $headers);

        return $response->send();
    }
    public function exportattributeTable(Request $request){
        $headers = array(
            'Content-Type'        => 'text/csv',
            'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
            'Content-Disposition' => 'attachment; filename=product_attributes.csv',
            'Expires'             => '0',
            'Pragma'              => 'public',
        );
        $response = new StreamedResponse(function(){
            // Open output stream
            $handle = fopen('php://output', 'w');
            // Add CSV headers
            fputcsv($handle, ["id","product_id","sku","bar_code","size","stock","price","status","created_at","updated_at"]);
            $ProductAttribute  = ProductAttribute::select("id","product_id","sku","bar_code","size","stock","price","status","created_at","updated_at");
            $ProductAttribute = $ProductAttribute->chunk(500, function($attributes) use($handle) {
                foreach ($attributes as $attribute){
                    fputcsv($handle, [
                        $attribute->id,
                        $attribute->product_id,
                        $attribute->sku,
                        $attribute->bar_code,
                        $attribute->size,
                        $attribute->stock,
                        $attribute->price,
                        $attribute->status,
                        $attribute->created_at,
                        $attribute->updated_at
                    ]);
                }
            });
            // Close the output stream
            fclose($handle);
        }, 200, $headers);

        return $response->send();
    }
    public function exportimageTable(Request $request){
        $headers = array(
            'Content-Type'        => 'text/csv',
            'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
            'Content-Disposition' => 'attachment; filename=product_images.csv',
            'Expires'             => '0',
            'Pragma'              => 'public',
        );
        $response = new StreamedResponse(function(){
            // Open output stream
            $handle = fopen('php://output', 'w');
            // Add CSV headers
            fputcsv($handle, ["id","product_id","image","image_sort","is_default","created_at","updated_at"]);
            $ProductImage  = ProductImage::select("id","product_id","image","image_sort","is_default","created_at","updated_at");
            $ProductImage = $ProductImage->chunk(500, function($images) use($handle) {
                foreach ($images as $image){
                    fputcsv($handle, [
                        $image->id,
                        $image->product_id,
                        $image->image,
                        $image->image_sort,
                        $image->is_default,
                        $image->created_at,
                        $image->updated_at
                    ]);
                }
            });
            // Close the output stream
            fclose($handle);
        }, 200, $headers);

        return $response->send();
    }
    public function exportproductTable(Request $request){
        $headers = array(
            'Content-Type'        => 'text/csv',
            'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
            'Content-Disposition' => 'attachment; filename=products.csv',
            'Expires'             => '0',
            'Pragma'              => 'public',
        );
        $response = new StreamedResponse(function(){
            // Open output stream
            $handle = fopen('php://output', 'w');
            // Add CSV headers
            fputcsv($handle, ["id","category_id","product_name","seo_url","product_code","short_description","product_description","fabric_description","size_description","care_description","current_discount","product_gst","product_price","product_discount","final_price","weight","group_code","color","product_dimension","color_name","productcolor","pattern","style","model_size","neck","sleeve","new_arrival","product_tag","best_seller","product_sort","barcode","hsn_code","related_cat","status","is_delete","created_at","updated_at"]);
            $Product  = Product::select("id","category_id","product_name","seo_url","product_code","short_description","product_description","fabric_description","size_description","care_description","current_discount","product_gst","product_price","product_discount","final_price","weight","group_code","color","product_dimension","color_name","productcolor","pattern","style","model_size","neck","sleeve","new_arrival","product_tag","best_seller","product_sort","barcode","hsn_code","related_cat","status","is_delete","created_at","updated_at");
            $Product = $Product->chunk(500, function($products) use($handle) {
                foreach ($products as $image){
                    fputcsv($handle, [
                        $image->id,
                        $image->category_id,
                        $image->product_name,
                        $image->seo_url,
                        $image->product_code,
                        $image->short_description,
                        $image->product_description,
                        $image->fabric_description,
                        $image->size_description,
                        $image->care_description,
                        $image->current_discount,
                        $image->product_gst,
                        $image->product_price,
                        $image->product_discount,
                        $image->final_price,
                        $image->weight,
                        $image->group_code,
                        $image->color,
                        $image->product_dimension,
                        $image->color_name,
                        $image->productcolor,
                        $image->pattern,
                        $image->style,
                        $image->model_size,
                        $image->neck,
                        $image->sleeve,
                        $image->new_arrival,
                        $image->product_tag,
                        $image->best_seller,
                        $image->product_sort,
                        $image->barcode,
                        $image->hsn_code,
                        $image->related_cat,
                        $image->status,
                        $image->is_delete,
                        $image->created_at,
                        $image->updated_at
                    ]);
                }
            });
            // Close the output stream
            fclose($handle);
        }, 200, $headers);

        return $response->send();
    }
}
