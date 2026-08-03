<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests;
use Illuminate\Support\Facades\Route;
use App\Contact;
use DB;
use Cookie;
use Session;
use Crypt;
use Illuminate\Support\Facades\Mail;
class ContactController extends Controller
{
    //
     public function index(Request $Request){
        Session::put('active','contact'); 
        if($Request->ajax()){
            $conditions = array();
            $data = $Request->input();
            $querys = DB::table('contacts');
            if(!empty($data['name'])){
                $querys = $querys->where('name','like','%'.$data['name'].'%');
            }
            if(!empty($data['mobile'])){
                $querys = $querys->where('mobile','like','%'.$data['mobile'].'%');
            }
			
            if(!empty($data['email'])){
                $querys = $querys->where('email','like','%'.$data['email'].'%');
            }
            $iDisplayLength = intval($_REQUEST['length']);
            $iDisplayStart = intval($_REQUEST['start']);
            $iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength; 
            $iTotalRecords = $querys->where($conditions)->count();
            $querys =  $querys->where($conditions)
                	->skip($iDisplayStart)->take($iDisplayLength)
                	->OrderBy('id','Desc')
                	->get();
            $sEcho = intval($_REQUEST['draw']);
            $records = array();
            $records["data"] = array(); 
            $end = $iDisplayStart + $iDisplayLength;
            $end = $end > $iTotalRecords ? $iTotalRecords : $end;
            $i=$iDisplayStart;
            $querys=json_decode( json_encode($querys), true);
            foreach($querys as $row){
                $id= base64_encode(convert_uuencode($row['id'])); 
               
               
                $actionValues ='<a  href="'.url('admin/view-contact/'.$row['id']).'" title="View Contact" class="btn btn-sm green"><i class="fa fa-eye"></i></a>';
                $num = ++$i;
                $records["data"][] = array(     
                    $num,
                    $row['name'],
                    $row['email'],
                    $row['country_code'].' '.$row['mobile'],
                    date('d M Y h:i:a',strtotime($row['created_at'])),
                    $actionValues
                );
            }
            $records["draw"] = $sEcho;
            $records["recordsTotal"] = $iTotalRecords;
            $records["recordsFiltered"] = $iTotalRecords;
            return response()->json($records);
        }
        $title = "Contact";
        return View::make('admin.contact.list')->with(compact('title'));
    }

     public function view_contact(Request $Request,$id){
		$title = "View Contact";
		$row = Contact::where('id',$id)->firstorFail();
        return View::make('admin.contact.view')->with(compact('title','row'));
	 }
      
   
}
