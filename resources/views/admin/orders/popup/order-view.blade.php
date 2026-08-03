<?php Use App\CustomFunction; ?> 
<style>
.text1{ font-size:13px; font-family:'roboto_condensedregular';  }
.text1  {  font-size:12px;  font-family:'roboto_condensedregular'; }
</style>


<p> <strong>Order date: </strong> {{ date('d F Y h:ia',strtotime($orderDetails['created_at'])) }} </p>
	
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
						<td width="10%" style="font-weight:bold;">Code </td>
						<td width="15%" style="font-weight:bold;">Name </td>
						<td width="10%" style="font-weight:bold;">Sku </td>
						<td width="10%" style="font-weight:bold;">Category</td>
						<td width="10%" style="font-weight:bold;">Image </td>
						<td width="10%" style="font-weight:bold;">Size </td>
						<td width="10%" style="font-weight:bold;">Color </td>
						<td width="10%" style="font-weight:bold;">Qty</td>
						<td width="15%" style="font-weight:bold;">Unit Price</td>
				</tr>
					 <?php $priceArr = array(); ?>
					@foreach($orderDetails['order_products'] as $key => $product)
					<tr style="text-align:center">
							<?php $priceArr[] = $product['subtotal'] ?>
							<td valign="top">{{$product['product_code']}}</td>
							<td valign="top"> <a  target="_blank" href="{{ url('/product/'.$product['productdetail']['seo_url']) }}">{{$product['product_name']}}</a></td>
							<td valign="top">{{$product['product_sku']}}</td>
							<td valign="top">{{$product['category_name']}}</td></td>
							<td valign="top"> 
							@if(isset($product['productdetail']['product_image']))
								<img style="border:0px;" src="{{asset('images/ProductImages/medium/'.$product['productdetail']['product_image']['image'])}}" height="50px" width="50px" >
							@else
								<img style="border:0px;" src="{{asset('images/no-image-found.jpg')}}" height="50px" width="50px" >
							@endif			
							</td>
							<td valign="top">{{$product['product_size']}}</td>
							
							<td valign="top">{{ $product['productdetail']['productcolor']}}</td>
							<td valign="top">{{$product['product_qty']}}</td>
							<td valign="top">INR {{ formatAmt($product['subtotal']/$product['product_qty']) }}</td>
					</tr>
					@endforeach		
					<?php $grandtotal = array_sum($priceArr);?>	
					<tr>
							<td colspan="9">
							Sub Total : INR {{formatAmt($grandtotal) }} 
							</td>
					</tr>
					<tr>
							<td colspan="9">
							Coupon Discount  : 
							INR {{ $orderDetails['coupon_discount'] }}	 <br>
							 
							</td>
					</tr>
					<tr>
							<td colspan="9">
								Grand Total (Including Shipping) : INR {{formatAmt($orderDetails['grand_total'])}} 
							</td>
					</tr>
					<tr>
							<td colspan="9">
							Payment Method:  {{ CustomFunction::get_payment_method($orderDetails['payment_method']) }}  </td>
					</tr>
					<tr>
							<td colspan="9">
							Comments:  {{$orderDetails['comments']}}</td>
					</tr>
				</table>
			   
			</div>


		</div>
		</div>
		
	</div>
	
</div>

	
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

		<div class="col-md-6">
		<br />
		<span class="text1">--------------------<strong>Billing Address</strong>--------------------</span><br>
		<span class="text1">
		{{ $orderDetails['order_address']['billing_name'] }} <br>
		{{ $orderDetails['order_address']['billing_address'] }}<br>
		{{ $orderDetails['order_address']['billing_city'] }} <br>
		{{ $orderDetails['order_address']['billing_state'] }} <br>
		{{ $orderDetails['order_address']['billing_mobile'] }} <br>
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
   <div class="orderStatus">
      <div class="col-md-12">

	<div class="portlet blue-hoki box">

		<div class="portlet-title">

			<div class="caption">

				<i class="fa fa-cogs"></i>Order Status

			</div>

		</div>

		<div class="portlet-body">

			<form method="post" id="update-order-status" class="form-horizontal" role="form" autocomplete="off" action="javascript:;">@csrf
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


<script>
$("#update-order-status").submit(function(e){ 
		 if(confirm('Are you sure you want to change the order status?') ){
			$.ajax({
				url: '@php echo url('admin/update-order-status').'/'.$orderDetails['id']; @endphp',
				type:'POST',
				data: $("#update-order-status").serialize(),
				success: function(data) {
					if(!data.status){
								$('#order_result_message').attr('style', 'color:red');
								$('#order_result_message').html(data.message);  
								
								setTimeout(function () {
									$('#order_result_message').css({
										'display': 'none'
									});
								}, 3000); 
					}else{     
								$('#order_result_message').attr('style', 'color:green');
								$('#order_result_message').html(data.message);
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