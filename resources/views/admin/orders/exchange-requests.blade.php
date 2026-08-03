@extends('layouts.adminLayout.backendLayout')
@section('content')
<div class="page-content-wrapper">
    <div class="page-content">
        <div class="page-head">
            <div class="page-title">
                <h1>Exchane's Management</h1>
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
                            <span class="caption-subject font-green-sharp bold uppercase">Exchane's Requests</span>
                            <span class="caption-helper">manage records...</span>
                        </div>
                        <div class="actions">
                            
                        </div>
                    </div>
                    <div class="portlet-body">
                        <div class="table-container">
                            <table class="table table-striped table-bordered table-hover" id="datatable_ajax">
                                <thead>
                                    <tr role="row" class="heading">
                                        <th width="5%">
                                            Order Id
                                        </th>
                                        <th width="10%">
                                            Name
                                        </th>
                                        <th width="10%">
                                            Product Name
                                        </th>
                                        <th>
                                            Size
                                        </th>
                                        <th>
                                            Sku
                                        </th>                                         
                                        <th>
                                            Price
                                        </th>
                                        <th>
                                            Reason
                                        </th>
                                        <th>
                                            Image
                                        </th>
                                        <th width="15%">
                                            Created Date
                                        </th>
                                        <th width="20%">
                                            Actions
                                        </th>
                                    </tr>
                                    <tr role="row" class="filter">
                                        <td><input type="text" autocomplete="off" class="form-control form-filter input-sm" name="orderid" placeholder="Order Id"></td>
                                        <td>
                                            <input type="text" autocomplete="off" class="form-control form-filter input-sm" name="name" placeholder="Name">
                                        </td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                         <td></td>
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





<div class="modal" id="viewIage">
	<div class="modal-dialog">
		<div class="modal-content">
			<!-- Modal Header -->
			<div class="modal-header">
				<h4 class="modal-title">View Images</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<form method="post" action="{{url('/admin/exchange-status')}}">@csrf
			<input type="hidden" name="exchange_id">
				<!-- Modal body -->
				<div class="modal-body">
					<div class="form-group">

					</div>
				</div>
				<!-- Modal footer -->
				<div class="modal-footer">
					<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
				</div>
			</form>
		</div>
	</div>
</div>

<div class="modal" id="returnItem">
	<div class="modal-dialog">
		<div class="modal-content">
			<!-- Modal Header -->
			<div class="modal-header">
				<h4 class="modal-title">Update Exchane's Request</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<form method="post" action="{{url('/admin/exchange-status')}}">@csrf
			<input type="hidden" name="exchange_id">
				<!-- Modal body -->
				<div class="modal-body">
					<div class="form-group">
						<label for="return_status" class="col-form-label">Select Status:</label>
						<select name="reply_status" id="reply_status"  class="form-control" required>
                            <option value="">Please Select</option>
                            <option value="Accept">Accept</option>
                            <option value="Reject">Reject</option>
                        </select>
					</div>
				</div>
				<!-- Modal footer -->
				<div class="modal-footer">
					<button type="submit" class="btn btn-success" id="exchange-submit">Submit</button>
					<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
				</div>
			</form>
		</div>
	</div>
</div>
<script>
	$(document).on('click','.viewIage',function(){
		    $('#viewIage').modal('show');
    });
 	$(document).on('click','.returnItem',function(){
	    	var id = $(this).data('id');
	    	
	    	var status = $(this).data('status');
			$('[name=exchange_id]').val(id);
		    $('#returnItem').modal('show');
		    if(status!=0){
		        $('[name=reply_status]').val(status);
		    }

    });   
	$(document).on('click','#reply_status',function(){
	    var status = $(this).val();
	    
	    if(status=='Accept'){
	        $(':input[type="submit"]').prop('disabled', true);
	        var exchange_id = $('[name=exchange_id]').val();
	        window.location.href = "{{url('admin/accept-exchange')}}" + "/" + exchange_id;
	    }else{
	        $('#exchange-submit').prop('readonly', false);
	    }

    });    
    
    
</script>
@stop





