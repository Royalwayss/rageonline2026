@extends('layouts.frontLayout.front-layout')
@section('content')
<?php 
   $sizeArr=[]; ?>
<main>
   <div class="container">
      <div class="row">
         <div class="col-12">
            <?php 
               use App\ExchangeRequest;
               use App\Order;
               use App\Product;
               use App\OrderProduct;
               use App\CustomFunction;
               use App\ReturnRequest;
               ?>
            <!-- Order Detail Page Html Starts -->
            @if(Session::has('flash_message_error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
               <strong>Error! </strong> {!! session('flash_message_error') !!}
               <button type="button" class="close" data-dismiss="alert" aria-label="Close">
               <span aria-hidden="true">&times;</span>
               </button>
            </div>
            @endif
            @if(Session::has('flash_message_success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
               <strong>Success! </strong> {!! session('flash_message_success') !!}
               <button type="button" class="close" data-dismiss="alert" aria-label="Close">
               <span aria-hidden="true">&times;</span>
               </button>
            </div>
            @endif
            @if(isset($_GET['order_id']) && !empty($_GET['order_id']))
            @else
            <div class="row accTabsInfo OrderView">
               <div class="col-12">
                  <a class="View-BackBtn" href="{{ url('account/orders') }}"> Back </a>
               </div>
               <div class="col-12">
                  <h4 class="booster-font">Order ID - {{ $order->id }} </h4>
               </div>
               <div class="col-sm-12 col-12 mt-1">
                  <?php 
                     if($order->payment_method == 'bank_deposit') { $payment_method = 'Bank deposit'; }  else { $payment_method = $order->payment_method;  }
                     
                     
                     if(@$order->order_address->shipping_state =='Punjab'){
                     $own_state = 'yes';
                     }else{
                     $own_state = 'no';
                     }
                     $total_gst_ = 0;
                     
                     ?>
                  <div class="row">
                     <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 no-pd">
                        <div id="no-more-tables">
                           <p><strong>Payment Method: </strong>{{
                              CustomFunction::get_payment_method($order->payment_method) }}
                           <p>
                           <p><strong>Order Date: </strong>{{date('d F Y h:ia',strtotime($order->created_at))}}
                           </p>
                           <div class="table-responsive">
                              <table class="table-bordered cf no-pd table table-bordered">
                                 <thead class="cf">
                                    <tr>
                                        <th></th>
                                       <th style="width:20%">Product Details</th>
                                       <th>MRP</th>
                                       <th>DIS</th>
                                       <th>UNIT PRICE</th>
                                       <th>TAXABLE VALUE</th>
                                       <th>GST</th>
                                       <th>QTY</th>
                                       <th>TOTAL</th>
									  
                                    </tr>
                                 </thead>
                                 <?php 
                                    $order_products_summery = order_products_summery($order);
                                    
                                    
                                                             
                                    $product_gst_array = $priceArr = array();
                                                                                 $total_gst_ = 0; 					 
                                                             ?>
                                 @foreach($order_products_summery['products'] as $order_product_summery)
                                 <?php  
                                    $priceArr[] = $order_product_summery['subtotal'];
                                    $sizeArr[] = $order_product_summery['product_size'];
                                    
                                    
                                    $product_gst_array[] = $order_product_summery['product_gst'];
                                    $unit_price = $order_product_summery['subtotal']/$order_product_summery['product_qty'];
                                    ?>
                                 <tr>
                                    <td data-title="Product Action">
                                       <?php 
                                          $check_returnrequest =  ReturnRequest::where('order_product_id',$order_product_summery['id'])->first();
                                          
                                          if(!empty($check_returnrequest)){
                                           
                                           echo $check_returnrequest->action.' Request Status:<br> ';
                                           
                                           if(empty($check_returnrequest->reply_status)){
                                          	 echo '<span style="color:green">Request in processing</span>';
                                           }else{
                                          	 $reply_status = $check_returnrequest->reply_status;
                                          	 
                                          	 if($reply_status == 'Request Rejected'){
                                                      echo '<span style="color:red">'.$reply_status.'</span>';
                                          	 }else{
                                          		      echo '<span style="color:green">'.$reply_status.'</span>';
                                          	 }
                                          	 
                                          
                                           }
                                           
                                           
                                          }
                                           
                                           
                                            
                                           
                                           ?>
                                    </td>
                                    
									<td data-title="Product name">
                                       <a
                                          href="{{ $order_product_summery['product_link'] }}">
                                       @if(isset($order_product_summery['image']))
                                       <img style="border:0px;"
                                          src="{{ asset('images/ProductImages/medium/'.$order_product_summery['image']) }}"
                                          height="50px" width="50px">
                                       @else
                                       <img style="border:0px;"
                                          src="{{asset('images/no-image-found.jpg')}}" height="50px"
                                          width="50px">
                                       @endif
                                       </a> 
                                       <a target="_block" style="color:#9d3d49"
                                          href="{{ $order_product_summery['product_link'] }}">{{
                                       $order_product_summery['product_name'] }}</a>
                                       <b><br>Code</b>: {{ $order_product_summery['product_code'] }}
                                       <b><br>Category</b>: {{ $order_product_summery['category_name'] }}
                                       <b><br>Sku</b>: {{ $order_product_summery['product_sku'] }}
                                       <b><br>Size</b>: {{ $order_product_summery['product_size'] }}
                                    </td>
                                    <td data-title=" ">{{ AmountFormat($order_product_summery['mrp']) }}</td>
                                    <td data-title=" ">{{ AmountFormat($order_product_summery['product_discount']) }}</td>
                                    <td data-title=" ">{{ AmountFormat($order_product_summery['unit_price']) }}</td>
                                    <td data-title=" ">{{ AmountFormat($order_product_summery['taxable_value']) }}</td>
                                    <td data-title="">
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
                                    <td data-title="Unit Price">
                                       {{ AmountFormat($order_product_summery['product_qty']) }}
                                    </td>
                                  
                                    <td data-title="Sub Total Price">
                                       {{ AmountFormat($order_product_summery['sub_total']) }}
                                    </td>
									
                                 </tr>
                                 @endforeach
                                 <?php 
								    $grandtotal = array_sum($priceArr);
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
                                    
                                    if(!empty($order['shipping_charges'])){
                                    	
                                    	$igstcalculate = igstcalculate($order['shipping_charges'],$shipping_gst);
                                        $shipping_gst_amt = round($igstcalculate);
                                        $shipping_charges = AmountFormat($order['shipping_charges']);
                                    }
                                    
                                    
                                    
                                    ?>
                                 <tr>
                                    <td data-title="Sub Total :" align="right" valign="top" colspan="10"><b
                                       class="visible-lg visible-md visible-sm">Total Amount
                                       :&nbsp;</b><span>
                                       {{ AmountFormat($order_products_summery['total_amount']) }} </span>
                                    </td>
                                 </tr>
								 
								 
								 @if(!empty($order_products_summery['discount']))
								 
								 <tr>
                                    <td data-title="Sub Total :" align="right" valign="top" colspan="10"><b
                                       class="visible-lg visible-md visible-sm">Discount
                                       :&nbsp;</b><span>
                                       {{ AmountFormat($order_products_summery['discount']) }} </span>
                                    </td>
                                 </tr>
								 @endif 
								 
								 
								
								 
								 
								 
                                 <tr>
                                    <td data-title="Sub Total :" align="right" valign="top" colspan="10"><b
                                       class="visible-lg visible-md visible-sm">Subtotal
                                       :&nbsp;</b><span>
                                       {{AmountFormat( $order_products_summery['subtotal'] ) }} </span>
                                    </td>
                                 </tr>
								 
								 
								  <tr>
                                    <td data-title="Sub Total :" align="right" valign="top" colspan="10"><b
                                       class="visible-lg visible-md visible-sm">Taxable Value
                                       :&nbsp;</b><span>
                                       {{AmountFormat( $order_products_summery['taxable_value'] ) }} </span>
                                    </td>
                                 </tr>
								 
								  <tr>
                                    <td data-title="Sub Total :" align="right" valign="top" colspan="10"><b
                                       class="visible-lg visible-md visible-sm">GST
                                       :&nbsp;</b><span>
                                       {{ AmountFormat( $order_products_summery['total_product_gst_amount'] + $shipping_gst_amt)  }} </span>
                                    </td>
                                 </tr>
								 
								 
								 
                                 @if(!empty($order->shipping_charges))
                                 <tr>
                                    <td data-title="Discount :" align="right" valign="top" colspan="10"><b
                                       class="visible-lg visible-md visible-sm">Shipping Amount  :&nbsp;</b>
                                       <span>  {{ AmountFormat($order->shipping_charges) }} </span>
                                       <br><small style="font-weight: 100;font-size: 0.875em;">(Including {{ $shipping_gst }}% GST)</small>
                                    </td>
                                 </tr>
                                 @endif
                                 <?php /* ?>
                                 @if(!empty($order->order_discount))
                                 <tr>
                                    <td data-title="Sub Total :" align="right" valign="top" colspan="10"><b
                                       class="visible-lg visible-md visible-sm">Order Discount ({{ $order->order_discount_percentage }}%) 
                                       :&nbsp;</b><span>
                                       {{AmountFormat($order->order_discount) }} </span>
                                    </td>
                                 </tr>
                                 @endif
                                 <tr>
                                    <td data-title="Discount :" align="right" valign="top" colspan="10"><b
                                       class="visible-lg visible-md visible-sm">Coupon Discount :&nbsp;</b>
                                       <span>  {{ AmountFormat($order->coupon_discount-$order->prepaid_discount) }} </span>
                                    </td>
                                 </tr>
                                 <?php */ ?>
                                 @if(!empty($order->prepaid_discount))
                                 <tr>
                                    <td data-title="Discount :" align="right" valign="top" colspan="10"><b
                                       class="visible-lg visible-md visible-sm">Prepaid Discount(5%) :&nbsp;</b>
                                       <span>  {{ AmountFormat($order->prepaid_discount) }} </span>
                                    </td>
                                 </tr>
                                 @endif
								 
								 
								 
								  @if(!empty($order->amount_redeemed))
                                 <tr>
                                    <td data-title="Discount :" align="right" valign="top" colspan="10"><b
                                       class="visible-lg visible-md visible-sm">Amount Redeemed  :&nbsp;</b>
                                       <span>  {{ AmountFormat($order->amount_redeemed) }} </span>
                                       <br><small style="font-weight: 100;font-size: 0.875em;">(by {{ $order->points_redeemed }} Points)</small>
                                    </td>
                                 </tr>
                                 @endif
								 
								 
								 
								 
								 
								 
								 
								  @if(isset($order_products_summery['round_of']) && !empty($order_products_summery['round_of']))
									
								 <tr>
                                    <td data-title="Discount :" align="right" valign="top" colspan="10"><b
                                       class="visible-lg visible-md visible-sm">Total :&nbsp;</b>
                                       <span>  {{ AmountFormat($order->grand_total_without_round_of) }} </span>
                                    </td>
                                 </tr>
								 
								  <tr>
                                    <td data-title="Discount :" align="right" valign="top" colspan="10"><b
                                       class="visible-lg visible-md visible-sm">Round Of :&nbsp;</b>
                                       <span>  {{ $order_products_summery['round_of'] }} </span>
                                    </td>
                                 </tr>
                                 @endif
								 
								 
								 
								 
                                 <tr>
                                    <td align="left" valign="top" colspan="5">
									@if(!empty($order->coupon_code))
									 
                                       <span class="visible-lg visible-md visible-sm">Applied Coupon Code :&nbsp;</span>
                                       <span>  {{ $order->coupon_code }} </span>
									   @endif
                                    </td>
									<td data-title="Grand Total :" align="right" valign="top" colspan="5"><b
                                       class="visible-lg visible-md visible-sm">Grand Total :&nbsp;</b>
                                       <span>  {{AmountFormat($order->grand_total)}} </span>
                                    </td>
                                 </tr>
                                 <tr class="visible-lg visible-md">
                                    <th colspan="4">
                                       <h5 class="bold">Billing Address</h5>
                                    </th>
                                    <th colspan="5">
                                       <h5 class="bold">Shipping Address</h5>
                                    </th>
                                 </tr>
                                 <tr>
                                    <td colspan="4" data-title="Invoice Address"
                                       style="background-color:white">
                                       <table class="table-responsive">
                                          <tr>
                                             <td ><b>Name:&nbsp;</b></td>
                                             <td>{{ @$order->order_address->billing_name }} </td>
                                          </tr>
                                          <tr>
                                             <td><b>Mobile:&nbsp;</b></td>
                                             <td>{{ @$order->order_address->billing_mobile }} </td>
                                          </tr>
                                          <tr>
                                             <td><b>Alternative Mobile:&nbsp;</b></td>
                                             <td>{{ @$order->order_address->billing_alternative_number }}
                                             </td>
                                          </tr>
                                          <tr>
                                             <td><b>Address:&nbsp;</b></td>
                                             <td>{{ @$order->order_address->billing_address }} </td>
                                          </tr>
                                          <tr>
                                             <td><b>Postcode:&nbsp;</b></td>
                                             <td>{{ @$order->order_address->billing_postcode }} </td>
                                          </tr>
                                          <tr>
                                             <td><b>City:&nbsp;</b></td>
                                             <td>{{ @$order->order_address->billing_city }} </td>
                                          </tr>
                                          <tr>
                                             <td><b>Statte:&nbsp;</b></td>
                                             <td>{{ @$order->order_address->billing_state }} </td>
                                          </tr>
                                          <tr>
                                             <td><b>Country:&nbsp;</b></td>
                                             <td>{{ @$order->order_address->billing_country }} </td>
                                          </tr>
                                       </table>
                                    </td>
                                    <td colspan="5" data-title="Invoice Address"
                                       style="background-color:white">
                                       <table class="table-responsive">
                                          <tr>
                                             <td style="width:60%"><b>Name:&nbsp;</b></td>
                                             <td>{{ @$order->order_address->shipping_name }} </td>
                                          </tr>
                                          <tr>
                                             <td><b>Mobile:&nbsp;</b></td>
                                             <td>{{ @$order->order_address->shipping_mobile }} </td>
                                          </tr>
                                          <tr>
                                             <td><b>Alternative Mobile:&nbsp;</b></td>
                                             <td>{{ @$order->order_address->shipping_alternative_number }}
                                             </td>
                                          </tr>
                                          <tr>
                                             <td><b>Address:&nbsp;</b></td>
                                             <td>{{ @$order->order_address->shipping_address }} </td>
                                          </tr>
                                          <tr>
                                             <td><b>Postcode:&nbsp;</b></td>
                                             <td>{{ @$order->order_address->shipping_postcode }} </td>
                                          </tr>
                                          <tr>
                                             <td><b>City:&nbsp;</b></td>
                                             <td>{{ @$order->order_address->shipping_city }} </td>
                                          </tr>
                                          <tr>
                                             <td><b>State</b></td>
                                             <td>{{ @$order->order_address->shipping_state }} </td>
                                          </tr>
                                          <tr>
                                             <td><b>Country:&nbsp;</b></td>
                                             <td>{{ @$order->order_address->shipping_country }} </td>
                                          </tr>
                                       </table>
                                    </td>
                                 </tr>
                              </table>
                           </div>
                        </div>
                     </div>
                     <div class="clearfix"></div>
                  </div>
               </div>
            </div>
            @endif
            <div class="modal " id="returnItem">
               <div class="modal-dialog">
                  <div class="modal-content">
                     <!-- Modal Header -->
                     <div class="modal-header">
                        <h4 class="modal-title">Exchange Item</h4>
                        <button type="button" style="border: transparent; background-color:transparent;"
                           data-dismiss="alert" aria-label="Close" class="close"><span
                           class="fas fa-times"></span></button>
                     </div>
                     <form method="post" action="{{url('/return-order-item')}}" id="return-form"
                        enctype="multipart/form-data">
                        @csrf
                        <!-- Modal body -->
                        <div class="modal-body">
                           <div class="container">
                              <div class="row">
                                 <div class="col">
                                    <label for="return_reason" class="col-form-label">Reason for
                                    Exchange:</label>
                                    <select name="return_reason" class="form-control return_items" required>
                                       <option value="">Please Select</option>
                                       <option value="Incorrect product received">Incorrect product
                                          received
                                       </option>
                                       <option value="Received product is defective">Received product is
                                          defective
                                       </option>
                                       <option value="A Part of the product is missing">A Part of the
                                          product is missing
                                       </option>
                                       <option value="Wrong size received">Wrong size received</option>
                                       <option value="Size Issue">Size Issue</option>
                                       <option value="Others">Others</option>
                                    </select>
                                 </div>
                              </div>
                              <div class="row">
                                 <div class="col">
                                    <label for="message-text" class="col-form-label">Required Size:</label>
                                    <input name="required_size" placeholder="Size" class="form-control"
                                       required>
                                 </div>
                              </div>
                              <div class="row">
                                 <div class="col">
                                    <label for="message-text" class="col-form-label">Comments:</label>
                                    <input type="hidden" name="order_product_id">
                                    <input type="hidden" name="sku">
                                    <textarea name="reason" placeholder="Comments"
                                       class="form-control return_items" id="message-text"
                                       required></textarea>
                                 </div>
                              </div>
                              <div class="row">
                                 <div class="col">
                                    <label for="exampleFormControlFile1">Choose file (if any)</label>
                                    <input type="file" class="form-control-file return_items"
                                       id="exampleFormControlFile1" name="file">
                                    <span style="color:red">Note:-Max file size is 2MB</span>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <!-- Modal footer -->
                        <div class="modal-footer">
                           <button type="submit" class="btn btn-success"
                              style="background-color: #28a745;color:white">Submit</button>
                           <button type="button" class="close btn btn-danger"
                              style="background-color: #dc3545;color:white" data-dismiss="alert"
                              aria-label="Close"> Close</button>
                        </div>
                  </div>
                  </form>
               </div>
            </div>
         </div>
         @section('javascript')
         @parent
         <script type="text/javascript" src="{{ asset('js/ajax_jquery.min.js')}}"></script>
         <script type="text/javascript">
            $(document).ready(function() {
                $(document).on('click', '.returnItem', function() {
                    var orderproid = $(this).data('orderproid');
                    var sku = $(this).data('sku');
                    $('[name=sku]').val(sku);
                    $('[name=order_product_id]').val(orderproid);
                    $('#returnItem').modal('show');
                })
            })
            
            
            $(document).on('click', '.close', function() {
                $("#returnItem").modal('hide');
            });
            
            
            $(document).on('click', '.triggerOrderDetails', function() {
            
                $(".collapse").css("display", "block");
            });
            $(document).ready(function() {
            
                /*$.validator.addMethod('filesize', function (value, element, arg) {
                    var minsize=1000; // min 1kb
                    if(element.files[0].size<=arg){
                        return true;
                    }else{
                        return false;
                    }
                });  */
                $('#return-form').validate({ // initialize the plugin
                    rules: {
                        return_reason: {
                            required: true
                        }
            
                    }
                });
            
            });
         </script>
         @stop
      </div>
   </div>
</main>
@stop
<style></style>