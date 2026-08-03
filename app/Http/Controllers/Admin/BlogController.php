<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Str;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests;
use DB;
use Cookie;
use Session;
use Crypt;
use Illuminate\Support\Facades\Mail;
use PDF;
use Image;
use App\Blog;
class BlogController extends Controller
{
    //
     public function blogs(Request $Request){
        Session::put('active','blogs'); 
        if($Request->ajax()){
            $conditions = array();
            $data = $Request->input();
            $querys = DB::table('blogs');
            if(!empty($data['cat_name'])){
                $querys = $querys->where('categories.name','like','%'.$data['cat_name'].'%');
            }
            $iDisplayLength = intval($_REQUEST['length']);
            $iDisplayStart = intval($_REQUEST['start']);
            $iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength; 
            $iTotalRecords = $querys->where($conditions)->count();
            $querys =  $querys->where($conditions)
                		->skip($iDisplayStart)->take($iDisplayLength)
                		->OrderBy('blogs.id','DESC')
                		->get();
            $sEcho = intval($_REQUEST['draw']);
            $records = array();
            $records["data"] = array(); 
            $end = $iDisplayStart + $iDisplayLength;
            $end = $end > $iTotalRecords ? $iTotalRecords : $end;
            $i=$iDisplayStart;
            $querys=json_decode( json_encode($querys), true);
            foreach($querys as $blog){
                $checked='';
                if($blog['status']==1){
                    $checked='on';
                }
                else{
                    $checked='off';
                }
                $actionValues='
                    <a target="_blank" title="Edit" class="btn btn-sm green margin-top-10" href="'.url('/admin/add-edit-blog/'.$blog['id']).'"> <i class="fa fa-edit"></i>
                    </a>';
                $num = ++$i;
                $records["data"][] = array(      
                    $num,
                    $blog['title'],
                    '<img width="190px" src="'.asset('images/BlogImages/'.$blog['image']).'"/>',
                    date('d M Y',strtotime($blog['date'])),
                    '<div  id="'.$blog['id'].'" rel="products" class="bootstrap-switch  bootstrap-switch-'.$checked.'  bootstrap-switch-wrapper bootstrap-switch-animate toogle_switch">
                    <div class="bootstrap-switch-container" ><span class="bootstrap-switch-handle-on bootstrap-switch-primary">&nbsp;Active&nbsp;&nbsp;</span><label class="bootstrap-switch-label">&nbsp;</label><span class="bootstrap-switch-handle-off bootstrap-switch-default">&nbsp;Inactive&nbsp;</span></div></div>',   
                    $actionValues
                );
            }
            $records["draw"] = $sEcho;
            $records["recordsTotal"] = $iTotalRecords;
            $records["recordsFiltered"] = $iTotalRecords;
            return response()->json($records);
        }
        $title = "Blogs";
        return View::make('admin.blogs.blogs')->with(compact('title'));
    }

    public function addEditBlog(Request $request,$id=null){
    	if($id==""){
    		$title="Add Blog";
    		$message="Blog has been added successfully";
    		$blog = new Blog;
    		$blogdata = array();
    	}else{
    		$title="Edit Blog";
    		$message="Blog has been updated successfully";
    		$blog = Blog::find($id);
    		$blogdata = json_decode(json_encode($blog),true);
    		$blogid = $blogdata['id'];
    	}
    	if($request->isMethod('post')){
    		$data = $request->all();
    		unset($data['_token']);
            $blog->title = $data['title'];
    		$blog->description = $data['description'];
    		$blog->date = $data['date'];
            $blog->status = 1;
    		if($request->hasFile('image')){
	            if ($request->file('image')->isValid()) {
	                $file = $request->file('image');
	                $img = Image::make($file);
	                $destination = public_path('/images/BlogImages/');
	                if(!empty($blogdata) &&  $blogdata['image'] !="" && file_exists($destination.$blogdata['image'])){
	                    unlink($destination.$blogdata['image']);
	                }
	                $ext = $file->getClientOriginalExtension();
	                $mainFilename = Str::slug($data['title'],'-').time().".".$ext;
	                $img->save($destination.$mainFilename);
	                $blog->image= $mainFilename;
	            }
	        }
	        $blog->save();
            return redirect()->action('App\Http\Controllers\Admin\BlogController@blogs')->with('flash_message_success',$message);
    	}
    	return view('admin.blogs.add-edit-blog')->with(compact('title','blogdata'));
    }
}
