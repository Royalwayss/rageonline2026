@extends('layouts.adminLayout.backendLayout')
@section('content')
<style>
#image-list img {
  border: 1px solid #ddd;
  border-radius: 4px;
  padding: 5px;
  margin:10px;
  max-width: 50%!important;
}
</style>
<div class="page-content-wrapper">
    <div class="page-content">
        <div class="page-head">
            <div class="page-title">
                <h1>Exchange/Return's Management</h1>
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
                            <span class="caption-subject font-green-sharp bold uppercase">Exchange/Return Requests</span>
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
										 <th>
                                            Request Type
                                        </th>
										 <th>
                                            Image
                                        </th>
                                        <th width="10%">
                                            Name
                                        </th>
                                        
                                        <th>
                                           Product Details
                                        </th>
                                                                               
                                       
                                        <th>
                                            Reason
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
                                        <td></td>
                                        <td></td>
                                        <td>
                                            <input type="text" autocomplete="off" class="form-control form-filter input-sm" name="name" placeholder="Name">
                                        </td>
                                        
                                       
                                        
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
<div class="modal" id="request-images">
	<div class="modal-dialog">
		<div class="modal-content">
			<!-- Modal Header -->
			<div class="modal-header">
				<h4 class="modal-title">Uploaded Images</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			
				<!-- Modal body -->
				<div class="modal-body">
					<div class="form-group">
						
						<div id="image-list">
						<div>
						
					</div>
					
				</div>
				<!-- Modal footer -->
				<div class="modal-footer">
					<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
				</div>
			
		</div>
	</div>
</div>
</div>
</div>

<div class="modal" id="returnItem">
	<div class="modal-dialog">
		<div class="modal-content">
			<!-- Modal Header -->
			<div class="modal-header">
				<h4 class="modal-title request_type" >Return/exchange</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<form method="post" action="{{url('/admin/return-status')}}">@csrf
				<!-- Modal body -->
				<div class="modal-body">
					<div class="form-group">
						<label for="return_status" class="col-form-label">Select Status:</label>
						<select name="reply_status" id="reply_status"  class="form-control" required>
                            <option value="">Please Select</option>
                            <option value="Return Accepted">Return Accepted</option>
                            <option value="Return Rejected">Return Rejected</option>
                            <option value="Exchange Approved">Exchange Approved</option>
                            <option value="Exchange Rejected">Exchange Rejected</option>
                            <option value="Refund in Process">Refund in Process</option>
                            <option value="Refunded">Refunded</option>
                           <!-- <option value="Others">Others</option>-->
                        </select>
					</div>
					<div class="form-group">
						<label for="message-text" class="col-form-label">Commends:</label>
						<input type="hidden" name="return_id">
						<textarea name="reply_comment" placeholder="Commends" class="form-control" id="reply_comment" required style="margin: 0px; height: 200px; width: 569px;"></textarea>
					</div>
				</div>
				<!-- Modal footer -->
				<div class="modal-footer">
					<button type="submit" class="btn btn-success">Submit</button>
					<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
				</div>
			</form>
		</div>
	</div>
</div>
<script>
	$(document).on('click','.request-images',function(){
		var img_base_url = '{{ asset("images/return") }}/';
		var images = $(this).attr('data-images'); 
		var imagesArray = images.split(','); console.log(imagesArray);
		var image_html = '';
		imagesArray.forEach(function(image, index) {
			var  img = '<img src="'+img_base_url+''+image+'">';
			
			if(image_html == ''){
               image_html = img;
			}else{
				image_html = image_html+''+img;
			}
			
			
        });
		$("#image-list").html(image_html);
		$("#request-images").modal('show');
	});	
	$(document).on('click','.returnItem',function(){ 
	    	var id = $(this).data('id');
			$('[name=return_id]').val(id);
		    $('#returnItem').modal('show');
				$.ajax({
					type : 'post',
					data : {
						"id" : id,
						"_token" : "{{csrf_token()}}"
					},
					url :'/admin/get_update_data',
					success:function(resp){
						
						if(!resp.status){

						}else{
                            $('.request_type').html(resp.action+' Request');
                            $('#reply_status').html(resp.status_options);
                            $('#reply_comment').val(resp.reply_comment);
                            $("#reply_status").val(resp.reply_status).change();
						}
					},
					error:function(){
						//nothing to do
					}
				})		    
    });
</script>
@stop





