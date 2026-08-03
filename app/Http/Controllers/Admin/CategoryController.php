<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Str;

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
use App\Category;
use App\Product;
use Image;
class CategoryController extends Controller
{
    //
    public function categories(Request $Request){
        Session::put('active','categories'); 
        if($Request->ajax()){
            $conditions = array();
            $data = $Request->input();
            $querys = DB::table('categories')->orderby('sort','asc');
            $name=""; 
            if(!empty($data['id'])){
                $querys = $querys->where('id',$data['id']);
            }
            if(!empty($data['parent_id'])){
                if($data['parent_id'] =="ROOT"){
                    $querys = $querys->where('parent_id',NULL);
                }else{
                    $querys = $querys->where('parent_id',$data['parent_id']);
                }
            }
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
            $i=$iDisplayStart;
            $querys=json_decode( json_encode($querys), true);
            foreach($querys as $category){
                $id= base64_encode(convert_uuencode($category['id'])); 
                $checked='';
                if($category['status']==1){
                    $checked='on';
                }
                else{
                    $checked='off';
                }
                $actionValues='
                    <a title="Edit" class="btn btn-sm green margin-top-10" href="'.url('/admin/add-edit-category/'.$category['id']).'"> <i class="fa fa-edit"></i>
                    </a>';
                if($category['parent_id'] == NULL){
                	$parentcategory = "ROOT";
                }else{
                	$parent_category = DB::table('categories')->where('id',$category['parent_id'])->select('name')->first();
                	$parentcategory = $parent_category->name;
                }
                $num = ++$i;
                $records["data"][] = array(      
                    $category['id'],
                    $category['name'],
                    $parentcategory,
                    $category['description'],
                    $category['category_discount'],
                    '<div  id="'.$category['id'].'" rel="categories" class="bootstrap-switch  bootstrap-switch-'.$checked.'  bootstrap-switch-wrapper bootstrap-switch-animate toogle_switch">
                    <div class="bootstrap-switch-container" ><span class="bootstrap-switch-handle-on bootstrap-switch-primary">&nbsp;Active&nbsp;&nbsp;</span><label class="bootstrap-switch-label">&nbsp;</label><span class="bootstrap-switch-handle-off bootstrap-switch-default">&nbsp;Inactive&nbsp;</span></div></div>',   
                    $actionValues
                );
                    if (isset($_REQUEST["customActionType"]) && $_REQUEST["customActionType"] == "group_action") {
                         $records["customActionStatus"] = "OK"; // pass custom message(useful for getting status of group actions)
                         $records["customActionMessage"] = "Group action successfully has been completed. Well done!"; // pass custom message(useful for getting status of group actions)
                    }
            }
            $records["draw"] = $sEcho;
            $records["recordsTotal"] = $iTotalRecords;
            $records["recordsFiltered"] = $iTotalRecords;
            return response()->json($records);
        }
        $getRootCategories = DB::table('categories')->where('parent_id','ROOT')->get();
        $getRootCategories = json_decode(json_encode($getRootCategories),true);
        $getAllCategories = DB::table('categories')->get();
        $getAllCategories = json_decode(json_encode($getAllCategories),true); 
        $title = "Categories";
        return View::make('admin.categories.categories')->with(compact('title','getAllCategories','getRootCategories'));
    }

    public function addEditCatgeory(Request $request,$id=null){
   		$getCategories = $this->getcategories();
   		if($id ==""){
   			$title="Add Category";
   			$category = new Category;
   			$message= "Category has been added successfully";
   			$categorydata = array();
   			$getselectedBrands = array();
   		}else{
   			$title="Edit Category";
			$category = Category::find($id);
   			$message= "Category has been updated successfully";
   			$categorydata = DB::table('categories')->where('id',$id)->first();
   			$categorydata = json_decode(json_encode($categorydata),true);
   			$catid = $categorydata['id'];
   		}
   		if($request->isMethod('post')){
   			$data = $request->all();
   			unset($data['_token']);
            if($data['parent_id'] =="ROOT"){
                unset($data['parent_id']);
                $data['parent_id'] = NULL;
            }else{
                $category->parent_id = $data['parent_id'];
            }
   			/*foreach ($data as $key => $value) {
   				$category->$key = trim($value);
   			}*/
            $category->name =  $data['name'];
            $category->sort =  $data['sort'];
            $category->description =  $data['description'];
            $category->category_discount =  $data['category_discount'];
            $category->meta_title =  $data['meta_title'];
            $category->meta_keyword =  $data['meta_keyword'];
            $category->meta_description =  $data['meta_description'];
           /* $category->sort =  $data['sort'];*/
            $category->seo_unique =  $data['seo_unique'];
            if(isset($data['filters'])){
                $category->filters =  implode(',', $data['filters']);
            }
   		//	$category->status = 1;
   			if($request->hasFile('image')){
	            if ($request->file('image')->isValid()) {
	                $file = $request->file('image');
	                $img = Image::make($file);
	                $destination = public_path('/images/CategoryImages/');
	                if(!empty($categorydata) &&  $categorydata['image'] !="" && file_exists($destination.$categorydata['image'])){
	                    unlink($destination.$categorydata['image']);
	                }
	                $ext = $file->getClientOriginalExtension();
	                $mainFilename = Str::slug($data['name'],'-').Str::random(5).date('h-i-s').".".$ext;
	                $img->save($destination.$mainFilename);
	                $category->image= $mainFilename;
	            }
	        }
            if($request->hasFile('size_chart')){
                if ($request->file('size_chart')->isValid()) {
                    $file = $request->file('size_chart');
                    $img = Image::make($file);
                    $destination = public_path('/images/SizeCharts/');
                    if(!empty($categorydata) &&  $categorydata['size_chart'] !="" && file_exists($destination.$categorydata['size_chart'])){
                        unlink($destination.$categorydata['size_chart']);
                    }
                    $ext = $file->getClientOriginalExtension();
                    $mainFilename = Str::slug($data['name'],'-').Str::random(5).date('h-i-s').".".$ext;
                    $img->save($destination.$mainFilename);
                    $category->size_chart= $mainFilename;
                }
            }
            if($request->hasFile('size_chart1')){
                if ($request->file('size_chart1')->isValid()) {
                    $file = $request->file('size_chart1');
                    $img = Image::make($file);
                    $destination = public_path('/images/SizeCharts/');
                    if(!empty($categorydata) &&  $categorydata['size_chart1'] !="" && file_exists($destination.$categorydata['size_chart1'])){
                        unlink($destination.$categorydata['size_chart1']);
                    }
                    $ext = $file->getClientOriginalExtension();
                    $mainFilename = Str::slug($data['name'],'-').Str::random(5).date('h-i-s').".".$ext;
                    $img->save($destination.$mainFilename);
                    $category->size_chart1= $mainFilename;
                }
            }            
            if($id != ""){
                if(!empty($data['category_discount'])){
                    $catpercentage = $data['category_discount'];
                    $currentDis = 'category';
                }else{
                     $currentDis = '';
                    $catpercentage = 0;
                }
                $catid = $id;
                Product::where('category_id',$catid)
                    ->update(array(
                        'current_discount' =>$currentDis,
                        'final_price' => DB::raw('product_price - (product_price * '.$catpercentage.' / 100.0)')
                    ));
            }
   			$category->save();
   			return redirect()->action('App\Http\Controllers\Admin\CategoryController@categories')->with('flash_message_success',$message);
   		}
   		return view('admin.categories.add-edit-category')->with(compact('title','categorydata','getCategories'));
   	}

   	public function CheckSeoUnique(Request $request){
        if($request->ajax()){
            $data = $request->all();
            $seounique = $data['seo_unique'];
            if(isset($data['catseo']) && !empty($data['catseo'])){
                $checkseounique= DB::table('categories')
                           ->where('seo_unique', $seounique)
                           ->where('seo_unique','!=',$data['catseo'])
                           ->count();
            }else{
                $checkseounique= DB::table('categories')
                           ->where('seo_unique', $seounique)
                           ->count();
            }
            if($checkseounique == 1) {
                 echo '{"valid":false}';die;
            }else {
                echo '{"valid":true}';die;
            }
        }
    }
	
	public function removeCategorySizechartImage(Request $request){
		if($request->ajax()){
			$data = $request->all();
			Category::where('id',$data['id'])->update(['size_chart'=>'']);
			echo 1;
		}
	}
}
