<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests;
use App\Admin;
use Auth;
use Cookie;
use Session;
use Crypt;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Image;
use App\Product;
use App\ProductAttribute;
use App\OrderProduct;
use App\ReturnRequest;
use App\Notifies;
use App\User;
use App\ProductImage;
use App\Module;
use App\AdminRole;
use Hash;
use App\Event;
use App\EventDetail;
use App\Dealership;
use App\Headertext;
use App\Store;
use App\Neck;
use App\Pattern;
use App\Fabric;
use App\Sleeve;
use App\CmsPage;
use App\Productcolor;
use App\State;
use App\WebSetting;
use App\FaqPageContent;
use App\Order;
use App\Cron;
use sngrl\SphinxSearch\SphinxSearch;
class AdminController extends Controller
{
    //
    public function status(Request $request){
        if(Auth::guard('admin')->check()){
        	if($request->ajax()){
                $data = $request->input();
                if(DB::table($data['table'])->where('id', $data['id'])->update(['status' => $data['status'] ]) ){
                    echo "1";die;
                } else {
                    echo "0";die; 
                }
            }
        }
    }

    public function login(Request $request){
    	if(isset($_GET['testttt'])){
		 Cron::stock_alert_mail(); exit;
		}
		if(Auth::guard('admin')->check()){
    		return redirect('admin/dashboard');
    	}
    	if($request->isMethod('post')){
    		$data = $request->all(); 
    		$rules = [
                'email' => 'bail|required|email|regex:/^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i|max:255',
                'password' => 'bail|required',
            ];
            $customMessages = [
            	//Add custom Messages here
            ];
            $this->validate($request, $rules, $customMessages);
    		if(Auth::guard('admin')->attempt($request->only('email','password'))) {
    			if(Auth::guard('admin')->user()->status ==0){
    				Auth::guard('admin')->logout();
		    		return redirect()->back()->with('flash_message_error','Account deactivated');
    			}else{
					
					
					if(isset($data['stock_id']) && !empty($data['stock_id'])){
					   return redirect()->route('add_edit_product', [$data['stock_id']])->with('flash_message_success','Logged in successfully');
					}else{
			           return redirect('admin/dashboard')->with('flash_message_success','Logged in successfully');
					}
					
    			}
		    }else{
		    	return redirect()->back()->with('flash_message_error','Invalid email or password');
		    }
    	}
    	return view('admin.admin_login');
    }



    public function update_stock(Request $request,$id) {
		if(Auth::guard('admin')->check()){
    		return redirect('admin/add-edit-product/'.$id);
    	}else{
			return redirect()->route('admin_login', ['stock_id' => $id]);
		}
	}
	
	
    public function checkAdminEmail(Request $request) {
        $data = $request->all();
        $email = $data['email'];
        $count = DB::table('admins')
                       ->where('email', $email)
                       ->count();
        if($count == 1) {
            echo '{"valid":true}';die;
        } else {
            echo '{"valid":false}';die;;
        }
    }

    public function dashboard(){
		Session::put('active',1);
        if(Auth::guard('admin')->user()->type =="admin"){
            $getModules = DB::table('modules')->where('status',1)->where('table_name','!=','')->select('id','name','view_route','table_name','icon')->orderBy('sortorder','ASc')->get();
        }else{
            $getsubadminmodules = DB::table('admin_roles')->where(['admin_id'=>Auth::guard('admin')->user()->id,'view_access'=>'1'])->select('module_id')->get();
            $getsubadminmodules = array_flatten(json_decode(json_encode($getsubadminmodules),true));
            $getModules = DB::table('modules')->where('status',1)->whereIn('id',$getsubadminmodules)->where('table_name','!=','')->select('id','name','view_route','table_name','icon')->orderBy('sortorder','ASc')->get();
        }
        $getModules = json_decode(json_encode($getModules),true);
        foreach ($getModules as $key => $module) {
            if($module['table_name']=="admins"){
                $getModules[$key]['table_count'] = DB::table('admins')->where('type','!=','admin')->count();
            }if($module['table_name']=="products"){
                $getModules[$key]['table_count'] = DB::table('products')->where('is_delete','no')->count();
            }else{
                $getModules[$key]['table_count'] = DB::table($module['table_name'])->count();
            }
        }
        $title = "Dashboard";
        return view('admin.admin_dashboard')->with(compact('title','getModules'));
    }
    
	 public function dashboard_reports(Request $request){
		 $form_data = $request->all(); 
		
		 $section =  $form_data['section'];
		
		
		if($section == 'analytics'){
			$from_date = $form_data['from_date'];
			$to_date =$form_data['to_date'];
			$set_filter_session = ['from_date'=>$from_date,'to_date'=>$to_date]; 
			Session::put('analytics',$set_filter_session);			
			
			$data = [];
			
			
			$sales = DB::table('orders')
			->selectRaw('SUM(grand_total) as total_sales');
			
			if(!empty($form_data['from_date'])){
                $sales = $sales->whereDate('orders.created_at', '>=',$form_data['from_date']);
            }
            if(!empty($form_data['to_date'])){
                $sales = $sales->whereDate('orders.created_at', '<=',$form_data['to_date']);
            }
			
			$sales = $sales->where('orders.is_delete','no')
            ->where('orders.order_status','!=','Cancelled')
            ->where('orders.order_status','!=','Abandoned')
            ->where('orders.order_status','!=','Cancelled by User')
			->get();
						
			$sales=json_decode( json_encode($sales), true);
			
			$total_sales =0;
			
			if(!empty($sales) && isset($sales[0]['total_sales'])){
				$total_sales = $sales[0]['total_sales'];
			}
			
			$section_data['total_sales'] = $total_sales;
			
			
			$users = new User;
            if(!empty($form_data['from_date'])){
                $users = $users->whereDate('created_at', '>=',$form_data['from_date']);
            }
            if(!empty($form_data['to_date'])){
                $users = $users->whereDate('created_at', '<=',$form_data['to_date']);
            }
			
			$users  = $users->count();
			$section_data['total_users'] = $users;
			
			
			
			
			$return_requests = new ReturnRequest;
            if(!empty($form_data['from_date'])){
                $return_requests = $return_requests->whereDate('created_at', '>=',$form_data['from_date']);
            }
            if(!empty($form_data['to_date'])){
                $return_requests = $return_requests->whereDate('created_at', '<=',$form_data['to_date']);
            }
			
			$return_requests  = $return_requests->count();
			$section_data['total_return_requests'] = $return_requests; 
			
			
			
			$total_notify = new Notifies;
            if(!empty($form_data['from_date'])){
                $total_notify = $total_notify->whereDate('created_at', '>=',$form_data['from_date']);
            }
            if(!empty($form_data['to_date'])){
                $total_notify = $total_notify->whereDate('created_at', '<=',$form_data['to_date']);
            }
			$total_notify  = $total_notify->count();
			$section_data['total_notify'] = $total_notify;
			
			
			$html = (String)view::make('admin.dashboard-reports.analytics')->with(compact('section_data'));
		}
		
		
		
		
		if($section == 'day_wise_sale'){
			$filterMonth = $form_data['month'];
			$filterYear =$form_data['year'];
			$payment_method =$form_data['payment_method'];
			$chart_type =$form_data['chart_type'];
			
			$set_filter_session = ['month'=>$filterMonth,'year'=>$filterYear,'payment_method'=>$payment_method,'chart_type'=>$chart_type];
			Session::put('day_wise_sale',$set_filter_session);			
			if($filterMonth == date('m') && $filterYear == date('Y')){
				$numDays = date('d');
			}else{
				$numDays = date('t', mktime(0, 0, 0, $filterMonth, 1, $filterYear)); 
               
			}			
			$allDates = [];
			$report_dates = [];
			for ($day = 1; $day <= $numDays; $day++) {
				$dateString = sprintf('%s-%s-%s', $filterYear, $filterMonth, str_pad($day, 2, '0', STR_PAD_LEFT));
				//$dateString = date('d-M',strtotime($dateString));
				$dates = $dateString;
				$report_dates[] = $dates;
			}
			
			$payment_method_array = [];
			if($payment_method != '' && $payment_method != 'all'){
				if($payment_method == 'cod'){
					$payment_method_array = ['cod'];
				}else{
					$payment_method_array = ['phonepe','ccavenue','razorpay'];
				}
			}
			
			
			
			
			$sales = DB::table('orders')
			->whereMonth('created_at', $filterMonth)
            ->whereYear('created_at', $filterYear)
            ->where('orders.is_delete','no');
			
			if(!empty($payment_method_array)){
				$sales = $sales->wherein('orders.payment_method',$payment_method_array);
			}
			
            $sales =  $sales->where('orders.order_status','!=','Cancelled')
            ->where('orders.order_status','!=','Abandoned')
            ->where('orders.order_status','!=','Cancelled by User')
			->select(DB::raw('DATE(created_at) as sale_day'), DB::raw('SUM(grand_total) as daily_sales'))
			->groupBy(DB::raw('DATE(created_at)'))
			->orderBy(DB::raw('DATE(created_at)'))
			->get();
						
			$sales=json_decode( json_encode($sales), true);
			
			$get_sales_date_wise = [];
			foreach($sales as $sale){
				$get_sales_date_wise[$sale['sale_day']]=  $sale['daily_sales'];
			}
			
			$day_wise_sales = [];
			$report = [];
			foreach($report_dates as $report_date){ 
				$report['dates'] = $report_date;
				
				if(isset($get_sales_date_wise[$report_date])){
				    $sales_amount = $get_sales_date_wise[$report_date];
				}else{
					 $sales_amount = 0;
				}
				
				$dateString = date('M-d',strtotime($report_date));
				$report['sale_dates'][] = $dateString;
				$report['sale_amount'][] = $sales_amount;
				
				
			}
			
			
			
			$section_data = $report;
			$section_data['chart_type'] = $chart_type;
			$section_data['title'] = 'Day Wise Sales ('.get_month($filterMonth).'-'.$filterYear.')';
			$data = [];
			$html = (String)view::make('admin.dashboard-reports.day_wise_sale')->with(compact('data'));
		}
		
		if($section == 'month_wise_sale'){
			
			$filterYear =$form_data['year'];
			$payment_method =$form_data['payment_method'];
			$chart_type =$form_data['chart_type'];
			$set_filter_session = ['year'=>$filterYear,'payment_method'=>$payment_method,'chart_type'=>$chart_type];
			Session::put('month_wise_sale',$set_filter_session);			
			
			if($filterYear == date('Y')){
				$numMonths = round(date('m'));
			}else{
				$numMonths = 12;
			}
			
			
			$report_months = [];
			for ($month = 1; $month <= $numMonths; $month++) {
				
				if($month < 10) { $month_no = '0'.$month; }else{ $month_no = $month; }
				
				$report_months[] = $filterYear.'-'.$month_no;
			}
			
			
			$payment_method_array = [];
			if($payment_method != '' && $payment_method != 'all'){
				if($payment_method == 'cod'){
					$payment_method_array = ['cod'];
				}else{
					$payment_method_array = ['phonepe','ccavenue','razorpay'];
				}
			}
			
			$sales = DB::table('orders')
			->selectRaw("DATE_FORMAT(created_at, '%Y-%m') as month, SUM(grand_total) as total_sales")
			->whereYear('created_at', $filterYear)
			->where('orders.is_delete','no');
			
			if(!empty($payment_method_array)){
				$sales = $sales->wherein('orders.payment_method',$payment_method_array);
			}
            $sales = $sales->where('orders.order_status','!=','Cancelled')
            ->where('orders.order_status','!=','Abandoned')
            ->where('orders.order_status','!=','Cancelled by User')
			->groupBy(DB::raw("DATE_FORMAT(created_at, '%Y-%m')"))
			->orderBy('month')
			->get();
						
			$sales=json_decode( json_encode($sales), true);
			
			$get_sales_month_wise = [];
			foreach($sales as $sale){
				$get_sales_month_wise[$sale['month']]=  $sale['total_sales'];
			}
			
			$month_wise_sales = [];
			$report = [];
			foreach($report_months as $report_month){ 
				$report['dates'] = $report_month;
				
				if(isset($get_sales_month_wise[$report_month])){
				    $sales_amount = $get_sales_month_wise[$report_month];
				}else{
					 $sales_amount = 0;
				}
				$get_month_name = explode('-',$report_month);
				$month_name = get_month($get_month_name[1]);
				$report['sale_dates'][] = $month_name;
				$report['sale_amount'][] = $sales_amount;
				
			}
			
			
			
			$section_data = $report;
			$section_data['chart_type'] = $chart_type;
			$section_data['title'] = 'Month Wise Sales ('.$filterYear.')';
			$data = [];
			$html = (String)view::make('admin.dashboard-reports.month_wise_sale')->with(compact('data'));
		}
		
		if($section == 'year_wise_sale'){
			
			$payment_method =$form_data['payment_method'];
			$chart_type =$form_data['chart_type'];
			$set_filter_session = ['payment_method'=>$payment_method,'chart_type'=>$chart_type];
			Session::put('year_wise_sale',$set_filter_session);			
			
			
			$report_years = [];
			for($y=2021; $y < date('Y')+1; $y++){				
				$report_years[] = $y;
			}
			$payment_method_array = [];
			if($payment_method != '' && $payment_method != 'all'){
				if($payment_method == 'cod'){
					$payment_method_array = ['cod'];
				}else{
					$payment_method_array = ['phonepe','ccavenue','razorpay'];
				}
			}
			
			$sales = DB::table('orders')
			->selectRaw('YEAR(created_at) as year, SUM(grand_total) as total_sales');
			
			if(!empty($payment_method_array)){
				$sales = $sales->wherein('orders.payment_method',$payment_method_array);
			}
			
			$sales = $sales->where('orders.is_delete','no')
            ->where('orders.order_status','!=','Cancelled')
            ->where('orders.order_status','!=','Abandoned')
            ->where('orders.order_status','!=','Cancelled by User')
			->groupBy(DB::raw('YEAR(created_at)'))
			->orderBy('year')
			->get();
						
			$sales=json_decode( json_encode($sales), true);
			
			$get_sales_year_wise = [];
			foreach($sales as $sale){
				$get_sales_year_wise[$sale['year']]=  $sale['total_sales'];
			}
			
			$year_wise_sales = [];
			$report = [];
			foreach($report_years as $report_year){ 
				$report['dates'] = $report_year;
				
				if(isset($get_sales_year_wise[$report_year])){
				     $sales_amount = $get_sales_year_wise[$report_year];
				}else{
					 $sales_amount = 0;
				}
				
				
				$report['sale_dates'][] = $report_year;
				$report['sale_amount'][] = $sales_amount;
				
			}
			
			
			
			$section_data = $report;
			$section_data['chart_type'] = $chart_type;
			$section_data['title'] = 'Year Wise Sales';
			$data = [];
			$html = (String)view::make('admin.dashboard-reports.year_wise_sale')->with(compact('data'));
		}
		
		if($section == 'top_sale'){ 
			$data = [];
			
			$set_filter_session = ['from_date'=>$form_data['from_date'],'to_date'=>$form_data['to_date']];
			Session::put('top_sale',$set_filter_session);		
			
			
			
			$sales = OrderProduct::with('productdetail')
			->join('products','order_products.product_id','products.id')
			->join('orders','order_products.order_id','orders.id')
			->where('orders.is_delete','no')
            ->where('orders.order_status','!=','Cancelled')
            ->where('orders.order_status','!=','Abandoned')
            ->where('orders.order_status','!=','Cancelled by User');
			
			
			if(!empty($form_data['from_date'])){
                $sales = $sales->whereDate('orders.created_at', '>=',$form_data['from_date']);
            }
            if(!empty($form_data['to_date'])){
                $sales = $sales->whereDate('orders.created_at', '<=',$form_data['to_date']);
            }
			
			$sales = $sales->select('products.product_name','order_products.product_id', DB::raw('SUM(product_qty) AS total_quantity_sold'))
			->groupBy('product_id')
			->orderByDesc('total_quantity_sold')
			->limit(5)
			->get();
			$sales=json_decode( json_encode($sales), true);
			$total_quantity_sold = 0;
            foreach($sales as $sale){
            	$total_quantity_sold += $sale['total_quantity_sold'];
            }
			
			$html = (String)view::make('admin.dashboard-reports.top_sale')->with(compact('sales','total_quantity_sold'));
			$section_data['title'] = 'Top Sale';
		}
		
		
		if($section == 'top_sale_category_wise'){ 
			$data = [];
			
			$set_filter_session = ['from_date'=>$form_data['from_date'],'to_date'=>$form_data['to_date']];
			Session::put('top_sale_category_wise',$set_filter_session);		
			
			
			
			$sales = DB::table('order_products')
			->join('products','order_products.product_id','products.id')
			->join('categories','categories.id','products.category_id')
			->join('orders','order_products.order_id','orders.id')
			->where('orders.is_delete','no')
            ->where('orders.order_status','!=','Cancelled')
            ->where('orders.order_status','!=','Abandoned')
            ->where('orders.order_status','!=','Cancelled by User');
			
			
			if(!empty($form_data['from_date'])){
                $sales = $sales->whereDate('orders.created_at', '>=',$form_data['from_date']);
            }
            if(!empty($form_data['to_date'])){
                $sales = $sales->whereDate('orders.created_at', '<=',$form_data['to_date']);
            }
			
			$sales = $sales->select('categories.name as category_name','categories.image','products.category_id','order_products.product_id', DB::raw('SUM(product_qty) AS total_quantity_sold'))
			->groupBy('products.category_id')
			->orderByDesc('total_quantity_sold')
			->limit(5)
			->get();
			$sales=json_decode( json_encode($sales), true);
			$total_quantity_sold = 0;
            foreach($sales as $sale){
            	$total_quantity_sold += $sale['total_quantity_sold'];
            }
			
			$html = (String)view::make('admin.dashboard-reports.top_sale_category_wise')->with(compact('sales','total_quantity_sold'));
			$section_data['title'] = 'Top Sale';
		}
		
		
		
		
		$dashboard_report =[
			'status'=>true,
			'html'=>$html,
			'section'=>$section,
			'section_data'=>$section_data,
		];// pd($dashboard_report);
		return response()->json($dashboard_report);
		
		 
	 }


    public function profile(Request $request){
        Session::put('active',3);
        $admindata = DB::table('admins')->where('id', Auth::guard('admin')->user()->id)->first();
        $admindata=json_decode( json_encode($admindata), true);
        $title = "Profile";
        return view('admin.profile', ['admindata'=>$admindata,'title'=>$title]);
    }

    public function logout(){
        Auth::guard('admin')->logout();
        return redirect()->action('App\Http\Controllers\Admin\AdminController@login')->with('flash_message_success', 'Logged out successfully.');
       
    }

    public function settings(Request $request){
        Session::put('active',4);
        if($request->isMethod('post')){
            $data = $request->all();
            $this->validate($request, [
                'name'=>'required',
                'email'=>'required|email',
                'mobile'=>'required'
        ]);
        $update_data = DB::table('admins')
            ->where('id', Auth::guard('admin')->user()->id)
            ->update([
                'name'=>$data['name'],
                'email'=>$data['email'],
                'mobile'=>$data['mobile']]); 
            return redirect()->back()->with('flash_message_success','Profile has been updated successfully');
        } else{
            $admindata = DB::table('admins')->where('id', Auth::guard('admin')->user()->id)->first();
            $admindata =json_decode( json_encode($admindata), true);
            $title = "Account Settings";
            return view('admin.admin_accountSettings', ['admindata'=>$admindata,'title'=>$title]); 
        }
    }

    public function changeAdminLogo(Request $request){
    	if($request->isMethod('post')){
    		$image=$_FILES;
	        if($image['image']['error']==0){
	            $imgName = pathinfo($_FILES['image']['name']);
	            $ext = $imgName['extension'];
	            $NewImageName = rand(4,10000);
	            $destination = base_path() . '/public/images/AdminImages/';
	            if(move_uploaded_file($image['image']['tmp_name'],$destination.$NewImageName.".".$ext)){
	                if(file_exists($destination.Auth::guard('admin')->user()->image) && !empty(Auth::guard('admin')->user()->image)){
	                    unlink($destination.Auth::guard('admin')->user()->image);
	                }  
	                $image =DB::table('admins')
	                ->where('id', Auth::guard('admin')->user()->id)
	                ->update(['image' => $NewImageName.".".$ext]);
	                if(!empty($image)){
	                   return redirect()->action('App\Http\Controllers\Admin\AdminController@profile')->with('flash_message_success', 'Image has been uploaded successfully');         
	                } else {
	                   return redirect('admin/settings/#tab_1_2')->with('flash_message_error', 'You have not Select any image'); 
	                }
	            }
	        }
	        else {
	            return redirect('admin/settings/#tab_1_2')->with('flash_message_error', 'You have not Select any image'); 
	        }
    	}
    }

    public function changeAdminPassword(Request $request){
        if($request->isMethod('post')){
            $data = $request->input();
            if(!empty($data)){
                if (Hash::check($data['password'], Auth::guard('admin')->user()->password)){
                    if($data['new_password'] == $data['re_password']){
                            DB::table('admins')
                            ->where('id', Auth::guard('admin')->user()->id)
                            ->update(['password' => bcrypt($data['new_password'])]);  
                        return redirect('admin/settings/')->with('flash_message_success', 'Password has been updated successfully');   
                    }else{
                        return redirect('admin/settings/#tab_1_3')->with('flash_message_error', 'New password and Retype password not match'); 
                    }
                } else {
                    return redirect('admin/settings/#tab_1_3')->with('flash_message_error', 'Your current password is incorrect'); 
                }
            }
        }
    }

    public function subadmins(Request $Request){
        Session::put('active','subadmins'); 
        if($Request->ajax()){
            $conditions = array();
            $data = $Request->input();
            $querys = DB::table('admins')->where('type','!=','admin');
            if(!empty($data['name'])){
                $querys = $querys->where('name','like','%'.$data['name'].'%');
            }
            if(!empty($data['email'])){
                $querys = $querys->where('email','like','%'.$data['email'].'%');
            }
            $querys = $querys->OrderBy('id','DESC');
            $iTotalRecords = $querys->where($conditions)->count();
            $iDisplayLength = intval($_REQUEST['length']);
            $iDisplayStart = intval($_REQUEST['start']);
            $iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength; 
            $querys =  $querys->where($conditions)
                    ->skip($iDisplayStart)->take($iDisplayLength)
                    ->get();
            $sEcho = intval($_REQUEST['draw']);
            $records = array();
            $records["data"] = array(); 
            $end = $iDisplayStart + $iDisplayLength;
            $end = $end > $iTotalRecords ? $iTotalRecords : $end;
            $i=$iDisplayStart;
            $querys=json_decode( json_encode($querys), true);
            foreach($querys as $subadmin){
                $id= base64_encode(convert_uuencode($subadmin['id'])); 
                $checked='';
                if($subadmin['status']==1){
                    $checked='on';
                }else{
                    $checked='off';
                }
                $adminrole ='<a title="Update Subadmin Role" class="btn btn-sm yellow margin-top-10" href="'.url('admin/update-role/'.$subadmin['id']).'"> <i class="fa fa-unlock-alt"></i>
                    </a>';
                $actionValues='<a title="Edit Subadmin" class="btn btn-sm green margin-top-10" href="'.url('admin/add-edit-subadmin/'.$subadmin['id']).'"> <i class="fa fa-edit"></i>
                    </a>'.$adminrole;
                $num = ++$i;
                $records["data"][] = array(     
                    $num,
                    $subadmin['name'],
                    $subadmin['email'],
                    $subadmin['mobile'],
                    '<div  id="'.$subadmin['id'].'" rel="admins" class="bootstrap-switch  bootstrap-switch-'.$checked.'  bootstrap-switch-wrapper bootstrap-switch-animate toogle_switch">
                    <div class="bootstrap-switch-container" ><span class="bootstrap-switch-handle-on bootstrap-switch-primary">&nbsp;Active&nbsp;&nbsp;</span><label class="bootstrap-switch-label">&nbsp;</label><span class="bootstrap-switch-handle-off bootstrap-switch-default">&nbsp;Inactive&nbsp;</span></div></div>',   
                    $actionValues
                );
            }
            $records["draw"] = $sEcho;
            $records["recordsTotal"] = $iTotalRecords;
            $records["recordsFiltered"] = $iTotalRecords;
            return response()->json($records);
        }
        $title = "SubAdmins";
        return View::make('admin.subadmins.subadmins')->with(compact('title'));
    }

    public function addeditSubadmin(Request $request,$id=null){
        Session::put('active',11); 
        if($id ==""){
            $message ='SubAdmin has been added successfully!';
            $title = "Add SubAdmin"; 
            $admin = new Admin;
            $admindata = array();
            $getunitAccessids = array();
        }else{
            $message = 'SubAdmin has been updated successfully!';
            $title = "Edit SubAdmin"; 
            $admin = Admin::find($id);
            $admindata = json_decode(json_encode($admin),true);
        }
        if($request->isMethod('post')){
            $data = $request->all();
            unset($data['_token']);
            foreach ($data as $key => $value) {
                if($key != "password"){
                    $admin->$key = $value;
                }
            }
            if(empty($admindata)){
                $admin->password = bcrypt($data['password']);
            }
            $admin->type="subadmin";
            $admin->save();
            return redirect()->action('App\Http\Controllers\Admin\AdminController@subadmins')->with('flash_message_success',$message);
        }
        return view('admin.subadmins.add-edit-subadmin')->with(compact('title','admindata'));
    }

    public function updateRole(Request $request,$id){
        $getModules = Module::where('shown_in_roles','1')->get();
        $getModules = json_decode(json_encode($getModules),true);
        $adminid = $id;
        $getRoleDetails = AdminRole::where('admin_id',$adminid)->get();
        $getRoleDetails = json_decode(json_encode($getRoleDetails),true);
        if($request->isMethod('post')){
            $data = $request->all();
            foreach ($data['module_id'] as $mkey => $module) {
                $checkIfExists = AdminRole::where(['admin_id'=>$id,'module_id'=>$mkey])->first();
                if(!empty($checkIfExists)){
                    $adminrole = AdminRole::find($checkIfExists->id);
                }else{
                    $adminrole = new AdminRole;
                    $adminrole->admin_id = $id;
                    $adminrole->module_id = $mkey;
                }
                if(is_array($data['module_id'][$mkey])){
                    foreach ($data['module_id'][$mkey] as $akey => $value) {
                        if(isset($data['module_id'][$mkey]['view_access'])){
                            $adminrole->$akey = 1;
                        }else{
                            $adminrole->view_access = 0;
                        }
                        if(isset($data['module_id'][$mkey]['edit_access'])){
                            $adminrole->$akey = 1;
                        }else{
                            $adminrole->edit_access = 0;
                        }
                        if(isset($data['module_id'][$mkey]['delete_access'])){
                            $adminrole->$akey = 1;
                        }else{
                            $adminrole->delete_access = 0;
                        }
                    }
                }else{
                    $adminrole->view_access = 0;
                    $adminrole->edit_access = 0;
                    $adminrole->delete_access = 0;
                }
                $adminrole->save();
            }
            return redirect()->back()->with('flash_message_success','Subadmins Roles Updated Successfully!');
        }
        $title = "Update SubAdmin Role";
        return view('admin.subadmins.update-roles')->with(compact('title','adminid','getRoleDetails','getModules'));
    }

    public function usercareers(Request $Request){
        Session::put('active','careers'); 
        if($Request->ajax()){
            $conditions = array();
            $data = $Request->input();
            $querys = DB::table('careers');
            if(!empty($data['name'])){
                $querys = $querys->where('name','like','%'.$data['name'].'%');
            }
            if(!empty($data['email'])){
                $querys = $querys->where('email','like','%'.$data['email'].'%');
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
            foreach($querys as $career){
                $downloadcv = '<a target="_blank" href="'.url('/Resumes/'.$career['resume']).'">Download</a>';
                $num = ++$i;
                $records["data"][] = array(  
                    $num,
                    $career['name'],  
                    $career['email'],  
                    $career['mobile'],  
                    date('d F y',strtotime($career['created_at'])),  
                    $downloadcv,
                    $career['message'],
                );
            }
            $records["draw"] = $sEcho;
            $records["recordsTotal"] = $iTotalRecords;
            $records["recordsFiltered"] = $iTotalRecords;
            return response()->json($records);
        }
        $title = "Careers";
        return View::make('admin.careers')->with(compact('title'));
    }

    public function events(Request $Request){
        Session::put('active','events'); 
        if($Request->ajax()){
            $conditions = array();
            $data = $Request->input();
            $querys = DB::table('events');
            $querys = $querys->OrderBy('id','DESC');
            $iTotalRecords = $querys->where($conditions)->count();
            $iDisplayLength = intval($_REQUEST['length']);
            $iDisplayStart = intval($_REQUEST['start']);
            $iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength; 
            $querys =  $querys->where($conditions)
                    ->skip($iDisplayStart)->take($iDisplayLength)
                    ->get();
            $sEcho = intval($_REQUEST['draw']);
            $records = array();
            $records["data"] = array(); 
            $end = $iDisplayStart + $iDisplayLength;
            $end = $end > $iTotalRecords ? $iTotalRecords : $end;
            $i=$iDisplayStart;
            $querys=json_decode( json_encode($querys), true);
            foreach($querys as $event){
                $checked='';
                if($event['status']==1){
                    $checked='on';
                }else{
                    $checked='off';
                }
                $actionValues='<a title="Edit Subadmin" class="btn btn-sm green margin-top-10" href="'.url('admin/add-edit-event/'.$event['id']).'"> <i class="fa fa-edit"></i>
                    </a>';
                $num = ++$i;
                $records["data"][] = array(     
                    $num,
                    $event['name'],
                    '<div  id="'.$event['id'].'" rel="events" class="bootstrap-switch  bootstrap-switch-'.$checked.'  bootstrap-switch-wrapper bootstrap-switch-animate toogle_switch">
                    <div class="bootstrap-switch-container" ><span class="bootstrap-switch-handle-on bootstrap-switch-primary">&nbsp;Active&nbsp;&nbsp;</span><label class="bootstrap-switch-label">&nbsp;</label><span class="bootstrap-switch-handle-off bootstrap-switch-default">&nbsp;Inactive&nbsp;</span></div></div>',   
                    $actionValues
                );
            }
            $records["draw"] = $sEcho;
            $records["recordsTotal"] = $iTotalRecords;
            $records["recordsFiltered"] = $iTotalRecords;
            return response()->json($records);
        }
        $title = "Events";
        return View::make('admin.events.events')->with(compact('title'));
    }

    public function addEditEvent(Request $request,$eventid=null){
        if($eventid){
            $title = "Edit Event";
            $event = Event::with('event_detail')->find($eventid);
            $eventdata = json_decode(json_encode($event),true);
        }else{ 
            $title = "Add Event";
            $eventdata = array();
            $event = new Event;
        }
        if($request->isMethod('post')){
            $data = $request->all();
            //create and Update event
            if($eventid){
                $event->name = $data['name'];
                $event->save();
            }else{
                $event->name = $data['name'];
                $event->status = 1;
                $event->save();
                $eventid = DB::getPdo()->lastInsertId();
            }
            foreach($data['event_name'] as $key => $eventname){
                $eventdetail = new EventDetail;
                $eventdetail->event_id = $eventid;
                $eventdetail->name = $eventname;
                if ($request->hasFile('image')) {
                    $files = $request->file('image');
                    foreach($files as $fkey => $file){
                        if($fkey == $key){
                            $filename = $file->getClientOriginalName();
                            $extension = $file->getClientOriginalExtension();
                            $fileName = "event-".$eventid.time()."-".Str::random(5).".".$extension;
                            $destinationPath = 'images/EventImages'.'/';
                            $file->move($destinationPath, $fileName);
                            $eventdetail->image = $fileName;
                        }
                    }
                }
                $eventdetail->status = 1;
                $eventdetail->save();
            }
            return redirect()->action('App\Http\Controllers\Admin\AdminController@events')->with('flash_message_success','Event has been added successfully');
        }
        return view('admin.events.add-edit-event')->with(compact('title','eventid','eventdata'));
    }

    public function updatEventDetailStatus($eventid){
        if($_GET['s'] =="a"){
            EventDetail::where('id',$eventid)->update(['status'=>1]);
        }else{
            EventDetail::where('id',$eventid)->update(['status'=>0]);
        }
        return redirect()->back()->with('flash_message_success','Status has been updated successfully!');
    }

    public function dealerships(Request $Request){
        Session::put('active','dealerships'); 
        if($Request->ajax()){
            $conditions = array();
            $data = $Request->input();
            $querys = DB::table('dealerships');
            if(!empty($data['name'])){
                $querys = $querys->where('name','like','%'.$data['name'].'%');
            }
            if(!empty($data['email'])){
                $querys = $querys->where('email','like','%'.$data['email'].'%');
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
            foreach($querys as $dealership){
                $num = ++$i;
                $actionValues ='';
                $records["data"][] = array(  
                    $dealership['name'],  
                    $dealership['email'],  
                    $dealership['phone'],  
                    $dealership['complete_address'],  
                    $dealership['current_business'],  
                    $dealership['annual_turnover'],  
                    $dealership['net_worth'],  
                    $dealership['nature_of_firm'],  
                    date('d F y',strtotime($dealership['created_at'])),
                );
            }
            $records["draw"] = $sEcho;
            $records["recordsTotal"] = $iTotalRecords;
            $records["recordsFiltered"] = $iTotalRecords;
            return response()->json($records);
        }
        $title = "Dealerships";
        return View::make('admin.dealerships')->with(compact('title'));
    }

    public function stores(Request $Request){
        Session::put('active','stores'); 
        if($Request->ajax()){
            $conditions = array();
            $data = $Request->input();
            $querys = DB::table('stores');
            if(!empty($data['store_name'])){
                $querys = $querys->where('store_name','like','%'.$data['store_name'].'%');
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
            foreach($querys as $store){
                $checked='';
                if($store['status']==1){
                    $checked='on';
                }
                else{
                    $checked='off';
                }
                $actionValues='
                    <a title="Edit" class="btn btn-sm green margin-top-10" href="'.url('/admin/add-edit-store/'.$store['id']).'"> <i class="fa fa-edit"></i>
                    </a>';
                $records["data"][] = array(  
                    $store['store_name'],  
                    $store['address'],  
                    $store['phone'],  
                    $store['email'],  
                    $store['state'],  
                    $store['city'],  
                    $store['pincode'],
                    '<div  id="'.$store['id'].'" rel="stores" class="bootstrap-switch  bootstrap-switch-'.$checked.'  bootstrap-switch-wrapper bootstrap-switch-animate toogle_switch">
                    <div class="bootstrap-switch-container" ><span class="bootstrap-switch-handle-on bootstrap-switch-primary">&nbsp;Active&nbsp;&nbsp;</span><label class="bootstrap-switch-label">&nbsp;</label><span class="bootstrap-switch-handle-off bootstrap-switch-default">&nbsp;Inactive&nbsp;</span></div></div>', 
                    $actionValues
                );
            }
            $records["draw"] = $sEcho;
            $records["recordsTotal"] = $iTotalRecords;
            $records["recordsFiltered"] = $iTotalRecords;
            return response()->json($records);
        }
        $title = "Stores";
        return View::make('admin.stores.stores')->with(compact('title'));
    }

    public function addEditStore(Request $request, $storeid=null){
        if($storeid==""){
            $title="Add Store";
            $store = new Store;
            $mesage="Store has been added successfully";
            $storedata= array();
        }else{
            $title="Edit Store";
            $mesage="Store has been updated successfully";
            $store = Store::find($storeid);
            $storedata = json_decode(json_encode($store),true);
        }
        if($request->isMethod('post')){
            $data = $request->all();
            $store->store_name = $data['store_name'];
            $explodeStateCity  = explode('-',$data['city']);
            $store->state  =$explodeStateCity[0];
            $store->city  =$explodeStateCity[1];
            $store->phone = $data['phone'];
            $store->email = $data['email'];
            $store->address = $data['address'];
            $store->pincode = $data['pincode'];
            $store->latitude = $data['latitude'];
            $store->longitude = $data['longitude'];
            $store->status = 1;
            $store->save();
            return redirect()->action('App\Http\Controllers\Admin\AdminController@stores')->with('flash_message_success',$mesage);
        }
        $states = State::with('cities')->get()->toArray();
        return view('admin.stores.add-edit-store')->with(compact('storedata','title','states'));
    }

    public function websettings(Request $Request){
        Session::put('active','websettings'); 
        if($Request->ajax()){
            $conditions = array();
            $data = $Request->input();
            $querys = DB::table('web_settings');
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
            foreach($querys as $websetting){
                $checked='';
                if($websetting['status']==1){
                    $checked='on';
                }
                else{
                    $checked='off';
                }
                $actionValues='
                    <a title="Edit" class="btn btn-sm green margin-top-10" href="'.url('/admin/edit-web-setting/'.$websetting['id']).'"> <i class="fa fa-edit"></i>
                    </a>';
                $records["data"][] = array(  
                    $websetting['type'],  
                    $websetting['description'],
                    '<div  id="'.$websetting['id'].'" rel="web_settings" class="bootstrap-switch  bootstrap-switch-'.$checked.'  bootstrap-switch-wrapper bootstrap-switch-animate toogle_switch">
                    <div class="bootstrap-switch-container" ><span class="bootstrap-switch-handle-on bootstrap-switch-primary">&nbsp;Active&nbsp;&nbsp;</span><label class="bootstrap-switch-label">&nbsp;</label><span class="bootstrap-switch-handle-off bootstrap-switch-default">&nbsp;Inactive&nbsp;</span></div></div>', 
                    $actionValues
                );
            }
            $records["draw"] = $sEcho;
            $records["recordsTotal"] = $iTotalRecords;
            $records["recordsFiltered"] = $iTotalRecords;
            return response()->json($records);
        }
        $title = "Web Settings";
        return View::make('admin.settings.web-settings')->with(compact('title'));
    }

    public function editWebSetting(Request $request, $id){
        if($request->isMethod('post')){
            $data = $request->all(); 
            WebSetting::where('id',$id)->update(['description'=>$data['description']]);
            return redirect()->back()->with('flash_message_success','Record updated successfully');
        }
        $details = DB::table('web_settings')->where('id',$id)->first();
        $title="Edit";
        return view('admin.settings.edit-web-setting')->with(compact('title','details'));
    }

    public function subscribers(Request $Request){
        Session::put('active','subscribers'); 
        if($Request->ajax()){
            $conditions = array();
            $data = $Request->input();
            $querys = DB::table('subscribers');
            if(!empty($data['email'])){
                $querys = $querys->where('email','like','%'.$data['email'].'%');
            }
            $iTotalRecords = $querys->where($conditions)->count();
            $iDisplayLength = intval($_REQUEST['length']);
            $iDisplayStart = intval($_REQUEST['start']);
            $iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength; 
            $querys =  $querys->where($conditions)
                ->skip($iDisplayStart)->take($iDisplayLength)
                ->OrderBy('subscribers.id','DESC')
                ->get();  
            $sEcho = intval($_REQUEST['draw']);
            $records = array();
            $records["data"] = array(); 
            $end = $iDisplayStart + $iDisplayLength;
            $end = $end > $iTotalRecords ? $iTotalRecords : $end;
            $i=$iDisplayStart;
            $querys=json_decode( json_encode($querys), true);
            foreach($querys as $websetting){
                $actionValues='<a  title="Delete Subscribers"  class="btn btn-sm red margin-top-10 delete"  onclick="return ConfirmDelete()" href="'.url('admin/delete-subscribers/'.$websetting['id']).'"> <i class="fa fa-times"></i>';
                $records["data"][] = array(  
                    $websetting['email'],  
                    $websetting['type'], 
                    $actionValues
                );
            }
            $records["draw"] = $sEcho;
            $records["recordsTotal"] = $iTotalRecords;
            $records["recordsFiltered"] = $iTotalRecords;
            return response()->json($records);
        }
        $title = "Subscribers";
        return View::make('admin.users.subscribers')->with(compact('title'));
    }
    public function notify(Request $Request){
        Session::put('active','Notify'); 
        if($Request->ajax()){
            $conditions = array();
            $data = $Request->input();
            $querys = DB::table('notifies');
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
                ->OrderBy('notifies.id','DESC')
                ->get();  
            $sEcho = intval($_REQUEST['draw']);
            $records = array();
            $records["data"] = array(); 
            $end = $iDisplayStart + $iDisplayLength;
            $end = $end > $iTotalRecords ? $iTotalRecords : $end;
            $i=$iDisplayStart;
            $querys=json_decode( json_encode($querys), true);
            foreach($querys as $websetting){
                $actionValues='';
                $records["data"][] = array(  
                    $websetting['name'],  
                    $websetting['email'], 
                    $websetting['mobile'],
                    $websetting['notifysize'],  
                    $websetting['notifycode'],
                    $websetting['created_at'],
                    $actionValues
                );
            }
            $records["draw"] = $sEcho;
            $records["recordsTotal"] = $iTotalRecords;
            $records["recordsFiltered"] = $iTotalRecords;
            return response()->json($records);
        }
        $title = "Notify";
        return View::make('admin.users.notify')->with(compact('title'));
    }  
    public function cms(Request $Request){
        Session::put('active','Cms'); 
        if($Request->ajax()){
            $conditions = array();
            $data = $Request->input();
            $querys = DB::table('cms_pages');
            $querys = $querys->where('status',1);
           /* if(!empty($data['email'])){
                $querys = $querys->where('email','like','%'.$data['email'].'%');
            }
            if(!empty($data['notifysize'])){
                $querys = $querys->where('notifysize','like','%'.$data['notifysize'].'%');
            }
            if(!empty($data['notifycode'])){
                $querys = $querys->where('notifycode','like','%'.$data['notifycode'].'%');
            }    */        
            $iTotalRecords = $querys->where($conditions)->count();
            $iDisplayLength = intval($_REQUEST['length']);
            $iDisplayStart = intval($_REQUEST['start']);
            $iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength; 
            $querys =  $querys->where($conditions)
                ->skip($iDisplayStart)->take($iDisplayLength)
                ->OrderBy('cms_pages.id','DESC')
                ->get();  
            $sEcho = intval($_REQUEST['draw']);
            $records = array();
            $records["data"] = array(); 
            $end = $iDisplayStart + $iDisplayLength;
            $end = $end > $iTotalRecords ? $iTotalRecords : $end;
            $i=$iDisplayStart;
            $querys=json_decode( json_encode($querys), true);
            foreach($querys as $websetting){
				
                $actionValues='<a title="Edit" class="btn btn-sm green margin-top-10" href="'.url('/admin/edit-add-cms/'.$websetting['id']).'"> <i class="fa fa-edit"></i>
                    </a>';
				
				if($websetting['id'] == '8'){
				$actionValues .='<a title="Edit" class="btn btn-sm green margin-top-10" href="'.url('/admin/faq-page/').'">Content
                    </a>';
				}
				
                $records["data"][] = array(  
                    $websetting['title'],  
                    $this->readmore($websetting['description'],$websetting['id']),  
                    $actionValues
                );
            }
            $records["draw"] = $sEcho;
            $records["recordsTotal"] = $iTotalRecords;
            $records["recordsFiltered"] = $iTotalRecords;
            return response()->json($records);
        }
        
		$title = "Cms";
        return View::make('admin.cms.cms')->with(compact('title'));
    }  
    public function readmore($string,$id){
        $string = strip_tags($string);
        if (strlen($string) > 500) {
        
            // truncate string
            $stringCut = substr($string, 0, 500);
            $endPoint = strrpos($stringCut, ' ');
        
            //if the string doesn't contain any space then it will cut without word basis.
            $string = $endPoint? substr($stringCut, 0, $endPoint) : substr($stringCut, 0);
            $string .= '... <a href="'.url('/admin/edit-add-cms/'.$id).'">Read More</a>';
        }
        return $string;        
    }    
    public function cmspage(){   
        
        
        
    }
    public function addEditCms(Request $request, $storeid=null){
        if($storeid==""){
            $title="Add Store";
            $cmsdata = "";
            $cms = new CmsPage;
            $mesage="Page has been added successfully";
            $storedata= array();
        }else{
            $title="Edit Store";
            $cmsdata = "";
            $mesage="Page has been updated successfully";
            $cms = CmsPage::find($storeid);
            $cmsdata = json_decode(json_encode($cms),true);
        }
        
        if($request->isMethod('post')){
            $data = $request->all();
            $cms->title = $data['title'];
            $cms->meta_title = $data['meta_title'];
            $cms->meta_description = $data['meta_description'];
            $cms->meta_keywords = $data['meta_keywords'];
            $cms->description = $data['editor1'];
            $cms->status = 1;
            $cms->save();
            return redirect()->action('App\Http\Controllers\Admin\AdminController@cms')->with('flash_message_success',$mesage);
        } 
        //echo "<pre>"; print_r($cmsdata); exit;
        return view('admin.cms.edit-add-cms')->with(compact('cmsdata','title'));        
        
    }
	public function faqpagereadmore($string,$id){
        $string = strip_tags($string);
        if (strlen($string) > 500) {
        
            // truncate string
            $stringCut = substr($string, 0, 500);
            $endPoint = strrpos($stringCut, ' ');
        
            //if the string doesn't contain any space then it will cut without word basis.
            $string = $endPoint? substr($stringCut, 0, $endPoint) : substr($stringCut, 0);
            $string .= '... <a href="'.url('/admin/faqpage-addEdit/'.$id).'">Read More</a>';
        }
        return $string;        
    } 
	 public function FaqPage(Request $Request, $storeid=null){ 
	    $data = FaqPageContent::orderBy('position')->get();
		$title = 'Faq Page';
		if($Request->ajax()){
            $conditions = array();
            $data = $Request->input();
            $querys = DB::table('faq_page_contents');
            $querys = $querys->orderBy('position');
           if(!empty($data['topic'])){
                $querys = $querys->where('topic','like','%'.$data['topic'].'%');
            }
			/*
            if(!empty($data['notifysize'])){
                $querys = $querys->where('notifysize','like','%'.$data['notifysize'].'%');
            }
            if(!empty($data['notifycode'])){
                $querys = $querys->where('notifycode','like','%'.$data['notifycode'].'%');
            }    */        
            $iTotalRecords = $querys->where($conditions)->count();
            $iDisplayLength = intval($_REQUEST['length']);
            $iDisplayStart = intval($_REQUEST['start']);
            $iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength; 
            $querys =  $querys->where($conditions)
                ->skip($iDisplayStart)->take($iDisplayLength)
                ->OrderBy('faq_page_contents.id','DESC')
                ->get();  
            $sEcho = intval($_REQUEST['draw']);
            $records = array();
            $records["data"] = array(); 
            $end = $iDisplayStart + $iDisplayLength;
            $end = $end > $iTotalRecords ? $iTotalRecords : $end;
            $i=$iDisplayStart;
            $querys=json_decode( json_encode($querys), true);
            foreach($querys as $websetting){
				
                $actionValues='<a title="Edit" class="btn btn-sm green margin-top-10" href="'.url('/admin/faqpage-addEdit/'.$websetting['id']).'"> <i class="fa fa-edit"></i>
                    </a>
				<a title="Edit"  class="btn btn-sm red margin-top-10 delete"  onclick="return Confirm_Delete()"  href="'.url('/admin/faqpage-delete/'.$websetting['id']).'"> <i class="fa fa-times"></i>
                    </a>'
				;
				if($websetting['contents'] ==''){
					$contents = '';
				}else{ 
					$contents = base64_decode($websetting['contents']);
				}
                $records["data"][] = array(  
                    $websetting['topic'],  
                    $this->faqpagereadmore($contents,$websetting['id']),
                    $websetting['position'],  					
                    $actionValues
                );
            }
            $records["draw"] = $sEcho;
            $records["recordsTotal"] = $iTotalRecords;
            $records["recordsFiltered"] = $iTotalRecords;
            return response()->json($records);
        }
        $title = '';
		return view('admin.cms.faqpage.list')->with(compact('title','data')); 
	 }
	    
	 public function faqPageAddEdit(Request $request, $storeid=null){ 
	  if($storeid==""){
            $title="Add Store";
            $cmsdata = "";
            $cms = new FaqPageContent;
            $mesage="Faq Page content has been added successfully";
            $storedata= array();
        }else{
            $title="Edit Store";
            $cmsdata = "";
            $mesage="Faq Page content has been updated successfully";
            $cms = FaqPageContent::find($storeid);
            $cmsdata = json_decode(json_encode($cms),true);
        }
        //echo "<pre>"; print_r($cms); exit; 
        if($request->isMethod('post')){
			//echo "<pre>"; print_r($_POST); exit; 
            $data = $request->all();
            $cms->topic = $data['topic'];
            $cms->contents = base64_encode($data['contents']);
            $cms->position = $data['position'];
            $cms->save();
            return redirect()->action('App\Http\Controllers\Admin\AdminController@faqPage')->with('flash_message_success',$mesage);
        } 
		return view('admin.cms.faqpage.addedit')->with(compact('title','cms')); 
	 }
    public function faqpage_delete($id){
		 FaqPageContent::where('id', $id)->delete();
		 $mesage="Faq Page content has been deleted successfully";
		 return redirect()->action('App\Http\Controllers\Admin\AdminController@faqPage')->with('flash_message_success',$mesage);
	}
	public function colorfamilies(Request $Request){
        Session::put('active','Colorfamily'); 
        if($Request->ajax()){
            $conditions = array();
            $data = $Request->input();
            $querys = DB::table('productcolors');
            if(!empty($data['product_color'])){
                $querys = $querys->where('product_color','like','%'.$data['product_color'].'%');
            }           
            $iTotalRecords = $querys->where($conditions)->count();
            $iDisplayLength = intval($_REQUEST['length']);
            $iDisplayStart = intval($_REQUEST['start']);
            $iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength; 
            $querys =  $querys->where($conditions)
                ->skip($iDisplayStart)->take($iDisplayLength)
                ->OrderBy('productcolors.id','DESC')
                ->get();  
            $sEcho = intval($_REQUEST['draw']);
            $records = array();
            $records["data"] = array(); 
            $end = $iDisplayStart + $iDisplayLength;
            $end = $end > $iTotalRecords ? $iTotalRecords : $end;
            $i=$iDisplayStart;
			$s  = 1;
            $querys=json_decode( json_encode($querys), true);
            foreach($querys as $websetting){
                    $deletePro = '</a><a  title="Delete Product"  class="btn btn-sm red margin-top-10 delete"  onclick="return ConfirmDelete()" href="'.url('admin/delete-colorfamily/'.$websetting['id']).'"> <i class="fa fa-times"></i>
                    </a>';
                    $actionValues='<a title="Edit" class="btn btn-sm green margin-top-10" href="'.url('/admin/add-edit-colorfamily/'.$websetting['id']).'"> <i class="fa fa-edit"></i>
                    </a>'.$deletePro;
                $records["data"][] = array(  
					$s,
                    $websetting['product_color'],  
                    $websetting['created_at'],    
                    $actionValues
                );
				$s++;
			}
            $records["draw"] = $sEcho;
            $records["recordsTotal"] = $iTotalRecords;
            $records["recordsFiltered"] = $iTotalRecords;
            return response()->json($records);
        }
        $title = "Color Family";
        return View::make('admin.master.colorfamily-list')->with(compact('title'));			
	}
    public function addEditColorFamilies(Request $request, $familyid=null){
        
        if($familyid==""){
            $title="Add Color Families";
            $familydata = "";
            $familys = '';
            $family = '';
            $familys = new Productcolor;
            $mesage="Color Families has been added successfully";
            $storedata= array();
        }else{
            $title="Edit Color Families";
            $familydata = "";
            $familys = '';
            $family = '';
            $mesage="Color Families has been updated successfully";
            $familys = Productcolor::find($familyid);
            $family = json_decode(json_encode($familys),true);
        }
        if($request->isMethod('post')){
            $data = $request->all();
            if($request->hasFile('image')){
                if ($request->file('image')->isValid()) {
                    $file = $request->file('image');
                    $img = Image::make($file);
                    $destination = public_path('/images/colors/');
                    if(!empty($family) &&  $family['image'] !="" && file_exists($destination.$family['image'])){
                        unlink($destination.$family['image']);
                    }
                    $ext = $file->getClientOriginalExtension();
                    $color_image = $this->slugify($data['product_color']).".png";
                    $img->resize(24,6);
                    $img->save($destination.$color_image);
                    $familys->image= $color_image;
                }
            }
            $familys->product_color = $this->slugify($data['product_color']);
            $familys->save();
            return redirect()->action('App\Http\Controllers\Admin\AdminController@colorfamilies')->with('flash_message_success',$mesage);
        } 
        return view('admin.master.add-edit-colorfamily')->with(compact('family','title'));        
        
    }	
	
    public function deleteColorfamily($familyid){
            $family = Productcolor::where('id', $familyid)->delete();
            $mesage="Color Families has been deleted successfully";
            return redirect()->action('App\Http\Controllers\Admin\AdminController@colorfamilies')->with('flash_message_success',$mesage);
    }	
    
    public function deleteSubscribers($id){
            $querys = DB::table('subscribers')->where('id',$id)->delete();
            $mesage="Subscribers has been deleted successfully";
            return redirect()->action('App\Http\Controllers\Admin\AdminController@subscribers')->with('flash_message_success',$mesage);
    }
	public function neck(Request $Request){
        Session::put('active','Neck'); 
        if($Request->ajax()){
            $conditions = array();
            $data = $Request->input();
            $querys = DB::table('necks');
            if(!empty($data['neck_name'])){
                $querys = $querys->where('neck_name','like','%'.$data['neck_name'].'%');
            }           
            $iTotalRecords = $querys->where($conditions)->count();
            $iDisplayLength = intval($_REQUEST['length']);
            $iDisplayStart = intval($_REQUEST['start']);
            $iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength; 
            $querys =  $querys->where($conditions)
                ->skip($iDisplayStart)->take($iDisplayLength)
                ->OrderBy('necks.id','DESC')
                ->get();  
            $sEcho = intval($_REQUEST['draw']);
            $records = array();
            $records["data"] = array(); 
            $end = $iDisplayStart + $iDisplayLength;
            $end = $end > $iTotalRecords ? $iTotalRecords : $end;
            $i=$iDisplayStart;
			$s  = 1;
            $querys=json_decode( json_encode($querys), true);
            foreach($querys as $websetting){
                    $deletePro = '</a><a  title="Delete Product"  class="btn btn-sm red margin-top-10 delete"  onclick="return ConfirmDelete()" href="'.url('admin/delete-neck/'.$websetting['id']).'"> <i class="fa fa-times"></i>
                    </a>';
                    $actionValues='<a title="Edit" class="btn btn-sm green margin-top-10" href="'.url('/admin/add-edit-neck/'.$websetting['id']).'"> <i class="fa fa-edit"></i>
                    </a>'.$deletePro;
                $records["data"][] = array(  
					$s,
                    $websetting['neck_name'],  
                    $websetting['created_at'],    
                    $actionValues
                );
				$s++;
			}
            $records["draw"] = $sEcho;
            $records["recordsTotal"] = $iTotalRecords;
            $records["recordsFiltered"] = $iTotalRecords;
            return response()->json($records);
        }
        $title = "Neck";
        return View::make('admin.master.neck-list')->with(compact('title'));			
	}
    public function addEditNeck(Request $request, $neckid=null){
        if($neckid==""){
            $title="Add Neck";
            $neck = "";
            $necks = '';
            $necks = new Neck;
            $mesage="Neck has been added successfully";
            $storedata= array();
        }else{
            $title="Edit Neck";
            $neckndata = "";
            $neck = "";
            $necks = '';
            $mesage="Neck has been updated successfully";
            $necks = Neck::find($neckid);
            $neck = json_decode(json_encode($necks),true);
        }
        
        if($request->isMethod('post')){
            $data = $request->all();
            $necks->neck_name = $data['neck_name'];
            $necks->save();
            return redirect()->action('App\Http\Controllers\Admin\AdminController@neck')->with('flash_message_success',$mesage);
        } 
        //echo "<pre>"; print_r($cmsdata); exit;
        return view('admin.master.add-edit-neck')->with(compact('neck','title'));        
        
    }	

    public function deleteNeck($id){
            $family = Neck::where('id', $id)->delete();
            $mesage="Neck has been deleted successfully";
            return redirect()->action('App\Http\Controllers\Admin\AdminController@neck')->with('flash_message_success',$mesage);
    }
	public function sleeve(Request $Request){
        Session::put('active','Sleeve'); 
        if($Request->ajax()){
            $conditions = array();
            $data = $Request->input();
            $querys = DB::table('sleeves');
            if(!empty($data['sleeve_name'])){
                $querys = $querys->where('sleeve_name','like','%'.$data['sleeve_name'].'%');
            }           
            $iTotalRecords = $querys->where($conditions)->count();
            $iDisplayLength = intval($_REQUEST['length']);
            $iDisplayStart = intval($_REQUEST['start']);
            $iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength; 
            $querys =  $querys->where($conditions)
                ->skip($iDisplayStart)->take($iDisplayLength)
                ->OrderBy('sleeves.id','DESC')
                ->get();  
            $sEcho = intval($_REQUEST['draw']);
            $records = array();
            $records["data"] = array(); 
            $end = $iDisplayStart + $iDisplayLength;
            $end = $end > $iTotalRecords ? $iTotalRecords : $end;
            $i=$iDisplayStart;
			$s  = 1;
            $querys=json_decode( json_encode($querys), true);
            foreach($querys as $websetting){
                    $deletePro = '</a><a  title="Delete Product"  class="btn btn-sm red margin-top-10 delete"  onclick="return ConfirmDelete()" href="'.url('admin/delete-sleeve/'.$websetting['id']).'"> <i class="fa fa-times"></i>
                    </a>';
                    $actionValues='<a title="Edit" class="btn btn-sm green margin-top-10" href="'.url('/admin/add-edit-sleeve/'.$websetting['id']).'"> <i class="fa fa-edit"></i>
                    </a>'.$deletePro;
                $records["data"][] = array(  
					$s,
                    $websetting['sleeve_name'],  
                    $websetting['created_at'],    
                    $actionValues
                );
				$s++;
			}
            $records["draw"] = $sEcho;
            $records["recordsTotal"] = $iTotalRecords;
            $records["recordsFiltered"] = $iTotalRecords;
            return response()->json($records);
        }
        $title = "Sleeve";
        return View::make('admin.master.sleeve-list')->with(compact('title'));			
	}
    public function addEditSleeve(Request $request, $sleeveid=null){
        if($sleeveid==""){
            $title="Add Sleeve";
            $sleeve = '';
            $sleevedata = "";
            $sleeves = new Sleeve;
            $mesage="Sleeve has been added successfully";
            $storedata= array();
        }else{
            $title="Edit Sleeve";
            $sleevedata = "";
            $sleeve = '';
            $mesage="Sleeve has been updated successfully";
            $sleeves = Sleeve::find($sleeveid);
            $sleeve = json_decode(json_encode($sleeves),true);
        }
        
        if($request->isMethod('post')){
            $data = $request->all();
            $sleeves->sleeve_name = $data['sleeve_name'];
            $sleeves->save();
            return redirect()->action('App\Http\Controllers\Admin\AdminController@sleeve')->with('flash_message_success',$mesage);
        } 
        //echo "<pre>"; print_r($cmsdata); exit;
        return view('admin.master.add-edit-sleeve')->with(compact('sleeve','title'));        
        
    }	
    public function deleteSleeve($id){
            $family = Sleeve::where('id', $id)->delete();
            $mesage="Sleeve has been deleted successfully";
            return redirect()->action('App\Http\Controllers\Admin\AdminController@sleeve')->with('flash_message_success',$mesage);
    }	
    public function fabric(Request $Request){
        Session::put('active','Fabric'); 
        if($Request->ajax()){
            $conditions = array();
            $data = $Request->input();
            $querys = DB::table('fabrics');
            if(!empty($data['fabric_name'])){
                $querys = $querys->where('fabric_name','like','%'.$data['fabric_name'].'%');
            }           
            $iTotalRecords = $querys->where($conditions)->count();
            $iDisplayLength = intval($_REQUEST['length']);
            $iDisplayStart = intval($_REQUEST['start']);
            $iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength; 
            $querys =  $querys->where($conditions)
                ->skip($iDisplayStart)->take($iDisplayLength)
                ->OrderBy('fabrics.id','DESC')
                ->get();  
            $sEcho = intval($_REQUEST['draw']);
            $records = array();
            $records["data"] = array(); 
            $end = $iDisplayStart + $iDisplayLength;
            $end = $end > $iTotalRecords ? $iTotalRecords : $end;
            $i=$iDisplayStart;
			$s  = 1;
            $querys=json_decode( json_encode($querys), true);
            foreach($querys as $websetting){
                    $deletePro = '</a><a  title="Delete Product"  class="btn btn-sm red margin-top-10 delete"  onclick="return ConfirmDelete()" href="'.url('admin/delete-fabric/'.$websetting['id']).'"> <i class="fa fa-times"></i>
                    </a>';
                    $actionValues='<a title="Edit" class="btn btn-sm green margin-top-10" href="'.url('/admin/add-edit-fabric/'.$websetting['id']).'"> <i class="fa fa-edit"></i>
                    </a>'.$deletePro;
                $records["data"][] = array(  
					$s,
                    $websetting['fabric_name'],  
                    $websetting['created_at'],    
                    $actionValues
                );
				$s++;
			}
            $records["draw"] = $sEcho;
            $records["recordsTotal"] = $iTotalRecords;
            $records["recordsFiltered"] = $iTotalRecords;
            return response()->json($records);
        }
        $title = "Fabric";
        return View::make('admin.master.fabric-list')->with(compact('title'));	        
        
        
    }
    public function addEditFabric(Request $request, $fabricid=null){
        if($fabricid==""){
            $title="Add Fabric";
            $fabricdata = "";
            $fabric = '';
            $fabrics = '';
            $fabrics = new Fabric;
            $mesage="Fabric has been added successfully";
            $storedata= array();
        }else{
            $title="Edit Fabric";
            $fabricdata = "";
            $fabric = '';
            $fabrics = '';
            $mesage="Fabric has been updated successfully";
            $fabrics = Fabric::find($fabricid);
            $fabric = json_decode(json_encode($fabrics),true);
        }
        
        if($request->isMethod('post')){
            $data = $request->all();
            $fabrics->fabric_name = $data['fabric_name'];
            $fabrics->save();
            return redirect()->action('App\Http\Controllers\Admin\AdminController@fabric')->with('flash_message_success',$mesage);
        } 
        //echo "<pre>"; print_r($cmsdata); exit;
        return view('admin.master.add-edit-fabric')->with(compact('fabric','title'));        
        
    }    
    
	public function pattern(Request $Request){
        Session::put('active','Pattern'); 
        if($Request->ajax()){
            $conditions = array();
            $data = $Request->input();
            $querys = DB::table('patterns');
            if(!empty($data['pattern_name'])){
                $querys = $querys->where('pattern_name','like','%'.$data['pattern_name'].'%');
            }           
            $iTotalRecords = $querys->where($conditions)->count();
            $iDisplayLength = intval($_REQUEST['length']);
            $iDisplayStart = intval($_REQUEST['start']);
            $iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength; 
            $querys =  $querys->where($conditions)
                ->skip($iDisplayStart)->take($iDisplayLength)
                ->OrderBy('patterns.id','DESC')
                ->get();  
            $sEcho = intval($_REQUEST['draw']);
            $records = array();
            $records["data"] = array(); 
            $end = $iDisplayStart + $iDisplayLength;
            $end = $end > $iTotalRecords ? $iTotalRecords : $end;
            $i=$iDisplayStart;
			$s  = 1;
            $querys=json_decode( json_encode($querys), true);
            foreach($querys as $websetting){
                    $deletePro = '</a><a  title="Delete Product"  class="btn btn-sm red margin-top-10 delete"  onclick="return ConfirmDelete()" href="'.url('admin/delete-pattern/'.$websetting['id']).'"> <i class="fa fa-times"></i>
                    </a>';
                    $actionValues='<a title="Edit" class="btn btn-sm green margin-top-10" href="'.url('/admin/add-edit-pattern/'.$websetting['id']).'"> <i class="fa fa-edit"></i>
                    </a>'.$deletePro;
                $records["data"][] = array(  
					$s,
                    $websetting['pattern_name'],  
                    $websetting['created_at'],    
                    $actionValues
                );
				$s++;
			}
            $records["draw"] = $sEcho;
            $records["recordsTotal"] = $iTotalRecords;
            $records["recordsFiltered"] = $iTotalRecords;
            return response()->json($records);
        }
        $title = "Pattern";
        return View::make('admin.master.pattern-list')->with(compact('title'));			
	}
    public function addEditPattern(Request $request, $patternid=null){
        if($patternid==""){
            $title="Add Pattern";
            $patterndata = "";
            $pattern = '';
            $patterns = '';
            $patterns = new Pattern;
            $mesage="Pattern has been added successfully";
            $storedata= array();
        }else{
            $title="Edit Pattern";
            $patterndata = "";
            $pattern = '';
            $patterns = '';
            $mesage="Pattern has been updated successfully";
            $patterns = Pattern::find($patternid);
            $pattern = json_decode(json_encode($patterns),true);
        }
        
        if($request->isMethod('post')){
            $data = $request->all();
            $patterns->pattern_name = $data['pattern_name'];
            $patterns->save();
            return redirect()->action('App\Http\Controllers\Admin\AdminController@pattern')->with('flash_message_success',$mesage);
        } 
        //echo "<pre>"; print_r($cmsdata); exit;
        return view('admin.master.add-edit-pattern')->with(compact('pattern','title'));        
        
    }
    public function headertext(Request $request){
            $title="Edit Header";
            $header_textdata = "";
            $header_text = '';
            $header_texts = '';
            $mesage="Header has been updated successfully";
            $header_texts = Headertext::find(1);
            $header_text = json_decode(json_encode($header_texts),true);

        if($request->isMethod('post')){
            $data = $request->all();
            $header_texts->name = $data['name'];
            $header_texts->save();
            return redirect()->action('App\Http\Controllers\Admin\AdminController@headertext')->with('flash_message_success',$mesage);
        } 
        return view('admin.master.add-edit-headertext')->with(compact('header_text','title'));        
        
    }    
    
    
    
    public function deletePattern($id){
            $family = Pattern::where('id', $id)->delete();
            $mesage="Pattern has been deleted successfully";
            return redirect()->action('App\Http\Controllers\Admin\AdminController@pattern')->with('flash_message_success',$mesage);
    }
    public function deleteFabric($id){
            $family = Fabric::where('id', $id)->delete();
            $mesage="Fabric has been deleted successfully";
            return redirect()->action('App\Http\Controllers\Admin\AdminController@fabric')->with('flash_message_success',$mesage);
    }
    public function slugify($text){
      // replace non letter or digits by -
      $text = preg_replace('~[^\pL\d]+~u', '-', $text);
    
      // transliterate
      $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
    
      // remove unwanted characters
      $text = preg_replace('~[^-\w]+~', '', $text);
    
      // trim
      $text = trim($text, '-');
    
      // remove duplicate -
      $text = preg_replace('~-+~', '-', $text);
    
      // lowercase
      $text = ucwords($text);
    
      if (empty($text)) {
        return 'n-a';
      }
    
      return $text;
    }
	
	public function  UPDATE_PRODUCT_ATTR_SKU(){
		$ProductAttributes =   ProductAttribute::where('sku','')->orwhere('sku',null)->limit('400')->get();
		$ProductAttributes = json_decode(json_encode($ProductAttributes),true);
		/* echo count($ProductAttributes); exit; */
		foreach($ProductAttributes as $ProductAttribute){
			
			$Product = Product::select('product_code')->where('id',$ProductAttribute['product_id'])->first();
			
			if(isset($Product['product_code']) && !empty($Product['product_code'])){
				
				$SKU = $Product->product_code.'-'.$ProductAttribute['size'];
				
				ProductAttribute::where('id',$ProductAttribute['id'])->limit('1')->update(array('sku' => $SKU));
				echo $SKU.'<br>';
				
			}
		}
		
		exit;
		
		
		
		
	}
	
	
	
	public function testfun(){
		exit; die();
		$products = Product::select('id','product_name','product_code','seo_url')->get()->toArray();
		
		//pd($products);
		
		
		foreach($products as $pro){
			
			
			 $slug ='';
             $slug = strtolower(str_replace(' ', '-', $pro['product_name']));
             $slug = strtolower(str_replace('.', '', $slug));
             $slug = strtolower(str_replace(',', '', $slug ));
            
			
			 if($pro['product_code'] != ''){
				 
				 $slug .= '-'.strtolower(str_replace(' ', '', $pro['product_code']));
			 }
			 if(!empty(Product::where('seo_url',$slug)->count())){
				 
				 $slug .='-'.$pro['id'];
			 }
			 
			 
			 
			 
			 //Product::where('id',$pro['id'])->update(['seo_url'=>$slug]);
			
		}
		
		
		pd($products);
		
	}
	
	
	public function update_product_price(){
		
		
		
		
		
		$products = Product::join('categories','categories.id','=','products.category_id')->select('products.id','products.product_name','products.product_code','products.seo_url','products.product_price','categories.name as category_name')->where('categories.status','1')->where('products.status','1')->get()->toArray();
		
		
		foreach($products as $product){

			
			$product_price = $product['product_price'];
			
			/*
			if($product_price > 2599){
			   $product_discount = 40;
		    }else{
			   $product_discount = 30;
		    } */
			
			$product_discount = 0;

			$update_product = Product::find($product['id']);
			$update_product->current_discount = ""; //product
			$update_product->product_discount = $product_discount;
			$update_product->final_price = $product_price - ($product_price * $product_discount)/100;
			$update_product->save();
			
			
			
			echo $product_price."<br>";
			echo $product_discount."<br>";
			echo $product_price - (($product_price * $product_discount)/100)."<br>";
			echo '<br>';
			echo '<br>';
			echo '<br>';
			echo '<br>';
			echo '<br>';
			echo '<br>';
			
			
			
			
			
		}
		
		
		
		
		
	}
	
	
	
	
	
	
	
	
}