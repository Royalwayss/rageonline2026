@extends('layouts.adminLayout.backendLayout')
@section('content')
<?php //echo "<pre>"; print_r($producttagdata->tag_name); ?>
<style type="text/css">
    .red{
        color: red;
    }
</style>
<style>
    #cke_editor1{
        margin-left:10px!important;
        margin-right: 10px!important;
    }
</style>

<script type="text/javascript" src="{!!asset('js/backend_js/ckeditor/ckeditor.js')!!}"></script>
<script type="text/javascript" src="{!!asset('js/backend_js/ckeditor/adapters/jquery.js')!!}"></script>


		
<div class="page-content-wrapper">
    <div class="page-content">
        <div class="page-head">
            <div class="page-title">
                <h1>Fabric Management </h1>
            </div>
        </div>
        <ul class="page-breadcrumb breadcrumb">
            <li>
                <a href="{{ url('admin/dashboard') }}">Dashboard</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <a href="{{ action('App\Http\Controllers\Admin\AdminController@fabric') }}">Fabric </a>
            </li>
        </ul>
        @if(Session::has('flash_message_error'))
            <div role="alert" class="alert alert-danger alert-dismissible fade in"> <button aria-label="Close" data-dismiss="alert" style="text-indent: 0;" class="close" type="button"><span aria-hidden="true">×</span></button> <strong>Error!</strong> {!! session('flash_message_error') !!} </div>
        @endif
        @if(Session::has('flash_message_success'))
            <div role="alert" class="alert alert-success alert-dismissible fade in"> <button aria-label="Close" data-dismiss="alert" style="text-indent: 0;" class="close" type="button"><span aria-hidden="true">×</span></button> <strong>Success!</strong> {!! session('flash_message_success') !!} </div>
        @endif
        <div class="row">
            <div class="col-md-12 ">
                <div class="portlet blue-hoki box ">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-gift"></i>{{ $title }}
                        </div>
                    </div>
                    <div class="portlet-body form">
                        <form id="addEditProduct" role="form" class="form-horizontal" method="post" @if(!empty($fabric['id'])) action="{{ url('admin/add-edit-fabric/'.$fabric['id']) }}" @else action="{{ url('admin/add-edit-fabric') }}" @endif enctype="multipart/form-data"> 
                            <input type="hidden" name="_token" value="{{{ csrf_token() }}}"  autocomplete="off" />
                             <div class="form-body">
									<div class="form-group col-md-6">
									<br><br>
										<label class="col-md-6 control-label">Fabric Name:<span class="red">*</span></label>
										<div class="col-md-6">
											<input autocomplete="off" type="text" placeholder="Faric Name" name="fabric_name" style="color:gray" class="form-control" value="{{(!empty($fabric['fabric_name']))?$fabric['fabric_name']: '' }}" required/>
										</div>
									 </div>
								</div>
<div class="form-actions right1 text-center">
                                <button  id="ProductSubmitBtn" class="btn green" type="submit">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Append Table Rows -->
<table class="table table-hover table-bordered table-striped imagesamplerow" style="display:none;">
    <tbody>
        <tr class="appenderTr blockIdWrap">
            <td>
                <input type="file" class="form-control" name="image[]">
            </td>
            <td>
                <input type="number" placeholder="Image Sort" name="image_sort[]" style="color:gray" autocomplete="off" class="form-control" required/>
            </td>
            <td>
                <a title="Remove" class="btn btn-sm red imageRowRemove" href="javascript:;"> <i class="fa fa-times"></i></a>
            </td>
        </tr>
    </tbody>
</table>
<!-- Append Table Rows -->
<script type="text/javascript">
    $(document).on('click','.updateImageSort',function(){
        var imageid = $(this).data('imageid');
        var imagesort = $('#ImageSort-'+imageid).val();
        $.ajax({
            data : {imageid:imageid,imagesort:imagesort},
            url : "/admin/update-image-sort",
            type : "get",
            success:function(resp){
                alert('Sort updated successfully');
            },
            error:function(){

            }
        })
    })
</script>
<script type="text/javascript">
    var rowid = 1;
    jQuery("#addrow").click(function() {        
        var row = jQuery('.samplerow tr').clone(true);
        row.appendTo('#dynamicTable1');        
    });
    $('.remove').on("click", function() {
        $(this).parents("tr").remove();
    });
</script>
<script type="text/javascript">
    var rowid = 1;
    jQuery("#addImageRow").click(function() {        
        var row = jQuery('.imagesamplerow tr').clone(true);
        row.appendTo('#ImageTable');        
    });
    $('.imageRowRemove').on("click", function() {
        $(this).parents("tr").remove();
    });
</script>
<script>
    $(document).on('change','.changeStatus',function(){
        var attrid = $(this).data('attrid');
        var status = $(this).val();
        $.ajax({
            data : {status:status,attrid:attrid},
            url : '/admin/change-attr-status',
            type : 'post',
            success:function(resp){

            },
            error:function(){
                alert('error');
            }
        })
    })
</script>
<script type="text/javascript">
    $('.MultipleSelect option').mousedown(function(e) {
        e.preventDefault();
        $('#addEditProduct').formValidation('revalidateField', 'cats[]');
        var originalScrollTop = $(this).parent().scrollTop();
        console.log(originalScrollTop);
        $(this).prop('selected', $(this).prop('selected') ? false : true);
        var self = this;
        $(this).parent().focus();
        setTimeout(function() {
            $(self).parent().scrollTop(originalScrollTop);
        }, 0);
        
        return false;
    });
</script>
<script>

  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()

    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })
  })
</script>
@endsection
