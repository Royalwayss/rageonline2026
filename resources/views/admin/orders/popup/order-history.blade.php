	<div class="col-md-12">

		<div class="portlet blue-hoki box">

			<div class="portlet-title">

				<div class="caption">

					<i class="fa fa-cogs"></i>Order History

				</div>

			</div>

			<div class="portlet-body">

				<div class="row static-info">

					<div class="col-md-12 value">

						@foreach($orderDetails['histories'] as $history)

						<div class="note note-success">

							<h4>

								<span class="label @if($history['order_status'] =="Cancelled" || $history['order_status'] =="Payment Failed" || $history['order_status'] =="Pending" || $history['order_status'] == "Cancelled by User"  ||  $history['order_status'] == "Failed" || $history['order_status'] == "Payment Captured")  label-danger @else label-success @endif">

								{{$history['order_status']}} </span>

							</h4>

							<small>

								{{$history['comments']}}

								<span style="text-align: right; float: right;">

								Updated at {{ date('d F Y h:ia',strtotime($history['created_at'])) }}
								 
								</span>

							</small>

						</div>

						@endforeach

					</div>

				</div>

			</div>

		</div>

     </div>
 