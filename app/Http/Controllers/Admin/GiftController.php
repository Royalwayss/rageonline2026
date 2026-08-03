<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests;
use Illuminate\Support\Facades\Route;
use App\GiftOffer;
use DB;
use Image;
use Cookie;
use Session;
use Crypt;
use Illuminate\Support\Facades\Mail;

class GiftController extends Controller
{
    //
    public function gifts(Request $Request){
        Session::put('active','gifts'); 
        if($Request->ajax()){
            $conditions = array();
            $data = $Request->input();
            $querys = DB::table('gift_offers');
            if(!empty($data['gift_name'])){
                $querys = $querys->where('gift_name','like','%'.$data['gift_name'].'%');
            }
            $iDisplayLength = intval($_REQUEST['length']);
            $iDisplayStart = intval($_REQUEST['start']);
            $iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength; 
            $iTotalRecords = $querys->where($conditions)->count();
            $querys =  $querys->where($conditions)
                	->skip($iDisplayStart)->take($iDisplayLength)
                	->OrderBy('gift_offers.id','Desc')
                	->get();
            $sEcho = intval($_REQUEST['draw']);
            $records = array();
            $records["data"] = array(); 
            $end = $iDisplayStart + $iDisplayLength;
            $end = $end > $iTotalRecords ? $iTotalRecords : $end;
            $i=$iDisplayStart;
            $querys=json_decode( json_encode($querys), true);
            foreach($querys as $gift){ 
                $checked='';
                if($gift['status']==1){
                    $checked='on';
                }else{
                    $checked='off';
                }
                $actionValues='
                    <a title="Edit Gift Offer" class="btn btn-sm green margin-top-10" href="'.url('admin/add-edit-gift/'.$gift['id']).'"> <i class="fa fa-edit"></i>
                    </a>';
                $num = ++$i;
                $records["data"][] = array(     
                    $num,
                    $gift['gift_name'],
                    "Rs.". $gift['mrp'],
                    $gift['bar_code'],
                    "Rs. ".$gift['shopping_amount_from'],
                    '<div  id='.$gift['id'].' rel=gift_offers class="bootstrap-switch  bootstrap-switch-'.$checked.'  bootstrap-switch-wrapper bootstrap-switch-animate toogle_switch">
                    <div class="bootstrap-switch-container" ><span class="bootstrap-switch-handle-on bootstrap-switch-primary">&nbsp;Active&nbsp;&nbsp;</span><label class="bootstrap-switch-label">&nbsp;</label><span class="bootstrap-switch-handle-off bootstrap-switch-default">&nbsp;Inactive&nbsp;</span></div></div>',   
                    $actionValues
                );
            }
            $records["draw"] = $sEcho;
            $records["recordsTotal"] = $iTotalRecords;
            $records["recordsFiltered"] = $iTotalRecords;
            return response()->json($records);
        }
        $title = "Gift Offer";
        return View::make('admin.gifts.gifts')->with(compact('title'));
    }

    public function addEditgift(Request $request,$id=null){
    	if($id==""){
    		$title = "Add Gift";
    		$message = "Gift has been added successfully!";
    		$giftdata = array();
    		$gift = new GiftOffer;
    	}else{
    		$title = "Edit Gift";
    		$message = "Gift has been updated successfully!";
    		$gift = GiftOffer::find($id);
    		$giftdata = json_decode(json_encode($gift),true);
    	}
        if($request->isMethod('post')){
            $data = $request->all();
            unset($data['_token']);
            $gift->gift_name = $data['gift_name'];
            $gift->invoice_gift_name = $data['invoice_gift_name'];
            $gift->mrp = $data['mrp'];
            $gift->gift_terms = $data['gift_terms'];
            $gift->bar_code = $data['bar_code'];
            $gift->shopping_amount_from = $data['shopping_amount_from'];
            $gift->stock = $data['stock'];
            $gift->status = 1;
            if($request->hasFile('gift_image')){
                if ($request->file('gift_image')->isValid()) {
                    $file = $request->file('gift_image');
                    $img = Image::make($file);
                    $destination = public_path('/images/GiftImages/');
                    if(!empty($giftdata) &&  $giftdata['gift_image'] !="" && file_exists($destination.$giftdata['gift_image'])){
                        unlink($destination.$giftdata['gift_image']);
                    }
                    $ext = $file->getClientOriginalExtension();
                    $mainFilename = "gift-".time().".".$ext;
                    $img->save($destination.$mainFilename);
                    $gift->gift_image= $mainFilename;
                }
            }
            $gift->save();
            return Redirect()->action('App\Http\Controllers\Admin\GiftController@gifts')->with('flash_message_success',$message);
        }
    	return view('admin.gifts.add-edit-gift')->with(compact('title','giftdata'));
    }
}
