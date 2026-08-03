@extends('layouts.adminLayout.backendLayout')
@section('content')
<?php 
   use App\GiftOffer; use App\CustomFunction;
   if($orderDetails['order_address']['shipping_state'] =='Punjab'){
   	  $own_state = 'yes';
   }else{
   	  $own_state = 'no';
   }
   $total_gst_ = 0;
    $order_products_summery = order_products_summery($orderDetails);
    
    ?>
<div class="page-content-wrapper">
   <div class="page-content" >
      <div class="page-head">
         <div class="page-title">
            <h1>Order View #{{ $orderDetails['id']}}</h1>
         </div>
      </div>
      <ul class="page-breadcrumb breadcrumb">
         <li>
            <a href="{!! url('admin/dashboard') !!}">Dashboard</a>
            <i class="fa fa-circle"></i>
         </li>
         <li>
            <a href="{!! url('admin/orders') !!}">Orders</a>
         </li>
      </ul>
      @if(Session::has('flash_message_error'))
      <div role="alert" class="alert alert-danger alert-dismissible fade in"> <button aria-label="Close" data-dismiss="alert" style="text-indent: 0;" class="close" type="button"><span aria-hidden="true">×</span></button> <strong>Error!</strong> {!! session('flash_message_error') !!} </div>
      @endif
      @if(Session::has('flash_message_success'))
      <div role="alert" class="alert alert-success alert-dismissible fade in"> <button aria-label="Close" data-dismiss="alert" style="text-indent: 0;" class="close" type="button"><span aria-hidden="true">×</span></button> <strong>Success!</strong> {!! session('flash_message_success') !!} </div>
      @endif
      <div class="row"  style="background-color:white">
         <div class="col-md-12" style="padding:10px">
            <div class="row">
               <div class="orderAddress">
                  <div class="col-md-12">
                     <div class="portlet blue-hoki box">
                        <div class="portlet-title">
                           <div class="caption">
                              <i class="fa fa-cogs"></i>Order Address
                           </div>
                        </div>
                        <div class="portlet-body">
                           <div class="row">
                              <p style="margin-left:10px"> <strong>Order date: </strong> {{ date('d F Y h:ia',strtotime($orderDetails['created_at'])) }} </p>
                           </div>
                           <div class="row">
                              <div class="col-md-6">
                                 <br />
                                 <span class="text1">--------------------<strong>Billing Address</strong>--------------------</span><br>
                                 <span class="text1">
                                 {{ $orderDetails['order_address']['billing_name'] }} <br>
                                 {{ $orderDetails['order_address']['billing_address'] }}<br>
                                 {{ $orderDetails['order_address']['billing_city'] }} <br>
                                 {{ $orderDetails['order_address']['billing_state'] }} <br>
                                 {{ $orderDetails['order_address']['billing_mobile'] }} <br>
                                 @if(!empty($orderDetails['order_address']['billing_alternative_number']))
                                 {{ $orderDetails['order_address']['billing_alternative_number'] }} <br>
                                 @endif
                                 {{ $orderDetails['order_address']['billing_country'] }}  <br>
                                 </span>
                                 <br><br />
                              </div>
                              <div class="col-md-6">
                                 <br />
                                 <span class="text1">--------------------<strong>Shipping Address</strong>--------------------<br></span>
                                 <span class="text1">
                                 {{ $orderDetails['order_address']['shipping_first_name'] }} <br>
                                 {{ $orderDetails['order_address']['shipping_address'] }}<br>
                                 {{ $orderDetails['order_address']['shipping_city'] }} <br>
                                 {{ $orderDetails['order_address']['shipping_state'] }} <br>
                                 {{ $orderDetails['order_address']['shipping_mobile'] }} <br>
                                 @if(!empty($orderDetails['order_address']['shipping_alternative_number']))
                                 {{ $orderDetails['order_address']['shipping_alternative_number'] }} <br>
                                 @endif
                                 {{ $orderDetails['order_address']['shipping_country'] }}  <br>
                                 </span>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="row">
               <div class="orderProducts">
                  <div class="col-md-12">
                     <div class="portlet blue-hoki box">
                        <div class="portlet-title">
                           <div class="caption">
                              <i class="fa fa-cogs"></i>Order Products
                           </div>
                        </div>
                        <div class="portlet-body">
                           <table width="100%" border="1" style="border-collapse:collapse; font-size:12px; font-family:'roboto_condensedregular';" bordercolor="#CCCCCC" cellpadding="5" cellspacing="5">
                              <tr style="text-align:center">
                                 <td width="25%" style="font-weight:bold;">Product Details </td>
                                 <td width="10%" style="font-weight:bold;">Image </td>
                                 <td width="6%" style="font-weight:bold;">MRP</td>
                                 <td width="6%" style="font-weight:bold;">Discount</td>
                                 <td width="6%" style="font-weight:bold;">Unit Price</td>
                                 <td width="11%" style="font-weight:bold;">Taxable Value</td>
                                 <td width="5%" style="font-weight:bold;">Qty</td>
                                 <td width="10%" style="font-weight:bold;">GST</td>
                                 <td width="10%" style="font-weight:bold;">TOTAL</td>
                              </tr>
                              <?php $priceArr = array(); ?>
                              @foreach($order_products_summery['products'] as $key => $order_product_summery)
                              <tr style="text-align:center">
                                 <?php 
                                    //$priceArr[] = $order_product_summery['subtotal'];
                                    
                                    ?>
                                 <td valign="top">
                                    <a  target="_blank" href="{{ $order_product_summery['product_link'] }}">{{$order_product_summery['product_name']}}</a>
                                    <br>
                                    sku - {{$order_product_summery['product_sku']}} <br>
                                    product code - {{$order_product_summery['product_code']}} <br>
                                    product size - {{$order_product_summery['product_size']}} <br>
                                    product color - {{$order_product_summery['productcolor']}} <br>
                                    category name - {{$order_product_summery['category_name']}} <br>
                                 </td>
                                 <td valign="top"> 
                                    @if(isset($order_product_summery['image']))
                                    <img style="border:0px;" src="{{asset('images/ProductImages/medium/'.$order_product_summery['image'])}}" height="50px" width="50px" >
                                    @else
                                    <img style="border:0px;" src="{{asset('images/no-image-found.jpg')}}" height="50px" width="50px" >
                                    @endif			
                                 </td>
                                 <?php
                                    $product_gst_array[] = $order_product_summery['product_gst'];
                                    
                                    ?>
                                 <td valign="top">{{ AmountFormat($order_product_summery['mrp']) }}</td>
                                 <td valign="top">{{ AmountFormat($order_product_summery['product_discount']) }}</td>
                                 <td valign="top">{{ AmountFormat($order_product_summery['unit_price']) }}</td>
                                 <td valign="top">{{ AmountFormat($order_product_summery['taxable_value']) }}</td>
                                 <td valign="top">{{$order_product_summery['product_qty']}}</td>
                                 </td>
                                 <td valign="top">
                                    <?php
                                       $product_gst =  $order_product_summery['product_gst'];
                                       $gst_amount =  $order_product_summery['product_gst_amount'];
                                       $total_gst_ += $gst_amount;
                                       if($own_state == 'no'){
                                       echo '<b>'.AmountFormat($order_product_summery['IGST']).'</b><br>';
                                       echo 'IGST - '.$gst_amount.' ('.$order_product_summery['product_gst'] .'%)';
                                       }else{
                                       echo '<b>'.AmountFormat($gst_amount).'</b><br>';
                                       echo 'CGST - '.($order_product_summery['CGST']).' ('.($product_gst/2) .'%)<br>';
                                       echo 'SGST - '.($order_product_summery['SGST']).' ('.($product_gst/2) .'%)';
                                       } 
                                       ?>
                                 </td>
                                 <td valign="top">{{ AmountFormat($order_product_summery['sub_total']) }}</td>
                              </tr>
                              @endforeach		
                              <?php 
                                 $shipping_gst = '0';
                                 $shipping_charges = '0';
                                 $shipping_gst_amt = '0';
                                 if(!empty($product_gst_array)){
                                 	
                                 	if(in_array('18',$product_gst_array)){
                                 		$shipping_gst = '18';
                                 	}else{
                                 		$shipping_gst = '5';
                                 	}
                                 	
                                 }
                                 
                                 if(!empty($orderDetails['shipping_charges'])){
                                 	
                                 	$igstcalculate = igstcalculate($orderDetails['shipping_charges'],$shipping_gst);
                                     $shipping_gst_amt = round($igstcalculate);
                                     $shipping_charges = AmountFormat($orderDetails['shipping_charges']);
                                 }
                                 
                                 
                                 
                                 ?>
                              
							  
							  
							
							  <tr>
                                 <td colspan="8" class="text-right">
                                    Total Amount :&nbsp; 
                                 </td>
                                 <td  class="text-right">
                                    <b> {{AmountFormat( $order_products_summery['total_amount'] ) }}</b>
                                 </td>
                              </tr>
							  
							  @if(!empty($order_products_summery['discount']))
							    <tr>
                                 <td colspan="8" class="text-right">
                                    Discount :&nbsp; 
                                 </td>
                                 <td  class="text-right">
                                    <b> {{AmountFormat( $order_products_summery['discount'] ) }}</b>
                                 </td>
                              </tr>
							  @endif
							  
							   <tr>
                                 <td colspan="8" class="text-right">
                                    Sub Total :&nbsp; 
                                 </td>
                                 <td  class="text-right">
                                    <b> {{AmountFormat( $order_products_summery['subtotal'] ) }}</b>
                                 </td>
                              </tr>
							  
							  
							  
							  <tr>
                                 <td colspan="8" class="text-right">
                                    Taxable Value :&nbsp; 
                                 </td>
                                 <td  class="text-right">
                                    <b> {{AmountFormat( $order_products_summery['taxable_value'] ) }}</b>
                                 </td>
                              </tr>
							  
							  
							  <tr>
                                 <td colspan="8" class="text-right">
                                     GST :&nbsp; 
                                 </td>
                                 <td  class="text-right">
                                    <b> {{AmountFormat($order_products_summery['total_product_gst_amount']) }} </b>
                                 </td>
                              </tr>
                              
                              <?php /*
                                 @if(!empty($orderDetails['order_discount']))
                                 <tr>
                                                         <td colspan="10" class="text-right">
                                                            Order Discount  ({{ $orderDetails['order_discount_percentage'] }}%)
                                 
                                                         </td>
                                 <td  class="text-right">
                                    <b> {{AmountFormat($orderDetails['order_discount']) }} </b>
                                 </td>
                                                      </tr>
                                 @endif
                                 
                                 <tr>
                                                         <td colspan="10" class="text-right">
                                                            Coupon Discount  : 
                                                            
                                                         </td>
                                 <td  class="text-right">
                                    <b> {{ AmountFormat($orderDetails['coupon_discount']-$orderDetails['prepaid_discount'])  }} </b>
                                 </td>
                                                      </tr>  */ ?>
                            
                              @if(!empty($orderDetails['shipping_charges']))
                              <tr>
                                 <td colspan="8" class="text-right">
                                    Shipping Charges:&nbsp;  
                                    <br>(Including {{ $shipping_gst }}% GST) : <b> 
                                 </td>
                                 <td  class="text-right">
                                    <b> {{AmountFormat($orderDetails['shipping_charges']) }} </b>
                                 </td>
                              </tr>
                              @endif
							  
							   @if(!empty($orderDetails['prepaid_discount'])) 
							  <tr>
                                
                                 <td colspan="8" class="text-right">
                                    Prepaid Discount  :&nbsp;   
                                 </td>
                                 <td  class="text-right">
                                    <strong>  {{AmountFormat($orderDetails['prepaid_discount'])}}</strong> 
                                 </td>
                              </tr>
							  
							   @endif
							   
							   
							   
							   @if(isset($order_products_summery['round_of']) && !empty($order_products_summery['round_of']))
								

                                   <tr>
                                
										 <td colspan="8" class="text-right">
											<strong>Total</strong>  : 
										 </td>
										 <td  class="text-right">
											<strong>  {{AmountFormat($orderDetails['grand_total_without_round_of'])}}</strong> 
										 </td>
                                  </tr>


                                 <tr>
                                
										 <td colspan="8" class="text-right">
											<strong>Round of</strong>  : 
										 </td>
										 <td  class="text-right">
											<strong>  {{ $order_products_summery['round_of']   }}</strong> 
										 </td>
                                  </tr>

							
							   @endif
							   
							   
							   
							   @if(!empty($orderDetails['amount_redeemed']))
							  <tr>
                                
                                 <td colspan="8" class="text-right">
                                    <strong>Amount Redeemed  </strong>  : 
									<br><small style="font-weight: 100;font-size: 0.875em;">(by {{ $orderDetails['points_redeemed'] }} Points)</small>							
                                 </td>
                                 <td  class="text-right">
                                    <strong> {{ AmountFormat($orderDetails['amount_redeemed']) }} </strong>
											
                                 </td>
                              </tr>
							  @endif
                              <tr>
                                
                                 <td colspan="8" class="text-right">
                                    <strong>Grand Total</strong>  : 
                                 </td>
                                 <td  class="text-right">
                                    <strong>  {{AmountFormat($orderDetails['grand_total'])}}</strong> 
                                 </td>
                              </tr>
							  
							  
							  @if(!empty($orderDetails['coupon_code']))
							   <tr>
                                 <td colspan="3" class="text-right">
                                    Applied Coupon Code: 
                                 </td>
                                 <td  colspan="6" class="text-left">
                                    <b> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $orderDetails['coupon_code'] }} </b> 
                                 </td>
                              </tr>
							  @endif
                              <tr>
                                 <td colspan="3" class="text-right">
                                    Payment Method: 
                                 </td>
                                 <td  colspan="6" class="text-left">
                                    <b> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ ucfirst(CustomFunction::get_payment_method($orderDetails['payment_method'])) }} </b> 
                                 </td>
                              </tr>
                              <tr>
                                 <td colspan="3" class="text-right">
                                    Comments:  
                                 </td>
                                 <td  colspan="6" class="text-left">
                                    <b> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{$orderDetails['comments']}} </b> 
                                 </td>
                              </tr>
                           </table>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="row">
               <div class="orderStatus">
                  <div class="col-md-12">
                     <div class="portlet blue-hoki box">
                        <div class="portlet-title">
                           <div class="caption">
                              <i class="fa fa-cogs"></i>Order Status
                           </div>
                        </div>
                        <div class="portlet-body">
                           <form method="post" id="update-order-status" class="form-horizontal" role="form" autocomplete="off" action="javascript:;">
                              @csrf
                              <div id="order_result_message"></div>
                              <div class="form-body">
                                 <div class="form-group">
                                    <label class="col-md-3 control-label">Current Status</label>
                                    <div class="col-md-9" style="margin-top: 10px;">
                                       {{ $orderDetails['order_status'] }}
                                    </div>
                                 </div>
                                 <div class="form-group">
                                    <label class="col-md-3 control-label">Select Status</label>
                                    <div class="col-md-9">
                                       <select id="OrderStatus" name="status" class="form-control input-sm" required>
                                          <option value="">Please Select</option>
                                          @foreach($getorderstatus as $ostatus)
                                          <option value="{{$ostatus['name']}}">{{$ostatus['name']}}</option>
                                          @endforeach
                                       </select>
                                    </div>
                                 </div>
								  <div class="form-group" id="weight" style="display: none;">
                                    <label class="col-md-3 control-label">Weight (optional)</label>
                                    <div class="col-md-9">
                                       <input type="number" name="weight" placeholder="Weight" class="form-control" value="{{ $orderDetails['weight'] }}">
                                    </div>
                                 </div>
                                 <div class="form-group" id="InvoiceNo" style="display: none;">
                                    <label class="col-md-3 control-label">Invoice No.</label>
                                    <div class="col-md-9">
                                       <input type="text" name="invoice_no" placeholder="Invoice No" class="form-control" >
                                    </div>
                                 </div>
                                 <div class="form-group">
                                    <label class="col-md-3 control-label">Comments </label>
                                    <div class="col-md-9">
                                       <textarea placeholder="Enter Comments here..." name="comments" id="comments" class="form-control" rows="3" cols="4"></textarea>
                                    </div>
                                 </div>
                                 <div class="form-group" style="display:none">
                                    <div class="col-md-3"> 
                                    </div>
                                    <div class="col-md-1">
                                       <input type="checkbox" name="send_mail" class="form-control" value="1" style="width:23px" checked>
                                    </div>
                                    <div class="col-md-4">
                                       <label class="control-label">Send mail to customer </label>
                                    </div>
                                 </div>
                              </div>
                              <div class="form-actions text-center">
                                 <button type="submit" class="btn green">Submit</button>
                              </div>
                           </form>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="row">
               <div id="orderHistory">
                  @include('admin.orders.popup.order-history') 
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<script>
   $("#OrderStatus").change(function(e){  
        var status = $(this).val();
		if(status == 'Shipped'){
			$('#weight').show();
		}else{
			$('#weight').hide();
		}
   });
   $("#update-order-status").submit(function(e){ 
   		 if(confirm('Are you sure you want to change the order status?') ){
   			$.ajax({
   				url: '@php echo url('admin/update-order-status').'/'.$orderDetails['id']; @endphp',
   				type:'POST',
   				data: $("#update-order-status").serialize(),
   				success: function(data) {
   					if(!data.status){
   								$('#order_result_message').attr('style', 'color:red');
   								$('#order_result_message').html('<h3>'+data.message+'</h3>');  
   								
   								setTimeout(function () {
   									$('#order_result_message').css({
   										'display': 'none'
   									});
   								}, 3000); 
   					}else{     
   								$('#order_result_message').attr('style', 'color:green');
   								$('#order_result_message').html('<h3>'+data.message+'</h3>');
   								$('#orderHistory').html(data.order_histories); 
   								 $("#update-order-status")[0].reset();
   								setTimeout(function () {
   									$('#order_result_message').css({
   										'display': 'none'
   									});
   								}, 3000); 
   					}
   				}
   			});
   	 }
       });	
</script>
@stop