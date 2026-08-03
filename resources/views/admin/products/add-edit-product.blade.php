@extends('layouts.adminLayout.backendLayout')
@section('content')
<?php
use App\Productcolor;  
?>
<link rel="stylesheet" href="{!!asset('css/backend_css/select2.min.css')!!}">
<link rel="stylesheet" href="{!!asset('css/backend_css/bootstrap/css/select2-bootstrap4.min.css')!!}">
<style type="text/css">
    .red{
        color: red;
    }
	.select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
    color: rgba(255,255,255,.7);
    float: right;
    margin-left: 5px;
    margin-right: -2px;
}
</style>
<style>
    #cke_editor1{
        margin-left:10px!important;
        margin-right: 10px!important;
    }
	.rage_checkbox{ margin-top:10px;width: 58%; height:22px;margin-left: -43px!important; }
</style>
<script type="text/javascript" src="{!!asset('js/backend_js/ckeditor/ckeditor.js')!!}"></script>
<script type="text/javascript" src="{!!asset('js/backend_js/ckeditor/adapters/jquery.js')!!}"></script>
<script type="text/javascript" src="{!!asset('js/backend_js/select2.full.min.js')!!}"></script>

<div class="page-content-wrapper">
    <div class="page-content">
        <div class="page-head">
            <div class="page-title">
                <h1>Products Management </h1>
            </div>
        </div>
        <ul class="page-breadcrumb breadcrumb">
            <li>
                <a href="{{ url('admin/dashboard') }}">Dashboard</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <a href="{{ action('App\Http\Controllers\Admin\ProductsController@products') }}">Products </a>
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
                        <form id="addEditProduct" role="form" class="form-horizontal" method="post" @if(!empty($productdata['id'])) action="{{ url('admin/add-edit-product/'.$productdata['id']) }}" @else action="{{ url('admin/add-edit-product') }}" @endif enctype="multipart/form-data"> 
                            <input type="hidden" name="_token" value="{{{ csrf_token() }}}"  autocomplete="off" />
                            <div class="form-body">
                                <div class="form-group col-md-6">
                                    <label class="col-md-6 control-label">Product Name:<span class="red">*</span></label>
                                    <div class="col-md-6">
                                        <input autocomplete="off" type="text" placeholder="Name" name="product_name" style="color:gray" class="form-control" value="{{(!empty($productdata['product_name']))?$productdata['product_name']: '' }}"/>
                                    </div>
                                </div>
								
								
                                @if(!empty($productdata['seo_url']))
                                    <div id="getSeoUrl" style="display:none;">{{$productdata['seo_url']}}</div>
                                    <input type="hidden" name="old_seo" value="{{$productdata['seo_url']}}">
                                @endif
                                <div class="form-group col-md-6" style="display:none;">
                                    <label class="col-md-6 control-label">SEO Unique Phrase:<span class="red">*</span></label>
                                    <div class="col-md-6">
                                        <input autocomplete="off" type="text" placeholder="SEO Unique Phrase" name="seo_url" style="color:gray" class="form-control" value="{{(!empty($productdata['seo_url']))?$productdata['seo_url']: '' }}"/>
                                        <b>Don't enter Special chars in SEO Unique execpt (-)</b>
                                    </div>
                                </div>
                                
                                <div class="form-group col-md-6">
                                    <label class="col-md-6 control-label">Product Code:<span class="red">*</span></label>
                                    <div class="col-md-6">
                                        <input autocomplete="off" type="text" placeholder="Product Code"  name="product_code" style="color:gray" class="form-control" value="{{(!empty($productdata['product_code']))?$productdata['product_code']: '' }}"/>
                                    </div>
                                </div>
								 <div class="form-group col-md-6">
                                    <label class="col-md-6 control-label">Group Code:</label>
                                    <div class="col-md-6">
                                        <input autocomplete="off" type="text" placeholder="Group Code" name="group_code" class="form-control" value="{{(!empty($productdata['group_code']))?$productdata['group_code']: '' }}"/>
                                    </div>
                                </div>
								<div class="clearfix"></div>
                                <div class="form-group col-md-6">
                                    <label class="col-md-6 control-label">Select Category: <span class="red">*</span></label>
                                    <div class="col-md-6">
                                        <select name="category_id" class="selectbox"> 
                                            <option value="">Select</option>
                                            <?php foreach ($getCategories as $key => $category) {?>
                                            <option value="{{$category['id']}}"@if(isset($productdata['category_id']) && $productdata['category_id'] ==$category['id']) selected @endif>&#9679;&nbsp;{{$category['name']}}</option>
                                            <?php if(!empty($category['subcategories'])){
                                                foreach ($category['subcategories'] as $key => $subcat) { ?>
                                                    <option value="{{$subcat['id']}}" @if(isset($productdata['category_id']) && $productdata['category_id'] ==$subcat['id']) selected @endif>&nbsp;&nbsp;&nbsp;&nbsp;&raquo; &nbsp;{{$subcat['name']}}</option>
                                                    <?php foreach ($subcat['subcategories'] as $key => $subsubcat) { ?>
                                                    <option value="{{$subsubcat['id']}}" @if(isset($productdata['category_id']) && $productdata['category_id'] ==$subsubcat['id']) selected @endif>&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&raquo; &raquo; &nbsp;{{$subsubcat['name']}}</option>
                                                <?php } 
                                                 }
                                                }
                                             } ?>
                                        </select>
                                    </div>
                                </div>
								
                                <div class="form-group col-md-6">
                                    <label class="col-md-6 control-label">Select Categories: <span class="red">*</span></label>
                                    <div class="col-md-6">
                                        <select name="cats[]" class="selectbox MultipleSelect" required multiple size="15" style="height: 50%;">
                                            <?php foreach ($getCategories as $key => $category) {?>
                                            <option value="{{$category['id']}}" @if(in_array($category['id'],$productCats)) selected @endif>&#9679;&nbsp;{{$category['name']}}</option>
                                            <?php if(!empty($category['subcategories'])){
                                                foreach ($category['subcategories'] as $key => $subcat) { ?>
                                                    <option value="{{$subcat['id']}}" @if(in_array($subcat['id'],$productCats)) selected @endif>&nbsp;&nbsp;&nbsp;&nbsp;&raquo; &nbsp;{{$subcat['name']}}</option>
                                                    <?php foreach ($subcat['subcategories'] as $key => $subsubcat) { ?>
                                                    <option value="{{$subsubcat['id']}}" @if(in_array($subsubcat['id'],$productCats)) selected @endif>&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&raquo; &raquo; &nbsp;{{$subsubcat['name']}}</option>
                                                <?php } 
                                                 }
                                                }
                                             } ?>
                                        </select>
                                    </div>
                                </div>
								
                                <div class="clearfix"></div>
                               
								
                                <div class="clearfix"></div>
                                @if(!empty($productImages))
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Product Images:</label>
                                        <div class="col-md-8">
                                            <table  class="table table-hover table-bordered table-striped">
                                                <tbody>
                                                    <tr>
                                                        <th width="15%">Image</th>
                                                        <th width="35%">Sort</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                    @foreach($productImages as $key => $image)
                                                    <tr id="delete-{{$image['id']}}">
                                                         
                                                        <td>
                                                            @if(!empty($image['image']))
                                                            <a download href="{{asset('images/ProductImages/xlarge/'.$image['image']) }}" ><img width="100px" src="{{asset('images/ProductImages/medium/'.$image['image']) }}" /> </a>
                                                            @else
                                                                N/A
                                                            @endif
                                                        </td>
                                                        <td class="text-center">
                                                            <input id="ImageSort-{{$image['id']}}"  type="number" class="form-control" value="{{$image['image_sort']}}">
                                                            <br>
                                                            <button data-imageid="{{$image['id']}}" class="btn green updateImageSort" type="button"> Update</button>
                                                        </td>
                                                        <td class="text-center">
                                                            <a   id="{{ $image['id'] }}" class="btn btn-danger pImage" href="javascript:void(0);"><i class="fa fa-times"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                @endif
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Add Product Images: <br><span style="color:red">Upload X large Image (1200 X 1800)</span></label> 
                                    <div class="col-md-8">
                                        <table id="ImageTable" class="table table-hover table-bordered table-striped">
                                            <tbody>
                                                <tr>
                                                    <th>Image</th>
                                                    <th>Image Sort</th>
                                                    <th>Actions</th>
                                                </tr>
                                                @for ($i=1; $i <=1; $i++)
                                                <tr class="blockIdWrap">
                                                    <td>
                                                        <input type="file" class="form-control" name="images[]">
                                                    <td>
                                                        <input type="text" placeholder="Image Sort" name="image_sort[]" style="color:gray" autocomplete="off" value="1" class="form-control"/>
                                                    </td>
                                                    </td>
                                                    <td></td>
                                                </tr>
                                                @endfor
                                            </tbody>
                                        </table>
                                        <input type="button" id="addImageRow" value="Add More" />
                                    </div>
                                </div>
								 <div class="form-group col-md-6">
                                        <label class="col-md-6 control-label">Color: <span class="red">*</span></label>
                                    <div class="col-md-6">
                                        
                                            <input autocomplete="off" type="text" placeholder="Color" name="color" style="color:gray" class="form-control" value="{{(!empty($productdata['color']))?$productdata['color']: '' }}"/>
                                        
                                    </div>
                                </div>
								<?php $productcolorarr = Productcolor::productcolors();  ?>
								<div class="form-group col-md-6">
                                        <label class="col-md-6 control-label">Color Family: <span class=""></span></label>
                                    <div class="col-md-6">
                                        <select name="productcolor" class="form-control">
                                            <option value="">Please Select</option>
                                            @foreach($productcolorarr as $productcolor)
                                                <option value="{{$productcolor->product_color}}" @if(isset($productdata['productcolor']) && $productdata['productcolor'] ==$productcolor->product_color) selected @endif>{{$productcolor->product_color}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="col-md-6 control-label">Product Price:<span class="red">*</span></label>
                                    <div class="col-md-6">
                                        <input autocomplete="off" type="text" placeholder="Product Price" name="product_price" style="color:gray" class="form-control" value="{{(!empty($productdata['product_price']))?$productdata['product_price']: '' }}"/>
                                    </div>
                                </div>
								
								 <div class="form-group col-md-6" style="display:none">
                                    <label class="col-md-6 control-label">Special Price:</label>
                                    <div class="col-md-6">
                                        <input autocomplete="off" type="number" placeholder="Special Price" name="special_price" style="color:gray" class="form-control" value="{{(!empty($productdata['special_price']))?$productdata['special_price']: '' }}"/>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
								<div class="form-group col-md-6" >
                                    <label class="col-md-6 control-label">Product Discount: </label>
                                    <div class="col-md-5">
                                        <input autocomplete="off" type="text" placeholder="Product Discount" name="product_discount" style="color:gray" class="form-control" value="{{(!empty($productdata['product_discount']))?$productdata['product_discount']: '' }}"/ max="99">
                                    </div>
                                        <p style="margin-top: 8px;">%</p>
                                </div>
								
                                
                              
                                <div class="form-group col-md-6">
                                    <label class="col-md-6 control-label">Weight in Grams:</label>
                                    <div class="col-md-6">
                                        <input autocomplete="off" step="0.1"   type="number" placeholder="Weight" name="weight" style="color:gray" class="form-control" value="{{(!empty($productdata['weight']))?$productdata['weight']: '' }}"/>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                              
                             
                                
                                <div class="form-group ">
                                    <label class="col-md-3 control-label">Description :</label>
                                    <div class="col-md-9">
                                              
                                        <textarea name="editor1">@if(!empty($productdata['product_description'])) {{$productdata['product_description']}} @endif</textarea>
                                        <script>
                                                CKEDITOR.replace( 'editor1' );
                                        </script>                            
                                        
                                        <!--<textarea rows="5" placeholder="Description..." name="product_description" style="color:gray" class="form-control">{{(!empty($productdata['product_description']))?$productdata['product_description']: '' }}</textarea>-->
                                    </div>
                                </div> 
								
								    
									<div class="clearfix"></div>
									
                                 <div class="form-group col-md-6">
                                    <label class="col-md-6 control-label">Fabric :</label>
                                    <div class="col-md-6">
                                         <input type="text" name="fabric_description" class="form-control" value="{{(!empty($productdata))?$productdata['fabric_description']: '' }}">
                                    </div>
                                </div> 
                                           
                                <div class="clearfix"></div>
                               
								
                              <div class="form-group col-md-6">
                                    <label class="col-md-6 control-label">Stock</label>
                                    <div class="col-md-6">
                                        <input name="product_stock" type="number" id="Stock"  min="0" value="{{(!empty($productdata))?$productdata['product_stock']: '' }}" class="form-control"  minlength="0">
                                    </div>
                                </div>
                              <div class="clearfix"></div>
                               
                                <div class="form-group col-md-6">
                                    <label class="col-md-6 control-label">Enable(visible on website):</label>
                                    <div class="col-md-6">
                                        <input name="status" type="checkbox" id="Enable" value="1" class="rage_checkbox" <?php if(!empty($productdata)){ if($productdata['status'] == 1 ) { echo 'checked'; } }?>>
                                    </div>
                                </div>
								 <div class="clearfix"></div>
								 <div class="form-group col-md-6">
                                    <label class="col-md-6 control-label">New Arrival:</label>
                                    <div class="col-md-6">
                                        <input name="new_arrival" type="checkbox"  value="Yes" class="rage_checkbox" <?php if(!empty($productdata)){ if($productdata['new_arrival'] == 'Yes' ) { echo 'checked'; } }?>>
                                    </div>
                                </div>
								
								
								<div class="clearfix"></div>
								 <div class="form-group col-md-6">
                                    <label class="col-md-6 control-label">Best Seller:</label>
                                    <div class="col-md-6">
                                        <input name="best_seller" type="checkbox"  value="Yes" class="rage_checkbox" <?php if(!empty($productdata)){ if($productdata['best_seller'] == 'Yes' ) { echo 'checked'; } }?>>
                                    </div>
                                </div>
								<div class="clearfix"></div>
								<div class="form-group col-md-9">
                                    <label class="col-md-4 control-label">Select Size Chart </label>
                                    <div class="col-md-8">
                                        <div data-provides="fileinput" class="fileinput fileinput-new">
                                            <div style="" class="fileinput-new thumbnail">
                                            <?php if(!empty($productdata['size_chart'])){
                                                $path = "images/SizeCharts/".$productdata['size_chart']; 
                                            if(file_exists($path)) { ?>
                                                <img style="height:100px;widtyh:100px;" id="SizeChart-{{ $productdata['id'] }}" class="img-responsive"  src="{{ asset('images/SizeCharts/'.$productdata['size_chart'])}}">
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
											@if(!empty($productdata['size_chart'])) 
											 <a href="javascript:;"   data-attr-id="{{ $productdata['id'] }}" class="btn btn-sm red DeleteSizeChart">Remove Size Chart </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                               
								
								
								
                                <div class="clearfix"></div>
                                @if(isset($productdata['attributes']) && !empty($productdata['attributes']))
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Attributes:</label>
                                        <div class="col-md-8">
                                            <table class="table table-hover table-bordered table-striped">
                                                <tbody>
                                                    <tr>
                                                        <th width="15%" class="text-center">SKU</th>
                                                        <th width="15%" class="text-center">Size</th>
														 <th width="15%" class="text-center" style="display:none">Color</th>
                                                        <th width="15%" class="text-center">Stock</th>
                                                        <th width="25%" class="text-center">Price</th>
                                                        <th width="25%" class="text-center">Actions</th>
                                                        <th width="25%" class="text-center">#</th>
                                                    </tr>
                                                    @foreach($productdata['attributes'] as $proAttr)
                                                        <input type="hidden" name="attr_id[]" value="{{$proAttr['id']}}">
                                                        <tr class="blockIdWrap">
                                                            <td>{{$proAttr['sku']}}</td>
                                                            <td>{{$proAttr['size']}}</td>
                                                            <td style="display:none">
                                                                <input type="text" class="form-control" name="attr_color[]" placeholder="Color" value="{{$proAttr['color']}}" />
                                                            </td>
                                                            <td>
                                                                <input type="number" class="form-control" name="attr_stock[]" min="0" placeholder="Stock" value="{{$proAttr['stock']}}" />
                                                            </td>
                                                            <td>
                                                                <input type="number" class="form-control" name="attr_price[]" placeholder="Price" value="{{$proAttr['price']}}" />
                                                            </td>
                                                            <td>
                                                                <input name="radio{{$proAttr['id']}}" data-attrid="{{$proAttr['id']}}" value="yes" class="changeStatus" type="radio" @if($proAttr['status'] ==1) checked @endif> Active
                                                                <input name="radio{{$proAttr['id']}}" data-attrid="{{$proAttr['id']}}" value="no" class="changeStatus" type="radio" @if($proAttr['status'] ==0) checked @endif> Inactive</td>
                                                            <td>
                                                                <a class="btn btn-danger" href="{{url('/admin/remove-attribute/'.$proAttr['id'])}}/{{$productdata['id']}}" onclick="return confirm('Are you sure ?')"><i class="fa fa-times"></i></a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                @endif
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Add Attributes Details:</label>
                                    <div class="col-md-8">
                                        <table id="dynamicTable1" class="table table-hover table-bordered table-striped">
                                            <tbody>
                                                <tr>
                                                    <th class="text-center">SKU</th>
                                                    <th class="text-center" style="display:none">Color</th>
                                                    <th class="text-center">Size</th>
                                                    <th class="text-center">Stock</th>
                                                    <th class="text-center">Price</th>
                                                    <th class="text-center">Actions</th>
                                                </tr>
                                                @for ($i=1; $i <=1 ; $i++)
                                                <tr class="blockIdWrap">
                                                    <td>
                                                        <input type="text" class="form-control" name="sku[]" placeholder="SKU" style="width:196px"/>
                                                    </td>
                                                    <td style="display:none">
                                                        <input type="text"  class="form-control" name="colors[]" placeholder="Color" />
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control" name="size[]" placeholder="Size"/>
                                                    </td>
                                                    <td>
                                                        <input type="number" class="form-control" name="stock[]" min="0" placeholder="Stock" />
                                                    </td>
                                                    <td>
                                                        <input type="number" class="form-control" name="price[]" placeholder="Price" />
                                                    </td>
                                                    <td></td>
                                                </tr>
                                                @endfor
                                            </tbody>
                                        </table>
                                        <input type="button" id="addrow" value="Add More" />
                                        <table class="table table-hover table-bordered table-striped samplerow" style="display:none;">
                                            <tbody>
                                                <tr class="appenderTr blockIdWrap">
                                                    <td>
                                                        <input type="text" class="form-control" name="sku[]" placeholder="SKU" style="width:196px"/>
                                                    </td>
                                                    <td style="display:none">
                                                        <input type="text" class="form-control" name="colors[]" placeholder="Color" />
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control" name="size[]" placeholder="Size"/>
                                                    </td>
                                                    <td>
                                                        <input type="number" class="form-control" name="stock[]" placeholder="Stock" min="0" />
                                                    </td>
                                                    <td>
                                                        <input type="number" class="form-control" name="price[]" placeholder="Price" />
                                                    </td>
                                                    <td>
                                                        <a title="Remove" class="btn btn-sm red remove" href="javascript:;"> <i class="fa fa-times"></i></a>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
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
                <input type="file" class="form-control" name="images[]">
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
	$(document).on('click','.DeleteSizeChart',function(){ 
        var id = $(this).attr('data-attr-id');
         $(this).hide();		
		$.ajax({
            data : {id:id},
            url : "/admin/remove-product-sizechartimage",
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
   /* $('.MultipleSelect option').mousedown(function(e) {
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
    }); */
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
