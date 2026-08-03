@extends('layouts.adminLayout.backendLayout')
@section('content')
<div class="page-content-wrapper">
    <div class="page-content">
        <div class="page-head">
            <div class="page-title">
                <h1>Banner Management </h1>
            </div>
        </div>
        <ul class="page-breadcrumb breadcrumb">
            <li>
                <a href="{{ url('admin/dashboard') }}">Dashboard</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <a href="{{ action('App\Http\Controllers\Admin\BannerController@bannerImages') }}">Banner Images</a>
            </li>
        </ul>
        <div class="row">
            <div class="col-md-12 ">
                <div class="portlet blue-hoki box ">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-gift"></i>Upload Banner Images
                        </div>
                    </div>
                    <div class="portlet-body form">
                        <form id="addEditBannerImage" role="form" class="form-horizontal" method="post" @if(empty($bannerdata)) action="{{ url('admin/add-edit-banner-image') }}" @else action="{{ url('admin/add-edit-banner-image/'.$bannerdata['id']) }}" @endif enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
                            <div class="form-body">
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Banner Type :</label>
                                     <?php $typeArray = array('home'=>'Home Page Section 1 (Top Slider)','home2'=>'Home Page Section 2','home3'=>'Home Page Section 3'); ?>
                                    <div class="col-md-4">
                                        <select name="type" class="selectbox" required>
                                            <option value="">Select</option>
                                            @foreach($typeArray as $key => $type)
                                                <option value="{{$key}}" @if(!empty($bannerdata) && $bannerdata['type'] == $key) selected @endif>{{$type}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group ">
                                    <label class="col-md-3 control-label">Select Banner Image : </label>
                                    <div class="col-md-4">
                                        <div data-provides="fileinput" class="fileinput fileinput-new">
                                            <div style="" class="fileinput-new thumbnail">
                                                @if(!empty($bannerdata['image']))
                                                    <?php $path = "images/BannerImages/".$bannerdata['image']; ?>
                                                    @if(file_exists($path))
                                                        <img style="height:100px;" class="img-responsive"  src="{{ asset('images/BannerImages/'.$bannerdata['image'])}}">
                                                    @endif
                                                @else
                                                    <img style="height:100px;" class="img-responsive"  src="{{ asset('images/default.png') }}">
                                                @endif
                                            </div>
                                            <div style="max-width: 200px; max-height: 150px; line-height: 10px;" class="fileinput-preview fileinput-exists thumbnail"></div>
                                            <div>
                                                <div class="form-group">
                                                    <span class="btn default btn-file">
                                                    <span class="fileinput-new">
                                                    Select Image </span>
                                                    <span class="fileinput-exists">
                                                    Select Image </span>
                                                    <input type="file" name="image">
                                                    </span>
                                                    <a data-dismiss="fileinput" class="btn default fileinput-exists" href="javascript:;">
                                                    Remove </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label"></label>
                                    <div class="col-md-6">
                                        <span><b>For sizes you can ask designer (sakshi)</b></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Description :</label>
                                    <div class="col-md-4">
                                        <textarea type="text" placeholder="Enter Description" name="description"  style="color:gray" class="form-control">@if(!empty($bannerdata['description'])) {{$bannerdata['description']}} @endif</textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Sort :</label>
                                    <div class="col-md-4">
                                        <input type="number" min="1" step="1" placeholder="Enter Sort number" name="sort"  style="color:gray" class="form-control" value="@if(!empty($bannerdata['sort'])){{$bannerdata['sort']}}@endif" required />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Link :</label>
                                    <div class="col-md-4">
                                        <input type="text" placeholder="E.g.- https://example.com" name="link"  style="color:gray" class="form-control" value="@if(!empty($bannerdata['link'])) {{$bannerdata['link']}} @endif"/>
                                    </div>
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