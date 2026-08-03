<?php  use App\CustomFunction;
if($orderDetails['order_address']['shipping_state'] =='Punjab'){
	 $own_state = 'yes';
 }else{
	  $own_state = 'no';
 } ?>
<html>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

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



                @import url('https://fonts.googleapis.com/css2?family=Covered+By+Your+Grace&display=swap');



                .main-table {

                    width: 700px;

                }



                .inner-table {

                    border:1px solid #ddd;

                }

                

                .address-details {

                    width: 48%;

                    border:2px solid #ddd;

                    float: left;

                    margin-right: 1%;

                    margin-bottom: 10px;

                }

                .address-details th {

                    background-color: #979ac6;

                    color: #fff;

                    padding: 5px;

                    text-align: left;

                }



                .address-details2 {

                    width: 97%;

                    border:2px solid #ddd;

                    float: left;

                }

                .address-details2 th {

                    background-color: #979ac6;

                    color: #fff;

                    padding: 5px;

                    text-align: left;

                }



                .purple-bg {

                    background-color: #979ac6;

                    color: #fff;

                }



                .purple-bg .btm-table h3 {

                    font-family: 'Covered By Your Grace', cursive;

                }



                .purple-bg .btm-table td {

                    color: #fff;

                }



               /* .footer-btm {

                    background-color: #43435d;

                    width: 100%;

                    padding: 10px;

                }*/



                /*.footer-btm .footer-btn a {

                    background-color: #ffb8af;

                    color: #43435d;

                    padding: 5px;

                    text-decoration: none;

                }*/

                @media only screen and (max-width: 767px) {

                    .main-table {

                        width: 100%;

                    }

                }

        </style>

    </head>

    <body>

        <table class="main-table" border='0' cellpadding='0' cellspacing='0'  style='border:#ddd 3px dashed; padding:5px;'>

            <tr>

                <td colspan='3'></td>

            </tr>

            <tr>

                <td  align='center' valign='middle'><img border='0' width="100px" src="{{ asset('images/logo-new.png') }}" /></td>

            </tr>

            <tr>

                <td>&nbsp;</td>

            </tr>

            <!--<tr style='background-color:#eee; padding:5px;'>

                <td align='center' valign='middle'><span class="style3">

                    <a target="_blank" href="https://www.facebook.com/MiArcus-112598203878728/"><img border='0' src="{{ asset('images/socials/fb.png') }}" /> </a>

                    <a target="_blank" href="https://instagram.com/official_miarcus?igshid=17ngfu0btzmco"><img border='0' src="{{ asset('images/socials/insta.png') }}" /></a>

                </td>

            </tr>-->

            <tr>

                <td>&nbsp;</td>

            </tr>

            <tr>

                <td  align='center' valign='middle' style="background-color: #253746; padding: 10px 5px; color: #fff;">Refund Completed</td>

            </tr>
               <tr>

                <td>&nbsp;</td>

            </tr>
            <tr>

                <td>Order#{{$orderDetails['id']}}</td>

            </tr>

            <tr>

                <td align='center' valign='top'>

                    <table class="inner-table" width='100%'>

                        <tr>

                            <td>&nbsp;</td>

                        </tr>

                       

                        <tr>

                            <td align='left' valign='top' class='style3'>&nbsp;</td>

                        </tr>

                        <tr>

                            <td align='left' valign='top' class='style3'>
							<b>Hello {{ $orderDetails['order_address']['billing_name'] }},</b><br>
							There fund has been successfully completed for below item(s).
						
							

							
							</td>

                        </tr>

                        <tr>

                            <td align='left' valign='top' class='style3'>&nbsp;</td>

                        </tr>

                     

                        <tr>

                            <td align='left' valign='top' class='style3'>&nbsp;</td>

                        </tr>

                        <tr width="100%">

                            <td>

                              
                                 <table class="">

                                    <tr>

                                                    <td style="color:red">Order Details </td>

                                    </tr>

                                    <tr>

                                        <td width='50%'>

                                            <table width='100%' border='0' align='left' cellpadding='3' cellspacing='0'>

                                                <tr>

                                                    <td>Order#{{$orderDetails['id']}}</td>

                                                </tr>

                                              
                                                <tr>

                                                    <td>Placed on <?php echo date('l,F d, Y',strtotime($orderDetails['created_at'])); ?>  <td>

                                                </tr>


                                              
                                            </table>

                                        </td>

                                      
                                    </tr>
                                      
                                </table>

                                
                             
                                <table class="address-details2">

                                    <tr>

                                        <th style="background-color:#253746!important">Items in your Order : {{ $orderDetails['id'] }} </th>

                                    </tr>

                                    <tr>

                                        <td width='50%'>

                                            <table width='100%' border='0' align='left' cellpadding='3' cellspacing='0'>

                                                <tr>

                                                     <td align='left' valign='top' class='style3'>

                                                        <table width='100%' border='0' align='left' cellpadding='3' cellspacing='1' bgcolor='ACA899'>

                                                            <tr>

                                                                <th width='10%' align='center' valign='top' class='style2' bgcolor='#cccccc'>Image</th>
                                                                <th width='10%' align='center' valign='top' class='style2' bgcolor='#cccccc'>Product Name</th>

                                                                <td width='8%' align='center' valign='top' class='style2' bgcolor='#cccccc'>Size</td>
                                                                 
																 <td width='8%' align='' valign='top' class='style2' bgcolor='#cccccc'>Color
																  </td> 
																  
																 <td width='10%' align='center' valign='top' class='style2' bgcolor='#cccccc'>Category</td> 
																 
																
																
                                                                <td width='8%' align='center' valign='top' class='style2' bgcolor='#cccccc'>QTY</td>
																
																
                                                                <td width='20%' align='center' valign='top' class='style2 text-center' bgcolor='#cccccc'>Price</td>

                                                            </tr>
                                                            <?php $total_gst = 0;
                                                                $gst_tot_percentage = 0;
                                                              ?>
                                                            @foreach($orderDetails['order_products'] as $pro)
                                                            <?php $gst_tot_percentage = $pro['product_gst']; ?>
                                                            <tr>
                                                                <td align='center' valign='top' class='style3' bgcolor='#F7F7F7'>
                                                              <?php if($pro['productdetail']['product_image']['image'] != ''){ ?>
															  <img src="{{ asset('images/ProductImages/large/'.$pro['productdetail']['product_image']['image'])}}" class="img-fluid" style="width:100px;height:50px" title="" />
															  <?php } else { ?>
															  <img src="{{asset('images/no-image-found.jpg')}}" class="img-fluid" style="width:100px;height:50" alt="" title="" />
															   <?php } ?>
															  
																</td>
																
                                                                <td align='center' valign='top' class='style3' bgcolor='#F7F7F7'>{{ $pro['product_name'] }}</td>

                                                                <td align='center' valign='top' class='style3' bgcolor='#F7F7F7'>{{ $pro['product_size'] }}</td>
																
																<td align='' valign='top' class='style3' bgcolor='#F7F7F7'>{{ $pro['productdetail']['color'] }}</td> 
																
                                                                
																<td align='center' valign='top' class='style3' bgcolor='#F7F7F7'>{{ $pro['category_name'] }}</td> 
																
																
                                                                <td align='center' valign='top' class='style3' bgcolor='#F7F7F7'>{{ $pro['product_qty'] }}</td>
                                                                

																
                                                                <td align='center' valign='top' class='style3' bgcolor='#F7F7F7'>Rs. {{ formatAmt($pro['subtotal'])}}</td>

                                                            </tr>
                                                            <?php

															$total_gst += CustomFunction::igstcalculate($pro['product_price'],$pro['product_gst'],$pro['product_qty']);

															?>
                                                            @endforeach
															
                                                            
															
															@if(!empty($orderDetails['order_discount']))

                                                                <tr>

                                                                    <td colspan='10' align='right' valign='top' class='style3' bgcolor='#F7F7F7'>Order Discount</td>

                                                                    <td align='center' valign='top' class='style3' bgcolor='#F7F7F7'>Rs. {{ formatAmt($orderDetails['order_discount']) }}</td>

                                                                </tr>

                                                            @endif
															
															
															
															
															
															
															<tr>

                                                                <td colspan='10' align='right' valign='top' class='style3' bgcolor='#F7F7F7'>Coupon Discount</td>

                                                                <td align='center' valign='top' class='style3' bgcolor='#F7F7F7'>Rs. {{ formatAmt($orderDetails['coupon_discount']) }}</td>

                                                            </tr>

                                                            @if($orderDetails['shipping_charges'])

                                                                <tr>

                                                                    <td colspan='10' align='right' valign='top' class='style3' bgcolor='#F7F7F7'>Shipping Charges</td>

                                                                    <td align='center' valign='top' class='style3' bgcolor='#F7F7F7'>Rs. {{ formatAmt($orderDetails['shipping_charges']) }}</td>

                                                                </tr>

                                                            @endif

                                                            <tr>

                                                                <td colspan='10' align='right' valign='top' class='style3' bgcolor='#F7F7F7'>Grand Total</td>

                                                                <td align='center' valign='top' class='style3' bgcolor='#F7F7F7'><strong>Rs. {{ formatAmt($orderDetails['grand_total']) }} </strong></td>

                                                            </tr>

                                                        </table>

                                                    </td>

                                                </tr>

                                            </table>

                                        </td>

                                    </tr>

                                </table>


                            </td>

                        </tr>

                        

                        <tr>

                            <td align='left' valign='top' class='style3'>&nbsp;</td>

                        </tr>



                        
                        

                        

                        <tr>

                            <td align='left' valign='top' class='style3'>

                                <table width='90%' border='0' align='left'>

                                    <tr>

                                    </tr>

                                    <tr>

                                        <td colspan='3' class='style3'>&nbsp;</td>

                                    </tr>

                                    <tr>

                                        <td colspan='3' class='style3'>&nbsp;</td>

                                    </tr>

                                     <tr>

                                        <td colspan='3' class='style3'>

                                        <b>Hope to see you again soon</b><br>
										This email was sent from a notification-only address that cannot accept incoming email.Please do not reply to this message</td>

                                    </tr>

                                    <tr>

                                        <td colspan='3' class='style3'>&nbsp;</td>

                                    </tr>

                                    

                                    <tr>

                                        

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


