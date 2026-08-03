<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Str;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests;
use Illuminate\Support\Facades\Route;
use DB;
use App\BannerImage;
use Session;
use Image;
class BannerController extends Controller
{
    //
    public function bannerImages(Request $Request){
        Session::put('active','banners'); 
        if($Request->ajax()){
            $conditions = array();
            $data = $Request->input();
            $querys = DB::table('banner_images');
            $iDisplayLength = intval($_REQUEST['length']);
            $iDisplayStart = intval($_REQUEST['start']);
            $iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength; 
            $iTotalRecords = $querys->where($conditions)->count();
            $querys =  $querys->where($conditions)
                ->skip($iDisplayStart)->take($iDisplayLength)
                ->OrderBy('id','DESC')
                ->get();
            $sEcho = intval($_REQUEST['draw']);
            $records = array();
            $records["data"] = array(); 
            $end = $iDisplayStart + $iDisplayLength;
            $end = $end > $iTotalRecords ? $iTotalRecords : $end;
            $i=0;
            $querys=json_decode( json_encode($querys), true);
            foreach($querys as $image){
                $id= base64_encode(convert_uuencode($image['id'])); 
                $checked='';
                if($image['status']==1){
                    $checked='on';
                }
                else{
                    $checked='off';
                }
                $actionValues='<a title="Edit Banner Image" class="btn btn-sm green margin-top-10" href="'.url('admin/add-edit-banner-image/'.$image['id']).'"> <i class="fa fa-edit"></i></a> 
                    <a  title="Delete Banner Image"  class="btn btn-sm red margin-top-10 delete"  onclick="return ConfirmDelete()" href="'.url('admin/delete-banner-image/'.$image['id']).'"> <i class="fa fa-times"></i>
                    </a>';
                $num = ++$i;
                $records["data"][] = array(     
                $num,
                '<img style="width:250px;" src="'.url('images/BannerImages/'.$image['image']).'"/>',
                $image['type'],
                '<div  id="'.$image['id'].'" rel="banner_images" class="bootstrap-switch  bootstrap-switch-'.$checked.'  bootstrap-switch-wrapper bootstrap-switch-animate toogle_switch">
                <div class="bootstrap-switch-container" ><span class="bootstrap-switch-handle-on bootstrap-switch-primary">&nbsp;Active&nbsp;&nbsp;</span><label class="bootstrap-switch-label">&nbsp;</label><span class="bootstrap-switch-handle-off bootstrap-switch-default">&nbsp;Inactive&nbsp;</span></div></div>',  
                $actionValues
                );
            }
            $records["draw"] = $sEcho;
            $records["recordsTotal"] = $iTotalRecords;
            $records["recordsFiltered"] = $iTotalRecords;
            return response()->json($records);
        }
        $title = "Banner Images";
        return View::make('admin.banners.banners')->with(compact('title'));
    }

    public function addEditBannerImage(Request $request, $id=null){
        if($id ==""){
            $message = "Banner Image has been added successfully!";
            $banner = new BannerImage;
            $bannerdata = array();
            $title = "Add Banner Image";
        }else{
            $message = "Banner Image has been updated successfully!";
            $banner = BannerImage::find($id);
            $bannerdata = json_decode(json_encode($banner),true);
            $title = "Edit Banner Image";
        }
        if($request->isMethod('post')){
            $data = $request->all();
            $banner->type = $data['type'];
            $banner->description = $data['description'];
            $banner->link= $data['link'];
            $banner->sort= $data['sort'];
            $banner->status = 1;
            if($request->hasFile('image')){
                if ($request->file('image')->isValid()) {
                    $file = $request->file('image');
                    $img = Image::make($file);
                    $destination = public_path('/images/BannerImages/');
                    if(!empty($bannerdata) &&  $bannerdata['image'] !="" && file_exists($destination.$bannerdata['image'])){
                        unlink($destination.$bannerdata['image']);
                    }
                    $ext = $file->getClientOriginalExtension();
                    $bannerFilename = "banner-".Str::random(5).date('h-i-s').".".$ext;
                    $img->save($destination.$bannerFilename);
                    $banner->image= $bannerFilename;
                }
            }
            $banner->save();
            return redirect()->action('App\Http\Controllers\Admin\BannerController@bannerImages')->with('flash_message_success',$message);
        }
        return view('admin.banners.add-edit-banner')->with(compact('title','bannerdata'));

    }

    public function deleteBannerImage($id){
        $banner = BannerImage::find($id);
        $destination = public_path('/images/BannerImages/');
        if($banner->image !="" && file_exists($destination.$banner->image)){
            unlink($destination.$banner->image);
        }
        $banner->delete();
        return redirect()->action('App\Http\Controllers\Admin\BannerController@bannerImages')->with('flash_message_success','Record has been deleted successfully!');
    }
}
