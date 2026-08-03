@extends('layouts.adminLayout.backendLayout')
@section('content')
<div class="page-content-wrapper">
   @if(Session::has('flash_message_error'))
   <div role="alert" class="alert alert-danger alert-dismissible fade in"> <button aria-label="Close" data-dismiss="alert" style="text-indent: 0;" class="close" type="button"><span aria-hidden="true">×</span></button> <strong>Error!</strong> {!! session('flash_message_error') !!} </div>
   @endif
   @if(Session::has('flash_message_success'))
   <div role="alert" class="alert alert-success alert-dismissible fade in"> <button aria-label="Close" data-dismiss="alert" style="text-indent: 0;" class="close" type="button"><span aria-hidden="true">×</span></button> <strong>Success!</strong> {!! session('flash_message_success') !!} </div>
   @endif
   <div class="page-content">
      <div class="page-head">
         <div class="page-title">
            <h1>Contacts Management </h1>
         </div>
      </div>
      <ul class="page-breadcrumb breadcrumb">
         <li>
            <a href="{{ url('admin/dashboard') }}">Dashboard</a>
            <i class="fa fa-circle"></i>
         </li>
         <li>
            <a href="{{ url('admin/contact') }}">Contacts </a>
         </li>
      </ul>
      <div class="row">
         <div class="col-md-12 ">
            <div class="portlet blue-hoki box ">
               <div class="portlet-title">
                  <div class="caption">
                     <i class="fa fa-gift"></i>{{ $title }}
                  </div>
               </div>
               <div class="portlet-body form">
                  <div class="form-body">
                     <div class="form-group" >
                        <div class="row">
                           <label class="col-md-2 control-label">Name :</label>
                           <div class="col-md-1">:</div>
                           <div class="col-md-9">
                              {{ $row['name'] }}
                           </div>
                        </div>
                        <div class="row">
                           <label class="col-md-2 control-label">Email :</label>
                           <div class="col-md-1">:</div>
                           <div class="col-md-9">
                              {{ $row['email'] }}
                           </div>
                        </div>
                        <div class="row">
                           <label class="col-md-2 control-label">Mobile :</label>
                           <div class="col-md-1">:</div>
                           <div class="col-md-9">
                              {{ $row['country_code'].' '.$row['mobile'] }}
                           </div>
                        </div>
                        <div class="row">
                           <label class="col-md-2 control-label">Country :</label>
                           <div class="col-md-1">:</div>
                           <div class="col-md-9">
                              {{ $row['country'] }}
                           </div>
                        </div>
                        <div class="row">
                           <label class="col-md-2 control-label">State :</label>
                           <div class="col-md-1">:</div>
                           <div class="col-md-9">
                              {{ $row['state'] }}
                           </div>
                        </div>
                        <div class="row">
                           <label class="col-md-2 control-label">City :</label>
                           <div class="col-md-1">:</div>
                           <div class="col-md-9">
                              {{ $row['city'] }}
                           </div>
                        </div>
                        <div class="row">
                           <label class="col-md-2 control-label">Message :</label>
                           <div class="col-md-1">:</div>
                           <div class="col-md-9">
                              {{ $row['message'] }}
                           </div>
                        </div>
                        <div class="row">
                           <label class="col-md-2 control-label">Created At :</label>
                           <div class="col-md-1">:</div>
                           <div class="col-md-9">
                              {{ date('d M Y h:i:a',strtotime($row['created_at'])) }}
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<script>
   $(document).on('click','.DeleteSizeChart',function(){ 
           var id = $(this).attr('data-attr-id');
            $(this).hide();		
   		$.ajax({
               data : {id:id},
               url : "/admin/remove-category-sizechartimage",
               type : "get",
               success:function(resp){
                   alert('Size chart Image has been removed successfully');
   				$("#SizeChart-"+id).attr("src", "<?php echo asset('images/default.png'); ?>");
               },
               error:function(){
   
               }
           })
       });
</script>
@endsection