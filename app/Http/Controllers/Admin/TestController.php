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
	
	class TestController extends Controller
	{
		public function test_img_name(){ die(); exit;
		    
		    
			for ($product_id = 1; $product_id <= 1; $product_id++) {
				
				$images = ProductImage::where('product_id',$product_id)->get();
				
				if(!empty($images)){
				foreach($images as $img){
					$image_name = $img['image'];
					$img_explode = explode('.',$image_name);
					$ext = end($img_explode);
					$new_img_name = time().''.rand('99999999','10000000').'.'.$ext;
				/*	try{
						@rename('images/ProductImages/xlarge/'.$image_name, 'images/ProductImages/xlarge/'.$new_img_name);
						@rename('images/ProductImages/large/'.$image_name, 'images/ProductImages/large/'.$new_img_name);
						@rename('images/ProductImages/medium/'.$image_name, 'images/ProductImages/medium/'.$new_img_name);
						@rename('images/ProductImages/small/'.$image_name, 'images/ProductImages/small/'.$new_img_name);
						ProductImage::where('id', $img['id'])->update(['image' => $new_img_name ]);
					    echo "The number is: $product_id <br>";
					}
					catch(Exception $e) {
						echo 'error';
					} */
				}
				
				
				
			}
		}
	}
	}