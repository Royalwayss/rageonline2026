@extends('layouts.adminLayout.backendLayout')
@section('content')
<div class="page-content-wrapper">
    <div class="page-content">
        <div class="page-head">
            <div class="page-title">
                <h1>Order's Management</h1>
            </div>
        </div>
        <ul class="page-breadcrumb breadcrumb">
            <li>
                <a href="{!! url('admin/dashboard') !!}">Dashboard</a>
            </li>
        </ul>
         @if(Session::has('flash_message_error'))
            <div role="alert" class="alert alert-danger alert-dismissible fade in"> <button aria-label="Close" data-dismiss="alert" style="text-indent: 0;" class="close" type="button"><span aria-hidden="true">×</span></button> <strong>Error!</strong> {!! session('flash_message_error') !!} </div>
        @endif
        @if(Session::has('flash_message_success'))
            <div role="alert" class="alert alert-success alert-dismissible fade in"> <button aria-label="Close" data-dismiss="alert" style="text-indent: 0;" class="close" type="button"><span aria-hidden="true">×</span></button> <strong>Success!</strong> {!! session('flash_message_success') !!} </div>
        @endif
        <div id="statusMessage" style="display: none;" role="alert" class="alert alert-success alert-dismissible fade in"><strong>Success!</strong> Status Updated Successfully.</div>
        <div class="row">
            <div class="col-md-12">
                <div class="portlet light">
                    <div class="portlet-title">
                        <div class="caption">
                            <span class="caption-subject font-green-sharp bold uppercase">Orders</span>
                            <span class="caption-helper">manage records...</span>
                        </div>
                        <div class="actions">
                            <div class="btn-group">
                                <a href="{{url('admin/export-orders')}}" class="btn btn-primary">Export Orders</a>
                            </div>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <div class="table-container">
                            <table class="table table-striped table-bordered table-hover" id="datatable_ajax">
                                <thead>
                                    <tr role="row" class="heading">
                                        <th width="3%">
                                            OrderId.
                                        </th>
                                        <th width="10%">
                                            User Details
                                        </th>
                                        
                                        <th>
                                            Discount
                                        </th>
                                        <th>
                                            Amount
                                        </th>
                                        <th>
                                            Method
                                        </th>
                                        
                                        <th width="15%">
                                            Order Date
                                        </th>
                                        <th width="25%">
                                            Status
                                        </th>
                                        <th width="35%">
                                            Actions
                                        </th>
                                    </tr>
                                    <tr role="row" class="filter">
                                        <td><input type="text" autocomplete="off" class="form-control form-filter input-sm" name="orderid" placeholder="Order Id"></td>
                                        <td>
											<input type="text" autocomplete="off" class="form-control form-filter input-sm" name="name" placeholder="Name"> <br> 
											<input type="text" autocomplete="off" class="form-control form-filter input-sm" name="email" placeholder="Email"><br>
											<input type="text" autocomplete="off" class="form-control form-filter input-sm" name="mobile" placeholder="Mobile"><br>
										</td>
                                        <td></td>
                                        <td></td>
                                        <td>
										  <div class="form-group">
                                                <label for="recipient-name" class="form-control-label"></label>
                                                <select class="form-control form-filter input-sm select" name="payment_method">
                                                    <option value="">Select</option>
                                                        <option value="cod">Cod</option>
                                                        <option value="ccavenue">Ccavenue</option>
                                                        <option value="bank_deposit">Bank deposit</option>
                                                        <option value="phonepe">Phonepe</option>
                                                </select>
                                            </div>
										</td>
                                        <td>
                                             <label for="recipient-name" class="form-control-label">From:</label>
                                            <div class="input-group input-append date datePicker">
                                                <input type="text" class="form-control date-reset form-filter resetPicker" name="from_date" />
                                                <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                                            </div>
                                            <div class="form-group">
                                                <label for="recipient-name" class="form-control-label">To:</label>
                                                <div class="input-group input-append date datePicker">
                                                    <input type="text" class="form-control date-reset form-filter resetPicker" name="to_date" />
                                                    <span class="input-group-addon add-on"><span class="glyphicon glyphicon-calendar"></span></span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <label for="recipient-name" class="form-control-label"></label>
                                                <select class="form-control form-filter input-sm select" name="order_status">
                                                    <option value="">Select</option>
												<!--	<option value="Bank deposit">Bank deposit</option>
													<option value="Payment Captured">Payment Captured</option>
													<option value="COD Confirmed">COD Confirmed</option> -->
                                                    @foreach($getorderstatus as $status)
                                                        <option value="{{$status['name']}}">{{$status['name']}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="margin-bottom-5">
                                                <button class="btn btn-sm yellow filter-submit margin-bottom"><i title="Search" class="fa fa-search"></i></button>
                                                <button class="btn btn-sm red filter-cancel"><i title="Reset" class="fa fa-refresh"></i></button>
                                            </div>
                                        </td>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="OrderView" tabindex="-1" role="dialog" aria-labelledby="OrderViewLabel" aria-hidden="true" >

    <div class="modal-dialog" role="document">

        <div class="modal-content" ><!-- style="background: #D4ECF9;" -->

            <div class="modal-header">

                <h5 class="modal-title" id="OrderViewLabel"></h5>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -14px!important;">

                <span aria-hidden="true">&times;</span>

                </button>

            </div>
			
		   <div class="modal-body">
					Loding....
		   </div>	
			   
		<div class="modal-footer">
			<button style="color: white; background-color: #f44336;" type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
		</div>
		
      </div>    
				
				

     </div>

</div>

    

<script type="text/javascript">
$( document ).ready(function() {
	$(document).on('click', '.view-modal', function () {
		var rowID = $(this).attr('id'); 
		$('#OrderView .modal-title').empty();
		$('#OrderView .modal-title').append('<b>View Order Details For Order Number:'+rowID+'</b>');
		$('#OrderView .modal-body').append('Loding');
		$.ajax({
			type: 'get',
			url: 'order-details/'+rowID,
			beforeSend: function(xhr) {
				xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
			},
			success: function(response) {
				$('#OrderView .modal-body').empty();
				$('#OrderView .modal-body').append(response);
				
			},
			error: function(e) {
				alert('An error occurred:');
				console.log(e);
			}
		});
	});
});

</script>
@stop