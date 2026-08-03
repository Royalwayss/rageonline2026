<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests;
use Illuminate\Support\Facades\Route;
use App\FranchiseEnquiry;
use DB;
use Cookie;
use Session;
use Crypt;
use Illuminate\Support\Facades\Mail;
class FranchiseenquiryController extends Controller
{
    //
     public function index(Request $Request){
        Session::put('active','franchiseenquiry'); 
        if($Request->ajax()){
            $conditions = array();
            $data = $Request->input();
            $querys = DB::table('franchise_enquiries');
            if(!empty($data['name_of_party'])){
                $querys = $querys->where('name_of_party','like','%'.$data['name_of_party'].'%');
            }
            if(!empty($data['address_of_party'])){
                $querys = $querys->where('address_of_party','like','%'.$data['address_of_party'].'%');
            }
			
            if(!empty($data['city_of_party'])){
                $querys = $querys->where('city_of_party','like','%'.$data['city_of_party'].'%');
            }
			
			 if(!empty($data['phone'])){
					 $querys = $querys->orWhere('phone_of_party','like','%'.$data['phone'].'%');
					 $querys = $querys->orWhere('showroom_phone','like','%'.$data['phone'].'%');
					 $querys = $querys->orWhere('phone','like','%'.$data['phone'].'%');
					 $querys = $querys->orWhere('mobile','like','%'.$data['phone'].'%');
           
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
               
               
             $actionValues=' <button title="View Details" class="btn btn-sm blue view-modal" id='.$row['id'].' data-toggle="modal" data-target="#View"><i class="fa fa-file"></i></button>';
               
			   $num = ++$i;
                $records["data"][] = array(     
                    $num,
                    $row['name_of_party'],
                    $row['address_of_party'],
                    $row['city_of_party'],
                    $row['phone_of_party'],
                    $row['showroom_phone'],
                    $row['phone'],
                    $row['mobile'],
                    $row['created_at'],
                    $actionValues
                );
            }
            $records["draw"] = $sEcho;
            $records["recordsTotal"] = $iTotalRecords;
            $records["recordsFiltered"] = $iTotalRecords;
            return response()->json($records);
        }
        $title = "Franchise Enquiry";
        return View::make('admin.franchiseenquiry.list')->with(compact('title'));
    }
   
    public function franchiseEnquiryDetails($id){
      $data = FranchiseEnquiry::where('id',$id)->first();
       return view('admin.franchiseenquiry.popup.details-view')->with(compact('data'));
    }
     
   
}
