@extends('layouts.adminLayout.backendLayout')
@section('content')
<style>
    .form-control-feedback {
      top: 9px !important;
    }
</style>
<script type="text/javascript" src="{!!asset('js/backend_js/ckeditor/ckeditor.js')!!}"></script>
<script type="text/javascript" src="{!!asset('js/backend_js/ckeditor/adapters/jquery.js')!!}"></script>
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
                <h1>FAQ Page Management </h1>
            </div>
        </div>
        <ul class="page-breadcrumb breadcrumb">
            <li>
                <a href="{{ action('App\Http\Controllers\Admin\AdminController@dashboard') }}">Dashboard</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <a href="{{ url('admin/faq-page') }}">Faq-page</a>
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
                        <form id="addCouponForm" @if(!empty($cms)) action="{{ url('/admin/faqpage-addEdit/'.($cms['id'])) }}" @else action="{{ url('/admin/faqpage-addEdit') }}"  @endif role="form" class="form-horizontal" method="post"> 
                            <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
                            <div class="form-body">
                                @if(!empty($cms))
                                    <div  class="form-group">
                                    <label class="col-md-3 control-label">Coupon Code:</label>
                                    <div class="col-md-5" style="margin-top: 8px;">
                                        <span><b>{{ $cms['code'] }}</b></span>
                                    </div>
                                </div>
                                @else
                               
                               
                                @endif 
                               
                               
                                 <div class="form-group">
                                    <label class="col-md-3 control-label">Topic:</label>
                                    <div class="col-md-6">
                                         <input type="text" style="color:gray" class="form-control" name="topic" value="@if(!empty($cms['topic'])) {{$cms['topic']}} @endif"/>
                                    </div>
                                 </div>
                               
                             
                            
                                <div class="form-group ">
                                    <label class="col-md-3 control-label">Question And Answers:</label>
                                    <div class="col-md-9">
                                        
                                                
                                        <textarea name="contents">@if(!empty($cms['contents'])) {{base64_decode($cms['contents'])}} @endif</textarea>
                                        <script>
                                                CKEDITOR.replace( 'contents' );
                                        </script>                            
                                    </div>
                                </div> 
								
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Position:</label>
                                    <div class="col-md-6">
                                         <input type="text" style="color:gray" class="form-control" name="position" value="@if(!empty($cms['position'])) {{$cms['position']}} @endif"/>
                                    </div>
                                 </div>
                                       
                            </div>
                            <div class="form-actions right1 text-center">
                                <button class="btn green" type="submit">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
.form-control-feedback{
    top:8px! important;
}
.form-horizontal .form-group {
    margin-left: 0px !important;
}
</style>
@endsection