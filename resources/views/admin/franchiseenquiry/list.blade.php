@extends('layouts.adminLayout.backendLayout')
@section('content')
<style>
.table-scrollable table tbody tr td{
    vertical-align: middle;
}
</style>
<div class="page-content-wrapper">
    <div class="page-content">
        <div class="page-head">
            <div class="page-title">
                <h1> Franchise Enquiry  Management</h1>
            </div>
        </div>
        <ul class="page-breadcrumb breadcrumb">
            <li>
                <a href="{!! url('admin/dashboard') !!}">Dashboard</a>
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
                            <span class="caption-subject font-green-sharp bold uppercase"> Franchise Enquiry </span>
                            <span class="caption-helper">manage records...</span>
                        </div>
                    </div>
                    <div class="portlet-body">
                       
                        <div class="table-container">
                            <table class="table table-striped table-bordered table-hover" id="datatable_ajax">
                                <thead>
                                    <tr role="row" class="heading">
                                         <th>
                                            S.No
                                        </th>
                                         <th>
                                           Name
                                        </th>
                                        <th>
                                             Address
                                        </th>
                                       <th>
                                             City / State :
                                        </th>
										<th>
                                             Phone
                                        </th>
										<th>
                                             Phone(Showroom)
                                        </th>
										<th>
                                             Phone(Business)
                                        </th>
										<th>
                                             Mobile(Business)
                                        </th>
										<th>
                                             Created At
                                        </th>
                                        <th>
                                            Actions
                                        </th>
                                    </tr>
                                    <tr role="row" class="filter">
                                       <td></td> 
                                       <td><input type="text" class="form-control form-filter input-sm" name="name_of_party" placeholder="name"></td>
                                      
                                        <td><input type="text" class="form-control form-filter input-sm" name="address_of_party" placeholder="address"></td>
										<td><input type="text" class="form-control form-filter input-sm" name="city_of_party" placeholder="city"></td>
                                      
									  <td><input type="text" style="width:110px" class="form-control form-filter input-sm" name="phone" placeholder="phone all"></td>
									  <td></td>
									  <td></td>
									  <td></td>
									  <td></td>
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
<div class="modal fade" id="View" tabindex="-1" role="dialog" aria-labelledby="OrderViewLabel" aria-hidden="true" >

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
		$('#View .modal-title').empty();
		$('#View .modal-title').append('<b>Franchise Enquiry Details</b>');
		$('#View .modal-body').append('Loding');
		$.ajax({
			type: 'get',
			url: 'franchise-enquiry-details/'+rowID,
			beforeSend: function(xhr) {
				xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
			},
			success: function(response) {
				$('#View .modal-body').empty();
				$('#View .modal-body').append(response);
				
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




