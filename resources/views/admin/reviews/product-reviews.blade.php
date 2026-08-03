@extends('layouts.adminLayout.backendLayout')
@section('content')
<style>
.table-scrollable table tbody tr td{
    vertical-align: middle;
}
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
                <h1>Product Reviews</h1>
            </div>
        </div>
        <ul class="page-breadcrumb breadcrumb">
            <li>
                <a href="{{url('admin/dashboard')}}">Dashboard</a>
            </li>
        </ul>
         @if(Session::has('flash_message_error'))
            <div role="alert" class="alert alert-danger alert-dismissible fade in"> <button aria-label="Close" data-dismiss="alert" style="text-indent: 0;" class="close" type="button"><span aria-hidden="true"></span></button> <strong>Error!</strong> {!! session('flash_message_error') !!} </div>
        @endif
        @if(Session::has('flash_message_success'))
            <div role="alert" class="alert alert-success alert-dismissible fade in"> <button aria-label="Close" data-dismiss="alert" style="text-indent: 0;" class="close" type="button"><span aria-hidden="true"></span></button> <strong>Success!</strong> {!! session('flash_message_success') !!} </div>
        @endif
        <div class="row">
            <div class="col-md-12">
                <div class="portlet light">
                    <div class="portlet-title">
                        <div class="caption">
                            <span class="caption-subject font-green-sharp bold uppercase">Product Reviews</span>
                            <span class="caption-helper">manage records...</span>
                        </div>
                        <!--<div class="actions">
                            <div class="btn-group">
                                <a href="{{url('admin/export-subscribers')}}" class="btn btn-primary">Click to Export Data</a>
                            </div>
                        </div>-->
                    </div>
                    <div class="portlet-body">
                        <div class="table-container">
                            <table class="table table-striped table-bordered table-hover" id="datatable_ajax">
                                <thead>
                                    <tr role="row" class="heading">
                                        <th>
                                            User Name/Email
                                        </th>
                                        <th>
                                            Product
                                        </th>
										 <th>
                                            Review
                                        </th>
                                                                         
                                        <th>
                                            Status
                                        </th> 
                                       
                                        <th>
                                            Created At
                                        </th> 
                                       
                                    </tr>
                                    <tr role="row" class="filter">
                                        <td></td>
                                       
										<td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                       
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
<div class="modal" id="review-images">
	<div class="modal-dialog">
		<div class="modal-content">
			<!-- Modal Header -->
			<div class="modal-header">
				<h4 class="modal-title">Review Images</h4>
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
<script>
$(document).on('click','.review-images',function(){
		var img_base_url = '{{ asset("images/ProductImages/review") }}/';
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
		$("#review-images").modal('show');
	});	
</script>
@stop





