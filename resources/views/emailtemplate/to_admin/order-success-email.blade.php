<?php 
   Use App\CustomFunction;
   $payment_method = CustomFunction::get_payment_method($orderDetails['payment_method']); 
   if($orderDetails['order_address']['shipping_state'] =='Punjab'){
   	  $own_state = 'yes';
   }else{
   	  $own_state = 'no';
   }
   $total_gst_ = 0;
    
   ?>
<html>
   <head>
      <style type='text/css'>
         <!--
            .style2 {
            font-size: 11px;
            font-weight: bold;
            text-decoration: none;
            font-family: Verdana, Arial, Helvetica, sans-serif;
            color:#666666;
            }
            .style3 {
            text-decoration: none;
            font-family: Verdana, Arial, Helvetica, sans-serif;
            font-size: 11px;
            color:#666666;
            }
            -->
      </style>
   </head>
   <body>
      <table width='700' border='0' cellpadding='0' cellspacing='0'  style='border:#EFEFEF 5px solid; padding:5px;'>
         <tr>
            <td colspan='3'></td>
         </tr>
         <tr>
            <td  align='center' valign='middle'>
               <img border='0' src="{{ config('constants.site_logo') }}"  />
               <hr>
            </td>
         </tr>
         <tr>
            <td height='70' align='right' valign='top'>
               <table width='93%' border='0' align='right' cellpadding='3' cellspacing='0' >
                  <tr>
                     <td align='left' valign='top' class='style3'><span class='style2'>Order Date :</span>{{date('l,F d Y h:ia',strtotime($orderDetails['created_at']))}}</td>
                  </tr>
                  <tr>
                     <td align='left' valign='top' class='style3'>&nbsp;</td>
                  </tr>
                  <tr>
                     <td align='left' valign='top' class='style3'>Hi  Admin, New order has been placed at {{ config('constants.website_url') }}
                  </tr>
                  <tr>
                     <td align='left' valign='top' class='style3'>&nbsp;</td>
                  </tr>
                  <tr>
                     <td align='left' valign='top' class='style3'><span class='style2'>Payment Method</span> :{{ ucfirst(CustomFunction::get_payment_method($orderDetails['payment_method'])) }} </td>
                  </tr>
                  <tr>
                     <td align='left' valign='top' class='style3'>&nbsp;</td>
                  </tr>
                   <td align='left' valign='top' class='style3'><span class='style2'>Order No</span> :{{ $orderDetails['id'] }} </td>
                  </tr>
                  <tr>
                     <td align='left' valign='top' class='style3'>&nbsp;</td>
                  </tr>
                  <tr>
                     <td align='left' valign='top' class='style3'>
                        <table width='95%' border='0' align='left' cellpadding='3' cellspacing='1' bgcolor='ACA899'>
                           <tr>
                              <td width='30%' align='center' valign='top' class='style2' bgcolor='#cccccc'>Product Details</td>
                              <td width='10%' align='center' valign='top' class='style2' bgcolor='#cccccc'>MRP</td>
                              <td width='5%' align='center' valign='top' class='style2' bgcolor='#cccccc'>DIS</td>
                              <td width='15%' align='right' valign='top' class='style2' bgcolor='#cccccc'>Unit Price</td>
                              <td width='15%' align='right' valign='top' class='style2' bgcolor='#cccccc' style="text-align: center;">Taxable Value</td>
                              <td width='30%' align='center' valign='top' class='style2' bgcolor='#cccccc'>GST</td>
                              <td width='5%' align='center' valign='top' class='style2' bgcolor='#cccccc'>QTY</td>
                              <td width='10%' align='right' valign='top' class='style2' bgcolor='#cccccc'>Sub Total</td>
                           </tr>
                           <?php   $order_products_summery = order_products_summery($orderDetails); ?>
                           @foreach($order_products_summery['products'] as $order_product_summery)
                           <tr style="text-align:center">
                              <td align='center' valign='top' class='style3' bgcolor='#F7F7F7'>
                                 <a style="text-decoration: none;"  target="_block" href="{{ $order_product_summery['product_link'] }}">
                                 @if(!empty($order_product_summery['image']))
                                 <img src="{{asset('images/ProductImages/small/'.$order_product_summery['image'])}}" class="attachment-rage_thumbnail size-rage_thumbnail"
                                    alt="img" width="50" height="50" style="margin:10px;">
                                 @else
                                 <img src="{{asset('images/no-image-found.jpg')}}"  alt="img" width="50" height="50"  class="img-fluid" style="margin:10px;"  />
                                 @endif
                                 </a>
                                 <br>
                                 <?php
                                    $product_gst_array[] = $order_product_summery['product_gst'];
                                    
                                    ?>
                                 <a style="text-decoration: none;"  target="_block" href="{{ $order_product_summery['product_link'] }}">{{ $order_product_summery['product_name'] }} </a>
                                 <p>Category: {{ $order_product_summery['category_name'] }} </p>
                                 <p>Size: {{ $order_product_summery['product_size'] }} </p>
                                 <p>Color: {{ $order_product_summery['productcolor'] }} </p>
                                 <p>Sku: {{ $order_product_summery['product_sku'] }} </p>
                              </td>
                              <td align='center' valign='top' class='style3' bgcolor='#F7F7F7'>{{ AmountFormat($order_product_summery['mrp']) }}</td>
                              <td align='center' valign='top' class='style3' bgcolor='#F7F7F7'>{{ AmountFormat($order_product_summery['product_discount']) }}</td>
                              <td align='center' valign='top' class='style3' bgcolor='#F7F7F7'>{{ AmountFormat($order_product_summery['unit_price']) }}</td>
                              <td align='center' valign='top' class='style3' bgcolor='#F7F7F7'>{{ AmountFormat($order_product_summery['taxable_value']) }}</td>
                              <td align='center' valign='top' class='style3' bgcolor='#F7F7F7'>
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
                              <td align='center' valign='top' class='style3' bgcolor='#F7F7F7'>{{ $order_product_summery['product_qty'] }}</td>
                              <td align='right' valign='top' class='style3' bgcolor='#F7F7F7'>{{ AmountFormat($order_product_summery['sub_total'])}}</td>
                           </tr>
                           @endforeach
                           <?php 
                              $shipping_gst = '0';
                              $shipping_charges = '0';
                              $shipping_gst_amt = '0';
                              if(!empty($product_gst_array)){
                              	
                              	if(in_array('12',$product_gst_array)){
                              		$shipping_gst = '12';
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
                              <td align='right' valign='top' class='style3' bgcolor='#F7F7F7' colspan='7'><strong>Total Amount:</strong></td>
                              <td align='right' valign='top' class='style3' bgcolor='#F7F7F7'>{{AmountFormat($order_products_summery['total_amount'])}}</td>
                           </tr>
                           
						    @if(!empty($order_products_summery['discount']))
								<tr>
                              <td align='right' valign='top' class='style3' bgcolor='#F7F7F7' colspan='7'><strong>Discount:</strong></td>
                              <td align='right' valign='top' class='style3' bgcolor='#F7F7F7'>{{AmountFormat($order_products_summery['discount'])}}</td>
                           </tr>
						    @endif 
						   
						   <tr>
                              <td align='right' valign='top' class='style3' bgcolor='#F7F7F7' colspan='7'><strong>
                                 Subtotal:
                                 </strong>
                              </td>
                              <td align='right' valign='top' class='style3' bgcolor='#F7F7F7'>{{ AmountFormat($order_products_summery['subtotal']) }}</td>
                           </tr>
                           
						  <tr>
                              <td align='right' valign='top' class='style3' bgcolor='#F7F7F7' colspan='7'><strong>
                                 Taxable Value:
                                 </strong>
                              </td>
                              <td align='right' valign='top' class='style3' bgcolor='#F7F7F7'>{{ AmountFormat($order_products_summery['taxable_value']) }}</td>
                           </tr>
                            
							
							<tr>
                              <td align='right' valign='top' class='style3' bgcolor='#F7F7F7' colspan='7'><strong>
                                 GST:
                                 </strong>
                              </td>
                              <td align='right' valign='top' class='style3' bgcolor='#F7F7F7'>{{ AmountFormat($order_products_summery['total_product_gst_amount'] + $shipping_gst_amt) }}</td>
                           </tr>
						   
						   
						   
						    
						   
						   
						   
						   
						   @if(!empty($orderDetails['shipping_charges']))					
                           <tr>
                              <td align='right' valign='top' class='style3' bgcolor='#F7F7F7' colspan='7'><strong>
                                 Shipping Amount:</strong><span> (Including  {{ $shipping_gst }}% GST) </span>
                              </td>
                              <td align='right' valign='top' class='style3' bgcolor='#F7F7F7'>{{AmountFormat($orderDetails['shipping_charges'])}}</td>
                           </tr>
                           @endif
                           @if(!empty($orderDetails['prepaid_discount']))
                           <tr>
                              <td align='right' valign='top' class='style3' bgcolor='#F7F7F7' colspan='7'><strong>
                                 Prepaid Discount (5%):
                                 </strong>
                              </td>
                              <td align='right' valign='top' class='style3' bgcolor='#F7F7F7'>{{AmountFormat($orderDetails['prepaid_discount'])}}</td>
                           </tr>
                           @endif
						   
						   @if(isset($order_products_summery['round_of']) && !empty($order_products_summery['round_of']))
							  <tr>
								  <td align='right' valign='top' class='style3' bgcolor='#F7F7F7' colspan='7'><strong>
									 Total:
									 </strong>
								  </td>
								  <td align='right' valign='top' class='style3' bgcolor='#F7F7F7'>{{AmountFormat($orderDetails['grand_total_without_round_of'])}}</td>
                             </tr>
							 
							   <tr>
								  <td align='right' valign='top' class='style3' bgcolor='#F7F7F7' colspan='7'><strong>
									 Round Of:
									 </strong>
								  </td>
								  <td align='right' valign='top' class='style3' bgcolor='#F7F7F7'>{{ $order_products_summery['round_of'] }}</td>
                             </tr>
						
						    @endif
						   
						   
						   
                           <tr>
                              <td colspan='3' align='right' valign='top' class='style3' bgcolor='#F7F7F7'>
							  @if(!empty($orderDetails['coupon_code']))
							  Applied Coupon Code :  <strong>{{ $orderDetails['coupon_code'] }}</strong>	
							  @endif
							  </td>
                              <td colspan='4' align='right' valign='top' class='style3' bgcolor='#F7F7F7'><strong> Grand total</strong> (<span>including all taxes and shipping</span>) </td>
                              <td align='right' valign='top' class='style3' bgcolor='#F7F7F7'>{{AmountFormat($orderDetails['grand_total'])}}</td>
                           </tr>
                        </table>
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <table width='100%'>
                           <tr>
                              <td width='50%'>
                                 <table width='100%' border='0' align='left' cellpadding='3' cellspacing='0'>
                                    <tr class='shop'>
                                       <td colspan='2' align='left' valign='middle' class='style3' ><span class='top_text1'><strong>Bill To: -</strong></span></td>
                                    </tr>
                                    <tr>
                                       <td colspan='2' align='left' valign='middle' class='style3'>{{ $orderDetails['order_address']['billing_name'] }}</td>
                                    </tr>
                                    <tr>
                                       <td colspan='2' align='left' valign='middle' class='style3'>{{ $orderDetails['order_address']['billing_address'] }}</td>
                                    </tr>
                                    <tr>
                                       <td colspan='2' align='left' valign='middle' class='style3'>{{ $orderDetails['order_address']['billing_city'] }}</td>
                                    </tr>
                                    <tr>
                                       <td colspan='2' align='left' valign='middle' class='style3'>{{ $orderDetails['order_address']['billing_state'] }}</td>
                                    </tr>
                                    <tr>
                                       <td colspan='2' align='left' valign='middle' class='style3'>{{ $orderDetails['order_address']['billing_postcode'] }}</td>
                                    </tr>
                                    <tr>
                                       <td align='left' valign='middle' class='style3'>{{ $orderDetails['order_address']['billing_country'] }}</td>
                                    </tr>
                                    <tr>
                                       <td align='left' valign='middle' class='style3'>{{ $orderDetails['order_address']['billing_mobile'] }}</td>
                                    </tr>
                                    <tr>
                                       <td align='left' valign='middle' class='top_text1'></td>
                                    </tr>
                                 </table>
                              </td>
                              <td width='39%'>
                                 <table width='100%' border='0' align='left' cellpadding='3' cellspacing='0'>
                                    <tr class='shop'>
                                       <td colspan='2' align='left' valign='middle' class='style3' ><span class='top_text1'><strong>Ship To: -</strong></span></td>
                                    </tr>
                                    <tr>
                                       <td colspan='2' align='left' valign='middle' class='style3'>{{ $orderDetails['order_address']['shipping_name'] }}</td>
                                    </tr>
                                    <tr>
                                       <td colspan='2' align='left' valign='middle' class='style3'>{{ $orderDetails['order_address']['shipping_address'] }}</td>
                                    </tr>
                                    <tr>
                                       <td colspan='2' align='left' valign='middle' class='style3'>{{ $orderDetails['order_address']['shipping_city'] }}</td>
                                    </tr>
                                    <tr>
                                       <td colspan='2' align='left' valign='middle' class='style3'>{{ $orderDetails['order_address']['shipping_state'] }}</td>
                                    </tr>
                                    <tr>
                                       <td colspan='2' align='left' valign='middle' class='style3'>{{ $orderDetails['order_address']['shipping_postcode'] }}</td>
                                    </tr>
                                    <tr>
                                       <td align='left' valign='middle' class='style3'>{{ $orderDetails['order_address']['shipping_country'] }}</td>
                                    </tr>
                                    <tr>
                                       <td align='left' valign='middle' class='style3'>{{ $orderDetails['order_address']['shipping_mobile'] }}</td>
                                    </tr>
                                    <tr>
                                       <td align='left' valign='middle' class='top_text1'></td>
                                    </tr>
                                 </table>
                              </td>
                           </tr>
                        </table>
                     </td>
                  </tr>
                  <tr>
                     <td align='left' valign='top' class='style3'>
                        <table width='90%' border='0' align='left' cellpadding='3' cellspacing='0'>
                           <tr>
                           </tr>
                           <tr>
                              <td colspan='3' class='style3'>&nbsp;</td>
                           </tr>
                           <tr>
                              <td colspan='3' class='style3'>&nbsp;</td>
                           </tr>
                           <tr>
                              <td colspan='3' class='style3'>Please keep this email for future reference &amp; don&rsquo;t forget to add us to your favourites to make it easier to come back  and view our latest product range and offers.</td>
                           </tr>
                           <tr>
                              <td colspan='3' class='style3'>&nbsp;</td>
                           </tr>
                           <tr>
                              <td colspan='3' class='style3'>
                                 <div align=\"left\">		
                                    Regards<br />
                                    {{ config('constants.project_name') }}
                                 </div>
                              </td>
                           </tr>
                        </table>
                     </td>
                  </tr>
               </table>
            </td>
         </tr>
      </table>
   </body>
</html>  
