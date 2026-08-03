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
                <h1>Categories Management </h1>
            </div>
        </div>
        <ul class="page-breadcrumb breadcrumb">
            <li>
                <a href="{{ url('admin/dashboard') }}">Dashboard</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <a href="{{ url('admin/categories') }}">Categories </a>
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
                        <form id="addEditCategoryForm" role="form" class="form-horizontal" method="post" @if(!empty($categorydata['id'])) action="{{ url('admin/add-edit-category/'.$categorydata['id']) }}" @else action="{{ url('admin/add-edit-category') }}" @endif enctype="multipart/form-data" autocomplete="off"> 
                            <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
                            <div class="form-body">
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Category Name :</label>
                                    <div class="col-md-4">
                                        <input  type="text" placeholder="Name" name="name" style="color:gray" class="form-control" value="{{(!empty($categorydata['name']))?$categorydata['name']: '' }}"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Select Category :</label>
                                    <div class="col-md-4">
                                        <select name="parent_id" class="selectbox"> 
                                            <option value="">Select</option>
                                            <option value="ROOT" @if( empty($categorydata['parent_id'])) selected @endif>Main Category</option>
                                            <?php foreach ($getCategories as $key => $category) {?>
                                            <option value="{{$category['id']}}"@if(isset($categorydata['parent_id']) && $categorydata['parent_id'] ==$category['id']) selected @endif>&#9679;&nbsp;{{$category['name']}}</option>
                                            <?php if(!empty($category['subcategories'])){
                                                foreach ($category['subcategories'] as $key => $subcat) { ?>
                                                    <option value="{{$subcat['id']}}"@if(isset($categorydata['parent_id']) && $categorydata['parent_id'] ==$subcat['id']) selected @endif>&nbsp;&nbsp;&nbsp;&nbsp;&raquo; &nbsp;{{$subcat['name']}}</option>
                                                    <?php foreach ($subcat['subcategories'] as $key => $subsubcat) { ?>
                                                    <option value="{{$subcat['id']}}">&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&raquo; &raquo; &nbsp;{{$subsubcat['name']}}</option>
                                                <?php } 
                                                }
                                            }
                                        } ?>
                                        </select>
                                    </div>
                                </div>
								
								<div class="form-group">
                                    <label class="col-md-3 control-label">Sort :</label>
                                    <div class="col-md-4">
                                        <input type="no" name="sort"  style="color:gray" class="form-control" value="{{(!empty($categorydata['sort']))?$categorydata['sort']: '' }}"/>
                                    </div>
                                </div>

                                <div class="form-group ">
                                    <label class="col-md-3 control-label">Select Main image: </label>
                                    <div class="col-md-5">
                                        <div data-provides="fileinput" class="fileinput fileinput-new">
                                            <div style="" class="fileinput-new thumbnail">
                                            <?php if(!empty($categorydata['image'])){
                                                $path = "images/CategoryImages/".$categorydata['image']; 
                                            if(file_exists($path)) { ?>
                                                <img style="height:100px;widtyh:100px;" class="img-responsive"  src="{{ asset('images/CategoryImages/'.$categorydata['image'])}}">
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
                                    <label class="col-md-3 control-label"></label>
                                    <div class="col-md-7">
                                     <label> <b style="color:green;"> Note:- Upload image having (1920 X 1070) dimensions</b></label>
                                    </div>
                                </div> 
                                <div class="form-group ">
                                    <label class="col-md-3 control-label">Select Size Chart </label>
                                    <div class="col-md-5">
                                        <div data-provides="fileinput" class="fileinput fileinput-new">
                                            <div style="" class="fileinput-new thumbnail">
                                            <?php if(!empty($categorydata['size_chart'])){
                                                $path = "images/SizeCharts/".$categorydata['size_chart']; 
                                            if(file_exists($path)) { ?>
                                                <img style="height:100px;widtyh:100px;" class="img-responsive" id="SizeChart-{{ $categorydata['id'] }}" src="{{ asset('images/SizeCharts/'.$categorydata['size_chart'])}}">
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
                                                    <input type="file" id="Image" name="size_chart">
                                                    </span>
                                                    <a data-dismiss="fileinput" class="btn default fileinput-exists" href="#">
                                                    Remove </a>
                                                </div>
                                            </div>
											@if(!empty($categorydata['size_chart'])) 
											 <a href="javascript:;"   data-attr-id="{{ $categorydata['id'] }}" class="btn btn-sm red DeleteSizeChart">Remove Size Chart </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                               
								<div class="form-group">
                                    <label class="col-md-3 control-label">Category Discount :</label>
                                    <div class="col-md-4">
                                        <input type="text" placeholder="Enter Category Discount" name="category_discount" style="color:gray" class="form-control" value="{{(!empty($categorydata['category_discount']))?$categorydata['category_discount']: '' }}"/>
                                    </div>
                                </div>
                                @if(!empty($categorydata['seo_unique']))
                                    <div id="CatSeoUnique" style="display:none;">{{$categorydata['seo_unique']}}</div>
                                @endif
                                <div class="form-group ">
                                    <label class="col-md-3 control-label">SEO Unique Phrase : </label>
                                    <div class="col-md-4">
                                        <input type="text" placeholder="SEO Unique" name="seo_unique"  style="color:gray" class="form-control " value="{{(!empty($categorydata['seo_unique']))?$categorydata['seo_unique']: '' }}"/>
                                    </div>
                                </div>
                                <div class="form-group" style="display:none">
                                    <label class="col-md-3 control-label">Filters : </label>
                                    <div class="col-md-4">
                                        <?php $selFilters = array();?>
                                        @if(!empty($categorydata['filters']))
                                            <?php $selFilters = explode(',',$categorydata['filters']); ?>
                                        @endif
                                        <select class="form-control selectpicker" name="filters[]" multiple="">
                                            <?php $filters = array('Age Group','Price','Color','Categories'); ?>
                                            @foreach($filters as $filter)
                                                <?php $selFilter=""; ?>
                                                @if(in_array($filter,$selFilters))
                                                    <?php $selFilter ="selected"; ?>
                                                @endif
                                                <option value="{{$filter}}" {{$selFilter}}>{{$filter}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Description :</label>
                                    <div class="col-md-4">
                                        <textarea placeholder="Description..." name="description"  style="color:gray" class="form-control">{{(!empty($categorydata['description']))?$categorydata['description']: '' }}</textarea>
                                    </div>
                                </div>
                                <div class="form-group ">
                                    <label class="col-md-3 control-label">Meta title : </label>
                                    <div class="col-md-4">
                                        <input type="text" placeholder="Meta title" name="meta_title"  style="color:gray" class="form-control " value="{{(!empty($categorydata['meta_title']))?$categorydata['meta_title']: '' }}"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Meta Keywords :</label>
                                    <div class="col-md-4">
                                        <textarea placeholder="Meta Keywords..." name="meta_keyword"  style="color:gray" class="form-control">{{(!empty($categorydata['meta_keyword']))?$categorydata['meta_keyword']: '' }}</textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Meta Description :</label>
                                    <div class="col-md-4">
                                        <textarea placeholder="Meta Description..." name="meta_description"  style="color:gray" class="form-control">{{(!empty($categorydata['meta_description']))?$categorydata['meta_description']: '' }}</textarea>
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