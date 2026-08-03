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
                <h1>Edit Header </h1>
            </div>
        </div>
        <ul class="page-breadcrumb breadcrumb">
            <li>
                <a href="{{ url('admin/dashboard') }}">Dashboard</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <a href="{{ action('App\Http\Controllers\Admin\AdminController@headertext') }}">Edit Header </a>
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
                        <form id="addEditProduct" role="form" class="form-horizontal" method="post" @if(!empty($header_text['id'])) action="{{ url('admin/header-text/'.$header_text['id']) }}" @else action="{{ url('admin/header-text') }}" @endif enctype="multipart/form-data"> 
                            <input type="hidden" name="_token" value="{{{ csrf_token() }}}"  autocomplete="off" />
                             <div class="form-body">
									<div class="form-group col-md-6">
									<br><br>
										<label class="col-md-6 control-label">Header Text:<span class="red">*</span></label>
										<div class="col-md-6">
										    <textarea type="text" placeholder="Header Text" name="name" style="color:gray" class="form-control">
									            <?php
									                if(!empty($header_text['name'])){
									                    echo $header_text['name'];
									                }
									            ?>
										    </textarea>
											
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
