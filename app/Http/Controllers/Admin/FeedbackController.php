<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests;
use Illuminate\Support\Facades\Route;
use App\Feedback;
use DB;
use Cookie;
use Session;
use Crypt;
use Illuminate\Support\Facades\Mail;
class FeedbackController extends Controller
{
    //
     public function index(Request $Request){
        Session::put('active','feedback'); 
        if($Request->ajax()){
            $conditions = array();
            $data = $Request->input();
            $querys = DB::table('feedback');
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
               
               
                $actionValues='';
                $num = ++$i;
                $records["data"][] = array(     
                    $num,
                    $row['name'],
                    $row['email'],
                    $row['mobile'],
                    $row['message'],
                    $row['created_at'],
                    $actionValues
                );
            }
            $records["draw"] = $sEcho;
            $records["recordsTotal"] = $iTotalRecords;
            $records["recordsFiltered"] = $iTotalRecords;
            return response()->json($records);
        }
        $title = "Feedback";
        return View::make('admin.feedback.list')->with(compact('title'));
    }

   
}
