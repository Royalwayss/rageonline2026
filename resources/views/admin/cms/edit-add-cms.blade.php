@extends('layouts.adminLayout.backendLayout')
@section('content')
<style>
    #cke_editor1{
        margin-left:10px!important;
        margin-right: 10px!important;
    }
</style>
<div class="page-content-wrapper">
    <div class="page-content">
        <div class="page-head">
            <div class="page-title">
                <h1>Page Management </h1>
            </div>
        </div>
        <ul class="page-breadcrumb breadcrumb">
            <li>
                <a href="{{ url('admin/dashboard') }}">Dashboard</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <a href="{{ action('App\Http\Controllers\Admin\BannerController@bannerImages') }}">Cms Page</a>
            </li>
        </ul>
        <div class="row">
            <div class="col-md-12 ">
                <div class="portlet blue-hoki box ">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-gift"></i>CMS Page
                        </div>
                    </div>
                    <div class="portlet-body form">
                        <form id="addEditBannerImage" role="form" class="form-horizontal" method="post" @if(empty($cmsdata)) action="{{ url('admin/edit-add-cms') }}" @else action="{{ url('admin/edit-add-cms/'.$cmsdata['id']) }}" @endif enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
                            <div class="form-body">
							
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Page Name :</label>
                                    <div class="col-md-4">
                                        <input type="text" style="color:gray" class="form-control" name="title" value="@if(!empty($cmsdata['title'])) {{$cmsdata['title']}} @endif"/>
                                    </div>
                                </div>							

                                <div class="form-group">
                                    <label class="col-md-3 control-label">Meta Title :</label>
                                    <div class="col-md-4">
                                        <input type="text" style="color:gray" class="form-control" name="meta_title" value="@if(!empty($cmsdata['meta_title'])) {{$cmsdata['meta_title']}} @endif"/>
                                    </div>
                                </div>							
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Meta Description :</label>
                                    <div class="col-md-4">
                                        <input type="text" style="color:gray" class="form-control" name="meta_description" value="@if(!empty($cmsdata['meta_description'])) {{$cmsdata['meta_description']}} @endif"/>
                                    </div>
                                </div>								
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Meta Keyword :</label>
                                    <div class="col-md-4">
                                        <input type="text" style="color:gray" class="form-control" name="meta_keywords" value="@if(!empty($cmsdata['meta_keywords'])) {{$cmsdata['meta_keywords']}} @endif"/>
                                    </div>
                                </div>
							
    
    
    
                                <div class="form-group">
                                    
                                        <textarea name="editor1">@if(!empty($cmsdata['description'])) {{$cmsdata['description']}} @endif</textarea>
                                        <script>
                                                CKEDITOR.replace( 'editor1' );
                                        </script>
                                </div>

                            </div>
                            <div class="form-actions right1 text-center">
                                <button id="check" class="btn green disable" type="submit">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

