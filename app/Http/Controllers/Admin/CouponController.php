<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Redirect;
use Session;
use DB;
use Illuminate\Support\Str;
use App\CouponCode;
use App\User;
use App\ProductAttribute;
class CouponController extends Controller
{
    //
    public function coupons(Request $Request){
		Session::put('active','coupons'); 
        if($Request->ajax()){
            $conditions = array();
            $data = $Request->input();
            $querys = DB::table('coupon_codes');
            if(!empty($data['code'])){
                $querys = $querys->where('code','like','%'.$data['code'].'%');
            }
            $iTotalRecords = $querys->where($conditions)->count();
            $iDisplayLength = intval($_REQUEST['length']);
            $iDisplayStart = intval($_REQUEST['start']);
            $iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength; 
            $querys =  $querys->where($conditions)
                		->skip($iDisplayStart)->take($iDisplayLength)
                		->OrderBy('id','DESC')
                		->get();
            $sEcho = intval($_REQUEST['draw']);
            $records = array();
            $records["data"] = array(); 
            $end = $iDisplayStart + $iDisplayLength;
            $end = $end > $iTotalRecords ? $iTotalRecords : $end;
            $i=$iDisplayStart;
            $querys=json_decode( json_encode($querys), true);
            foreach($querys as $coupon){
                $id= base64_encode(convert_uuencode($coupon['id'])); 
                $checked='';
                if($coupon['status']==1){
                    $checked='on';
                }
                else{
                    $checked='off';
                }
                $deletcoupon ='<a  title="Delete"  class="btn btn-sm red margin-top-10 delete" rel="'.$id.'"  onclick=" return ConfirmDelete()" href="'.url('admin/delete-coupon/'.$id).'"> <i class="fa fa-times"></i>
                    </a>'; 
                $actionValues='
                    <a title="Edit" class="btn btn-sm green margin-top-10" href="'.url('/admin/add-edit-coupon/'.$id).'"> <i class="fa fa-edit"></i>
                    </a>'.$deletcoupon;

                if($coupon['amount_type'] =="Percentage"){
                	$amount = $coupon['amount'] ." %";
                }else{
                	$amount = $coupon['amount'] ." Rs.";
                }
                $num = ++$i;
                $records["data"][] = array(      
                    $num,
                    $coupon['code'],
                    $coupon['coupon_type'],
                    $amount,
                    date('d-F-Y',strtotime($coupon['expiry_date'])),
                    '<div  id="'.$coupon['id'].'" rel="coupon_codes" class="bootstrap-switch  bootstrap-switch-'.$checked.'  bootstrap-switch-wrapper bootstrap-switch-animate toogle_switch">
                    <div class="bootstrap-switch-container" ><span class="bootstrap-switch-handle-on bootstrap-switch-primary">&nbsp;Active&nbsp;&nbsp;</span><label class="bootstrap-switch-label">&nbsp;</label><span class="bootstrap-switch-handle-off bootstrap-switch-default">&nbsp;Inactive&nbsp;</span></div></div>',   
                    $actionValues
                );
            }
            $records["draw"] = $sEcho;
            $records["recordsTotal"] = $iTotalRecords;
            $records["recordsFiltered"] = $iTotalRecords;
            return response()->json($records);
        }
        $title = "Coupons";
        return View::make('admin.coupons.coupons')->with(compact('title'));
    }

    public function addEditCoupon(Request $request, $id=null){
        Session::put('active',7); 
    	if($id !=""){
    		$couponId = convert_uudecode(base64_decode($id));
    		$couponData = DB::table('coupon_codes')->where('id',$couponId)->first();
    		$couponData = json_decode(json_encode($couponData),true);
            $Selcats = explode(',',$couponData['categories']);
    		$title = "Edit Coupon";
    		$coupon = CouponCode::find($couponId);
    		$message= "Coupon updated successfully!";
    	}else{
            $Selcats =array();
    		$couponData = array();
			$title = "Add Coupon";
			$coupon = new CouponCode;
			$message= "Coupon added successfully!";
    	}
    	if($request->isMethod('post')){
    		$data = $request->all();
    		unset($data['_token']);
            if(isset($data['user_emails'])){
                $coupon->user_emails = implode(',',$data['user_emails']);
            }else{
                $coupon->user_emails  = '';
            } 
            if(isset($data['product_sku']) && !empty($data['product_sku']) ){
               
               $data['product_sku'] = array_filter($data['product_sku']);
			   if(!empty($data['product_sku'])){
					$coupon->product_sku = implode(',',$data['product_sku']);
               }else{
				   $coupon->product_sku = '';
			   }
			}else{
                $coupon->product_sku  = '';
            }
            $coupon->coupon_type = $data['coupon_type'];
            if(isset($data['codeoption'])){
                $coupon->codeoption = $data['codeoption'];
            }
            $coupon->type = $data['type'];
            $coupon->amount_type = $data['amount_type'];
            $coupon->min_qty = $data['min_qty'];
            $coupon->remarks = $data['remarks'];
            $coupon->max_qty = $data['max_qty'];
            $coupon->min_amount = $data['min_amount'];
            $coupon->max_amount = $data['max_amount'];
            $coupon->expiry_date = $data['expiry_date'];
            $coupon->start_date = $data['start_date'];
            //$coupon->coupon_usage = $data['coupon_usage'];
            $coupon->amount = $data['amount'];
            $coupon->terms_and_conditions = $data['terms_and_conditions'];
            if(isset($data['categories'])){
                $coupon->categories = implode(',',$data['categories']);
            }else{
                 $coupon->categories ="";
            }
    		if(empty($couponData)){
    			if($data['codeoption'] =="Manual"){
    				if($data['code']==""){
    					$code = Str::random(6);
	                	$checkCode = DB::table('coupon_codes')->where(['code'=>$code])->count();
		                while($checkCode>0){
		                   	$code = Str::random(6);
		                    $checkCode = DB::table('coupon_codes')->where(['code'=>$code])->count();
		                }
	                	$coupon->code = strtolower($code);
    				} else{
    					$coupon->code = strtolower($data['code']);
    				}
	    		}else{
					$code = Str::random(6);
	                $checkCode = DB::table('coupon_codes')->where(['code'=>$code])->count();
	                while($checkCode>0)
	                {
	                    $code = Str::random(6);
	                    $checkCode = DB::table('coupon_codes')->where(['code'=>$code])->count();
	                }
	                $coupon->code = strtolower($code);
	    		}
    		}
			
			
			
			
			if(isset($data['coupon_for_new_user'])){
                $coupon->coupon_for_new_user = '1';
            }else{
                $coupon->coupon_for_new_user = '0';
            }
			
    		if(isset($data['status'])){
                $coupon->status = 1;
            }else{
                $coupon->status = 0;
            }
            if(isset($data['visible'])){
                $coupon->visible = 1;
            }else{
                $coupon->visible = 0;
            }
    		$coupon->save();
    		    //	echo "<pre>"; print_r($coupon); exit;
    		return redirect()->action('App\Http\Controllers\Admin\CouponController@coupons')->with('flash_message_success',$message);
    	}
        $getCategories = $this->getcategories();
        $users = User::select('id','email','name')->where('status',1)->get();
        $getattributes = ProductAttribute::where('status',1)->get();
    	return view('admin.coupons.add-edit-coupon')->with(compact('title','couponData','getCategories','users','Selcats','getattributes'));
    }

    public function checkCouponCode(Request $request){
    	if($request->ajax()){
    		$data = $request->all();
    		$getcount = DB::table('coupon_codes')->where('code',$data['code'])->count();
    		if($getcount == 0){
    			echo '{"valid":true}';die;
    		}else{
    			echo '{"valid":false}';die;
    		}
    	}
    }

    public function deleteCouponCode($id){
    	$CouponId = convert_uudecode(base64_decode($id));
    	DB::table('coupon_codes')->where('id',$CouponId)->delete();
    	return redirect()->action('App\Http\Controllers\Admin\CouponController@coupons')->with('flash_message_success','Coupon has been deleted successfully!');
    }
}
