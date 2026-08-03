<?php use App\ExchangeRequest; use App\Order; use App\Product; use App\OrderProduct; use App\CustomFunction; ?>

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
<div class="row accTabsInfo">
  <div class="col-12">
    <h4 class="booster-font">Orders</h4>
  </div>
  <div class="col-sm-12 col-12 mt-3">
    <table class="table table-hover table-responsive tbl_res tbl-ordr">
      <thead>
        <tr style="text-align:center">
          <td>ORDER ID</td>
          <td>PAYMENT METHOD</td>
          <td>ORDER DATE</td>
          <td>AMOUNT(Rs)</td>
          <td>STATUS</td>
          <td colspan="3" class="text-center">ACTIONS</td>
        </tr>
		
      </thead>
      <tbody>
        @if(count($orders) >0)
        @foreach($orders as $order)
        <?php 	if($order->payment_method == 'bank_deposit') { $payment_method = 'Bank deposit'; }  else { $payment_method = $order->payment_method;  }?>

        <?php
						   if(@$order->order_address->shipping_state =='Punjab'){
								$own_state = 'yes';
							}else{
								  $own_state = 'no';
							}
							$total_gst_ = 0;
						   
						   ?>
        <tr style="text-align:center">
          <td>{{$order->id}}</td>
          <td>{{ucwords($payment_method)}}</td>
          <td>{{date('d M Y',strtotime($order->created_at))}}</td>
          <td >{{number_format($order->grand_total,2)}}</td>
          <td>{{ucwords($order->order_status)}}</td>
          
            <?php /* <a href="{{url('/account/orders?order_id='.$order->id)}}">View Detail</a>   
					 <a href="{{url('/account/order-invoice-print/'.$order->id)}}">Invoice</a> */ ?>
            
			<?php /*
			<a data-toggle="modal" data-target="#myModal{{ $order->id }}" href="javascript:;"> <img
                src="{{ asset('images/report.png') }}" width="20px"></a> */ ?>
			<?php $check_order_return_exchange = Order::check_order_return_exchange($order->id); ?>    
				
				<td><a  href="{{ url('order/'.$order->id) }}"> View</a></td>
				@if(!empty($order['waybill']))
				<td><a  target="_blank" href="{{ url('track-order/'.$order->id) }}"> Track Order</a></td>
				@endif
				<td>
				    @if($check_order_return_exchange['cancel'] == 1)
					   <a  href="{{ url('order-cancel/'.$order->id) }}"> Cancel</a>
					@endif
				</td>
				<td>
				    @if($check_order_return_exchange['return'] == 1 || $check_order_return_exchange['exchange'] == 1)
					<a  href="{{ url('exchange-item/'.$order->id) }}"> Exchange</a>
					@endif
				</td>
			    
          </td>
          
        </tr>
        @endforeach
        @else
        <tr>
          <td colspan="7" class="text-center">No orders yet.</td>
        </tr>
        @endif
      </tbody>
    </table>
  </div>
</div>
@endif




<div class="modal " id="returnItem">
  <div class="modal-dialog">
    <div class="modal-content">
      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Return Item</h4>
        <button type="button" style="border: transparent; background-color:transparent;" class="close"
                      data-dismiss="modal"><span class="fas fa-times"></span></button>
      </div>
      <form method="post" action="{{url('/return-order-item')}}" id="return-form" enctype="multipart/form-data">@csrf
        <!-- Modal body -->
        <div class="modal-body">
          <div class="container">
            <div class="row">
              <div class="col">
                <label for="return_reason" class="col-form-label">Reason for Returning:</label>
                <select name="return_reason" class="form-control return_items" required>
                  <option value="">Please Select</option>
                  <option value="Incorrect product received">Incorrect product received</option>
                  <option value="Received product is defective">Received product is defective</option>
                  <option value="A Part of the product is missing">A Part of the product is missing</option>
                  <option value="Wrong size received">Wrong size received</option>
                  <option value="Size Issue">Size Issue</option>
                  <option value="Others">Others</option>
                </select>
              </div>
            </div>
            <div class="row">
              <div class="col">
                <label for="message-text" class="col-form-label">Comments:</label>
                <input type="hidden" name="order_product_id">
                <input type="hidden" name="sku">
                <textarea name="reason" placeholder="Comments" class="form-control return_items" id="message-text"
                  required></textarea>
              </div>
            </div>
            <div class="row">
              <div class="col">
                <label for="exampleFormControlFile1">Choose file (if any)</label>
                <input type="file" class="form-control-file return_items" id="exampleFormControlFile1" name="file">
                <span style="color:red">Note:-Max file size is 2MB</span>
              </div>
            </div>
          </div>
        </div>
        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="submit" class="btn btn-success" style="background-color: #28a745;color:white">Submit</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal"
            style="background-color: #dc3545;color:white">Close</button>
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
  $(document).ready(function () {
    $(document).on('click', '.returnItem', function () {
      var orderproid = $(this).data('orderproid');
      var sku = $(this).data('sku');
      $('[name=sku]').val(sku);
      $('[name=order_product_id]').val(orderproid);
      $('#returnItem').modal('show');
    })
  })
  $(document).on('click', '.triggerOrderDetails', function () {

    $(".collapse").css("display", "block");
  });
  $(document).ready(function () {

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