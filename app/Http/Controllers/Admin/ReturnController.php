<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests;
use DB;
use Cookie;
use Session;
use Crypt;
use App\ReturnRequest;
use App\User;
use App\OrderProduct;
use App\ProductImage;
use App\ExchangeRequest;
use Illuminate\Support\Facades\Mail;
use Auth;
class ReturnController extends Controller
{
    //

    public function returnRequests(Request $Request){
		Session::put('active','returns');
        if($Request->ajax()){
            $conditions = array();
            $data = $Request->input();
            $querys = DB::table('return_requests')->join('users','users.id','=','return_requests.user_id')->join('order_products','order_products.id','=','return_requests.order_product_id')->select('return_requests.*','users.email','users.name','users.mobile','order_products.product_name','order_products.product_size','order_products.product_sku','order_products.product_qty','order_products.subtotal');
            if(!empty($data['orderid'])){
                $querys = $querys->where('return_requests.id','like','%'.$data['orderid'].'%');
            }
            if(!empty($data['name'])){
                $querys = $querys->where(function($qyery) use($data){
                	$qyery->where('users.name','like','%'.$data['name'].'%')->orwhere('users.email','like','%'.$data['name'].'%')->orwhere('users.mobile',$data['name']);
                });
            }
            if(!empty($data['from_date'])){
                    $querys = $querys->whereDate('return_requests.created_at', '>=',$data['from_date']);
            }
            if(!empty($data['to_date'])){
                $querys = $querys->whereDate('return_requests.created_at', '<=',$data['to_date']);
            }
            $iTotalRecords = $querys->where($conditions)->count();
            $iDisplayLength = intval($_REQUEST['length']);
            $iDisplayStart = intval($_REQUEST['start']);
            $iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength; 
            $querys =  $querys->where($conditions)
                        ->skip($iDisplayStart)->take($iDisplayLength)
                		->orderby('return_requests.id','DESC')
                		->get();
            $sEcho = intval($_REQUEST['draw']);
            $records = array();
            $records["data"] = array(); 
            $end = $iDisplayStart + $iDisplayLength;
            $end = $end > $iTotalRecords ? $iTotalRecords : $end;
            $querys=json_decode( json_encode($querys), true);
            foreach($querys as $return){
                    if($return['status']==1){
                        $actionValues='
                        <p class="account-return mb-2"><a class="returnItem blue" href="javascript:;" data-id='.$return['id'].' style="color:green">
    									<i class="fa fa-exchange" aria-hidden="true" style="color: #337b06;"></i>&nbsp; Updated</a></p>';                        
                    }else{
                        $actionValues='
                        <p class="account-return mb-2"><a class="returnItem blue" href="javascript:;" data-id='.$return['id'].' style="color:red">
									<i class="fa fa-exchange" aria-hidden="true" style="color: #ff0000;"></i>&nbsp; Update</a></p>';                        
                    }
					$image = '';
					if($return['filename'] != ''){
						$images = explode(',',$return['filename']);
						$image = '<img style="width:50px" src="'.asset('images/return/'.$images[0]).'">';
						$image .= '<a href="javascript:;" class="request-images" data-images="'.$return['filename'].'" >View</a>';
					}
					
					$product_details = $return['product_name'].'<br>';
					
					$product_details .= '<strong>size </strong>:'.$return['product_size'].'<br>';
					$product_details .= '<strong>sku </strong>:'.$return['product_sku'].'<br>';
					$product_details .= '<strong>price </strong>:'.formatAmt($return['subtotal']).'<br>';
					
					
					$reason = '';
					$reason = $return['reason'];
					if( !empty($return['required_size'])){
						$reason .= '<br><strong>required size</strong> : '.$return['required_size'];
					}
					
                $records["data"][] = array(      
                    '<a target="_blank" href="'.url('admin/order-view/'.$return['order_id']).'">'.$return['order_id'].'</a>',
                    $return['action'],
					$image,
					$return['name'] ."<br>".$return['email']."<br>".$return['mobile'],
                    $product_details,
                    $reason,
                    date('d M Y H:ia',strtotime($return['created_at'])),
                    $actionValues
                );
            }
            $records["draw"] = $sEcho;
            $records["recordsTotal"] = $iTotalRecords;
            $records["recordsFiltered"] = $iTotalRecords;
            return response()->json($records);
        }
        $title = "Product Reviews";
        return View::make('admin.orders.return-requests')->with(compact('title'));
    }
    public function return_status(Request $Request){
        $returnrequest = ReturnRequest::where('id',$_POST['return_id'])->get()->toArray();
        if($returnrequest){
            $user = User::select('email','name')->where('id',$returnrequest[0]['user_id'])->get()->toArray();
        }
        $email = $user[0]['email'];
        $name = $user[0]['name'];
        $return = ReturnRequest::find($_POST['return_id']);
        $return->reply_status = $_POST['reply_status'];
        $return->reply_comment = $_POST['reply_comment'];
        $return->status = 1;
        if($return->save()){
            $messageData = [
                'orderDetails' => $_POST,
                'name' => $name
            ]; 
            if(env('MAIL_MODE') =="live" ){	
            Mail::send('emails.return-update-ordermail', $messageData, function($message) use ($email){
                $message->to($email)->subject('Exchange order status - '.$_POST['reply_status']);
            });
			}			
			
            return redirect()->action('App\Http\Controllers\Admin\ReturnController@returnRequests')->with('flash_message_success','Sucessfully updated');
        }else{
            return redirect()->action('App\Http\Controllers\Admin\ReturnController@returnRequests')->with('flash_message_error','Something went wrong!. Please try again');
        }
    }
    public function get_update_data(Request $Request){
        
        $returnrequest = ReturnRequest::where('id',$_POST['id'])->get()->toArray();
            
			
			if($returnrequest[0]['action'] == 'Exchange'){
			
			    $status_options = '<option value="">Please Select</option>
                            <option value="Exchange Approved">Exchange Approved</option>
                            <option value="Exchange Rejected">Exchange Rejected</option>
                            <option value="Refund in Process">Refund in Process</option>
                            <option value="Refunded">Refunded</option>';
			
			}else{
				$status_options = '<option value="">Please Select</option>
                            <option value="Return Accepted">Return Accepted</option>
                            <option value="Return Rejected">Return Rejected</option>
                            <option value="Refund in Process">Refund in Process</option>
                            <option value="Refunded">Refunded</option>';
			}
			
			
			return response()->json([
                'status'=>true,
                'action'=>$returnrequest[0]['action'],
                'status_options'=>$status_options,
                'reply_comment' =>$returnrequest[0]['reply_comment'],
                'reply_status' =>$returnrequest[0]['reply_status']
            ]);        
    }
    
    public function exchangeRequests(Request $Request){
		Session::put('active','exchange');
        if($Request->ajax()){
            $conditions = array();
            $data = $Request->input();
            $querys = DB::table('exchange_requests')->join('users','users.id','=','exchange_requests.user_id')->join('order_products','order_products.id','=','exchange_requests.order_product_id')->select('exchange_requests.*','users.email','users.name','users.mobile','order_products.product_name','order_products.product_size','order_products.product_sku','order_products.product_qty','order_products.subtotal');
            if(!empty($data['orderid'])){
                $querys = $querys->where('exchange_requests.id','like','%'.$data['orderid'].'%');
            }
            if(!empty($data['name'])){
                $querys = $querys->where(function($qyery) use($data){
                	$qyery->where('users.name','like','%'.$data['name'].'%')->orwhere('users.email','like','%'.$data['name'].'%')->orwhere('users.mobile',$data['name']);
                });
            }
            if(!empty($data['from_date'])){
                    $querys = $querys->whereDate('exchange_requests.created_at', '>=',$data['from_date']);
            }
            if(!empty($data['to_date'])){
                $querys = $querys->whereDate('exchange_requests.created_at', '<=',$data['to_date']);
            }
            $iTotalRecords = $querys->where($conditions)->count();
            $iDisplayLength = intval($_REQUEST['length']);
            $iDisplayStart = intval($_REQUEST['start']);
            $iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength; 
            $querys =  $querys->where($conditions)
                        ->skip($iDisplayStart)->take($iDisplayLength)
                		->orderby('exchange_requests.id','DESC')
                		->get();
            $sEcho = intval($_REQUEST['draw']);
            $records = array();
            $records["data"] = array(); 
            $end = $iDisplayStart + $iDisplayLength;
            $end = $end > $iTotalRecords ? $iTotalRecords : $end;
            $querys=json_decode( json_encode($querys), true);
            foreach($querys as $return){
                    if($return['filename']!=''){
                        $image = '<p class="account-return mb-2"><a class="example-image-link" href="'.asset('images/exchange/'.$return['filename']).'" data-lightbox="example-'.$return['id'].'"><img class="example-image" src="'.asset('images/exchange/'.$return['filename']).'" alt="image-1"/></a></p>';
                    }else{
                        $image = '';
                    }
                    if($return['status']==1){
                        $actionValues='
                        <p class="account-return mb-2"><a class="blue" href="javascript:;" data-id='.$return['id'].' data-status= '.$return['reply_status'].'>
    									<i class="fa fa-ban" aria-hidden="true" style="color:red;font-size: 23px;"></i>&nbsp;</a></p>';                        
                    }else if($return['status']==2){
                        $actionValues='
                        <p class="account-return mb-2"><a class="blue" href="javascript:;" data-id='.$return['id'].' data-status= '.$return['reply_status'].'>
    									<i class="fa fa-check-circle" aria-hidden="true" style="color:green;font-size: 23px;"></i>&nbsp;</a></p>';                        
                    }else{
                        $actionValues='
                        <p class="account-return mb-2"><a class="returnItem blue" href="javascript:;" data-id='.$return['id'].' data-status= '.$return['status'].'>
									<i class="fa fa-exchange" aria-hidden="true" style="color: #ff0000;"></i>&nbsp; Update</a></p>';                        
                    }

                $records["data"][] = array(      
                    '<a target="_blank" href="'.url('admin/order-view/'.$return['order_id']).'">'.$return['order_id'].'</a>',
                    $return['name'] ."<br>".$return['email']."<br>".$return['mobile'],
                    $return['product_name'],
                    $return['product_size'],
                    $return['product_sku'],
                    "Rs.". formatAmt($return['subtotal']),
                    $return['reason'],
                    $image,
                    date('d M Y H:ia',strtotime($return['created_at'])),
                    $actionValues
                );
            }
            $records["draw"] = $sEcho;
            $records["recordsTotal"] = $iTotalRecords;
            $records["recordsFiltered"] = $iTotalRecords;
            return response()->json($records);
        }
        $title = "Exchange Requests";
        return View::make('admin.orders.exchange-requests')->with(compact('title'));
    }
    public function exchange_status(Request $Request){
        $returnrequest = ExchangeRequest::where('id',$_POST['exchange_id'])->get()->toArray();
        if($returnrequest){
            $user = User::select('email','name')->where('id',$returnrequest[0]['user_id'])->get()->toArray();
        }
        $email = $user[0]['email'];
        $name = $user[0]['name'];
        $return = ExchangeRequest::find($_POST['exchange_id']);
        $return->reply_status = $_POST['reply_status'];
        $return->status = 1;
        if($return->save()){
            $messageData = [
                'orderDetails' => $_POST,
                'name' => $name
            ];    
            Mail::send('emails.exchange-update-ordermail', $messageData, function($message) use ($email){
                $message->to($email)->subject('Exchange order status update');
            }); 
            return redirect()->action('App\Http\Controllers\Admin\ReturnController@exchangeRequests')->with('flash_message_success','Sucessfully updated');
        }else{
            return redirect()->action('App\Http\Controllers\Admin\ReturnController@exchangeRequests')->with('flash_message_error','Something went wrong!. Please try again');
        }
    }
    public function accept_exchange($id){
        $title = "Exchange Approve";
        $exchangerequest = ExchangeRequest::where('id',$id)->get()->first();
        $exchangerequest_id = $exchangerequest->id;
        $orderDetails = OrderProduct::where('id',$exchangerequest->order_product_id)->where('user_id',$exchangerequest->user_id)->first();
        if($orderDetails){
            $productAttribute = ProductImage::where('product_id',$orderDetails->product_id)->where('is_default',1)->select('image')->first();
            if(!isset($productAttribute)){
                $productAttribute = ProductImage::where('product_id',$orderDetails->product_id)->select('image')->first();
            }
            return view('admin.orders.exchange-accept-view')->with(compact('title','orderDetails','productAttribute','exchangerequest_id','exchangerequest'));
        }
    }
    public function exchange_acceptstatus(Request $Request){
        $exchangerequest = ExchangeRequest::where('id',$Request->exchange_id)->get()->toArray();
        if($exchangerequest){
            $user = User::select('email','name')->where('id',$exchangerequest[0]['user_id'])->get()->toArray();
        }
        $email = $user[0]['email'];
        $name = $user[0]['name'];
        
        $exchange = ExchangeRequest::find($Request->exchange_id);
        $exchange->reply_comment = $Request->comments;
        $exchange->status = 2;
        $exchange->exchange_sku = $Request->search;
        $exchange->reply_status = 'Accept';
        if($exchange->save()){
            $messageData = [
                'name' => $name
            ];  
            Mail::send('emails.exchange-accept', $messageData, function($message) use ($email){
                $message->to($email)->subject('Exchange order status Approve');
            }); 
            return redirect()->action('App\Http\Controllers\Admin\ReturnController@exchangeRequests')->with('flash_message_success','Sucessfully updated');
        }else{
            return redirect()->action('App\Http\Controllers\Admin\ReturnController@exchangeRequests')->with('flash_message_error','Something went wrong!. Please try again');
        }
    }
}
