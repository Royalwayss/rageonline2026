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
use SoapClient;
use SoapHeader;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Http;
use App\Order;
use App\OrderProduct;
use App\ProductAttribute;
use App\Product;
use NumberFormatter;
use App\OrderHistory;
use App\AwbNumber;
use App\OrderAddress;
use Auth;
class OrdersController extends Controller
{
    //
    public function orders(Request $Request){
	    
		Session::put('active','orders'); 
        $getorderstatus = DB::table('order_statuses')->where('status',1)->get();
        $getorderstatus = json_decode(json_encode($getorderstatus),true);
        if($Request->ajax()){
            $conditions = array();
            $data = $Request->input();
            $querys = DB::table('orders')->join('users','users.id','=','orders.user_id')->where('orders.is_delete','no')->select('orders.*','users.email','users.name','users.mobile','users.user_type');
            if(!empty($data['orderid'])){
                $querys = $querys->where('orders.id','like','%'.$data['orderid'].'%');
            }
            if(!empty($data['name'])){
                $querys = $querys->where('users.name','like','%'.$data['name'].'%');
            }
            if(!empty($data['email'])){
                $querys = $querys->where('users.email','like','%'.$data['email'].'%');
            }
			
			if(isset($data['mobile']) && $data['mobile'] != ''){
                $querys = $querys->where('users.mobile','like','%'.$data['mobile'].'%');
            }
			
            if(!empty($data['order_status'])){
                $querys = $querys->where('orders.order_status','like','%'.$data['order_status'].'%');
            }
            if(!empty($data['from_date'])){
                    $querys = $querys->whereDate('orders.created_at', '>=',$data['from_date']);
            }
            if(!empty($data['to_date'])){
                $querys = $querys->whereDate('orders.created_at', '<=',$data['to_date']);
            }
			
			if(!empty($data['payment_method'])){
                $querys = $querys->where('orders.payment_method',$data['payment_method']);
            }
			
			
			
			
			
            $iTotalRecords = $querys->where($conditions)->count();
            $iDisplayLength = intval($_REQUEST['length']);
            $iDisplayStart = intval($_REQUEST['start']);
            $iDisplayLength = $iDisplayLength < 0 ? $iTotalRecords : $iDisplayLength; 
            $querys =  $querys->where($conditions)
                        ->skip($iDisplayStart)->take($iDisplayLength)
                		->orderby('orders.id','DESC')
                		->get();
            $sEcho = intval($_REQUEST['draw']);
            $records = array();
            $records["data"] = array(); 
            $end = $iDisplayStart + $iDisplayLength;
            $end = $end > $iTotalRecords ? $iTotalRecords : $end;
            $querys=json_decode( json_encode($querys), true);
            //echo "<pre>"; print_r($querys); echo "</pre>"; die;
            foreach($querys as $order){
                $bluedartInvoice = '';
                if($order['awb_number'] !=""){ 
                    $bluedartInvoice = '<a target="_blank" title="View" class="btn btn-sm red" href="'.url('/admin/courier-invoice/'.$order['id']).'"><i class="fa fa-print"></i></a>';
                }
				if($order['payment_method'] == 'cod'){
					$payment_method = 'Cod'; 
				}else if($order['payment_method'] == 'payu'){
					$payment_method = 'Payu'; 
				}else if($order['payment_method'] == 'ccavenue'){
					$payment_method = 'Ccavenue'; 
				}else if($order['payment_method'] == 'bank_deposit'){
					$payment_method = 'Bank deposit'; 
				}else if($order['payment_method'] == 'razorpay'){
					$payment_method = 'Razorpay'; 
				}else if($order['payment_method'] == 'phonepe'){
					$payment_method = 'Phonepe'; 
				}else{
					$payment_method = $order['payment_method'];
				}					
				
				/*$actionValues='<button title="View Order Details" class="btn btn-sm blue view-modal" id='.$order['id'].' data-toggle="modal" data-target="#OrderView"><i class="fa fa-file"></i></button>'; */
				$actionValues='<a title="View Order Details" class="btn btn-sm green" target="_black" href='.url("admin/order-view/".$order['id']."").' style="margin: 2px;"> <i class="fa fa-file"></i> </a>';
               /* $actionValues .='
                    <a target="_blank" title="View Invoice" class="btn btn-sm green" href="'.url('/admin/order-invoice/'.$order['id']).'" style="margin: 2px;"> <i class="fa fa-print"></i>
                    </a>'.$bluedartInvoice; */
					
				$actionValues .='
                    <a target="_blank" title="View Invoice" class="btn btn-sm green" href="'.url('/admin/order-invoice-new/'.$order['id']).'" style="margin: 2px;"><i class="fa fa-print"></i></a>';
                    
				if($order['waybill'] != ''){
					$actionValues .='<a target="_blank" href="'.asset('admin/track-order/'.$order['id']).'" title="Track Order" class="btn btn-sm green">
					<strong>S</strong>
					</a>';
				}
				
				if(!empty($order['total_order_discount'])){
					 $order_discount = '';
					 if(!empty($order['coupon_discount'])){
				        $order_discount = 'CD-'.formatAmt($order['coupon_discount']);
					 }
					 if(!empty($order['order_discount'])){
						if(!empty($order_discount)){ $order_discount .='<br>'; }
						$order_discount .= 'OD-'.formatAmt($order['order_discount']);
					 }
					 if(!empty($order['prepaid_discount'])){
				        if(!empty($order_discount)){ $order_discount .='<br>'; }
						$order_discount .= 'PD-'.formatAmt($order['prepaid_discount']);
					 }
				}else{
					 $order_discount = formatAmt($order['coupon_discount']);
				}
				
				
				
				
				
				
				$actionValues .='<a title="Delete Order" class="delete_order btn btn-sm red" href="javascript:;" data-order-id='.$order['id'].' style="margin: 2px;"> <i class="fa fa-trash"></i> </a>';
                $records["data"][] = array(      
                    $order['id'],
                    $order['name'].($order['user_type']=="guest"?' (guest)':'').'<br>'.($order['user_type']=="guest"?'':$order['email']).'<br>'.$order['mobile'],  
                    $order_discount, 
                    formatAmt($order['grand_total']), 
                    $payment_method,
                    date('d M Y h:i:a',strtotime($order['created_at'])), 
                    $order['order_status'],
                    $actionValues
                );
            }
            $records["draw"] = $sEcho;
            $records["recordsTotal"] = $iTotalRecords;
            $records["recordsFiltered"] = $iTotalRecords;
            return response()->json($records);
        }
        $title = "Orders";
        return View::make('admin.orders.orders')->with(compact('title','getorderstatus'));
    }
	public function orderdelete(Request $request){
		 $data = $request->all();
		 Order::where('id',$data['id'])->update(['is_delete'=>'yes']);
		 echo true;
	}
	
    public function order_status($id,$order_current_status){
		  $token = Session::token();
		$order_status = DB::table('order_statuses')->where('type','yes')->where('status',1)->orderby('sort','ASC')->get();
		$status = '<form name="orderstatus_form" action='.url('admin/update-order-status/'.$id.'').' class="" method="post">
		<input type="hidden" name="_token" value="'.$token.'">'; 
		
                                        	
                                            $status .= '<select name="status" class="text1" style="width: 113px;">';
											foreach($order_status as $value){
												if($order_current_status == $value->name){ $selected = 'selected'; }else { $selected = ''; }
                                            	$status .= '<option value="'.$value->name.'" '.$selected.'>'.$value->name.'</option>';
											}  
                                             $status.= '</select>
                                            <input name="Submit" type="submit" class="button" value="Go" style="margin-top:8px; height:28px; width:25px; border:0px;">
                                        </form>';
	  return $status;
	}
    public function orderview($id){
        Session::put('active','orders'); 
         $orderDetails = Order::with(['order_address','getuser','order_products','histories'])->where('id',$id)->first();
        $orderDetails = json_decode(json_encode($orderDetails),true);
        $getorderstatus = DB::table('order_statuses')->where('type','yes')->where('status',1)->orderby('sort','ASC')->get();
        $getorderstatus = json_decode(json_encode($getorderstatus),true);
		$title ='Order View';
        return view('admin.orders.order-view')->with(compact('title','orderDetails','getorderstatus'));
    }
	 public function orderDetails($id){
        $orderDetails = Order::with(['order_address','getuser','order_products','histories'])->where('id',$id)->first();
        $orderDetails = json_decode(json_encode($orderDetails),true);
        $getorderstatus = DB::table('order_statuses')->where('type','yes')->where('status',1)->orderby('sort','ASC')->get();
        $getorderstatus = json_decode(json_encode($getorderstatus),true);
        return view('admin.orders.popup.order-view')->with(compact('orderDetails','getorderstatus'));
    }
	

    public function vieworderInvoice(Request $request,$id){
        $orderDetails = Order::withCount(['order_products as total_items'=>function($query){
                $query->select(DB::raw('sum(product_qty)'));
            }])->with(['order_address','getuser','order_products'])->where('id',$id)->first();
        $orderDetails = json_decode(json_encode($orderDetails),true);
        $title="Invoice";
        $numberWords =  convert_number_to_words($orderDetails['grand_total']);
        return view('admin.orders.order-invoice')->with(compact('title','orderDetails','numberWords'));
    }
    
    public function vieworderInvoicenew(Request $request,$id){ 
        $orderDetails = Order::withCount(['order_products as total_items'=>function($query){
                $query->select(DB::raw('sum(product_qty)'));
            }])->with(['order_address','getuser','order_products'])->where('id',$id)->first();
        $orderDetails = json_decode(json_encode($orderDetails),true);
        $title="Invoice";
        $numberWords =  convert_number_to_words($orderDetails['grand_total']);
        return view('admin.orders.order-invoice-new')->with(compact('title','orderDetails','numberWords'));
    }

    public function courierInvoice($orderid){
        $orderDetails = Order::withCount(['order_products as total_items'=>function($query){
                $query->select(DB::raw('sum(product_qty)'));
            }])->with(['order_address','getuser','order_products'])->where('id',$orderid)->first();
        $orderDetails = json_decode(json_encode($orderDetails),true);
        $title="Invoice";
        $numberWords =  convert_number_to_words($orderDetails['grand_total']);
        return view('admin.orders.courier-invoice')->with(compact('title','orderDetails','numberWords'));
    }

   public function updateOrderStatus(Request $request,$orderid){ 
	    $print_value =0;
        if($request->isMethod('post')){
            $data = $request->all(); //echo "<pre>"; print_r($data ); exit;
            DB::beginTransaction();
            $history = array('order_status'=>$data['status'],'comments'=>$data['comments'],'updated_by'=>Auth::guard('admin')->user()->id,'order_id'=>$orderid);
            OrderHistory::create($history);
            
			if($data['status'] =="Shipped"){
			    
				
				Order::where('id',$orderid)->update(['weight'=>$data['weight']]);
				
				
				$delhivery = new \App\Services\DelhiveryService();
				$delhivery_response = $delhivery->createOrder($orderid);
				if(!empty($delhivery_response) && isset($delhivery_response['packages']) && isset($delhivery_response['packages'][0]) && $delhivery_response['packages'][0]['status'] != 'status') {
					$waybill = $delhivery_response['packages'][0]['waybill'];
					$update_shipping_details = [
							 'ship_by'=>'One Delhivery',
							 'waybill'=>$waybill,
							 'one_delhivery_response'=>json_encode($delhivery_response)
							 
					];
					Order::where('id',$orderid)->update($update_shipping_details);
				}else{
					return response()->json(['status'=>false,'message'=>'<center>Something went to wrong in One Delhivery. Please trh again.</center>']);
				} 
		        
				
			
			} 
		  if($data['status'] =="Cancelled"){	
             $updateqty = OrderProduct::where('order_id',$orderid)->first();
	         ProductAttribute::where('product_id',$updateqty->product_id)->where('size',$updateqty->product_size)->increment('stock',1);
		  }
            Order::where('id',$orderid)->update(['order_status'=>$data['status']]);
            DB::commit();
            $orderDetails = Order::with(['order_products','order_address','getuser'])->where('id',$orderid)->first();
            $orderDetails = json_decode(json_encode($orderDetails),true);
            if(env('MAIL_MODE')=="live" && isset($data['send_mail'])){
                $email = $orderDetails['getuser']['email'];
                $messageData = [
                    'orderDetails' => $orderDetails,
                    'orderStatus' =>$data['status'],
                    'orderid' =>$orderid,
                ];
                $emails = array($email);
                if($data['status'] !=""){
                     foreach($emails as $email){
                        Mail::send('emailtemplate.to_user.order-status-update', $messageData, function($message) use ($email,$orderDetails,$orderid){
                            $message->to($email)->subject('Status - Order#'.$orderid.' '.config('constants.website_url'));
                        });
					}
                }
            }
         
                  $orderDetails['histories'] = OrderHistory::where('order_id',$orderid)->orderby('id','desc')->get();
					
                    $order_histories_data =  (String)view::make('admin.orders.popup.order-history')->with(compact('orderDetails'));
					
					return response()->json(['status'=>true,'message'=>'<center>Order status updated sucessfully.</center>','order_histories'=>$order_histories_data]);
        }
    }

    public function updateShippingAddress(Request $request,$id){
        if($request->isMethod('post')){
            $data = $request->all();
            unset($data['_token']);
            $data['shipping_name'] = $data['shipping_first_name']." ". $data['shipping_last_name'];
            OrderAddress::where('order_id',$id)->update($data);
            return redirect()->back()->with('flash_message_success','Shipping address has been updated successfully');
        }
    }
    public function awb($id){
            $orderDetails = Order::with(['order_address','getuser','order_products'])->where('id',$id)->first();
			//echo "<pre>"; print_r($orderDetails); echo "</pre>"; die;
            if($orderDetails->payment_method=='cod'){
                $pay_method = 'C';
            }else{
                $pay_method = 'P';
            }
            
            $weight = 1;
			$itemDetail = [];
            if($orderDetails->order_products){
                foreach($orderDetails->order_products as $order_products){
                    
					$itemDetail['ItemDetails'] =
						[
							'CGSTAmount'=>'',
							'HSCode'=>'',
							'IGSTAmount'=>'',
							'Instruction'=>'NA' ,
							'InvoiceDate'=> date('Y-m-d'),
							'InvoiceNumber'=> $orderDetails->id.$orderDetails->user_id,
							'ItemID'=> '00'.$order_products->product_id,
							'ItemName'=> $order_products->product_name,
							'ItemValue'=> $order_products->subtotal,
							'Itemquantity'=> $order_products->product_qty,
							'PlaceofSupply'=> '',
							'ProductDesc1'=> 'size: '.$order_products->product_size,
							//'SGSTAmount'=> $order_products->product_gst,
							'SGSTAmount'=> '',
							'SKUNumber'=> $order_products->product_sku,
							'SellerGSTNNumber'=> '03AABCG2143E1ZD',
							'SellerName'=>'Glory Knitwears Pvt Ltd',
							'TaxableAmount'=>'',
							'TotalValue'=> $order_products->grand_total
						];
					
					$product = Product::find($order_products->product_id)->toArray();
                    if(is_array($product>0)){
                        $weight+= $product['weight'];
                    }
                }
            }
			
            try {
				//echo "<pre>"; print_r($itemDetail); die;
            	$url = "http://netconnect.bluedart.com/Ver1.9/ShippingAPI/WayBill/WayBillGeneration.svc";
            	
            	// options for ssl in php 5.6.5
            	$opts = array(
            		'ssl' => array(
            			'ciphers' => 'RC4-SHA',
            			'verify_peer' => false,
            			'verify_peer_name' => false
            		)
            	);
            	
            	// SOAP 1.2 client
            	$params = array(
            		'encoding' => 'UTF-8',
            		'verifypeer' => false,
            		'verifyhost' => false,
            		'soap_version' => SOAP_1_2,
            		'trace' => 1,
            		'exceptions' => 1,
            		'connection_timeout' => 180,
            		'stream_context' => stream_context_create($opts)
            	);
            	
            	$wsdlUrl = $url . '?WSDL';
            	
            	$soap = new SoapClient($wsdlUrl, $params);
            	
            	$soap->__setLocation("http://netconnect.bluedart.com/Ver1.9/ShippingAPI/WayBill/WayBillGeneration.svc");
            	$soap->sendRequest = true;
            	$soap->printRequest = true;
            	$soap->formatXML = true; 
            	
            	$actionHeader = new SoapHeader(
            		'http://www.w3.org/2005/08/addressing',
            		'Action',
            		'http://tempuri.org/IWayBillGeneration/GenerateWayBill',
            		true
            	);
            	
            	$soap->__setSoapHeaders($actionHeader);
            	if($pay_method=='C'){
                	$params = array(
                		'Request' => 
                			array (
                				'Consignee' => array (
                                    'ConsigneeName'=> substr($orderDetails->getuser->name,0,28),
                                    'ConsigneeAddress1' => substr($orderDetails->getuser->address,0,28),
                                    'ConsigneePincode'=> $orderDetails->order_address->shipping_postcode,
                                    'ConsigneeMobile'=> $orderDetails->getuser->mobile,
                				),
                				'Services' => [ 
                						'ProductCode' => 'A',
                						'SubProductCode' => $pay_method,
                						'ProductType' => 'Dutiables',
                						'PieceCount' => '1',
                                        'ActualWeight' => 1,
                                        'InvoiceNo' => $orderDetails->id.$orderDetails->user_id,
                                        'DeclaredValue' => $orderDetails->grand_total,
                                        'CollectableAmount' => $orderDetails->grand_total,
                                        'CreditReferenceNo' => $id, // $idits order number
                						'Dimensions' => [
    										'Dimension' =>
    											[
    												'Breadth' => '2',
    												'Count' => '1',
    												'Height' => '5',
    												'Length' => '3'
    											]
    									],
                						'PickupDate' => date('Y-m-d'),
                						'PickupTime' => '1600'
                				],
								'itemdtl' => $itemDetail,
                				'Shipper' =>
                					array(
                						'OriginArea' => 'LDH',
                						'CustomerCode' => '912332',
                						'CustomerName' => 'Glory Knitwears Pvt Ltd',
                						'CustomerAddress1' => '31-32 SunderNagar Ludhiana Punjab',
                						'CustomerPincode' => '141007',
                						'IsToPayCustomer' => false
                					)
                			),
                			'Profile' => 
                				array(
                					'Api_type' => 'S',
                					'LicenceKey'=>'4b370045996a755284b261b384e3949e',
                					'LoginID'=>'LD910195',
                					'Version'=>'1.3'
                				)
                	);                  	    
            	}else{
                	$params = array(
                		'Request' => 
                			array (
                				'Consignee' => array (
                                    'ConsigneeName'=> substr($orderDetails->getuser->name,0,28),
                                    'ConsigneeAddress1' => substr($orderDetails->getuser->address,0,28),
                                    'ConsigneePincode'=> $orderDetails->order_address->shipping_postcode,
                                    'ConsigneeMobile'=> $orderDetails->getuser->mobile,
                				),								
                				'Services' => [
                						'ProductCode' => 'A',
                						'SubProductCode' => $pay_method,
                						'ProductType' => 'Dutiables',
                						'PieceCount' => '1',
                                        'ActualWeight' => 1,
                                        'InvoiceNo' => $orderDetails->invoice_no,
                                        'DeclaredValue' => $orderDetails->grand_total,
                                        'CreditReferenceNo' => $id, // its order number
                						'Dimensions' => [
    										'Dimension' =>
    											[
    												'Breadth' => '2',
    												'Count' => '1',
    												'Height' => '5',
    												'Length' => '3'
    											]
    									],
                						'PickupDate' => date('Y-m-d'),
                						'PickupTime' => '0000'
                				],
								'itemdtl' => $itemDetail,
                				'Shipper' =>
                					array(
                						'OriginArea' => 'LDH',
                						'CustomerCode' => '912332',
                						'CustomerName' => 'Glory Knitwears Pvt Ltd',
                						'CustomerAddress1' => '31-32 SunderNagar Ludhiana Punjab',
                						'CustomerPincode' => '141007',
                						'IsToPayCustomer' => false
                					)
                			),
                			'Profile' => 
                				array(
                					'Api_type' => 'S',
                					'LicenceKey'=>'4b370045996a755284b261b384e3949e',
                					'LoginID'=>'LD910195',
                					'Version'=>'1.3'
                				)
                	);
            	}
				//echo "<pre>"; print_r($params); die; 
            	$result = $soap->__soapCall('GenerateWayBill', array($params));
                //echo "<pre>"; print_r($result); echo "</pre>"; die;
            	if($result->GenerateWayBillResult){
                	$order = Order::find($id);
                	$order->awb_number = $result->GenerateWayBillResult->AWBNo;
                    $order->destination_area = $result->GenerateWayBillResult->DestinationArea;
                    $order->destination_location = $result->GenerateWayBillResult->DestinationLocation;
                	$order->save();
            	}
            	//echo "<pre>"; print_r($result); exit;
            } catch (SOAPFault $f) {
            	echo $f; die;
                error_log('ERROR => '.$f);
            }  
        }   
		
		
         public function trackOrder(Request $Request,$order_id){
			$order = Order::where('id',$order_id)->where('waybill','!=','')->firstOrFail();
			if(!empty($order)){ 
				$delhivery = new \App\Services\DelhiveryService();
				$ShipmentData = $delhivery->trackOrder($order['waybill']); 
				return View::make('admin.orders.shipment')->with(compact('order','ShipmentData')); 
			}
			
			
		 }
    }
