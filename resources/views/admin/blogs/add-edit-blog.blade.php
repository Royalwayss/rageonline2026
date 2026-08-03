@extends('layouts.adminLayout.backendLayout')
@section('content')
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
                <h1>Blogs Management </h1>
            </div>
        </div>
        <ul class="page-breadcrumb breadcrumb">
            <li>
                <a href="{{ url('admin/dashboard') }}">Dashboard</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <a href="{{ action('App\Http\Controllers\Admin\BlogController@blogs') }}">Blogs </a>
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
                        <form id="addEditBlog" role="form" class="form-horizontal" method="post" @if(!empty($blogdata['id'])) action="{{ url('admin/add-edit-blog/'.$blogdata['id']) }}" @else action="{{ url('admin/add-edit-blog') }}" @endif enctype="multipart/form-data"> 
                            <input type="hidden" name="_token" value="{{{ csrf_token() }}}"  autocomplete="off" />
                            <div class="form-body">
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Title :</label>
                                    <div class="col-md-4">
                                        <input autocomplete="off" type="text" placeholder="Title" name="title" style="color:gray" class="form-control" value="{{(!empty($blogdata['title']))?$blogdata['title']: '' }}"/>
                                    </div>
                                </div>

                                <div class="form-group ">
                                    <label class="col-md-3 control-label">Select Image: </label>
                                    <div class="col-md-5">
                                        <div data-provides="fileinput" class="fileinput fileinput-new">
                                            <div style="" class="fileinput-new thumbnail">
                                            <?php if(!empty($blogdata['image'])){
                                                $path = "images/BlogImages/".$blogdata['image']; 
                                            if(file_exists($path)) { ?>
                                                <img style="height:100px;widtyh:100px;" class="img-responsive"  src="{{ asset('images/BlogImages/'.$blogdata['image'])}}">
                                            <?php }else{?>
                                                    <img style="height:100px;widtyh:100px;" class="img-responsive"  src="{{ asset('images/default.png') }}">
                                            <?php } } else { ?>
                                            <img style="height:100px;widtyh:100px;" class="img-responsive"  src="{{ asset('images/default.png') }}">
                                            <?php } ?>
                                        </div>
                                            <div style="max-width: 200px; max-height: 150px; line-height: 10px;" class="fileinput-preview fileinput-exists thumbnail">
                                            </div>
                                            <div>
                                                <div class="form-group">
                                                    <span class="btn default btn-file">
                                                    <span class="fileinput-new">
                                                    Select Image </span>
                                                    <span class="fileinput-exists">
                                                    Select Image </span>
                                                    <input type="file" id="Image" name="image">
                                                    </span>
                                                    <a data-dismiss="fileinput" class="btn default fileinput-exists" href="#">
                                                    Remove </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div> 
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Blog Date :</label>
                                    <div class="col-md-4">
                                        <input autocomplete="off" type="date" placeholder="Date" name="date" style="color:gray" class="form-control" value="{{(!empty($blogdata['date']))?$blogdata['date']: '' }}"/>
                                    </div>
                                </div> 
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Description :</label>
                                    <div class="col-md-6">
                                        <textarea  placeholder="Description..." name="description" rows="8" style="color:gray" class="form-control">{{(!empty($blogdata['description']))?$blogdata['description']: '' }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="form-actions right1 text-center">
                                <button  id="blogSubmitBtn" class="btn green" type="submit">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection