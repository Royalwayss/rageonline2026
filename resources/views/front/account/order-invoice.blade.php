<?php use App\GiftOffer; use App\CustomFunction;
 if($orderDetails['order_address']['shipping_state'] =='Punjab'){
	 $own_state = 'yes';
 }else{
	  $own_state = 'no';
 }
 ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="icon" href="{{ asset('images/favicon.ico') }}" type="image/x-icon">
        <title>User Invoice</title>
        <style type="text/css">
          @font-face {
              font-family: 'junicoderegular';
              src: url('../../css/fonts/junicode-webfont.eot');
              src: url('../../css/fonts/junicode-webfont.eot?#iefix') format('embedded-opentype'),
                   url('../../css/fonts/junicode-webfont.woff2') format('woff2'),
                   url('../../css/fonts/junicode-webfont.woff') format('woff'),
                   url('../../css/fonts/junicode-webfont.ttf') format('truetype'),
                   url('../../css/fonts/junicode-webfont.svg#junicoderegular') format('svg');
              font-weight: normal;
              font-style: normal;
          }

          @font-face {
              font-family: 'open_sans';
              src: url('../../css/fonts/opensans-regular-webfont.eot');
              src: url('../../css/fonts/opensans-regular-webfont.eot?#iefix') format('embedded-opentype'),
                   url('../../css/fonts/opensans-regular-webfont.woff2') format('woff2'),
                   url('../../css/fonts/opensans-regular-webfont.woff') format('woff'),
                   url('../../css/fonts/opensans-regular-webfont.ttf') format('truetype'),
                   url('../../css/fonts/opensans-regular-webfont.svg#open_sansregular') format('svg');
              font-weight: normal;
              font-style: normal;
          }

          .Btnsdiv__Invoice{margin-bottom: 30px; margin-top: 30px; text-align: center;}
          .Btnsdiv__Invoice input{background-color: #121212; color: #fff; opacity: 0.75;text-decoration: none;outline: none; border-width: 1px; border-color: transparent; border-style: solid; display: inline-block; padding: 8px 12px; margin-bottom: 0; margin-right: 15px; margin-left: 0; border-radius: 4px; -webkit-border-radius: 4px; -moz-border-radius: 4px; background-clip: padding-box; float: none; cursor: pointer;}
          .Btnsdiv__Invoice input:focus,
          .Btnsdiv__Invoice input:hover,
          .Btnsdiv__Invoice input:active{color: #fff; background-color: #999; opacity: 1; text-decoration: none;outline: none; border-width: 1px; border-color: transparent; border-style: solid; cursor: pointer;}
          .fullWidth{width: 100%; float: left; display: inline-block; position: relative;}
          .InvoiceTable p{margin-bottom: 0; line-height: 1.257em;letter-spacing: 0; color: #828282; font-size:12px;}
          .InvoiceTable p.barcode:not(:last-of-type){margin-bottom: 10px;}
          .InvoiceTable > tbody > tr > td:only-child{width: 100%;}
          .InvoiceTable p:not(:last-of-type){margin-bottom: 3px; margin-top: 0; display: inline-block; width: 100%; float: left;text-align: left;}
          .InvoiceTable h6{margin-bottom: 0;margin-top: 0;display: inline-block; width: 100%; float: left;text-align: left;font-family: 'junicoderegular', sans-serif; letter-spacing: 1px; font-weight: 600; font-size: 14px; line-height: 1.1428em;}
          .InvoiceTable h6 span{display: inline-block; float: none; font-family: "open_sans", sans-serif; font-weight: normal;}
          .InvoiceTable h1{margin-bottom: 10px;margin-top: 0;display: inline-block; width: 100%; float: left;text-align: left;font-family: 'junicoderegular', sans-serif; font-size: 14px; letter-spacing: 1px;font-weight: 600;}
          .InvoiceTable h1.para{margin-bottom: 0;margin-top: 0;display: inline-block; width: 100%; float: left;text-align: left;font-family: 'open_sans', sans-serif; font-size: 14px; letter-spacing: 1px;font-weight: 600;}
          .InvoiceTable h6:not(:last-of-type){ margin-bottom: 6px;}
          .InvoiceTable h6:only-of-type{margin-bottom: 6px !important;}
          html{font-size-adjust: 100%; -webkit-text-size-adjust: 100%; font-size: 14px;}
          body{margin: 0; padding: 0; font-family: 'open_sans', 'Arial', 'Helvetica', sans-serif; font-size: 14px; font-weight: normal; font-style: normal; text-align: center;}
          /* .barcode {font-family: 'basawa_3_of_9_mhrregular';font-size:48px;} */
          .InvoiceTable h6{font-size: 14px; font-weight: bold;}
          h6.para{font-family: "open_sans", sans-serif; font-size: 12px;}
          table.InvoiceTable h6.para{margin-bottom: 0 !important;}
          *,*:after,*:before{box-sizing: border-box; -webkit-box-sizing: border-box; -moz-box-sizing: border-box;}
          table.InvoiceTable{float: none; width: 100%; border: 1px solid #ddd; table-layout: fixed; text-align: left; border-collapse: collapse;vertical-align: top;font-family: 'open_sans', 'Arial', 'Helvetica', sans-serif; font-size: 14px; }
          table.InvoiceTable > tbody > tr:not(:last-of-type){border-bottom: 1px solid #ddd;}
          table.InvoiceTable > tbody > tr > td:not(:last-of-type){}
          table.InvoiceTable td,
          table.InvoiceTable th{padding: 4px;vertical-align: top;}
          table:not(.InvoiceTable){table-layout: fixed; width: 100%; float: left;border-collapse: collapse; vertical-align: top;font-family: 'open_sans', 'Arial', 'Helvetica', sans-serif; font-size: 14px; }
          table td,
          table th{padding: 0px; vertical-align: top; font-size: 14px;}
          img{max-width: 100%;}
        </style>
    </head>
    <body>
         <div style="max-width: 780px; text-align: center; float: none; display: inline-block; width: 780px;">
            <table width="778px" class="InvoiceTable" border="0" cellspacing="0" cellpadding="0" style="text-align: left;">
                <tr>
                     <td style="width: 75px; vertical-align: middle;" ><img src="{{ public_path('images/logo.png')}}" > </td>
                    <td>
                        <p>{{config('constants.project_name')}} Address</p>
                        <p>{{config('constants.return_address')}},</p>
                        <p>{{config('constants.pincode')}} </p>
                    </td>
                    <td>
                        <p>Toll Free No. : {{config('constants.project_mobile')}}</p>
                        <p>Email: {{config('constants.project_email')}}</p>
                        <p>GST: {{config('constants.gst')}}</p>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                         @if($orderDetails['order_address']['company_name'] !="" ||  $orderDetails['order_address']['gstin'] != '')
					    <h6>BILLED TO :</h6>
						<p>
                            {{$orderDetails['order_address']['company_name'] }}
                        </p>
                        <p>
                            {{$orderDetails['order_address']['gstin'] }}
                        </p>
						<p>
                            {{$orderDetails['order_address']['billing_name'] }}
                        </p>
                        <p>
                            {{$orderDetails['order_address']['billing_address'] }}
                        </p>
                        <p>
                            {{$orderDetails['order_address']['billing_address2'] }}
                        </p>
                        <p>  
                            {{$orderDetails['order_address']['billing_city'] }}
                        </p>
                        <p>
                            {{$orderDetails['order_address']['billing_state'] }}
                        </p>
                        <p>
                            {{$orderDetails['order_address']['billing_postcode'] }}
                        </p>
                        <p><b>Mobile:</b> {{$orderDetails['order_address']['billing_mobile'] }}<br>
                        </p>
					     @endif
                        <h6>DELIVER TO :</h6>
                        <p>
                            {{$orderDetails['order_address']['shipping_name'] }}
                        </p>
                        <p>
                            {{$orderDetails['order_address']['shipping_address'] }}
                        </p>
                        <p>
                            {{$orderDetails['order_address']['shipping_address2'] }}
                        </p>
                        <p>  
                            {{$orderDetails['order_address']['shipping_city'] }}
                        </p>
                        <p>
                            {{$orderDetails['order_address']['shipping_state'] }}
                        </p>
                        <p>
                            {{$orderDetails['order_address']['shipping_postcode'] }}
                        </p>
                        <p><b>Mobile:</b> {{$orderDetails['order_address']['shipping_mobile'] }}<br>
                        </p>
                    </td>
                    <td>
                        <h1>{{ ($orderDetails['payment_method'] == "cod") ? "COD" : 'Prepaid' }} Order</h1>
                        <p><strong>Order ID: </strong>{{$orderDetails['id']}}</p>
                        <p><strong>Order Date: </strong>{{date('d F Y h:ia',strtotime($orderDetails['created_at']))}}</p>
                        <p><strong>Quantity: </strong>{{$orderDetails['total_items']}}</p>
                        <p><strong>Grand Total: </strong>{{formatAmt($orderDetails['grand_total'])}}</p>
                    </td>
                </tr>
                <tr>
                    <td colspan="3">
                        @if($orderDetails['payment_method'] =="cod")
                            <h3>Amount To be Collected: Rs. {{formatAmt($orderDetails['grand_total']) }}</h3>
                        @else
                            <h3>Amount: Rs. {{formatAmt($orderDetails['grand_total']) }}</h3>
                        @endif
                    </td>
                </tr> 
                <tr>
                    <td colspan="3">
                        <h5 class="para">Grand Total in Words: &nbsp; {{ucwords($numberWords)}} Rupees Only</h5>   
                    </td>
                </tr>
                @if(!empty($orderDetails['gift_id']))
                <?php $details = GiftOffer::giftinfo($orderDetails['gift_id']); ?>
                <tr>
                    <td colspan="3">
                        <h5 class="para" style="color:green;">Freebie Included: &nbsp; {{$details->invoice_gift_name}}</h5>   
                    </td>
                </tr>
                @endif
                <tr>
                    <td colspan="3">
                        <table cellspacing="0" cellpadding="0">
                            <tbody>
                                <tr style="background-color:#ddd;">
                                    <td style="width:20%;" >
                                        <h6 class="para">Product Name </h6>
                                    </td>
                                    <td>
                                        <h6 class="para">Product Size</h6>
                                    </td>
                                    <td >
                                        <h6 class="para">Sku</h6>
                                    </td>
                                    <td>
                                        <h6 class="para">Quantity</h6>
                                    </td>
                                    <td>
                                        <h6 class="para">Unit Price</h6>
                                    </td>
									<td>
                                        <h6 class="para">CGST  </h6>
                                    </td>
									<td>
                                        <h6 class="para">SGST</h6>
                                    </td>
									<td>
                                        <h6 class="para">IGST</h6>
                                    </td>
									
                                    <td >
                                        <h6 class="para">Price</h6>
                                    </td>
                                </tr>
                                <?php $total_gst = 0;
                                    $gst_tot_percentage = 0;
                                ?>
                                @foreach($orderDetails['order_products'] as $product)
                                
                                <?php $gst_tot_percentage = $product['product_gst']; ?>
                                    <tr style="border-bottom: 1px solid #ddd;">
                                        <td colspan="">
                                            <p style="color: #8B9931; font-weight: bold; font-size: 14px;">{{$product['product_name']}}</p>
                                        </td>
                                        <td>
                                            <p>{{$product['product_size']}}</p>
                                        </td>
                                        <td>
                                            <p>{{$product['product_sku']}}</p>
                                        </td>
                                        <td>
                                            <p>{{$product['product_qty']}}</p>
                                        </td>
                                        <td>
                                            <p>Rs. {{ abs(formatAmt(CustomFunction::gstunitcalculate($product['product_price'],$product['product_gst'],1)))}}</p>
                                        </td>
										<td>
                                            <p> 
											<?php 
											

											if($own_state == 'yes'){ 
											
											
											
											
											
											?>
												{{ round(CustomFunction::sgstcalculate($product['product_price'],$product['product_gst'],$product['product_qty']), 2)}} ( {{ $product['product_gst']/2 }}%)
											<?php } else { echo "(0%) Rs.0"; } ?>
												
											</p>
                                        </td>
										<td>
										<p>
										   <?php 

										   if($own_state == 'yes'){ ?>
                                           {{ round(CustomFunction::sgstcalculate($product['product_price'],$product['product_gst'],$product['product_qty']), 2)}} ( {{ $product['product_gst']/2 }}%)
											
											<?php } else { echo "(0%) Rs.0"; } ?>
											</p>
                                        </td>
										<td>
                                            <p><?php 
                                                
                                            if($own_state == 'no'){ ?>
											{{ round(CustomFunction::igstcalculate($product['product_price'],$product['product_gst'],$product['product_qty']),2)}} ( {{ $product['product_gst'] }}%)
											<?php } else { echo "(0%) Rs.0"; } ?>
											</p>
                                        </td>
                                        <td>
                                            <p>Rs. {{formatAmt($product['subtotal'])}}</p>
                                        </td>
                                        <td></td>
                                    </tr>
                                    
                                    <?php

                                        $total_gst += CustomFunction::igstcalculate($product['product_price'],$product['product_gst'],$product['product_qty']);

                                    ?>
                                    
                                    
                                @endforeach
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td colspan="6"></td>
                                    <td colspan="1">Total GST:</td>
                                    <td colspan="2">Rs. {{formatAmt($total_gst)}} ( {{ $gst_tot_percentage }} %)</td>
                                </tr>                                
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td colspan="6"></td>
                                    <td colspan="1">Coupon Discount:</td>
                                    <td colspan="1">Rs. {{$orderDetails['coupon_discount']}}</td>
                                </tr>
                                <tr style="border-bottom: 1px solid #ddd;">
                                    <td colspan="6"></td>
                                    <td colspan="1">Shipping Charges :</td>
                                    <td colspan="1">Rs. {{formatAmt($orderDetails['shipping_charges'])}}</td>
                                </tr>
                                <tr>
                                    <td colspan="6"></td>
                                    <td colspan="1"><b>Grand Total:</b></td>
                                    <td colspan="2"><b>Rs.  {{formatAmt($orderDetails['grand_total'])}}</b></td>
                                </tr>
                                <tr style="background-color:#F5F5F5;">
                                    <td colspan="6">
                                    </td>
                                    <td style="text-align: left; vertical-align: middle;" colspan="1">
                                        <p style="margin-top: 0">
                                            Order Status:
                                        </p>
                                    </td>
                                    <td style="text-align: left; vertical-align: middle;" colspan="2">
                                        <p style="margin-top: 0">
                                        <strong>{{$orderDetails['order_status']}}</strong>
                                        </p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td colspan="3">
                        <p>
                            <b>This is a computer generated invoice and does not require signature</b>
                        </p>
                        <p>If you receive an open or a tampered package at the time of delivery, please do not accept it.</p>
                    </td>
                </tr>
            </table>
        </div>
    
    </body>
</html>