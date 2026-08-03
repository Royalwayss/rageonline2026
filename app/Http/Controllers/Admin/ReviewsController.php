<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests;
use App\Admin;
use App\ProductReview;
use Auth;
use DB;
use Session;
class ReviewsController extends Controller
{
  
	
	public function productreviews(Request $Request){
        Session::put('active','product_reviews'); 
        if($Request->ajax()){
            $conditions = array();
            $data = $Request->input();
            $querys = ProductReview::with('product_details');
            if(!empty($data['email'])){
                $querys = $querys->where('email','like','%'.$data['email'].'%');
            }
            if(!empty($data['notifysize'])){
                $querys = $querys->where('notifysize','like','%'.$data['notifysize'].'%');
            }
            if(!empty($data['notifycode'])){
                $querys = $querys->where('notifycode','like','%'.$data['notifycode'].'%');
            }  
            if(!empty($data['mobile'])){
                $querys = $querys->where('mobile','like','%'.$data['mobile'].'%');
            }                  
            $iTotalRecords = $querys->where($conditions)->count();
            $iDisplayLength = intval($_REQUEST['length']);
            $iDisplayStart = intval($_REQUEST['start']);
            $iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength; 
            $querys =  $querys->where($conditions)
                ->skip($iDisplayStart)->take($iDisplayLength)
                ->OrderBy('product_reviews.id','DESC')
                ->get();  
            $sEcho = intval($_REQUEST['draw']);
            $records = array();
            $records["data"] = array(); 
            $end = $iDisplayStart + $iDisplayLength;
            $end = $end > $iTotalRecords ? $iTotalRecords : $end;
            $i=$iDisplayStart;
            $querys=json_decode( json_encode($querys), true);
            foreach($querys as $row){
                
				
			    $image = '';
				if($row['images'] != ''){
					$images = explode(',',$row['images']);
					$image = '<img style="width:50px" src="'.asset('images/ProductImages/review/'.$images[0]).'">';
					$image .= '<br><a href="javascript:;" class="review-images" data-images="'.$row['images'].'" >View</a>';
				}
				
				if($row['status']==1){
                    $checked='on';
                }
                else{
                    $checked='off';
                }
				
				
				 $status = '<div  id="'.$row['id'].'" rel="product_reviews" class="bootstrap-switch  bootstrap-switch-'.$checked.'  bootstrap-switch-wrapper bootstrap-switch-animate toogle_switch">
                    <div class="bootstrap-switch-container" ><span class="bootstrap-switch-handle-on bootstrap-switch-primary">&nbsp;Active&nbsp;&nbsp;</span><label class="bootstrap-switch-label">&nbsp;</label><span class="bootstrap-switch-handle-off bootstrap-switch-default">&nbsp;Inactive&nbsp;</span></div></div>';   
				$product_name = '';
				if(!empty($row['product_details'])){
					$product_name = '<a href="'.url('product/'.$row['product_details']['seo_url']).'">'.$row['product_details']['product_name'].'</a>';
				}
				
				$actionValues='';
                $records["data"][] = array(  
                     
                    $row['display_name'].'<br>'. $row['email'], 
                    $product_name,
                    '<strong>Title</strong> -' .$row['review_title'].'<br> <strong>Message</strong> - '.$row['review_content'].'<br> <strong>Rating</strong>: '.$row['rating'].'<br>'. $image, 
                    $status,  
                    $row['created_at'],
                    $actionValues
                );
            }
            $records["draw"] = $sEcho;
            $records["recordsTotal"] = $iTotalRecords;
            $records["recordsFiltered"] = $iTotalRecords;
            return response()->json($records);
        }
        $title = "Product Reviews";
        return View::make('admin.reviews.product-reviews')->with(compact('title'));
    }  
   

	
}
