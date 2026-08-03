<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests;
use Illuminate\Support\Facades\Route;
use App\User;
use App\State;
use DB;
use Cookie;
use Session;
use Crypt;
use Illuminate\Support\Facades\Mail;
class UsersController extends Controller
{
    //
     public function users(Request $Request){
        Session::put('active','users'); 
        if($Request->ajax()){
            $conditions = array();
            $data = $Request->input();
            $querys = DB::table('users');
            if(!empty($data['name'])){
                $querys = $querys->where('name','like','%'.$data['name'].'%');
            }
            if(!empty($data['last_name'])){
                $querys = $querys->where('last_name','like','%'.$data['last_name'].'%');
            }
            if(!empty($data['email'])){
                $querys = $querys->where('email','like','%'.$data['email'].'%');
            }
			if(!empty($data['from_date'])){
                $querys = $querys->whereDate('users.created_at', '>=',$data['from_date']);
            }
            if(!empty($data['to_date'])){
                $querys = $querys->whereDate('users.created_at', '<=',$data['to_date']);
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
            foreach($querys as $user){
                $id= base64_encode(convert_uuencode($user['id'])); 
                $checked='';
                if($user['status']==1){
                    $checked='on';
                }else{
                    $checked='off';
                }
                $actionValues='
                    <a title="Edit User" class="btn btn-sm green margin-top-10" href="'.url('admin/add-edit-user/'.$user['id']).'"> <i class="fa fa-edit"></i>
                    </a>';
                $num = ++$i;
                $records["data"][] = array(     
                    $num,
                    $user['name'],
                    $user['email'],
                    $user['mobile'],
					date('d M Y h:i:a',strtotime($user['created_at'])), 
                    '<div  id='.$user['id'].' rel=users class="bootstrap-switch  bootstrap-switch-'.$checked.'  bootstrap-switch-wrapper bootstrap-switch-animate toogle_switch">
                    <div class="bootstrap-switch-container" ><span class="bootstrap-switch-handle-on bootstrap-switch-primary">&nbsp;Active&nbsp;&nbsp;</span><label class="bootstrap-switch-label">&nbsp;</label><span class="bootstrap-switch-handle-off bootstrap-switch-default">&nbsp;Inactive&nbsp;</span></div></div>',   
                    $actionValues
                );
            }
            $records["draw"] = $sEcho;
            $records["recordsTotal"] = $iTotalRecords;
            $records["recordsFiltered"] = $iTotalRecords;
            return response()->json($records);
        }
        $title = "Users";
        return View::make('admin.users.users')->with(compact('title'));
    }

    public function addEditUser(Request $request,$id=null){
    	if($id==""){
    		$title = "Add User";
    		$message = "User has been added successfully!";
    		$userdata = array();
    		
    		$user = new User;
    	}else{
    		$title = "Edit User";
    		$message = "User has been updated successfully!";
    		$user = User::find($id);
			
    		$userdata = json_decode(json_encode($user),true);
    	}
		$states = State::orderby('name','ASC')->pluck('name')->toArray();
        if($request->isMethod('post')){
            $data = $request->all();
            unset($data['_token']);
            $user->name = $data['name'];
            
            if(isset($data['email'])){
                $user->email = $data['email'];
            }
            $user->gender = $data['gender'];
            $user->mobile = $data['mobile'];
            $user->country = $data['country'];
            $user->state = $data['state'];
            $user->city = $data['city'];
            $user->address = $data['address'];
            $user->address2 = $data['address2'];
            $user->dob = $data['dob'];
            $user->postcode = $data['postcode'];
            if(isset($data['password'])){
                $user->password = bcrypt($data['password']);
            }
            $user->status = 1;
            $user->save();
            return Redirect()->action('App\Http\Controllers\Admin\UsersController@users')->with('flash_message_success',$message);
        }
    	return view('admin.users.add-edit-user')->with(compact('title','userdata','states'));
    }

    public function CheckUserEmail(Request $request){
        $data = $request->all();
        $userEmail = $data['email'];
        $count = DB::table('users')
                       ->where('email', $userEmail)
                       ->count();
        if($count == 1) {
             echo '{"valid":false}';die;;
        }else {
            echo '{"valid":true}';die;
        }
    }

    public function getStates(Request $request){
        if($request->ajax()){
            $data = $request->all();
            $getstates = DB::table('states')->where('country_id',$data['countryid'])->get();
            $getstates = json_decode(json_encode($getstates),true);
            $states = '<option value="">Select</option>';
            foreach($getstates as $key => $state){
                $states .= '<option value="'.$state['id'].'">'.$state['name'].'</option>';
            }
            print_r($states);
        }
    }

    public function getCities(Request $request){
        if($request->ajax()){
            $data = $request->all();
            $getcities = DB::table('cities')->where('state_id',$data['stateid'])->get();
            $getcities = json_decode(json_encode($getcities),true);
            $cities = '<option value="">Select</option>';
            foreach($getcities as $key => $city){
                $cities .= '<option value="'.$city['id'].'">'.$city['name'].'</option>';
            }
            print_r($cities);
        }
    }
}
